<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reserva extends MX_Controller {

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

            $this->load->model('Reserva_model', 'Model');
        }
    }

    public function create()
    {
        if ($this->input->post('bandera') == 1)
        {
            $result = $this->Model->crear($this->input->post('lugar'),$this->input->post('horario'),$this->input->post('fecha'), $this->input->post('usuario'), $this->input->post('nombre'), $this->input->post('cedula'));
        }
        else{
            $result = $this->Model->create($this->input->post('lugar'),$this->input->post('horario'),$this->input->post('fecha'));
        }


        if($result)
        {
            $r = array("data"    => $result,
                "success" => "true");
        }
        else
        {
            $r = array("failure" => "true");
        }
        echo json_encode($r);
    }

    public function get()
    {
        $start = $this->input->post('start');
        $limit = $this->input->post('limit');
        if ($this->input->post('bandera') == 1) {
            $result = $this->Model->buscar($this->input->post('fecha'), $this->input->post('usuario'), $this->input->post('lugar'), $this->input->post('horario'), $this->input->post('cedula'), $start,$limit);
            $cantidad = $this->Model->buscarTotal($this->input->post('fecha'), $this->input->post('usuario'), $this->input->post('lugar'), $this->input->post('horario'), $this->input->post('cedula'), $start,$limit);
        }
        else {
            $result = $this->Model->get($start,$limit);
            $cantidad = $this->Model->getTotal();
        }
        $r = array("data"    => $result,
            "cantidad" => $cantidad,
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

    public function verificar_aforo()
    {
        $result = $this->Model->verificar_aforo($this->input->post('lugar'),$this->input->post('horario'),$this->input->post('fecha'));
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

    public function verificar_reserva()
    {
        if ($this->input->post('bandera') == 1)
            $result = $this->Model->verificacion_reserva($this->input->post('fecha'), $this->input->post('usuario'));
        else
            $result = $this->Model->verificar_reserva($this->input->post('fecha'));
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

    public function correo()//genera el correo
    {
        $username = $this->input->post('usuario');
        $reserva = $this->Model->getReserva($this->input->post('reserva'));
        $bcc = $username.'@puce.edu.ec;';

        $data['descripcion'] = $reserva[0]['descripcion'];
        $data['hora_inicio'] = $reserva[0]['hora_inicio'];
        $data['hora_fin'] = $reserva[0]['hora_fin'];
        $data['fecha'] = $reserva[0]['fecha_reserva'];
        $mensaje = $this->load->view('correo_view', $data, TRUE);

        $result['mensaje institucional'] = $this->Model->correo('RESERVAS_PUCE@puce.edu.ec',$bcc, $mensaje, 'Reserva');

        if($result['mensaje institucional']==true){
            $r = array("data"    => $result,
                "success" => true);
        }else{
            $r = array("data"    => $result,
                "success" => false);
        }
        echo json_encode($r);
    }
}