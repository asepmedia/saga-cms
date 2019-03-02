<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY Controller
 */
class MY_Controller extends CI_Controller
{
  function __construct()
  {
      parent::__construct();
  }
}

/**
 * Admin Controller
 */
class Admin_Controller extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->saga->theme->switch('adminlte');
    if(!$this->session->userdata('user')) {
      redirect('auth');
    }    
  }
}

/**
 * Public Controller
 */
class Public_Controller extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->saga->theme->switch('saga');
  }
}

/**
 * Public Controller
 */
class Auth_Controller extends MY_Controller
{
  public $auth;

  public $theme;

  function __construct()
  {
    parent::__construct();
    $this->theme = $this->saga->theme->switch('adminlte')->view();
    $this->auth = $this->saga->single('auth');
  }
}