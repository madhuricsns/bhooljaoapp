<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Dashboard extends REST_Controller {
 
	public function __construct()
    {
        parent::__construct();
		$this->load->model('ApiModels/customer/DashboardModel');
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
            /*if($user_id=="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            { */
                $userdetails = $this->DashboardModel->getUserDetails($user_id);
                if(!isset($userdetails->full_name))
				{
					$userdetails->full_name="";
				}
				if(!isset($userdetails->profile_pic))
				{
					$userdetails->profile_pic="";
				}
				if(!isset($userdetails->address))
				{
					$userdetails->address="";
				}
				if(!isset($userdetails->user_lat))
				{
					$userdetails->user_lat="";
				}
				

				$banners = $this->DashboardModel->getAllBanners();
				foreach($banners as $key=>$banner)
				{
					if($banner['banner_url']=="")
					{
						$banner['banner_url']="";
					}
					if($banner['banner_start_date']=="")
					{
						$banner['banner_start_date']="";
					}
					if($banner['banner_end_date']=="")
					{
						$banner['banner_end_date']="";
					}

					$banners[$key]=$banner;
				}
				$categories = $this->DashboardModel->getCategory($limit=6);

				$arrOngoingServices = $this->DashboardModel->ongoingServices($user_id);
				foreach($arrOngoingServices as $key=>$booking)
				{
					
					// Calculate Days
					$date1 = new DateTime($booking['booking_date']);
					$date1 = $date1->format('Y-m-d');
					
					$date2 = new DateTime($booking['expiry_date']);
					$date2 = $date2->format('Y-m-d');

					$date1=date_create($date1);
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

					$arrOngoingServices[$key]=$booking;
				}


				$arrServiceGivers = $this->DashboardModel->getNearByServiceGivers(3,$userLat,$userLong);
				foreach($arrServiceGivers as $key=>$sp)
				{
					$sp['total_rating']="120";
					$sp['rating_avg']="4.5";
					$sp['isVerified']=true;
					$sp['isFavourite']=false;
					if(!isset($sp['distance']))
					{
						$sp['distance']="";
					}
					if(!isset($sp['address']))
					{
						$sp['address']="";
					}
					if(!isset($sp['category_name']))
					{
						$sp['category_name']="";
					}
					if(!isset($sp['profile_pic']))
					{
						$sp['profile_pic']="";
					}

					$arrServiceGivers[$key]=$sp;
				}
				//print_r($arrServiceGivers);
                //$banners = $this->DashboardModel->getAllBanners();
               
                //$this->Common_Model->insert_data('banner',$inputArr);
                $data['responsecode'] = "200";
                $data['UserData'] = $userdetails;
                $data['Banners'] = $banners;
                $data['Categories'] = $categories;
				$data['OngoingServices'] = $arrOngoingServices;
                $data['NearByServiceGivers'] = $arrServiceGivers;
                //$data['banners'] = $banners;
            // }
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
