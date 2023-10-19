<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Reports extends REST_Controller {
 
	public function __construct()
    {
        parent::__construct();
		$this->load->model('Common_Model');
		$this->load->model('ApiModels/TasksModel');
	}
		
	public function index_post()
	{
		$token 			= $this->input->post("token");
				
		$pageid 		= $this->input->post("pageid");
        $pagination 	= $this->input->post("pagination");
		$filter_by 		= 
		$this->input->post("filter_by") ? $this->input->post("filter_by") : '';
		
		$filter 		= 
		$this->input->post("filter") ? $this->input->post("filter") : '';
		
		$status 		= $this->input->post("status") ? $this->input->post("status") : 'All';
		
		
		$from_date 	= $this->input->post("from_date");
		$to_date 	= $this->input->post("to_date");
		
		if(isset($from_date))
		{
			$date = str_replace('/', '-', $from_date);
			$from_date = date('Y-m-d', strtotime($date));
		}
		
		if(isset($to_date))
		{
			$date_to = str_replace('/', '-', $to_date);
			$to_date = date('Y-m-d', strtotime($date_to));
		}

		if(!isset($pagination))
        {
            $pagination='false';
        }
        if($pageid > 0)
        {
			if($pageid=='1')
			{
				$pageid=0;
			}
			else if($pageid>1)
			{
				$pageid=$pageid-1;
			}
            $offset = $pageid * POSTLIMIT;
        }
        else
        {
            $pageid=0;
            $offset = ($pageid) * POSTLIMIT;
        }
		
		if($token == TOKEN)
		{
			$data['responsecode'] = "200";
			
			$data['total'] = $this->TasksModel->getUserTaskReportsCnt($status,$filter_by,$filter,$from_date,$to_date);
			
			$data['pagecount'] = ceil($data['total']/POSTLIMIT);
			
			$data['data'] = $this->TasksModel->getUserTaskReports($pagination,$pageid,$offset,$limit = '',$status,$filter_by,$filter,$from_date,$to_date);
		}
		else
		{
			$data['responsecode'] = "201";
			$data['responsemessage'] = 'Token did not match';
		}	
		$response_array=json_encode($data);						
		print_r($response_array);
	}
	
	public function changeStatus_post()
	{
		$token 			= $this->input->post("token");
		$task_id 		= $this->input->post("task_id");
		$status 		= $this->input->post("status");
		
		if($token == TOKEN)
		{
			$this->Common_Model->updateData('user_tasks','task_id',$task_id,array('status' => $status));
			
			$taskData = $this->TasksModel->getTaskDetails($task_id);
			
			$data['responsecode'] = "200";
			$data['responsemessage'] = 'Task status changed successfully..';
			$data['data'] = $taskData;
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
