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

		$this->db->order_by('userid','ASC');
		$result = $this->db->get('users');
		//echo $this->db->last_query();exit;
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
	
	
}