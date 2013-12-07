<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('month'))
{
    function month($nMonth, $bLong){

        switch ($nMonth) {
            case 0:
                return $bLong?"Enero":"Ene";
                break;
            case 1:
                return $bLong?"Febrero":"Feb";
                2;
                break;
            case 2:
                return $bLong?"Marzo":"Mar";
                break;
            case 3:
                return $bLong?"Abril":"Abr";
                break;
            case 4:
                return $bLong?"Mayo":"May";
                break;
            case 5:
                return $bLong?"Junio":"Jun";
                break;
            case 6:
                return $bLong?"Julio":"Jul";
                break;
            case 7:
                return $bLong?"Agosto":"Ago";
                break;
            case 8:
                return $bLong?"Septiembre":"Sep";
                break;
            case 9:
                return $bLong?"Octubre":"Oct";
                break;
            case 10:
                return $bLong?"Noviembre":"Nov";
                break;
            case 11:
                return $bLong?"Diciembre":"Dic";
                break;
        }

    }
}   