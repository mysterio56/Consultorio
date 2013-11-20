<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Especialidad extends DataMapper
{

	public $table = "especialidades";

	public $has_many = array("empleado", "consultorio");

	public $error_prefix = '<div class="error">';
    public $error_suffix = '</div>';

	public $validation = array(
        'nombre' => array(
            'label' => 'Especialidad',
            'rules' => array('required', 'trim', 'unique_for_surgery' => 'nombre', 'min_length' => 2, 'max_length' => 45),
        ),
        'codigo' => array(
            'label' => 'Código',
            'rules' => array('required', 'trim', 'unique_for_surgery' => 'codigo', 'min_length' => 4, 'max_length' => 15),
        )
    );

    function _unique_for_surgery($field, $campo)
    {

        $especialidad = new Especialidad();

        $especialidad->where(array($campo           => $this->{$field},
                                   "consultorio_id" => CONSULTORIOID))->get();

        if(count($especialidad->all)){
            return false;
        } else {
            return true;
        }

    }

}