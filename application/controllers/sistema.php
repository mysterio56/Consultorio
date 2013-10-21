<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sistema extends CI_Controller{

	public function __contruct(){
		parent::__consturct();
	}

	public function index(){

		$data['view'] = 'sistema/tab1';
		$data['cssFiles'] = array('styles.css');

		$this->load->view('sistema/template',$data);

	}

	public function usuarios(){

		$data['view'] = 'sistema/tab2';
		$data['cssFiles'] = array('styles.css');

		$this->load->view('sistema/template',$data);
	}

}