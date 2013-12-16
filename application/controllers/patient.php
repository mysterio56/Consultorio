<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Patient extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('type_user'));
    }
   public function index(){
    
    	$pacientes = new Paciente();
    	
    	$aPermisos = permisos($this->session->userdata('type_user'));

    	$data['permisos'] = $aPermisos['patient'];
    	$data['view']	  =	'sistema/pacientes/lista';
    	$data['cssFiles'] = array('sistema.css',
								  'jquery-ui/jquery-ui.css');
		$data['jsFiles']  = array('jquery.js',
							      'jquery-ui.js',
							      'valid_forms.js');



    	$this->load->view('sistema/template',$data);
    }

    public function grid($page = 1){


    		$pacientes = new Paciente();


    	if($this->input->post()){

    		$pacientes = new Paciente();
			$consultorio = new Consultorio();

    		$consultorio->where(array('id' => $this->session->userdata('id_consultorio')))->get();

			$permisos = permisos($this->session->userdata('type_user'));
    		
    		$pacientes->where('estatus <> 2');

			
			
			if($this->input->post('codigo')){

    			$pacientes->where('codigo',$this->input->post('codigo'));
    			$pacientes->order_by(' codigo ');

    		}

    		if($this->input->post('nombre')){

    			$pacientes->where('nombre',$this->input->post('nombre'));
    			
    		}

    		if($this->input->post('email')){
    			$pacientes->where('email',$this->input->post('email'));
    		}

    		if($this->input->post('telefono')){
    			$pacientes->where('telefono',$this->input->post('telefono'));
    		}

    		if($this->input->post('celular')){
    			$pacientes->where('celular',$this->input->post('celular'));
    		}

    		if($this->input->post('buscarId')){

				$pacientes->where('id' ,$this->input->post('buscarId'));
    		}
    		
    		$oPacientes = $pacientes->get_paged_iterated($page, 5);
    		
    		foreach( $oPacientes as $nKey => $paciente){	

		    	$aPacientes['data'][$nKey] = array("id"        => $paciente->id,
		    								   	   "codigo"    => $paciente->codigo,
		    								   	   "nombre"    => $paciente->nombre." ".$paciente->apellido_p." ".$paciente->apellido_m,
		    								   	   "email"	   => $paciente->email,
		    								   	   "telefono"  => $paciente->telefono,
		    								   	   "celular"   => $paciente->celular,
		    								   	   "estatus"   => $paciente->estatus,
		    								   	   "activar"   => in_array($permisos['patient'],aPermisos('Editar'))?true:false,
		    								       "editar"    => in_array($permisos['patient'],aPermisos('Editar'))?true:false,
		    								       "eliminar"  => in_array($permisos['patient'],aPermisos('Eliminar'))?true:false
		    										  );  
				
    		}

    		if(isset($aPacientes)){

    			$aPacientes['page_total']    = $pacientes->paged->total_pages;
    			$aPacientes['page_actual']   = $page;
    			$aPacientes['has_previous']  = $pacientes->paged->has_previous;
    			$aPacientes['has_next']      = $pacientes->paged->has_next;
    			$aPacientes['previous_page'] = $pacientes->paged->previous_page;
    			$aPacientes['next_page']     = $pacientes->paged->next_page;

				echo json_encode($aPacientes);

			} else {

				echo json_encode(array('empty' => true)); 

			}

    	}

    }
	public function agregar(){

		$direccion   = new Direccion();
    	$paciente    = new Paciente();
    	$consultorio = new Consultorio();

    	$consultorio->where('id', $this->session->userdata('id_consultorio'))->get();
		$nCodigo = $consultorio->paciente->count() + 1;

    	$data['view']     = 'sistema/pacientes/agregar';
		$data['return']   = 'patient';
		$data['nCodigo']  = $nCodigo; 
		$data['cssFiles'] = array('jquery-ui/jquery-ui.css',
								  'sistema.css');
		$data['jsFiles']  = array('jquery.js',
							      'jquery-ui.js',
							   	  'jquery-validation/dist/jquery.validate.js',
								  'jquery-validation/localization/messages_es.js',
								  'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){

			$paciente->codigo         = $this->input->post('codigo'); 
			$paciente->nombre         = $this->input->post('nombre');
			$paciente->apellido_p     = $this->input->post('apellido_p');
			$paciente->apellido_m     = $this->input->post('apellido_m');
			$paciente->email          = $this->input->post('email');
			$paciente->telefono       = $this->input->post('telefono');
			$paciente->celular        = $this->input->post('celular');
			$paciente->fecha_alta     = date("Y-m-d H:i:s");
			$paciente->estatus        = 1;

			$direccion->estado_id        = $this->input->post('estado');
			$direccion->municipio_id     = $this->input->post('municipio');
			$direccion->codigo_postal_id = $this->input->post('codigo_postal');
			$direccion->colonia_id       = $this->input->post('colonia');
			$direccion->calle            = $this->input->post('calle');
			$direccion->numero_int       = $this->input->post('numero_int');
			$direccion->numero_ext       = $this->input->post('numero_ext');

			$consultorio->where('id',$this->session->userdata('id_consultorio'))->get();

			$direccion->save();
			$paciente->direccion_id = $direccion->id;

			if($paciente->save($consultorio->all)){

				redirect(base_url('patient'));

			} else {

				echo $paciente->error->string;
				
			}

		}

    }

    public function editar($id_paciente){

    	$paciente = new Paciente();

		$paciente->where('id',$id_paciente)->get();
    	$paciente->direccion->get();

		$data['paciente'] = $paciente; 
		$data['return']   = 'patient'; 		
		$data['view']     = 'sistema/pacientes/editar';
		$data['cssFiles'] = array('jquery-ui/jquery-ui.css',
								  'sistema.css');
		$data['jsFiles']  = array('jquery.js',
							      'jquery-ui.js',
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

			$paciente->direccion->estado_id        = $this->input->post('estado');
			$paciente->direccion->municipio_id     = $this->input->post('municipio');
			$paciente->direccion->codigo_postal_id = $this->input->post('codigo_postal');
			$paciente->direccion->colonia_id       = $this->input->post('colonia');
			$paciente->direccion->calle            = $this->input->post('calle');
			$paciente->direccion->numero_int       = $this->input->post('numero_int');
			$paciente->direccion->numero_ext       = $this->input->post('numero_ext');

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
			
			$consultorio = new Consultorio();
			$consultorio->where(array('id' => $this->session->userdata('id_consultorio')))->get();

			$aPermisos = permisos($this->session->userdata('type_user'));
			$input_count = 0;

			foreach ($this->input->post() as $input_name => $input) {
				if($input_name != 'buscar' && $input_name != 'fecha_alta_value' && $input != '' && $input_name != 'estatus'){
			 		$consultorio->paciente->like($input_name, $input);
			 		$input_count++;
			 	}

			  	if($input_name == 'estatus'){
			  		$consultorio->paciente->where_in('estatus', $this->input->post('estatus'));
			  		$input_count++;			  
			 	}
			}

			 if($input_count > 0){

				$consultorio->paciente->order_by('estatus');
				$consultorio->paciente->order_by('codigo');
				$pacientes = $consultorio->paciente->get_paged_iterated($page, 8);
				
				$data['permisos']     = $aPermisos['patient'];
				$data['paginaActual'] = $page;
				$data['pacientes']	  = $pacientes;
				$data['buscar']       = true;

			}

		}

		$this->load->view('sistema/template',$data);

	} 

	public function lista(){

		$consultorio= new Consultorio();
				
		$consultorio->where('id',$this->session->userdata('id_consultorio'))->get();

		$consultorio->paciente->where('CONCAT( codigo,  "  " , nombre,  " " , apellido_p, " " , apellido_m ) like "%'.$_GET['term'].'%"');
		$consultorio->paciente->where('estatus',1)->get();
		$aPaciente = array();

		foreach($consultorio->paciente as $pacient){
			 $aPaciente[] = array("Id"        => $pacient->id, 
			 					  "label"     => $pacient->codigo .' '. $pacient->nombre .' '. $pacient->apellido_p .' '. $pacient->apellido_m,
			 					  "value"     => $pacient->codigo .' '. $pacient->nombre .' '. $pacient->apellido_p .' '. $pacient->apellido_m,);
		}
	
		echo json_encode($aPaciente);

	}
}
