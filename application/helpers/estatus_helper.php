<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('estatus'))
{

    function estatus($estatus){

    	switch ($estatus) {
        case 1:
            return 'yellow';
            break;
        case 2:
            return "green";
            break;
        case 3:
            return "red";
            break;
        case 4:
            return "orange";
            break;
    	}
    }

}