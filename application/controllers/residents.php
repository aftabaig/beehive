<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once('beehive.php');

define ('EMP_ROLE_ID',3);

class Residents extends Beehive
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('resident_model');
		$this->load->model('contact_model');
	}
	
	public function create()
	{
		$data['page'] = 'resident';
		$data['title'] = 'Create Resident';
		$data['bread_crumb'] = 'Residents | Create Resident';
		$data['type'] = 'save';
		$this->load->view('template',$data);
	}
	
	public function edit()
	{
		
		$resident_id = $this->input->get('resident_id');
		$resident = $this->resident_model->get_resident_detail($resident_id);
		$contact = $this->contact_model->get_contact_detail($resident->contact_id);
		
		$data['resident'] = $resident;
		$data['contact'] = $contact;
		$data['page'] = 'resident';
		$data['title'] = 'Edit Resident';
		$data['bread_crumb'] = 'Residents | Edit Resident';
		$data['type'] = 'update';
		$this->load->view('template',$data);
	}
	
	public function save()
	{
		$this->form_validation->set_rules('resident_id','','');
		$this->form_validation->set_rules('contact_id','','');
		
		$this->form_validation->set_rules('first_name','First Name','required');
		$this->form_validation->set_rules('middle_name','','');
		$this->form_validation->set_rules('last_name','Last Name','required');
		$this->form_validation->set_rules('dob','','');
		$this->form_validation->set_rules('gender','','');
		$this->form_validation->set_rules('nick_name','','');
		$this->form_validation->set_rules('room_no','Room No.','required');
		$this->form_validation->set_rules('phone_no','','');
		$this->form_validation->set_rules('email','Email address','required|valid_email');
		$this->form_validation->set_rules('address','','');
		
		if ($this->form_validation->run() == FALSE) 
		{
			$data['page'] = 'resident';
			$data['title'] = 'Create Resident';
			$data['bread_crumb'] = 'Resident | Create Resident';
			$data['type'] = 'save';
			$this->load->view('template',$data);
		}
		else 
		{
		
			$home_id = $this->session->userdata('home_id');
			
			//resident detail.
			$first_name = $this->input->post('first_name');
			$middle_name = $this->input->post('middle_name');
			$last_name = $this->input->post('last_name');
			$nick_name = $this->input->post('nick_name');
			$dob = $this->input->post('dob');
			$gender = $this->input->post('gender');
			$room_no = $this->input->post('room_no');
			
			//contact detail.
			$phone_no = $this->input->post('phone_no');
			$email = $this->input->post('email');
			$address = $this->input->post('address');
			
			//insert data into contact_info and resident table.
			$contact_id = $this->contact_model->insert_contact($phone_no,$email,$address);
			$employee_id = $this->resident_model->insert_resident($first_name,$middle_name,$last_name,$nick_name,$gender,$room_no,$dob,$home_id,$contact_id);
			
			redirect('residents/view');
		}
	}
	
	public function update()
	{
		$this->form_validation->set_rules('resident_id','','');
		$this->form_validation->set_rules('contact_id','','');
		
		$this->form_validation->set_rules('first_name','First Name','required');
		$this->form_validation->set_rules('middle_name','','');
		$this->form_validation->set_rules('last_name','Last Name','required');
		$this->form_validation->set_rules('dob','','');
		$this->form_validation->set_rules('gender','','');
		$this->form_validation->set_rules('nick_name','','');
		$this->form_validation->set_rules('room_no','Room No.','required');
		$this->form_validation->set_rules('phone_no','','');
		$this->form_validation->set_rules('email','Email address','required|valid_email');
		$this->form_validation->set_rules('address','','');
			
		if ($this->form_validation->run() == FALSE) 
		{
			$data['page'] = 'resident';
			$data['title'] = 'Edit Resident';
			$data['type'] = 'update';
			$data['bread_crumb'] = 'Residents | Edit Resident';
			$this->load->view('template',$data);
		}
		else 
		{
		
			//resident detail.
			$resident_id = $this->input->post('resident_id');
			$first_name = $this->input->post('first_name');
			$middle_name = $this->input->post('middle_name');
			$last_name = $this->input->post('last_name');
			$nick_name = $this->input->post('nick_name');
			$dob = $this->input->post('dob');
			$gender = $this->input->post('gender');
			$room_no = $this->input->post('room_no');
			
			//contact detail.
			$contact_id = $this->input->post('contact_id');
			$phone_no = $this->input->post('phone_no');
			$email = $this->input->post('email');
			$address = $this->input->post('address');
				
			$home_id = $this->session->userdata('home_id');
		
			//update data in respective tables.
			$this->contact_model->update_contact($contact_id,$phone_no,$email,$address);
			$this->resident_model->update_resident($resident_id,$first_name,$middle_name,$last_name,$nick_name,$gender,$room_no,$dob,$home_id,$contact_id);
			
			redirect('residents/view');
		}
	}
	
	public function delete()
	{
		//TODO: Delete related contact info otherwise it will become orphan.
		$resident_id = $this->input->get('resident_id');
		$this->resident_model->delete_resident($resident_id);
		redirect('residents/view');
	}
	
	public function view()
	{
		$data['page'] = 'view_residents';
		$data['title'] = 'Residents List';
		$data['bread_crumb'] = 'Residents | List';
		$home_id = $this->session->userdata('home_id');
		$data['residents'] = $this->resident_model->get_all_residents($home_id);
		$this->load->view('template',$data);
	}
	
	public function rhome()
	{
		
		$resident_id = $this->input->get('resident_id');
		$resident = $this->resident_model->get_resident_detail($resident_id);
		$this->session->set_userdata('resident',$resident);
		
		$data['page'] = 'resident_home';
		$data['title'] = 'Resident Home';
		$data['bread_crumb'] = 'Residents | '.$resident->first_name.' '.$resident->last_name;
		$this->load->view('template',$data);
		
	}
}