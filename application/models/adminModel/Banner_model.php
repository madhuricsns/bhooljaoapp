<?php
Class Banner_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function getSingleBannerInfo($banner_id,$res)
	{
		$this->db->select('*');
		$this->db->where('banner_id',$banner_id);
		$query = $this->db->get(TBLPREFIX."banner");
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

	public function getAllBanners($res,$per_page,$page)
	{
		$this->db->select('*');

		$this->db->order_by('banner_id','ASC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get(TBLPREFIX.'banner');
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}
	
	public function uptdateBanner($input_data,$banner_id) 
	{
		$banner_title = $input_data['banner_title'];
		$query=$this->db->query("select * from bhool_banner where upper(banner_title)=upper('$banner_title') and banner_id<>$banner_id");
		if($query->num_rows()>0){
			return false;
		}
		else {
			$this->db->where('banner_id',$banner_id);
			$res = $this->db->update(TBLPREFIX.'banner',$input_data);
			if($res)
			{
				return true;
			}
			else
				return false;
		}
	}
	
	public function insert_banner($input_data) 
	{
		$res = $this->db->insert(TBLPREFIX.'banner',$input_data);
		if($res)
		{
			return $this->db->insert_id();
		}
		else
			return false;
	}
	
	public function deleteBanner($banner_id)
	{
		// $this->db->where('banner_id',$banner_id);
		// $res = $this->db->delete(TBLPREFIX.'banner');
		$input_data = array(
			'banner_status'=>"Delete",
			'dateupdated' => date('Y-m-d H:i:s')
			);
		$this->db->where('banner_id',$banner_id);
		$res = $this->db->update(TBLPREFIX.'banner',$input_data);
		if($res)
			return true;
		else
			return false;
	}

	public function uptdateStatus($input_data,$banner_id) 
	{
		$this->db->where('banner_id',$banner_id);
		$res = $this->db->update(TBLPREFIX.'banner',$input_data);
		if($res)
		{
			return true;
		}
		else
			return false;
	}
}