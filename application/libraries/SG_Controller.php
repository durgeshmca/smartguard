<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * this class will load necessary resources
 */
class SG_Controller extends CI_Controller {
  /**
   * language idiom
   * @var $language
   */
  public $language = '';

  public function __construct()
  {
    parent::__construct();
    //set language
    $this->language = ( ! empty($_SESSION['lang'])) ? $_SESSION['lang'] : DEFAULT_LANG;
  }

}
