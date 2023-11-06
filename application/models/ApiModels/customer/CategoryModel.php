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
            $this->db->select('*');
            $this->db->from(TBLPREFIX.'category');
            $query = $this->db->get();
			$result= $query->row();
            
			if(isset($result->category_image) && $result->category_image != "")
			{
				$result->category_image = base_url()."uploads/category_images/".$result->category_image;
			}

            return $result;
        }
	}