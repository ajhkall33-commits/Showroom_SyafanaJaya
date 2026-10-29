<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cbt_hasil extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("m_data");
    }

    // =========================================================
    // INDEX
    // =========================================================
    public function index()
    {
        $data["plugin"][]  = "plugin/datatable";
        $data["plugin"][]  = "plugin/select2";
        $data["title"]     = "Hasil Ujian CBT";
        $data["title_des"] = "Rekap Hasil & Review Jawaban Peserta";
        $data["content"]   = "v_index";

        $data['ujian_list'] = $this->Mod->getWhere('cbt_ujian', ['status !=' => 8])->result_array();
        $data['unit_list']  = $this->Mod->getWhere('unit', ['status !=' => 8])->result_array();

        $this->load->view('template_v2', $data);
    }

    // =========================================================
    // LOAD DATA — Daftar semua hasil ujian dengan filter
    // =========================================================
    function LoadData()
    {
        $id_ujian = $this->input->post('id_ujian');
        $id_unit  = $this->input->post('id_unit');

        $whereUjian = "";
        if (!empty($id_ujian)) {
            $whereUjian .= " AND h.id_ujian_cbt = " . (int)$id_ujian;
        }
        
        // Asumsi data ujian terikat pada unit dari tabel cbt_ujian (u.id_unit)
        if (!empty($id_unit)) {
            $whereUjian .= " AND u.id_unit = " . (int)$id_unit;
        }

        $data = $this->Mod->GetCustome("
            SELECT h.*,
                   u.nama_ujian_cbt, u.durasi_menit, u.jumlah_soal,
                   usr.nama AS nama_peserta, usr.nik,
                   un.name_unit, r.name_role AS jabatan,
                   r_ujian.name_role AS role_ujian
            FROM cbt_hasil_ujian h
            LEFT JOIN cbt_ujian u ON u.id_ujian_cbt = h.id_ujian_cbt
            LEFT JOIN user usr ON usr.id = h.id_user
            LEFT JOIN role r ON r.id = usr.type_user
            LEFT JOIN unit un ON un.id_unit = u.id_unit
            LEFT JOIN role r_ujian ON r_ujian.id = u.id_role
            WHERE h.status = 1
            $whereUjian
            ORDER BY h.nilai DESC, h.id_hasil_ujian_cbt DESC
        ")->result_array();

        echo json_encode($data);
    }

    // =========================================================
    // LOAD UJIAN LIST — Untuk filter dropdown
    // =========================================================
    function LoadUjianList()
    {
        $data = $this->Mod->GetCustome("
            SELECT id_ujian_cbt, nama_ujian_cbt FROM cbt_ujian WHERE status != 8 ORDER BY id_ujian_cbt DESC
        ")->result_array();
        echo json_encode($data);
    }

    // =========================================================
    // DETAIL HASIL — Ambil jawaban peserta per soal (review)
    // =========================================================
    function DetailHasil($id_hasil = null)
    {
        if (empty($id_hasil)) {
            echo json_encode(['status' => '400', 'msg' => 'ID tidak valid']);
            return;
        }

        $hasil = $this->Mod->getWhere('cbt_hasil_ujian', ['id_hasil_ujian_cbt' => $id_hasil])->row_array();
        if (!$hasil) {
            echo json_encode(['status' => '404', 'msg' => 'Data tidak ditemukan']);
            return;
        }

        // Ambil detail jawaban + soal (pertanyaan, opsi, kunci)
        $detail = $this->Mod->GetCustome("
            SELECT d.*,
                   b.pertanyaan, b.opsi_a, b.opsi_b, b.opsi_c, b.opsi_d, b.jawaban AS kunci, b.bobot
            FROM cbt_detail_hasil_ujian d
            LEFT JOIN cbt_bank_soal b ON b.id_bank_soal_cbt = d.id_bank_soal_cbt
            WHERE d.id_hasil_ujian_cbt = $id_hasil
            ORDER BY d.id_detail_hasil_ujian_cbt ASC
        ")->result_array();

        // Info peserta
        $peserta = $this->Mod->getWhere('user', ['id' => $hasil['id_user']])->row_array();
        $ujian   = $this->Mod->getWhere('cbt_ujian', ['id_ujian_cbt' => $hasil['id_ujian_cbt']])->row_array();

        echo json_encode([
            'status'  => '200',
            'hasil'   => $hasil,
            'peserta' => $peserta,
            'ujian'   => $ujian,
            'detail'  => $detail,
        ]);
    }

    // =========================================================
    // STATISTIK UJIAN — Nilai rata, max, min, distribusi
    // =========================================================
    function StatistikUjian()
    {
        $id_ujian = $this->input->post('id_ujian');
        $id_unit  = $this->input->post('id_unit');

        $whereUjian = "";
        $joinUjian = "";
        
        if (!empty($id_ujian)) {
            $whereUjian .= " AND h.id_ujian_cbt = " . (int)$id_ujian;
        }
        if (!empty($id_unit)) {
            $joinUjian = "LEFT JOIN cbt_ujian u ON u.id_ujian_cbt = h.id_ujian_cbt";
            $whereUjian .= " AND u.id_unit = " . (int)$id_unit;
        }

        $stat = $this->Mod->GetCustome("
            SELECT
                COUNT(h.id_hasil_ujian_cbt) AS jumlah_peserta,
                IFNULL(ROUND(AVG(h.nilai), 2), 0) AS rata_rata,
                IFNULL(MAX(h.nilai), 0) AS tertinggi,
                IFNULL(MIN(h.nilai), 0) AS terendah,
                SUM(CASE WHEN h.nilai >= 75 THEN 1 ELSE 0 END) AS jumlah_lulus,
                SUM(CASE WHEN h.nilai < 75 THEN 1 ELSE 0 END)  AS jumlah_tidak_lulus
            FROM cbt_hasil_ujian h
            $joinUjian
            WHERE h.status = 1 $whereUjian
        ")->row_array();

        echo json_encode(['status' => '200', 'stat' => $stat]);
    }

    // =========================================================
    // SMART PROCTORING — Detail Monitoring
    // =========================================================
    public function DetailMonitoring($id_ujian = null, $id_user = null)
    {
        if (empty($id_ujian) || empty($id_user)) {
            echo json_encode(['status' => '400', 'msg' => 'ID tidak valid']);
            return;
        }

        // Ambil data proses ujian
        $proses = $this->Mod->getWhere('cbt_proses_ujian', [
            'id_ujian_cbt' => $id_ujian,
            'id_user'      => $id_user
        ])->row_array();

        if (!$proses) {
            echo json_encode(['status' => '404', 'msg' => 'Data monitoring tidak ditemukan']);
            return;
        }

        $id_proses = $proses['id_proses_ujian_cbt'];

        // Ambil rekap (group by jenis)
        $rekap = $this->Mod->GetCustome("
            SELECT jenis, COUNT(*) as jumlah
            FROM cbt_log_monitoring
            WHERE id_proses_ujian_cbt = $id_proses
            GROUP BY jenis
        ")->result_array();

        // Ambil timeline log
        $logs = $this->Mod->GetCustome("
            SELECT *
            FROM cbt_log_monitoring
            WHERE id_proses_ujian_cbt = $id_proses
            ORDER BY created_at ASC
        ")->result_array();

        echo json_encode([
            'status' => '200',
            'proses' => $proses,
            'rekap'  => $rekap,
            'logs'   => $logs
        ]);
    }

    // =========================================================
    // CETAK LAPORAN NATIVE HTML (PRINT TO PDF)
    // =========================================================
    public function CetakLaporan()
    {
        $id_ujian = $this->input->get('id_ujian');
        $id_unit  = $this->input->get('id_unit');
        $id_hasil = $this->input->get('id_hasil');

        $where = "h.status = 1";
        if (!empty($id_hasil)) {
            $where .= " AND h.id_hasil_ujian_cbt = " . (int)$id_hasil;
        } else {
            if (!empty($id_ujian)) {
                $where .= " AND h.id_ujian_cbt = " . (int)$id_ujian;
            }
            if (!empty($id_unit)) {
                $where .= " AND u.id_unit = " . (int)$id_unit;
            }
        }

        $hasil_list = $this->Mod->GetCustome("
            SELECT h.*,
                   u.nama_ujian_cbt, u.durasi_menit, u.jumlah_soal,
                   usr.nama AS nama_peserta, usr.nik,
                   p.id_proses_ujian_cbt, p.foto_awal,
                   un.name_unit, r.name_role AS jabatan,
                   r_ujian.name_role AS role_ujian
            FROM cbt_hasil_ujian h
            LEFT JOIN cbt_ujian u ON u.id_ujian_cbt = h.id_ujian_cbt
            LEFT JOIN user usr ON usr.id = h.id_user
            LEFT JOIN cbt_proses_ujian p ON p.id_ujian_cbt = h.id_ujian_cbt AND p.id_user = h.id_user
            LEFT JOIN role r ON r.id = usr.type_user
            LEFT JOIN unit un ON un.id_unit = u.id_unit
            LEFT JOIN role r_ujian ON r_ujian.id = u.id_role
            WHERE $where
            ORDER BY h.nilai DESC, h.id_hasil_ujian_cbt DESC
        ")->result_array();

        foreach ($hasil_list as &$h) {
            $h['pelanggaran'] = [];
            if (!empty($h['id_proses_ujian_cbt'])) {
                $h['pelanggaran'] = $this->Mod->GetCustome("
                    SELECT * FROM cbt_log_monitoring 
                    WHERE id_proses_ujian_cbt = " . $h['id_proses_ujian_cbt'] . "
                    ORDER BY created_at ASC
                ")->result_array();
            }

            // Ambil detail jawaban + soal
            $h['detail'] = $this->Mod->GetCustome("
                SELECT d.*, b.pertanyaan, b.opsi_a, b.opsi_b, b.opsi_c, b.opsi_d, b.jawaban AS kunci, b.bobot
                FROM cbt_detail_hasil_ujian d
                LEFT JOIN cbt_bank_soal b ON b.id_bank_soal_cbt = d.id_bank_soal_cbt
                WHERE d.id_hasil_ujian_cbt = " . (int)$h['id_hasil_ujian_cbt'] . "
                ORDER BY d.id_detail_hasil_ujian_cbt ASC
            ")->result_array();
        }

        $data['hasil_list'] = $hasil_list;
        $this->load->view('v_cetak_laporan', $data);
    }
}
