<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->model(array('login_model', 'menu_model'));
  }

  function index()
  {
    try {
      if ($this->input->method() == 'post') {
        //validate input data
          $validate = [
            [
              'field' => 'user_name',
              'label' => 'User Name',
              'rules' => 'trim|required|min_length[2]|max_length[50]',
            ],
            [
              'field' => 'pwd',
              'label' => 'Password',
              'rules' => 'trim|required|min_length[5]|max_length[50]',
            ]
          ];
          $this->form_validation->set_rules($validate);
          if ($this->form_validation->run()) {
            //now check if username and password is correct
            $loginDetails['user_name'] = $this->input->post('user_name', TRUE);
            $loginDetails['pwd']       = $this->input->post('pwd', TRUE);
            $loginData = $this->login_model->login($loginDetails);
            if ($loginData != FALSE && is_array($loginData) ) {
              //user is valid
              //nowset user's session and data
              $_SESSION['logged_in'] = TRUE;
              $_SESSION['userDetails']   = $loginData;
              //get menu
              $_SESSION['menu'] = $this->menu_model->getMenu($loginData['user_id'], $loginData['group_id']);
              $this->session->set_flashdata('success', 'You have logged in successfully');
              redirect('admin/dashboard');
            } else {
              $this->session->set_flashdata('error', 'Invalid Login Credentials');
            }
          }
      }
      $this->load->view('login/login');
    } catch (\Exception $e) {
      echo $e->getMessege();
    }


  }

}
