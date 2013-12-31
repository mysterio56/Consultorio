<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Servicio extends DataMapper
{

    public $extensions = array('array');

    public $table = "servicios";
    
    public $has_one = array("consultorio");

     public $has_many = array("reunion","ingreso","egreso");

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

        $servicio = new Servicio();

        $servicio->where(array($campo           => $this->{$field},
                               "consultorio_id" => CONSULTORIOID))->get();

        if(count($servicio->all)){
            return false;
        } else {
            return true;
        }

    }


 
}