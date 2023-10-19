<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	function __construct()
    {
		// Call the Model constructor
        //$this->load->library('email');
		date_default_timezone_set('Asia/Kolkata');
    }
// ------------------------------------------------------------------------

/**
 * Common Functions Helpers
 * 
 * 
 * @author		CSNS
 * 
 */

// ------------------------------------------------------------------------
function convertsectomin($iSeconds){   $min = intval($iSeconds / 60);    return $min;  /* return $min . ':' . str_pad(($iSeconds % 60), 2, '0', STR_PAD_LEFT); */}

if ( ! function_exists('get_lat_long'))
{
	function get_lat_long($address)
	{
		$arrReturn = array();
		if ($address != "")
		{	
			$address = str_replace(" ", "+", $address);
			$str="https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=AIzaSyD7CJZzaVXcO18AfuhbZkKzw7P2MKuivm8"; 
			$json = file_get_contents($str);
			$json = json_decode($json);

			$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
			$long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
			
			$city = $json->{'results'}[0]->{'address_components'}[3]->{'long_name'};
			$state = $json->{'results'}[0]->{'address_components'}[4]->{'long_name'};
			$country = $json->{'results'}[0]->{'address_components'}[5]->{'long_name'};
			$zipcode = $json->{'results'}[0]->{'address_components'}[6]->{'long_name'};
			 
			
			$arrReturn['latitude'] = $lat;
			$arrReturn['longitude'] = $long;
			$arrReturn['city'] = $city;
			$arrReturn['state'] = $state;
			$arrReturn['country'] = $country;
			$arrReturn['zipcode'] = $zipcode; //exit;
			//return $lat.','.$long;	
		}
		return $arrReturn;
	}
}

function getSellingPrice($rst_id,$item_price)
{
	$ci=& get_instance();
    $ci->load->database(); 


    $sql = "select * from dseos_restaurant  where rst_id='" . $rst_id . "'";
		$queryItems = $ci->db->query($sql);

		 
		if ($queryItems->num_rows() > 0) 
		{
			$reqItemInfo = $queryItems->row_array();
			$selling_price=0;
			if(isset($reqItemInfo) && count($reqItemInfo)>0)
			{
					$commission_type=$reqItemInfo['rst_commission_type'];
					$commission_amt=(float)$reqItemInfo['rst_commission_amt'];



					if($commission_type=="Percentage" && $commission_amt>0)
					{
						//$selling_price1=($item_price/100)*$commission_amt;
						$selling_price1=($item_price*$commission_amt)/100;
						$selling_price=$selling_price1+$item_price;

					}
					else
					{
						$selling_price=$item_price+$commission_amt;
					}
			}
			return $selling_price;
		}

	//echo $sucess;exit;
	
}
function languageConversion($translate_text,$target)
{
	$apiKey = 'AIzaSyAt7o6V5RlTQLWlKjfgwjOgaOhOBSNop0w';
	$text = $translate_text;
 	$url = 'https://www.googleapis.com/language/translate/v2?key='.$apiKey.'&q='. rawurlencode($text).'&source=en&target='.$target;

	$handle = curl_init($url);
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($handle);
	$responseDecoded = json_decode($response, true);
	$responseCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);      //Here we fetch the HTTP response code
	curl_close($handle);
		$sucess="";
	if($responseCode != 200) 
	{
		$sucess="";
		//echo 'Fetching translation failed! Server response code:' . $responseCode . '<br>';
		//echo 'Error description: ' . $responseDecoded['error']['errors'][0]['message'];
	}
	else 
	{
		$sucess= $responseDecoded['data']['translations'][0]['translatedText'];
		
		//echo 'Source: ' . $text . '<br>';
		
		//echo 'Translation: ' . $responseDecoded['data']['translations'][0]['translatedText'];
		//echo "<pre>";print_r($responseDecoded);
		
	}
	
	//echo $sucess;exit;
	return $sucess;
}

function get_address_from_latlong($address)
	{
		//$arrReturn = array();
		$arrReturn = '';
		if ($address != "")
		{	
			$address = str_replace(" ", "+", $address);
			$str="https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=AIzaSyD7CJZzaVXcO18AfuhbZkKzw7P2MKuivm8"; 
			$json = file_get_contents($str);
			$json = json_decode($json);

			$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
			$long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
			
			$address = $json->{'results'}[0]->{'formatted_address'};
			
			$city = $json->{'results'}[0]->{'address_components'}[3]->{'long_name'};
			$state = $json->{'results'}[0]->{'address_components'}[4]->{'long_name'};
			$country = $json->{'results'}[0]->{'address_components'}[5]->{'long_name'};
			$zipcode = $json->{'results'}[0]->{'address_components'}[6]->{'long_name'};
			 
			$arrReturn =$address; 
			//$arrReturn['latitude'] = $lat;
			//$arrReturn['longitude'] = $long;
			//$arrReturn['address'] = $address;
			//$arrReturn['city'] = $city;
			//$arrReturn['state'] = $state;
			//$arrReturn['country'] = $country;
			//$arrReturn['zipcode'] = $zipcode; //exit;
			//return $lat.','.$long;	
		}
		return $arrReturn;
	}
	
