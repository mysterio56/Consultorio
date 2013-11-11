<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('IframeRedirect'))
{
    function IframeRedirect()
    {
    	if(!isset($_SERVER['HTTP_REFERER'])){
    		if($_SERVER['HTTP_REFERER'] != base_url('welcome')){
    			redirect(base_url('welcome'));
    		}
    	}
    }   
}