<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Saga Dynamic CMS
 * @author Asep Yayat
 * @email asepmedia18@gmail.com
 * @version 0.0.1
 * @since 2018
 */
class Module {
  
  /**
   * Property
   */
  public $data = array();

  public $path;

  public $CI;

  public $role_args = array();

  /**
   * constructor function
   */
  public function __construct()
  {
    $this->path = APPPATH . 'modules/';
    $this->CI =& get_instance();
  }

  /**
   * name function
   *
   * @param [type] $name
   * @return void
   */
  public static function name($name)
  {
    $this->data['name'] = $name;
    return $this;
  }

  /**
   * action function
   *
   * @param [type] $action
   * @return void
   */
  public static function action($action)
  {
    $this->data['action'] = $action;
    return $this;
  }  

  /**
   * data function
   *
   * @param [type] $data
   * @return void
   */
  public static function data($data)
  {
    $this->data['data'] = $data;
    return $this;
  }  

  /**
   * args function
   *
   * @param [type] $data
   * @return void
   */
  public function args($args)
  {
    $explode = explode("/", $args);
    unset($explode[0]);
    $this->data['args'] = $explode;
    return $this;
  }  

  // /**
  //  * run function
  //  *
  //  * @return void
  //  */
  // public static function run()
  // {
  //   $args = $this->data['args'];

  //   $name = ucfirst($this->data['name'] . '_module');

  //   $file = $this->path . $name . '.php';

  //   if(!file_exists($file)) {
  //     echo 'Page not found';
  //     return false;
  //   }

  //   require $file;

  //   $class = new $name;

  //   if(!method_exists($class, $this->data['action'])) {
  //     echo 'Page not found';
  //     return false;
  //   }
  //   return call_user_func_array(array($class, $this->data['action']), array_slice($args, 1));
  // }

  /**
   * run function
   *
   * @return void
   */
  public function run()
  {
    $args = $this->data['args'];

    if(count($args) <= 1) {
      redirect(base_url());
    }
    
    $func_class = array_slice($args, -2, 2, true);

    $last_path = end($args);

    if(is_numeric($last_path)) {
      $func_class = array_slice($args, -3, 3, true);
    }

    $folder = implode("/",array_diff($args, $func_class)) . '/';

    $save_class_func = array_combine(range(1, count($func_class)), $func_class);
    
    $this->data['name'] = $save_class_func[1];

    $this->data['action'] = $save_class_func[2];

    $name = ucfirst($this->data['name'] . '_module');

    $file = $this->path . $folder . $name . '.php';

    if(!file_exists($file)) {
     echo 'Page not found';
      return false;
    }

    require $file;

    $class = new $name;

    if(!method_exists($class, $this->data['action'])) {
      echo 'Page not found';
      return false;
    }
    return call_user_func_array(array($class, $this->data['action']), array_slice($args, -2));
  }  

  /**
   * Json
   */
  public function json($response = array())
  {
    $this->output
      ->set_content_type('application/json', 'utf-8')
      ->set_output(json_encode($response, JSON_PRETTY_PRINT))
      ->_display();
      exit;    
  }

  /**
   * Undocumented function
   *
   * @param [type] $url
   * @return void
   */
  public function url($url)
  {
    return str_replace("@", base_url(),$url);
  }
  
  public function withRole($role = 0)
  {
   $this->saga->run('role')->module($role, $this->role_args);
  }

  public function with($args = 0)
  {
    $this->role_args = $args;
    return $this;
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