<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Controller {

    public function index(){
        $this->base->checkSession();

        $data['notifications'] = $this->notifications->getAll();
        $data['title'] = 'Configuração do perfil';

        $this->db->where('id', $this->session->userdata('agent')->id);
        $data['myData'] = $this->db->get('agents')->row();

        $this->load->view('layout/header',$data);
        $this->load->view('pages/config',$data);
        $this->load->view('layout/footer');
    }
    public function api(){
        $this->base->checkSession();

        $data['notifications'] = $this->notifications->getAll();
        $data['title'] = 'Configuração API';

        $this->db->where('id', $this->session->userdata('agent')->id);
        $data['myData'] = $this->db->get('agents')->row();

        $this->load->view('layout/header',$data);
        $this->load->view('pages/config-api',$data);
        $this->load->view('layout/footer');
    }
    public function update(){
        $this->base->checkSession();
    
        $data = $this->input->post();

        if(!empty($data['balance'])){
            $this->session->set_flashdata('error', 'O campo balance não pode ser atualizado');
            redirect('config'); 
        }

        if(!empty($data['password'])){
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            unset($data['password']);
        }
    
        $this->db->where('id', $this->session->userdata('agent')->id);
        $this->db->update('agents', $data);
    
        $this->session->set_flashdata('success', 'Configurações atualizadas com sucesso!');
        $referer = $this->input->server('HTTP_REFERER');
        if($referer){
            redirect($referer);
        } else {
            redirect('config'); 
        }
    }
}
