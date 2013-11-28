<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Historia extends DataMapper
{

	public $table = "historico_citas";

	public $has_many = array("reunion");

	public $error_prefix = '<div class="error">';
    public $error_suffix = '</div>';

	public $validation = array(
        'fecha_hora' => array(
            'label' => 'Fecha de la cita',
            'rules' => array('required')
        ),
        'fecha_alta' => array(
            'label' => 'fecha de alta',
            'rules' => array('required')
            
        )
    );

}
