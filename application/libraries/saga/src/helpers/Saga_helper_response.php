<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Saga Dynamic CMS
 * @author Asep Yayat
 * @email asepmedia18@gmail.com
 * @version 0.0.1
 * @since 2018
 */
class Saga_helper_response {
  static $CI;

  /**
   * constructor function
   */
  public function __construct()
  {
    self::$CI =& get_instance();
  }

  /**
   * Json
   */
  public static function json($response = array())
  {
    self::$CI->output
      ->set_content_type('application/json', 'utf-8')
      ->set_output(json_encode($response, JSON_PRETTY_PRINT))
      ->_display();
      exit;    
  }  
}