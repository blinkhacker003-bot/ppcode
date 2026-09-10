<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Games extends CI_Controller {
    
        public function index(){
            $this->base->checkSession();
            $data['notifications'] = $this->notifications->getAll();
            $data['title'] = 'Jogos';

            $data['game'] = $this->db->get('games')->result();
            $this->load->view('layout/header',$data);
            $this->load->view('pages/games',$data);
            $this->load->view('layout/footer');
        }
    }