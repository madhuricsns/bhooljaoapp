<?php
Class HelpCenter_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function getSingleHelpCenterInfo($help_id,$res)
	{
		$this->db->select('*');
		$this->db->where('help_id',$help_id);
		$query = $this->db->get(TBLPREFIX."helpcenter");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}
	public function chkHelpName($helpcenter_name,$res)
	{
		$this->db->select('*');
		$this->db->where('help_name',$helpcenter_name);
		$query=$this->db->get(TBLPREFIX."helpcenter");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}

	public function chkUpdateHelpName($helpcenter_name,$help_id,$res)
	{
		$this->db->select('*');
		$this->db->where('help_id!=',$help_id);
		$this->db->where('help_name',$helpcenter_name);
		$query=$this->db->get(TBLPREFIX."helpcenter");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}

	public function getAllHelpCenter($res,$per_page,$page)
	{
		$this->db->select('*');
		$this->db->where('status','Active');

		$this->db->order_by('help_id','ASC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get(TBLPREFIX.'helpcenter');
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}
	
	public function uptdateHelpCenter($input_data,$help_id) 
	{
		
			$this->db->where('help_id',$help_id);
			$res = $this->db->update(TBLPREFIX.'helpcenter',$input_data);
			if($res)
			{
				return true;
			}
			else
				return false;
		
	}
	
	public function insert_HelpCenter($input_data) 
	{
		$res = $this->db->insert(TBLPREFIX.'helpcenter',$input_data);
		if($res)
		{
			return $this->db->insert_id();
		}
		else
			return false;
	}
	
	public function deleteHelpCenter($help_id)
	{
		// $this->db->where('banner_id',$banner_id);
		// $res = $this->db->delete(TBLPREFIX.'banner');
		$input_data = array(
			'status'=>"Delete",
			'dateupdated' => date('Y-m-d H:i:s')
			);
		$this->db->where('help_id',$help_id);
		$res = $this->db->update(TBLPREFIX.'helpcenter',$input_data);
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