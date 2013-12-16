<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Specialism extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('type_user'));
    }
   
    public function index(){
    
    	$especialidades = new Especialidad();
    	
    	$aPermisos = permisos($this->session->userdata('type_user'));

    	$data['permisos'] = $aPermisos['specialism'];
    	$data['view']	  =	'sistema/especialidades/lista';
    	$data['cssFiles'] = array('sistema.css',
								  'jquery-ui/jquery-ui.css');
		$data['jsFiles']  = array('jquery.js',
							      'jquery-ui.js',
							      'valid_forms.js');


    	$this->load->view('sistema/template',$data);
    }

    public function grid($page = 1){


    		$especialidades = new Especialidad();

    	if($this->input->post()){

    		$especialidades = new Especialidad();

    		$especialidades->where(array('consultorio_id' => $this->session->userdata('id_consultorio')));
    		$especialidades->where('estatus <> 2');

			$permisos = permisos($this->session->userdata('type_user'));

			
			if($this->input->post('codigo')){

    			$especialidades->where('codigo',$this->input->post('codigo'));
    			$especialidades->order_by(' codigo ', 'ASC ');

    		}

    		if($this->input->post('nombre')){

    			$especialidades->where('nombre',$this->input->post('nombre'));
    			
    		}

    		if($this->input->post('fecha_alt')){

    			$especialidades->where('fecha_alta',$this->input->post('fecha_alt'));
    			
    		}

    		if($this->input->post('buscarId')){

				$especialidades->where('id' ,$this->input->post('buscarId'));
    			
    			
			}
    		
    		$data['buscar']   = true;
    		$oEspecialidades = $especialidades->get_paged_iterated($page, 5);
    		
    		foreach( $oEspecialidades as $nKey => $especialidad){	

		    	$aEspecialidades['data'][$nKey] = array("id"      	=> $especialidad->id,
		    								   			"codigo"  	=> $especialidad->codigo,
		    								   			"nombre"  	=> $especialidad->nombre,
		    								   			"fecha_alt" => date("d",strtotime($especialidad->fecha_alta))."/".
		    								   				           month(date("m",strtotime($especialidad->fecha_alta)),false)."/".
		    								   				           date("Y",strtotime($especialidad->fecha_alta)),
		    								   			"estatus"   => $especialidad->estatus,
		    								   			"activar"   => in_array($permisos['specialism'],aPermisos('Editar'))?true:false,
		    								    	    "editar"    => in_array($permisos['specialism'],aPermisos('Editar'))?true:false,
		    								    	    "eliminar"  => in_array($permisos['specialism'],aPermisos('Eliminar'))?true:false
		    										  );  
				
    		}

    		if(isset($aEspecialidades)){

    			$aEspecialidades['page_total']    = $especialidades->paged->total_pages;
    			$aEspecialidades['page_actual']   = $page;
    			$aEspecialidades['has_previous']  = $especialidades->paged->has_previous;
    			$aEspecialidades['has_next']      = $especialidades->paged->has_next;
    			$aEspecialidades['previous_page'] = $especialidades->paged->previous_page;
    			$aEspecialidades['next_page']     = $especialidades->paged->next_page;

				echo json_encode($aEspecialidades);

			} else {

				echo json_encode(array('empty' => true)); 

			}

    	}

    }
    public function agregar(){

    	$especialidad = new Especialidad();

    	$data['view']     	  = 'sistema/especialidades/agregar';
		$data['return']       = 'specialism';
		$data['cssFiles']     = array('sistema.css');
		$data['jsFiles']      = array('jquery.js',
							     	  'jquery-validation/dist/jquery.validate.js',
								      'jquery-validation/localization/messages_es.js',
								      'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){

			$especialidad->codigo     = $this->input->post('codigo'); 
			$especialidad->nombre     = $this->input->post('nombre');
			$especialidad->fecha_alta = date("Y-m-d H:i:s");
			$especialidad->consultorio_id = $this->session->userdata('id_consultorio');
			$especialidad->estatus    = 1;

			if($especialidad->save()){

				redirect(base_url('specialism'));

			} else {

				echo $especialidad->error->string;
				
			}

		}

    }

    public function editar($id_especialidad){

    	$especialidad = new Especialidad();

		$data['especialidad'] = $especialidad->where('id',$id_especialidad)->get();
		$data['return']       = 'specialism'; 		
		$data['view']         = 'sistema/especialidades/editar';
		$data['cssFiles']     = array('sistema.css');
		$data['jsFiles']      = array('jquery.js',
							   	      'jquery-validation/dist/jquery.validate.js',
								      'jquery-validation/localization/messages_es.js',
								      'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){

			$especialidad->codigo             = $this->input->post('codigo'); 
			$especialidad->nombre             = $this->input->post('nombre');
			$especialidad->fecha_modificacion = date("Y-m-d H:i:s");

			if($especialidad->save()){

				redirect(base_url('specialism'));
				
			} else {

				echo $especialidad->error->string;

			}

		}
	}

