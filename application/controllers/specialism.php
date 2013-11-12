<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Specialism extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('id_user'));
    }

    public function index($page = 1){

    	$especialidades = new Especialidad();
		$aPermisos = permisos($this->session->userdata('id_user'));

		$especialidades->where('estatus <>', 2);
		$especialidades->order_by('nombre');
		$especialidades->get_paged_iterated($page, 9);

		$data['permisos']       = $aPermisos['specialism'];
		$data['paginaActual']   = $page;
		$data['especialidades'] = $especialidades;
		$data['view']           = 'sistema/especialidades/lista';
		$data['cssFiles']       = array('sistema.css');
		$data['jsFiles']        = array('valid_forms.js');
		if($this->input->post()){
			$especialidades = new Especialidad();
			$aPermisos = permisos($this->session->userdata('id_user'));
			$input_count = 0;

			foreach ($this->input->post() as $input_name => $input) {
				if($input_name != 'buscar' && $input_name != 'fecha_alta_value' && $input != ''){
			 		$especialidades->like($input_name, $input);
			 		$input_count++;
			 	}
			 } 
			if($input_count > 0){
				$especialidades->where('estatus <>', 2);
				$especialidades->order_by('nombre');
				$especialidades->get_paged_iterated($page, 8);

				$data['permisos']     = $aPermisos['specialism'];
				$data['paginaActual'] = $page;
				$data['especialidades']= $especialidades;
				$data['buscar']       = true;

			}

		}

		$this->load->view('sistema/template',$data);

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

}