<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modules extends Admin_Controller {
  /**
   * index function
   *
   * @return void
   */
	// public function index($name = 'menu', $action = 'index')
	// {
  //   // $name = $this->uri->segment(2);
  //   // $action = $this->uri->segment(3);
  //   // $data = $this->uri->segment(4);

  //   Saga::run('module')
  //     ->name($name)
  //     ->action($action)
  //     ->run();
  // }  
  public function test()
  {
    $args = $this->uri->uri_string();

    echo "<pre>";
    print_r($args);
  }

  public function index()
  {
    $args = $this->uri->uri_string();
    $this->saga->module
    ->args($args)
    ->run();  
  }
  /**
   * Get Method
   */
  public function method()
  {
    $module = $this->input->get('module');
    $type = $this->input->get('type');

    $data = array();

    Saga::call(APPPATH . $type . '/' , $module);

    foreach(get_class_methods($module) as $method) {
      $r = new ReflectionMethod($module, $method);
      // $params = $r->getParameters();
      // if(isset($params[0]->name) && $params[0]->name == 'page') {
      //   $data[] = $method;
      // }
      $data[] = $method;
    }

    echo json_encode($data);
  }
}