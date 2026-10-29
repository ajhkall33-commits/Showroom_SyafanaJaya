<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wwc_kriteria extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"]    = "Master Kriteria Kompetensi";
        $data["title_des"] = "Kelola data master kriteria wawancara kompetensi";
        $data["content"]  = "v_index";

        $this->load->view('template_v2', $data);
    }

    // Load semua data kriteria (AJAX)
    public function LoadData()
    {
        $data = $this->Mod->GetCustome("
            SELECT id_kriteria, kode_kriteria, nama_kriteria, deskripsi, urutan, status
            FROM wwc_kriteria
            WHERE status != 8
            ORDER BY urutan ASC, id_kriteria ASC
        ")->result_array();

        echo json_encode($data);
    }

    // Ambil 1 data untuk form edit (AJAX)
    public function EditData($id = null)
    {
        if (!empty($id)) {
            $data = $this->Mod->getWhere('wwc_kriteria', array('id_kriteria' => $id))->row_array();
            echo json_encode($data);
        } else {
            echo json_encode([]);
        }
    }

    // Simpan data baru (AJAX)
    public function SaveData()
    {
        $kode_kriteria  = trim($this->input->post('kode_kriteria'));
        $nama_kriteria  = trim($this->input->post('nama_kriteria'));
        $deskripsi      = $this->input->post('deskripsi');
        $urutan         = $this->input->post('urutan');

        if (empty($kode_kriteria) || empty($nama_kriteria)) {
            echo json_encode(['status' => '400', 'msg' => 'Kode dan Nama Kriteria tidak boleh kosong.']);
            return;
        }

        // Cek duplikat kode
        $cek = $this->Mod->GetCustome("
            SELECT id_kriteria FROM wwc_kriteria WHERE kode_kriteria = '" . $this->db->escape_str($kode_kriteria) . "' AND status != 8
        ")->row_array();

        if ($cek) {
            echo json_encode(['status' => '400', 'msg' => 'Kode Kriteria sudah digunakan.']);
            return;
        }

        $data = [
            'kode_kriteria' => $kode_kriteria,
            'nama_kriteria' => $nama_kriteria,
            'deskripsi'     => $deskripsi,
            'urutan'        => !empty($urutan) ? (int)$urutan : 0,
            'status'        => 0,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];

        $this->db->insert('wwc_kriteria', $data);

        echo json_encode(['status' => '200', 'msg' => 'Kriteria berhasil disimpan.']);
    }

    // Update data (AJAX)
    public function UpdateData($id = null)
    {
        if (empty($id)) {
            echo json_encode(['status' => '400', 'msg' => 'ID tidak valid.']);
            return;
        }

        $kode_kriteria = trim($this->input->post('kode_kriteria'));
        $nama_kriteria = trim($this->input->post('nama_kriteria'));
        $deskripsi     = $this->input->post('deskripsi');
        $urutan        = $this->input->post('urutan');

        if (empty($kode_kriteria) || empty($nama_kriteria)) {
            echo json_encode(['status' => '400', 'msg' => 'Kode dan Nama Kriteria tidak boleh kosong.']);
            return;
        }

        // Cek duplikat kode (exclude diri sendiri)
        $cek = $this->Mod->GetCustome("
            SELECT id_kriteria FROM wwc_kriteria 
            WHERE kode_kriteria = '" . $this->db->escape_str($kode_kriteria) . "' 
            AND status != 8 AND id_kriteria != " . (int)$id . "
        ")->row_array();

        if ($cek) {
            echo json_encode(['status' => '400', 'msg' => 'Kode Kriteria sudah digunakan.']);
            return;
        }

        $data = [
            'kode_kriteria' => $kode_kriteria,
            'nama_kriteria' => $nama_kriteria,
            'deskripsi'     => $deskripsi,
            'urutan'        => !empty($urutan) ? (int)$urutan : 0,
            'updated_at'    => date('Y-m-d H:i:s'),
        ];

        $this->Mod->update2('wwc_kriteria', array('id_kriteria' => $id), $data);

        echo json_encode(['status' => '200', 'msg' => 'Kriteria berhasil diupdate.']);
    }

    // Soft delete (AJAX)
    public function Delete($id = null)
    {
        if (empty($id)) {
            echo json_encode(['status' => '400', 'msg' => 'ID tidak valid.']);
            return;
        }

        // Cek apakah ada indikator aktif yang menggunakan kriteria ini
        $cek = $this->Mod->GetCustome("
            SELECT id_indikator FROM wwc_indikator 
            WHERE id_kriteria = " . (int)$id . " AND status != 8
        ")->num_rows();

        if ($cek > 0) {
            echo json_encode(['status' => '400', 'msg' => 'Kriteria tidak dapat dihapus karena masih memiliki indikator aktif.']);
            return;
        }

        $this->Mod->update2('wwc_kriteria', array('id_kriteria' => $id), ['status' => 8, 'updated_at' => date('Y-m-d H:i:s')]);

        echo json_encode(['status' => '200', 'msg' => 'Kriteria berhasil dihapus.']);
    }

    // Toggle status aktif/nonaktif (AJAX)
    public function ToggleStatus($id = null)
    {
        if (empty($id)) {
            echo json_encode(['status' => '400', 'msg' => 'ID tidak valid.']);
            return;
        }

        $current = $this->Mod->getWhere('wwc_kriteria', array('id_kriteria' => $id))->row_array();
        if (empty($current)) {
            echo json_encode(['status' => '400', 'msg' => 'Data tidak ditemukan.']);
            return;
        }

        $new_status = ($current['status'] == 0) ? 1 : 0;
        $label      = ($new_status == 0) ? 'Aktif' : 'Nonaktif';

        $this->Mod->update2('wwc_kriteria', array('id_kriteria' => $id), ['status' => $new_status, 'updated_at' => date('Y-m-d H:i:s')]);

        echo json_encode(['status' => '200', 'msg' => 'Status berhasil diubah menjadi ' . $label . '.']);
    }
}