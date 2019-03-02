<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Page_module extends Module {
  
  static $response = array();

  public function __construct()
  {
   
  }

  /**
   * Index
   */
  public function index($module = 0) {
    $context['view'] = 'modules/blog/post/index';
    Theme::run($context);	
  }

  /**
   * Index
   */
  public function create($module = 0) {
    $context['view'] = 'modules/blog/post/create';
    Theme::run($context);	
  }

  /**
   * save function
   *
   * @param [type] $module
   * @return void
   */
  public function save($module) {
    $data = array(
      'post_title' => $this->input->post('post_title', TRUE),
      'post_content' => $this->input->post('post_content', TRUE),
      'post_slug' => $this->input->post('post_slug', TRUE),
      'post_type' => $this->input->post('post_type', TRUE),
      'post_status' => $this->input->post('post_status', TRUE)
    );
  }
}