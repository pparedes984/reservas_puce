<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lugar extends MX_Controller {

    public function __construct()
    {

        parent::__construct();

        if(!$this->input->is_ajax_request())
        {
            show_404();
            exit();
        }
        else
        {

            $this->load->model('Lugar_model', 'Model');
        }
    }

    public function create()
    {
        $data = json_decode($this->input->post('data'), TRUE);
        unset($data['id']);
        if($this->input->post('id_lugar') == '')
            $data['id_lugar'] = null;
        else
            $data['id_lugar'] = $this->input->post('id_lugar');
        $data['id_estado'] = 1;
        $result = $this->Model->create($data);

        if($result)
        {
            $r = array("success" => "true");
        }
        else
        {
            $r = array("failure" => "true");
        }
        echo json_encode($r);
    }

    public function verificar()
    {

        $result = $this->Model->verificar($this->input->post('descripcion'));
        if($result<>'FALSE')
        {
            $r = array("success" => "true");
        }
        else
        {
            $r = array("failure" => "true");
        }
        echo json_encode($r);
    }

    public function verificar_ingreso()
    {

        $result = $this->Model->verificar_ingreso($this->input->post('id_lugar'));
        if($result<>'FALSE')
        {
            $r = array("success" => "true");
        }
        else
        {
            $r = array("failure" => "true");
        }
        echo json_encode($r);
    }

    public function verificar_regreso()
    {

        $result = $this->Model->verificar_regreso($this->input->post('id_lugar'));
        if($result<>'FALSE')
        {
            $r = array("success" => "true");
        }
        else
        {
            $r = array("failure" => "true");
        }
        echo json_encode($r);
    }

    public function get()
    {
        if($this->input->post('busqueda') == 1)
            $result = $this->Model->getHorario();
        elseif($this->input->post('busqueda') == 2)
            $result = $this->Model->getHorarioFaltantes();
        elseif($this->input->post('busqueda') == 3)
            $result = $this->Model->getReserva($this->input->post('id_lugar'));
        elseif($this->input->post('busqueda') == 4)
            $result = $this->Model->getReservaRegreso($this->input->post('id_lugar'));
        else
            $result = $this->Model->get();
        $r = array("data"    => $result,
            "success" => "true");
        echo json_encode($r);

    }

    public function delete()
    {
        $result = $this->Model->delete($this->input->post('id'));
        if($result <> 'FALSE')
        {
            $r = array("success" => "true");
        }
        else
        {
            $r = array("failure" => "true");
        }
        echo json_encode($r);
    }

    public function deleteHorario()
    {
        $result = $this->Model->deleteHorario($this->input->post('id'));
        if($result <> 'FALSE')
        {
            $r = array("success" => "true");
        }
        else
        {
            $r = array("success" => "false");
        }
        echo json_encode($r);
    }

    public function update()
    {
        $data = json_decode($this->input->post('data'), TRUE);
        unset($data['id']);
        $result = $this->Model->update($this->input->post('id'),$data);

        if($result)
        {
            $r = array("success" => "true");
        }
        else
        {
            $r = array("failure" => "true");
        }
        echo json_encode($r);
    }

    public function updateHorario()
    {
        $result = $this->Model->updateHorario($this->input->post('id'),$this->input->post('hora_inicio'),$this->input->post('hora_fin'),$this->input->post('intervalo'));

        if($result)
        {
            $r = array("success" => "true");
        }
        else
        {
            $r = array("failure" => "true");
        }
        echo json_encode($r);
    }
}