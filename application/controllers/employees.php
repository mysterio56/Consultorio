<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employees extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('id_user'));
    }

	public function index($page = 1)
	{

		$empleados = new Empleado();
		$aPermisos = permisos($this->session->userdata('id_user'));

		$empleados->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
								'estatus <>'     => 2));

		$empleados->order_by('nombre');
		$empleados->get_paged_iterated($page, 9);

		$data['permisos']     = $aPermisos['employees'];
		$data['paginaActual'] = $page;
		$data['empleados']    = $empleados;
		$data['view']         = 'sistema/empleados/lista';
		$data['cssFiles']     = array('sistema.css');
		$data['jsFiles']      = array('valid_forms.js');
		if($this->input->post()){

			$empleados = new Empleado();
			
			$aPermisos = permisos($this->session->userdata('id_user'));
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

				$empleados->order_by('nombre');
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

		$data['view']     = 'sistema/empleados/agregar';
		$data['return']   = 'employees';
		$data['cssFiles'] = array('sistema.css');
		$data['jsFiles']  = array('jquery.js',
								  'jquery-validation/dist/jquery.validate.js',
								  'jquery-validation/localization/messages_es.js',
								  'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){

			$empleado = new Empleado();

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

			if($empleado->save()){

				redirect(base_url('employees/index/'));

			} else {

				echo $empleado->error->string;
				
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

		$data['empleado']       = $empleado->where(array('id'             => $id_empleado,
							 	   				  	     'consultorio_id' => $this->session->userdata('id_consultorio')))->get();
		$data['permisos']       = $oPermisos->where('usuario_id', $usuario->id)->get();
		$data['act_usuario']    = $total;
		$data['tipoEmpleado']   = $tipoEmpleado->where('estatus', 1)->get();
		$data['especialidades'] = $especialidades->where('estatus', 1)->get();
		$data['usuario']        = $usuario;
		$data['return']         = 'employees';
		$data['modulos']        = $modulos->get(); 		
		$data['view']           = 'sistema/empleados/editar';
		$data['cssFiles']       = array('sistema.css');
		$data['jsFiles']        = array('jquery.js',
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

			if($this->input->post('act_sistema')){

				$this->_activarUsuario($id_empleado, $this->input->post('email'), $this->input->post('modulos'));

				foreach($modulos->get() as $modulo){

					if( $this->input->post('modulos') ){

						if(in_array($modulo->id,$this->input->post('modulos'))){

							$nPermisos = 0;

							if(is_array($this->input->post('permisos_'.$modulo->id))){

								foreach($this->input->post('permisos_'.$modulo->id) as $permiso){
									$nPermisos += $permiso;	
								}

								$usuario->where('empleado_id', $id_empleado)->get();

								$oPermisos->where(array('modulo_id'  =>$modulo->id,
														'usuario_id' => $usuario->id))->get();

								$oPermisos->permiso = $nPermisos;

								$oPermisos->save();

							}
						}
					}
				}

			} else {
				$this->_desactivarUsuario($id_empleado);
			}

			$empleado->especialidad->get();
			$empleado->delete($empleado->especialidad->all);
			$especialidades->where_in('id',$this->input->post('especialidades'))->get();

			if($empleado->save($especialidades->all)){

				redirect(base_url('employees'));

			} else {

				echo $paciente->error->string;

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
		}

		$empleado->fecha_modificacion = date("Y-m-d H:i:s");
		$empleado->save();
		$usuario->save();

		redirect(base_url('employees'));

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
			
			$aPermisos = permisos($this->session->userdata('id_user'));
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

				$empleados->order_by('nombre');
				$empleados->get_paged_iterated($page, 5);

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

		if(!$total){
			$usuario->empleado_id = $id_empleado;
			$usuario->usuario     = $email_empleado;
			$usuario->estatus      = 1;
			$usuario->clave       = md5('masqweb');

			if($usuario->save($modulos->all)){
				return true;
			} else {
				return false;
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

}