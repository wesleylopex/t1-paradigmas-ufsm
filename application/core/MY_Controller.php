<?php

include_once 'application/core/ManagerController.php';
include_once 'application/core/ManagerGodController.php';

class MainController extends CI_Controller {
  public $data = [];
  public $user = null;

  protected function __construct () {
    parent::__construct();

    $this->user = $this->getUserOrRedirect();

    $this->load->vars($this->data);
  }

  private function getUserOrRedirect () {
    $user = $this->session->userdata('user');

    if (!is_array($user) || empty($user)) {
      redirect('login');
    }

    return $user;
  }

  protected function goToPreviousPage () {
    $this->load->library('user_agent');
    redirect($this->agent->referrer());
  }

  protected function response (array $response) : bool {
    echo json_encode($response);
    return array_key_exists('success', $response) ? $response['success'] : false;
  }
}