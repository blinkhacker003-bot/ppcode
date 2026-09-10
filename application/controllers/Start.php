<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Start extends CI_Controller {

    public function resync(){
        $this->games2->obterProvedores();
        //$this->games2->obterProvedores();
        //$this->games2->obterJogos('PGSOFT');
    }
}