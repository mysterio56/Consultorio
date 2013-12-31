<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Format extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('type_user'));
    }

	public function index(){

    	$formatos    = new Formato();
		$aPermisos = permisos($this->session->userdata('type_user'));

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

    		$consultorio->where(array('id' => $this->session->userdata('id_consultorio')))->get();

			$permisos = permisos($this->session->userdata('type_user'));
						
			if($this->input->post('codigo')){

    			$consultorio->formatos->where('codigo',$this->input->post('codigo'));
    			$consultorio->formatos->order_by(' codigo ', 'ASC ');

    		}

    		if($this->input->post('nombre')){

    			$consultorio->formatos->where('nombre',$this->input->post('nombre'));
    			$consultorio->formatos->order_by(' codigo ', 'ASC ');
    		}

    		if($this->input->post('Codigo')){

    			$consultorio->formatos->where('codigo like "%'.$_POST['Codigo'].'%"');
    			$consultorio->formatos->order_by(' codigo ', 'ASC ');

    		}
    		
    		if($this->input->post('Nombre')){

    			$consultorio->formatos->where('nombre like "%'.$_POST['Nombre'].'%"');
    			$consultorio->formatos->order_by(' codigo ', 'ASC ');
    		}

    		if($this->input->post('estatus')){

    			$consultorio->formatos->where_in('estatus',$this->input->post('estatus'));	
    			$consultorio->formatos->order_by(' estatus ');
    			$consultorio->formatos->order_by(' codigo ', 'ASC ');   			
    		} else {

    			$consultorio->formatos->where('estatus <> 2');
    		}


    		if($this->input->post('fecha_alta')){

    			$consultorio->formatos->where('fecha_alta',$this->input->post('fecha_alta'));
    			$consultorio->formatos->order_by(' codigo ', 'ASC ');
    		}

    		if($this->input->post('buscarId')){

				$consultorio->formatos->where('id' ,$this->input->post('buscarId'));
    			$consultorio->formatos->order_by(' codigo ', 'ASC ');
    		}
    		
    		
    		$oFormatos = $consultorio->formatos->get_paged_iterated($page, 5);
    		
    		foreach( $oFormatos as $nKey => $formato){	

		    	$aFormatos['data'][$nKey] = array("id"        => $formato->id,
		    								   	  "codigo"    => $formato->codigo,
		    								   	  "nombre"    => $formato->nombre,
		    								   	  "fecha_alt" => date("d",strtotime($formato->fecha_alta))." / ".
		    								   				     month(date("m",strtotime($formato->fecha_alta))-1,false)." / ".
		    								   				     date("Y",strtotime($formato->fecha_alta)),
		    								   	  "estatus"   => $formato->estatus,
		    								   	  "editar"    => in_array($permisos['format'],aPermisos('Editar'))?true:false,
		    								      "eliminar"  => in_array($permisos['format'],aPermisos('Eliminar'))?true:false
		    										  );  
				
    		}

    		if(isset($aFormatos)){

    			$aFormatos['page_total']    = $consultorio->formatos->paged->total_pages;
    			$aFormatos['page_actual']   = $page;
    			$aFormatos['has_previous']  = $consultorio->formatos->paged->has_previous;
    			$aFormatos['has_next']      = $consultorio->formatos->paged->has_next;
    			$aFormatos['previous_page'] = $consultorio->formatos->paged->previous_page;
    			$aFormatos['next_page']     = $consultorio->formatos->paged->next_page;

				echo json_encode($aFormatos);

			} else {

				echo json_encode(array('empty' => true)); 

			}

    	}

    }


    public function agregar(){
        
        $consultorio = new Consultorio();
    	$formato     = new Formato();

    	$consultorio->where('id', $this->session->userdata('id_consultorio'))->get();
		$nCodigo = $consultorio->formato->count() + 1;

    	$data['view']     = 'sistema/formato/agregar';
		$data['return']   = 'format';
		$data['nCodigo']  = $nCodigo;
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
			$formato->descripcion    = $this->input->post('descripcion');
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
			$formato->descripcion    = $this->input->post('descripcion');
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

			echo json_encode(array('error'=>false,'id' => $id_formato));

		} else {

			echo json_encode(array('error'=>true));

		}
	}



	public function status($id_formato){

		$formato = new Formato();

		$formato->where('id', $id_formato)->get();
		
		$estatus_actual = $formato->estatus;


		if($formato->estatus == 1){

			$formato->estatus    = 0;
			$status=0;
	
		} else{

			$formato->estatus    = 1;
			$status=1;
		}
		
		$formato->fecha_modificacion = date("Y-m-d H:i:s");
		
		if($formato->save()){

			echo json_encode(array('estatus' => $status ,'id'=> $id_formato ));

		}else{
			echo json_encode(array('error' =>true,'estatus'=>$estatus_actual,'id'=>$id_formato));
		}

		
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
			

		$consultorio->where(array('id' => $this->session->userdata('id_consultorio')))->get();
			
        $consultorio->formatos->where('CONCAT( codigo, "  " , nombre ) like "%'.$_GET['term'].'%"')->get();
		
		$aFormatos = array();		

		foreach($consultorio->formatos as $format){
			 $aFormatos[] = array("Id"    => $format->id, 
			 					  "label" => $format->codigo ." ". $format->nombre,
			 					  "value" => $format->codigo ." ". $format->nombre);
		}
		
		echo json_encode($aFormatos);

	}

}