function create_thumb($width,$height,$file_path)
	{
		$ci = get_instance();
		$ci->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = $file_path; 
		$config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $width;
        $config['height'] = $height;
        $config['new_image'] = $file_path;               
        $ci->image_lib->initialize($config);
        if(!$ci->image_lib->resize())
        { 
            echo $ci->image_lib->display_errors();exit;
        }     
	}
	function fnSendEmail($strMessage, $user_email,$strSubjectMessage)
	{
		$config = array();
		$config['useragent']           = "CodeIgniter";
		$config['mailpath']            = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
		$config['protocol']            = "smtp";
		$config['smtp_host']           = "localhost";
		$config['smtp_port']           = "25";
		$config['mailtype'] 		   = 'html';
		$config['charset']  		   = 'utf-8';
		$config['newline']  		   = "\r\n";
		$config['wordwrap'] 		   = TRUE;
		$ci = get_instance();
		
		$ci->load->library('email');
						
		
			//echo $message;exit;

	
			$ci->load->library('email', $config);
			$ci->email->set_newline("\r\n");  
			$ci->email->initialize($config);
			//$ci->email->from('sales@nashikproperty.com','NashikProperty.com');
			$ci->email->from('support@deseos.com','deseos.com');
			$ci->email->to($user_email); 
			//$this->email->to("shantilal@nashikproperty.com"); 
			$ci->email->subject($strSubjectMessage);
			$ci->email->message($strMessage); 
			$ci->email->send();
	}
 	function smt_send_mail($userEmail,$output_arr,$input_arr)
	{
		
		$ci = get_instance();
		
		$config = array();
		$config['useragent']           = "CodeIgniter";
		$config['mailpath']            = "/usr/bin/sendmail"; 
		$config['protocol']            = "smtp";
		$config['smtp_host']           = "localhost";
		$config['smtp_port']           = "25";
		$config['mailtype'] 		   = 'html';
		$config['charset']  		   = 'utf-8';
		$config['newline']  		   = "\r\n";
		$config['wordwrap'] 		   = TRUE;
		
		$ci->load->library('email', $config);		
		$ci->email->initialize($config);
		$ci->email->set_newline("\r\n");  
		$ci->email->from('support@deseos.com','deseos.com');
		$ci->email->to($userEmail); 
		if(isset($input_arr['subject_mail']))
		{
			$ci->email->subject($input_arr['subject_mail']);
		}
		$message = $ci->load->view('emails/'.$output_arr['view_load'],$input_arr,true);
				
		$ci->email->message($message); 
		$str_email=$ci->email->send();				
						
		#$ci->email->initialize($config);
		#$ci->email->set_newline("\r\n");  
		#$ci->email->from($input_arr['admin_email'],'');
		#$ci->email->to($userEmail); 		 
		#$ci->email->subject($input_arr['subject_mail']);
		
		#$ci->email->message($mesg);
		//
		#$str_email=$ci->email->send();
		//print_r($ci->email);exit;
		if($str_email)
		{
			  return true;
		}
		else
		{
			//print_r($ci->email);echo $str_email;exit;
			return false;
		}
	}
	### FUNCTION TO SEND SMS 
	function fnSendSms($strMessage = "", $strMobile= "")
	{ 
		return "";
		
		/*require FCPATH . '/vendor/twilio/sdk/src/Twilio/autoload.php';
		$strMessage = urldecode($strMessage);
		$sid    = "ACab1c190bff294800a40bdb614ca41eb1"; 
		$token  = "c303995b4ab79b3700bd0b09e8192430"; 
		try{		 
			$client = new Twilio\Rest\Client($sid, $token);		 
			$message = $client->messages 
                  ->create("$strMobile", // to 
                           array(  
                               "messagingServiceSid" => "MG3cf04f373a46d44e3e6b39a8e3d67496",      
                               "body" => "$strMessage" 
                           ) 
                  );
		  return $message->sid;
		}
		catch(exception $e){
			return "";
		}*/
		
	}
	### FUNCTION TO SEND SMS 
	function fnSendSmsTTTTTT($strMessage = "", $strMobile= "")
	{
		return "";	
		#$strUserName = "SHTECH03";
		#$strPassword = "SHTECH123";
		#$strSenderId = "OTPMSG"; 
		#$strUrl = "http://49.50.67.32/smsapi/httpapi.jsp?username=$strUserName&password=$strPassword&from=$strSenderId&to=$strMobile&text=$strMessage";
		
		$strUserName = "kreedak";
		$strPassword = "kreedak";
		$strSenderId = "KREEDO";
		#$strSenderId = "KREDAK";
		$strMobile = $strMobile;
		$strUrl = "http://sms.indiatext.in/api/mt/SendSMS?user=$strUserName&password=$strUserName&senderid=$strSenderId&channel=Trans&DCS=0&flashsms=0&number=$strMobile&text=$strMessage&route=32";
		
		$curl 		 = curl_init() or die("Error"); 		
		curl_setopt($curl, CURLOPT_URL, $strUrl);  // Web service for OTP sending 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,1); 
		curl_setopt($curl, CURLOPT_HEADER, 0);
		$output = curl_exec($curl); 
		$info = curl_getinfo($curl);		
		curl_close($curl);
		#echo "<pre> $strUrl ";var_dump($output); exit;
	}
	
	### FUNCTION TO SEND SMS WITH EMAIL
	function fnSENDSmSEmail($strMessage = "", $strMobile= "",$userEmail="",$output_arr,$input_arr)
	{
		$strUserName = "cyborgsy";
		$strPassword = "cyborg123";
		$strSenderId = "KREDAK";
		$strMobile = $strMobile;
		 
		$strUrl = "http://49.50.67.32/smsapi/httpapi.jsp?username=$strUserName&password=$strPassword&from=$strSenderId&to=$strMobile&text=$strMessage"; 
	
		$curl 		 = curl_init() or die("Error"); 		
		curl_setopt($curl, CURLOPT_URL, $strUrl);  // Web service for OTP sending 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,1); 
		curl_setopt($curl, CURLOPT_HEADER, 0);
		$output = curl_exec($curl); 
		$info = curl_getinfo($curl);		
		curl_close($curl);
		echo "<pre>";var_dump($output); exit;
		
		$ci = get_instance();
		$config = Array('protocol' => 'smtp',
								'smtp_host' => 'csns.co.in',
								'smtp_port' => 587,
								'smtp_user' => 'rahul@csns.co.in',
								'smtp_pass' => 'csns123$',
								'mailtype'  => 'html', 
								'charset'   => 'iso-8859-1'
								);
					
		$ci->email->set_newline("\r\n");  
		$ci->email->initialize($config);
		$ci->email->from('mayur@csns.co.in','Kreedak');//$input_arr['admin_email']
		$ci->email->to($userEmail); 		 
		$ci->email->subject($input_arr['subject_mail']);
		
		$mesg = $ci->load->view('email/'.$output_arr['view_load'],$input_arr,true);
		
		$ci->email->message($mesg);
		//
		$str_email=$ci->email->send();
		print_r($ci->email);exit;
		if($str_email)
		{
			  return true;
		}
		else
		{
			//print_r($this->email);echo $str;exit;
			return false;
		}
	}
	
	
	//Common pagination
	//Function for common pagination code
   	function commonPagination($base = '',$count_user = '',$uri = '')
   	{
    	$config = array();
        $config["base_url"] = $base;
        $config["total_rows"] = $count_user;

    	// Number of items you intend to show per page.
        $config["per_page"] = 10;

        //Set that how many number of pages you want to view.
        if(!empty($uri)) {
        	$config["uri_segment"] = $uri;
        }
        else {
        	$config["uri_segment"] = 3;
        }
        // Open tag for CURRENT link.
        $config['cur_tag_open'] = '&nbsp;<a class="current">';

        // Close tag for CURRENT link.
        $config['cur_tag_close'] = '</a>';

        // By clicking on performing NEXT pagination.
        $config['next_link'] = 'Next';

        // By clicking on performing PREVIOUS pagination.
        $config['prev_link'] = 'Previous';

        return $config;
  	}

  	function fnchecktoken($agent_id, $login_token)
	{
		$CI =& get_instance();
        $CI->db->from('tb_users');
        $CI->db->where('id',$agent_id);
        $CI->db->where('login_token',$login_token);
        $query = $CI->db->get();
        $count = $query->row();

        if (count($count) == '1')
        {
        	return 'TRUE';
        }
        else
        {
        	return 'FALSE';
        }	
	}
	
	
