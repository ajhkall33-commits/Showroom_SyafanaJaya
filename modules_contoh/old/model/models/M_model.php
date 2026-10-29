<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class M_Model extends CI_Model {
   
    public function saveData($data) {
        $this->db->insert('model', $data);
    }
   
    public function getModelData() {
        $query = $this->db->get('model');
        return $query->result_array();
    }

    public function getTiketById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('model'); 
        return $query->row_array();
    }    

    public function updateTiket($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('model', $data);
        return $this->db->affected_rows();
    }
}

