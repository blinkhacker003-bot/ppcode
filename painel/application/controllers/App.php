<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

    public function index()
	{
		$this->load->view('pages/register');
	}
    public function login()
	{
		$this->load->view('pages/login');
	}
	
}