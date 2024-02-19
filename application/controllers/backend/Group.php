<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller {
	public function __construct(){
		parent::__construct();
	if(empty($this->session->userdata('logged_in'))){
			redirect(base_url().'backend/login','refresh');  
		}
		$this->load->library("pagination");	
		$this->load->helper('email');
		$this->load->library('session');
		$this->load->model('adminModel/Group_model');
		$this->load->model('Common_Model');
		
	}
	public function index()
	{
		redirect(base_url().'backend/Group/manageGroup','refresh');
	}
	public function manageGroup()
	{
		$data['title']='Manage Group';
		
		if($this->session->userdata("pagination_rows") != '')
		{
			$per_page = $this->session->userdata("pagination_rows");
		}
		else {
			$per_page='10';
		}
		
		$data['categorycnt']=$this->Group_model->getAllGroup(0,"","");
		
		$config = array();
		$config["base_url"] = base_url().'backend/Group/manageGroup/'.$per_page;
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
		$config["total_rows"] =$data['categorycnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		// $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		//echo "ConttPerPage--".$config["per_page"];
		//echo "Conttpage--".$page;
		//exit();
		$data['categories']=$this->Group_model->getAllGroup(1,$config["per_page"],$page);
		//echo $this->db->last_query();exit;
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/manageGroup',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function addGroup()
	{
		$data['title']='Add Group';
		$data['error_msg']='';
		$data['categoryLists']=$this->Group_model->getAllCategory(1);	
		 // echo $this->db->last_query();exit;	
		if(isset($_POST['btn_addgroup']))
		{
			$this->form_validation->set_rules('group_name','Group Name','required');
			$this->form_validation->set_rules('category_id', 'Category Id', 'required');
			$this->form_validation->set_rules('status','Group Status','required');
			// $this->form_validation->set_rules('sp_ids','Service Giver','required');
			if($this->form_validation->run())
			{
				$category_id=$this->input->post('category_id');
				$group_name=$this->input->post('group_name');
				$status=$this->input->post('status');
				$sp_ids=$this->input->post('sp_ids');
						
				$categoryName=$this->Group_model->chkGroupCategory($category_id,0);

				// if($categoryName==0)
				// {
					$input_data = array(
						'group_category_id'=>$category_id,
						'group_name'=>trim($group_name),
						'group_status'=>$status,
						'dateadded' => date('Y-m-d H:i:s')
						);

					$group_id = $this->Common_Model->insert_data('service_group',$input_data);
					
					if($group_id)
					{	
						if(!empty($sp_ids))
						{
							$this->db->where('group_parent_id',$group_id);
							$this->db->delete('bhool_service_group');
							foreach($sp_ids as $sp_id){
								if($sp_id!="")
								{
									$input_data = array(
										'group_parent_id'=>$group_id,
										'service_provider_id'=>$sp_id,
										'group_status'=>'Active',
										'dateadded' => date('Y-m-d H:i:s')
										);

									$insertgroup_id = $this->Common_Model->insert_data('service_group',$input_data);
								}
							}
						}
						$this->session->set_flashdata('success','Group added successfully.');
						redirect(base_url().'backend/Group/manageGroup');	
					}
					else
					{
						$this->session->set_flashdata('error','Error while adding user.');
						redirect(base_url().'backend/Group/addGroup/');
					}	
				// }
				// else
				// {
				// 	$this->session->set_flashdata('error','Your selected Category group already exist.');
				// 	redirect(base_url().'backend/Group/addGroup');	
				// }

			}else{
				$this->session->set_flashdata('error',$this->form_validation->error_string());
				redirect(base_url().'backend/Group/addGroup');
			}
		}

		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/addGroup',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function updateGroup()
	{
		$data['title']='Update Group';
		$data['error_msg']='';
		//echo "segment--".$this->uri->segment(4);exit();
		$group_id=base64_decode($this->uri->segment(4));

		$data['categoryLists']=$this->Group_model->getAllCategory(1);
		if($group_id)
		{
			$groupInfo=$this->Group_model->getSingleGroupInfo($group_id,0);
			if($groupInfo>0)
			{
				$data['groupInfo'] = $this->Group_model->getSingleGroupInfo($group_id,1);
				if(isset($_POST['btn_uptgroup']))
				{
					$this->form_validation->set_rules('group_name','Group Name','required');
					$this->form_validation->set_rules('category_id', 'Category Id', 'required');
					$this->form_validation->set_rules('status','Group Status','required');

					if($this->form_validation->run())
					{
						$category_id=$this->input->post('category_id');
						$group_name=$this->input->post('group_name');
						$status=$this->input->post('status');
						$sp_ids=$this->input->post('sp_ids');

						$categoryName=$this->Group_model->chkupdateGroupCategory($category_id,$group_id,0);
						if($categoryName==0)
						{
							$input_data = array(
								'group_category_id'=>$category_id,
								'group_name'=>trim($group_name),
								'group_status'=>$status
							);
							
							$updatedata = $this->Group_model->uptdateGroup($input_data,$group_id);
							// echo $this->db->last_query();exit;
							if($updatedata)
							{	
								if(!empty($sp_ids))
								{
									$this->db->where('group_parent_id',$group_id);
									$this->db->delete('bhool_service_group');
									foreach($sp_ids as $sp_id){
										if($sp_id!="")
										{
											$input_data = array(
												'group_parent_id'=>$group_id,
												'service_provider_id'=>$sp_id,
												'group_status'=>'Active',
												'dateadded' => date('Y-m-d H:i:s')
												);

											$insertgroup_id = $this->Common_Model->insert_data('service_group',$input_data);
										}
									}
								}

								$this->session->set_flashdata('success','Group updated successfully.');
								redirect(base_url().'backend/Group/manageGroup');	
							}
							else
							{
								$this->session->set_flashdata('error','Error while updating User.');
								redirect(base_url().'backend/Group/updateGroup/'.base64_encode($group_id));
							}	
						}
						else
						{
							$this->session->set_flashdata('error','Your selected Category group already exist.');
							redirect(base_url().'backend/Group/updateGroup/'.base64_encode($group_id));
						}
					}
					else
					{
						$this->session->set_flashdata('error',$this->form_validation->error_string());
						redirect(base_url().'backend/Group/updateGroup/'.base64_encode($group_id));
					}
				}
			}
			else
			{
				$data['error_msg'] = 'Group not found.';
			}
		}
		
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/updateGroup',$data);
		$this->load->view('admin/admin_footer');
	}

	public function ViewGroup()
	{
		$data['title']='View Group';
		$data['error_msg']='';
		//echo "segment--".$this->uri->segment(4);exit();
		$group_id=base64_decode($this->uri->segment(4));
		//echo "Brand_id--".$brand_id;exit();
		if($group_id>0)
		{
			$data['groupInfo']=$this->Group_model->getSingleGroupInfo($group_id,1);
			if(isset($_POST['btn_addsp']))
			{
				print_r($_POST);
				$this->form_validation->set_rules('group_id','Group Name','required');
				if($this->form_validation->run())
				{
					$sp_ids=$this->input->post('sp_ids');
					$id=$this->input->post('group_id');
					// print_r($sp_ids);
					// exit;
					if(!empty($sp_ids))
					{
						$this->db->where('group_parent_id',$id);
						$this->db->delete('bhool_service_group');
						foreach($sp_ids as $sp_id){
							$input_data = array(
								'group_parent_id'=>$id,
								'service_provider_id'=>$sp_id,
								'group_status'=>'Active',
								'dateadded' => date('Y-m-d H:i:s')
								);

							$insertgroup_id = $this->Common_Model->insert_data('service_group',$input_data);
						}
						if($insertgroup_id)
						{	
							$this->session->set_flashdata('success','Service provider updated successfully.');
							redirect(base_url().'backend/Group/viewGroup/'.base64_encode($id));	
						}
						else
						{
							$this->session->set_flashdata('error','Error while adding service provider.');
							redirect(base_url().'backend/Group/viewGroup/'.base64_encode($id));	
						}	
					}
					else
					{
						$this->session->set_flashdata('error','Your selected Category group already exist.');
						redirect(base_url().'backend/Group/viewGroup/'.base64_encode($id));	
					}

				}else{
					$this->session->set_flashdata('error','Validation failed.');
					redirect(base_url().'backend/Group/viewGroup/'.base64_encode($id));	
				}
			}
		}
		else
		{
			$data['error_msg'] = 'Group not found.';
		}
		
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/viewGroup',$data);
		$this->load->view('admin/admin_footer');
	}

	public function change_status()
	{
		$data['title']='Change Status';
		$data['error_msg']='';
		
		$group_id=base64_decode($this->uri->segment(4));

		$statusTobeUpdated=base64_decode($this->uri->segment(5));
		//echo "user_id--".$user_id;exit();
		if($group_id)
		{
			$input_data = array(
								'group_status'=> $statusTobeUpdated
								);
			$userdata = $this->Group_model->uptdateStatus($input_data,$group_id);
			if($userdata){
				$this->session->set_flashdata('success','Status updated successfully.');
				redirect(base_url().'backend/Group/manageGroup/');
				}
		}
	}


	public function addSPGroup()
	{
		$data['title']='Add Group';
		$data['error_msg']='';
		$data['categoryLists']=$this->Group_model->getAllCategory(1);	
		 // echo $this->db->last_query();exit;	
		if(isset($_POST['btn_addgroup']))
		{
			$this->form_validation->set_rules('group_name','Group Name','required');
			$this->form_validation->set_rules('category_id', 'Category Id', 'required');
			$this->form_validation->set_rules('status','Group Status','required');
			if($this->form_validation->run())
			{
				$category_id=$this->input->post('category_id');
				$group_name=$this->input->post('group_name');
				$status=$this->input->post('status');
						
				$categoryName=$this->Group_model->chkGroupCategory($category_id,0);

				if($categoryName==0)
				{
					$input_data = array(
						'group_category_id'=>$category_id,
						'group_name'=>trim($group_name),
						'group_status'=>$status,
						'dateadded' => date('Y-m-d H:i:s')
						);

					$group_id = $this->Common_Model->insert_data('service_group',$input_data);
					
					if($group_id)
					{	
						$this->session->set_flashdata('success','Group added successfully.');
						redirect(base_url().'backend/Group/manageGroup');	
					}
					else
					{
						$this->session->set_flashdata('error','Error while adding user.');
						redirect(base_url().'backend/Group/addGroup/');
					}	
				}
				else
				{
					$this->session->set_flashdata('error','Your selected Category group already exist.');
					redirect(base_url().'backend/Group/addGroup');	
				}

			}else{
				$this->session->set_flashdata('error','Validation failed.');
				redirect(base_url().'backend/Group/addGroup');
			}
		}

		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/addGroup',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function deleteGroup()
	{
		$data['error_msg']='';
		$group_id = base64_decode($this->uri->segment(4));
		if($group_id)
		{
			$groupInfo = $data['groupInfo'] = $this->Group_model->getSingleGroupInfo($group_id,1);
			if(count($groupInfo) > 0)
			{   
				$input_data = array(
					'group_status'=>'Delete'
				);

				$deluser = $this->Group_model->uptdateGroup($input_data,$group_id);
				if($deluser > 0)
				{
					$this->session->set_flashdata('success','Group deleted successfully.');
					redirect(base_url().'backend/Group/manageGroup');	
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleting user.');
					redirect(base_url().'backend/Group/manageGroup');
				}
			}
			else
			{
				$data['error_msg'] = 'Group not found.';
			}
		}
		else
		{
			$this->session->set_flashdata('error','Group not found.');
			redirect(base_url().'backend/Users/index');
		}
	}
	
	public function getServiceprovider()
    {
        if($this->input->post('category_id')) 
        {
			// print_r($this->input->post('category_id'));exit;
            $countsp=$this->Group_model->getAllServiceproviders($this->input->post('category_id'),0);
			if($countsp>0){
				$serviceproviders=$this->Group_model->getAllServiceproviders($this->input->post('category_id'),1);
				$output = '<option value="">Select Service Givers</option>';
				// echo json_encode($serviceproviders);
				foreach($serviceproviders as $row)
				{
					$output .= '<option value="'.$row['user_id'].'">'.$row['full_name'].'</option>';
				}
				 echo $output; 
			}
			else{
				echo "<option>No Service Giver Available.</option>";
			}

        }else{
			echo "<option>No Service Giver Available.</option>";
        }

		// return $output;

    }


}