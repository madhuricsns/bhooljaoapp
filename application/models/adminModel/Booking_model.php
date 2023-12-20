
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
		$this->db->where('b.is_demo','No');
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

	public function getCategoryDetails($category_id)
	{
		$this->db->select('*');
		$this->db->where('category_id',$category_id );
		$query = $this->db->get(TBLPREFIX."category");
		return $query->row();
	}

	public function getAllGroup($res,$category_id)
	{
		$this->db->select('g.*,c.category_name');
		$this->db->where('group_category_id',$category_id);
		$this->db->join(TBLPREFIX.'category as c','c.category_id=g.group_category_id','left');
		$this->db->order_by('group_id','DESC');
		$result = $this->db->get(TBLPREFIX.'service_group as g');
		//echo $this->db->last_query();exit;
		if($res == 1){
			$response=$result->result_array();
		}else{
			$response=$result->num_rows();
		}
		return $response;
	}


 	public function getBookingBystatus($booking_status) 
	{
        // Query to fetch products by category
        $this->db->where('booking_status', $booking_status);
        $this->db->order_by('booking_id','DESC');
		
	
        $query = $this->db->get(TBLPREFIX."booking");
        
        return $query->result();
    }

	public function getAllUsers($res,$per_page,$page,$category_id)
	{
		/*echo "PerPage--".$per_page;
		echo "page--".$page;exit();*/
		//$this->db->select('*');
		$this->db->select('u.*,z.zone_name');
		$this->db->join(TBLPREFIX.'zone as z','z.zone_id=u.zone_id','left');
		$this->db->where('user_type',$user_type = "Service Provider");
		$this->db->where('status','Active');
		$this->db->where('category_id',$category_id);
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
			$this->db->where('booking_id',$booking_id);
			$this->db->where('service_provider_id !=',$input_data['service_provider_id']);
			$this->db->update(TBLPREFIX."booking_accepted",array('status'=>'Rejected'));
			
			$this->db->where('booking_id',$booking_id);
			$this->db->where('service_provider_id',$input_data['service_provider_id']);
			$this->db->update(TBLPREFIX."booking_accepted",array('status'=>'Accepted'));
			
			
			return true;
		}
		else
		{
			return false;
		}	
	}
	
	public function getServiceDetails($booking_id) 
	{
		$this->db->select('s.service_name,bd.option_label,bd.option_value,bd.option_amount,b.duration,b.admin_commision,b.gst_amount,b.gst_percentage,b.coupon_code,b.coupon_amount,b.coupon_percentage');
		$this->db->from(TBLPREFIX.'booking as b');
		$this->db->where('b.booking_id',$booking_id);
		$this->db->join(TBLPREFIX.'booking_details as bd','bd.booking_id = b.booking_id','left');
		$this->db->where('bd.option_amount >',0);
		$this->db->join(TBLPREFIX.'service as s','s.service_id = bd.service_id','left');
		$query = $this->db->get();
		$result= $query->result_array();
		return $result;
	}
	
	public function getServiceDetailsWOPricing($booking_id) 
	{
		$this->db->select('s.service_name,bd.option_label,bd.option_value');
		$this->db->from(TBLPREFIX.'booking as b');
		$this->db->where('b.booking_id',$booking_id);
		$this->db->join(TBLPREFIX.'booking_details as bd','bd.booking_id = b.booking_id','left');
		$this->db->where('bd.option_amount =',0);
		$this->db->join(TBLPREFIX.'service as s','s.service_id = bd.service_id','left');
		$query = $this->db->get();
		$result= $query->result_array();
		return $result;
	}
		
	public function getBookingAddressDetails($address_id)
	{
		$this->db->select('*');
		$this->db->where('address_id',$address_id );
		$query = $this->db->get(TBLPREFIX."addresses");
		return $query->row();
	}
	
	public function getAllBookingDemo($res,$per_page,$page,$filter=array())
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
		$this->db->where('b.is_demo','Yes');
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
	
	public function getPromocodeDetails($promocode_id)
	{
		$this->db->select('*');
		$this->db->where('promocode_id',$promocode_id );
		$query = $this->db->get(TBLPREFIX."promo_code");
		return $query->result_array();
	}
	
	public function getBookingWorkHistory($booking_id)
	{
		$this->db->select('*');
		$this->db->where('booking_id',$booking_id );
		$query = $this->db->get(TBLPREFIX."booking_history");
		return $query->result_array();
	}
	
	public function getBookingTransactionHistory($booking_id)
	{
		$this->db->select('*');
		$this->db->where('booking_id',$booking_id );
		$query = $this->db->get(TBLPREFIX."booking_transaction");
		return $query->result_array();
	}
}