<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Usuario extends DataMapper
{
 
    public $table = "usuarios";
 
    //public $has_one = array("empleado");
 
    public $validation = array(
        'usuario' => array(
            'label' => 'Usuario',
            'rules' => array('required', 'trim', 'unique', 'min_length' => 2, 'max_length' => 45),
        ),
        'clave' => array(
            'label' => 'Clave',
            'rules' => array('required', 'trim', 'alpha_dash', 'min_length' => 5, 'max_length' => 50),
        )
    );
}