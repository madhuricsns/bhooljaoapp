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
				foreach($categories as $key=>$category)
				{
					$subcategories = $this->CategoryModel->getAllSubCategories(0,$category['category_id']);
					$category['isSubcategoryAvailable']=false;
					if($subcategories>0)
					{
						$category['isSubcategoryAvailable']=true;
					}
					$categories[$key]=$category;
				}
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

	public function subcategoryList_post()
	{
		$token 			= $this->input->post("token");
		$user_id		= $this->input->post("user_id");
		$category_id	= $this->input->post("category_id");
		
		if($token == TOKEN)
		{
            if($category_id=="" || $category_id==0)
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            {
				$subcategories = $this->CategoryModel->getAllSubCategories(1,$category_id);
                $data['responsecode'] = "200";
                $data['data'] = $subcategories;
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
				
				$service = $this->CategoryModel->getAllServiceByCategoryId($category_id);

				//  $allservice = $this->CategoryModel->getServiceDetails($service->service_id);
				//  print_r($allservice);
				// foreach($services as $key=>$service)
				// {
					$images=array();
					$services_images = $this->CategoryModel->getAllServiceImages($service->service_id);
					foreach($services_images as $image)
					{
						$images[]=$image['service_image'];
					}
					$services_details = $this->CategoryModel->getAllServiceDetails($service->service_id);
					$Vehicle_details = $this->CategoryModel->getAllVehicleDetails($service->service_id);
					$whychooseus = $this->CategoryModel->whyChooseus($service->service_id);
					$main_category_id=$category_id;
					$categoryData=$this->CategoryModel->getCategory($category_id);
					if($categoryData->category_parent_id!=0)
					{
						$category=$this->CategoryModel->getCategory($categoryData->category_parent_id);
						$main_category_id=$categoryData->category_parent_id;
					}
					$arrReviews = $this->CategoryModel->getReviewByCategory($main_category_id);

					// print_r($arrReviews);
					// echo $this->db->last_query();
					$star1=$star2=$star3=$star4=$star5=$rowCount=$average=$percent=0;
					foreach($arrReviews as $rating)
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
					$rowCount=count($arrReviews);
					if($tot_stars>0)
					{
						$average = $tot_stars/$rowCount;
					}
					$service->rating_avg=number_format($average,1);
					$service->total_rating=$rowCount;
					// $service->rating_avg="4.6";
					// $service->total_rating="120";

					$service->addonServiceAvailable=false;
					$checkAVailable = $this->CategoryModel->checkAddonServicesAvailable($service->service_id);
					if($checkAVailable>0)
					{
						$service->addonServiceAvailable=true;
					}

					$service->ServiceImages=$images;
					$service->VehicleDetails=$Vehicle_details;
					$service->labels=$services_details;
					foreach($services_details as $k=>$option)
					{
						$option_details = $this->CategoryModel->getAllServiceDetailOptions($option['service_id'],$option['option_type'],$option['option_label']);
						// echo $this->db->last_query();
						if($option['option_type']=='Dropdown')
						{
							$option['options']=$option_details;
						}
						else 
						{
							$option['options']="";
						}	
						$service->labels[$k]=$option;
					}
					$whychooseus_arr=array();
					
					foreach($whychooseus as $key=>$chooseus)
					{
						$whychooseus_arr[]=$chooseus['option_name'];
					}
					$service->whychooseus=$whychooseus_arr;
					// $services[$key]=$service;
					
				// }
                $data['responsecode'] = "200";
                $data['data'] = $service;
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

	public function selectedaddonserviceList_post()
	{
		$token 			= $this->input->post("token");
		$user_id		= $this->input->post("user_id");
		$service_ids_arr	    = $this->input->post("service_ids_arr");
		
		if($token == TOKEN)
		{
            if(!isset($user_id) || !isset($service_ids_arr))
            {
                $data['responsemessage'] = 'Please provide Parameter  ';
                $data['responsecode'] = "400"; //create an array
            }
			else if($user_id=="" || $service_ids_arr=="" )
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            {
				// $input_data=array(
				// 	'option_label'=>'Enter no of Persons',
				// 	'option_name'=>'',
				// 	'option_amount'=>'',
				// 	'service_id'=>'3',
				// 	'option_type'=>'Input'
				// );

				// $insert_id=$this->Common_Model->insert_data('service_details',$input_data);
				// $this->Common_Model->update_data('booking_details','order_id','3',$input_data);

				// $input_data=array(
				// 	'category_id'=>'1',
				// 	'parent_service_id'=>'1',
				// 	'service_name'=>'Bathroom Cleaning',
				// 	'service_description'=>'Bathroom Cleaning description',
				// 	'service_price'=>'3000',
				// 	'service_discount_price'=>'2400',
				// 	'offer_percentage'=>'20'
				// );
				// $insert_id=$this->Common_Model->insert_data('service',$input_data);

             	$addonservices = $this->CategoryModel->getSelectedAddonServices($service_ids_arr);
				// print_r($addonservices);
				foreach($addonservices as $key=>$service)
				{
					$services_details = $this->CategoryModel->getAllServiceDetails($service['service_id']);
					// echo $this->db->last_query();
					$service['labels']=$services_details;
					
					foreach($services_details as $k=>$option)
					{
						$option_details = $this->CategoryModel->getAllServiceDetailOptions($option['service_id'],$option['option_type'],$option['option_label']);
						// echo $this->db->last_query();
						if($option['option_type']=='Dropdown')
						{
							$option['options']=$option_details;
						}
						else 
						{
							$option['options']="";
						}	
						$service['labels'][$k]=$option;
					}
					$addonservices[$key]=$service;
					
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
