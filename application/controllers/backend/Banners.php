<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banners extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if(empty($this->session->userdata('logged_in'))){
			
			redirect(base_url().'backend/Login','refresh');
		}
		$this->load->library("pagination");	
		$this->load->model('adminModel/Banner_model');
		$this->load->model('Common_Model');
	}
	public function index()
	{
		redirect('backend/Banners/manageBanner','refresh');
	}
	public function manageBanner()
	{
		$data['title']='Manage Banners';
		
		if($this->session->userdata("pagination_rows") != '')
		{
			$per_page = $this->session->userdata("pagination_rows");
		}
		else {
			$per_page='10';
		}
		
		$data['bannercnt']=$this->Banner_model->getAllBanners(0,"","");
		
		
		
		$config = array();
		$config["base_url"] = base_url().'backend/Banners/manageBanner/'.$per_page;
		$config['per_page'] = $per_page;
		
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
		$config["total_rows"] =$data['bannercnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		$data['banners']=$this->Banner_model->getAllBanners(1,$config["per_page"],$page);
		//echo $this->db->last_query();exit;
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/manageBanners',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function addBanner()
	{
		$data['title']='Add Banner';
		$data['error_msg']='';
				
		if(isset($_POST['btn_addbanner']))
		{
			$this->form_validation->set_rules('banner_title','Banner Title','required');
			$this->form_validation->set_rules('banner_type','Banner Type ','required');
			$this->form_validation->set_rules('status','Banner Status','required');
			if($this->form_validation->run())
			{
				$banner_title=$this->input->post('banner_title');
				$banner_type=$this->input->post('banner_type');
				$status=$this->input->post('status');
				$banner_image='';
				if(isset($_FILES['banner_image']))
				{
					if($_FILES['banner_image']['name']!="")
					{
						$photo_imagename='';
						$new_image_name = rand(1, 99999).$_FILES['banner_image']['name'];
						$config = array(
									'upload_path' => "uploads/banner_images/",
									'allowed_types' => "gif|jpg|png|bmp|jpeg",
									'max_size' => "0", 
									'file_name' =>$new_image_name
						);
						$this->load->library('upload', $config);
						if($this->upload->do_upload('banner_image'))
						{ 
							$imageDetailArray = $this->upload->data();								
							$photo_imagename =  $imageDetailArray['file_name'];
						}else
						{
							$errorMsg = $this->upload->display_errors();
							$this->session->set_flashdata('error',$errorMsg);
							redirect(base_url().'backend/Banners/addBanner/');

						}
						if($_FILES['banner_image']['error']==0)
						{ 
							$banner_image=$photo_imagename;
						}
					}
				}
				//$description=$this->input->post('description');
				
				$bannertitle=$this->Banner_model->chkBannerName($banner_title,0);

				if($bannertitle==0)
				{
					$input_data = array(
						'banner_title'=>trim($banner_title),
						'banner_type'=>$banner_type,
						'banner_status'=>$status,
						'dateupdated' => date('Y-m-d H:i:s'),
						'dateadded' => date('Y-m-d H:i:s'),
						'banner_image'=>$banner_image
						);
					/*echo"<pre>";
					print_r($input_data);
					exit();*/

					$banner_id = $this->Banner_model->insert_banner($input_data);
					
					if($banner_id)
					{	
						$this->session->set_flashdata('success','Banner added successfully.');

						redirect(base_url().'backend/Banners/index');	
					}
					else
					{
						$this->session->set_flashdata('error','Error while adding Banner.');

						redirect(base_url().'backend/Banners/addBanner/');
					}	
				}
				else
				{
					$this->session->set_flashdata('error','Banner name is already exist.');

					redirect(base_url().'backend/Banners/addBanner');	
				}

			}
		}

		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/addBanner',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function updateBanner()
	{
		$data['title']='Update Banner';
		$data['error_msg']='';
		//echo "segment--".$this->uri->segment(4);exit();
		$banner_id=base64_decode($this->uri->segment(4));
		$banner_id_base64 = base64_encode($banner_id);
		//echo "Brand_id--".$brand_id;exit();
		if($banner_id)
		{
			$bannerInfo=$this->Banner_model->getSingleBannerInfo($banner_id,0);
			if($bannerInfo>0)
			{
				$data['BannerInfo'] = $this->Banner_model->getSingleBannerInfo($banner_id,1);
				if(isset($_POST['btn_uptbanner']))
				{
					// print_r($_POST);
					$this->form_validation->set_rules('banner_title','Banner Title','required');
					$this->form_validation->set_rules('banner_type','Banner Type ','required');
					$this->form_validation->set_rules('status','Banner Status','required');

					if($this->form_validation->run())
					{
						$banner_title = $this->input->post('banner_title');
						$banner_type=$this->input->post('banner_type');
						$status = $this->input->post('status');
						// print_r($_FILES);
						// echo count($_FILES);
						// $banner_image='';
						if(count($_FILES) > 0) 
						{
							$ImageName = "banner_image";
							$target_dir = "uploads/banner_images/";
							$banner_image= $this->Common_Model->ImageUpload($ImageName,$target_dir);
						}
						// echo $banner_image;
						// exit;
						//$description = $this->input->post('description');
						if($_FILES['banner_image']['name']!="")
						{
							$input_data = array(
								'banner_title'=>trim($banner_title),
								'banner_type'=>$banner_type,
								'banner_status'=>$status,
								'banner_image'=>$banner_image,
								'dateupdated' => date('Y-m-d H:i:s')
								);
						}
						else
						{
							$input_data = array(
								'banner_title'=>trim($banner_title),
								'banner_type'=>$banner_type,
								'banner_status'=>$status,
								'dateupdated' => date('Y-m-d H:i:s')
								);
						}
						// print_r($input_data);exit;
						$bannerdata = $this->Banner_model->uptdateBanner($input_data,$banner_id);

						if($bannerdata)
						{	
							$this->session->set_flashdata('success','Banner updated successfully.');

							redirect(base_url().'backend/Banners/index');	
						}
						else
						{
							$this->session->set_flashdata('error','Error while updating banner.');

							redirect(base_url().'backend/Banners/updateBanner/'.base64_encode($banner_id));
						}	
					}
					else
					{
						$this->session->set_flashdata('error',$this->form_validation->error_string());

						redirect(base_url().'backend/Banners/updateBanner/'.base64_encode($banner_id));
					}
				}
			}
			else
			{
				$data['error_msg'] = 'Banner not found.';
			}
		}
		
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/updateBanner',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function deleteBanner()
	{
		$data['error_msg']='';
		$banner_id = base64_decode($this->uri->segment(4));
		if($banner_id)
		{
			$bannerInfo = $data['bannerInfo'] = $this->Banner_model->getSingleBannerInfo($banner_id,1);
			if(count($bannerInfo) > 0)
			{
				$delbanner=$this->Banner_model->deleteBanner($banner_id);
				if($delbanner > 0)
				{
					$this->session->set_flashdata('success','Banner deleted successfully.');
					redirect(base_url().'backend/Banners/index');	
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleting banner.');
					redirect(base_url().'backend/Banners/index');
				}
			}
			else
			{
				$data['error_msg'] = 'Banner not found.';
			}
		}
		else
		{
			$this->session->set_flashdata('error','Banner not found.');
			redirect(base_url().'backend/Banners/index');
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
								'banner_status'=> $statusTobeUpdated
								);
			$userdata = $this->Banner_model->uptdateStatus($input_data,$banner_id);
			if($userdata){
				$this->session->set_flashdata('success','Status updated successfully.');
				redirect(base_url().'backend/Banners/manageBanner/');
				}
		}
	}
}