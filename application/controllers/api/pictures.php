<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include(APPPATH . '/core/REST_Controller.php');

class Pictures extends REST_Controller 
{

	public function __construct() 
	{
		parent::__construct();
		$this->load->model('picture_model');		
		$this->load->model('relative_model');		
	}
	
	//list all picture messages between the resident and the relative.
	//parameter:
	//1. user_id
	public function list_get()
	{
		$user_id = $this->input->get("user_id");
		
		if ($user_id > 0) 
		{
			$relative = $this->relative_model->get_relative_detail_by_userid($user_id);
			$messages = $this->picture_model->get_all_resident_relative_pictures(
																	 $relative->resident_id,
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
	
	public function upload_post()
	{
		$user_id = $this->input->post("user_id");
		
		if ($user_id > 0) 
		{
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = '*';
			$this->load->library('upload', $config);
		
			if ($this->upload->do_upload()) 
			{
				$upload_data = $this->upload->data();
				$relative = $this->relative_model->get_relative_detail_by_userid($user_id);
				$group_id = $this->picture_model->insert_group($relative->resident_id,$relative->id,2,0,$relative->home_id);
				$this->picture_model->insert_picture($group_id,$upload_data['file_name'],0,0);
				
				$this->response(array("status"=>0),200);
			}
			else 
			{
				$this->response(array("status"=>-1,"error"=>$this->upload->display_errors()),400);
			}
		}
	}
	
	public function mark_as_read_get()
	{
		$user_id = $this->input->get("user_id");
		$message_id = $this->input->get("message_id");
		
		if ($user_id > 0) 
		{
			$relative = $this->relative_model->get_relative_detail_by_userid($user_id);
			$this->picture_model->set_picture_group_as_read($message_id,$relative->home_id);
			$this->response(array("status"=>0),200);
		}
		else
		{
			$this->response(array("status"=>-1),404);
		}
	}
			
}