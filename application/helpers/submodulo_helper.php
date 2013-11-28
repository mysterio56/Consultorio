<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('submodulos'))
{
    function submodulos($tipo_empleado_id = null, $modulo_id = null)
    {

    	$permisosub = new Permisosub();
    	$modulos = new Modulo();

        $modulos->where("id",  $modulo_id)->get();

        $submodulos = $modulos->submodulo->get()->all;

        foreach ($submodulos as $submodulo){

            $permisosub->where(array('submodulo_id'     => $submodulo->id,
                                     'tipo_empleado_id' => $tipo_empleado_id))->get();

            foreach($permisosub as $permiso){
                $aPermisosSub[$submodulo->nombre] =  $permiso->permiso;
            }
        } 

        if (isset($aPermisosSub)){
           return $aPermisosSub;
        } else {
            return false;
        }

    }   
}