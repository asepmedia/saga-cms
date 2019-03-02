<?php defined('BASEPATH') OR exit('No direct script access allowed');

require 'saga/Saga_core.php';

/**
 * Saga Dynamic CMS
 * @author Asep Yayat
 * @email asepmedia18@gmail.com
 * @version 0.0.1
 * @since 2018
 */

 class Saga extends Saga_core
 {
  static $CI;

  /**
   * Constructor
   */
  public function __construct()
  {
    self::$CI =& get_instance();
  }

  /**
   * run function
   *
   * @param [type] $class
   * @return void
   */
  public function run($class)
  {
    $filter = ucfirst($class);
    return $this->run_core($filter);
  }

  /**
   * run function
   *
   * @param [type] $class
   * @return void
   */
  public function single($class)
  {
    $filter = ucfirst($class);
    return $this->runv2($filter);
  }

  /**
   * helper function
   *
   * @param [type] $class
   * @return void
   */
  public static function helper($class)
  {
    $name = strtolower('saga_helper_' . $class);
    $folder = strtolower('helpers');
    $file = self::$path  . '' .$folder . '/' . ucfirst($name) . '.php';
    $instance = ucfirst($name);   

    $data = array(
      'file' => $file,
      'instance' => $instance
    );

    return parent::helper($data);
  }

  /**
   * run function
   *
   * @param [type] $class
   * @return void
   */
  public static function call($path , $class)
  {
    $filter = ucfirst($class);
    return parent::call($path, $filter);
  }    
  /**
   * Undocumented function
   *
   * @param [type] $object
   * @return void
   */
  function with($object): object {
    $filter = ucfirst($object);
    return parent::run($filter);
  }

  /**
   * Undocumented function
   *
   * @param [type] $var
   * @return void
   */
  function __get($var) {
      // global $CI;
      // return $CI->$var;
      $filter = ucfirst($var);
      return $this->run_core($filter);   
  }   
 }