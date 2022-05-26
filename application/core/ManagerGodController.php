<?php
class ManagerGodController extends ManagerController {  
  function __construct () {
    parent::__construct();
    $this->load->model($this->model);
    
    $this->model = $this->{$this->model};
    
    $this->data['permissions'] = $this->permissions;
    $this->data['names'] = $this->names;

    $this->data['uploadFolder'] = isset($this->uploadFolder) ? $this->uploadFolder : '';

    $this->data['fields'] = $this->configSelectFields($this->fields);
  }

  public function index () {
    if (array_key_exists('isUnique', $this->permissions) && $this->permissions['isUnique']) {
      redirect('manager/' . $this->names['link'] . '/update');
    }

    if (isset($this->getAllWhere)) {
      $records = $this->model->getAllWhere($this->getAllWhere);
    } else {
      $records = $this->model->getAllWhere(['profile_id' => $this->user->id]);
    }

    $this->data['records'] = $this->configOptionsToTable($records, $this->fields);

    $this->load->view('manager/god-controller/index', $this->data);
  }

  public function create () {
    if ($this->permissions['create']) {
      $this->load->view('manager/god-controller/form', $this->data);
    } else {
      redirect('manager/' . $this->names['link']);
    }
  }

  public function update (int $id = null) {
    $isUnique = array_key_exists('isUnique', $this->permissions) && $this->permissions['isUnique'];

    if ($id && $isUnique) {
      redirect('manager/' . $this->names['link'] . '/update');
    }

    if (isset($this->getPrimaryFromSession) && $this->getPrimaryFromSession === true) {
      $id = $this->user->id;
    }

    if (!$id && $isUnique) {
      $record = $this->model->getLast();
    } else {
      $record = $this->model->getByPrimary($id);
    }
    
    if (!$this->permissions['update'] || !$record) {
      redirect('manager/' . $this->names['link']);
    }

    if (isset($record->profile_id) && $record->profile_id != $this->user->id) {
      redirect('manager/' . $this->names['link']);
    }

    $this->data['record'] = $record;

    $this->load->view('manager/god-controller/form', $this->data);
  }

  public function delete () {
    $ids = $this->input->post('id');
    foreach ($ids as $id) {
      $record = $this->model->getByPrimary($id);
      
      if (!$this->permissions['delete'] || !$record) {
        return false;
      }

      $this->deleteRecordFiles($id);
      $this->model->delete($id);
    }
  }

  private function deleteRecordFiles ($recordId) {
    $record = $this->model->getByPrimary($recordId);
    if (!$record) {
      return false;
    }
    
    $fields = array_filter($this->fields, function ($field) {
      return $field['type'] == 'image' || $field['type'] == 'video' || $field['type'] == 'file';
    });

    foreach ($fields as $field) {
      $this->deleteFile($recordId, $field['name'], $field['type']);
    }

    return true;
  }
  
  private function deleteFile ($recordId, string $fieldName, string $fileType) {
    $record = $this->model->getByPrimary($recordId);
    
    if (!$record) {
      return false;
    }

    $recordFile = $record->{$fieldName};

    if (!$recordFile) {
      return false;
    }

    $allowedTypes = ['image', 'video', 'file'];
    if (!in_array($fileType, $allowedTypes)) {
      return false;
    }

    $this->load->model('FileModel');
    $this->FileModel->removeFile(
      $this->uploadFolder ? ($this->uploadFolder . '/') : '',
      $recordFile,
      $fileType
    );
  }

