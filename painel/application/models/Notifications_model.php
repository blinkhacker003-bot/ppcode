<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications_model extends CI_Model {

    public function getAll(){
        $this->db->select('*');
        $this->db->from('popups');
        $this->db->order_by('id', 'DESC');
        return $this->db->get()->result();
    }
}