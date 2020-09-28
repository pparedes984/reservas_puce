<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuariorol_model extends CI_Model {

    public function getRol($usuario)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $this->reservas->select('id_rol');
        $this->reservas->where('usuario',$usuario);
        $query = $this->reservas->get('usuario_x_rol')->result_array();
        return $query;
    }

    public function get($usuario)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $query = $this->reservas->get('rol')->result_array();
        $usuariorol = $this->reservas->query("select id_rol from usuario_x_rol where usuario = '$usuario';")->result_array();
        for($i =0; $i<count($query); $i++) {
            $query[$i]['activo'] = 0;
        }
        for($i = 0; $i<count($query); $i++){
            for($j = 0; $j<count($usuariorol); $j++){
                if($query[$i]['id']==$usuariorol[$j]['id_rol']) {
                    $query[$i]['activo'] = 1;
                    break;
                }
            }
        }
        return $query;
    }

    public function update($data, $usuario)
    {
        $this->reservas = $this->load->database('reservas', TRUE);
        $id = $data['id'];
        if($data['activo']==0)
        {
            $query = $this->reservas->query("delete from usuario_x_rol
                                    where usuario = '$usuario' and id_rol = $id;");
        }
        else{
            $query = $this->reservas->query("insert into usuario_x_rol (usuario, id_rol)
                                                  values('$usuario', $id);");
        }
        if($query)
        {
            $msn = 'Se modificó los roles del usuario '.$usuario;
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
                                              values ('$mensaje', 'usuario_x_rol', '$usuario');");
    }
}