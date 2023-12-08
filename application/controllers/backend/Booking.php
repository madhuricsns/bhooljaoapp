<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {
	public function __construct(){
		parent::__construct();
	if(empty($this->session->userdata('logged_in'))){
			redirect(base_url().'backend/login','refresh');  
		}
		$this->load->library("pagination");	
		$this->load->helper('email');
		$this->load->library('session');
		$this->load->model('adminModel/Booking_model');
		$this->load->model('adminModel/User_model');
		$this->load->model('adminModel/Notification_model');
		$this->load->model('Common_Model');
		
	}
	public function index()
	{
        redirect('backend/Booking/manageBooking','refresh');
    }

	public function manageBooking()
	{
		$data['title']='Manage Booking';
		$srchStatus = $srchDate = 'Na';
		if($this->uri->segment(4)!='')
		{
			if($this->uri->segment(4)!="Na")
			{
				$srchStatus=($this->uri->segment(4));
			}
		}
		
		if($this->uri->segment(5)!='')
		{
			if($this->uri->segment(5)!="Na")
			{
				$srchDate=($this->uri->segment(5));
			}
		}
		
		$filter=array();
		//$date_filter=array();
		  $selectedBookingstatus = $srchStatus;
		
		  $search_date = $srchDate;

			if ($search_date != 'Na') {
	            // If a category is selected, filter the records by that Booking
	            $filter['datesearch']=$search_date;
	           //  $data['datesearch']=$search_date;
	        } 

		  if ($selectedBookingstatus != 'Na') {
            // If a category is selected, filter the records by that Booking
            $filter['status']=$selectedBookingstatus;
        } 
		$data['bookingcnt']=$this->Booking_model->getAllBooking(0,"","",$filter);
		
		$config = array();
		$config["base_url"] = base_url().'backend/Booking/manageBooking/'.$srchStatus.'/'.$srchDate;
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
		$config["total_rows"] =$data['bookingcnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		//echo "ConttPerPage--".$config["per_page"];
		//echo "Conttpage--".$page;
		//exit();
		//$data['bookingList']=$this->Booking_model->getAllBooking(1,$config["per_page"],$page);
		// $data['Bookingstatus'] = $this->Booking_model->getBookingstatus();
		   $data['bookingList']=$this->Booking_model->getAllBooking(1,$config["per_page"],$page,$filter);
        // echo $this->db->last_query();
		// print_r($filter);
		//  exit;
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/manageBooking',$data);
		$this->load->view('admin/admin_footer');
		
		 
	}
	
	public function search_list()
	{
		$srchStatus = $srchDate = 'Na';
		
		if(isset($_POST['Search']))
		{
			if($_POST['bookingstatus']!="")
			{
				$srchStatus=trim($_POST['bookingstatus']);
			}
			if($_POST['datesearch']!="")
			{
				$srchDate=trim($_POST['datesearch']);
			}
			
			redirect('backend/Booking/manageBooking/'.$srchStatus.'/'.$srchDate);
		}
		redirect('backend/Booking/manageBooking', 'refresh');
	}
	
	public function addMaterial()
	{
		$data['title']='Add Material';
		$data['error_msg']='';
				
		if(isset($_POST['btn_addmaterial']))
		{
			$this->form_validation->set_rules('material_name','Zone Name','required');
			
			$this->form_validation->set_rules('status','Zone Status','required');
			if($this->form_validation->run())
			{
				$material_name=$this->input->post('material_name');
				$status=$this->input->post('status');
                		
				$materialname=$this->Booking_model->chkMaterialName($material_name,0);

				if($materialname==0)
				{
					$input_data = array(
						'material_name'=>trim($material_name),
						'material_status'=>$status,
						'dateupdated' => date('Y-m-d H:i:s'),
						'dateadded' => date('Y-m-d H:i:s')
						);

					/*echo"<pre>";
					print_r($input_data);
					exit();*/
					
					$insert_id = $this->Common_Model->insert_data('material',$input_data);
					
					if($insert_id)
					{	
						$this->session->set_flashdata('success','Material added successfully.');

						redirect(base_url().'backend/Material/manageMaterial');	
					}
					else
					{
						$this->session->set_flashdata('error','Error while adding user.');

						redirect(base_url().'backend/Material/addMaterial');
					}	
				}
				else
				{
					$this->session->set_flashdata('error','Material name  already exist.');

					redirect(base_url().'backend/Material/addMaterial');	
				}

			}else{
				$this->session->set_flashdata('error','Validation failed. Please enter valid data.');
				redirect(base_url().'backend/Material/addMaterial');
			}
		}

		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/addMaterial',$data);
		$this->load->view('admin/admin_footer');
	}


	public function AssingServiceProvider()
	{
		$data['title']='Assing Service Provider';
		$data['error_msg']='';
		$session_data=$this->session->userdata('logged_in');
			$booking_id=base64_decode($this->uri->segment(4));

			if ($booking_id) {
				$bokingInfo=$this->Booking_model->getSingleBookingInfo($booking_id,0);
				
			if($bokingInfo>0)
			{
				$data['bokingInfo'] = $this->Booking_model->getSingleBookingInfo($booking_id,1);
				
				
			$category_id = $data['bokingInfo'][0]['category_id'];
			$data['usersList']=$this->Booking_model->getAllUsers(1,"","",$category_id);
				if(isset($_POST['btn_upAssing']))
				{
				
			        $this->form_validation->set_rules('service_provider','Service Provider ','required');

					if($this->form_validation->run())
					{
						$servicepro=$this->input->post('service_provider');
						// $status=$this->input->post('status');
							
						$input_data = array(
                            'service_provider_id'=>$servicepro
                         );
					// echo"<pre>";
					// print_r($input_data);
					// exit();
						$updatedata = $this->Booking_model->uptdateAssingServiceprovider($input_data,$booking_id);
                       
                       // echo $this->db->last_query();exit;
						if($updatedata)
						{	
							$orderno = $data['bokingInfo'][0]['order_no'];
							
							$user=$this->Notification_model->getUserDetails(1,$servicepro);
							
							$title="New Booking Assigned";
							$message="Booking no $orderno has been assigned to you";
		
							$input_data = array(
								'noti_title'=>trim($title),
								'noti_message'=>trim($message),
								'noti_type'=>'Service Provider',
								'noti_user_id'=>$servicepro,
								'noti_gcmID'=>$user->user_fcm,
								'created_by' => $session_data['admin_id'],
								'dateadded' => date('Y-m-d H:i:s')
								);
							
							$notification_id = $this->Notification_model->insert_notification($input_data);
								
							$this->Common_Model->sendexponotification($notification_name,$notification_description,$users['user_fcm']);
							
							
							$this->session->set_flashdata('success','Assing Service Provider successfully.');

							redirect(base_url().'backend/Booking/manageBooking');	
						}
						else
						{
							$this->session->set_flashdata('error','Error while updating Zone.');

							redirect(base_url().'backend/Booking/AssingServiceProvider/'.base64_encode($user_id));
						}	
					}
					else
					{
						$this->session->set_flashdata('error',$this->form_validation->error_string());

						redirect(base_url().'backend/Booking/AssingServiceProvider/'.base64_encode($user_id));
					}
				}
			}
			else
			{
				$data['error_msg'] = 'Not found.';
			}
		}
		
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/update_AssingServicepro',$data);
		$this->load->view('admin/admin_footer');
					// echo"<pre>";
					// print_r($bokingidInfo);
					// exit();
			}
	
	
	public function updateMaterial()
	{
		$data['title']='Update Material';
		$data['error_msg']='';
		// echo "segment--".$this->uri->segment(4);exit();
		$material_id=base64_decode($this->uri->segment(4));
        // echo $zone_id;
        if($material_id)
		{
			$materialInfo=$this->Booking_model->getSingleMaterialInfo($material_id,0);
			if($materialInfo>0)
			{
				$data['materialInfo'] = $this->Booking_model->getSingleMaterialInfo($material_id,1);

				if(isset($_POST['btn_updatematerial']))
				{
                    print_r($_POST);//exit;
					$this->form_validation->set_rules('material_name','Material Name','required');
			
			        $this->form_validation->set_rules('status','Material Status','required');

					if($this->form_validation->run())
					{
						$material_name=$this->input->post('material_name');
						$status=$this->input->post('status');
							
						$input_data = array(
                            'material_name'=>trim($material_name),
							'material_status'=>$status,
							'dateupdated' => date('Y-m-d H:i:s'),
                            );
					
						$updatedata = $this->Common_Model->update_data('material','material_id',$material_id,$input_data);
                       
                        // echo $this->db->last_query();exit;
						if($updatedata)
						{	
							$this->session->set_flashdata('success','Material updated successfully.');

							redirect(base_url().'backend/Material/manageMaterial');	
						}
						else
						{
							$this->session->set_flashdata('error','Error while updating Zone.');

							redirect(base_url().'backend/Material/updateMaterial/'.base64_encode($user_id));
						}	
					}
					else
					{
						$this->session->set_flashdata('error',$this->form_validation->error_string());

						redirect(base_url().'backend/Material/updateMaterial/'.base64_encode($user_id));
					}
				}
			}
			else
			{
				$data['error_msg'] = 'Material not found.';
			}
		}
		
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/updateMaterial',$data);
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
								'zone_status'=> $statusTobeUpdated
								);
			$usertaskdata = $this->Booking_model->uptdateStatus($input_data,$task_id);
			if($usertaskdata){
				$this->session->set_flashdata('success','Status updated successfully.');
				redirect(base_url().'backend/users/viewUsertask/'.$user_id);
				}
		}
	}
	public function deleteMaterial()
	{
		$data['error_msg']='';
		$material_id = base64_decode($this->uri->segment(4));
		if($material_id)
		{
			$materialInfo=$this->Booking_model->getSingleMaterialInfo($material_id,0);
			if($materialInfo>0)
			{
				$input_data = array(
					'material_status'=>'Delete',
					'dateupdated' => date('Y-m-d H:i:s')
				);

				$delrecord =$this->Common_Model->update_data('material','material_id',$material_id,$input_data);
                       
				if($delrecord > 0)
				{
					$this->session->set_flashdata('success','Material deleted successfully.');
					redirect(base_url().'backend/Material/manageMaterial');	
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleting zone.');
					redirect(base_url().'backend/Material/manageMaterial');
				}
			}
			else
			{
				$data['error_msg'] = 'Material not found.';
			}
		}
		else
		{
			$this->session->set_flashdata('error','Material not found.');
			redirect(base_url().'backend/Material/manageMaterial');
		}
	}

