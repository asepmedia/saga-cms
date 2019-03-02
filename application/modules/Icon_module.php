<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Icon_module extends Module {
  
  static $response = array();

  public function __construct()
  {
    Theme::$saga->load->model('module/m_menu', 'm_menu');
  }

  /**
   * Index
   */
  public function index($module = 0) {
    $context['view'] = 'modules/icon/index';
    Theme::run($context);	
  }

  /**
   * Save Icon
   */
  public function create($module = 0) {
    $icon  = self::$CI->input->post('name');
    $keyword  = self::$CI->input->post('keyword');

    $data = array(
      'name' => $icon,
      'keyword' => $keyword
    );

    if(!$icon || !$keyword) {
      self::$response['status'] = 0;
      self::$response['message'] = 'Please complete form';
      self::json(self::$response);
      return false;
    }

    if($row = self::$CI->model->insert('saga_awesome_icon', $data)) {
      self::$response['status'] = 1;
      self::$response['message'] = 'Success add icon';
      self::$response['data'] = $row;
      self::json(self::$response);
    }
  }
}