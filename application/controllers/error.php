<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller{

	public function index(){

		echo 'Tu sesión expiro, Inicia session de nuevo';
		
	}
}