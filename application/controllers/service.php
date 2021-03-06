<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('type_user'));
    }

	public function index(){
    
    	$servicios = new Servicio();
    	
    	$aPermisos = permisos($this->session->userdata('type_user'));

    	$data['permisos'] = $aPermisos['service'];
    	$data['view']	  =	'sistema/servicio/lista';
    	$data['cssFiles'] = array('sistema.css',
								  'jquery-ui/jquery-ui.css');
		$data['jsFiles']  = array('jquery.js',
							      'jquery-ui.js',
							      'valid_forms.js');


    	$this->load->view('sistema/template',$data);
    }

    public function grid($page = 1){


    		$servicios = new Servicio();

    	if($this->input->post()){

    		$servicios = new Servicio();

    		$servicios->where(array('consultorio_id' => $this->session->userdata('id_consultorio')));
    		

			$permisos = permisos($this->session->userdata('type_user'));

			
			if($this->input->post('codigo')){

    			$servicios->where('codigo',$this->input->post('codigo'));
    			$servicios->order_by(' codigo ', 'ASC ');

    		}

    		if($this->input->post('nombre')){

    			$servicios->where('nombre',$this->input->post('nombre'));
    			
    		}
    		if($this->input->post('Codigo')){

    			$servicios->where('codigo like "%'.$_POST['Codigo'].'%"');
    			$servicios->order_by(' codigo ', 'ASC ');

    		}
    		
    		if($this->input->post('Nombre')){

    			$servicios->where('nombre like "%'.$_POST['Nombre'].'%"');
    			
    		}

    		if($this->input->post('estatus')){

    			$servicios->where_in('estatus',$this->input->post('estatus'));	
    			   			
    		} else {

    			$servicios->where('estatus <> 2');
    		}
			
			if($this->input->post('fecha_alta')){

    			$servicios->where('DATE(fecha_alta) = \''.$this->input->post('fecha_alta').'\'');
    			
    		}
    		if($this->input->post('buscarId')){

				$servicios->where('id' ,$this->input->post('buscarId'));
    			
    			
			}
    		
    		$oServicios = $servicios->get_paged_iterated($page, 5);
    		
    		foreach( $oServicios as $nKey => $servicio){	

		    	$aServicios['data'][$nKey] = array("id"      	=> $servicio->id,
		    								   	   "codigo"  	=> $servicio->codigo,
		    								   	   "nombre"  	=> $servicio->nombre,
		    								   	   "fecha_alt"  => date("d",strtotime($servicio->fecha_alta))." / ".
		    								   	   	               month(date("m",strtotime($servicio->fecha_alta))-1,false)." / ".
		    								   	   	               date("Y",strtotime($servicio->fecha_alta)),
		    								   	   "estatus"   => $servicio->estatus,
		    								   	   "editar"    => in_array($permisos['service'],aPermisos('Editar'))?true:false,
		    								       "eliminar"  => in_array($permisos['service'],aPermisos('Eliminar'))?true:false
		    										  );  
				
    		}

    		if(isset($aServicios)){

    			$aServicios['page_total']    = $servicios->paged->total_pages;
    			$aServicios['page_actual']   = $page;
    			$aServicios['has_previous']  = $servicios->paged->has_previous;
    			$aServicios['has_next']      = $servicios->paged->has_next;
    			$aServicios['previous_page'] = $servicios->paged->previous_page;
    			$aServicios['next_page']     = $servicios->paged->next_page;

				echo json_encode($aServicios);

			} else {

				echo json_encode(array('empty' => true)); 

			}

    	}

    }

    public function agregar(){

    	$nCodigo = new Servicio();

    	$nCodigo->where('consultorio_id', $this->session->userdata('id_consultorio'))->get();
		$nCodigo = $nCodigo->count() + 1;

    	$data['view']     	  = 'sistema/servicio/agregar';
		$data['return']       = 'service';
		$data['nCodigo']      = $nCodigo;
		$data['cssFiles']     = array('sistema.css');
		$data['jsFiles']      = array('jquery.js',
							     	  'jquery-validation/dist/jquery.validate.js',
								      'jquery-validation/localization/messages_es.js',
								      'autoNumeric.js',
								      'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){

			$servicio = new Servicio();

			$servicio->codigo         = $this->input->post('codigo'); 
			$servicio->nombre         = $this->input->post('nombre');
			$servicio->descripcion    = $this->input->post('descripcion');
			$servicio->cita           = $this->input->post('cita');

			if ($this->input->post('servicios') == 1) {
				$servicio->costo_compra = 0.00;
				$servicio->costo_venta  = str_replace(",","",$this->input->post('costo_v'));
			}else if($this->input->post('servicios') == 2){
				$servicio->costo_venta = 0.00;
				$servicio->costo_compra   = str_replace(",","",$this->input->post('costo_c'));
			}else if($this->input->post('servicios') == 3){
				$servicio->costo_venta  = str_replace(",","",$this->input->post('costo_v'));
				$servicio->costo_compra   = str_replace(",","",$this->input->post('costo_c'));
			}
			
			$servicio->tipo           = $this->input->post('servicios'); 
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

			$servicio->codigo      = $this->input->post('codigo'); 
			$servicio->nombre      = $this->input->post('nombre');
			$servicio->descripcion = $this->input->post('descripcion');
			$servicio->cita        = $this->input->post('cita');

			if ($this->input->post('servicios') == 1) {
				$servicio->costo_compra = 0.00;
				$servicio->costo_venta  = str_replace(",","",$this->input->post('costo_v'));
			}else if($this->input->post('servicios') == 2){
				$servicio->costo_venta = 0.00;
				$servicio->costo_compra   = str_replace(",","",$this->input->post('costo_c'));
			}else if($this->input->post('servicios') == 3){
				$servicio->costo_venta  = str_replace(",","",$this->input->post('costo_v'));
				$servicio->costo_compra   = str_replace(",","",$this->input->post('costo_c'));
			}
			
			$servicio->tipo               = $this->input->post('servicios'); 
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

			echo json_encode(array('error'=>false,'id' => $id_servicio));

		} else {

			echo json_encode(array('error'=>true));

		}

	}



	public function status($id_servicio){

		$servicio = new Servicio();

		$servicio->where('id', $id_servicio)->get();

		$estatus_actual = $servicio->estatus;

		if($servicio->estatus == 1){

			$servicio->estatus    = 0;
			$status = 0;
	
		} else {

			$status = 1;
			$servicio->estatus    = 1;

		}

		$servicio->fecha_modificacion = date("Y-m-d H:i:s");
		
		if($servicio->save()){
			echo json_encode(array('estatus'=>$status,'id'=>$id_servicio));
		} else {
			echo json_encode(array('error'=>true,'estatus'=>$estatus_actual,'id'=>$id_servicio));
		}
	
	}


   public function buscar($page = 1){

   		$aPermisos = permisos($this->session->userdata('type_user'));

    	$data['permisos'] = $aPermisos['service'];
		$data['view']     = 'sistema/servicio/buscar';
		$data['return']   = 'service';
		$data['cssFiles'] = array('jquery-ui/jquery-ui.css',
								  'sistema.css');
		$data['jsFiles']  = array('jquery.js',
							      'jquery-ui.js',
							      'jquery.ui.datepicker-es.js',
							      'valid_forms.js');

		
		$this->load->view('sistema/template',$data);

	}

	public function lista(){

		$servicio = new Servicio();

		$servicio->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
								'tipo'          => 1,
								'estatus'       => 1));

		$servicio->where('CONCAT( codigo,  "  " , nombre ) like "%'.$_GET['term'].'%"')->get();
		
		$aServicio = array();

		foreach($servicio as $service){
			 $aServicio[] = array("Id"    => $service->id, 
			 					  "label" => $service->codigo ." ". $service->nombre,
			 					  "value" => $service->codigo ." ". $service->nombre);
		}
		
		echo json_encode($aServicio);

	}

	public function lista_add(){

	$servicio = new Servicio();
	$servicio->where(array('consultorio_id' => $this->session->userdata('id_consultorio')));
	$servicio->where_in('tipo', array(1,3));
	$servicio->where(array('estatus' => 1, 'cita' => 1))->get();
	
	$aServicio = $servicio->all_to_array(); 
		
	echo json_encode($aServicio);

	}

	public function lista_buy(){

	$servicio = new Servicio();
	$servicio->where(array('consultorio_id' => $this->session->userdata('id_consultorio')));
	$servicio->where_in('tipo', array(1,3));
	$servicio->where(array('estatus' => 1, 'cita' => 2))->get();
	
	$aServicio = $servicio->all_to_array(); 
		
	echo json_encode($aServicio);

	}

	public function lista_egresos(){

	$servicio = new Servicio();
	$servicio->where(array('consultorio_id' => $this->session->userdata('id_consultorio')));
	$servicio->where_in('tipo', array(2,3));
	$servicio->where('estatus', 1)->get();
	
	$aServicio = $servicio->all_to_array(); 
		
	echo json_encode($aServicio);

	}

	public function lista_ingresos(){

	$servicio = new Servicio();
	$servicio->where(array('consultorio_id' => $this->session->userdata('id_consultorio')));
	$servicio->where_in('tipo', array(1,3));
	$servicio->where(array('estatus' => 1))->get();
	
	$aServicio = $servicio->all_to_array(); 
		
	echo json_encode($aServicio);

	}
}




