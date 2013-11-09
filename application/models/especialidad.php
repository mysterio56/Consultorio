<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Especialidad extends DataMapper
{

	public $table = "especialidades";

	public $has_many = array("empleado");

	public $error_prefix = '<div class="error">';
    public $error_suffix = '</div>';

	public $validation = array(
        'nombre' => array(
            'label' => 'Especialidad',
            'rules' => array('required', 'trim', 'unique', 'min_length' => 2, 'max_length' => 45),
        ),
        'codigo' => array(
            'label' => 'Código',
            'rules' => array('required', 'trim', 'unique', 'min_length' => 4, 'max_length' => 15),
        )
    );

}