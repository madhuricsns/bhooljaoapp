<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HelpCenter extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if(empty($this->session->userdata('logged_in'))){
			
			redirect(base_url().'backend/Login','refresh');
		}
		$this->load->library("pagination");	
		$this->load->model('adminModel/HelpCenter_model');
	}
	public function index()
	{
		redirect('backend/HelpCenter/manageHelpCenter','refresh');
	}
	public function manageHelpCenter()
	{
		$data['title']='Manage Feedback';
		
		$data['Helpcentercnt']=$this->HelpCenter_model->getAllHelpCenter(0,"","");
		
		$config = array();
		$config["base_url"] = base_url().'backend/HelpCenter/index/';
		$config['per_page'] = 25;
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
		$config["total_rows"] =$data['Helpcentercnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		$data['HelpCenter']=$this->HelpCenter_model->getAllHelpCenter(1,$config["per_page"],$page);
		//echo $this->db->last_query();exit;
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/manageHelpCenter',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function addHelpCenter()
	{
		$data['title']='Add HelpCenter';
		$data['error_msg']='';
				
		if(isset($_POST['btn_addHelpCenter']))
		{
			$this->form_validation->set_rules('helpcenter_name','HelpCenter Name','required');
			$this->form_validation->set_rules('helpcenter_value','HelpCenter Value ','required');

			if($this->form_validation->run())
			{
				$helpcenter_name=$this->input->post('helpcenter_name');
				$helpcenter_value=$this->input->post('helpcenter_value');
				
				$helpcenter_image='';
				if(isset($_FILES['helpcenter_image']))
				{
					if($_FILES['helpcenter_image']['name']!="")
					{
						$photo_imagename='';
						$new_image_name = rand(1, 99999).$_FILES['helpcenter_image']['name'];
						$config = array(
									'upload_path' => "uploads/helpcenter/",
									'allowed_types' => "gif|jpg|png|bmp|jpeg",
									'max_size' => "0", 
									'file_name' =>$new_image_name
						);
						$this->load->library('upload', $config);
						if($this->upload->do_upload('helpcenter_image'))
						{ 
							$imageDetailArray = $this->upload->data();								
							$photo_imagename =  $imageDetailArray['file_name'];
						}else
						{
							$errorMsg = $this->upload->display_errors();
							$this->session->set_flashdata('error',$errorMsg);
							redirect(base_url().'backend/HelpCenter/addHelpCenter/');

						}
						if($_FILES['helpcenter_image']['error']==0)
						{ 
							$helpcenter_image=$photo_imagename;
						}
					}
				}
					$checkName = $this->HelpCenter_model->chkHelpName($helpcenter_name,0);
					// echo $checkName;
					// echo $this->db->last_query();exit;
					if($checkName==0)
					{
						$input_data = array(
							'help_image'=>$helpcenter_image,
							'help_name'=>$helpcenter_name,
							'help_value'=>$helpcenter_value,
							'help_type'=>'contactus',
							'dateupdated' => date('Y-m-d H:i:s'),
							'dateadded' => date('Y-m-d H:i:s')
							);
						// echo"<pre>";
						// print_r($input_data);
						// exit();

						$help_id = $this->HelpCenter_model->insert_HelpCenter($input_data);
						
						if($help_id)
						{	
							$this->session->set_flashdata('success','HelpCenter added successfully.');
							redirect(base_url().'backend/HelpCenter/index');	
						}
						else
						{
							$this->session->set_flashdata('error','Error while adding HelpCenter.');
							redirect(base_url().'backend/HelpCenter/addHelpCenter/');
						}
					}
					else
					{
						$this->session->set_flashdata('error','Help name already exist.');
						redirect(base_url().'backend/HelpCenter/addHelpCenter/');
					}

				}
				else
				{
					$this->session->set_flashdata('error','HelpCenter is already exist.');
					redirect(base_url().'backend/HelpCenter/addHelpCenter');	
				}

			}
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/addHelpCenter',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function updateHelpCenter()
	{
		$data['title']='Update HelpCenter';
		$data['error_msg']='';
		//echo "segment--".$this->uri->segment(4);exit();
		$help_id=base64_decode($this->uri->segment(4));
		$help_id_base64 = base64_encode($help_id);
		//echo "Brand_id--".$brand_id;exit();
		if($help_id)
		{
			$HelpInfo=$this->HelpCenter_model->getSingleHelpCenterInfo($help_id,0);
			if($HelpInfo>0)
			{
				$data['HelpInfo'] = $this->HelpCenter_model->getSingleHelpCenterInfo($help_id,1);
				if(isset($_POST['btn_uptHelpCenter']))
				{
				$this->form_validation->set_rules('helpcenter_name','HelpCenter Name','required');
				$this->form_validation->set_rules('helpcenter_value','HelpCenter Value ','required');

				if($this->form_validation->run())
				{

					$helpcenter_name=$this->input->post('helpcenter_name');
					$helpcenter_value=$this->input->post('helpcenter_value');


					$helpcenter_image='';
					if(isset($_FILES['helpcenter_image']))
					{
						if($_FILES['helpcenter_image']['name']!="")
						{
							$photo_imagename='';
							$new_image_name = rand(1, 99999).$_FILES['helpcenter_image']['name'];
							$config = array(
										'upload_path' => "uploads/helpcenter/",
										'allowed_types' => "gif|jpg|png|bmp|jpeg",
										'max_size' => "0", 
										'file_name' =>$new_image_name
							);
							$this->load->library('upload', $config);
							if($this->upload->do_upload('helpcenter_image'))
							{ 
								$imageDetailArray = $this->upload->data();								
								$photo_imagename =  $imageDetailArray['file_name'];
							}else
							{
								$errorMsg = $this->upload->display_errors();
								$this->session->set_flashdata('error',$errorMsg);
								redirect(base_url().'backend/HelpCenter/addHelpCenter/');

							}
							if($_FILES['helpcenter_image']['error']==0)
							{ 
								$helpcenter_image=$photo_imagename;
							}
						}
					}
						$checkName = $this->HelpCenter_model->chkUpdateHelpName($helpcenter_name,$help_id,0);
						// echo $checkName;
						// echo $this->db->last_query();exit;
						if($checkName==0)
						{
							if($helpcenter_image!="")
							{
								$input_data = array(
									'help_image'=>$helpcenter_image,
									'help_name'=>$helpcenter_name,
									'help_value'=>$helpcenter_value,
									'dateupdated' => date('Y-m-d H:i:s')
									);
							}
							else
							{
								$input_data = array(
									'help_name'=>$helpcenter_name,
									'help_value'=>$helpcenter_value,
									'dateupdated' => date('Y-m-d H:i:s')
									);
							}
							
							$HELPdata = $this->HelpCenter_model->uptdateHelpCenter($input_data,$help_id);

							if($HELPdata)
							{	
								$this->session->set_flashdata('success','HelpCenter updated successfully.');
								redirect(base_url().'backend/HelpCenter/index');	
							}
							else
							{
								$this->session->set_flashdata('error','Error while updating FAQ.');
								redirect(base_url().'backend/HelpCenter/updateHelpCenter/'.base64_encode($help_id));
							}	
						}
						else
						{
							$this->session->set_flashdata('error','Help name already exist.');
							redirect(base_url().'backend/HelpCenter/updateHelpCenter/'.base64_encode($help_id));
						}
					}
					else
					{
						$this->session->set_flashdata('error',$this->form_validation->error_string());
						redirect(base_url().'backend/HelpCenter/updateHelpCenter/'.base64_encode($help_id));
					}
				}
			}
			else
			{
				$data['error_msg'] = 'Help name not found.';
			}
		}
		
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/updateHelpCenter',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function deleteHelpCenter()
	{
		$data['error_msg']='';
		$help_id = base64_decode($this->uri->segment(4));
		if($help_id)
		{
			$HelpInfo = $data['HelpCenterInfo'] = $this->HelpCenter_model->getSingleHelpCenterInfo($help_id,1);
			if(count($HelpInfo) > 0)
			{
				$delHelp=$this->HelpCenter_model->deleteHelpCenter($help_id);
				if($delHelp > 0)
				{
					$this->session->set_flashdata('success','HelpCenter deleted successfully.');
					redirect(base_url().'backend/HelpCenter/index');	
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleting HelpCenter.');
					redirect(base_url().'backend/HelpCenter/index');
				}
			}
			else
			{
				$data['error_msg'] = 'HelpCenter not found.';
			}
		}
		else
		{
			$this->session->set_flashdata('error','FAQ not found.');
			redirect(base_url().'backend/HelpCenter/index');
		}
	}
	public function change_status()
	{
		$data['title']='Change Status';
		$data['error_msg']='';
		
		$banner_id=base64_decode($this->uri->segment(4));

		$statusTobeUpdated=base64_decode($this->uri->segment(5));
		//echo "user_id--".$user_id;exit();
		if($banner_id)
		{
			$input_data = array(
								'faq_status'=> $statusTobeUpdated
								);
			$userdata = $this->FAQ_model->uptdateStatus($input_data,$banner_id);
			if($userdata){
				$this->session->set_flashdata('success','Status updated successfully.');
				redirect(base_url().'backend/FAQ/manageFAQ/');
				}
		}
	}
}