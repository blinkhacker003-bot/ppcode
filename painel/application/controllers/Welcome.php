<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Sao_Paulo');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->login();
	}
	public function login()
	{
		$this->load->view('pages/login');
	}
	public function register()
	{
		$this->load->view('pages/register');
	}

	public function auth($action){

		switch($action){
			case 'login':
				$agentCode = $this->input->post('agentCode');
				$password = $this->input->post('inputPassword');
				$this->load->model('Base_model');
				$agent = $this->base->login($agentCode, $password);
				if ($agent) {
					$this->session->set_userdata('agent', $agent);
					$this->session->set_userdata('logged', true);
					redirect('dashboard');
				} else {
					$this->session->set_flashdata('error', 'Credenciais inválidas');
					redirect('welcome/login');
				}
				break;
			case 'register':
				$agentCode = $this->input->post('agentCode');
				$email = $this->input->post('email');

				$this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');
				$this->form_validation->set_rules('agentCode', 'Código do Agente', 'required');
				$this->form_validation->set_rules('password', 'Senha', 'required');
	
				if ($this->form_validation->run() == false) {
					$this->session->set_flashdata('error', 'Erro porfavor preencher os campos corretamente');
					redirect('welcome/register');
					return;
				}
            
				if ($this->base->isAgentCodeExists($agentCode)) {
						$this->session->set_flashdata('error', 'Código de agente já existe');
						redirect('welcome/register');
					return;
				}

				if ($this->base->isEmailExists($email)) {
						$this->session->set_flashdata('error', 'E-mail já está em uso');
						redirect('welcome/register');
					return; 
				}

				$data = array(
					'email' => $email,
					'agentCode' => $agentCode ,
					'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                    'token' => md5($agentCode.$this->input->post('password').date('YmdHis')),
                    'secretKey' => $this->engine->uuid(),
                    'agentName' => $this->input->post('agentCode'),
                    'agentType' => 2,
                    'percent' => 20,
                    'balance' => 50,
                    'depth' => 1, 
                    'parentId' => 1,
                    'currency' => 'BRL',
                    'lang' => 'pt',
					'rtp' => '96',
					'memo' => 'Cadastrou pelo site no dia '.date('d/m/Y'),
					'createdAt' => date('Y-m-d H:i:s')
                );
				if ($this->base->register($data)) {
					$this->session->set_flashdata('success', 'Agente cadastrado com sucesso');
					redirect('welcome/login');
				} else {
					$this->session->set_flashdata('error', 'Erro ao cadastrar agente');
					redirect('welcome/register');
				}
				break;
		}
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('');
  }
}
