<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {
	public function __construct(){
		parent::__construct();
	if(empty($this->session->userdata('logged_in'))){
			redirect(base_url().'backend/login','refresh');  
		}
		$this->load->library("pagination");	
		$this->load->helper('email');
		$this->load->library('session');
		
		$this->load->model('adminModel/Service_model');
		$this->load->model('Common_Model');
		
	}
	public function index()
	{
		redirect(base_url().'backend/Service/manageService','refresh');
	}
	public function manageService()
	{
		$data['title']='Manage Sub Category';

		
		$data['usercnt']=$this->Service_model->getAllService(0,"","");
		
		$config = array();
		$config["base_url"] = base_url().'backend/Service/manageService/';
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
		$data['serviceList']=$this->Service_model->getAllService(1,$config["per_page"],$page);
		//echo $this->db->last_query();exit;
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/manageService',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function addService()
	{
		$data['title']='Add Sub Category';
		$data['error_msg']='';
		$data['categoryList']=$this->Service_model->getAllCategory(1);		
		if(isset($_POST['btn_addService']))
		{
			// print_r($_POST);//exit;
			$this->form_validation->set_rules('category','Category','required');
			$this->form_validation->set_rules('service_name', 'Service Name', 'required');
			//$this->form_validation->set_rules('email_address', 'Email Address', 'required');
			$this->form_validation->set_rules('description','Description','required');
			$this->form_validation->set_rules('minprice', 'Price ', 'required'); //{10} for 10 digits number
			$this->form_validation->set_rules('maxprice', 'Max Price ', 'required'); //{10} for 10 digits number

			if($this->form_validation->run())
			{
				//echo "successfully validated";exit();
			
				$category_id=$this->input->post('category');
				$Service_name=$this->input->post('service_name');
				$minprice=$this->input->post('minprice');
				$maxprice=$this->input->post('maxprice');
				$option_label=$this->input->post('option_label');
				$optionsArr=$this->input->post('optionsArr');
				$amountArr=$this->input->post('amountArr');
				$labelArr=$this->input->post('labelArr');
				$labelvalueArr=$this->input->post('labelvalueArr');

				//$daily_report=$this->input->post('daily_report');
				$status="Active";
				$description=$this->input->post('description');
				
					//Image Upload Code 
					if(count($_FILES) > 0) 
					{
						$ImageName = "servicefile";
						$target_dir = "uploads/service_images/";
						$service_image= $this->Common_Model->ImageUpload($ImageName,$target_dir);
					}

					$input_data = array(
						'category_id'=>$category_id,
						'service_name'=>trim($Service_name),
						'service_description'=>$description,
						'min_price'=>$minprice,
						'max_price'=>$maxprice,
						'service_image'=>$service_image,
						'service_status'=>$status,
						'service_option_name'=>$option_label,
						'dateadded' => date('Y-m-d H:i:s'),
						'dateupdated' => date('Y-m-d H:i:s')
						);

					// echo"<pre>";
					// print_r($input_data);
					// exit();
					
					$Service_id = $this->Service_model->insert_Service($input_data);
					
					if($Service_id>0)
					{	
						// print_r($optionsArr);
						if(!empty($optionsArr))
						{
							foreach($optionsArr as $key=>$option)
							{
								$amount=$amountArr[$key];
								$insert_data=array(
									'service_id'=>$Service_id,
									'option_name'=>$option,
									'option_amount'=>$amount,
									'dateadded' => date('Y-m-d H:i:s'),
									'dateupdated' => date('Y-m-d H:i:s')
								);
								if($option!="" && $amount!=""){
									$this->Common_Model->insert_data('service_details',$insert_data);
									}
								// echo $this->db->last_query();
							}
						}

						foreach($labelArr as $key=>$label)
						{
							$labelvalue=$labelvalueArr[$key];
							$insert_data=array(
								'service_id'=>$Service_id,
								'option_name'=>$label,
								'option_value'=>$labelvalue,
								'option_type'=>'Label',
								'dateadded' => date('Y-m-d H:i:s'),
								'dateupdated' => date('Y-m-d H:i:s')
							);
							if($label!="" && $labelvalue!=""){
								$this->Common_Model->insert_data('service_details',$insert_data);
								}
						}
						$this->session->set_flashdata('success','Service added successfully.');

						redirect(base_url().'backend/Service/manageService');	
					}
					else
					{
						$this->session->set_flashdata('error','Error while adding Service.');

						redirect(base_url().'backend/Service/addService');
					}	
				
			}else{
				$this->session->set_flashdata('success','Validation failed. Please enter valid Text.');
				redirect(base_url().'backend/Service/addService');
			}
		}

		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/addService',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function updateService()
	{
		$data['title']='Update Service';
		$data['error_msg']='';
		//echo "segment--".$this->uri->segment(4);exit();
		$id=base64_decode($this->uri->segment(4));
		$data['categoryList']=$this->Service_model->getAllCategory(1);	
		//echo "Brand_id--".$brand_id;exit();
		if($id)
		{
			$serviceInfo=$this->Service_model->getSingleServiceInfo($id,0);
			if($serviceInfo>0)
			{
				$data['serviceInfo'] = $this->Service_model->getSingleServiceInfo($id,1);
				$data['optionList']=$this->Service_model->getAllServiceDetailOptions($id,1);	
				$data['labelList']=$this->Service_model->getAllServiceDetailLabels($id,1);	
				if(isset($_POST['btn_uptuser']))
				{
					$this->form_validation->set_rules('category','Category','required');
			
		     	$this->form_validation->set_rules('service_name', 'Service Name', 'required');
			   //$this->form_validation->set_rules('email_address', 'Email Address', 'required');
			   $this->form_validation->set_rules('description','Description','required');
			   /*$this->form_validation->set_rules('minprice', 'Min Price ', 'required'); //{10} for 10 digits number
			   $this->form_validation->set_rules('maxprice', 'Max Price ', 'required'); //{10} for 10 digits number
			  */
			  $this->form_validation->set_rules('status','Service Status','required');

				if($this->form_validation->run())
				{ 
					$category_id=$this->input->post('category');
					$service_name=$this->input->post('service_name');
					$service_price=$this->input->post('service_price');
					$service_discount_price=$this->input->post('service_discount_price');
					$service_demo_price=$this->input->post('service_demo_price');
					$service_demo_discount_price=$this->input->post('service_demo_discount_price');
					$optionsArr=$this->input->post('optionsArr');
					$amountArr=$this->input->post('amountArr');
					$labelArr=$this->input->post('labelArr');
					$labelvalueArr=$this->input->post('labelvalueArr');

					$status=$this->input->post('status');
					//$status="active";
					$description=$this->input->post('description');
				
					//Image Upload Code 
					if(count($_FILES) > 0) 
					{
						$ImageName = "servicefile";
						$target_dir = "uploads/service_images/";
						$service_image= $this->Common_Model->ImageUpload($ImageName,$target_dir);
					}
					if($_FILES['servicefile']['name']!="")		
					{
						$input_data = array(
						'category_id'=>$category_id,
						'service_name'=>$service_name,
						'service_description'=>$description,
						'service_price'=>$service_price,
						'service_discount_price'=>$service_discount_price,
						'service_demo_price'=>$service_demo_price,
						'service_demo_discount_price'=>$service_demo_discount_price,
						'service_image'=>$service_image,
						'service_status'=>$status,
						'dateupdated' => date('Y-m-d H:i:s'),
						);
					}
					else
					{
						$input_data = array(
							'category_id'=>$category_id,
							'service_name'=>$service_name,
							'service_description'=>$description,
							'service_price'=>$service_price,
							'service_discount_price'=>$service_discount_price,
							'service_demo_price'=>$service_demo_price,
							'service_demo_discount_price'=>$service_demo_discount_price,
							'service_status'=>$status,
							'dateupdated' => date('Y-m-d H:i:s'),
							);
					}
					
						$Service_data = $this->Service_model->uptdateService($input_data,$id);
// echo"<pre>";
// 					print_r($Service_data);
// 					exit();
						if($Service_data)
						{	
							$delOption=$this->Service_model->deleteoption($id);
							// print_r($optionsArr);
							if(!empty($optionsArr))
							{
								foreach($optionsArr as $key=>$option)
								{
									$amount=$amountArr[$key];
									$insert_data=array(
										'service_id'=>$id,
										'option_name'=>$option,
										'option_amount'=>$amount,
										'dateadded' => date('Y-m-d H:i:s'),
										'dateupdated' => date('Y-m-d H:i:s')
									);
									if($option!="" && $amount!=""){
									$this->Common_Model->insert_data('service_details',$insert_data);
									}
									// echo $this->db->last_query();
								}
							}
							foreach($labelArr as $key=>$label)
							{
								$labelvalue=$labelvalueArr[$key];
								$insert_data=array(
									'service_id'=>$id,
									'option_name'=>$label,
									'option_value'=>$labelvalue,
									'option_type'=>'Label',
									'dateadded' => date('Y-m-d H:i:s'),
									'dateupdated' => date('Y-m-d H:i:s')
								);
								if($label!="" && $labelvalue!=""){
									$this->Common_Model->insert_data('service_details',$insert_data);
									}
							}
							$this->session->set_flashdata('success','Service updated successfully.');

							redirect(base_url().'backend/Service/manageService');	
						}
						else
						{
							$this->session->set_flashdata('error','Error while updating Service.');

							redirect(base_url().'backend/Service/updateService/'.base64_encode($id));
						}	
					}
					else
					{
						$this->session->set_flashdata('error',$this->form_validation->error_string());

						redirect(base_url().'backend/Service/updateService/'.base64_encode($id));
					}
				}
			}
			else
			{
				$data['error_msg'] = 'Service not found.';
			}
		}
		
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/updateService',$data);
		$this->load->view('admin/admin_footer');
	}

	
	public function viewService()
	{
		$data['title']='View Service Details';
		$service_id=base64_decode($this->uri->segment(4));
		//echo "user_id--".$user_id;exit();
		$data['service_id'] = $service_id;
		$service_id_base64 = base64_encode($service_id);
		$data['serviceinfo']=$this->Service_model->getSingleServiceInfo($service_id,1);
		// echo $this->db->last_query();
		$data['optionList']=$this->Service_model->getAllServiceDetailOptions($service_id,1);	
		$data['labelList']=$this->Service_model->getAllServiceDetailLabels($service_id,1);	
		/*echo "<pre>";
		print_r($data['userinfo']);
		exit();*/

		
		/*echo "<pre>";
		print_r($data['usertasks']);exit();*/
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/viewService',$data);
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
	public function deleteService()
	{
		$data['error_msg']='';
		$id = base64_decode($this->uri->segment(4));
		if($id)
		{
			$userInfo = $data['userInfo'] = $this->Service_model->getSingleServiceInfo($id,1);
			if(count($userInfo) > 0)
			{   
				$input_data = array(
					'service_status'=>'Delete',
					'dateupdated' => date('Y-m-d H:i:s')
				);

				$deluser = $this->Service_model->uptdateService($input_data,$id);
				if($deluser > 0)
				{
					$this->session->set_flashdata('success','Service deleted successfully.');
					//redirect(base_url().'backend/Users/index');	
					redirect(base_url().'backend/Service/manageService');
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleting user.');
					redirect(base_url().'backend/Service/managesservice');
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
			redirect(base_url().'backend/Service/managesservice');
		}
	}

	
	public function manageAddonServices()
	{
		$data['title']='Manage Sub Category';
		
		$id = base64_decode($this->uri->segment(4));
		
		$data['servicecnt']=$this->Service_model->getAllAddonService(0,"","",$id);
		
		$config = array();
		$config["base_url"] = base_url().'backend/Service/manageAddonServices/';
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
		$config["total_rows"] =$data['servicecnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		//echo "ConttPerPage--".$config["per_page"];
		//echo "Conttpage--".$page;
		//exit();
		$data['serviceList']=$this->Service_model->getAllAddonService(1,$config["per_page"],$page,$id);
		//echo $this->db->last_query();exit;
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/manageAddonService',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function addOnService()
	{
		$data['title']='Add Sub Category';
		$data['error_msg']='';
		$data['categoryList']=$this->Service_model->getAllCategory(1);		
		$data['ServiceList']=$this->Service_model->getAllServiceList(1);
		if(isset($_POST['btn_addService']))
		{
			// print_r($_POST);//exit;
			$this->form_validation->set_rules('parent_service_id','Parent Service','required');
			$this->form_validation->set_rules('service_name', 'Service Name', 'required');
			$this->form_validation->set_rules('description','Description','required');
			$this->form_validation->set_rules('price', 'Price', 'required'); //{10} for 10 digits number
			$this->form_validation->set_rules('discount_price', 'Discount Price ', 'required'); //{10} for 10 digits number
			
			if($this->form_validation->run())
			{
				//echo "successfully validated";exit();
			
				$parent_service_id=$this->input->post('parent_service_id');
				$Service_name=$this->input->post('service_name');
				$price=$this->input->post('price');
				$discount_price=$this->input->post('discount_price');
				$offer_percentage=$this->input->post('offer_percentage');
				$demo_price=$this->input->post('demo_price');
				$demo_discount_price=$this->input->post('demo_discount_price');
				$option_labelArr=$this->input->post('option_label');
				$optionsArr=$this->input->post('optionsArr');
				$amountArr=$this->input->post('amountArr');
				$labelArr=$this->input->post('labelArr');
				$labelvalueArr=$this->input->post('labelvalueArr');

				//$daily_report=$this->input->post('daily_report');
				$status="Active";
				$description=$this->input->post('description');
				
					//Image Upload Code 
					if(count($_FILES) > 0) 
					{
						$ImageName = "servicefile";
						$target_dir = "uploads/service_images/";
						$service_image= $this->Common_Model->ImageUpload($ImageName,$target_dir);
					}

					$input_data = array(
						'parent_service_id'=>$parent_service_id,
						'service_name'=>trim($Service_name),
						'service_description'=>$description,
						'service_price'=>$price,
						'service_discount_price'=>$discount_price,
						'offer_percentage'=>$offer_percentage,
						'service_demo_price'=>$demo_price,
						'service_demo_discount_price'=>$demo_discount_price,
						'service_image'=>$service_image,
						'service_status'=>$status,
						'dateadded' => date('Y-m-d H:i:s'),
						'dateupdated' => date('Y-m-d H:i:s')
						);

					// echo"<pre>";
					// print_r($input_data);
					// exit();
					
					$Service_id = $this->Service_model->insert_Service($input_data);
					
					if($Service_id>0)
					{	
						if($service_image!="")
						{
						// Upload Service Image
							$image_data = array(
								'service_id'=>$service_id,
								'service_image'=>$service_image,
								'dateadded' => date('Y-m-d H:i:s'),
								'dateupdated' => date('Y-m-d H:i:s')
								);
		
							$this->Common_Model->insert_data('service_images',$image_data);
						}

						if(!empty($option_labelArr))
						{
							foreach($option_labelArr as $key=>$option_label)
							{
								// print_r($optionsArr);
								if(!empty($optionsArr))
								{
									foreach($optionsArr as $key=>$option)
									{
										$amount=$amountArr[$key];
										$insert_data=array(
											'service_id'=>$Service_id,
											'option_label'=>$option_label,
											'option_name'=>$option,
											'option_amount'=>$amount,
											'dateadded' => date('Y-m-d H:i:s'),
											'dateupdated' => date('Y-m-d H:i:s')
										);
										// if($option!="" && $amount!=""){
											$this->Common_Model->insert_data('service_details',$insert_data);
										// }
										echo $this->db->last_query();
									}
								}
							}
						}

						// foreach($labelArr as $key=>$label)
						// {
						// 	$labelvalue=$labelvalueArr[$key];
						// 	$insert_data=array(
						// 		'service_id'=>$Service_id,
						// 		'option_name'=>$label,
						// 		'option_value'=>$labelvalue,
						// 		'option_type'=>'Label',
						// 		'dateadded' => date('Y-m-d H:i:s'),
						// 		'dateupdated' => date('Y-m-d H:i:s')
						// 	);
						// 	if($label!="" && $labelvalue!=""){
						// 		$this->Common_Model->insert_data('service_details',$insert_data);
						// 		}
						// }
						$this->session->set_flashdata('success','Service added successfully.');

						redirect(base_url().'backend/Service/manageAddonServices/'.base64_encode($parent_service_id));
					}
					else
					{
						$this->session->set_flashdata('error','Error while adding Service.');

						redirect(base_url().'backend/Service/addOnService');
					}	
				
			}else{
				$this->session->set_flashdata('success','Validation failed. Please enter valid Text.');
				redirect(base_url().'backend/Service/addOnService');
			}
		}

		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/addOnService',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function updateAddOnService()
	{
		$data['title']='Update Service';
		$data['error_msg']='';
		//echo "segment--".$this->uri->segment(4);exit();
		$id=base64_decode($this->uri->segment(4));
		$data['categoryList']=$this->Service_model->getAllCategory(1);	
		$data['ServiceList']=$this->Service_model->getAllServiceList(1);
		//echo "Brand_id--".$brand_id;exit();
		if($id)
		{
			$serviceInfo=$this->Service_model->getSingleServiceInfo($id,0);
			if($serviceInfo>0)
			{
				$data['serviceInfo'] = $this->Service_model->getSingleServiceInfo($id,1);
				$data['optionList']=$this->Service_model->getAllServiceDetailOptions($id,1);	
				$data['labelList']=$this->Service_model->getAllServiceDetailLabels($id,1);	
				if(isset($_POST['btn_uptuser']))
				{
					$this->form_validation->set_rules('parent_service_id','Parent Service','required');
			
		     	$this->form_validation->set_rules('service_name', 'Service Name', 'required');
			   //$this->form_validation->set_rules('email_address', 'Email Address', 'required');
			   $this->form_validation->set_rules('description','Description','required');
			   /*$this->form_validation->set_rules('minprice', 'Min Price ', 'required'); //{10} for 10 digits number
			   $this->form_validation->set_rules('maxprice', 'Max Price ', 'required'); //{10} for 10 digits number
			  */
			  $this->form_validation->set_rules('status','Service Status','required');

				if($this->form_validation->run())
				{ 
					$parent_service_id=$this->input->post('parent_service_id');
					$service_name=$this->input->post('service_name');
					$service_price=$this->input->post('service_price');
					$service_discount_price=$this->input->post('service_discount_price');
					$service_demo_price=$this->input->post('service_demo_price');
					$service_demo_discount_price=$this->input->post('service_demo_discount_price');
					$optionsArr=$this->input->post('optionsArr');
					$amountArr=$this->input->post('amountArr');
					$labelArr=$this->input->post('labelArr');
					$labelvalueArr=$this->input->post('labelvalueArr');

					$status=$this->input->post('status');
					//$status="active";
					$description=$this->input->post('description');
				
					//Image Upload Code 
					if(count($_FILES) > 0) 
					{
						$ImageName = "servicefile";
						$target_dir = "uploads/service_images/";
						$service_image= $this->Common_Model->ImageUpload($ImageName,$target_dir);
					}
					if($_FILES['servicefile']['name']!="")		
					{
						$input_data = array(
						'parent_service_id'=>$parent_service_id,
						'service_name'=>$service_name,
						'service_description'=>$description,
						'service_price'=>$service_price,
						'service_discount_price'=>$service_discount_price,
						'service_demo_price'=>$service_demo_price,
						'service_demo_discount_price'=>$service_demo_discount_price,
						'service_image'=>$service_image,
						'service_status'=>$status,
						'dateupdated' => date('Y-m-d H:i:s'),
						);
					}
					else
					{
						$input_data = array(
							'parent_service_id'=>$parent_service_id,
							'service_name'=>$service_name,
							'service_description'=>$description,
							'service_price'=>$service_price,
							'service_discount_price'=>$service_discount_price,
							'service_demo_price'=>$service_demo_price,
							'service_demo_discount_price'=>$service_demo_discount_price,
							'service_status'=>$status,
							'dateupdated' => date('Y-m-d H:i:s'),
							);
					}
					
						$Service_data = $this->Service_model->uptdateService($input_data,$id);
// echo"<pre>";
// 					print_r($Service_data);
// 					exit();
						if($Service_data)
						{	
							$delOption=$this->Service_model->deleteoption($id);
							// print_r($optionsArr);
							if(!empty($optionsArr))
							{
								foreach($optionsArr as $key=>$option)
								{
									$amount=$amountArr[$key];
									$insert_data=array(
										'service_id'=>$id,
										'option_name'=>$option,
										'option_amount'=>$amount,
										'dateadded' => date('Y-m-d H:i:s'),
										'dateupdated' => date('Y-m-d H:i:s')
									);
									if($option!="" && $amount!=""){
									$this->Common_Model->insert_data('service_details',$insert_data);
									}
									// echo $this->db->last_query();
								}
							}
							foreach($labelArr as $key=>$label)
							{
								$labelvalue=$labelvalueArr[$key];
								$insert_data=array(
									'service_id'=>$id,
									'option_name'=>$label,
									'option_value'=>$labelvalue,
									'option_type'=>'Label',
									'dateadded' => date('Y-m-d H:i:s'),
									'dateupdated' => date('Y-m-d H:i:s')
								);
								if($label!="" && $labelvalue!=""){
									$this->Common_Model->insert_data('service_details',$insert_data);
									}
							}
							$this->session->set_flashdata('success','Service updated successfully.');
							redirect(base_url().'backend/Service/manageAddonServices/'.base64_encode($parent_service_id));	
						}
						else
						{
							$this->session->set_flashdata('error','Error while updating Service.');

							redirect(base_url().'backend/Service/updateAddOnService/'.base64_encode($id));
						}	
					}
					else
					{
						$this->session->set_flashdata('error',$this->form_validation->error_string());

						redirect(base_url().'backend/Service/updateAddOnService/'.base64_encode($id));
					}
				}
			}
			else
			{
				$data['error_msg'] = 'Service not found.';
			}
		}
		
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/updateAddOnService',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function change_status()
	{
		$data['title']='Change Status';
		$data['error_msg']='';
		
		$service_id=base64_decode($this->uri->segment(4));

		$statusTobeUpdated=base64_decode($this->uri->segment(5));
		//echo "user_id--".$user_id;exit();
		if($service_id)
		{
			$input_data = array(
								'service_status'=> $statusTobeUpdated
								);
			$userdata = $this->Service_model->uptdateStatus($input_data,$service_id);
			if($userdata){
				$this->session->set_flashdata('success','Status updated successfully.');
				redirect(base_url().'backend/Service/manageService/');
				}
		}
	}

}

