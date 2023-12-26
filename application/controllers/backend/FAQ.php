<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FAQ extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if(empty($this->session->userdata('logged_in'))){
			
			redirect(base_url().'backend/Login','refresh');
		}
		$this->load->library("pagination");	
		$this->load->model('adminModel/FAQ_model');
	}
	public function index()
	{
		redirect('backend/FAQ/manageFaq','refresh');
	}
	public function manageFAQ()
	{
		$data['title']='Manage FAQ';
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
		
	$data['faqcnt']=$this->FAQ_model->getAllFAQ(0,"","");
		
		
		$config = array();
		$config["base_url"] = base_url().'backend/FAQ/manageFAQ/'.$per_page;
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
		$config["total_rows"] =$data['faqcnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		$data['FAQS']=$this->FAQ_model->getAllFAQ(1,$config["per_page"],$page);
		//echo $this->db->last_query();exit;
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/manageFAQ',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function addFAQ()
	{
		$data['title']='Add FAQ';
		$data['error_msg']='';
				
		if(isset($_POST['btn_addFAQ']))
		{
			$this->form_validation->set_rules('faq_question','FAQ Question','required');
			$this->form_validation->set_rules('faq_answer','FAQ answer ','required');
			$this->form_validation->set_rules('faq_type','FAQ Type ','required');
			$this->form_validation->set_rules('status','FAQ Status','required');
			if($this->form_validation->run())
			{
				$faq_question=$this->input->post('faq_question');
				$faq_answer=$this->input->post('faq_answer');
				$faq_type=$this->input->post('faq_type');
				$faq_status=$this->input->post('status');
				
					$input_data = array(
						'faq_question'=>trim($faq_question),
						'faq_answer'=>$faq_answer,
						'faq_type'=>$faq_type,
						'faq_status'=>$faq_status,
						'dateupdated' => date('Y-m-d H:i:s'),
						'dateadded' => date('Y-m-d H:i:s')
						
						);
					// echo"<pre>";
					// print_r($input_data);
					// exit();

					$faq_id = $this->FAQ_model->insert_FAQ($input_data);
					
					if($faq_id)
					{	
						$this->session->set_flashdata('success','FAQ added successfully.');

						redirect(base_url().'backend/FAQ/index');	
					}
					else
					{
						$this->session->set_flashdata('error','Error while adding FAQ.');

						redirect(base_url().'backend/FAQ/addFAQ/');
					}	
				}
				else
				{
					$this->session->set_flashdata('error','FAQ is already exist.');

					redirect(base_url().'backend/FAQ/addFAQ');	
				}

			}
		

		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/addFAQ',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function updateFAQ()
	{
		$data['title']='Update FAQ';
		$data['error_msg']='';
		//echo "segment--".$this->uri->segment(4);exit();
		$faq_id=base64_decode($this->uri->segment(4));
		$faq_id_base64 = base64_encode($faq_id);
		//echo "Brand_id--".$brand_id;exit();
		if($faq_id)
		{
			$FAQInfo=$this->FAQ_model->getSingleFAQInfo($faq_id,0);
			if($FAQInfo>0)
			{
				$data['FAQInfo'] = $this->FAQ_model->getSingleFAQInfo($faq_id,1);
				if(isset($_POST['btn_uptFAQ']))
				{
					$this->form_validation->set_rules('faq_question','FAQ Question','required');
			$this->form_validation->set_rules('faq_answer','FAQ answer ','required');
			$this->form_validation->set_rules('faq_type','FAQ Type ','required');
			$this->form_validation->set_rules('status','FAQ Status','required');

					if($this->form_validation->run())
					{
						$faq_question=$this->input->post('faq_question');
				$faq_answer=$this->input->post('faq_answer');
				$faq_type=$this->input->post('faq_type');
				$faq_status=$this->input->post('status');
				
									
						$input_data = array(
								'faq_question'=>trim($faq_question),
						'faq_answer'=>$faq_answer,
						'faq_type'=>$faq_type,
						'faq_status'=>$faq_status,
								'dateupdated' => date('Y-m-d H:i:s')
								);
					// 	echo"<pre>";
					// print_r($input_data);
					// exit();

						$FAQdata = $this->FAQ_model->uptdateFAQ($input_data,$faq_id);

						if($FAQdata)
						{	
							$this->session->set_flashdata('success','FAQ updated successfully.');

							redirect(base_url().'backend/FAQ/index');	
						}
						else
						{
							$this->session->set_flashdata('error','Error while updating FAQ.');

							redirect(base_url().'backend/FAQ/updateFAQ/'.base64_encode($faq_id));
						}	
					}
					else
					{
						$this->session->set_flashdata('error',$this->form_validation->error_string());

						redirect(base_url().'backend/FAQ/updateFAQ/'.base64_encode($faq_id));
					}
				}
			}
			else
			{
				$data['error_msg'] = 'FAQ not found.';
			}
		}
		
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/updateFAQ',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function deleteFAQ()
	{
		$data['error_msg']='';
		$faq_id = base64_decode($this->uri->segment(4));
		if($faq_id)
		{
			$FAQInfo = $data['bannerInfo'] = $this->FAQ_model->getSingleFAQInfo($faq_id,1);
			if(count($FAQInfo) > 0)
			{
				$delFAQ=$this->FAQ_model->deleteFAQ($faq_id);
				if($delFAQ > 0)
				{
					$this->session->set_flashdata('success','FAQ deleted successfully.');
					redirect(base_url().'backend/FAQ/index');	
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleting FAQ.');
					redirect(base_url().'backend/FAQ/index');
				}
			}
			else
			{
				$data['error_msg'] = 'FAQ not found.';
			}
		}
		else
		{
			$this->session->set_flashdata('error','FAQ not found.');
			redirect(base_url().'backend/FAQ/index');
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