<?php
require(APPPATH.'/libraries/REST_Controller.php');
class Login extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        
        // Load the user model
        $this->load->model('ApiModels/User');
		$this->load->model('Common_Model');
    }
    
    public function index_post() {
        // Get the post data
       // echo "inside login api";exit();
        $token          = $this->input->post("token");
        $username = $this->input->post('username');
        $password = $this->input->post('password');
		$fcm_token = $this->input->post('fcm_token');
        //echo "<pre>";
        //print_r($_POST);exit();
        // Validate the post data
		$data = array();
        if($token == TOKEN)
        {
            if(!empty($username) && !empty($password)){
                
                // Check if any user exists with the given credentials
                $con['returnType'] = 'single';
                $con['conditions'] = array(
                    'username' => $username,
                    'password' => md5($password)
                );
                $user = $this->User->getRows($con);

                /*echo "<pre>";
                print_r($user);exit();*/
                
                if($user){
                    // Set the response and exit
                    $status=$user['status'];
                    //echo "Status--".$status;exit();
                    if($status== "Active"){
						$data['responsemessage'] = 'Logged in successfully';
						$data['responsecode'] = "200";
                        
						if($user['profile_pic'] != '')
						{
							$user['profile_pic'] = base_url()."uploads/user_profile/".$user['profile_pic'];
						}
						$user['daily_report'] = $user['daily_report'] == 'Yes' ? 'true' : 'false';
						
						//*** FCM Update */
						$fcmdata=array('fcm_token'=> $fcm_token);
						$this->Common_Model->updateData('users','userid',$user['userid'],$fcmdata);
						//*********** */
						
						$arrUserDetails = $this->User->getUserDetails($user['userid']);
						
						$data['data'] = $arrUserDetails;
                    }elseif ($status== "Deleted") {
                            $data['responsemessage'] = 'Your account is deleted';
							$data['responsecode'] = "408";
                    }elseif ($status== "Inactive") {
                            $data['responsemessage'] = 'Your account is inactive';
							$data['responsecode'] = "405";
                    }
                }
				else {
                    $data['responsemessage'] = 'Invalid username or password!';
					$data['responsecode'] = "406";
				}
            }
        }else{
            $data['responsecode'] = "201";
            $data['responsemessage'] = 'Token did not match';
        }
        $obj = (object)$data;//Creating Object from array
        $response = json_encode($obj);
        print_r($response);
    }

    
    public function update_post() {
        $id = $this->input->post('id');
       // echo "id--".$id;exit();
        
        // Get the post data
        $token = $this->input->post("token");
        $full_name = $this->input->post('full_name');
        $email_address = $this->input->post('email_address');
        $mobile_number =$this->input->post('mobile_number');
		        
        // Validate the post data

        if($token == TOKEN){
        	if(!empty($id)) 
        	{
        		$con['returnType'] = 'single';
                $con['conditions'] = array(
                    'userid' => $id
                );
                $user = $this->user->getRows($con);
                /*echo "<pre>";
                print_r($user);
                exit();*/
	            
                if($user){
	            // Update user's account data
		            $userData = array();
		            if(!empty($full_name)){
		                $userData['full_name'] = $full_name;
		            }
		          
		            if(!empty($email_address)){
		                $userData['email_address'] = $email_address;
		            }
		           
		            if(!empty($mobile_number)){
		                $userData['mobile_number'] = $mobile_number;
		            }
		            $update = $this->user->update($userData, $id);
		            
		            // Check if the user data is updated
		            if($update){
		                // Set the response and exit
		                $this->response([
		                    'responsecode' => 200,
		                    'responsemessage' => 'The user info has been updated successfully.'
		                ], REST_Controller::HTTP_OK);
		             }
		        }else{
		        	 $this->response([
                            'responsecode' => 406,
                            'responsemessage' => 'User id does not exist'
                        ], REST_Controller::HTTP_OK);

		        }
        	}else{
            	$response_array['responsecode'] = "201";
            	$response_array['responsemessage'] = 'Please provide user id to update';
            	$obj = (object)$response_array;//Creating Object from array
        		$response = json_encode($obj);
        		print_r($response);
        	}
        }else{
            $response_array['responsecode'] = "201";
            $response_array['responsemessage'] = 'Token did not match';
            $obj = (object)$response_array;//Creating Object from array
        		$response = json_encode($obj);
        		print_r($response);
        }
    }
	
	public function forgot_password_post()
	{
		$token 	= $this->input->post("token");
		$email	= $this->input->post('email_address');
		
		if($token == TOKEN)
		{
			$userExists = $this->User->chkUserEmailExists($email);
			
			if(!empty($userExists))
			{
				//$rnd_number=rand(pow(10, 5),pow(10, 6)-1);
				// Crate 4 Digit Random Number for OTP 
							
				//$rnd_number = "5678"; //default SMS
				$rnd_number = $this->Common_Model->otp();
				$updateData['otp_code'] = $rnd_number;
					
				$updateOtp 	= $this->Common_Model->updateData('users','userid',$userExists->userid,$updateData);
				$arrUserDetails = $this->User->getUserDetails($userExists->userid);
				//print_r($arrUserDetails);
				$arrUserDetails->daily_report = $arrUserDetails->daily_report == 'Yes' ? 'true' : 'false';
				
				//Send Mail
				$subject="Spaceloon Forgot Password OTP";
				$strMessage="Dear user your Forgot Password OTP for Spaceloon is ".$rnd_number;
				
				mail($email,$subject,$strMessage);

				$response_array['responsecode'] = "200";
				$response_array['responsemessage'] = 'OTP sent successfully.';
				$response_array['data'] = $arrUserDetails;
			}
			else
			{
				$response_array['responsecode'] = "405";
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
				$response_array['responsecode'] = '403';
				$response_array['responsemessage'] = 'Please provide valid data';
			}
			else 
			{
				$usersOtp = $this->User->checkOtp($email_address,$otp_code);
				
				if(!empty($usersOtp))
				{ 					
					$this->Common_Model->updateData('users','userid',$usersOtp->userid,array('otp_code'=>'','password'=>md5($password)));
					
					$arrUserDetails = $this->User->getUserDetails($usersOtp->userid);
					$arrUserDetails->daily_report = $arrUserDetails->daily_report == 'Yes' ? 'true' : 'false';
					$response_array['responsecode'] = "200";
					$response_array['responsemessage'] = 'Your password has been updated';
					
					$response_array['userDetails'] = $arrUserDetails;
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
}