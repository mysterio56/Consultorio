<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Tipo_consultorio extends DataMapper
{

    public $table = "tipo_consultorios";

    public $has_one = array("consultorio");
 
}