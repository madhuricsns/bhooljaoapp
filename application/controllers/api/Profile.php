<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Profile extends REST_Controller {
 
	public function __construct()
    {
        parent::__construct();
		$this->load->model('ApiModels/User');
		$this->load->model('Common_Model');
	}
	
	public function change_password_post()
	{
		$token 			= $this->input->post("token");
		$userid			= $this->input->post('userid');
		$oldpassword	= $this->input->post("oldpassword");
		$password		= $this->input->post("password");
		$cpassword		= $this->input->post("cpassword");
		
		if($token == TOKEN)
		{
			if($userid == "" || $oldpassword == "" || $password == "" || $password!=$cpassword)
			{
				$response_array['responsemessage'] = 'Please provide valid data';
				$response_array['responsecode'] = "403";
			}	
			else
			{
				$arrUserDetails = $this->User->getUserDetails($userid);
				//echo "old: ".md5($oldpassword)."DB: ".$arrUserDetails->password;
				if(md5($oldpassword) === $arrUserDetails->password)
				{
					$updateData['password'] = md5($password);
					$updateUser 	= $this->Common_Model->updateData('users','userid',$userid,$updateData);
					$arrUserDetails = $this->User->getUserDetails($userid);
					$arrUserDetails->daily_report = $arrUserDetails->daily_report == 'Yes' ? 'true' : 'false';
					//print_r($arrUserDetails);
					$response_array['responsecode'] = "200";
					$response_array['responsemessage'] = 'Password changed successfully.';
					$response_array['data'] = $arrUserDetails;
				}
				else {
					$response_array['responsecode'] = "405";
					$response_array['responsemessage'] = 'Wrong old password!';
				}
			}
		}
		else
		{
			$response_array['responsecode'] = "201";
			$response_array['responsemessage'] = 'Token did not match';
		}
		$obj = (object)$response_array;//Creating Object from array
		$response = json_encode($obj);
		print_r($response);
	}
	
	public function update_post()
	{
		$token 			= $this->input->post("token");
		$userid 		= $this->input->post("userid");
		$full_name		= $this->input->post("full_name");
		$mobile_number	= $this->input->post("mobile_number");
		$email_address	= $this->input->post("email_address");
		
		if($token == TOKEN)
		{
			if($userid =="")
			{
				$data['responsemessage'] = 'Please provide valid data';
				$data['responsecode'] = "403";
			}	
			else
			{
				if (isset($_FILES['photo']['name']) && $_FILES['photo']['name'] != '') 
				{
					$ImageName = "photo";
					$target_dir = "uploads/user_profile/";
					$photo= $this->Common_Model->ImageUpload($ImageName,$target_dir);
					
					$this->Common_Model->updateData('users','userid',$userid,array('profile_pic'=>$photo));
				
					unset($_FILES['file']['name']);
					$docDetailArray = array();
					$document = "";
				}
				
				$arrUserData = array(
									'full_name' => $full_name,
									'mobile_number' => $mobile_number,
									'email_address' => $email_address,
									'dateupdated' => date('Y-m-d H:i:s')
								  );
						  
				$result   = $this->Common_Model->updateData('users','userid',$userid,$arrUserData);
				
				$arrProfile = $this->User->getProfile($userid);
				if($arrProfile->profile_pic != '')
				{
					$arrProfile->profile_pic = base_url()."uploads/user_profile/".$arrProfile->profile_pic;
				}
				$arrProfile->daily_report = $arrProfile->daily_report == 'Yes' ? 'true' : 'false';
				$data['data'] = $arrProfile;
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
	
	public function index_post()
	{
		$token 			= $this->input->post("token");
		$userid			= $this->input->post("userid");
		
		if($token == TOKEN)
		{
			$arrProfile = $this->User->getProfile($userid);
			if($arrProfile->profile_pic != '')
			{
				$arrProfile->profile_pic = base_url()."uploads/user_profile/".$arrProfile->profile_pic;
			}
			$arrProfile->daily_report = $arrProfile->daily_report == 'Yes' ? 'true' : 'false';
            $data['data'] = $arrProfile;
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
	
	public function verifyOtp_post()
	{
		$email_address	= $this->input->post("email_address");
		$otp_code	= $this->input->post("otp_code");			 
		$token 		= $this->input->post("token");
		
		$response_array = array();
								
		if($token == TOKEN)
		{
			if($email_address == "")
			{
				$response_array['responsecode'] = '403';
				$response_array['responsemessage'] = 'Enter Email';
			}
			else if($otp_code == "")
			{
				$response_array['responsecode'] = '403';
				$response_array['responsemessage'] = 'Enter OTP';
			}
			else 
			{
				$usersOtp = $this->UserModel->checkOtp($email_address,$otp_code);

				if(!empty($usersOtp))
				{ 					
					$arrUserDetails = $this->UserModel->getUserDetails($usersOtp->userid);
					$this->UserModel->updateData('users','userid',$arrUserDetails->userid,array('otp_verified'=>'Yes', 'status'=>'Active'));
					$response_array['responsecode'] = "200";
					$response_array['responsemessage'] = 'OTP has been verified.';
					$response_array['data'] = $arrUserDetails;
				}
				else  
				{
					$response_array['responsecode'] = "401";
					$response_array['responsemessage'] = 'OTP does not match.';
				}
			}
		}
		else
		{
			$response_array['responsecode'] = "201";
			$response_array['responsemessage'] = 'Token did not match';
		}
		
		$obj = (object)$response_array;//Creating Object from array
		$response = json_encode($obj);
		print_r($response);
	}
	
	public function resendOtp_post()
	{
		$token 			= $this->input->post("token");
		$email_address 	= $this->input->post("email_address");
		
		$response_array = array();
								
		if($token == TOKEN)
		{
			if($email_address == "")
			{
				$response_array['responsecode'] = '403';
				$response_array['responsemessage'] = 'Enter Email';
			}
			else 
			{
				$checkAccount = $this->UserModel->validateUser($email_address);
				
				if(!empty($checkAccount))
				{
					//$rnd=rand(pow(10, 3),pow(10, 4)-1);
					//$rnd = "1234";
					$rnd = $this->Common_Model->otp();
					$updateData['confirm_otp'] 	= $rnd;
					
					$updateOtp 	= $this->UserModel->updateData('users','userid',$checkAccount->userid,$updateData);
					$arrUserDetails = $this->UserModel->getUserDetails($checkAccount->userid);
					
					//Send Mail
					$subject="MSMED Resend OTP";
					$strMessage="Dear user resend OTP for MSMED is ".$rnd;
					$output=$this->Common_Model->SendMail($email_address,$strMessage,$subject);

					$response_array['responsecode'] = "200";
					$response_array['responsemessage'] = 'OTP sent successfully.';
					$response_array['data'] = $arrUserDetails;
				}
				else
				{
					$response_array['responsemessage'] = 'Invalid Email';
					$response_array['responsecode'] = "405";
				}
			}
		}
		else
		{
			$response_array['responsecode'] = "201";
			$response_array['responsemessage'] = 'Token did not match';
		}
		
		$obj = (object)$response_array;//Creating Object from array
		$response = json_encode($obj);
		print_r($response);
	}
	
	public function sitepages_post()
	{
		$token 			= $this->input->post("token");
		$pagename		= $this->input->post("pagename");
		$type		= $this->input->post("type");
				
		if($token == TOKEN)
		{
			if($pagename=='faq')
			{
				if($type=="")
				{
					$num = array('responsemessage' => 'Please provide valid data ',
					'responsecode' => "403"); //create an array
					$sitePage = (object)$num;//Creating Object from array
					//$response_array=json_encode($obj);
				}
				else
				{
					$sitePage = $this->UserModel->getAllfaqList($type);
					foreach($sitePage as $key=>$page)
					{
						$page['checked']='false';
						$sitePage[$key]=$page;
					}
				}
			}
			else
			{
				$sitePage = $this->UserModel->getPageContent($pagename);
			}
			
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
