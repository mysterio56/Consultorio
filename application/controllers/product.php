<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('type_user'));
    }

    public function index(){
    	$productos = new Producto();

    	$aPermisos = permisos($this->session->userdata('type_user'));

    	$data['permisos'] = $aPermisos['product'];
    	$data['view']	  =	'sistema/producto/lista';
    	$data['cssFiles'] = array('sistema.css',
								  'jquery-ui/jquery-ui.css');
		$data['jsFiles']  = array('jquery.js',
							      'jquery-ui.js',
							      'valid_forms.js');
		
    	$this->load->view('sistema/template',$data);
    }
	
	public function grid($page = 1){


    		$productos = new Producto();

    	if($this->input->post()){

    		$productos = new Producto();

    		$productos->where(array('consultorio_id' => $this->session->userdata('id_consultorio')));
    		

			$permisos = permisos($this->session->userdata('type_user'));

			
			if($this->input->post('codigo')){

    			$productos->where('codigo',$this->input->post('codigo'));
    			$productos->order_by(' codigo ', 'ASC ');

    		}

    		if($this->input->post('nombre')){

    			$productos->where('nombre',$this->input->post('nombre'));
    			$productos->order_by(' codigo ', 'ASC ');

    		}

    		if($this->input->post('Codigo')){

    			$productos->where('codigo like "%'.$_POST['Codigo'].'%"');
    			$productos->order_by(' codigo ', 'ASC ');

    		}
    		
    		if($this->input->post('Nombre')){

    			$productos->where('nombre like "%'.$_POST['Nombre'].'%"');
    			$productos->order_by(' codigo ', 'ASC ');

    		}

    		if($this->input->post('estatus')){

    			$productos->where_in('estatus',$this->input->post('estatus'));
    			$productos->order_by(' estatus');	
    			$productos->order_by(' codigo ', 'ASC ');   			
    		} else {

    			$productos->where('estatus <> 2');
    		}

    		if($this->input->post('fecha_alta')){

    			$productos->where('DATE(fecha_alta) = \''.$this->input->post('fecha_alta').'\'');
    			$productos->order_by(' codigo ', 'ASC ');
    		}

    		if($this->input->post('buscarId')){

				$productos->where('id' ,$this->input->post('buscarId'));
    			$productos->order_by(' codigo ', 'ASC ');
    			
			}
    		
    		$oProductos = $productos->get_paged_iterated($page, 5);
    		
    		foreach( $oProductos as $nKey => $producto){	

		    	$aProductos['data'][$nKey] = array("id"      	=> $producto->id,
		    								       "codigo"  	=> $producto->codigo,
		    								       "nombre"  	=> $producto->nombre,
		    								       "fecha_alt" => date("d",strtotime($producto->fecha_alta))."/".
		    								   				           month(date("m",strtotime($producto->fecha_alta))-1,false)."/".
		    								   				           date("Y",strtotime($producto->fecha_alta)),
		    								       "estatus"   => $producto->estatus,
		    								       "editar"    => in_array($permisos['product'],aPermisos('Editar'))?true:false,
		    								       "eliminar"  => in_array($permisos['product'],aPermisos('Eliminar'))?true:false
		    										  );  
				
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

    }
    public function agregar(){

    	$nCodigo = new Producto();

    	$nCodigo->where('consultorio_id', $this->session->userdata('id_consultorio'))->get();
		$nCodigo = $nCodigo->count() + 1;

    	$data['view']     	  = 'sistema/producto/agregar';
		$data['return']       = 'product';
		$data['nCodigo']      = $nCodigo;
		$data['cssFiles']     = array('sistema.css');
		$data['jsFiles']      = array('jquery.js',
							     	  'jquery-validation/dist/jquery.validate.js',
								      'jquery-validation/localization/messages_es.js',
								      'autoNumeric.js',
								      'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){

			$producto = new Producto();

			$producto->codigo         = $this->input->post('codigo'); 
			$producto->nombre         = $this->input->post('nombre');
			$producto->descripcion    = $this->input->post('descripcion');
			$producto->costo_compra   = str_replace(",","",$this->input->post('costo_c'));
			$producto->costo_venta    = str_replace(",","",$this->input->post('costo_v'));
			$producto->consultorio_id = $this->session->userdata('id_consultorio');
			$producto->fecha_alta     = date("Y-m-d H:i:s");
			$producto->estatus        = 1;

			if($producto->save()){

				redirect(base_url('product'));

			} else {

				echo $producto->error->string;
				
			}

		}

    }

    public function editar($id_producto){

    	$producto = new Producto();

		$data['producto'] = $producto->where(array('id'             => $id_producto,
												   'consultorio_id' => $this->session->userdata('id_consultorio')))->get();
		$data['return']   = 'product'; 		
		$data['view']     = 'sistema/producto/editar';
		$data['cssFiles'] = array('sistema.css');
		$data['jsFiles']  = array('jquery.js',
							   	  'jquery-validation/dist/jquery.validate.js',
								  'jquery-validation/localization/messages_es.js',
								  'autoNumeric.js',
								  'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){

			$producto->codigo             = $this->input->post('codigo'); 
			$producto->nombre             = $this->input->post('nombre');
			$producto->descripcion        = $this->input->post('descripcion');
			$producto->costo_compra       = str_replace(",","",$this->input->post('costo_c'));
			$producto->costo_venta        = str_replace(",","",$this->input->post('costo_v'));
			$producto->fecha_modificacion = date("Y-m-d H:i:s");

			if($producto->save()){

				redirect(base_url('product'));
				
			} else {

				echo $producto->error->string;

			}

		}
	}


public function eliminar($id_producto){

		$producto = new Producto();

		$producto->where('id', $id_producto)->get();

		$producto->estatus    = 2;
		$producto->fecha_baja = date("Y-m-d H:i:s");

		if($producto->save()){

			echo json_encode(array('error' =>false ,'id'=>$id_producto));
		}else{
			echo json_encode(array('error' =>true));
		}

	}


	public function status($id_producto){

		$producto = new Producto();

		$producto->where('id', $id_producto)->get();

		$estatus_actual= $producto->estatus;

		if($producto->estatus == 1){

			$producto->estatus    = 0;
			$status=0;

		} else{

			$producto->estatus    = 1;
			$status=1;
		}

		$producto->fecha_baja = date("Y-m-d H:i:s");
		
		if($producto->save()){
			echo json_encode(array('estatus' =>$status ,'id'=>$id_producto ));

		}else{

			echo json_encode(array('error' =>true ,'estatus'=>$estatus_actual,'id'=>$id_producto));
		}

	}


   public function buscar($page = 1){

   		$aPermisos = permisos($this->session->userdata('type_user'));

    	$data['permisos'] = $aPermisos['product'];
		$data['view']     = 'sistema/producto/buscar';
		$data['return']   = 'product';
		$data['cssFiles'] = array('jquery-ui/jquery-ui.css',
								  'sistema.css');
		$data['jsFiles']  = array('jquery.js',
							      'jquery-ui.js',
							      'jquery.ui.datepicker-es.js',
							      'valid_forms.js');

		
		$this->load->view('sistema/template',$data);

	}

	public function lista_add(){

	$producto = new Producto();
	$producto->where(array('consultorio_id' => $this->session->userdata('id_consultorio')));
	$producto->where('estatus', 1)->get();

	$aProducto = array(); 

	foreach($producto as $product){
			 $aProducto[] = array("id"           => $product->id, 
			 					  "value"        => $product->codigo .' '. $product->nombre,
			 					  "costo"        => $product->costo_venta,
			 					  "costo_compra" => $product->costo_compra);
		}
		
		echo json_encode($aProducto);

	}
}