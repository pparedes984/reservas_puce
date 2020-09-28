<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lugar_model extends CI_Model {
    public function get()
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $query = $this->reservas->query("SELECT id
                                          ,descripcion
                                          ,id_estado
                                          ,aforo
                                          ,id_tipo
                                          ,id_lugar
                                          ,nivel
                                          ,left(hora_inicio,5) hora_inicio
                                          ,left(hora_fin,5) hora_fin
                                          ,left(intervalo,5 ) intervalo
                                      FROM lugar");
        return $query->result_array();
    }

    public function getReserva($id_lugar)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $sql = 'SELECT id
                                          ,descripcion
                                          ,id_estado
                                          ,aforo
                                          ,id_tipo
                                          ,id_lugar
                                          ,nivel
                                          ,left(hora_inicio,5) hora_inicio
                                          ,left(hora_fin,5) hora_fin
                                          ,left(intervalo,5 ) intervalo
                                      FROM lugar
                                      where id_estado = 1 
                                      and hora_inicio is not null';
        if($id_lugar == '')
            $sql = $sql.' and id_lugar is null';
        else
            $sql = $sql.' and id_lugar = '.$id_lugar;
        $query = $this->reservas->query($sql);
        return $query->result_array();
    }

    public function verificar_ingreso($id_lugar)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $sql = 'SELECT id
                                          ,descripcion
                                          ,id_estado
                                          ,aforo
                                          ,id_tipo
                                          ,id_lugar
                                          ,nivel
                                          ,left(hora_inicio,5) hora_inicio
                                          ,left(hora_fin,5) hora_fin
                                          ,left(intervalo,5 ) intervalo
                                      FROM lugar
                                      where id_estado = 1 
                                      and hora_inicio is not null';
        if($id_lugar == '')
            $sql = $sql.' and id_lugar is null';
        else
            $sql = $sql.' and id_lugar = '.$id_lugar;
        $query = $this->reservas->query($sql)->num_rows();
        if($query > 0)
        {
            return 'TRUE';
        }
        else
        {
            return 'FALSE';
        }
    }

    public function getReservaRegreso($id_lugar)
    {
        $this->reservas = $this->load->database('reservas', TRUE);

        $padre = $this->reservas->query("select id_lugar from lugar where id = $id_lugar")->result_array();
        $id_padre = $padre[0]['id_lugar'];
        $sql = 'SELECT id
                                          ,descripcion
                                          ,id_estado
                                          ,aforo
                                          ,id_tipo
                                          ,id_lugar
                                          ,nivel
                                          ,left(hora_inicio,5) hora_inicio
                                          ,left(hora_fin,5) hora_fin
                                          ,left(intervalo,5 ) intervalo
                                      FROM lugar
                                      where id_estado = 1 
                                      and hora_inicio is not null';
        if($id_padre == '')
            $sql = $sql.' and id_lugar is null';
        else
            $sql = $sql.' and id_lugar = '.$id_padre;
        $query = $this->reservas->query($sql);
        return $query->result_array();
    }

    public function verificar_regreso($id_lugar)
    {
        $this->reservas = $this->load->database('reservas', TRUE);

        $query = $this->reservas->query("select id_lugar from lugar where id = $id_lugar")->num_rows();
        if($query > 0)
        {
            return 'TRUE';
        }
        else
        {
            return 'FALSE';
        }
    }

    public function getHorario()
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $query = $this->reservas->query("SELECT id
                                          ,descripcion
                                          ,id_estado
                                          ,aforo
                                          ,id_tipo
                                          ,id_lugar
                                          ,nivel
                                          ,left(hora_inicio,5) hora_inicio
                                          ,left(hora_fin,5) hora_fin
                                          ,left(intervalo,5 ) intervalo
                                      FROM lugar
                                      WHERE hora_inicio is not null
									  AND hora_fin is not null
									  AND intervalo is not null ");
        return $query->result_array();
    }

    public function getHorarioFaltantes()
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $query = $this->reservas->query("SELECT id
                                          ,descripcion
                                          ,id_estado
                                          ,aforo
                                          ,id_tipo
                                          ,id_lugar
                                          ,nivel
                                          ,left(hora_inicio,5) hora_inicio
                                          ,left(hora_fin,5) hora_fin
                                          ,left(intervalo,5 ) intervalo
                                      FROM lugar
                                      WHERE hora_inicio is null
									  AND hora_fin is null
									  AND intervalo is null ");
        return $query->result_array();
    }

    public function update($id, $data)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        if (isset($data['id_lugar'])) {
            $aux = $data['id_lugar'];
            $query = $this->reservas->query("select nivel from lugar where id = $aux ")->result_array();
            $lugar = $this->reservas->query("select nivel from lugar where id = $id ")->result_array();
            $data['nivel'] = $query[0]['nivel'] + 1;
            $valor = $lugar[0]['nivel'] - $data['nivel'];
            $lugares = $this->reservas->query("WITH n(id, descripcion, id_estado, aforo, id_tipo, id_lugar, nivel, hora_inicio, hora_fin, intervalo) AS 
                                                (SELECT id, descripcion, id_estado, aforo, id_tipo, id_lugar, nivel, hora_inicio, hora_fin, intervalo 
                                                FROM lugar
                                                WHERE id = $id
                                                UNION ALL
                                                SELECT tb.id, tb.descripcion, tb.id_estado, tb.aforo, tb.id_tipo, tb.id_lugar, tb.nivel, tb.hora_inicio, tb.hora_fin, tb.intervalo
                                                FROM lugar as tb, n
                                                WHERE n.id = tb.id_lugar)
                                                SELECT * FROM n
                                                where id != $id;")->result_array();
            for($i =0; $i<count($lugares); $i++) {
                $lugar = $lugares[$i]['id'];
                $nivel = $lugares[$i]['nivel'] - $valor;
                $this->reservas->query("update lugar set nivel = $nivel where id = $lugar");
            }
        }
        $this->reservas->where('id', $id);
        $resp = $this->reservas->update('lugar', $data);
        if (isset($data['hora_inicio'])) {
            $hora_inicio = $data['hora_inicio'];
            $this->reservas->query("update lugar set hora_inicio = '$hora_inicio' where id_lugar = $id");
        }
        if (isset($data['hora_fin'])) {
            $hora_fin= $data['hora_fin'];
            $this->reservas->query("update lugar set hora_fin = '$hora_fin' where id_lugar = $id");
        }
        if (isset($data['intervalo'])) {
            $intervalo = $data['intervalo'];
            $this->reservas->query("update lugar set intervalo = '$intervalo' where id_lugar = $id");
        }
        if($resp)
        {
            $msn = 'Se actualizó el lugar '.$id;
            $this->log($msn);
            return 'TRUE';
        }
        else
        {
            return 'FALSE';
        }
    }

    public function updateHorario($id, $hora_inicio, $hora_fin, $intervalo)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $resp = $this->reservas->query("update lugar 
                                        set hora_inicio = '$hora_inicio', hora_fin = '$hora_fin', intervalo = '$intervalo'
                                        where id = $id");
        if($resp)
        {
            $msn = 'Se actualizó el lugar '.$id;
            $this->log($msn);
            return 'TRUE';
        }
        else
        {
            return 'FALSE';
        }
    }

    public function deleteHorario($id)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $lugares = $this->reservas->query("select id from lugar where id = $id or (id_lugar = $id 
                                      and hora_inicio is null
									  AND hora_fin is null
									  AND intervalo is null)   ")->result_array();
        for($i =0; $i<count($lugares); $i++) {
            $lugar = $lugares[$i]['id'];
            $this->reservas->query("update horario set estado = 0 where id_lugar = $lugar");
        }
        $resp = $this->reservas->query("update lugar 
                                        set hora_inicio = null, hora_fin = null, intervalo = null
                                        where id = $id");
        if($resp)
        {
            $msn = 'Se inactivo los horarios del registro '.$id;
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

        $lugar= $this->reservas->query("select * from lugar where id_lugar = $id")->num_rows();
        $reserva= $this->reservas->query("select * from reserva where id_lugar = $id")->num_rows();
        if($lugar == 0 && $reserva == 0) {
            $this->reservas->query("delete from horario where id_lugar = $id");
            $this->reservas->where('id', $id);
            $resp = $this->reservas->delete('lugar');
            if($resp)
            {
                $msn = 'Se eliminó el lugar '.$id;
                $this->log($msn);
                return 'TRUE';
            }
            else
            {
                return 'FALSE';
            }
        }
        else
            return 'FALSE';
    }

    public function create($data)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        if($data['id_lugar'] == null)
        {
            $data['nivel'] = 1;
        }
        else{
            $aux = $data['id_lugar'];
            $query = $this->reservas->query("select nivel from lugar where id = $aux ")->result_array();
            $data['nivel'] = $query[0]['nivel'] + 1;
            $horario = null;
            $id_lugar = null;
            do{
                $lugar = $this->reservas->query("select id_lugar, hora_inicio, hora_fin, intervalo from lugar where id = $aux")->result_array();
                $id_lugar = $lugar[0]['id_lugar'];
                $aux = $id_lugar;
                $horario = $lugar[0]['hora_inicio'];
                if($horario != '') {
                    $data['hora_inicio'] = $lugar[0]['hora_inicio'];
                    $data['hora_fin'] = $lugar[0]['hora_fin'];
                    $data['intervalo'] = $lugar[0]['intervalo'];
                    break;
                }
            }while($id_lugar != '');
        }
        $resp = $this->reservas->insert('lugar', $data);
        $last_id = $this->reservas->query("select IDENT_CURRENT('lugar') as id;")->result_array();
        $last_id = $last_id[0]['id'];

        if($resp)
        {
            $msn = 'Se creó el lugar '.$last_id;
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
        $query = $this->reservas->get('lugar')->num_rows();
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
                                              values ('$mensaje', 'lugar', '$usuario');");
    }
}