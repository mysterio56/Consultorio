<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



    function addressData($sModule, $sMethod, $nId){

            $sWebService = 'webservice.masqweb.com';
            $sKey        = '7d8c7a75cc08ebb6ebc890c4acf3c005';

        if(function_exists('curl_init')){

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://'. $sWebService .'/'.$sModule.'/'.$sMethod.'/'.$nId);
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