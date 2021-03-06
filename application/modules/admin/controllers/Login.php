<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/SG_Controller.php';
/**
 * Login controller
 */
class Login extends SG_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->model(array('login_model', 'menu_model'));
    $this->load->helper('menu');
    $this->lang->load('common', $this->language);
  }
/**
 * method to handle user login and session binding
 *
 * @param user_name login id of the user
 * @param pwd       password of the user
 */
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
              $_SESSION['userDetails'] ['login_id']  = $loginData['login_id'];
              $_SESSION['userDetails'] ['user_id']   = $loginData['user_id'];
              $_SESSION['userDetails'] ['group_id']  = $loginData['group_id'];
              $_SESSION['userDetails'] ['owner_id']  = $loginData['owner_id'];
              //get menu
              $_SESSION['menu'] = $this->menu_model
                                      ->getMenu($loginData['user_id'],
                                                $loginData['group_id']
                                              );
              $this->session->set_flashdata('success', $this->lang->line('login_success'));
              redirect('admin/dashboard');
            } else {
              $this->session->set_flashdata('error', $this->lang->line('invalid_cred'));
            }
          }
      }
      $this->load->view('login/login');
    } catch (\Exception $e) {
      //log error
      $message = $e->getMessage().' Error at line: '.__LINE__.' in file: '.__FILE__.' class: '.__CLASS__.' method: '. __METHOD__.'';
      log_message('error', $message);
      show_error($this->lang->line('try_again'));
    }


  }

  public function logOut()
  {
    session_destroy();
    redirect('admin/login');
  }

}
