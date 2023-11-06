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
            $this->db->from(TBPREFIX.'banner');
            $this->db->where('banner_status	','Active');
            $this->db->where('banner_type','Customer');
            $query = $this->db->get();
            $result= $query->result_array();
            foreach($result as $key=>$row)
            {
                if(isset($row['banner_image']) && $row['banner_image']!="")
                {
                    $row['banner_image']=base_url()."uploads/banners/".$row['banner_image'];
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
                // if(isset($result->profile_pic) && $result->profile_pic!="")
                // {
                //     $result->profile_pic=base_url()."uploads/user/profile_photo/".$result->profile_pic;
                // }
                return $result;
            }
        }
		
		public function getCategory($limit)
		{
			$this->db->select('*');
            $this->db->from(TBLPREFIX.'category');
            $this->db->where('category_status','Active');
            $query = $this->db->get();
			if(isset($limit) && $limit!='')
			{
				$this->db->limit($limit);
			}
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
		
		public function ongoingServices($user_id)
		{
			$this->db->select("c.category_name,c.category_image,u.profile_id,u.full_name,(DATE_FORMAT(DATE(b.booking_date),'%M/%d/,%Y')) as booking_date,b.time_slot,b.expiry_date,b.booking_status");
            $this->db->from(TBLPREFIX.'booking b');
            $this->db->where('b.user_id',$user_id);
            $this->db->where('b.booking_status','ongoing');
            $this->db->join(TBLPREFIX.'users as u','u.user_id =b.user_id','left');
            $this->db->join(TBLPREFIX.'category as c','c.category_id = b.service_category_id','left');
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
					$result[$key]=$row;
				}
			}
			return $result;
		}
		
		function getNearByServiceGivers($limit,$userLat,$userLong,$pagination='',$pageid=0,$Offset=0)
		{
			//$distance_customer='10';
			
			$distance_parameter = '(
				6371 * acos(
				  cos(radians('.'u.user_lat)) * cos(radians('.$userLat.')) * cos(
					radians('.$userLong.') - radians('.'u.user_long)
				  ) + sin(radians('.$userLat.')) * sin(radians('.'u.user_lat))
				)
			  ) AS distance';
									  
			$this->db->select($distance_parameter.','.'u.full_name,u.address,u.profile_pic');
			$this->db->from(TBLPREFIX.'users as u');
			$this->db->where('u.user_type','Service Provider');
			$this->db->where('u.status','Active');
			$this->db->order_by('user_id', 'desc');
			$this->db->having("distance <=" ,NEARDISTANCE);
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
				foreach($result as $key=>$row)
				{
					if(isset($row['category_image']) && $row['category_image']!="")
					{
						$row['category_image']=base_url()."uploads/category_images/".$row['category_image'];
					}
					$result[$key]=$row;
				}
			}
		}
	}