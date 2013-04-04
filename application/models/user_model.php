<?php

class User_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//description: insert user
	//parameters: user-name,password,role-id,home-id
	//returns: newly inserted user's id
	public function insert_user($username,$password,$role_id) 
	{
		$data = array(
				'username' => $username,
				'password' => $password,
				'role_id' => $role_id
				);
				
		$this->db->insert('user',$data);
		return $this->db->insert_id();
			
	}
	
	//description: update user's information (only password can be changed)
	//parameters: user-id,password
	//returns: void
	public function update_user($user_id,$password)
	{
		$data = array('password' => $password);
		$this->db->where('id',$user_id);
		$this->db->update('user',$data);
	}
	
	public function update_role($user_id,$role_id)
	{
		$data = array('role_id' => $role_id);
		$this->db->where('id',$user_id);
		$this->db->update('user',$data);
	}
	
	//description: delete user
	//			   this function will be used in conjunction with delete function
	//			   for either home/employee/resident's delete method.
	//parameters: user-id
	//returns: void
	public function delete_user($user_id)
	{
		$this->db->where('user_id',$user_id);
		$this->db->delete('user');
	}
	
	//description: get user's id
	//			   will be used while authenticating the user.
	//parameters: user-name,password
	//returns: user-id if authenticated, -1 otherwise
	public function get_user_id($username,$password) 
	{	
		$sql = 'SELECT * FROM user WHERE username=? AND password=?';
		$parameters = array($username,$password);
		$query = $this->db->query($sql,$parameters);
		if ($query->num_rows() > 0) 
		{
			$row = $query->row();
			return $row->id;
		}
		else 
		{
			return -1;
		}
	}
	
	//description: checks if username already exists in the database
	//			   will be used to check if username is already taken by someone else while inserting
	//			   a new user.
	//parameters: user-name
	//returns: YES/NO
	public function user_exists($username)
	{
		$sql = 'SELECT * FROM user WHERE username=?';
		$parameters = array($username);
		$query = $this->db->query($sql,$parameters);
		return ($query->num_rows()>0);
	}
	
	//description: get all permissions (controller/function) allowed for a user
	//parameters: user-id
	//returns: list of permissions (permission-id,permission-name,permission-page)
	public function get_permissions($user_id)
	{
		$sql = 'SELECT permission.id AS permission_id, 
					   permission.name AS permission_name,
					   permission.page AS permission_page
			    FROM permission 
			    INNER JOIN role_permission 
			    ON permission.id = role_permission.permission_id
			    INNER JOIN role 
			    ON role_permission.role_id = role.id
			    INNER JOIN user
			    ON role.id = user.role_id
			    WHERE user.id = ?';
		
		$parameters = array($user_id);
		$query = $this->db->query($sql,$parameters);
		$result = $query->result();
		
		return $result;
		
	}
	
	//description: get user details
	//parameters: user-id
	//returns: array (username,password)
	public function get_user_detail($user_id) 
	{	
		$this->db->select('id,username,password,role_id');
		$this->db->from('user');
		$this->db->where('id',$user_id);
		$query = $this->db->get();
		$result = $query->result();
		return $result[0];
	}
	
	//description: get all the menus (displayed on the home screen) allocated to a user.
	//parameters: user-id
	//returns: list of menus (menu-id,menu-title,menu-page)
	public function get_menus($user_id)
	{
		$sql = 'SELECT menu.id AS menu_id, 
					   menu.title AS menu_title,
					   menu.page AS menu_page
			    FROM menu 
			    INNER JOIN role_menu 
			    ON menu.id = role_menu.menu_id
			    INNER JOIN role 
			    ON role_menu.role_id = role.id
			    INNER JOIN user
			    ON role.id = user.role_id
			    WHERE user.id = ?';
		
		$parameters = array($user_id);
		$query = $this->db->query($sql,$parameters);
		$result = $query->result();
		
		return $result;
	}
	
	public function get_home_id($user_id,$role_id)
	{
		if ($role_id > 5)
		{
			return FALSE;
		}
		else if ($role_id == 1) 
		{
			return 0;
		}
		else if ($role_id == 2) 
		{
			$this->db->select('id AS home_id');
			$this->db->from('home');
		}
		else if ($role_id == 3) 
		{
			$this->db->select('home_id');
			$this->db->from('employee');
			
		}
		else if ($role_id == 4)
		{
			$this->db->select('home_id');
			$this->db->from('relative');
		}
		else if ($role_id == 5)
		{
			$this->db->select('home_id');
			$this->db->from('relative');
		
		}
		
		$this->db->where('user_id',$user_id);
		$query = $this->db->get();
		$row = $query->row_array();
		return $row['home_id'];
	}
	
	
			
}