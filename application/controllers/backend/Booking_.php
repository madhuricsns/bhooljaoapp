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
		date_default_timezone_set('Asia/Kolkata');
	}
	public function index()
	{
        redirect('backend/Booking/manageBooking','refresh');
    }

	public function manageBooking()
	{
		$data['title']='Manage Booking';
		$srchStatus = $srchDate = 'Na';
		$per_page='10';
	
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

		if($this->uri->segment(6)!='')
		{
			if($this->uri->segment(6)!="Na")
			{
				$pageNo=($this->uri->segment(6));
			}
		}

		if($this->uri->segment(7)!='')
		{
			if($this->uri->segment(7)!="Na")
			{
				$per_page=($this->uri->segment(7));
			}
		}
		else
		{
			$per_page='10';
		}
		 //echo "perPage: ".$per_page." pageno: ".$pageNo;
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
		$config["base_url"] = base_url().'backend/Booking/manageBooking/'.$srchStatus.'/'.$srchDate.'/'.$per_page;
		// $config['per_page'] = 10;
		if($per_page>100)
		{
			$config['per_page'] = 100;
		}
		else
		{
			$config['per_page'] = $per_page;
		}
		
		$config["uri_segment"] = 7;
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
				
		// $per_page = ($this->uri->segment(7)) ? $this->uri->segment(7) : 0;
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
		$srchStatus = $srchDate = $pageNo=$per_page='Na';
		
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
			if($_POST['per_page']!="")
			{
				$per_page=trim($_POST['per_page']);
			}


			redirect('backend/Booking/manageBooking/'.$srchStatus.'/'.$srchDate.'/'.$pageNo.'/'.$per_page);
		}
		redirect('backend/Booking/manageBooking', 'refresh');
	}

	public function searchdemo_list()
	{
		$srchStatus = $srchDate = $pageNo ='Na';
		
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
			if($_POST['per_page']!="")
			{
				$per_page=trim($_POST['per_page']);
			}
			
			redirect('backend/Booking/manageBookingDemo/'.$srchStatus.'/'.$srchDate.'/'.$pageNo.'/'.$per_page);
		}
		redirect('backend/Booking/manageBookingDemo', 'refresh');
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

			if($booking_id) {
				$bokingInfo=$this->Booking_model->getSingleBookingInfo($booking_id,0);
				
			if($bokingInfo>0)
			{
				$data['bokingInfo'] =$booking= $this->Booking_model->getSingleBookingInfo($booking_id,1);
				
			$booking_user_id=$data['bokingInfo'][0]['user_id'];	
			$category_id = $data['bokingInfo'][0]['category_id'];
			$categoryData=$this->Booking_model->getCategoryDetails($category_id);
			if($categoryData->category_parent_id!=0)
			{
				$category_id=$categoryData->category_parent_id;
			}
			$data['serviceGroup']=$this->Booking_model->getAllGroup(1,$category_id);
			$data['usersList']=$this->Booking_model->getAllUsers(1,"","",$category_id);
				if(isset($_POST['btn_upAssing']))
				{
			        // $this->form_validation->set_rules('service_provider','Service Provider ','required');
			        // $this->form_validation->set_rules('service_group_assign','Service Provider ','required');
					// if($this->form_validation->run())
					// {
						$servicepro=$this->input->post('service_provider');
						$service_group_assign='NO';
						
						$group_id=$this->input->post('group_id');
						if($group_id>0)
						{
							$service_group_assign='YES';
						}
						
						// $status=$this->input->post('status');
						if($group_id>0)
						{
							$input_data = array(
								'service_provider_id'=>'0',
								'service_group_assigned'=>$service_group_assign,
								'service_group_id'=>$group_id,
							 );
						}	
						else
						{
							$input_data = array(
								'service_provider_id'=>$servicepro,
								'service_group_assigned'=>$service_group_assign
							 );
						}
						
						// echo"<pre>";
						// print_r($input_data);
						// exit();
						$updatedata = $this->Booking_model->uptdateAssingServiceprovider($input_data,$booking_id);
                       
                       // echo $this->db->last_query();exit;
						if($updatedata)
						{	
							$orderno = $data['bokingInfo'][0]['order_no'];
							if($service_group_assign=='NO')
							{
								$user=$this->Notification_model->getUserDetails(1,$servicepro);
								
								$title="New Booking Assigned";
								$message="Booking no $orderno has been assigned to you";
			
								$input_data = array(
									'noti_title'=>trim($title),
									'noti_message'=>trim($message),
									'noti_user_type'=>'Service Provider',
									'noti_type'=>'Booking',
									'noti_user_id'=>$servicepro,
									'noti_gcmID'=>$user->user_fcm,
									// 'created_by' => $session_data['admin_id'],
									'dateadded' => date('Y-m-d H:i:s')
									);
								
								$notification_id = $this->Notification_model->insert_notification($input_data);
								$this->Common_Model->sendexponotification($title,$message,$user->user_fcm);
								
							}
							else
							{
								$groupBySP=$this->Booking_model->getGroupBySP($group_id,1);
								
								foreach($groupBySP as $sp){
									$user=$this->Notification_model->getUserDetails(1,$sp['service_provider_id']);
									
									$title="New Booking Assigned";
									$message="Booking no $orderno has been assigned to your service group";
				
									$input_data = array(
										'noti_title'=>trim($title),
										'noti_message'=>trim($message),
										'noti_user_type'=>'Service Provider',
										'noti_type'=>'Booking',
										'noti_user_id'=>$user->user_id,
										'noti_gcmID'=>$user->user_fcm,
										// 'created_by' => $session_data['admin_id'],
										'dateadded' => date('Y-m-d H:i:s')
										);
									
									$notification_id = $this->Notification_model->insert_notification($input_data);
									$this->Common_Model->sendexponotification($title,$message,$user->user_fcm);
								}
							}
							
							// Send Customer Notification
							$customer=$this->Notification_model->getUserDetails(1,$booking_user_id);
							
							$titleC="Your Booking Assigned SP";
							$messageC="Booking no $orderno has been assigned to $user->full_name";
		
							$input_dataC = array(
								'noti_title'=>trim($titleC),
								'noti_message'=>trim($messageC),
								'noti_user_type'=>'Customer',
								'noti_type'=>'Booking',
								'noti_user_id'=>$booking_user_id,
								'noti_gcmID'=>$customer->user_fcm,
								'created_by' => $session_data['admin_id'],
								'dateadded' => date('Y-m-d H:i:s')
								);

							$notification_idc = $this->Notification_model->insert_notification($input_dataC);
							$this->Common_Model->sendexponotification($titleC,$messageC,$customer->user_fcm);
							
							$this->session->set_flashdata('success','Assing Service Provider successfully.');
							redirect(base_url().'backend/Booking/manageBooking');	
						}
						else
						{
							$this->session->set_flashdata('error','Error while updating Service Provider.');
							redirect(base_url().'backend/Booking/AssingServiceProvider/'.base64_encode($booking_id));
						}	
					// }
					// else
					// {
					// 	$this->session->set_flashdata('error',$this->form_validation->error_string());
					// 	redirect(base_url().'backend/Booking/AssingServiceProvider/'.base64_encode($booking_id));
					// }
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

	public function viewBookingDemoDetails()
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
		$srchStatus = $srchDate = 'Na';
		$per_page='10';
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

		if($this->uri->segment(6)!='')
		{
			if($this->uri->segment(6)!="Na")
			{
				$pageNo=($this->uri->segment(6));
			}
		}

		if($this->uri->segment(7)!='')
		{
			if($this->uri->segment(7)!="Na")
			{
				$per_page=($this->uri->segment(7));
			}
		}
		else
		{
			$per_page='10';
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
		
		$data['bookingdemocnt']=$this->Booking_model->getAllBookingDemo(0,"","",$filter);
		
		$config = array();
		$config["base_url"] = base_url().'backend/Booking/manageBookingDemo/'.$srchStatus.'/'.$srchDate.'/'.$per_page;
		// $config['per_page'] = 10;
		if($per_page>100)
		{
			$config['per_page'] = 100;
		}
		else
		{
			$config['per_page'] = $per_page;
		}
		$config["uri_segment"] = 6;
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
				
		$page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		//echo "ConttPerPage--".$config["per_page"];
		//echo "Conttpage--".$page;
		//exit();
		//$data['bookingList']=$this->Booking_model->getAllBooking(1,$config["per_page"],$page);
		// $data['Bookingstatus'] = $this->Booking_model->getBookingstatus();
		// $filter=array();
		// //$date_filter=array();
		//  $selectedBookingstatus = $this->input->get('bookingstatus');
		
		//   $search_date = $this->input->get('datesearch');

		// 	if ($search_date) {
	    //         // If a category is selected, filter the records by that Booking
	    //         $filter['datesearch']=$search_date;
	    //        //  $data['datesearch']=$search_date;
	    //     } 

		//   if ($selectedBookingstatus) {
        //     // If a category is selected, filter the records by that Booking
        //     $filter['status']=$selectedBookingstatus;
        // } 

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
		//$data['usersList']=$this->Booking_model->getAllUsers(1,"","","");

			$booking_id=base64_decode($this->uri->segment(4));

			if ($booking_id) {
				$data['booking_id']=$booking_id;
				$bokingInfo=$this->Booking_model->getSingleBookingInfo($booking_id,0);
			
			if($bokingInfo>0)
			{
				$data['bokingInfo'] = $this->Booking_model->getSingleBookingInfo($booking_id,1);
				
				$category_id = $data['bokingInfo'][0]['category_id'];
				$categoryData=$this->Booking_model->getCategoryDetails($category_id);
				if($categoryData->category_parent_id!=0)
				{
					$category_id=$categoryData->category_parent_id;
				}
				$data['usersList']=$this->Booking_model->getAllUsers(1,"","",$category_id);
			
				if(isset($_POST['btn_upAssing']))
				{
				
			        $this->form_validation->set_rules('assingtime','Assing Time','required');

					if($this->form_validation->run())
					{
						$service_provider=$this->input->post('service_provider');
						$bookingdate=$this->input->post('bookingdate');
						$assingtime=$this->input->post('assingtime');
						
						$input_data = array(
                            'service_provider_id'=>$service_provider,
                            'booking_date'=>$bookingdate,
                            'time_slot'=>$assingtime,
							'admin_demo_accept' => 'Yes'
                         );
					/*echo"<pre>";
					print_r($input_data);
					exit();*/
						$updatedata = $this->Booking_model->uptdateAssingServiceprovider($input_data,$booking_id);
                       
                       // echo $this->db->last_query();exit;
						if($updatedata)
						{	
							$this->session->set_flashdata('success','Assing Service Provider successfully.');

							redirect(base_url().'backend/Booking/manageBookingDemo');	
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


public function exportBookingCSV()
	{
		$this->load->helper('download');
      $data['error']=$data['success']="";
		$todaysdate=date('d-M-YHi');
		
		// $data['session_from_date'] = $this->session->userdata('session_from_date');		
		// $data['session_to_date'] = $this->session->userdata('session_to_date');		
		// $input_data = array(
		// 	'from_date'=> $data['session_from_date'] ?? ''	,
		// 	'to_date'=>$data['session_to_date'] ?? '');
		
		$array[] = array('','','Bhooljao - Export CSV For Booking','','','');
		
		$i=1;

		$data['bookingList']=$bookingList=$this->Booking_model->getAllBooking(1,"","");

		$people = array('Sr.','Order No','Booking Date','Time','Duration','Service Name','Customer','Service Provider','Status');
		$array[] =$people;

	   	if(isset($bookingList) && count($bookingList)>0)
		{  	
			foreach($bookingList as $g)
			{    
				$sp_name="";
				if($g['service_provider_id']>0 )
				{
					$user=$this->Booking_model->getServiceproviderDetails($g['service_provider_id'],1); 
					if(isset($user[0]['full_name']))
					{
						$sp_name=$user[0]['full_name'];
					}
				
				} else { 
			//	echo "---";
				}
				$g['booking_date']= new DateTime($g['booking_date']);
             	$g['booking_date']=$g['booking_date']->format('d-M-Y');


				$order_no =$g['order_no'];
				$booking_date=$g['booking_date'];
				$time_slot=$g['time_slot'];
				$duration=$g['duration'];
				$category_name=$g['category_name'];
				$full_name=$g['full_name'];
				$sp=$sp_name;
				
											
				$status=$g['booking_status'];
				
				// echo "<pre>";print_r($sp); exit;
				if(is_array($people) &&count($people)> 0){
					foreach ($people as $key => $peopledtls) {
						$strDtlVal = $peopledtls;
						switch ($peopledtls) {
							case 'Sr.':
								$strDtlVal = $i;
								break;
							case 'Order No':
								$strDtlVal = $order_no;
								break;
							case 'Booking Date':
								$strDtlVal = $booking_date;
								break;
							case 'Time':
								$strDtlVal = $time_slot;
								break;
							case 'Duration':
								$strDtlVal = $duration;
								break;
							case 'Service Name':
								$strDtlVal = $category_name;
								break;
							case 'Customer':
								$strDtlVal = $full_name;
								break;
							case 'Service Provider':
								$strDtlVal = $sp;
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
			// echo"<pre>";
			// 		print_r($array);
			// 		exit();
		}
		  $this->load->helper('csv');
		  $csvname = 'BookingListExport'.$todaysdate.'.csv';
		  array_to_csv($array,$csvname);
		  $data['success']= "download sample export data successfully!";
	}

//<--------------------------< exportBookingDemoCSV >------------------------------------------------->

	public function exportBookingDemoCSV()
	{
		$this->load->helper('download');
      $data['error']=$data['success']="";
		$todaysdate=date('d-M-YHi');
		
		// $data['session_from_date'] = $this->session->userdata('session_from_date');		
		// $data['session_to_date'] = $this->session->userdata('session_to_date');		
		// $input_data = array(
		// 	'from_date'=> $data['session_from_date'] ?? ''	,
		// 	'to_date'=>$data['session_to_date'] ?? '');
		
		$array[] = array('','','Bhooljao - Export CSV For Booking-Demo','','','');
		
		$i=1;

		$data['bookingdemoList']=$bookingdemoList=$this->Booking_model->getAllBookingDemo(1,"","");

		$people = array('Sr.','Order No','Booking Date','Time','Duration','Service Name','Customer','Service Provider','Status');
		$array[] =$people;

	   	if(isset($bookingdemoList) && count($bookingdemoList)>0)
		{  	
			foreach($bookingdemoList as $g)
			{    
				 if($g['service_provider_id']>0 ){
				$user=$this->Booking_model->getServiceproviderDetails($g['service_provider_id'],1); 
												
				if(isset($user[0]['full_name'])) ;
				
				} else { 
			//	echo "---";
				}
				 $g['booking_date']= new DateTime($g['booking_date']);
             $g['booking_date']=$g['booking_date']->format('d-M-Y');


				$order_no =$g['order_no'];
				$booking_date=$g['booking_date'];
				$time_slot=$g['time_slot'];
				$duration=$g['duration'];
				$category_name=$g['category_name'];
				$full_name=$g['full_name'];
				$sp=$user[0]['full_name'];
				
												
												
												
				$status=$g['booking_status'];
				
				// echo "<pre>";print_r($sp); exit;
				if(is_array($people) &&count($people)> 0){
					foreach ($people as $key => $peopledtls) {
						$strDtlVal = $peopledtls;
						switch ($peopledtls) {
							case 'Sr.':
								$strDtlVal = $i;
								break;
							case 'Order No':
								$strDtlVal = $order_no;
								break;
							case 'Booking Date':
								$strDtlVal = $booking_date;
								break;
							case 'Time':
								$strDtlVal = $time_slot;
								break;
							case 'Duration':
								$strDtlVal = $duration;
								break;
							case 'Service Name':
								$strDtlVal = $category_name;
								break;
							case 'Customer':
								$strDtlVal = $full_name;
								break;
							case 'Service Provider':
								$strDtlVal = $sp;
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
			// echo"<pre>";
			// 		print_r($array);
			// 		exit();
		}
		  $this->load->helper('csv');
		  $csvname = 'BookingDemoListExport'.$todaysdate.'.csv';
		  array_to_csv($array,$csvname);
		  $data['success']= "download sample export data successfully!";
	}

	public function change_status()
	{
		$data['title']='Change Status';
		$data['error_msg']='';


		$booking_id= $this->input->get('booking_id');
		$status= $this->input->get('status');

		if($booking_id)
		{
			$input_data = array(
								'booking_status'=> $status
								);
			$userdata = $this->Booking_model->uptdateStatus($input_data,$booking_id);
			 // echo $this->db->last_query();

			//echo $userdata;

			if($userdata){
				
				echo "Status updated successfully";
				} else{

					echo "Status updated failed";
				}
		}
	}

}