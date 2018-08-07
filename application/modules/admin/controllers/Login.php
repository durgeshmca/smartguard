<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{

  public function __construct()
  {
    $this->load->library('form_validation')
  }

  function index()
  {
    if ($this->input->method() == 'post') {
        //validate iput data
        $validate = [
          
        ];
    }
    $this->load->view('login/login');
  }

}
