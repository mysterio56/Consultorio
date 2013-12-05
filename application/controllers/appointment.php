<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appointment extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('type_user'));
    	$this->load->helper("submodulo");
    	$this->load->helper("estatus");
    }

    /*public function index($page = 1, $estatus_cita = 1){

    	$citas = new Reunion();

		$aPermisos    = permisos($this->session->userdata('type_user'));
		$aPermisosSub = submodulos($this->session->userdata('type_user'),9);

		$citas->where(array('consultorio_id' => $this->session->userdata('id_consultorio')));

		if($estatus_cita == 1){

			$citas->db->where('YEAR(fecha_hora)' , date("Y"));
			$citas->db->where('MONTH(fecha_hora)', date("m"));
			$citas->db->where('DAY(fecha_hora)'  , date("d"));
			$citas->db->order_by(' ABS(TIMESTAMPDIFF( MINUTE, fecha_hora, NOW() ))  ASC'); 

		} else {

			$citas->order_by('fecha_hora');

		}
		
		$citas->get_paged_iterated($page, 9);

		$data['permisos']      = $aPermisos['appointment'];
		$data['permisosSub']   = $aPermisosSub;
		$data['paginaActual']  = $page;
		$data['estatusActual'] = $estatus_cita;
		$data['citas']         = $citas;
		$data['view']          = 'sistema/citas/lista';
		$data['cssFiles']      = array('prototip.css',
									   'sistema.css',
									   'jquery-ui/jquery-ui.css');
		$data['jsFiles']       = array('prototip/js/prototip/prototype.js',
									   'prototip/js/prototip/prototip.js',
									   'jquery.js',
							      	   'jquery-ui.js',
							      	   'jquery.ui.datepicker-es.js',
							      	   'jquery-timepicker.js',
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
    	
    }*/

    public function index(){

    	$citas = new Reunion();

		$aPermisos    = permisos($this->session->userdata('type_user'));
		$aPermisosSub = submodulos($this->session->userdata('type_user'),9);

		$data['permisos'] = $aPermisos['appointment'];    
		$data['view']          = 'sistema/citas/lista';
		$data['cssFiles']      = array('prototip.css',
									   'sistema.css',
									   'jquery-ui/jquery-ui.css');
		$data['jsFiles']       = array('prototip/js/prototip/prototype.js',
									   'prototip/js/prototip/prototip.js',
									   'jquery.js',
							      	   'jquery-ui.js',
							      	   'jquery.ui.datepicker-es.js',
							      	   'jquery-timepicker.js',
									   'valid_forms.js');

		$this->load->view('sistema/template_citas',$data);
    	
    }

    public function grid($page = 1){

    	if($this->input->post()){

    		$citas = new Reunion();
    		$citas->where('consultorio_id' , $this->session->userdata('id_consultorio'));

    		$permisos  = permisos($this->session->userdata('type_user'));

    		$aPermisos = array("Agregar"  => array(4,5,6,7),
                               "Editar"   => array(2,3,6,7),
                               "Eliminar" => array(1,3,5,7)
                               );

    		$aMeses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");

    		$permisosSub = submodulos($this->session->userdata('type_user'),9);

    		if($this->input->post('estatus_citas')){

    			switch ($this->input->post('estatus_citas')) {
				    case 1:
				        $citas->where('YEAR(fecha_hora)' , date("Y"));
						$citas->where('MONTH(fecha_hora)', date("m"));
						$citas->where('DAY(fecha_hora)'  , date("d"));
						$citas->order_by(' ABS(TIMESTAMPDIFF( MINUTE, fecha_hora, NOW() ))  ASC'); 
				        break;
				    case 2:
						$citas->where('DATE(fecha_hora) > CURRENT_DATE');
						$citas->order_by(' fecha_hora '); 
				        break;
				    case 3:
				        echo "i es igual a 2";
				        break;
				}

    		}

    		if($citas->count()){
	    		foreach($citas->get_paged_iterated($page, 9) as $nKey => $cita){
	    			$cita->paciente->get();
	    			$cita->empleado->get();
	    			$cita->servicio->get();	

	    			$aCitas[$nKey] = array("id"            => $cita->id,
	    								   "paciente"      => $cita->paciente->nombre." ".$cita->paciente->apellido_p." ".$cita->paciente->apellido_m,
	    								   "doctor"        => $cita->empleado->nombre." ".$cita->empleado->apellido_p." ".$cita->empleado->apellido_m,
	    								   "servicio"      => $cita->servicio->nombre,
	    								   "fecha"         => $cita->fecha_hora,
	    								   "fecha_format"  => date("d", strtotime($cita->fecha_hora)) ." ". 
	    								   					  $aMeses[date("m", strtotime($cita->fecha_hora)) - 1] ." ".
	    								   					  date("H", strtotime($cita->fecha_hora)) .":".
	    								   					  date("i", strtotime($cita->fecha_hora)),
	    								   "fecha_format2" => date("d/m/Y H:i", strtotime($cita->fecha_hora)),
	    								   "estatus"       => estatus($cita->estatus),
	    								   "nEstatus"      => $cita->estatus,
	    								   "editar"        => in_array($permisos['appointment'],$aPermisos['Editar'])?true:false,
	    								   "historia"      => isset($permisosSub['Histórico'])?true:false,
	    								   "costo"         => isset($permisosSub['Costo'])?true:false,
	    								   "adicionales"   => isset($permisosSub['Adicionales'])?true:false
	    								  );  
	    		}

				echo json_encode($aCitas);

			}

			echo json_encode(array('empty' => true));

    	}

    }

    public function estatus($cita_id = null, $estatus = null, $fecha = null){

    	$seconds = $fecha / 1000; 

		$cita     = new Reunion();
		$historia = new Historia();

		$cita->where('id', $cita_id)->get();
		$estatus_actual = $cita->estatus;
		$cita->estatus  = $estatus;

		if($estatus == 1){
			$cita->fecha_hora = date("Y-m-d H:i:s", $seconds);
		}

		$historia->cita_id    = $cita_id;
        $historia->fecha_hora = $cita->fecha_hora;
        $historia->fecha_alta = date("Y-m-d H:i:s");
		$historia->estatus    = $estatus;

		if($cita->save() && $historia->save()){
			echo json_encode(array('error'    => false, 
								   'estatus'  => estatus($estatus),
								   'nEstatus' => $estatus,
								   'fecha'    => $cita->fecha_hora));
		}else{
			echo json_encode(array('error'   => "Hubo un error al intentar modificar el estatus, intente de nuevo", 
								   'estatus' => estatus($estatus_actual)));
		}

    }

    public function estatusAuto($cita_id = null){

    	$this->load->helper('date');

		$cita        = new Reunion();
		$historia    = new Historia();
		$consultorio = new Consultorio();

		$cita->where('id', $cita_id)->get();
		$estatus_actual = $cita->estatus;

		$consultorio->where('id', $this->session->userdata('id_consultorio'))->get();
		
		$dateBD = $cita->fecha_hora;
		$dateBD = strtotime($dateBD);
		$dateBD = $dateBD+( 60 * $consultorio->tolerancia);

		$now = time();

		if($cita->estatus == 1 && $dateBD < $now){

			$cita->estatus = 3;

			$historia->cita_id    = $cita_id;
        	$historia->fecha_hora = $cita->fecha_hora;
        	$historia->fecha_alta = date("Y-m-d H:i:s");
			$historia->estatus    = 3;

			if($cita->save() && $historia->save()){

				echo json_encode(array('error'    => false, 
								       'estatus'  => estatus(3),
								       'nEstatus' => 3,
								       'fecha'    => $cita->fecha_hora));

			}else{

				echo json_encode(array('error'   => "Hubo un error al intentar modificar el estatus, intente de nuevo", 
								       'estatus' => estatus($estatus_actual)));

			}
			
		} else {
			
			echo json_encode(array('error'    => false, 
								   'estatus'  => estatus($cita->estatus),
								   'nEstatus' => $cita->estatus,
								   'fecha'    => $cita->fecha_hora));			
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

		$historia = new Historia();	
		$citas    = new Reunion();

		$citas->paciente_id = $this->input->post('pacienteId'); 
		$citas->empleado_id = $this->input->post('doctorId'); 
		$citas->fecha_hora  = $this->input->post('fecha_alt').':00';
		$citas->servicio_id	= $this->input->post('servicioId');
		$citas->estatus		= 1;

		$citas->consultorio_id = $this->session->userdata('id_consultorio');
		$citas->fecha_alta          = date("Y-m-d H:i:s");
		
		if($citas->save()){
				$historia->cita_id     = $citas->id;
				$historia->paciente_id = $this->input->post('pacienteId');
				$historia->empleado_id = $this->input->post('doctorId');
				$historia->fecha_hora  = $this->input->post('fecha_alt').':00';
				$historia->servicio_id = $this->input->post('servicioId');
				$historia->estatus     = 1;
				$historia->fecha_alta  = date("Y-m-d H:i:s");
				
				if($historia->save()){
					redirect(base_url('appointment'));
				}else{
					echo $historia->error->string;
				}

			} else {

				echo $citas->error->string;
				
			}
   		}
	}

	public function editar($id_cita){

		$cita = new Reunion();
		
		
		$cita->where(array( 'id'     => $id_cita,
							'estatus'=> 1))->get();
		    	

		$data['cita']     = $cita; 
		$data['return']   = 'appointment'; 		
		$data['view']     = 'sistema/citas/editar';
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

			$dateAnterior = strtotime($cita->fecha_hora);
			$dateInput    = strtotime($this->input->post('fecha_alt'));
			
			$cita->empleado_id = $this->input->post('doctorId'); 
			$cita->fecha_hora  = $this->input->post('fecha_alt');
			$cita->servicio_id = $this->input->post('servicioId');
			$cita->estatus	   = 1;

			$cita->consultorio_id = $this->session->userdata('id_consultorio');
			$cita->fecha_alta          = date("Y-m-d H:i:s");
			
			if($cita->save()){
				
				if ($dateAnterior < $dateInput){

					$historia = new Historia();

					$historia->cita_id     = $cita->id;
					$historia->paciente_id = $this->input->post('pacienteId');
					$historia->empleado_id = $this->input->post('doctorId');
					$historia->fecha_hora  = $this->input->post('fecha_alt');
					$historia->servicio_id = $this->input->post('servicioId');
					$historia->estatus     = 1;
					$historia->fecha_alta  = date("Y-m-d H:i:s");
					$historia->save();

				}

				redirect(base_url('appointment'));
						
			} else {

					echo $cita->error->string;
					
			}
	   	}
	}

	public function adicional(){

		$data['view']     	  = 'sistema/citas/adicional';
		$data['return']       = 'appointment';
		$data['cssFiles'] = array('jquery-ui/jquery-ui.css',
								  'sistema.css');
		$data['jsFiles']  = array('jquery.js',
							      'jquery-ui.js',
							      'jquery.ui.datepicker-es.js',
							   	  'jquery-validation/dist/jquery.validate.js',
								  'jquery-validation/localization/messages_es.js'
								  );

	$this->load->view('sistema/template',$data);
	}
}
