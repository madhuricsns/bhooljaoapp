<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

    class Common_Model extends CI_Model{

        public function __construct()
        {
			parent::__construct();
            $this->load->database();
        }
      
		function randomImageName($length = 4) {
			$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[random_int(0, $charactersLength - 1)];
			}
			return $randomString;
		}
		function randomPassword($length = 6) {
			$characters = '0123456789';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[random_int(0, $charactersLength - 1)];
			}
			return $randomString;
		}
		function randomCode($length = 4) {
			$characters = '0123456789';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[random_int(0, $charactersLength - 1)];
			}
			return $randomString;
		}
        function otp($length = 4) {
			$characters = '0123456789';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[random_int(0, $charactersLength - 1)];
			}
			// $randomString='1234';
			return $randomString;
		}
        function ImageUpload($imageName,$target_dir)
        {
            $photo="";
                $strDocName = $imageName;
                if (isset($_FILES[$strDocName]['name']) && $_FILES[$strDocName]['name'] != '') 
                {
                    $_FILES['file']['name']     = $_FILES[$strDocName]['name']; 
                    $_FILES['file']['type']     = $_FILES[$strDocName]['type']; 
                    $_FILES['file']['tmp_name'] = $_FILES[$strDocName]['tmp_name']; 
                    $_FILES['file']['error']     = $_FILES[$strDocName]['error']; 
                    $_FILES['file']['size']     = $_FILES[$strDocName]['size']; 
                    
                    $photo='';
                    $new_doc_name = "";
                    $new_doc_name = date('Ymd').$this->randomImageName();
                    
                    $config = array(
                            'upload_path' => $target_dir,
                            'allowed_types' => "jpg|png|jpeg|pdf",
                            'max_size' => "0", 
                            'file_name' =>$new_doc_name
                            );
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config); 
                    if($this->upload->do_upload($strDocName))
                    { 
                        $docDetailArray = $this->upload->data();
                        //echo "<pre>"; print_r($docDetailArray);	
                        $photo =  $docDetailArray['file_name'];
                    }
                    else
                    {
                        echo $this->upload->display_errors();
                    }
                    if($_FILES[$strDocName]['error']==0)
                    { 
                        $photo=$photo;
                    }
                }
            return $photo;
        }
		
		public function insert_data($tablename,$data)
		{
			if($this->db->insert(TBLPREFIX.$tablename,$data))
			{
				return $this->db->insert_id();
			}
			else
				return false;
		}
		
		public function update_data($tablename,$where,$id,$data = array()) 
		{
		  	if($id > 0) 
			{
		    	$this->db->where($where,$id);
			  	$res=$this->db->update(TBLPREFIX.$tablename,$data); 
				  if($res)
				  {
					  return true;
				  }
				  else
					  return false;
		  	}
		} 

        public function delete_data($tablename,$where,$id) 
		{
		  	if($id > 0) 
			{
		    	$this->db->where($where,$id);
			  	$this->db->delete(TBLPREFIX.$tablename); 
		  	}
		} 
	 
		public function distance($lat1, $lon1, $lat2, $lon2, $unit) 
		{
			if (($lat1 == $lat2) && ($lon1 == $lon2)) {
				return 0;
			}
			else 
			{
				$theta = $lon1 - $lon2;
				$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
				$dist = acos($dist);
				$dist = rad2deg($dist);
				$miles = $dist * 60 * 1.1515;
				$unit = strtoupper($unit);

				if ($unit == "K") {
				$distance= ($miles * 1.609344);
				return (round($distance,2));
				} else if ($unit == "N") {
				return ($miles * 0.8684);
				} else {
				return $miles;
				}
			}
		}

		//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "M") . " Miles<br>";
		//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "K") . " Kilometers<br>";
		//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "N") . " Nautical Miles<br>";
		
		### FUNCTION TO SEND SMS 
		public function SendSms($strMessage = "", $strMobile= "")
		{
			$strSenderName = "PANANS";
			$strMobile = $strMobile;

			//Template ID - 
			$templateid='1207170382400848768';

			//PE ID - 
			$peid='1201170317327391541';

			// $strUrl="http://sms.messageindia.in/v2/sendSMS?username=cyborgapi&message=$strMessage&sendername=MIRICR&smstype=TRANS&numbers=$strMobile&apikey=949776f6-b95e-4d74-944b-03d5bfc051da&peid=1201161527747662237&templateid=1207161760669839695";
			$strUrl="http://sms.messageindia.in/v2/sendSMS?username=pananapi&message=$strMessage&sendername=$strSenderName&smstype=TRANS&numbers=$strMobile&apikey=eeb6ad00-6d9e-4c52-8107-094a0308cff5&peid=$peid&templateid=$templateid";
			
			$curl 		 = curl_init() or die("Error"); 	
			//echo $strUrl;exit;	
			curl_setopt($curl, CURLOPT_URL, $strUrl);  // Web service for OTP sending 
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,1); 
			curl_setopt($curl, CURLOPT_HEADER, 0);
			$output = curl_exec($curl); 
			$info = curl_getinfo($curl);		
			$result=curl_close($curl);
			//print_r($curl);
			//exit;
			//echo $strUrl;
			//return $result;
			//echo "<pre> $strUrl ";
			//var_dump($output); //exit;
		}

		### FUNCTION TO SEND SMS WITH EMAIL
		function SendMail($userEmail,$strMessage,$subject)
		{
			// echo $userEmail;
			// $strSubjectMessage='checking mail';
			// $strMessage='this is testing mail';
			$strSubjectMessage=$subject;
			$strMessage=$strMessage;
		
			$ci = get_instance();
    
			require FCPATH .'vendor/sendgride/vendor/autoload.php';
			  //Dotenv::load(DIR);
			  $email = new \SendGrid\Mail\Mail(); 
			  $personalization1=new \SendGrid\Mail\Personalization();
		
			  $email->setFrom("panansathi@gmail.com", "Panan Sathi");
				// $email->setFrom("msmednsk@gmail.com", "msmed.csnsindia.com");
			  if(isset($strSubjectMessage))
			  {
				$email->setSubject($strSubjectMessage);
			  }
			   $personalization1->addTo(new SendGrid\Mail\To(trim($userEmail)));
			  //$email->addTo($userEmail);
			  //$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
			   $message ="<html><body><h4>".$strMessage."</h4></body></html>"; 
			   
			//   $message="<html><body></body></html>";
			 
			 
			 
			   //$ci->load->view('emails/'.$output_arr1['view_load'],$input_arr1,true);
			   $email->addContent(
					"text/html", $message
				  );
				  $email->addPersonalization($personalization1);
			//   $sendgrid = new \SendGrid('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');
			  $sendgrid = new \SendGrid('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');
			  
			  try {
				  $response = $sendgrid->send($email);
				//   print_r($response);
				  //print $response->statusCode() . "\n";
				  //print_r($response->headers());
				  //print $response->body() . "\n";
			  } catch (Exception $e) {
				  echo 'Caught exception: '. $e->getMessage() ."\n";
			  }
		}
		function sendexponotification($strTitle, $strMessage, $arrGcmID)
		{
			// $key = "ExponentPushToken[S7yeHjLJAT0CRkG3jatxQT]";
			// $userId = $arrGcmID[0];//'userId from your database';
			// $notification = ['title' => $strTitle,'body' => $strMessage];
			// try{
			// 	$expo = \ExponentPhpSDK\Expo::normalSetup();
			// 	$expo->notify($userId,$notification);//$userId from database
			// 	$status = 'success';
			// }catch(Exception $e){
			// 		$expo->subscribe($userId, $key); //$userId from database
			// 		$expo->notify($userId,$notification);
			// 		$status = 'new subscribtion';
			// }

			// echo $status;

			$payload = array(
				'title' => $strTitle,
				'to' => $arrGcmID,
				'sound' => 'default',
				'body' => $strMessage,
			);
		
			// $payload = array(
			// 	'to' => $arrGcmID[0],
			// 	'sound' => 'default',
			// 	'body' => 'hello',
			// );
					$curl = curl_init();
					
					curl_setopt_array($curl, array(
					CURLOPT_URL => "https://exp.host/--/api/v2/push/send",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS => json_encode($payload),
					CURLOPT_HTTPHEADER => array(
						"Accept: application/json",
						"Accept-Encoding: gzip, deflate",
						"Content-Type: application/json",
						"cache-control: no-cache",
						"host: exp.host"
					),
					));
					
					$response = curl_exec($curl);
					$err = curl_error($curl);
					curl_close($curl);
					//print_r($response);

				if ($err) {
				echo "cURL Error #:" . $err;
				} else {
				//echo $response;
				}
		}

		function SendNotification($strTitle, $strMessage, $arrGcmID) 
		{
			$msg = array(
					'message' => "$strMessage",
					'contentTitle' => "$strTitle", 
					'vibrate' => 1, 
					'sound' => 1
				);
				/*
				$fields = array(
								'registration_ids' => $arrGcmID,
								//'notification' 	   => array('title' => $strTitle, 'body' => $strMessage,'sound'=>'Default', 'data'=>$msg),
								'priority' 		   => 'high',
								'data' 			   => $msg,
								);
				*/
				$fields = array(
				'registration_ids' => $arrGcmID[0],
				'notification' => array('contentTitle' => $strTitle, 'body' => $strMessage,'sound'=>'Default', 'data'=>$msg),
				'priority' => 'high',
				'data' 			   => $msg,
				);		
				print_r($fields);
				exit;	
				//echo "<pre>"; print_r( $fields ); //die;
				// define('FIREBASE_API_KEY', 'AAAA8mbICJ8:APA91bFcnzwJJFAzAH3whFLXwMb0bN_Hfd3dBmug-09QY3nYEOM_zfWcJZzq3xP_0iRXTrhEVoVbMBo-3asGjYdL-G-RggBCR7qzDqgeCtP1jhJmNfOWP4LCC7Gzs-fLV3lP0MmuOlDQ');
				define('FIREBASE_API_KEY', 'AAAAxD6-Zx4:APA91bFE-XNt_iQ7CrpKZO9YzdsSleW8B7q5MfobLtEKECoeZ7zTgCgzxdPApytGZxnOnCB55ZFIIxSdPWk8wQ0aEqBHyfHLCQC6HTq8R73CTUlGDu0UWw4LMjNkYzU7P-V5YJnRf-ea');
				//define( 'FIREBASE_API_KEY', 'AIzaSyD3JzXow72jcze-PvQevko5KWNsgjLvuQ0' );
				//firebase server url to send the curl request
				$url = 'https://fcm.googleapis.com/fcm/send';
				//building headers for the request
				$headers = array(
					'Authorization: key=' . FIREBASE_API_KEY,
					'Content-Type: application/json'
				);
		
				//Initializing curl to open a connection
				$ch = curl_init();
		
				//Setting the curl url
				curl_setopt($ch, CURLOPT_URL, $url);
				
				//setting the method as post
				curl_setopt($ch, CURLOPT_POST, true);
		
				//adding headers 
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
				//disabling ssl support
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				
				#print json_encode($fields);
				//adding the fields in json format 
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		
				//finally executing the curl request 
				$result = curl_exec($ch);
				//var_dump($result); //exit;
				if ($result === FALSE) 
				{
					die('Curl failed: ' . curl_error($ch));
				}
				//Now close the connection
				curl_close($ch);
				//print_r($fields); 
				//print_r($result);//exit;	 
				//and return the result 
				return $result;
		}
		
		public function updateData($tablename,$where,$id,$data = array()) 
		{
		  	if($id > 0) 
			{
		    	$this->db->where($where,$id);
			  	$this->db->update(TBLPREFIX.$tablename,$data); 
		  	}
		} 
		function get_lat_long($address)
		{
			$arrReturn = array();
			if ($address != "")
			{	
				$address = str_replace(" ", "+", $address);
				$str="https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=AIzaSyB0-m0BRbw8AtbMAawt7YPC4hFKmAO2hBI"; 
				$json = file_get_contents($str);
				$json = json_decode($json);
				// echo "<pre>";
				// print_r($json);
				// exit;

				$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
				$long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
				$city = "";
				$state = "";
				$country = "";
				if(isset($json->{'results'}[0]->{'address_components'}[3]->{'long_name'}))
				{
					$city = $json->{'results'}[0]->{'address_components'}[3]->{'long_name'};
				}

				if(isset($json->{'results'}[0]->{'address_components'}[4]->{'long_name'}))
				{
					$state = $json->{'results'}[0]->{'address_components'}[3]->{'long_name'};
				}

				if(isset($json->{'results'}[0]->{'address_components'}[5]->{'long_name'}))
				{
					$country = $json->{'results'}[0]->{'address_components'}[3]->{'long_name'};
				}
				
				//$zipcode = $json->{'results'}[0]->{'address_components'}[6]->{'long_name'};
				
				
				$arrReturn['latitude'] = $lat;
				$arrReturn['longitude'] = $long;
				$arrReturn['city'] = $city;
				$arrReturn['state'] = $state;
				$arrReturn['country'] = $country;
				//$arrReturn['zipcode'] = $zipcode; //exit;
				//return $lat.','.$long;	
			}
			return $arrReturn;
		}

		public function adminSetting($res)
        {
            $this->db->select('*');
            $this->db->from(TBLPREFIX.'admin_settings');
            if($res==1)
            {
                $result=$this->db->get()->result_array();
            }
            else
            {
                $result=$this->db->get()->num_rows();
            }
            return  $result;
        }

		function encrypt($plainText,$key)
		{
			$key = hex2bin(md5($key));
			$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
			$openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
			$encryptedText = bin2hex($openMode);
			return $encryptedText;
		}

		function decrypt($encryptedText,$key)
		{
			$key = hex2bin(md5($key));
			$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
			$encryptedText = hex2bin($encryptedText);
			$decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
			return $decryptedText;
		}

		function email_content($mailtype,$data)
		{
			if($mailtype=='Signup')
			{
				$body = $this->load->view('emailtemplate/signup_success',$data,true);
			}
			else if($mailtype=='Login')
			{
				$body = $this->load->view('emailtemplate/signup_otp',$data,true);
			}
			else if($mailtype=='Booking')
			{
				$body = $this->load->view('emailtemplate/bookingplaced',$data,true);
			}
			else if($mailtype=='BookingCancel')
			{
				$body = $this->load->view('emailtemplate/bookingCanceled',$data,true);
			}
			else if($mailtype=='Payment')
			{
				$body = $this->load->view('emailtemplate/payment',$data,true);
			}
			
			return $body;
		}
		
		
    }
?>