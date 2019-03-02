<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Admin_Controller {

	public function index()
	{
		$context['view'] = 'dashboard';
		$context['module'] = 'dashboard';
		Theme::run($context);	
	}

	public function form()
	{
		$context['view'] = 'form';
		$context['module'] = 'form';
		Theme::run($context);	
	}	

	public function widget()
	{
		$context['view'] = 'dashboard';
		$context['module'] = 'setting';
		Theme::run($context);	
	}	

	public function clear()
	{
		$this->session->sess_destroy();
	}
}
