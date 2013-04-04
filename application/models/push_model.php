<?php

class Push_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//description: insert new push message
	//parameters: resident-id,message
	//returns: newly inserted contact's id
	public function insert_message($resident_id,$message)
	{
		$data = array(
				'resident_id' => $resident_id,
				'message' => $message
				);
				
		$this->db->insert('message_push',$data);
		return $this->db->insert_id();
		
	}
	
	//description: delete message
	//parameters: message-id
	//returns: void
	public function delete_message($message_id)
	{
		$this->db->where('id',$message_id);
		$this->db->delete('message_push');

	}
	
	//description: get push messages
	//parameters: resident-id
	//returns: array of push-messages
	public function get_messages($resident_id) 
	{	
		$this->db->select('*');
		$this->db->from('message_push');
		$this->db->where('resident_id',$resident_id);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	
}