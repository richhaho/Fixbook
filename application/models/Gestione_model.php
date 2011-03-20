<?php

/*
|--------------------------------------------------------------------------
| General model file
|--------------------------------------------------------------------------
| 
*/

class Gestione_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Impostazioni_model');
        $this->load->library('skebby');
        $this->load->library('twilio');
        $this->load->library('email');
    }

    /*------------------------------------------------------------------------
	| ADD THE ORDER/REPARATION TO DB
	| @param Customer name, phone number, category, model, problem, piece, advance, price, type, txt 1 or 0, comments
	|--------------------------------------------------------------------------*/
    public function inserisci_ordine($nominativo, $idnominativo, $telefono, $categoria, $modello, $guasto, $pezzo, $anticipo, $prezzo, $tipo, $sms, $commenti, $status, $custom,  $codice, $send_email, $email = false)
    {
        $data = array(
            'Nominativo' => $nominativo,
            'ID_nominativo' => $idnominativo,
            'Telefono' => $telefono,
            'Tipo' => $tipo,
            'Categoria' => $categoria,
            'Modello' => $modello,
            'Guasto' => $guasto,
            'Pezzo' => $pezzo,
            'Anticipo' => $anticipo,
            'Prezzo' => $prezzo,
            'sms' => $sms,
            'Commenti' => $commenti,
            'codice' => $codice,
            'status' =>  $status,
            'custom_field' => $custom,
            'dataApertura' => date('Y-m-d H:i:s'),
            'send_email' => $send_email,
            'email' => $email
        );

        $this->db->insert('oggetti', $data);
        $id = $this->db->insert_id();

        if ($sms == 1) 
        {
            $impostazioni = $this->Impostazioni_model->lista_impostazioni();
            $this->send_sms($telefono, $impostazioni[0]['r_apertura'], $nominativo, $modello, $codice, $id);
        }


        if ($send_email == 1 && $email != '') 
        {
            $impostazioni = $this->Impostazioni_model->lista_impostazioni();
            $this->send_email( $email, $impostazioni[0]['r_apertura'], $nominativo, $modello, $codice, $id);
        }

        return $id;
    }

    /*
	|--------------------------------------------------------------------------
	| ADD CUSTOMERS TO DB
	| @param Customer name, surname, street, city, phone, mail, comments
	|--------------------------------------------------------------------------
	*/
    public function inserisci_cliente($nome, $cognome, $indirizzo, $citta, $telefono, $email, $commenti, $vat, $cf)
    {
        $data = array(
            'nome' => $nome,
            'cognome' => $cognome,
            'telefono' => $telefono,
            'indirizzo' => $indirizzo,
            'citta' => $citta,
            'email' => $email,
            'data' => date('Y-m-d H:i:s'),
            'commenti' => $commenti,
            'vat' => $vat,
            'cf' => $cf
        );

        $this->db->insert('clienti', $data);
        return $this->db->insert_id();
    }

    /*
	|--------------------------------------------------------------------------
	| GET LIST OF ALL ORDERS/REPARATION
	|--------------------------------------------------------------------------
	*/
    public function lista_oggetti($id_nome = null)
    {
        $data = array();
        $this->db->order_by('Id', 'desc');
        if($id_nome != null) $query = $this->db->get_where('oggetti', array('ID_Nominativo' => $id_nome));
        else $query = $this->db->get('oggetti');
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }

        return $data;
    }

    /*
	|--------------------------------------------------------------------------
	| GET ALL CUSTOMERS LIST
	|--------------------------------------------------------------------------
	*/
    public function lista_clienti()
    {
        $data = array();
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('clienti');
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }

        return $data;
    }

    /*
	|--------------------------------------------------------------------------
	| COUNT CUSTOMERS
	| Get customers quantity value
	|--------------------------------------------------------------------------
	*/
    public function conta_clienti()
    {
        $this->db->from('clienti');

        return $this->db->count_all_results();
    }

    /*
	|--------------------------------------------------------------------------
	| COUNT ORDER
	| Get orders quantity value
	|--------------------------------------------------------------------------
	*/
    public function conta_ordini()
    {
        $this->db->where(array('tipo' => 1, 'status' => 1));
        $this->db->from('oggetti');

        return $this->db->count_all_results();
    }

    /*
	|--------------------------------------------------------------------------
	| COUNT REPARATION
	| Get reparation quantity value
	|--------------------------------------------------------------------------
	*/
    public function conta_riparazioni()
    {
        $this->db->where(array('tipo' => 2, 'status' => 1));
        $this->db->from('oggetti');

        return $this->db->count_all_results();
    }

    /*
	|--------------------------------------------------------------------------
	| SAVE ORDER/REPARATION TO DATABASE
	| @param Customer name, phone number, category, model, problem, piece, advance, price, type (order or reparation), id, txt 1 or 0, comments
	|--------------------------------------------------------------------------
	*/
    public function salva_ordine($nominativo, $idnominativo, $telefono, $categoria, $modello, $guasto, $pezzo, $anticipo, $prezzo, $tipo, $id, $sms, $commenti, $status, $custom, $codice, $send_email, $email)
    {

        $custom = $custom;
        $data = array(
            'Nominativo' => $nominativo,
            'ID_Nominativo' => $idnominativo,
            'Telefono' => $telefono,
            'Tipo' => $tipo,
            'Categoria' => $categoria,
            'Modello' => $modello,
            'Guasto' => $guasto,
            'Pezzo' => $pezzo,
            'Anticipo' => $anticipo,
            'Prezzo' => $prezzo,
            'sms' => $sms,
            'Commenti' => $commenti,
            'custom_field' => $custom,
            'status' => $status,
            'codice' => $codice,
            'send_email' => $send_email,
            'email' => $email
        );
        
        
        $ogg = $this->trova_oggetto($id);

        if ($sms == 1 && $ogg['status'] != $status && $status == 2) 
        {
            $impostazioni = $this->Impostazioni_model->lista_impostazioni();
            $this->send_sms($telefono, $impostazioni[0]['r_chiusura'], $nominativo, $modello, $codice, $id);
        }
        

        if ($send_email == 1 && $email != '' && $ogg['status'] != $status && $status == 2) 
        {
            $impostazioni = $this->Impostazioni_model->lista_impostazioni();
            $this->send_email( $email, $impostazioni[0]['r_chiusura'], $nominativo, $modello, $codice, $id);
        }
        
        $this->db->where('ID', $id);
        
        return $this->db->update('oggetti', $data);
    }

    /*
	|--------------------------------------------------------------------------
	| SAVE CUSTOMER
	| @param Customer name, surname, street, city, phone, id, mail, comments
	|--------------------------------------------------------------------------
	*/
    public function salva_cliente($nome, $cognome, $indirizzo, $citta, $telefono, $id, $email, $commenti, $vat, $cf)
    {
        $data = array(
            'nome' => $nome,
            'cognome' => $cognome,
            'telefono' => $telefono,
            'indirizzo' => $indirizzo,
            'citta' => $citta,
            'email' => $email,
            'commenti' => $commenti,
            'vat' => $vat,
            'cf' => $cf
        );
        $this->db->where('id', $id);
        $this->db->update('clienti', $data);
    }

    /*
	|--------------------------------------------------------------------------
	| LIST OF CLOSED ORDER/REPARATION
	| @param month, year
	|--------------------------------------------------------------------------
	*/
    public function lista_oggetti_chiusi($mese, $anno)
    {
        $data = array();
        $data1 = array();
        $this->db->order_by('Id', 'asc');
        $query = $this->db->get('oggetti');
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        foreach ($data as $d) {
            if ($d['status'] == 0) {
                if ((date('m', strtotime($d['dataChiusura'])) == $mese) && (date('Y', strtotime($d['dataChiusura'])) == $anno)) {
                    $data1[] = $d;
                }
            }
        }

        return $data1;
    }

    /*
	|--------------------------------------------------------------------------
	| GET EARNINGS BY MONTHS/YEARS
	| @param month, year
	|--------------------------------------------------------------------------
	*/
    public function lista_guadagni($mese, $anno)
    {
        $data = $this->lista_oggetti_chiusi($mese, $anno);
        $number = array();

        if(count($data) == 0) return 0;
        
        for ($i = 1; $i <= 33; ++$i) {
            $number[$i] = 0;
        }

        for ($d = 0; $d < count($data); ++$d) {
            $id = @date('j', strtotime($data[$d]['dataChiusura']));
            $number[$id] = $number[$id] + @$data[$d]['Prezzo'] + @$data[$d]['Anticipo'];
        }

        $number[32] = (int) $mese;
        $number[33] = (int) $anno;

        return $number;
    }

    /*
	|--------------------------------------------------------------------------
	| FIND ORDER/REPARATION
	| @param The ID
	|--------------------------------------------------------------------------
	*/
    public function trova_oggetto($id)
    {
        $data = array();
        $query = $this->db->get_where('oggetti', array('ID' => $id));
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }

        return $data;
    }

    /*
	|--------------------------------------------------------------------------
	| FIND CUSTOMER
	| @param The ID
	|--------------------------------------------------------------------------
	*/
    public function trova_cliente($id)
    {
        $data = array();
        $query = $this->db->get_where('clienti', array('ID' => $id));
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }

        return $data;
    }

    /*
	|--------------------------------------------------------------------------
	| GET THE NUMBER FROM CUSTOMERS NAME
	| @param Customers name
	|--------------------------------------------------------------------------
	*/
    public function number_from_id($id)
    {
        $data = array();

        $this->db->from('clienti');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->row_array();

            return $data['telefono'];
        } else {
            return false;
        }
    }

    /*
	|--------------------------------------------------------------------------
	| GET THE EAIL FROM CUSTOMERS NAME
	| @param Customers name
	|--------------------------------------------------------------------------
	*/
    public function email_from_id($id)
    {
        $data = array();

        $this->db->from('clienti');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->row_array();

            return $data['email'];
        } else {
            return false;
        }
    }

    /*
	|--------------------------------------------------------------------------
	| GET CUSTOMERS ID FROM NAME
	| @param Name
	|--------------------------------------------------------------------------
	*/
    public function id_from_name($nomen)
    {
        $value = $this->db->escape_like_str($nomen);

        $data = array();

        $this->db->from('clienti');
        $this->db->where("CONCAT(nome, ' ', cognome) LIKE '%".$value."%'", null, false);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->row_array();

            return $data['id'];
        } else {
            return false;
        }
    }

    /*
	|--------------------------------------------------------------------------
	| GET NAME FROM ID
	| @param ID
	|--------------------------------------------------------------------------
	*/
    public function name_from_id($id)
    {
        $data = array();

        $this->db->from('clienti');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->row_array();

            return $data['nome'].' '.$data['cognome'];
        } else {
            return false;
        }
    }

    /*
	|--------------------------------------------------------------------------
	| SET THE ORDERS STATUS TO: WORK IN PROGRESS
	| @param Order ID
	|--------------------------------------------------------------------------
	*/
    public function inriparazione_oggetto($id)
    {
        $data = array(
            'tipo' => 2,
        );
        $this->db->where('ID', $id);
        $this->db->update('oggetti', $data);
    }

    /*
	|--------------------------------------------------------------------------
	| SET THE ORDER STATUS  TO: CLOSED
	| @param Order ID
	|--------------------------------------------------------------------------
	*/
    public function completa_oggetto($id)
    {
        $data = array(
            'status' => 0,
            'dataChiusura' => date('Y-m-d H:i:s'),
        );
        $this->db->where('ID', $id);
        $this->db->update('oggetti', $data);
    }

    /*
	|--------------------------------------------------------------------------
	| SET THE ORDER STATUS  TO: APPROVED
	| @param Order ID
	|--------------------------------------------------------------------------
	*/
    public function approva_oggetto($id)
    {
        $data = array(
            'status' => 1,
        );
        $this->db->where('ID', $id);
        $this->db->update('oggetti', $data);
    }

    /*
	|--------------------------------------------------------------------------
	| SET THE ORDER STATUS TO: TO DELIVER
	| @param Order ID
	|--------------------------------------------------------------------------
	*/
    public function daconsegnare_oggetto($id)
    {
        $data = array(
            'status' => 2,
            'dataChiusura' => date('Y-m-d H:i:s'),
        );
        $this->db->where('ID', $id);
        $this->db->update('oggetti', $data);


        $ogg = $this->trova_oggetto($id);

        if ($ogg['sms'] == 1) 
        {
            $impostazioni = $this->Impostazioni_model->lista_impostazioni();
            $this->send_sms($ogg['Telefono'], $impostazioni[0]['r_chiusura'], $ogg['Nominativo'], $ogg['Modello'], $ogg['codice'], $id);
        }

        if ($ogg['send_email'] == 1 && $ogg['email'] != '') 
        {
            $impostazioni = $this->Impostazioni_model->lista_impostazioni();
            $this->send_email( $ogg['email'], $impostazioni[0]['r_chiusura'], $ogg['Nominativo'], $ogg['Modello'], $ogg['codice'], $id);
        }
    }

    /*
	|--------------------------------------------------------------------------
	| SEND THE SMS TO CUSTOMER
	|--------------------------------------------------------------------------
	*/
    public function send_sms($numero, $testo, $nominativo = '', $modello = '', $codice = '', $id = '')
    {
        $impostazioni = $this->Impostazioni_model->lista_impostazioni();
        $search  = array('%businessname%', '%customer%', '%model%', '%fixbookurl%', '%statuscode%', '%id%');
        $replace = array($impostazioni[0]['titolo'], $nominativo, $modello, site_url(), $codice, $id);
        $testo = str_replace($search, $replace, $testo);

        // IF THAT IS SKEBBY //
        if($impostazioni[0]['usesms'] == 1)
        {
            $this->skebby->set_recipients(array($impostazioni[0]['prefix_number'].''.$numero));
            $this->skebby->set_text($testo);
            return $this->skebby->send_sms();
        }
        // IF THAT IS TWILIO //
        else
        {
            return $this->twilio->sms(strval('+'.$impostazioni[0]['twilio_number']), strval('+'.$impostazioni[0]['prefix_number'].''.$numero), $testo);
        }
    }

    /*
	|--------------------------------------------------------------------------
	| SEND THE EMAIL TO CUSTOMER
	|--------------------------------------------------------------------------
	*/
    public function send_email($email, $testo, $nominativo = '', $modello = '', $codice = '', $id = '')
    {
        $impostazioni = $this->Impostazioni_model->lista_impostazioni();
        $search  = array('%businessname%', '%customer%', '%model%', '%fixbookurl%', '%statuscode%', '%id%');
        $replace = array($impostazioni[0]['titolo'], $nominativo, $modello, site_url(), $codice, $id);
        $testo = str_replace($search, $replace, $testo);

        // IF THAT IS SKEBBY //
        if($impostazioni[0]['email_sender'] != '')
        {
            
            if($impostazioni[0]['email_use_smtp'])
            {
                $config['protocol'] = 'smtp';
                $config['smtp_host'] = $impostazioni[0]['email_smtp_host'];
                $config['smtp_user'] = $impostazioni[0]['email_smtp_user'];
                $config['smtp_pass'] = $impostazioni[0]['email_smtp_pass'];
                $config['smtp_port'] = $impostazioni[0]['email_smtp_port'];

                $this->email->initialize($config);
            }
            
            $this->email->from($impostazioni[0]['email_sender'], $impostazioni[0]['titolo']);
            $this->email->to($email);
            $this->email->message($testo);
            
            return $this->email->send();
        }
    }

    /*
	|--------------------------------------------------------------------------
	| DELETE ORDER
	| @param Order ID
	|--------------------------------------------------------------------------
	*/
    public function elimina_oggetto($id)
    {
        $this->db->delete('oggetti', array('ID' => $id));
    }

    /*
	|--------------------------------------------------------------------------
	| DELETE CUSTOMER
	| @param Customer id
	|--------------------------------------------------------------------------
	*/
    public function elimina_cliente($id)
    {
        $this->db->delete('clienti', array('id' => $id));
    }

    public function writeLog($string) {
        $log_file = dirname(__FILE__) . '/log.txt';        
        if ($fh = @fopen($log_file, "w+")) {
            fputs($fh, $string, strlen($string));
            fclose($fh);
            return true;
        }
        else {
            return false;
        }
    }
}
