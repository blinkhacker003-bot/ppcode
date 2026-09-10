<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Api extends REST_Controller {

    public function index_get(){
        $this->response(['status' => 0, 'msg' => 'Acesso negado'], 400);
    }

    public function index_post() {

    $input_data = $this->input->raw_input_stream;
    $data = json_decode($input_data, true);
    $headers = json_encode($this->input->request_headers());

        if(empty($data)){
            $this->response(['status' => 0, 'msg' => 'body não preenchido'], 400);
                return;  
        }

        $this->loggy->create($data['agent_code'], $data['method'],$headers,$input_data);
        log_message('DEBUG', 'Input: ' . $input_data);

        if (!isset($data['method'])) {
            $this->response(['status' => 0, 'msg' => 'O campo "method" é obrigatório'], 400);
            return;
        }
        if (!isset($data['agent_code'])) {
            $this->response(['status' => 0, 'msg' => 'O campo "agent_code" é obrigatório'], 400);
            return;
        }
        if (!isset($data['agent_token'])) {
            $this->response(['status' => 0, 'msg' => 'O campo "agent_token" é obrigatório'], 400);
            return; 
        }
    
        $code = $data['agent_code'];
        $token = $data['agent_token'];

        $checkAgent = $this->agent->check($code, $token);

        if($checkAgent != true){
            $this->response(['status' => 0, 'msg' => 'O Agente é inválido'], 400);
            return; 
        }
        $zero = $this->agent->checkZero($code, $token);

        if($zero == true){
            $this->response(['status' => 0, 'msg' => 'O Agente está sem saldo'], 400);
            return; 
        }
        

        switch ($data['method']) {
            case 'user_create':
                $this->user_create($data);
                break;
            case 'user_deposit':
                $this->user_deposit($data);
                break;
            case 'user_withdraw':
                $this->user_withdraw($data);
                break;
            case 'user_withdraw_reset':
                $this->user_withdraw_reset($data);
                break;
            case 'game_launch':
                $this->game_launch($data);
                break;
            case 'money_info':
                $this->money_info($data);
                break;
            case 'provider_list':
                $this->provider_list($data);
                break;
            case 'game_list':
                $this->game_list($data);
                break;
            case 'get_game_log':
                $this->get_game_log($data);
                break;
            case 'user_all':
                $this->user_all($data);
                break;
            case 'subagent_deposit':
                $this->subagent_deposit($data);
                break;
            case 'subagent_withdraw':
                $this->subagent_withdraw($data);
                break;
            case 'subagent_reset':
                $this->subagent_reset($data);
                break;
            default:
                $this->response(['status' => 0, 'msg' => 'Método não suportado'], 400);
                break;
        }
    }
    public function user_create($data) {
        
        date_default_timezone_set('America/Sao_Paulo');
        $code = $data['agent_code'];
        $token = $data['agent_token'];
        $user_code = $data['user_code'];

        $id = $this->agent->getId($code, $token);

        $insertData = array(
            'agentCode' => $code,
            'userCode' => $user_code,
            'aasUserCode' => $code . md5(rand(0, 20000).date('Ymdhhmmss')),
            'createdAt'=> date('Y-m-d H:i:s'),
            'balance' => 0,
            'status' => 1,
            'apiType' => 1
        );

        $user = $this->user->get($user_code, $code);

        if($user != false){
            $this->response(['status' => 0, 'msg' => 'DUPLICATED_USER'], 400);
            return;
        }else{
            if($this->user->create($insertData)){
                $this->response(['status' => 1, 'msg' => 'SUCCESS','user_code' => $user_code, 'user_balance' => 0], 200);
            } else {
                $this->response(['status' => 0, 'msg' => 'INTERNAL_ERROR'], 400);
            }
        }
    }
    public function user_all($data) {
        
        $code = $data['agent_code'];
        $token = $data['agent_token'];

        $allUser = $this->user->getAllUser($code);

        $this->response(['status' => 1, 'msg' => 'SUCCESS', 'user_list' => $allUser], 200);
    }
    public function user_deposit($data) {
        date_default_timezone_set('America/Sao_Paulo');
        $code = $data['agent_code'];
        $token = $data['agent_token'];
        $user_code = $data['user_code'];
        if (!isset($data['amount'])) {
            $this->response(['status' => 0, 'msg' => 'O campo "amount" é obrigatório'], 400);
            return;
        }

        $checkAgent = $this->agent->checkZero($code, $token);

        if($checkAgent == true){
            $this->response(['status' => 0, 'msg' => 'INSUFFICIENT_FUNDS'], 400);
            return; 
        }

        $amount = $data['amount'];
        $id = $this->agent->getId($code, $token);
        $user = $this->user->get($user_code, $code);
        if($user == false){
            $this->response(['status' => 0, 'msg' => 'INVALID_USER'], 400);
            return;
        }
        $balance = $user[0]['balance'] + $amount;
        $agentAjust = $this->agent->ajustBalance($code, $amount);

        if($agentAjust == false){
            $this->response(['status' => 0, 'msg' => 'INSUFFICIENT_FUNDS'], 400);
            return; 
        }

        $updateData = array(
            'balance' => $balance
        );
        $agentBalance = $this->agent->getBalance($code);
        if($this->db->where('id', $user[0]['id'])->update('users', $updateData)){
            $this->response(['status' => 1, 'msg' => 'SUCCESS', 'agent_balance' => $agentBalance, 'user_balance' => strval($balance)], 200);
        } else {
            $this->response(['status' => 0, 'msg' => 'INTERNAL_ERROR'], 400);
        }
    }
    public function user_withdraw($data) {
        
        date_default_timezone_set('America/Sao_Paulo');
        $code = $data['agent_code'];
        $token = $data['agent_token'];
        $user_code = $data['user_code'];

        $agentType = $this->agent->getType($code, $token);
        if($agentType == 0){
            $this->response(['status' => 0, 'msg' => 'INVALID_AGENT_TYPE'], 400);
            return;
        }

        if (!isset($data['amount'])) {
            $this->response(['status' => 0, 'msg' => 'O campo "amount" é obrigatório'], 400);
            return;
        }

        $amount = $data['amount'];
        $id = $this->agent->getId($code, $token);
        $user = $this->user->getUserAndAgType($user_code, $code);

        if($user == false){
            $this->response(['status' => 0, 'msg' => 'INVALID_USER'], 400);
            return;
        }

        $balance = $user[0]['balance'] - $amount;

        if($user[0]['balance'] <= 0){
            $this->response(['status' => 0, 'msg' => 'INSUFFICIENT_FUNDS'], 400);
            return;
        }
        $this->agent->ajustBalanceAdd($code, $amount);
        $updateData = array(
            'balance' => $balance
        );

        $agentBalance = $this->agent->getBalance($code);

        if($this->db->where('id', $user[0]['id'])->update('users', $updateData)){
            $this->response(['status' => 1, 'msg' => 'SUCCESS','agent_balance' => $agentBalance, 'user_balance' =>  strval($balance)], 200);
        } else {
            $this->response(['status' => 0, 'msg' => 'INTERNAL_ERROR'], 400);
        }
    }
    public function user_withdraw_reset($data) {
        
        date_default_timezone_set('America/Sao_Paulo');
        $code = $data['agent_code'];
        $token = $data['agent_token'];
        $user_code = $data['user_code'];

        $id = $this->agent->getId($code, $token);
        $user = $this->user->getUserAndAgType($user_code, $code);

        $agentType = $this->agent->getType($code, $token);
        if($agentType == 0){
            $this->response(['status' => 0, 'msg' => 'INVALID_AGENT_TYPE'], 400);
            return;
        }

        if($user == false){
            $this->response(['status' => 0, 'msg' => 'INVALID_USER'], 400);
            return;
        }

        $balance = $user[0]['balance'];

        if($balance <= 0){
            $this->response(['status' => 0, 'msg' => 'INSUFFICIENT_FUNDS'], 400);
            return;
        }

        $this->agent->ajustBalanceAdd($code, $balance);
        $updateData = array(
            'balance' => 0
        );
        $agentBalance = $this->agent->getBalance($code);
       
        if($this->db->where('id', $user[0]['id'])->update('users', $updateData)){   
            $this->response(['status' => 1, 'msg' => 'SUCCESS','agent_balance' => $agentBalance, 'user_balance' => strval($balance)], 200);
        } else {
            $this->response(['status' => 0, 'msg' => 'INTERNAL_ERROR'], 400);
        }
    }

    public function money_info($data){
        $code = $data['agent_code'];
        $token = $data['agent_token'];
    
        $id = $this->agent->getId($code, $token);
    
        $agent = $this->agent->get($code);
    
        $agentData = array('agent_code' => $code,
                           'balance' => $agent[0]['balance']);

    
        $allUserAndBalance = $this->user->getAllUserAndBalance($code);
    
        if (isset($data['all_users']) && $data['all_users'] == true) {
            $this->response(['status' => 1, 'msg' => 'SUCCESS','agent' => $agentData, 'user_list' => $allUserAndBalance], 200);
            return;
        }
    
        if (!isset($data['user_code'])) {
            $this->response(['status' => 1, 'msg' => 'SUCCESS','agent' => $agentData], 200);
            return;
        }
    
        $user_code = $data['user_code'];
        
        $user = $this->user->get($user_code, $code);
    
        if($user == false){
            $this->response(['status' => 0, 'msg' => 'INVALID_USER'], 400);
            return;
        }
    
        $balance = $this->user->getBalance($user_code, $code);
        $userData = array(
            'user_code' => $user_code,
            'balance' => strval($balance) // Convertendo para string
        );
    
        $this->response(['status' => 1, 'msg' => 'SUCCESS', 'agent' => $agentData, 'user' => $userData], 200);
    }
    
    public function provider_list(){

        $this->db->select('id,code,name,type,status');
        $provider = $this->db->get_where('providers', array('status' => 1))->result();
        $this->response(['status' => 1, 'msg' => 'Lista de provedores', 'providers' => $provider], 200);
    }
    public function game_list($data){

        if (!isset($data['provider_code'])) {
            $this->response(['status' => 0, 'msg' => 'O campo "provider_code" é obrigatório'], 400);
            return;
        }  
        $provider = $data['provider_code'];

        $this->db->select('id, game_code,game_name,banner,status,provider');
        $games = $this->db->get_where('games', array('provider' => $provider, 'status' => 1))->result();
        $this->response(['status' => 1, 'msg' => 'SUCCESS', 'games' => $games], 200);
    }

    public function game_launch($data){

        if (!isset($data['provider_code'])) {
            $this->response(['status' => 0, 'msg' => 'O campo "provider_code" é obrigatório'], 400);
            return;
        };
        if (!isset($data['game_code'])) {
            $this->response(['status' => 0, 'msg' => 'O campo "game_code" é obrigatório'], 400);
            return;
        }
        if (!isset($data['lang'])) {
            $this->response(['status' => 0, 'msg' => 'O campo "lang" é obrigatório'], 400);
            return;
        }
        $code = $data['agent_code'];
        $token = $data['agent_token'];
        $user_code = $data['user_code'];
        $provider_code = $data['provider_code'];
        $game_code = $data['game_code'];
        $lang = $data['lang'];
        
        if(!isset($data['currency'])){
            $data['currency'] = $this->db->select('currency')->from('agents')->where('agentCode', $code)->get()->row()->currency;
        }

        $agentType = $this->agent->getType($code, $token);
        $user = $this->user->getByID($user_code,$code);

        if($agentType == 0){
        
            if(empty($user)){
                $insertData = array(
                    'agentCode' => $code,
                    'userCode' => $user_code,
                    'aasUserCode' => $code . md5(rand(0, 20000).date('Ymdhhmmss')),
                    'createdAt'=> date('Y-m-d H:i:s'),
                    'balance' => 0,
                    'status' => 1,
                    'apiType' => 0
                );
                $user = $this->user->create($insertData);
            }
            $this->webhook->getBalance($code, $user_code);
        }else{

            if($user == false){   
                $this->response(['status' => 0, 'msg' => 'INVALID_USER'], 400);
                return;
            }        

        }

        $game = $this->game->game_launch($data);

        if($game == false){
            $this->response(['status' => 0, 'msg' => 'GAME_NOT_FOUND'], 400);
            return;
        }
        $game_url = $game['launch_url'];

        $this->response(['status' => 1, 'msg' => 'SUCCESS' , 'launch_url' => $game_url ], 200);
        return;
    }

    public function get_game_log($data) {
        // Verifica se os campos obrigatórios estão presentes nos dados
        $required_fields = ['user_code', 'start', 'end', 'perPage'];
        foreach ($required_fields as $field) {
            if (!isset($data[$field])) {
                $this->response(['status' => 0, 'msg' => 'O campo "' . $field . '" é obrigatório'], 400);
                return;
            }
        }
    
        // Recupera o usuário com base no user_code fornecido
        $this->db->where('userCode', $data['user_code']);
        $user_query = $this->db->get('users');
        if ($user_query->num_rows() == 0) {
            $this->response(['status' => 0, 'msg' => 'Usuário não encontrado'], 404);
            return;
        }
        $user = $user_query->row();
    
        // Define as datas de início e fim
        $start_date = $data['start'];
        $end_date = $data['end'];
    
        // Consulta o registro de histórico de transações
        $this->db->where('user_code', $data['user_code']);
        $this->db->where('created_at >=', $start_date);
        $this->db->where('created_at <=', $end_date);
        $this->db->limit($data['perPage']);
        $gameLog_query = $this->db->get('transaction_history');
    
        if ($gameLog_query === FALSE) {
            $this->response(['status' => 0, 'msg' => 'Erro ao consultar o histórico de jogo'], 500);
            return;
        }
        if ($gameLog_query->num_rows() == 0) {
            $this->response(['status' => 0, 'msg' => 'Nenhum registro de histórico de jogo encontrado'], 404);
            return;
        }
        $gameLog = $gameLog_query->result();
    
        $this->response(['status' => 1, 'slot' => $gameLog], 200);
        return;
    }
    

    public function subagent_deposit($data) {
        date_default_timezone_set('America/Sao_Paulo');
        $code = $data['agent_code'];
        $token = $data['agent_token'];
        $subagent_code = $data['subagent_code'];
       
        $required_fields = ['subagent_code', 'amount'];
        foreach ($required_fields as $field) {
            if (!isset($data[$field])) {
                $this->response(['status' => 0, 'msg' => 'O campo "' . $field . '" é obrigatório'], 400);
                return;
            }
        }

        $checkAgent = $this->agent->checkZero($code, $token);

        if($checkAgent == true){
            $this->response(['status' => 0, 'msg' => 'INSUFFICIENT_FUNDS'], 400);
            return; 
        }

        $amount = $data['amount'];
        $id = $this->agent->getId($code, $token);
        $user = $this->agent->get($subagent_code);
        if($user == false){
            $this->response(['status' => 0, 'msg' => 'INVALID_SUBAGENT'], 400);
            return;
        }
        $balance = $user[0]['balance'] + $amount;
        $agentAjust = $this->agent->ajustBalance($code, $amount);

        if($agentAjust == false){
            $this->response(['status' => 0, 'msg' => 'INSUFFICIENT_FUNDS'], 400);
            return; 
        }

        $updateData = array(
            'balance' => $balance
        );
        $agentBalance = $this->agent->getBalance($code);
        if($this->db->where('id', $user[0]['id'])->update('agents', $updateData)){
            $this->response(['status' => 1, 'msg' => 'SUCCESS', 'agent_balance' => $agentBalance, 'subagent_balance' => strval($balance)], 200);
        } else {
            $this->response(['status' => 0, 'msg' => 'INTERNAL_ERROR'], 400);
        }
    }
    public function subagent_withdraw($data) {
        
        date_default_timezone_set('America/Sao_Paulo');
        $code = $data['agent_code'];
        $token = $data['agent_token'];
        $subagent_code = $data['subagent_code'];
       
        $required_fields = ['subagent_code', 'amount'];
        foreach ($required_fields as $field) {
            if (!isset($data[$field])) {
                $this->response(['status' => 0, 'msg' => 'O campo "' . $field . '" é obrigatório'], 400);
                return;
            }
        }

        $amount = $data['amount'];
        $id = $this->agent->getId($code, $token);
        $user = $this->agent->get($subagent_code);
        if($user == false){
            $this->response(['status' => 0, 'msg' => 'INVALID_SUBAGENT'], 400);
            return;
        }
        $balance = $user[0]['balance'] - $amount;

        if($balance <= 0){
            $this->response(['status' => 0, 'msg' => 'INSUFFICIENT_FUNDS'], 400);
            return;
        }
        $this->agent->ajustBalanceAdd($code, $amount);
        $updateData = array(
            'balance' => $balance
        );

        $agentBalance = $this->agent->getBalance($code);
        if($this->db->where('id', $user[0]['id'])->update('agents', $updateData)){
            $this->response(['status' => 1, 'msg' => 'SUCCESS', 'agent_balance' => $agentBalance, 'subagent_balance' => strval($balance)], 200);
        } else {
            $this->response(['status' => 0, 'msg' => 'INTERNAL_ERROR'], 400);
        }
    }
    public function subagent_reset($data) {
        
        date_default_timezone_set('America/Sao_Paulo');
        $required_fields = ['subagent_code', 'agent_token', 'agent_code'];
        foreach ($required_fields as $field) {
            if (!isset($data[$field])) {
                $this->response(['status' => 0, 'msg' => 'O campo "' . $field . '" é obrigatório'], 400);
                return;
            }
        }

        $code = $data['agent_code'];
        $token = $data['agent_token'];
        $subagent_code = $data['subagent_code'];


        $id = $this->agent->getId($code, $token);
        $user = $this->agent->get($subagent_code);
        if($user == false){
            $this->response(['status' => 0, 'msg' => 'INVALID_SUBAGENT'], 400);
            return;
        }
        $balance = $user[0]['balance'];

        if($balance <= 0){
            $this->response(['status' => 0, 'msg' => 'INSUFFICIENT_FUNDS'], 400);
            return;
        }

        $this->agent->ajustBalanceAdd($code, $balance);
        $updateData = array(
            'balance' => 0
        );
        $agentBalance = $this->agent->getBalance($code);
        if($this->db->where('id', $user[0]['id'])->update('agents', $updateData)){
            $this->response(['status' => 1, 'msg' => 'SUCCESS', 'agent_balance' => $agentBalance], 200);
        } else {
            $this->response(['status' => 0, 'msg' => 'INTERNAL_ERROR'], 400);
        }
    }
}
