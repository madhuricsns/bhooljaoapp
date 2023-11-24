<?php
Class Notification_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function getAllUserlist($qury,$select_type)
	{
		$this->db->select('*');
		$this->db->where('user_type',$select_type);
		$query=$this->db->get(TBLPREFIX."users");
		$output = '<option value="">Select Users</option>';
        foreach($query->result() as $row)
         {
          $output .= '<option value="'.$row->user_id.'">'.$row->full_name.'</option>';
            }
       
        
		echo $this->db->last_query();exit;
		if($qury==1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
			 return $output;
		}	
		
	}
	
	public function getAllNotifications($res,$per_page,$page)
	{
		$this->db->select('*');
		//$this->db->join('users','users.userid=notifications.userid','left');
		//$this->db->where('users.userid',$user_id);

		//$this->db->order_by('noti_id','ASC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get(TBLPREFIX."notification");
		//echo $this->db->last_query();exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}
	
	
	
	public function insert_notification($input_data) 
	{
		$res = $this->db->insert('notifications',$input_data);
		if($res)
		{
			return $this->db->insert_id();
		}
		else
			return false;
	}
	
	
}