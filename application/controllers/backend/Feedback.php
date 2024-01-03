<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if(empty($this->session->userdata('logged_in'))){
			
			redirect(base_url().'backend/Login','refresh');
		}
		$this->load->library("pagination");	
		$this->load->library('session');
		$this->load->model('adminModel/Feedback_model');
	}
	
	public function index()
	{
		redirect('backend/Feedback/manageFeedback','refresh');
	}
	public function manageFeedback()
	{
		$data['title']='Manage Feedback';
		
		if($this->session->userdata("pagination_rows") != '')
		{
			$per_page = $this->session->userdata("pagination_rows");
		}
		else {
			$per_page='10';
		}
		
		$data['feedbackcnt']=$this->Feedback_model->getAllFeedback(0,"","");
		
		
		$config = array();
		$config["base_url"] = base_url().'backend/Feedback/manageFeedback/'.$per_page;
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
		$config["total_rows"] =$data['feedbackcnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		$data['Feedbacks']=$this->Feedback_model->getAllFeedback(1,$config["per_page"],$page);
		//echo $this->db->last_query();exit;
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/manageFeedback',$data);
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
	
	public function feedbackReply()
	{
		$data['title']='Feedback Reply';
		$data['error_msg']='';
		$feedback_id=base64_decode($this->uri->segment(4));
		$feedback_id_base64 = base64_encode($feedback_id);
		//echo "Brand_id--".$brand_id;exit();
		if($feedback_id)
		{
			$FeedbackInfo=$this->Feedback_model->getSingleFeedbackInfo($feedback_id,0);
			if($FeedbackInfo>0)
			{
				$data['FeedbackInfo'] = $this->Feedback_model->getSingleFeedbackInfo($feedback_id,1);
				if(isset($_POST['btn_replyFeedback']))
				{
					$this->form_validation->set_rules('admin_reply','Reply','required');

					if($this->form_validation->run())
					{
						$admin_reply=$this->input->post('admin_reply');
									
						$input_data = array(
								'admin_reply'=>trim($admin_reply),
								'reply_date' => date('Y-m-d')
								);
					
						$Updatedata = $this->Feedback_model->uptdateFeedback($input_data,$feedback_id);

						if($Updatedata)
						{	
							$this->session->set_flashdata('success','Feedback updated successfully.');
							redirect(base_url().'backend/Feedback/index');	
						}
						else
						{
							$this->session->set_flashdata('error','Error while updating FAQ.');
							redirect(base_url().'backend/Feedback/feedbackReply/'.base64_encode($faq_id));
						}	
					}
					else
					{
						$this->session->set_flashdata('error',$this->form_validation->error_string());
						redirect(base_url().'backend/Feedback/feedbackReply/'.base64_encode($faq_id));
					}
				}
			}
			else
			{
				$data['error_msg'] = 'Feedback not found.';
			}
		}
		
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/feedback_reply',$data);
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