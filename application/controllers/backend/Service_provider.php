<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_provider extends CI_Controller {
	public function __construct(){
		parent::__construct();
	if(empty($this->session->userdata('logged_in'))){
			redirect(base_url().'backend/login','refresh');  
		}
		$this->load->library("pagination");	
		$this->load->helper('email');
		$this->load->library('session');
		
		$this->load->model('adminModel/Serviceprovider_model');
		$this->load->model('Common_Model');
		
	}
	
	public function managesservice()
	{
		$data['title']='Manage Service Provider';

		
		$data['usercnt']=$this->Serviceprovider_model->getAllUsers(0,"","");
		
		$config = array();
		$config["base_url"] = base_url().'backend/Users/manageUsers/';
		$config['per_page'] = 10;
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
		$config["total_rows"] =$data['usercnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		//echo "ConttPerPage--".$config["per_page"];
		//echo "Conttpage--".$page;
		//exit();
		$data['service_provider']=$this->Serviceprovider_model->getAllUsers(1,$config["per_page"],$page);
		//echo $this->db->last_query();exit;
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/manageServiceprovider',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function addservice_provider()
	{
		$data['title']='Add Service Provider';
		$data['error_msg']='';
		$data['zoneList']=$this->Serviceprovider_model->getAllzone(1,"","");
				
		if(isset($_POST['btn_addservice_provider']))
		{
			
			$this->form_validation->set_rules('full_name','Full Name','required');
			
			$this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email');
			//$this->form_validation->set_rules('email_address', 'Email Address', 'required');
			//$this->form_validation->set_rules('username','User Name','required');
			$this->form_validation->set_rules('password','Password','required');
			$this->form_validation->set_rules('address', 'Address ', 'required'); //{10} for 10 digits number

			$this->form_validation->set_rules('mobile_number', 'Mobile Number ', 'required|numeric|min_length[7]|max_length[13]'); //{10} for 10 digits number
			// $this->form_validation->set_rules('is_superadmin','Is Superadmin','required');
			$this->form_validation->set_rules('zone_id','Zone Id','required');
			$this->form_validation->set_rules('daily_report','Daily Report');
			$this->form_validation->set_rules('status','User Status','required');

			if($this->form_validation->run())
			{
				//echo "successfully validated";exit();
			
				$full_name=$this->input->post('full_name');
				$mobile=$this->input->post('mobile_number');
				$email=$this->input->post('email_address');
				$username=$this->input->post('username');
				$password=$this->input->post('password');
				$is_superadmin="Service Provider";
				$zone_id=$this->input->post('zone_id');
				$address=$this->input->post('address');

				//$daily_report=$this->input->post('daily_report');
				$status=$this->input->post('status');
				//$description=$this->input->post('description');
				if($is_superadmin == 'Yes' ){
						$daily_report = 'NO';
				}

				$servicefile='';
				if($_FILES['servicefile'])
				{
					if($_FILES['servicefile']['name']!="")
					{
						$photo_imagename='';
						$new_image_name = rand(1, 99999).$_FILES['servicefile']['name'];
						$config = array(
									'upload_path' => "uploads/service_provider/",
									'allowed_types' => "gif|jpg|png|bmp|jpeg",
									'max_size' => "0", 
									'file_name' =>$new_image_name
						);
						$this->load->library('upload', $config);
						if($this->upload->do_upload('servicefile'))
						{ 
							$imageDetailArray = $this->upload->data();								
							$photo_imagename =  $imageDetailArray['file_name'];
						}else
						{
							$errorMsg = $this->upload->display_errors();
							$this->session->set_flashdata('error',$errorMsg);
							redirect(base_url().'backend/Service_provider/addservice_provider/');

						}
						if($_FILES['servicefile']['error']==0)
						{ 
							$servicefile=$photo_imagename;
						}
					}
				}


				$usertitle=$this->Serviceprovider_model->chkUserName($username,$email,0);

				if($usertitle==0)
				{
					$input_data = array(
						'profile_pic'=>$servicefile,
						'full_name'=>trim($full_name),
						'email'=>$email,
						//'username'=>$username,
						'password'=>md5($password),
						'mobile'=>$mobile,
						'user_type'=>$is_superadmin,
						'address'=>$address,
						'zone_id'=>$zone_id,
						'status'=>$status,
						'dateupdated' => date('Y-m-d H:i:s'),
						'dateadded' => date('Y-m-d H:i:s')
						);

					// echo"<pre>";
					// print_r($input_data);
					// exit();
					
					$user_id = $this->Serviceprovider_model->insert_user($input_data);
					
					if($user_id)
					{	
						$this->session->set_flashdata('success','User added successfully.');

						redirect(base_url().'backend/Service_provider/managesservice');	
					}
					else
					{
						$this->session->set_flashdata('error','Error while adding user.');

						redirect(base_url().'backend/Service_provider/addservice_provider');
					}	
				}
				else
				{
					$this->session->set_flashdata('success','Username  already exist.');

					redirect(base_url().'backend/Service_provider/addservice_provider');	
				}

			}else{
				$this->session->set_flashdata('success','Validation failed. Please enter valid email or mobile number.');
				redirect(base_url().'backend/Service_provider/addservice_provider');
			}
		}

		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/add_service_provider',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function updateservice()
	{
		$data['title']='Update Service Provider';
		$data['error_msg']='';
		//echo "segment--".$this->uri->segment(4);exit();
		$user_id=base64_decode($this->uri->segment(4));
		//echo "Brand_id--".$brand_id;exit();
		$data['zoneList']=$this->Serviceprovider_model->getAllzone(1,"","");
		if($user_id)
		{
			$userInfo=$this->Serviceprovider_model->getSingleUserInfo($user_id,0);

			if($userInfo>0)
			{
				$data['userInfo'] = $this->Serviceprovider_model->getSingleUserInfo($user_id,1);
				if(isset($_POST['btn_uptuser']))
				{
			
					$this->form_validation->set_rules('full_name','Full Name','required');
					$this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email');
					$this->form_validation->set_rules('mobile_number', 'Mobile Number ', 'required|numeric|min_length[7]|max_length[13]');
					// $this->form_validation->set_rules('username','User Name','required');
					$this->form_validation->set_rules('daily_report','Daily Report');
					$this->form_validation->set_rules('is_superadmin','IS Superadmin','required');
					$this->form_validation->set_rules('zone_id','Zone Id','required');
			        $this->form_validation->set_rules('status','User Status','required');

					if($this->form_validation->run())
					{
					
						$full_name=$this->input->post('full_name');

						$mobile_number=$this->input->post('mobile_number');
						$email_address=$this->input->post('email_address');
						$username=$this->input->post('username');
						$password=$this->input->post('password');
						$is_superadmin=$this->input->post('is_superadmin');
						$zone_id=$this->input->post('zone_id');
						$daily_report=$this->input->post('daily_report');
						$status=$this->input->post('status');
						//$description = $this->input->post('description');
						if($is_superadmin == 'Yes' ){
							$daily_report = 'NO';
						}	
		
$servicefile='';
				if(isset($_FILES['servicefile']))
				{
					if($_FILES['servicefile']['name']!="")
					{
						$photo_imagename='';
						$new_image_name = rand(1, 99999).$_FILES['servicefile']['name'];
						$config = array(
									'upload_path' => "uploads/service_provider/",
									'allowed_types' => "gif|jpg|png|bmp|jpeg",
									'max_size' => "0", 
									'file_name' =>$new_image_name
						);
						$this->load->library('upload', $config);
						if($this->upload->do_upload('servicefile'))
						{ 
							$imageDetailArray = $this->upload->data();								
							$photo_imagename =  $imageDetailArray['file_name'];
						}else
						{
							$errorMsg = $this->upload->display_errors();
							$this->session->set_flashdata('error',$errorMsg);
							redirect(base_url().'backend/Service_provider/addservice_provider/');

						}
						if($_FILES['servicefile']['error']==0)
						{ 
							$servicefile=$photo_imagename;
						}
					}
				}

						$input_data = array(
							'profile_pic'=>$servicefile,
								'full_name'=>trim($full_name),
							'email'=>$email_address,
							
							'mobile'=>$mobile_number,
							'user_type'=>$is_superadmin,
							'zone_id'=>$zone_id,
							
							'status'=>$status,
							'dateupdated' => date('Y-m-d H:i:s'),
						
								);
					
					// echo"<pre>";
					// print_r($input_data);
					// exit();

						$userdata =$this->Serviceprovider_model->uptdateservices($input_data,$user_id);

						if($userdata)
						{	
							$this->session->set_flashdata('success','User updated successfully.');

							redirect(base_url().'backend/Service_provider/managesservice');	
						}
						else
						{
							$this->session->set_flashdata('error','Error while updating User.');

							redirect(base_url().'backend/Service_provider/updateservice/'.base64_encode($user_id));
						}	
					}
					else
					{
						$this->session->set_flashdata('error',$this->form_validation->error_string());

						redirect(base_url().'backend/Service_provider/updateservice/'.base64_encode($user_id));
					}
				}
			}
			else
			{
				$data['error_msg'] = 'User not found.';
			}
		}
		
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/update_service_provider',$data);
		$this->load->view('admin/admin_footer');
	}

	
	public function viewUsertask()
	{
		$data['title']='View User Tasks';
		$user_id=base64_decode($this->uri->segment(4));
		//echo "user_id--".$user_id;exit();
		$data['user_id'] = $user_id;
		$user_id_base64 = base64_encode($user_id);
		$data['userinfo']=$this->User_model->getSingleUserInfo($user_id,1);
		/*echo "<pre>";
		print_r($data['userinfo']);
		exit();*/

		$input_data = array();
        if(isset($_POST['btn_clear']))
		{
			 $this->session->unset_userdata('spsession_start_date');
			 $this->session->unset_userdata('spsession_start_date_fmt');
			 $this->session->unset_userdata('spsession_end_date');
			 $this->session->unset_userdata('spsession_end_date_fmt');
			 //$this->session->unset_userdata('session_username');
			 $this->session->unset_userdata('spsession_status');
			 redirect(base_url().'backend/Users/viewUsertask/'.$user_id_base64);
		}
		if(isset($_POST['btn_search']))
		{
			 	$this->session->unset_userdata('spsession_start_date');
			 	$this->session->unset_userdata('spsession_start_date_fmt');
			 	$this->session->unset_userdata('spsession_end_date');
			 	$this->session->unset_userdata('spsession_end_date_fmt');
			 	$this->session->unset_userdata('spsession_status');
				$spdate_from_fmt="";
				$spdate_to_fmt="";
				$spstart_date=$this->input->post('from_date');
				$spend_date=$this->input->post('end_date');
				//$username=$this->input->post('username');
				$spstatus=$this->input->post('status');
				if($spstart_date!=""){
					$this->session->set_userdata(array("spsession_start_date"=>$spstart_date));
					$spdate_from_fmt = date('Y-m-d H:i:s', strtotime($spstart_date));
					$this->session->set_userdata(array("spsession_start_date_fmt"=>$spdate_from_fmt));
					$data['spsession_start_date'] = $spstart_date;
					$data['spsession_start_date_fmt'] = $spdate_from_fmt;
					
				}
				if($spend_date!=""){
					$this->session->set_userdata(array("spsession_end_date"=>$spend_date));
        		
                	$spdate_to_fmt = date('Y-m-d H:i:s', strtotime($spend_date));
                	$this->session->set_userdata(array("spsession_end_date_fmt"=>$spdate_to_fmt));
                	$data['spsession_end_date'] = $spend_date;
                	$data['spsession_end_date_fmt'] = $spdate_to_fmt;
            	}
                /*if($username!=""){
					$this->session->set_userdata(array("session_username"=>$username));
					$data['session_username'] = $this->session->userdata('session_username');
				
            	}*/
            	if($spstatus!="novalue"){
					$this->session->set_userdata(array("spsession_status"=>$spstatus));
					$data['spsession_status'] = $this->session->userdata('spsession_status');
            	}
		}
		$data['spsession_start_date'] = $this->session->userdata('spsession_start_date');
		$data['spsession_start_date_fmt'] = $this->session->userdata('spsession_start_date_fmt');
		$data['spsession_end_date'] = $this->session->userdata('spsession_end_date');
		$data['spsession_end_date_fmt'] = $this->session->userdata('spsession_end_date_fmt');
		//$data['session_username'] = $this->session->userdata('session_username');
		$data['spsession_status'] = $this->session->userdata('spsession_status');

		$input_data = array(
					'start_date'=> $data['spsession_start_date_fmt'] ?? '',
					'end_date'=>$data['spsession_end_date_fmt'] ?? '',
					//'username'=>$data['session_username'] ?? '',
					'status' =>$data['spsession_status'] ?? 'novalue'
					);
		/*echo "<pre>";
		print_r($input_data);
		exit();*/
		
				
		$data['usertaskcnt']=$this->User_model->getAllUsertasks(0,"","",$user_id,$input_data);
		
		$config = array();
		$config["base_url"] = base_url().'backend/Users/viewUsertask/'.$user_id_base64;
		$config['per_page'] = 20;
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
		$config["total_rows"] =$data['usertaskcnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		//echo "userid--".$user_id;exit();
		$data['usertasks']=$this->User_model->getAllUsertasks(1,$config["per_page"],$page,$user_id,$input_data);

		/*echo "<pre>";
		print_r($data['usertasks']);exit();*/
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/viewUsertask',$data);
		$this->load->view('admin/admin_footer');
	}

	 public function updateStatus()
	{
		$data['title']='Update Status';
		$data['error_msg']='';
		//echo "segment--".$this->uri->segment(4);exit();

		//echo "seg4--".$this->uri->segment(4);
		//echo "seg5--".$this->uri->segment(5);exit();
		$action=$this->uri->segment(4);

		$task_id=base64_decode($this->uri->segment(5));
		$user_id=$this->uri->segment(6);
		//echo "user_id--".$user_id;exit();
		if($action=='accept'){
			$statusTobeUpdated="Accepted";
		}elseif($action=='reject'){
			 $statusTobeUpdated="Rejected";
		}

		if($task_id)
		{
			
			$input_data = array(
								'status'=> $statusTobeUpdated
								);
			$usertaskdata = $this->Usertask_model->uptdateStatus($input_data,$task_id);
			if($usertaskdata){
				$this->session->set_flashdata('success','Status updated successfully.');
				redirect(base_url().'backend/users/viewUsertask/'.$user_id);
				}
		}
	}
	public function deleteservice()
	{
		$data['error_msg']='';
		$user_id = base64_decode($this->uri->segment(4));

		if($user_id)
		{
			$userInfo = $data['userInfo'] = $this->Serviceprovider_model->getSingleUserInfo($user_id,1);

			if(count($userInfo) > 0)
			{   
				$input_data = array(
					'status'=>'Delete',
					'dateupdated' => date('Y-m-d H:i:s')
				);

				$deluser = $this->Serviceprovider_model->uptdateservices($input_data,$user_id);
				if($deluser > 0)
				{
					$this->session->set_flashdata('success','User deleted successfully.');
					redirect(base_url().'backend/Service_provider/managesservice');	
				}
				else 

				{
					$this->session->set_flashdata('error','Error while deleting user.');
					redirect(base_url().'backend/Service_provider/managesservice');
				}
			}
			else
			{
				$data['error_msg'] = 'User not found.';
			}
		}
		else
		{
			$this->session->set_flashdata('error','User not found.');
			redirect(base_url().'backend/Users/index');
		}
	}
}