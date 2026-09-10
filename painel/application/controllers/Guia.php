<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guia extends CI_Controller {

    public function index(){
        $this->base->checkSession();

        $data['notifications'] = $this->notifications->getAll();
        $data['title'] = 'Guia da API';

        $this->db->where('id', $this->session->userdata('agent')->id);
        $data['myData'] = $this->db->get('agents')->row();

        $this->load->view('layout/header',$data);
        $this->load->view('pages/guia',$data);
        $this->load->view('layout/footer');
    }
}