<?php 

class User_model extends CI_Model {

    public function get($user_code, $agent) {
        $this->db->from('users');
        $this->db->where('agentCode', $agent);
        $this->db->where('userCode', $user_code);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getUserAndAgType($user_code, $agent) {
        $this->db->from('users');
        $this->db->where('apiType', 1);
        $this->db->where('agentCode', $agent);
        $this->db->where('userCode', $user_code);
        $query = $this->db->get()->result_array();
        return $query;
    }


    public function getByID($user_code, $agent) {
        $this->db->from('users');
        $this->db->where('agentCode', $agent);
        $this->db->where('userCode', $user_code);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getReturnID($user_code, $agent) {
        $this->db->select('id');
        $this->db->from('users');
        $this->db->where('agentCode', $agent);
        $this->db->where('userCode', $user_code);
        $query = $this->db->get()->row(); // Use row() para obter apenas uma linha como objeto
        return $query->id; // Acesse diretamente o ID
    }

    public function getByInternalID($user) {
        $this->db->where('aasUserCode', $user);
        $query = $this->db->get('users')->result();
        return $query;
    }

    public function createExt($id) {
        $this->spinshield->createUser($id);
        //$this->fiverscan->createUser($id);
        return true;
    }
    
    public function create($insertData) {
        $this->db->insert('users', $insertData);
        $id = $this->db->insert_id();
        return $id;
    }

    public function getAllUserAndBalance($code){

        $this->db->where('agentCode',$code);
        $this->db->select('userCode as user_code, balance');
        $this->db->from('users');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getAllUser($code){

        $this->db->where('agentCode',$code);
        $this->db->select('userCode as user_code, status, totalDebit, totalCredit, balance');
        $this->db->from('users');
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function getBalance($user_code, $agent) {

        $this->db->where('agentCode', $agent);
        $this->db->where('userCode', $user_code);
        $user = $this->db->get('users')->result();

        $this->db->where('aasUserCode', $user[0]->aasUserCode);
        $curbalance = $this->db->get('users')->result();
        return $curbalance[0]->balance;
    }


    public function updateBalance($user_code, $new_balance) {
        $this->db->where('aasUserCode', $user_code);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            $data = array('balance' => $new_balance);
            $this->db->where('aasUserCode', $user_code);
            $this->db->update('users', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }
}