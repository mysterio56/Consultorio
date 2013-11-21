<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Consultorio extends DataMapper
{

	public $table    = "consultorios";

	public $has_one  = array("empleado","tipo_consultorio","direccion","producto","servicio","tipo_empleado");

    public $has_many = array("paciente", "especialidad","formato");

}