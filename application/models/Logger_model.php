<?php 

class Logger_model extends CI_Model {

    public function create($agent,$method,$head,$data) {
        date_default_timezone_set('America/Sao_Paulo');
    
        $data = array(
            'server' => $this->input->ip_address(),
            'method' => $method,
            'header' => $head,
            'payload' => $data,
            'create_at' => date('Y-m-d H:i:s'),
            'agentCode' => $agent
        );
    
        $resultado = $this->db->insert('call_log', $data);
    }    
}