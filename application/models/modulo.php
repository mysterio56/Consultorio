<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Modulo extends DataMapper
{
 
    public $table = "modulos";

    public $has_many = array("usuario");

    public $has_one = array("modulo");

}