<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Expenses extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('type_user'));
    }

	public function index(){

		$data['view']     = 'sistema/egresos/lista';
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

        $egresos = new Egreso();
        
        $egresos->select(' sum(costo) sumCosto ' );
        $egresos->where('consultorio_id', $this->session->userdata('id_consultorio'));
        
        if($this->input->post('producto') && $this->input->post('servicio')){

            $egresos->where('(producto_id = '. $this->input->post('producto') . ' or  servicio_id = '. $this->input->post('servicio') .')' );

        }

        if($this->input->post('producto') && !$this->input->post('servicio')){

            $egresos->where('producto_id',  $this->input->post('producto'));

        }

        if($this->input->post('servicio') && !$this->input->post('producto')){

            $egresos->where('servicio_id',  $this->input->post('servicio'));

        }

        if($this->input->post('date_start') && $this->input->post('date_end')){

            $date_start = explode("/",$this->input->post('date_start'));
            $date_start = $date_start[2].'-'.$date_start[1].'-'.$date_start[0];

            $date_end   = explode("/",$this->input->post('date_end'));
            $date_end   = $date_end[2].'-'.$date_end[1].'-'.$date_end[0];

            $egresos->where("DATE(fecha_alta) between '".$date_start."' and '".$date_end."'");
            $egresos->order_by(' fecha_alta ', 'ASC ');

        } elseif($this->input->post('date_start') && !$this->input->post('date_end')){

            $date_start = explode("/",$this->input->post('date_start'));
            $date_start = $date_start[2].'-'.$date_start[1].'-'.$date_start[0];

            $egresos->where('DATE(fecha_alta)' ,$date_start);
            $egresos->order_by(' fecha_alta ', 'ASC ');

        
        } elseif($this->input->post('date_end') && !$this->input->post('date_start')){

            $date_end = explode("/",$this->input->post('date_end'));
            $date_end = $date_end[2].'-'.$date_end[1].'-'.$date_end[0];

            $egresos->where('DATE(fecha_alta)' ,$date_end);
            $egresos->order_by(' fecha_alta ', 'ASC ');

        } else {

            $egresos->where('DATE(fecha_alta) = CURRENT_DATE');

        }

        $egresos->get();

        echo $egresos->sumCosto;

    }

    public function grid($page = 1){

        $egresos  = new Egreso();
        $count    = new Egreso();
        
        $egresos->select(' *, sum(costo) as sumCosto, sum(cantidad) as sumCantidad ' );
        $count->select(' id ' );
        $egresos->where('consultorio_id', $this->session->userdata('id_consultorio'));
        $count->where('consultorio_id', $this->session->userdata('id_consultorio'));
        
        if($this->input->post('producto') && $this->input->post('servicio')){

            $egresos->where('(producto_id = '. $this->input->post('producto') . ' or  servicio_id = '. $this->input->post('servicio') .')' );
            $count->where('(producto_id = '. $this->input->post('producto') . ' or  servicio_id = '. $this->input->post('servicio') .')' );

        }

        if($this->input->post('producto') && !$this->input->post('servicio')){

            $egresos->where('producto_id',  $this->input->post('producto'));
            $count->where('producto_id',  $this->input->post('producto'));


        }

        if($this->input->post('servicio') && !$this->input->post('producto')){

            $egresos->where('servicio_id',  $this->input->post('servicio'));
            $count->where('servicio_id',  $this->input->post('servicio'));

        }

        if($this->input->post('date_start') && $this->input->post('date_end')){

            $date_start = explode("/",$this->input->post('date_start'));
            $dPdf_start = $date_start[0].' / '.month(($date_start[1]-1),false).' / '.$date_start[2];
            $date_start = $date_start[2].'-'.$date_start[1].'-'.$date_start[0];

            $date_end   = explode("/",$this->input->post('date_end'));
            $dPdf_end   = $date_end[0].' / '.month(($date_end[1]-1),false).' / '.$date_end[2];
            $date_end   = $date_end[2].'-'.$date_end[1].'-'.$date_end[0];

            $egresos->where("DATE(fecha_alta) between '".$date_start."' and '".$date_end."'");
            $count->where("DATE(fecha_alta) between '".$date_start."' and '".$date_end."'");

            $egresos->order_by(' fecha_alta ', 'ASC ');

        } elseif($this->input->post('date_start') && !$this->input->post('date_end')){

            $date_start = explode("/",$this->input->post('date_start'));
            $dPdf_start = $date_start[0].' / '.month(($date_start[1]-1),false).' / '.$date_start[2];
            $date_start = $date_start[2].'-'.$date_start[1].'-'.$date_start[0];

            $egresos->where('DATE(fecha_alta)' ,$date_start);
            $count->where('DATE(fecha_alta)' ,$date_start);

            $egresos->order_by(' fecha_alta ', 'ASC ');

        
        } elseif($this->input->post('date_end') && !$this->input->post('date_start')){

            $date_end = explode("/",$this->input->post('date_end'));
            $dPdf_end = $date_end[0].' / '.month(($date_end[1]-1),false).' / '.$date_end[2];
            $date_end = $date_end[2].'-'.$date_end[1].'-'.$date_end[0];

            $egresos->where('DATE(fecha_alta)' ,$date_end);
            $count->where('DATE(fecha_alta)' ,$date_end);
            $egresos->order_by(' fecha_alta ', 'ASC ');

        } else {

            $egresos->where('DATE(fecha_alta) = CURRENT_DATE');
            $count->where('DATE(fecha_alta) = CURRENT_DATE');

        }

        $egresos->group_by(' servicio_id , producto_id ');

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

            $egresos->limit($TAMANO_PAGINA,$inicio)->get();       

            foreach($egresos->all as $egreso){

                $egreso->producto->get();
                $egreso->servicio->get();

                $aEgresos['data'][] = array("nombre"       => $egreso->producto_id?$egreso->producto->nombre:$egreso->servicio->nombre,
                                             "fecha"        => $egreso->fecha_alta,
                                             "fecha_format" => date("d", strtotime($egreso->fecha_alta)) ." ". 
                                                               month(date("m", strtotime($egreso->fecha_alta)) - 1,false)." ".
                                                               date("Y", strtotime($egreso->fecha_alta)),
                                             "cantidad"     => $egreso->sumCantidad,
                                             "total"        => $egreso->sumCosto,
                                             "tipo"         => $egreso->producto_id?'producto':'servicio', 
                                             "id"           => $egreso->producto_id?$egreso->producto->id:$egreso->servicio->id);
            }

            if(isset($aEgresos)){

                    $has_previous = 1;
                    $has_next = 1;

                    if ($page == 1){
                        $has_previous = 0;
                    }

                    if($page == $total_paginas){
                        $has_next = 0;
                    }

                    $aEgresos['page_total']    = $total_paginas;
                    $aEgresos['page_actual']   = $page;
                    $aEgresos['has_previous']  = $has_previous;
                    $aEgresos['has_next']      = $has_next;
                    $aEgresos['previous_page'] = $page - 1 ;
                    $aEgresos['next_page']     = $page + 1;

                echo json_encode($aEgresos);

            } else {

                echo json_encode(array('empty' => true));

            }
        } else {

            $egresos->get();  

            $this->load->library('Pdf');

            $imgConsultorio = new Consultorio();
            $imgConsultorio->where('id',$this->session->userdata('id_consultorio'))->get();
            $imgConsultorio = $imgConsultorio->nombre_logo;

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

            $pdf->Image(base_url('assets/images/logos/'.$imgConsultorio.'_logo.png'), 10, 10, 45, 25, '', '', '', false, 300);

            $pdf->writeHTMLCell(0, 0, 60, 15, '<h1 style="font-size:8px;">Egresos del '.$fecha.'</h1>', 0, 1,  0, true, '', true);

            $html  = $this->_css().' <table class="table">';
            $html .= '<thead>
                        <tr>
                            <th class="th">Producto/Servicio</th>
                            <th class="th">Cantidad</th>
                            <th class="th">Total</th>
                        </tr>
                    </thead>';
            $html .= '<tbody>';  

            $totalPdf = 0;

            foreach ($egresos->all as $key => $egreso) {

                $totalPdf = $totalPdf + $egreso->sumCosto;

                if ((($key+1) % 2) == 0) {
                        $rowClass = "even";
                    } else  {
                        $rowClass = "odd";
                    }

                $egreso->producto->get();
                $egreso->servicio->get();

                $nombre = $egreso->producto_id?$egreso->producto->nombre:$egreso->servicio->nombre;

                $html .= '<tr class="'.$rowClass.'">';
                $html .= '<td class="td">'.$nombre.'</td>';
                $html .= '<td class="td" align="right">'.$egreso->sumCantidad.'</td>';
                $html .= '<td class="td" align="right">$ '.$egreso->sumCosto.'</td>';
                $html .= '</tr>';
            }

            $html .= '</tbody>';
            $html .= '</table>';
     
            $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 40, $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

            $pdf->writeHTMLCell(0, 0, 140, '', '<h1 style="font-size:8px;">Total: <strong>$ '.number_format($totalPdf, 2, '.', ',').'</strong></h1>', 0, 1,  0, true, '', true);

            $nombre_archivo = utf8_decode("Egresos.pdf");
            $pdf->Output($nombre_archivo, 'I');
        }

    }

    public function detail($id = null, $tipo = null, $date_start, $date_end, $page = 1, $imprimir = null ){

        $egresos = new Egreso();

        $egresos->where('consultorio_id', $this->session->userdata('id_consultorio'));

        if ($tipo == "producto"){

            $egresos->where('producto_id', $id);

        }

        if ($tipo == "servicio"){

            $egresos->where('servicio_id', $id);

        }

        if($date_start != 'false' && $date_end != 'false'){

            $date_start = $date_start / 1000; 
            $date_end   = $date_end / 1000; 
            $dPdf_start = date("d", $date_start)." / ".month((date("m", $date_start)-1),false)." / ".date("Y", $date_start);
            $dPdf_end   = date("d", $date_end)." / ".month((date("m", $date_end)-1),false)." / ".date("Y", $date_end);
            $date_start = date("Y-m-d H:i:s", $date_start);
            $date_end   = date("Y-m-d H:i:s", $date_end);

            $egresos->where("DATE(fecha_alta) between '".$date_start."' and '".$date_end."'");

        }elseif($date_start != 'false' && $date_end == 'false'){

            $date_start = $date_start / 1000;
            $dPdf_start = date("d", $date_start)." / ".month((date("m", $date_start)-1),false)." / ".date("Y", $date_start);
            $date_start = date("Y-m-d H:i:s", $date_start);

            $egresos->where('DATE(fecha_alta)' ,$date_start);
         
        }elseif($date_start == 'false' && $date_end != 'false'){

            $date_end = $date_end / 1000; 
            $dPdf_end   = date("d", $date_end)." / ".month((date("m", $date_end)-1),false)." / ".date("Y", $date_end);
            $date_end = date("Y-m-d H:i:s", $date_end);

            $egresos->where('DATE(fecha_alta)' ,$date_end);

        }else{

            $egresos->where('DATE(fecha_alta) = CURRENT_DATE');

        }

        if(!$imprimir){

            $egresos->get_paged_iterated($page,6);

            $data['egresos']      = $egresos;
            $data['id']           = $id;
            $data['paginaActual'] = $page;
            $data['tipo']         = $tipo;
            $data['date_start']   = $date_start;
            $data['date_end']     = $date_end;
            $data['cssFiles']     = array('sistema.css');
            $data['jsFiles']      = array('jquery.js');
            $data['view']         = 'sistema/egresos/detalle';

            $this->load->view('sistema/template_simple',$data);

        } else {

            $egresos->get();  

            $this->load->library('Pdf');

            $imgConsultorio = new Consultorio();
            $imgConsultorio->where('id',$this->session->userdata('id_consultorio'))->get();
            $imgConsultorio = $imgConsultorio->nombre_logo;

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

            $pdf->Image(base_url('assets/images/logos/'.$imgConsultorio.'_logo.png'), 10, 10, 45, 25, '', '', '', false, 300);

            $pdf->writeHTMLCell(0, 0, 60, 15, '<h1 style="font-size:8px;">Egresos del '.$fecha.'</h1>', 0, 1,  0, true, '', true);

            $total = 0; 
            $html  = $this->_css().' <table class="table">';
            $html .= '<thead>
                        <tr>
                            <th class="th">Fecha/Hora</th>
                            <th class="th">Cantidad</th>
                            <th class="th">Costo</th>
                            <th class="th">Total</th>
                        </tr>
                    </thead>';
            $html .= '<tbody>';  

            foreach ($egresos->all as $key => $egreso) {

                if ((($key+1) % 2) == 0) {
                        $rowClass = "even";
                    } else  {
                        $rowClass = "odd";
                    }

                $total = $total + $egreso->costo;
                $egreso->producto->get();
                $egreso->servicio->get();
                //$egreso->paciente->get();

                $nombre   = $egreso->producto_id?$egreso->producto->nombre:$egreso->servicio->nombre;
                //$paciente = $ingreso->paciente_id?$ingreso->paciente->nombre." ".$ingreso->paciente->apellido_p." ".$ingreso->paciente->apellido_m:'Publico';

                $html .= '<tr class="'.$rowClass.'">';
                $html .= '<td class="td">'.date("d", strtotime($egreso->fecha_alta)).'/'.
                                           month((date("m", strtotime($egreso->fecha_alta))-1),false).'/'.
                                           date("Y H:i", strtotime($egreso->fecha_alta)).'</td>';
                $html .= '<td class="td" align="right">'.$egreso->cantidad.'</td>';
                $html .= '<td class="td" align="right">$ '.number_format(($egreso->costo/$egreso->cantidad), 2, '.', ',').'</td>';
                $html .= '<td class="td" align="right">$ '.number_format($egreso->costo, 2, '.', ',').'</td>';
                $html .= '</tr>';
            }

            $html .= '</tbody>';
            $html .= '</table>';
            
            $pdf->writeHTMLCell(0, 0, 60, 25, '<h1 style="font-size:8px;">'.$nombre.'</h1>', 0, 1,  0, true, '', true);

            $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = 40, $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

            $pdf->writeHTMLCell(0, 0, 140, '', '<h1 style="font-size:8px;">Total: <strong>$ '.number_format($total, 2, '.', ',').'</strong></h1>', 0, 1,  0, true, '', true);

            $nombre_archivo = utf8_decode("Egresos.pdf");
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