<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Saga Dynamic CMS
 * @author Asep Yayat
 * @email asepmedia18@gmail.com
 * @version 0.0.1
 * @since 2018
 */

class Role
{
  /**
   * Construct function
   */
  public function __construct()
  {
    $this->load->model('module/m_role', 'role');
  }
  
  public function module($access = 0)
  {
    $user = $this->session->userdata('user');
    $role = $user ? $user->role : 0;

    if(is_array($access)) {
      if(in_array($role, $access) == false) {
        redirect(base_url('404'));
        exit();
      }
    }

    $uri = explode("/", $this->uri->uri_string());
    
    $last_path = array_slice($uri, -1)[0];

    $module_access = array_slice($uri, -2, 2);
    
    $path_role = implode("_", array_slice($uri, 1, count($uri) - 2));
    $path_method = array_slice($uri, count($uri) - 1, 1)[0];

    if(is_numeric($last_path)) {
      $module_access = array_slice($uri, -2, 2);
      $path_role = implode("_", array_slice($uri, 1, count($uri) - 3));
      $path_method = array_slice($uri, count($uri) - 2, 1)[0];
    }

    $module = strtolower($path_role);
    $module_child = strtolower($path_method);
    
    $session_name = 'user_role_' . $module . '_' . $module_child;
    $exist = $this->session->userdata($session_name);
    $role_key = isset($exist['role_key']) ? $exist['role_key'] : 0;
    $role_access = isset($exist['role']) ? $exist['role'] : 0;
    
    if(is_null($exist) || $role != $role_key) {
      $check = $this->role->has($module, $module_child, $role);
      $data = array(
        $session_name => array(
          'role' => $check <= 0 ? 0 : 1,
          'role_key' => $role,
          'user' => 1
        )
      );
      $this->session->sess_expiration = 30;
      $this->session->set_userdata($data);
      $role_access = $check <= 0 ? 0 : 1;
    }
    if($role_access != 1) {
      $this->session->unset_userdata($session_name);
      redirect(base_url('404'));
      return false;
    }

    return true;
  }

 /**
   * Undocumented function
   *
   * @param [type] $object
   * @return void
   */
  function load($object) {
    $this->$object = load_class(ucfirst($object));
  }

  /**
   * Undocumented function
   *
   * @param [type] $var
   * @return void
   */
  function __get($var) {
      global $CI;
      return $CI->$var;
  } 
}