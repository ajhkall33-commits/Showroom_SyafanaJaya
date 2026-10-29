<?php

class Keterangan_model extends CI_Model {
    public function save_keterangan($data) {
        $this->db->insert('keterangan', $data);
   
    }

}
