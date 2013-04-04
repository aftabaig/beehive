<?php

class Picture_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//description: insert new picture group.
	//			   a user can enter multiple images in a single group.
	//parameters: resident-id,relative-id,to_forth*,is_read*,home_id
	//to_forth: '1' for pictures from resident to relative 
	//			'2' for pictures from relative back to resident
	//is_read:  flag to set picture_group as read (read=1,unread=0)
	//			would always be 0 when inserting a new picture_group.
	//timestamp: this is another field in picture-group table but it' populated 
	//			 by default to current timestamp.
	//returns: newly inserted picture_group's id
	function insert_group($resident_id,$relative_id,$to_forth,$is_read,$home_id)
	{
		$data = array(
				'resident_id' => $resident_id,
				'relative_id' => $relative_id,
				'to_forth' => $to_forth,
				'is_read' => $is_read,
				'home_id' => $home_id
				);
		$this->db->insert('picture_group',$data);
		return $this->db->insert_id();
	}
	
	//description: inserts pictures into a group.
	//parameters: group-id,$file-name,$width,$height
	//returns newly inserted picture's id
	function insert_picture($group_id,$file_name,$width,$height)
	{
		$data = array(
				'group_id' => $group_id,
				'file_name' => $file_name,
				'width' => $width,
				'height' => $height);
		$this->db->insert('picture',$data);
		return $this->db->insert_id();
	}
	
	function set_picture_group_as_read($group_id,$home_id)
	{
		$data = array(
				'is_read' => 1
				);
				
		$this->db->where('id',$group_id);
		$this->db->where('home_id',$home_id);
		$this->db->update('picture_group',$data);
	}
	
	//get all the pictures in a group.
	//parameters: group-id
	//returns: list of pictures associated with the group.
	function get_group_pictures($group_id)
	{
		$this->db->select('*');
		$this->db->from('picture');
		$this->db->where('group_id',$group_id);
		$this->db->order_by('id','ASC');
		$query = $this->db->get();
		return $query->result();
		
	}
	
	//description: get all new picture groups (having read flag set to 0)
	//parameters: home-id
	//returns: list of new picture groups.
	function get_all_new_picture_groups($home_id)
	{
		$this->db->select('*');
		$this->db->from('picture_group_view');
		$this->db->where('is_read',0);
		//we need to show only those new messages that are
		//sent from relative to resident (to_forth=2).
		$this->db->where('to_forth',2);
		$this->db->where('home_id',$home_id);
		$this->db->order_by('group_date','DESC');
		$query = $this->db->get();
		return $query->result();
	}
	
	//description: get all new picture-groups for a specific resident
	//parameters: resident-id
	//returns: list of new picture groups for that particular resident.
	function get_all_new_picture_groups_for_resident($resident_id,$home_id)
	{
		$this->db->select('*');
		$this->db->from('picture_group_view');
		$this->db->where('is_read',0);
		//we need to show only those new messages that are
		//sent from relative to resident (to_forth=2).
		$this->db->where('to_forth',2);
		$this->db->where('resident_id',$resident_id);
		$this->db->where('home_id',$home_id);
		$this->db->order_by('group_date','DESC');
		$query = $this->db->get();
		return $query->result();
	}
	
	//description: get all pictures from/to a resident.
	//			   the pictures would be from all resident's relatives.
	//parameters: resident-id,home-id
	//returns: list of pictures(grouped by picture-group).
	function get_all_resident_pictures($resident_id,$home_id)
	{
		$this->db->select('*');
		$this->db->from('picture_group_view');
		$this->db->where('resident_id',$resident_id);
		$this->db->where('home_id',$home_id);
		$this->db->order_by('group_date','ASC');
		$query = $this->db->get();
		
		$result = $query->result();
		foreach ($result as $group)
		{
			$pictures = self::get_group_pictures($group->id);
			$group->pictures = $pictures;
		}
		return $result;
	}
	
	//description: get all pictures between a specific resident and relative.
	//parameters: resident-id,relative-id,home-id
	//returns: list of pictures between a particular resident and relative.
	function get_all_resident_relative_pictures($resident_id,$relative_id,$home_id)
	{
		$this->db->select('*');
		$this->db->from('picture_group_view');
		$this->db->where('resident_id',$resident_id);
		$this->db->where('relative_id',$relative_id);
		$this->db->where('home_id',$home_id);
		$this->db->order_by('group_date','ASC');
		$query = $this->db->get();
		
		$result = $query->result();
		$result = $query->result();
		foreach ($result as $group)
		{
			$pictures = self::get_group_pictures($group->id);
			$group->pictures = $pictures;
		}
		return $result;
		
	}
	
	//description: deletes a picture group
	//parameters: group-id,home-id
	function delete_group($group_id,$home_id)
	{
		$this->db->where('id',$group_id);
		$this->db->where('home_id',$home_id);
		$this->db->delete('picture_group');
	}
	
	//description: deletes all pictures belonging to a group.
	//parameters: group-id
	function delete_group_pictures($group_id)
	{
		$this->db->where('group_id',$group_id);
		$this->db->delete('picture');
	}

}