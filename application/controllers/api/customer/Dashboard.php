<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Dashboard extends REST_Controller {
 
	public function __construct()
    {
        parent::__construct();
		$this->load->model('ApiModels/customer/DashboardModel');
		$this->load->model('Common_Model');
	}
	
	public function dashboard_post()
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
                $userdetails = $this->DashboardModel->getUserDetails($user_id);
                $banners = $this->DashboardModel->getAllBanners();
               
                //$this->Common_Model->insert_data('banner',$inputArr);
                $data['responsecode'] = "200";
                $data['data'] = $userdetails;
                $data['banners'] = $banners;
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
