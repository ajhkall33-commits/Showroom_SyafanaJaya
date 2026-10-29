<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wwc_penilaian extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    // Daftar penugasan untuk assessor yang login
    public function index()
    {
        $data["plugin"][]  = "plugin/datatable";
        $data["title"]     = "Penilaian Wawancara";
        $data["title_des"] = "Daftar form penilaian yang ditugaskan kepada Anda";
        $data["content"]   = "v_index";
        $this->load->view('template_v2', $data);
    }

    // Load daftar penugasan milik assessor yang login (AJAX)
    public function LoadData()
    {
        $id_user = sess()['id'];

        $data = $this->Mod->GetCustome("
            SELECT fa.id_form_assessor, fa.id_form, fa.urutan, fa.assigned_at,
                   fp.kode_form, fp.nama_form, fp.tanggal_penilaian, fp.lokasi, fp.status as status_form,
                   fp.id_unit, fp.id_role,
                   un.name_unit, r.name_role,
                   (SELECT COUNT(*) FROM wwc_penilaian p WHERE p.id_form_assessor = fa.id_form_assessor AND p.status = 1) as total_peserta_dinilai,
                   (SELECT CASE 
                       WHEN (SELECT COUNT(*) FROM wwc_form_assessor_peserta fap WHERE fap.id_form_assessor = fa.id_form_assessor) > 0 
                       THEN (SELECT COUNT(*) FROM wwc_form_assessor_peserta fap WHERE fap.id_form_assessor = fa.id_form_assessor)
                       ELSE (SELECT COUNT(*) FROM user u WHERE (u.unit_kerja = fp.id_unit OR fp.id_unit IS NULL) AND (u.type_user = fp.id_role OR fp.id_role IS NULL) AND u.status = 1)
                   END) as total_peserta_target
            FROM wwc_form_assessor fa
            JOIN wwc_form_penilaian fp ON fa.id_form = fp.id_form
            LEFT JOIN unit un ON fp.id_unit = un.id_unit
            LEFT JOIN role r ON fp.id_role = r.id
            WHERE fa.id_user = " . (int)$id_user . "
            AND fa.status != 8
            AND fp.status != 8
            ORDER BY fp.tanggal_penilaian DESC, fa.id_form_assessor DESC
        ")->result_array();

        echo json_encode($data);
    }

    // Halaman form penilaian (per assessor)
    public function FormPenilaian($id_form_assessor = null, $id_peserta = null)
    {
        if (empty($id_form_assessor)) { redirect('wwc_penilaian'); return; }

        $id_user = sess()['id'];

        // Validasi penugasan milik user yang login
        $penugasan = $this->Mod->GetCustome("
            SELECT fa.*, fp.kode_form, fp.nama_form, fp.tanggal_penilaian, fp.lokasi, fp.catatan, fp.status as status_form,
                   fp.id_unit, fp.id_role, un.name_unit, r.name_role
            FROM wwc_form_assessor fa
            JOIN wwc_form_penilaian fp ON fa.id_form = fp.id_form
            LEFT JOIN unit un ON fp.id_unit = un.id_unit
            LEFT JOIN role r ON fp.id_role = r.id
            WHERE fa.id_form_assessor = " . (int)$id_form_assessor . "
            AND fa.id_user = " . (int)$id_user . "
            AND fa.status != 8
        ")->row_array();

        if (empty($penugasan)) { redirect('wwc_penilaian'); return; }

        $where_unit = !empty($penugasan['id_unit']) ? " AND u.unit_kerja = " . (int)$penugasan['id_unit'] : "";
        $where_role = !empty($penugasan['id_role']) ? " AND u.type_user = " . (int)$penugasan['id_role'] : "";

        // Cek apakah ada peserta khusus yang ditugaskan ke assessor ini
        $has_khusus = $this->Mod->GetCustome("
            SELECT 1 FROM wwc_form_assessor_peserta WHERE id_form_assessor = " . (int)$id_form_assessor . " LIMIT 1
        ")->num_rows();

        if ($has_khusus > 0) {
            $where_peserta = " AND u.id IN (SELECT id_peserta FROM wwc_form_assessor_peserta WHERE id_form_assessor = " . (int)$id_form_assessor . ")";
        } else {
            $where_peserta = $where_unit . $where_role;
        }

        $list_peserta = $this->Mod->GetCustome("
            SELECT u.id, u.nik, u.nama, u.jabatan,
                   (SELECT p.total_nilai FROM wwc_penilaian p WHERE p.id_form_assessor = " . (int)$id_form_assessor . " AND p.id_peserta = u.id LIMIT 1) as nilai_terisi,
                   (SELECT p.status FROM wwc_penilaian p WHERE p.id_form_assessor = " . (int)$id_form_assessor . " AND p.id_peserta = u.id LIMIT 1) as status_dinilai
            FROM user u
            WHERE u.status = 1
            $where_peserta
            ORDER BY u.nama ASC
        ")->result_array();

        if (empty($list_peserta)) {
            $list_peserta = $this->Mod->GetCustome("SELECT id, nik, nama, jabatan FROM user WHERE status = 1 ORDER BY nama ASC")->result_array();
        }

        // Tentukan peserta aktif
        if (empty($id_peserta) && !empty($list_peserta)) {
            $id_peserta = $list_peserta[0]['id'];
        }

        $peserta_aktif = $this->Mod->GetCustome("SELECT id, nik, nama, jabatan FROM user WHERE id = " . (int)$id_peserta)->row_array();

        // Load indikator dari form
        $indikator = $this->Mod->GetCustome("
            SELECT dff.id_detail_form, i.id_indikator, i.kode_indikator, i.nama_indikator,
                   i.bobot, i.nilai_min, i.nilai_max, i.deskripsi,
                   k.nama_kriteria, k.kode_kriteria, k.id_kriteria
            FROM wwc_detail_form_penilaian dff
            JOIN wwc_indikator i ON dff.id_indikator = i.id_indikator
            JOIN wwc_kriteria k ON i.id_kriteria = k.id_kriteria
            WHERE dff.id_form = " . (int)$penugasan['id_form'] . " AND dff.status != 8
            ORDER BY k.urutan ASC, dff.urutan ASC
        ")->result_array();

        // Load penilaian existing (jika sudah pernah diisi untuk peserta ini)
        $penilaian = $this->Mod->GetCustome("
            SELECT * FROM wwc_penilaian 
            WHERE id_form_assessor = " . (int)$id_form_assessor . " 
            AND (id_peserta = " . (int)$id_peserta . " OR (id_peserta IS NULL AND id_form = " . (int)$penugasan['id_form'] . "))
            LIMIT 1
        ")->row_array();

        $detail_penilaian = [];
        if (!empty($penilaian)) {
            $detail_raw = $this->Mod->GetCustome("
                SELECT * FROM wwc_detail_penilaian WHERE id_penilaian = " . (int)$penilaian['id_penilaian'] . "
            ")->result_array();
            foreach ($detail_raw as $dp) {
                $detail_penilaian[$dp['id_indikator']] = $dp;
            }
        }

        $data["plugin"][]  = "plugin/select2";
        $data["title"]     = "Form Penilaian Wawancara";
        $data["title_des"] = $penugasan['nama_form'];
        $data["content"]   = "v_form";
        $data['penugasan']       = $penugasan;
        $data['list_peserta']    = $list_peserta;
        $data['peserta_aktif']   = $peserta_aktif;
        $data['id_peserta']      = $id_peserta;
        $data['indikator']       = $indikator;
        $data['penilaian']       = $penilaian;
        $data['detail_penilaian'] = $detail_penilaian;
        $this->load->view('template_v2', $data);
    }

    // Simpan penilaian (AJAX + Transaksi DB + Hitung Otomatis)
    public function SavePenilaian()
    {
        $id_form_assessor = $this->input->post('id_form_assessor');
        $id_form          = $this->input->post('id_form');
        $id_peserta       = $this->input->post('id_peserta');
        $kesimpulan       = $this->input->post('kesimpulan');
        $rekomendasi      = $this->input->post('rekomendasi');
        $nilai_arr        = $this->input->post('nilai');     // array: [id_indikator => nilai]
        $catatan_arr      = $this->input->post('catatan_ind'); // array: [id_indikator => catatan]

        if (empty($id_form_assessor) || empty($id_form) || empty($id_peserta)) {
            echo json_encode(['status' => '400', 'msg' => 'Data tidak valid atau Peserta belum dipilih.']); return;
        }

        // Validasi penugasan milik user yang login
        $id_user = sess()['id'];
        $penugasan = $this->Mod->GetCustome("
            SELECT * FROM wwc_form_assessor WHERE id_form_assessor = " . (int)$id_form_assessor . " AND id_user = " . (int)$id_user . " AND status != 8
        ")->row_array();
        if (empty($penugasan)) {
            echo json_encode(['status' => '400', 'msg' => 'Anda tidak berwenang melakukan penilaian ini.']); return;
        }

        // Ambil semua indikator form beserta bobot dan nilai_max
        $indikator = $this->Mod->GetCustome("
            SELECT i.id_indikator, i.bobot, i.nilai_max
            FROM wwc_detail_form_penilaian dff
            JOIN wwc_indikator i ON dff.id_indikator = i.id_indikator
            WHERE dff.id_form = " . (int)$id_form . " AND dff.status != 8
        ")->result_array();

        // Hitung total nilai dan skor per indikator
        $total_nilai  = 0;
        $total_bobot  = 0;
        $detail_items = [];

        foreach ($indikator as $ind) {
            $id_ind    = $ind['id_indikator'];
            $nilai     = isset($nilai_arr[$id_ind]) ? (float)$nilai_arr[$id_ind] : 0;
            $nilai_max = (float)$ind['nilai_max'];
            $bobot     = (float)$ind['bobot'];
            $catatan   = isset($catatan_arr[$id_ind]) ? $catatan_arr[$id_ind] : '';

            // Rumus: (nilai / nilai_max) * bobot
            $skor = ($nilai_max > 0) ? round(($nilai / $nilai_max) * $bobot, 2) : 0;

            $total_nilai += $skor;
            $total_bobot += $bobot;
            $detail_items[] = [
                'id_indikator' => $id_ind,
                'nilai'        => $nilai,
                'skor'         => $skor,
                'catatan'      => $catatan,
            ];
        }

        $persentase  = ($total_bobot > 0) ? round(($total_nilai / $total_bobot) * 100, 2) : 0;
        $total_nilai = $persentase;

        $this->db->trans_begin();
        try {
            // Cek apakah header penilaian sudah ada untuk peserta ini
            $existing = $this->Mod->GetCustome("
                SELECT id_penilaian FROM wwc_penilaian 
                WHERE id_form_assessor = " . (int)$id_form_assessor . " 
                AND (id_peserta = " . (int)$id_peserta . " OR id_peserta IS NULL)
                LIMIT 1
            ")->row_array();

            if ($existing) {
                // Update header
                $this->Mod->update2('wwc_penilaian', array('id_penilaian' => $existing['id_penilaian']), [
                    'id_peserta'      => (int)$id_peserta,
                    'total_nilai'     => $total_nilai,
                    'persentase'      => $persentase,
                    'kesimpulan'      => $kesimpulan,
                    'rekomendasi'     => $rekomendasi,
                    'tanggal_selesai' => date('Y-m-d H:i:s'),
                    'status'          => 1,
                    'updated_at'      => date('Y-m-d H:i:s'),
                ]);
                $id_penilaian = $existing['id_penilaian'];

                // Hapus detail lama & re-insert
                $this->db->where('id_penilaian', $id_penilaian)->delete('wwc_detail_penilaian');
            } else {
                // Insert header baru
                $this->db->insert('wwc_penilaian', [
                    'id_form'         => (int)$id_form,
                    'id_form_assessor' => (int)$id_form_assessor,
                    'id_peserta'      => (int)$id_peserta,
                    'tanggal_mulai'   => date('Y-m-d H:i:s'),
                    'tanggal_selesai' => date('Y-m-d H:i:s'),
                    'total_nilai'     => $total_nilai,
                    'persentase'      => $persentase,
                    'kesimpulan'      => $kesimpulan,
                    'rekomendasi'     => $rekomendasi,
                    'status'          => 1,
                    'created_at'      => date('Y-m-d H:i:s'),
                    'updated_at'      => date('Y-m-d H:i:s'),
                ]);
                $id_penilaian = $this->db->insert_id();
            }

            // Insert detail penilaian
            foreach ($detail_items as $di) {
                $this->db->insert('wwc_detail_penilaian', [
                    'id_penilaian' => $id_penilaian,
                    'id_indikator' => $di['id_indikator'],
                    'nilai'        => $di['nilai'],
                    'skor'         => $di['skor'],
                    'catatan'      => $di['catatan'],
                ]);
            }

            // Cek apakah semua assessor sudah selesai
            $total_assessor = $this->Mod->GetCustome("
                SELECT COUNT(*) as total FROM wwc_form_assessor WHERE id_form = " . (int)$id_form . " AND status != 8
            ")->row_array();
            $selesai = $this->Mod->GetCustome("
                SELECT COUNT(*) as total FROM wwc_penilaian WHERE id_form = " . (int)$id_form . "
            ")->row_array();

            if ((int)$selesai['total'] >= (int)$total_assessor['total'] && (int)$total_assessor['total'] > 0) {
                // Semua assessor selesai → update status form menjadi Completed
                $this->Mod->update2('wwc_form_penilaian', array('id_form' => $id_form), ['status' => 2, 'updated_at' => date('Y-m-d H:i:s')]);
            }

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                echo json_encode(['status' => '400', 'msg' => 'Gagal menyimpan penilaian.']);
            } else {
                $this->db->trans_commit();
                echo json_encode(['status' => '200', 'msg' => 'Penilaian berhasil disimpan. Total Nilai: ' . $total_nilai . ' (' . $persentase . '%)']);
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo json_encode(['status' => '400', 'msg' => 'Error: ' . $e->getMessage()]);
        }
    }
}
