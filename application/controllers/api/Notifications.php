<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Notifications extends REST_Controller {
 
	public function __construct()
    {
        parent::__construct();
		$this->load->model('Common_Model');
		$this->load->model('ApiModels/NotificationsModel');
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
				$arrNotifications = $this->NotificationsModel->getAllNotifications($userid);
				$data['responsecode'] = "200";
				$data['data'] = $arrNotifications;
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
}
