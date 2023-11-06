<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Category extends REST_Controller {
 
	public function __construct()
    {
        parent::__construct();
		$this->load->model('ApiModels/customer/CategoryModel');
		$this->load->model('Common_Model');
	}
	
	public function index_post()
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
                //$userdetails = $this->DashboardModel->getUserDetails($user_id);
				
				$categories = $this->CategoryModel->getAllCategories();
				
                $data['responsecode'] = "200";
                $data['data'] = $categories;
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
	
	public function details_post()
	{
		$token 			= $this->input->post("token");
		$user_id		= $this->input->post("user_id");
		$category_id	= $this->input->post("category_id");
		
		if($token == TOKEN)
		{
            if($user_id=="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            {
             	$categories = $this->CategoryModel->getCategoryDetails($category_id);
				
                $data['responsecode'] = "200";
                $data['data'] = $categories;
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
