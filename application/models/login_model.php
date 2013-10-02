<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

	public function get_user ($name, $password)
	{
		$query = $this->db->get_where('usuarios', array('usuario' => $name,
														'clave'   => $password));

		if ($query->num_rows() > 0 ) {

				$userdata = array('username' => $user_name);
				$this->session->set_userdata($userdata);
				return true;

			} else {

				return false;
				
			}
		}

}