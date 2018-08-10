<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/SG_Controller.php';

/**
 * Dashboard controller
 */
class Dashboard extends SG_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->helper(array('common','menu'));
    $this->load->model('Menu_model','menu');
  }

  function index()
  {
    $data = $_SESSION['menu'];
    load_views('dashboard/dashboard_content',['data'=>$data]);
  }

}
