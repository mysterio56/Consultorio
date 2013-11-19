<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('type_user'));
    }

	public function index($page = 1){

    	$productos = new Producto();
		$aPermisos = permisos($this->session->userdata('type_user'));

		$productos->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
								'estatus <>'     => 2));

		$productos->order_by('codigo');
    
    	$productos->get_paged_iterated($page, 9);

		$data['permisos']      = $aPermisos['product'];
		$data['paginaActual']  = $page;
		$data['productos']     = $productos;
		$data['view']          = 'sistema/producto/lista';
		$data['cssFiles']      = array('sistema.css');
		$data['jsFiles']       = array('valid_forms.js');

		if($this->input->post()){

			$productos = new Producto();
			
			$aPermisos = permisos($this->session->userdata('type_user'));
			$input_count = 0;

			foreach ($this->input->post() as $input_name => $input) {
				if($input_name != 'buscar' && $input_name != 'fecha_alta_value' && $input != ''){
			 		$productos->like($input_name, $input);
			 		$input_count++;
			 	}
			 } 

			if($input_count > 0){

                $productos->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
									    'estatus <>'     => 2));
				$productos->order_by('codigo');
				$productos->get_paged_iterated($page, 8);

				$data['permisos']     = $aPermisos['product'];
				$data['paginaActual'] = $page;
				$data['productos']    = $productos;
				$data['buscar']       = true;

			}

		}
		$this->load->view('sistema/template',$data);
    }

    public function agregar(){

    	$producto = new Producto();

    	$data['view']     	  = 'sistema/producto/agregar';
		$data['return']       = 'product';
		$data['cssFiles']     = array('sistema.css');
		$data['jsFiles']      = array('jquery.js',
							     	  'jquery-validation/dist/jquery.validate.js',
								      'jquery-validation/localization/messages_es.js',
								      'autoNumeric.js',
								      'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){

			$producto->codigo         = $this->input->post('codigo'); 
			$producto->nombre         = $this->input->post('nombre');
			$producto->costo          = str_replace(",","",$this->input->post('costo'));
			$producto->consultorio_id = $this->session->userdata('id_consultorio');
			$producto->fecha_alta     = date("Y-m-d H:i:s");
			$producto->estatus        = 1;

			if($producto->save()){

				redirect(base_url('product'));

			} else {

				echo $producto->error->string;
				
			}

		}

    }

    public function editar($id_producto){

    	$producto = new Producto();

		$data['producto'] = $producto->where(array('id'             => $id_producto,
												   'consultorio_id' => $this->session->userdata('id_consultorio')))->get();
		$data['return']   = 'product'; 		
		$data['view']     = 'sistema/producto/editar';
		$data['cssFiles'] = array('sistema.css');
		$data['jsFiles']  = array('jquery.js',
							   	  'jquery-validation/dist/jquery.validate.js',
								  'jquery-validation/localization/messages_es.js',
								  'autoNumeric.js',
								  'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){

			$producto->codigo             = $this->input->post('codigo'); 
			$producto->nombre             = $this->input->post('nombre');
			$producto->costo          = str_replace(",","",$this->input->post('costo'));
			$producto->fecha_modificacion = date("Y-m-d H:i:s");

			if($producto->save()){

				redirect(base_url('product'));
				
			} else {

				echo $producto->error->string;

			}

		}
	}


public function eliminar($id_producto){

		$producto = new Producto();

		$producto->where('id', $id_producto)->get();

		$producto->estatus    = 2;
		$producto->fecha_baja = date("Y-m-d H:i:s");

		if($producto->save()){

			redirect(base_url('product'));
		} else {
			echo $producto->error->string;

		}

	}


	public function status($id_producto){

		$producto = new Producto();

		$producto->where('id', $id_producto)->get();

		if($producto->estatus == 1){

			$producto->estatus    = 0;
			$producto->fecha_baja = '0000-00-00 00:00:00';
	
		} else{

			$producto->fecha_baja = date("Y-m-d H:i:s");
			$producto->estatus    = 1;

		}
		
		$producto->save();

		redirect(base_url('product'));

	}


   public function buscar($page = 1){

		$data['view']     = 'sistema/producto/buscar';
		$data['return']   = 'product';
		$data['cssFiles'] = array('jquery-ui/jquery-ui.css',
								  'sistema.css');
		$data['jsFiles']  = array('jquery.js',
							      'jquery-ui.js',
							      'jquery.ui.datepicker-es.js',
							      'valid_forms.js');

		if($this->input->post()){

			$productos = new Producto();
			
			$aPermisos = permisos($this->session->userdata('type_user'));
			$input_count = 0;

			foreach ($this->input->post() as $input_name => $input) {
				if($input_name != 'buscar' && $input_name != 'fecha_alta_value' && $input != ''){
			 		$productos->like($input_name, $input);
			 		$input_count++;
			 	}
			 } 
			if($input_count > 0){

				$productos->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
								        'estatus <>'     => 2));

				$productos->order_by('codigo');
				$productos->get_paged_iterated($page, 8);

				$data['permisos']     = $aPermisos['product'];
				$data['paginaActual'] = $page;
				$data['productos']     = $productos;
				$data['buscar']       = true;

			}

		}

		$this->load->view('sistema/template',$data);

	}
}