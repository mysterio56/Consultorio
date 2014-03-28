<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Address extends CI_Controller{

	public function __construct()
    {
    	parent::__construct();
    	if (!$this->session->userdata('username')){ echo "error"; exit(); }
    	$this->load->helper('address');
    }

	public function getFederalEntities()
	{

		$id_pais = 139;
		echo addressData('federal_entities','getFederalEntities'); 

	}

	public function getMunicipalities($id_federal_entities)
	{

		echo addressData('municipalities','getMunicipalities', $id_federal_entities); 

	}

	public function getPostalCodes($id_municipio)
	{

		echo addressData('postal_codes','getPostalCodes', $id_municipio); 

	}

	public function getColonies($id_codigo_postal)
	{

		echo addressData('colonies','getColonies', $id_codigo_postal); 

	}



}