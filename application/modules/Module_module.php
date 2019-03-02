<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Module_module extends Module {

  public function __construct()
  {
    $this->withRole();
  }  
  
  /**
   * Get Method
   */
  public function method($module = 0)
  {
    $module = $this->input->get('module') ?? 'Menu_module';
    $type = $this->input->get('type') ?? 'modules';
    $path = $this->input->get('path');
    $folder = $path != '/' ? '/' . $path . '/' : '/';

    $data = array();
    if(!class_exists($module)) {
      $this->saga->call(APPPATH . $type . $folder , $module);
    }

    foreach(get_class_methods($module) as $method) {
      $r = new ReflectionMethod($module, $method);
      $params = $r->getParameters();
      if(isset($params[0]->name) && $params[0]->name == 'module') {
        $data[] = $method;
      }
    }

    self::json($data);
  }  

  /**
   * dir function
   *
   * @param integer $module
   * @return void
   */
  public function dir($module  = 0)
  {
    $root = APPPATH . 'modules/';
    $iter = new RecursiveIteratorIterator(
      new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS),
      RecursiveIteratorIterator::SELF_FIRST,
      RecursiveIteratorIterator::CATCH_GET_CHILD // Ignore "Permission denied"
    );
    
    $paths = array($root);
    foreach ($iter as $path => $dir) {
        if ($dir->isDir()) {
            $paths[] = str_replace($root, "/", $dir);
        }
    }
    
    $dir = str_replace($paths[0], "/", $paths);
    sort($dir);
    self::json($dir);
  }

  public function list_module($module = 0) {
    $path = $this->input->get('path', TRUE) ?? '/';
    $list = $this->saga->run('widget')->list('modules', $path);
    self::json($list);
  }
}