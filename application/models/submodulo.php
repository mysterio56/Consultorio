<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Submodulo extends DataMapper
{
 
 	public $extensions = array('array');
 	
    public $table = "submodulos";

    public $has_many = array("tipo_empleado");

    public $has_one = array("modulo");

}