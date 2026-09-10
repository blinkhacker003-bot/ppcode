<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function index(){
        $this->base->checkSession();

        $data['notifications'] = $this->notifications->getAll();
        $data['title'] = 'Dashboard';

        $this->db->where('agentCode', $this->session->userdata('agent')->agentCode);
        $data['allUsers'] = $this->db->get('users')->num_rows();

        $this->db->where('parentId', $this->session->userdata('agent')->id);
        $data['allAgents'] = $this->db->get('agents')->num_rows();
        
        $this->db->select('SUM(totalDebit) as debit, SUM(totalCredit) as credit');
        $this->db->where('agentCode', $this->session->userdata('agent')->agentCode);
        $query = $this->db->get('users');
        
        if ($query->num_rows() > 0) {
            $data['winloss'] = $query->row();
        } else {
            $data['winloss'] = (object) ['debit' => 0, 'credit' => 0];
        }

        $this->db->where('id', $this->session->userdata('agent')->id);
        $data['myData'] = $this->db->get('agents')->row();

        $this->load->view('layout/header',$data);
		$this->load->view('pages/dashboard',$data);
		$this->load->view('layout/footer');
    }
}