<?php

class Auth extends Auth_Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
		$this->load->view($this->theme . 'auth/login');
  }

  public function login()
  {
    $email = $this->input->post('email');
    $password = $this->input->post('password');

    $data = array(
      'email' => $email,
      'password' => $password
    );

    $data = $this->auth
      ->email($email)
      ->password($password)
      ->login()
      ->redirect(base_url());
  }  

	public function logout()
	{
    $this->session->sess_destroy();
    redirect(base_url('auth'));
	}  
}