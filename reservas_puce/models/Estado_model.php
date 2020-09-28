<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Estado_model extends CI_Model {
    public function get()
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $query = $this->reservas->get('estado');
        return $query->result_array();
    }
}