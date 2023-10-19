<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
	
	public function __construct() 
	{
		//call CodeIgniter's default Constructor
		parent::__construct();
		$this->load->model('Home_model');
	}
	
	public function index()
	{
		$data['title']='Home';
		$this->load->view('frontend/front_header',$data);
		$this->load->view('frontend/home',$data);
		$this->load->view('frontend/front_footer',$data);
	}
	
	public function newindex()
	{ 
		$data['title']='Home';
		$this->load->view('frontend/front_header',$data);
		$this->load->view('frontend/oldhome',$data);
		$this->load->view('frontend/front_footer',$data);
	}
	
	public function maps()
	{
		if(! $this->session->userdata('logged_in'))
		{
			redirect('Login', 'refresh');
		}
		$data['title']='Home';
		$data['ltlnInfo']=$this->Home_model->getLatLongInfo();
		$data['TimeAltInfo']=$this->Home_model->getTimeAlt();
		$this->load->view('frontend/front_header',$data);
		//$this->load->view('frontend/mapsviewdata',$data);
		//$this->load->view('frontend/maps_recent',$data);
		$this->load->view('frontend/maps_recent_new',$data);
		//$this->load->view('frontend/mapsview',$data);
		$this->load->view('frontend/front_footer',$data);
	}
	
	public function linechart()
	{
		if(! $this->session->userdata('logged_in'))
		{
			redirect('Login', 'refresh');
		}
		$data['title']='Home';
		//$data['ltlnInfo']=$this->Home_model->getLatLongInfo();
		$data['TimeAltInfo']=$this->Home_model->getTimeAlt();
		
		$this->load->view('frontend/front_header',$data);
		$this->load->view('frontend/linechart',$data);
		$this->load->view('frontend/front_footer',$data);
	}

	public function contact()
	{
		$data['title']='Contact';
		$data['ltlnInfo']=$this->Home_model->getLatLongInfo();
		$data['TimeAltInfo']=$this->Home_model->getTimeAlt();
		$this->load->view('frontend/front_header',$data);
		$this->load->view('frontend/mapsview',$data);
		$this->load->view('frontend/front_footer',$data);
	}
}