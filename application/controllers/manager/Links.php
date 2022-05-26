<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Links extends ManagerGodController {
  protected $model = 'LinkModel';
	protected $recordsRelative = true;
	protected $names = [
		'singular' => 'Link',
		'plural' => 'Links',
		'link' => 'links'
	];
	protected $uploadFolder = 'links';
	protected $permissions = [
		'create' => true,
		'update' => true,
		'delete' => true
	];
	protected $fields = [
		[
			'name' => 'id',
			'label' => 'Id',
			'type' => 'hidden',
			'rules' => 'trim'
		],
		[
			'name' => 'label',
			'label' => 'Título',
			'type' => 'text',
			'showOnTable' => true,
			'rules' => 'trim|required',
			'required' => true,
			'col' => 'col-md-4'
		],
		[
			'name' => 'category_id',
			'label' => 'Categoria',
			'type' => 'select',
			'fromDataBase' => true,
			'options' => [
				'model' => 'CategoryModel',
				'text' => 'title',
				'value' => 'id'
			],
			'showOnTable' => true,
			'rules' => 'trim|required',
			'required' => true,
			'col' => 'col-md-4'
		],
		[
			'name' => 'url',
			'label' => 'URL',
			'type' => 'url',
			'rules' => 'trim',
			'col' => 'col-md-4'
		],
		[
			'name' => 'download_file',
			'label' => 'Arquivo p/ download',
			'type' => 'file',
			'rules' => 'trim',
			'col' => 'col-md-12'
		],
		[
			'name' => 'position',
			'label' => 'Posição',
			'type' => 'number',
			'showOnTable' => true,
			'rules' => 'trim',
			'col' => 'col-md-4'
		],
		[
			'name' => 'icon',
			'label' => 'Ícone (imagem)',
			'type' => 'image',
			'showOnTable' => true,
			'rules' => 'trim',
			'col' => 'col-md-12'
		]
	];

  function __construct () {
    parent::__construct();

		$index = array_search('category_id', array_column($this->fields, 'name'));
		$this->data['fields'][$index]['options'] = $this->setCategoriesOptions($this->fields[$index]);
  }

	private function setCategoriesOptions ($field) {
    $modelName = $field['options']['model'];

    $this->load->model($modelName);
    $model = $this->{$modelName};

    $options = $model->getOptionsByUserId($this->user->id, $field);

		return $options;
  }
}