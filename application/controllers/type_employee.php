<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Type_employee extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	permisos($this->session->userdata('type_user'));
    }

	public function index(){
    
    	$tipoEmpleados = new Tipo_Empleado();
    	
    	$aPermisos = permisos($this->session->userdata('type_user'));

    	$data['permisos'] = $aPermisos['type_employee'];
    	$data['view']	  =	'sistema/tipo_empleado/lista';
       	$data['cssFiles'] = array('sistema.css',
								  'jquery-ui/jquery-ui.css');
		$data['jsFiles']  = array('jquery.js',
							      'jquery-ui.js',
							      'valid_forms.js');


    	$this->load->view('sistema/template',$data);
    }

    public function grid($page = 1){


    		$tipoEmpleados = new Tipo_Empleado();

    	if($this->input->post()){

    		$tipoEmpleados = new Tipo_Empleado();

    		$tipoEmpleados->where(array('consultorio_id' => $this->session->userdata('id_consultorio')));
    		

			$permisos = permisos($this->session->userdata('type_user'));

			
			if($this->input->post('codigo')){

    			$tipoEmpleados->where('codigo',$this->input->post('codigo'));
    			$tipoEmpleados->order_by(' codigo ', 'ASC ');

    		}

    		if($this->input->post('nombre')){

    			$tipoEmpleados->where('nombre',$this->input->post('nombre'));
    			$tipoEmpleados->order_by(' codigo ', 'ASC ');
    	
    		}

    		if($this->input->post('Codigo')){

    			$tipoEmpleados->where('codigo like "%'.$_POST['Codigo'].'%"');
    			$tipoEmpleados->order_by(' codigo ', 'ASC ');

    		}

			if($this->input->post('Nombre')){

    			$tipoEmpleados->where('nombre like "%'.$_POST['Nombre'].'%"');
    			$tipoEmpleados->order_by(' codigo ', 'ASC ');
    		
    		}

    		if($this->input->post('estatus')){

    			$tipoEmpleados->where_in('estatus',$this->input->post('estatus'));	
    			$tipoEmpleados->order_by(' estatus');
    			$tipoEmpleados->order_by(' codigo ', 'ASC ');   			
    		} else {

    			$tipoEmpleados->where('estatus <> 2');
    		}

    		if($this->input->post('fecha_alta')){

    			$tipoEmpleados->where('DATE(fecha_alta) = \''.$this->input->post('fecha_alta').'\'');
    			$tipoEmpleados->order_by(' codigo ', 'ASC ');
    		}

    		if($this->input->post('buscarId')){

				$tipoEmpleados->where('id' ,$this->input->post('buscarId'));
    			$tipoEmpleados->order_by(' codigo ', 'ASC ');
    		}
    		
    		
    		$oTipoEmpleados = $tipoEmpleados->get_paged_iterated($page, 5);
    		
    		foreach( $oTipoEmpleados as $nKey => $tipoempleado){	

		    	$aTipoEmpleados['data'][$nKey] = array("id"        => $tipoempleado->id,
		    								   	   	   "codigo"    => $tipoempleado->codigo,
		    								   	   	   "nombre"    => $tipoempleado->nombre." ".$tipoempleado->apellido_p." ".$tipoempleado->apellido_m,
		    								   	   	   "fecha_alt" => date("d",strtotime($tipoempleado->fecha_alta))." / ".
		    								   	   	   				  month(date("m",strtotime($tipoempleado->fecha_alta))-1, false)." / ".
		    								   	   	   				  date("Y",strtotime($tipoempleado->fecha_alta)), 
		    								   	   	   "estatus"   => $tipoempleado->estatus,
		    								   	   	   "editar"    => in_array($permisos['type_employee'],aPermisos('Editar'))?true:false,
		    								       	   "eliminar"  => in_array($permisos['type_employee'],aPermisos('Eliminar'))?true:false
		    										  );  
				
    		}

    		if(isset($aTipoEmpleados)){

    			$aTipoEmpleados['page_total']    = $tipoEmpleados->paged->total_pages;
    			$aTipoEmpleados['page_actual']   = $page;
    			$aTipoEmpleados['has_previous']  = $tipoEmpleados->paged->has_previous;
    			$aTipoEmpleados['has_next']      = $tipoEmpleados->paged->has_next;
    			$aTipoEmpleados['previous_page'] = $tipoEmpleados->paged->previous_page;
    			$aTipoEmpleados['next_page']     = $tipoEmpleados->paged->next_page;

				echo json_encode($aTipoEmpleados);

			} else {

				echo json_encode(array('empty' => true)); 

			}

    	}

    }
    public function agregar(){

    	$tipoEmpleado = new Tipo_empleado();
    	$modulos      = new Modulo();
    	$oPermisos    = new Permiso();

    	$data['view']     	  = 'sistema/tipo_empleado/agregar';
		$data['return']       = 'type_employee';
		$data['modulos']      = $modulos->where("estatus",1)->get();
		$data['cssFiles']     = array('sistema.css');
		$data['jsFiles']      = array('jquery.js',
							     	  'jquery-validation/dist/jquery.validate.js',
								      'jquery-validation/localization/messages_es.js',
								      'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){

			$tipoEmpleado->codigo         = $this->input->post('codigo'); 
			$tipoEmpleado->nombre         = $this->input->post('nombre');
			$tipoEmpleado->fecha_alta     = date("Y-m-d H:i:s");
			$tipoEmpleado->consultorio_id =  $this->session->userdata('id_consultorio');
			$tipoEmpleado->estatus        =  1;

			$modulos->where_in('id',$this->input->post('modulos'))->get();

			if($tipoEmpleado->save($modulos->all)){

				foreach($this->input->post('modulos') as $modulo){
					
					$oPermisos->where(array('modulo_id' => $modulo, 'tipo_empleado_id' => $tipoEmpleado->id))->get();
					$sumPermiso = 0;
					
					foreach($this->input->post('permisos_'.$modulo) as $permiso){
						 $sumPermiso = $sumPermiso + $permiso;
					}

					$oPermisos->permiso = $sumPermiso;
					$oPermisos->save();

				}

				redirect(base_url('type_employee'));

			} else {

				echo $tipoEmpleado->error->string;
				
			}

		}

    }

    public function editar($id_tipoEmpleado){

    	$tipoEmpleado = new Tipo_empleado();
    	$modulos      = new Modulo();
    	$oPermisos    = new Permiso();

    	$aPermisos = permisos($this->session->userdata('type_user'));

		$data['tipoEmpleado'] = $tipoEmpleado->where('id',$id_tipoEmpleado)->get();
		$data['modulos']      = $modulos->where("estatus",1)->get();
		$data['permisos']     = $oPermisos->where('tipo_empleado_id', $id_tipoEmpleado)->get();
		$data['printPermiso'] = $aPermisos['type_employee'];
 		$data['return']       = 'type_employee'; 		
		$data['view']         = 'sistema/tipo_empleado/editar';
		$data['cssFiles']     = array('sistema.css');
		$data['jsFiles']      = array('jquery.js',
							   	      'jquery-validation/dist/jquery.validate.js',
								      'jquery-validation/localization/messages_es.js',
								      'valid_forms.js');

		$this->load->view('sistema/template',$data);

		if($this->input->post()){	

			$tipoEmpleado->codigo             = $this->input->post('codigo'); 
			$tipoEmpleado->nombre             = $this->input->post('nombre');
			$tipoEmpleado->fecha_modificacion = date("Y-m-d H:i:s");

			$tipoEmpleado->modulo->get();
			$tipoEmpleado->delete($tipoEmpleado->modulo->all);
			$modulos->where_in('id',$this->input->post('modulos'))->get();

			if($tipoEmpleado->save($modulos->all)){

				foreach($this->input->post('modulos') as $modulo){
					
					$oPermisos->where(array('modulo_id' => $modulo, 'tipo_empleado_id' => $id_tipoEmpleado))->get();
					$sumPermiso = 0;
					
					foreach($this->input->post('permisos_'.$modulo) as $permiso){
						 $sumPermiso = $sumPermiso + $permiso;
					}

					$oPermisos->permiso = $sumPermiso;
					$oPermisos->save();

				}
				
				redirect(base_url('type_employee'));
				
			} else {

				echo $tipoEmpleado->error->string;

			}

		}
	}


