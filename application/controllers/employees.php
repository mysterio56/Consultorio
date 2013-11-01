<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employees extends CI_Controller{

	public function __contruct(){
		parent::__consturct();
	}

	public function index(){

		$empleados = new Empleado();

		$data['empleados'] = $empleados->where('consultorio_id', $this->session->userdata('id_consultorio'))->get();
		$data['view']      = 'sistema/empleados/lista';
		$data['cssFiles']  = array('sistema.css');
		$data['jsFiles']   = array('valid_forms.js');

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

			$empleado->codigo         = $this->input->post('codigo'); 
			$empleado->nombre         = $this->input->post('nombre');
			$empleado->apellido_p     = $this->input->post('apellido_p');
			$empleado->apellido_m     = $this->input->post('apellido_m');
			$empleado->email          = $this->input->post('email');
			$empleado->telefono       = $this->input->post('telefono');
			$empleado->celular        = $this->input->post('celular');
			$empleado->fecha_alta     = date("Y-m-d H:i:s");
			$empleado->status         = 1;
			$empleado->consultorio_id = $this->session->userdata('id_consultorio');

			if($empleado->save()){
				redirect(base_url('employees'));
			} else {

			}

		}

	}

	public function editar($id_empleado){

		$empleado = new Empleado();
		$usuario  = new Usuario();
		$modulos  = new Modulo();

		$usuario->where(array('empleado_id' => $id_empleado,
							  'estatus'     => 1))->get();

		$total = count($usuario->all);


		$data['empleado']    = $empleado->where(array('id'             => $id_empleado,
								   					  'consultorio_id' => $this->session->userdata('id_consultorio')))->get();		
		$data['act_usuario'] = $total;
		$data['usuario']     = $usuario;
		$data['return']      = 'employees';
		$data['modulos']     = $modulos->get(); 		
		$data['view']        = 'sistema/empleados/editar';
		$data['cssFiles']    = array('sistema.css');
		$data['jsFiles']     = array('jquery.js',
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
			$empleado->fecha_modificacion = date("Y-m-d H:i:s");
			$empleado->estatus            = $this->input->post('activo');

			if($this->input->post('act_sistema')){
				$this->_activarUsuario($id_empleado, $this->input->post('email'), $this->input->post('modulos'));
			} else {
				$this->_desactivarUsuario($id_empleado);
			}

			if($empleado->save()){
				redirect(base_url('employees'));
			}else{
				
			}
		}

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
			$usuario->status      = 1;
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