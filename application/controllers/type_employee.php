<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Type_employee extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('id_user'));
    }

	public function index($page = 1){

    	$tipoEmpleados = new Tipo_empleado();
		$aPermisos = permisos($this->session->userdata('id_user'));

		$tipoEmpleados->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
								    'estatus <>'     => 2));

		$tipoEmpleados->order_by('codigo');
    
    	$tipoEmpleados->get_paged_iterated($page, 9);

		$data['permisos']      = $aPermisos['type_employee'];
		$data['paginaActual']  = $page;
		$data['tipoEmpleados'] = $tipoEmpleados;
		$data['view']          = 'sistema/tipo_empleado/lista';
		$data['cssFiles']      = array('sistema.css');
		$data['jsFiles']       = array('valid_forms.js');
		if($this->input->post()){

			$tipoEmpleados = new Tipo_empleado();
			
			$aPermisos = permisos($this->session->userdata('id_user'));
			$input_count = 0;

			foreach ($this->input->post() as $input_name => $input) {
				if($input_name != 'buscar' && $input_name != 'fecha_alta_value' && $input != ''){
			 		$tipoEmpleados->like($input_name, $input);
			 		$input_count++;
			 	}
			 } 
			if($input_count > 0){

				$tipoEmpleados->order_by('codigo');
				$tipoEmpleados->get_paged_iterated($page, 8);

				$data['permisos']     = $aPermisos['type_employee'];
				$data['paginaActual'] = $page;
				$data['tipoEmpleados']= $tipoEmpleados;
				$data['buscar']       = true;

			}

		}
		$this->load->view('sistema/template',$data);
    }

    public function agregar(){

    	$tipoEmpleado = new Tipo_empleado();

    	$data['view']     	  = 'sistema/tipo_empleado/agregar';
		$data['return']       = 'type_employee';
		$data['cssFiles']     = array('sistema.css');
		$data['jsFiles']      = array('jquery.js',
							     	  'jquery-validation/dist/jquery.validate.js',
								      'jquery-validation/localization/messages_es.js',
								      'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){

			$tipoEmpleado->codigo         = $this->input->post('codigo'); 
			$tipoEmpleado->nombre         = $this->input->post('nombre');
			$tipoEmpleado->fecha_alta     = date("Y-m-d H:i:s");
			$tipoEmpleado->consultorio_id =  $this->session->userdata('id_consultorio');
			$tipoEmpleado->estatus        = 1;

			if($tipoEmpleado->save()){

				redirect(base_url('type_employee'));

			} else {

				echo $tipoEmpleado->error->string;
				
			}

		}

    }

    public function editar($id_tipoEmpleado){

    	$tipoEmpleado = new Tipo_empleado();

		$data['tipoEmpleado'] = $tipoEmpleado->where('id',$id_tipoEmpleado)->get();
		$data['return']       = 'type_employee'; 		
		$data['view']         = 'sistema/tipo_empleado/editar';
		$data['cssFiles']     = array('sistema.css');
		$data['jsFiles']      = array('jquery.js',
							   	      'jquery-validation/dist/jquery.validate.js',
								      'jquery-validation/localization/messages_es.js',
								      'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){

			$tipoEmpleado->codigo             = $this->input->post('codigo'); 
			$tipoEmpleado->nombre             = $this->input->post('nombre');
			$tipoEmpleado->fecha_modificacion = date("Y-m-d H:i:s");

			if($tipoEmpleado->save()){

				redirect(base_url('type_employee'));
				
			} else {

				echo $tipoEmpleado->error->string;

			}

		}
	}


public function eliminar($id_tipoEmpleado){

		$tipoEmpleado = new Tipo_empleado();

		$tipoEmpleado->where('id', $id_tipoEmpleado)->get();

		$tipoEmpleado->estatus    = 2;
		$tipoEmpleado->fecha_baja = date("Y-m-d H:i:s");

		if($tipoEmpleado->save()){

			redirect(base_url('type_employee'));
		} else {
			echo $tipoEmpleado->error->string;

		}

	}



	public function status($id_tipoEmpleado){

		$tipoEmpleado = new Tipo_empleado();

		$tipoEmpleado->where('id', $id_tipoEmpleado)->get();

		if($tipoEmpleado->estatus == 1){

			$tipoEmpleado->estatus    = 0;
			$tipoEmpleado->fecha_baja = '0000-00-00 00:00:00';
	
		} else{

			$tipoEmpleado->fecha_baja = date("Y-m-d H:i:s");
			$tipoEmpleado->estatus    = 1;

		}
		
		$tipoEmpleado->save();

		redirect(base_url('type_employee'));

	}


   public function buscar($page = 1){

		$data['view']     = 'sistema/tipo_empleado/buscar';
		$data['return']   = 'type_employee';
		$data['cssFiles'] = array('jquery-ui/jquery-ui.css',
								  'sistema.css');
		$data['jsFiles']  = array('jquery.js',
							      'jquery-ui.js',
							      'jquery.ui.datepicker-es.js',
							      'valid_forms.js');

		if($this->input->post()){

			$tipoEmpleados = new Tipo_empleado();
			
			$aPermisos = permisos($this->session->userdata('id_user'));
			$input_count = 0;

			foreach ($this->input->post() as $input_name => $input) {
				if($input_name != 'buscar' && $input_name != 'fecha_alta_value' && $input != ''){
			 		$tipoEmpleados->like($input_name, $input);
			 		$input_count++;
			 	}
			 } 
			if($input_count > 0){

				$tipoEmpleados->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
									        'estatus <>'     => 2));

				$tipoEmpleados->order_by('codigo');
				$tipoEmpleados->get_paged_iterated($page, 8);

				$data['permisos']     = $aPermisos['type_employee'];
				$data['paginaActual'] = $page;
				$data['tipoEmpleados']= $tipoEmpleados;
				$data['buscar']       = true;

			}

		}

		$this->load->view('sistema/template',$data);

	}
}