<?php
	require(APPPATH.'/libraries/REST_Controller.php');
	class Pubnubchat extends REST_Controller {
		public function __construct()
		{
			parent::__construct();
            date_default_timezone_set('Asia/Kolkata');
			//date_default_timezone_set(DEFAULT_TIME_ZONE);
			$this->load->model('ApiModels/customer/Chatmodel');
			 
			$this->load->helper('url');
		}
		
		public function listchat_post()
		{			 
			//date_default_timezone_set(DEFAULT_TIME_ZONE);	
			$token 		= $this->input->post("token");
			$user_id	= $this->input->post("user_id");

			if($token == TOKEN){
				if($user_id == "")
				{
					$num = array(
									'responsemessage' => 'Please provide valid data ',
									'responsecode' => "400"
								); //create an array
					$obj = (object)$num;//Creating Object from array
						
					$response_array=json_encode($obj);
					 
				}
				else{
					 
					// $this->db->where('service_provider_id',5);
					// $this->db->delete('bhool_chat_channels'); 
					// echo $this->db->last_query();exit;
					$chatData = $this->Chatmodel->getChatList($user_id);
					
					foreach($chatData  as $key=>$chatDataDtls)
					{
						$user_photo='';
						if($chatDataDtls['user_photo']!="")
						{
							$chatDataDtls['user_photo']=base_url().'uploads/user_profile/'.$chatDataDtls['user_photo'];
						}
						$rst_photo='';
						if($chatDataDtls['sp_image']!="")
						{
							$chatDataDtls['sp_image']=base_url().'uploads/user_profile/'.$chatDataDtls['sp_image'];
						}

						$dateadded=new DateTime($chatDataDtls['dateadded']);
						$chatDataDtls['dateadded']=$dateadded->format('Y-m-d H:i');

						$dateupdated=new DateTime($chatDataDtls['dateupdated']);
						$chatDataDtls['dateupdated']=$dateadded->format('Y-m-d H:i');
						$chatDataDtls['message']="";
						
						$chatData[$key]=$chatDataDtls;				  
					}
					$data['data'] = $chatData;
					$data['responsemessage'] = 'Chat List';
					$data['responsecode'] = "200";
					$response_array=json_encode($data);	
					
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
			print_r($response_array);
		}
		
		public function addchatchannel_post()
		{
			error_reporting(E_ALL);
			date_default_timezone_set('Asia/Kolkata');			 
			$token 		= $this->input->post("token");
			$channel_id	= $this->input->post("channel_id");
			$user_id	= $this->input->post("user_id");			 
			$service_provider_id	= $this->input->post("service_provider_id");
			$booking_id	= $this->input->post("booking_id");

			
			if($token == TOKEN){
				if($channel_id=="" || $service_provider_id == ""|| $user_id == "" && $booking_id=="" || $channel_id==0
				|| $channel_id==null || $channel_id=="undefined" || $booking_id==0
				|| $booking_id==null || $booking_id=="undefined")
				{
					$num = array(
                                'responsemessage' => 'Please provide valid data ',
                                'responsecode' => "400"
								); //create an array
					$obj = (object)$num;//Creating Object from array
					$response_array=json_encode($obj);
				}
				else
				{
					$arrInsertChat = array(
						'booking_id' => $booking_id,
						'channel_id' => $channel_id,
						'user_id' => $user_id,
						'service_provider_id' => $service_provider_id,
						'dateadded' => date("Y-m-d H:i:s"),
						'dateupdated' => date("Y-m-d H:i:s"),
					); //create an array

					$checkChatData = $this->Chatmodel->checkChatExists(0,$channel_id,$user_id,$service_provider_id);
					if($checkChatData > 0 ){
						$ChatData = $this->Chatmodel->checkChatExists(1,$channel_id,$user_id,$service_provider_id);
						$this->Chatmodel->update_new_Chat($arrInsertChat,'chat_id',$ChatData->chat_id);
						$chatData 	= $this->Chatmodel->getChat($service_provider_id);
						
						$data['responsemessage'] = 'Chat data added successfully ';
						$data['responsecode'] = "200";
						$data['data'] = $chatData;
						$response_array=json_encode($data);		
					}
					else
					{
						$chat_id 	= $this->Chatmodel->insert_new_Chat($arrInsertChat);
						$chatData 	= $this->Chatmodel->getChat($service_provider_id);
						if($chat_id){
							$data['responsemessage'] = 'Chat data added successfully ';
							$data['responsecode'] = "200";
							$data['data'] = $chatData;
							$response_array=json_encode($data);	
						}
						else
						{
							$data['responsemessage'] = 'Could not add Chat data.';
							$data['responsecode'] = "402";
							$response_array=json_encode($data);	
						}
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
			print_r($response_array);
		}
	}
 ?>