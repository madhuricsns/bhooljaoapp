<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Profile extends REST_Controller {
 
	public function __construct()
    {
        parent::__construct();
		$this->load->model('ApiModels/sp/CustomerModel');
		$this->load->model('Common_Model');
	}
	
	public function editprofile_post()
	{
		$token 			= $this->input->post("token");
		$user_id 		= $this->input->post("user_id");
		$fullname		= $this->input->post("full_name");
		$mobile_number	= $this->input->post("mobile");
		$email_address	= $this->input->post("email");
		$address		= $this->input->post("address");
		
		if($token == TOKEN)
		{
			if($user_id =="" || $fullname=="" || $mobile_number==""  || $email_address=="")
			{
				$data['responsemessage'] = 'Please provide valid data';
				$data['responsecode'] = "400";
			}	
			else
			{
				$arrUserData = array(
					'full_name' => $fullname,
					'mobile' => $mobile_number,
					'email' => $email_address,
					'address' => $address,
					'dateupdated' => date('Y-m-d H:i:s')
					);
						  
				$result   = $this->Common_Model->update_data('users','user_id',$user_id,$arrUserData);
				
				$arrData = $this->CustomerModel->getUserDetails($user_id);
				
				$data['data'] = $arrData;
				$data['responsemessage'] = 'Profile updated successfully';
				$data['responsecode'] = "200";
			}
		}
		else
		{
			$data['responsemessage'] = 'Token not match';
			$data['responsecode'] =  "201";
		}	
		$obj = (object)$data;//Creating Object from array
		$response = json_encode($obj);
		print_r($response);
	}

	public function updateProfilephoto_post()
	{
		$token 			= $this->input->post("token");
		$user_id		= $this->input->post("user_id");
		
		if($token == TOKEN)
		{
			if($user_id=="" || $_FILES['profile_photo']['name']=="") 
			{
				$data['responsemessage'] = 'Please provide valid data';
				$data['responsecode'] = "400";
			}	
			else
			{
				 //Image Upload Code 
				 if(count($_FILES) > 0) 
				 {
					 $ImageName1 = "profile_photo";
					 $target_dir = "uploads/user_profile/";
					 $profile_pic= $this->Common_Model->ImageUpload($ImageName1,$target_dir);
				 }
				$arrUserData = array('profile_pic' => $profile_pic);
								
				$this->Common_Model->update_data('users','user_id',$user_id,$arrUserData);
				$arrData = $this->CustomerModel->getUserDetails($user_id);
				
				$data['data'] = $arrData;
				$data['responsemessage'] = 'Profile photo updated successfully';
				$data['responsecode'] = "200";
			}
		}
		else
		{
			$data['responsemessage'] = 'Token not match';
			$data['responsecode'] =  "201";
		}	
		$obj = (object)$data;//Creating Object from array
		$response = json_encode($obj);
		print_r($response);
	}
	
	public function userDetails_post()
	{
		$token 			= $this->input->post("token");
		$user_id			= $this->input->post("user_id");
		
		if($token == TOKEN)
		{
            if($user_id=="") 
			{
				$data['responsemessage'] = 'Please provide valid data';
				$data['responsecode'] = "400";
			}	
			else
			{
				$arrData = $this->CustomerModel->getUserDetails($user_id);
				if($arrData->category_id>0)
				{
					$category = $this->CustomerModel->getCategoryDetails($arrData->category_id);
					$arrData->service_name=$category->category_name;
				}
                $data['data'] = $arrData;
				$data['responsecode'] = "200";		
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
	
	public function sitepages_post()
	{
		$token 			= $this->input->post("token");
		$pagename		= $this->input->post("pagename");
				
		if($token == TOKEN)
		{
			$sitePage = $this->CustomerModel->getPageContent($pagename);
			
			$data['data'] = $sitePage;
			$data['responsecode'] = "200";
			$response_array=json_encode($data);						
		}
		else
		{
			$data['responsecode'] = "201";
			$response_array['responsemessage'] = 'Token did not match';
		}	
		print_r($response_array);
	}

	public function faqList_post()
	{
		$token 			= $this->input->post("token");
		$type		    = 'Customer';
				
		if($token == TOKEN)
		{
			$sitePage = $this->CustomerModel->getAllfaqList($type);
			// foreach($sitePage as $key=>$page)
			// {
			// 	$page['checked']='false';
			// 	$sitePage[$key]=$page;
			// }
			
			$data['data'] = $sitePage;
			$data['responsecode'] = "200";
			$response_array=json_encode($data);						
		}
		else
		{
			$data['responsecode'] = "201";
			$response_array['responsemessage'] = 'Token did not match';
		}	
		print_r($response_array);
	}

	public function serviceproviderDetails_post()
	{
		$token 			= $this->input->post("token");
		$user_id			= $this->input->post("service_provider_id");
		
		if($token == TOKEN)
		{
            if($user_id=="") 
			{
				$data['responsemessage'] = 'Please provide valid data';
				$data['responsecode'] = "400";
			}	
			else
			{
				$arrData = $this->CustomerModel->getServiceProviderDetails($user_id);
				$service = $this->CustomerModel->getAllServiceByCategoryId($arrData->category_id);
				$images=array();
				$services_images = $this->CustomerModel->getAllServiceImages($service->service_id);
				foreach($services_images as $image)
				{
					$images[]=$image['service_image'];
				}
                $data['data'] = $arrData;
                $data['ServiceImages'] = $images;
				$data['responsecode'] = "200";		
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
