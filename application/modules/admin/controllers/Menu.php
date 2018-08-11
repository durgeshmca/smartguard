<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/SG_Controller.php';

/**
 * Dashboard controller
 */
class Menu extends SG_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('menu_model'));
    $this->load->helper(array('common','menu'));
  }

  public function index($search = '')
  {
    $searchedMenu = array();
    if (! empty(trim($search))) {
      $menuArray = $this->menu_model->getMenuIds($_SESSION['userDetails'] ['group_id']);
      foreach ($menuArray as $key => $value) {
        if (stripos($value['menu_name'], $search) !== FALSE) {
          $searchedMenu[$key] = $value;
        }
      }
      $menuManaged = getCompleteMenu($searchedMenu, TRUE);
    } else {
      $menuManaged = getCompleteMenu($_SESSION['menu']);
    }

    //pr($menuManaged);
    echo renderMenu($menuManaged);
  }

}
