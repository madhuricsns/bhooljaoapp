
<?php
Class Booking_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function getAllBooking($res,$per_page,$page)
	{
		/*echo "PerPage--".$per_page;
		echo "page--".$page;exit();*/
		$this->db->select('b.*,u.full_name,bd.*,c.category_name');
		$this->db->join(TBLPREFIX.'category as c','c.category_id=b.category_id','left');
		$this->db->join(TBLPREFIX.'users as u','u.user_id=b.user_id','left');
		$this->db->join(TBLPREFIX.'booking_details as bd','bd.booking_id=b.booking_id','left');
		$this->db->order_by('b.booking_id','DESC');
		if($per_page!="")
		{
			$this->db->limit($per_page,$page);
		}

		$result = $this->db->get(TBLPREFIX.'booking as b');
		// echo $this->db->last_query();exit;
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
		$this->db->where('user_id',$user_id);
		$query = $this->db->get(TBLPREFIX."users");
		//echo $this->db->last_query();exit;
		
			return $query->result_array();
		
	}
 
}