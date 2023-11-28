<?php
Class LoginModel extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	// Read data using username and password
	public function check_login($data) 
	{
		if(!empty ($data))
		{
			$condition = "mobile = '".$data['username']."'";
			$this->db->select('*');
			$this->db->from(TBLPREFIX.'users');
			$this->db->where($condition);
			$this->db->where('user_type','Service Provider');
			$this->db->limit(1);
			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			return $query->num_rows();
		}
	}

	// Read data using username and password
	public function chk_login($data,$qty) 
	{
		$condition = "(mobile = '".$data['username']."') ";	
		$this->db->select('*');
		$this->db->from(TBLPREFIX.'users');
		$this->db->where($condition);
		$this->db->where('user_type','Service Provider');
		$this->db->limit(1);
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		if ($qty==0) 
		{
			return $query->num_rows();
		} 
		else 
		{
			return $query->row();
		}
	}

	public function check_user($user_id) 
	{
		if(!empty ($user_id))
		{
			$this->db->select('*');
			$this->db->from(TBLPREFIX.'users');
			$this->db->where('user_id',$user_id);
			$this->db->where('user_type','Service Provider');
			$this->db->limit(1);
			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			//return $query->row();
			return $query->num_rows();
		}
	}

	public function chk_otp($data,$qty) 
	{
		if(!empty ($data))
		{
			$this->db->select('*');
			$this->db->from(TBLPREFIX.'users');
			$this->db->where('user_id',$data['user_id']);
			$this->db->where('otp',$data['otp']);
			$this->db->where('user_type','Service Provider');
			$this->db->limit(1);
			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			if ($qty==0) 
			{
				return $query->num_rows();
			} 
			else 
			{
				return $query->row();
			}
		}
	}

	public function getuserDetails($username) 
	{
		if(!empty ($username))
		{
			$condition = "(mobile = '".$username."') ";		
			$this->db->select('*');
			$this->db->from(TBLPREFIX.'users');
			$this->db->where($condition);
			$this->db->where('user_type','Service Provider');
			$this->db->limit(1);
			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			$user= $query->row();
			if(isset($user->profile_pic) && $user->profile_pic!="")
			{
				$user->profile_pic=base_url()."uploads/user_profile/".$user->profile_pic;;
			}
			return $user;
		}
	}
	
	public function chkUserEmailExists($email) 
	{
		$this->db->select('*');
		$this->db->from(TBLPREFIX.'users');
		$this->db->where('user_type','Service Provider');
		$this->db->where('email',$email);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}
}