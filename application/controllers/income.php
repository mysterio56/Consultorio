<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Income extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('type_user'));
    }

	public function index(){

		$data['view']     = 'sistema/ingresos/lista';
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

    public function getTotal(){

        $ingresos = new Ingreso();
        
        $ingresos->select(' sum(costo) sumCosto ' );
        $ingresos->where('consultorio_id', $this->session->userdata('id_consultorio'));
        
        if($this->input->post('producto') && $this->input->post('servicio')){

            $ingresos->where('(producto_id = '. $this->input->post('producto') . ' or  servicio_id = '. $this->input->post('servicio') .')' );

        }

        if($this->input->post('producto') && !$this->input->post('servicio')){

            $ingresos->where('producto_id',  $this->input->post('producto'));

        }

        if($this->input->post('servicio') && !$this->input->post('producto')){

            $ingresos->where('servicio_id',  $this->input->post('servicio'));

        }

        if($this->input->post('date_start') && $this->input->post('date_end')){

            $date_start = explode("/",$this->input->post('date_start'));
            $date_start = $date_start[2].'-'.$date_start[1].'-'.$date_start[0];

            $date_end   = explode("/",$this->input->post('date_end'));
            $date_end   = $date_end[2].'-'.$date_end[1].'-'.$date_end[0];

            $ingresos->where("DATE(fecha_alta) between '".$date_start."' and '".$date_end."'");
            $ingresos->order_by(' fecha_alta ', 'ASC ');

        } elseif($this->input->post('date_start') && !$this->input->post('date_end')){

            $date_start = explode("/",$this->input->post('date_start'));
            $date_start = $date_start[2].'-'.$date_start[1].'-'.$date_start[0];

            $ingresos->where('DATE(fecha_alta)' ,$date_start);
            $ingresos->order_by(' fecha_alta ', 'ASC ');

        
        } elseif($this->input->post('date_end') && !$this->input->post('date_start')){

            $date_end = explode("/",$this->input->post('date_end'));
            $date_end = $date_end[2].'-'.$date_end[1].'-'.$date_end[0];

            $ingresos->where('DATE(fecha_alta)' ,$date_end);
            $ingresos->order_by(' fecha_alta ', 'ASC ');

        } else {

            $ingresos->where('DATE(fecha_alta) = CURRENT_DATE');

        }

        $ingresos->where(' cita_id IS NULL ');

        $ingresos->get();

        echo $ingresos->sumCosto;

    }

    public function getTotalCitas(){

        $ingresos = new Ingreso();
        
        $ingresos->select(' sum(costo) sumCosto ' );
        $ingresos->where('consultorio_id', $this->session->userdata('id_consultorio'));
        
        if($this->input->post('producto') && $this->input->post('servicio')){

            $ingresos->where('(producto_id = '. $this->input->post('producto') . ' or  servicio_id = '. $this->input->post('servicio') .')' );

        }

        if($this->input->post('producto') && !$this->input->post('servicio')){

            $ingresos->where('producto_id',  $this->input->post('producto'));

        }

        if($this->input->post('servicio') && !$this->input->post('producto')){

            $ingresos->where('servicio_id',  $this->input->post('servicio'));

        }

        if($this->input->post('date_start') && $this->input->post('date_end')){

            $date_start = explode("/",$this->input->post('date_start'));
            $date_start = $date_start[2].'-'.$date_start[1].'-'.$date_start[0];

            $date_end   = explode("/",$this->input->post('date_end'));
            $date_end   = $date_end[2].'-'.$date_end[1].'-'.$date_end[0];

            $ingresos->where("DATE(fecha_alta) between '".$date_start."' and '".$date_end."'");
            $ingresos->order_by(' fecha_alta ', 'ASC ');

        } elseif($this->input->post('date_start') && !$this->input->post('date_end')){

            $date_start = explode("/",$this->input->post('date_start'));
            $date_start = $date_start[2].'-'.$date_start[1].'-'.$date_start[0];

            $ingresos->where('DATE(fecha_alta)' ,$date_start);
            $ingresos->order_by(' fecha_alta ', 'ASC ');

        
        } elseif($this->input->post('date_end') && !$this->input->post('date_start')){

            $date_end = explode("/",$this->input->post('date_end'));
            $date_end = $date_end[2].'-'.$date_end[1].'-'.$date_end[0];

            $ingresos->where('DATE(fecha_alta)' ,$date_end);
            $ingresos->order_by(' fecha_alta ', 'ASC ');

        } else {

            $ingresos->where('DATE(fecha_alta) = CURRENT_DATE');

        }

        $ingresos->where(' cita_id IS NOT NULL ');
        $ingresos->where('estatus', 2 );

        $ingresos->get();

         echo $ingresos->sumCosto;

    }

    public function gridPS($page = 1){

        $ingresos = new Ingreso();
        $count    = new Ingreso();
        
        $ingresos->select(' *, sum(costo) as sumCosto, sum(cantidad) as sumCantidad ' );
        $count->select(' id ' );
        $ingresos->where('consultorio_id', $this->session->userdata('id_consultorio'));
        $count->where('consultorio_id', $this->session->userdata('id_consultorio'));
        
        if($this->input->post('producto') && $this->input->post('servicio')){

            $ingresos->where('(producto_id = '. $this->input->post('producto') . ' or  servicio_id = '. $this->input->post('servicio') .')' );
            $count->where('(producto_id = '. $this->input->post('producto') . ' or  servicio_id = '. $this->input->post('servicio') .')' );

        }

        if($this->input->post('producto') && !$this->input->post('servicio')){

            $ingresos->where('producto_id',  $this->input->post('producto'));
            $count->where('producto_id',  $this->input->post('producto'));


        }

        if($this->input->post('servicio') && !$this->input->post('producto')){

            $ingresos->where('servicio_id',  $this->input->post('servicio'));
            $count->where('servicio_id',  $this->input->post('servicio'));

        }

        if($this->input->post('date_start') && $this->input->post('date_end')){

            $date_start = explode("/",$this->input->post('date_start'));
            $dPdf_start = $date_start[0].' / '.month(($date_start[1]-1),false).' / '.$date_start[2];
            $date_start = $date_start[2].'-'.$date_start[1].'-'.$date_start[0];

            $date_end   = explode("/",$this->input->post('date_end'));
            $dPdf_end   = $date_end[0].' / '.month(($date_end[1]-1),false).' / '.$date_end[2];
            $date_end   = $date_end[2].'-'.$date_end[1].'-'.$date_end[0];

            $ingresos->where("DATE(fecha_alta) between '".$date_start."' and '".$date_end."'");
            $count->where("DATE(fecha_alta) between '".$date_start."' and '".$date_end."'");

            $ingresos->order_by(' fecha_alta ', 'ASC ');

        } elseif($this->input->post('date_start') && !$this->input->post('date_end')){

            $date_start = explode("/",$this->input->post('date_start'));
            $dPdf_start = $date_start[0].' / '.month(($date_start[1]-1),false).' / '.$date_start[2];
            $date_start = $date_start[2].'-'.$date_start[1].'-'.$date_start[0];

            $ingresos->where('DATE(fecha_alta)' ,$date_start);
            $count->where('DATE(fecha_alta)' ,$date_start);

            $ingresos->order_by(' fecha_alta ', 'ASC ');

        
        } elseif($this->input->post('date_end') && !$this->input->post('date_start')){

            $date_end = explode("/",$this->input->post('date_end'));
            $dPdf_end = $date_end[0].' / '.month(($date_end[1]-1),false).' / '.$date_end[2];
            $date_end = $date_end[2].'-'.$date_end[1].'-'.$date_end[0];

            $ingresos->where('DATE(fecha_alta)' ,$date_end);
            $count->where('DATE(fecha_alta)' ,$date_end);
            $ingresos->order_by(' fecha_alta ', 'ASC ');

        } else {

            $ingresos->where('DATE(fecha_alta) = CURRENT_DATE');
            $count->where('DATE(fecha_alta) = CURRENT_DATE');

        }

        $ingresos->where('cita_id IS NULL');
        $count->where('cita_id IS NULL');

        $ingresos->group_by(' servicio_id , producto_id ');

        if(!$this->input->post('imprimir')){

            $count->group_by(' servicio_id , producto_id ')->get();

            $TAMANO_PAGINA = 7;

            if ($page == 1) { 
                 $inicio = 0;  
            } 
            else { 
                $inicio = ($page - 1) * $TAMANO_PAGINA; 
            }

            $num_total_registros = count($count->all);

            $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA); 

            $ingresos->limit($TAMANO_PAGINA,$inicio)->get();       

            foreach($ingresos->all as $ingreso){

                $ingreso->producto->get();
                $ingreso->servicio->get();

                $aIngresos['data'][] = array("nombre"       => $ingreso->producto_id?$ingreso->producto->nombre:$ingreso->servicio->nombre,
                                             "fecha"        => $ingreso->fecha_alta,
                                             "fecha_format" => date("d", strtotime($ingreso->fecha_alta)) ." ". 
                                                               month(date("m", strtotime($ingreso->fecha_alta)) - 1,false)." ".
                                                               date("Y", strtotime($ingreso->fecha_alta)),
                                             "cantidad"     => $ingreso->sumCantidad,
                                             "total"        => $ingreso->sumCosto,
                                             "tipo"         => $ingreso->producto_id?'producto':'servicio', 
                                             "id"           => $ingreso->producto_id?$ingreso->producto->id:$ingreso->servicio->id);
            }

            if(isset($aIngresos)){

                    $has_previous = 1;
                    $has_next = 1;

                    if ($page == 1){
                        $has_previous = 0;
                    }

                    if($page == $total_paginas){
                        $has_next = 0;
                    }

                    $aIngresos['page_total']    = $total_paginas;
                    $aIngresos['page_actual']   = $page;
                    $aIngresos['has_previous']  = $has_previous;
                    $aIngresos['has_next']      = $has_next;
                    $aIngresos['previous_page'] = $page - 1 ;
                    $aIngresos['next_page']     = $page + 1;

                echo json_encode($aIngresos);

            } else {

                echo json_encode(array('empty' => true));

            }
            
        } else {

            $ingresos->get();  

            $this->load->library('Pdf');
            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);

            $pdf->SetFont('Helvetica', '', 14, '', true); 

            $pdf->AddPage();
     
            $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
            $pdf->setImageScale(0.47);

            if(isset($dPdf_start) && isset($dPdf_end)){

                $fecha = $dPdf_start ." al ". $dPdf_end;                    

            }elseif(isset($dPdf_start) && !isset($dPdf_end)){

                $fecha = $dPdf_start;                    

            }elseif(isset($dPdf_end) && !isset($dPdf_start)){

                $fecha = $dPdf_end;                    

            }else{

                $fecha = date('d')." / ".month((date('m')-1),false). " / ". date('Y');

            }    

            $pdf->Image(base_url('assets/images/logos/'.$this->session->userdata('logo').'_logo.png'), 10, 10, 45, 25, '', '', '', false, 300);

            $pdf->writeHTMLCell(0, 0, 60, 15, '<h1 style="font-size:8px;">Ingresos del '.$fecha.'</h1>', 0, 1,  0, true, '', true);

            $html  = $this->_css().' <table class="table">';
            $html .= '<thead>
                        <tr>
                            <th class="th">Producto/Servicio</th>
                            <th class="th">Cantidad</th>
                            <th class="th">Total</th>
                        </tr>
                    </thead>';
            $html .= '<tbody>';  

            foreach ($ingresos->all as $key => $ingreso) {

                if ((($key+1) % 2) == 0) {
                        $rowClass = "even";
                    } else  {
                        $rowClass = "odd";
                    }

                $ingreso->producto->get();
                $ingreso->servicio->get();

                $nombre = $ingreso->producto_id?$ingreso->producto->nombre:$ingreso->servicio->nombre;

                $html .= '<tr class="'.$rowClass.'">';
                $html .= '<td class="td">'.$nombre.'</td>';
                $html .= '<td class="td" align="right">'.$ingreso->sumCantidad.'</td>';
                $html .= '<td class="td" align="right">$ '.$ingreso->sumCosto.'</td>';
                $html .= '</tr>';
            }

            $html .= '</tbody>';
            $html .= '</table>';
     
            $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 40, $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

            $pdf->writeHTMLCell(0, 0, 140, '', '<h1 style="font-size:8px;">Total: <strong>$ '.number_format($this->input->post('inputTotalPS'), 2, '.', ',').'</strong></h1>', 0, 1,  0, true, '', true);

            $nombre_archivo = utf8_decode("Ingresos.pdf");
            $pdf->Output($nombre_archivo, 'I');
        }

    }

    public function gridCitas($page = 1 ){

        $ingresos = new Ingreso();
        $count    = new Ingreso();
        
        $ingresos->select(' *, sum(costo) as sumCosto, sum(cantidad) as sumCantidad ' );
        $count->select(' id ' );
        $ingresos->where('consultorio_id', $this->session->userdata('id_consultorio'));
        $count->where('consultorio_id', $this->session->userdata('id_consultorio'));
        
        if($this->input->post('producto') && $this->input->post('servicio')){

            $ingresos->where('(producto_id = '. $this->input->post('producto') . ' or  servicio_id = '. $this->input->post('servicio') .')' );
            $count->where('(producto_id = '. $this->input->post('producto') . ' or  servicio_id = '. $this->input->post('servicio') .')' );

        }

        if($this->input->post('producto') && !$this->input->post('servicio')){

            $ingresos->where('producto_id',  $this->input->post('producto'));
            $count->where('producto_id',  $this->input->post('producto'));

        }

        if($this->input->post('servicio') && !$this->input->post('producto')){

            $ingresos->where('servicio_id',  $this->input->post('servicio'));
            $count->where('servicio_id',  $this->input->post('servicio'));

        }

        if($this->input->post('date_start') && $this->input->post('date_end')){

            $date_start = explode("/",$this->input->post('date_start'));
            $dPdf_start = $date_start[0].' / '.month(($date_start[1]-1),false).' / '.$date_start[2];
            $date_start = $date_start[2].'-'.$date_start[1].'-'.$date_start[0];

            $date_end   = explode("/",$this->input->post('date_end'));
            $dPdf_end   = $date_end[0].' / '.month(($date_end[1]-1),false).' / '.$date_end[2];
            $date_end   = $date_end[2].'-'.$date_end[1].'-'.$date_end[0];

            $ingresos->where("DATE(fecha_alta) between '".$date_start."' and '".$date_end."'");
            $count->where("DATE(fecha_alta) between '".$date_start."' and '".$date_end."'");

            $ingresos->order_by(' fecha_alta ', 'ASC ');

        } elseif($this->input->post('date_start') && !$this->input->post('date_end')){

            $date_start = explode("/",$this->input->post('date_start'));
            $dPdf_start = $date_start[0].' / '.month(($date_start[1]-1),false).' / '.$date_start[2];
            $date_start = $date_start[2].'-'.$date_start[1].'-'.$date_start[0];

            $ingresos->where('DATE(fecha_alta)' ,$date_start);
            $count->where('DATE(fecha_alta)' ,$date_start);

            $ingresos->order_by(' fecha_alta ', 'ASC ');

        
        } elseif($this->input->post('date_end') && !$this->input->post('date_start')){

            $date_end = explode("/",$this->input->post('date_end'));
            $dPdf_end = $date_end[0].' / '.month(($date_end[1]-1),false).' / '.$date_end[2];
            $date_end = $date_end[2].'-'.$date_end[1].'-'.$date_end[0];

            $ingresos->where('DATE(fecha_alta)' ,$date_end);
            $count->where('DATE(fecha_alta)' ,$date_end);

            $ingresos->order_by(' fecha_alta ', 'ASC ');

        } else {

            $ingresos->where('DATE(fecha_alta) = CURRENT_DATE');
            $count->where('DATE(fecha_alta) = CURRENT_DATE');

        }

        $ingresos->where('cita_id IS NOT NULL');
        $count->where('cita_id IS NOT NULL');

        $ingresos->where('estatus', 2 );
        $count->where('estatus', 2 );

        $ingresos->group_by('cita_id');

        if(!$this->input->post('imprimir')){

            $count->group_by('cita_id')->get();

            $TAMANO_PAGINA = 7;

            if ($page == 1) { 
                 $inicio = 0;  
            } 
            else { 
                $inicio = ($page - 1) * $TAMANO_PAGINA; 
            }

            $num_total_registros = count($count->all);

            $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA); 

            $ingresos->limit($TAMANO_PAGINA,$inicio)->get();

            foreach($ingresos->all as $ingreso){
                $ingreso->producto->get();
                $ingreso->servicio->get();

                $aIngresos['data'][] = array("nombre"       => "Consulta",
                                             "fecha"        => $ingreso->fecha_alta,
                                             "fecha_format" => date("d", strtotime($ingreso->fecha_alta)) ." ". 
                                                               month(date("m", strtotime($ingreso->fecha_alta)) - 1,false)." ".
                                                               date("Y", strtotime($ingreso->fecha_alta))." ".
                                                               date("H:i", strtotime($ingreso->fecha_alta)),
                                             "cantidad"     => $ingreso->sumCantidad,
                                             "total"        => $ingreso->sumCosto,
                                             "tipo"        => "cita",
                                             "id"           => $ingreso->cita_id);
            }

           if(isset($aIngresos)){

                    $has_previous = 1;
                    $has_next = 1;

                    if ($page == 1){
                        $has_previous = 0;
                    }

                    if($page == $total_paginas){
                        $has_next = 0;
                    }

                    $aIngresos['page_total']    = $total_paginas;
                    $aIngresos['page_actual']   = $page;
                    $aIngresos['has_previous']  = $has_previous;
                    $aIngresos['has_next']      = $has_next;
                    $aIngresos['previous_page'] = $page - 1 ;
                    $aIngresos['next_page']     = $page + 1;

                echo json_encode($aIngresos);

            } else {

                echo json_encode(array('empty' => true));

            }

        } else {

            $ingresos->get();  

            $this->load->library('Pdf');
            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);

            $pdf->SetFont('Helvetica', '', 14, '', true); 

            $pdf->AddPage();
     
            $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
            $pdf->setImageScale(0.47);

            if(isset($dPdf_start) && isset($dPdf_end)){

                $fecha = $dPdf_start ." al ". $dPdf_end;                    

            }elseif(isset($dPdf_start) && !isset($dPdf_end)){

                $fecha = $dPdf_start;                    

            }elseif(isset($dPdf_end) && !isset($dPdf_start)){

                $fecha = $dPdf_end;                    

            }else{
                $fecha = date('d')." / ".month((date('m')-1),false). " / ". date('Y');
            }    

            $pdf->Image(base_url('assets/images/logos/'.$this->session->userdata('logo').'_logo.png'), 10, 10, 45, 25, '', '', '', false, 300);

            $pdf->writeHTMLCell(0, 0, 60, 15, '<h1 style="font-size:8px;">Ingresos del '.$fecha.'</h1>', 0, 1,  0, true, '', true);

            $html  = $this->_css().' <table class="table">';
            $html .= '<thead>
                        <tr>
                            <th class="th">Servicio</th>
                            <th class="th">Cantidad Productos/Servicios</th>
                            <th class="th">Total</th>
                        </tr>
                    </thead>';
            $html .= '<tbody>';  

            foreach ($ingresos->all as $key => $ingreso) {

                if ((($key+1) % 2) == 0) {
                        $rowClass = "even";
                    } else  {
                        $rowClass = "odd";
                    }

                $ingreso->producto->get();
                $ingreso->servicio->get();

                $html .= '<tr class="'.$rowClass.'">';
                $html .= '<td class="td">Cita</td>';
                $html .= '<td class="td" align="right">'.$ingreso->sumCantidad.'</td>';
                $html .= '<td class="td" align="right">$ '.$ingreso->sumCosto.'</td>';
                $html .= '</tr>';
            }

            $html .= '</tbody>';
            $html .= '</table>';
     
            $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 40, $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

            $pdf->writeHTMLCell(0, 0, 140, '', '<h1 style="font-size:8px;">Total: <strong>$ '.number_format($this->input->post('inputTotalCita'), 2, '.', ',').'</strong></h1>', 0, 1,  0, true, '', true);

            $nombre_archivo = utf8_decode("Ingresos.pdf");
            $pdf->Output($nombre_archivo, 'I');

        }

    }

    public function detail($id = null, $tipo = null, $date_start, $date_end, $page = 1, $imprimir = null ){

        $ingresos = new Ingreso();

        $ingresos->where('consultorio_id', $this->session->userdata('id_consultorio'));

        if ($tipo == "producto"){

            $ingresos->where('producto_id', $id);

        }

        if ($tipo == "servicio"){

            $ingresos->where('servicio_id', $id);

        }

        if($date_start != 'false' && $date_end != 'false'){

            $date_start = $date_start / 1000; 
            $date_end   = $date_end / 1000; 
            $dPdf_start = date("d", $date_start)." / ".month((date("m", $date_start)-1),false)." / ".date("Y", $date_start);
            $dPdf_end   = date("d", $date_end)." / ".month((date("m", $date_end)-1),false)." / ".date("Y", $date_end);
            $date_start = date("Y-m-d H:i:s", $date_start);
            $date_end   = date("Y-m-d H:i:s", $date_end);

            $ingresos->where("DATE(fecha_alta) between '".$date_start."' and '".$date_end."'");

        }elseif($date_start != 'false' && $date_end == 'false'){

            $date_start = $date_start / 1000;
            $dPdf_start = date("d", $date_start)." / ".month((date("m", $date_start)-1),false)." / ".date("Y", $date_start);
            $date_start = date("Y-m-d H:i:s", $date_start);

            $ingresos->where('DATE(fecha_alta)' ,$date_start);
         
        }elseif($date_start == 'false' && $date_end != 'false'){

            $date_end = $date_end / 1000; 
            $dPdf_end   = date("d", $date_end)." / ".month((date("m", $date_end)-1),false)." / ".date("Y", $date_end);
            $date_end = date("Y-m-d H:i:s", $date_end);

            $ingresos->where('DATE(fecha_alta)' ,$date_end);

        }else{

            $ingresos->where('DATE(fecha_alta) = CURRENT_DATE');

        }

        if(!$imprimir){

            $ingresos->where('cita_id IS NULL')->get_paged_iterated($page,6);

            $data['ingresos']     = $ingresos;
            $data['id']           = $id;
            $data['paginaActual'] = $page;
            $data['tipo']         = $tipo;
            $data['date_start']   = $date_start;
            $data['date_end']     = $date_end;
            $data['cssFiles']     = array('sistema.css');
            $data['jsFiles']      = array('jquery.js');
            $data['view']         = 'sistema/ingresos/detalle';

            $this->load->view('sistema/template_simple',$data);

        } else {

            $ingresos->where('cita_id IS NULL')->get();  

            $this->load->library('Pdf');
            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);

            $pdf->SetFont('Helvetica', '', 14, '', true); 

            $pdf->AddPage();
     
            $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
            $pdf->setImageScale(0.47);

            if(isset($dPdf_start) && isset($dPdf_end)){

                $fecha = $dPdf_start ." al ". $dPdf_end;                    

            }elseif(isset($dPdf_start) && !isset($dPdf_end)){

                $fecha = $dPdf_start;                    

            }elseif(isset($dPdf_end) && !isset($dPdf_start)){

                $fecha = $dPdf_end;                    

            }else{

                $fecha = date('d')." / ".month((date('m')-1),false). " / ". date('Y');

            }    

            $pdf->Image(base_url('assets/images/logos/'.$this->session->userdata('logo').'_logo.png'), 10, 10, 45, 25, '', '', '', false, 300);

            $pdf->writeHTMLCell(0, 0, 60, 15, '<h1 style="font-size:8px;">Ingresos del '.$fecha.'</h1>', 0, 1,  0, true, '', true);

            $total = 0; 
            $html  = $this->_css().' <table class="table">';
            $html .= '<thead>
                        <tr>
                            <th class="th">Fecha/Hora</th>
                            <th class="th">Publico/Paciente</th>
                            <th class="th">Cantidad</th>
                            <th class="th">Costo</th>
                            <th class="th">Total</th>
                        </tr>
                    </thead>';
            $html .= '<tbody>';  

            foreach ($ingresos->all as $key => $ingreso) {

                if ((($key+1) % 2) == 0) {
                        $rowClass = "even";
                    } else  {
                        $rowClass = "odd";
                    }

                $total = $total + $ingreso->costo;
                $ingreso->producto->get();
                $ingreso->servicio->get();
                $ingreso->paciente->get();

                $nombre   = $ingreso->producto_id?$ingreso->producto->nombre:$ingreso->servicio->nombre;
                $paciente = $ingreso->paciente_id?$ingreso->paciente->nombre." ".$ingreso->paciente->apellido_p." ".$ingreso->paciente->apellido_m:'Publico';

                $html .= '<tr class="'.$rowClass.'">';
                $html .= '<td class="td">'.date("d", strtotime($ingreso->fecha_alta)).'/'.
                                           month((date("m", strtotime($ingreso->fecha_alta))-1),false).'/'.
                                           date("Y H:i", strtotime($ingreso->fecha_alta)).'</td>';
                $html .= '<td class="td" align="right">'.$paciente.'</td>';
                $html .= '<td class="td" align="right">'.$ingreso->cantidad.'</td>';
                $html .= '<td class="td" align="right">$ '.number_format(($ingreso->costo/$ingreso->cantidad), 2, '.', ',').'</td>';
                $html .= '<td class="td" align="right">$ '.number_format($ingreso->costo, 2, '.', ',').'</td>';
                $html .= '</tr>';
            }

            $html .= '</tbody>';
            $html .= '</table>';
            
            $pdf->writeHTMLCell(0, 0, 60, 25, '<h1 style="font-size:8px;">'.$nombre.'</h1>', 0, 1,  0, true, '', true);

            $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 40, $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

            $pdf->writeHTMLCell(0, 0, 140, '', '<h1 style="font-size:8px;">Total: <strong>$ '.number_format($total, 2, '.', ',').'</strong></h1>', 0, 1,  0, true, '', true);

            $nombre_archivo = utf8_decode("Ingresos.pdf");
            $pdf->Output($nombre_archivo, 'I');

        }
        

    }

    public function detailCita($id_cita = null, $imprimir = null ){

        $ingresos = new Ingreso();
        $cita     = new Reunion();

        $ingresos->select(' *, sum(cantidad) as sumCantidad, sum(costo) as sumCosto ')->
                   where(array('cita_id' => $id_cita))->
                   where('consultorio_id', $this->session->userdata('id_consultorio'))->
                   group_by('producto_id, servicio_id')->
                   get(); 

        $cita->where('id', $id_cita)->get();            

        if(!$imprimir){

            $data['ingresos'] = $ingresos;
            $data['cita']     = $cita;
            $data['cssFiles'] = array('sistema.css');
            $data['jsFiles']  = array('jquery.js');
            $data['view']     = 'sistema/ingresos/detalleCita';

            $this->load->view('sistema/template_simple',$data);

        } else { 

            $this->load->library('Pdf');
            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);

            $pdf->SetFont('Helvetica', '', 14, '', true); 

            $pdf->AddPage();
     
            $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
            $pdf->setImageScale(0.47);

            if(isset($dPdf_start) && isset($dPdf_end)){

                $fecha = $dPdf_start ." al ". $dPdf_end;                    

            }elseif(isset($dPdf_start) && !isset($dPdf_end)){

                $fecha = $dPdf_start;                    

            }elseif(isset($dPdf_end) && !isset($dPdf_start)){

                $fecha = $dPdf_end;                    

            }else{

                $fecha = date('d')." / ".month((date('m')-1),false). " / ". date('Y');

            }    

            $pdf->Image(base_url('assets/images/logos/'.$this->session->userdata('logo').'_logo.png'), 10, 10, 45, 25, '', '', '', false, 300);

            $pdf->writeHTMLCell(0, 0, 60, 7, '<h1 style="font-size:8px;">Ingresos por Cita</h1>', 0, 1,  0, true, '', true);

            $pdf->writeHTMLCell(0, 0, 60, 16, '<h1 style="font-size:8px;">Fecha:</h1>', 0, 1,  0, true, '', true);
            $pdf->writeHTMLCell(0, 0, 60, 23, '<h1 style="font-size:8px;">Doctor:</h1>', 0, 1,  0, true, '', true);
            $pdf->writeHTMLCell(0, 0, 60, 30, '<h1 style="font-size:8px;">Paciente:</h1>', 0, 1,  0, true, '', true);

            $pdf->writeHTMLCell(0, 0, 90, 16, '<h1 style="font-size:8px;">'.$cita->fecha_hora.'</h1>', 0, 1,  0, true, '', true);

            $cita->paciente->get();
            $cita->empleado->get();

            $pdf->writeHTMLCell(0, 0, 90, 23, '<h1 style="font-size:8px;">'.$cita->empleado->nombre.' '.$cita->empleado->apellido_p.' '.$cita->empleado->apellido_m.'</h1>', 0, 1,  0, true, '', true);
            $pdf->writeHTMLCell(0, 0, 90, 30, '<h1 style="font-size:8px;">'.$cita->paciente->nombre.' '.$cita->paciente->apellido_p.' '.$cita->paciente->apellido_m.'</h1>', 0, 1,  0, true, '', true);

            $totalCita = 0; 
            $html  = $this->_css().' <table class="table">';
            $html .= '<thead>
                        <tr>
                            <th class="th">Producto/Servicio</th>
                            <th class="th">Cantidad</th>
                            <th class="th">Costo</th>
                            <th class="th">Total</th>
                        </tr>
                    </thead>';
            $html .= '<tbody>';  

            foreach ($ingresos->all as $key => $ingreso) {

                $totalCita = $totalCita + $ingreso->sumCosto;

                if ((($key+1) % 2) == 0) {
                        $rowClass = "even";
                    } else  {
                        $rowClass = "odd";
                    }

                $ingreso->producto->get();
                $ingreso->servicio->get();
                $ingreso->paciente->get();

                $nombre   = $ingreso->producto_id?$ingreso->producto->nombre:$ingreso->servicio->nombre;

                $html .= '<tr class="'.$rowClass.'">';
                $html .= '<td class="td">'.$nombre.'</td>';
                $html .= '<td class="td" align="right">'.$ingreso->sumCantidad.'</td>';
                $html .= '<td class="td" align="right">$ '.number_format(($ingreso->sumCosto/$ingreso->sumCantidad), 2, '.', ',').'</td>';
                $html .= '<td class="td" align="right">$ '.number_format($ingreso->sumCosto, 2, '.', ',').'</td>';
                $html .= '</tr>';
            }

            $html .= '</tbody>';
            $html .= '</table>';

            $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 40, $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

            $pdf->writeHTMLCell(0, 0, 140, '', '<h1 style="font-size:8px;">Total: <strong>$ '.number_format($totalCita, 2, '.', ',').'</strong></h1>', 0, 1,  0, true, '', true);

            $nombre_archivo = utf8_decode("Ingresos.pdf");
            $pdf->Output($nombre_archivo, 'I');

        } 
        

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