<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil_asesmen extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Hasil_asesmen_mod', 'Hasil_asesmen_MOD');
    }

    /**
     * Halaman Utama Rekap Hasil Asesmen
     */
    public function index() {
        $this->role();

        $data["plugin"][]  = "plugin/select2";
        $data["title"]     = "Hasil Seluruh Asesmen";
        $data["title_des"] = "Rekapitulasi Terpadu Hasil CBT, Wawancara, dan Presensi Karyawan";
        $data["content"]   = "v_index";

        $sess = sess();
        $is_super = (isset($sess['type_user']) && $sess['type_user'] == 'super') || 
                    (isset($sess['username']) && $sess['username'] == 'iassomcgk');

        // Ambil data unit
        if ($is_super) {
            $data['units'] = $this->db->get_where('unit', ['status !=' => 8])->result_array();
        } else {
            $user_unit = $sess['unit'] ?? 0;
            $data['units'] = $this->db->get_where('unit', ['id_unit' => $user_unit, 'status !=' => 8])->result_array();
        }

        $this->load->view('template_v2', $data);
    }

    /**
     * AJAX: Load data rekap asesmen personil
     */
    public function LoadData() {
        $start_date = $this->input->post('start_date');
        $end_date   = $this->input->post('end_date');
        $unit_id    = $this->input->post('unit_id');
        $search     = trim($this->input->post('search') ?? '');

        if (empty($start_date) || empty($end_date)) {
            echo json_encode([
                'status'  => false,
                'message' => 'Rentang Tanggal Presensi (Dari Tanggal & Sampai Tanggal) wajib diisi.',
                'data'    => []
            ]);
            return;
        }

        // Role restriction
        $sess = sess();
        $is_super = (isset($sess['type_user']) && $sess['type_user'] == 'super') || 
                    (isset($sess['username']) && $sess['username'] == 'iassomcgk');

        if (!$is_super && isset($sess['unit'])) {
            $unit_id = $sess['unit'];
        }

        $data = $this->Hasil_asesmen_MOD->get_rekap_asesmen($start_date, $end_date, $unit_id, $search);

        echo json_encode([
            'status' => true,
            'data'   => $data,
            'total'  => count($data)
        ]);
    }

    /**
     * AJAX: Load personil berdasarkan unit untuk autocomplete/dropdown
     */
    public function get_users_by_unit() {
        $unit_id = $this->input->post('unit_id');
        $this->db->select('id, nik, nama');
        $this->db->from('user');
        $this->db->where('status !=', 8);

        if (!empty($unit_id)) {
            $this->db->where('unit_kerja', (int)$unit_id);
        }

        $this->db->order_by('nama', 'ASC');
        $users = $this->db->get()->result_array();

        echo json_encode([
            'status' => true,
            'data'   => $users
        ]);
    }

    /**
     * Cetak PDF Komprehensif Laporan Hasil Asesmen Per Personil
     */
    public function cetak_pdf() {
        $this->role();

        $user_id    = $this->input->get('user_id');
        $start_date = $this->input->get('start_date');
        $end_date   = $this->input->get('end_date');

        if (empty($user_id)) {
            show_error('Parameter personil (user_id) tidak valid.', 400);
            return;
        }

        if (empty($start_date) || empty($end_date)) {
            // Default periode bulan berjalan jika tidak terisi
            $start_date = date('Y-m-01');
            $end_date   = date('Y-m-d');
        }

        $data = $this->Hasil_asesmen_MOD->get_detail_asesmen_personil($user_id, $start_date, $end_date);

        if (empty($data) || empty($data['peserta'])) {
            show_error('Data personil atau hasil asesmen tidak ditemukan.', 404);
            return;
        }

        $data['title'] = 'Laporan Hasil Asesmen Karyawan - ' . ($data['peserta']['nama_peserta'] ?? '');

        $this->load->view('v_cetak_pdf', $data);
    }

    /**
     * Cek otentikasi login
     */
    private function role() {
        if (!sess()) {
            redirect('login');
        }
    }
}
