<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Reunion extends DataMapper
{

    public $extensions = array('array');
    
	public $table = "citas";

	public $has_one = array("paciente","empleado","servicio");

   // public $has_many = array("ingreso");

	public $error_prefix = '<div class="error">';
    public $error_suffix = '</div>';

	public $validation = array(
        'fecha_hora' => array(
            'label' => 'Fecha de la cita',
            'rules' => array('required')
        ),
        'fecha_alta' => array(
            'label' => 'fecha de alta',
            'rules' => array('required')
            
        )
    );

}
