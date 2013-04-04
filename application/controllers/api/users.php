<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include(APPPATH . '/core/REST_Controller.php');

class Users extends REST_Controller 
{

	public function __construct() 
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('relative_model');
		$this->load->model('resident_model');
		$this->load->model('home_model');
		
	}
	
	//user login method.
	//parameters:
	//1. username
	//2. password
	public function authenticate_post()
	{
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		$device_id = $this->input->post("device_id");
		
		$user_id = $this->user_model->get_user_id($username,$password);
		if ($user_id > 0) 
		{
			$user = $this->user_model->get_user_detail($user_id);
			if ($user->role_id != 4 &&
				$user->role_id != 5)
			{
				$this->response(array("status"=>-1),404);
			}
			else
			{
				$relative = $this->relative_model->get_relative_detail_by_userid($user_id);
				$this->relative_model->update_device_id($relative->id,$device_id);
				$resident = $this->resident_model->get_resident_detail($relative->resident_id);
				$home = $this->home_model->get_home_detail($relative->home_id);
				$this->response(array
								(
								"status"=>0,
								"user_id"=>$user_id,
								"relative"=>$relative,
								"resident"=>$resident,
								"home"=>$home
								),200);
			}
		}
		else
		{
			$this->response(array("status"=>-1),404);
		}
	}
	
	//to check if user is required to reenter his password.
	//parameters:
	//1. user-name
	//2. password
	public function required_auth_post()
	{
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		
		$user_id = $this->user_model->get_user_id($username,$password);
		if ($user_id > 0) 
		{
			$this->response(array("status"=>0),200);
		}
		else
		{
			$this->response(array("status"=>-1),404);
		}	
	}	
}