<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  //method to get Menu
  public function getMenu($userId = 0, $groupID = 0)
  {
    $menuArray = array();
    $menuIds = $this->getMenuIds($groupID);
    //process menu
    //create an array according to menu
    if (is_array($menuIds)) {
        foreach ($menuIds as  $menuItem) {
          if ($menuItem['parent_id'] == 0) { //for main menus
            $menuArray[$menuItem['menu_id']] = $menuItem;
          }
        }
      //now for get sub menu level 1
      foreach ($menuArray as $key => $value) {
        $menuArray[$key] ['sub']= $this->getSubMenu($key, $menuIds);
        //for level 2
        if(count($menuArray[$key] ['sub']) > 0){
          foreach ($menuArray[$key] ['sub'] as $key1 => $value1) {
            $subMenu = $this->getSubMenu($key1, $menuIds);
            if(count($subMenu) > 0){
            $menuArray[$key] ['sub'][$key1]['sub'] = $subMenu;
            //for level 3
            foreach ($menuArray[$key] ['sub'][$key1]['sub'] as $key2 => $value2) {
              $subMenu = $this->getSubMenu($key2, $menuIds);
            }
            if(count($subMenu) > 0){
              $menuArray[$key] ['sub'][$key1]['sub'][$key2]['sub'] = $subMenu;
            }
          }
          }
        }
      }
    //  $menuArray = $this->getSubMenu(1,  $menuIds);

    }
    return $menuArray;
  }

  private function getMenuIds($groupID = 0)
  {

    $menu_rights = $this->getMenuRights($groupID);
    if (count($menu_rights) == 0 ) {
      return FALSE;
    }

    //get and process menu ids
    $mainMenu = explode(':' , $menu_rights['mainmenu_rights']);
    $mainMenu = array_unique($mainMenu);
    $this->db->select('menu_id, menu_name, parent_id, menu_link')
             ->from('mainmenu')
             ->where('disable_icon !=', '1')
             ->where_in('menu_id', $mainMenu)
             ->order_by('sequence, menu_id');
    $result = $this->db->get();
    //echo $this->db->last_query();
    if (! $result) {
      throw new Exception("Error while getting  menu rights ".$this->db->last_query());
    }
    return $result->result_array();

  }
  private function getMenuRights($groupID = 0)
  {
    if($groupID){
      $result = $this->db->where('group_id', $groupID)
                         ->get('groupmenu');
      if (! $result) {
        throw new Exception("Error while getting  menu rights ".$this->db->last_query());
      }
      return $result->row_array();
    }
    return [];
  }
  //recursive funtion to get menu array
  private function getSubMenu($menuId, $menuArray = array())
  {
    $subMenu  = array();
    foreach ($menuArray as $menuItem) {
      if ($menuItem['parent_id'] == $menuId) {
          $subMenu[$menuItem['menu_id']] = $menuItem;
      }
    }

      return $subMenu;
    }
}