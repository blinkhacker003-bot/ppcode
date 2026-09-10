<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function index(){
        $this->base->checkSession();

        $data['notifications'] = $this->notifications->getAll();
        $data['title'] = 'Users';

        $this->db->where('agentCode', $this->session->userdata('agent')->agentCode);
        $data['myUsers'] = $this->db->get('users')->result();

        $this->load->view('layout/header',$data);
		$this->load->view('pages/users',$data);
		$this->load->view('layout/footer');
    }
}