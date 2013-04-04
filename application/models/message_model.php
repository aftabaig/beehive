<?php

class Message_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//description: insert new message.
	//parameters: resident-id,relative-id,message,to_forth*,is_read*,home_id
	//to_forth: '1' for message from resident to relative 
	//			'2' for message from relative back to resident
	//is_read:  flag to set message as read (read=1,unread=0)
	//			would always be 0 when inserting a new message.
	//timestamp: this is another field in message table but it' populated 
	//			 by default to current timestamp.
	//returns: newly inserted message's id
	function insert_message($resident_id,$relative_id,$message,$to_forth,$is_read,$home_id)
	{
		$data = array(
				'resident_id' => $resident_id,
				'relative_id' => $relative_id,
				'message' => $message,
				'to_forth' => $to_forth,
				'is_read' => $is_read,
				'home_id' => $home_id
				);
		$this->db->insert('message',$data);
		return $this->db->insert_id();
	}
	
	function set_message_as_read($message_id,$home_id)
	{
		$data = array(
				'is_read' => 1
				);
				
		$this->db->where('id',$message_id);
		$this->db->where('home_id',$home_id);
		$this->db->update('message',$data);
	}
	
	//description: deletes message
	//parameters: message-id
	function delete_message($message_id,$home_id)
	{
		$this->db->where('id',$message_id);
		$this->db->where('home_id',$home_id);
		$this->db->delete('message');
	}
	
	//description: deletes all message to/from resident
	//parameters: resident_id
	function delete_resident_messages($resident_id,$home_id)
	{
		$this->db->where('resident_id',$resident_id);
		$this->db->where('home_id',$home_id);
		$this->db->delete('message');
	}
	
	//description: deletes all message to/from relative
	//parameters: relative_id
	function delete_relative_messages($relative_id,$home_id)
	{
		$this->db->where('relative_id',$relative_id);
		$this->db->where('home_id',$home_id);
		$this->db->delete('message');
	}
	
	//description: get all new messages (having read flag set to 0)
	//parameters: void
	//returns: list of new messages.
	function get_all_new_messages($home_id)
	{
		$this->db->select('*');
		$this->db->from('message_view');
		$this->db->where('is_read',0);
		//we need to show only those new messages that are
		//sent from relative to resident (to_forth=2).
		$this->db->where('to_forth',2);
		$this->db->where('home_id',$home_id);
		$this->db->order_by('message_date','DESC');
		$query = $this->db->get();
		return $query->result();
	}
	
	//description: get all new messages for a specific resident
	//parameters: resident-id
	//returns: list of new messages for that particular resident.
	function get_all_new_messages_for_resident($resident_id,$home_id)
	{
		$this->db->select('*');
		$this->db->from('message_view');
		$this->db->where('is_read',0);
		//we need to show only those new messages that are
		//sent from relative to resident (to_forth=2).
		$this->db->where('to_forth',2);
		$this->db->where('resident_id',$resident_id);
		$this->db->where('home_id',$home_id);
		$this->db->order_by('message_date','DESC');
		$query = $this->db->get();
		return $query->result();
	}
	
	//description: get all messages from/to a resident.
	//			   the messages would be from all resident's relatives.
	//parameters: resident-id
	//returns: list of messages.
	function get_all_resident_messages($resident_id,$home_id)
	{
		$data = array('is_read' => 1);
		$this->db->where('resident_id',$resident_id);
		$this->db->where('relative_id',$relative_id);
		$this->db->where('home_id',$home_id);
		$this->db->update('message',$data);
	
		$this->db->select('*');
		$this->db->from('message_view');
		$this->db->where('resident_id',$resident_id);
		$this->db->where('home_id',$home_id);
		$this->db->order_by('message_date','ASC');
		$query = $this->db->get();
		return $query->result();
	}
	
	//description: get all messages between a specific resident and relative.
	//parameters: resident-id,relative-id
	//returns: list of messages between a particular resident and relative.
	function get_all_resident_relative_messages($resident_id,$relative_id,$home_id)
	{
	
		$data = array('is_read' => 1);
		$this->db->where('resident_id',$resident_id);
		$this->db->where('relative_id',$relative_id);
		$this->db->where('home_id',$home_id);
		$this->db->update('message',$data);
	
		$this->db->select('*');
		$this->db->from('message_view');
		$this->db->where('resident_id',$resident_id);
		$this->db->where('relative_id',$relative_id);
		$this->db->where('home_id',$home_id);
		$this->db->order_by('message_date','ASC');
		$query = $this->db->get();
		return $query->result();
		
	}
}