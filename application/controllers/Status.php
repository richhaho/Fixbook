<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Status
 *
 *
 * @package		FixBook
 * @category	Controller
 * @author		Luigi Verzì
 * @description	Get the order status to client
*/

class Status extends CI_Controller
{
	// THE CONSTRUCTOR //
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('Impostazioni_model');
        $this->lang->load('global', $this->Impostazioni_model->get_lingua());
    }
	
	// SHOW THE STATUS PAGE //
    public function index()
    {
        $data['impostazioni'] = $this->Impostazioni_model->lista_impostazioni();
        $this->load->view('status_page', $data);
    }
	
	// GET THE STATUS OF ORDER //
    public function ottieni_stato()
    {
        $codice = $this->input->post('codice', true);

        $data = array();
        $query = $this->db->get_where('oggetti', array('codice' => $codice));
        if ($query->num_rows() > 0 && strlen($codice) > 3) {
            $data = $query->row_array();
            echo json_encode($data);
        } else {
            echo 'false';
        }
    }
}