if ( ! function_exists('fnSendNotification'))
{
	function fnSendNotification($strTitle, $strMessage, $arrGcmID, $arrData=array()) 
	{
		$msg = array(
						'message' => "$strMessage",
						'contentTitle' => "$strTitle", 
						'order_id' => $order_id, 
						'order_no' =>  $order_no, 
						'order_date' => $order_date, 
						'oreder_by' => $oreder_by, 
						'order_status' => $order_status, 
						'order_amount' => $order_amount, 
						'user_role' =>$user_role, 
						'vibrate' => 1, 
						'sound' => 1, 
						'status' => "$status1"
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
             'registration_ids' => $arrGcmID,
             'notification' => array('contentTitle' => $strTitle, 'body' => $strMessage,'sound'=>'Default', 'data'=>$msg),
             'priority' => 'high',
             'data' 			   => $msg,
            );				
			//echo "<pre>"; print_r( $fields ); //die;
			define('FIREBASE_API_KEY', 'AAAAEjeytAs:APA91bHwVZU3r47_KmSuNdxlM3FoND86Nez9Brt4sYAMOU-vSNs8HsT1DmU3OAzZtF8PztlrcAZQgG3_Hdh7067sunytxUmr7KdJoB9eGrlgaN5765U5D-Xg0erHUlt2WCA3ceZzk20k');
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
			#var_dump($result); exit;
			if ($result === FALSE) 
			{
				die('Curl failed: ' . curl_error($ch));
			}
			//Now close the connection
			curl_close($ch);
			#print_r($fields); 
			#print_r($result);exit;	 
			//and return the result 
			return $result;
	}
}	

