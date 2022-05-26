<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class DefaultLinks extends ManagerGodController {
  protected $model = 'ProfileDefaultLinkModel';
	protected $recordsRelative = true;
	protected $names = [
		'singular' => 'Link',
		'plural' => 'Links',
		'link' => 'defaultLinks'
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
			'name' => 'default_link_id',
			'label' => 'Tipo',
			'type' => 'select',
			'fromDataBase' => true,
			'options' => [
				'model' => 'DefaultLinkModel',
				'text' => 'name',
				'value' => 'id'
			],
			'showOnTable' => true,
			'rules' => 'trim|required',
			'required' => true,
			'col' => 'col-md-4'
		],
		[
			'name' => 'label',
			'label' => 'Título',
			'type' => 'text',
			'showOnTable' => true,
			'rules' => 'trim',
			'col' => 'col-md-4'
		],
		[
			'name' => 'url',
			'label' => 'URL',
			'type' => 'text',
			'rules' => 'trim',
			'col' => 'col-md-4'
		],
		[
			'name' => 'copy_text',
			'label' => 'Texto p/ cópia',
			'type' => 'text',
			'rules' => 'trim',
			'col' => 'col-md-4'
		],
		[
			'name' => 'position',
			'label' => 'Posição',
			'type' => 'number',
			'showOnTable' => true,
			'rules' => 'trim',
			'col' => 'col-md-4'
		]
	];

  function __construct () {
    parent::__construct();
  }

	public function create () {
		$this->load->model('DefaultLinkModel');
		$this->data['defaultLinks'] = $defaultLinks = $this->DefaultLinkModel->getAll();
		$this->data['defaultLinksOptions'] = $this->getDefaultLinksOptions($defaultLinks);

		$this->load->view('manager/default-links/form', $this->data);
	}

	public function update (int $recordId = null) {
		if (!$recordId) {
			redirect('manager/' . $this->names['links']);
		}

		$this->load->model('ProfileDefaultLinkModel');
		$this->data['record'] = $this->ProfileDefaultLinkModel->getByPrimary($recordId);

		$this->load->model('DefaultLinkModel');
		$this->data['defaultLinks'] = $defaultLinks = $this->DefaultLinkModel->getAll();
		$this->data['defaultLinksOptions'] = $this->getDefaultLinksOptions($defaultLinks);

		$this->load->view('manager/default-links/form', $this->data);
	}

	private function getDefaultLinksOptions (array $defaultLinks) {
		$options = [];

		foreach ($defaultLinks as $link) {
			$options[$link->id] = $link->name;
		}

		return $options;
	}
}