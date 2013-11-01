<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	if (!$this->session->userdata('username')){ redirect(base_url().'login'); }
    }

	public function index()
	{

		$oUsuario = new Usuario();
		$oUsuario->where('id',$this->session->userdata('id_user'))->get();

		$data['modulos']  = $oUsuario->modulo->get()->all;
		$data['title']    = "welcome page";
		$data['view']     = "welcome";
		$data['cssFiles'] = array('styles.css');
		$data['jsFiles']  = array('jquery.js',
								  'main.js'); 
		
		$this->load->view('template',$data);

	}

}