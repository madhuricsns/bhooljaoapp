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
				$input_data=array(
					'option_label'=>'Why choose us',
					'option_name'=>'Detail-oriented',
					'option_amount'=>'0',
					'service_id'=>'1',
					'option_type'=>'Information'
				);
				$insert_id=$this->Common_Model->insert_data('service_details',$input_data);

				// $this->db->where('option_label',"");
				// $this->db->where('service_id',"2");
			  	// $this->db->delete(TBLPREFIX.'service_details');
             	// $categories = $this->CategoryModel->getCategoryDetails($category_id);
             	$services = $this->CategoryModel->getAllServiceByCategoryId($category_id);
				foreach($services as $key=>$service)
				{
					$services_details = $this->CategoryModel->getAllServiceDetails($service['service_id']);
					// echo $this->db->last_query();
					$service['labels']=$services_details;
					
					foreach($services_details as $k=>$option)
					{
						$option_details = $this->CategoryModel->getAllServiceDetailOptions($option['service_id'],$option['option_type']);
						// echo $this->db->last_query();
						if($option['option_type']=='Dropdown' || $option['option_type']=='Information')
						{
							$option['options']=$option_details;
						}
						else 
						{
							$option['options']="";
						}	
						$service['labels'][$k]=$option;
					}
					$services[$key]=$service;
					
				}
                $data['responsecode'] = "200";
                $data['data'] = $services;
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

	public function addonserviceList_post()
	{
		$token 			= $this->input->post("token");
		$user_id		= $this->input->post("user_id");
		$service_id	    = $this->input->post("service_id");
		
		if($token == TOKEN)
		{
            if($user_id=="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            {
				
             	$addonservices = $this->CategoryModel->getAllAddonServices($service_id);
				foreach($addonservices as $key=>$service)
				{
					$services_details = $this->CategoryModel->getAllServiceDetails($service['service_id']);
					// echo $this->db->last_query();
					$service['labels']=$services_details;
					
					// foreach($services_details as $k=>$option)
					// {
					// 	$option_details = $this->CategoryModel->getAllServiceDetailOptions($option['service_id'],$option['option_type']);
					// 	// echo $this->db->last_query();
					// 	if($option['option_type']=='Dropdown' || $option['option_type']=='Information')
					// 	{
					// 		$option['options']=$option_details;
					// 	}
					// 	else 
					// 	{
					// 		$option['options']="";
					// 	}	
					// 	$service['labels'][$k]=$option;
					// }
					$services[$key]=$service;
					
				}
                $data['responsecode'] = "200";
                $data['data'] = $addonservices;
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
