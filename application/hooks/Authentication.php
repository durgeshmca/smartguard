<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication {
    private $CI;
    public function __construct()
    {
      $this->CI = & get_instance();
    }
  public function checkAuth()
  {
    //exclude controllers here to bypass authentication
    $excludedControllers = $this->CI->config->item('authExcludeControllers');
    $controllerName = strtolower($this->CI->router->fetch_class());
    if (! in_array($controllerName, $excludedControllers)) {
      if((! isset($_SESSION['logged_in'])) || $_SESSION['logged_in'] !== TRUE){
        redirect('/admin/login', 'refresh');
      }
    }

  }

}
