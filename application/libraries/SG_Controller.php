<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * this class will load necessary resources
 */
class SG_Controller extends CI_Controller {

  public function method()
  {
    parent::__construct();
    //set language
    $lang = ( ! empty($_SESSION['lang'])) ? $_SESSION['lang'] : 'english';
    $this->load->lang($_SESSION['lang']);
  }

}
