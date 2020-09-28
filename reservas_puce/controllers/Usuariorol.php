<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuariorol extends MX_Controller {

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

            $this->load->model('Usuariorol_model', 'Model');
        }
    }

    public function get()
    {
        $result = $this->Model->get($this->input->post('usuario'));
        $r = array("data"    => $result,
            "success" => "true");
        echo json_encode($r);
    }

    public function update()
    {
        $data = json_decode($this->input->post('data'), TRUE);
        $result = $this->Model->update($data,$this->input->post('usuario') );
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