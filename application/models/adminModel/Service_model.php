<?php
Class Service_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function getSingleServiceInfo($id,$res)
	{
		$this->db->select('s.*,c.category_name');
		$this->db->join(TBLPREFIX.'category as c','c.category_id=s.category_id','left');
		$this->db->where('s.service_id',$id);
		$query = $this->db->get(TBLPREFIX."service as s");
		if($res == 1)
		{
			$result= $query->result_array();
			if(isset($result[0]['service_image']) && $result[0]['service_image']!="")
			{
				$result[0]['service_image']=base_url()."uploads/service_images/".$result[0]['service_image'];
			}
		}
		else
		{
			$result=$query->num_rows();
		}	
		return $result;
	}
	
	public function getAllService($res,$per_page,$page)
	{
		/*echo "PerPage--".$per_page;
		echo "page--".$page;exit();*/
		$this->db->select('s.*,c.category_name');
		$this->db->join(TBLPREFIX.'category as c','c.category_id=s.category_id','left');
		$this->db->where('s.parent_service_id','0');
		$this->db->order_by('s.service_id','DESC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get(TBLPREFIX.'service as s');
		//echo $this->db->last_query();exit;
		if($res == 1){
			$response= $result->result_array();
			foreach($response as $key=>$row)
			{
				if(isset($row['service_image']) && $row['service_image']!="")
				{
					$row['service_image']=base_url()."uploads/service_images/".$row['service_image'];
				}
				$response[$key]=$row;
			}
		}else{
			$response= $result->num_rows();
		}
			return $response;
	}
	public function getAllCategory($res)
	{
		/*echo "PerPage--".$per_page;
		echo "page--".$page;exit();*/
		$this->db->select('*');
		$this->db->where('category_status',"Active");
		// $this->db->order_by('category_name','ASC');
		
		$result = $this->db->get(TBLPREFIX.'category');
		//echo $this->db->last_query();exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}
	
	public function getAllServiceDetails($service_id,$res)
	{
		/*echo "PerPage--".$per_page;
		echo "page--".$page;exit();*/
		$this->db->select('*');
		$this->db->where('service_id',$service_id);
		$result = $this->db->get(TBLPREFIX.'service_details');
		//echo $this->db->last_query();exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}

	public function getAllServiceDetailOptions($service_id,$res)
	{
		/*echo "PerPage--".$per_page;
		echo "page--".$page;exit();*/
		$this->db->select('*');
		$this->db->where('service_id',$service_id);
		//$this->db->where('option_type','Option');
		$result = $this->db->get(TBLPREFIX.'service_details');
		//echo $this->db->last_query();exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}

	public function getAllServiceDetailLabels($service_id,$res)
	{
		/*echo "PerPage--".$per_page;
		echo "page--".$page;exit();*/
		$this->db->select('*');
		$this->db->where('service_id',$service_id);
		$this->db->where('option_type','Label');
		$result = $this->db->get(TBLPREFIX.'service_details');
		//echo $this->db->last_query();exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}
	
	public function getSingleUsertaskInfo($usertask_id,$res)
	{
		$this->db->select('user_tasks.*,users.full_name');
		$this->db->join('users','users.userid=user_tasks.userid','inner');
		$this->db->where('task_id',$usertask_id);
		$query = $this->db->get("user_tasks");
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


public function uptdateService($input_data,$id)
	{
		$this->db->where('service_id',$id);
		$query=$this->db->update(TBLPREFIX."service",$input_data);
		if($query==1)
		{
			return true;
		}
		else
		{
			return false;
		}	
	}


	
	
	
	
	public function insert_service($input_data) 
	{
		$res = $this->db->insert(TBLPREFIX.'service',$input_data);
		if($res)
		{
			return $this->db->insert_id();
		}
		else
			return false;
	}
	
	public function deleteoption($service_id)
	{
		$this->db->where('service_id',$service_id);
		$res = $this->db->delete(TBLPREFIX.'service_details');
		if($res)
			return true;
		else
			return false;
	}
	
	public function getAllUsersFcmToken()
	{
		$this->db->select('fcm_token');
		$this->db->where('status','Active');
		$query = $this->db->get("users");
		return $query->result_array();
	}
	
	public function getUserFcmToken($userid)
	{
		$this->db->select('fcm_token');
		$this->db->where('userid',$user_id);
		$query = $this->db->get("users");
		return $query->row();
	}

	
	public function getAllAddonService($res,$per_page,$page,$id)
	{
		/*echo "PerPage--".$per_page;
		echo "page--".$page;exit();*/
		$this->db->select('s.*');
		//$this->db->join(TBLPREFIX.'category as c','c.category_id=s.category_id','left');
		$this->db->where('s.parent_service_id',$id);
		$this->db->order_by('s.service_id','DESC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get(TBLPREFIX.'service as s');
		// echo $this->db->last_query();exit;
		if($res == 1){
			$response= $result->result_array();
			foreach($response as $key=>$row)
			{
				if(isset($row['service_image']) && $row['service_image']!="")
				{
					$row['service_image']=base_url()."uploads/service_images/".$row['service_image'];
				}
				
				if($row['parent_service_id'] != 0)
				{
					$this->db->select('service_name');
					$this->db->where('service_id',$row['parent_service_id']);
					$qryParent = $this->db->get(TBLPREFIX.'service');
					$parentRes = $qryParent->row();
					$row['parent_service'] = $parentRes->service_name;
				}
				$response[$key]=$row;
			}
		}else{
			$response= $result->num_rows();
		}
			return $response;
	}

	public function uptdateStatus($input_data,$service_id) 
	{
		$this->db->where('service_id',$service_id);
		$res = $this->db->update(TBLPREFIX.'service',$input_data);
		if($res)
		{
			return true;
		}
		else
			return false;
	}
	
	public function getAllServiceList($res)
	{
		$this->db->select('*');
		$this->db->where('service_status',"Active");
		$this->db->where('parent_service_id','0');
		$result = $this->db->get(TBLPREFIX.'service');
		
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}
}