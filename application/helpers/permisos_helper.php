<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('permisos'))
{
    function permisos($usuario_id = null)
    {

    	$permisos = new Permiso();
    	$modulos  = new Modulo();

    	$permisos->where('usuario_id', $usuario_id)->get();

    	foreach($permisos as $aIthem){
    		$modulos->where('id', $aIthem->modulo_id)->get();
    		$aPermisosUsuario[$modulos->url] = $aIthem->permiso;
    	}

        if(isset($aPermisosUsuario)){
            return $aPermisosUsuario;
        } else {
            redirect(base_url('error'));
        }

    }   
}