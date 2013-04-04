<?php

class Employee_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//description: insert employee details
	//parameters: first-name,middle-name,last-name,dob,gender,job-title,user-id,home-id,contact-id
	//returns: newly inserted employee's id
	public function insert_employee($first_name,$middle_name,$last_name,$dob,$gender,$job_title,$user_id,$home_id,$contact_id)
	{
		$data = array(
				'first_name' => $first_name,
				'middle_name' => $middle_name,
				'last_name' => $last_name,
				'dob' => $dob,
				'gender' => $gender,
				'job_title' => $job_title,
				'user_id' => $user_id,
				'home_id' => $home_id,
				'contact_id' => $contact_id
				);
				
		$this->db->insert('employee',$data);
		return $this->db->insert_id();
		
	}
	
	//description: update employee details
	//parameters: employee-id,first-name,middle-name,last-name,dob,gender,job-title,user-id,home-id,contact-id
	//returns: void
	public function update_employee($employee_id,$first_name,$middle_name,$last_name,$dob,$gender,$job_title,$user_id,$home_id,$contact_id)
	{
		$data = array(
				'first_name' => $first_name,
				'middle_name' => $middle_name,
				'last_name' => $last_name,
				'dob' => $dob,
				'gender' => $gender,
				'job_title' => $job_title,
				'user_id' => $user_id,
				'home_id' => $home_id,
				'contact_id' => $contact_id
				);
		
		$this->db->where('id',$employee_id);
		$this->db->update('employee',$data);

	}
	
	//description: delete employee
	//parameters: employee-id
	//returns: void
	public function delete_employee($employee_id)
	{
		$this->db->where('id',$employee_id);
		$this->db->delete('employee');
	}
	
	//description: get employee details
	//parameters: employee-id
	//returns: array (first-name,middle-name,last-name,dob,gender,job-title,user-id,home-id,contact-id)
	public function get_employee_detail($employee_id) 
	{	
		$this->db->select('*');
		$this->db->from('employee');
		$this->db->where('id',$employee_id);
		$query = $this->db->get();
		$result = $query->result();
		return $result[0];
	}
	
	//description: get all employees (for a home)
	//parameters: home-id
	//returns: arrays of employees(employee-id,first-name,middle-name,last-name,dob,gender,job-title,user-id,home-id,contact-id)
	function get_all_employees($home_id)
	{
		$this->db->select('*');
		$this->db->from('employee');
		$this->db->where('home_id',$home_id);
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		return $query->result();
	}
	
}