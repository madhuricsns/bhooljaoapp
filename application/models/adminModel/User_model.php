
<?php
Class User_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function getSingleUserInfo($user_id,$res)
	{
		$this->db->select('*');
		$this->db->where('user_id',$user_id);
		$query = $this->db->get(TBLPREFIX."users");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}
	public function chkUserName($mobile,$email_address,$res)
	{
		$this->db->select('*');
		//$this->db->where('username',$username);
		//$this->db->where('email_address',$email_address);
		$where = '(mobile="'.$mobile.'" AND email = "'.$email_address.'")';
       	$this->db->where($where);
		$query=$this->db->get(TBLPREFIX."users");
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
		$this->db->select('*');
		$this->db->where('user_type','Customer');
		$this->db->order_by('user_id','DESC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get(TBLPREFIX.'users');
		//echo $this->db->last_query();exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}
	
	
	public function uptdateUser($input_data,$user_id) 
	{
		$full_name = $input_data['full_name'];
		$query=$this->db->query("select * from bhool_users where upper(full_name)=upper('$full_name') and user_id<>$user_id");
		if($query->num_rows()>0){
			return false;
		}
		else {
			$this->db->where('user_id',$user_id);
			$res = $this->db->update(TBLPREFIX.'users',$input_data);
			if($res)
			{
				return true;
			}
			else
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
		$this->db->where('userid',$user_id);
		$res = $this->db->delete(TBLPREFIX.'users');
		if($res)
			return true;
		else
			return false;
	}

	public function uptdateStatus($input_data,$user_id) 
	{
		$this->db->where('user_id',$user_id);
		$res = $this->db->update(TBLPREFIX.'users',$input_data);
		if($res)
		{
			return true;
		}
		else
			return false;
	}
	
	public function getAllUsersFcmToken()
	{
		$this->db->select('fcm_token');
		$this->db->where('status','Active');
		$query = $this->db->get(TBLPREFIX."users");
		return $query->result_array();
	}
	
	public function getUserFcmToken($userid)
	{
		$this->db->select('fcm_token');
		$this->db->where('user_id',$user_id);
		$query = $this->db->get(TBLPREFIX."users");
		return $query->row();
	}

	public function getAllBooking($user_id,$res,$per_page,$page)
	{
		/*echo "PerPage--".$per_page;
		echo "page--".$page;exit();*/
		$this->db->select('b.*,u.full_name,bd.*,c.category_name');
		$this->db->join(TBLPREFIX.'category as c','c.category_id=b.service_category_id','left');
		$this->db->join(TBLPREFIX.'users as u','u.user_id=b.user_id','left');
		$this->db->join(TBLPREFIX.'booking_details as bd','bd.booking_id=b.booking_id','left');
		$this->db->where('b.user_id',$user_id);
		$this->db->order_by('b.booking_id','DESC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get(TBLPREFIX.'booking as b');
		// echo $this->db->last_query();exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();
	}

	public function getAllServiceBooking($user_id,$res,$per_page,$page)
	{
		/*echo "PerPage--".$per_page;
		echo "page--".$page;exit();*/
		$this->db->select('b.*,u.full_name,bd.*,c.category_name');
		$this->db->join(TBLPREFIX.'category as c','c.category_id=b.service_category_id','left');
		$this->db->join(TBLPREFIX.'users as u','u.user_id=b.user_id','left');
		$this->db->join(TBLPREFIX.'booking_details as bd','bd.booking_id=b.booking_id','left');
		$this->db->where('b.service_provider_id',$user_id);
		$this->db->order_by('b.booking_id','DESC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get(TBLPREFIX.'booking as b');
		// echo $this->db->last_query();exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();
	}

	public function getAllServiceProvider($res,$per_page,$page)
	{
		/*echo "PerPage--".$per_page;
		echo "page--".$page;exit();*/
		$this->db->select('u.*,z.zone_name,c.category_name');
		$this->db->join(TBLPREFIX.'zone as z','z.zone_id=u.zone_id','left');
		$this->db->join(TBLPREFIX.'category as c','c.category_id=u.category_id','left');
		$this->db->where('user_type','Service Provider');
		$this->db->order_by('user_id','DESC');
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
	public function getAllCategory($res,$per_page,$page)
	{
		/*echo "PerPage--".$per_page;
		echo "page--".$page;exit();*/
		$this->db->select('*');
		$this->db->where('category_status',"Active");

		$this->db->order_by('category_id','DESC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get(TBLPREFIX.'category');
		//echo $this->db->last_query();exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}
}