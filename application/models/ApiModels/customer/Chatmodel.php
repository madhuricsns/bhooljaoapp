<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Chatmodel extends CI_Model {
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
			//date_default_timezone_set('Europe/Madrid');
		}
		
		/* Register functions */
		function checkChatExists($res,$channel_id = '' , $user_id = '' , $service_provider_id = '')
		{				
			$this->db->select('*');
			$this->db->from(TBLPREFIX.'chat_channels');
			$this->db->where('channel_id',$channel_id);
			$this->db->where('user_id',$user_id);
			$this->db->where('service_provider_id',$service_provider_id);
			if($res==1)
			{
				return $this->db->get()->row();
			}
			else
			{
				return $this->db->get()->num_rows();
			}
		}
		
		 /* getFeedBackList functions */
		function getChatList($user_id,$channel_id = '')
		{				
			$this->db->select('c.*,u.full_name,u.profile_pic as user_photo,sp.full_name as sp_name,sp.profile_pic as sp_image');
			$this->db->from(TBLPREFIX.'chat_channels as c');
			$this->db->join(TBLPREFIX.'users as sp','sp.user_id=c.service_provider_id','left');
			$this->db->join(TBLPREFIX.'users as u','u.user_id=c.user_id','left');
			$this->db->order_by('c.chat_id','DESC');
            $this->db->where('c.user_id',$user_id);
			if($channel_id != "")
            {
                $this->db->where('channel_id',$channel_id);
            }
			return $this->db->get()->result_array();
		}
		 
		public function insert_new_Chat($data)
		{
			if($this->db->insert(TBLPREFIX.'chat_channels',$data))
			{
				return $this->db->insert_id();
			}
			else
				return false;
			#return $query=$this->db->insert('birth',$data);
		}

		public function update_new_Chat($data,$where,$id)
		{
			if($id > 0) 
			{
		    	$this->db->where($where,$id);
			  	$res=$this->db->update(TBLPREFIX.'chat_channels',$data); 
				  if($res)
				  {
					  return true;
				  }
				  else
					  return false;
		  	}
		}

		public function delete_chat($tablename)
		{
			$this->db->where('service_provider_id',5);
			$this->db->delete(TBLPREFIX.$tablename); 
		
			#return $query=$this->db->insert('birth',$data);
		}

		function getChat($service_provider_id)
		{				
			$this->db->select('u.full_name,u.user_fcm');
			// $this->db->from(TBLPREFIX.'chat_channels as c');
			// $this->db->join(TBLPREFIX.'users as sp','sp.user_id=c.service_provider_id','left');
			$this->db->from(TBLPREFIX.'users as u');
			// $this->db->order_by('c.chat_id','DESC');
            $this->db->where('u.user_id',$service_provider_id);
			
			return $this->db->get()->row();
		}
		
	}	
	/* End of file Feedbacksmodel.php */
	/* Location: ./application/models/Feedbacksmodel.php */
?>