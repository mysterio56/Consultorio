<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Empleado extends DataMapper
{

	public $table = "empleados";

	public $has_one = array("usuario","consultorio","direccion");

	public $has_many = array("especialidad");

	public $error_prefix = '<div class="error">';
    public $error_suffix = '</div>';

	public $validation = array(
        'nombre' => array(
            'label' => 'Nombre del Empleado',
            'rules' => array('required', 'trim', 'min_length' => 2, 'max_length' => 45),
        ),
        'codigo' => array(
            'label' => 'Código',
            'rules' => array('required', 'trim', 'unique', 'min_length' => 4, 'max_length' => 15),
        ),
        'apellido_p' => array(
            'label' => 'Apellido Paterno',
            'rules' => array('required', 'trim', 'min_length' => 2, 'max_length' => 15),
        ),
        'apellido_m' => array(
            'label' => 'Apellido Materno',
            'rules' => array('trim', 'min_length' => 2, 'max_length' => 15),
        ),
        'email' => array(
            'label' => 'Email',
            'rules' => array('valid_email', 'trim', 'min_length' => 2, 'max_length' => 45),
        ),
        'telefono' => array(
            'label' => 'Teléfono',
            'rules' => array('trim', 'min_length' => 2, 'max_length' => 15),
        ),
        'celular' => array(
            'label' => 'Celular',
            'rules' => array('trim', 'min_length' => 2, 'max_length' => 15),
        )
    );

}