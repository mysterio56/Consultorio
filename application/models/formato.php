<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Formato extends DataMapper
{

    public $table = "formatos";
   
    public $has_many = array("consultorio");

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

        $consultorio = new Consultorio();

        $consultorio->where(array("id" => CONSULTORIOID))->get();

        $consultorio->formato->where($campo,$this->{$field})->get();

        if(count($consultorio->formato->all)){
            return false;
        } else {
            return true;
        }

    }
 
}