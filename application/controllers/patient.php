<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Patient extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('id_user'));
    }

	public function index($page = 1){

    	$pacientes = new Paciente();
		$aPermisos = permisos($this->session->userdata('id_user'));

		$pacientes->order_by('nombre', 'ASC');
    
    	$pacientes->get_paged($page, 9);

		$pacientes->where('estatus <>',2)->get();

		$data['permisos']     = $aPermisos['patient'];
		$data['paginaActual'] = $page;
		$data['pacientes']    = $pacientes;
		$data['view']         = 'sistema/pacientes/lista';
		$data['cssFiles']     = array('sistema.css');
		$data['jsFiles']      = array('valid_forms.js');
		if($this->input->post()){
			$pacientes = new Paciente();
			$aPermisos = permisos($this->session->userdata('id_user'));
			$input_count = 0;

			foreach ($this->input->post() as $input_name => $input) {
				if($input_name != 'buscar' && $input_name != 'fecha_alta_value' && $input != ''){
			 		$pacientes->like($input_name, $input);
			 		$input_count++;
			 	}
			 } 
			if($input_count > 0){
				$pacientes->where('estatus <>', 2);
				$pacientes->order_by('nombre');
				$pacientes->get_paged_iterated($page, 8);

				$data['permisos']     = $aPermisos['patient'];
				$data['paginaActual'] = $page;
				$data['pacientes']	  = $pacientes;
				$data['buscar']       = true;

			}

		}

		$this->load->view('sistema/template',$data);

	}

	public function agregar(){
		$direccion = new Direccion();
    	$paciente = new Paciente();

    	$data['view']     	  = 'sistema/pacientes/agregar';
		$data['return']       = 'patient';
		$data['cssFiles']     = array('sistema.css');
		$data['jsFiles']      = array('jquery.js',
							     	  'jquery-validation/dist/jquery.validate.js',
								      'jquery-validation/localization/messages_es.js',
								      'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){

			$paciente->codigo     = $this->input->post('codigo'); 
			$paciente->nombre     = $this->input->post('nombre');
			$paciente->apellido_p = $this->input->post('apellido_p');
			$paciente->apellido_m = $this->input->post('apellido_m');
			$paciente->email      = $this->input->post('email');
			$paciente->telefono   = $this->input->post('telefono');
			$paciente->celular    = $this->input->post('celular');
			$paciente->fecha_alta = date("Y-m-d H:i:s");
			$paciente->estatus    = 1;

			$direccion->estado_id        = $this->input->post('estado');
			$direccion->municipio_id     = $this->input->post('municipio');
			$direccion->codigo_postal_id = $this->input->post('codigo_postal');
			$direccion->colonia_id       = $this->input->post('colonia');
			$direccion->calle            = $this->input->post('calle');
			$direccion->numero_int       = $this->input->post('numero_int');
			$direccion->numero_ext       = $this->input->post('numero_ext');

			$direccion->save();
			$paciente->direccion_id = $direccion->id;

			if($paciente->save()){

				redirect(base_url('patient'));

			} else {

				echo $paciente->error->string;
				
			}

		}

    }

    public function editar($id_paciente){

    	$paciente = new Paciente();

		$paciente->where('id',$id_paciente)->get();
    	$paciente->direccion-> get();

		$data['paciente'] = $paciente; 
		$data['return']   = 'patient'; 		
		$data['view']     = 'sistema/pacientes/editar';
		$data['cssFiles'] = array('sistema.css');
		$data['jsFiles']  = array('jquery.js',
							   	  'jquery-validation/dist/jquery.validate.js',
								  'jquery-validation/localization/messages_es.js',
								  'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){

			$paciente->codigo             = $this->input->post('codigo'); 
			$paciente->nombre             = $this->input->post('nombre');
			$paciente->apellido_p         = $this->input->post('apellido_p');
			$paciente->apellido_m         = $this->input->post('apellido_m');
			$paciente->email              = $this->input->post('email');
			$paciente->telefono           = $this->input->post('telefono');
			$paciente->celular            = $this->input->post('celular');
			$paciente->fecha_modificacion = date("Y-m-d H:i:s");

			$paciente->direccion->estado_id         = $this->input->post('estado');
			$paciente->direccion->municipio_id      = $this->input->post('municipio');
			$paciente->direccion->codigo_postal_id  = $this->input->post('codigo_postal');
			$paciente->direccion->colonia_id        = $this->input->post('colonia');
			$paciente->direccion->calle             = $this->input->post('calle');
			$paciente->direccion->numero_int        = $this->input->post('numero_int');
			$paciente->direccion->numero_ext        = $this->input->post('numero_ext');

			if($paciente->save() && $paciente->direccion->save()){

				redirect(base_url('patient'));
				
			} else {

				echo $paciente->error->string;

			}

		}

	}

	public function status($id_paciente){

		$paciente = new Paciente();

		$paciente->where('id', $id_paciente)->get();

		if($paciente->estatus == 1){

			$paciente->estatus = 0;
	
		} else{

			$paciente->estatus = 1;

		}

		$paciente->fecha_modificacion = date("Y-m-d H:i:s");
		$paciente->save();

		redirect(base_url('patient'));

	}

	public function eliminar($id_paciente){

		$paciente = new Paciente();

		$paciente->where('id', $id_paciente)->get();

		$paciente->estatus    = 2;
		$paciente->fecha_baja = date("Y-m-d H:i:s");

		$paciente->save();

		redirect(base_url('patient'));

	}

	public function buscar($page = 1){

		$data['view']     = 'sistema/pacientes/buscar';
		$data['return']   = 'patient';
		$data['cssFiles'] = array('jquery-ui/jquery-ui.css',
								  'sistema.css');
		$data['jsFiles']  = array('jquery.js',
							      'jquery-ui.js',
							      'jquery.ui.datepicker-es.js',
							      'valid_forms.js');
		if($this->input->post()){
			$pacientes = new Paciente();
			$aPermisos = permisos($this->session->userdata('id_user'));
			$input_count = 0;

			foreach ($this->input->post() as $input_name => $input) {
				if($input_name != 'buscar' && $input_name != 'fecha_alta_value' && $input != ''){
			 		$pacientes->like($input_name, $input);
			 		$input_count++;
			 	}
			 } 
			if($input_count > 0){
				$pacientes->where('estatus <>', 2);
				$pacientes->order_by('nombre');
				$pacientes->get_paged_iterated($page, 8);

				$data['permisos']     = $aPermisos['patient'];
				$data['paginaActual'] = $page;
				$data['pacientes']	  = $pacientes;
				$data['buscar']       = true;

			}

		}
		$this->load->view('sistema/template',$data);
	}	
}