<?php 

class Agent_model extends CI_Model {

    
    
    public function check($code, $token) {
        $this->db->where('agentCode', $code);
        $this->db->where('token', $token);
        $this->db->where('status', 1);
        $query = $this->db->get('agents');
    
        if ($query) {
            if ($query->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function checkZero($code, $token) {
        $this->db->where('agentCode', $code);
        $this->db->where('token', $token);
        $this->db->where('status', 1);
        $query = $this->db->get('agents');
    
        if ($query && $query->num_rows() > 0) {
            $agent = $query->row(); // Obtém a primeira linha do resultado da consulta
            if ($agent->balance <= 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function subCheck($code) {
        $this->db->where('agentCode', $code);
        $this->db->where('status', 1);
        $query = $this->db->get('agents');
    
        if ($query) {
            if ($query->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function getId($code, $token) {
        $this->db->select('id'); // Seleciona apenas o campo 'id'
        $this->db->where('agentCode', $code);
        $this->db->where('token', $token);
        $query = $this->db->get('agents');
    
        if ($query) {
            if ($query->num_rows() > 0) {
                return $query->row()->id;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function getType($code, $token) {
        $this->db->select('apiType'); // Seleciona apenas o campo 'id'
        $this->db->where('agentCode', $code);
        $this->db->where('token', $token);
        $query = $this->db->get('agents');
    
        if ($query) {
            if ($query->num_rows() > 0) {
                return $query->row()->apiType;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function get($code) {
        $this->db->from('agents');
        $this->db->where('agentCode', $code);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function ajustBalance($agent, $balance) {
        // Verificar se o usuário existe
        $this->db->where('agentCode', $agent);
        $query = $this->db->get('agents');

        $agents = $query->row(); // Obtém a primeira linha do resultado da consulta
        if ($agents->balance <= $balance) {
            return false;
        } else {
            $newBalance = ($agents->balance - $balance);
            $data = array('balance' => $newBalance);
            $this->db->where('agentCode', $agent);
            $this->db->update('agents', $data);
            return TRUE;
        }
    }

    public function ajustBalanceAdd($agent, $balance) {
        // Verificar se o usuário existe
        $this->db->where('agentCode', $agent);
        $query = $this->db->get('agents')->result();;

        if ($query) {

            $newBalance = ($query[0]->balance + $balance);
            $data = array('balance' => $newBalance);
            $this->db->where('agentCode', $agent);
            $this->db->update('agents', $data);
            return TRUE;
        } else {
            // Usuário não encontrado
            return FALSE;
        }
    }

    public function getBalance($code){
        $this->db->where('agentCode', $code);
        $query = $this->db->get('agents')->result();

        if ($query) {
            return $query[0]->balance;
        } else {
            return false;
        }
    }

    public function getCurrency($code){
        $this->db->where('agentCode', $code);
        $query = $this->db->get('agents')->result();

        if ($query) {
            return $query[0]->currency;
        } else {
            return false;
        }
    }
}