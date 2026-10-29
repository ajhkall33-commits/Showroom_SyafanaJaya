<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Komponen_masuk extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("m_data");
    }

    public function index() {
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"]     = "Komponen Masuk";
        $data["title_des"] = "Daftar Stok Komponen Masuk";
        $data["content"]   = "v_index";
        $data["data"]      = $data;
        $this->load->view('template_v2', $data);
    }

    // Load semua data komponen masuk milik unit yang sedang login, status != 8
    public function LoadData() {
        // SK Manager: filter unit dinamis
        $unit_filter_sql = get_unit_filter_sql('unit');
        
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        
        $where_date = "";
        if (!empty($bulan) && !empty($tahun)) {
            $where_date = "AND MONTH(km.tanggal) = '$bulan' AND YEAR(km.tanggal) = '$tahun'";
        } elseif (!empty($tahun)) {
            $where_date = "AND YEAR(km.tanggal) = '$tahun'";
        }

        $res = $this->Mod->GetCustome("
            SELECT km.id_komponen_masuk,
                   km.id_komponen,
                   km.satuan_masuk,
                   km.tanggal,
                   km.status,
                   k.nama_komponen,
                   jp.nama AS nama_jenis_perangkat
            FROM komponen_masuk km
            LEFT JOIN komponen k  ON k.id_komponen           = km.id_komponen
            LEFT JOIN jenis_perangkat jp ON jp.id_jenisperangkat = k.id_jenisperangkat
            WHERE km.id_unit $unit_filter_sql
              AND km.status != 8
              $where_date
            ORDER BY km.tanggal DESC
        ")->result_array();

        echo json_encode(['data' => $res]);
    }

    // Ambil daftar komponen aktif milik unit untuk dropdown form
    public function GetKomponenList() {
        $unit = sess()['unit'];

        // SK Manager: jika role terdaftar di role_sk_manager, tampilkan data dari semua unit yang dikelola
        $unit_filter_sql = "= '$unit'";
        if (is_sk_manager()) {
            $sk_units = get_allowed_units();
            if (!empty($sk_units)) {
                $unit_filter_sql = "IN (" . implode(',', $sk_units) . ")";
            }
        }

        $res  = $this->Mod->GetCustome("
            SELECT k.id_komponen,
                   k.nama_komponen,
                   COALESCE(jp.nama, '-') AS nama_jenis_perangkat
            FROM komponen k
            LEFT JOIN jenis_perangkat jp ON jp.id_jenisperangkat = k.id_jenisperangkat
            WHERE k.status != 8
              AND k.id_unit $unit_filter_sql
            ORDER BY jp.nama ASC, k.nama_komponen ASC
        ")->result_array();
        echo json_encode($res);
    }

    // Simpan data baru
    public function SaveData() {
        $id_komponen  = $this->input->post('id_komponen');
        $satuan_masuk = $this->input->post('satuan_masuk');
        $tanggal      = $this->input->post('tanggal');

        if (empty($id_komponen) || empty($satuan_masuk) || empty($tanggal)) {
            echo json_encode(['status' => '400', 'msg' => 'Semua field harus diisi.']);
            return;
        }

        $data = [
            'id_komponen'  => $id_komponen,
            'satuan_masuk' => (int) $satuan_masuk,
            'tanggal'      => $tanggal,
            'id_unit'      => sess()['unit'],
            'status'       => 1
        ];
        $this->db->insert('komponen_masuk', $data);
        echo json_encode(['status' => '200', 'msg' => 'Data berhasil disimpan.']);
    }

    // Ambil satu record untuk diisi ke form edit
    public function EditData($id = null) {
        if (empty($id)) {
            echo json_encode([]);
            return;
        }
        $id  = (int) $id;
        $res = $this->Mod->GetCustome("
            SELECT km.id_komponen_masuk,
                   km.id_komponen,
                   km.satuan_masuk,
                   DATE_FORMAT(km.tanggal, '%Y-%m-%d') AS tanggal,
                   k.nama_komponen
            FROM komponen_masuk km
            LEFT JOIN komponen k ON k.id_komponen = km.id_komponen
            WHERE km.id_komponen_masuk = '$id'
            LIMIT 1
        ")->row_array();
        echo json_encode($res ?: []);
    }

    // Update record
    public function Update($id = null) {
        $id           = (int) $id;
        $id_komponen  = $this->input->post('id_komponen');
        $satuan_masuk = $this->input->post('satuan_masuk');
        $tanggal      = $this->input->post('tanggal');

        if (empty($id) || empty($id_komponen) || empty($satuan_masuk) || empty($tanggal)) {
            echo json_encode(['status' => '400', 'msg' => 'Semua field harus diisi.']);
            return;
        }

        $data = [
            'id_komponen'  => $id_komponen,
            'satuan_masuk' => (int) $satuan_masuk,
            'tanggal'      => $tanggal
        ];
        $this->db->query("UPDATE komponen_masuk SET id_komponen='{$id_komponen}', satuan_masuk='{$satuan_masuk}', tanggal='{$tanggal}' WHERE id_komponen_masuk = '$id'");
        echo json_encode(['status' => '200', 'msg' => 'Data berhasil diperbarui.']);
    }

    // Soft delete: set status = 8
    public function Delete($id = null) {
        $id = (int) $id;
        if (empty($id)) {
            echo json_encode(['status' => '400', 'msg' => 'ID tidak valid']);
            return;
        }

        $this->db->query("UPDATE komponen_masuk SET status = 8 WHERE id_komponen_masuk = '$id'");
        echo json_encode(['status' => '200', 'msg' => 'Data berhasil dihapus']);
    }
}