<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('type_user'));
    }

	public function index($page = 1){

    	$servicios = new Servicio();
		$aPermisos = permisos($this->session->userdata('type_user'));

		$servicios->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
								'estatus <>'     => 2));

		$servicios->order_by('codigo');
    
    	$servicios->get_paged_iterated($page, 9);
    	

    	$data['permisos']      = $aPermisos['service'];
		$data['paginaActual']  = $page;
		$data['servicios']     = $servicios;
		$data['view']          = 'sistema/servicio/lista';
		$data['cssFiles']      = array('sistema.css');
		$data['jsFiles']       = array('valid_forms.js');
		if($this->input->post()){

			$servicios = new Servicio();
			
			$aPermisos = permisos($this->session->userdata('type_user'));
			$input_count = 0;

			foreach ($this->input->post() as $input_name => $input) {
				if($input_name != 'buscar' && $input_name != 'fecha_alta_value' && $input != ''){
			 		$servicios->like($input_name, $input);
			 		$input_count++;
			 	}
			 } 

			if($input_count > 0){
				$servicios->where('estatus <>', 2);
				$servicios->order_by('codigo');
				$servicios->get_paged_iterated($page, 8);

				$data['permisos']     = $aPermisos['service'];
				$data['paginaActual'] = $page;
				$data['servicios']    = $servicios;
				$data['buscar']       = true;

			}

		}
		$this->load->view('sistema/template',$data);
    }

    public function agregar(){

    	$servicio = new Servicio();

    	$data['view']     	  = 'sistema/servicio/agregar';
		$data['return']       = 'service';
		$data['cssFiles']     = array('sistema.css');
		$data['jsFiles']      = array('jquery.js',
							     	  'jquery-validation/dist/jquery.validate.js',
								      'jquery-validation/localization/messages_es.js',
								      'autoNumeric.js',
								      'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){

			$servicio->codigo         = $this->input->post('codigo'); 
			$servicio->nombre         = $this->input->post('nombre');
			$servicio->costo          = str_replace(",","",$this->input->post('costo'));
			$servicio->consultorio_id = $this->session->userdata('id_consultorio');
			$servicio->fecha_alta     = date("Y-m-d H:i:s");
			$servicio->estatus        = 1;

			if($servicio->save()){

				redirect(base_url('service'));

			} else {

				echo $servicio->error->string;
				
			}

		}

    }

    public function editar($id_servicio){

    	$servicio = new Servicio();

		$data['servicio'] = $servicio->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
											       'id'             => $id_servicio))->get();
		$data['return']       = 'service'; 		
		$data['view']         = 'sistema/servicio/editar';
		$data['cssFiles']     = array('sistema.css');
		$data['jsFiles']      = array('jquery.js',
							   	      'jquery-validation/dist/jquery.validate.js',
								      'jquery-validation/localization/messages_es.js',
								      'autoNumeric.js',
								      'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){

			$servicio->codigo             = $this->input->post('codigo'); 
			$servicio->nombre             = $this->input->post('nombre');
			$servicio->costo              = str_replace(",","",$this->input->post('costo'));
			$servicio->fecha_modificacion = date("Y-m-d H:i:s");

			if($servicio->save()){

				redirect(base_url('service'));
				
			} else {

				echo $servicio->error->string;

			}

		}
	}


public function eliminar($id_servicio){

		$servicio = new Servicio();

		$servicio->where('id', $id_servicio)->get();

		$servicio->estatus    = 2;
		$servicio->fecha_baja = date("Y-m-d H:i:s");

		if($servicio->save()){

			redirect(base_url('service'));
		} else {
			echo $servicio->error->string;

		}

	}



	public function status($id_servicio){

		$servicio = new Servicio();

		$servicio->where('id', $id_servicio)->get();

		if($servicio->estatus == 1){

			$servicio->estatus    = 0;
			$servicio->fecha_modificacion = '0000-00-00 00:00:00';
	
		} else{

			$servicio->fecha_modificacion = date("Y-m-d H:i:s");
			$servicio->estatus    = 1;

		}
		
		$servicio->save();

		redirect(base_url('service'));

	}


   public function buscar($page = 1){

		$data['view']     = 'sistema/servicio/buscar';
		$data['return']   = 'service';
		$data['cssFiles'] = array('jquery-ui/jquery-ui.css',
								  'sistema.css');
		$data['jsFiles']  = array('jquery.js',
							      'jquery-ui.js',
							      'jquery.ui.datepicker-es.js',
							      'valid_forms.js');

		if($this->input->post()){

			$servicios = new Servicio();
			
			$aPermisos = permisos($this->session->userdata('type_user'));
			$input_count = 0;

			foreach ($this->input->post() as $input_name => $input) {
				if($input_name != 'buscar' && $input_name != 'fecha_alta_value' && $input != ''){
			 		$servicios->like($input_name, $input);
			 		$input_count++;
			 	}
			 } 

			if($input_count > 0){

				$servicios->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
								        'estatus <>'     => 2)); 

				$servicios->order_by('codigo');

				$servicios->get_paged_iterated($page, 8);

				$data['permisos']     = $aPermisos['service'];
				$data['paginaActual'] = $page;
				$data['servicios']     = $servicios;
				$data['buscar']       = true;

			}

		}

		$this->load->view('sistema/template',$data);

	}
}