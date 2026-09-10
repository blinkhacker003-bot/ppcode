<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Sao_Paulo');
class Base_model extends CI_Model {

    public function login($agentCode, $password) {
        $sql = "SELECT * FROM agents WHERE agentCode = ? LIMIT 1";
        $query = $this->db->query($sql, array($agentCode));      

        if ($query->num_rows() == 1) {
            $agent = $query->row();
            $this->logSession($agentCode);
            if (password_verify($password, $agent->password)) {
                return $agent;
            }
        }
        return false;
    }

    public function isAgentCodeExists($agentCode) {
        $this->db->where('agentCode', $agentCode);
        $query = $this->db->get('agents');
        return $query->num_rows() > 0;
    }
    
    public function isEmailExists($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('agents');
        return $query->num_rows() > 0;
    }

    public function register($data) {
        return $this->db->insert('agents', $data);
    }

    public function checkSession()
	{
		if($this->session->userdata('logged') == false){
            $this->session->set_flashdata('error', 'Você precisa estar logado!');
			redirect ('');
		}	  
	}

    public function logSession($agent_code){
         $ip = $this->input->ip_address();
         $query['agent'] = $this->db->get_where('agents', array('agentCode' => $agent_code))->row();
         $ipInfo = $this->get_ip_info($ip);
         $data = array(
             'agentCode' => $query['agent']->agentCode,
             'agentName' =>  $query['agent']->agentName,
             'ip' => $ip,
             'country' => isset($ipInfo['country']) ? $ipInfo['country'] : '',
             'region' => isset($ipInfo['region']) ? $ipInfo['region'] : '',
             'city' => isset($ipInfo['city']) ? $ipInfo['city'] : '',
             'loc' => isset($ipInfo['loc']) ? $ipInfo['loc'] : '',
             'org' => isset($ipInfo['org']) ? $ipInfo['org'] : '',
             'postal' => isset($ipInfo['postal']) ? $ipInfo['postal'] : '',
             'createdAt' => date('Y-m-d H:i:s'),
             'updatedAt' => date('Y-m-d H:i:s')
         );

         $this->db->insert('agent_login_histories', $data);
         return $this->db->insert_id();

    }

    private function get_ip_info($ip) {
        $url = "https://ipinfo.io/$ip/json";
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpcode == 200) {
            $ipInfo = json_decode($response, true);
        } else {
            $ipInfo = array();
        }

        curl_close($ch);
        return $ipInfo;
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
}
