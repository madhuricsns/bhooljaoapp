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
					 
					//$this->Chatmodel->delete_chat('chat_channels');
					//echo $this->db->last_query();exit;
					$chatData = $this->Chatmodel->getChatList($user_id);
					
					if(is_array($chatData) && count($chatData) > 0)
					{
						foreach($chatData  as $key=>$chatDataDtls)
						{
							$user_photo='';
							if($chatDataDtls['user_photo']!="")
							{
								$chatDataDtls['user_photo']=base_url().'uploads/user/profile_photo/'.$chatDataDtls['user_photo'];
							}
							$rst_photo='';
							if($chatDataDtls['sp_image']!="")
							{
								$chatDataDtls['sp_image']=base_url().'uploads/user/profile_photo/'.$chatDataDtls['sp_image'];
							}

							$dateadded=new DateTime($chatDataDtls['dateadded']);
							$chatDataDtls['dateadded']=$dateadded->format('Y-m-d H:i');

							$dateupdated=new DateTime($chatDataDtls['dateupdated']);
							$chatDataDtls['dateupdated']=$dateadded->format('Y-m-d H:i');
						
							$chatData[$key]=$chatDataDtls;				  
						}
						$data['data'] = $chatData;
						$data['responsemessage'] = 'Chat List';
						$data['responsecode'] = "200";
						$response_array=json_encode($data);	
					}
					else
					{
						$data['responsemessage'] = 'No Chat List ';
						$data['responsecode'] = "402";
						$response_array=json_encode($data);	
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
		
		public function addchatchannel_post()
		{
			error_reporting(E_ALL);
			date_default_timezone_set('Asia/Kolkata');			 
			$token 		= $this->input->post("token");
			$channel_id	= $this->input->post("channel_id");
			$user_id	= $this->input->post("user_id");			 
			$service_provider_id	= $this->input->post("service_provider_id");

			
			if($token == TOKEN){
				if($channel_id=="" || $service_provider_id == ""|| $user_id == "")
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
						'channel_id' => $channel_id,
						'user_id' => $user_id,
						'service_provider_id' => $service_provider_id,
						'dateadded' => date("Y-m-d H:i:s"),
						'dateupdated' => date("Y-m-d H:i:s"),
					); //create an array

					$checkChatData = $this->Chatmodel->checkChatExists($channel_id,$user_id,$service_provider_id);
					if($checkChatData > 0 ){
						// $data['responsemessage'] = 'Chat data already Inititated.';
						// $data['responsecode'] = "402";

						$data['responsemessage'] = 'Chat data added successfully ';
						$data['responsecode'] = "200";
						$response_array=json_encode($data);	
					}
					else
					{
						$chat_id 	= $this->Chatmodel->insert_new_Chat($arrInsertChat);
						if($chat_id){
							$data['responsemessage'] = 'Chat data added successfully ';
							$data['responsecode'] = "200";
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