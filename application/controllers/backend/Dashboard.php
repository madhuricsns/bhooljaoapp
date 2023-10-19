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
		// $data['usercnt']=$this->Dashboard_model->getAllUsercount(0);
		// //$data['feedbackcnt']=$this->Dashboard_model->getAllFeedbackcount(0,"","");
		// $data['feedbacks']=$this->Feedback_model->getAllFeedbacks(1,10,0);
		// $data['feedbackcnt']=$this->Feedback_model->getAllFeedbacks(0,'',0);
		// $data['latrecords']=$this->Dashboard_model->getLatRecords(1,25,0);
		// $data['flights']=$this->Flights_model->getFlightsDashboard(10);
		
		// $data['ScheduledFlights'] = $this->Flights_model->getscheduledFlights();
		// $data['PastFlights'] = $this->Flights_model->getPastFlights();
		// //echo "count--".$getlatcnt;exit();
		// /*echo "<pre>";
		// print_r($data['latrecords']);
		// exit();*/

		$this->load->view('admin/admin_header',$data);
		$this->load->view('admin/dashboard',$data);
		$this->load->view('admin/admin_footer');
	}
}




