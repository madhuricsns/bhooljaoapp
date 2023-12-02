<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Booking extends REST_Controller {
 
	public function __construct()
    {
        parent::__construct();
		$this->load->model('ApiModels/sp/BookingModel');
		$this->load->model('Common_Model');
	}
	
    public function myBooking_post()
	{
		$token 			= $this->input->post("token");
		$user_id		= $this->input->post("user_id");
		$status 		= $this->input->post("status");	
			
		if($token == TOKEN)
		{
            if($user_id=="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            { 
				if($status=='assigned')
				{
					$status='waiting';
				}
				$arrBooking = $this->BookingModel->getMyBookings($user_id,$status,1);
				
				foreach($arrBooking as $key=>$booking)
				{
					// Calculate Days
					$date1 = new DateTime($booking['booking_date']);
					$date1 = $date1->format('Y-m-d');
					
					// $date2 = new DateTime($booking['expiry_date']);
					// $date2 = $date2->format('Y-m-d');

					if($booking['expiry_date']!="" || $booking['expiry_date']!=null)
					{
						$date2 = new DateTime($booking['expiry_date']);
						$date2 = $date2->format('Y-m-d');
					}
					else
					{
						$date2="";
					}

					$today=date('Y-m-d');
					$date1=date_create($today);
					$date2=date_create($date2);
					
					$interval = date_diff($date1, $date2); 
					$days  = $interval->format('%a days left'); 
					
					$booking['booking_date']=$date1->format('M d,Y');
					$booking['expiry_date']=$date2->format('M d,Y');

					$booking['expiry_day']=$days;
					if(!isset($booking['full_name']))
					{
						$booking['full_name']="";
					}
					if(!isset($booking['profile_pic']))
					{
						$booking['profile_pic']="";
					}

					$checkReport=$this->BookingModel->checkTodayWorkHistory($booking['booking_id']);
					$booking['reportAvailable']=$checkReport;

					$arrBooking[$key]=$booking;
				}

                //$this->Common_Model->insert_data('banner',$inputArr);
                $data['responsecode'] = "200";
                // $data['UserData'] = $userdetails;
                $data['data'] = $arrBooking;
             }
		}
		else
		{
			$data['responsecode'] = "201";
			$data['responsemessage'] = 'Token did not match';
		}	
		$obj = (object)$data;//Creating Object from array
		$response = json_encode($obj);
		print_r($response);
	}

    public function bookingDetails_post()
	{
		$token 		= $this->input->post("token");
		$booking_id = $this->input->post("booking_id");
		$userLat = $this->input->post("userLat");
		$userLong = $this->input->post("userLong");
		if(!isset($userLat) && !isset($userLong))
		{
			$userLat=$userLong='';
		}
		if($token == TOKEN)
		{
            if($booking_id =="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            {
				// $inputData=array(
				// 	'booking_status'=>'completed'
				// );
				//  $this->Common_Model->update_data('booking','booking_id',$booking_id,$inputData);

				$arrBookingData = $this->BookingModel->getBookingData($booking_id,$userLat,$userLong);
				
					// Calculate Days
					$date1 = new DateTime($arrBookingData->booking_date);
					$date1 = $date1->format('Y-m-d');
					
					
					if($arrBookingData->expiry_date!="" || $arrBookingData->expiry_date!=null)
					{
						$date2 = new DateTime($arrBookingData->expiry_date);
						$date2 = $date2->format('Y-m-d');
					}
					else
					{
						$date2="";
					}

					$date1=date_create($date1);
					$date2=date_create($date2);
					
					$interval = date_diff($date1, $date2); 
					$days  = $interval->format('%a'); 
					$arrBookingData->booking_date=$date1->format('M d,Y');
					$arrBookingData->expiry_date=$date2->format('M d,Y');
					$arrBookingData->left_days=$days." days left";

					$checkReport=$this->BookingModel->checkTodayWorkHistory($booking_id);
					$arrBookingData->reportAvailable=$checkReport;

				
				// User details
				
                $sp=$this->BookingModel->getSPDetails($arrBookingData->user_id);
				
				$arrServiceDetails = $this->BookingModel->getServiceDetailsWOPricing($booking_id);
				if(empty($arrServiceDetails))
				{
					$arrServiceDetails = $this->BookingModel->getServiceDetailsInformation($booking_id);
				}
				$total = $admin_commision = $gst_percentage = $gst_amount = $coupon_amount = $coupon_percentage = 0;
				
                $data['responsecode'] = "200";
                $data['data']['BookingDetails'] = $arrBookingData;
                $data['data']['UserDetails'] = $sp;
                $data['data']['ServiceDetails'] = $arrServiceDetails;
				
			}
		}
		else
		{
			$data['responsecode'] = "201";
			$data['responsemessage'] = 'Token did not match';
		}	
		$obj = (object)$data;//Creating Object from array
		$response = json_encode($obj);
		print_r($response);
	}

	public function notifications_post()
	{
		$token 		= $this->input->post("token");
		$user_id = $this->input->post("user_id");
		
		if($token == TOKEN)
		{
            if($user_id =="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            {
				$arrNotifications = $this->BookingModel->getnotifications($user_id);
					
                $data['responsecode'] = "200";
                $data['data'] = $arrNotifications;
			}
		}
		else
		{
			$data['responsecode'] = "201";
			$data['responsemessage'] = 'Token did not match';
		}	
		$obj = (object)$data;//Creating Object from array
		$response = json_encode($obj);
		print_r($response);
	}

	public function workHistory_post()
	{
		$token 		= $this->input->post("token");
		$booking_id	= $this->input->post("booking_id");
				
		if($token == TOKEN)
		{
            if($booking_id=="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            {
				$bookingData = $this->BookingModel->getBookingDetails($booking_id);

                $arrWorkhistory = $this->BookingModel->getBookingWorkHistory($booking_id);
				foreach($arrWorkhistory as $key=>$history)
				{
					$history['history_date']=new DateTime($history['history_date']);
					$history['history_date']=$history['history_date']->format('d-m-Y');
					$arrWorkhistory[$key]=$history;
				}
				$user=$this->BookingModel->getSPDetails($bookingData->user_id);

				$data['responsecode'] = "200";
                $data['data']['bookingDetails']['order_no'] = $bookingData->order_no;
                $data['data']['bookingDetails']['booking_status'] = $bookingData->booking_status;
                $data['data']['UserDetails'] = $user;
                $data['data']['workHistory'] = $arrWorkhistory;
            }
		}
		else
		{
			$data['responsecode'] = "201";
			$data['responsemessage'] = 'Token did not match';
		}	
		$obj = (object)$data;//Creating Object from array
		$response = json_encode($obj);
		print_r($response);
	}

	public function todayWorkReport_post()
	{
		$token 		= $this->input->post("token");
		$booking_id	= $this->input->post("booking_id");
		$user_id	= $this->input->post("user_id");
		$workphoto1	= $this->input->post("workphoto1");
		$workphoto2	= $this->input->post("workphoto2");
				
		if($token == TOKEN)
		{
            if($booking_id=="" || $user_id=="" )
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            {
				 //Image Upload Code 
				 $workphoto1="";
				 if(count($_FILES) > 0) 
				 {
					 $ImageName1 = "workphoto1";
					 $target_dir = "uploads/work_history/";
					 $workphoto1= $this->Common_Model->ImageUpload($ImageName1,$target_dir);
				 }
				 $workphoto2="";
				 if(count($_FILES) > 0) 
				 {
					 $ImageName1 = "workphoto2";
					 $target_dir = "uploads/work_history/";
					 $workphoto2= $this->Common_Model->ImageUpload($ImageName1,$target_dir);
				 }

				date_default_timezone_set('Asia/Kolkata');
				// echo date('d-m-Y H:i');
				 $todayDate=date('Y-m-d H:i:s');

				 $todayTime = date('h:i A', strtotime($todayDate));

				 $arrInputData = array(
					'booking_id' => $booking_id,
					'history_date' => $todayDate,
					'history_time' => $todayTime,
					'work_photo1' => $workphoto1,
					'work_photo2' => $workphoto2
					);
								
				$this->Common_Model->insert_data('booking_history',$arrInputData);
					// echo $this->db->last_query();
				$data['responsecode'] = "200";
				$data['responsemessage'] = 'Todays report submit successfully';
                // $data['data'] = $arrWorkhistory;
            }
		}
		else
		{
			$data['responsecode'] = "201";
			$data['responsemessage'] = 'Token did not match';
		}	
		$obj = (object)$data;//Creating Object from array
		$response = json_encode($obj);
		print_r($response);
	}

	public function Reviews_post()
	{
		$token 		= $this->input->post("token");
		$user_id 	= $this->input->post("user_id");
		
		if($token == TOKEN)
		{
			if($user_id=="")
			{
				$response_array['responsecode'] = "400";
				$response_array['responsemessage'] = 'Please Provide valid data';
			}
			else
			{
				// Rating Percentage Code Start
				$rating_arr=array();
				$ratings=$this->BookingModel->getRatingPercentage($user_id);
				$star1=$star2=$star3=$star4=$star5=$rowCount=$average=$percent=0;
				foreach($ratings as $rating)
				{
					if($rating['rating']=='1')
					{
						$star1+=$rating['rating'];
					}
					if($rating['rating']=='2')
					{
						$star2+=$rating['rating'];
					}
					if($rating['rating']=='3')
					{
						$star3+=$rating['rating'];
					}
					if($rating['rating']=='4')
					{
						$star4+=$rating['rating'];
					}
					if($rating['rating']=='5')
					{
						$star5+=$rating['rating'];
					}
				}

				$tot_stars = $star1 + $star2 + $star3 + $star4 + $star5;
				$rowCount=count($ratings);

				if($tot_stars>0)
				{
					$average = $tot_stars/$rowCount;
				}
				$rating_arr['average']=$average;
				$rating_arr['total']=$rowCount;

				for ($i=1;$i<=5;++$i) 
				{
					$var = "star$i";
					$count = $$var;
					if($tot_stars>0)
					{
						$percent = $count * 100 / $tot_stars;
					}
					$rating_arr['star'.$i.'_total']=$count;
					$rating_arr['star'.$i.'_per']=round($percent);
				}

				$arrReviews=$this->BookingModel->getReviews($user_id);
				//echo $this->db->last_query();
				foreach($arrReviews as $key=>$review)
				{
					if(isset($review['profile_pic']) && $review['profile_pic']!="")
					{
						$review['profile_pic']=base_url()."uploads/user_profile/".$review['profile_pic'];
					} 
					
					$arrReviews[$key]=$review;
				}
				
				$response_array['responsecode'] = "200";
				$response_array['data']['Ratings'] = $rating_arr;
				$response_array['data']['Reviews'] = $arrReviews;
			}
		}
		else
		{
			$response_array['responsecode'] = "201";
			$response_array['responsemessage'] = 'Token did not match';
		}
		$obj = (object)$response_array;//Creating Object from array
		$response = json_encode($obj);
		print_r($response);
	}

	public function feedbackList_post()
	{
		$token 		= $this->input->post("token");
		$user_id = $this->input->post("user_id");
		
		if($token == TOKEN)
		{
            if($user_id =="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            {
				$arrFeedbacks = $this->BookingModel->getFeedbacks($user_id);
					
                $data['responsecode'] = "200";
                $data['data'] = $arrFeedbacks;
			}
		}
		else
		{
			$data['responsecode'] = "201";
			$data['responsemessage'] = 'Token did not match';
		}	
		$obj = (object)$data;//Creating Object from array
		$response = json_encode($obj);
		print_r($response);
	}

	public function newBooking_post()
	{
		$token 			= $this->input->post("token");
		$user_id		= $this->input->post("user_id");
		$userLat 		= $this->input->post("userLat");
		$userLong 		= $this->input->post("userLong");	
			
		if($token == TOKEN)
		{
            if($user_id=="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            { 
				// $inputData=array(
				// 	'address_id'=>'33'
				// );
				//  $this->Common_Model->update_data('booking','booking_id','171',$inputData);

				$arrBooking = $this->BookingModel->getNewBookings($user_id,$userLat,$userLong);
				
                $data['responsecode'] = "200";
                $data['data'] = $arrBooking;
             }
		}
		else
		{
			$data['responsecode'] = "201";
			$data['responsemessage'] = 'Token did not match';
		}	
		$obj = (object)$data;//Creating Object from array
		$response = json_encode($obj);
		print_r($response);
	}

	public function acceptBooking_post()
	{
		$token 					= $this->input->post("token");
		$user_id 				= $this->input->post("user_id");
		$booking_id 			= $this->input->post("booking_id");
				
		if($token == TOKEN)
		{
			if($booking_id=="" || $user_id=="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            {
				$inputData=array(
					'booking_id'=>$booking_id,
					'service_provider_id'=>$user_id,
					'dateadded'=>date('Y-m-d H:i:s')
				);

				$bookingExist=$this->BookingModel->checkAlreadyExist(0,$user_id,$booking_id);
				if($bookingExist==0)
				{
					$accepted_id=$this->Common_Model->insert_data('booking_accepted',$inputData);
				}
				// $arrFeedback = $this->BookingModel->getFeedback($feedback_id);
				
				$data['responsecode'] = "200";
				$data['responsemessage'] = 'New service accepted successfully';
			}
		}
		else
		{
			$data['responsecode'] = "201";
			$data['responsemessage'] = 'Token did not match';
		}	
		$obj = (object)$data;//Creating Object from array
		$response = json_encode($obj);
		print_r($response);
	}

	public function historyBooking_post()
	{
		$token 			= $this->input->post("token");
		$user_id		= $this->input->post("user_id");
		
		
		if($token == TOKEN)
		{
            if($user_id=="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            { 
				$arrBooking = $this->BookingModel->getacceptedBookings($user_id);
				
                $data['responsecode'] = "200";
                $data['data'] = $arrBooking;
             }
		}
		else
		{
			$data['responsecode'] = "201";
			$data['responsemessage'] = 'Token did not match';
		}	
		$obj = (object)$data;//Creating Object from array
		$response = json_encode($obj);
		print_r($response);
	}
}
