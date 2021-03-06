<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Egreso extends DataMapper
{
	public $table = "egresos";

	public $has_one = array("producto","consultorio","servicio");

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


