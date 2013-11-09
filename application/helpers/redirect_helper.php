<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('IframeRedirect'))
{
    function IframeRedirect()
    {
    	if(!isset($_SERVER['HTTP_REFERER']))
    		redirect(base_url('welcome'));
    }   
}