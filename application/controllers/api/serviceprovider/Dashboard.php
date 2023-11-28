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
                // $userdetails = $this->DashboardModel->getUserDetails($user_id);
				
				$assignedBooking = $this->DashboardModel->getAllBookings($user_id,'waiting',0);
				$ongoingBooking = $this->DashboardModel->getAllBookings($user_id,'ongoing',0);
				$completedBooking = $this->DashboardModel->getAllBookings($user_id,'completed',0);
				$demoBooking = $this->DashboardModel->getAllDemoBookings($user_id,0);

				$todayschedule = $this->DashboardModel->getAllBookings($user_id,'waiting',1);
				foreach($todayschedule as $key=>$booking)
				{
					// Calculate Days
					$date1 = new DateTime($booking['booking_date']);
					$date1 = $date1->format('Y-m-d');
					
					$date2 = new DateTime($booking['expiry_date']);
					$date2 = $date2->format('Y-m-d');

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

					$checkReport=$this->DashboardModel->checkTodayWorkHistory($booking['booking_id']);
					$booking['reportAvailable']=$checkReport;
					
					$todayschedule[$key]=$booking;
				}

				$demoschedule = $this->DashboardModel->getAllDemoBookings($user_id,1);

                $data['responsecode'] = "200";
                // $data['UserData'] = $userdetails;
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
