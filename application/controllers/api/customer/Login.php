<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Login extends REST_Controller {
	
	public function __construct()
    {
        parent::__construct();
		$this->load->model('ApiModels/customer/LoginModel');
		$this->load->model('ApiModels/UserModel');
		$this->load->model('Common_Model');
	}
	
	public function login_post()
	{
		$token 		  = $this->input->post("token");
		$username	  = $this->input->post('username');
		$fcm		  = $this->input->post('fcm');
		
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
				// $q=$this->Common_Model->update_data('users','userid',$result->userid,$fcmdata);
				//*********** */
				
				if($status == 'Active')
				{
					$session_data = array(
						'user_id' => $result->user_id,
						'full_name' => $result->full_name,
						'mobile' => $result->mobile,
						'email' => $result->email,
						'status' => $result->status);

					// Send OTP
					$otp_code = $this->Common_Model->otp();
					$strMessage=urlencode("Dear user your CSNS Login OTP for LOBA is $otp_code");
					$output=$this->Common_Model->SendSms($strMessage, $result->mobile);	
					$response_array['OTP'] = $otp_code;

					//Send Email
					$Subject="Login OTP";
					$msg="OTP for your login is $otp_code . Do not share it with anyone.";
					$usermail=$this->Common_Model->SendMail($result->email,$msg,$Subject);

					//*** User Update */
					$updatedata=array('user_fcm'=>$fcm,'otp'=>$otp_code);
					$q=$this->Common_Model->update_data('users','user_id',$result->user_id,$updatedata);
					//*********** */
					//$this->session->set_userdata('logged_in', $session_data);
					$response_array['data'] = $session_data;
					$response_array['responsecode'] = "200";
					$response_array['responsemessage'] = 'OTP send successfully.';
				}
				else  if($status=='Inactive')
				{
					$response_array['responsecode'] = "402";
					$response_array['responsemessage'] = 'Your account is Inactive!';
				}
				else if($status=='Deleted')
				{
					$response_array['responsecode'] = "402";
					$response_array['responsemessage'] = 'Your account is Deleted!';
				}
			}
			else
			{
				$response_array['responsecode'] = "402";
				$response_array['responsemessage'] = 'Invalid Username!';
				
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
 					
						$session_data = array(
							'user_id' => $result->user_id,
							'full_name' => $result->full_name,
							'mobile' => $result->mobile,
							'email' => $result->email,
							'status' => $result->status);
						
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
		$username	= $this->input->post("username");
		
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
					//print_r($users_username);
					
					if(!empty($users_username))
					{
						$user_id 		= $users_username->user_id;
						//$rnd = "12345"; //default SMS
						$otp_code = $this->Common_Model->otp();
						if($this->input->post("print") == 1)
						{
							//print_r($users_username); exit;
						}		
						
						$updateData['otp'] 	= $otp_code;
						$this->Common_Model->update_Data('users','user_id',$user_id,$updateData);
						
						$strMessage=urlencode("Dear user your CSNS Login OTP for LOBA is $otp_code");
						//$output=$this->Common_Model->SendSms($strMessage, $username);	
						
						$datas = array(
								'mobile_number'   	=> $username,
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
		$email	= $this->input->post('email_address');
		
		if($token == TOKEN)
		{
			$userExists=$this->LoginModel->chkUserEmailExists($email);
			
			if(!empty($userExists))
			{
				//$rnd_number=rand(pow(10, 5),pow(10, 6)-1);
				// Crate 4 Digit Random Number for OTP 
							
				//$rnd_number = "5678"; //default SMS
				$rnd_number = $this->Common_Model->otp();
				$updateData['confirm_otp'] 	= $rnd_number;
					
				$updateOtp 	= $this->UserModel->updateData('users','userid',$userExists->userid,$updateData);
				$arrUserDetails = $this->UserModel->getUserDetails($userExists->userid);
				//print_r($arrUserDetails);

				//Send Mail
				$subject="MSMED Forgot Password OTP";
				$strMessage="Dear user your Forgot Password OTP for MSMED is ".$rnd_number;
				$output=$this->Common_Model->SendMail($email,$strMessage,$subject);

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
		$email_address	=	$this->input->post('email_address');
		$otp_code		=	$this->input->post('otp_code');
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
				$usersOtp = $this->UserModel->checkOtp($email_address,$otp_code);
				
				if(!empty($usersOtp))
				{ 					
					$arrUserDetails = $this->UserModel->getUserDetails($usersOtp->userid);
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
