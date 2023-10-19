<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	public function __construct(){
		parent::__construct();
	if(empty($this->session->userdata('logged_in'))){
			redirect(base_url().'backend/login','refresh');  
		}
		$this->load->library("pagination");	
		$this->load->helper('email');
		$this->load->library('session');
		$this->load->model('adminModel/User_model');
		
	}
	
	public function manageUsers()
	{
		$data['title']='Manage Users';

		
		$data['usercnt']=$this->User_model->getAllUsers(0,"","");
		
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
		$data['users']=$this->User_model->getAllUsers(1,$config["per_page"],$page);
		//echo $this->db->last_query();exit;
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/manageUsers',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function addUser()
	{
		$data['title']='Add User';
		$data['error_msg']='';
				
		if(isset($_POST['btn_adduser']))
		{
			$this->form_validation->set_rules('full_name','Full Name','required');
			$this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email');
			//$this->form_validation->set_rules('email_address', 'Email Address', 'required');
			$this->form_validation->set_rules('username','User Name','required');
			$this->form_validation->set_rules('password','Password','required');
			//$this->form_validation->set_rules('mobile_number', 'Mobile Number ', 'required'); //{10} for 10 digits number

			$this->form_validation->set_rules('mobile_number', 'Mobile Number ', 'required|numeric|min_length[7]|max_length[13]'); //{10} for 10 digits number
			$this->form_validation->set_rules('is_superadmin','Is Superadmin','required');
			$this->form_validation->set_rules('daily_report','Daily Report');
			$this->form_validation->set_rules('status','User Status','required');
			if($this->form_validation->run())
			{
				//echo "successfully validated";exit();
				$full_name=$this->input->post('full_name');
				$mobile_number=$this->input->post('mobile_number');
				$email_address=$this->input->post('email_address');
				$username=$this->input->post('username');
				$password=$this->input->post('password');
				$is_superadmin=$this->input->post('is_superadmin');

				$daily_report=$this->input->post('daily_report');
				$status=$this->input->post('status');
				//$description=$this->input->post('description');
				if($is_superadmin == 'Yes' ){
						$daily_report = 'NO';
				}		
				$usertitle=$this->User_model->chkUserName($username,$email_address,0);

				if($usertitle==0)
				{
					$input_data = array(
						'full_name'=>trim($full_name),
						'email_address'=>$email_address,
						'username'=>$username,
						'password'=>md5($password),
						'mobile_number'=>$mobile_number,
						'is_superadmin'=>$is_superadmin,
						'daily_report'=>$daily_report,
						'status'=>$status,
						'dateupdated' => date('Y-m-d H:i:s'),
						'dateadded' => date('Y-m-d H:i:s')
						);

					/*echo"<pre>";
					print_r($input_data);
					exit();*/
					
					$user_id = $this->User_model->insert_user($input_data);
					
					if($user_id)
					{	
						$this->session->set_flashdata('success','User added successfully.');

						redirect(base_url().'backend/Users/index');	
					}
					else
					{
						$this->session->set_flashdata('error','Error while adding user.');

						redirect(base_url().'backend/Users/addUser/');
					}	
				}
				else
				{
					$this->session->set_flashdata('success','Username  already exist.');

					redirect(base_url().'backend/Users/addUser');	
				}

			}else{
				$this->session->set_flashdata('success','Validation failed. Please enter valid email or mobile number.');
				redirect(base_url().'backend/Users/addUser');
			}
		}

		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/addUser',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function updateUser()
	{
		$data['title']='Update User';
		$data['error_msg']='';
		//echo "segment--".$this->uri->segment(4);exit();
		$user_id=base64_decode($this->uri->segment(4));
		//echo "Brand_id--".$brand_id;exit();
		if($user_id)
		{
			$userInfo=$this->User_model->getSingleUserInfo($user_id,0);
			if($userInfo>0)
			{
				$data['userInfo'] = $this->User_model->getSingleUserInfo($user_id,1);
				if(isset($_POST['btn_uptuser']))
				{
					$this->form_validation->set_rules('full_name','Full Name','required');
					$this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email');
					$this->form_validation->set_rules('mobile_number', 'Mobile Number ', 'required|numeric|min_length[7]|max_length[13]');
					$this->form_validation->set_rules('username','User Name','required');
					$this->form_validation->set_rules('daily_report','Daily Report');
					$this->form_validation->set_rules('is_superadmin','IS Superadmin','required');
			        $this->form_validation->set_rules('status','User Status','required');

					if($this->form_validation->run())
					{
						$full_name=$this->input->post('full_name');
						$mobile_number=$this->input->post('mobile_number');
						$email_address=$this->input->post('email_address');
						$username=$this->input->post('username');
						$password=$this->input->post('password');
						$is_superadmin=$this->input->post('is_superadmin');
						$daily_report=$this->input->post('daily_report');
						$status=$this->input->post('status');
						//$description = $this->input->post('description');
						if($is_superadmin == 'Yes' ){
							$daily_report = 'NO';
						}	
						$input_data = array(
								'full_name'=>trim($full_name),
							'email_address'=>$email_address,
							'username'=>$username,
							'password'=>$password,
							'mobile_number'=>$mobile_number,
							'is_superadmin'=>$is_superadmin,
							'daily_report'=>$daily_report,
							'status'=>$status,
							'dateupdated' => date('Y-m-d H:i:s'),
						
								);
					if($input_data['is_superadmin'] == 'Yes' )
					{
						$daily_report == 'NO';
					}
					

						$userdata = $this->User_model->uptdateUser($input_data,$user_id);

						if($userdata)
						{	
							$this->session->set_flashdata('success','User updated successfully.');

							redirect(base_url().'backend/Users/index');	
						}
						else
						{
							$this->session->set_flashdata('error','Error while updating User.');

							redirect(base_url().'backend/Users/updateUser/'.base64_encode($user_id));
						}	
					}
					else
					{
						$this->session->set_flashdata('error',$this->form_validation->error_string());

						redirect(base_url().'backend/Users/updateUser/'.base64_encode($user_id));
					}
				}
			}
			else
			{
				$data['error_msg'] = 'User not found.';
			}
		}
		
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/updateUser',$data);
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
	public function deleteUser()
	{
		$data['error_msg']='';
		$user_id = base64_decode($this->uri->segment(4));
		if($user_id)
		{
			$userInfo = $data['userInfo'] = $this->User_model->getSingleUserInfo($user_id,1);
			if(count($userInfo) > 0)
			{   
				$input_data = array(
					'status'=>'Deleted',
					'dateupdated' => date('Y-m-d H:i:s')
				);

				$deluser = $this->User_model->uptdateUser($input_data,$user_id);
				if($deluser > 0)
				{
					$this->session->set_flashdata('success','User deleted successfully.');
					redirect(base_url().'backend/Users/index');	
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleting user.');
					redirect(base_url().'backend/Users/index');
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