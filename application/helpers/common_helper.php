<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    function load_views($view, $data = array())
    {
        $CI = &get_instance();
        $CI->load->view('tempalate/header', $data);
        $CI->load->view('tempalate/menu', $data);
        $CI->load->view($view, $data);
        $CI->load->view('tempalate/footer', $data);
    }
function pr($array)
{
  echo '<pre>';
  print_r($array);
  die;
}
