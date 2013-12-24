<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Format extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('type_user'));
    }

	public function index(){

    	$consultorio = new Consultorio();
    	$formatos    = new Formato();
		$aPermisos = permisos($this->session->userdata('type_user'));

		$consultorio->where(array('id' => $this->session->userdata('id_consultorio')))->get();

		$data['permisos'] = $aPermisos['format'];
    	$data['view']	  =	'sistema/formato/lista';
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
    		$formatos   = new Formato();


    		$consultorio->where(array('consultorio_id' => $this->session->userdata('id_consultorio')));
    		

			$permisos = permisos($this->session->userdata('type_user'));

			
			if($this->input->post('codigo')){

    			$formatos->where('codigo',$this->input->post('codigo'));
    			$formatos->order_by(' codigo ', 'ASC ');

    		}

    		if($this->input->post('nombre')){

    			$formatos->where('nombre',$this->input->post('nombre'));
    			
    		}

    		if($this->input->post('Codigo')){

    			$formatos->where('codigo like "%'.$_POST['Codigo'].'%"');
    			$formatos->order_by(' codigo ', 'ASC ');

    		}
    		
    		if($this->input->post('Nombre')){

    			$formatos->where('nombre like "%'.$_POST['Nombre'].'%"');
    			
    		}

    		if($this->input->post('estatus')){

    			$formatos->where_in('estatus',$this->input->post('estatus'));	
    			   			
    		} else {

    			$formatos->where('estatus <> 2');
    		}


    		if($this->input->post('fecha_alta')){

    			$formatos->where('fecha_alta',$this->input->post('fecha_alta'));
    			
    		}

    		if($this->input->post('buscarId')){

				$formatos->where('id' ,$this->input->post('buscarId'));
    			
    					}
    		
    		
    		$oFormatos = $formatos->get_paged_iterated($page, 5);
    		
    		foreach( $oFormatos as $nKey => $formato){	

		    	$aFormatos['data'][$nKey] = array("id"        => $formato->id,
		    								   	  "codigo"    => $formato->codigo,
		    								   	  "nombre"    => $formato->nombre,
		    								   	  "fecha_alt" => date("d",strtotime($formato->fecha_alta))." / ".
		    								   				     month(date("m",strtotime($formato->fecha_alta))-1,false)." / ".
		    								   				     date("Y",strtotime($formato->fecha_alta)),
		    								   	  "estatus"   => $formato->estatus,
		    								   	  "activar"   => in_array($permisos['specialism'],aPermisos('Editar'))?true:false,
		    								      "editar"    => in_array($permisos['specialism'],aPermisos('Editar'))?true:false,
		    								      "eliminar"  => in_array($permisos['specialism'],aPermisos('Eliminar'))?true:false
		    										  );  
				
    		}

    		if(isset($aFormatos)){

    			$aFormatos['page_total']    = $formatos->paged->total_pages;
    			$aFormatos['page_actual']   = $page;
    			$aFormatos['has_previous']  = $formatos->paged->has_previous;
    			$aFormatos['has_next']      = $formatos->paged->has_next;
    			$aFormatos['previous_page'] = $formatos->paged->previous_page;
    			$aFormatos['next_page']     = $formatos->paged->next_page;

				echo json_encode($aFormatos);

			} else {

				echo json_encode(array('empty' => true)); 

			}

    	}

    }


    public function agregar(){
        
        $consultorio = new Consultorio();
    	$formato     = new Formato();

    	$data['view']     = 'sistema/formato/agregar';
		$data['return']   = 'format';
		$data['cssFiles'] = array('sistema.css');
		$data['jsFiles']  = array('jquery.js',
						    	  'jquery-validation/dist/jquery.validate.js',
							      'jquery-validation/localization/messages_es.js',
							      'autoNumeric.js',
							      'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){

			$formato->codigo         = $this->input->post('codigo'); 
			$formato->nombre         = $this->input->post('nombre');
			$formato->fecha_alta     = date("Y-m-d H:i:s");
			$formato->estatus        = 1;

			$consultorio->where_in('id',$this->session->userdata('id_consultorio'))->get();

			if($formato->save($consultorio->all)){

				redirect(base_url('format'));

			} else {

				echo $formato->error->string;
				
			}

		}

    }

    public function editar($id_formato){

    	$formato     = new Formato();

    	$formato->where('id',$id_formato)->get();
    
		$data['formato']  = $formato; 
		$data['return']   = 'format'; 		
		$data['view']     = 'sistema/formato/editar';
		$data['cssFiles'] = array('sistema.css');
		$data['jsFiles']  = array('jquery.js',
						   	      'jquery-validation/dist/jquery.validate.js',
							      'jquery-validation/localization/messages_es.js',
							      'autoNumeric.js',
							      'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){

			$formato->codigo             = $this->input->post('codigo'); 
			$formato->nombre             = $this->input->post('nombre');
			$formato->fecha_modificacion = date("Y-m-d H:i:s");

			if($formato->save()){

				redirect(base_url('format'));
				
			} else {

				echo $formato->error->string;

			}

		}
	}


public function eliminar($id_formato){

		$formato = new Formato();

		$formato->where('id', $id_formato)->get();

		$formato->estatus    = 2;
		$formato->fecha_baja = date("Y-m-d H:i:s");

		if($formato->save()){

			redirect(base_url('format'));
		} else {
			echo $formato->error->string;

		}

	}



	public function status($id_formato){

		$formato = new Formato();

		$formato->where('id', $id_formato)->get();

		if($formato->estatus == 1){

			$formato->estatus    = 0;
			$formato->fecha_modificacion = '0000-00-00 00:00:00';
	
		} else{

			$formato->fecha_modificacion = date("Y-m-d H:i:s");
			$formato->estatus    = 1;

		}
		
		$formato->save();

		redirect(base_url('format'));

	}


   public function buscar($page = 1){

   		$aPermisos = permisos($this->session->userdata('type_user'));
		$data['permisos'] = $aPermisos['format'];
		$data['view']     = 'sistema/formato/buscar';
		$data['return']   = 'format';
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
		$formatos   = new Formato();	

		$consultorio->where(array('id' => $this->session->userdata('id_consultorio')))->get();
			
        $formatos->where('CONCAT( codigo, "  " , nombre ) like "%'.$_GET['term'].'%"')->get();
		
		$aFormatos = array();		

		foreach($formatos as $format){
			 $aFormatos[] = array("Id"    => $format->id, 
			 					  "label" => $format->codigo ." ". $format->nombre,
			 					  "value" => $format->codigo ." ". $format->nombre);
		}
		
		echo json_encode($aFormatos);

	}

}
