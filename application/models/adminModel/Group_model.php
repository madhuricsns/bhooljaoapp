
<?php
Class Group_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function getSingleGroupInfo($group_id,$res)
	{
		$this->db->select('g.*,c.category_name');
		$this->db->where('group_parent_id','0');
		$this->db->where('group_id',$group_id);
		$this->db->join(TBLPREFIX.'category as c','c.category_id=g.group_category_id','left');
		$query = $this->db->get(TBLPREFIX."service_group as g");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}

	public function getGroupSP($group_id,$res)
	{
		$this->db->select('g.*,u.full_name,u.profile_id');
		$this->db->where('group_parent_id!=','0');
		$this->db->where('group_parent_id',$group_id);
		// $this->db->join(TBLPREFIX.'category as c','c.category_id=g.group_category_id','left');
		$this->db->join(TBLPREFIX.'users as u','u.user_id=g.service_provider_id','left');
		$query = $this->db->get(TBLPREFIX."service_group as g");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}

	public function getAllServiceproviders($category_id,$res)
	{
		$this->db->select('*');
		$this->db->where('category_id',$category_id);
		$query = $this->db->get(TBLPREFIX."users");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}

	public function chkGroupCategory($category_id,$res)
	{
		$this->db->select('*');
		$where = '(group_category_id="'.$category_id.'")';
       	$this->db->where($where);
		$query=$this->db->get(TBLPREFIX."service_group");
		//echo $this->db->last_query();exit;
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}

	public function chkupdateGroupCategory($category_id,$group_id,$res)
	{
		$this->db->select('*');
		$where = '(group_category_id="'.$category_id.'")';
       	$this->db->where($where);
       	$this->db->where('group_id!=',$group_id);
		$query=$this->db->get(TBLPREFIX."service_group");
		//echo $this->db->last_query();exit;
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}

	public function getAllGroup($res,$per_page,$page)
	{
		$this->db->select('g.*,c.category_name');
		$this->db->where('group_parent_id','0');
		$this->db->join(TBLPREFIX.'category as c','c.category_id=g.group_category_id','left');
		$this->db->order_by('group_id','DESC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}
		$result = $this->db->get(TBLPREFIX.'service_group as g');
		//echo $this->db->last_query();exit;
		if($res == 1){
			$response=$result->result_array();
		}else{
			$response=$result->num_rows();
		}
		return $response;
	}

	public function getAllCategory($res)
	{
		$this->db->select('*');
		$this->db->where('category_parent_id','0');
		$this->db->order_by('category_name','ASC');
		$result = $this->db->get(TBLPREFIX.'category');
		//echo $this->db->last_query();exit;
		if($res == 1){
			$response=$result->result_array();
		}else{
			$response=$result->num_rows();
		}
		return $response;
	}
	
	
	public function uptdateGroup($input_data,$group_id) 
	{
		$this->db->where('group_id',$group_id);
		$res = $this->db->update(TBLPREFIX.'service_group',$input_data);
		if($res)
		{
			return true;
		}
		else
			return false;
	}

	
	public function uptdateStatus($input_data,$group_id) 
	{
		$this->db->where('group_id',$group_id);
		$res = $this->db->update(TBLPREFIX.'service_group',$input_data);
		if($res)
		{
			return true;
		}
		else
			return false;
	}
	
}