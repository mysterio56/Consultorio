<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Ingreso extends DataMapper
{
	public $table = "ingresos";
	public $has_many = array("paciente", "reunion","servicio");

	public $error_prefix = '<div class="error">';
    public $error_suffix = '</div>';
    
    public $validation = array(
    		'costo' =>array(
	    		'label'  =>'costo' ,
	    		'rules'  =>array('requeride'), 
    		),

    		'estatus'=>array(
    			'label' =>'estatus',
    			'rules' =>array('requeride'),
    		) 
    );
}


