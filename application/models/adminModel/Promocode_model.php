<?php
Class Promocode_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function getSinglepromocodeInfo($promocode_id,$res)
	{
		$this->db->select('*');
		$this->db->where('promocode_id',$promocode_id);
		$query = $this->db->get(TBLPREFIX."promo_code");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}
	public function chkPromocode_codeName($promocode_code,$res)
	{
		$this->db->select('*');
		$this->db->where('promocode_code',$promocode_code);
		$query=$this->db->get(TBLPREFIX."promo_code");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}

	public function getAllPromocode($res,$per_page,$page)
	{
		
		$this->db->select('*');
		//$this->db->join(TBLPREFIX.'service as s','s.service_id=p.service_id','left');
		$this->db->order_by('promocode_id','DESC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get(TBLPREFIX.'promo_code');
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}
	public function getAllservice($res,$per_page,$page)
	{
		/*echo "PerPage--".$per_page;
		echo "page--".$page;exit();*/
		$this->db->select('*');
		$this->db->where('service_status',"Active");

		$this->db->order_by('service_id','DESC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get(TBLPREFIX.'service');
		//echo $this->db->last_query();exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}
	
	public function uptdatePromocode($input_data,$promocode_id) 
	{
		
		
			$this->db->where('promocode_id',$promocode_id);
			$query = $this->db->update(TBLPREFIX.'promo_code',$input_data);
			if($query==1)
		{
			return true;
		}
		else
		{
			return false;
		}	
		
	}
	
	public function insert_Promocode($input_data) 
	{
		$res = $this->db->insert(TBLPREFIX.'promo_code',$input_data);
		if($res)
		{
			return $this->db->insert_id();
		}
		else
			return false;
	}
	
	public function deletePromocode($promocode_id)
	{
		// $this->db->where('banner_id',$banner_id);
		// $res = $this->db->delete(TBLPREFIX.'banner');
		$input_data = array(
			'promocode_status'=>"Delete",
			'dateupdated' => date('Y-m-d H:i:s')
			);
		$this->db->where('promocode_id',$promocode_id);
		$res = $this->db->update(TBLPREFIX.'promo_code',$input_data);
		if($res)
			return true;
		else
			return false;
	}
	public function uptdateStatus($input_data,$promocode_id) 
	{
		$this->db->where('promocode_id',$promocode_id);
		$res = $this->db->update(TBLPREFIX.'promo_code',$input_data);
		if($res)
		{
			return true;
		}
		else
			return false;
	}
}