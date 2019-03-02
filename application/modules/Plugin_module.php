<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Plugin_module {
  
  public function index() {
    $context['view'] = 'modules/plugin/index';
    Theme::run($context);	
  }

  public function create() {}

  public function save() {
    echo json_encode(array(
      'data' => 1
    ));
  }

  public function delete() {}

  public function read() {}
  
}