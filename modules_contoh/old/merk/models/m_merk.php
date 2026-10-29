<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class m_merk extends CI_Model {
   
    public function saveData($data) {
        $this->db->insert('merk', $data);
    }
   
    public function getMerkData() {
        $query = $this->db->get('merk');
        return $query->result_array();
    }

    public function getTiketById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('merk'); 
        return $query->row_array();
    }    

    public function updateTiket($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('merk', $data);
        return $this->db->affected_rows();
    }
}

