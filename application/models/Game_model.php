<?php 

class Game_model extends CI_Model {

    public function game_launch($data){

        $this->db->where('game_code', $data['game_code']);
        $game = $this->db->get('games')->result();

        $this->db->where('userCode', $data['user_code']);
        $user = $this->db->get('users')->result();

        $this->db->where('user', $user[0]->aasUserCode);
        $this->db->delete('game_session');

        if (!empty($game)) {
            switch ($game[0]->API) {
                case 'GAMES2API':
                    return $this->games2->getGame($game[0]->provider, $game[0]->game_code, $data['user_code'], $data['agent_code']);
                    break;
                default:
                    $gameURL = base_url().'play?game='.$data['game_code'].'&user='. $user[0]->aasUserCode  .'&lang=pt&cur=BRL';
                    $data = array(
                        'status' => 1, 'message' => 'GAME_URL', 'launch_url' => $gameURL
                    );
                    return $data;
            }
        } else {
            return false;
        }

    }
}