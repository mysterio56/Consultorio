<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Surgery extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('type_user'));
    	define("IMAGEPATH", "/var/www/Consultorio/assets/images/logos/");
    }

	public function index($id_consultorio = null){
		
		$aPermisos      = permisos($this->session->userdata('type_user'));
		$consultorio    = new Consultorio();
		$especialidades = new Especialidad();

        $consultorio->where('id', $this->session->userdata('id_consultorio'))->get();
        $consultorio->direccion->get();

        $data['especialidades'] = $especialidades->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
									    					   'estatus'        => 1))->get();
		$data['permisos']       = $aPermisos['surgery'];
		$data['consultorio']    = $consultorio;
		$data['view']           = 'sistema/consultorio/editar';
		$data['cssFiles']       = array('sistema.css');
		$data['jsFiles']        = array('jquery.js',
							   	    	'jquery-validation/dist/jquery.validate.js',
								  	    'jquery-validation/localization/messages_es.js',
								  	    'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){
			
			if($_FILES['userfile']['error'] == 0){

				$name = $this->_randomString();

				$config['upload_path']   = IMAGEPATH;
				$config['allowed_types'] = 'png';
				$config['file_name']     = $name.'_logo.png';
				$config['max_size']	     = '100';
				$config['max_width']     = '1024';
				$config['max_height']    = '768';

				$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload())
				{
					$error = array('error' => $this->upload->display_errors());
				}
				else
				{
					if(!$this->_resizeImage($name)){
						echo "error";
					}
				}

				unlink(IMAGEPATH.$consultorio->nombre_logo."_logo.png");
				unlink(IMAGEPATH.$consultorio->nombre_logo."_bg_logo.png");
				$consultorio->nombre_logo = $name;				

			}

			$consultorio->telefono1           = $this->input->post('telefono1');
			$consultorio->telefono2           = $this->input->post('telefono2');
			$consultorio->email               = $this->input->post('email');
			$consultorio->fecha_modificacion  = date("Y-m-d H:i:s");

			$consultorio->direccion->estado_id         = $this->input->post('estado');
			$consultorio->direccion->municipio_id      = $this->input->post('municipio');
			$consultorio->direccion->codigo_postal_id  = $this->input->post('codigo_postal');
			$consultorio->direccion->colonia_id        = $this->input->post('colonia');
			$consultorio->direccion->calle             = $this->input->post('calle');
			$consultorio->direccion->numero_int        = $this->input->post('numero_int');
			$consultorio->direccion->numero_ext        = $this->input->post('numero_ext');

			$consultorio->especialidad->get();
			$consultorio->delete($consultorio->especialidad->all);
			$especialidades->where_in('id',$this->input->post('especialidades'))->get();

			if($consultorio->save($especialidades->all) && $consultorio->direccion->save()){

				redirect('surgery');

			}else{

				echo $consultorio->error->string;

			}

		}

	}

	private function _resizeImage($name){

		$config['image_library'] = 'gd2';
	    $config['source_image']	 = IMAGEPATH.$name.'_logo.png';
		$config['new_image']     = IMAGEPATH.$name.'_bg_logo.png';
		$config['width']	     = 655;
		$config['height']	     = 400;

		$this->load->library('image_lib');

		$this->image_lib->initialize($config);
		$logo_bg = $this->image_lib->resize();

		$config['new_image'] = IMAGEPATH.$name.'_logo.png';
		$config['width']	 = 127;
		$config['height']	 = 65;

		$this->image_lib->initialize($config);
		$logo = $this->image_lib->resize();

		if($logo_bg && $logo){ 
			return true;
		} else {
			return false;
		}

	}

	private function _randomString() {
   		$letters = 'abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
   		return substr(str_shuffle($letters), 0, 8);
	}

}