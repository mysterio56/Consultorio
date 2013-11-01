<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Empleado extends DataMapper
{

	public $table = "empleados";

	public $has_one = array("usuario");

}