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
				
		$servicios->where(array('consultorio_id' => $this->session->userdata('id_consultorio')));
		$servicios->where('estatus <> 2');
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
				$servicios->order_by('estatus');
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
				if($input_name != 'buscar' && $input_name != 'fecha_alta_value' && $input != '' && $input_name != 'estatus'){
			 		$servicios->like($input_name, $input);
			 		$input_count++;
			 	}

			  	if($input_name == 'estatus'){
			  		$servicios->where_in('estatus', $this->input->post('estatus'));
			  		$input_count++;			  
			 	}
			}

			 if($input_count > 0){

				$servicios->where(array('consultorio_id' => $this->session->userdata('id_consultorio')));
				$servicios->order_by('estatus');
				$servicios->order_by('codigo');
				$servicios->get_paged_iterated($page, 4);

				$data['permisos']     = $aPermisos['service'];
				$data['paginaActual'] = $page;
				$data['servicios']    = $servicios;
				$data['buscar']       = true;

			}

		}

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
	$servicio->where('estatus', 1)->get();
	
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
}




