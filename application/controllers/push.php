<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once('beehive.php');
require_once 'urbanairship.php';

define('APPKEY','K_3pT4LGRBmdTGRYaPv7Uw'); 
define('PUSHSECRET', 'dJ5ksAl-Q66DqZXyD5-r6g'); // Master Secret
define('BROADCASTURL', 'https://go.urbanairship.com/api/push/broadcast/'); 
define('PUSHURL', 'https://go.urbanairship.com/api/push/'); 

class Push extends Beehive
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('push_model');
		$this->load->model('relative_model');
	}
	
	public function compose_notification()
	{
		
		$data['page'] = 'compose_notification';
		$data['title'] = 'Compose Notification';
		$data['bread_crumb'] = 'Notifications | Compose Notification';
		$this->load->view('template',$data);
	}
	
	public function compose_updates()
	{
		
		$resident = $this->session->userdata('resident');
		
		$data['page'] = 'compose_updates';
		$data['title'] = 'Compose Updates';
		$data['bread_crumb'] = 'Residents | '.$resident->first_name.' '.$resident->last_name.' | Updates | Compose Updates';
		$data['resident_id'] = $resident->id;
		$this->load->view('template',$data);
	}
	
	public function send_notification()
	{
	
		$this->form_validation->set_rules('message','Message','required');
				
		if ($this->form_validation->run() == FALSE) 
		{
			$data['page'] = 'compose_notification';
			$data['title'] = 'Compose Notification';
			$data['bread_crumb'] = 'Notifications | Compose Notification';
			$this->load->view('template',$data);
		}
		else 
		{
			//message detail.
			$message = $this->input->post('message');
			
			//broadcast message
			$contents = array(); 
 			$contents['badge'] = ""; 
 			$contents['alert'] = "NOTIFICATION:".$message; 
 			$contents['sound'] = ""; 
 			$push = array("aps" => $contents); 

 			$json = json_encode($push); 
			$session = curl_init(BROADCASTURL); 
			curl_setopt($session, CURLOPT_USERPWD, APPKEY . ':' . PUSHSECRET); 
			curl_setopt($session, CURLOPT_POST, True); 
 			curl_setopt($session, CURLOPT_POSTFIELDS, $json); 
			curl_setopt($session, CURLOPT_HEADER, False); 
 			curl_setopt($session, CURLOPT_RETURNTRANSFER, True); 
 			curl_setopt($session, CURLOPT_HTTPHEADER, array('Content-Type:application/json')); 
 			$content = curl_exec($session); 
 			
			$response = curl_getinfo($session); 
			if($response['http_code'] == 200) 
			{
				//insert data into message_push table.
				$message_id = $this->push_model->insert_message(0,$message);
			} 
			
 			curl_close($session);
			redirect('push/notifications');
		}
	}
	
	public function send_updates() 
	{
		$this->form_validation->set_rules('message','Message','required');
		
		$resident = $this->session->userdata('resident');
				
		if ($this->form_validation->run() == FALSE) 
		{
			$data['page'] = 'compose_updates';
			$data['title'] = 'Compose Updates';
			$data['bread_crumb'] = 'Residents | '.$resident->first_name.' '.$resident->last_name.' | Updates | Compose Updates';
			$data['resident_id'] = $resident->id;
			$this->load->view('template',$data);
		}
		else 
		{
			//message detail.
			$resident_id = $resident->id;
			$relatives = $this->relative_model->get_resident_relatives($resident->id,$resident->home_id);
			$message = $this->input->post('message');
			
			$device_tokens = array();
			foreach ($relatives as $relative)
			{
				if ($relative->device_id != NULL &&
					$relative->device_id != "")
				{
					$device_tokens[] = $relative->device_id;
				}
			}
			
			//broadcast message
			$contents = array(); 
 			$contents['badge'] = ""; 
 			$contents['alert'] = "UPDATE:".$message; 
 			$contents['sound'] = ""; 
 			$push = array("aps" => $contents,
 						  "device_tokens" => $device_tokens); 

 			$json = json_encode($push); 
			$session = curl_init(PUSHURL); 
			curl_setopt($session, CURLOPT_USERPWD, APPKEY . ':' . PUSHSECRET); 
			curl_setopt($session, CURLOPT_POST, True); 
 			curl_setopt($session, CURLOPT_POSTFIELDS, $json); 
			curl_setopt($session, CURLOPT_HEADER, False); 
 			curl_setopt($session, CURLOPT_RETURNTRANSFER, True); 
 			curl_setopt($session, CURLOPT_HTTPHEADER, array('Content-Type:application/json')); 
 			$content = curl_exec($session); 
 			
			$response = curl_getinfo($session); 
			if($response['http_code'] == 200) 
			{
				//insert data into message_push table.
				$message_id = $this->push_model->insert_message($resident_id,$message);
			} 
			
 			curl_close($session);
			redirect('push/updates');
		}
	}
	
	public function notifications()
	{
		$data['page'] = 'notifications';
		$data['title'] = 'Notifications';
		$data['bread_crumb'] = 'Notifications';
		$data['messages'] = $this->push_model->get_messages(0);
		
		$this->load->view('template',$data);
	}
	
	public function updates()
	{
		$resident = $this->session->userdata('resident');
		
		$data['page'] = 'updates';
		$data['title'] = 'Updates';
		$data['bread_crumb'] = 'Residents | '.$resident->first_name.' '.$resident->last_name.' | Updates';
		$data['messages'] = $this->push_model->get_messages($resident->id);
		
		$this->load->view('template',$data);
	}
}