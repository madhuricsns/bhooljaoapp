<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class CustomerModel extends CI_Model {
	
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

        function checkUserMobile($mobile_number)
		{
			$this->db->select('*');
			$this->db->from(TBLPREFIX.'users');
			$this->db->where('mobile',$mobile_number);
			$this->db->where('user_type','Customer');
			return $this->db->get()->num_rows();			
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

		public function check_user($user_id) 
		{
			if(!empty ($user_id))
			{
				$this->db->select('*');
				$this->db->from(TBLPREFIX.'users');
				$this->db->where('user_id',$user_id);
				$this->db->where('user_type','Customer');
				$this->db->limit(1);
				$query = $this->db->get();
				//echo $this->db->last_query();exit;
				//return $query->row();
				return $query->num_rows();
			}
		}
		
		## CHECK  MPIN 
		public function chk_mpin($data,$qty) 
		{
			if(!empty ($data))
			{
				$this->db->select('*');
				$this->db->from(TBLPREFIX.'users');
				$this->db->where('user_id',$data['user_id']);
				$this->db->where('mobile_otp',$data['mpin']);
				$this->db->where('user_type','Customer');
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
		
		public function getUserDetails($user_id) 
        {
            if(!empty ($user_id))
            {
                $this->db->select('*');
                $this->db->from(TBLPREFIX.'users');
                $this->db->where('user_id',$user_id);
                $this->db->where('user_type','Customer');
                $this->db->limit(1);
                $query = $this->db->get();
                $user= $query->row();
                if(isset($user->profile_pic) && $user->profile_pic!="")
                {
                    $user->profile_pic=base_url()."uploads/user/profile_photo/".$user->profile_pic;;
                }
                
				$user->mpin=$user->otp;
                
                return $user;
            }
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
					  ->get(TBLPREFIX.'users');
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
			$this->db->from(TBLPREFIX.'faq');
			$this->db->where('faq_status','Active');
			$this->db->where('faq_type',$type);
			return $this->db->get()->result_array();			
		}

		public function getMedicalrecords($user_id) 
        {
            if(!empty ($user_id))
            {
                $this->db->select('*');
                $this->db->from(TBLPREFIX.'medical_records');
                $this->db->where('user_id',$user_id);
                $query = $this->db->get();
                $result= $query->result_array();
                return $result;
            }
        }

		public function getMedicalRecordFiles($record_id,$qty)
		{
			$this->db->select("*");
			$this->db->from(TBLPREFIX.'medical_record_files');
			$this->db->where('record_id',$record_id);
			$query = $this->db->get();
			if($qty==1)
				$result= $query->result_array();
			else
				$result=$query->num_rows();
			foreach($result as $key=>$record)
			{
				if(isset($record['filename']) && $record['filename']!="")
				{
					$record['filename']=base_url()."uploads/medical_records/".$record['filename'];
				}
				$result[$key]=$record;
			}
			return $result;
		}

		public function getMedicalrecordDetails($record_id,$user_id) 
        {
            if(!empty ($record_id))
            {
                $this->db->select('*');
                $this->db->from(TBLPREFIX.'medical_records');
                $this->db->where('user_id',$user_id);
                $this->db->where('record_id',$record_id);
                $query = $this->db->get();
                $result= $query->row();
                return $result;
            }
        }

		//get Service List
		public function getAllService($qty,$lng)
		{
			if($lng == "" || $lng == 'en'){
				$strPrefix = "";
				$this->db->select('*');
				$this->db->where(TBLPREFIX.'main_services.service_status','Active');
				$query=$this->db->get(TBLPREFIX.'main_services');
			}else{
				$strPrefix = "_ch";
				$this->db->select('en.service_id,ch.service_id,en.service_image,en.service_status,ch.service_name,ch.service_description');
				$this->db->from(TBLPREFIX.'main_services_ch as ch');
				$this->db->join(TBLPREFIX.'main_services as en','en.service_id=ch.service_id','left');
				$this->db->where('ch.service_status','Active');
				$query=$this->db->get();
			}
			if($qty==1){
				$result=$query->result_array();
				foreach($result as $key=>$row){
					if(isset($row['service_image']) && $row['service_image']!="")
					{
						$row['service_image']=base_url()."uploads/service_img/".$row['service_image'];
					}
					if(isset($row['service_app_image']) && $row['service_app_image']!="")
					{
						$row['service_app_image']=base_url()."uploads/service_img/".$row['service_app_image'];
					}
					$result[$key]=$row;
				}
				return $result;
			}else{
	
				return $query->num_rows();
			}
		}

		
	}