public function eliminar($id_especialidad){

		$especialidad = new Especialidad();

		$especialidad->where('id', $id_especialidad)->get();

		$especialidad->estatus    = 2;
		$especialidad->fecha_baja = date("Y-m-d H:i:s");

		if($especialidad->save()){

			redirect(base_url('specialism'));
		} else {
			echo $especialidad->error->string;

		}

	}


	public function status($id_especialidad){

		$especialidad = new Especialidad();

		$especialidad->where('id', $id_especialidad)->get();

		if($especialidad->estatus == 1){

			$especialidad->estatus    = 0;
			$especialidad->fecha_baja = '0000-00-00 00:00:00';
	
		} else{

			$especialidad->fecha_baja = date("Y-m-d H:i:s");
			$especialidad->estatus    = 1;

		}
		
		$especialidad->save();

		redirect(base_url('specialism'));

	}

	public function buscar($page = 1){

		$data['view']     = 'sistema/especialidades/buscar';
		$data['return']   = 'specialism';
		$data['cssFiles'] = array('jquery-ui/jquery-ui.css',
								  'sistema.css');
		$data['jsFiles']  = array('jquery.js',
							      'jquery-ui.js',
							      'jquery.ui.datepicker-es.js',
							      'valid_forms.js');

		if($this->input->post()){

			$especialidades = new Especialidad();
			
			$aPermisos = permisos($this->session->userdata('type_user'));
			$input_count = 0;

			foreach ($this->input->post() as $input_name => $input) {
				if($input_name != 'buscar' && $input_name != 'fecha_alta_value' && $input != '' && $input_name != 'estatus'){
			 		$especialidades->like($input_name, $input);
			 		$input_count++;
			 	}
			 	if($input_name == 'estatus'){
			  		$especialidades->where_in('estatus', $this->input->post('estatus'));
			  		$input_count++;			  
			 	}
			 } 
			if($input_count > 0){

				$especialidades->where(array('consultorio_id' => $this->session->userdata('id_consultorio')));
				$especialidades->order_by('estatus');					    
				$especialidades->order_by('codigo');
				$especialidades->get_paged_iterated($page, 6);

				$data['permisos']     = $aPermisos['specialism'];
				$data['paginaActual'] = $page;
				$data['especialidades']= $especialidades;
				$data['buscar']       = true;

			}

		}

		$this->load->view('sistema/template',$data);

	}

	public function lista(){

		$especialidad = new Especialidad();

		$especialidad->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
								   'estatus'       => 1));

		$especialidad->where('CONCAT( codigo, "  " , nombre ) like "%'.$_GET['term'].'%"')->get();
		
		$aEspecialidad = array();

		foreach($especialidad as $specialism){
			 $aEspecialidad[] = array("Id"    => $specialism->id, 
			 					  	  "label" => $specialism->codigo ." ". $specialism->nombre,
			 					  	  "value" => $specialism->codigo ." ". $specialism->nombre);
		}
		
		echo json_encode($aEspecialidad);

	}

}