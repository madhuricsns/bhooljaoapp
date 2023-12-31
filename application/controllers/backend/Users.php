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
		$this->load->model('Common_Model');
	}
	public function index()
	{
		redirect(base_url().'backend/Users/manageUsers','refresh');
	}
	public function manageUsers()
	{
		$data['title']='Manage Customer';

		$per_page='10';
		$pageNo ='';
		if($this->uri->segment(4)!='')
		{
			if($this->uri->segment(4)!="Na")
			{
				$pageNo=($this->uri->segment(4));
			}
		}

		if($this->uri->segment(5)!='')
		{
			if($this->uri->segment(5)!="Na")
			{
				$per_page=($this->uri->segment(5));
			}
		}
		else
		{
			$per_page='10';
		}
		
		$data['usercnt']=$this->User_model->getAllUsers(0,"","");
		
		$config = array();
		
		$config["base_url"] = base_url().'backend/Users/manageUsers/'.$pageNo.'/'.$per_page;
		// $config['per_page'] = 10;
		if($per_page>100)
		{
			$config['per_page'] = 100;
		}
		else
		{
			$config['per_page'] = $per_page;
		}
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
		$data['title']='Add Customer';
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
									'upload_path' => "uploads/user_profile/",
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
							redirect(base_url().'backend/Users/addUser');

						}
						if($_FILES['servicefile']['error']==0)
						{ 
							$servicefile=$photo_imagename;
						}
					}
				}	
						
				$usertitle=$this->User_model->chkUserName($mobile_number,$email_address,0);

				if($usertitle == 0)
				{
					$profile_id = "BJC".$this->Common_Model->randomCode();
					$input_data = array(
						'profile_id'=>$profile_id,
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
						$this->session->set_flashdata('success','Customer added successfully.');
						redirect(base_url().'backend/Users/manageUsers');	
					}
					else
					{
						$this->session->set_flashdata('error','Error while adding Customer.');
						redirect(base_url().'backend/Users/addUser/');
					}	
				}
				else
				{
					$this->session->set_flashdata('error','Customer Mobile and Email already exist.');
					redirect(base_url().'backend/Users/addUser');	
				}

			}else{
				$this->session->set_flashdata('success','Validation failed.');
				redirect(base_url().'backend/Users/addUser');
			}
		}

		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/addUser',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function updateUser()
	{
		$data['title']='Update Customer';
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
										'upload_path' => "uploads/user_profile/",
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
								redirect(base_url().'backend/Users/manageUsers');

							}
							if($_FILES['servicefile']['error']==0)
							{ 
								$servicefile=$photo_imagename;
							}
						}
					}	
							
					if($servicefile!="")
						{
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
						}
						else
						{
							$input_data = array(
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
						}

						$UserdataFound = $this->User_model->checkuptdateUser($mobile_number,$user_id);
						if($UserdataFound==0)
						{
							$userdata = $this->User_model->uptdateUser($input_data,$user_id);

							if($userdata)
							{	
								$this->session->set_flashdata('success','Customer updated successfully.');

								redirect(base_url().'backend/Users/manageUsers');	
							}
							else
							{
								$this->session->set_flashdata('error','Error while updating Customer.');

								redirect(base_url().'backend/Users/updateUser/'.base64_encode($user_id));
							}
						}	
						else
						{
							$this->session->set_flashdata('error','Mobile number already register.');

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
				$data['error_msg'] = 'Customer not found.';
			}
		}
		
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/updateUser',$data);
		$this->load->view('admin/admin_footer');
	}

	
	public function viewUserDetails()
	{
		$data['title']='View Customer Details';
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
		$data['title']='Manage Service Givers';
$per_page='10';
		$pageNo ='';
		if($this->uri->segment(4)!='')
		{
			if($this->uri->segment(4)!="Na")
			{
				$pageNo=($this->uri->segment(4));
			}
		}

		if($this->uri->segment(5)!='')
		{
			if($this->uri->segment(5)!="Na")
			{
				$per_page=($this->uri->segment(5));
			}
		}
		else
		{
			$per_page='10';
		}
		
		$data['serviceproviderscnt']=$this->User_model->getAllServiceProvider(0,"","");
		
		$config = array();
		
		$config["base_url"] = base_url().'backend/Users/manageServiceProvider/'.$pageNo.'/'.$per_page;
		// $config['per_page'] = 10;
		if($per_page>100)
		{
			$config['per_page'] = 100;
		}
		else
		{
			$config['per_page'] = $per_page;
		}
		
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
		$data['title']='Add Service Giver';
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
			$this->form_validation->set_rules('experience','Experience','required');
			$this->form_validation->set_rules('mobile_number', 'Mobile Number ', 'required|numeric|min_length[7]|max_length[13]'); //{10} for 10 digits number
			$this->form_validation->set_rules('gender','Gender','required');
			$this->form_validation->set_rules('status','Status','required');
			$this->form_validation->set_rules('is_verified','Is Verified','required');
			if($this->form_validation->run())
			{
				//echo "successfully validated";exit();
				$full_name=$this->input->post('full_name');
				$mobile_number=$this->input->post('mobile_number');
				$email_address=$this->input->post('email_address');
				$password=$this->input->post('password');
				$address=$this->input->post('address');
				$experience=$this->input->post('experience');
				$category_id=$this->input->post('category_id');
				$zone_id=$this->input->post('zone_id');
				$gender=$this->input->post('gender');
				$status=$this->input->post('status');
				$is_verified=$this->input->post('is_verified');
				//$description=$this->input->post('description');
				$servicefile='';
				if($_FILES['servicefile'])
				{
					if($_FILES['servicefile']['name']!="")
					{
						$photo_imagename='';
						$new_image_name = rand(1, 99999).$_FILES['servicefile']['name'];
						$config = array(
									'upload_path' => "uploads/user_profile/",
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
							redirect(base_url().'backend/Users/addServiceprovider');

						}
						if($_FILES['servicefile']['error']==0)
						{ 
							$servicefile=$photo_imagename;
						}
					}
				}	
				$checkexist=$this->User_model->chkSPName($mobile_number,$email_address,0);

				if($checkexist==0)
				{
					$profile_id = "BJS".$this->Common_Model->randomCode();
					$latitude = $longitude = '';
					if($address != '')
					{
						$latlngarr = $this->Common_Model->get_lat_long($address);
						if(isset($latlngarr))
						{
						  $latitude=$latlngarr['latitude'];
						  $longitude=$latlngarr['longitude'];
						}
					}

					$input_data = array(
						'profile_id'=>$profile_id,
						'profile_pic'=>$servicefile,
						'full_name'=>trim($full_name),
						'email'=>$email_address,
						'password'=>md5($password),
						'gender'=>$gender,
						'mobile'=>$mobile_number,
						'address'=>$address,
						'experience'=>$experience,
						'user_lat'=>$latitude,
						'user_long'=>$longitude,
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
						if($is_verified=='Yes')
						{
							$inputData=array('service_provider_id'=>$user_id,'is_verified'=>$is_verified,'dateadded'=>date('Y-m-d H:i:s'));
							$this->Common_Model->insert_data('sp_favourite_verify',$inputData);
						}
						$this->session->set_flashdata('success','Service Giver added successfully.');

						redirect(base_url().'backend/Users/manageServiceProvider');	
					}
					else
					{
						$this->session->set_flashdata('error','Error while adding Service Giver.');

						redirect(base_url().'backend/Users/addServiceprovider/');
					}	
				}
				else
				{
					$this->session->set_flashdata('error','Service Giver already exist.');
					redirect(base_url().'backend/Users/addServiceprovider');	
				}

			}else{
				$this->session->set_flashdata('success','Validation failed.');
				redirect(base_url().'backend/Users/addServiceprovider');
			}
		}

		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/addServiceprovider',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function updateServiceprovider()
	{
		$data['title']='Update Service Giver';
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
				$isVerifiedExist= $this->User_model->isVerified($user_id,0);
				if($isVerifiedExist>0)
				{
					$isVerified= $this->User_model->isVerified($user_id,1);
					$data['isVerified']=$isVerified->is_verified;
					$data['favourite_id']=$isVerified->favourite_id;
				}
				else
				{
					$data['isVerified']="No";
					$data['favourite_id']="0";
				}
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
					$this->form_validation->set_rules('experience','Experience','required');
			        $this->form_validation->set_rules('status','User Status','required');
			        $this->form_validation->set_rules('is_verified','is_verified','required');

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
						$experience=$this->input->post('experience');
						$status=$this->input->post('status');
						$is_verified = $this->input->post('is_verified');
						$favourite_id = $this->input->post('favourite_id');
						$servicefile='';
						if($_FILES['servicefile'])
						{
							if($_FILES['servicefile']['name']!="")
							{
								$photo_imagename='';
								$new_image_name = rand(1, 99999).$_FILES['servicefile']['name'];
								$config = array(
											'upload_path' => "uploads/user_profile/",
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
									redirect(base_url().'backend/Users/manageServiceProvider');

								}
								if($_FILES['servicefile']['error']==0)
								{ 
									$servicefile=$photo_imagename;
								}
							}
						}
				
						$latitude = $longitude = '';
						if($address != '')
						{
							$latlngarr = $this->Common_Model->get_lat_long($address);
							if(isset($latlngarr))
							{
							  $latitude=$latlngarr['latitude'];
							  $longitude=$latlngarr['longitude'];
							}
						}

						if($servicefile!="")
						{
							$input_data = array(
								'profile_pic'=>$servicefile,
								'full_name'=>trim($full_name),
								'email'=>$email_address,
								'gender'=>$gender,
								'mobile'=>$mobile_number,
								'address'=>$address,
								'user_lat'=>$latitude,
								'user_long'=>$longitude,
								'status'=>$status,
								'category_id'=>$category_id,
								'zone_id'=>$zone_id,
								'experience'=>$experience,
								'user_type'=>'Service Provider',
								'dateupdated' => date('Y-m-d H:i:s'),
								);
						}
						else
						{
							$input_data = array(
								'full_name'=>trim($full_name),
								'email'=>$email_address,
								'gender'=>$gender,
								'mobile'=>$mobile_number,
								'address'=>$address,
								'user_lat'=>$latitude,
								'user_long'=>$longitude,
								'status'=>$status,
								'category_id'=>$category_id,
								'zone_id'=>$zone_id,
								'experience'=>$experience,
								'user_type'=>'Service Provider',
								'dateupdated' => date('Y-m-d H:i:s'),
								);
						}

						$spdataFound = $this->User_model->checkuptdateSP($mobile_number,$user_id);
						if($spdataFound==0)
						{
							$userdata = $this->User_model->uptdateSP($input_data,$user_id);

							if($favourite_id>0)
							{
								$inputData=array('service_provider_id'=>$user_id,'is_verified'=>$is_verified,'dateupdated'=>date('Y-m-d H:i:s'));
								// print_r($inputData);
								$this->Common_Model->update_data('sp_favourite_verify','favourite_id',$favourite_id,$inputData);
								// echo $this->db->last_query();
							}
							else
							{
								$inputData=array('service_provider_id'=>$user_id,'is_verified'=>$is_verified,'dateadded'=>date('Y-m-d H:i:s'));
								$this->Common_Model->insert_data('sp_favourite_verify',$inputData);
							}

							if($userdata)
							{	
								$this->session->set_flashdata('success','Service Giver updated successfully.');

								redirect(base_url().'backend/Users/manageServiceProvider');	
							}
							else
							{
								$this->session->set_flashdata('error','Error while updating Service Giver.');

								redirect(base_url().'backend/Users/updateServiceprovider/'.base64_encode($user_id));
							}
						}
						else
						{
							$this->session->set_flashdata('error','Mobile Number already register.');

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
				$data['error_msg'] = 'Service Giver not found.';
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
					$this->session->set_flashdata('success','Service Giver deleted successfully.');
					redirect(base_url().'backend/Users/manageServiceProvider');	
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleting Service Giver.');
					redirect(base_url().'backend/Users/manageServiceProvider');
				}
			}
			else
			{
				$data['error_msg'] = 'Service Giver not found.';
			}
		}
		else
		{
			$this->session->set_flashdata('error','Service Giver not found.');
			redirect(base_url().'backend/Users/manageServiceProvider');
		}
	}

