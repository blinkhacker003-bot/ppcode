<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Callback extends CI_Controller {

    public function index() {
        $json_data = file_get_contents('php://input');
        date_default_timezone_set('America/Sao_Paulo');
        log_message('debug', '[Callback.php] Receive Request: ' . $json_data);

        $headers = $this->input->request_headers();
        log_message('debug', '[Callback.php] Receive HeaderRequest: ' . json_encode($headers));

        $data = json_decode($json_data, true);
        $method = $data['method'];
        $playerid = $data['user_code'];     

        if ($this->isAgentBalanceZero($playerid)) {
            return $this->outputError('INSUFFICIENT_USER_FUNDS', 0);
        }

        $user = $this->getUserByCode($playerid);
        if (!$user) {
            return $this->outputError('INSUFFICIENT_USER_FUNDS', 0);
        }

        switch ($method) {
            case 'user_balance':
                $this->handleUserBalance($user);
                break;

            case 'transaction':
                $this->handleTransaction($data, $user);
                break;
        }
    }

    private function getUserByCode($playerid) {
        $query = $this->db->get_where('users', array('aasUserCode' => $playerid));
        return ($query->num_rows() > 0) ? $query->row_array() : null;
    }

    private function isAgentBalanceZero($playerid) {
        $user = $this->db->get_where('users', array('aasUserCode' => $playerid))->row();
        if ($user) {
            $agent = $this->db->get_where('agents', array('agentCode' => $user->agentCode))->row();
            return $agent && $agent->balance <= 0;
        }
        return false;
    }

    private function outputError($message, $balance = 0) {
        http_response_code(400);
        $response = array(
            'status' => 0,
            'user_balance' => $balance,
            'msg' => $message
        );
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    private function handleUserBalance($user) {
        $response = array(
            'status' => 1,
            'user_balance' => $user['balance']
        );
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    private function handleTransaction($data, $user) {
        log_message('debug', '[Callback.php] Transaction Callback Request: ' . json_encode($data));

        $this->saveTransaction($historyInsert, $data);

        $getBalance = $this->formatAmount($data['balance']);
        $response = array(
            'status' => 1,
            'user_balance' => $getBalance
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    private function formatAmount($amount) {
        return number_format((float)$amount, 2, '.', '');
    }

    private function getGameByCode($game_code) {
        $game_code = (string) $game_code;
        return $this->db->get_where('games', array('game_code' => $game_code))->row_array();
    }

    private function prepareHistoryInsert($data) {
        return array(
            'user_code' => $data['userCode'],
            'agent_code' => $data['agentCode'],
            'user_balance' => $this->formatAmount($data['balance']),
            'user_after_balance' => $this->formatAmount($data['user_after_balance']),
            'provider_code' =>  $data['provider_code'],
            'currency' => $data['currency'],
            'game_code' => $game['game_code'],
            'bet_money' => $data['bet_money'],
            'win_money' => $data['win_money'],
            'txn_id' => rand(100000, 999999),
            'created_at' => date("Y-m-d H:i:s")
        );
    }

    private function saveTransaction($historyInsert, $user, $getBalance, $newTotalCredit, $newTotalDebit) {
        $this->saveHistory($historyInsert);
        $this->updateUserBalance($user['id'], $getBalance, $newTotalCredit, $newTotalDebit);

        $agent = $this->db->get_where('agents', array('agentCode' => $user['agentCode']))->row();
        if ($agent->apiType == 0) {
            $this->webhook->transaction($user['agentCode'], $user['userCode'], $historyInsert);
        }
    }

    private function updateUserBalance($user_id, $getBalance, $newTotalCredit, $newTotalDebit) {
        $updateData = array(
            'balance' => $this->formatAmount($getBalance),
            'totalCredit' => $this->formatAmount($newTotalCredit),
            'totalDebit' => $this->formatAmount($newTotalDebit)
        );
        $this->db->where('id', $user_id)->update('users', $updateData);
    }

    private function saveHistory($data) {
        $this->db->insert('transaction_history', $data);
        return $this->db->insert_id();
    }
}
