<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Sao_Paulo');

class Support extends CI_Controller {

    
    public function index(){
        $this->base->checkSession();

        $data['notifications'] = $this->notifications->getAll();
        $data['title'] = 'Suporte';

        $this->db->where('id', $this->session->userdata('agent')->id);
        $data['myData'] = $this->db->get('agents')->row();

        $this->load->view('layout/header',$data);
        $this->load->view('pages/support',$data);
        $this->load->view('layout/footer');
    }
}