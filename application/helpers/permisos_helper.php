<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('permisos'))
{
    function permisos($tipo_empleado_id = null)
    {

    	$permisos = new Permiso();
    	$modulos  = new Modulo();
        $aPermisosUsuario = array();

    	$permisos->where('tipo_empleado_id', $tipo_empleado_id)->get();

    	foreach($permisos as $aIthem){
    		$modulos->where('id', $aIthem->modulo_id)->get();
    		$aPermisosUsuario[$modulos->url] = $aIthem->permiso;
    	}

        if(empty($aPermisosUsuario) || $tipo_empleado_id == 'admin'){

            return $aPermisosUsuario;

        } else {

                redirect(base_url('error'));
            
        }

    }   
}