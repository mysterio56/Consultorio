<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('permisos'))
{
    function permisos($usuario_id = null, $modulo_id = null)
    {

    	$permisos = new Permiso();
    	$permisos->where(array('usuario_id' => $usuario_id,
    						   'modulo_id'  => $modulo_id))->get();

        return $permisos->permiso;

    }   
}