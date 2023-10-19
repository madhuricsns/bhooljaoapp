<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Dashboard extends REST_Controller {
 
	public function __construct()
    {
        parent::__construct();
		$this->load->model('Common_Model');
		$this->load->model('ApiModels/DashboardModel');
		$this->load->model('Home_model');
	}
		
	public function index_post()
	{
		$token 			= $this->input->post("token");
		$userid			= $this->input->post("userid");
		
		if($token == TOKEN)
		{
			if(!isset($userid) || $userid=="")
			{
				$num = array('responsemessage' => 'Please provide user Id ',
					'responsecode' => "403"); //create an array
				$obj = (object)$num;//Creating Object from array
				$response_array=json_encode($obj);
			}
			else
			{
				// $this->Common_Model->delete_data('flights','flight_id','5');
				$arrBanners = $this->DashboardModel->getBanners();
				if(!empty($arrBanners))
				{
					foreach($arrBanners as $k=>$banner)
					{
						if($banner['banner_image'] != '')
						{
							$banner['banner_image'] = base_url()."uploads/banner_images/".$banner['banner_image'];
						}
						$arrBanners[$k]=$banner;
					}
				}
				
				$arrscheduledFlights = $this->DashboardModel->getscheduledFlights(5);
				foreach($arrscheduledFlights as $key=>$scheduled)
				{
					$scheduled['flight_time']= new DateTime($scheduled['flight_time']);
					$scheduled['flight_time']=$scheduled['flight_time']->format('H:i');
					
					$am_pm = date('H:i A', strtotime($scheduled['flight_time']));
					
					$scheduled['flight_time']=$am_pm;

					$record_available='No';
					$available = $this->DashboardModel->checkFlightRecords($scheduled['flight_id']);
					if($available>0)
					{
						$record_available='Yes';
					}
					$scheduled['record_available']=$record_available;
					$arrscheduledFlights[$key]=$scheduled;
				}
				$arrPastFlights = $this->DashboardModel->getPastFlights(5);
				foreach($arrPastFlights as $key=>$past)
				{
					$past['flight_time']= new DateTime($past['flight_time']);
					$past['flight_time']=$past['flight_time']->format('H:i');
					
					$am_pm = date('H:i A', strtotime($past['flight_time']));
					
					$past['flight_time']=$am_pm;
					$record_available='No';
					$available = $this->DashboardModel->checkFlightRecords($past['flight_id']);
					if($available>0)
					{
						$record_available='Yes';
					}
					$past['record_available']=$record_available;
					$arrPastFlights[$key]=$past;
				}

				$data['responsecode'] = "200";
				$data['data']['Banners'] = $arrBanners;
				$data['data']['scheduledFlights'] = $arrscheduledFlights;
				$data['data']['PastFlights'] = $arrPastFlights;
				
				//$data['data']['SpaceRecords'] = $this->DashboardModel->getSpaceRecords($pagination=false,$pageid='',$Offset='',$limit = 5);
			}
		}
		else
		{
			$data['responsecode'] = "201";
			$data['responsemessage'] = 'Token did not match';
		}	
		$response_array=json_encode($data);						
		print_r($response_array);
	}

	public function scheduledFlights_post()
	{
		$token 			= $this->input->post("token");
		$userid			= $this->input->post("userid");
		
		if($token == TOKEN)
		{
			if(!isset($userid) || $userid=="")
			{
				$data = array('responsemessage' => 'Please provide user Id ',
					'responsecode' => "403"); //create an array
				$obj = (object)$data;//Creating Object from array
				$response_array=json_encode($obj);
			}
			else
			{
				$arrscheduledFlights = $this->DashboardModel->getscheduledFlights();
				foreach($arrscheduledFlights as $key=>$scheduled)
				{
					$scheduled['flight_time']= new DateTime($scheduled['flight_time']);
					$scheduled['flight_time']=$scheduled['flight_time']->format('H:i');
					
					$am_pm = date('H:i A', strtotime($scheduled['flight_time']));
					
					$scheduled['flight_time']=$am_pm;

					$record_available='No';
					$available = $this->DashboardModel->checkFlightRecords($scheduled['flight_id']);
					if($available>0)
					{
						$record_available='Yes';
					}
					$scheduled['record_available']=$record_available;
					$arrscheduledFlights[$key]=$scheduled;
				}
				

				$data['responsecode'] = "200";
				$data['data'] = $arrscheduledFlights;
				
				//$data['data']['SpaceRecords'] = $this->DashboardModel->getSpaceRecords($pagination=false,$pageid='',$Offset='',$limit = 5);
			}
		}
		else
		{
			$data['responsecode'] = "201";
			$data['responsemessage'] = 'Token did not match';
		}	
		$response_array=json_encode($data);						
		print_r($response_array);
	}

	public function pastFlights_post()
	{
		$token 			= $this->input->post("token");
		$userid			= $this->input->post("userid");
		
		if($token == TOKEN)
		{
			if(!isset($userid) || $userid=="")
			{
				$data = array('responsemessage' => 'Please provide user Id ',
					'responsecode' => "403"); //create an array
				$obj = (object)$data;//Creating Object from array
				$response_array=json_encode($obj);
			}
			else
			{
				
				$arrPastFlights = $this->DashboardModel->getPastFlights();
				foreach($arrPastFlights as $key=>$past)
				{
					$past['flight_time']= new DateTime($past['flight_time']);
					$past['flight_time']=$past['flight_time']->format('H:i');
					
					$am_pm = date('H:i A', strtotime($past['flight_time']));
					
					$past['flight_time']=$am_pm;
					$record_available='No';
					$available = $this->DashboardModel->checkFlightRecords($past['flight_id']);
					if($available>0)
					{
						$record_available='Yes';
					}
					$past['record_available']=$record_available;
					$arrPastFlights[$key]=$past;
				}

				$data['responsecode'] = "200";
				$data['data'] = $arrPastFlights;
				
				//$data['data']['SpaceRecords'] = $this->DashboardModel->getSpaceRecords($pagination=false,$pageid='',$Offset='',$limit = 5);
			}
		}
		else
		{
			$data['responsecode'] = "201";
			$data['responsemessage'] = 'Token did not match';
		}	
		$response_array=json_encode($data);						
		print_r($response_array);
	}

	public function flightDetails_post()
	{
		$token 			= $this->input->post("token");
		$flight_id		= $this->input->post("flight_id");
		$userid			= $this->input->post("userid");
		
		if($token == TOKEN)
		{
			if(!isset($userid) || $userid=="" || $flight_id=="")
			{
				$data = array('responsemessage' => 'Please provide user Id ',
					'responsecode' => "403"); //create an array
				$obj = (object)$data;//Creating Object from array
				$response_array=json_encode($obj);
			}
			else
			{
				$data['responsecode'] = "200";
				$flight=$this->DashboardModel->getFlightDetails($flight_id);
				
					$flight->flight_time= new DateTime($flight->flight_time);
					$flight->flight_time=$flight->flight_time->format('H:i');
					
					$am_pm = date('H:i A', strtotime($flight->flight_time));
					
					$flight->flight_time=$am_pm;
				
				$spacerecords=$this->DashboardModel->getFlightRecords($flight_id,$pagination=false,$pageid='',$Offset='',$limit = 5);
				$data['data']['flight_details'] =$flight;
				$data['data']['SpaceRecords'] =$spacerecords;
			}
		}
		else
		{
			$data['responsecode'] = "201";
			$data['responsemessage'] = 'Token did not match';
		}	
		$response_array=json_encode($data);						
		print_r($response_array);
	}
	
	public function sendFeedback_post()
	{
		$token 			= $this->input->post("token");
		$userid 		= $this->input->post("userid");
		$feedback	 	= $this->input->post("feedback");
		
		if($token == TOKEN)
		{
			$arrFeedback = array(
							'userid' => $userid,
							'feedback_message' => $feedback
							);
							
			$feedback_id = $this->Common_Model->insert_data('feedback',$arrFeedback);
			
			$feedbackData = $this->DashboardModel->getFeedbackDetails($feedback_id);
			
			$data['responsecode'] = "200";
			$data['responsemessage'] = 'Feedback sent successfully..';
			$data['data'] = $feedbackData;
		}
		else
		{
			$data['responsecode'] = "201";
			$data['responsemessage'] = 'Token did not match';
		}	
		$response_array=json_encode($data);						
		print_r($response_array);
	}
}
