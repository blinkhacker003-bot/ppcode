<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Sao_Paulo');

class Agents extends CI_Controller {

    public function index(){
        $this->base->checkSession();

        $data['notifications'] = $this->notifications->getAll();
        $data['title'] = 'Agentes';

        $this->db->where('parentId', $this->session->userdata('agent')->id);
        $data['myAgents'] = $this->db->get('agents')->result();

        $this->load->view('layout/header',$data);
		$this->load->view('pages/agents',$data);
		$this->load->view('layout/footer');
    }
    public function view($agent){
        $this->base->checkSession();

        $this->db->where('id', $agent);
        $this->db->where('parentId', $this->session->userdata('agent')->id);
        $myAgent = $this->db->get('agents')->row();

        if(!$myAgent){
            $this->session->set_flashdata('error', 'Agente não encontrado!');
            redirect('agents');
        }

        $data['notifications'] = $this->notifications->getAll();
        $data['title'] = 'Editar agente';

        $this->db->where('id', $agent);
        $data['agent'] = $this->db->get('agents')->row();

        $this->load->view('layout/header',$data);
		$this->load->view('pages/agent-view',$data);
		$this->load->view('layout/footer'); 
    }
    public function new(){
        $agentCode = $this->input->post('agentCode');
        $email = $this->input->post('email');

        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');
        $this->form_validation->set_rules('agentCode', 'Código do Agente', 'required');
        $this->form_validation->set_rules('password', 'Senha', 'required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', 'Erro porfavor preencher os campos corretamente');
            redirect('agents'); 
            return;
        }
    
        if ($this->base->isAgentCodeExists($agentCode)) {
                $this->session->set_flashdata('error', 'Código de agente já existe');
                redirect('agents'); 
            return;
        }

        if ($this->base->isEmailExists($email)) {
                $this->session->set_flashdata('error', 'E-mail já está em uso');
                redirect('agents'); 
            return; 
        }

        $data = array(
            'email' => $email,
            'agentCode' => $agentCode ,
            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            'token' => md5($agentCode.$this->input->post('password').date('YmdHis')),
            'secretKey' => md5($agentCode.$this->input->post('password').date('YmdHis').rand(0, 1000)),
            'agentName' => $this->input->post('agentCode'),
            'agentType' => 2,
            'percent' => 22,
            'balance' => 0,
            'depth' => 1, 
            'parentId' => $this->session->userdata('agent')->id,
            'currency' => 'BRL',
            'lang' => 'pt',
            'createdAt' => date('Y-m-d H:i:s')
        );
        if ($this->base->register($data)) {
            $this->session->set_flashdata('success', 'Agente cadastrado com sucesso');
            redirect('agents'); 
        } else {
            $this->session->set_flashdata('error', 'Erro ao cadastrar agente');
            redirect('agents'); 
        }

    }
    public function update($id){
        $this->base->checkSession();

        $this->db->where('id', $id);
        $this->db->where('parentId', $this->session->userdata('agent')->id);
        $myAgent = $this->db->get('agents')->row();

        if(!$myAgent){
            $this->session->set_flashdata('error', 'Agente não encontrado!');
            redirect('agents');
        }
    
        $data = $this->input->post();
        if(!empty($data['password'])){
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            unset($data['password']);
        }
    
        $this->db->where('id', $id);
        $this->db->update('agents', $data);
    
        $this->session->set_flashdata('success', 'Configurações atualizadas com sucesso!');
        $referer = $this->input->server('HTTP_REFERER');
        if($referer){
            redirect($referer);
        } else {
            redirect('agents'); 
        }
    }
    public function delete($agent){
        $this->base->checkSession();

        $this->db->where('id', $agent);
        $this->db->where('parentId', $this->session->userdata('agent')->id);
        $myAgent = $this->db->get('agents')->row();

        if(!$myAgent){
            $this->session->set_flashdata('error', 'Agente não encontrado!');
            redirect('agents');
        }

        $this->db->where('id', $agent);
        $this->db->update('agents', ['status' => 3]);

        $this->session->set_flashdata('success', 'Agente deletado com sucesso!');
        redirect('agents');
    }
    public function addSaldo($agent){
        $this->base->checkSession();

        $this->db->where('id', $agent);
        $this->db->where('parentId', $this->session->userdata('agent')->id);
        $myAgent = $this->db->get('agents')->row();

        if(!$myAgent){
            $this->session->set_flashdata('error', 'Agente não encontrado!');
            redirect('agents');
        }

        $this->db->where('id', $this->session->userdata('agent')->id);
        $me = $this->db->get('agents')->row();

        if($me->balance < 0){
            $this->session->set_flashdata('error', 'Saldo insuficiente!');
            redirect('agents/view/'.$agent);
        }

        $data = $this->input->post();

        if($data['newbalance'] <= 0){
            $this->session->set_flashdata('error', 'Valor inválido!');
            redirect('agents/view/'.$agent);
        }

        if($me->balance <= $data['newbalance']){
            $this->session->set_flashdata('error', 'Saldo insuficiente!');
            redirect('agents/view/'.$agent);
        }
        
        $this->db->where('id', $agent);
        $this->db->update('agents', ['balance' => $myAgent->balance + $data['newbalance']]);

        $this->db->insert('agent_balance_progresses', [
            'agentCode' =>  $myAgent->agentCode,
            'agentBalance' => $me->balance,
            'comment' => '[Agent Deposit] ('.$me->agentCode.'):'.$data['newbalance'],
            'parentPath' => $myAgent->parentPath,
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s')
        ]);

        $this->db->where('id', $this->session->userdata('agent')->id);
        $this->db->update('agents', ['balance' => $me->balance - $data['newbalance']]);

        $this->session->set_flashdata('success', 'Saldo adicionado com sucesso!');
        redirect('agents/view/'.$agent);
    }
}