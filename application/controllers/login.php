<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller{

	public function index()
	{	
		
		if ($this->session->userdata('username')){ redirect(base_url('welcome')); }

		$data['title'] = "Login";
		$data['view']  = "login";
		$data['cssFiles'] = array('styles.css');
		
        $name      = $this->input->post('user_name');
		$password  = $this->input->post('password');

		$oUsuarios = new Usuario();
	    $oUsuarios->get();

	    $total = count($oUsuarios->all);

	    print_r($total);exit();

		if ($oUsuarios->save()) {
	        redirect('welcome');
    	} else {
        	$this->load->view('template',$data);
    	}
	}
	

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url().'login');
	}

}