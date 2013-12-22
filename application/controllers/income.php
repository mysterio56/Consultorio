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
								  'valid_forms.js');

		$this->load->view('sistema/template_simple',$data);
	}

    public function getTotal(){

        $ingresos = new Ingreso();
        
        $ingresos->select(' sum(costo) sumCosto ' );
        
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

        $ingresos->where('cita_id IS NULL');

        $ingresos->get();

        echo $ingresos->sumCosto;

    }

    public function getTotalCitas(){

        $ingresos = new Ingreso();
        
        $ingresos->select(' sum(costo) sumCosto ' );
        
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
            $date_start = $date_start[2].'-'.$date_start[1].'-'.$date_start[0];

            $date_end   = explode("/",$this->input->post('date_end'));
            $date_end   = $date_end[2].'-'.$date_end[1].'-'.$date_end[0];

            $ingresos->where("DATE(fecha_alta) between '".$date_start."' and '".$date_end."'");
            $count->where("DATE(fecha_alta) between '".$date_start."' and '".$date_end."'");

            $ingresos->order_by(' fecha_alta ', 'ASC ');

        } elseif($this->input->post('date_start') && !$this->input->post('date_end')){

            $date_start = explode("/",$this->input->post('date_start'));
            $date_start = $date_start[2].'-'.$date_start[1].'-'.$date_start[0];

            $ingresos->where('DATE(fecha_alta)' ,$date_start);
            $count->where('DATE(fecha_alta)' ,$date_start);

            $ingresos->order_by(' fecha_alta ', 'ASC ');

        
        } elseif($this->input->post('date_end') && !$this->input->post('date_start')){

            $date_end = explode("/",$this->input->post('date_end'));
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

        $oIngresos = $ingresos->limit($TAMANO_PAGINA,$inicio)->get();       

        foreach($oIngresos as $ingreso){

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

    }

    public function gridCitas(){

        $ingresos = new Ingreso();
        
        $ingresos->select(' *, sum(costo) as sumCosto, sum(cantidad) as sumCantidad ' );
        
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

        $ingresos->where('cita_id IS NOT NULL');

        $ingresos->group_by('cita_id');

        $ingresos->get();

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
                                         "id"           => $ingreso->producto_id?$ingreso->producto->id:$ingreso->servicio->id);
        }

        if(isset($aIngresos)){
            echo json_encode($aIngresos);
        } else {
            echo json_encode(array('empty' => true));
        }

    }

    public function detail($id = null, $tipo = null, $date_start = null, $date_end){

        if($date_start != 'false' && $date_end != 'false'){

            $date_start = $date_start / 1000; 
            $date_end   = $date_end / 1000; 
            $date_start = date("Y-m-d H:i:s", $date_start);
            $date_end   = date("Y-m-d H:i:s", $date_end);


        }elseif($date_start != 'false' && $date_end == 'false'){

            $date_start = $date_start / 1000;
            $date_start = date("Y-m-d H:i:s", $date_start);
         
        }elseif($date_start == 'false' && $date_end != 'false'){

            $date_end = $date_end / 1000; 
            $date_end = date("Y-m-d H:i:s", $date_end);

        }else{

        }

        echo $id;
        echo $tipo;
        echo $date_start;
        echo $date_end;
    }
}