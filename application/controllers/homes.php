<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once('beehive.php');

define ('HOME_ROLE_ID',2);

class Homes extends Beehive
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('home_model');
		$this->load->model('contact_model');
		$this->load->model('user_model');
	}
	
	public function create()
	{
		$data['page'] = 'home';
		$data['title'] = 'Create Home';
		$data['bread_crumb'] = 'Bee-Homes | Create Home';
		$data['type'] = 'save';
		$this->load->view('template',$data);
	}
	
	public function edit()
	{
		
		$home_id = $this->input->get('home_id');
		$home = $this->home_model->get_home_detail($home_id);
		$contact = $this->contact_model->get_contact_detail($home->contact_id);
		$user = $this->user_model->get_user_detail($home->user_id);
		
		$data['home'] = $home;
		$data['contact'] = $contact;
		$data['user'] = $user;
		$data['page'] = 'home';
		$data['title'] = 'Edit Home';
		$data['bread_crumb'] = 'Bee-Homes | Edit Home';
		$data['type'] = 'update';
		$this->load->view('template',$data);
	}
	
	public function save()
	{
	
		$this->form_validation->set_rules('home_id','','');
		$this->form_validation->set_rules('contact_id','','');
		$this->form_validation->set_rules('user_id','','');
		
		$this->form_validation->set_rules('home_name','Home Name','required|min_length[5]');
		$this->form_validation->set_rules('phone_no','','');
		$this->form_validation->set_rules('email','Email address','required|valid_email');
		$this->form_validation->set_rules('address','','');
		$this->form_validation->set_rules('username','Username','required|min_length[6]|is_unique[user.username]');
		$this->form_validation->set_rules('password','Password','required|min_length[6]');
		
		if ($this->form_validation->run() == FALSE) 
		{
			$data['page'] = 'home';
			$data['title'] = 'Create Home';
			$data['bread_crumb'] = 'Bee-Homes | Create Home';
			$data['type'] = 'save';
			$this->load->view('template',$data);
		}
		else 
		{
			
			//home detail.
			$home_name = $this->input->post('home_name');
			
			//contact detail.
			$phone_no = $this->input->post('phone_no');
			$email = $this->input->post('email');
			$address = $this->input->post('address');
			
			//user detail.
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			//insert data into user,contact_info and home table.
			$user_id = $this->user_model->insert_user($username,$password,constant('HOME_ROLE_ID'));
			$contact_id = $this->contact_model->insert_contact($phone_no,$email,$address);
			$home_id = $this->home_model->insert_home($home_name,$user_id,$contact_id);
			
			redirect('homes/view');
		}
	}
	
	public function update()
	{
		
		$this->form_validation->set_rules('home_id','','');
		$this->form_validation->set_rules('contact_id','','');
		$this->form_validation->set_rules('user_id','','');
		
		$this->form_validation->set_rules('home_name','Home Name','required|min_length[5]');
		$this->form_validation->set_rules('phone_no','','');
		$this->form_validation->set_rules('email','Email address','required|valid_email');
		$this->form_validation->set_rules('address','','');
		$this->form_validation->set_rules('username','','');
		$this->form_validation->set_rules('password','Password','required|min_length[6]');
		
		if ($this->form_validation->run() == FALSE) 
		{
			$data['page'] = 'home';
			$data['title'] = 'Edit Home';
			$data['type'] = 'update';
			$data['bread_crumb'] = 'Bee-Homes | Edit Home';
			$this->load->view('template',$data);
		}
		else 
		{
		
			//home detail.
			$home_id = $this->input->post('home_id');
			$home_name = $this->input->post('home_name');
				
			//contact detail.
			$contact_id = $this->input->post('contact_id');
			$phone_no = $this->input->post('phone_no');
			$email = $this->input->post('email');
			$address = $this->input->post('address');
				
			//user detail.
			$user_id = $this->input->post('user_id');
			$password = $this->input->post('password');	
		
			//update data in respective tables.
			$this->user_model->update_user($user_id,$password);
			$this->contact_model->update_contact($contact_id,$phone_no,$email,$address);
			$this->home_model->update_home($home_id,$home_name,$user_id,$contact_id);
			
			redirect('homes/view');
		}
	}
	
	public function delete()
	{
		//TODO: Delete related contact/user info otherwise they will become orphan.
		$home_id = $this->input->get('home_id');
		$this->home_model->delete_home($home_id);
		redirect('homes/view');
	}
	
	public function view()
	{
		$data['page'] = 'view_homes';
		$data['title'] = 'Homes List';
		$data['bread_crumb'] = 'Bee-Homes | List';
		$data['homes'] = $this->home_model->get_all_homes();
		$this->load->view('template',$data);
	}
}