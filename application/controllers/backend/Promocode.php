<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promocode extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if(empty($this->session->userdata('logged_in'))){
			
			redirect(base_url().'backend/Login','refresh');
		}
		$this->load->library("pagination");	
		$this->load->model('adminModel/Promocode_model');
	}
	public function index()
	{
		redirect('backend/Promocode/managePromocode','refresh');
	}
	public function managePromocode()
	{
		$data['title']='Manage Promocode';
		
		$data['promocodecnt']=$this->Promocode_model->getAllPromocode(0,"","");
		
		$config = array();
		$config["base_url"] = base_url().'backend/Promocode/index/';
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
		$config["total_rows"] =$data['promocodecnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		$data['promocodes']=$this->Promocode_model->getAllPromocode(1,$config["per_page"],$page);

		//echo $this->db->last_query();exit;
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/managePromocode',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function addPromocode()
	{
		$data['title']='Add Promocode';
		$data['error_msg']='';
		$data['serviceList']=$this->Promocode_model->getAllservice(1,"","");
				
		if(isset($_POST['btn_addPromocode']))
		{
			$this->form_validation->set_rules('service_id','Service Id','required');
			$this->form_validation->set_rules('promocode_code','Promocode Code ','required');
			$this->form_validation->set_rules('promocode_description','Promocode Description','required');
			$this->form_validation->set_rules('promocode_discount','Promocode Discount','required');
			$this->form_validation->set_rules('promocode_type','Promocode Type','required');
			
			$this->form_validation->set_rules('status','Promocode Status','required');
			if($this->form_validation->run())
			{
				$service_id=$this->input->post('service_id');
				$promocode_code=$this->input->post('promocode_code');
				$promocode_description=$this->input->post('promocode_description');
				$promocode_discount=$this->input->post('promocode_discount');
				$promocode_type=$this->input->post('promocode_type');
				$status=$this->input->post('status');
				
				//$description=$this->input->post('description');
				
				$promocode=$this->Promocode_model->chkPromocode_codeName($promocode_code,0);

				if($promocode==0)
				{
					$input_data = array(
						'service_id'=>$service_id,
						'promocode_code'=>$promocode_code,
						'promocode_description'=>$promocode_description,
						'promocode_type'=>$promocode_type,
						'promocode_discount'=>$promocode_discount,
						'promocode_status'=>$status,
						'dateupdated' => date('Y-m-d H:i:s'),
						'dateadded' => date('Y-m-d H:i:s')
						
						);
					// echo"<pre>";
					// print_r($input_data);
					// exit();

					$promocode_id = $this->Promocode_model->insert_Promocode($input_data);
					
					if($promocode_id)
					{	
						$this->session->set_flashdata('success','Promocode added successfully.');

						redirect(base_url().'backend/Promocode/index');	
					}
					else
					{
						$this->session->set_flashdata('error','Error while adding Promocode.');

						redirect(base_url().'backend/Promocode/addPromocode/');
					}	
				}
				else
				{
					$this->session->set_flashdata('error','Promocode name is already exist.');

					redirect(base_url().'backend/Promocode/addPromocode');	
				}

			}
		}

		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/addPromocode',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function updatePromocode()
	{
		$data['title']='Update Promocode';
		$data['error_msg']='';
		$data['serviceList']=$this->Promocode_model->getAllservice(1,"","");
		//echo "segment--".$this->uri->segment(4);exit();
		$promocode_id=base64_decode($this->uri->segment(4));
		$promocode_id_base64 = base64_encode($promocode_id);
		//echo "promocoder_id--".$promocoder_id;exit();
		if($promocode_id)
		{
			$PromocodeInfo=$this->Promocode_model->getSinglepromocodeInfo($promocode_id,0);
			if($PromocodeInfo >0)
			{
				$data['PromocodeInfo'] = $this->Promocode_model->getSinglepromocodeInfo($promocode_id,1);
				if(isset($_POST['btn_uptpromocode']))
				{
					$this->form_validation->set_rules('service_id','Service Id','required');
			$this->form_validation->set_rules('promocode_code','Promocode Code ','required');
			$this->form_validation->set_rules('promocode_description','Promocode Description','required');
			$this->form_validation->set_rules('promocode_discount','Promocode Discount','required');
			$this->form_validation->set_rules('promocode_type','Promocode Type','required');
			
			$this->form_validation->set_rules('status','Promocode Status','required');
			if($this->form_validation->run())
					{
						
				$service_id=$this->input->post('service_id');
				$promocode_code=$this->input->post('promocode_code');
				$promocode_description=$this->input->post('promocode_description');
				$promocode_discount=$this->input->post('promocode_discount');
				$promocode_type=$this->input->post('promocode_type');
				$status=$this->input->post('status');
						//$description = $this->input->post('description');
									
						$input_data = array(
								'service_id'=>$service_id,
								'promocode_code'=>$promocode_code,
								'promocode_description'=>$promocode_description,
								'promocode_type'=>$promocode_type,
								'promocode_discount'=>$promocode_discount,
								'promocode_status'=>$status,
								'dateupdated' => date('Y-m-d H:i:s')
								);

						$promocodedata = $this->Promocode_model->uptdatePromocode($input_data,$promocode_id);

						if($promocodedata)
						{	
							$this->session->set_flashdata('success','Promocode updated successfully.');

							redirect(base_url().'backend/Promocode/index');	
						}
						else
						{
							$this->session->set_flashdata('error','Error while updating Promocode.');

						redirect(base_url().'backend/Promocode/updatePromocode/'.base64_encode($promocode_id));
						}	
					
					}
					else
					{
						$this->session->set_flashdata('error',$this->form_validation->error_string());

						redirect(base_url().'backend/Service_provider/updateservice/'.base64_encode($user_id));
					}
				}
			}
				else
			{
				$data['error_msg'] = 'Promocode not found.';
			}
		}
		
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/updatePromocode',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function deletePromocode()
	{
		$data['error_msg']='';
		$promocode_id = base64_decode($this->uri->segment(4));
		if($promocode_id)
		{
			$PromocodeInfo = $data['PromocodeInfo'] = $this->Promocode_model->getSinglepromocodeInfo($promocode_id,1);
			if(count($PromocodeInfo) > 0)
			{
				$delPromocode=$this->Promocode_model->deletePromocode($promocode_id);
				if($delPromocode > 0)
				{
					$this->session->set_flashdata('success','Promocode deleted successfully.');
					redirect(base_url().'backend/Promocode/index');	
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleting Promocode.');
					redirect(base_url().'backend/Promocode/index');
				}
			}
			else
			{
				$data['error_msg'] = 'Promocode not found.';
			}
		}
		else
		{
			$this->session->set_flashdata('error','Promocode not found.');
			redirect(base_url().'backend/Promocode/index');
		}
	}
}