<?php

class Contact_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//description: insert contact details
	//parameters: phone,email,address
	//returns: newly inserted contact's id
	public function insert_contact($phone,$email,$address)
	{
		$data = array(
				'phone_no' => $phone,
				'email' => $email,
				'address' => $address
				);
				
		$this->db->insert('contact_info',$data);
		return $this->db->insert_id();
		
	}
	
	//description: update contact details
	//parameters: contact-id,phone,email,address
	//returns: void
	public function update_contact($contact_id,$phone,$email,$address)
	{
		$data = array('phone_no' => $phone,
					  'email' => $email,
					  'address' => $address
					  );
		
		$this->db->where('id',$contact_id);
		$this->db->update('contact_info',$data);

	}
	
	//description: delete contact
	//			   this function will be used in conjunction with delete function
	//			   for either home/employee/resident's delete method.
	//parameters: contact-id
	//returns: void
	public function delete_contact($contact_id)
	{
		$this->db->where('id',$contact_id);
		$this->db->delete('contact_info');
	}
	
	//description: get contact details
	//parameters: contact-id
	//returns: array (phone,email,address)
	public function get_contact_detail($contact_id) 
	{	
		$this->db->select('*');
		$this->db->from('contact_info');
		$this->db->where('id',$contact_id);
		$query = $this->db->get();
		$result = $query->result();
		return $result[0];
	}
	
}