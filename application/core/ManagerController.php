<?php
class ManagerController extends CI_Controller {
  public function __construct () {
    parent::__construct();

    $this->load->library('parser');

    $sessionUser = $this->getUserOrRedirect();

    $this->load->model('ProfileModel');
    $this->data['user'] = $this->user = $this->ProfileModel->getByPrimary($sessionUser['id']);

    $this->load->vars($this->data);
  }

  private function getUserOrRedirect () {
    $user = $this->session->userdata('user');

    if (!$user) {
      redirect('manager/login');
    }

    return $user;
  }

  protected function response (array $response) : bool {
    echo json_encode($response);
    return array_key_exists('success', $response) ? $response['success'] : false;
  }
}
