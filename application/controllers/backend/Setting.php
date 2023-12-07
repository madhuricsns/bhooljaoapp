<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if(empty($this->session->userdata('logged_in'))){
			
			redirect(base_url().'backend/Login','refresh');
		}
		$this->load->library("pagination");	
		$this->load->model('adminModel/Setting_model');
	}
	public function index()
	{
		redirect('backend/Setting/manageSetting','refresh');
	}

	public function manageSetting()
	{
		$data['title']='Manage Setting';

		
		$data['settingcnt']=$this->Setting_model->getAllSetting(0,"","");
		
		$config = array();
		$config["base_url"] = base_url().'backend/Setting/manageSetting/';
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
		$config["total_rows"] =$data['settingcnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		$data['Settings']=$this->Setting_model->getAllSetting(1,$config["per_page"],$page);
		//echo $this->db->last_query();exit;
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/manageSetting',$data);
		$this->load->view('admin/admin_footer');
	}

public function updateSetting()
	{
		$data['title']='Update Setting';
		$data['error_msg']='';
		

			$setting_id=base64_decode($this->uri->segment(4));

			if ($setting_id) {
				$data['setting_id']=$setting_id;
				$settingInfo=$this->Setting_model->getSingleSettingInfo($setting_id,0);
			
			if($settingInfo>0)
			{
				$data['SettingInfo'] = $this->Setting_model->getSingleSettingInfo($setting_id,1);

				if(isset($_POST['btn_upsettig']))
				{
				
			        $this->form_validation->set_rules('commission','Commission','required');


					if($this->form_validation->run())
					{
						$commission=$this->input->post('commission');
						
						
							
						$input_data = array(
                            'commission'=>$commission
                         );
					// echo"<pre>";
					// print_r($input_data);
					// exit();
						$updatesetting = $this->Setting_model->updateAdminsetting($input_data,$setting_id);
                       
                       // echo $this->db->last_query();exit;
						if($updatesetting)
						{	
							$this->session->set_flashdata('success',' Updated setting successfully.');

							redirect(base_url().'backend/Setting/manageSetting');	
						}
						else
						{
							$this->session->set_flashdata('error','Error while updating setting.');

							redirect(base_url().'backend/Setting/AssingDateTime/'.base64_encode($booking_id));
						}	
					}
					else
					{
						$this->session->set_flashdata('error',$this->form_validation->error_string());

						redirect(base_url().'backend/Setting/AssingDateTime/'.base64_encode($booking_id));
					}
				}
			}
			else
			{
				$data['error_msg'] = 'Not found.';
			}
		}
		
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/update_adminSetting',$data);
		$this->load->view('admin/admin_footer');
					// echo"<pre>";
					// print_r($bokingidInfo);
					// exit();
			}
	


}