<!DOCTYPE html>
<html lang="pt-br">

<head>
  <?php include_once 'application/views/manager/utils/start.php' ?>
</head>

<body data-background-color="bg3">
  <div class="wrapper">
    <?php include_once 'application/views/manager/utils/header.php' ?>
    <div class="main-panel">
      <div class="content">
        <div class="container-fluid">
          <div class="page-header god-header">
            <h4 class="page-title"><?= isset($record) ? 'Editar ' : 'Criar ' . $names['singular'] ?></h4>
            <ul class="breadcrumbs">
              <li class="nav-home">
                <a href="<?= base_url('manager') ?>"> home </a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item">
                <a href="<?= base_url("manager/" . $names['link']) ?>"><?= $names['plural'] ?></a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item">
                <?= $names['singular'] ?>
              </li>
            </ul>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <form id="main-form" action="<?= base_url('manager/' . $names['link'] . '/save') ?>" enctype="multipart/form-data" method="post">
                  <div class="card-body p-30px">
                      <div class="form-row">
                        <?php foreach ($fields as $key => $field) : ?>
                          <?php if (!array_key_exists('showOnForm', $field) || $field['showOnForm']) : ?>
                            
                            <?php if ($field['type'] == 'separator') : ?>
                              <div class="form-group col-md-12 no-pb">
                                <div class="row">
                                  <div class="col-auto">
                                    <div class="title-section">
                                      <h6><?= $field['title'] ?></h6>
                                    </div>
                                  </div>
                                  <div class="col">
                                    <hr class="title-separator mt-10px">
                                  </div>
                                </div>
                              </div>
                            <?php endif ?>
                            
                            <?php $disabled = array_key_exists('disabled', $field) ? $field['disabled'] : false ?>
                            <?php $maxlength = array_key_exists('maxlength', $field) ? $field['maxlength'] : false ?>
                            <?php $required = array_key_exists('required', $field) ? $field['required'] : false ?>
                            <?php $class = array_key_exists('class', $field) ? $field['class'] : '' ?>
                            <?php $col = array_key_exists('col', $field) ? $field['col'] : 'col-md-12' ?>

                            <?php if ($field['type'] == 'hidden') : ?>
                              <?php $recordValue = isset($record) ? $record->{$field['name']} : '' ?>
                              <?php $defaultValue = array_key_exists('defaultValue', $field) ? $field['defaultValue'] : '' ?>
                              <?php $value = $recordValue ? $recordValue : $defaultValue ?>

                              <input
                                type="hidden"
                                class="<?= $class ?>"
                                <?= $disabled ? 'disabled' : '' ?>
                                name="<?= $field['name'] ?>"
                                value="<?= $value ?>"
                              >
                            <?php endif ?>

                            <?php if ($field['type'] != 'hidden' && $field['type'] != 'separator') : ?>
                              <div class="form-group <?= $col ?> form-show-validation <?= $field['type'] == 'image' ? 'pb-20px' : '' ?>">
                                <div class="d-flex justify-content-between flex-wrap">
                                  <label style="white-space: initial" class="d-flex align-items-center">
                                    <?php if (isset($record) && isset($field['baseForeignLinkOnLabel']) && isset($field['disabled']) && $field['disabled']) : ?>
                                      <a href="<?= base_url($field['baseForeignLinkOnLabel'].'/'.$record->{$field['name']}) ?>">
                                        <?= $field['label'] ?>
                                      </a>
                                    <?php else : ?>
                                      <?= $field['label'] ?>
                                    <?php endif ?>
                                  </label>
                                  <?php if ($maxlength) : ?>
                                    <div>
                                      <span class="input-length">0</span>
                                      <span>/ <?= $maxlength ?></span>
                                    </div>
                                  <?php endif ?>
                                </div>

                                <?php if ($field['type'] == 'text' || $field['type'] == 'number' || $field['type'] == 'email' || $field['type'] == 'url') : ?>
                                  <div>
                                    <input
                                      type="<?= $field['type'] ?>"
                                      <?= array_key_exists('isTagsInput', $field) && $field['isTagsInput'] ? 'data-role="tagsinput"' : '' ?>
                                      class="form-control <?= $class ?>"
                                      name="<?= $field['name'] ?>"
                                      value="<?= isset($record) ? $record->{$field['name']} : "" ?>"
                                      <?= $disabled ? 'disabled' : '' ?>
                                      <?= $required ? 'required' : '' ?>
                                      <?= $maxlength ? "maxlength='$maxlength'" : '' ?>
                                    >
                                    <label class="error-label"></label>
                                  </div>
                                <?php endif ?>

                                <?php if ($field['type'] == 'password') : ?>
                                  <input type="password" class="form-control <?= $class ?>" <?= $disabled ? 'disabled' : '' ?> name="<?= $field['name'] ?>" <?php if ($required) : ?> required <?php endif ?> autocomplete="off">
                                <?php endif ?>

                                <?php if ($field['type'] == 'textarea') : ?>
                                  <div>
                                    <textarea name="<?= $field['name'] ?>" maxlength="<?= array_key_exists('maxlength', $field) ? $field['maxlength'] : '' ?>" rows="<?= isset($field['rows']) ? $field['rows'] : "5" ?>" <?= $disabled ? 'disabled' : '' ?> class="form-control <?= $class ?>" <?php if ($required) : ?> required <?php endif ?>><?= isset($record) ? $record->{$field['name']} : "" ?></textarea>
                                    <label class="error-label"></label>
                                  </div>
                                <?php endif ?>

                                <?php if ($field['type'] == 'image') : ?>
                                  <div class="input-file input-file-image">
                                    <img class="img-upload-preview" width="150" src="<?= isset($record) ? base_url('assets/uploads/images/' . $uploadFolder . ($uploadFolder ? '/' : '') . $record->{$field['name']}) : "" ?>" alt="">
                                    <input type="file" class="form-control form-control-file" id="<?= $field['name'] ?>" name="<?= $field['name'] ?>" accept="image/*">
                                    <label for="<?= $field['name'] ?>" class="label-input-file btn btn-icon btn-primary btn-lg"><i class="la la-file-image-o"></i> Escolher imagem</label>
                                    <?php if (isset($record) && $record->{$field['name']} && (!array_key_exists('required', $field) || $field['required'] === false)) : ?>
                                      <div class="form-check p-0">
                                        <label class="form-check-label">
                                          <input name="delete-file-<?= $field['name'] ?>" class="form-check-input" type="checkbox">
                                          <span class="form-check-sign">Remover arquivo</span>
                                        </label>
                                      </div>
                                    <?php endif ?>
                                  </div>
                                <?php endif ?>

                                <?php if ($field['type'] == 'file' || $field['type'] == 'video') : ?>
                                  <div class="mb-3">
                                    <div class="custom-file">
                                      <input type="file" <?= $disabled ? 'disabled' : '' ?> name="<?= $field['name'] ?>" class="custom-file-input" id="<?= $field['name'] ?>" accept="<?= $field['type'] == 'video' ? 'video/mp4,video/x-m4v,video' : 'application/pdf' ?>">
                                      <label style="white-space: initial" class="custom-file-label" for="<?= $field['name'] ?>" data-browse="Procurar">
                                        <?= isset($record) && $record->{$field['name']} ? $record->{$field['name']} : 'Escolher um arquivo'?>
                                      </label>
                                    </div>
                                    <?php if (isset($record) && $record->{$field['name']}) : ?>
                                      <a class="text-blue-600 text-xs leading-none" href="<?= base_url('assets/uploads/'. ($field['type'] . 's/') . ($uploadFolder ? $uploadFolder . '/' : '') . $record->{$field['name']}) ?>" download>
                                        <?= $record->{$field['name']} ?>
                                      </a>
                                      <div class="form-check p-0">
                                        <label class="form-check-label">
                                          <input name="delete-file-<?= $field['name'] ?>" class="form-check-input" type="checkbox">
                                          <span class="form-check-sign">Remover arquivo</span>
                                        </label>
                                      </div>
                                    <?php endif ?>
                                  </div>
                                <?php endif ?>

                                <?php if ($field['type'] == 'dropzone') : ?>
                                  <div action="<?= base_url('manager/' . $names['link'] . '/uploadDropzoneImages') ?>" class="dropzone">
                                    <div class="dz-message" data-dz-message>
                                      <div class="icon">
                                        <i data-feather="image"></i>
                                      </div>
                                      <h4 class="message">Arraste e solte imagens</h4>
                                      <div class="note">(Ou clique e selecione)</div>
                                    </div>
                                    <div class="fallback">
                                      <input name="dropzone_file_input" type="file" multiple />
                                    </div>
                                  </div>
                                <?php endif ?>
                                
                                <?php if ($field['type'] == 'select') : ?>
                                  <div>
                                    <?= form_dropdown($field['name'], $field['options'], isset($record) ? $record->{$field['name']} : '', ['class' => "form-control $class select2", $disabled ? 'disabled' : '' => 'disabled', $required ? 'required' : '' => 'required']) ?>
                                    <label class="error-label"></label>
                                  </div>
                                <?php endif ?>

                                <?php if ($field['type'] == 'date') : ?>
                                  <div class="input-group">
                                    <input
                                      type="text"
                                      class="form-control date"
                                      <?= $disabled ? 'disabled' : '' ?>
                                      name="<?= $field['name'] ?>"
                                      value="<?= isset($record) && $record->{$field['name']} ? date('d/m/Y', strtotime($record->{$field['name']})) : '' ?>">
                                    <div class="input-group-append">
                                      <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                      </span>
                                    </div>
                                    <label for="" class="error"></label>
                                  </div>
                                <?php endif ?>

                                <?php if ($field['type'] == 'month') : ?>
                                  <div>
                                    <input
                                      type="month"
                                      class="form-control"
                                      <?= $disabled ? 'disabled' : '' ?>
                                      name="<?= $field['name'] ?>"
                                      value="<?= isset($record) ? $record->{$field['name']} : null ?>"
                                    >
                                    <label for="" class="error-label"></label>
                                  </div>
                                <?php endif ?>
                                
                                <?php if ($field['type'] == 'color') : ?>
                                  <div>
                                    <input
                                      type="color"
                                      <?= $disabled ? 'disabled' : '' ?>
                                      name="<?= $field['name'] ?>"
                                      value="<?= isset($record) ? $record->{$field['name']} : null ?>"
                                    >
                                    <label for="" class="error-label"></label>
                                  </div>
                                <?php endif ?>
                              </div>
                            <?php endif ?>
                          <?php endif ?>
                        <?php endforeach ?>
                      </div>
                  </div>
                  <div class="card-action">
                    <?php if (!array_key_exists('isUnique', $permissions) || !$permissions['isUnique']) : ?>
                      <a href="<?= site_url('manager/' . $names['link']) ?>">
                        <button type="button" class="btn btn-primary btn-border">
                          Voltar
                        </button>
                      </a>
                    <?php endif ?>
                    <button type="submit" class="submit-button d-flex align-items-center btn btn-primary btn-save">
                      Salvar
                      <i class="submit-button__loader ml-2 rotating hidden" data-feather="loader"></i>
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <?php include_once 'application/views/manager/utils/end.php' ?>

  <script>
    const settings = {
      baseURL: '<?= base_url() ?>',
      names: <?= json_encode($names) ?>
    }

    window.addEventListener('load', () => {
      onFormSubmit()
      setInputsMaxlength()
    })

    function setInputsMaxlength () {
      const inputs = document.querySelectorAll('.form-control')
      inputs.forEach(input => {
        setInputMaxlength(input)
        
        input.addEventListener('keyup', (event) => {
          setInputMaxlength(event.target)
        })
      })
    }

    function setInputMaxlength (input) {
      const labelContainer = input.parentElement.previousElementSibling
      if (!labelContainer) return null
      const inputLengthElement = labelContainer.querySelector('.input-length')
      
      if (inputLengthElement) {
        inputLengthElement.innerHTML = input.value.length
      }
    }

    function onFormSubmit () {
      const form = document.querySelector('form')
      form.addEventListener('submit', async event => {
        event.preventDefault()
        await saveRegister(event.target)
      })
    }

    async function saveRegister (form) {
      try {
        isLoading()

        const response = await fetch(form.action, {
          method: 'POST',
          body: new FormData(form)
        }).then(res => res.json())

        if (response.success === true) {
          showNotify('Registro salvo com sucesso')
          window.location.href = `${settings.baseURL}manager/${settings.names.link}`
        } else {
          showNotify(response.error, false)
        }

        isNotLoading()
      } catch (error) {
        isNotLoading()
        console.log(error)
        showNotify('Erro interno', false)
      }
    }

    function isLoading () {
      const submitButton = document.querySelector('.submit-button')
      submitButton.disabled = true

      const buttonLoader = submitButton.querySelector('.submit-button__loader')
      buttonLoader.classList.remove('hidden')
    }

    function isNotLoading () {
      const submitButton = document.querySelector('.submit-button')
      submitButton.disabled = false

      const buttonLoader = submitButton.querySelector('.submit-button__loader')
      buttonLoader.classList.add('hidden')
    }
  </script>
</body>

</html>