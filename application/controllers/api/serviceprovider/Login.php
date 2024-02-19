<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Login extends REST_Controller {
	
	public function __construct()
    {
        parent::__construct();
		$this->load->model('ApiModels/sp/LoginModel');
		$this->load->model('ApiModels/UserModel');
		$this->load->model('Common_Model');
	}
	
	public function login_post()
	{
		$token 		  = $this->input->post("token");
		$username	  = $this->input->post('username');
		$fcm		  = $this->input->post('user_fcm');
		$device_id	  = $this->input->post('device_id');
		$device_type  = $this->input->post('device_type');
		
		if($token == TOKEN)
		{
			$data = array('username' => $this->input->post('username'));
		
			$isLogin = $this->LoginModel->check_login($data);
		
			if ($isLogin > 0) 
			{
				$result = $this->LoginModel->chk_login($data,1);
				
				$status = $result->status;

				//*** FCM Update */
				// $fcmdata=array('fcm'=> $fcm);
				// $q=$this->Common_Model->update_data('user','userid',$result->userid,$fcmdata);
				//*********** */
				
				if($status == 'Active')
				{
					$zone = $this->LoginModel->getZoneBySP($result->zone_id);

					$session_data = array(
						'user_id' => $result->user_id,
						'full_name' => $result->full_name,
						'mobile' => $result->mobile,
						'email' => $result->email,
						'status' => $result->status,
						'zone_lat' => $zone->zone_lat,
						'zone_long' => $zone->zone_long
					);

					// Send OTP
					$otp_code = $this->Common_Model->otp();
					if($result->mobile=='8087877835' || $result->mobile=='8668766511')
					{
						$otp_code='1234';
					}
					$strMessage=urlencode("$otp_code is your OTP. Please do not share it with anybody. Panan Saathi Ventures");
					if($result->mobile!='8087877835' || $result->mobile!='8668766511')
					{
						$output=$this->Common_Model->SendSms($strMessage, $result->mobile);	
					}
					
					$response_array['OTP'] = $otp_code;

					//Send Email
					/*$Subject="Login OTP";
					$msg="OTP for your login is $otp_code . Do not share it with anyone.";
					$usermail=$this->Common_Model->SendMail($result->email,$msg,$Subject);*/

					//Send Email
					$dataArr['fullname']=$result->full_name;
					$dataArr['otp_code']=$otp_code;
					$Subject="Login OTP";
					$loginbody = $this->Common_Model->email_content('Login',$dataArr);
					$usermail=$this->Common_Model->SendMail($result->email,$loginbody,$Subject);

					//*** User Update */
					$last_login=date('Y-m-d H:i:s a');
					// $updatedata=array('user_fcm'=>$fcm,'otp'=>$otp_code);
					$updatedata=array('user_fcm'=>$fcm,'otp'=>$otp_code,'device_type'=>$device_type,'device_id'=>$device_id,'last_login'=>$last_login);
					$q=$this->Common_Model->update_data('users','user_id',$result->user_id,$updatedata);
					//*********** */
					//$this->session->set_userdata('logged_in', $session_data);

					// $title="Login OTP";
					// $message="OTP for your login is $otp_code . Do not share it with anyone.";
					// $output=$this->Common_Model->sendexponotification($title,$message,$result->user_fcm);


					$response_array['data'] = $session_data;
					$response_array['responsecode'] = "200";
					$response_array['responsemessage'] = 'OTP send successfully.';
				}
				else  if($status=='Inactive')
				{
					$response_array['responsecode'] = "402";
					$response_array['responsemessage'] = 'Your account is Inactive!';
				}
				else if($status=='Delete')
				{
					$response_array['responsecode'] = "402";
					$response_array['responsemessage'] = 'Your account is Deleted!';
				}
			}
			else
			{
				$response_array['responsecode'] = "402";
				$response_array['responsemessage'] = 'Invalid Mobile No';
				
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

	public function confirmotp_post()
	{
		$token 		  = $this->input->post("token");
		$user_id	  = $this->input->post('user_id');
		$otp          = $this->input->post('otp');
		
		if($token == TOKEN)
		{
			$data = array('user_id' => $this->input->post('user_id')
						,'otp' => $this->input->post('otp'));

			$isLogin = $this->LoginModel->check_user($user_id);
		//print_r($isLogin);
			if ($isLogin > 0) 
			{
				$loginData = $this->LoginModel->chk_otp($data,0);

				if ($loginData > 0) 
				{
					
					$result = $this->LoginModel->chk_otp($data,1);
					$zone = $this->LoginModel->getZoneBySP($result->zone_id);
						$session_data = array(
							'user_id' => $result->user_id,
							'full_name' => $result->full_name,
							'mobile' => $result->mobile,
							'email' => $result->email,
							'status' => $result->status,
							'zone_lat' => $zone->zone_lat,
							'zone_long' => $zone->zone_long);
						
						$response_array['data'] = $session_data;
						$response_array['responsecode'] = "200";
						$response_array['responsemessage'] = 'You are logged in successfully.';
				}
				else
				{
					$response_array['responsecode'] = "402";
					$response_array['responsemessage'] = 'OTP does not match !';
				}
			}
			else
			{
				$response_array['responsecode'] = "402";
				$response_array['responsemessage'] = 'Invalid User Id!';
				
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

	##### Mobile RESEND OTP ##### 
	public function resendOtp_post()
	{
		//date_default_timezone_set(DEFAULT_TIME_ZONE);	
		$token 		= $this->input->post("token");
		$username	= $this->input->post("mobile");
		
		if($token == TOKEN)
		{
			if(isset($username))
			{
				if($username=="")
				{
					$num = array(
						'responsemessage' => 'Please Provide Mobile Number.',
						'responsecode' => "400"
					); //create an array
					$obj = (object)$num;//Creating Object from array
					$response_array=json_encode($obj);
					print_r($response_array);
				}
				else
				{
					$users_username = $this->LoginModel->getuserDetails($username);
					// print_r($users_username);
					
					if(!empty($users_username))
					{
						$user_id 		= $users_username->user_id;
						//$rnd = "12345"; //default SMS
						$otp_code = $this->Common_Model->otp();
						if($username=='8087877835' || $username=='8668766511')
						{
							$otp_code='1234';
						}
						
						$updateData['otp'] 	= $otp_code;
						$this->Common_Model->update_Data('users','user_id',$user_id,$updateData);
						
						$strMessage=urlencode("$otp_code is your OTP. Please do not share it with anybody. Panan Saathi Ventures");
						if($username!='8087877835' || $username!='8668766511')
						{
							$output=$this->Common_Model->SendSms($strMessage, $username);
						}	

						//Send Email
						$dataArr['fullname']=$users_username->full_name;
						$dataArr['otp_code']=$otp_code;
						$Subject="Login OTP";
						$loginbody = $this->Common_Model->email_content('Login',$dataArr);
						$usermail=$this->Common_Model->SendMail($users_username->email,$loginbody,$Subject);
						
						$datas = array(
								'mobile'   	=> $username,
								'user_id' => $users_username->user_id,
								'otp' 	=> $updateData['otp'],
									);
						$data['data'] = $datas;
						$data['responsemessage'] = 'OTP Send Successfully';
						$data['responsecode'] = "200";
						$response_array=json_encode($data);
					}
					else
					{
						$num = array(
									'responsemessage' => 'User Not Available, please contact admin or register again.',
									'responsecode' => "402"
								); //create an array
						$obj = (object)$num;//Creating Object from array
						$response_array=json_encode($obj);
					}
					print_r($response_array);
				}
			}
		}
		else
		{
			$num = array(
							'responsemessage' => 'Token not match',
							'responsecode' => "201"
						); //create an array
			$obj = (object)$num;//Creating Object from array
			$response_array=json_encode($obj);
		}
	}
	
	public function logout_post()
	{
		$token 		= $this->input->post("token");
		
		if($token == TOKEN)
		{
			$response_array['responsecode'] = "200";
			$response_array['responsemessage'] = 'You are logged out successfully.';
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
	
	public function forgot_password_post()
	{
		$token 	= $this->input->post("token");
		$email	= $this->input->post('email');
		
		if($token == TOKEN)
		{
			$userExists=$this->LoginModel->chkUserEmailExists($email);
			
			if(!empty($userExists))
			{
				//$rnd_number=rand(pow(10, 5),pow(10, 6)-1);
				// Crate 4 Digit Random Number for OTP 
							
				//$rnd_number = "5678"; //default SMS
				$rnd_number = $this->Common_Model->otp();
				if($userExists->mobile=='8087877835' || $userExists->mobile=='8668766511')
				{
					$rnd_number='1234';
				}

				$updateData['otp'] 	= $rnd_number;
					
				$updateOtp 	= $this->Common_Model->update_data('users','user_id',$userExists->user_id,$updateData);
				$arrUserDetails = $this->CustomerModel->getUserDetails($userExists->user_id);
				//print_r($arrUserDetails);

				//Send Mail
				/*$subject="MSMED Forgot Password OTP";
				$strMessage="Dear user your Forgot Password OTP for MSMED is ".$rnd_number;
				$output=$this->Common_Model->SendMail($email,$strMessage,$subject);
				*/
				
				$response_array['responsecode'] = "200";
				$response_array['responsemessage'] = 'OTP sent successfully.';
				$response_array['data'] = $arrUserDetails;
			}
			else
			{
				$response_array['responsecode'] = "402";
				$response_array['responsemessage'] = 'Invalid email';
				
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
	
	
	public function reset_password_post()
	{
		$token 			=   $this->input->post("token");
		$email_address	=	$this->input->post('email');
		$otp_code		=	$this->input->post('otp');
		$password		=	$this->input->post('password');
		$cpassword		=	$this->input->post('cpassword');

		if($token == TOKEN)
		{
			if($email_address == "" || $otp_code == "" || $password == "" || $cpassword == "" || $password != $cpassword)
			{
				$response_array['responsecode'] = '400';
				$response_array['responsemessage'] = 'Please provide valid data';
			}
			else 
			{
				$userExists=$this->LoginModel->chkUserEmailExists($email_address);
			
				if(!empty($userExists))
				{
					$dataToVerify = array('user_id'=>$userExists->user_id,'otp'=>$otp_code);
					$usersOtp = $this->LoginModel->chk_otp($dataToVerify,1);
					
					if(!empty($usersOtp))
					{ 			
						$updateData['password'] = md5($password);
						$updateData['otp'] = '';
						$updateUser 	= $this->Common_Model->update_data('users','user_id',$usersOtp->user_id,$updateData);
						
						$arrUserDetails = $this->CustomerModel->getUserDetails($usersOtp->user_id);
						$response_array['responsecode'] = "200";
						$response_array['responsemessage'] = 'Your password has been updated';
						
						$response_array['userDetails'] = $arrUserDetails;
					}
					else  
					{
						$response_array['responsecode'] = "402";
						$response_array['responsemessage'] = 'OTP does not match.';
					}
				}
				else {
				$response_array['responsecode'] = "402";
				$response_array['responsemessage'] = 'Invalid email';
				
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
}
