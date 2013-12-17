<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Producto extends DataMapper
{

    public $table = "productos";

    public $has_one = array("consultorio");

    public $has_many = array("ingreso");

    public $error_prefix = '<div class = "error">';
    public $error_suffix = '</div>';

	public $validation = array(
        'nombre' => array(
            'label' => 'Nombre',
            'rules' => array('required', 'trim', 'unique_for_surgery' => 'nombre', 'min_length' => 2, 'max_length' => 45),
        ),
        'codigo' => array(
            'label' => 'Código',
            'rules' => array('required', 'trim', 'unique_for_surgery' => 'codigo', 'min_length' => 1, 'max_length' => 10),
        ),
        'descripcion' => array(
            'label' => 'Descripcion',
            'rules' => array('trim', 'max_length' => 100)
        )
    );

    function _unique_for_surgery($field, $campo)
    {

        $producto = new Producto();

        $producto->where(array($campo           => $this->{$field},
                               "consultorio_id" => CONSULTORIOID))->get();

        if(count($producto->all)){
            return false;
        } else {
            return true;
        }

    }
 
}