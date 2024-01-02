<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class CustomerModel extends CI_Model {
	
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

        function checkUserMobile($mobile_number,$email_address)
		{
			$where = '(mobile="'.$mobile_number.'" OR email = "'.$email_address.'")';
			$this->db->select('*');
			$this->db->from(TBLPREFIX.'users');
			// $this->db->where('mobile',$mobile_number);
			$this->db->where('user_type','Customer');
			$this->db->where($where);
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
                    $user->profile_pic=base_url()."uploads/user_profile/".$user->profile_pic;;
                }
                
				$user->mpin=$user->otp;
                
                return $user;
            }
        }

		public function getServiceProviderDetails($user_id,$userLat='',$userLong='') 
        {
            if(!empty ($user_id))
            {
				if($userLat!="" && $userLong!="")
				{
					$distance_parameter = '(
						6371 * acos(
						  cos(radians('.'user_lat)) * cos(radians('.$userLat.')) * cos(
							radians('.$userLong.') - radians('.'user_long)
						  ) + sin(radians('.$userLat.')) * sin(radians('.'user_lat))
						)
					  ) AS distance';
				}
				else
				{
					$distance_parameter = '( 0 ) AS distance';
				}
				
                $this->db->select('*,'.$distance_parameter.','.'user_id as service_provider_id');
                $this->db->from(TBLPREFIX.'users as u');
                $this->db->where('user_id',$user_id);
                $this->db->where('user_type','Service Provider');
                $this->db->limit(1);
                $query = $this->db->get();
                $user= $query->row();
				// echo $this->db->last_query();
                if(isset($user->profile_pic) && $user->profile_pic!="")
                {
                    $user->profile_pic=base_url()."uploads/user_profile/".$user->profile_pic;;
                }
                
				// $user->mpin=$user->otp;
                
                return $user;
            }
        }

		public function getSPWhatWeDo($user_id) 
        {
            if(!empty ($user_id))
            {
                $this->db->select('*');
                $this->db->from(TBLPREFIX.'sp_whatwedo');
                $this->db->where('service_provider_id',$user_id);
                // $this->db->limit(1);
                $query = $this->db->get();
                $result= $query->result_array();
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

		function getContactUs()
		{
			$this->db->select('*');
			$this->db->from(TBLPREFIX.'helpcenter');
			$this->db->where('help_type','contactus');
			$this->db->where('status','Active');
			$result=$this->db->get()->result_array();
			foreach($result as $key=>$row)
			{
				if(isset($row['help_image']) && $row['help_image']!="")
				{
					$row['help_image']=base_url()."uploads/helpcenter/".$row['help_image'];
				}
				$result[$key]=$row;
			}	
			return $result;		
		}

		public function getPhotos($service_provider_id) 
        {
            if(!empty ($service_provider_id))
            {
                $this->db->select('photo');
                $this->db->from(TBLPREFIX.'sp_photos');
                $this->db->where('service_provider_id',$service_provider_id);
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

		public function getCategory($category_id) 
        {
            if(!empty ($category_id))
            {
                $this->db->select('*');
                $this->db->from(TBLPREFIX.'category');
                $this->db->where('category_id',$category_id);
                $query = $this->db->get();
                $result= $query->row();
                // if(isset($user->profile_pic) && $user->profile_pic!="")
                // {
                //     $user->profile_pic=base_url()."uploads/user_profile/".$user->profile_pic;;
                // }
                
				// $user->mpin=$user->otp;
                
                return $result;
            }
        }

		public function getSubCategory($category_id) 
        {
            if(!empty ($category_id))
            {
                $this->db->select('*');
                $this->db->from(TBLPREFIX.'category');
                $this->db->where('category_parent_id',$category_id);
                $query = $this->db->get();
                $result= $query->result_array();
                return $result;
            }
        }


		public function getAllBanners() 
        {
            $this->db->select('*');
            $this->db->from(TBLPREFIX.'banner');
            $this->db->where('banner_status	','Active');
            $this->db->where('banner_type','Customer');
            $query = $this->db->get();
            $result= $query->result_array();
            foreach($result as $key=>$row)
            {
                if(isset($row['banner_image']) && $row['banner_image']!="")
                {
                    $row['banner_image']=base_url()."uploads/banner_images/".$row['banner_image'];
                }
                $result[$key]=$row;
            }
            return $result;
        }

		function getNearByServiceGivers($limit,$userLat,$userLong,$category_id,$service_provider_id,$pagination='',$pageid=0,$Offset=0)
		{
			//$distance_customer='10';
			// $distance_parameter="";
			$distance=$this->getDistance(1);
			$distance_parameter = '(
				6371 * acos(
				  cos(radians('.'z.zone_lat)) * cos(radians('.$userLat.')) * cos(
					radians('.$userLong.') - radians('.'z.zone_long)
				  ) + sin(radians('.$userLat.')) * sin(radians('.'z.zone_lat))
				)
			  ) AS distance';
									  
			$this->db->select($distance_parameter.','.'u.user_id as service_provider_id,u.full_name,u.address,u.profile_id,u.profile_pic,u.category_id,u.zone_id,c.category_name');
			$this->db->from(TBLPREFIX.'users as u');
			$this->db->join(TBLPREFIX.'category as c','c.category_id=u.category_id','left');
			$this->db->join(TBLPREFIX.'zone as z','z.zone_id=u.zone_id','left');
			$this->db->where('u.user_type','Service Provider');
			$this->db->where('u.user_id!=',$service_provider_id);
			$this->db->where('u.status','Active');
			// $this->db->having("distance <=" ,NEARDISTANCE);
			$this->db->where('u.category_id',$category_id);
			$this->db->group_by('u.user_id');
			$this->db->order_by('u.user_id', 'desc');
			$this->db->having("distance <=" ,$distance->nearbydistance);
			if(isset($limit) && $limit!='')
			{
				$this->db->limit($limit);
			}

			if($pagination=='true')
			{
				if($pageid>0)
				{
					$this->db->limit(POSTLIMIT,$Offset);
				}
				else
				{
					$this->db->limit(POSTLIMIT,$Offset);
				}
			}
			
			$result = $this->db->get()->result_array();
			// echo $this->db->last_query();
			if(!empty ($result) )
			{
				foreach($result as $key=>$row)
				{
					if(isset($row['category_image']) && $row['category_image']!="")
					{
						$row['category_image']=base_url()."uploads/category_images/".$row['category_image'];
					}
					if(isset($row['profile_pic']) && $row['profile_pic']!="")
					{
						$row['profile_pic']=base_url()."uploads/user_profile/".$row['profile_pic'];
					}
					$result[$key]=$row;
				}
			}
			return $result;
		}

		public function getDistance($res)
        {
            $this->db->select('commission as nearbydistance');
            $this->db->from(TBLPREFIX.'admin_settings');
            $this->db->where('commission_type','DISTANCE');
            if($res==1)
            {
                $result=$this->db->get()->row();
            }
            else
            {
                $result=$this->db->get()->num_rows();
            }
            return  $result;
        }

		public function checkIsFavourite($user_id,$service_provider_id) 
        {
            $this->db->select('*');
            $this->db->from(TBLPREFIX.'sp_favourite_verify');
            $this->db->where('user_id',$user_id);
            $this->db->where('service_provider_id',$service_provider_id);
            $query = $this->db->get();
            $result= $query->row();
            return $result;
        }

		public function checkIsVerified($service_provider_id) 
        {
            $this->db->select('*');
            $this->db->from(TBLPREFIX.'sp_favourite_verify');
            // $this->db->where('user_id',$user_id);
            $this->db->where('service_provider_id',$service_provider_id);
            $query = $this->db->get();
            $result= $query->row();
            return $result;
        }

		public function getReviews($user_id)
        {
            $this->db->select('r.*,u.user_id,u.full_name,u.profile_pic');
            $this->db->from(TBLPREFIX.'review r');
            $this->db->where('r.service_provider_id',$user_id);
            $this->db->join(TBLPREFIX.'users as u','u.user_id =r.user_id','left');
            $this->db->order_by('r.review_id','desc');
            // $this->db->limit(2);
            return $this->db->get()->result_array();			
        }

		public function getAllReviews($user_id)
        {
            $this->db->select('r.*,u.user_id,u.full_name,u.profile_pic');
            $this->db->from(TBLPREFIX.'review r');
            $this->db->where('r.service_provider_id',$user_id);
            $this->db->join(TBLPREFIX.'users as u','u.user_id =r.user_id','left');
            $this->db->order_by('r.review_id','desc');
            $this->db->limit(2);
            return $this->db->get()->result_array();			
        }

		public function getAllSubCategories($res,$category_id) 
        {
            $this->db->select('*');
            $this->db->from(TBLPREFIX.'category');
            $this->db->where('category_status','Active');
            $this->db->where('category_parent_id',$category_id);
            $this->db->where('category_status','Active');
            $query = $this->db->get();
            if($res==1)
            {
                $result= $query->result_array();
                foreach($result as $key=>$row)
                {
                    if(isset($row['category_image']) && $row['category_image']!="")
                    {
                        $row['category_image']=base_url()."uploads/category_images/".$row['category_image'];
                    }
                    $result[$key]=$row;
                }
            }
            else
            {
                $result= $query->num_rows();
            }
			// echo $this->db->last_query();
            return $result;
        }

		function searchServiceProvider($searchtype,$searchkeyword)
		{
			//$distance_customer='10';
			// $distance_parameter="";
			if($searchtype=='sortby')
			{
				$distance_parameter = '(
					6371 * acos(
					cos(radians('.'u.user_lat)) * cos(radians('.$userLat.')) * cos(
						radians('.$userLong.') - radians('.'u.user_long)
					) + sin(radians('.$userLat.')) * sin(radians('.'u.user_lat))
					)
				) AS distance';
			}
			else
			{
				$distance_parameter = '(0 ) AS distance';
			}
									  
			$this->db->select($distance_parameter.','.'u.user_id as service_provider_id,u.full_name,u.address,u.profile_id,u.profile_pic,u.category_id,c.category_name');
			$this->db->from(TBLPREFIX.'users as u');
			$this->db->join(TBLPREFIX.'category as c','c.category_id=u.category_id','left');
			$this->db->where('u.user_type','Service Provider');
			$this->db->where('u.status','Active');
			if($searchtype=='search')
			{
				$this->db->like('c.category_name',$searchkeyword);
			}
			$this->db->order_by('u.user_id', 'desc');
			// $this->db->having("distance <=" ,NEARDISTANCE);
			
			$result = $this->db->get()->result_array();
			if(!empty ($result) )
			{
				foreach($result as $key=>$row)
				{
					if(isset($row['category_image']) && $row['category_image']!="")
					{
						$row['category_image']=base_url()."uploads/category_images/".$row['category_image'];
					}
					$result[$key]=$row;
				}
			}
			return $result;
		}

		public function getAllZones($res) 
        {
            $this->db->select('*');
            $this->db->from(TBLPREFIX.'zone');
            $this->db->where('zone_status','Active');
            $query = $this->db->get();
            if($res==1)
            {
                $result= $query->result_array();
            }
            else
            {
                $result= $query->num_rows();
            }
            return $result;
        }
	}