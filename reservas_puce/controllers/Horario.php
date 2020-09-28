<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Horario extends MX_Controller {

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

            $this->load->model('Horario_model', 'Model');
        }
    }

    public function create()
    {
        $result = $this->Model->create($this->input->post('id'));

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

    public function get()
    {
        if($this->input->post('busqueda') == 1)
            $result = $this->Model->obtener($this->input->post('id'));


        else
            $result = $this->Model->get($this->input->post('id'), $this->input->post('fecha'));

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
            $r = array("success" => "false");
        }
        echo json_encode($r);
    }

    public function update()
    {
        $data = json_decode($this->input->post('data'), TRUE);

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

    public function verificar()
    {
        $result = $this->Model->verificar();
        if($result <> 'FALSE')
        {
            $result = $this->Model->create($result);
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
        else
        {
            $r = array("success" => "false");
        }
        echo json_encode($r);
    }
}