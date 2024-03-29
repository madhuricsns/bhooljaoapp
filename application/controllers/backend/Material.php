<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Material extends CI_Controller {
	public function __construct(){
		parent::__construct();
	if(empty($this->session->userdata('logged_in'))){
			redirect(base_url().'backend/login','refresh');  
		}
		$this->load->library("pagination");	
		$this->load->helper('email');
		$this->load->library('session');
		$this->load->model('adminModel/Material_model');
		$this->load->model('Common_Model');
		
	}
	public function index()
	{
        redirect('backend/Material/manageMaterial','refresh');
    }

	public function manageMaterial()
	{
		$data['title']='Manage Material';
	
	
		if($this->session->userdata("pagination_rows") != '')
		{
			$per_page = $this->session->userdata("pagination_rows");
		}
		else {
			$per_page='10';
		}
		$data['materialcnt']=$this->Material_model->getAllMaterial(0,"","");
		
		
		$config = array();
		$config["base_url"] = base_url().'backend/Material/manageMaterial/'.$per_page;
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
		$config["total_rows"] =$data['materialcnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		//echo "ConttPerPage--".$config["per_page"];
		//echo "Conttpage--".$page;
		//exit();
		$data['materialList']=$this->Material_model->getAllMaterial(1,$config["per_page"],$page);
		
		//echo $this->db->last_query();exit;
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/manageMaterial',$data);
		$this->load->view('admin/admin_footer');
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
                		
				$materialname=$this->Material_model->chkMaterialName($material_name,0);

				if($materialname==0)
				{
					$input_data = array(
						'material_name'=>trim($material_name),
						'material_status'=>$status,
						'dateupdated' => date('Y-m-d H:i:s'),
						'dateadded' => date('Y-m-d H:i:s')
						);

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
	
	public function updateMaterial()
	{
		$data['title']='Update Material';
		$data['error_msg']='';
		// echo "segment--".$this->uri->segment(4);exit();
		$material_id=base64_decode($this->uri->segment(4));
        // echo $zone_id;
        if($material_id)
		{
			$materialInfo=$this->Material_model->getSingleMaterialInfo($material_id,0);
			if($materialInfo>0)
			{
				$data['materialInfo'] = $this->Material_model->getSingleMaterialInfo($material_id,1);

				if(isset($_POST['btn_updatematerial']))
				{
                    // print_r($_POST);//exit;
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

		$request_id=base64_decode($this->uri->segment(4));
		$statusTobeUpdated=base64_decode($this->uri->segment(5));
		$material_id=base64_decode($this->uri->segment(6));
		//echo "user_id--".$user_id;exit();
		
		if($request_id)
		{
			$input_data = array(
								'request_status'=> $statusTobeUpdated
								);
			$usertaskdata = $this->Common_Model->update_data('material_request','request_id',$request_id,$input_data);
			if($usertaskdata)
			{
				/************************************************************** */
				$materialRequest=$this->Material_model->getMaterialRequest($request_id);
				$sp=$this->Material_model->getServiceProvider($materialRequest->service_provider_id);
					// Send Notification 
					$title="Material Request ".$statusTobeUpdated;
					$message="Your $materialRequest->material_name Material Request has been $statusTobeUpdated";
					$output=$this->Common_Model->sendexponotification($title,$message,$sp->user_fcm);

					$inputData=array(
						'noti_user_type'=>'Service Provider',
						'noti_type'=>'Admin',
						'noti_title'=>$title,
						'noti_message'=>$message,
						'noti_gcmID'=>$sp->user_fcm,
						'noti_user_id'=>$sp->user_id,
						'created_by'=>'1',
						'dateadded'=>date('Y-m-d H:i:s')
					);
					$this->Common_Model->insert_data('notification',$inputData);
				/************************************************************** */

				$this->session->set_flashdata('success',$statusTobeUpdated.' successfully.');
				redirect(base_url().'backend/Material/materialRequest/'.base64_encode($material_id));
			}
		}
	}
	public function deleteMaterial()
	{
		$data['error_msg']='';
		$material_id = base64_decode($this->uri->segment(4));
		if($material_id)
		{
			$materialInfo=$this->Material_model->getSingleMaterialInfo($material_id,0);
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

	public function change_status()
	{
		$data['title']='Change Status';
		$data['error_msg']='';
		
		$material_id=base64_decode($this->uri->segment(4));

		$statusTobeUpdated=base64_decode($this->uri->segment(5));
		//echo "user_id--".$user_id;exit();
		if($material_id)
		{
			$input_data = array(
								'material_status'=> $statusTobeUpdated
								);
			$userdata = $this->Material_model->uptdateStatus($input_data,$material_id);
			if($userdata){
				$this->session->set_flashdata('success','Status updated successfully.');
				redirect(base_url().'backend/Material/manageMaterial/');
				}
		}
	}

	public function materialRequest()
	{
		$data['title']='Material Requests';
		$data['error_msg']='';
		
		$material_id=base64_decode($this->uri->segment(4));
		//echo "user_id--".$user_id;exit();
		if($material_id)
		{
			$data['material_id']=$material_id;
			$data['requestList'] = $this->Material_model->getAllMaterialRequest($material_id);
			$this->load->view('admin/admin_header',$data);
			$this->load->view('admin/materialRequest',$data);
			$this->load->view('admin/admin_footer');
		}
	}
}