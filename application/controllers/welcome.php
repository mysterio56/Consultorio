<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
       //if (!$this->session->userdata('username')){ redirect(base_url().'login'); }
    }

	public function index()
	{
		$data['title'] = "welcome page";
		$data['view']  = "welcome";
		$this->load->view('template',$data);
	}

}