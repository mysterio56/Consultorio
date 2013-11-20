<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Format extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('type_user'));
    }

	public function index($page = 1){

    	$consultorio = new Consultorio();
		$aPermisos = permisos($this->session->userdata('type_user'));

		$consultorio->where(array('id' => $this->session->userdata('id_consultorio')))->get();

		$consultorio->formato->where('estatus <>', 2);

		$consultorio->formato->order_by('codigo');
    
    	$formatos = $consultorio->formato->get_paged_iterated($page, 9);
    	

    	$data['permisos']      = $aPermisos['format'];
		$data['paginaActual']  = $page;
		$data['formatos']      = $formatos;
		$data['view']          = 'sistema/formato/lista';
		$data['cssFiles']      = array('sistema.css');
		$data['jsFiles']       = array('valid_forms.js');
		if($this->input->post()){
        
        $consultorio = new Consultorio();
			
			$aPermisos = permisos($this->session->userdata('type_user'));
			$input_count = 0;

			foreach ($this->input->post() as $input_name => $input) {
				if($input_name != 'buscar' && $input_name != 'fecha_alta_value' && $input != ''){
			 		$formatos->like($input_name, $input);
			 		$input_count++;
			 	}
			 } 

			if($input_count > 0){
				$formatos->where('estatus <>', 2);
				$formatos->order_by('codigo');
				$formatos->get_paged_iterated($page, 8);

				$data['permisos']     = $aPermisos['format'];
				$data['paginaActual'] = $page;
				$data['formatos']    = $formatos;
				$data['buscar']       = true;

			}

		}
		$this->load->view('sistema/template',$data);
    }

    public function agregar(){
        
        $consultorio = new Consultorio();
    	$formato = new Formato();

    	$data['view']     	  = 'sistema/formato/agregar';
		$data['return']       = 'format';
		$data['cssFiles']     = array('sistema.css');
		$data['jsFiles']      = array('jquery.js',
							     	  'jquery-validation/dist/jquery.validate.js',
								      'jquery-validation/localization/messages_es.js',
								      'autoNumeric.js',
								      'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){

			$formato->codigo         = $this->input->post('codigo'); 
			$formato->nombre         = $this->input->post('nombre');
			/*$servicio->costo_compra   = str_replace(",","",$this->input->post('costo_c'));
			$servicio->costo_venta    = str_replace(",","",$this->input->post('costo_v'));
			$servicio->tipo           = $this->input->post('servicios'); 
			$servicio->consultorio_id = $this->session->userdata('id_consultorio');*/
			$formato->fecha_alta     = date("Y-m-d H:i:s");
			$formato->estatus        = 1;

			$consultorio->where_in($this->session->userdata('id_consultorio'))->get();

		
			

			if($formato->save($consultorio->all)){

				redirect(base_url('format'));

			} else {

				echo $formato->error->string;
				
			}

		}

    }

    public function editar($id_formato){

    	$formato = new Formato();
    	$formato->where('id',$id_formato)->get();

		/*$data['formato'] = $formato->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
											       'id'             => $id_formato))->get();*/
		$data['formato'] = $formato; 
		$data['return']       = 'format'; 		
		$data['view']         = 'sistema/formato/editar';
		$data['cssFiles']     = array('sistema.css');
		$data['jsFiles']      = array('jquery.js',
							   	      'jquery-validation/dist/jquery.validate.js',
								      'jquery-validation/localization/messages_es.js',
								      'autoNumeric.js',
								      'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){

			$formato->codigo             = $this->input->post('codigo'); 
			$formato->nombre             = $this->input->post('nombre');
			/*$formato->costo_compra       = str_replace(",","",$this->input->post('costo_c'));
			$formato->costo_venta        = str_replace(",","",$this->input->post('costo_v'));
			$formato->tipo               = $this->input->post('servicios'); */
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

		$data['view']     = 'sistema/formato/buscar';
		$data['return']   = 'format';
		$data['cssFiles'] = array('jquery-ui/jquery-ui.css',
								  'sistema.css');
		$data['jsFiles']  = array('jquery.js',
							      'jquery-ui.js',
							      'jquery.ui.datepicker-es.js',
							      'valid_forms.js');

		if($this->input->post()){

			$formatos = new Formato();
			
			$aPermisos = permisos($this->session->userdata('type_user'));
			$input_count = 0;

			foreach ($this->input->post() as $input_name => $input) {
				if($input_name != 'buscar' && $input_name != 'fecha_alta_value' && $input != ''){
			 		$formatos->like($input_name, $input);
			 		$input_count++;
			 	}
			 } 

			if($input_count > 0){

				$formatos->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
								        'estatus <>'     => 2)); 

				$formatos->order_by('codigo');

				$formatos->get_paged_iterated($page, 8);

				$data['permisos']     = $aPermisos['format'];
				$data['paginaActual'] = $page;
				$data['formatos']     = $formatos;
				$data['buscar']       = true;

			}

		}

		$this->load->view('sistema/template',$data);

	}
}