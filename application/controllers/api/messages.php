<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include(APPPATH . '/core/REST_Controller.php');

class Messages extends REST_Controller 
{

	public function __construct() 
	{
		parent::__construct();
		$this->load->model('message_model');		
		$this->load->model('relative_model');		
	}
	
	//list all messages between the resident and the relative.
	//parameter:
	//1. user_id
	public function list_get()
	{
		$user_id = $this->input->get("user_id");
		
		if ($user_id > 0) 
		{
			$relative = $this->relative_model->get_relative_detail_by_userid($user_id);
			$messages = $this->message_model->get_all_resident_relative_messages($relative->resident_id,
																	 $relative->id,
																	 $relative->home_id);
			$this->response(array("status"=>0,
								  "messages"=>$messages
								  ),200);
		}
		else 
		{
			$this->response(array("status"=>-1),404);
		}
	}
	
	public function send_post()
	{
		$user_id = $this->input->post("user_id");
		$message = $this->input->post("message");
		
		if ($user_id > 0) 
		{
			$relative = $this->relative_model->get_relative_detail_by_userid($user_id);
			$message_id = $this->message_model->insert_message($relative->resident_id,
												 $relative->id,
												 $message,
												 2,
												 0,
												 $relative->home_id);
			$this->response(array("status"=>0,
								  "message_id"=>$message_id
								  ),200);
			
		}
		else
		{
			$this->response(array("status"=>-1),404);
		}
	}
	
	public function mark_as_read_get()
	{
		$user_id = $this->input->post("user_id");
		$message = $this->input->post("message");
		
		if ($user_id > 0) 
		{
			$relative = $this->relative_model->get_relative_detail_by_userid($user_id);
			$this->message_model->set_message_as_read($message_id,$relative->home_id);
			$this->response(array("status"=>0),200);
		}
		else
		{
			$this->response(array("status"=>-1),404);
		}
	}
			
}