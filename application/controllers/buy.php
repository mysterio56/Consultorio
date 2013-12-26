<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Buy extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('type_user'));
    }

	public function index(){

		$data['view']     = 'sistema/compra/compra';
		$data['cssFiles'] = array('prototip.css',
								  'sistema.css',
								  'jquery-ui/jquery-ui.css');
		$data['jsFiles']  = array('jquery.js',
						     	  'jquery-ui.js',
							      'jquery.ui.datepicker-es.js',
							      'jquery-timepicker.js',
								  'valid_forms.js');

		$this->load->view('sistema/template_simple',$data);
	}

	public function insert(){

		if($this->input->post()){

			if($this->input->post('servicio')){

				$egreso_serv = new Egreso();
				$servicio     = new Servicio();

				$servicio->where('id',$this->input->post('servicio'))->get();
				
				$egreso_serv->estatus	      = 1;			
				$egreso_serv->consultorio_id = $this->session->userdata('id_consultorio');
		   	 	$egreso_serv->fecha_alta     = date("Y-m-d H:i:s");
				$egreso_serv->costo          = $servicio->costo_compra * $this->input->post('cantidad_serv');
				$egreso_serv->cantidad       = $this->input->post('cantidad_serv');
				$egreso_serv->servicio_id    = $this->input->post('servicio');
				
				if($egreso_serv->save()){
					$aEgresos[] = array("nombre"   => $servicio->nombre,
								 	 	 "codigo"   => $servicio->codigo,
										 "cantidad" => $this->input->post('cantidad_serv'),
										 "costo"    => $servicio->costo_compra * $this->input->post('cantidad_serv'),
										 "id"       => $egreso_serv->id); 
				}

			}

			if($this->input->post('producto')){

				$egreso_prod = new Egreso();
				$producto     = new Producto();

				$producto->where('id',$this->input->post('producto'))->get();
				
				$egreso_prod->estatus	      = 1;			
				$egreso_prod->consultorio_id = $this->session->userdata('id_consultorio');
		   	 	$egreso_prod->fecha_alta     = date("Y-m-d H:i:s");
				$egreso_prod->costo          = $producto->costo_compra * $this->input->post('cantidad_prod');
				$egreso_prod->cantidad       = $this->input->post('cantidad_prod');
				$egreso_prod->producto_id    = $this->input->post('producto');
				
				if($egreso_prod->save()){
					$aEgresos[] = array("nombre"   => $producto->nombre,
								 	 	 "codigo"   => $producto->codigo,
										 "cantidad" => $this->input->post('cantidad_prod'),
										 "costo"    => $producto->costo_compra * $this->input->post('cantidad_prod'),
										 "id"       => $egreso_prod->id); 
				}

			}

			echo json_encode($aEgresos);
		}

	}


	public function delete(){

		if($this->input->post()){

			$egreso = new Egreso();
			$egreso->where('id', $this->input->post('idEgreso'))->get();

			if($egreso->delete()){
				echo json_encode(array('addDelete' => true));
			} else {
				echo json_encode(array('addDelete' => false));
			}			
			
		}

	}

}