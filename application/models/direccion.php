<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Direccion extends DataMapper
{
 
    public $table = "direcciones";

    public $has_one = array("consultorio","empleado","paciente");

    public $validation = array(
        'estado_id' => array(
            'label' => 'Estado',
            'rules' => array('required'),
        ),
        'municipio_id' => array(
            'label' => 'Municipio',
            'rules' => array('required'),
        ),
        'codigo_postal_id' => array(
            'label' => 'Codigo Postal',
            'rules' => array('required'),
        ),
        'colonia_id' => array(
            'label' => 'Colonia',
            'rules' => array('required'),
        ),
        'calle' => array(
            'label' => 'Calle',
            'rules' => array('required'),
        ),
    );

}