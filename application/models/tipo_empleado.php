<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Tipo_empleado extends DataMapper
{

    public $extensions = array('array');

    public $table = "tipo_empleados";

    public $has_many = array("modulo", "submodulo");

    public $has_one = array("empleado");

    public $error_prefix = '<div class = "error">';
    public $error_suffix = '</div>';

	public $validation = array(
        'nombre' => array(
            'label' => 'Nombre',
            'rules' => array('required', 'trim', 'unique_for_surgery' => 'nombre', 'min_length' => 2, 'max_length' => 45),
        ),
        'codigo' => array(
            'label' => 'Código',
            'rules' => array('required', 'trim', 'unique_for_surgery' => 'codigo', 'min_length' => 4, 'max_length' => 15),
        )
    );

    function _unique_for_surgery($field, $campo)
    {

        $tipo_empleado = new Tipo_empleado();

        $tipo_empleado->where(array($campo           => $this->{$field},
                                    "consultorio_id" => CONSULTORIOID))->get();

        if(count($tipo_empleado->all)){
            return false;
        } else {
            return true;
        }

    }

}