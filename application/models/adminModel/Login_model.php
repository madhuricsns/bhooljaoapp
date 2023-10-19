<?php
Class Login_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	// Read data using username and password
	public function chk_login_username($data) 
	{
		// $condition = "username ="."'".$data['username']."' AND user_type='Super Admin'";
		$condition = "username ="."'".$data['username']."'";
					  
		$this->db->select('*');
		$this->db->from(TBLPREFIX.'admin');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		// echo $this->db->last_query();exit;
		return $query->num_rows();
	}



	// Read data using username and password
	public function chk_login($data,$qty) 
	{
		$condition = "username =" . "'" . $data['username'] . "' 	
					  AND " . "admin_password =" . "'" . md5($data['admin_password']) . "'
					 ";
					  
		$this->db->select('*');
		$this->db->from(TBLPREFIX.'admin');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		//echo $this->db->last_query();exit;
		if ($qty==0) 
		{
			return $query->num_rows();
		} 
		else 
		{
			return $query->result_array();
		}
	}



// Read  data from database to show data in admin page

	public function read_user_information($username) 
	{
			$condition = "user_name =" . "'" . $username . "'";
			$this->db->select('*');
			$this->db->from(TBLPREFIX.'admin');
			$this->db->where($condition);
			$this->db->limit(1);
			$query = $this->db->get();
			if ($query->num_rows() == 1) 
			{
				return $query->result();
			} 
			else 
			{
				return false;
			}
	}
	public function resetPass($new_password,$admin_email)
	{
		$sts = $this->db->query('Update '.TBLPREFIX.'admin SET admin_password ="'.md5($new_password).'" WHERE admin_email="'.$admin_email.'"');
		return $sts;
	}
	public function checkexist($email)
	{
		$query = $this->db->query('select admin_id from '.TBLPREFIX.'admin where admin_email="'.$email.'"');
		return $query->result_array();
	}
	
	public function chkAdminEmailExists($admin_email,$user_type) 
	{
		if($user_type=='Admin')
		{
			$condition = " admin_email='".$admin_email."' AND user_type='Admin'";
						  
			$this->db->select('*');
			$this->db->from(TBLPREFIX.'admin');
			$this->db->where($condition);
			$this->db->limit(1);
			$query = $this->db->get();
			return $query->result_array();
		}
		else if($user_type=='Subadmin')
		{
			$condition = "admin_email =" . "'" . $admin_email . "' AND user_type='Subadmin'";
						
			$this->db->select('*');
			$this->db->from(TBLPREFIX.'admin');
			$this->db->where($condition);
			$this->db->limit(1);
			$query = $this->db->get();
			return $query->result_array();
		}
	}
	
	public function upadteAdminPassword($user_type,$admin_email,$rnd_number)
	{
		if($user_type=='Admin')
		{
			$sts = $this->db->query('Update '.TBLPREFIX.'admin SET admin_password ="'.md5($rnd_number).'" 
							WHERE admin_email="'.$admin_email.'"');
			return $sts;
		}
		if($user_type=='Subadmin')
		{
			$sts = $this->db->query('Update '.TBLPREFIX.'admin SET admin_password ="'.md5($rnd_number).'" 
							WHERE admin_email="'.$admin_email.'"');
			return $sts;
		}
	}
}