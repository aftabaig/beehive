<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once('beehive.php');

class Users extends Beehive
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('resident_model');
		$this->load->model('relative_model');
	}
	
	public function index() 
	{
		$data['title'] = '';
		$data['bread_crumb'] = 'Home';
		$data['page'] = 'index';
		$this->load->view('template',$data);
	}
	
	public function login()
	{
		$data['title'] = 'Login';
		$this->load->view('login',$data);
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('users/login');
	}
		
	public function authenticate()
	{
		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');
		
		if ($this->form_validation->run() == FALSE) 
		{
			$data['title'] = 'Login';
			$this->load->view('login',$data);
		}
		else 
		{
			$username = $this->input->post("username");
			$password = $this->input->post("password");
			
			$user_id = $this->user_model->get_user_id($username,$password);
			if ($user_id == -1) 
			{
				$data['title'] = 'Login';
				$data['error'] = 'Invalid Username/Password.';
				$this->load->view('login',$data);
			}
			else
			{
				$permissions = $this->user_model->get_permissions($user_id);
				$menus = $this->user_model->get_menus($user_id);
				$user = $this->user_model->get_user_detail($user_id);
				$home_id = $this->user_model->get_home_id($user_id,$user->role_id);
				
				$this->session->set_userdata('user_id',$user_id);
				$this->session->set_userdata('home_id',$home_id);
				$this->session->set_userdata('username',$username);
				$this->session->set_userdata('permissions',$permissions);
				$this->session->set_userdata('menus',$menus);
				$this->session->set_userdata('role',$user->role_id);
				
				//if the user is an admin relative
				if ($user->role_id == 5)
				{
					//get relative's detail.
					$relative = $this->relative_model->get_relative_detail_by_userid($user->id);
					//get relative's resident.
					$resident = $this->resident_model->get_resident_detail($relative->resident_id);
					$this->session->set_userdata('resident',$resident);
				}
				redirect('users/index');
			}	
			
		}
	}

}