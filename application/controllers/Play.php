<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Play extends CI_Controller {

    public function index()
    {
        $data = $this->input->get();
        $this->load->view('game', $data);
    }
}
