
<?php
Class Category_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function getSingleCategoryInfo($category_id,$res)
	{
		$this->db->select('*');
		$this->db->where('category_id',$category_id);
		$query = $this->db->get(TBLPREFIX."category");
		if($res == 1)
		{
			return $query->result_array();
		}
		else
		{
			return $query->num_rows();
		}	
	}
	public function chkCategoryName($category_name,$res)
	{
		$this->db->select('*');
		//$this->db->where('username',$username);
		//$this->db->where('email_address',$email_address);
		$where = '(category_name="'.$category_name.'")';
       	$this->db->where($where);
		$query=$this->db->get(TBLPREFIX."category");
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

	public function getAllCategory($res,$per_page,$page)
	{
		$this->db->select('*');
		$this->db->order_by('category_id','DESC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}
		$result = $this->db->get(TBLPREFIX.'category');
		//echo $this->db->last_query();exit;
		if($res == 1){
			$response=$result->result_array();
			foreach($response as $key=>$row)
			{
				if(isset($row['category_image']) && $row['category_image']!="")
				{
					$row['category_image']=base_url()."uploads/category_images/".$row['category_image'];
				}
				$response[$key]=$row;
			}
		}else{
			$response=$result->num_rows();
		}

		
		return $response;
	}
	
	
	public function uptdateCategory($input_data,$category_id) 
	{
		$this->db->where('category_id',$category_id);
		$res = $this->db->update(TBLPREFIX.'category',$input_data);
		if($res)
		{
			return true;
		}
		else
			return false;
	}

	
	public function uptdateStatus($input_data,$category_id) 
	{
		$this->db->where('category_id',$category_id);
		$res = $this->db->update(TBLPREFIX.'category',$input_data);
		if($res)
		{
			return true;
		}
		else
			return false;
	}
	

public function getAllCategorydropdown($res,)
	{
		
	
		/*echo "PerPage--".$per_page;
		echo "page--".$page;exit();*/
		$this->db->select('*');
		$this->db->where('`category_parent_id`="0"','category_status="Active"');
		// $this->db->order_by('category_name','ASC');
		
		$result = $this->db->get(TBLPREFIX.'category');
		//echo $this->db->last_query();exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	
	}



}