<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class CategoryModel extends CI_Model {
	
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
        
        public function getAllCategories() 
        {
            $this->db->select('*');
            $this->db->from(TBLPREFIX.'category');
            $this->db->where('category_status','Active');
            $query = $this->db->get();
			$result= $query->result_array();
            foreach($result as $key=>$row)
            {
                if(isset($row['category_image']) && $row['category_image']!="")
                {
                    $row['category_image']=base_url()."uploads/category_images/".$row['category_image'];
                }
                $result[$key]=$row;
            }
            return $result;
        }

		public function getCategoryDetails($category_id) 
        {
            $this->db->select('category_name,category_image,category_description,category_amount');
			$this->db->where('category_id',$category_id);
            $this->db->from(TBLPREFIX.'category');
            $query = $this->db->get();
			$result = $query->row();
            
			if(isset($result->category_image) && $result->category_image != "")
			{
				$result->category_image = base_url()."uploads/category_images/".$result->category_image;
			}
			
			$this->db->select('*');
            $this->db->where('category_id',$category_id);
			$this->db->from(TBLPREFIX.'category_details');
			//$this->db->group_by('option_label');
			$qry = $this->db->get();
            $categoryDetails = $qry->result_array();
			$result->categoryDetails = $categoryDetails;
            return $result;
        }

        public function getAllServiceByCategoryId($category_id) 
        {
            $this->db->select('*');
            $this->db->from(TBLPREFIX.'service');
            $this->db->where('service_status','Active');
            // $this->db->where('parent_service_id','0');
            $query = $this->db->get();
			$result= $query->result_array();
            foreach($result as $key=>$row)
            {
                if(isset($row['service_image']) && $row['service_image']!="")
                {
                    $row['service_image']=base_url()."uploads/service_images/".$row['service_image'];
                }
                $result[$key]=$row;
            }
            return $result;
        }

        public function getAllServiceDetails($service_id) 
        {
            $this->db->select('option_label,option_type,service_id');
            $this->db->from(TBLPREFIX.'service_details');
            $this->db->where('service_id',$service_id);
            $this->db->group_by('option_label');
            $this->db->order_by('option_id','asc');
            $query = $this->db->get();
			$result= $query->result_array();
            
            return $result;
        }

        public function getAllServiceDetailOptions($service_id,$option_type) 
        {
            $this->db->select('option_name,option_amount');
            $this->db->from(TBLPREFIX.'service_details');
            $this->db->where('service_id',$service_id);
            $this->db->where('option_type',$option_type);
            $query = $this->db->get();
			$result= $query->result_array();
            
            return $result;
        }

        public function getAllAddonServices($service_id) 
        {
            $this->db->select('*');
            $this->db->from(TBLPREFIX.'service');
            $this->db->where('service_status','Active');
            $this->db->where('parent_service_id',$service_id);
            $query = $this->db->get();
			$result= $query->result_array();
            foreach($result as $key=>$row)
            {
                if(isset($row['service_image']) && $row['service_image']!="")
                {
                    $row['service_image']=base_url()."uploads/service_images/".$row['service_image'];
                }
                $result[$key]=$row;
            }
            return $result;
        }
	}