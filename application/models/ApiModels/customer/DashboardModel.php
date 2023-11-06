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
		
		public function getCategory()
		{
			$this->db->select('*');
            $this->db->from(TBLPREFIX.'category');
            $this->db->where('category_status','Active');
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
		
		public function ongoingServices()
		{
			$this->db->select('*');
            $this->db->from(TBLPREFIX.'category');
            $this->db->where('category_status','Active');
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
		
		function getNearByServices($limit,$userLat,$userLong,$pagination='',$pageid=0,$Offset=0)
		{
			//$distance_customer='10';
			
			$distance_parameter = '(
				6371 * acos(
				  cos(radians('.'u.user_lat)) * cos(radians('.$userLat.')) * cos(
					radians('.$userLong.') - radians('.'u.user_long)
				  ) + sin(radians('.$userLat.')) * sin(radians('.'u.user_lat))
				)
			  ) AS distance';
									  
			$this->db->select($distance_parameter.','.'a.agencyid,a.agency_name,a.agency_email,a.agency_address,a.agency_license_no,a.established_year,a.added_by,a.agency_lat,a.agency_long,a.status,a.status_flag,u.available_in_call,u.mobile_number,u.available_now');
			$this->db->from('agency as a');
			$this->db->join('agency_users as u','a.added_by=u.user_id','left');
			$this->db->where('u.available_now','YES');
			$this->db->where('a.status','Accepted');
			$this->db->where('a.status_flag','Active');
			$this->db->order_by('agencyid', 'desc');
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
			return $this->db->get()->result_array();
		}
	}