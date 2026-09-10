<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    
    public function recharge(){
        $this->base->checkSession();
        
        $data['notifications'] = $this->notifications->getAll();
        $data['title'] = 'Lista de Recargas';
        $data['recharge'] = $this->db->order_by('id', 'DESC')->get('agent_recharge')->result();
        
        $this->load->view('layout/header',$data);
		$this->load->view('admin/recharge',$data);
		$this->load->view('layout/footer');
    }
    public function access(){
        $this->base->checkSession();
        
        $data['notifications'] = $this->notifications->getAll();
        $data['title'] = 'Lista de Acessos';
        $data['access'] = $this->db->order_by('id', 'DESC')->get('agent_login_histories')->result();

        
        $this->load->view('layout/header',$data);
		$this->load->view('admin/access',$data);
		$this->load->view('layout/footer');
    }
    public function agents(){
        $this->base->checkSession();
        
        $data['notifications'] = $this->notifications->getAll();
        $data['title'] = 'Lista de Agentes';
        $data['agents'] = $this->db->get('agents')->result();
        
        $this->load->view('layout/header',$data);
		$this->load->view('admin/agents',$data);
		$this->load->view('layout/footer');
    }

}