  private function addFile (string $fieldName, string $fileType, string $uploadFolder = null) {
    $file = $_FILES[$fieldName];
    $fileName = $file['name'];

    if (!$fileName) return ['success' => false, 'error' => 'Arquivo não encontrado'];

    $allowedTypes = ['image', 'video', 'file'];
    if (!in_array($fileType, $allowedTypes)) {
      return ['success' => false, 'error' => 'Arquivo inválido'];
    }

    $cropFields = isset($this->cropFields) ? $this->cropFields : [];

    $resizeImage = true;
    $cropImage = in_array($fieldName, $cropFields);

    $this->load->model('FileModel');
    $response = $this->FileModel->uploadFile(
      $uploadFolder ? $uploadFolder : $this->uploadFolder,
      slugify($this->names['plural']) . '-' . $fileName,
      $fieldName,
      $fileType,
      $resizeImage,
      $cropImage
    );

    if ($response['success'] === true) {
      $fileName = $response['uploadData']['file_name'];
      return ['success' => true, 'fileName' => $fileName];
    }

    return $response;
  }

  private function getFieldValue (string $fieldName, array $fieldInfo) {
    if (!array_key_exists('type', $fieldInfo)) return null;
    
    $actions = [
      'date' => function () use ($fieldName) {
        if ($this->input->post($fieldName)) {
          return implode('-', array_reverse(explode('/', $this->input->post($fieldName))));
        }

        return null;
      },
      'user_id' => function () {
        $user = $this->session->userdata('user');

        if (array_key_exists('id', $user)) {
          return $user['id'];
        }

        return null;
      },
      'password' => function () use ($fieldName) {
        $password = $this->input->post($fieldName);

        if ($password) {
          return encode_crip($password);
        }
      }
    ];

    if (array_key_exists($fieldInfo['type'], $actions)) {
      $action = $actions[$fieldInfo['type']];
      return $action();
    }

    $fileTypes = ['image', 'video', 'file'];
    if (in_array($fieldInfo['type'], $fileTypes)) {
      $response = $this->addFile($fieldName, $fieldInfo['type']);

      if (array_key_exists('fileName', $response)) {
        return $response['fileName'];
      }

      return null;
    }

    return $this->input->post($fieldName);
  }

  public function save () {
    $this->setRulesValidation($this->data['fields']);

    $recordData = [];

    if (isset($this->getPrimaryFromSession) && $this->getPrimaryFromSession === true) {
      $recordData['id'] = $this->user->id;
    }

    foreach ($this->fields as $field) {
      $hasDisabled = array_key_exists('disabled', $field);
      $isEnabled = !$hasDisabled || ($hasDisabled && !$field['disabled']);
      
      $hasShowOnForm = array_key_exists('showOnForm', $field);
      $showOnForm = !$hasShowOnForm || ($hasShowOnForm && $field['showOnForm']);

      if ($isEnabled && $showOnForm) {
        $fileTypes = ['image', 'video', 'file'];
        
        if (
          array_key_exists('id', $recordData)
          && $recordData['id']
          && in_array($field['type'], $fileTypes)
          && !empty($_FILES[$field['name']]['name'])
        ) {
          $this->deleteFile($recordData['id'], $field['name'], $field['type']);
        }

        $ignoredFieldTypes = ['separator', 'slug'];
        if (!in_array($field['type'], $ignoredFieldTypes)) {
          if (
            !in_array($field['type'], $fileTypes)
            || (array_key_exists($field['name'], $_FILES) && !empty($_FILES[$field['name']]['name']))
          ) {
            $fieldValue = $this->getFieldValue($field['name'], $field);
            if ($field['type'] != 'password' || ($field['type'] == 'password' && $fieldValue)) {
              $recordData[$field['name']] = $fieldValue;
            }
          } else if (in_array($field['type'], $fileTypes)) {
            $deleteFile = $this->input->post('delete-file-' . $field['name']);

            if ($deleteFile && array_key_exists('id', $recordData) && $recordData['id']) {
              $recordData[$field['name']] = null;
              $this->deleteFile($recordData['id'], $field['name'], $field['type']);
            }
          }
        }
      }

      if (array_key_exists('slug', $field) && $field['slug'] === true) {
        $recordData['slug'] = slugify($this->input->post($field['name']));
      }
    }

    if ($this->form_validation->run() == false) {
      echo json_encode(['success' => false, 'error' => strip_tags(validation_errors())]);
      return false;
    }

    if (isset($this->recordsRelative) && $this->recordsRelative === true) {
      $recordData['profile_id'] = $this->user->id;
    }

    $recordId = null;

    if (array_key_exists('id', $recordData) && $recordData['id']) {
      if ($this->permissions['update']) {
        $this->model->update($recordData);
        
        $recordId = $recordData['id'];

        if ($recordId) {
          $this->session->set_flashdata('success', 'Registro editado com sucesso.');
        }
      }
    } else if ($this->permissions['create']) {
      $recordId = $this->model->create($recordData);
      if ($recordId) {
        $this->session->set_flashdata('success', 'Registro criado com sucesso.');
      }
    }
    
    echo json_encode(['success' => true]);
  }

