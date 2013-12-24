<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sale extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('type_user'));
    }

	public function index(){

		$data['view']     = 'sistema/venta/venta';
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

				$ingreso_serv = new Ingreso();
				$servicio     = new Servicio();

				$servicio->where('id',$this->input->post('servicio'))->get();
				
				$ingreso_serv->estatus	      = 1;			
				$ingreso_serv->consultorio_id = $this->session->userdata('id_consultorio');
		   	 	$ingreso_serv->fecha_alta     = date("Y-m-d H:i:s");
				$ingreso_serv->costo          = $this->input->post('costo_serv') * $this->input->post('cantidad_serv');
				$ingreso_serv->paciente_id    = $this->input->post('pacienteId');
				$ingreso_serv->cantidad       = $this->input->post('cantidad_serv');
				$ingreso_serv->servicio_id    = $this->input->post('servicio');
				
				if($ingreso_serv->save()){
					$aIngresos[] = array("nombre"   => $servicio->nombre,
								 	 	 "codigo"   => $servicio->codigo,
										 "cantidad" => $this->input->post('cantidad_serv'),
										 "costo"    => $this->input->post('costo_serv') * $this->input->post('cantidad_serv'),
										 "id"       => $ingreso_serv->id); 
				}

			}

			if($this->input->post('producto')){

				$ingreso_prod = new Ingreso();
				$producto     = new Producto();

				$producto->where('id',$this->input->post('producto'))->get();
				
				$ingreso_prod->estatus	      = 1;			
				$ingreso_prod->consultorio_id = $this->session->userdata('id_consultorio');
		   	 	$ingreso_prod->fecha_alta     = date("Y-m-d H:i:s");
				$ingreso_prod->costo          = $this->input->post('costo_prod') * $this->input->post('cantidad_prod');
				$ingreso_prod->paciente_id    = $this->input->post('pacienteId');
				$ingreso_prod->cantidad       = $this->input->post('cantidad_prod');
				$ingreso_prod->producto_id    = $this->input->post('producto');
				
				if($ingreso_prod->save()){
					$aIngresos[] = array("nombre"   => $producto->nombre,
								 	 	 "codigo"   => $producto->codigo,
										 "cantidad" => $this->input->post('cantidad_prod'),
										 "costo"    => $this->input->post('costo_prod') * $this->input->post('cantidad_prod'),
										 "id"       => $ingreso_prod->id); 
				}

			}

			echo json_encode($aIngresos);
		}

	}


	public function delete(){

		if($this->input->post()){

			$ingreso = new Ingreso();
			$ingreso->where('id', $this->input->post('idIngreso'))->get();

			if($ingreso->delete()){
				echo json_encode(array('addDelete' => true));
			} else {
				echo json_encode(array('addDelete' => false));
			}			
			
		}

	}

}