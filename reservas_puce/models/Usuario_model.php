<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {
    public function get()
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $query = $this->reservas->get('usuario');
        return $query->result_array();
    }

    public function update($usuario, $data)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $this->reservas->where('usuario', $usuario);
        $resp = $this->reservas->update('usuario', $data);

        if($resp)
        {
            $msn = 'Se actualizó el usuario '.$usuario;
            $this->log($msn);
            return 'TRUE';
        }
        else
        {
            return 'FALSE';
        }
    }

    public function delete($usuario)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $this->reservas->where('usuario', $usuario);
        $resp = $this->reservas->delete('usuario_x_rol');
        $this->reservas->where('usuario', $usuario);
        $resp1 = $this->reservas->delete('usuario');
        if($resp && $resp1)
        {
            $msn = 'Se eliminó el usuario '.$usuario;
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
        $resp = $this->reservas->insert('usuario', $data);

        if($resp)
        {
            $msn = 'Se creó el usuario '.$data['usuario'];
            $this->log($msn);
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
                                              values ('$mensaje', 'usuario', '$usuario');");
    }
}