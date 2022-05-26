<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Download extends ManagerController {
  function __construct () {
    parent::__construct();
  }

  public function index () {
    $this->data['names']['link'] = 'download';
    $this->load->view('manager/download/index', $this->data);
  }
}