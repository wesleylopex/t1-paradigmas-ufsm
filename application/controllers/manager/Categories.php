<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends ManagerGodController {
  protected $model = 'CategoryModel';
	protected $recordsRelative = true;
	protected $names = [
		'singular' => 'Categoria',
		'plural' => 'Categorias',
		'link' => 'categories'
	];
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
			'name' => 'title',
			'label' => 'Título',
			'type' => 'text',
			'showOnTable' => true,
			'rules' => 'trim|required',
			'required' => true,
			'col' => 'col-md-4'
		],
		[
			'name' => 'position',
			'label' => 'Posição',
			'type' => 'number',
			'showOnTable' => true,
			'rules' => 'trim',
			'col' => 'col-md-4'
		],
	];

  function __construct () {
    parent::__construct();
  }
}