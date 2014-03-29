<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Address extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	if (!$this->session->userdata('username')){ echo "error"; exit(); }
    	$this->load->helper('address');
    }

	public function getFederalEntities($id_federal_entities = null)
	{

		
		echo addressData('getFederalEntities'); 

	}

	public function getMunicipalities($id_federal_entities, $id_municipio = null)
	{

		echo addressData('getMunicipalities', $id_federal_entities); 

	}

	public function getPostalCodes($id_municipio, $id_codigo_postal = null)
	{

		echo addressData('getPostalCodes', $id_municipio); 

	}

	public function getColonies($id_codigo_postal, $id_colonia = null)
	{

		echo addressData('getColonies', $id_codigo_postal); 

	}



}