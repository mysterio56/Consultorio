<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('addressData'))
{
    function addressData($sModule, $sMethod, $nIdParent = NULL){

        $sWebService = 'localhost/Address';
        $sKey        = '1owvUtwudHylyenow15OkerirfudhocOve';

        if(function_exists('curl_init')){

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://'. $sWebService .'/'.$sModule.'/'.$sMethod.'/'.$nIdParent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('key: '.$sKey));
            $aData = curl_exec($ch);
            curl_close($ch);

            return $aData;
        } else {

            echo "No hay soporte para cURL";

        }
    }
}   