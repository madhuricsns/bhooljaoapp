<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
	
	public function __construct() 
	{
		//call CodeIgniter's default Constructor
		parent::__construct();
		#$this->load->helpers('commonfunctions');
		
		$this->load->model('Login_model');
	}
	
	public function index()
	{
		//echo "in index";exit();
		$data['title']='Login';
		
		if(isset($_POST['btn_login']))
		{	
			//echo "in post";
		    //print_r($_POST);exit;
			$this->form_validation->set_rules('username','User Name','required');
			$this->form_validation->set_rules('password','User Password','required');
			if($this->form_validation->run())
			{
				//echo "validation success";exit();
				
				$username=$this->input->post('username');
				$password=$this->input->post('password');
				//echo "pass--".$password;exit();
				//echo md5($this->input->post('admin_password'));exit;
				
				$data = array('username' => $username,
								'password' => $password);
				/*echo"<pre>";
				print_r($data);
				exit();*/
				
				$result11 = $this->Login_model->chk_login_username($data);
				/*echo"<pre>";
				print_r($result11);
				exit();*/
				
				if ($result11>0) 
				{
						
						$result1 = $this->Login_model->chk_login($data,0);

                 /*echo"<pre>";
				print_r($result1);
				exit();*/
						//echo $this->db->last_query();exit;
						if ($result1>0) 
						{
							$result = $this->Login_model->chk_login($data,1);
							//print_r($result);exit;
							$status=$result[0]['status'];
							
							if($status=='Active')
							{
								
								$session_data = array(
															'userid' => $result[0]['userid'],

															'username' => $result[0]['username'],
															'status'=>$result[0]['status']);
								
								$this->session->set_userdata('logged_in', $session_data);
								
								
								redirect('home/maps', 'refresh');
							}
							else  if($status=='Inactive')
							{
								$this->session->set_flashdata('error', 'Inactive Status.');
								redirect('login/index', 'refresh');
							}
							else  
							{
								$this->session->set_flashdata('error', 'Record deleted.');
								redirect('login/index', 'refresh');
							}
						}
						else
						{ 
							$this->session->set_flashdata('error','Incorrect password.');//$this->session->set_flashdata('error','Invalid Creditionals.');
							redirect('login/index', 'refresh');
						}
					
				}
				else
				{ 
					$this->session->set_flashdata('error','Invalid username.');
					redirect('login/index', 'refresh');
				}
			}
			else
			{
				$this->session->set_flashdata('error',$this->form_validation->error_string());
				redirect('login/index', 'refresh');
			}
		}
		$this->load->view('frontend/front_header',$data);
		$this->load->view('frontend/loginpage',$data);
		$this->load->view('frontend/front_footer',$data);
	}
	
	public function logout()
	{
		if(isset($this->session->userdata['logged_in']))
		{
			$sessiondata=$this->session->userdata('logged_in');
			
			unset($_SESSION['logged_in']);
			$this->session->sess_destroy();
			redirect('Login','refresh');
		}
		else
		{ 
			redirect('/','refresh');
		}
	}
}