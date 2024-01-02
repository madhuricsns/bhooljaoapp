<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Dashboard extends REST_Controller {
 
	public function __construct()
    {
        parent::__construct();
		$this->load->model('ApiModels/sp/DashboardModel');
		$this->load->model('Common_Model');
	}
	
	public function index_post()
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
                $userdetails = $this->DashboardModel->getUserDetails($user_id);
				
				// Update booking status
				$this->DashboardModel->updateBookingStatus($user_id);
				$this->DashboardModel->updateGroupBookingStatus($user_id);
				$this->DashboardModel->updateDemoBookingStatus($user_id);
				
				$assignedBooking = $this->DashboardModel->getAllBookings($user_id,'waiting',0);
				// echo $this->db->last_query();
				$ongoingBooking = $this->DashboardModel->getAllBookings($user_id,'ongoing',0);
				$completedBooking = $this->DashboardModel->getAllBookings($user_id,'completed',0);
				$demoBooking = $this->DashboardModel->getAllDemoBookings($user_id,0);

				// $input=array('booking_status'=>'ongoing');
				// $this->Common_Model->update_data('booking','booking_id','202',$input);

				$todayschedule = $this->DashboardModel->getAllBookings($user_id,'ongoing',1);
				// echo $this->db->last_query();
				foreach($todayschedule as $key=>$booking)
				{
					$categoryData=$this->DashboardModel->getCategory($booking['category_id']);
					$main_category="";
					if($categoryData->category_parent_id!=0)
					{
						$category=$this->DashboardModel->getCategory($categoryData->category_parent_id);
						$category_id=$categoryData->category_parent_id;
						$main_category=$category->category_name;
						$booking['category_name']=$main_category."-".$booking['category_name'];
					}

					// Calculate Days
					$date1 = new DateTime($booking['booking_date']);
					$date1 = $date1->format('Y-m-d');
					
					
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
					if($booking['booking_date']<$today && $booking['is_demo']=='No')
					{
						$date1=date_create($today);
					}
					else{ $date1=date_create($date1);}
					$date2=date_create($date2);
					
					$interval = date_diff($date1, $date2); 
					$days  = $interval->format('%a days left'); 
					
					$booking_date = new DateTime($booking['booking_date']);
					// $booking_date = $booking_date->format('M d,Y');

					$booking['booking_date']=$booking_date->format('M d,Y');
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

					$checkReport=$this->DashboardModel->checkTodayWorkHistory($booking['booking_id']);
					$booking['reportAvailable']=$checkReport;
					
					$todayschedule[$key]=$booking;
				}

				$demoschedule = $this->DashboardModel->getAllDemoBookings($user_id,1);
				foreach($demoschedule as $k=>$demo)
				{
					$categoryData=$this->DashboardModel->getCategory($demo['category_id']);
					$main_category="";
					if($categoryData->category_parent_id!=0)
					{
						$category=$this->DashboardModel->getCategory($categoryData->category_parent_id);
						$category_id=$categoryData->category_parent_id;
						$main_category=$category->category_name;
						$demo['category_name']=$main_category."-".$demo['category_name'];
					}
					
					$checkReport=$this->DashboardModel->checkTodayWorkHistory($demo['booking_id']);
					$demo['reportAvailable']=$checkReport;
					
					$demoschedule[$k]=$demo;
				}

                $data['responsecode'] = "200";
                $data['data']['UserDetails'] = $userdetails;
                $data['data']['AssignedBooking'] = $assignedBooking;
                $data['data']['ongoingBooking'] = $ongoingBooking;
                $data['data']['completedBooking'] = $completedBooking;
                $data['data']['demoBooking'] = $demoBooking;
                $data['data']['TodaySchedule'] = $todayschedule;
				$data['data']['DemoSchedule'] = $demoschedule;
              
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
