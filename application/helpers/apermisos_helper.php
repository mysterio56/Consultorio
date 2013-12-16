<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('aPermisos'))
{
    function aPermisos($sPermisos)
    {

    	$aPermisos = array("Agregar"  => array(4,5,6,7),
                           "Editar"   => array(2,3,6,7),
                           "Eliminar" => array(1,3,5,7)
                           );
        
        return $aPermisos[$sPermisos];

    }   
}