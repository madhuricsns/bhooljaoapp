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
        function otp($length = 4) {
			$characters = '0123456789';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[random_int(0, $charactersLength - 1)];
			}
			//$randomString='1234';
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
			$strUserName = "shramapi";
			$strMobile = $strMobile;

			//Template ID - 
			$templateid='1207162288297684013';

			//Entity ID - 
			$entityid='1201162246168290922';

			//$key="http://sms.messageindia.in/v2/sendSMS?username=shramapi&message=XXXXXXXXXX&sendername=XYZ&smstype=TRANS&numbers=";
			//mobile_numbers>&apikey=32cce567-656c-40bd-80e6-9319e7128f1b&peid=XXXXXX&templateid=XXXXXX
			//echo $entityid;
			//http://sms.messageindia.in/v2/sendSMS?username=shramapi&message=Dear%20user%20your%20CSNS%20Login%20OTP%20for%20MSMED%20is%201234&sendername=CSNSIN&smstype=TRANS&numbers=9527482493&apikey=32cce567-656c-40bd-80e6-9319e7128f1b&peid=1201162246168290922&templateid=1207162288297684013
			//$strUrl = "http://sms.messageindia.in/v2/sendSMS?username=$strUserName&message=$strMessage&sendername=CSNSIN&smstype=TRANS&numbers=$strMobile&apikey=32cce567-656c-40bd-80e6-9319e7128f1b&peid=$entityid&templateid=$templateid";
			// echo $strUrl;
			$strUrl="http://sms.messageindia.in/v2/sendSMS?username=shramapi&message=$strMessage&sendername=CSNSIN&smstype=TRANS&numbers=$strMobile&apikey=32cce567-656c-40bd-80e6-9319e7128f1b&peid=1201162246168290922&templateid=1207162288297684013";
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
			//$strSubjectMessage='checking mail';
			//$strMessage='this is testing mail';
			$strSubjectMessage=$subject;
			$strMessage=$strMessage;
		
			$ci = get_instance();
    
			require FCPATH .'vendor/sendgride/vendor/autoload.php';
			  //Dotenv::load(DIR);
			  $email = new \SendGrid\Mail\Mail(); 
			  $personalization1=new \SendGrid\Mail\Personalization();
		
			  $email->setFrom("msmednsk@gmail.com", "msmed.csnsindia.com");
			  if(isset($strSubjectMessage))
			  {
				$email->setSubject($strSubjectMessage);
			  }
			   $personalization1->addTo(new SendGrid\Mail\To(trim($userEmail)));
			  //$email->addTo($userEmail);
			  //$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
			   $message ="<html><body><h4>".$strMessage."</h4></body></html>"; //$ci->load->view('emails/'.$output_arr1['view_load'],$input_arr1,true);
			   $email->addContent(
					"text/html", $message
				  );
				  $email->addPersonalization($personalization1);
			  $sendgrid = new \SendGrid('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');
			  try {
				  $response = $sendgrid->send($email);
				  //print_r($response);
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
				define('FIREBASE_API_KEY', 'AAAA8mbICJ8:APA91bFcnzwJJFAzAH3whFLXwMb0bN_Hfd3dBmug-09QY3nYEOM_zfWcJZzq3xP_0iRXTrhEVoVbMBo-3asGjYdL-G-RggBCR7qzDqgeCtP1jhJmNfOWP4LCC7Gzs-fLV3lP0MmuOlDQ');
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
		
		
    }
?>