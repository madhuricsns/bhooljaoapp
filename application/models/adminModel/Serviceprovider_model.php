
<?php
Class Serviceprovider_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function getSingleUserInfo($user_id,$res)
	{
		$this->db->select('*');
		$this->db->where('user_id',$user_id);
		$query = $this->db->get(TBLPREFIX.'users');
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}
	public function chkUserName($username,$email_address,$res)
	{
		$this->db->select('*');
		//$this->db->where('username',$username);
		//$this->db->where('email_address',$email_address);
		$where = '(full_name="'.$username.'" or email = "'.$email_address.'")';
       	$this->db->where($where);
		$query=$this->db->get(TBLPREFIX.'users');
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

	public function getAllUsers($res,$per_page,$page)
	{
		/*echo "PerPage--".$per_page;
		echo "page--".$page;exit();*/
		//$this->db->select('*');
		$this->db->select('u.*,z.zone_name');
		$this->db->join(TBLPREFIX.'zone as z','z.zone_id=u.zone_id','left');
		$this->db->where('user_type',$user_type = "Service Provider");

		$this->db->order_by('u.user_id','DESC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get(TBLPREFIX.'users as u');
		//echo $this->db->last_query();exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}
	public function getAllzone($res,$per_page,$page)
	{
		/*echo "PerPage--".$per_page;
		echo "page--".$page;exit();*/
		$this->db->select('*');
		$this->db->where('zone_status',"Active");

		$this->db->order_by('zone_id','DESC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get(TBLPREFIX.'zone');
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



	public function uptdateservices($input_data,$user_id)
	{
		$this->db->where('user_id',$user_id);
		$query=$this->db->update(TBLPREFIX.'users',$input_data);

		if($query==1)
		{
			return true;
		}
		else
		{
			return false;
		}	
	}
	
	
	
	
	public function insert_user($input_data) 
	{
		$res = $this->db->insert(TBLPREFIX.'users',$input_data);
		if($res)
		{
			return $this->db->insert_id();
		}
		else
			return false;
	}
	
	public function deleteUser($user_id)
	{
		$this->db->where('user_id',$user_id);
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