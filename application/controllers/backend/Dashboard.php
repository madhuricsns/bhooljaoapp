<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->load->model('adminModel/Dashboard_model');
		if(empty($this->session->userdata('logged_in'))){
			redirect(base_url().'backend/login','refresh');  
		}
		$this->load->model('adminModel/Dashboard_model');
		
	}


	public function index()
	{
		$data['title']='Dashboard';
		$todays=date('Y-m-d');
		 $data['User']=$this->Dashboard_model->getAllUsercount(0);
		 $data['ServiceProvider']=$this->Dashboard_model->getAllServiceProvidercount(0);
		 $data['Booking']=$this->Dashboard_model->getAllBookingcount(0);
		  $data['BookingWaiting']=$this->Dashboard_model->getAllBookingWaitingcount(0);
		  $data['BookingAccepted']=$this->Dashboard_model->getAllBookingAcceptedcount(0);
		   $data['BookingOngoing']=$this->Dashboard_model->getAllBookingOngoingcount(0);
		    $data['BookingCompleted']=$this->Dashboard_model->getAllBookingCompletedcount(0);
		//exit();
		// //$data['feedbackcnt']=$this->Dashboard_model->getAllFeedbackcount(0,"","");
		// $data['feedbacks']=$this->Feedback_model->getAllFeedbacks(1,10,0);
		// $data['feedbackcnt']=$this->Feedback_model->getAllFeedbacks(0,'',0);
		// $data['latrecords']=$this->Dashboard_model->getLatRecords(1,25,0);
		// $data['flights']=$this->Flights_model->getFlightsDashboard(10);
		
		// $data['ScheduledFlights'] = $this->Flights_model->getscheduledFlights();
		// $data['PastFlights'] = $this->Flights_model->getPastFlights();
		// //echo "count--".$getlatcnt;exit();
		// echo "<pre>";
		// print_r($data['User']);
		// exit();

		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/dashboard',$data);
		$this->load->view('admin/admin_footer');
	}
}




