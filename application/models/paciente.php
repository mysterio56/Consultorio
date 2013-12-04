<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Paciente extends DataMapper
{

    public $table = "pacientes";

    public $has_one  = array("direccion");

    public $has_many = array("consultorio", "reunion");

    public $error_prefix = '<div class="error">';
    public $error_suffix = '</div>';

	public $validation = array(
        'nombre' => array(
            'label' => 'Nombre del Paciente',
            'rules' => array('required', 'trim', 'min_length' => 2, 'max_length' => 45),
        ),
        'codigo' => array(
            'label' => 'Código',
            'rules' => array('required', 'trim', 'unique_for_surgery' => 'codigo' , 'min_length' => 1, 'max_length' => 10),
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
            'rules' => array('trim', 'min_length' => 8, 'max_length' => 10),
        ),
        'celular' => array(
            'label' => 'Celular',
            'rules' => array('trim', 'min_length' => 10, 'max_length' => 13),
        )
    );

    function _unique_for_surgery($field, $campo)
    {

        $consultorio = new Consultorio();

        $consultorio->where(array("id" => CONSULTORIOID))->get();

        $consultorio->paciente->where($campo,$this->{$field})->get();

        if(count($consultorio->paciente->all)){
            return false;
        } else {
            return true;
        }

    }
 
}