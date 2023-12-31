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
			$this->db->where('user_type','Service Provider');
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
				$this->db->where('user_type','Service Provider');
				$this->db->limit(1);
				$query = $this->db->get();
				//echo $this->db->last_query();exit;
				//return $query->row();
				return $query->num_rows();
			}
		}
		
		
		public function getUserDetails($user_id) 
        {
            if(!empty ($user_id))
            {
                $this->db->select('u.*,z.zone_name,z.zone_lat,z.zone_long');
                $this->db->from(TBLPREFIX.'users as u');
                $this->db->join(TBLPREFIX.'zone as z','z.zone_id=u.zone_id','left');
                $this->db->where('user_id',$user_id);
                $this->db->where('user_type','Service Provider');
                $this->db->limit(1);
                $query = $this->db->get();
                $user= $query->row();
                if(isset($user->profile_pic) && $user->profile_pic!="")
                {
                    $user->profile_pic=base_url()."uploads/user_profile/".$user->profile_pic;;
                }
                
                return $user;
            }
        }

		public function getUserWhatWeDo($user_id) 
        {
            if(!empty ($user_id))
            {
                $this->db->select('description');
                $this->db->from(TBLPREFIX.'sp_whatwedo');
                $this->db->where('service_provider_id',$user_id);
                $query = $this->db->get();
                $result= $query->result_array();
                return $result;
            }
        }

		public function getPhotos($user_id) 
        {
            if(!empty ($user_id))
            {
                $this->db->select('photo');
                $this->db->from(TBLPREFIX.'sp_photos');
                $this->db->where('service_provider_id',$user_id);
                $query = $this->db->get();
                $result= $query->result_array();
				foreach($result as $key=>$row)
				{
					if(isset($row['photo']) && $row['photo']!="")
					{
						$row['photo']=base_url()."uploads/sp_photos/".$row['photo'];
					}
					$result[$key]=$row;
				}
                return $result;
            }
        }

		public function getZoneBySP($zone_id) 
		{
			$this->db->select('*');
			$this->db->from(TBLPREFIX.'zone');
			$this->db->where('zone_id',$zone_id);
			$query = $this->db->get();
			//echo $this->db->last_query();exit;
			return $query->row();
		}

		public function deletephoto($user_id) 
        {
            if(!empty ($user_id))
            {
				$this->db->where('service_provider_id',$user_id);
				$this->db->delete(TBLPREFIX.'sp_photos'); 
            }
        }

		public function deleteWhatWeDo($user_id) 
        {
            if(!empty ($user_id))
            {
				$this->db->where('service_provider_id',$user_id);
				$this->db->delete(TBLPREFIX.'sp_whatwedo'); 
            }
        }

		public function getCategoryDetails($category_id) 
        {
            if(!empty ($category_id))
            {
                $this->db->select('*');
                $this->db->from(TBLPREFIX.'category');
                $this->db->where('category_id',$category_id);
                $this->db->limit(1);
                $query = $this->db->get();
                $result= $query->row();
                return $result;
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

		public function getAllServiceByCategoryId($category_id) 
        {
            $this->db->select('*');
            $this->db->from(TBLPREFIX.'service');
            $this->db->where('category_id',$category_id);
            $this->db->where('service_status','Active');
            $query = $this->db->get();
			$result= $query->row();
           
            return $result;
        }

		public function getAllServiceImages($service_id) 
        {
            $this->db->select('service_image');
            $this->db->from(TBLPREFIX.'service_images');
            $this->db->where('service_id',$service_id);
            $query = $this->db->get();
			$result= $query->result_array();
            foreach($result as $key=>$row)
            {
                if(isset($row['service_image']) && $row['service_image']!="")
                {
                    $row['service_image']=base_url()."uploads/service_images/".$row['service_image'];
                }
                $result[$key]=$row;
            }
            return $result;
        }

		public function getAllMaterials() 
        {
            $this->db->select('material_id,material_name,material_status');
            $this->db->from(TBLPREFIX.'material');
            $this->db->where('material_status','Active');
            $query = $this->db->get();
			$result= $query->result_array();
            return $result;
        }

		public function getAllMaterialRequest($service_provider_id)
		{
			$this->db->select('r.*,u.full_name,m.material_name');
			$this->db->where('r.service_provider_id',$service_provider_id);
			$this->db->join(TBLPREFIX.'users as u','u.user_id=r.service_provider_id','left');
			$this->db->join(TBLPREFIX.'material as m','m.material_id=r.material_id','left');
			$this->db->order_by('r.request_id','DESC');
			$result = $this->db->get(TBLPREFIX.'material_request as r');
			//echo $this->db->last_query();exit;
			return $result->result_array();
		}
	}