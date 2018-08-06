<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Dashboard controller
 */
class Dashboard extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->helper(array('common','menu'));
    $this->load->model('Menu_model','menu');
  }

  function index()
  {
    $data = $this->menu->getMenu(1, 1);
    load_views('dashboard/dashboard_content',['data'=>$data]);
  }

}
