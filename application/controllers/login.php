<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller{

	public function index()
	{	
		
		if ($this->session->userdata('username')){ redirect(base_url('welcome')); }

		$data['title']    = "Login";
		$data['view']     = "login";
		$data['cssFiles'] = array('styles.css');
		$data['jsFiles']  = array('jquery.js',
								  'jquery-validation/dist/jquery.validate.js',
								  'jquery-validation/localization/messages_es.js',
								  'valid_forms.js');
		
		if($this->input->post()){

	        $usuario   = $this->input->post('usuario');
			$password  = md5($this->input->post('password'));

			$oUsuarios = new Usuario();

		    $oUsuarios->where(array('usuario' => $usuario,
		    						'clave'   => $password,
		    						'estatus' => 1))->get();

		    $oUsuarios->empleados->get();

		    $total = count($oUsuarios->all);

		    if($oUsuarios->empleados->estatus != 1){
		    	$total = 0;
			}

			$oUsuarios->empleados->consultorio->get(); 

			if($oUsuarios->empleados->consultorio->estatus != 1){
		    	$total = 0;
			}

			if ($total) {

				$oUsuarios->empleado->get();

				$userdata = array('username'        => $oUsuarios->usuario,
	                              'id_user'         => $oUsuarios->id,
	                              'type_user'       => $oUsuarios->empleado->tipo_empleado_id,
	                              'id_consultorio'  => $oUsuarios->empleado->consultorio_id,
	                              'nombre_completo' => $oUsuarios->empleado->nombre.' '.
	                              					   $oUsuarios->empleado->apellido_p.' '.
	                              					   $oUsuarios->empleado->apellido_m);
	              
	            $this->session->set_userdata($userdata);
	            
		        redirect('welcome');

	    	} else {
	    		
	    		$data['error_menssage'] = 'Usuario y/o constraseña invalido';
	        	$this->load->view('template',$data);

	    	}

    	} else {

    		$this->load->view('template',$data);

    	}
	}
	

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url().'login');
	}

}