public function viewBookingDetails()
	{
		$data['title']='Booking Details';
	
		$booking_id=base64_decode($this->uri->segment(4));
        
		$data['orderInfo']=$this->Booking_model->getSingleBookingInfo($booking_id,1);
		
		$data['serviceDetails'] = $this->Booking_model->getServiceDetails($booking_id);
		
		$data['servicePricing'] = $this->Booking_model->getServiceDetailsWOPricing($booking_id);
		
		$data['addressDetails'] = $this->Booking_model->getBookingAddressDetails($data['orderInfo'][0]['address_id']);
		
		$data['workHistory'] = $this->Booking_model->getBookingWorkHistory($booking_id);
		
		$data['transactionHistory'] = $this->Booking_model->getBookingTransactionHistory($booking_id);
		
		//echo $this->db->last_query();exit;
		 $this->load->view('admin/admin_header',$data);
		// $this->load->view('admin/addMaterial',$data);
		$this->load->view('admin/viewBookingDetails',$data);
		$this->load->view('admin/admin_footer');
	}

	public function manageBookingDemo()
	{
		$data['title']='Manage Booking Demo';

		
		$data['bookingdemocnt']=$this->Booking_model->getAllBookingDemo(0,"","");
		
		$config = array();
		$config["base_url"] = base_url().'backend/Booking/manageBookingDemo/';
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
		$config["total_rows"] =$data['bookingdemocnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		//echo "ConttPerPage--".$config["per_page"];
		//echo "Conttpage--".$page;
		//exit();
		//$data['bookingList']=$this->Booking_model->getAllBooking(1,$config["per_page"],$page);
		// $data['Bookingstatus'] = $this->Booking_model->getBookingstatus();
		$filter=array();
		//$date_filter=array();
		 $selectedBookingstatus = $this->input->get('bookingstatus');
		
		  $search_date = $this->input->get('datesearch');

			if ($search_date) {
	            // If a category is selected, filter the records by that Booking
	            $filter['datesearch']=$search_date;
	           //  $data['datesearch']=$search_date;
	        } 

		  if ($selectedBookingstatus) {
            // If a category is selected, filter the records by that Booking
            $filter['status']=$selectedBookingstatus;
        } 

           $data['bookingDemoList']=$this->Booking_model->getAllBookingDemo(1,$config["per_page"],$page,$filter);
      //   echo $this->db->last_query();
		// print_r($filter);
		//  exit;
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/manageBookingDemo',$data);
		$this->load->view('admin/admin_footer');
		
		 
	}

	public function AssingDateTime()
	{
		$data['title']='Assing Date Time';
		$data['error_msg']='';
		$data['usersList']=$this->Booking_model->getAllUsers(1,"","");

			$booking_id=base64_decode($this->uri->segment(4));

			if ($booking_id) {
				$data['booking_id']=$booking_id;
				$bokingInfo=$this->Booking_model->getSingleBookingInfo($booking_id,0);
			
			if($bokingInfo>0)
			{
				$data['bokingInfo'] = $this->Booking_model->getSingleBookingInfo($booking_id,1);

				if(isset($_POST['btn_upAssing']))
				{
				
			        $this->form_validation->set_rules('assingtime','Assing Time','required');

					if($this->form_validation->run())
					{
						$assingtime=$this->input->post('assingtime');
						
						
							
						$input_data = array(
                            'time_slot'=>$assingtime
                         );
					echo"<pre>";
					print_r($input_data);
					exit();
						$updatedata = $this->Booking_model->uptdateAssingServiceprovider($input_data,$booking_id);
                       
                       // echo $this->db->last_query();exit;
						if($updatedata)
						{	
							$this->session->set_flashdata('success','Assing Service Provider successfully.');

							redirect(base_url().'backend/Booking/manageBooking');	
						}
						else
						{
							$this->session->set_flashdata('error','Error while updating Zone.');

							redirect(base_url().'backend/Booking/AssingDateTime/'.base64_encode($booking_id));
						}	
					}
					else
					{
						$this->session->set_flashdata('error',$this->form_validation->error_string());

						redirect(base_url().'backend/Booking/AssingDateTime/'.base64_encode($booking_id));
					}
				}
			}
			else
			{
				$data['error_msg'] = 'Not found.';
			}
		}
		
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/update_AssingDateTime',$data);
		$this->load->view('admin/admin_footer');
					// echo"<pre>";
					// print_r($bokingidInfo);
					// exit();
	}


}