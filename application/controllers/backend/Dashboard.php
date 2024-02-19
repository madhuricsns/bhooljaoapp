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
		 $data['DemoBooking']=$this->Dashboard_model->getAllDemoBookingcount(0);
		  $data['BookingWaiting']=$this->Dashboard_model->getAllBookingWaitingcount(0);
		  $data['BookingAccepted']=$this->Dashboard_model->getAllBookingAcceptedcount(0);
		   $data['BookingOngoing']=$this->Dashboard_model->getAllBookingOngoingcount(0);
		    $data['BookingCompleted']=$this->Dashboard_model->getAllBookingCompletedcount(0);
		$filter = 'Today';
		$data['AllIncome']=$this->Dashboard_model->getAllBookingIncome($filter);
		$data['Paid']=$this->Dashboard_model->getAllBookingPaid($filter);
		$data['UnPaid']=$data['AllIncome'] - $data['Paid'];
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

	public function income()
	{
		$data['title']='Dashboard';
		$todays=date('Y-m-d');
		if(isset($_GET['filter']))
		{
			$filter = $_GET['filter'];
		}
		else
		{
			$filter = 'Today';
		}

		if($_GET['report_type']=='AllIncome')
		{
			$data['income_data']=$booking=$this->Dashboard_model->getAllBookingIncomeHistory($filter);
			$data['total']=$this->Dashboard_model->getAllBookingIncome($filter);
		}
		else if($_GET['report_type']=='Paid')
		{
			$data['income_data']=$booking=$this->Dashboard_model->getAllBookingPaidHistory($filter);
			$data['total']=$this->Dashboard_model->getAllBookingPaid($filter);
		}
		else if($_GET['report_type']=='UnPaid')
		{
			$data['income_data']=$booking=$this->Dashboard_model->getAllBookingPaidHistory($filter);
		}
		
		// echo "<pre>";
		// print_r($booking);
		// echo "</pre>";
		// echo $this->db->last_query();exit;
		// $data['Paid']=$this->Dashboard_model->getAllBookingPaid($filter);
		// $data['UnPaid']=$data['AllIncome'] - $data['Paid'];
		
		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/incomeList',$data);
		$this->load->view('admin/admin_footer');
	}
	
	public function getIncomeFilters()
	{
		$filter = $_POST['filter'];
		
		$data['AllIncome']=$this->Dashboard_model->getAllBookingIncome($filter);
		$data['Paid']=$this->Dashboard_model->getAllBookingPaid($filter);
		$data['UnPaid']=$data['AllIncome'] - $data['Paid'];
		
		$dataToReturn = $data['AllIncome'].'_'.$data['Paid'].'_'.$data['UnPaid'];
		
		echo $dataToReturn;
	}	
}




