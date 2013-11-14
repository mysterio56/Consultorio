<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Paciente extends DataMapper
{

    public $table = "pacientes";

    public $has_one = array("direccion");

    public $error_prefix = '<div class="error">';
    public $error_suffix = '</div>';

	public $validation = array(
        'nombre' => array(
            'label' => 'Nombre del Paciente',
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
            'rules' => array('valid_email', 'trim', 'min_length' => 2, 'max_length' => 15),
        ),
        'telefono' => array(
            'label' => 'Teléfono',
            'rules' => array('trim', 'min_length' => 8, 'max_length' => 10),
        ),
        'celular' => array(
            'label' => 'Celular',
            'rules' => array('trim', 'min_length' => 10, 'max_length' => 13),
        )
    );
 
}