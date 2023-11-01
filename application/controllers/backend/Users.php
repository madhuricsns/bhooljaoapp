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
	public function index()
	{
		redirect(base_url().'backend/Users/manageUsers','refresh');
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
			// $this->form_validation->set_rules('mobile_number', 'Mobile Number ', 'required'); //{10} for 10 digits number
			// $this->form_validation->set_rules('zone_id','Zone Id','required');
			$this->form_validation->set_rules('password','Password','required');
					$this->form_validation->set_rules('address', 'Address ', 'required');
			$this->form_validation->set_rules('mobile_number', 'Mobile Number ', 'required|numeric|min_length[7]|max_length[13]'); //{10} for 10 digits number
			$this->form_validation->set_rules('gender','Gender','required');
			$this->form_validation->set_rules('status','Status','required');
			if($this->form_validation->run())
			{
				//echo "successfully validated";exit();
				$full_name=$this->input->post('full_name');
				$mobile_number=$this->input->post('mobile_number');
				$email_address=$this->input->post('email_address');
				$password=$this->input->post('password');
						$address=$this->input->post('address');
						// $zone_id=$this->input->post('zone_id');
						$gender=$this->input->post('gender');
						$status=$this->input->post('status');
				//$description=$this->input->post('description');
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
						
				$usertitle=$this->User_model->chkUserName($mobile_number,$email_address,0);

				if($usertitle==0)
				{
					$input_data = array(
						'profile_pic'=>$servicefile,
							'full_name'=>trim($full_name),
							'email'=>$email_address,
							'password'=>md5($password),
							'gender'=>$gender,
							'mobile'=>$mobile_number,
							'address'=>$address,
							'status'=>$status,
						'user_type'=>'Customer',
						'dateupdated' => date('Y-m-d H:i:s'),
						'dateadded' => date('Y-m-d H:i:s')
						);

					// echo"<pre>";
					// print_r($input_data);
					// exit();
					
					$user_id = $this->User_model->insert_user($input_data);
					
					if($user_id)
					{	
						$this->session->set_flashdata('success','User added successfully.');

						redirect(base_url().'backend/Users/manageUsers');	
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
			// $this->form_validation->set_rules('mobile_number', 'Mobile Number ', 'required'); //{10} for 10 digits number
			// $this->form_validation->set_rules('zone_id','Zone Id','required');
			//$this->form_validation->set_rules('password','Password','required');
					$this->form_validation->set_rules('address', 'Address ', 'required');
			$this->form_validation->set_rules('mobile_number', 'Mobile Number ', 'required|numeric|min_length[7]|max_length[13]'); //{10} for 10 digits number
			$this->form_validation->set_rules('gender','Gender','required');
			$this->form_validation->set_rules('status','Status','required');

					if($this->form_validation->run())
					{
						$full_name=$this->input->post('full_name');
						$mobile_number=$this->input->post('mobile_number');
						$email_address=$this->input->post('email_address');
						//$password=$this->input->post('password');
						$address=$this->input->post('address');
						// $zone_id=$this->input->post('zone_id');
						$gender=$this->input->post('gender');
						$status=$this->input->post('status');
				//$description=$this->input->post('description');
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
							
						$input_data = array(
							'profile_pic'=>$servicefile,
							'full_name'=>trim($full_name),
							'email'=>$email_address,
							//'password'=>md5($password),
							'gender'=>$gender,
							'mobile'=>$mobile_number,
							'address'=>$address,
							'status'=>$status,
							'user_type'=>'Customer',
							'dateupdated' => date('Y-m-d H:i:s'),
								);
					
						$userdata = $this->User_model->uptdateUser($input_data,$user_id);

						if($userdata)
						{	
							$this->session->set_flashdata('success','User updated successfully.');

							redirect(base_url().'backend/Users/manageUsers');	
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

	
	public function viewUserDetails()
	{
		$data['title']='View User Details';
		$user_id=base64_decode($this->uri->segment(4));
		//echo "user_id--".$user_id;exit();
		$data['user_id'] = $user_id;
		$user_id_base64 = base64_encode($user_id);
		$data['userinfo']=$this->User_model->getSingleUserInfo($user_id,1);
		$data['bookingList']=$this->User_model->getAllBooking($user_id,1,"","");
		
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/viewUserDetails',$data);
		$this->load->view('admin/admin_footer');
	}
	public function change_status()
	{
		$data['title']='Change Status';
		$data['error_msg']='';
		
		$user_id=base64_decode($this->uri->segment(4));

		$statusTobeUpdated=base64_decode($this->uri->segment(5));
		//echo "user_id--".$user_id;exit();
		if($user_id)
		{
			$input_data = array(
								'status'=> $statusTobeUpdated
								);
			$userdata = $this->User_model->uptdateStatus($input_data,$user_id);
			if($userdata){
				$this->session->set_flashdata('success','Status updated successfully.');
				redirect(base_url().'backend/Users/manageUsers/');
				}
		}
	}
	public function spchange_status()
	{
		$data['title']='Change Status';
		$data['error_msg']='';
		
		$user_id=base64_decode($this->uri->segment(4));

		$statusTobeUpdated=base64_decode($this->uri->segment(5));
		//echo "user_id--".$user_id;exit();
		if($user_id)
		{
			$input_data = array(
								'status'=> $statusTobeUpdated
								);
			$userdata = $this->User_model->uptdateStatus($input_data,$user_id);
			if($userdata){
				$this->session->set_flashdata('success','Status updated successfully.');
				redirect(base_url().'backend/Users/manageServiceProvider/');
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
					'status'=>'Delete',
					'dateupdated' => date('Y-m-d H:i:s')
				);

				$deluser = $this->User_model->uptdateUser($input_data,$user_id);
				if($deluser > 0)
				{
					$this->session->set_flashdata('success','User deleted successfully.');
					redirect(base_url().'backend/Users/manageUsers');	
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleting user.');
					redirect(base_url().'backend/Users/manageUsers');
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
	public function exportCustomerCSV()
	{
		$this->load->helper('download');
        $data['error']=$data['success']="";
		$todaysdate=date('d-M-YHi');
		
		// $data['session_from_date'] = $this->session->userdata('session_from_date');		
		// $data['session_to_date'] = $this->session->userdata('session_to_date');		
		// $input_data = array(
		// 	'from_date'=> $data['session_from_date'] ?? ''	,
		// 	'to_date'=>$data['session_to_date'] ?? '');
		
		$array[] = array('','','Bhooljao - Export CSV For Customer','','','');
		
		$i=1;

		$data['userList']=$userList=$this->User_model->getAllUsers(1,"","");

		$people = array('Sr.','Full Name','Email','Mobile','Gender','Status');
		$array[] =$people;

	   	if(isset($userList) && count($userList)>0)
		{  	
			foreach($userList as $g)
			{
				$user_id =$g['user_id'];
				$full_name=ucfirst($g['full_name']);
				$email=$g['email'];
				$mobile=$g['mobile'];
				$gender=$g['gender'];
				$status=$g['status'];
				
				//echo "<pre>";print_r($straddress); exit;
				if(is_array($people) &&count($people)> 0){
					foreach ($people as $key => $peopledtls) {
						$strVal = $peopledtls;
						switch ($peopledtls) {
							case 'Sr.':
								$strDtlVal = $i;
								break;
							case 'Full Name':
								$strDtlVal = $full_name;
								break;
							case 'Email':
								$strDtlVal = $email;
								break;
							case 'Mobile':
								$strDtlVal = $mobile;
								break;
							case 'Gender':
								$strDtlVal = $gender;
								break;
							case 'Status':
								$strDtlVal = $status;
								break;
						}
						
						$arrayCSV[$peopledtls]=$strDtlVal;
					}
				}
				$array[] = $arrayCSV;
				$i++;
			}
			#print_r($array); exit;
		}
		  $this->load->helper('csv');
		  $csvname = 'CustomerListExport'.$todaysdate.'.csv';
		  array_to_csv($array,$csvname);
		  $data['success']= "download sample export data successfully!";
	}

	public function manageServiceProvider()
	{
		$data['title']='Manage Service Providers';

		
		$data['serviceproviderscnt']=$this->User_model->getAllServiceProvider(0,"","");
		
		$config = array();
		$config["base_url"] = base_url().'backend/Users/manageServiceProvider/';
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
		$config["total_rows"] =$data['serviceproviderscnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		//echo "ConttPerPage--".$config["per_page"];
		//echo "Conttpage--".$page;
		//exit();
		$data['serviceproviders']=$this->User_model->getAllServiceProvider(1,$config["per_page"],$page);
		//echo $this->db->last_query();exit;
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/manageServiceProvider',$data);
		$this->load->view('admin/admin_footer');
	}

	public function addServiceprovider()
	{
		$data['title']='Add Service Provider';
		$data['error_msg']='';
		$data['zoneList']=$this->User_model->getAllzone(1,"","");
		$data['categoryList']=$this->User_model->getAllCategory(1,"","");
				
		if(isset($_POST['btn_addsp']))
		{
			$this->form_validation->set_rules('full_name','Full Name','required');
			$this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email');
			// $this->form_validation->set_rules('mobile_number', 'Mobile Number ', 'required'); //{10} for 10 digits number
			$this->form_validation->set_rules('category_id','Category Id','required');
			$this->form_validation->set_rules('zone_id','Zone Id','required');
			$this->form_validation->set_rules('password','Password','required');
					$this->form_validation->set_rules('address', 'Address ', 'required');
			$this->form_validation->set_rules('mobile_number', 'Mobile Number ', 'required|numeric|min_length[7]|max_length[13]'); //{10} for 10 digits number
			$this->form_validation->set_rules('gender','Gender','required');
			$this->form_validation->set_rules('status','Status','required');
			if($this->form_validation->run())
			{
				//echo "successfully validated";exit();
				$full_name=$this->input->post('full_name');
				$mobile_number=$this->input->post('mobile_number');
				$email_address=$this->input->post('email_address');
				$password=$this->input->post('password');
						$address=$this->input->post('address');
						$category_id=$this->input->post('category_id');
						$zone_id=$this->input->post('zone_id');
						$gender=$this->input->post('gender');
						$status=$this->input->post('status');
				//$description=$this->input->post('description');
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
				$usertitle=$this->User_model->chkUserName($mobile_number,$email_address,0);

				if($usertitle==0)
				{
					$input_data = array(
						'profile_pic'=>$servicefile,
							'full_name'=>trim($full_name),
							'email'=>$email_address,
							'password'=>md5($password),
							'gender'=>$gender,
							'mobile'=>$mobile_number,
							'address'=>$address,
							'status'=>$status,
							'category_id'=>$category_id,
							'zone_id'=>$zone_id,
							'user_type'=>'Service Provider',
						'dateupdated' => date('Y-m-d H:i:s'),
						'dateadded' => date('Y-m-d H:i:s')
						);

					/*echo"<pre>";
					print_r($input_data);
					exit();*/
					
					$user_id = $this->User_model->insert_user($input_data);
					
					if($user_id)
					{	
						$this->session->set_flashdata('success','Service provider added successfully.');

						redirect(base_url().'backend/Users/manageServiceProvider');	
					}
					else
					{
						$this->session->set_flashdata('error','Error while adding user.');

						redirect(base_url().'backend/Users/addServiceprovider/');
					}	
				}
				else
				{
					$this->session->set_flashdata('success','Username  already exist.');

					redirect(base_url().'backend/Users/addServiceprovider');	
				}

			}else{
				$this->session->set_flashdata('success','Validation failed. Please enter valid email or mobile number.');
				redirect(base_url().'backend/Users/addServiceprovider');
			}
		}

		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/addServiceprovider',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function updateServiceprovider()
	{
		$data['title']='Update Service Provider';
		$data['error_msg']='';
		//echo "segment--".$this->uri->segment(4);exit();
		$user_id=base64_decode($this->uri->segment(4));
		//echo "Brand_id--".$brand_id;exit();
		$data['zoneList']=$this->User_model->getAllzone(1,"","");
		$data['categoryList']=$this->User_model->getAllCategory(1,"","");
		if($user_id)
		{
			$userInfo=$this->User_model->getSingleUserInfo($user_id,0);
			if($userInfo>0)
			{
				$data['userInfo'] = $this->User_model->getSingleUserInfo($user_id,1);
				if(isset($_POST['btn_uptsp']))
				{
					$this->form_validation->set_rules('full_name','Full Name','required');
					$this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email');
					$this->form_validation->set_rules('mobile_number', 'Mobile Number ', 'required|numeric|min_length[7]|max_length[13]');
					//$this->form_validation->set_rules('password','Password','required');
					$this->form_validation->set_rules('address', 'Address ', 'required');
					$this->form_validation->set_rules('gender','Gender','required');
					$this->form_validation->set_rules('category_id','Category Id','required');
					$this->form_validation->set_rules('zone_id','Zone Id','required');
			        $this->form_validation->set_rules('status','User Status','required');

					if($this->form_validation->run())
					{
						$full_name=$this->input->post('full_name');
						$mobile_number=$this->input->post('mobile_number');
						$email_address=$this->input->post('email_address');
						//$password=$this->input->post('password');
						$address=$this->input->post('address');
						$category_id=$this->input->post('category_id');
						$zone_id=$this->input->post('zone_id');
						$gender=$this->input->post('gender');
						$status=$this->input->post('status');
						//$description = $this->input->post('description');
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
							
						$input_data = array(
							'profile_pic'=>$servicefile,
							'full_name'=>trim($full_name),
							'email'=>$email_address,
							//'password'=>md5($password),
							'gender'=>$gender,
							'mobile'=>$mobile_number,
							'address'=>$address,
							'status'=>$status,
							'category_id'=>$category_id,
							'zone_id'=>$zone_id,
							'user_type'=>'Service Provider',
							'dateupdated' => date('Y-m-d H:i:s'),
								);
					
						$userdata = $this->User_model->uptdateUser($input_data,$user_id);

						if($userdata)
						{	
							$this->session->set_flashdata('success','Service provider updated successfully.');

							redirect(base_url().'backend/Users/manageServiceProvider');	
						}
						else
						{
							$this->session->set_flashdata('error','Error while updating User.');

							redirect(base_url().'backend/Users/updateServiceprovider/'.base64_encode($user_id));
						}	
					}
					else
					{
						$this->session->set_flashdata('error',$this->form_validation->error_string());

						redirect(base_url().'backend/Users/updateServiceprovider/'.base64_encode($user_id));
					}
				}
			}
			else
			{
				$data['error_msg'] = 'Service provider not found.';
			}
		}
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/updateServiceprovider',$data);
		$this->load->view('admin/admin_footer');
	}

	public function deleteServiceprovider()
	{
		$data['error_msg']='';
		$user_id = base64_decode($this->uri->segment(4));
		if($user_id)
		{
			$userInfo = $data['userInfo'] = $this->User_model->getSingleUserInfo($user_id,1);
			if(count($userInfo) > 0)
			{   
				$input_data = array(
					'status'=>'Delete',
					'dateupdated' => date('Y-m-d H:i:s')
				);

				$deluser = $this->User_model->uptdateUser($input_data,$user_id);
				if($deluser > 0)
				{
					$this->session->set_flashdata('success','Service Provider deleted successfully.');
					redirect(base_url().'backend/Users/manageServiceProvider');	
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleting user.');
					redirect(base_url().'backend/Users/manageServiceProvider');
				}
			}
			else
			{
				$data['error_msg'] = 'User not found.';
			}
		}
		else
		{
			$this->session->set_flashdata('error','Service Provider not found.');
			redirect(base_url().'backend/Users/manageServiceProvider');
		}
	}

public function viewServiceProviderDetails()
	{
		$data['title']='View ServiceProvider Details';
		$user_id=base64_decode($this->uri->segment(4));
		//echo "user_id--".$user_id;exit();
		$data['user_id'] = $user_id;
		$user_id_base64 = base64_encode($user_id);
		$data['userinfo']=$this->User_model->getSingleUserInfo($user_id,1);
		$data['bookingList']=$this->User_model->getAllServiceBooking($user_id,1,"","");
		
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/viewServiceProviderDetails',$data);
		$this->load->view('admin/admin_footer');
	}






	public function exportSPCSV()
	{
		$this->load->helper('download');
        $data['error']=$data['success']="";
		$todaysdate=date('d-M-YHi');
		
		// $data['session_from_date'] = $this->session->userdata('session_from_date');		
		// $data['session_to_date'] = $this->session->userdata('session_to_date');		
		// $input_data = array(
		// 	'from_date'=> $data['session_from_date'] ?? ''	,
		// 	'to_date'=>$data['session_to_date'] ?? '');
		
		$array[] = array('','','Bhooljao - Export CSV For Service Provider','','','');
		
		$i=1;

		$data['userList']=$userList=$this->User_model->getAllServiceProvider(1,"","");

		$people = array('Sr.','Full Name','Email','Mobile','Gender','Status');
		$array[] =$people;

	   	if(isset($userList) && count($userList)>0)
		{  	
			foreach($userList as $g)
			{
				$user_id =$g['user_id'];
				$full_name=ucfirst($g['full_name']);
				$email=$g['email'];
				$mobile=$g['mobile'];
				$gender=$g['gender'];
				$status=$g['status'];
				
				//echo "<pre>";print_r($straddress); exit;
				if(is_array($people) &&count($people)> 0){
					foreach ($people as $key => $peopledtls) {
						$strVal = $peopledtls;
						switch ($peopledtls) {
							case 'Sr.':
								$strDtlVal = $i;
								break;
							case 'Full Name':
								$strDtlVal = $full_name;
								break;
							case 'Email':
								$strDtlVal = $email;
								break;
							case 'Mobile':
								$strDtlVal = $mobile;
								break;
							case 'Gender':
								$strDtlVal = $gender;
								break;
							case 'Status':
								$strDtlVal = $status;
								break;
						}
						
						$arrayCSV[$peopledtls]=$strDtlVal;
					}
				}
				$array[] = $arrayCSV;
				$i++;
			}
			#print_r($array); exit;
		}
		  $this->load->helper('csv');
		  $csvname = 'ServiceProviderListExport'.$todaysdate.'.csv';
		  array_to_csv($array,$csvname);
		  $data['success']= "download sample export data successfully!";
	}
}