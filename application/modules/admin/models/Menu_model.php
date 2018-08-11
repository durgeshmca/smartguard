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
    $menuArray = getCompleteMenu($menuIds);
    return $menuArray;
  }

  public function getMenuIds($groupID = 0)
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

}
