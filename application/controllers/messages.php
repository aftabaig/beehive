<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once('beehive.php');

define('RES_TO_REL',1);
define('REL_TO_RES',2);

class Messages extends Beehive
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('message_model');
		$this->load->model('resident_model');
		$this->load->model('relative_model');
	}
	
	public function compose()
	{
		
		$home_id = $this->session->userdata('home_id');
		$resident = $this->session->userdata('resident');
		
		$data['page'] = 'compose_message';
		$data['title'] = 'Compose Message';
		$data['bread_crumb'] = 'Residents | '.$resident->first_name.' '.$resident->last_name.' | Messages | Compose Message';
		$data['relatives'] = self::_relatives($resident->id,$home_id,'Select');
		$data['selected'] = '0';
		$this->load->view('template',$data);
	}
		
	public function save()
	{
	
		$this->form_validation->set_rules('relative_id','To','greater_than[0]');
		$this->form_validation->set_rules('message','Message','required');
		
		$home_id = $this->session->userdata('home_id');
		$resident = $this->session->userdata('resident');
				
		if ($this->form_validation->run() == FALSE) 
		{
			$data['page'] = 'compose_message';
			$data['title'] = 'Compose Message';
			$data['bread_crumb'] = 'Residents | '.$resident->first_name.' '.$resident->last_name.' | Messages | Compose Message';
			$data['relatives'] = self::_relatives($resident->id,$home_id,'Select');
			$data['selected'] = '0';
			$this->load->view('template',$data);
		}
		else 
		{
			//message detail.
			$resident_id = $resident->id;
			$relative_id = $this->input->post('relative_id');
			$message = $this->input->post('message');
						
			//insert data into message table.
			$message_id = $this->message_model->insert_message($resident_id,$relative_id,$message,constant('RES_TO_REL'),0,$home_id);
			
			redirect('messages/resident');
		}
	}
	
	public function delete()
	{
		$message_id = $this->input->get('message_id');
		$home_id = $this->session->userdata('home_id');
		$this->message_model->delete_message($message_id,$home_id);
		redirect('messages/unread');
	}
	
	public function unread()
	{
		$data['page'] = 'unread_messages';
		$data['title'] = 'New Messages';
		$data['bread_crumb'] = 'Messages | New Messages';
		
		$home_id = $this->session->userdata('home_id');
		$resident_id = $this->input->get('resident_id');
		if (empty($resident_id)) 
		{
			$data['messages'] = $this->message_model->get_all_new_messages($home_id);
			$data['selected'] = 0;
		}
		else 
		{
			$data['messages'] = $this->message_model->get_all_new_messages_for_resident($resident_id,$home_id);
			$data['selected'] = $resident_id;
		}
		
		$data['residents'] = self::_residents($home_id);
		$this->load->view('template',$data);
	}
	
	public function resident()
	{
		$resident = $this->session->userdata('resident');
		if (empty($resident)) 
		{
			$resident_id = $this->input->get('resident_id');
			$resident = $this->resident_model->get_resident_detail($resident_id);
			$this->session->set_userdata('resident',$resident);
		}
		
		$home_id = $this->session->userdata('home_id');
		
		$data['page'] = 'resident_messages';
		$data['title'] = 'Resident Messages';
		$data['bread_crumb'] = 'Resident | '.$resident->first_name.' '.$resident->last_name.' | Messages';
		
		$relative_id = $this->input->get('relative_id');
		if (empty($relative_id))
		{
			$data['messages'] = $this->message_model->get_all_resident_messages($resident->id,$home_id);
			$data['selected'] = 0;
		}
		else
		{
			$data['messages'] = $this->message_model->get_all_resident_relative_messages($resident->id,$relative_id,$home_id);
			$data['selected'] = $relative_id;
		}
		
		$data['relatives'] = self::_relatives($resident->id,$home_id);
		$this->load->view('template',$data);
		
	}
	
	private function _residents($home_id)
	{
		$residents_list = array();
		$residents = $this->resident_model->get_all_residents($home_id);
		
		$residents_list[0] = '&nbsp;&nbsp;&nbsp;&nbsp;All';
		foreach ($residents as $resident)
		{
			$residents_list[$resident->id] = '&nbsp;&nbsp;&nbsp;&nbsp;'.$resident->first_name.' '.$resident->last_name;
		}
		return $residents_list;	
	}
	
	private function _relatives($resident_id,$home_id,$first="All")
	{
		$relatives_list = array();
		$relatives = $this->relative_model->get_resident_relatives($resident_id,$home_id);
		
		$relatives_list[0] = '&nbsp;&nbsp;&nbsp;&nbsp;'.$first;
		foreach ($relatives as $relative)
		{
			$relatives_list[$relative->id] = '&nbsp;&nbsp;&nbsp;&nbsp;'.$relative->first_name.' '.$relative->last_name;
		}
		return $relatives_list;
	}
}