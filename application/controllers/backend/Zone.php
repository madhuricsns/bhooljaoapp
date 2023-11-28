<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zone extends CI_Controller {
	public function __construct(){
		parent::__construct();
	if(empty($this->session->userdata('logged_in'))){
			redirect(base_url().'backend/login','refresh');  
		}
		$this->load->library("pagination");	
		$this->load->helper('email');
		$this->load->library('session');
		$this->load->model('adminModel/Zone_model');
		$this->load->model('Common_Model');
		
	}
	
	public function manageZones()
	{
		$data['title']='Manage Zone';

		
		$data['zonecnt']=$this->Zone_model->getAllZone(0,"","");
		
		$config = array();
		$config["base_url"] = base_url().'backend/Zone/manageZones/';
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
		$config["total_rows"] =$data['zonecnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		//echo "ConttPerPage--".$config["per_page"];
		//echo "Conttpage--".$page;
		//exit();
		$data['zones']=$this->Zone_model->getAllZone(1,$config["per_page"],$page);
		//echo $this->db->last_query();exit;
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/manageZones',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function addZone()
	{
		$data['title']='Add Zone';
		$data['error_msg']='';
				
		if(isset($_POST['btn_addzone']))
		{
			$this->form_validation->set_rules('zone_name','Zone Name','required');
			$this->form_validation->set_rules('zone_pincode','Zone Pincode','required');
			$this->form_validation->set_rules('status','Zone Status','required');
			if($this->form_validation->run())
			{
				$address=$this->input->post('zone_name');
				$zone_pincode=$this->input->post('zone_pincode');
				$status=$this->input->post('status');
                		
				$zonename=$this->Zone_model->chkZoneName($address,0);

				$latlong=$this->get_lat_long($address);
						$parts=explode(",",$latlong);
						$zone_lat=$parts[0];
						$zone_long=$parts[1];

				if($zonename==0)
				{
					$input_data = array(
						'zone_name'=>trim($address),
						'zone_status'=>$status,
						'zone_pincode'=>$zone_pincode,
						'zone_lat'=>$zone_lat,
						'zone_long'=>$zone_long,
						'dateupdated' => date('Y-m-d H:i:s'),
						'dateadded' => date('Y-m-d H:i:s')
						);

					// echo"<pre>";
					// print_r($input_data);
					// exit();
					
					$zone_id = $this->Zone_model->insert_zone(TBLPREFIX.'zone',$input_data);
					
					if($zone_id)
					{	
						$this->session->set_flashdata('success','Zone added successfully.');

						redirect(base_url().'backend/Zone/manageZones');	
					}
					else
					{
						$this->session->set_flashdata('error','Error while adding user.');

						redirect(base_url().'backend/Zone/addZone');
					}	
				}
				else
				{
					$this->session->set_flashdata('success','Zone name  already exist.');

					redirect(base_url().'backend/Zone/addZone');	
				}

			}else{
				$this->session->set_flashdata('success','Validation failed. Please enter valid email or mobile number.');
				redirect(base_url().'backend/Zone/addZone');
			}
		}

		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/addZone',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function update_Zone()
	{
		$data['title']='Update Zone';
		$data['error_msg']='';
		// echo "segment--".$this->uri->segment(4);exit();
		$zone_id=base64_decode($this->uri->segment(4));
        // echo $zone_id;
        if($zone_id)
		{
			$zoneInfo=$this->Zone_model->getSingleZoneInfo($zone_id,0);
			if($zoneInfo>0)
			{
				$data['zoneInfo'] = $this->Zone_model->getSingleZoneInfo($zone_id,1);

				if(isset($_POST['btn_updatezone']))
				{
                    print_r($_POST);//exit;
					$this->form_validation->set_rules('zone_name','Zone Name','required');
					$this->form_validation->set_rules('zone_pincode','Zone Pincode','required');
			        $this->form_validation->set_rules('status','Zone Status','required');

					if($this->form_validation->run())
					{
						$address=$this->input->post('zone_name');
				$zone_pincode=$this->input->post('zone_pincode');
				$status=$this->input->post('status');
                		
				$zonename=$this->Zone_model->chkZoneName($address,0);

				$latlong=$this->get_lat_long($address);
						$parts=explode(",",$latlong);
						$zone_lat=$parts[0];
						$zone_long=$parts[1];
							
						$input_data = array(
                            'zone_name'=>trim($address),
							'zone_status'=>$status,
							'zone_pincode'=>$zone_pincode,
						'zone_lat'=>$zone_lat,
						'zone_long'=>$zone_long,
							'dateupdated' => date('Y-m-d H:i:s')
                            );
					
						$zonedata = $this->Zone_model->uptdate_zone($input_data,$zone_id);
                       
                        // echo $this->db->last_query();exit;
						if($zonedata)
						{	
							$this->session->set_flashdata('success','Zone updated successfully.');

							redirect(base_url().'backend/Zone/manageZones');	
						}
						else
						{
							$this->session->set_flashdata('error','Error while updating Zone.');

							redirect(base_url().'backend/Zone/updateZone/'.base64_encode($user_id));
						}	
					}
					else
					{
						$this->session->set_flashdata('error',$this->form_validation->error_string());

						redirect(base_url().'backend/Zone/updateZone/'.base64_encode($user_id));
					}
				}
			}
			else
			{
				$data['error_msg'] = 'Zone not found.';
			}
		}
		
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/updateZone',$data);
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
								'zone_status'=> $statusTobeUpdated
								);
			$usertaskdata = $this->Zone_model->uptdateStatus($input_data,$task_id);
			if($usertaskdata){
				$this->session->set_flashdata('success','Status updated successfully.');
				redirect(base_url().'backend/users/viewUsertask/'.$user_id);
				}
		}
	}
	public function deleteZone()
	{
		$data['error_msg']='';
		$zone_id = base64_decode($this->uri->segment(4));
		if($zone_id)
		{
			$zoneInfo=$this->Zone_model->getSingleZoneInfo($zone_id,0);
			if($zoneInfo>0)
			{
				$input_data = array(
					'zone_status'=>'Delete',
					'dateupdated' => date('Y-m-d H:i:s')
				);

				$deluser =$this->Common_Model->update_data('zone','zone_id',$zone_id,$input_data);
                       
				if($deluser > 0)
				{
					$this->session->set_flashdata('success','Zone deleted successfully.');
					redirect(base_url().'backend/Zone/manageZones');	
				}
				else
				{
					$this->session->set_flashdata('error','Error while deleting zone.');
					redirect(base_url().'backend/Zone/manageZones');
				}
			}
			else
			{
				$data['error_msg'] = 'Zone not found.';
			}
		}
		else
		{
			$this->session->set_flashdata('error','Zone not found.');
			redirect(base_url().'backend/Zone/manageZones');
		}
	}




/* start lat & long function*/
public function get_lat_long($address)
  {
  echo $address = str_replace(" ", "+", $address);

    // echo "http://maps.google.com/maps/api/geocode/json?address=$zone_name&sensor=false";
    // exit;
    $json1 = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=AIzaSyB0-m0BRbw8AtbMAawt7YPC4hFKmAO2hBI");
    $json = json_decode($json1);

    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $longl = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
    return $lat.','.$longl;
    //return "19.95099258,73.84654236";
    //echo json_encode(array('lat'=>$lat,'longl'=>$longl));
  }

/* End lat & long function*/

public function change_status()
	{
		$data['title']='Change Status';
		$data['error_msg']='';
		
		$zone_id=base64_decode($this->uri->segment(4));

		$statusTobeUpdated=base64_decode($this->uri->segment(5));
		//echo "user_id--".$user_id;exit();
		if($zone_id)
		{
			$input_data = array(
								'zone_status'=> $statusTobeUpdated
								);
			$userdata = $this->Zone_model->uptdateStatus($input_data,$zone_id);
			if($userdata){
				$this->session->set_flashdata('success','Status updated successfully.');
				redirect(base_url().'backend/Zone/manageZones/');
				}
		}
	}

}