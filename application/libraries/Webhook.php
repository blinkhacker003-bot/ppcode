<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Webhook {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    private function enviarRequest($url, $config) {
        $ch = curl_init();

        $headerArray = ['Content-Type: application/json'];

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $config);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        log_message('DEBUG', 'Webhook exec Request Response: ' . $response);
        return $response;
    }
    public function getBalance($agent, $user_code){

        $query['agent'] = $this->CI->db->get_where('agents', array('agentCode' => $agent))->row();
        $query['user'] = $this->CI->db->get_where('users', array('userCode' => $user_code, 'agentCode' => $agent))->row();

        $url = $query['agent']->siteEndPoint;

        $agent = $query['agent']->agentCode;

        $data = array(
            'method' => 'user_balance',
            'agent_code' =>  $agent,
            'agent_secret' =>  $query['agent']->secretKey,
            'user_code' => $user_code
        );

        $json_data = json_encode($data);
        $response = $this->enviarRequest($url, $json_data);
        log_message('debug', '[Webhook] Saldo: '. $response);
        
        $dados = json_decode($response, true);
       
        if (isset($dados['user_balance'])) {
            $updateData = array(
                'balance' => $dados['user_balance']
            );

            if($query['agent']->balance <= $dados['user_balance']){
                return $dados['user_balance'];
            }else{
                $user_id = isset($query['user']->id) ? $query['user']->id : null;
                $this->CI->db->where('id', $user_id)->update('users', $updateData);
            }
            return $dados['user_balance'];
        }
    }

    public function transaction($agent, $user_code, $transData){

        $query['agent'] = $this->CI->db->get_where('agents', array('agentCode' => $agent))->row();
        $query['user'] = $this->CI->db->get_where('users', array('userCode' => $user_code, 'agentCode' => $agent))->row();

        $url = $query['agent']->siteEndPoint;

        $this->ajustBalanceAgent($agent, $transData['bet_money']);

        $data = array(
            'method' => 'transaction',
            'agent_code' =>  $query['agent']->agentCode,
            'agent_secret' =>  $query['agent']->secretKey,
            'agent_balance'=> $query['agent']->balance,
            'user_code' => $user_code,
            'user_balance' => $query['user']->balance,
            'game_type' => 'slot',
            'slot' => $transData
        );

        $json_data = json_encode($data);

        $response = $this->enviarRequest($url, $json_data);
        log_message('debug', '[Webhook] Resposta transação: '. $response);

        $dados = json_decode($response, true);
       
        if (isset($dados['user_balance'])) {
            $updateData = array(
                'balance' => $dados['user_balance']
            );
            return $dados['user_balance'];
        }
    }

    private function havecredit($user_code){
        $query = $this->CI->db->get_where('users', array('userCode' => $user_code))->row();
        if ($query->balance > 0) {
            return $query->balance;
        } else {
            return FALSE;
        }
    }

    private function ajustBalanceAgent($agent, $balance) {
        $this->CI->db->where('agentCode', $agent);
        $query = $this->CI->db->get('agents')->result();

        $newBalance = ($query[0]->balance - $balance);
        $data = array('balance' => $newBalance);
        $this->CI->db->where('agentCode', $agent)->update('agents', $data);
        return $newBalance;
    }

    private function addBalanceAgent($agent, $balance) {
        $this->CI->db->where('agentCode', $agent);
        $query = $this->CI->db->get('agents')->result();

        $newBalance = ($query[0]->balance + $balance);
        $data = array('balance' => $newBalance);
        $this->CI->db->where('agentCode', $agent)->update('agents', $data);
        return $newBalance;
    }
}
