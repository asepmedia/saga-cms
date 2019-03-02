<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Saga Dynamic CMS
 * @author Asep Yayat
 * @email asepmedia18@gmail.com
 * @version 0.0.1
 * @since 2018
 */

class Saga_core
{
  /**
  * Property
  */
  public $path = 'src/';
  public $class = '';

  /**
   * Constructor
   */
  public function __construct()
  {

  }

  /**
   * run function
   *
   * @param [type] $class
   * @return void
   */
  public function run_core($class)
  {
    $folder = strtolower($class);
    $file = $this->path  . $folder . '/' . $class . '.php';

    require_once $file; // require

    $this->class = new $class;

    return $this->class;
  }

  /**
   * run v1
   *
   * @param [type] $class
   * @return void
   */
  public function runv2($class)
  {
    $name = strtolower('saga_' . $class);
    $file = $this->path  . '' .$name . '/' . ucfirst($name) . '.php';
    $instance = ucfirst($name);

    require_once $file; // require

    $this->class = new $instance;

    return $this->class;
  }

  /**
   * run v1
   *
   * @param [type] $class
   * @return void
   */
  public static function helper($data)
  {
    require_once $data['file'];

    $this->class = new $data['instance'];

    return $this->class;
  }

  /**
   * call function
   *
   * @param [type] $class
   * @return void
   */
  public static function call($path, $class)
  {
    $folder = strtolower($class);
    $file = $path . $class . '.php';

    require_once $file;

    $class = new $class;

    return $class;
  }  
}