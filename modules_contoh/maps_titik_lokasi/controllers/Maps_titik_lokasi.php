<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Maps_titik_lokasi extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Excel');
        $this->load->model("m_data");
    }

    public function index()
    {
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Master Titik Lokasi";
        $data["title_des"] = "Master data koordinat lokasi perangkat";
        $data["content"] = "v_index";

        $data['unit'] = $this->Mod->getWhere('unit', array('status !=' => 8))->result_array();

        $this->load->view('template_v2', $data);
    }

    // Fungsi menampilkan data dari database ke tabel view
    function LoadData()
    {
        $id_unit = $this->input->post('id_unit');
        
        $whereUnit = "";
        if (!empty($id_unit)) {
            $whereUnit = " AND f.id_unit = " . $this->db->escape($id_unit);
        }

        $data = $this->Mod->GetCustome("
            SELECT 
                fd.idfasilitas_detail, 
                jp.nama as jenis_perangkat, 
                f.nama_fasilitas, 
                p.nama_perangkat, 
                f.terminal, 
                tl.id_titik_lokasi,
                tl.latitude, 
                tl.longitude, 
                tl.status
            FROM fasilitas_detail fd
            JOIN fasilitas f ON fd.id_fasilitas = f.id_fasilitas
            JOIN perangkat p ON fd.id_perangkat = p.id_perangkat
            LEFT JOIN jenis_perangkat jp ON fd.id_jenisperangkat = jp.id_jenisperangkat
            LEFT JOIN titik_lokasi tl ON fd.idfasilitas_detail = tl.idfasilitas_detail AND tl.status != 8
            LEFT JOIN unit u ON f.id_unit = u.id_unit
            WHERE (tl.status IS NULL OR tl.status != 8)
            AND f.status != 8 
            AND p.status != 8
            AND (u.status IS NULL OR u.status != 8)
            AND f.nama_fasilitas NOT LIKE '%listrik%' 
            AND p.nama_perangkat NOT LIKE '%listrik%'
            $whereUnit
            ORDER BY fd.idfasilitas_detail
        ")->result_array();

        echo json_encode($data);
    }

    // Fungsi sava/update data koordinat
    public function SaveData()
    {
        $idfasilitas_detail = $this->input->post('idfasilitas_detail');
        $latitude = $this->input->post('latitude');
        $longitude = $this->input->post('longitude');

        if (empty($idfasilitas_detail) || empty($latitude) || empty($longitude)) {
            $res = [
                'status' => '400',
                'msg'    => 'Data Gagal Disimpan, pastikan latitude & longitude terisi.'
            ];
            echo json_encode($res);
            return;
        }

        // Cek apakah data koordinat sudah ada untuk idfasilitas_detail ini (dan tidak terhapus)
        $cek = $this->Mod->getWhere('titik_lokasi', array('idfasilitas_detail' => $idfasilitas_detail, 'status !=' => 8))->row_array();

        if ($cek) {
            // Update data
            $data_to_update = [
                'latitude'  => $latitude,
                'longitude' => $longitude
            ];
            $res_update = $this->Mod->update2('titik_lokasi', array('id_titik_lokasi' => $cek['id_titik_lokasi']), $data_to_update);
            
            $res = [
                'status' => '200',
                'msg'    => 'Data Berhasil Diupdate'
            ];
        } else {
            // Insert baru
            $data_to_insert = [
                'idfasilitas_detail' => $idfasilitas_detail,
                'latitude'           => $latitude,
                'longitude'          => $longitude,
                'status'             => 0
            ];
            $this->db->insert('titik_lokasi', $data_to_insert);
            
            $res = [
                'status' => '200',
                'msg'    => 'Data Berhasil Disimpan'
            ];
        }

        echo json_encode($res);
    }

    function Delete($id=null){
        if (!empty($id)) {
            $data = ['status' => 8];
            $res_update = $this->Mod->update2('titik_lokasi', array('id_titik_lokasi' => $id), $data);  
            
            $res = [
                'code' => '200',
                'msg' => 'Data Koordinat Berhasil di Hapus'
            ];
            echo json_encode($res);
        } else {
            echo json_encode(['code' => '400', 'msg' => 'ID tidak valid']);
        }
    }
}