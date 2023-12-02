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
		$about		    = $this->input->post("about");
		$whatwedo		= $this->input->post("whatwedo");

		
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
					'about' => $about,
					'dateupdated' => date('Y-m-d H:i:s')
					);
						  
				$result   = $this->Common_Model->update_data('users','user_id',$user_id,$arrUserData);
				
				// $whatwedoArr=explode("+",$whatwedo);
				// print_r($whatwedo);
				$delete   = $this->CustomerModel->deleteWhatWeDo($user_id);
				foreach($whatwedo as $description)
				{
					$arrInputData = array(
						'service_provider_id' => $user_id,
						'description' => $description,
						'dateadded' => date('Y-m-d H:i:s')
						);
					$this->Common_Model->insert_data('sp_whatwedo',$arrInputData);	
				}
				$arrwhatweDoData = $this->CustomerModel->getUserWhatWeDo($user_id);
				// print_r($arrwhatweDoData);
				
					// Upload  Photos
					if(!empty($_FILES['photo_arr']) )
					{
						$deletephoto   = $this->CustomerModel->deletephoto($user_id);
					// echo "Image Upload";
						$imgCount=count($_FILES['photo_arr']['name']);
						for($i=0;$i<$imgCount;$i++)
						{
							$strDocName = "photo_arr";
							$_FILES['file']['name']     = $_FILES[$strDocName]['name'][$i]; 
							$_FILES['file']['type']     = $_FILES[$strDocName]['type'][$i]; 
							$_FILES['file']['tmp_name'] = $_FILES[$strDocName]['tmp_name'][$i]; 
							$_FILES['file']['error']    = $_FILES[$strDocName]['error'][$i]; 
							$_FILES['file']['size']     = $_FILES[$strDocName]['size'][$i]; 
							
							$photo='';
							$new_doc_name = "";
							$new_doc_name = date('YmdHis').$this->Common_Model->randomImageName();
							$target_dir="uploads/sp_photos/";
				
							$config = array(
									'upload_path' => $target_dir,
									'allowed_types' => "jpg|png|jpeg|pdf",
									'max_size' => "0", 
									'file_name' =>$new_doc_name
									);
							$this->load->library('upload', $config);
							$this->upload->initialize($config); 
							if($this->upload->do_upload('file'))
							{ 
								$docDetailArray = $this->upload->data();
								$photo =  $docDetailArray['file_name'];
							}
							else
							{
								echo $this->upload->display_errors();
							}
							if($_FILES[$strDocName]['error'][$i]==0)
							{ 
								$photo=$photo;
							}
							//echo $photo;
							$arrphotos = array(
								'service_provider_id' => $user_id,
								'photo' => $photo
								);    
	
							$this->Common_Model->insert_data('sp_photos',$arrphotos);
						}
						// $agencyphotos = true;
					}

				$arrData = $this->CustomerModel->getUserDetails($user_id);
				$arrData->WhatWeDo=$arrwhatweDoData;

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
				$arrPhotos = $this->CustomerModel->getPhotos($user_id);
				$photoArr=array();
				foreach($arrPhotos as $photo)
				{
					$photoArr[]=$photo['photo'];
				}

				$arrwhatweDoData = $this->CustomerModel->getUserWhatWeDo($user_id);
				$whatwedoArr=array();
				foreach($arrwhatweDoData as $description)
				{
					$whatwedoArr[]=$description['description'];
				}

				if($arrData->category_id>0)
				{
					$category = $this->CustomerModel->getCategoryDetails($arrData->category_id);
					$arrData->service_name=$category->category_name;
				}

				$arrData->WhatWeDo=$whatwedoArr;
				$arrData->photo=$photoArr;

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
