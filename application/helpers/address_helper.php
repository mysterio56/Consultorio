<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('addressData'))
{
    function addressData($sModule, $sMethod, $nIdParent = NULL){

        $sWebService   = 'localhost/Address';
        $sKey          = '1owvUtwudHylyenow15OkerirfudhocOve';
        $fields        = array('key' => urlencode($sKey));
        $fields_string = '';

        if(function_exists('curl_init')){

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://'. $sWebService .'/'.$sModule.'/'.$sMethod.'/'.$nIdParent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);

            foreach($fields as $key => $value) { $fields_string .= $key.'='.$value.'&'; }
            rtrim($fields_string, '&');
            
            curl_setopt($ch,CURLOPT_POST, count($fields));
            curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

            $aData = curl_exec($ch);
            curl_close($ch);

            return $aData;
        } else {

            echo "No hay soporte para cURL";

        }
    }
}   