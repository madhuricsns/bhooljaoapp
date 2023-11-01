<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class AddressModel extends CI_Model {
	
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

    
		public function getAddressDetails($user_id,$address_id) 
        {
            if(!empty ($address_id))
            {
                $this->db->select('*');
                $this->db->from(TBPREFIX.'adresses');
                $this->db->where('user_id',$user_id);
                $this->db->where('address_id',$address_id);
                $this->db->limit(1);
                $query = $this->db->get();
                $result= $query->row();
                return $result;
            }
        }
	
		function getAllAddress($user_id,$lng)
		{
			$this->db->select('*');
			$this->db->from(TBPREFIX.'adresses');
			$this->db->where('adress_status','Active');
			$this->db->where('user_id',$user_id);
            if(!isset($lng))
            {
              $lng='english';  
            }
            $this->db->where('address_language',$lng);
			return $this->db->get()->result_array();			
		}

        function getAllCity($lng='')
		{
            if($lng=="" || $lng=='en')
            {
                $strPrefix = "";
            }
            else
            {
                $strPrefix = "_ch";
            }
			$this->db->select('*');
			$this->db->from(TBPREFIX.'city'.$strPrefix);
			return $this->db->get()->result_array();			
		}

        function isselected_pickup_update($user_id)
        {
            $data=array('is_seleted'=>0);
            $this->db->where('user_id',$user_id);
            $this->db->update(TBPREFIX.'adresses',$data);
        }

        function isselected_drop_update($user_id)
        {
            $data=array('is_selected_drop'=>0);
            $this->db->where('user_id',$user_id);
            $this->db->update(TBPREFIX.'adresses',$data);
        }
	}