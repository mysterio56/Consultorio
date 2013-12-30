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


    		$consultorio = new Consultorio();


    	if($this->input->post()){

    		$consultorio = new Consultorio();

    		$consultorio->where(array('id' => $this->session->userdata('id_consultorio')))->get();

			$permisos = permisos($this->session->userdata('type_user'));
    		
    		if($this->input->post('codigo')){

    			$consultorio->pacientes->where('codigo',$this->input->post('codigo'));
    			$consultorio->pacientes->order_by(' codigo ');

    		}

    		if($this->input->post('nombre')){

    			$consultorio->pacientes->where('nombre',$this->input->post('nombre'));
    			$consultorio->pacientes->order_by(' codigo ');
    		}
    		if($this->input->post('Codigo')){

    			$consultorio->pacientes->where('codigo like "%'.$_POST['Codigo'].'%"');
    			$consultorio->pacientes->order_by(' codigo ', 'ASC ');

    		}
    		
    		if($this->input->post('Nombre')){

    			$consultorio->pacientes->where('nombre like "%'.$_POST['Nombre'].'%"');
    			$consultorio->pacientes->order_by(' codigo ');
    		}
    		if($this->input->post('Apellido_p')){

    			$consultorio->pacientes->where('apellido_p like "%'.$_POST['Apellido_p'].'%"');
    			$consultorio->pacientes->order_by(' codigo ');
    		}
    		if($this->input->post('Apellido_m')){

    			$consultorio->pacientes->where('apellido_m like "%'.$_POST['Apellido_m'].'%"');
    			$consultorio->pacientes->order_by(' codigo ');
    		}
    		if($this->input->post('estatus')){

    			$consultorio->pacientes->where_in('estatus',$this->input->post('estatus'));	
    			$consultorio->pacientes->order_by(' estatus ');
    			$consultorio->pacientes->order_by(' codigo ');
    			   			
    		} else {

    			$consultorio->pacientes->where('estatus <> 2');
    		}


			if($this->input->post('fecha_alta')){

    			$consultorio->pacientes->where('DATE(fecha_alta) = \''.$this->input->post('fecha_alta').'\'');
    			$consultorio->pacientes->order_by(' codigo ');
    			
    		}


    		if($this->input->post('buscarId')){

				$consultorio->pacientes->where('id' ,$this->input->post('buscarId'));
    			$consultorio->pacientes->order_by(' codigo ');
    			
    		}
    		
    		$oPacientes = $consultorio->pacientes->get_paged_iterated($page, 5);
    		
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

    			$aPacientes['page_total']    = $consultorio->pacientes->paged->total_pages;
    			$aPacientes['page_actual']   = $page;
    			$aPacientes['has_previous']  = $consultorio->pacientes->paged->has_previous;
    			$aPacientes['has_next']      = $consultorio->pacientes->paged->has_next;
    			$aPacientes['previous_page'] = $consultorio->pacientes->paged->previous_page;
    			$aPacientes['next_page']     = $consultorio->pacientes->paged->next_page;

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
		$estatus_actual = $paciente->estatus;

		if($paciente->estatus == 1){

			$paciente->estatus = 0;
			$status=0;

	
		} else{

			$paciente->estatus = 1;
			$status=1;
		}

		$paciente->fecha_modificacion = date("Y-m-d H:i:s");
		if($paciente->save()){

			echo json_encode(array('estatus' =>$status ,'id'=>$id_paciente));
		}else{

			echo json_encode(array('error' =>true ,'estatus'=>$estatus_actual,'id'=>$id_paciente));
		}

	}

	public function eliminar($id_paciente){

		$paciente = new Paciente();

		$paciente->where('id', $id_paciente)->get();

		$paciente->estatus    = 2;
		$paciente->fecha_baja = date("Y-m-d H:i:s");

		if($paciente->save()){

			echo json_encode(array('error'=>false, 'id'=>$id_paciente));
		}else{

			echo json_encode(array('error' =>true ));
		}

	}

	public function buscar($page = 1){

		$aPermisos = permisos($this->session->userdata('type_user'));

    	$data['permisos'] = $aPermisos['patient'];
		$data['view']     = 'sistema/pacientes/buscar';
		$data['return']   = 'patient';
		$data['cssFiles'] = array('jquery-ui/jquery-ui.css',
								  'sistema.css');
		$data['jsFiles']  = array('jquery.js',
							      'jquery-ui.js',
							      'jquery.ui.datepicker-es.js',
							      'valid_forms.js');
		
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
