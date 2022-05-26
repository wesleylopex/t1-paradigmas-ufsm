<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends ManagerController {
  function __construct () {
    parent::__construct();
  }

  public function index () {
    redirect('manager/profile');
    $this->load->view('manager/home/index', $this->data);
  }

  public function error () {
    redirect('manager/profile');
  }
}