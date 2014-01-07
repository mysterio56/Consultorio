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
    		

			$permisos = permisos($this->session->userdata('type_user'));

			
			if($this->input->post('codigo')){

    			$especialidades->where('codigo',$this->input->post('codigo'));
    			$especialidades->order_by(' codigo ', 'ASC ');

    		}
    		if($this->input->post('nombre')){

    			$especialidades->where('nombre',$this->input->post('nombre'));
    			$especialidades->order_by(' codigo ', 'ASC ');

    		}

    		if($this->input->post('Codigo')){

    			$especialidades->where('codigo like "%'.$_POST['Codigo'].'%"');
    			$especialidades->order_by(' codigo ', 'ASC ');

    		}
    		
    		if($this->input->post('estatus')){

    			$especialidades->where_in('estatus',$this->input->post('estatus'));	
    			   			
    		} else {

    			$especialidades->where('estatus <> 2');
    		}

    		if($this->input->post('Nombre')){

    			$especialidades->where('nombre like "%'.$_POST['Nombre'].'%"');
    			
    		}
			 	    	
    		if($this->input->post('fecha_alta')){

    			$especialidades->where('DATE(fecha_alta) = \''.$this->input->post('fecha_alta').'\'');
    			
    		}

    		if($this->input->post('buscarId')){

				$especialidades->where('id' ,$this->input->post('buscarId'));
    			
    			
			}


    		$oEspecialidades = $especialidades->get_paged_iterated($page, 5);
    		
    		foreach( $oEspecialidades as $nKey => $especialidad){	

		    	$aEspecialidades['data'][$nKey] = array("id"      	=> $especialidad->id,
		    								   			"codigo"  	=> $especialidad->codigo,
		    								   			"nombre"  	=> $especialidad->nombre,
		    								   			"fecha_alt" => date("d",strtotime($especialidad->fecha_alta))."/".
		    								   				           month(date("m",strtotime($especialidad->fecha_alta))-1,false)."/".
		    								   				           date("Y",strtotime($especialidad->fecha_alta)),
		    								   			"fecha_alta_value"=> $especialidades->fecha_alta,
		    								   			"estatus"   => $especialidad->estatus,
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

    	$nCodigo = new Especialidad();

    	$nCodigo->where('consultorio_id', $this->session->userdata('id_consultorio'))->get();
		$nCodigo = $nCodigo->count() + 1;

    	$data['view']     	  = 'sistema/especialidades/agregar';
		$data['return']       = 'specialism';
		$data['nCodigo']      = $nCodigo;
		$data['cssFiles']     = array('sistema.css');
		$data['jsFiles']      = array('jquery.js',
							     	  'jquery-validation/dist/jquery.validate.js',
								      'jquery-validation/localization/messages_es.js',
								      'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){

			$especialidad = new Especialidad();

			$especialidad->codigo         = $this->input->post('codigo'); 
			$especialidad->nombre         = $this->input->post('nombre');
			$especialidad->descripcion    = $this->input->post('descripcion');
			$especialidad->fecha_alta     = date("Y-m-d H:i:s");
			$especialidad->consultorio_id = $this->session->userdata('id_consultorio');
			$especialidad->estatus        = 1;

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
			$especialidad->descripcion        = $this->input->post('descripcion');
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
			echo json_encode(array('error' =>false ,'id'=>$id_especialidad));
		}else{
			echo json_encode(array('error' =>true));

		}

	}


	public function status($id_especialidad){

		$especialidad = new Especialidad();

		$especialidad->where('id', $id_especialidad)->get();

		$estatus_actual=$especialidad->estatus;

		if($especialidad->estatus == 1){

			$especialidad->estatus    = 0;
			$status=0;
	
		} else{

			$especialidad->estatus    = 1;
			$status=1;
		}
		
		$especialidad->fecha_baja = date("Y-m-d H:i:s");
		
		if($especialidad->save()){

			echo json_encode(array('estatus' =>$status ,'id'=>$id_especialidad));
		}else{
			echo json_encode(array('error'=>false,'estatus' =>$estatus_actual ,'id'=>$id_especialidad ));
		}

	}

	public function buscar($page = 1){

		$aPermisos = permisos($this->session->userdata('type_user'));

    	$data['permisos'] = $aPermisos['specialism'];
		$data['view']     = 'sistema/especialidades/buscar';
		$data['return']   = 'specialism';
		$data['cssFiles'] = array('jquery-ui/jquery-ui.css',
								  'sistema.css');
		$data['jsFiles']  = array('jquery.js',
							      'jquery-ui.js',
							      'jquery.ui.datepicker-es.js',
							      'valid_forms.js');
		
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