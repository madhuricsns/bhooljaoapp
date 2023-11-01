<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class UserModel extends CI_Model {
	
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		function checkUser($email_address,$mobile_number)
		{
			$condition = "email = '".$email_address."' AND mobile = '".$mobile_number."'";
			$this->db->select('*');
			$this->db->from(TBLPREFIX.'users');
			$this->db->where($condition);
			return $this->db->get()->result_array();			
		}

		public function insert_user($data)
		{
			if($this->db->insert(TBLPREFIX.'users',$data))
			{
				return $this->db->insert_id();
			}
			else
				return false;
		}
		
		public function updateData($tablename,$where,$id,$data = array()) 
		{
		  	if($id > 0) 
			{
		    	$this->db->where($where,$id);
			  	$this->db->update(TBLPREFIX.$tablename,$data); 
		  	}
		} 
		
		function validateUser($email_address = '')
		{
			$this->db->select(TBLPREFIX.'users.*');
			$this->db->from(TBLPREFIX.'users');
			$this->db->where('email_address',$email_address);
			return $this->db->get()->row();			
		}
		
		## CHECK  OTP from  Mob and OPT CODE
		function checkOtp($email_address = '' , $otp = '')
		{				
			$this->db->select('*');
			$this->db->from('users');
			$this->db->where('confirm_otp',$otp);
			$this->db->where('email_address',$email_address);
			return $this->db->get()->row();
		}
		
		function getUserDetails($user_id)
		{				
			$this->db->select('*');
			$this->db->from('users');
			$this->db->where('userid',$user_id);
			return $this->db->get()->row();
		}
		
		function getProfile($user_id)
		{				
			$this->db->select("userid,firstname,lastname,mobile_number,email_address,otp_verified,status,profile_pic,(DATE_FORMAT(DATE(dateadded),'%d/%m/%Y')) as dateadded");
			$this->db->from('users');
			$this->db->where('userid',$user_id);
			return $this->db->get()->row();
		}
		// Read data using username and password
		public function check_login($username,$password)
		{			
			$q = $this->db->where('mobilenumber',$username)
					  ->where('upassword',$password)
					  ->get(TBPREFIX.'users');
			if($q->num_rows()){

				return $q->row();
			}
			else{
				return FALSE;
			}
		}
		
		function getPageContent($page_name)
		{
			$this->db->select('*');
			$this->db->from('pages');
			$this->db->where('page_name',$page_name);
			$this->db->where('page_status','Active');
			return $this->db->get()->row();			
		}		
		
		
		function getSearchCount($userid)
		{
			$this->db->select('*');
			$this->db->from('user_search');
			$this->db->where('userid',$userid);
			return $this->db->get()->num_rows();			
		}
		
		function checkSearchExists($userid,$srch)
		{
			$this->db->select('*');
			$this->db->from('user_search');
			$this->db->where('userid',$userid);
			$this->db->where('search_keyword',$srch);
			return $this->db->get()->num_rows();			
		}
		
		function removeFirstRecentSrch($userid)
		{
			$this->db->where('userid',$userid);
			$this->db->order_by('search_id', 'asc');
			$this->db->limit(1); 
			$this->db->delete('user_search');
			return true;
		}
		
		function getRecentSearchData($userid)
		{
			$this->db->select('*');
			$this->db->from('user_search');
			$this->db->where('userid',$userid);
			return $this->db->get()->result_array();			
		}
		function getAllfaqList($type)
		{
			$this->db->select('*');
			$this->db->from('faq');
			$this->db->where('faq_status','Active');
			$this->db->where('faq_type',$type);
			return $this->db->get()->result_array();			
		}
	}