<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_tinjut extends CI_Model {

    public function get_lokasi_options() {
        $query = $this->db->get('terminal');
        return $query->result();
    }

    public function get_fasilitas_options() {
        $query = $this->db->get('fasilitas');
        return $query->result();
    }


    public function getTiketById($id) {
        $this->db->where('id_tiket', $id);
        $query = $this->db->get('tiket'); 
        return $query->row_array();
    }    

    public function updateTiket($id, $data) {
        $this->db->where('id_tiket', $id);
        $this->db->update('tiket', $data);
        return $this->db->affected_rows();
    }


}