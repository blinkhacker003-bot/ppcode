<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends CI_Controller {

    public function index(){
        $this->base->checkSession();
        
        $data['notifications'] = $this->notifications->getAll();
        $data['title'] = 'Central de Notificações';
        $data['popup'] = $this->db->get('popups')->result();
        
        $this->load->view('layout/header',$data);
		$this->load->view('pages/notifications',$data);
		$this->load->view('layout/footer');
    }
}