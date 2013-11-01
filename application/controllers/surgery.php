<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Surgery extends CI_Controller{

	public function editar($id_consultorio = null){

		$consultorio = new Consultorio();

		$data['consultorio'] = $consultorio->where('id', $this->session->userdata('id_consultorio'))->get();
		$data['view']        = 'sistema/consultorio/editar';
		$data['cssFiles']    = array('sistema.css');
		$data['jsFiles']     = array('jquery.js',
							   		 'jquery-validation/dist/jquery.validate.js',
								  	 'jquery-validation/localization/messages_es.js',
								  	 'valid_forms.js');

		$this->load->view('sistema/template',$data);


		if($this->input->post()){

			$consultorio->nombre              = $this->input->post('nombre');
			$consultorio->telefono1           = $this->input->post('telefono1');
			$consultorio->telefono2           = $this->input->post('telefono2');
			$consultorio->email               = $this->input->post('email');
			$consultorio->fecha_modificacion  = date("Y-m-d H:i:s");
			$consultorio->tipo_consultorio_id = 1;

			$consultorio->save();

		}

	}

}