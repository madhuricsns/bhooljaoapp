<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
	public function __construct(){
		parent::__construct();
	if(empty($this->session->userdata('logged_in'))){
			redirect(base_url().'backend/login','refresh');  
		}
		$this->load->library("pagination");	
		$this->load->helper('email');
		$this->load->library('session');
		$this->load->model('adminModel/Category_model');
		$this->load->model('Common_Model');
		
	}
	public function index()
	{
		redirect(base_url().'backend/Category/manageCategory','refresh');
	}
	public function manageCategory()
	{
		$data['title']='Manage Category';
		$per_page='10';
		
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
		
		$data['categorycnt']=$this->Category_model->getAllCategory(0,"","");
		
		
		$config = array();
		$config["base_url"] = base_url().'backend/Category/manageCategory/'.$per_page;
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
		$config["total_rows"] =$data['categorycnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		//echo "ConttPerPage--".$config["per_page"];
		//echo "Conttpage--".$page;
		//exit();
		$data['categories']=$this->Category_model->getAllCategory(1,$config["per_page"],$page);
		//echo $this->db->last_query();exit;
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/manageCategory',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function addCategory()
	{
		$data['title']='Add Category';
		$data['error_msg']='';
		$data['categoryLists']=$this->Category_model->getAllCategorydropdown(1);	
		 // echo $this->db->last_query();exit;	
		if(isset($_POST['btn_addcategory']))
		{
			$this->form_validation->set_rules('category_name','Category Name','required');
			$this->form_validation->set_rules('description', 'Description', 'required');
			$this->form_validation->set_rules('status','Category Status','required');
			if($this->form_validation->run())
			{
				//echo "successfully validated";exit();
				$category=$this->input->post('category');
				$category_name=$this->input->post('category_name');
				$category_description=$this->input->post('description');
				$status=$this->input->post('status');
				//$description=$this->input->post('description');
						
				$categoryName=$this->Category_model->chkCategoryName($category_name,0);

				if($categoryName==0)
				{
					//Image Upload Code 
					if(count($_FILES) > 0) 
					{
						$ImageName = "category_image";
						$target_dir = "uploads/category_images/";
						$category_image= $this->Common_Model->ImageUpload($ImageName,$target_dir);
					}
					$input_data = array(
						'category_parent_id'=>$category,
						'category_name'=>trim($category_name),
						'category_image'=>$category_image,
						'category_description'=>$category_description,
						'category_status'=>$status,
						'dateupdated' => date('Y-m-d H:i:s'),
						'dateadded' => date('Y-m-d H:i:s')
						);

					/*echo"<pre>";
					print_r($input_data);
					exit();*/
					
					$user_id = $this->Common_Model->insert_data('category',$input_data);
					
					if($user_id)
					{	
						$this->session->set_flashdata('success','Category added successfully.');

						redirect(base_url().'backend/Category/manageCategory');	
					}
					else
					{
						$this->session->set_flashdata('error','Error while adding user.');

						redirect(base_url().'backend/Category/addCategory/');
					}	
				}
				else
				{
					$this->session->set_flashdata('success','Category  already exist.');

					redirect(base_url().'backend/Category/addCategory');	
				}

			}else{
				$this->session->set_flashdata('success','Validation failed. Please enter valid email or mobile number.');
				redirect(base_url().'backend/Category/addCategory');
			}
		}

		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/addCategory',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function updateCategory()
	{
		$data['title']='Update Category';
		$data['error_msg']='';
		//echo "segment--".$this->uri->segment(4);exit();
		$category_id=base64_decode($this->uri->segment(4));
		$data['categoryLists']=$this->Category_model->getAllCategorydropdown(1);
		//echo "Brand_id--".$brand_id;exit();

		if($category_id)
		{
			$categoryInfo=$this->Category_model->getSingleCategoryInfo($category_id,0);
			if($categoryInfo>0)
			{
				$data['categoryInfo'] = $this->Category_model->getSingleCategoryInfo($category_id,1);
				if(isset($_POST['btn_uptcategory']))
				{
					$this->form_validation->set_rules('category_name','Category Name','required');
					$this->form_validation->set_rules('description', 'Description', 'required');
					$this->form_validation->set_rules('status','Category Status','required');

					if($this->form_validation->run())
					{
						$category=$this->input->post('category');
						$category_name=$this->input->post('category_name');
						$category_description=$this->input->post('description');
						$status=$this->input->post('status');

						//Image Upload Code 
						if(count($_FILES) > 0) 
						{
							$ImageName = "category_image";
							$target_dir = "uploads/category_images/";
							$category_image= $this->Common_Model->ImageUpload($ImageName,$target_dir);
						}
						if($_FILES['category_image']['name']!="")
						{
							$input_data = array(
								'category_parent_id'=>$category,
								'category_name'=>trim($category_name),
								'category_image'=>$category_image,
								'category_description'=>$category_description,
								'category_status'=>$status,
								'dateupdated' => date('Y-m-d H:i:s')
							);
						}
						else{
							$input_data = array(
								'category_parent_id'=>$category,
								'category_name'=>trim($category_name),
								'category_description'=>$category_description,
								'category_status'=>$status,
								'dateupdated' => date('Y-m-d H:i:s')
							);
						}
					
						$userdata = $this->Category_model->uptdateCategory($input_data,$category_id);
						// echo $this->db->last_query();exit;
						if($userdata)
						{	
							$this->session->set_flashdata('success','Category updated successfully.');

							redirect(base_url().'backend/Category/manageCategory');	
						}
						else
						{
							$this->session->set_flashdata('error','Error while updating User.');

							redirect(base_url().'backend/Category/updateCategory/'.base64_encode($category_id));
						}	
					}
					else
					{
						$this->session->set_flashdata('error',$this->form_validation->error_string());

						redirect(base_url().'backend/Category/updateCategory/'.base64_encode($category_id));
					}
				}
			}
			else
			{
				$data['error_msg'] = 'Category not found.';
			}
		}
		
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/updateCategory',$data);
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
								'category_status'=> $statusTobeUpdated
								);
			$userdata = $this->Category_model->uptdateStatus($input_data,$user_id);
			if($userdata){
				$this->session->set_flashdata('success','Status updated successfully.');
				redirect(base_url().'backend/Category/manageCategory/');
				}
		}
	}
	
	public function deleteCategory()
	{
		$data['error_msg']='';
		$category_id = base64_decode($this->uri->segment(4));
		if($category_id)
		{
			$categoryInfo = $data['categoryInfo'] = $this->Category_model->getSingleCategoryInfo($category_id,1);
			if(count($categoryInfo) > 0)
			{   
				$input_data = array(
					'category_status'=>'Delete',
					'dateupdated' => date('Y-m-d H:i:s')
				);

				$deluser = $this->Category_model->uptdateCategory($input_data,$category_id);
				if($deluser > 0)
				{
					$this->session->set_flashdata('success','Category deleted successfully.');
					redirect(base_url().'backend/Category/manageCategory');	
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleting user.');
					redirect(base_url().'backend/Category/manageCategory');
				}
			}
			else
			{
				$data['error_msg'] = 'Category not found.';
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

		$data['userList']=$userList=$this->Category_model->getAllUsers(1,"","");

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

//<---------------------------------<Sub Category>-------------------------------------------->


public function manageSubCategory()
	{
		$data['title']='Manage Sub Category';
		
		$id = base64_decode($this->uri->segment(4));
		
		$data['subcategorycnt']=$this->Category_model->getAllSubcategory(0,"","",$id);
		
		$config = array();
		$config["base_url"] = base_url().'backend/Service/manageSubCategory/';
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
		$config["total_rows"] =$data['subcategorycnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		//echo "ConttPerPage--".$config["per_page"];
		//echo "Conttpage--".$page;
		//exit();
		$data['subcategoryList']=$this->Category_model->getAllSubcategory(1,$config["per_page"],$page,$id);
		//echo $this->db->last_query();exit;
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/SubCategorylising',$data);
		$this->load->view('admin/admin_footer');
	
	}


	
}