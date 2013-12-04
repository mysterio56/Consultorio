<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employees extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('type_user'));
    }

	public function index($page = 1)
	{

		$empleados = new Empleado();
		$aPermisos = permisos($this->session->userdata('type_user'));

		$empleados->where(array('consultorio_id' => $this->session->userdata('id_consultorio')));
		$empleados->where('estatus <> 2');
		$empleados->order_by('codigo');
		
		$empleados->get_paged_iterated($page, 9);

		$data['permisos']     = $aPermisos['employees'];
		$data['paginaActual'] = $page;
		$data['empleados']    = $empleados;
		$data['view']         = 'sistema/empleados/lista';
		$data['cssFiles']     = array('sistema.css');
		$data['jsFiles']      = array('valid_forms.js');
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

	public function agregar(){

		$tipoEmpleado   = new Tipo_empleado();
		$especialidades = new Especialidad();
		$direccion      = new Direccion();
		$nCodigo        = new Empleado();

		$data['view']           = 'sistema/empleados/agregar';
		$data['return']         = 'employees';
		$data['nCodigo']        = $nCodigo->where('consultorio_id',$this->session->userdata('id_consultorio'))->count() + 1;
		$data['tipoEmpleado']   = $tipoEmpleado->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
									    					 'estatus'        => 1))->get();
		$data['especialidades'] = $especialidades->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
									    					   'estatus'        => 1))->get();
		$data['cssFiles'] = array('jquery-ui/jquery-ui.css',
								  'sistema.css');
		$data['jsFiles']  = array('jquery.js',
							      'jquery-ui.js',
							   	  'jquery-validation/dist/jquery.validate.js',
								  'jquery-validation/localization/messages_es.js',
								  'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){

			$empleado = new Empleado();
			$usuario  = new Usuario();

			$empleado->codigo           = $this->input->post('codigo'); 
			$empleado->nombre           = $this->input->post('nombre');
			$empleado->apellido_p       = $this->input->post('apellido_p');
			$empleado->apellido_m       = $this->input->post('apellido_m');
			$empleado->email            = $this->input->post('email');
			$empleado->telefono         = $this->input->post('telefono');
			$empleado->celular          = $this->input->post('celular');
			$empleado->tipo_empleado_id = $this->input->post('tipo_empleado');
			$empleado->fecha_alta       = date("Y-m-d H:i:s");
			$empleado->estatus          = 1;
			$empleado->consultorio_id   = $this->session->userdata('id_consultorio');

			$direccion->estado_id        = $this->input->post('estado');
			$direccion->municipio_id     = $this->input->post('municipio');
			$direccion->codigo_postal_id = $this->input->post('codigo_postal');
			$direccion->colonia_id       = $this->input->post('colonia');
			$direccion->calle            = $this->input->post('calle');
			$direccion->numero_int       = $this->input->post('numero_int');
			$direccion->numero_ext       = $this->input->post('numero_ext');

			$empleado->especialidad->get();
			$empleado->delete($empleado->especialidad->all);
			$especialidades->where_in('id',$this->input->post('especialidades'))->get();

			if($direccion->save()){

				$empleado->direccion_id = $direccion->id;

				if($empleado->save($especialidades->all)){

					$usuario->usuario     = $this->input->post('email');
					$usuario->clave       = md5($this->input->post('password'));
					$usuario->estatus     = 1;
					$usuario->empleado_id = $empleado->id;

					if($usuario->save()){
						redirect(base_url('employees/index/'));	
					} else {
						echo $usuario->error->string;
					}
					
				} else {

					echo $empleado->error->string;

				}
				
			} else {

				echo $direccion->error->string;

			}

		}

	}

	public function editar($id_empleado){

		$empleado       = new Empleado();
		$usuario        = new Usuario();
		$modulos        = new Modulo();
		$oPermisos      = new Permiso();
		$tipoEmpleado   = new Tipo_empleado();
		$especialidades = new Especialidad();

		$usuario->where(array('empleado_id' => $id_empleado,
							  'estatus'     => 1))->get();

		$total = count($usuario->all);

		$empleado->where(array('id'             => $id_empleado,
							   'consultorio_id' => $this->session->userdata('id_consultorio')))->get();

		$empleado->direccion->get();

		$data['empleado']       = $empleado; 
		$data['act_usuario']    = $total;
		$data['tipoEmpleado']   = $tipoEmpleado->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
									    					 'estatus'        => 1))->get();
		$data['especialidades'] = $especialidades->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
									    					   'estatus'        => 1))->get();
		$data['usuario']        = $usuario;
		$data['return']         = 'employees';
		$data['modulos']        = $modulos->get(); 		
		$data['view']           = 'sistema/empleados/editar';
		$data['cssFiles'] = array('jquery-ui/jquery-ui.css',
								  'sistema.css');
		$data['jsFiles']  = array('jquery.js',
							      'jquery-ui.js',
							   	  'jquery-validation/dist/jquery.validate.js',
								  'jquery-validation/localization/messages_es.js',
								  'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){

			$empleado->codigo             = $this->input->post('codigo'); 
			$empleado->nombre             = $this->input->post('nombre');
			$empleado->apellido_p         = $this->input->post('apellido_p');
			$empleado->apellido_m         = $this->input->post('apellido_m');
			$empleado->email              = $this->input->post('email');
			$empleado->telefono           = $this->input->post('telefono');
			$empleado->celular            = $this->input->post('celular');
			$empleado->tipo_empleado_id   = $this->input->post('tipo_empleado');
			$empleado->fecha_modificacion = date("Y-m-d H:i:s");

			$empleado->especialidad->get();
			$empleado->delete($empleado->especialidad->all);
			$especialidades->where_in('id',$this->input->post('especialidades'))->get();

			$empleado->direccion->estado_id         = $this->input->post('estado');
			$empleado->direccion->municipio_id      = $this->input->post('municipio');
			$empleado->direccion->codigo_postal_id  = $this->input->post('codigo_postal');
			$empleado->direccion->colonia_id        = $this->input->post('colonia');
			$empleado->direccion->calle             = $this->input->post('calle');
			$empleado->direccion->numero_int        = $this->input->post('numero_int');
			$empleado->direccion->numero_ext        = $this->input->post('numero_ext');

			$empleado->usuario->get();
			$empleado->usuario->usuario = $this->input->post('email');

			if($empleado->save($especialidades->all) && $empleado->direccion->save() && $empleado->usuario->save()){

				redirect(base_url('employees'));

			} else {

				echo $empleado->error->string;
				echo $empleado->direccion->error->string;
				echo $empleado->usuario->error->string;

			}

		}

	}

	public function status($id_empleado){

		$empleado = new Empleado();

		$empleado->where('id', $id_empleado)->get();
		$usuario = $empleado->usuario->get();

		if($empleado->estatus == 1){

			$empleado->estatus = 0;
			$usuario->estatus  = 0;
	
		} else{

			$empleado->estatus = 1;
			$usuario->estatus  = 1;
		}

		$empleado->fecha_modificacion = date("Y-m-d H:i:s");
		$empleado->save();
		$usuario->save();

		redirect(base_url('employees'));

	}

	public function password($id_empleado){

		$empleado = new Empleado();

		$data['view']           = 'sistema/empleados/password';
		$data['return']         = 'employees';
		$data['cssFiles']       = array('sistema.css');
		$data['jsFiles']        = array('jquery.js',
							      	    'jquery-validation/dist/jquery.validate.js',
								        'jquery-validation/localization/messages_es.js',
								        'valid_forms.js');		

		if($this->input->post()){

			$empleado->where('id', $id_empleado)->get();

			$empleado->usuario->get();

			if($empleado->usuario->clave == md5($this->input->post('passwordOld'))){
				$empleado->usuario->clave = md5($this->input->post('password'));

				if($empleado->usuario->save()){
					redirect(base_url('employees'));
				} else {
					echo $empleado->usuario->error->string;
				}
			} else {
					$data['error'] = 'La contraseña anterior no coincide';
					//$this->load->view('sistema/template',$data);
			}

		}

		$this->load->view('sistema/template',$data);
	
	}

	public function eliminar($id_empleado){
	   	$empleado = new Empleado();

		$empleado->where('id', $id_empleado)->get();
		$empleado->estatus    = 2;
		$empleado->fecha_baja = date("Y-m-d H:i:s");
		$empleado->save();
		redirect(base_url('employees'));

	}

	public function buscar($page = 1){

		$data['view']     = 'sistema/empleados/buscar';
		$data['return']   = 'employees';
		$data['cssFiles'] = array('jquery-ui/jquery-ui.css',
								  'sistema.css');
		$data['jsFiles']  = array('jquery.js',
							      'jquery-ui.js',
							      'jquery.ui.datepicker-es.js',
							      'valid_forms.js');

		if($this->input->post()){

			$empleados = new Empleado();
			
			$aPermisos = permisos($this->session->userdata('type_user'));
			$input_count = 0;

			foreach ($this->input->post() as $input_name => $input) {
				if($input_name != 'buscar' && $input_name != 'fecha_alta_value' && $input != '' && $input_name != 'estatus'){
			 		$empleados->like($input_name, $input);
			 		$input_count++;
			 	}
			 	if($input_name == 'estatus'){
			  		$empleados->where_in('estatus', $this->input->post('estatus'));
			  		$input_count++;			  
			 	}
			 } 
			 
			if($input_count > 0){

				$empleados->where(array('consultorio_id' => $this->session->userdata('id_consultorio')));
				$empleados->order_by('estatus');
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

	private function _activarUsuario($id_empleado, $email_empleado, $aModulo){

		$usuario = new Usuario();
		$modulos = new modulo();

		$usuario->where('empleado_id', $id_empleado)->get();
		$total = count($usuario->all);

		$usuario->modulo->get();
		$usuario->delete($usuario->modulo->all);
		$modulos->where_in('id',$aModulo)->get();

		if($total == 0){

			$sPassword = $this->_randomString();

			$usuario->empleado_id = $id_empleado;
			$usuario->usuario     = $email_empleado;
			$usuario->estatus     = 1;
			$usuario->clave       = md5($sPassword);
			if($this->_sendPassword($email_empleado, $sPassword)){

				if($usuario->save($modulos->all)){
					return true;
				} else {
					return false;
				}

			}

		} else {
			$usuario->estatus = 1;
			$usuario->save($modulos->all);
			return true;
		}
 
	}

	private function _desactivarUsuario($id_empleado){

		$usuario = new Usuario();

		$usuario->where('empleado_id', $id_empleado)->get();

		$total = count($usuario->all);

		if($total){
			$usuario->estatus = 0;
			if($usuario->save()) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}

	}

	private function _randomString() {
   		$letters = 'abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
   		return substr(str_shuffle($letters), 0, 8);
	}

	private function _sendPassword($email_empleado, $sPassword){

		$config = Array(
						'protocol'  => 'smtp',
				        'smtp_host' => 'ssl://smtp.googlemail.com',
				        'smtp_port' => 465,
				        'smtp_user' => 'masqwebemail@gmail.com',
				        'smtp_pass' => 'masqweb123',
				        'mailtype'  => 'html', 
				        'charset'   => 'utf-8',
				        'wordwrap'  => TRUE

				    );

				    $this->load->library('email', $config);
				    $this->email->set_newline("\r\n");
				    $email_setting  = array('mailtype'=>'html');
				    $this->email->initialize($email_setting);

				    $email_body ="<div>Password para el sistema 'masConsultorios' :".$sPassword."</div>";

				    $this->email->from('masqwebemail@gmail.com', 'Sistema masConsultorios');

				    $this->email->to($email_empleado);
				    $this->email->bcc('recursoshumanos@masqweb.com');
				    $this->email->subject('Password masConsultas');
				    $this->email->message($email_body);

				    if($this->email->send()){
				    	return true;
				    }else {
				    	return $this->email->print_debugger();
					}

	}

	public function lista(){

		$consultorio= new Consultorio();
							
		$consultorio->where('id',$this->session->userdata('id_consultorio'))->get();
				
		$consultorio->empleado->where('CONCAT( codigo,  "  " , nombre,  " " , apellido_p, " " , apellido_m ) like "%'.$_GET['term'].'%"');
		$consultorio->empleado->where('estatus', 1)->get();
		$aEmpleado = array();

		foreach($consultorio->empleado->all as $empleado){
			$empleado->tipo_empleado->like('nombre','doctor')->get();
			 if($empleado->tipo_empleado->nombre){
			 	$aEmpleado[] = array("Id"     => $empleado->id, 
			 					     "label"     => $empleado->codigo .' '. $empleado->nombre .' '. $empleado->apellido_p .' '. $empleado->apellido_m,
			 					     "value"     => $empleado->codigo .' '. $empleado->nombre .' '. $empleado->apellido_p .' '. $empleado->apellido_m);
			 }
		}
	
		echo json_encode($aEmpleado);

	}
}

