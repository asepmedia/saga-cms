<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Saga Dynamic CMS
 * @author Asep Yayat
 * @email asepmedia18@gmail.com
 * @version 0.0.1
 * @since 2018
 */
class Saga_auth {

  /**
   * property
   */
  static $email;

  static $password;

  static $data = array();

  static $type;

  static $response = array();

  static $is_login = 0;

  /**
   * construct function
   */
  public function __construct()
  {

  }

  /**
   * type function
   *
   * @param string $type
   * @return void
   */
  public static function type($type = '')
  {
    self::$type = $type;
    return new self();
  }

  /**
   * email function
   *
   * @param string $email
   * @return void
   */
  public static function email($email = '')
  {
    self::$data['email'] = $email;
    return new self();
  }

  /**
   * password function
   *
   * @param string $password
   * @return void
   */
  public static function password($password = '')
  {
    self::$data['password'] = $password;
    return new self();
  }

  /**
   * login function
   *
   * @param string $type
   * @return void
   */
  public static function login()
  {
    $CI =& get_instance();
    $CI->load->model('saga/m_user', 'm_auth');
    self::$is_login = $CI->m_auth->login(self::$data);
    return self::do_login();
  }

  /**
   * do_login function
   *
   * @return void
   */
  public static function do_login($login = 0)
  {
    if(self::$type == 'ajax') {
      self::$response['status'] = 1;
      return self::$response;
    } else {
      return new self();
    }
  }

  public static function dump()
  {
    echo "<pre>";
    print_r(self::$data);
  }

  public static function toArray()
  {
    return self::$data;
  }

  public static function redirect($path = '')
  {
    if(self::$is_login != 1) {
      $CI =& get_instance();
      $CI->session->set_flashdata('auth_error', 'Failed to Login member area.');
      redirect(base_url('auth'));
    }
    redirect($path);
  }
}