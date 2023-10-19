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
	}
	
	public function index()
	{
		$data['title']='Manage Notifications';
		
		$data['notificationcnt']=$this->Notification_model->getAllNotifications(0,"","");
		
		
		//$arrGcmID[] = 'ExponentPushToken[ILvrAQKXZylNfqwZrnRmXO]';
		/*$arrGcmID[] = 'ExponentPushToken[XiEPpvAeQshWRuImc99MHx]';
		$this->Common_Model->sendexponotification('test', 'Testing notifications 5 pm sent...', $arrGcmID);*/
		
		$config = array();
		$config["base_url"] = base_url().'backend/Notifications/index/';
		$config['per_page'] = 25;
		$config["uri_segment"] = 4;
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
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		$data['notifications']=$this->Notification_model->getAllNotifications(1,$config["per_page"],$page);
		//echo $this->db->last_query();exit;
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/manageNotifications',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function addNotification()
	{
		$data['title']='Add Notification';
		$data['error_msg']='';
		$data['userinfo']=$this->Notification_model->getAllUserlist(1);
		/*echo "<pre>";
		print_r($data['userinfo']);
		exit();*/

		if(isset($_POST['btn_addnotification']))
		{ 
			$this->form_validation->set_rules('notification_name','Notification Name','required');
			$this->form_validation->set_rules('notification_description','Notification Description','required');
			
			$this->form_validation->set_rules('notification_type','Notification Type','required');
			if($this->form_validation->run())
			{
				$notification_name=$this->input->post('notification_name');
				$notification_description=$this->input->post('notification_description');
				$type=$this->input->post('notification_type');
				//$description=$this->input->post('description');
				if($type==0){
					$dbType = "All";
					$dbUserId = 0;
				}else{
					$dbType = "User";
					$dbUserId = $type;
				}
				
					$input_data = array(
						'notification_name'=>trim($notification_name),
						'notification_description'=>trim($notification_description),
						'type'=>$dbType,
						'userid'=>$dbUserId,
						'dateupdated' => date('Y-m-d H:i:s'),
						'dateadded' => date('Y-m-d H:i:s')
						);
					/*echo"<pre>";
					print_r($input_data);
					exit();*/

					$notification_id = $this->Notification_model->insert_notification($input_data);
					
					if($notification_id)
					{	
						if($dbType == 'All')
						{
							$usersToNotifications = $this->User_model->getAllUsersFcmToken();
							if(!empty($usersToNotifications))
							{
								foreach($usersToNotifications as $userFcm)
								{
									if($userFcm['fcm_token'] != '')
									{
										$arrGcmID[] .= $userFcm['fcm_token'];
									}
								}
							}
							$this->Common_Model->sendexponotification($notification_name, $notification_description, $arrGcmID);
						}
						else if($dbType == 'User') 
						{
							$userFcm = $this->User_model->getUserFcmToken($dbUserId);
							
							$arrGcmID[] = $userFcm->fcm_token;
							
							$this->Common_Model->sendexponotification($notification_name, $notification_description, $arrGcmID);
						}
						
						$this->session->set_flashdata('success','Notification added successfully.');
				
						redirect(base_url().'backend/Notifications/index');	
					}
					else
					{
						$this->session->set_flashdata('error','Error while adding Notification.');

						redirect(base_url().'backend/Notifications/addNotification/');
					}
			}

		}

		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/addNotification',$data);
		$this->load->view('admin/admin_footer');
	}
	
	
}