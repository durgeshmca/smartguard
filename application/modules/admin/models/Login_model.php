<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }
  public function login(array $loginDetails)
  {
    $whereArr = [
      'login_id' => $loginDetails['user_name'],
      'password' => md5($loginDetails['pwd']),
    ];
    $query = $this->db->where($whereArr)
                      ->get('login_master');
    if ($query && $query->num_rows() > 0) {
      return $query->row_array();
    } else {
      return FALSE;
    }
  }
}
