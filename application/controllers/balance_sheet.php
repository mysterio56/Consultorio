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

		if($this->input->post('type_aux')){

			if($this->input->post('type_aux') == "ingreso"){
				echo $totalIngreso;
			} else {
				echo $totalEgreso;
			}

		}else{

			echo $totalIngreso - $totalEgreso;

		}
		

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

		if($this->input->post('type_aux')){

			if($this->input->post('type_aux') == "ingreso"){
				echo $totalIngreso;
			} else {
				echo $totalEgreso;
			}

		}else{

			echo $totalIngreso - $totalEgreso;

		}
	
	}

	function gridProducto($page = 1){

		$productos = new Producto();

		$productos->where('consultorio_id', $this->session->userdata('id_consultorio'));
		$productos->where('estatus', 1);

		if($this->input->post('producto')){

           $productos->where('id',  $this->input->post('producto'));

        }


        if(!$this->input->post('imprimir')){

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

				$aProductos['data'][] = array('id'      => $producto->id,
											  'nombre'  => $producto->nombre,
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

		} else {

			$productos->get();  

            $this->load->library('Pdf');

            $imgConsultorio = new Consultorio();
            $imgConsultorio->where('id',$this->session->userdata('id_consultorio'))->get();
            $imgConsultorio = $imgConsultorio->nombre_logo;

            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);

            $pdf->SetFont('Helvetica', '', 14, '', true); 

            $pdf->AddPage();
     
            $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
            $pdf->setImageScale(0.47);

            $pdf->Image(base_url('assets/images/logos/'.$imgConsultorio.'_logo.png'), 10, 10, 45, 25, '', '', '', false, 300);

            $html  = $this->_css().' <table class="table">';
            $html .= '<thead>
                        <tr>
                            <th class="th">Producto</th>
                            <th class="th">Egreso</th>
                            <th class="th">Ingreso</th>
                            <th class="th">Balance</th>
                        </tr>
                    </thead>';
            $html .= '<tbody>';  

            foreach ($productos->all as $key => $producto) {

                if ((($key+1) % 2) == 0) {
                        $rowClass = "even";
                    } else  {
                        $rowClass = "odd";
                    }

                $totalIngreso = 0;
				$totalEgreso  = 0;

				$producto->ingreso->where("estatus", 2);
		
				if ($this->input->post('date_start_alt') && $this->input->post('date_end_alt')){

					$dPdf_start = explode('-',$this->input->post('date_start_alt'));
					$dPdf_start = month(($dPdf_start[1]-1),false)." ".$dPdf_start[0];
					$dPdf_end   = explode('-',$this->input->post('date_end_alt'));
					$dPdf_end   = month(($dPdf_end[1]-1),false)." ".$dPdf_end[0];

					$producto->ingreso->where("DATE(fecha_alta) between '".$this->input->post('date_start_alt')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end_alt')."-01', INTERVAL 0 DAY))");
	            	$producto->egreso->where("DATE(fecha_alta) between '".$this->input->post('date_start_alt')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end_alt')."-01', INTERVAL 0 DAY))");
					         	
	        	} elseif ($this->input->post('date_start_alt') && !$this->input->post('date_end_alt')){

	        		$dPdf_start = explode('-',$this->input->post('date_start_alt'));
					$dPdf_start = month(($dPdf_start[1]-1),false)." ".$dPdf_start[0];

					$producto->ingreso->where("DATE(fecha_alta) between '".$this->input->post('date_start_alt')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_start_alt')."-01', INTERVAL 0 DAY))");
	            	$producto->egreso->where("DATE(fecha_alta) between '".$this->input->post('date_start_alt')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_start_alt')."-01', INTERVAL 0 DAY))");

					         	
	        	} elseif (!$this->input->post('date_start_alt') && $this->input->post('date_end_alt')){

	        		$dPdf_end   = explode('-',$this->input->post('date_end_alt'));
					$dPdf_end   = month(($dPdf_end[1]-1),false)." ".$dPdf_end[0];

					$producto->ingreso->where("DATE(fecha_alta) between '".$this->input->post('date_end_alt')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end_alt')."-01', INTERVAL 0 DAY))");
	            	$producto->egreso->where("DATE(fecha_alta) between '".$this->input->post('date_end_alt')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end_alt')."-01', INTERVAL 0 DAY))");
					         	
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

				$balance = $totalIngreso - $totalEgreso;

                $html .= '<tr class="'.$rowClass.'">';
                $html .= '<td class="td">'.$producto->nombre.'</td>';
                $html .= '<td class="td" align="right">$ '.number_format($totalEgreso, 2, '.', ',').'</td>';
                $html .= '<td class="td" align="right">$ '.number_format($totalIngreso, 2, '.', ',').'</td>';
                $html .= '<td class="td" align="right">$ '.number_format($balance, 2, '.', ',').'</td>';
                $html .= '</tr>';
            }

            $html .= '</tbody>';
            $html .= '</table>';
     
     		if(isset($dPdf_start) && isset($dPdf_end)){

                $fecha = $dPdf_start ." al ". $dPdf_end;                    

            }elseif(isset($dPdf_start) && !isset($dPdf_end)){

                $fecha = $dPdf_start;                    

            }elseif(isset($dPdf_end) && !isset($dPdf_start)){

                $fecha = $dPdf_end;                    

            }else{

                $fecha = month((date('m')-1),false). " / ". date('Y');

            }    

            $pdf->writeHTMLCell(0, 0, 60, 15, '<h1 style="font-size:8px;">Balance de '.$fecha.'</h1>', 0, 1,  0, true, '', true);

            $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 40, $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

            $pdf->writeHTMLCell(0, 0, 140, '', '<h1 style="font-size:8px;">Total: <strong>$ '.number_format($this->input->post('inputTotalProducto'), 2, '.', ',').'</strong></h1>', 0, 1,  0, true, '', true);

            $nombre_archivo = utf8_decode("Balance.pdf");

            $pdf->Output($nombre_archivo, 'I');

		}

	}

	function gridServicio($page = 1){

		$servicios = new Servicio();

		$servicios->where('consultorio_id', $this->session->userdata('id_consultorio'));
		$servicios->where('estatus', 1);

		if($this->input->post('servicio')){

           $servicios->where('id',  $this->input->post('servicio'));

        }

        if(!$this->input->post('imprimir')){

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

				$aServicio['data'][] = array( 'id'      => $servicio->id,
											  'nombre'  => $servicio->nombre,
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

		} else {

			$servicios->get();  

            $this->load->library('Pdf');

            $imgConsultorio = new Consultorio();
            $imgConsultorio->where('id',$this->session->userdata('id_consultorio'))->get();
            $imgConsultorio = $imgConsultorio->nombre_logo;

            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);

            $pdf->SetFont('Helvetica', '', 14, '', true); 

            $pdf->AddPage();
     
            $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
            $pdf->setImageScale(0.47);

            $pdf->Image(base_url('assets/images/logos/'.$imgConsultorio.'_logo.png'), 10, 10, 45, 25, '', '', '', false, 300);

            $html  = $this->_css().' <table class="table">';
            $html .= '<thead>
                        <tr>
                            <th class="th">Producto</th>
                            <th class="th">Egreso</th>
                            <th class="th">Ingreso</th>
                            <th class="th">Balance</th>
                        </tr>
                    </thead>';
            $html .= '<tbody>';  

            foreach ($servicios->all as $key => $servicio) {

                if ((($key+1) % 2) == 0) {
                        $rowClass = "even";
                    } else  {
                        $rowClass = "odd";
                    }

                $totalIngreso = 0;
				$totalEgreso  = 0;
				
				$servicio->ingreso->where("estatus", 2);
				
				if ($this->input->post('date_start_alt') && $this->input->post('date_end_alt')){

					$dPdf_start = explode('-',$this->input->post('date_start_alt'));
					$dPdf_start = month(($dPdf_start[1]-1),false)." ".$dPdf_start[0];
					$dPdf_end   = explode('-',$this->input->post('date_end_alt'));
					$dPdf_end   = month(($dPdf_end[1]-1),false)." ".$dPdf_end[0];

					$servicio->ingreso->where("DATE(fecha_alta) between '".$this->input->post('date_start_alt')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end_alt')."-01', INTERVAL 0 DAY))");
	            	$servicio->egreso->where("DATE(fecha_alta) between '".$this->input->post('date_start_alt')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end_alt')."-01', INTERVAL 0 DAY))");
					         	
	        	} elseif ($this->input->post('date_start_alt') && !$this->input->post('date_end_alt')){

	        		$dPdf_start = explode('-',$this->input->post('date_start_alt'));
					$dPdf_start = month(($dPdf_start[1]-1),false)." ".$dPdf_start[0];

					$servicio->ingreso->where("DATE(fecha_alta) between '".$this->input->post('date_start_alt')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_start_alt')."-01', INTERVAL 0 DAY))");
	            	$servicio->egreso->where("DATE(fecha_alta) between '".$this->input->post('date_start_alt')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_start_alt')."-01', INTERVAL 0 DAY))");

					         	
	        	} elseif (!$this->input->post('date_start_alt') && $this->input->post('date_end_alt')){

	        		$dPdf_end   = explode('-',$this->input->post('date_end_alt'));
					$dPdf_end   = month(($dPdf_end[1]-1),false)." ".$dPdf_end[0];

					$servicio->ingreso->where("DATE(fecha_alta) between '".$this->input->post('date_end_alt')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end_alt')."-01', INTERVAL 0 DAY))");
	            	$servicio->egreso->where("DATE(fecha_alta) between '".$this->input->post('date_end_alt')."-01' and LAST_DAY(DATE_ADD('".$this->input->post('date_end_alt')."-01', INTERVAL 0 DAY))");
					         	
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

				$balance = $totalIngreso - $totalEgreso;

                $html .= '<tr class="'.$rowClass.'">';
                $html .= '<td class="td">'.$servicio->nombre.'</td>';
                $html .= '<td class="td" align="right">$ '.number_format($totalEgreso, 2, '.', ',').'</td>';
                $html .= '<td class="td" align="right">$ '.number_format($totalIngreso, 2, '.', ',').'</td>';
                $html .= '<td class="td" align="right">$ '.number_format($balance, 2, '.', ',').'</td>';
                $html .= '</tr>';
            }

            $html .= '</tbody>';
            $html .= '</table>';
     
     		if(isset($dPdf_start) && isset($dPdf_end)){

                $fecha = $dPdf_start ." al ". $dPdf_end;                    

            }elseif(isset($dPdf_start) && !isset($dPdf_end)){

                $fecha = $dPdf_start;                    

            }elseif(isset($dPdf_end) && !isset($dPdf_start)){

                $fecha = $dPdf_end;                    

            }else{

                $fecha = month((date('m')-1),false). " / ". date('Y');

            }    

            $pdf->writeHTMLCell(0, 0, 60, 15, '<h1 style="font-size:8px;">Balance de '.$fecha.'</h1>', 0, 1,  0, true, '', true);

            $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 40, $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

            $pdf->writeHTMLCell(0, 0, 140, '', '<h1 style="font-size:8px;">Total: <strong>$ '.number_format($this->input->post('inputTotalServicio'), 2, '.', ',').'</strong></h1>', 0, 1,  0, true, '', true);

            $nombre_archivo = utf8_decode("Balance.pdf");

            $pdf->Output($nombre_archivo, 'I');

		}

	}


	public function detailProducto($id = null, $type = null, $date_start, $date_end, $page = 1, $imprimir = null){

		$producto = new Producto();

		$producto->where('id', $id)->get();

		$producto->ingreso->where('estatus', 2);	
 
		if($date_start != 'false' && $date_end != 'false'){

			$date_start = $date_start / 1000; 
	        $date_end   = $date_end / 1000;

	        $date_start = date("Y-m-d", $date_start);
	        $date_end   = date("Y-m-d", $date_end);

			$producto->ingreso->where("DATE(fecha_alta) between '".$date_start."' and LAST_DAY(DATE_ADD('".$date_end."', INTERVAL 0 DAY))");
	    	$producto->egreso->where("DATE(fecha_alta) between '".$date_start."' and LAST_DAY(DATE_ADD('".$date_end."', INTERVAL 0 DAY))");
			         	
		} elseif ($date_start != 'false' && $date_end == 'false'){

			$date_start = $date_start / 1000; 
			$date_start = date("Y-m-d", $date_start);

			$producto->ingreso->where("DATE(fecha_alta) between '".$date_start."' and LAST_DAY(DATE_ADD('".$date_start."', INTERVAL 0 DAY))");
	    	$producto->egreso->where("DATE(fecha_alta) between '".$date_start."' and LAST_DAY(DATE_ADD('".$date_start."', INTERVAL 0 DAY))");

			         	
		} elseif ($date_start == 'false' && $date_end != 'false'){

			$date_end = $date_end / 1000; 
			$date_end = date("Y-m-d", $date_end);

			$producto->ingreso->where("DATE(fecha_alta) between '".$date_end."' and LAST_DAY(DATE_ADD('".$date_end."', INTERVAL 0 DAY))");
	    	$producto->egreso->where("DATE(fecha_alta) between '".$date_end."' and LAST_DAY(DATE_ADD('".$date_end."', INTERVAL 0 DAY))");
			         	
		} else {

			$producto->ingreso->where("DATE(fecha_alta) between '".date("Y-m")."-01' and LAST_DAY(DATE_ADD('".date("Y-m")."-01', INTERVAL 0 DAY))");
	    	$producto->egreso->where("DATE(fecha_alta) between '".date("Y-m")."-01' and LAST_DAY(DATE_ADD('".date("Y-m")."-01', INTERVAL 0 DAY))");

		}

		if($type == "ingreso"){

			$detail = $producto->ingreso->get_paged_iterated($page,6);

		} elseif($type == "egreso") {

			$detail = $producto->egreso->get_paged_iterated($page,6);

		}

		$data['view']         = 'sistema/balance/detalle';
		$data['detail']       = $detail;
		$data['tipo']         = $type;
		$data['id']           = $id;
		$data['paginaActual'] = $page;
		$data['date_start']   = $date_start;
        $data['date_end']     = $date_end;
        $data['nombre']       = $producto->nombre;
        $data['typeDetail']   = "Producto";
		$data['cssFiles']     = array('sistema.css',
							     	  'jquery-ui/jquery-ui.css');
		$data['jsFiles']      = array('jquery.js',
						         	  'jquery-ui.js',
							          'jquery.ui.datepicker-es.js');

		$this->load->view('sistema/template_simple',$data);

	}

	public function detailServicio($id = null, $type = null, $date_start, $date_end, $page = 1, $imprimir = null){

		$servicio = new Servicio();

		$servicio->where('id', $id)->get();

		$servicio->ingreso->where('estatus', 2);	
 
		if($date_start != 'false' && $date_end != 'false'){

			$date_start = $date_start / 1000; 
	        $date_end   = $date_end / 1000;

	        $date_start = date("Y-m-d", $date_start);
	        $date_end   = date("Y-m-d", $date_end);

			$servicio->ingreso->where("DATE(fecha_alta) between '".$date_start."' and LAST_DAY(DATE_ADD('".$date_end."', INTERVAL 0 DAY))");
	    	$servicio->egreso->where("DATE(fecha_alta) between '".$date_start."' and LAST_DAY(DATE_ADD('".$date_end."', INTERVAL 0 DAY))");
			         	
		} elseif ($date_start != 'false' && $date_end == 'false'){

			$date_start = $date_start / 1000; 
			$date_start = date("Y-m-d", $date_start);

			$servicio->ingreso->where("DATE(fecha_alta) between '".$date_start."' and LAST_DAY(DATE_ADD('".$date_start."', INTERVAL 0 DAY))");
	    	$servicio->egreso->where("DATE(fecha_alta) between '".$date_start."' and LAST_DAY(DATE_ADD('".$date_start."', INTERVAL 0 DAY))");

			         	
		} elseif ($date_start == 'false' && $date_end != 'false'){

			$date_end = $date_end / 1000; 
			$date_end = date("Y-m-d", $date_end);

			$servicio->ingreso->where("DATE(fecha_alta) between '".$date_end."' and LAST_DAY(DATE_ADD('".$date_end."', INTERVAL 0 DAY))");
	    	$servicio->egreso->where("DATE(fecha_alta) between '".$date_end."' and LAST_DAY(DATE_ADD('".$date_end."', INTERVAL 0 DAY))");
			         	
		} else {

			$servicio->ingreso->where("DATE(fecha_alta) between '".date("Y-m")."-01' and LAST_DAY(DATE_ADD('".date("Y-m")."-01', INTERVAL 0 DAY))");
	    	$servicio->egreso->where("DATE(fecha_alta) between '".date("Y-m")."-01' and LAST_DAY(DATE_ADD('".date("Y-m")."-01', INTERVAL 0 DAY))");

		}

		if($type == "ingreso"){

			$detail = $servicio->ingreso->get_paged_iterated($page,6);

		} elseif($type == "egreso") {
			
			$detail = $servicio->egreso->get_paged_iterated($page,6);

		}	 

		$data['view']         = 'sistema/balance/detalle';
		$data['detail']       = $detail;
		$data['tipo']         = $type;
		$data['id']           = $id;
		$data['paginaActual'] = $page;
		$data['date_start']   = $date_start;
        $data['date_end']     = $date_end;
        $data['nombre']       = $servicio->nombre;
        $data['typeDetail']   = "Servicio";
		$data['cssFiles']     = array('sistema.css',
							     	  'jquery-ui/jquery-ui.css');
		$data['jsFiles']      = array('jquery.js',
						         	  'jquery-ui.js',
							          'jquery.ui.datepicker-es.js');

		$this->load->view('sistema/template_simple',$data);

	}


	public function detailImprimir($id = null, $type = null, $date_start, $date_end, $page = 1, $imprimir = null){

		$servicio = new Servicio();
		$producto = new Producto();

		$servicio->where('id', $id)->get();
		$producto->where('id', $id)->get();

		$servicio->ingreso->where('estatus', 2);
		$producto->ingreso->where('estatus', 2);	
 
		if($date_start != 'false' && $date_end != 'false'){

			$date_start = $date_start / 1000; 
	        $date_end   = $date_end / 1000;

	        $dPdf_start = month(date("m", $date_start)-1,false).' '.date("Y", $date_start);
	        $dPdf_end = month(date("m", $date_end)-1,false).' '.date("Y", $date_end);

	        $date_start = date("Y-m-d", $date_start);
	        $date_end   = date("Y-m-d", $date_end);

			$servicio->ingreso->where("DATE(fecha_alta) between '".$date_start."' and LAST_DAY(DATE_ADD('".$date_end."', INTERVAL 0 DAY))");
	    	$servicio->egreso->where("DATE(fecha_alta) between '".$date_start."' and LAST_DAY(DATE_ADD('".$date_end."', INTERVAL 0 DAY))");

	    	$producto->ingreso->where("DATE(fecha_alta) between '".$date_start."' and LAST_DAY(DATE_ADD('".$date_end."', INTERVAL 0 DAY))");
	    	$producto->egreso->where("DATE(fecha_alta) between '".$date_start."' and LAST_DAY(DATE_ADD('".$date_end."', INTERVAL 0 DAY))");
			         	
		} elseif ($date_start != 'false' && $date_end == 'false'){

			$date_start = $date_start / 1000; 

			$dPdf_start = month(date("m", $date_start)-1,false).' '.date("Y", $date_start);
			$date_start = date("Y-m-d", $date_start);

			$servicio->ingreso->where("DATE(fecha_alta) between '".$date_start."' and LAST_DAY(DATE_ADD('".$date_start."', INTERVAL 0 DAY))");
	    	$servicio->egreso->where("DATE(fecha_alta) between '".$date_start."' and LAST_DAY(DATE_ADD('".$date_start."', INTERVAL 0 DAY))");

	    	$producto->ingreso->where("DATE(fecha_alta) between '".$date_start."' and LAST_DAY(DATE_ADD('".$date_start."', INTERVAL 0 DAY))");
	    	$producto->egreso->where("DATE(fecha_alta) between '".$date_start."' and LAST_DAY(DATE_ADD('".$date_start."', INTERVAL 0 DAY))");
			         	
		} elseif ($date_start == 'false' && $date_end != 'false'){

			$date_end = $date_end / 1000; 

			$dPdf_end = month(date("m", $date_end)-1,false).' '.date("Y", $date_end);
			$date_end = date("Y-m-d", $date_end);

			$servicio->ingreso->where("DATE(fecha_alta) between '".$date_end."' and LAST_DAY(DATE_ADD('".$date_end."', INTERVAL 0 DAY))");
	    	$servicio->egreso->where("DATE(fecha_alta) between '".$date_end."' and LAST_DAY(DATE_ADD('".$date_end."', INTERVAL 0 DAY))");

	    	$producto->ingreso->where("DATE(fecha_alta) between '".$date_end."' and LAST_DAY(DATE_ADD('".$date_end."', INTERVAL 0 DAY))");
	    	$producto->egreso->where("DATE(fecha_alta) between '".$date_end."' and LAST_DAY(DATE_ADD('".$date_end."', INTERVAL 0 DAY))");
			         	
		} else {

			$servicio->ingreso->where("DATE(fecha_alta) between '".date("Y-m")."-01' and LAST_DAY(DATE_ADD('".date("Y-m")."-01', INTERVAL 0 DAY))");
	    	$servicio->egreso->where("DATE(fecha_alta) between '".date("Y-m")."-01' and LAST_DAY(DATE_ADD('".date("Y-m")."-01', INTERVAL 0 DAY))");

	    	$producto->ingreso->where("DATE(fecha_alta) between '".date("Y-m")."-01' and LAST_DAY(DATE_ADD('".date("Y-m")."-01', INTERVAL 0 DAY))");
	    	$producto->egreso->where("DATE(fecha_alta) between '".date("Y-m")."-01' and LAST_DAY(DATE_ADD('".date("Y-m")."-01', INTERVAL 0 DAY))");

		}

		if(isset($dPdf_start) && isset($dPdf_end)){

            $fecha = $dPdf_start ." al ". $dPdf_end;                    

        }elseif(isset($dPdf_start) && !isset($dPdf_end)){

            $fecha = $dPdf_start;                    

        }elseif(isset($dPdf_end) && !isset($dPdf_start)){

            $fecha = $dPdf_end;                    

        }else{

            $fecha = month((date('m')-1),false). " / ". date('Y');

        }  

		if($type == "producto") {

			$detailIngresos = $producto->ingreso->get();
			$detailEgreso   = $producto->egreso->get();
			$nombre         = $producto->nombre;

		} else {

			$detailIngresos = $servicio->ingreso->get();
			$detailEgreso   = $servicio->egreso->get();
			$nombre         = $servicio->nombre;
			
		}

		$this->load->library('Pdf');

		$imgConsultorio = new Consultorio();
        $imgConsultorio->where('id',$this->session->userdata('id_consultorio'))->get();
        $imgConsultorio = $imgConsultorio->nombre_logo;

        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);

        $pdf->SetFont('Helvetica', '', 14, '', true); 

        $pdf->AddPage();
 
        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

        $pdf->setImageScale(0.47);

        $pdf->Image(base_url('assets/images/logos/'.$imgConsultorio.'_logo.png'), 10, 10, 45, 25, '', '', '', false, 300);

        $html  = $this->_css().' <table class="table">';
        $html .= '<thead>
                    <tr>
                        <th class="th" style="width:60px;">Fecha/Hora</th>
                        <th class="th">Por Cita</th>
       					<th class="th">Cantidad</th>
                        <th class="th">Costo</th>
                        <th class="th">Total</th>
                    </tr>
                </thead>';
        $html .= '<tbody>'; 

        $total = 0;

        foreach ($detailIngresos->all as $key => $detalle) {

        	if ((($key+1) % 2) == 0) {
                        $rowClass = "even";
                    } else  {
                        $rowClass = "odd";
                    }

            $html .= '<tr class="'.$rowClass.'">';
        	$html .= '<td class="td" style="width:60px;">'.date("d", strtotime($detalle->fecha_alta)).'/'.
            					month(date("m", strtotime($detalle->fecha_alta))-1,false).'/'.
            					date("Y H:i", strtotime($detalle->fecha_alta)).'</td>';

        	$porCita = $detalle->cita_id?"Si":"";
        	$html .= '<td class="td">'.$porCita.'</td>';

        	$html .= '<td class="td" style="text-align: right;">'.$detalle->cantidad.'</td>';
        	$html .= '<td class="td" style="text-align: right;">$ '.number_format(($detalle->costo/$detalle->cantidad), 2, '.', ',').'</td>'; 
        	$html .= '<td class="td" style="text-align: right;">$ '.number_format($detalle->costo, 2, '.', ',').'</td>'; 

        	$html .= '</tr>';

        	$total = $total + $detalle->costo;

        }

        $html .= '</tbody>';
        $html .= '</table>';  

        $pdf->writeHTMLCell(0, 0, 60, 15, '<h1 style="font-size:8px;">Balance de '.$fecha.'</h1>', 0, 1,  0, true, '', true);

        $pdf->writeHTMLCell(0, 0, 60, 25, '<h1 style="font-size:8px;">Ingresos de '.$nombre.'</h1>', 0, 1,  0, true, '', true);

        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 40, $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

        $pdf->writeHTMLCell(0, 0, 140, '', '<h1 style="font-size:8px;">Total: <strong>$ '.number_format($total, 2, '.', ',').'</strong></h1>', 0, 1,  0, true, '', true);

        $pdf->AddPage();
 
        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

        $pdf->setImageScale(0.47);

        $pdf->Image(base_url('assets/images/logos/'.$imgConsultorio.'_logo.png'), 10, 10, 45, 25, '', '', '', false, 300);

        $html  = $this->_css().' <table class="table">';
        $html .= '<thead>
                    <tr>
                        <th class="th" style="width:60px;">Fecha/Hora</th>
       					<th class="th">Cantidad</th>
                        <th class="th">Costo</th>
                        <th class="th">Total</th>
                    </tr>
                </thead>';
        $html .= '<tbody>'; 

        $total = 0;

        foreach ($detailEgreso->all as $key => $detalle) {

        	if ((($key+1) % 2) == 0) {
                        $rowClass = "even";
                    } else  {
                        $rowClass = "odd";
                    }

            $html .= '<tr class="'.$rowClass.'">';
        	$html .= '<td class="td" style="width:60px;">'.date("d", strtotime($detalle->fecha_alta)).'/'.
            					month(date("m", strtotime($detalle->fecha_alta))-1,false).'/'.
            					date("Y H:i", strtotime($detalle->fecha_alta)).'</td>';

        	$html .= '<td class="td" style="text-align: right;">'.$detalle->cantidad.'</td>';
        	$html .= '<td class="td" style="text-align: right;">$ '.number_format(($detalle->costo/$detalle->cantidad), 2, '.', ',').'</td>'; 
        	$html .= '<td class="td" style="text-align: right;">$ '.number_format($detalle->costo, 2, '.', ',').'</td>'; 

        	$html .= '</tr>';

        	$total = $total + $detalle->costo;

        }

        $html .= '</tbody>';
        $html .= '</table>';

        $pdf->writeHTMLCell(0, 0, 60, 15, '<h1 style="font-size:8px;">Balance de '.$fecha.'</h1>', 0, 1,  0, true, '', true);

        $pdf->writeHTMLCell(0, 0, 60, 25, '<h1 style="font-size:8px;">Egresos de '.$nombre.'</h1>', 0, 1,  0, true, '', true);

        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 40, $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

        $pdf->writeHTMLCell(0, 0, 140, '', '<h1 style="font-size:8px;">Total: <strong>$ '.number_format($total, 2, '.', ',').'</strong></h1>', 0, 1,  0, true, '', true);

        $nombre_archivo = utf8_decode("Detalle-Balance.pdf");

        $pdf->Output($nombre_archivo, 'I');

	}


	private function _css(){
     
     return " <style> 

        .table {
          width: 100%; 
        }

        .th {
        padding: 3px 5px;
        background-color:#4cbade;
        color:#005d7b;
        font-size: 7px;
        border: 0.5px solid #0070A8;
        font-weight:bold;
        }

        .td {
        padding: 3px 5px;
        font-size: 6px;
        border: 0.5px solid #0070A8;
        }

        .even {
            background-color: #CEECF5;  
        }

    </style>";

    }

}