public function viewServiceProviderDetails()
	{
		$data['title']='View Service Giver Details';
		$user_id=base64_decode($this->uri->segment(4));
		//echo "user_id--".$user_id;exit();
		$data['user_id'] = $user_id;
		$user_id_base64 = base64_encode($user_id);
		$data['userinfo']=$this->User_model->getSingleUserInfo($user_id,1);
		$data['bookingList']=$this->User_model->getAllServiceBooking($user_id,1,"","");
		$data['zoneList']=$this->User_model->getAllzone(1,"","");
		$data['categoryList']=$this->User_model->getAllCategory(1,"","");
		//  Review
		$data['reviewList']=$arrReviews=$this->User_model->getReviews($user_id);
		//echo $this->db->last_query();
		$star1=$star2=$star3=$star4=$star5=$rowCount=$average=$percent=0;
		foreach($arrReviews as $key=>$review)
		{
			$reviewdate = new DateTime($review['dateadded']);
			$review['dateadded'] = $reviewdate->format('d M Y');

			if($review['rating']=='1')
			{
				$star1+=$review['rating'];
			}
			if($review['rating']=='2')
			{
				$star2+=$review['rating'];
			}
			if($review['rating']=='3')
			{
				$star3+=$review['rating'];
			}
			if($review['rating']=='4')
			{
				$star4+=$review['rating'];
			}
			if($review['rating']=='5')
			{
				$star5+=$review['rating'];
			}
			$arrReviews[$key]=$review;
		}
		$data['star1']=$star1;
		$data['star2']=$star2;
		$data['star3']=$star3;
		$data['star4']=$star4;
		$data['star5']=$star5;
		$tot_stars = $star1 + $star2 + $star3 + $star4 + $star5;
		$reviewCount=count($arrReviews);
		if($tot_stars>0)
		{
			$average = $tot_stars/$reviewCount;
		}
		$data['rating_avg']=$average;
		$data['total_rating']=$reviewCount;
		//End Review & Rating Count
		
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
		
		$array[] = array('','','Bhooljao - Export CSV For Service Giver','','','');
		
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