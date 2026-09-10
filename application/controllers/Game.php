<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Game extends CI_Controller {

    private $initial_balance = 15.00; // Balance inicial

    private function getBalance($token){
        return $this->db->get_where('users', ['aasUserCode' => $token], 1)->row('balance');
    }

    public function index($game)
    {
        $action = $this->input->post('action');
        $aasUserCode = $this->input->post('mgckey');
        $initBal = $this->getBalance($aasUserCode);
        $symbol = $this->input->post('symbol');
        $key = $this->sessionKey($aasUserCode);
       
        switch ($action) {
            case 'settings':
                echo $this->getSettings($symbol);
                break;
            case 'doInit':
                $mgckey = $this->mgckey($symbol);
                $data = array(
                    'code' => $symbol,
                    'key' => $mgckey,
                    'user' => $aasUserCode
                );
                $this->db->insert('game_session', $data);


               log_message('debug', '[Game] load Saldo: '. $initBal);
                $response = $this->sendCurlRequest($this->getPostData('doInit', $mgckey));
                $updatedResponse = $this->updateBalance($response, $initBal);
                $this->saveResponse('doInit', $updatedResponse, $symbol, $this->input->post('index'));
                $this->outputResponse($updatedResponse);

                log_message('debug', '[Game] doInit: '. $updatedResponse);
                break;
            case 'doSpin':
                $response = $this->sendCurlRequest($this->getPostData('doSpin', $key));
                $updatedResponse = $this->updateBalanceFromSpin($response, $aasUserCode);
                $this->saveResponse('doSpin', $updatedResponse, $symbol, $this->input->post('index'));
                $this->outputResponse($updatedResponse);
                break;
            case 'doCollect':
                $response = $this->sendCurlRequest($this->getPostData('doCollect', $key));
                $currentBalance = $this->getBalance($aasUserCode);
                $updatedResponse = $this->replaceBalanceInResponse($response, $currentBalance);
                $this->saveResponse('doCollect', $updatedResponse, $symbol, $this->input->post('index'));
                $this->outputResponse($updatedResponse);
                break;
            default:
                $response = $this->sendCurlRequest($this->getPostData($action,  $key));
                $this->outputResponse($response);
                break;
        }
    }

    private function sessionKey($user){
        return $this->db->get_where('game_session', ['user' => $user], 1)->row('key');
    }

    private function getSettings($symbol)
    {
        $url = base_url().'public/'.$symbol.'/gs2c/saveSettings.do';

        $headers = array(
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:100.0) Gecko/20100101 Firefox/100.0",
            "Accept: */*",
            "Content-Type: application/x-www-form-urlencoded",
            "Origin: https://demogamesfree.ppgames.net",
            "Referer: https://demogamesfree.ppgames.net/",
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;        $url = base_url()."public/js/wurfl.js";
        $headers = array(
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:100.0) Gecko/20100101 Firefox/100.0",
            "Accept: */*",
            "Content-Type: application/x-www-form-urlencoded",
            "Origin: https://demogamesfree.ppgames.net",
            "Referer: https://demogamesfree.ppgames.net/",
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    }

    private function getPostData($action, $mgckey)
    {
        $postData = array(
            'action' => $action,
            'symbol' => $this->input->post('symbol'),
            'cver' => $this->input->post('cver'),
            'index' => $this->input->post('index'),
            'counter' => $this->input->post('counter'),
            'repeat' => $this->input->post('repeat'),
            'mgckey' => $mgckey,
            'ver' => $this->input->get('ver')
        );

        if ($action === 'doSpin') {
            $postData['c'] = $this->input->post('c');
            $postData['l'] = $this->input->post('l');
            $postData['bl'] = $this->input->post('bl');
        }

        return $postData;
    }

    private function sendCurlRequest($postData)
    {
        $url = "https://demogamesfree.ppgames.net/gs2c/v3/gameService";
        if ($postData['ver'] == 'v4') {
            $url = "https://demogamesfree.pragmaticplay.net/gs2c/ge/v4/gameService";
        } elseif ($postData['ver'] == 'gameService') {
            $url = "https://demogamesfree.pragmaticplay.net/gs2c/gameService";
        }

        $headers = array(
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:100.0) Gecko/20100101 Firefox/100.0",
            "Accept: */*",
            "Content-Type: application/x-www-form-urlencoded",
            "Origin: https://demogamesfree.ppgames.net",
            "Referer: https://demogamesfree.ppgames.net/",
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    private function outputResponse($response)
    {
        if ($response === false) {
            echo "Erro ao fazer a solicitação cURL: " . curl_error($ch);
        } else {
            echo $response;
        }
    }

    private function saveResponse($action, $response, $game, $index)
    {
        $data = array(
            'action' => $action,
            'response' => $response,
            'game_code' => $game,
            'index' => $index
        );
        $this->db->insert('game_responses', $data);
    }

    private function updateBalance($response, $newBalance)
    {
        $response = preg_replace('/balance=\d+,\d+\.\d+/', 'balance=' . number_format($newBalance, 2, '.', ''), $response);
        $response = preg_replace('/balance_cash=\d+,\d+\.\d+/', 'balance_cash=' . number_format($newBalance, 2, '.', ''), $response);
        return $response;
    }

    private function updateBalanceFromSpin($response, $aasUserCode)
    {
        // Obter o balance atual
        $balance = $this->getBalance($aasUserCode);
        log_message('debug', '[Game] Saldo sessão: '. $response);

        // Obter o valor da aposta e as linhas
        $betValue = (float)$this->input->post('c');
        $lines = (int)$this->input->post('l');
        $betAmount = $betValue * $lines;

        // Verificar se a aposta é maior que o balance
        if ($balance < $betAmount) {
            $errorResponse = "balance=0.0&balance_cash=0.0&balance_bonus=0.0&frozen=Saldo+insuficiente+para+a+aposta&msg_code=0&ext_code=SystemError";
            log_message('DEBUG', '[INFO.cc] Aposta maior que o saldo. ' . $errorResponse);
            return $errorResponse;
        }

        // Subtrair a aposta do balance
        $balance -= $betAmount;
        log_message('DEBUG', '[INFO.cc] betAmount: ' .  $betAmount);
        log_message('DEBUG', '[INFO.cc] Balance after bet: ' .  $balance);

        // Verificar se há uma vitória e somar ao balance
        preg_match('/tw=([\d.]+)/', $response, $matches);
        if (isset($matches[1])) {
            $winAmount = ((float)$matches[1]); // Converter de centavos para valor decimal
            $balance += $winAmount;
            log_message('DEBUG', '[INFO.cc] Win amount: ' .  $winAmount);
        }else{
            $winAmount = 0.00;
        }

        // Atualizar o balance no banco de dados
        $this->updateUserBalance($aasUserCode, $balance, $betAmount, $winAmount);

        log_message('DEBUG', '[INFO.cc] Adjusted Balance: ' .  $balance);

        return $this->replaceBalanceInResponse($response, $balance);
    }

    private function updateUserBalance($aasUserCode, $balance, $betAmount, $winAmount)
    {
        $user = $this->db->get_where('users', ['aasUserCode' => $aasUserCode], 1)->row();

        if($user->apiType == 1){
            $this->db->where('aasUserCode', $aasUserCode);
            $updata = array(
                'balance' => $balance
            );
            $this->db->update('users', $updata);
        } else {
            $this->db->where('aasUserCode', $aasUserCode);
            $updata = array(
                'balance' => $balance
            );
            $this->db->update('users', $updata);

            $historyInsert = array(
                'user_code' => $user->userCode,
                'agent_code' => $user->agentCode,
                'user_balance' => $this->formatAmount($balance + $betAmount),
                'user_after_balance' => $this->formatAmount($balance),
                'provider_code' =>  'PRAGMATICPLAY',
                'currency' => 'BRL',
                'game_code' => $this->input->post('symbol'),
                'bet_money' => $this->formatAmount($betAmount),
                'win_money' => $this->formatAmount($winAmount),
                'txn_id' => rand(100000, 999999),
                'created_at' => date("Y-m-d H:i:s")
            );

            $this->webhook->transaction($user->agentCode, $user->userCode, $historyInsert);
        }
    }

    private function replaceBalanceInResponse($response, $newBalance)
    {
        $formattedBalance = number_format($newBalance, 2, '.', '');
        $response = preg_replace('/balance=\d{1,3}(?:,\d{3})*\.\d{2}/', 'balance=' . $formattedBalance, $response);
        $response = preg_replace('/balance_cash=\d{1,3}(?:,\d{3})*\.\d{2}/', 'balance_cash=' . $formattedBalance, $response);
        return $response;
    }

    public function promo()
    {
        echo '{}';
    }

    public function wurlf()
    {
        $url = base_url()."public/js/wurfl.js";
        $headers = array(
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:100.0) Gecko/20100101 Firefox/100.0",
            "Accept: */*",
            "Content-Type: application/x-www-form-urlencoded",
            "Origin: https://demogamesfree.ppgames.net",
            "Referer: https://demogamesfree.ppgames.net/",
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    }

    public function mgckey($gameSymbol)
    {
        $compactSessionUrl = "https://demogamesfree.pragmaticplay.net/gs2c/openGame.do?gameSymbol=" . $gameSymbol . "&websiteUrl=https%3A%2F%2Fdemogamesfree.pragmaticplay.net&jurisdiction=99&lobby_url=https%3A%2F%2Fwww.pragmaticplay.com%2Fen%2F&lang=PT&cur=EUR";
        $headers = array(
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:100.0) Gecko/20100101 Firefox/100.0",
            "Accept: */*",
            "Content-Type: application/x-www-form-urlencoded",
            "Origin: https://demogamesfree.ppgames.net",
            "Referer: https://demogamesfree.ppgames.net/",
        );

        $ch = curl_init($compactSessionUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $html = curl_exec($ch);
        $redirectURL = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);

        if ($html === false) {
            echo "Erro ao fazer a requisição cURL: " . curl_error($ch);
        } else {
            $parsedUrl = parse_url($redirectURL);
            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $query);
                if (isset($query['mgckey'])) {
                    return $query['mgckey'];
                } else {
                    echo "mgckey não encontrado na URL de redirecionamento.";
                }
            } else {
                echo "A URL de redirecionamento não contém parâmetros de consulta.";
            }
        }
    }

    public function stats(){
        return '{"error":0,"description":"OK"}';
    }

    private function formatAmount($amount) {
        return number_format((float)$amount, 2, '.', '');
    }
}
