<?php
Class Admin_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	
	public function check_adminexists($admin_email,$username,$adminId="")
	{
		if($adminId> 0)
			$query="SELECT admin_id FROM ".TBLPREFIX."admin WHERE (admin_email = '$admin_email' OR username ='$username') AND admin_id != $adminId"; 
		else
			$query="SELECT admin_id FROM ".TBLPREFIX."admin WHERE (admin_email = '$admin_email' OR username ='$username') "; 
		$sts = $this->db->query($query);
		return $sts->num_rows();
	}
	// Read data using username and password
	
	
	# Add Admin Details  
	public function add_admin($input_data) 
	{
		$res	=	$this->db->insert(TBLPREFIX.'admin',$input_data);
		if($res)
		{
			$fdbrd_admin_id=$this->db->insert_id();
			return $fdbrd_admin_id;
		}
		else
		return false;
	}
	
	# Update Admin Details 
	public function upt_admin($input_data,$admin_id)
	{
		$this->db->where('admin_id',$admin_id);
		$query=$this->db->update(TBLPREFIX."admin",$input_data);
		if($query==1)
		{
			return true;
		}
		else
		{
			return false;
		}	
	}
	
	
	public function getAdminCnt()
	{
		$this->db->select('userid');
		$res=$this->db->get(TBLPREFIX.'users');
		$this->db->where("status NOT IN ('Delete')");
		return $tsr=$res->num_rows();
	}
	
	public function getAdminInfo()
	{
		$this->db->select(TBLPREFIX.'users.*');
		$res=$this->db->get(TBLPREFIX.'users');
		return $tsr=$res->result_array();
	}
	
	
	// Read data using username and password
	public function getAdminDetails($admin_id,$qty) 
	{
		$this->db->select('*');
		$this->db->from(TBLPREFIX.'admin');
		$this->db->where('admin_id',$admin_id);
		$query = $this->db->get();
		if($qty==1)
			return $query->result_array();
		else
			return $query->num_rows();
	}
	
	public function checkAdminPassword($old_password,$admin_id)
	{
		$this->db->select('admin_id');
		$this->db->from(TBLPREFIX.'admin');
		$this->db->where('admin_id',$admin_id);
		$this->db->where('admin_password',md5($old_password));
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function udatPassord($admin_password,$adminId)
	{
	    $sts = "";
	    if($adminId > 0){
	     $admin_password = md5($admin_password);
		    $sts = $this->db->query("Update ".TBLPREFIX."admin SET admin_password = '$admin_password' WHERE admin_id = '$adminId' ");
	    }
		return $sts;
	}
	
	
}