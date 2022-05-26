<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MainController {
  function __construct () {
    parent::__construct();
    $this->data['page'] = 'home';
  }

  public function index () {
    $this->load->view('home', $this->data);
  }

  public function error () {
    $this->data['page'] = 'error';
    $this->load->view('404', $this->data);
  }
}