<?php	
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller { 
	
	public function __construct()
	{
		 parent::__construct();
		 //$this->load->helper("commonfunctions");		
		 $this->load->model('adminModel/Login_model');
		 $this->load->model('Common_Model');
	}
	public function index()
	{
		if(isset($_POST['btn_login']))
		{	#print_r($_POST);exit;
			//echo "in index";exit()
			$this->form_validation->set_rules('username','User Name','required');
			$this->form_validation->set_rules('admin_password','Admin Password','required');
			if($this->form_validation->run())
			{
				$username=$this->input->post('username');
				$admin_password=$this->input->post('admin_password');
				// echo md5($this->input->post('admin_password'));exit;
				
				$data = array('username' => $this->input->post('username')
								,'admin_password' => $this->input->post('admin_password'));
				
				$result11 = $this->Login_model->chk_login_username($data);
				// echo $this->db->last_query();exit;
				if ($result11>0) 
				{
						$result1 = $this->Login_model->chk_login($data,0);

						//echo $this->db->last_query();exit;
						if ($result1>0) 
						{
							$result = $this->Login_model->chk_login($data,1);
							#print_r($result);exit;
							$status=$result[0]['status'];
							
							if($status=='Active')
							{
								
								$session_data = array(
										'admin_id' => $result[0]['admin_id'],
										'admin_name' => $result[0]['admin_name'],
										'username' => $result[0]['username'],
										'mobile_number' => $result[0]['mobile_number'],
										'user_type' => $result[0]['user_type'],
										
										'status'=>$result[0]['status']);
								
								$this->session->set_userdata('logged_in', $session_data);
								redirect('backend/Dashboard/index', 'refresh');
							}
							else  if($status=='Inactive')
							{
								$this->session->set_flashdata('error', 'Inactive Status.');
								redirect('backend/login/index', 'refresh');
							}
							else  
							{
								$this->session->set_flashdata('error', 'Record deleted.');
								redirect('backend/login/index', 'refresh');
							}
						}
						else
						{ 
							$this->session->set_flashdata('error','Incorrect password.');//$this->session->set_flashdata('error','Invalid Creditionals.');
							redirect('backend/login/index', 'refresh');
						}
					
				}
				else
				{ 
					$this->session->set_flashdata('error','Invalid username.');
					redirect('backend/login/index', 'refresh');
				}
			}
			else
			{
				$this->session->set_flashdata('error',$this->form_validation->error_string());
				redirect('admin/login/index', 'refresh');
			}
		}
		$this->load->view('admin/login');
	}

	public function  logout()
	{
		if(isset($this->session->userdata['logged_in']))
		{
			unset($_SESSION['logged_in']);
			$this->session->sess_destroy();
			redirect('backend/Login','refresh');
		}
		else
		{ 

			redirect('backend/Dashboard','refresh');

		}
	}

 public function forgotpassword()
	{
		$data['error']=$data['success']='';
		if(isset($_POST['btn_forget_password']))
		{		//print_r($_POST);exit;
			$this->form_validation->set_rules('email_address','Email address','required|valid_email');
			
			if($this->form_validation->run())
			{
				$admin_email=$this->input->post('email_address');
				$user_type=$this->input->post('user_type');;
				
				$chk_email=$this->Login_model->chkAdminEmailExists($admin_email,$user_type);
				//echo $this->db->last_query();exit;
				
				if(isset($chk_email)&& count($chk_email)>0)
				{
					$rnd_number=rand(pow(10, 5),pow(10, 6)-1);// Crate 4 Digit Random Number for OTP 
								
					$rnd_number = "123456"; //default SMS
					
					if($user_type=='Admin')
					{
						$admin_name=$chk_email[0]['admin_name'];
						$subject_mail='Admin';
						//update for admin password
						$uptem=$this->Login_model->upadteAdminPassword($user_type,$admin_email,$rnd_number);
					}
					else if($user_type=='Subadmin')
					{
						$admin_name=$chk_email[0]['admin_name'];
						$subject_mail='Subadmin';
						//update for admin password
						$uptem=$this->Login_model->upadteAdminPassword($user_type,$admin_email,$rnd_number);
					}
					$output_arr=array('view_load'=>'adminside_forgot_password');
					$input_arr=array('adminname'=>$admin_name,
									'base_pat'=>base_url(),
									'rnd_number'=>$rnd_number,
									'subject_mail'=>'Bhooljao:'.$subject_mail.'  Regarding Forgot Password');
					
					//echo 'pp';exit;
					// $ress=$this->Common_Model->SendMail($admin_email,$output_arr,$input_arr);
					//
					// if($ress)
					// {
						//$data['success']='Password is send to your mail successfully.';
						$this->session->set_flashdata('success', 'Password is send to your mail successfully.');
						redirect(base_url().'backend/Login/index', 'refresh');
						
					// }
					// else
					// {
					// 	$data['error']= 'Error while sending mail';
					// }
				}
				else
				{
					$data['error']='Email address is not exists';
				}
			}
			else
			{
				$this->session->set_flashdata('error_msg', $this->form_validation->error_string());
						redirect(base_url().'backend/login/forgotpassword', 'refresh');
			}
		}
		$this->load->view('admin/forgetpasword',$data);
	}


	 public function randomPassword() 

	 {

		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

		$pass = array(); //remember to declare $pass as an array

		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache

		for ($i = 0; $i < 8; $i++) 

		{

			$n = rand(0, $alphaLength);

			$pass[] = $alphabet[$n];

		}

		return implode($pass); //turn the array into a string

	}

}

