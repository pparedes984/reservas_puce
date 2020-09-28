<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reserva_model extends CI_Model {
    public function get($start,$limit)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $usuario = $this->session->session_usuario_apps;
        $cantidadConsulta = $start+$limit;
        $query = $this->reservas->query("select * from 
                                        (select reserva.id, usuario, nombre, cedula, id_horario, reserva.id_lugar, asistencia, fecha_reserva,
                                        lugar.descripcion lugar
                                        ,left(horario.hora_inicio,5) hora_inicio
                                        ,left(horario.hora_fin,5) hora_fin 
                                        ,ROW_NUMBER() OVER (ORDER BY fecha_reserva desc) AS ROW 
                                        from reserva 
                                        inner join horario on reserva.id_horario = horario.id
                                        inner join lugar on reserva.id_lugar = lugar.id
                                        where usuario = '$usuario'
                                        )
                                        IT
                                        where IT.row > $start and IT.row <= $cantidadConsulta;");
        return $query->result_array();
    }

    public function getTotal()
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $usuario = $this->session->session_usuario_apps;
        $this->reservas->where('usuario', $usuario);
        $query = $this->reservas->get('reserva');
        return $query->num_rows();
    }

    public function buscar($fecha, $usuario, $lugar, $horario, $cedula, $start,$limit)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $cantidadConsulta = $start+$limit;
        $sql ="select * from 
                                        (select reserva.id, usuario, nombre, cedula, id_horario, reserva.id_lugar, asistencia, fecha_reserva,
                                        lugar.descripcion lugar
                                        ,left(horario.hora_inicio,5) hora_inicio
                                        ,left(horario.hora_fin,5) hora_fin 
                                        ,ROW_NUMBER() OVER (ORDER BY fecha_reserva desc) AS ROW 
                                        from reserva 
                                        inner join horario on reserva.id_horario = horario.id
                                        inner join lugar on reserva.id_lugar = lugar.id
                                        where 1=1
                                        ";
        if($fecha != '') {
            $fecha = date("Y-m-d", strtotime($fecha) );
            $sql = $sql . " and fecha_reserva = '" . $fecha . "'";
        }
        if($usuario != '')
            $sql = $sql." and usuario = '".$usuario."'";

        if($lugar != '')
            $sql = $sql." and reserva.id_lugar = '".$lugar."'";

        if($horario != '')
            $sql = $sql." and reserva.id_horario = '".$horario."'";

        if($cedula != '')
            $sql = $sql." and cedula = '".$cedula."'";

        //AQUI PONES LOS DEMAS WHERE'S ASI COMO ESTAN LOS DE ARRIBA Y AUMENTAS EN LA FUNCION DE ABAJO TAMBIEN



        $sql = $sql." )IT
                                        where IT.row > ".$start." and IT.row <= ".$cantidadConsulta;
        $query = $this->reservas->query($sql);
        return $query->result_array();
    }

    public function buscarTotal($fecha, $usuario, $lugar, $horario, $cedula)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $this->reservas->select('reserva.id, usuario, cedula, nombre, id_horario, reserva.id_lugar, asistencia, fecha_reserva, lugar.descripcion lugar');
        $this->reservas->select('LEFT(horario.hora_inicio,5) hora_inicio',false);
        $this->reservas->select('LEFT(horario.hora_fin,5) hora_fin',false);
        $this->reservas->from('reserva');
        $this->reservas->join('horario', 'reserva.id_horario = horario.id', 'inner');
        $this->reservas->join('lugar', 'reserva.id_lugar = lugar.id', 'inner');
        if($fecha != '')
            $this->reservas->where('fecha_reserva', $fecha);
        if($usuario != '')
            $this->reservas->where('usuario', $usuario);
        if($lugar != '')
            $this->reservas->where('reserva.id_lugar', $lugar);

        if($horario != '')
            $this->reservas->where('reserva.id_horario', $horario);
        if($cedula!= '')
            $this->reservas->where('cedula', $cedula);

        $query = $this->reservas->get();
        return $query->num_rows();
    }

    public function update($id, $data)
    {
        $this->reservas = $this->load->database('reservas', TRUE);

        $this->reservas->where('id', $id);
        $resp = $this->reservas->update('reserva', $data);

        if($resp)
        {
            $msn = 'Se actualizó el registro '.$id;
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
        $resp = $this->reservas->delete('reserva');
        if($resp)
        {
            $msn = 'Se eliminó el registro '.$id;
            $this->log($msn);
            return 'TRUE';
        }
        else
        {
            return 'FALSE';
        }
    }

    public function create($lugar, $horario, $fecha)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $usuario = $this->session->session_usuario_apps;
        $nombre = $this->session->session_nombre_apps;
        $cedula = $this->session->session_cedula_apps;
        $resp = $this->reservas->query("insert into reserva (usuario, id_lugar, id_horario, fecha_reserva, nombre, cedula) values('$usuario',$lugar,$horario,'$fecha','$nombre','$cedula')");
        $last_id = $this->reservas->query("select IDENT_CURRENT('reserva') as id;")->result_array();
        $last_id = $last_id[0]['id'];
        if($resp)
        {
            $msn = 'Se creó la reserva '.$last_id;
            $this->log($msn);
            return $last_id;
        }
        else
        {
            return 'FALSE';
        }
    }

    public function crear($lugar, $horario, $fecha, $usuario, $nombre, $cedula)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $resp = $this->reservas->query("insert into reserva (usuario, id_lugar, id_horario, fecha_reserva, nombre, cedula) values('$usuario',$lugar,$horario,'$fecha','$nombre','$cedula')");
        $last_id = $this->reservas->query("select IDENT_CURRENT('reserva') as id;")->result_array();
        $last_id = $last_id[0]['id'];
        if($resp)
        {
            $msn = 'Se creó la reserva '.$last_id;
            $this->log($msn);
            return $last_id;
        }
        else
        {
            return 'FALSE';
        }
    }

    public function verificar_aforo($lugar, $horario, $fecha)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $this->reservas->where('id', $lugar);
        $aforo = $this->reservas->get('lugar')->result_array();
        $aforo = $aforo[0]['aforo'];
        $reservas = $this->reservas->query("SELECT *
                                              FROM [RESERVAS_PUCE].[dbo].[reserva]
                                              where id_horario = $horario
                                              and id_lugar = $lugar
                                              and fecha_reserva = '$fecha';")->num_rows();


        if($aforo > $reservas)
        {
            return 'TRUE';
        }
        else
        {
            return 'FALSE';
        }
    }

    public function verificar_reserva($fecha)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $usuario = $this->session->session_usuario_apps;
        $this->reservas->where('usuario',$usuario);
        $this->reservas->where('fecha_reserva', $fecha);
        $resp = $this->reservas->get('reserva')->num_rows();
        if($resp == 0)
        {
            return 'TRUE';
        }
        else
        {
            return 'FALSE';
        }
    }

    public function verificacion_reserva($fecha, $usuario)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $this->reservas->where('usuario',$usuario);
        $this->reservas->where('fecha_reserva', $fecha);
        $resp = $this->reservas->get('reserva')->num_rows();
        if($resp == 0)
        {
            return 'TRUE';
        }
        else
        {
            return 'FALSE';
        }
    }

    public function correo($from, $bcc, $mensaje, $subject)//envia el correo
    {
        $this->email->from($from);
        $this->email->bcc($bcc);
        $this->email->subject($subject);
        $this->email->set_mailtype("html");
        $this->email->message($mensaje);
        $envio = $this->email->send();
        if ($envio)
            return true;
        else
            return false;
    }

    public function getReserva($reserva)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $query = $this->reservas->query("SELECT descripcion, left(horario.hora_inicio,5) hora_inicio, left(horario.hora_fin,5) hora_fin, fecha_reserva
                                          FROM [RESERVAS_PUCE].[dbo].[reserva]
                                          inner join lugar on lugar.id = reserva.id_lugar
                                          inner join horario on horario.id = reserva.id_horario
                                          where reserva.id = $reserva;");
        return $query->result_array();
    }

    public function log($mensaje)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $usuario = $this->session->session_usuario_apps;
        $this->reservas->query("insert into log
                                              (descripcion, tabla, usuario)
                                              values ('$mensaje', 'reserva', '$usuario');");
    }
}