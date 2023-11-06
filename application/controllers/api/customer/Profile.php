<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Profile extends REST_Controller {
 
	public function __construct()
    {
        parent::__construct();
		$this->load->model('ApiModels/customer/CustomerModel');
		$this->load->model('Common_Model');
	}
	
	public function signup_post()
	{
		$token 			= $this->input->post("token");
		$fullname		= $this->input->post("full_name");
		$mobile_number	= $this->input->post("mobile");
		$email_address	= $this->input->post("email");
		$password	= $this->input->post("password");
		
		if($token == TOKEN)
		{
			if($fullname=="" || $email_address == "" || $mobile_number == "" || $password == "") //$password == "" || $password!=$cpassword
			{
				$data['responsemessage'] = 'Please provide valid data';
				$data['responsecode'] = "400";
			}	
			else
			{
				$userExists = $this->CustomerModel->checkUserMobile($mobile_number);
				if($userExists>0)
				{	
					$data['responsemessage'] = 'User already exists';
					$data['responsecode'] = "402";
				}
				else
				{
					$profile_id="BHOOL-C-".$this->Common_Model->randomCode();
					// Random Number for OTP  
					$otp_code = $this->Common_Model->otp();
					
					$arrUserData = array(
							'profile_id' => $profile_id,
							'full_name'=>$fullname,
							'email'=>$email_address,
							'password'=>md5($password),
							'mobile'=>$mobile_number,
							'otp' => $otp_code,
							'user_type'=>'Customer',
							'status'=>'Active',
							'dateadded' => date('Y-m-d H:i:s')
							);
								  
					$user_id   = $this->Common_Model->insert_data('users',$arrUserData);
					//echo $this->db->last_query();
					$arrData = $this->CustomerModel->getUserDetails($user_id);
					// Send SMS
					$strMessage=urlencode("Dear user your CSNS Login OTP for LOBA is $otp_code");
					//$output=$this->Common_Model->SendSms($strMessage, $mobile_number);	
					
					$data['data'] = $arrData;
					$data['responsemessage'] = 'OTP send successfully';
					$data['responsecode'] = "200";
				}
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

	public function editprofile_post()
	{
		$token 			= $this->input->post("token");
		$user_id 		= $this->input->post("user_id");
		$fullname		= $this->input->post("full_name");
		$mobile_number	= $this->input->post("mobile");
		$email_address	= $this->input->post("email");
		
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
					'dateupdated' => date('Y-m-d H:i:s')
					);
						  
				$result   = $this->Common_Model->update_data('users','user_id',$user_id,$arrUserData);
				
				$arrData = $this->CustomerModel->getUserDetails($user_id);
				
				$data['data'] = $arrData;
				$data['responsemessage'] = 'User updated successfully';
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
				// $updatedata = array('mobile_code'=>'852','alt_mobile_code'=>'852');
					// $this->db->where('mobile_code','');
			  	// 	$this->db->update('loba_users',$updatedata);

				$arrData = $this->CustomerModel->getUserDetails($user_id);

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

	
}
