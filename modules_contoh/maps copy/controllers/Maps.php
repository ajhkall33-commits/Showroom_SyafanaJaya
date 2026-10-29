<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Maps extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Excel');
        $this->load->model("m_data");
    }

    public function index()
    {
        $data["title"] = "Peta Lokasi Perangkat";
        $data["title_des"] = "Sebaran Lokasi Perangkat di Bandara Soekarno-Hatta";
        $data["content"] = "v_index";

        $lokasi = $this->Mod->GetCustome("
            SELECT 
                jp.nama as jenis_perangkat, 
                f.nama_fasilitas, 
                p.nama_perangkat, 
                f.terminal, 
                tl.latitude, 
                tl.longitude,
                u.name_unit
            FROM titik_lokasi tl
            JOIN fasilitas_detail fd ON tl.idfasilitas_detail = fd.idfasilitas_detail
            JOIN fasilitas f ON fd.id_fasilitas = f.id_fasilitas
            JOIN perangkat p ON fd.id_perangkat = p.id_perangkat
            LEFT JOIN jenis_perangkat jp ON fd.id_jenisperangkat = jp.id_jenisperangkat
            LEFT JOIN unit u ON f.id_unit = u.id_unit
            WHERE tl.status = 0
            AND f.status != 8 
            AND p.status != 8
            AND (u.status IS NULL OR u.status != 8)
            AND f.nama_fasilitas NOT LIKE '%listrik%' 
            AND p.nama_perangkat NOT LIKE '%listrik%'
        ")->result_array();

        $data["lokasi_json"] = json_encode($lokasi);

        $units = $this->Mod->GetCustome("SELECT * FROM unit WHERE status != 8")->result_array();
        $data["units"] = $units;

        $this->load->view('template_v2', $data);
    }
}