<?php

/*
|--------------------------------------------------------------------------
| Login model file
|--------------------------------------------------------------------------
| 
*/


class Login_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

	/*------------------------------------------------------------------------
	| CHECK THE LOGIN
	| @param email, password
	|--------------------------------------------------------------------------*/
    public function controlla_login($email, $password)
    {
        $this->db->where('admin_user', $email);
        $this->db->where('admin_password', $password);
        $query = $this->db->get('impostazioni', 1);

        if ($query->num_rows() == 1) {
            $this->load->helper('cookie');
            $this->input->cookie('admin', TRUE);
            return true;
        }

        return false;
    }

	/*------------------------------------------------------------------------
	| CHECK IF EMAIL EXISTS
	| @param email
	|--------------------------------------------------------------------------*/
    public function controlla_email($mail)
    {
        $data = array();
        $query = $this->db->get_where('impostazioni', array('admin_user' => $mail));
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

	/*------------------------------------------------------------------------
	| SEND PASSWORD TO MAIL
	| @param mail
	|--------------------------------------------------------------------------*/
    public function invia_password($mail)
    {
        $data = array();
        $query = $this->db->get('impostazioni');
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
            $this->send_email('luigiverzi@hotmail.it', $data[0]['admin_password']);
        }

        return 1;
    }

	/*------------------------------------------------------------------------
	| SEND THE EMAIL
	| @param email, password
	|--------------------------------------------------------------------------*/
    public function send_email($email, $password)
    {
        /* IN PROGRESS, OUT ON NEW VERSION */
    }
}
