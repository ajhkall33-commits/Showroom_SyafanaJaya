<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Komponen_terpakai extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("m_data");
    }

    public function index() {
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"]     = "Komponen Terpakai";
        $data["title_des"] = "Daftar Komponen Terpakai";
        $data["content"]   = "v_index";
        $data["data"]      = $data;
        $this->load->view('template_v2', $data);
    }

    // Load data komponen terpakai milik unit yang sedang login, dengan filter bulan/tahun
    public function LoadData() {
        // SK Manager: filter unit dinamis
        $unit_filter_sql = get_unit_filter_sql('unit');
        
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');

        $filter_tanggal = "";
        
        // Filter menggunakan tanggal_selesai dari tabel tinjut
        if (!empty($bulan) && !empty($tahun)) {
            $filter_tanggal = " AND MONTH(t.tanggal_selesai) = '$bulan' AND YEAR(t.tanggal_selesai) = '$tahun' ";
        } elseif (!empty($tahun)) {
            $filter_tanggal = " AND YEAR(t.tanggal_selesai) = '$tahun' ";
        } elseif (!empty($bulan)) {
            $filter_tanggal = " AND MONTH(t.tanggal_selesai) = '$bulan' ";
        }

        $sql = "
            SELECT 
                kt.id_komponen_terpakai,
                kt.id_tinjut,
                kt.id_komponen,
                kt.satuan_terpakai,
                kt.status,
                k.nama_komponen,
                jp.nama AS nama_jenis_perangkat,
                t.nomor AS nomor_tinjut,
                t.tanggal_mulai,
                t.tanggal_selesai
            FROM komponen_terpakai kt
            INNER JOIN tinjut t ON t.id_tinjut = kt.id_tinjut
            INNER JOIN komponen k ON k.id_komponen = kt.id_komponen
            LEFT JOIN jenis_perangkat jp ON jp.id_jenisperangkat = k.id_jenisperangkat
            WHERE kt.status != 8 
              AND t.id_unit $unit_filter_sql
              $filter_tanggal
            ORDER BY t.tanggal_selesai DESC, kt.id_komponen_terpakai DESC
        ";

        $res = $this->Mod->GetCustome($sql)->result_array();

        echo json_encode(['data' => $res]);
    }
}