<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once('beehive.php');

define ('EMP_ROLE_ID',3);

class Employees extends Beehive
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('employee_model');
		$this->load->model('contact_model');
		$this->load->model('user_model');
	}
	
	public function create()
	{
		$data['page'] = 'employee';
		$data['title'] = 'Create Employee';
		$data['bread_crumb'] = 'Employees | Create Employee';
		$data['type'] = 'save';
		$this->load->view('template',$data);
	}
	
	public function edit()
	{
		
		$employee_id = $this->input->get('employee_id');
		$employee = $this->employee_model->get_employee_detail($employee_id);
		$contact = $this->contact_model->get_contact_detail($employee->contact_id);
		$user = $this->user_model->get_user_detail($employee->user_id);
		
		$data['employee'] = $employee;
		$data['contact'] = $contact;
		$data['user'] = $user;
		$data['page'] = 'employee';
		$data['title'] = 'Edit Employee';
		$data['bread_crumb'] = 'Employees | Edit Employee';
		$data['type'] = 'update';
		$this->load->view('template',$data);
	}
	
	public function save()
	{
	
		$this->form_validation->set_rules('employee_id','','');
		$this->form_validation->set_rules('contact_id','','');
		$this->form_validation->set_rules('user_id','','');
		
		$this->form_validation->set_rules('first_name','First Name','required');
		$this->form_validation->set_rules('middle_name','','');
		$this->form_validation->set_rules('last_name','Last Name','required');
		$this->form_validation->set_rules('dob','','');
		$this->form_validation->set_rules('gender','','');
		$this->form_validation->set_rules('job_title','','');
		$this->form_validation->set_rules('phone_no','','');
		$this->form_validation->set_rules('email','Email address','required|valid_email');
		$this->form_validation->set_rules('address','','');
		$this->form_validation->set_rules('username','Username','required|min_length[6]|is_unique[user.username]');
		$this->form_validation->set_rules('password','Password','required|min_length[6]');
		
		if ($this->form_validation->run() == FALSE) 
		{
			$data['page'] = 'employee';
			$data['title'] = 'Create Employee';
			$data['bread_crumb'] = 'Employees | Create Employee';
			$data['type'] = 'save';
			$this->load->view('template',$data);
		}
		else 
		{
		
			$home_id = $this->session->userdata('home_id');
			
			//employee detail.
			$first_name = $this->input->post('first_name');
			$middle_name = $this->input->post('middle_name');
			$last_name = $this->input->post('last_name');
			$dob = $this->input->post('dob');
			$gender = $this->input->post('gender');
			$job_title = $this->input->post('job_title');
			
			//contact detail.
			$phone_no = $this->input->post('phone_no');
			$email = $this->input->post('email');
			$address = $this->input->post('address');
			
			//user detail.
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			//insert data into user,contact_info and home table.
			$user_id = $this->user_model->insert_user($username,$password,constant('EMP_ROLE_ID'));
			$contact_id = $this->contact_model->insert_contact($phone_no,$email,$address);
			$employee_id = $this->employee_model->insert_employee($first_name,$middle_name,$last_name,$dob,$gender,$job_title,$user_id,$home_id,$contact_id);
			
			redirect('employees/view');
		}
	}
	
	public function update()
	{
		
		$this->form_validation->set_rules('employee_id','','');
		$this->form_validation->set_rules('contact_id','','');
		$this->form_validation->set_rules('user_id','','');
		
		$this->form_validation->set_rules('first_name','First Name','required');
		$this->form_validation->set_rules('middle_name','','');
		$this->form_validation->set_rules('last_name','Last Name','required');
		$this->form_validation->set_rules('dob','','');
		$this->form_validation->set_rules('gender','','');
		$this->form_validation->set_rules('job_title','','');
		$this->form_validation->set_rules('phone_no','','');
		$this->form_validation->set_rules('email','Email address','required|valid_email');
		$this->form_validation->set_rules('address','','');
		$this->form_validation->set_rules('username','');
		$this->form_validation->set_rules('password','Password','required|min_length[6]');
			
		if ($this->form_validation->run() == FALSE) 
		{
			$data['page'] = 'employee';
			$data['title'] = 'Edit Employee';
			$data['type'] = 'update';
			$data['bread_crumb'] = 'Employees | Edit Employee';
			$this->load->view('template',$data);
		}
		else 
		{
		
			//employee detail.
			$employee_id = $this->input->post('employee_id');
			$first_name = $this->input->post('first_name');
			$middle_name = $this->input->post('middle_name');
			$last_name = $this->input->post('last_name');
			$dob = $this->input->post('dob');
			$gender = $this->input->post('gender');
			$job_title = $this->input->post('job_title');
			
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
			$this->contact_model->update_contact($contact_id,$phone_no,$email,$address);
			$this->employee_model->update_employee($employee_id,$first_name,$middle_name,$last_name,$dob,$gender,$job_title,$user_id,$home_id,$contact_id);
			
			redirect('employees/view');
		}
	}
	
	public function delete()
	{
		//TODO: Delete related contact/user info otherwise they will become orphan.
		$employee_id = $this->input->get('employee_id');
		$this->employee_model->delete_employee($employee_id);
		redirect('employees/view');
	}
	
	public function view()
	{
		$data['page'] = 'view_employees';
		$data['title'] = 'Employees List';
		$data['bread_crumb'] = 'Employees | List';
		$home_id = $this->session->userdata('home_id');
		$data['employees'] = $this->employee_model->get_all_employees($home_id);
		$this->load->view('template',$data);
	}
}