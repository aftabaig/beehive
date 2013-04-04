<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once('beehive.php');

define ('REL_ROLE_ID',4);
define ('REL_ADMIN_ROLE_ID',5);

class Relatives extends Beehive
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('relative_model');
		$this->load->model('contact_model');
		$this->load->model('user_model');
	}
	
	public function create()
	{
		$resident = $this->session->userdata('resident');
		
		$data['page'] = 'relative';
		$data['title'] = 'Create Relative';
		$data['role'] = $this->session->userdata('role');
		$data['bread_crumb'] = $resident->first_name.' '.$resident->last_name.' | Relatives | Create Relative';
		$data['type'] = 'save';
		$this->load->view('template',$data);
	}
	
	public function edit()
	{
		
		$relative_id = $this->input->get('relative_id');
		$resident = $this->session->userdata('resident');
		$relative = $this->relative_model->get_relative_detail($relative_id);
		$contact = $this->contact_model->get_contact_detail($relative->contact_id);
		$user = $this->user_model->get_user_detail($relative->user_id);
		
		$data['relative'] = $relative;
		$data['contact'] = $contact;
		$data['user'] = $user;
		$data['page'] = 'relative';
		$data['title'] = 'Edit Realtive';
		$data['role'] = $this->session->userdata('role');
		$data['bread_crumb'] = $resident->first_name.' '.$resident->last_name.' | Relatives | Edit Relative';
		$data['type'] = 'update';
		$this->load->view('template',$data);
	}
	
	public function save()
	{
		
		$resident = $this->session->userdata('resident');
	
		$this->form_validation->set_rules('relative_id','','');
		$this->form_validation->set_rules('contact_id','','');
		$this->form_validation->set_rules('user_id','','');
		
		$this->form_validation->set_rules('first_name','First Name','required');
		$this->form_validation->set_rules('last_name','Last Name','required');
		$this->form_validation->set_rules('relation','','');
		$this->form_validation->set_rules('is_admin','','');
		$this->form_validation->set_rules('phone_no','','');
		$this->form_validation->set_rules('email','Email address','required|valid_email');
		$this->form_validation->set_rules('address','','');
		$this->form_validation->set_rules('username','Username','required|min_length[6]|is_unique[user.username]');
		$this->form_validation->set_rules('password','Password','required|min_length[6]');
		
		if ($this->form_validation->run() == FALSE) 
		{
			$data['page'] = 'relative';
			$data['title'] = 'Create Relative';
			$data['role'] = $this->session->userdata('role');
			$data['bread_crumb'] = $resident->first_name.' '.$resident->last_name.' | Relatives | Create Relative';
			$data['type'] = 'save';
			$this->load->view('template',$data);
		}
		else 
		{
		
			$home_id = $this->session->userdata('home_id');
			
			//relative detail.
			$first_name = $this->input->post('first_name');
			$last_name = $this->input->post('last_name');
			$relation = $this->input->post('relation');
			$is_admin = $this->input->post('is_admin')==='on'?1:0;
			
			//contact detail.
			$phone_no = $this->input->post('phone_no');
			$email = $this->input->post('email');
			$address = $this->input->post('address');
			
			//user detail.
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			//insert data into user,contact_info and home table.
			$user_id = $this->user_model->insert_user($username,$password,$is_admin==1?constant('REL_ADMIN_ROLE_ID'):constant('REL_ROLE_ID'));
			$contact_id = $this->contact_model->insert_contact($phone_no,$email,$address);
			$relative_id = $this->relative_model->insert_relative($first_name,$last_name,$resident->id,$relation,$is_admin,$user_id,$home_id,$contact_id);
			
			redirect('relatives/view');
		}
	}
	
	public function update()
	{
	
		$resident = $this->session->userdata('resident');
		
		$this->form_validation->set_rules('relative_id','','');
		$this->form_validation->set_rules('contact_id','','');
		$this->form_validation->set_rules('user_id','','');
		
		$this->form_validation->set_rules('first_name','First Name','required');
		$this->form_validation->set_rules('last_name','Last Name','required');
		$this->form_validation->set_rules('relation','','');
		$this->form_validation->set_rules('is_admin','','');
		$this->form_validation->set_rules('phone_no','','');
		$this->form_validation->set_rules('email','Email address','required|valid_email');
		$this->form_validation->set_rules('address','','');
		$this->form_validation->set_rules('username','');
		$this->form_validation->set_rules('password','Password','required|min_length[6]');
		
		if ($this->form_validation->run() == FALSE) 
		{
			$data['page'] = 'relative';
			$data['title'] = 'Edit Relative';
			$data['role'] = $this->session->userdata('role');
			$data['type'] = 'update';
			$data['bread_crumb'] = $resident->first_name.' '.$resident->last_name.' | Relatives | Edit Relative';
			$this->load->view('template',$data);
		}
		else 
		{
		
			//relative detail.
			$relative_id = $this->input->post('relative_id');
			$first_name = $this->input->post('first_name');
			$last_name = $this->input->post('last_name');
			$relation = $this->input->post('relation');
			$is_admin = $this->input->post('is_admin')==='on'?1:0;
			
			//contact detail.
			$contact_id = $this->input->post('contact_id');
			$phone_no = $this->input->post('phone_no');
			$email = $this->input->post('email');
			$address = $this->input->post('address');
				
			//user detail.
			$user_id = $this->input->post('user_id');
			$password = $this->input->post('password');	
			
			$home_id = $this->session->userdata('home_id');
		
			//update data in respective tables.
			$this->user_model->update_user($user_id,$password);
			$this->user_model->update_role($user_id,$is_admin==1?5:4);
			$this->contact_model->update_contact($contact_id,$phone_no,$email,$address);
			$this->relative_model->update_relative($relative_id,$first_name,$last_name,$resident->id,$relation,$is_admin,$user_id,$home_id,$contact_id);
			
			redirect('relatives/view');
		}
	}
	
	public function delete()
	{
		//TODO: Delete related contact/user info otherwise they will become orphan.
		$relative_id = $this->input->get('relative_id');
		$this->employee_model->delete_employee($employee_id);
		redirect('relatives/view');
	}
	
	public function view()
	{
		$home_id = $this->session->userdata('home_id');
		$resident = $this->session->userdata('resident');

		$data['page'] = 'view_relatives';
		$data['title'] = 'Relatives List';
		$data['bread_crumb'] = $resident->first_name.' '.$resident->last_name.' | Relatives | List';
		
		$data['relatives'] = $this->relative_model->get_resident_relatives($resident->id,$home_id);
		$this->load->view('template',$data);
	}
}