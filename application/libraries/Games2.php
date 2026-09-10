<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Games2{
    
        public function __construct()
        {
            $this->CI = &get_instance();
            $this->CI->load->helper('url');
            $this->CI->config->item('base_url');
            $this->CI->load->database();
        }
        private function enviarRequest($url, $config) {
            $ch = curl_init();
    
            $headerArray = ['Content-Type: application/json'];
            // Configurando as opções do cURL
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $config);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
            // Executando a requisição e obtendo a resposta
            $response = curl_exec($ch);
    
            // Fechando a conexão cURL
            curl_close($ch);
    
            log_message('DEBUG', '[GAMES2] Request Response: ' . $response);
            return $response;
        }
    
        private function getKeys(){    
            $data = array(
                'url' => 'https://api.games2api.xyz',
                'agent_code' => 'admin-3',
                'agent_token' => 'admin-3-tk:70b0ea68-a392-4837-af14-b55f2f59fc4e'
            );
    
            return $data;
        }

        public function setBalance($id, $balance){

            $keys = $this->getKeys();
    
            $url = $keys['url']; 
    
            $query['user'] = $this->CI->db->get_where('users', array('id' => $id))->row();
    
            $num = floatval($balance);
    
            // Dados para o corpo da requisição em formato JSON
            $data = array(
                'method' => 'user_deposit',
                'agent_code' => $keys['agent_code'],
                'agent_token' => $keys['agent_token'], 
                'user_code' => $query['user']->aasUserCode,
                "amount" => $num
            );
    
            $json_data = json_encode($data);
    
    
            // Fazendo a requisição POST
            $response = $this->enviarRequest($url, $json_data);
    
            // Exibindo a resposta
    
            $data = json_decode($response, true);
    
            return true;
        }

        public function reset($id){

            $keys = $this->getKeys();
    
            $query['user'] = $this->CI->db->get_where('users', array('id' => $id))->row();
    
            $url = $keys['url']; 
    
            // Dados para o corpo da requisição em formato JSON
            $data = array(
                'method' => 'user_withdraw_reset',
                'agent_code' => $keys['agent_code'],
                'agent_token' => $keys['agent_token'], 
                'user_code' => $query['user']->aasUserCode
            );
    
            $json_data = json_encode($data);
    
    
            // Fazendo a requisição POST
            $response = $this->enviarRequest($url, $json_data);
    
            // Exibindo a resposta
    
            $data = json_decode($response, true);
    
        }
        public function createUser($id){

            $keys = $this->getKeys();
            $url = $keys['url']; 
    
            $query['user'] = $this->CI->db->get_where('users', array('id' => $id))->row();
    
            // Dados para o corpo da requisição em formato JSON
            $data = array(
                'method' => 'user_create',
                'agent_code' => $keys['agent_code'],
                'agent_token' => $keys['agent_token'],
                'user_code' => $query['user']->aasUserCode
            );
    
            $json_data = json_encode($data);
    
            // Fazendo a requisição POST
            $response = $this->enviarRequest($url, $json_data);
        }

        public function obterProvedores() {
            date_default_timezone_set('America/Sao_Paulo');
            $keys = $this->getKeys();
        
            $url = $keys['url'];
        
            $data = array(
                'method' => 'provider_list',
                'agent_code' => $keys['agent_code'],
                'agent_token' => $keys['agent_token'] 
            );
        
            $json_data = json_encode($data);
        
            // Fazendo a requisição POST
            $response = $this->enviarRequest($url, $json_data);
        
            // Exibindo a resposta
            $dados = json_decode($response, true);
        
            if ($dados && isset($dados['status']) && $dados['status'] == 1 && isset($dados['providers'])) {
                foreach ($dados['providers'] as $provedor) {
                    // Verificar se o provedor já existe na tabela
                    $exists = $this->provedorExiste($provedor['code']);
                    
                    if (!$exists) {
                        // Insere o provedor na tabela 'provedores'
                        $dados_provedor = array(
                            'code' => $provedor['code'],
                            'name' => $provedor['name'],
                            'type' => $provedor['type'],
                            'endpoint' => 'GAMES2API',
                            'createdAt' => date('Y-m-d H:i:s'),
                            'status' => 1
                        );
        
                        $this->CI->db->insert('providers', $dados_provedor);
                        $this->obterJogos($provedor['code']);
                    } else {
                        echo "O provedor com código " . $provedor['code'] . " já existe na tabela. Dando skip.<br>";
                    }
                }
        
                echo "A lista de jogos foi atualizada com sucesso! <br>";
            } else {
                echo "Os dados da API estão incorretos ou o status não é 1. <br>";
            }
        }
        
        // Função para verificar se o provedor já existe na tabela
        private function provedorExiste($code) {
            $this->CI->db->where('code', $code);
            $query = $this->CI->db->get('providers');
            return $query->num_rows() > 0;
        } 
        
    
        public function obterJogos($provedor) {
            $keys = $this->getKeys();
        
            $url = $keys['url'];
        
            $data = array(
                'method' => 'game_list',
                'agent_code' => $keys['agent_code'],
                'agent_token' => $keys['agent_token'],
                'provider_code' => $provedor
            );
        
            $json_data = json_encode($data);
        
            // Fazendo a requisição POST
            $response = $this->enviarRequest($url, $json_data);
        
            // Exibindo a resposta
            $dados = json_decode($response, true);
        
            if ($dados && isset($dados['games'])) {
                foreach ($dados['games'] as $game) {
                    // Verificar se o jogo já existe na tabela
                    $exists = $this->jogoExiste($game['game_code']);
        
                    if (!$exists) {
                        // Insere o jogo na tabela 'games'
                        $dados_jogo = array(
                            'game_code' => $game['game_code'],
                            'game_name' => $game['game_name'],
                            'banner' => $game['banner'],
                            'API' => 'GAMES2API',
                            'provider' => $provedor
                        );
        
                        $this->CI->db->insert('games', $dados_jogo);
                    } else {
                        echo "O jogo com código " . $game['game_code'] . " já existe na tabela. Dando skip.<br>";
                    }
                }
            }
        }
        
        // Função para verificar se o jogo já existe na tabela
        private function jogoExiste($game_code) {
            $this->CI->db->where('game_code', $game_code);
            $query = $this->CI->db->get('games');
            return $query->num_rows() > 0;
        }
        
        public function getGame($provedor,$game, $user_code, $agent_code){

            $query['user'] = $this->CI->db->get_where('users', array('userCode' => $user_code, 'agentCode' => $agent_code))->row();

            $keys = $this->getKeys();
    
            $url = $keys['url']; 
    
            // Dados para o corpo da requisição em formato JSON
            $data = array(
                'method' => 'game_launch',
                'agent_code' => $keys['agent_code'],
                'agent_token' => $keys['agent_token'], 
                'user_code' => $query['user']->aasUserCode,
                "provider_code" => $provedor,
                "game_code" => $game,
                "lang" =>  "pt"
            );
    
            $json_data = json_encode($data);
       
            // Fazendo a requisição POST
            $response = $this->enviarRequest($url, $json_data);
            $dados = json_decode($response, true);
            return $dados;
        }

        public function resetBalance($aasUserCode){

            $keys = $this->getKeys();
    
            $url = $keys['url']; 
    
            // Dados para o corpo da requisição em formato JSON
            $data = array(
                'method' => 'user_withdraw_reset',
                'agent_code' => $keys['agent_code'],
                'agent_token' => $keys['agent_token'], 
                'user_code' => $aasUserCode
            );
    
            $json_data = json_encode($data);
    
            // Fazendo a requisição POST
            $response = $this->enviarRequest($url, $json_data);
    
            // Exibindo a resposta
            $data = json_decode($response, true);
    
        }
        public function getBalance($user_code, $agent_code){
                
            $keys = $this->getKeys();

            $query['user'] = $this->CI->db->get_where('users', array('userCode' => $user_code, 'agentCode' => $agent_code))->row();
    
            $url = $keys['url'];
    
            $data = array(
                'method' => 'money_info',
                'agent_code' => $keys['agent_code'],
                'agent_token' => $keys['agent_token'],
                'user_code' => $query['user']->aasUserCode
            );
    
            $json_data = json_encode($data);

            $response = $this->enviarRequest($url, $json_data);
            $dados = json_decode($response, true);
           
            if (isset($dados['user']['balance'])) {
                return $dados['user']['balance'];
            } else {
                return null; 
            }
        }
        public function getHist($user_code){

            date_default_timezone_set('America/Sao_Paulo');
            $dataAtual = date('Y-m-d');
            $dataObj = new DateTime($dataAtual);
            $dataAnterior = $dataObj->modify('-1 day');
            $diaAnterior = $dataAnterior->format('Y-m-d');

            $dataposterior = $dataObj->modify('+3 day');
            $amanha = $dataposterior->format('Y-m-d');
            $keys = $this->getKeys();
            $url = $keys['url']; 
            $query['user'] = $this->CI->db->get_where('users', array('userCode' => $user_code))->row();
    
            $data = array(
                'method' => 'get_game_log',
                'agent_code' => $keys['agent_code'],
                'agent_token' => $keys['agent_token'], 
                'user_code' => $query['user']->aasUserCode,
                'game_type' => 'slot',
                'start' => $diaAnterior.' 00:00:00',
                'end' => $amanha.' 23:59:00',
                'page' => 0,
                'perPage' => 10000
            );

            $json_data = json_encode($data);

            $response = $this->enviarRequest($url, $json_data);

            $dados = json_decode($response, true);
            return $dados;
        }

        public function getMoneyInfo(){
                
            $keys = $this->getKeys();
    
            $url = $keys['url'];
    
            $data = array(
                'method' => 'money_info',
                'agent_code' => $keys['agent_code'],
                'agent_token' => $keys['agent_token'],
            );
    
            $json_data = json_encode($data);

            $response = $this->enviarRequest($url, $json_data);
            $dados = json_decode($response, true);
           
            if (isset($dados['agent']['balance'])) {
                return $dados['agent']['balance'];
            } else {
                return null; 
            }
        }
        public function resetAll(){

            $keys = $this->getKeys();

            $url = $keys['url'];
    
            // Dados para o corpo da requisição em formato JSON
            $data = array(
                'method' => 'user_withdraw_reset',
                'agent_code' => $keys['agent_code'],
                'agent_token' => $keys['agent_token'], 
                'all_users' => true 
            );
    
            $json_data = json_encode($data);
    
    
            // Fazendo a requisição POST
            $response = $this->enviarRequest($url, $json_data);
    
            // Exibindo a resposta
    
            echo json_encode($response, true);
    
        }
}