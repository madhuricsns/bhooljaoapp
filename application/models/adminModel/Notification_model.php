<?php
Class Notification_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function getAllUserlist($qury,$user_type)
	{
		$this->db->select('*');
		$this->db->where('user_type',$user_type);
		$this->db->where('status','Active');
		$query=$this->db->get(TBLPREFIX."users");
		
		if($qury==1)
		{
			$output=$query->result_array();
		}
		else
		{
			$output=$query->num_rows();
			
		}	
		return $output;
	}

	public function getUserDetails($qury,$user_id)
	{
		$this->db->select('*');
		$this->db->where('user_id',$user_id);
		$query=$this->db->get(TBLPREFIX."users");
		
		if($qury==1)
		{
			$output=$query->row();
		}
		else
		{
			$output=$query->num_rows();
			
		}	
		return $output;
	}
	
	public function getAllNotifications($res,$per_page,$page)
	{
		$this->db->select('n.*,u.full_name');
		$this->db->join(TBLPREFIX.'users as u','u.user_id=n.noti_user_id','left');
		//$this->db->where('users.userid',$user_id);

		//$this->db->order_by('noti_id','ASC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get(TBLPREFIX."notification as n");
		//echo $this->db->last_query();exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}
	
	
	
	public function insert_notification($input_data) 
	{
		$res = $this->db->insert(TBLPREFIX.'notification',$input_data);
		if($res)
		{
			return $this->db->insert_id();
		}
		else
			return false;
	}
	
	
}