<?php
//funtion to get sub menu array
function getSubMenu($menuId, $menuArray = array())
{
  $subMenu  = array();
  foreach ($menuArray as $menuItem) {
    if ($menuItem['parent_id'] == $menuId) {
        $subMenu[$menuItem['menu_id']] = $menuItem;
    }
  }

    return $subMenu;
  }
//get complete menu 
  function getCompleteMenu(array $menuIds)
  {
    $menuArray = array();
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
        $menuArray[$key] ['sub']= getSubMenu($key, $menuIds);
        //for level 2
        if(count($menuArray[$key] ['sub']) > 0){
          foreach ($menuArray[$key] ['sub'] as $key1 => $value1) {
            $subMenu = getSubMenu($key1, $menuIds);
            if(count($subMenu) > 0){
            $menuArray[$key] ['sub'][$key1]['sub'] = $subMenu;
            //for level 3
            foreach ($menuArray[$key] ['sub'][$key1]['sub']
                      as $key2 => $value2
                    ) {
              $subMenu = getSubMenu($key2, $menuIds);
            }
            if(count($subMenu) > 0){
              $menuArray[$key] ['sub'][$key1]['sub'][$key2]['sub'] = $subMenu;
              //for level 4
              foreach ($menuArray[$key] ['sub'][$key1]['sub'][$key2]['sub']
                        as $key3 => $value3
                      ) {
                $subMenu = getSubMenu($key3, $menuIds);
              }
              if(count($subMenu) > 0){
                $menuArray[$key] ['sub'][$key1]['sub'][$key2]['sub'] [$key3]['sub']= $subMenu;
              }
            }
          }
          }
        }
      }
    //  $menuArray = $this->getSubMenu(1,  $menuIds);

    }
    return $menuArray;
  }

  //render menu for admin
  function renderMenu()
  {
    $menu = '';
      foreach ($_SESSION['menu'] as $menuId => $menuItem) {
          //for level 0
            if (array_key_exists('sub', $menuItem) && count($menuItem['sub'] > 0)) {
              $menu .= '<li class="treeview">
                        <a href="#">
                        <i class="fa fa-share"></i> <span>'.$menuItem['menu_name'].'</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        </a>';
              $menu .= '<ul class="treeview-menu">';
              foreach ($menuItem['sub'] as $menuId1 => $menuItem1) {
                if (array_key_exists('sub', $menuItem1) && count($menuItem1['sub'] > 0)) {
                  $menu .= '<li class="treeview">
                        <a href="#">
                        <i class="fa fa-share"></i> <span>'.$menuItem1['menu_name'].'</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        </a>';
                $menu .= '<ul class="treeview-menu">';
                  
                foreach ($menuItem1['sub'] as $menuId2 => $menuItem2) {
                  if (array_key_exists('sub', $menuItem2) && count($menuItem2['sub'] > 0)) {
                    $menu .= '<li class="treeview">
                          <a href="#">
                          <i class="fa fa-share"></i> <span>'.$menuItem2['menu_name'].'</span>
                          <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                          </span>
                          </a>';
                  $menu .= '<ul class="treeview-menu">';
                  foreach ($menuItem2['sub'] as $menuId3 => $menuItem3) {
                    if (array_key_exists('sub', $menuItem3) && count($menuItem3['sub'] > 0)) {
                      $menu .= '<li class="treeview">
                            <a href="#">
                            <i class="fa fa-share"></i> <span>'.$menuItem3['menu_name'].'</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                            </a>';
                    // $menu .= '<ul class="treeview-menu">';
                    // $menu .= '</ul></li>';
                    }else {
                    $menu .= '<li><a href="#"><i class="fa fa-circle-o"></i>'. $menuItem3['menu_name'].'</a></li>';
                    }
                  }
                  $menu .= '</ul></li>';
                  }else {
                  $menu .= '<li><a href="#"><i class="fa fa-circle-o"></i>'. $menuItem2['menu_name'].'</a></li>';
                  }
                }
                $menu .= '</ul></li>';
                }else {
                $menu .= '<li><a href="#"><i class="fa fa-circle-o"></i>'. $menuItem1['menu_name'].'</a></li>';
                }
              }
              $menu .= '</ul></li>';
            } else {
              $menu .= '<li><a href="#"><i class="fa fa-circle-o"></i>'. $menuItem['menu_name'].'</a></li>';
            }
      }
      return $menu;
  }
