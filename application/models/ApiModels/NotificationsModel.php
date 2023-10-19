<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class NotificationsModel extends CI_Model {
	
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		
		function getAllNotifications($userid)
		{
			$this->db->select('*');
			$this->db->from('notifications');
			return $this->db->get()->result_array();			
		}

	}