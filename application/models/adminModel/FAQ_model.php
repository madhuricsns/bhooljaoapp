<?php
Class FAQ_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function getSingleFAQInfo($faq_id,$res)
	{
		$this->db->select('*');
		$this->db->where('faq_id',$faq_id);
		$query = $this->db->get(TBLPREFIX."faq");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}
	public function chkFaqName($faq_question,$res)
	{
		$this->db->select('*');
		$this->db->where('faq_question',$faq_question);
		$query=$this->db->get(TBLPREFIX."faq");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}

	public function chkUpdateFaqName($faq_question,$faq_id,$res)
	{
		$this->db->select('*');
		$this->db->where('faq_id!=',$faq_id);
		$this->db->where('faq_question',$faq_question);
		$query=$this->db->get(TBLPREFIX."faq");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}

	public function getAllFAQ($res,$per_page,$page)
	{
		$this->db->select('*');

		$this->db->order_by('faq_id','ASC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get(TBLPREFIX.'faq');
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}
	
	public function uptdateFAQ($input_data,$faq_id) 
	{
			$this->db->where('faq_id',$faq_id);
			$res = $this->db->update(TBLPREFIX.'faq',$input_data);
			if($res)
			{
				return true;
			}
			else
				return false;
		
	}
	
	public function insert_FAQ($input_data) 
	{
		$res = $this->db->insert(TBLPREFIX.'faq',$input_data);
		if($res)
		{
			return $this->db->insert_id();
		}
		else
			return false;
	}
	
	public function deleteFAQ($faq_id)
	{
		// $this->db->where('banner_id',$banner_id);
		// $res = $this->db->delete(TBLPREFIX.'banner');
		$input_data = array(
			'faq_status'=>"Delete",
			'dateupdated' => date('Y-m-d H:i:s')
			);
		$this->db->where('faq_id',$faq_id);
		$res = $this->db->update(TBLPREFIX.'faq',$input_data);
		if($res)
			return true;
		else
			return false;
	}

	public function uptdateStatus($input_data,$faq_id) 
	{
		$this->db->where('faq_id',$faq_id);
		$res = $this->db->update(TBLPREFIX.'faq',$input_data);
		if($res)
		{
			return true;
		}
		else
			return false;
	}
}