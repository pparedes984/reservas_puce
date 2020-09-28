<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Horario_model extends CI_Model {
    public function get($id, $fecha)
    {

        $this->reservas = $this->load->database('reservas', TRUE);
        $sql = 'select id, id_lugar, estado, 
                                          left(hora_inicio,5) hora_inicio,
                                          left(hora_fin,5) hora_fin
                                          from horario
                                         where id_lugar = '.$id.
                                          ' and estado = 1';
        date_default_timezone_set('America/Bogota');
        $date = date("Y-m-d");
        $fecha = date("Y-m-d", strtotime($fecha) );
        if($fecha == $date) {
            $sql = $sql . ' and hora_inicio > CONVERT (time, GETDATE());';
        }
        $query = $this->reservas->query($sql);

        return $query->result_array();
    }

    public function obtener($id)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $sql = 'select id, id_lugar, estado, 
                                          left(hora_inicio,5) hora_inicio,
                                          left(hora_fin,5) hora_fin
                                          from horario
                                          where id_lugar = '.$id.
                                          ' and estado = 1';
        //$sql = $sql . ' and hora_inicio > CONVERT (time, GETDATE());';
        $query = $this->reservas->query($sql);
        return $query->result_array();
    }


    public function create($id)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $lugares = $this->reservas->query("WITH n(id, descripcion, id_estado, aforo, id_tipo, id_lugar, nivel, hora_inicio, hora_fin, intervalo) AS 
                                           (SELECT id, descripcion, id_estado, aforo, id_tipo, id_lugar, nivel, hora_inicio, hora_fin, intervalo 
                                            FROM lugar
                                            WHERE id = $id
                                                UNION ALL
                                            SELECT tb.id, tb.descripcion, tb.id_estado, tb.aforo, tb.id_tipo, tb.id_lugar, tb.nivel, tb.hora_inicio, tb.hora_fin, tb.intervalo
                                            FROM lugar as tb, n
                                            WHERE n.id = tb.id_lugar)
                                        SELECT * FROM n;")->result_array();

        $minutos = $this->reservas->query("SELECT id
                                        ,LTRIM(DATEDIFF(MINUTE, 0, intervalo)) intervalo 
                                        ,LTRIM(DATEDIFF(MINUTE, 0, hora_inicio)) hora_inicio
                                        ,LTRIM(DATEDIFF(MINUTE, 0, hora_fin)) hora_fin
                                        FROM lugar where id = $id")->result_array();
        $inicio = $minutos[0]['hora_inicio'];
        $fin = $minutos[0]['hora_fin'];
        $intervalo = $minutos[0]['intervalo'];
        $horas_inicio = date('H:i', mktime(0, $inicio));
        $horas_fin = date('H:i', mktime(0, $fin));
        $horas_intervalo = date('H:i', mktime(0, $intervalo));
        for($i =0; $i<count($lugares); $i++) {
            $lugar = $lugares[$i]['id'];
            $aux_inicio = $inicio;
            $this->reservas->query("update lugar set hora_inicio = '$horas_inicio', hora_fin = '$horas_fin', intervalo = '$horas_intervalo' where id = $lugar ");
            $this->reservas->query("update horario set estado = 0 where id_lugar = $lugar");
            while($aux_inicio<=($fin-$intervalo)){
                $hora_inicio = date('H:i', mktime(0, $aux_inicio));
                $hora_fin = date('H:i', mktime(0, $aux_inicio + $intervalo));
                $this->reservas->query("insert into horario (id_lugar, hora_inicio, hora_fin)
                                        values($lugar,'$hora_inicio','$hora_fin')");
                $aux_inicio = $aux_inicio + $intervalo;
            };
        }
        $msn = 'Se creó los horarios para el registro '.$id.' y todos sus hijos';
        $this->log($msn);
        return 'TRUE';
    }

    public function verificar()
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $last_id = $this->reservas->query("select IDENT_CURRENT('lugar') as id;")->result_array();
        $last_id = $last_id[0]['id'];
        $resp = $this->reservas->query("SELECT *
                                          FROM lugar
                                          where id = $last_id
                                          and hora_inicio is not null;")->num_rows();
        if($resp > 0)
        {
            return $last_id;
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
                                              values ('$mensaje', 'horario', '$usuario');");
    }
}