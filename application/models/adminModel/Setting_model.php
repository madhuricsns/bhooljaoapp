<?php
Class Setting_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function getSingleSettingInfo($setting_id ,$res)
	{
		$this->db->select('*');
		$this->db->where('setting_id ',$setting_id );
		$query = $this->db->get(TBLPREFIX."admin_settings");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}
	

	public function getAllSetting($res,$per_page,$page)
	{
		$this->db->select('*');

		$this->db->order_by('setting_id','ASC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get(TBLPREFIX.'admin_settings');
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}
	
	
	
	public function updateAdminsetting($input_data,$setting_id)
	{
		$this->db->where('setting_id',$setting_id);
		$query=$this->db->update(TBLPREFIX."admin_settings",$input_data);
              //echo $this->db->last_query();exit;
		if($query==1)
		{
			return true;
		}
		else
		{
			return false;
		}	
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