<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Post_module extends Module {
  
  static $response = array();

  public function __construct()
  {
   
  }

  /**
   * Index
   */
  public function index($module = 0) {
    $context['view'] = 'modules/blog/post/index';
    $this->saga->theme->run($context);
  }
}