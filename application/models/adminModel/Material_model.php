
<?php
Class Material_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function getAllMaterial($res,$per_page,$page)
	{
		/*echo "PerPage--".$per_page;
		echo "page--".$page;exit();*/
		$this->db->select('*');

		$this->db->order_by('material_id','DESC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get(TBLPREFIX.'material');
		//echo $this->db->last_query();exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}
	
	public function getSingleMaterialInfo($material_id,$res)
	{
		$this->db->select('*');
		$this->db->where('material_id',$material_id);
		$query = $this->db->get(TBLPREFIX."material");
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

    public function chkMaterialName($material_name,$res)
	{
		$this->db->select('*');
		$this->db->where('material_name',$material_name);
		$query = $this->db->get(TBLPREFIX."material");
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
	
}