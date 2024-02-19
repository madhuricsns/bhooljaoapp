<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller {
	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('Admin_model');
		 $this->load->library("pagination");
		 $this->load->model('Common_Model');
		 if(! $this->session->userdata('logged_in'))
		 {
			redirect('Login', 'refresh');
		 }
	}
	// code for manage Admin
	public function manageAdmin()
	{
		$data['title']='Manage Admin';
		$data['cmpCnt']=$this->Admin_model->getAdminCnt();
		$data['adminInfo']=$this->Admin_model->getAdminInfo();
		$this->load->view('frontend/front_header',$data);
		$this->load->view('frontend/manageAdmin',$data);
		$this->load->view('frontend/front_footer',$data);
	}
   
	## Add Admin 
	public function addAdmin()
	{
		$data['title']='Add New Admin';
		
		if(isset($_POST['btn_save_admin']))
		{
			//print_r($_POST);
			$this->form_validation->set_rules('admin_name','Admin Name','required');
			$this->form_validation->set_rules('username','Username','required');
			$this->form_validation->set_rules('admin_password','Admin Password','required');
			$this->form_validation->set_rules('admin_email','Admin Email','required');
			
			if($this->form_validation->run())
			{
				$admin_name=$this->input->post('admin_name');
				$admin_email=$this->input->post('admin_email');
				$username=$this->input->post('username');
				$admin_password=$this->input->post('admin_password');
				$mobile_number=$this->input->post('mobile_number');
				$status=$this->input->post('status');
				
				// check already category exists
				$admin_exists = $this->Admin_model->check_adminexists($admin_email,$username,"");
				 
				if($admin_exists == 0)
				{
					$admin_password = md5($admin_password);
					$input_data=array(
										'admin_name'=>$admin_name,
										'admin_email'=>$admin_email,
										'username'=>$username,
										'admin_password'=>$admin_password,
										'mobile_number'=>$mobile_number,
										'user_type'=>'Admin',
										'status'=>$status,
										'dateadded'=>date('Y-m-d H:i:s'),
										'dateupdated'=>date('Y-m-d H:i:s'),
									);
					
					$admin_id=$this->Admin_model->add_admin($input_data);
						//echo $this->db->last_query();exit;
					if($admin_id > 0)
					{
						$this->session->set_flashdata('success','Record added successfully.');
						redirect(base_url().'Admin/manageAdmin');	
					}
					else
					{	   
						$data['adminInfo'] = $_POST;
						$this->session->set_flashdata('error','Error while adding record.');
					}
				}
				else
				{
						$data['adminInfo'] = $_POST;
						$this->session->set_flashdata('error','Admin already exists.');		
				}
			}
			else
			{
				$data['adminInfo'] = $_POST;
				$this->session->set_flashdata('error',$this->form_validation->error_string());
			}
		}
		$this->load->view('frontend/front_header',$data);
		$this->load->view('frontend/addAdmin',$data);
		$this->load->view('frontend/front_footer',$data);
	}
	
	public function updateAdmin()
	{
		$data['title']='Update Admin';
		$data['error_msg']='';
		$adminId=base64_decode($this->uri->segment(3));
		if($adminId)
		{
			$numadminInfo =$this->Admin_model->getAdminDetails($adminId,0);
			
			if($numadminInfo  > 0)
			{
				$data['adminInfo'] =$this->Admin_model->getAdminDetails($adminId,1);
				//print_r($data['adminInfo']);exit;
				if(isset($_POST['btn_save_admin']))
				{
					$this->form_validation->set_rules('admin_name','Admin Name','required');
					$this->form_validation->set_rules('username','Username','required');
					$this->form_validation->set_rules('admin_email','Admin Email','required');
					
					if($this->form_validation->run())
					{
						$admin_name=$this->input->post('admin_name');
						$admin_email=$this->input->post('admin_email');
						$username=$this->input->post('username');
						$admin_password=$this->input->post('admin_password');
						$mobile_number=$this->input->post('mobile_number');
						$status=$this->input->post('status');
						
						$admin_exists = $this->Admin_model->check_adminexists($admin_email,$username,$adminId);
					//	echo $this->db->last_query();exit;
						if($admin_exists==0)
						{
							if($admin_password != "")
							{
								$admin_password = md5($admin_password);
								$input_data['admin_password'] = $admin_password;
							}
							$strUserType = "Admin";	
							$input_data=array(
												'admin_name'=>$admin_name,
												'admin_email'=>$admin_email,
												'username'=>$username,
												'mobile_number'=>$mobile_number,
												'user_type'=>$strUserType,
												'status'=>$status,
												'dateupdated'=>date('Y-m-d H:i:s'),
											);
							$retid=$this->Admin_model->upt_admin($input_data,$adminId);
							#echo $this->db->last_query();exit;
							if($retid)
							{
								$this->session->set_flashdata('success','Record updated successfully.');
								redirect(base_url().'Admin/manageAdmin');
							}
							else
							{
								$data['adminInfo'] = $_POST;
								$this->session->set_flashdata('error','Error while updating record.');
								#redirect(base_url().'Company/updateCompany/'.base64_encode($cmp_id));
							}							
						}
						else
						{
							$data['adminInfo'] = $_POST;
							$this->session->set_flashdata('error','Admin already exists.');
						}
					}
					else
					{
						$data['adminInfo'] = $_POST;
						$this->session->set_flashdata('error',$this->form_validation->error_string());
					}
				}
			}
			else
			{
				$data['error_msg']='Record is not found.';
			}
		}
		else
		{
			$this->session->set_flashdata('error','Record is not found.');
			redirect(base_url().'Admin/manageAdmin/');
		}
		$this->load->view('frontend/front_header',$data);
		$this->load->view('frontend/updateAdmin',$data);
		$this->load->view('frontend/front_footer',$data);
	}
	
	public function deleteuser()
	{
		$data['page_title']='Delete User';
		$data['error_msg']='';
		$user_id = base64_decode($this->uri->segment(3));
		if($user_id)
		{
			$delcat=$this->Admin_model->upt_admin(array('status'=>'Delete'),$user_id);
				if($delcat>0)
				{
					$this->session->set_flashdata('success','User deleted successfully.');
					redirect(base_url().'Admin/manageAdmin');	
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleting User.');
					redirect(base_url().'Admin/manageAdmin');
				}
		}
		else
		{
			$this->session->set_flashdata('error','User is not found.');
			redirect(base_url().'Admin/manageAdmin');
		}
	}	
	
	public function adminDetails()
	{
		$data['title']='Admin Details';
		$arrSession = $this->session->userdata('logged_in');
		$admin_id = $arrSession['admin_id'];
		$data['error_msg']='';
		$data['adminInfo']=$this->Admin_model->getAdminDetails($admin_id);
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/adminDetails',$data);
		$this->load->view('admin/admin_footer');
	}

	// code for change Password
	public function changePassword()
	{
		$arrSession = $this->session->userdata('logged_in');
		$admin_id = $arrSession['admin_id'];
		$data['title']='Change Password';
		$data['error_msg']='';
		if(isset($_POST['btn_chnagePassword']))
		{
			$this->form_validation->set_rules('old_password','Old Password','required');
			$this->form_validation->set_rules('admin_password','New Password','required');
			$this->form_validation->set_rules('confirm_password','Confirm Password','required');
			if($this->form_validation->run())
			{
				$old_password=$this->input->post('old_password');
				$admin_password=$this->input->post('admin_password');
				$confirm_password=$this->input->post('confirm_password');
				if($admin_password==$confirm_password)
				{
					$oldPass=$this->Admin_model->checkAdminPassword($old_password,$admin_id);
					if($oldPass>0)
					{  
					   // echo "<pre>";print_r($arrSession); exit;
						$asmin_id=$this->Admin_model->udatPassord($admin_password,$arrSession['admin_id']);
						//echo $this->db->last_query();exit;
						if($asmin_id)
						{	// echo '///';exit;

							$this->session->set_flashdata('success','Password change successfully.');
							redirect(base_url().'Admin/ChangePassword');	
						}
						else
						{
							$this->session->set_flashdata('error','Error while updating record.');
							redirect(base_url().'Admin/ChangePassword');
						}							
					}
					else
					{
							$this->session->set_flashdata('error','Old password is not match');
							redirect(base_url().'Admin/ChangePassword');								
					}
				}
				else
				{
						$this->session->set_flashdata('error','Confirm password is npt match with new password');
						redirect(base_url().'Admin/ChangePassword');								
				}
			}
			else
			{
				$this->session->set_flashdata('error',$this->form_validation->error_string());
				redirect(base_url().'Admin/ChangePassword');
			}
		}
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/changePassword',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function updateprofile()
	{
		$data['title']='Update Profile';
		$data['error_msg']='';
		 $sessiondata=$this->session->userdata('logged_in');
		$session_admin_id=$sessiondata['admin_id']; 
		$data['session_admin_name']=$session_admin_name=$sessiondata['admin_name'];
		$session_user_type=$sessiondata['user_type'];

		/*if($session_user_type=="Admin")
		{*/
			$data['adminInfo'] =$this->Admin_model->getAdminDetails($session_admin_id,1);
			#print_r($data['adminInfo']);exit;
			if(isset($_POST['btn_updateprofile']))
			{
				$this->form_validation->set_rules('admin_name','Admin Name','required');
				$this->form_validation->set_rules('username','Username','required');
				$this->form_validation->set_rules('admin_address','Address','required');
				$this->form_validation->set_rules('admin_email','Admin Email','required|valid_email');
				
				if($this->form_validation->run())
				{
					$admin_name=$this->input->post('admin_name');
					$admin_email=$this->input->post('admin_email');
					$username=$this->input->post('username');
					$admin_address=$this->input->post('admin_address');
					
					$mobile_number=$this->input->post('mobile_number');
					$status='Active';
					
					
					//$strUserType = "Admin";	
					$latitude = $longitude = '';
					if($admin_address != '')
					{
						$latlngarr = $this->Common_Model->get_lat_long($admin_address);
						if(isset($latlngarr))
						{
						  $latitude=$latlngarr['latitude'];
						  $longitude=$latlngarr['longitude'];
						}
					}
					// $latlong=$this->Common_Model->get_lat_long($admin_address);
					// 	$parts=explode(",",$latlong);
					// 	$address_lat=$parts[0];
					// 	$address_long=$parts[1];
						
					$input_data=array(
										'admin_name'=>$admin_name,
										'admin_email'=>$admin_email,
										'username'=>$username,
										'admin_address'=>addslashes($admin_address),
										'mobile_number'=>$mobile_number,
										//'user_type'=>$strUserType,
										'status'=>$status,
										'address_lat'=>$latitude,
										'address_long'=>$longitude,
										'dateupdated'=>date('Y-m-d H:i:s')
									);
					if($_POST['admin_password']!= "")
					{
						$admin_password=$_POST['admin_password'];
						$admin_password = md5($admin_password);
						$input_data['admin_password'] = $admin_password;
					}				
					$retid=$this->Admin_model->upt_admin($input_data,$session_admin_id);
					#echo $this->db->last_query();exit;
					if($retid)
					{
						$this->session->set_flashdata('success','Record updated successfully.');
						redirect(base_url().'Admin/updateprofile');
					}
					else
					{
						$data['adminInfo'] = $_POST;
						$this->session->set_flashdata('error','Error while updating record.');
						redirect(base_url().'Admin/updateprofile');
					}
				}
				else
				{
					$data['adminInfo'] = $_POST;
					$this->session->set_flashdata('error',$this->form_validation->error_string());
					redirect(base_url().'Admin/updateprofile');
				}
			}
			$this->load->view('admin/admin_header',$data);		
			$this->load->view('admin/admin_right',$data);		
			$this->load->view('admin/updateprofile',$data);		
			$this->load->view('admin/admin_footer');
	}

	// function to get  the address
	public function get_lat_long($address)
	{
		$address = str_replace(" ", "+", $address);
		//echo "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
		//exit;
		$json1 = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=AIzaSyD7CJZzaVXcO18AfuhbZkKzw7P2MKuivm8");
		$json = json_decode($json1);

		$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
		$longl = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
		return $lat.','.$longl;
		//return "19.95099258,73.84654236";
		//echo json_encode(array('lat'=>$lat,'longl'=>$longl));
	}
}