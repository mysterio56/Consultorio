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
		$citas         = new Reunion();
		$prox_citas    = new Reunion();

		$oUsuario->where('id',$this->session->userdata('id_user'))->get();

		$oTipoEmpleado->where('id',$this->session->userdata('type_user'))->get();
		
		$empleado = $oUsuario->empleado->get();
		$empleado->consultorio->get();

		$citas->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
                            'estatus'        => 1));
        
        $citas->order_by('TIMESTAMPDIFF(MINUTE,fecha_hora,now()) DESC');   
        $citas->limit('5');

        $prox_citas->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
                            'estatus'        => 1));
        
        $prox_citas->order_by('TIMESTAMPDIFF(MINUTE,fecha_hora,now()) DESC');   
        $prox_citas->limit('1');

		$data['logo']       = $empleado->consultorio->nombre_logo;
		$data['modulos']    = $oTipoEmpleado->modulo->where('modulo_id',0)->get()->all;
		$data['submodulos'] = $oTipoEmpleado->modulo->where('modulo_id <>',0)->get()->all;
		$data['citas']      = $citas->get();
		$data['prox_cita']  = $prox_citas->get();
		$data['title']      = "welcome page";
		$data['view']       = "welcome";
		$data['cssFiles']   = array('styles.css');
		$data['jsFiles']    = array('jquery.js',
							     	'main.js');

		$this->load->view('template',$data);

	}

}