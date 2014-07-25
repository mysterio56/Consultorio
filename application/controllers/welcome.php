<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	if (!$this->session->userdata('username')){ redirect(base_url().'login'); }
    	
    }

	public function index()
	{

		$oUsuario      = new Usuario();
		$oTipoEmpleado = new Tipo_empleado();
		$oModulos      = new Modulo();

		$oUsuario->where('id',$this->session->userdata('id_user'))->get();

		$oTipoEmpleado->where('id',$this->session->userdata('type_user'))->get();
		
		$empleado = $oUsuario->empleado->get();
		$empleado->consultorio->get();

		$data['logo']       = $this->session->userdata('logo');
		$data['modulos']    = $oTipoEmpleado->modulo->where(array('modulo_id' => 0))->get()->all;
		$data['submodulos'] = $oTipoEmpleado->modulo->where('modulo_id <>',0)->get()->all;
		$data['allModulos'] = $oModulos->where(array('estatus' => 1, 'modulo_id' => 0, 'tipo' => 0))->get()->all;
		$data['title']      = "welcome page";
		$data['view']       = "welcome";
		$data['cssFiles']   = array('styles.css');
		$data['jsFiles']    = array('jquery.js',
							     	'main.js');


		if($this->session->userdata('type_user') == 'admin'){
			$data['allModulosAdmin'] = $oModulos->where(array('estatus' => 1, 'modulo_id' => 0, 'tipo' => 1))->get()->all;
		}

		$this->load->view('template',$data);

	}

}