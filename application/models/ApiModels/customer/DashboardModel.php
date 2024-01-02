<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class DashboardModel extends CI_Model {
	
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
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

        

        public function getUserDetails($user_id) 
        {
            if(!empty($user_id))
            {
                $this->db->select('full_name,address,user_lat,user_long,profile_pic');
                $this->db->from(TBLPREFIX.'users');
                $this->db->where('user_id',$user_id);
                $this->db->where('user_type','Customer');
                $query = $this->db->get();
                $result= $query->row();
                if(isset($result->profile_pic) && $result->profile_pic!="")
                {
                    $result->profile_pic=base_url()."uploads/user_profile/".$result->profile_pic;
                }
                return $result;
            }
        }
		
		public function getCategory($limit)
		{
			
			$this->db->select('*');
            $this->db->from(TBLPREFIX.'category');
            $this->db->where('category_status','Active');
            $this->db->where('category_parent_id','0');
            $this->db->order_by('category_name','asc');
			if(isset($limit) && $limit!='')
			{
				$this->db->limit($limit);
			}
            $query = $this->db->get();
			
            $result= $query->result_array();
            foreach($result as $key=>$row)
            {
                if(isset($row['category_image']) && $row['category_image']!="")
                {
                    $row['category_image']=base_url()."uploads/category_images/".$row['category_image'];
                }
                $result[$key]=$row;
            }
            return $result;
		}

		public function getCategoryDetails($category_id) 
        {
			$this->db->select('*');
            $this->db->where('category_id',$category_id );
            $query = $this->db->get(TBLPREFIX."category");
            return $query->row();
        }

		public function getAllSubCategories($res,$category_id) 
        {
            $this->db->select('*');
            $this->db->from(TBLPREFIX.'category');
            $this->db->where('category_status','Active');
            $this->db->where('category_parent_id',$category_id);
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
            return $result;
        }
		
		public function ongoingServices($limit,$user_id)
		{
			$this->db->select("b.booking_id,b.order_no,b.is_demo,b.admin_demo_accept,c.category_id,c.category_name,c.category_image,u.profile_id,u.profile_pic,u.full_name,b.booking_date,b.time_slot,b.expiry_date,b.duration,b.booking_status,b.service_provider_id,sp.full_name as sp_name,sp.mobile as sp_mobile,sp.profile_id as sp_profile_id,sp.profile_pic as sp_profile_pic");
            $this->db->from(TBLPREFIX.'booking b');
			if($user_id != '')
			{
				$this->db->where('b.user_id',$user_id);
			}
            $this->db->where('b.booking_status','ongoing');
            $this->db->join(TBLPREFIX.'users as u','u.user_id =b.user_id','left');
            $this->db->join(TBLPREFIX.'users as sp','sp.user_id =b.service_provider_id','left');
            $this->db->join(TBLPREFIX.'category as c','c.category_id = b.category_id','left');
			if(isset($limit) && $limit!='')
			{
				$this->db->limit($limit);
			}
			$this->db->order_by('b.booking_id','desc');
			$query = $this->db->get();
            $result= $query->result_array();
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
					else
					{
						$row['profile_pic']="";
					}

					if(isset($row['sp_profile_pic']) && $row['sp_profile_pic']!="")
					{
						$row['sp_profile_pic']=base_url()."uploads/user_profile/".$row['sp_profile_pic'];
					}
					else
					{
						$row['sp_profile_pic']="";
					}
					$result[$key]=$row;
				}
			}
			return $result;
		}
		
		function getNearByServiceGivers($limit,$userLat,$userLong,$pagination='',$pageid=0,$Offset=0)
		{
			//$distance_customer='10';
			$distance=$this->getDistance(1);
        //    print_r($distance);

			$distance_parameter = '(
				6371 * acos(
				  cos(radians('.'u.user_lat)) * cos(radians('.$userLat.')) * cos(
					radians('.$userLong.') - radians('.'u.user_long)
				  ) + sin(radians('.$userLat.')) * sin(radians('.'u.user_lat))
				)
			  ) AS distance';

			//   $distance_parameter = '(
			// 	6371 * acos(
			// 	  cos(radians('.'z.zone_lat)) * cos(radians('.$userLat.')) * cos(
			// 		radians('.$userLong.') - radians('.'z.zone_long)
			// 	  ) + sin(radians('.$userLat.')) * sin(radians('.'z.zone_lat))
			// 	)
			//   ) AS distance';
									  
			$this->db->select($distance_parameter.','.'u.user_id as service_provider_id,u.full_name,u.address,u.profile_id,u.profile_pic,u.category_id,u.zone_id,c.category_name');
			$this->db->from(TBLPREFIX.'users as u');
			$this->db->join(TBLPREFIX.'category as c','c.category_id=u.category_id','left');
			$this->db->join(TBLPREFIX.'zone as z','z.zone_id=u.zone_id','left');
			$this->db->where('u.user_type','Service Provider');
			$this->db->where('u.status','Active');
			$this->db->order_by('user_id', 'desc');
			$this->db->group_by('user_id');
			// $this->db->having("distance <=" ,NEARDISTANCE);
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
			if(!empty ($result) )
			{
				foreach($result as $k=>$row)
				{
					if(isset($row['category_image']) && $row['category_image']!="")
					{
						$row['category_image']=base_url()."uploads/category_images/".$row['category_image'];
					}
					if(isset($row['profile_pic']) && $row['profile_pic']!="")
					{
						$row['profile_pic']=base_url()."uploads/user_profile/".$row['profile_pic'];
					}
					$result[$k]=$row;
				}
			}
			return $result;
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
		
	}