
<?php
Class Booking_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function getAllBooking($res,$per_page,$page,$filter=array())
	//public function getAllBooking($res,$per_page,$page,$filter=array())
	{
		/*echo "PerPage--".$per_page;
		echo "page--".$page;exit();*/
		$this->db->select('b.*,u.full_name,c.category_name');
		$this->db->join(TBLPREFIX.'category as c','c.category_id=b.category_id','left');
		$this->db->join(TBLPREFIX.'users as u','u.user_id=b.user_id','left');
	
		if(!empty($filter))
		{
			extract($filter);
			if(isset($status) && $status!="")
			{
				$this->db->where('b.booking_status',$status);
			}
			if(isset($datesearch) && $datesearch!="")
			{
				$this->db->where('b.booking_date>=',$datesearch);
				$this->db->where('b.booking_date<=',$datesearch." 23:59:59");
			}
		}
		$this->db->order_by('b.booking_id','DESC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get(TBLPREFIX."booking as b");
		 //echo $this->db->last_query();exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();

	}
	
	public function getSingleBookingInfo($booking_id,$res)
	{
		$this->db->select('b.*,u.full_name,u.profile_pic,u.email,u.mobile,bd.*,c.category_name');
		$this->db->join(TBLPREFIX.'category as c','c.category_id=b.category_id','left');
		$this->db->join(TBLPREFIX.'users as u','u.user_id=b.user_id','left');
		$this->db->join(TBLPREFIX.'booking_details as bd','bd.booking_id=b.booking_id','left');
		$this->db->where('b.booking_id',$booking_id);
		$query = $this->db->get(TBLPREFIX."booking as b");
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

    public function getServiceproviderDetails($user_id)
	{
		$this->db->select('*');
		$this->db->where('user_id',$user_id );
		$query = $this->db->get(TBLPREFIX."users");
		//echo $this->db->last_query();exit;
		
			return $query->result_array();
		
	}


 public function getBookingBystatus($booking_status) {
        // Query to fetch products by category
        $this->db->where('booking_status', $booking_status);
        $this->db->order_by('booking_id','DESC');
		
	
        $query = $this->db->get(TBLPREFIX."booking");
        
        return $query->result();
    }

	public function getAllUsers($res,$per_page,$page)
	{
		/*echo "PerPage--".$per_page;
		echo "page--".$page;exit();*/
		//$this->db->select('*');
		$this->db->select('u.*,z.zone_name');
		$this->db->join(TBLPREFIX.'zone as z','z.zone_id=u.zone_id','left');
		$this->db->where('user_type',$user_type = "Service Provider");
		$this->db->order_by('u.user_id','DESC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}
		$result = $this->db->get(TBLPREFIX.'users as u');
		//echo $this->db->last_query();exit;
		if($res == 1)
			return $result->result_array();
		else
			return $result->num_rows();
	}

	public function uptdateAssingServiceprovider($input_data,$booking_id)
	{
		$this->db->where('booking_id',$booking_id);
		$query=$this->db->update(TBLPREFIX."booking",$input_data);
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

 
}