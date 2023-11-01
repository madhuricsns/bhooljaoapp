<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class BookingModel extends CI_Model {
	
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

    
		public function getPromocode($service_id) 
        {
            if(!empty($service_id))
            {
                $this->db->select('*');
                $this->db->from(TBPREFIX.'promo_code');
                $this->db->where('service_id',$service_id);
                $this->db->where('promocode_status','Active');
                $query = $this->db->get();
                $result= $query->result_array();
                return $result;
            }
        }

        public function getPromocodeByid($promocode_id) 
        {
            if(!empty($promocode_id))
            {
                $this->db->select('*');
                $this->db->from(TBPREFIX.'promo_code');
                $this->db->where('promocode_id',$promocode_id);
                $query = $this->db->get();
                $result= $query->row();
                return $result;
            }
        }

        public function getAllCards($user_id) 
        {
            if(!empty($user_id))
            {
                $this->db->select('*');
                $this->db->from(TBPREFIX.'customer_cards');
                $this->db->where('user_id',$user_id);
                $query = $this->db->get();
                $result= $query->result_array();
                return $result;
            }
        }

        public function getCardDetails($user_id,$card_id) 
        {
            if(!empty($card_id))
            {
                $this->db->select('*');
                $this->db->from(TBPREFIX.'customer_cards');
                $this->db->where('user_id',$user_id);
                $this->db->where('card_id',$card_id);
                $query = $this->db->get();
                $result= $query->row();
                return $result;
            }
        }
	
		function getAllAddress($user_id)
		{
			$this->db->select('*');
			$this->db->from(TBPREFIX.'adresses');
			$this->db->where('adress_status','Active');
			$this->db->where('user_id',$user_id);
			return $this->db->get()->result_array();			
		}

        function isselected_pickup_update($user_id)
        {
            $data=array('is_seleted'=>0);
            $this->db->where('user_id',$user_id);
            $this->db->update(TBPREFIX.'adresses',$data);
        }

        function isselected_drop_update($user_id)
        {
            $data=array('is_selected_drop'=>0);
            $this->db->where('user_id',$user_id);
            $this->db->update(TBPREFIX.'adresses',$data);
        }

        //get user selected address
        public function getSelectedPickupAddress($user_id,$qty,$lng)
        {
            if($lng == "" || $lng == 'english')
                $strPrefix = "";
            else
                $strPrefix = "_ch";
            $this->db->select('*');
            $this->db->where(TBPREFIX.'adresses'.$strPrefix.'.user_id',$user_id);
            $this->db->where(TBPREFIX.'adresses'.$strPrefix.'.is_seleted',1);
            $query=$this->db->get(TBPREFIX.'adresses'.$strPrefix.'');

            if($qty==1)

                return $query->row_array();

            else

                return $query->num_rows();
        }
        //get user selected drop address
        public function getSelectedDropAddress($user_id,$qty,$lng)
        {
            if($lng == "" || $lng == 'english')
                $strPrefix = "";
            else
                $strPrefix = "_ch";
            $this->db->select('*');
            $this->db->where(TBPREFIX.'adresses'.$strPrefix.'.user_id',$user_id);
            $this->db->where(TBPREFIX.'adresses'.$strPrefix.'.is_selected_drop',1);
            $query=$this->db->get(TBPREFIX.'adresses'.$strPrefix.'');

            if($qty==1)

                return $query->row_array();

            else

                return $query->num_rows();
        }

        
        public function getAllDoctors() 
        {
            $this->db->select('*');
            $this->db->from(TBPREFIX.'doctors');
            $this->db->where('doctor_status','Active');
            $query = $this->db->get();
            $result= $query->result_array();
            foreach($result as $key=>$row)
            {
                if(isset($row['doctor_image']) && $row['doctor_image']!="")
                {
                    $row['doctor_image']=base_url()."uploads/doctor_images/".$row['doctor_image'];
                }
                $result[$key]=$row;
            }
            return $result;
        }

        public function getDoctorDetails($doctor_id) 
        {
            $this->db->select('*');
            $this->db->from(TBPREFIX.'doctors');
            $this->db->where('doctor_id',$doctor_id);
            $query = $this->db->get();
            $result= $query->row();
            if(isset($result->doctor_image) && $result->doctor_image!="")
            {
                $result->doctor_image=base_url()."uploads/doctor_images/".$result->doctor_image;
            }
            return $result;
        }

        public function getAllNurse() 
        {
            $this->db->select('*');
            $this->db->from(TBPREFIX.'nurse');
            $this->db->where('nurse_status','Active');
            $query = $this->db->get();
            $result= $query->result_array();
            foreach($result as $key=>$row)
            {
                if(isset($row['nurse_image']) && $row['nurse_image']!="")
                {
                    $row['nurse_image']=base_url()."uploads/nurse_images/".$row['nurse_image'];
                }
                $result[$key]=$row;
            }
            return $result;
        }

        public function getNurseDetails($nurse_id) 
        {
            $this->db->select('*');
            $this->db->from(TBPREFIX.'nurse');
            $this->db->where('nurse_id',$nurse_id);
            $query = $this->db->get();
            $result= $query->row();
            if(isset($result->nurse_image) && $result->nurse_image!="")
            {
                $result->nurse_image=base_url()."uploads/nurse_images/".$result->nurse_image;
            }
            return $result;
        }

        public function getMyBookings($user_id,$status='')
        {
            $this->db->select('b.booking_id,b.service_category_id,b.booking_category_id,b.booking_date,b.time_slot,b.no_of_hourse,b.select_mobility_aid,b.booking_status,b.booking_sub_status,b.service_provider_id
            ,s.service_name,s.service_image,s.service_app_image,u.full_name,u.user_id,u.profile_pic,u.mobile,pickup.address1 as pickup_location,drop.address1 as drop_location,pickup.address_lat as pickup_address_lat,pickup.address_lng as pickup_address_lng,drop.address_lat as drop_address_lat,drop.address_lng as drop_address_lng
            ,o.order_no,o.order_place_amt as amount,o.total_order_amount,o.offer_amount');
            $this->db->from(TBPREFIX.'service_booking as b');
            $this->db->join(TBPREFIX.'main_services as s','s.service_id=b.service_category_id','left');
            $this->db->join(TBPREFIX.'users as u','u.user_id=b.user_id','left');
            $this->db->join(TBPREFIX.'orders as o','o.booking_id=b.booking_id','left');
            $this->db->join(TBPREFIX.'adresses as pickup','pickup.address_id=b.pickup_address_id','left');
            $this->db->join(TBPREFIX.'adresses as drop','drop.address_id=b.drop_address_id','left');
            $this->db->where('b.user_id',$user_id);
            if($status!='')
            {
                $this->db->where('b.booking_status',$status);
            }
            else
            {
                $condition="b.booking_status IN('accepted','ongoing','completed')";
                $this->db->where($condition);
            }
            
            $res=$this->db->get();
            $tsr=$res->result_array();
            foreach($tsr as $key=>$booking)
            {
                if(isset($booking['service_image']) && $booking['service_image']!="")
                {
                    $booking['service_image']=base_url()."uploads/service_img/".$booking['service_image'];
                }
                if(isset($booking['service_app_image']) && $booking['service_app_image']!="")
                {
                    $booking['service_app_image']=base_url()."uploads/service_img/".$booking['service_app_image'];
                }
                $tsr[$key]=$booking;
            }
            return $tsr;
        }

        public function getBookingDetails($booking_id)
        {
            $this->db->select('b.booking_id,b.service_category_id,b.booking_date,b.time_slot,b.no_of_hourse,b.select_mobility_aid,b.booking_status,b.booking_sub_status,b.doctor_id,b.nurse_id,b.service_provider_id,
            b.pickup_address_id,b.drop_address_id,b.booking_category_id
            ,s.service_name,s.service_description,s.service_image,s.service_app_image,s.amount,b.user_id,u.full_name,u.mobile,u.profile_pic,u.profile_id,pickup.address1 as pickup_location,drop.address1 as drop_location,pickup.address_lat as pickup_address_lat,pickup.address_lng as pickup_address_lng,drop.address_lat as drop_address_lat,drop.address_lng as drop_address_lng
            ,o.order_no,o.total_order_amount,o.order_place_amt,o.offer_amount,o.offer_id,o.coupon_code,o.order_status,o.payment_type');
            $this->db->from(TBPREFIX.'service_booking as b');
            $this->db->join(TBPREFIX.'orders as o','o.booking_id=b.booking_id','left');
            $this->db->join(TBPREFIX.'main_services as s','s.service_id=b.service_category_id','left');
            $this->db->join(TBPREFIX.'users as u','u.user_id=b.user_id','left');
            $this->db->join(TBPREFIX.'adresses as pickup','pickup.address_id=b.pickup_address_id','left');
            $this->db->join(TBPREFIX.'adresses as drop','drop.address_id=b.drop_address_id','left');
            $this->db->where('b.booking_id',$booking_id);
            $res=$this->db->get();
            return $tsr=$res->row();
        }

        public function getOrderDetails($booking_id)
        {
            $this->db->select('*');
            $this->db->from(TBPREFIX.'orders');
            $this->db->where('booking_id',$booking_id);
            $res=$this->db->get();
            return $tsr=$res->row();
        }

        //get user booking slot exist
        public function getCheckTimeSlotBook($category_id,$doctor_id,$nurse_id,$chktime,$booking_date,$qty)
        {
            $this->db->select('*');
            $this->db->where(TBPREFIX.'service_booking.booking_status!=',"completed");
            $this->db->where(TBPREFIX.'service_booking.service_category_id',$category_id);
            $this->db->where(TBPREFIX.'service_booking.time_slot',$chktime);
            $this->db->where(TBPREFIX.'service_booking.booking_date',$booking_date);
            if($service_id=='3' && $doctor_id!="" && $doctor_id!="0")
            {
                $this->db->where(TBPREFIX.'service_booking.doctor_id',$doctor_id);
            }
            if($service_id=='4' && $nurse_id!="" && $nurse_id!="0")
            {
                $this->db->where(TBPREFIX.'service_booking.nurse_id',$nurse_id);
            }
            
            ///$this->db->join(TBPREFIX.'adresses',TBPREFIX.'adresses.user_id='.TBPREFIX.'adresses.user_id');
            $query=$this->db->get(TBPREFIX.'service_booking');

            if($qty==1)

                return $query->row_array();

            else

                return $query->num_rows();
        }

        public function getServiceDetails($service_id) 
        {
            if(!empty($service_id))
            {
                $this->db->select('s.service_id,s.service_name,s.service_app_image,s.service_image,s.service_description,s.amount');
                $this->db->from(TBPREFIX.'main_services as s');
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

        public function getUserDetails($user_id) 
        {
            if(!empty($user_id))
            {
                $this->db->select('*');
                $this->db->from(TBPREFIX.'users');
                $this->db->where('user_id',$user_id);
                // $this->db->where('user_type','Customer');
                $query = $this->db->get();
                $result= $query->row();
                if(isset($result->profile_pic) && $result->profile_pic!="")
                {
                    $result->profile_pic=base_url()."uploads/user/profile_photo/".$result->profile_pic;
                }
                return $result;
            }
        }

        public function getAllUser() 
        {
            $this->db->select('*');
            $this->db->from(TBPREFIX.'users');
            $this->db->where('status_flag','Active');
            $this->db->where('user_type','Service Provider');
            $this->db->where('service_type','Service Provider');
            $query = $this->db->get();
            $result= $query->result_array();
            foreach($result as $key=>$user)
            {
                if(isset($user->profile_pic) && $user->profile_pic!="")
                {
                    $user->profile_pic=base_url()."uploads/user/profile_photo/".$user->profile_pic;
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

        public function getMyratings($service_provider_id,$qty) 
        {
            if(!empty($service_provider_id))
            {
                $this->db->select('*');
                $this->db->from(TBPREFIX.'sp_reviews');
                $this->db->where('service_provider_id',$service_provider_id);
                $query = $this->db->get();
                if($qty==1)
                    return $query->result_array();
                else
                return $query->num_rows();
            }
        }

        public function checkreviewExist($user_id,$service_provider_id,$booking_id) 
        {
            $this->db->select('*');
            $this->db->from(TBPREFIX.'sp_reviews');
            $this->db->where('service_provider_id',$service_provider_id);
            $this->db->where('user_id',$user_id);
            $this->db->where('booking_id',$booking_id);
            $query = $this->db->get();
            return $query->num_rows();
        }

        function getnotifications($user_id)
        {
            $this->db->select('*');
            $this->db->from(TBPREFIX.'notification');
            $this->db->where('noti_user_id',$user_id);
            $this->db->where('noti_user_type','User');
            $this->db->order_by('noti_id','desc');
            $this->db->limit('50');
            return $result = $this->db->get()->result_array();
        }

        //code for add order transaction
  		public function addOrderTransaction($arrOrderData)
          {
              if($this->db->insert('loba_order_transaction',$arrOrderData))
              {
                  $orderId=$this->db->insert_id();
                  // $insertDAta=array('order_id'=>$orderId,'change_type'=>'user','change_status'=>'order_placed','change_date'=>date('Y-m-d'),'addedDate'=>date('Y-m-d H:i:s'));
                  // $this->db->insert('dseos_item_order_status',$insertDAta);
                  return $orderId;
              }
              
              else
                  return false;
          }

        public function getRatingPercentage($user_id)
        {
            $this->db->select('*');
            $this->db->from(TBPREFIX.'sp_reviews r');
            $this->db->where('r.service_provider_id',$user_id);
            return $result = $this->db->get()->result_array();
        }

        public function getReviews($user_id)
        {
            $this->db->select('r.*,u.user_id,u.full_name,u.profile_pic');
            $this->db->from(TBPREFIX.'sp_reviews r');
            $this->db->where('r.service_provider_id',$user_id);
            $this->db->join(TBPREFIX.'users as u','u.user_id =r.user_id','left');
            return $this->db->get()->result_array();			
            // if(!empty($reviews))
            // 	return $reviews;
            // else
            // 	return null;
        }
        
	}