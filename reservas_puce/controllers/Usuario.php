<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends MX_Controller {

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

            $this->load->model('Usuario_model', 'Model');
        }
    }

    public function create()
    {
        $data = json_decode($this->input->post('data'), TRUE);
        unset($data['id']);
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

    public function get()
    {
        $result = $this->Model->get();
        $r = array("data"    => $result,
            "success" => "true");
        echo json_encode($r);

    }

    public function delete()
    {
        $result = $this->Model->delete($this->input->post('usuario'));
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
        $result = $this->Model->update($this->input->post('usuario'),$data);
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