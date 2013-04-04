<?php

class Relative_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//description: insert new relative.
	//parameters: first_name,last_name,resident_id,relation,is_admin,user_id,home_id,contact_id
	//returns: newly inserted relative's id
	function insert_relative($first_name,$last_name,$resident_id,$relation,$is_admin,$user_id,$home_id,$contact_id)
	{
		$data = array(
				'first_name' => $first_name,
				'last_name' => $last_name,
				'resident_id' => $resident_id,
				'relation' => $relation,
				'is_admin' => $is_admin,
				'user_id' => $user_id,
				'home_id' => $home_id,
				'contact_id' => $contact_id
				);
		$this->db->insert('relative',$data);
		return $this->db->insert_id();
	}
	
	//description: update relative details
	//parameters: relative-id,first-name,last-name,resident-id,relation,is-admin,user-id,home-id,contact-id
	//returns: void
	function update_relative($relative_id,$first_name,$last_name,$resident_id,$relation,$is_admin,$user_id,$home_id,$contact_id)
	{
		
		$data = array(
				'first_name' => $first_name,
				'last_name' => $last_name,
				'resident_id' => $resident_id,
				'relation' => $relation,
				'is_admin' => $is_admin,
				'user_id' => $user_id,
				'home_id' => $home_id,
				'contact_id' => $contact_id
				);
		
		$this->db->where('id',$relative_id);
		$this->db->update('relative',$data);

	}
	
	function update_device_id($relative_id,$device_id)
	{
		$data = array('device_id'=>$device_id);
		$this->db->where('id',$relative_id);
		$this->db->update('relative',$data);
	}
	
	//description: delete employee
	//parameters: employee-id
	//returns: void
	function delete_relative($relative_id)
	{
		$this->db->where('id',$relative_id);
		$this->db->delete('relative');
	}
	
	//description: get relative details
	//parameters: relative-id
	//returns: array containing relative details
	function get_relative_detail($relative_id) 
	{	
		$this->db->select('*');
		$this->db->from('relative');
		$this->db->where('id',$relative_id);
		$query = $this->db->get();
		$result = $query->result();
		return $result[0];
	}

	function get_relative_detail_by_userid($user_id)
	{
		$this->db->select('*');
		$this->db->from('relative');
		$this->db->where('user_id',$user_id);
		$query = $this->db->get();
		$result = $query->result();
		return $result[0];
	}
	
	//description: get all relatives (for a resident)
	//parameters: resident-id,home-id
	//returns: arrays of relatives
	function get_resident_relatives($resident_id,$home_id)
	{
		$this->db->select('*');
		$this->db->from('relative');
		$this->db->where('resident_id',$resident_id);
		$this->db->where('home_id',$home_id);
		$this->db->order_by('first_name','ASC');
		$query = $this->db->get();
		return $query->result();
	}
		
}