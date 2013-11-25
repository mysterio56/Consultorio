<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appointment extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('type_user'));
    }

    public function index($page = 1, $estatus_cita = 1){

    	$citas = new Reunion();

		$aPermisos = permisos($this->session->userdata('type_user'));

		$citas->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
							'estatus <>'     => 2));

		if($estatus_cita == 1){
			$citas->db->where('YEAR(fecha_hora)' , date("Y"));
			$citas->db->where('MONTH(fecha_hora)', date("m"));
			$citas->db->where('DAY(fecha_hora)'  , date("d"));
		}

		$citas->order_by('fecha_hora');
		$citas->get_paged_iterated($page, 9);

		$data['permisos']      = $aPermisos['appointment'];
		$data['paginaActual']  = $page;
		$data['estatusActual'] = $estatus_cita;
		$data['citas']         = $citas;
		$data['view']          = 'sistema/citas/lista';
		$data['cssFiles']      = array('sistema.css');
		$data['jsFiles']       = array('valid_forms.js');

		if($this->input->post()){

			$empleados = new Empleado();
			
			$aPermisos = permisos($this->session->userdata('type_user'));
			$input_count = 0;

			foreach ($this->input->post() as $input_name => $input) {
				if($input_name != 'buscar' && $input_name != 'fecha_alta_value' && $input != ''){
			 		$empleados->like($input_name, $input);
			 		$input_count++;
			 	}
			 } 

			if($input_count > 0){

				$empleados->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
									    'estatus <>'     => 2));

				$empleados->order_by('codigo');
				$empleados->get_paged_iterated($page, 8);

				$data['permisos']     = $aPermisos['employees'];
				$data['paginaActual'] = $page;
				$data['empleados']    = $empleados;
				$data['buscar']       = true;

			}

		}
		$this->load->view('sistema/template',$data);
    	
    }

}