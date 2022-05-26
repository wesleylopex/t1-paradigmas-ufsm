<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends ManagerGodController {
  protected $model = 'ProfileModel';
	protected $names = [
		'singular' => 'Perfil',
		'plural' => 'Perfil',
		'link' => 'profile'
	];
  protected $getPrimaryFromSession = true;
	protected $uploadFolder = 'profiles';
	protected $cropFields = ['image'];
	protected $permissions = [
		'create' => false,
		'update' => true,
		'delete' => false,
		'isUnique' => true
	];
	protected $fields = [
		[
			'name' => 'id',
			'label' => 'Id',
			'type' => 'hidden',
			'rules' => 'trim'
		],
		[
			'name' => 'name',
			'label' => 'Nome',
			'type' => 'text',
			'rules' => 'trim|required',
			'required' => true,
			'col' => 'col-md-4'
		],
		[
			'name' => 'email',
			'label' => 'Email',
			'type' => 'email',
			'disabled' => true,
			'col' => 'col-md-4'
		],
		[
			'name' => 'username',
			'label' => 'Nome de usuário',
			'type' => 'text',
			'rules' => 'trim',
			'disabled' => true,
			'col' => 'col-md-4'
		],
		[
			'name' => 'biography',
			'label' => 'Biografia',
			'type' => 'text',
			'maxlength' => 100,
			'rules' => 'trim',
			'col' => 'col-md-8'
		],
		[
			'name' => 'image',
			'label' => 'Imagem de perfil',
			'type' => 'image',
			'rules' => 'trim',
			'col' => 'col-md-12'
		]
	];

  function __construct () {
    parent::__construct();
  }
}