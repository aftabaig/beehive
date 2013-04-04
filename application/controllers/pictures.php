<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once('beehive.php');

define('RES_TO_REL',1);
define('REL_TO_RES',2);

class Pictures extends Beehive
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('picture_model');
		$this->load->model('resident_model');
		$this->load->model('relative_model');
	}
	
	public function upload()
	{
		$home_id = $this->session->userdata('home_id');
		$resident = $this->session->userdata('resident');
		
		$data['page'] = 'upload_pictures';
		$data['title'] = 'Upload Pictures';
		$data['bread_crumb'] = 'Residents | '.$resident->first_name.' '.$resident->last_name.' | Pictures | Upload Pictures';
		$data['relatives'] = self::_relatives($resident->id,$home_id,'Select');
		$data['selected'] = 0;
		$this->load->view('template',$data);
	}
		
	public function do_upload()
	{
		
		$this->form_validation->set_rules('relative_id','To','greater_than[0]');
				
		if ($this->form_validation->run() == FALSE) 
		{
			$home_id = $this->session->userdata('home_id');
			$resident = $this->session->userdata('resident');
			
			$data['page'] = 'upload_pictures';
			$data['title'] = 'Upload Pictures';
			$data['bread_crumb'] = 'Residents | '.$resident->first_name.' '.$resident->last_name.' | Pictures | Upload Pictures';
			$data['relatives'] = self::_relatives($resident->id,$home_id,'Select');
			$data['selected'] = 0;
			$this->load->view('template',$data);
		}
		else 
		{
			$relative_id = $this->input->post('relative_id');
			$home_id = $this->session->userdata('home_id');
			$resident = $this->session->userdata('resident');
			
			$group_id = $this->picture_model->insert_group($resident->id,$relative_id,1,0,$home_id);
			
			// Load the library - no config specified here
        	$this->load->library('upload');
        	
        	$count=0;
        	for ($i=1; $i<=5; $i++) 
        	{
				if (!empty($_FILES['userfile'.$i]['name']))
        		{
            		
            		$count++;
            		
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size'] = '1024';
					$config['max_width']  = '2000';
					$config['max_height']  = '2000';       
 
            		$this->upload->initialize($config);
 
					if ($this->upload->do_upload('userfile'.$i))
					{
						$data = $this->upload->data();
						$file_name = $data['file_name'];
						$width = $data['image_width'];
						$height = $data['image_height'];
						$this->picture_model->insert_picture($group_id,$file_name,$width,$height);
					}
					else
					{
						$error = $this->upload->display_errors();
						echo $error;
						exit(0);
						$data['page'] = 'upload_pictures';
						$data['title'] = 'Upload Pictures';
						$data['bread_crumb'] = 'Pictures | Upload Pictures';
						$data['relatives'] = self::_relatives($resident->id,$home_id,'Select');
						$data['selected'] = 0;
						$this->load->view('template',$data,$error);
					}
 				}
 				
 				if ($count == 0) 
 				{
 					$this->picture_model->delete_picture_group($group_id,$home_id);
 				}
 				
        	}
        	redirect('pictures/upload');
        }
 		
	}
	
	public function delete()
	{
		$group_id = $this->input->get('group_id');
		$home_id = $this->session->userdata('home_id');
		$this->message_model->delete_group($group_id,$home_id);
		redirect('pictures/unread');
	}
	
	public function unread()
	{
		$data['page'] = 'unread_pictures';
		$data['title'] = 'New Pictures';
		$data['bread_crumb'] = 'Pictures | New Pictures';
		
		$home_id = $this->session->userdata('home_id');
		$resident_id = $this->input->get('resident_id');
		if (empty($resident_id)) 
		{
			$data['picture_groups'] = $this->picture_model->get_all_new_picture_groups($home_id);
			$data['selected'] = 0;
		}
		else 
		{
			$data['picture_groups'] = $this->picture_model->get_all_new_picture_groups_for_resident($resident_id,$home_id);
			$data['selected'] = $resident_id;
		}
		
		$data['residents'] = self::_residents($home_id);
		$this->load->view('template',$data);
	}
	
	public function resident()
	{
		$resident = $this->session->userdata('resident');
		$home_id = $this->session->userdata('home_id');
		
		$data['page'] = 'resident_pictures';
		$data['title'] = 'Resident Pictures';
		$data['bread_crumb'] = 'Resident | '.$resident->first_name.' '.$resident->last_name.' | Pictures';
		
		$relative_id = $this->input->get('relative_id');
		if (empty($relative_id))
		{
			$data['picture_groups'] = $this->picture_model->get_all_resident_pictures($resident->id,$home_id);
			$data['selected'] = 0;
		}
		else
		{
			$data['picture_groups'] = $this->picture_model->get_all_resident_relative_pictures($resident->id,$relative_id,$home_id);
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
	
	private function _relatives($resident_id,$home_id,$first='All')
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