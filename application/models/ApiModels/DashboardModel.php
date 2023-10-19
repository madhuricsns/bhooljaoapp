<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class DashboardModel extends CI_Model {
	
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		
		function getBanners()
		{
			$this->db->select('*');
			$this->db->from('banners');
			return $this->db->get()->result_array();			
		}

		function getscheduledFlights($limit='')
		{
			$todays_date=date('Y-m-d');
			$condition="flight_date>='".$todays_date."'";
			$this->db->select('f.*,ft.flight_type_name');
			$this->db->from('flights as f');
			$this->db->join('flight_types as ft','ft.flight_type_id=f.flight_type','left');
			$this->db->where($condition);
			$this->db->where('status','Enable');
			$this->db->order_by('flight_date','desc');
			if(isset($limit) && $limit!="")
			{
				$this->db->limit($limit);
			}
			
			return $this->db->get()->result_array();			
		}
		
		function getPastFlights($limit='')
		{
			$todays_date=date('Y-m-d');
			$condition="flight_date<'".$todays_date."'";
			$this->db->select('f.*,ft.flight_type_name');
			$this->db->from('flights as f');
			$this->db->join('flight_types as ft','ft.flight_type_id=f.flight_type','left');
			$this->db->where($condition);
			$this->db->where('status','Enable');
			$this->db->order_by('flight_date','desc');
			if(isset($limit) && $limit!="")
			{
				$this->db->limit($limit);
			}
			return $this->db->get()->result_array();			
		}

		function getFlightDetails($flight_id)
		{
			$this->db->select('f.*,ft.flight_type_name');
			$this->db->from('flights as f');
			$this->db->join('flight_types as ft','ft.flight_type_id=f.flight_type','left');
			$this->db->where('flight_id',$flight_id);
			return $this->db->get()->row();			
		}

		public function checkFlightRecords($flight_id)
		{
			$this->db->select('Lat,Lon,Time_GPS,Alt');
			$this->db->where('Lat >',20);
			$this->db->where('flight_id',$flight_id);
			$this->db->order_by('Time_GPS','desc');
			$res=$this->db->get('PrimaryLive');
			//print_r($this->db->last_query());
			return $tsr=$res->num_rows();
		}
		public function getFlightRecords($flight_id,$pagination,$pageid,$Offset,$limit)
		{
			$this->db->select('Lat,Lon,Time_GPS,Alt');
			$this->db->where('Lat >',20);
			$this->db->where('flight_id',$flight_id);
						
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
			$this->db->order_by('Time_GPS','desc');
			$res=$this->db->get('PrimaryLive');
			//print_r($this->db->last_query());
			return $tsr=$res->result_array();
		}

		function getQUARTER()
		{
			$today=date('Y-m-d');
			$this->db->select("QUARTER('".$today."') as quarter");
			$result = $this->db->get()->row();			
			return $result->quarter;
		}
		public function getSpaceRecords($pagination,$pageid,$Offset,$limit,$filter='All',$from_date='',$to_date='')
		{
			$quarter=$this->getQUARTER();
			$this->db->select('Lat,Lon,Time_GPS,Alt,record_date');
			$this->db->where('Lat >',20);
						
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

			if(isset($filter) && $filter!="" && $filter!="All")
			{
				
				switch($filter)
				{
					case "Today":
						$this->db->where('record_date = CURRENT_DATE()');
						break;

					case "Yesterday":
						$yesterday=date("Y-m-d", strtotime("yesterday")); 
						$this->db->where("record_date ='".$yesterday."'");
						break;

					case "Last Week":
						$this->db->where('DATE(record_date) > DATE_SUB(CURRENT_DATE(), INTERVAL 1 WEEK) ');
						$this->db->where('record_date <= CURRENT_DATE()');
						break;
							
					case "Last Month":
						//$this->db->where('MONTH(b.booking_date) = MONTH(NOW()) - 1 ');
						$this->db->where('DATE(record_date) > DATE_SUB(CURRENT_DATE() , INTERVAL 1 MONTH) ');
						$this->db->where('record_date <= CURRENT_DATE()');
						break;
					
					case "Last Quarter":
						$this->db->where('DATE(record_date) > DATE_SUB(CURRENT_DATE(), INTERVAL '.$quarter.' QUARTER) ');
						$this->db->where('record_date <= CURRENT_DATE()');
						break;

					// case "Semiyearly":
					// 	$this->db->where('DATE(b.booking_date) > DATE_SUB(CURRENT_DATE(), INTERVAL 6 MONTH) ');
					// 	$this->db->where('b.booking_date <= CURRENT_DATE()');
					// 	break;
						
					// case "Yearly":
					// 	$this->db->where('DATE(b.booking_date) > DATE_SUB(CURRENT_DATE(), INTERVAL 1 YEAR) ');
					// 	$this->db->where('b.booking_date <= CURRENT_DATE()');
					// 	break;

					case "Custom":
						$this->db->where("record_date >='".$from_date."'");
						$this->db->where("record_date <='".$to_date."'");
						break;
				}
			}

			$this->db->order_by('Time_GPS','desc');
			$res=$this->db->get('PrimaryLive');
			//print_r($this->db->last_query());
			return $tsr=$res->result_array();
		}
		
		public function getSpaceRecordsCnt($filter='All',$from_date='',$to_date='')
		{
			$this->db->select('Lat,Lon,Time_GPS,Alt');
			$this->db->where('Lat >',20);
			if(isset($filter) && $filter!="" && $filter!="All")
			{
				switch($filter)
				{
					case "Today":
						$this->db->where('record_date = CURRENT_DATE()');
						break;

					case "Yesterday":
						$yesterday=date("Y-m-d", strtotime("yesterday")); 
						$this->db->where("record_date ='".$yesterday."'");
						break;

					case "Last Week":
						$this->db->where('DATE(record_date) > DATE_SUB(CURRENT_DATE(), INTERVAL 1 WEEK) ');
						$this->db->where('record_date <= CURRENT_DATE()');
						break;
							
					case "Last Month":
						//$this->db->where('MONTH(b.booking_date) = MONTH(NOW()) - 1 ');
						$this->db->where('DATE(record_date) > DATE_SUB(CURRENT_DATE() , INTERVAL 1 MONTH) ');
						$this->db->where('record_date <= CURRENT_DATE()');
						break;
					
					case "Last Quarter":
						$this->db->where('DATE(record_date) > DATE_SUB(CURRENT_DATE(), INTERVAL '.$quarter.' QUARTER) ');
						$this->db->where('record_date <= CURRENT_DATE()');
						break;

					case "Custom":
						$this->db->where("record_date >='".$from_date."'");
						$this->db->where("record_date <='".$to_date."'");
						break;
				}
			}
			$this->db->order_by('Time_GPS','desc');
			$res=$this->db->get('PrimaryLive');
			return $res->num_rows();
		}
		
		function getFeedbackDetails($feedback_id)
		{
			$this->db->select('*');
			$this->db->from('feedback');
			$this->db->where('feedback_id',$feedback_id);
			return $this->db->get()->row();			
		}
	}