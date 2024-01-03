<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//$this->load_global();

		//echo "<pre>";
	if(empty($this->session->userdata('logged_in'))){
			redirect(base_url().'backend/login','refresh');  
		}
		$this->load->library("pagination");	
		$this->load->model('adminModel/Notification_model');
		$this->load->model('adminModel/User_model');
		$this->load->model('Common_Model');
		date_default_timezone_set('Asia/Kolkata');
	}
	
	public function manageNotifications()
	{
		$data['title']='Manage Notifications';
		
		if($this->session->userdata("pagination_rows") != '')
		{
			$per_page = $this->session->userdata("pagination_rows");
		}
		else {
			$per_page='10';
		}
		
		$data['notificationcnt']=$this->Notification_model->getAllNotifications(0,"","");
		
		$config = array();
		
		$config["base_url"] = base_url().'backend/Notifications/manageNotifications/'.$per_page;
		
		$config['per_page'] = $per_page;
		
		
		//$arrGcmID[] = 'ExponentPushToken[ILvrAQKXZylNfqwZrnRmXO]';
		/*$arrGcmID[] = 'ExponentPushToken[XiEPpvAeQshWRuImc99MHx]';
		$this->Common_Model->sendexponotification('test', 'Testing notifications 5 pm sent...', $arrGcmID);*/
		
		//print $uriSegment; exit;
		$config["uri_segment"] = 5;
		$config['full_tag_open'] = '<ul class="pagination">'; 
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = "<li class='paginate_button  page-item'>";
		$config['first_tag_close'] = "</li>"; 
		$config['prev_tag_open'] =	"<li class='paginate_button  page-item'>"; 
		$config['prev_tag_close'] = "</li>";
		$config['next_tag_open'] = "<li class='paginate_button  page-item'>";
		$config['next_tag_close'] = "</li>"; 
		$config['last_tag_open'] = "<li class='paginate_button  page-item'>"; 
		$config['last_tag_close'] = "</li>";
		$config['cur_tag_open'] = "<li class='paginate_button  page-item active'><a class='page-link active' href=''>"; 
		$config['cur_tag_close'] = "</a></li>";
		$config['num_tag_open'] = "<li class='paginate_button  page-item'>";
		$config['num_tag_close'] = "</li>"; 
		$config['attributes'] =array('class' => 'page-link');
		$config["total_rows"] =$data['notificationcnt'];
		//print_r($config);
		$this->pagination->initialize($config);
		
		if(HOSTPAGINATE == 'local')
		{
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		}
		else
		{
			$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		}
		//echo "<pre>";print_r($config);
		//echo "<pre>";print_r($this->uri->segment); exit;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		$data['notifications']=$this->Notification_model->getAllNotifications(1,$config["per_page"],$page);
		//echo $this->db->last_query();exit;
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/manageNotifications',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function addnotification()
	{
		$data['title']='Add Notification';
		$data['error_msg']='';
		$session_data=$this->session->userdata('logged_in');
		$data['UserList'] = $this->Notification_model->getAllUserlist(1,'Customer');
		$data['ServiceProviderList']=$this->Notification_model->getAllUserlist(1,'Service Provider');
		 //echo "<pre>";
		//  print_r($_POST);
		// exit();

		if(isset($_POST['btn_addnotification']))
		{ 

			// echo "OK";exit;
			$this->form_validation->set_rules('title','Notification Name','required');
			$this->form_validation->set_rules('message','Notification Description','required');
			
			$this->form_validation->set_rules('select_type','Notification Type','required');
			if($this->form_validation->run())
			{
				$notification_name=$this->input->post('title');
				$notification_description=$this->input->post('message');
				$type=$this->input->post('select_type');
				$user_ids=$this->input->post('user_ids');
				//print_r($user_ids);exit;
				/*if($type==0){
					$dbType = "All";
					$dbUserId = 0;
				}else{
					$dbType = "User";
					$dbUserId = $type;
				}*/

				if(!empty($user_ids))
				{
					if($user_ids[0] == 'All')
					{
						if($type == 'Customer')
						{
							foreach($data['UserList'] as $users)
							{
								$input_data = array(
								'noti_title'=>trim($notification_name),
								'noti_message'=>trim($notification_description),
								'noti_user_type'=>$type,
								'noti_type'=>'Admin',
								'noti_user_id'=>$users['user_id'],
								'noti_gcmID'=>$users['user_fcm'],
								'created_by' => $session_data['admin_id'],
								'dateadded' => date('Y-m-d H:i:s')
								);
							
								$notification_id = $this->Notification_model->insert_notification($input_data);
								
								$this->Common_Model->sendexponotification($notification_name,$notification_description,$users['user_fcm']);
							}
						}
						else if($type == 'Service Provider')
						{
							foreach($data['ServiceProviderList'] as $users)
							{
								$input_data = array(
								'noti_title'=>trim($notification_name),
								'noti_message'=>trim($notification_description),
								'noti_user_type'=>$type,
								'noti_type'=>'Admin',
								'noti_user_id'=>$users['user_id'],
								'noti_gcmID'=>$users['user_fcm'],
								'created_by' => $session_data['admin_id'],
								'dateadded' => date('Y-m-d H:i:s')
								);
							
								$notification_id = $this->Notification_model->insert_notification($input_data);
								
								$this->Common_Model->sendexponotification($notification_name,$notification_description,$users['user_fcm']);
							}
						}
						
					} else 
					{
						foreach($user_ids as $user_id)
						{
							$user=$this->Notification_model->getUserDetails(1,$user_id);
						//print_r($user);exit;
							$input_data = array(
								'noti_title'=>trim($notification_name),
								'noti_message'=>trim($notification_description),
								'noti_user_type'=>$type,
								'noti_type'=>'Admin',
								'noti_user_id'=>$user_id,
								'noti_gcmID'=>$user->user_fcm,
								'created_by' => $session_data['admin_id'],
								'dateadded' => date('Y-m-d H:i:s')
								);
							
							$notification_id = $this->Notification_model->insert_notification($input_data);

							$this->Common_Model->sendexponotification($notification_name,$notification_description,$user->user_fcm);
						}
						// exit;
					}
					
				}
					$this->session->set_flashdata('success','Notification added successfully.');
					redirect(base_url().'backend/Notifications/manageNotifications');	

					// if($notification_id)
					// {	
					// 	if($dbType == 'All')
					// 	{
					// 		$usersToNotifications = $this->User_model->getAllUsersFcmToken();
					// 		if(!empty($usersToNotifications))
					// 		{
					// 			foreach($usersToNotifications as $userFcm)
					// 			{
					// 				if($userFcm['fcm_token'] != '')
					// 				{
					// 					$arrGcmID[] .= $userFcm['fcm_token'];
					// 				}
					// 			}
					// 		}
					// 		$this->Common_Model->sendexponotification($notification_name, $notification_description, $arrGcmID);
					// 	}
					// 	else if($dbType == 'User') 
					// 	{
					// 		$userFcm = $this->User_model->getUserFcmToken($dbUserId);
							
					// 		$arrGcmID[] = $userFcm->fcm_token;
							
					// 		$this->Common_Model->sendexponotification($notification_name, $notification_description, $arrGcmID);
					// 	}
						
					// 	$this->session->set_flashdata('success','Notification added successfully.');
				
					// 	redirect(base_url().'backend/Notifications/index');	
					// }
					// else
					// {
					// 	$this->session->set_flashdata('error','Error while adding Notification.');

					// 	redirect(base_url().'backend/Notifications/addNotification/');
					// }
			}
			else
			{
				// exit;
				$this->session->set_flashdata('error','Error while adding Notification.');
				redirect(base_url().'backend/Notifications/addNotification/');
			}

		}

		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/addNotification',$data);
		$this->load->view('admin/admin_footer');
	}
	

    public function fetch_user()
	{
		if($this->input->post('select_type'))
		{
		echo $this->Notification_model->getAllUserlist($this->input->post('select_type'));
		}
	}

	public function deletenotification()
	{
		$data['error_msg']='';
		$noti_id = base64_decode($this->uri->segment(4));
		if($noti_id)
		{ 
				
				$this->db->where('noti_id',$noti_id);
				$deluser = $this->db->delete('bhool_notification');
				if($deluser > 0)
				{
					$this->session->set_flashdata('success','Notification deleted successfully.');
					redirect(base_url().'backend/Notifications/manageNotifications');	
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleting notification.');
					redirect(base_url().'backend/Notifications/manageNotifications');
				}
			
		}
		else
		{
			$this->session->set_flashdata('error','Notification not found.');
			redirect(base_url().'backend/Users/index');
		}
	}
	
	public function setPagination()
	{
		$the_session = array('pagination_rows',$_POST['pageid']);
		$this->session->set_userdata('pagination_rows',$_POST['pageid']);
	}	
}