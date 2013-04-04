<?php

class Home_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//description: insert new home.
	//parameters: name,user-id,contact-id
	//returns: newly inserted home's id
	function insert_home($home_name,$user_id,$contact_id)
	{
		$data = array(
				'home_name' => $home_name,
				'user_id' => $user_id,
				'contact_id' => $contact_id
				);
		$this->db->insert('home',$data);
		return $this->db->insert_id();
	}
	
	//description: updates home detail
	//parameters: home-id,home-name,user-id,contact-id
	//returns: void
	function update_home($home_id,$home_name,$user_id,$contact_id)
	{
		$data = array(
				'home_name' => $home_name,
				'user_id' => $user_id,
				'contact_id' => $contact_id
				);
				
		$this->db->where('id',$home_id);
		$this->db->update('home',$data);
	}
	
	//description: deletes home
	//parameters: home-id
	function delete_home($home_id)
	{
		$this->db->where('id',$home_id);
		$this->db->delete('home');
	}
	
	//description: get home details
	//parameters: home-id
	//returns: array (home-name,user-id,contact-id)
	public function get_home_detail($home_id) 
	{	
		$this->db->select('*');
		$this->db->from('home');
		$this->db->where('id',$home_id);
		$query = $this->db->get();
		$result = $query->result();
		return $result[0];
	}
	
	//description: get all homes
	//parameters: void
	//returns: arrays of homes(home-name,user-id,contact-id)
	function get_all_homes()
	{
		$this->db->select('*');
		$this->db->from('home');
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		return $query->result();
	}
		
}