<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {
	public function __construct(){
		parent::__construct();
	if(empty($this->session->userdata('logged_in'))){
			redirect(base_url().'backend/login','refresh');  
		}
		$this->load->library("pagination");	
		$this->load->helper('email');
		$this->load->library('session');
		$this->load->model('adminModel/Booking_model');
		$this->load->model('Common_Model');
		
	}
	public function index()
	{
        redirect('backend/Booking/manageBooking','refresh');
    }

	public function manageBooking()
	{
		$data['title']='Manage Booking';

		
		$data['bookingcnt']=$this->Booking_model->getAllBooking(0,"","");
		
		$config = array();
		$config["base_url"] = base_url().'backend/Booking/manageBooking/';
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
		$config["total_rows"] =$data['bookingcnt'];
		#echo "<pre>"; print_r($config); exit;
		$this->pagination->initialize($config);
				
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data["total_rows"] = $config["total_rows"]; 
		$data["links"] = $this->pagination->create_links();
		//echo "ConttPerPage--".$config["per_page"];
		//echo "Conttpage--".$page;
		//exit();
		$data['bookingList']=$this->Booking_model->getAllBooking(1,$config["per_page"],$page);
		//echo $this->db->last_query();exit;
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/manageBooking',$data);
		$this->load->view('admin/admin_footer');
	}

    public function viewBookingDetails()
	{
		$data['title']='Booking Details';
	
		$booking_id=base64_decode($this->uri->segment(4));
        
		$data['orderInfo']=$this->Booking_model->getSingleBookingInfo($booking_id,1);
		//echo $this->db->last_query();exit;
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/viewBookingDetails',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function exportBookingCSV()
	{
		$this->load->helper('download');
        $data['error']=$data['success']="";
		$todaysdate=date('d-M-YHi');
		
		// $data['session_from_date'] = $this->session->userdata('session_from_date');		
		// $data['session_to_date'] = $this->session->userdata('session_to_date');		
		// $input_data = array(
		// 	'from_date'=> $data['session_from_date'] ?? ''	,
		// 	'to_date'=>$data['session_to_date'] ?? '');
		
		$array[] = array('','','','','Bhooljao - Export CSV For Bookings','','','','','');
		
		$i=1;

		$data['bookingList']=$bookingList=$this->Booking_model->getAllBooking(1,"","");

		$people = array('Sr.','Order No','Date','Time','Service Name','Customer','Hrs','Status');
		$array[] =$people;

	   	if(isset($bookingList) && count($bookingList)>0)
		{  	
			foreach($bookingList as $g)
			{
				$booking_id =$g['booking_id'];
				$order_no=$g['order_no'];
				$category_name=$g['category_name'];
				$full_name=ucfirst($g['full_name']);
				$booking_date=$g['booking_date'];
				$time_slot=$g['time_slot'];
				$no_of_hourse=$g['no_of_hourse'];
				$status=$g['booking_status'];
				
				//echo "<pre>";print_r($straddress); exit;
				if(is_array($people) &&count($people)> 0){
					foreach ($people as $key => $peopledtls) {
						$strVal = $peopledtls;
						switch ($peopledtls) {
							case 'Sr.':
								$strDtlVal = $i;
								break;
							case 'Order No':
								$strDtlVal = $order_no;
								break;
							case 'Date':
								$strDtlVal = date('d-m-Y',strtotime($booking_date));
								break;
							case 'Time':
								$strDtlVal = $time_slot;
								break;
							case 'Service Name':
								$strDtlVal = $category_name;
								break;
							case 'Customer':
								$strDtlVal = $full_name;
								break;
							case 'Hrs':
								$strDtlVal = $no_of_hourse;
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
		  $csvname = 'BookingExport'.$todaysdate.'.csv';
		  array_to_csv($array,$csvname);
		  $data['success']= "download sample export data successfully!";
	}
}