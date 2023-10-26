
<?php
Class City_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function getSingleCityInfo($city_id,$res)
	{
		$this->db->select('*');
		$this->db->where('city_id',$city_id);
		$query = $this->db->get(TBLPREFIX."city");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}
	// public function chkUserName($username,$email_address,$res)
	// {
	// 	$this->db->select('*');
	// 	//$this->db->where('username',$username);
	// 	//$this->db->where('email_address',$email_address);
	// 	$where = '(full_name="'.$username.'" or email = "'.$email_address.'")';
    //    	$this->db->where($where);
	// 	$query=$this->db->get(TBLPREFIX.'users');
	// 	//echo $this->db->last_query();exit;
	// 	if($res == 1)
	// 	{
	// 		return $query->result_array();
	// 	}
	// 	else
	// 	{
	// 		return $query->num_rows();
	// 	}	
	// }

	public function getAllcity($res,$per_page,$page)
	{
		/*echo "PerPage--".$per_page;
		echo "page--".$page;exit();*/
		$this->db->select('*');
		$this->db->where('city_status',$city_status = "Active");

		$this->db->order_by('city_id','DESC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get(TBLPREFIX.'city');
		//echo $this->db->last_query();exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}
	
	public function getSingleUsertaskInfo($usertask_id,$res)
	{
		$this->db->select('user_tasks.*,users.full_name');
		$this->db->join('users','users.userid=user_tasks.userid','inner');
		$this->db->where('task_id',$usertask_id);
		$query = $this->db->get("user_tasks");
		//echo $this->db->last_query();exit;
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}


public function uptdateCity($input_data,$city_id)
	{
		$this->db->where('city_id',$city_id);
		$query=$this->db->update(TBLPREFIX."city",$input_data);
		if($query==1)
		{
			return true;
		}
		else
		{
			return false;
		}	
	}


	
	
	
	
	public function insert_city($input_data) 
	{
		$res = $this->db->insert(TBLPREFIX.'city',$input_data);
		if($res)
		{
			return $this->db->insert_id();
		}
		else
			return false;
	}
	
	public function deleteUser($user_id)
	{
		$this->db->where('userid',$user_id);
		$res = $this->db->delete('users');
		if($res)
			return true;
		else
			return false;
	}
	
	public function getAllUsersFcmToken()
	{
		$this->db->select('fcm_token');
		$this->db->where('status','Active');
		$query = $this->db->get("users");
		return $query->result_array();
	}
	
	public function getUserFcmToken($userid)
	{
		$this->db->select('fcm_token');
		$this->db->where('userid',$user_id);
		$query = $this->db->get("users");
		return $query->row();
	}
}