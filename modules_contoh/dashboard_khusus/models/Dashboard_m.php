<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        // Load database
        $this->load->database();   
    }

    public function get_data()
    {
        // Data statis
        $data = array(40, 30, 30);
        return $data;
    }

    public function get_users() {
        $tanggal_hari_ini = date('Y-m-d');
    
        $query = $this->db
            ->select('user.nama, user.nik, user.no_hp,jadwal_kerja.shift')
            ->from('user')
            ->join('jadwal_kerja', 'user.id = jadwal_kerja.id_user')
            ->where('jadwal_kerja.tanggal', $tanggal_hari_ini)
            ->get();
    
        return $query->result_array(); 
    }
}