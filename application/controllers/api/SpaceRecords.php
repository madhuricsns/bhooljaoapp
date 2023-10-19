<?php
require(APPPATH.'/libraries/REST_Controller.php');

class SpaceRecords extends REST_Controller {
 
	public function __construct()
    {
        parent::__construct();
		$this->load->model('Common_Model');
		$this->load->model('ApiModels/DashboardModel');
		$this->load->model('Home_model');
	}
		
	public function index_post()
	{
		$token 			= $this->input->post("token");
		$userid			= $this->input->post("userid");
		$pageid 		= $this->input->post("pageid");
        $pagination 	= $this->input->post("pagination");
		$filter 		= $this->input->post("filter") ? $this->input->post("filter") : 'All';
		$fromdate 		= $this->input->post("from_date") ? $this->input->post("from_date") : '';
		$todate 		= $this->input->post("to_date") ? $this->input->post("to_date") : '';
		
		$from = str_replace('/', '-', $fromdate);  
    	$from_date = date("Y-m-d", strtotime($from));  
		
		$to = str_replace('/', '-', $todate);  
    	$to_date = date("Y-m-d", strtotime($to)); 
		
		if(!isset($pagination))
        {
            $pagination=false;
        }
        if($pageid > 1)
        {
            $offset = ($pageid - 1) * POSTLIMIT;
        }
        else
        {
            $pageid=1;
            $offset = ($pageid) * POSTLIMIT;
        }
		//echo "pageid: ".$pageid." offset:".$offset;
		
		if($token == TOKEN)
		{
			if(!isset($userid) || $userid=="")
			{
				$data = array('responsemessage' => 'Please provide user Id ',
					'responsecode' => "403"); //create an array
				$obj = (object)$data;//Creating Object from array
				// $response_array=json_encode($obj);
			}
			else if(!isset($filter) || $filter=="Custom" && $from_date=="" && $to_date=="")
			{
				$data = array('responsemessage' => 'Please provide From date and To Date ',
					'responsecode' => "403"); //create an array
				$obj = (object)$data;//Creating Object from array
				// $response_array=json_encode($obj);
			}
			else
			{
				// $update=array('record_date'=>'2023-09-30');
				// $this->db->where('PrimaryLive.No','4638');
			  	// $this->db->update('PrimaryLive',$update);

				$data['responsecode'] = "200";
				$data['total'] = $this->DashboardModel->getSpaceRecordsCnt($filter,$from_date,$to_date);
				$data['pagecount'] = round($data['total']/POSTLIMIT);
				$data['data'] = $this->DashboardModel->getSpaceRecords($pagination,$pageid,$offset,$limit = '',$filter,$from_date,$to_date);
				// echo $this->db->last_query();
			}
		}
		else
		{
			$data['responsecode'] = "201";
			$data['responsemessage'] = 'Token did not match';
		}	
		$response_array=json_encode($data);						
		print_r($response_array);
	}
}
