<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crond extends CI_Controller{

	public function __construct()
    {
   		parent::__construct();
    }

	public function index()
	{
		
		
		$this->load->library('email');

		$config['protocol'] = "smtp";
		$config['smtp_host'] = "ssl://smtp.gmail.com";
		$config['smtp_port'] = "465";
		$config['smtp_user'] = "aslanlion56@gmail.com"; 
		$config['smtp_pass'] = "wnY3IEWIVW";
		$config['charset'] = "utf-8";
		$config['mailtype'] = "html";
		$config['newline'] = "\r\n";

		$this->email->initialize($config);

		$this->email->from('aslanlion56@gmail.com', 'Blabla');
		$list = array('srfj_56@hotmail.com');
		$this->email->to($list);
		//$this->email->reply_to('my-email@gmail.com', 'Explendid Videos');
		$this->email->subject('This is an email test');
		$this->email->message('It is working. Great!');
		$this->email->send();

		
	}

}