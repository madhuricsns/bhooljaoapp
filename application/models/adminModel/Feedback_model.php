<?php
Class Feedback_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function getSingleFeedbackInfo($feedback_id,$res)
	{
		$this->db->select('*');
		$this->db->where('feedback_id',$feedback_id);
		$query = $this->db->get(TBLPREFIX."feedback");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}
	public function chkBannerName($banner_title,$res)
	{
		$this->db->select('*');
		$this->db->where('banner_title',$banner_title);
		$query=$this->db->get(TBLPREFIX."banner");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}

	public function getAllFeedback($res,$per_page,$page)
	{
		$this->db->select('f.*,u.full_name,b.order_no,sp.full_name as sp_fullname,');
        $this->db->join(TBLPREFIX.'booking as b','b.booking_id=f.booking_id','left');
        $this->db->join(TBLPREFIX.'users as u','u.user_id=f.user_id','left');
         $this->db->join(TBLPREFIX.'users as sp','sp.user_id=f.service_provider_id','left');
       // $this->db->where('sp.user_type',"Service Provider");
		$this->db->order_by('feedback_id','DESC');

		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get(TBLPREFIX.'feedback as f');
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
		$result = $this->db->get(TBLPREFIX.'users as sp');
		//echo $result;exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}

	public function uptdateFeedback($input_data,$feedback_id) 
	{
			$this->db->where('feedback_id',$feedback_id);
			$res = $this->db->update(TBLPREFIX.'feedback',$input_data);
			if($res)
			{
				return true;
			}
			else
				return false;
	}
	

}