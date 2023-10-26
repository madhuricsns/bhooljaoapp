<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class City extends CI_Controller {
	public function __construct(){
		parent::__construct();
	if(empty($this->session->userdata('logged_in'))){
			redirect(base_url().'backend/login','refresh');  
		}
		$this->load->library("pagination");	
		$this->load->helper('email');
		$this->load->library('session');
		
		$this->load->model('adminModel/City_model');
		$this->load->model('Common_Model');
		
	}
	
	public function managescity()
	{
		$data['title']='Manage City';

		
		$data['usercnt']=$this->City_model->getAllcity(0,"","");
		
		$config = array();
		$config["base_url"] = base_url().'backend/City/managecity/';
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
		$data['City']=$this->City_model->getAllcity(1,$config["per_page"],$page);
		//echo $this->db->last_query();exit;
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/managescity',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function addcity()
	{
		$data['title']='Add City';
		$data['error_msg']='';
		$data['stateList']=$this->City_model->getAllState(1,"","");
				
		if(isset($_POST['btn_addcity']))
		{
			
			$this->form_validation->set_rules('city_name','City Name','required');
			
			$this->form_validation->set_rules('state_id', 'State Id ', 'required');
			//$this->form_validation->set_rules('email_address', 'Email Address', 'required');
			// $this->form_validation->set_rules('description','Description','required');
			// $this->form_validation->set_rules('duration','Duration','required');
			// $this->form_validation->set_rules('price', 'Price ', 'required'); //{10} for 10 digits number
			// $this->form_validation->set_rules('maxprice', 'Max Price ', 'required'); //{10} for 10 digits number

			

			if($this->form_validation->run())
			{
				//echo "successfully validated";exit();
			
				$city_name=$this->input->post('city_name');
				$state_id=$this->input->post('state_id');
				// $duration=$this->input->post('duration');
				// $price=$this->input->post('price');
				// $maxprice=$this->input->post('maxprice');

				// //$daily_report=$this->input->post('daily_report');
				$status="Active";
				// $description=$this->input->post('description');
				
				// $subcategoryfile='';
				// if(isset($_FILES['subcategoryfile']))
				// {
				// 	if($_FILES['subcategoryfile']['name']!="")
				// 	{
				// 		$photo_imagename='';
				// 		$new_image_name = rand(1, 99999).$_FILES['subcategoryfile']['name'];
				// 		$config = array(
				// 					'upload_path' => "uploads/subcategory/",
				// 					'allowed_types' => "gif|jpg|png|bmp|jpeg",
				// 					'max_size' => "0", 
				// 					'file_name' =>$new_image_name
				// 		);
				// 		$this->load->library('upload', $config);
				// 		if($this->upload->do_upload('subcategoryfile'))
				// 		{ 
				// 			$imageDetailArray = $this->upload->data();								
				// 			$photo_imagename =  $imageDetailArray['file_name'];
				// 		}else
				// 		{
				// 			$errorMsg = $this->upload->display_errors();
				// 			$this->session->set_flashdata('error',$errorMsg);
				// 			redirect(base_url().'backend/SubCategory/addsubcategory/');

				// 		}
				// 		if($_FILES['subcategoryfile']['error']==0)
				// 		{ 
				// 			$subcategoryfile=$photo_imagename;
				// 		}
				// 	}
				// }

			
					$input_data = array(
						'city_name'=>$city_name,
						'state_id'=>$state_id,
						
						// 'duration'=>$duration,
						// 'price'=>$price,
						// 'max_price'=>$maxprice,
						// 'subcategory_image'=>$subcategoryfile,
						'city_status'=>$status,
						'dateadded' => date('Y-m-d H:i:s'),
						'dateupdated' => date('Y-m-d H:i:s')
						);

					// echo"<pre>";
					// print_r($input_data);
					// exit();
					
					$city_id = $this->City_model->insert_city($input_data);
					
					if($city_id)
					{	
						$this->session->set_flashdata('success','City added successfully.');

						redirect(base_url().'backend/City/managescity');	
					}
					else
					{
						$this->session->set_flashdata('error','Error while adding City.');

						redirect(base_url().'backend/City/addcity');
					}	
				
				

			}else{
				$this->session->set_flashdata('success','Validation failed. Please enter valid Text.');
				redirect(base_url().'backend/City/addcity');
			}
		}

		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/add_city',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function updatecity()
	{
		$data['title']='Update City';
		$data['error_msg']='';
		//echo "segment--".$this->uri->segment(4);exit();
		$city_id=base64_decode($this->uri->segment(4));
		//echo "Brand_id--".$brand_id;exit();
		$data['stateList']=$this->City_model->getAllState(1,"","");
		if($city_id)
		{
			$cityInfo=$this->City_model->getSingleCityInfo($city_id,0);
			if($cityInfo>0)
			{
				$data['cityInfo'] = $this->City_model->getSingleCityInfo($city_id,1);
				if(isset($_POST['btn_uptcity']))
				{
					$this->form_validation->set_rules('city_name','City Name','required');
			
			$this->form_validation->set_rules('state_id', 'State Id ', 'required');

					if($this->form_validation->run())
					{ 

						$city_name=$this->input->post('city_name');
				$state_id=$this->input->post('state_id');
                $status=$this->input->post('status');
				// $subcategory_name=$this->input->post('subcategory_name');
				// $duration=$this->input->post('duration');
				// $price=$this->input->post('price');
				// $maxprice=$this->input->post('maxprice');

				// $status=$this->input->post('status');
			//$status="active";
				// $description=$this->input->post('description');
				// $subcategoryfile='';
				// if(isset($_FILES['subcategoryfile']))
				// {
				// 	if($_FILES['subcategoryfile']['name']!="")
				// 	{
				// 		$photo_imagename='';
				// 		$new_image_name = rand(1, 99999).$_FILES['subcategoryfile']['name'];
				// 		$config = array(
				// 					'upload_path' => "uploads/subcategory/",
				// 					'allowed_types' => "gif|jpg|png|bmp|jpeg",
				// 					'max_size' => "0", 
				// 					'file_name' =>$new_image_name
				// 		);
				// 		$this->load->library('upload', $config);
				// 		if($this->upload->do_upload('subcategoryfile'))
				// 		{ 
				// 			$imageDetailArray = $this->upload->data();								
				// 			$photo_imagename =  $imageDetailArray['file_name'];
				// 		}else
				// 		{
				// 			$errorMsg = $this->upload->display_errors();
				// 			$this->session->set_flashdata('error',$errorMsg);
				// 			redirect(base_url().'backend/SubCategory/addsubcategory/');

				// 		}
				// 		if($_FILES['subcategoryfile']['error']==0)
				// 		{ 
				// 			$subcategoryfile=$photo_imagename;
				// 		}
				// 	}
				// }
							
						$input_data = array(
						'city_name'=>$city_name,
						'state_id'=>$state_id,
						
						// 'duration'=>$duration,
						// 'price'=>$price,
						// 'max_price'=>$maxprice,
						// 'subcategory_image'=>$subcategoryfile,
						'city_status'=>$status,
						
						'dateupdated' => date('Y-m-d H:i:s')
						
								);
					
					

						$city_data = $this->City_model->uptdateCity($input_data,$city_id);
// echo"<pre>";
// 					print_r($subcategory_data);
// 					exit();
						if($city_data)
						{	
							$this->session->set_flashdata('success','City Updated successfully.');

							redirect(base_url().'backend/City/managescity');	
						}
						else
						{
							$this->session->set_flashdata('error','Error while updating City.');

							redirect(base_url().'backend/City/update_city/'.base64_encode($city_id));
						}	
					}
					else
					{
						$this->session->set_flashdata('error',$this->form_validation->error_string());

						redirect(base_url().'backend/City/update_city/'.base64_encode($city_id));
					}
				}
			}
			else
			{
				$data['error_msg'] = 'User not found.';
			}
		}
		
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/update_city',$data);
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
	public function deletecity()
	{
		$data['error_msg']='';
		$city_id = base64_decode($this->uri->segment(4));
		if($city_id)
		{
			$cityInfo = $data['cityInfo'] = $this->City_model->getSingleCityInfo($city_id,1);
			if(count($cityInfo) > 0)
			{   
				$input_data = array(
					'city_status'=>'Delete',
					'dateupdated' => date('Y-m-d H:i:s')
				);

				$deluser = $this->City_model->uptdateCity($input_data,$city_id);
				if($deluser > 0)
				{
					$this->session->set_flashdata('success','City deleted successfully.');
					//redirect(base_url().'backend/Users/index');	
					redirect(base_url().'backend/City/managescity');
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleting user.');
					redirect(base_url().'backend/City/managescity');
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
			redirect(base_url().'backend/SubCategory/managesservice');
		}
	}
}