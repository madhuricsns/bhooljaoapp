<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Tasks extends REST_Controller {
 
	public function __construct()
    {
        parent::__construct();
		$this->load->model('Common_Model');
		$this->load->model('ApiModels/TasksModel');
		$this->load->model('ApiModels/User');
	}
		
	public function index_post()
	{
		$token 			= $this->input->post("token");
		$userid			= $this->input->post("userid");
		
		/*$res = $this->db->query("select * from users where userid = 2");
		print_r($res->result_array());*/
		
		if($token == TOKEN)
		{
			if(!isset($userid) || $userid=="")
			{
				$num = array('responsemessage' => 'Please provide user Id ',
					'responsecode' => "403"); //create an array
				$obj = (object)$num;//Creating Object from array
				$response_array=json_encode($obj);
			}
			else
			{
				$arrTasks = $this->TasksModel->getUserTasks($userid);
				
				$data['responsecode'] = "200";
				$data['data'] = $arrTasks;
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
	
	public function addTask_post()
	{
		$token 			= $this->input->post("token");
		$userid 		= $this->input->post("userid");
		$title		 	= $this->input->post("title");
		$description	= $this->input->post("description");
		$task_hrs	 	= $this->input->post("task_hrs");
		$task_date	 	= $this->input->post("task_date");
		
		$date = str_replace('/', '-', $task_date);
		$task_date = date('Y-m-d', strtotime($date));
		
		if($token == TOKEN)
		{
			$arrTask = array(
							'userid' => $userid,
							'title' => $title,
							'description' => $description,
							'task_hrs' => $task_hrs,
							'task_date' => $task_date,
							);
							
			$task_id = $this->Common_Model->insert_data('user_tasks',$arrTask);
			
			$taskData = $this->TasksModel->getTaskDetails($task_id);
			
			$userFcmToSendNotifications = $this->User->getAllSuperadminUsers();
			//print_r($userFcmToSendNotifications);
			if(!empty($userFcmToSendNotifications))
			{
				$arrUserDetails = $this->User->getUserDetails($userid);
				
				$taskDesc = 'New time is reported by '.$arrUserDetails->full_name.' '.$taskData->task_hrs.' Hrs reported.';
				
				//$taskDesc = 'New task added by '.$arrUserDetails->full_name.'\n'.'Task Details: '.$taskData->title.' ('.$taskData->task_hrs.')\n'.$taskData->description;
				$i = 0;
				//$arrGcmID[] = array();
				foreach($userFcmToSendNotifications as $userFcm)
				{
					if($userFcm['fcm_token'] != '')
					{
						if($i == 0)
							$arrGcmID[] = $userFcm['fcm_token'];
						else
							$arrGcmID[] .= $userFcm['fcm_token'];
					}
					$i++;
					
					
				}
				
				$this->Common_Model->sendexponotification('New Task', stripslashes($taskDesc), $arrGcmID);
			}
			
			$data['responsecode'] = "200";
			$data['responsemessage'] = 'Task added successfully..';
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