public function eliminar($id_tipoEmpleado){

		$tipoEmpleado = new Tipo_empleado();

		$tipoEmpleado->where('id', $id_tipoEmpleado)->get();

		$tipoEmpleado->estatus    = 2;
		$tipoEmpleado->fecha_baja = date("Y-m-d H:i:s");

		if($tipoEmpleado->save()){

			echo json_encode(array('error' =>false,'id'=>$id_tipoEmpleado ));
		}else{

			echo json_encode(array('error' =>true));
		}
	}



	public function status($id_tipoEmpleado){

		$tipoEmpleado = new Tipo_empleado();

		$tipoEmpleado->where('id', $id_tipoEmpleado)->get();
		$estatus_actual = $tipoEmpleado->estatus;

		if($tipoEmpleado->estatus == 1){

			$tipoEmpleado->estatus    = 0;
			$status=0;
	
		} else{
			
			$tipoEmpleado->estatus    = 1;
			$status=1;

		}
		
		$tipoEmpleado->fecha_modificacion = date("Y-m-d H:i:s");
		if($tipoEmpleado->save()){

			echo json_encode(array('estatus' =>$status ,'id'=>$id_tipoEmpleado));
		}else{

			echo json_encode(array('error'=>true,'estatus' =>$estatus_actual ,'id'=>$id_tipoEmpleado));
		}

		

	}


   public function buscar($page = 1){

   		$aPermisos = permisos($this->session->userdata('type_user'));

    	$data['permisos'] = $aPermisos['type_employee'];
		$data['view']     = 'sistema/tipo_empleado/buscar';
		$data['return']   = 'type_employee';
		$data['cssFiles'] = array('jquery-ui/jquery-ui.css',
								  'sistema.css');
		$data['jsFiles']  = array('jquery.js',
							      'jquery-ui.js',
							      'jquery.ui.datepicker-es.js',
							      'valid_forms.js');

		$this->load->view('sistema/template',$data);

	}

	public function lista(){

		$tipoEmpleados = new Tipo_empleado();
		
		$tipoEmpleados->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
								    'estatus'        => 1))->get();

		$aTipoEmpleados = $tipoEmpleados->all_to_array();

		echo json_encode($aTipoEmpleados);

	}

	public function lista_add(){
	
		$tipoEmpleados = new Tipo_Empleado();

		$tipoEmpleados->where(array('consultorio_id' => $this->session->userdata('id_consultorio'),
								   'estatus'       => 1));

		$tipoEmpleados->where('CONCAT( codigo, "  " , nombre ) like "%'.$_GET['term'].'%"')->get();
		
		$aTipoEmpleados = array();

		foreach($tipoEmpleados as $tipoempleado){
			 $aTipoEmpleados[] = array("Id"    => $tipoempleado->id, 
			 					  	   "label" => $tipoempleado->codigo ." ". $tipoempleado->nombre,
		 					  	       "value" => $tipoempleado->codigo ." ". $tipoempleado->nombre);

	}

	echo json_encode($aTipoEmpleados);

}

}
