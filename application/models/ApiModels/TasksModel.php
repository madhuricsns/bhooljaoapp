<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class TasksModel extends CI_Model {
	
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		
		function getUserTasks($userid)
		{
			$this->db->select('*');
			$this->db->from('user_tasks');
			$this->db->where('userid',$userid);
			$this->db->order_by('dateadded', 'desc');
			return $this->db->get()->result_array();	
		}
		
		function getTaskDetails($task_id)
		{
			$this->db->select('*');
			$this->db->from('user_tasks');
			$this->db->where('task_id',$task_id);
			return $this->db->get()->row();	
		}
		
		function getUserTaskReports($pagination,$pageid,$Offset,$limit,$status,$filter_by,$filter,$from_date,$to_date)
		{
			$this->db->select("u.full_name,ut.task_id,ut.title,ut.description,ut.task_hrs,ut.status,(DATE_FORMAT(DATE(ut.task_date),'%d/%m/%Y')) as task_date");
			$this->db->from('user_tasks as ut');
			$this->db->join('users u','u.userid=ut.userid','left');
			$this->db->where('ut.status',$status);
			if($filter_by == 'Username')
			{
				$this->db->like('u.full_name', $filter);
			}
			else if($filter_by == 'Date')
			{
				if($filter == 'Today')
				{
					$this->db->where('DATE(ut.task_date) = CURDATE()');
				}
				if($filter == 'Yesterday')
				{
					$this->db->where('DATE(ut.task_date) = DATE(NOW() - INTERVAL 1 DAY)');
				}
				if($filter == 'This Week')
				{
					$this->db->where('ut.task_date >= DATE(NOW()) - INTERVAL 7 DAY');
				}
				if($filter == 'Last Week')
				{
					$this->db->where('YEARWEEK(ut.task_date, 1) = YEARWEEK( CURDATE() - INTERVAL 1 WEEK, 1)');
				}
				if($filter == 'Last Month')
				{
					$this->db->where('MONTH(ut.task_date) = MONTH(NOW()) - 1 ');
				}
				if($filter == 'Last Quarter')
				{
					$this->db->where('MONTH(ut.task_date) = MONTH(NOW()) - 6 ');
				}
				if($filter == 'Custom')
				{
					$this->db->where("date(ut.task_date) BETWEEN '".$from_date."' AND '".$to_date."'");
				}
			}
			
			if($pagination=='true')
			{
				if($pageid>1)
				{
					$this->db->limit(POSTLIMIT,$Offset);
				}
				else
				{
					$this->db->limit(POSTLIMIT,$Offset);
				}
			}
			else if($limit != '') {
				$this->db->limit($limit);
			}

			$this->db->order_by('ut.dateadded', 'desc');
			return $this->db->get()->result_array();	
		}
		
		function getUserTaskReportsCnt($status,$filter_by,$filter,$from_date,$to_date)
		{
			$this->db->select("u.full_name,ut.title,ut.description,ut.task_hrs,ut.status,(DATE_FORMAT(DATE(ut.task_date),'%d/%m/%Y')) as task_date");
			$this->db->from('user_tasks as ut');
			$this->db->join('users u','u.userid=ut.userid','left');
			$this->db->where('ut.status',$status);
			if($filter_by == 'Username')
			{
				$this->db->like('u.full_name', $filter);
			}
			else if($filter_by == 'Date')
			{
				if($filter == 'Today')
				{
					$this->db->where('DATE(ut.task_date) = CURDATE()');
				}
				if($filter == 'Yesterday')
				{
					$this->db->where('DATE(ut.task_date) = DATE(NOW() - INTERVAL 1 DAY)');
				}
				if($filter == 'This Week')
				{
					$this->db->where('ut.task_date >= DATE(NOW()) - INTERVAL 7 DAY');
				}
				if($filter == 'Last Week')
				{
					$this->db->where('YEARWEEK(ut.task_date, 1) = YEARWEEK( CURDATE() - INTERVAL 1 WEEK, 1)');
				}
				if($filter == 'Last Month')
				{
					$this->db->where('MONTH(ut.task_date) = MONTH(NOW()) - 1 ');
				}
				if($filter == 'Last Quarter')
				{
					$this->db->where('MONTH(ut.task_date) = MONTH(NOW()) - 6 ');
				}
				if($filter == 'Custom')
				{
					$this->db->where("date(ut.task_date) BETWEEN '".$from_date."' AND '".$to_date."'");
				}
			}
			return $this->db->get()->num_rows();	
		}
	}