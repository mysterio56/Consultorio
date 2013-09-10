<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

	public function get_user ($name, $password)
	{
		$query = $this->db->get_where('users', array('username' => $name));

		if ($query->num_rows() > 0 ) {

			$query       = $query->row_array();
			$user_name   = $query['username'];
			$password_db = $query['password'];

			if($name === $user_name && $password === $password_db){

				$userdata = array('username' => $user_name);
				$this->session->set_userdata($userdata);
				return true;

			} else {

				return false;
				
			}
		}

	}

}