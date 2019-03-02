<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Saga Dynamic CMS
 * @author Asep Yayat
 * @email asepmedia18@gmail.com
 * @version 0.0.1
 * @since 2018
 */
class Widget {


  /**
   * construct function
   */
  public function __construct()
  {

  }
  
  /**
   * list function
   */
  public static function list($name = 'modules', $dir = '',  $affix = 'module')
  {
    $list = array();
    
    $search = array(
      "_$affix.php",
      "_",
    );
    
    $replace = array(
      "",
      " "
    );

    $append_dir = $dir != '' ? $dir . '/' : '/';

    $path = APPPATH . strtolower($name) . $append_dir;
    // $files = array_values( preg_grep(['/^((?!Module_module.php).)*$/'], glob($path . "*.php") ) );
    $file = glob($path . "*.php");
    foreach($file as $k =>$module) {
      // $mod = array_search($path . 'Module_module.php', $file);
      // $role = array_search($path . 'Role_module.php', $file);
      $list[] = array(
        'name' => ucwords(basename(str_replace($search, $replace, $module))),
        'original_name' => basename($module),
        'class_name' => basename(str_replace(".php", "", $module))
      );
      // unset($list[$role]);
      // unset($list[$mod]);
    }    

    return  $list;
  }

  /**
   * Call widget
   */
  public static function module($name = 'module')
  {
    $path = APPPATH . ucfirst($name . 's');

    $file = ucfirst($name);

    if(!file_exists($path . '/' . $file . '.php')) {
      echo 'File tidak ada';
      return false;
    }

    $class = new $file;

    $args = array(
      'list' => self::list('module')
    );

    return call_user_func_array(array($class, 'init'), $args);
  }
}