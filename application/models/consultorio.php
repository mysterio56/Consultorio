<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Consultorio extends DataMapper
{

	public $table    = "consultorios";

	public $has_one  = array("empleado","tipo_consultorio","direccion","producto","servicio","tipo_empleado");

    public $has_many = array("paciente", "especialidad");

	public $error_prefix = '<div class="error">';
    public $error_suffix = '</div>';

    public $validation = array(
        'email' => array(
            'label' => 'Email',
            'rules' => array('valid_email', 'trim', 'min_length' => 2, 'max_length' => 45),
        ),
        'telefono1' => array(
            'label' => 'Teléfono 1',
            'rules' => array('trim', 'min_length' => 8, 'max_length' => 13),
        ),
        'telefono2' => array(
            'label' => 'Teléfono 2
            ',
            'rules' => array('trim', 'min_length' => 8, 'max_length' => 13),
        )
    );

}