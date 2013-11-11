<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Direccion extends DataMapper
{
 
    public $table = "direcciones";

    public $has_one = array("consultorio");

}