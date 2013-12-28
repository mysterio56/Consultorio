<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Balance_sheet extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('type_user'));
    }

	public function index(){

		$data['view']     = 'sistema/balance/lista';
		$data['cssFiles'] = array('prototip.css',
								  'sistema.css',
								  'jquery-ui/jquery-ui.css');
		$data['jsFiles']  = array('jquery.js',
						     	  'jquery-ui.js',
							      'jquery.ui.datepicker-es.js',
							      'jquery-timepicker.js',
								  'valid_forms.js',
                                  'fancy-box/source/jquery.fancybox.pack.js');

		$this->load->view('sistema/template_simple',$data);

	}

	public function getTotalProducto(){

		$productos = new Producto();

		$productos->where('consultorio_id', $this->session->userdata('id_consultorio'));
		$productos->where('estatus', 1);

		if($this->input->post('producto')){

           $productos->where('id',  $this->input->post('producto'));

        }

		$productos->get();

		$totalIngreso = 0;
		$totalEgreso  = 0;
		
		foreach($productos as $producto){

			$producto->ingreso->where("estatus", 2);

			if ($this->input->post('date_start') && $this->input->post('date_end')){

				$producto->ingreso->where("DATE(fecha_alta) between '".$this->input->post('date_start')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end')."-01', INTERVAL 0 DAY))");
            	$producto->egreso->where("DATE(fecha_alta) between '".$this->input->post('date_start')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end')."-01', INTERVAL 0 DAY))");
				         	
        	} elseif ($this->input->post('date_start') && !$this->input->post('date_end')){

				$producto->ingreso->where("DATE(fecha_alta) between '".$this->input->post('date_start')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_start')."-01', INTERVAL 0 DAY))");
            	$producto->egreso->where("DATE(fecha_alta) between '".$this->input->post('date_start')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_start')."-01', INTERVAL 0 DAY))");
				         	
        	} elseif (!$this->input->post('date_start') && $this->input->post('date_end')){

				$producto->ingreso->where("DATE(fecha_alta) between '".$this->input->post('date_end')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end')."-01', INTERVAL 0 DAY))");
            	$producto->egreso->where("DATE(fecha_alta) between '".$this->input->post('date_end')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end')."-01', INTERVAL 0 DAY))");
				         	
        	} else {

        		$producto->ingreso->where("DATE(fecha_alta) between '".date("Y-m")."-01' and LAST_DAY(DATE_ADD('".date("Y-m")."-01', INTERVAL 0 DAY))");
            	$producto->egreso->where("DATE(fecha_alta) between '".date("Y-m")."-01' and LAST_DAY(DATE_ADD('".date("Y-m")."-01', INTERVAL 0 DAY))");

        	}

        	$producto->ingreso->get();
			$producto->egresos->get();
			
			foreach($producto->ingreso->all as $ingreso){
				$totalIngreso = $totalIngreso + $ingreso->costo;
			}

			foreach($producto->egreso->all as $egreso){
				$totalEgreso = $totalEgreso + $egreso->costo;
			}
			
		}

		echo $totalIngreso - $totalEgreso;        

	}

	public function getTotalServicio(){

		$servicios = new Servicio();

		$servicios->where('consultorio_id', $this->session->userdata('id_consultorio'));
		$servicios->where('estatus', 1);

		if($this->input->post('servicio')){

           $servicios->where('id',  $this->input->post('servicio'));

        }

		$servicios->get();

		$totalIngreso = 0;
		$totalEgreso  = 0;
		
		foreach($servicios as $servicio){

			$servicio->ingreso->where("estatus", 2);

			if ($this->input->post('date_start') && $this->input->post('date_end')){

				$servicio->ingreso->where("DATE(fecha_alta) between '".$this->input->post('date_start')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end')."-01', INTERVAL 0 DAY))");
            	$servicio->egreso->where("DATE(fecha_alta) between '".$this->input->post('date_start')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end')."-01', INTERVAL 0 DAY))");
				         	
        	} elseif ($this->input->post('date_start') && !$this->input->post('date_end')){

				$servicio->ingreso->where("DATE(fecha_alta) between '".$this->input->post('date_start')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_start')."-01', INTERVAL 0 DAY))");
            	$servicio->egreso->where("DATE(fecha_alta) between '".$this->input->post('date_start')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_start')."-01', INTERVAL 0 DAY))");
				         	
        	} elseif (!$this->input->post('date_start') && $this->input->post('date_end')){

				$servicio->ingreso->where("DATE(fecha_alta) between '".$this->input->post('date_end')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end')."-01', INTERVAL 0 DAY))");
            	$servicio->egreso->where("DATE(fecha_alta) between '".$this->input->post('date_end')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end')."-01', INTERVAL 0 DAY))");
				         	
        	} else {

        		$servicio->ingreso->where("DATE(fecha_alta) between '".date("Y-m")."-01' and LAST_DAY(DATE_ADD('".date("Y-m")."-01', INTERVAL 0 DAY))");
            	$servicio->egreso->where("DATE(fecha_alta) between '".date("Y-m")."-01' and LAST_DAY(DATE_ADD('".date("Y-m")."-01', INTERVAL 0 DAY))");

        	}

        	$servicio->ingreso->get();
			$servicio->egresos->get();
			
			foreach($servicio->ingreso->all as $ingreso){
				$totalIngreso = $totalIngreso + $ingreso->costo;
			}

			foreach($servicio->egreso->all as $egreso){
				$totalEgreso = $totalEgreso + $egreso->costo;
			}
			
		}

		echo $totalIngreso - $totalEgreso;
	
	}

	function gridProducto($page = 1){

		$productos = new Producto();

		$productos->where('consultorio_id', $this->session->userdata('id_consultorio'));
		$productos->where('estatus', 1);

		if($this->input->post('producto')){

           $productos->where('id',  $this->input->post('producto'));

        }

		$productos->get_paged_iterated($page, 9);

		foreach($productos as $producto){

			$totalIngreso = 0;
			$totalEgreso  = 0;

			$producto->ingreso->where("estatus", 2);

			if ($this->input->post('date_start') && $this->input->post('date_end')){

				$producto->ingreso->where("DATE(fecha_alta) between '".$this->input->post('date_start')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end')."-01', INTERVAL 0 DAY))");
            	$producto->egreso->where("DATE(fecha_alta) between '".$this->input->post('date_start')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end')."-01', INTERVAL 0 DAY))");
				         	
        	} elseif ($this->input->post('date_start') && !$this->input->post('date_end')){

				$producto->ingreso->where("DATE(fecha_alta) between '".$this->input->post('date_start')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_start')."-01', INTERVAL 0 DAY))");
            	$producto->egreso->where("DATE(fecha_alta) between '".$this->input->post('date_start')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_start')."-01', INTERVAL 0 DAY))");
				         	
        	} elseif (!$this->input->post('date_start') && $this->input->post('date_end')){

				$producto->ingreso->where("DATE(fecha_alta) between '".$this->input->post('date_end')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end')."-01', INTERVAL 0 DAY))");
            	$producto->egreso->where("DATE(fecha_alta) between '".$this->input->post('date_end')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end')."-01', INTERVAL 0 DAY))");
				         	
        	} else {

        		$producto->ingreso->where("DATE(fecha_alta) between '".date("Y-m")."-01' and LAST_DAY(DATE_ADD('".date("Y-m")."-01', INTERVAL 0 DAY))");
            	$producto->egreso->where("DATE(fecha_alta) between '".date("Y-m")."-01' and LAST_DAY(DATE_ADD('".date("Y-m")."-01', INTERVAL 0 DAY))");

        	}

        	$producto->ingreso->get();
			$producto->egresos->get();
			
			foreach($producto->ingreso->all as $ingreso){
				$totalIngreso = $totalIngreso + $ingreso->costo;
			}

			foreach($producto->egreso->all as $egreso){
				$totalEgreso = $totalEgreso + $egreso->costo;
			}

			$aProductos['data'][] = array('nombre'  => $producto->nombre,
										  'ingreso' => $totalIngreso,
										  'egreso'  => $totalEgreso,
										  'total'   => $totalIngreso - $totalEgreso);

		}

		if(isset($aProductos)){

    			$aProductos['page_total']    = $productos->paged->total_pages;
    			$aProductos['page_actual']   = $page;
    			$aProductos['has_previous']  = $productos->paged->has_previous;
    			$aProductos['has_next']      = $productos->paged->has_next;
    			$aProductos['previous_page'] = $productos->paged->previous_page;
    			$aProductos['next_page']     = $productos->paged->next_page;

				echo json_encode($aProductos);

			} else {

				echo json_encode(array('empty' => true)); 

			}

	}

	function gridServicio($page = 1){

		$servicios = new Servicio();

		$servicios->where('consultorio_id', $this->session->userdata('id_consultorio'));
		$servicios->where('estatus', 1);

		if($this->input->post('servicio')){

           $servicios->where('id',  $this->input->post('servicio'));

        }

		$servicios->get_paged_iterated($page, 9);

		foreach($servicios as $servicio){

			$totalIngreso = 0;
			$totalEgreso  = 0;

			$servicio->ingreso->where("estatus", 2);

			if ($this->input->post('date_start') && $this->input->post('date_end')){

				$servicio->ingreso->where("DATE(fecha_alta) between '".$this->input->post('date_start')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end')."-01', INTERVAL 0 DAY))");
            	$servicio->egreso->where("DATE(fecha_alta) between '".$this->input->post('date_start')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end')."-01', INTERVAL 0 DAY))");
				         	
        	} elseif ($this->input->post('date_start') && !$this->input->post('date_end')){

				$servicio->ingreso->where("DATE(fecha_alta) between '".$this->input->post('date_start')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_start')."-01', INTERVAL 0 DAY))");
            	$servicio->egreso->where("DATE(fecha_alta) between '".$this->input->post('date_start')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_start')."-01', INTERVAL 0 DAY))");
				         	
        	} elseif (!$this->input->post('date_start') && $this->input->post('date_end')){

				$servicio->ingreso->where("DATE(fecha_alta) between '".$this->input->post('date_end')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end')."-01', INTERVAL 0 DAY))");
            	$servicio->egreso->where("DATE(fecha_alta) between '".$this->input->post('date_end')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end')."-01', INTERVAL 0 DAY))");
				         	
        	} else {

        		$servicio->ingreso->where("DATE(fecha_alta) between '".date("Y-m")."-01' and LAST_DAY(DATE_ADD('".date("Y-m")."-01', INTERVAL 0 DAY))");
            	$servicio->egreso->where("DATE(fecha_alta) between '".date("Y-m")."-01' and LAST_DAY(DATE_ADD('".date("Y-m")."-01', INTERVAL 0 DAY))");

        	}

        	$servicio->ingreso->get();
			$servicio->egresos->get();
			
			foreach($servicio->ingreso->all as $ingreso){
				$totalIngreso = $totalIngreso + $ingreso->costo;
			}

			foreach($servicio->egreso->all as $egreso){
				$totalEgreso = $totalEgreso + $egreso->costo;
			}

			$aServicio['data'][] = array('nombre'  => $servicio->nombre,
										  'ingreso' => $totalIngreso,
										  'egreso'  => $totalEgreso,
										  'total'   => $totalIngreso - $totalEgreso);

		}

		if(isset($aServicio)){

    			$aServicio['page_total']    = $servicios->paged->total_pages;
    			$aServicio['page_actual']   = $page;
    			$aServicio['has_previous']  = $servicios->paged->has_previous;
    			$aServicio['has_next']      = $servicios->paged->has_next;
    			$aServicio['previous_page'] = $servicios->paged->previous_page;
    			$aServicio['next_page']     = $servicios->paged->next_page;

				echo json_encode($aServicio);

			} else {

				echo json_encode(array('empty' => true)); 

			}

	}

}
