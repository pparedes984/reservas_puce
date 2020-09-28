<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tipo_model extends CI_Model {
    public function get()
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $query = $this->reservas->get('tipo');
        return $query->result_array();
    }

    public function update($id, $data)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $this->reservas->where('id', $id);
        $resp = $this->reservas->update('tipo', $data);

        if($resp)
        {
            $msn = 'Se actualizó el tipo '.$id;
            $this->log($msn);
            return 'TRUE';
        }
        else
        {
            return 'FALSE';
        }
    }

    public function delete($id)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $this->reservas->where('id', $id);
        $resp = $this->reservas->delete('tipo');
        if($resp)
        {
            $msn = 'Se eliminó el tipo '.$id;
            $this->log($msn);
            return 'TRUE';
        }
        else
        {
            return 'FALSE';
        }
    }

    public function create($data)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $resp = $this->reservas->insert('tipo', $data);
        $last_id = $this->reservas->query("select IDENT_CURRENT('tipo') as id;")->result_array();
        $last_id = $last_id[0]['id'];
        if($resp)
        {
            $msn = 'Se creó el tipo '.$last_id;
            $this->log($msn);
            return 'TRUE';
        }
        else
        {
            return 'FALSE';
        }
    }

    public function verificar($descripcion)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $this->reservas->where('descripcion', $descripcion);
        $query = $this->reservas->get('tipo')->num_rows();
        if($query == 0)
        {
            return 'TRUE';
        }
        else
        {
            return 'FALSE';
        }
    }

    public function log($mensaje)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $usuario = $this->session->session_usuario_apps;
        $this->reservas->query("insert into log
                                              (descripcion, tabla, usuario)
                                              values ('$mensaje', 'tipo', '$usuario');");
    }
}