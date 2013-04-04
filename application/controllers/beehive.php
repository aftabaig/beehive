<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Beehive extends CI_Controller {

	public function __construct()
	{
	
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('calendar');
		session_start();
	
		$user_id = $this->session->userdata('user_id');
		if (!$user_id) 
		{
			if ($this->router->fetch_method() != "login" &&
				$this->router->fetch_method() != "authenticate")
			{
				redirect('users/login');
				return;
			}
		}
		
	}
	
}