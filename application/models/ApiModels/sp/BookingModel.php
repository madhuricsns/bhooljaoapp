<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class BookingModel extends CI_Model {
	
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		public function updateBookingStatus($user_id)
		{
            $conditionOngoing="booking_status!='canceled'";
			// Ongoing 
			$update_data = array('booking_status' => 'ongoing');
			$this->db->where('service_provider_id',$user_id);
			$this->db->where('is_demo','No');
			$this->db->where($conditionOngoing);
			$this->db->where('CURDATE() BETWEEN DATE(booking_date) AND expiry_date');
			$this->db->update(TBLPREFIX.'booking',$update_data);
			//  echo $this->db->last_query();
            // exit;

			// Completed
			$update_data = array('booking_status' => 'completed');
			$this->db->where('service_provider_id',$user_id);
			$this->db->where('is_demo','No');
			$this->db->where($conditionOngoing);
			$this->db->where('CURDATE() > expiry_date');
			$this->db->update(TBLPREFIX.'booking',$update_data);
		}

        public function updateGroupBookingStatus($user_id)
		{
			/*************** Ongoing ************************** */
            $ongoing_bookings=$this->getMyBookings($user_id,'waiting');
            $ongoingbooking_ids="(-1";
            foreach($ongoing_bookings as $booking)
            {
                if($booking['service_group_assigned']=='YES')
                {
                    $ongoingbooking_ids.=",".$booking['booking_id'];
                }
            }
            $ongoingbooking_ids.=")";
            $condition="booking_id IN  $ongoingbooking_ids";
            /***************************************** */

			// Group Booking Ongoing
			$conditionOngoing="booking_status!='canceled'";
			// Ongoing 
			$update_data = array('booking_status' => 'ongoing');
			// $this->db->where('service_provider_id',$user_id);
			$this->db->where($condition);
			$this->db->where('is_demo','No');
			$this->db->where($conditionOngoing);
			$this->db->where('CURDATE() BETWEEN DATE(booking_date) AND expiry_date');
			$this->db->update(TBLPREFIX.'booking',$update_data);
			
			// Completed
			/*************** Ongoing ************************** */
            $ongoing_bookings=$this->getMyBookings($user_id,'ongoing');
            $ongoingbooking_ids="(-1";
            foreach($ongoing_bookings as $booking)
            {
                if($booking['service_group_assigned']=='YES')
                {
                    $ongoingbooking_ids.=",".$booking['booking_id'];
                }
            }
            $ongoingbooking_ids.=")";
            $condition="booking_id IN  $ongoingbooking_ids";
            /***************************************** */

			$update_data = array('booking_status' => 'completed');
			// $this->db->where('service_provider_id',$user_id);
			$this->db->where('is_demo','No');
			$this->db->where($condition);
			$this->db->where($conditionOngoing);
			$this->db->where('CURDATE() > expiry_date');
			$this->db->update(TBLPREFIX.'booking',$update_data);
		}

        public function updateDemoBookingStatus($user_id)
		{
			$todayDate=date('Y-m-d');
            $conditionOngoing="booking_status!='canceled'";
            $condition="booking_status!='completed'";
			// Ongoing 
			$update_data = array('booking_status' => 'ongoing');
			$this->db->where('service_provider_id',$user_id);
			$this->db->where('is_demo','Yes');
			$this->db->where('admin_demo_accept','Yes');
			$this->db->where('booking_date',$todayDate);
			$this->db->where($conditionOngoing);
			$this->db->where($condition);
			// $this->db->where('CURDATE() BETWEEN DATE(booking_date)');
			$this->db->update(TBLPREFIX.'booking',$update_data);
		}
		public function getMyBookings($user_id,$status)
		{

            //(DATE_FORMAT(DATE(b.booking_date),'%M/%d/,%Y')) as booking_date
			$this->db->select("b.booking_id,b.order_no,b.is_demo,b.admin_demo_accept,b.user_id,b.service_group_id,b.service_group_assigned,c.category_id,c.category_name,c.category_image,u.profile_id,u.profile_pic,u.full_name,u.mobile,b.booking_date,b.time_slot,b.expiry_date,b.booking_status,b.service_provider_id
            ,a.address1 as address,sg.group_name,g.service_provider_id as sp_id");
            $this->db->from(TBLPREFIX.'booking b');
            $this->db->where('b.booking_status',$status);
            // $this->db->where('b.service_provider_id',$user_id);
            // $condition="g.service_provider_id IN (".$user_id.")";
            $condition="(b.service_provider_id='".$user_id."' OR g.service_provider_id IN (".$user_id."))";
            $this->db->where($condition);

            // if($status == 'ongoing')
			// {
			// 	$this->db->where('CURDATE() BETWEEN DATE(b.booking_date) AND b.expiry_date');
			// }
			// else if($status == 'completed')
			// {
			// 	$this->db->where('CURDATE() > expiry_date');
			// }
			// else
			// {
			// 	$this->db->where('CURDATE() < DATE(b.booking_date)');
			// }
           
            $this->db->join(TBLPREFIX.'users as u','u.user_id =b.user_id','left');
            $this->db->join(TBLPREFIX.'service_group as g','g.group_parent_id =b.service_group_id','left');
            $this->db->join(TBLPREFIX.'service_group as sg','sg.group_id =b.service_group_id','left');
            $this->db->join(TBLPREFIX.'users as sp','sp.user_id =g.service_provider_id','left');
            $this->db->join(TBLPREFIX.'category as c','c.category_id = b.category_id','left');
            $this->db->join(TBLPREFIX.'addresses as a','a.address_id = b.address_id','left');
            $this->db->order_by('b.booking_id','desc');
            $this->db->group_by('b.booking_id');
			$query = $this->db->get();
            $result= $query->result_array();
            // echo $this->db->last_query();
			if(!empty ($result) )
			{
				foreach($result as $key=>$row)
				{
					if(isset($row['profile_pic']) && $row['profile_pic']!="")
					{
						$row['profile_pic']=base_url()."uploads/user_profile/".$row['profile_pic'];
					}
                    if(isset($row['category_image']) && $row['category_image']!="")
					{
						$row['category_image']=base_url()."uploads/category_images/".$row['category_image'];
					}
					$result[$key]=$row;
				}
			}
			return $result;
		}
		
		public function getBookingData($booking_id,$userLat='',$userLong='')
		{
            if($userLat!='' && $userLong!='')
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
                $distance_parameter ='(0 ) AS distance';
            }

			$this->db->select($distance_parameter.','.'b.order_no,b.booking_status,b.is_demo,b.admin_demo_accept,b.user_id,c.category_id,c.category_name,c.category_description,c.category_image,ad.address1 as address,b.booking_date,b.time_slot,b.expiry_date,b.duration,b.service_provider_id,b.payment_type
            ,ad.address_lat,ad.address_lng');
			$this->db->from(TBLPREFIX.'booking as b');
			$this->db->where('b.booking_id',$booking_id);
			$this->db->join(TBLPREFIX.'category as c','c.category_id = b.category_id','left');
			$this->db->join(TBLPREFIX.'addresses as ad','ad.address_id = b.address_id','left');
            $this->db->join(TBLPREFIX.'users as u','u.user_id =b.user_id','left');
			$query = $this->db->get();
			$result= $query->row();
			
			if(isset($result->category_image) && $result->category_image!="")
			{
				$result->category_image = base_url()."uploads/category_images/".$result->category_image;
			}
					
			return $result;
		}
		
		public function getBookingDetails($booking_id)
		{
			$this->db->select('*');
			$this->db->from(TBLPREFIX.'booking as b');
			$this->db->where('b.booking_id',$booking_id);
			$query = $this->db->get();
			$result= $query->row();
			return $result;
		}
		
		public function getServiceDetailsWOPricing($booking_id) 
		{
			$this->db->select('s.service_name,bd.option_label,bd.option_value');
			$this->db->from(TBLPREFIX.'booking as b');
			$this->db->where('b.booking_id',$booking_id);
			$this->db->join(TBLPREFIX.'booking_details as bd','bd.booking_id = b.booking_id','left');
			$this->db->where('bd.option_amount =',0);
			$this->db->join(TBLPREFIX.'service as s','s.service_id = bd.service_id','left');
			$query = $this->db->get();
			$result= $query->result_array();
			return $result;
		}

        public function getServiceDetailsInformation($booking_id) 
		{
			$this->db->select('s.service_name,bd.option_label,bd.option_value');
			$this->db->from(TBLPREFIX.'booking as b');
			$this->db->where('b.booking_id',$booking_id);
			$this->db->join(TBLPREFIX.'booking_details as bd','bd.booking_id = b.booking_id','left');
			$this->db->where('bd.option_amount >',0);
			$this->db->join(TBLPREFIX.'service as s','s.service_id = bd.service_id','left');
			$query = $this->db->get();
			$result= $query->result_array();
			return $result;
		}
		
		public function getServiceDetails($booking_id) 
		{
			$this->db->select('s.service_name,bd.option_label,bd.option_value,bd.option_amount,b.duration,b.admin_commision,b.gst_amount,b.gst_percentage,b.coupon_code,b.coupon_amount,b.coupon_percentage');
			$this->db->from(TBLPREFIX.'booking as b');
			$this->db->where('b.booking_id',$booking_id);
			$this->db->join(TBLPREFIX.'booking_details as bd','bd.booking_id = b.booking_id','left');
			$this->db->where('bd.option_amount >',0);
			$this->db->join(TBLPREFIX.'service as s','s.service_id = bd.service_id','left');
			$query = $this->db->get();
			$result= $query->result_array();
			return $result;
		}

        public function getBookingWorkHistory($booking_id)
		{
			$this->db->select('booking_id,history_date,history_time,work_photo1,work_photo2,history_lat,history_long');
			$this->db->from(TBLPREFIX.'booking_history');
			$this->db->where('booking_id',$booking_id);
			$query = $this->db->get();
			$result= $query->result_array();
			foreach($result as $k=>$row)
            {
                if(isset($row['work_photo1']) && $row['work_photo1']!="")
                {
                    $row['work_photo1'] = base_url()."uploads/work_history/".$row['work_photo1'];
                }
                if(isset($row['work_photo2']) && $row['work_photo2']!="")
                {
                    $row['work_photo2'] = base_url()."uploads/work_history/".$row['work_photo2'];
                }
                $result[$k]=$row;
            }
					
			return $result;
		}

        public function checkTodayWorkHistory($booking_id)
		{
            $history_date=date('Y-m-d');
			$this->db->select('booking_id,history_date,history_time,work_photo1,work_photo2');
			$this->db->from(TBLPREFIX.'booking_history');
			$this->db->where('booking_id',$booking_id);
			$this->db->where('history_date>=',$history_date);
			$this->db->where('history_date<=',$history_date." 23:59:59");
			$query = $this->db->get();
			$result= $query->num_rows();
			if($result>0)
			{
				return true;
			}
			else
			{
				return false;
			}
			
		}
    
		public function getPromocode() 
        {
            $this->db->select('*');
            $this->db->from(TBLPREFIX.'promo_code');
            // $this->db->where('service_id',$service_id);
            $this->db->where('promocode_status','Active');
            $query = $this->db->get();
            $result= $query->result_array();
            return $result;
        }

        public function getFeedback($feedback_id) 
        {
            $this->db->select('*');
            $this->db->from(TBLPREFIX.'feedback');
            $this->db->where('feedback_id',$feedback_id);
            $query = $this->db->get();
            $result= $query->row();
            return $result;
        }

       
        /*public function getServiceDetails($service_id) 
        {
            if(!empty($service_id))
            {
                $this->db->select('s.service_id,s.service_name,s.service_app_image,s.service_image,s.service_description,s.amount');
                $this->db->from(TBLPREFIX.'main_services as s');
                $this->db->where('service_id',$service_id);
                $query = $this->db->get();
                $result= $query->row();
                if(isset($result->service_image) && $result->service_image!="")
                {
                    $result->service_image=base_url()."uploads/service_img/".$result->service_image;
                }
                if(isset($result->service_app_image) && $result->service_app_image!="")
                {
                    $result->service_app_image=base_url()."uploads/service_img/".$result->service_app_image;
                }
                return $result;
            }
        }
		*/
        public function getUserDetails($user_id) 
        {
            if(!empty($user_id))
            {
                $this->db->select('*');
                $this->db->from(TBLPREFIX.'users');
                $this->db->where('user_id',$user_id);
                // $this->db->where('user_type','Customer');
                $query = $this->db->get();
                $result= $query->row();
                if(isset($result->profile_pic) && $result->profile_pic!="")
                {
                    $result->profile_pic=base_url()."uploads/user_profile/".$result->profile_pic;
                }
                return $result;
            }
        }

        public function getSPDetails($user_id) 
        {
            if(!empty($user_id))
            {
                $this->db->select('user_id,profile_id,full_name,mobile,profile_pic');
                $this->db->from(TBLPREFIX.'users');
                $this->db->where('user_id',$user_id);
                // $this->db->where('user_type','Customer');
                $query = $this->db->get();
                $result= $query->row();
                if(isset($result->profile_pic) && $result->profile_pic!="")
                {
                    $result->profile_pic=base_url()."uploads/user_profile/".$result->profile_pic;
                }
                return $result;
            }
        }

        public function getAllUser() 
        {
            $this->db->select('*');
            $this->db->from(TBLPREFIX.'users');
            $this->db->where('status_flag','Active');
            $this->db->where('user_type','Service Provider');
            $this->db->where('service_type','Service Provider');
            $query = $this->db->get();
            $result= $query->result_array();
            foreach($result as $key=>$user)
            {
                if(isset($user->profile_pic) && $user->profile_pic!="")
                {
                    $user->profile_pic=base_url()."uploads/user_profile/".$user->profile_pic;
                }
                $result[$key]=$user;
            }
            return $result;
        }

        public function getAllCategory($service_id) 
        {
            $this->db->select('*');
            $this->db->from('booking_category');
            $this->db->where('category_type',$service_id);
            $this->db->where('status','active');
            $query = $this->db->get();
            $result= $query->result_array();
            return $result;
        }

        public function getCategoryDetails($booking_category_id) 
        {
            $this->db->select('*');
            $this->db->from('booking_category');
            $this->db->where('booking_category_id',$booking_category_id);
            $query = $this->db->get();
            $result= $query->row();
            return $result;
        }

        public function getCategory($category_id)
        {
            $this->db->select('*');
            $this->db->where('category_id',$category_id );
            $query = $this->db->get(TBLPREFIX."category");
            return $query->row();
        }

        
        public function checkreviewExist($user_id,$service_provider_id,$booking_id) 
        {
            $this->db->select('*');
            $this->db->from(TBLPREFIX.'review');
            $this->db->where('service_provider_id',$service_provider_id);
            $this->db->where('user_id',$user_id);
            // $this->db->where('booking_id',$booking_id);
            $query = $this->db->get();
            return $query->num_rows();
        }

        function getnotifications($user_id)
        {
            $this->db->select('*');
            $this->db->from(TBLPREFIX.'notification');
            $this->db->where('noti_user_id',$user_id);
            // $this->db->where('noti_user_type','Customer');
            $this->db->order_by('noti_id','desc');
            $this->db->limit('50');
            return $result = $this->db->get()->result_array();
        }

       
        public function getRatingPercentage($user_id)
        {
            $this->db->select('*');
            $this->db->from(TBLPREFIX.'review r');
            $this->db->where('r.service_provider_id',$user_id);
            return $result = $this->db->get()->result_array();
        }

        public function getReviews($user_id)
        {
            $this->db->select('r.*,u.user_id,u.full_name,u.profile_pic');
            $this->db->from(TBLPREFIX.'review r');
            $this->db->where('r.service_provider_id',$user_id);
            $this->db->join(TBLPREFIX.'users as u','u.user_id =r.user_id','left');
            return $this->db->get()->result_array();			
            // if(!empty($reviews))
            // 	return $reviews;
            // else
            // 	return null;
        }

        public function getFeedbacks($user_id)
        {
            $this->db->select('f.*,u.user_id,u.full_name,u.profile_pic,b.order_no');
            $this->db->from(TBLPREFIX.'feedback as f');
            $this->db->where('f.service_provider_id',$user_id);
            $this->db->join(TBLPREFIX.'users as u','u.user_id =f.user_id','left');
            $this->db->join(TBLPREFIX.'booking as b','b.booking_id =f.booking_id','left');
            $query = $this->db->get();
            $result= $query->result_array();
			if(!empty ($result) )
			{
				foreach($result as $key=>$row)
				{
					if(isset($row['profile_pic']) && $row['profile_pic']!="")
					{
						$row['profile_pic']=base_url()."uploads/user_profile/".$row['profile_pic'];
					}
                    
					$result[$key]=$row;
				}
			}
			return $result;		
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

        public function getNewBookings($user_id,$userLat,$userLong)
		{
        
           $user=$this->getUserDetails($user_id);
           $category_ids="(-1,".$user->category_id;
           $subcategory=$this->getSubCategory($user->category_id);
            // print_r($subcategory);
            if(!empty($subcategory))
            {
                foreach($subcategory as $subcat)
                {
                    $category_ids.=",".$subcat['category_id'];
                }
            }
            $category_ids.=")";
            $wherecategory="b.category_id IN ".$category_ids;
            // echo $category_ids;

           $accepted =$this->getacceptedBookings($user_id);
           $booking_ids="(-1";
            foreach($accepted as $acceptBooking)
            {
                $booking_ids.=",".$acceptBooking['booking_id'];
            }
            $booking_ids.=")";
            // echo $booking_ids;
            $condition="b.booking_id NOT IN ".$booking_ids;
            $distance_parameter=0;
            $distance_parameter = '(
				6371 * acos(
				  cos(radians('.'a.address_lat)) * cos(radians('.$userLat.')) * cos(
					radians('.$userLong.') - radians('.'a.address_lng)
				  ) + sin(radians('.$userLat.')) * sin(radians('.'a.address_lat))
				)
			  ) AS distance';
                
            //(DATE_FORMAT(DATE(b.booking_date),'%M/%d/,%Y')) as booking_date
			$this->db->select($distance_parameter.','.'b.booking_id,b.order_no,b.duration,c.category_id,c.category_name,c.category_image,u.profile_id,u.profile_pic,u.full_name,b.booking_date,b.time_slot,b.expiry_date,b.booking_status,b.service_provider_id
            ,a.address1 as address,a.address_id,a.address_lat,a.address_lng');
            $this->db->from(TBLPREFIX.'booking b');
            $this->db->where($wherecategory);
            $this->db->where($condition);
            $this->db->where('b.service_provider_id','0');
            $this->db->where('b.booking_status','waiting');
            $this->db->join(TBLPREFIX.'users as u','u.user_id =b.user_id','left');
            $this->db->join(TBLPREFIX.'category as c','c.category_id = b.category_id','left');
            $this->db->join(TBLPREFIX.'addresses as a','a.address_id = b.address_id','left');
			$this->db->having("distance <=" ,'10');
			$query = $this->db->get();
            $result= $query->result_array();
            // echo $this->db->last_query();
			if(!empty ($result) )
			{
				foreach($result as $key=>$row)
				{
					if(isset($row['profile_pic']) && $row['profile_pic']!="")
					{
						$row['profile_pic']=base_url()."uploads/user_profile/".$row['profile_pic'];
					}
                    if(isset($row['category_image']) && $row['category_image']!="")
					{
						$row['category_image']=base_url()."uploads/category_images/".$row['category_image'];
					}
					$result[$key]=$row;
				}
			}
			return $result;
		}

        public function checkAlreadyExist($res,$user_id,$booking_id)
        {
            $this->db->select('*');
            $this->db->from(TBLPREFIX.'booking_accepted');
            $this->db->where('service_provider_id',$user_id);
            $this->db->where('booking_id',$booking_id);
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

        public function getacceptedBookings($user_id)
        {
            $this->db->select('ab.*,b.user_id,b.category_id,b.order_no,c.category_name,c.category_image,u.profile_id,u.profile_pic,u.full_name');
            $this->db->from(TBLPREFIX.'booking_accepted as ab');
            $this->db->where('ab.service_provider_id',$user_id);
            $this->db->join(TBLPREFIX.'booking as b','b.booking_id = ab.booking_id','left');
            $this->db->join(TBLPREFIX.'users as u','u.user_id =b.user_id','left');
            $this->db->join(TBLPREFIX.'category as c','c.category_id = b.category_id','left');
            $result=$this->db->get()->result_array();
            foreach($result as $key=>$row)
            {
                if(isset($row['profile_pic']) && $row['profile_pic']!="")
                {
                    $row['profile_pic']=base_url()."uploads/user_profile/".$row['profile_pic'];
                }
                if(isset($row['category_image']) && $row['category_image']!="")
                {
                    $row['category_image']=base_url()."uploads/category_images/".$row['category_image'];
                }
                $result[$key]=$row;
            }	
            return  $result;
        }

        public function getreport($user_id,$report_type,$from_date='',$to_date='',$searchkeyword='')
        {
            // $quarter=$this->getQUARTER();
            // $user=$this->getUserDetails($user_id);
            
            $this->db->select('h.history_id,h.booking_id,h.history_date,h.history_time,h.work_photo1,h.work_photo2,b.order_no,b.service_provider_id,b.service_group_id,u.full_name,u.profile_id,
            ');
			$this->db->from(TBLPREFIX.'booking_history as h');
            $this->db->join(TBLPREFIX.'booking as b','b.booking_id=h.booking_id','left');
            $this->db->join(TBLPREFIX.'users as u','u.user_id=b.user_id','left');
            $this->db->join(TBLPREFIX.'service_group as g','g.group_parent_id =b.service_group_id','left');
            $this->db->join(TBLPREFIX.'service_group as sg','sg.group_id =b.service_group_id','left');

			// $this->db->where('b.service_provider_id',$user_id);
            $condition="(b.service_provider_id='".$user_id."' OR g.service_provider_id IN (".$user_id."))";
            $this->db->where($condition);
            if($searchkeyword!="")
            {
                $this->db->like('u.full_name',$searchkeyword);
            }
			
			
            switch($report_type)
            {
                case "Today":
                    $this->db->where('h.history_date = CURRENT_DATE()');
                    break;

                case "Last Week":
                    $this->db->where('DATE(h.history_date) > DATE_SUB(CURRENT_DATE(), INTERVAL 1 WEEK) ');
                    $this->db->where('h.history_date <= CURRENT_DATE()');
                    break;
                        
                case "Last Month":
                    //$this->db->where('MONTH(b.booking_date) = MONTH(NOW()) - 1 ');
                    $this->db->where('DATE(h.history_date) > DATE_SUB(CURRENT_DATE() , INTERVAL 1 MONTH) ');
                    $this->db->where('h.history_date <= CURRENT_DATE()');
                    break;
                
                case "Custom":
                    $this->db->where("h.history_date >='".$from_date."'");
                    $this->db->where("h.history_date <='".$to_date." 23:59:59'");
                    break;
            }
            $this->db->order_by('h.history_date','desc');
            $this->db->order_by('h.history_time','desc');
            $this->db->group_by('b.booking_id');
            $query = $this->db->get();
			$result= $query->result_array();
            // echo $this->db->last_query();
			// foreach($result as $k=>$row)
            // {
            //     if(isset($row['work_photo1']) && $row['work_photo1']!="")
            //     {
            //         $row['work_photo1'] = base_url()."uploads/work_history/".$row['work_photo1'];
            //     }
            //     if(isset($row['work_photo2']) && $row['work_photo2']!="")
            //     {
            //         $row['work_photo2'] = base_url()."uploads/work_history/".$row['work_photo2'];
            //     }
            //     $result[$k]=$row;
            // }
					
			return $result;

        }
        
	}