  public function saveFromTable () {
    $id = $this->input->post('recordId');
    $fieldName = $this->input->post('fieldName');
    $fieldValue = $this->input->post('fieldValue');

    $fieldKey = array_search($fieldName, array_column($this->fields, 'name'));
    $field = $this->fields[$fieldKey];

    if (!$field) {
      echo json_encode(['success' => false, 'error' => 'Campo não encontrado']);
      return false;
    }

    $recordData = [
      'id' => $id,
      $fieldName => $fieldValue
    ];

    if (array_key_exists('slug', $field)) {
      $slug = slugify($recordData[$fieldName]);
      if ($this->model->count(['slug' => $slug]) > 0) {
        echo json_encode(['success' => false, 'error' => 'Campo duplicado']);
        return false;
      } else {
        $recordData['slug'] = $slug;
      }
    }

    if ($this->model->update($recordData)) {
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['success' => false]);
    }
  }

  private function setRulesValidation (array $fields) {
    foreach ($fields as $field) {
      if (array_key_exists('rules', $field)) {
        if ($field['type'] != 'image') {
          $this->form_validation->set_rules($field['name'], $field['label'], $field['rules']);
        } else {
          $id = $this->input->post('id');
          $alreadyHasImage = false;
  
          if ($id) {
            $alreadyHasImage = !!$this->model->getByPrimary($id)->{$field['name']};
            if (empty($_FILES[$field['name']]['name']) && !$alreadyHasImage) {
              $this->form_validation->set_rules($field['name'], $field['label'], $field['rules']);
            }
          } else {
            if (empty($_FILES[$field['name']]['name'])) {
              $this->form_validation->set_rules($field['name'], $field['label'], $field['rules']);
            }
          }
        }
      }
    }
  }

  private function configSelectFields (array $fields)  {
    $fields = array_map(function ($field) {
      if (
        $field['type'] == 'select'
        && array_key_exists('fromDataBase', $field)
        && $field['fromDataBase'] == true
      ) {
        $field['options'] = $this->getSelectFieldOptions($field);
      }

      return $field;
    }, $fields);

    return $fields;
  }

  private function getSelectFieldOptions ($field) {
    $modelName = $field['options']['model'];

    $this->load->model($modelName);
    $model = $this->{$modelName};

    $records = $model->getAll();
    $options = [];

    foreach ($records as $record) {
      $options[$record->{$field['options']['value']}] = $record->{$field['options']['text']};
    }

    return $options;
  }

  private function configOptionsToTable ($records, $fields) {
    foreach ($records as $record) {
      foreach ($fields as $field) {
        if (
          $field['type'] == 'select'
          && array_key_exists('fromDataBase', $field)
          && $field['fromDataBase'] === true
        ) {
          $modelName = $field['options']['model'];
          $this->load->model($modelName);
          $model = $this->{$modelName};

          $row = $model->getByPrimary($record->{$field['name']});
          if (!array_key_exists('editableOnTable', $field) || !$field['editableOnTable']) {
            $record->{$field['name']} = [];
            if ($row) {
              $record->{$field['name']}['selectText'] = $row->{$field['options']['text']};
            } else {
              $record->{$field['name']}['selectText'] = null;
            }
          }
        }
      }
    }

    return $records;
  }
}