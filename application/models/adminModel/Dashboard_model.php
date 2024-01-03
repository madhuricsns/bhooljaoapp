<?php

Class Dashboard_model extends CI_Model {

	function __construct()

	{

		// Call the Model constructor

		parent::__construct();

	}

	
public function getAllUsercount($res)
	{
		$this->db->select('*');
		$this->db->where('user_type',"Customer"); 
		$this->db->order_by('user_id','ASC');
		$result = $this->db->get(TBLPREFIX.'users');
		//echo $result;exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}

	public function getAllServiceProvidercount($res)
	{
		$this->db->select('*');
		$this->db->where('user_type',"Service Provider"); 
		$this->db->order_by('user_id','ASC');
		$result = $this->db->get(TBLPREFIX.'users');
		//echo $result;exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}



public function getAllBookingcount($res)
	{
		$this->db->select('*');
		// $this->db->where('user_type',"Service Provider"); 
		$this->db->order_by('booking_id','ASC');
		$result = $this->db->get(TBLPREFIX.'booking');
		//echo $result;exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}
	
	public function getAllDemoBookingcount($res)
	{
		$this->db->select('*');
		$this->db->where('is_demo','Yes'); 
		$this->db->order_by('booking_id','ASC');
		$result = $this->db->get(TBLPREFIX.'booking');
		//echo $result;exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}

public function getAllBookingWaitingcount($res)
	{
		$this->db->select('*');
	    $this->db->where('booking_status',"waiting"); 
		$this->db->order_by('booking_id','ASC');
		$result = $this->db->get(TBLPREFIX.'booking');
		//echo $result;exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}

public function getAllBookingAcceptedcount($res)
	{
		$this->db->select('*');
	    $this->db->where('booking_status',"accepted"); 
		$this->db->order_by('booking_id','ASC');
		$result = $this->db->get(TBLPREFIX.'booking');
		//echo $result;exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}

public function getAllBookingOngoingcount($res)
	{
		$this->db->select('*');
	    $this->db->where('booking_status',"ongoing"); 
		$this->db->order_by('booking_id','ASC');
		$result = $this->db->get(TBLPREFIX.'booking');
		//echo $result;exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}

public function getAllBookingCompletedcount($res)
	{
		$this->db->select('*');
	    $this->db->where('booking_status',"completed"); 
		$this->db->order_by('booking_id','ASC');
		$result = $this->db->get(TBLPREFIX.'booking');
		//echo $result;exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}








public function getAllFeedbackcount($res,$per_page,$page)
	{
		$this->db->select('feedback.*,users.full_name');
		$this->db->join('users','users.userid=feedback.userid','inner');

		$this->db->order_by('feedback_id','DESC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get('feedback');
		//echo $this->db->last_query();exit;

		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}

public function getLatRecords($res,$per_page,$page)
	{

	$this->db->select('Lat,Lon,Time_GPS,Alt');  
	$this->db->where('Lat >',20);
   	$this->db->order_by('Time_GPS','desc');
   	if($per_page!="")
	{
		$this->db->limit($per_page,$page);
	}   
   	$result=$this->db->get('PrimaryLive');
   	//echo $this->db->last_query();exit;
   	if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();
   }
   
   public function getAllBookingIncome($filter)
	{
		$this->db->select('sum(total_booking_amount) as total');
		
		if($filter == 'Last Month')
		{
			$this->db->where('MONTH(dateadded) = MONTH(NOW()) - 1');
		}	
		else if($filter == 'Last 6 Months')
		{	
			$this->db->where('dateadded >= DATE(NOW()) - INTERVAL 6 MONTH');
		}
		else if($filter == 'Last Year')
		{
			$this->db->where('YEAR(dateadded) = YEAR(NOW() - INTERVAL 1 YEAR)');
		}
		else {
			$this->db->where('DATE(dateadded) = CURDATE()');
		}
		//$this->db->where('is_demo','Yes'); 
		//$this->db->order_by('booking_id','ASC');
		$result = $this->db->get(TBLPREFIX.'booking');
		//echo $this->db->last_query();
		$res = $result->row();
		if($res->total == NULL)
			return 0;
		else 
			return $res->total;
		
	}
	
	public function getAllBookingPaid($filter)
	{
		$this->db->select('sum(paid_amount) as total');
		$this->db->where('payment_response','success'); 
		//$this->db->order_by('booking_id','ASC');
		if($filter == 'Last Month')
		{
			$this->db->where('MONTH(dateadded) = MONTH(NOW()) - 1');
		}	
		else if($filter == 'Last 6 Months')
		{
			$this->db->where('dateadded >= DATE(NOW()) - INTERVAL 6 MONTH');
		}
		else if($filter == 'Last Year')
		{
			$this->db->where('YEAR(dateadded) = YEAR(NOW() - INTERVAL 1 YEAR)');
		}
		else {
			$this->db->where('DATE(dateadded) = CURDATE()');
		}
		
		$result = $this->db->get(TBLPREFIX.'booking_transaction');
		//echo $result;exit;
		$res = $result->row();
		if($res->total == NULL)
			return 0;
		else 
			return $res->total;
		
	}
	
	
}