function fnSendNotificationALL($strTitle, $strMessage, $arrGcmID, $msg) 
		{
			
				$fields = array(
					'registration_ids' => $arrGcmID,
					'data' => $msg,
				);
				
				//echo "<pre>"; print_r( $fields ); //die;
				define('FIREBASE_API_KEY', 'AAAAEjeytAs:APA91bHwVZU3r47_KmSuNdxlM3FoND86Nez9Brt4sYAMOU-vSNs8HsT1DmU3OAzZtF8PztlrcAZQgG3_Hdh7067sunytxUmr7KdJoB9eGrlgaN5765U5D-Xg0erHUlt2WCA3ceZzk20k');
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
				//var_dump($result); exit;
				if ($result === FALSE) 
				{
					die('Curl failed: ' . curl_error($ch));
				} 
				//Now close the connection
				curl_close($ch);
				#print_r($result);exit;	
				//and return the result 
				return $result;
		}
		
		
	function random_strings($length_of_string) 
	{ 
		$str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'; 
		return substr(str_shuffle($str_result), 0, $length_of_string); 
	} 	
	
	function Calculatedistance($lat1, $lon1, $lat2, $lon2, $unit) 
	{
	
	  $theta = $lon1 - $lon2;
	  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	  $dist = acos($dist);
	  $dist = rad2deg($dist);
	  $miles = $dist * 60 * 1.1515;
	  $unit = strtoupper($unit);

	  if ($unit == "K") {
		  return ($miles * 1.609344);
	  } else if ($unit == "N") {
		  return ($miles * 0.8684);
	  } else if ($unit == "nmi") {
		  return ($miles * 59.97662);
	  }else {
		  return $miles;
	  }
	}
	
	function CalculateTime($distance,$speed= 30) 
	{
		#return $distance;
		$hours="00";
		$minutes="00";
		$seconds="00";

		#$time=($hours*3600)+($minutes*60)+$seconds;
		#return $time = ($speed * $distance)/60;
		$time=($distance/$speed);
		//$time = $time*(18/5);
		return $time*60;
		#return $formated=date('i:s', $time);
	}
	
	// function for array list for time difference 30 min
function hoursRange( $lower, $upper = 86400, $step = 3600, $format = '' ) 
{
    $times = array();

    if ( empty( $format ) ) 
	{
        $format = 'g:i a';
    }

    foreach ( range( $lower, $upper, $step ) as $increment ) 
	{
        $increment = gmdate( 'H:i', $increment );

        list( $hour, $minutes ) = explode( ':', $increment );

        $date = new DateTime( $hour . ':' . $minutes );
	
		$disp=$date->format( $format );
		
		$times[(string) $increment] = $disp;
    }
    return $times;
}

function hourMinute2Minutes($strHourMinute) {
    $from = date('Y-m-d 00:00:00');
    $to = date('Y-m-d '.$strHourMinute.':00');
    $diff = strtotime($to) - strtotime($from);
    $minutes = $diff / 60;
    return (int) $minutes;
}	
/* End of file csv_helper.php */
/* Location: ./system/helpers/commonfunctions.php */