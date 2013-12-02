<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appointment extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('type_user'));
    	$this->load->helper("submodulo");
    	$this->load->helper("estatus");
    }

    public function index($page = 1, $estatus_cita = 1){

    	$citas = new Reunion();

		$aPermisos    = permisos($this->session->userdata('type_user'));
		$aPermisosSub = submodulos($this->session->userdata('type_user'),9);

		$citas->where(array('consultorio_id' => $this->session->userdata('id_consultorio')));

		if($estatus_cita == 1){

			$citas->db->where('YEAR(fecha_hora)' , date("Y"));
			$citas->db->where('MONTH(fecha_hora)', date("m"));
			$citas->db->where('DAY(fecha_hora)'  , date("d"));

		}

		$citas->order_by('fecha_hora');
		$citas->get_paged_iterated($page, 9);

		$data['permisos']      = $aPermisos['appointment'];
		$data['permisosSub']   = $aPermisosSub;
		$data['paginaActual']  = $page;
		$data['estatusActual'] = $estatus_cita;
		$data['citas']         = $citas;
		$data['view']          = 'sistema/citas/lista';
		$data['cssFiles']      = array('prototip.css',
									   'sistema.css');
		$data['jsFiles']       = array('prototip/js/prototip/prototype.js',
									   'prototip/js/prototip/prototip.js',
									   'valid_forms.js');

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

		$this->load->view('sistema/template_citas',$data);
    	
    }


    public function estatus($cita_id = null){

    	$cita = new Reunion();

    	$cita->where('id', $cita_id)->get();

        $data['estatus_act'] = $cita->estatus;

        if($this->input->post()){

        	$historia = new historia();

        	$historia->cita_id    = $cita_id;
        	$historia->fecha_hora = $cita->fecha_hora;
        	$historia->fecha_alta = date("Y-m-d H:i:s");
			$historia->estatus        = $this->input->post('estatus');	

    		$cita->estatus = $this->input->post('estatus');

    		if($cita->save() && $historia->save()){
    			redirect(base_url('appointment'));
    		}

    	} else {

    		$this->load->view('sistema/citas/estatus', $data);

    	}

    }

    public function historia($cita_id = null){

    	$historia= new historia();

    	$historia->where('cita_id', $cita_id)->order_by('fecha_alta', 'DESC')->get();
    	
    	//$historia->where('concat(fecha_alta," ",fecha_hora ) like "%'.$_GET['term'].'%" ')->get();

    	$data['view']      = 'sistema/citas/historia';
		$data['cssFiles']  = array('sistema.css');
		$data['historial'] = $historia;

		$this->load->view('sistema/citas/historia', $data);

    }

    public function agregar(){    	


    	$data['view']     	  = 'sistema/citas/agregar';
		$data['return']       = 'appointment';
		$data['cssFiles'] = array('jquery-ui/jquery-ui.css',
								  'sistema.css');
		$data['jsFiles']  = array('valid_forms.js',
								  'jquery.js',
							      'jquery-ui.js',
							      'jquery.ui.datepicker-es.js',
							   	  'jquery-validation/dist/jquery.validate.js',
								  'jquery-validation/localization/messages_es.js',
								  'jquery-timepicker.js');

	$this->load->view('sistema/template',$data);

		if($this->input->post()){

		$citas = new Reunion();

		$citas->paciente_id = $this->input->post('pacienteId'); 
		$citas->empleado_id = $this->input->post('doctorId'); 
		$citas->fecha_hora  = $this->input->post('fecha_alt').':00';
		$citas->servicio_id	= $this->input->post('servicioId');
		$citas->estatus		= 1;

		$citas->consultorio_id = $this->session->userdata('id_consultorio');
		$citas->fecha_alta          = date("Y-m-d H:i:s");
		
		if($citas->save()){

				redirect(base_url('appointment'));

			} else {

				echo $citas->error->string;
				
			}
   }


}

}