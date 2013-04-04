<?php

class Resident_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//description: insert new resident.
	//parameters: first_name,middle_name,last_name,nick_name,gender,room_no,dob,home_id,contact_id
	//returns: newly inserted resident's id
	function insert_resident($first_name,$middle_name,$last_name,$nick_name,$gender,$room_no,$dob,$home_id,$contact_id)
	{
		$data = array(
				'first_name' => $first_name,
				'middle_name' => $middle_name,
				'last_name' => $last_name,
				'nick_name' => $nick_name,
				'gender' => $gender,
				'room_no' => $room_no,
				'dob' => $dob,
				'home_id' => $home_id,
				'contact_id' => $contact_id
				);
		$this->db->insert('resident',$data);
		return $this->db->insert_id();
	}
	
	//description: updates resident detail
	//parameters: resident-id,first_name,middle_name,last_name,nick_name,gender,room_no,dob,home_id,contact_id
	//returns: void
	function update_resident($resident_id,$first_name,$middle_name,$last_name,$nick_name,$gender,$room_no,$dob,$home_id,$contact_id)
	{
		$data = array(
				'first_name' => $first_name,
				'middle_name' => $middle_name,
				'last_name' => $last_name,
				'nick_name' => $nick_name,
				'gender' => $gender,
				'room_no' => $room_no,
				'dob' => $dob,
				'home_id' => $home_id,
				'contact_id' => $contact_id
				);
				
		$this->db->where('id',$resident_id);
		$this->db->update('resident',$data);
	}
	
	//description: deletes resident
	//parameters: resident-id
	function delete_resident($resident_id)
	{
		$this->db->where('id',$resident_id);
		$this->db->delete('resident');
	}
	
	//description: get resident details
	//parameters: resident-id
	//returns: array
	public function get_resident_detail($resident_id) 
	{	
		$this->db->select('*');
		$this->db->from('resident');
		$this->db->where('id',$resident_id);
		$query = $this->db->get();
		$result = $query->result();
		return $result[0];
	}
	
	//description: get all residents (for a home)
	//parameters: home-id
	//returns: arrays of residents
	function get_all_residents($home_id)
	{
		$this->db->select('*');
		$this->db->from('resident');
		$this->db->where('home_id',$home_id);
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		return $query->result();
	}
		
}