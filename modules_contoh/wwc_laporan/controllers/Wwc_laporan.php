<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wwc_laporan extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    // Daftar semua form yang sudah Completed
    public function index()
    {
        $data["plugin"][]  = "plugin/datatable";
        $data["title"]     = "Laporan Wawancara Kompetensi";
        $data["title_des"] = "Rekap dan laporan hasil penilaian wawancara kompetensi";
        $data["content"]   = "v_index";

        $data['list_unit'] = $this->Mod->getWhere('unit', array('status !=' => 8))->result_array();

        $this->load->view('template_v2', $data);
    }

    // Load data laporan (AJAX) - support filter
    public function LoadData()
    {
        $id_unit     = $this->input->post('id_unit');
        $tgl_dari    = $this->input->post('tgl_dari');
        $tgl_sampai  = $this->input->post('tgl_sampai');

        $where_unit    = !empty($id_unit)    ? " AND fp.id_unit = " . (int)$id_unit . "" : "";
        $where_dari    = !empty($tgl_dari)   ? " AND fp.tanggal_penilaian >= '" . $this->db->escape_str($tgl_dari) . "'" : "";
        $where_sampai  = !empty($tgl_sampai) ? " AND fp.tanggal_penilaian <= '" . $this->db->escape_str($tgl_sampai) . "'" : "";

        $data = $this->Mod->GetCustome("
            SELECT fp.id_form, fp.kode_form, fp.nama_form, fp.tanggal_penilaian, fp.status,
                   u.nama as nama_peserta, u.nik,
                   un.name_unit, r.name_role,
                   COUNT(DISTINCT fa.id_form_assessor) as jumlah_assessor,
                   COUNT(DISTINCT p.id_penilaian) as jumlah_penilaian,
                   ROUND(AVG(p.total_nilai), 2) as rata_nilai,
                   ROUND(AVG(p.persentase), 2) as rata_persentase,
                   MAX(p.tanggal_selesai) as selesai_at
            FROM wwc_form_penilaian fp
            LEFT JOIN wwc_penilaian p ON p.id_form = fp.id_form
            LEFT JOIN user u ON u.id = COALESCE(p.id_peserta, fp.id_peserta)
            LEFT JOIN unit un ON un.id_unit = COALESCE(NULLIF(fp.id_unit, 0), u.unit_kerja)
            LEFT JOIN role r ON r.id = COALESCE(NULLIF(fp.id_role, 0), u.type_user)
            LEFT JOIN wwc_form_assessor fa ON fa.id_form = fp.id_form AND fa.status != 8
            WHERE fp.status != 8
            $where_unit $where_dari $where_sampai
            GROUP BY fp.id_form, COALESCE(p.id_peserta, fp.id_peserta)
            ORDER BY fp.tanggal_penilaian DESC, fp.id_form DESC
        ")->result_array();

        echo json_encode($data);
    }

    // Halaman detail laporan per form (rekap semua assessor per peserta)
    public function Detail($id_form = null, $id_peserta = null)
    {
        if (empty($id_form)) { redirect('wwc_laporan'); return; }
        if (empty($id_peserta)) { $id_peserta = $this->input->get('id_peserta'); }

        $data["title"]     = "Detail Laporan Wawancara";
        $data["title_des"] = "Rekap hasil penilaian seluruh assessor";
        $data["content"]   = "v_detail";

        $data['form'] = $this->Mod->GetCustome("
            SELECT fp.*, un.name_unit, r.name_role
            FROM wwc_form_penilaian fp
            LEFT JOIN unit un ON un.id_unit = fp.id_unit
            LEFT JOIN role r ON r.id = fp.id_role
            WHERE fp.id_form = " . (int)$id_form . "
        ")->row_array();

        if (empty($data['form'])) { redirect('wwc_laporan'); return; }

        // Daftar peserta yang sudah dinilai pada form ini
        $list_peserta = $this->Mod->GetCustome("
            SELECT DISTINCT u.id, u.nik, u.nama, COALESCE(NULLIF(u.jabatan, ''), r.name_role, '-') as jabatan,
                   (SELECT ROUND(AVG(p2.total_nilai), 2) FROM wwc_penilaian p2 WHERE p2.id_form = fp.id_form AND (p2.id_peserta = u.id OR (p2.id_peserta IS NULL AND fp.id_peserta = u.id))) as avg_nilai,
                   (SELECT COUNT(p3.id_penilaian) FROM wwc_penilaian p3 WHERE p3.id_form = fp.id_form AND (p3.id_peserta = u.id OR (p3.id_peserta IS NULL AND fp.id_peserta = u.id))) as jml_assessor
            FROM wwc_penilaian p
            JOIN wwc_form_penilaian fp ON p.id_form = fp.id_form
            JOIN user u ON u.id = COALESCE(p.id_peserta, fp.id_peserta)
            LEFT JOIN role r ON u.type_user = r.id
            WHERE p.id_form = " . (int)$id_form . "
            ORDER BY u.nama ASC
        ")->result_array();

        // Fallback jika belum ada penilaian, ambil peserta dari unit & role form
        if (empty($list_peserta)) {
            $where_unit = !empty($data['form']['id_unit']) ? " AND u.unit_kerja = " . (int)$data['form']['id_unit'] : "";
            $where_role = !empty($data['form']['id_role']) ? " AND u.type_user = " . (int)$data['form']['id_role'] : "";
            $list_peserta = $this->Mod->GetCustome("
                SELECT u.id, u.nik, u.nama, COALESCE(NULLIF(u.jabatan, ''), r.name_role, '-') as jabatan, 0 as avg_nilai, 0 as jml_assessor
                FROM user u
                LEFT JOIN role r ON u.type_user = r.id
                WHERE u.status = 1 $where_unit $where_role
                ORDER BY u.nama ASC
            ")->result_array();
        }

        $data['list_peserta'] = $list_peserta;

        // Tentukan peserta terpilih
        if (empty($id_peserta) && !empty($list_peserta)) {
            $id_peserta = $list_peserta[0]['id'];
        }

        $peserta_aktif = null;
        if (!empty($id_peserta)) {
            $peserta_aktif = $this->Mod->GetCustome("
                SELECT u.id, u.nik, u.nama, COALESCE(NULLIF(u.jabatan, ''), r.name_role, '-') as jabatan
                FROM user u
                LEFT JOIN role r ON u.type_user = r.id
                WHERE u.id = " . (int)$id_peserta
            )->row_array();
        }
        $data['peserta_aktif'] = $peserta_aktif;
        $data['id_peserta_aktif'] = $id_peserta;

        // Populate for legacy views
        $data['form']['nama_peserta'] = !empty($peserta_aktif['nama']) ? $peserta_aktif['nama'] : '-';
        $data['form']['nik']          = !empty($peserta_aktif['nik']) ? $peserta_aktif['nik'] : '-';
        $data['form']['jabatan']      = (!empty($peserta_aktif['jabatan']) && $peserta_aktif['jabatan'] != '-') ? $peserta_aktif['jabatan'] : ($data['form']['name_role'] ?? '-');

        $where_p = !empty($id_peserta) ? " AND (p.id_peserta = " . (int)$id_peserta . " OR p.id_peserta IS NULL)" : "";

        // Penilaian tiap assessor untuk peserta ini
        $data['penilaian_list'] = $this->Mod->GetCustome("
            SELECT p.id_penilaian, p.id_form_assessor, p.total_nilai, p.persentase,
                   p.kesimpulan, p.rekomendasi, p.tanggal_selesai,
                   u.nama as nama_assessor, u.nik as nik_assessor, u.jabatan as jabatan_assessor, fa.urutan
            FROM wwc_penilaian p
            JOIN wwc_form_assessor fa ON p.id_form_assessor = fa.id_form_assessor
            JOIN user u ON fa.id_user = u.id
            WHERE p.id_form = " . (int)$id_form . " $where_p
            ORDER BY fa.urutan ASC
        ")->result_array();

        // Rekap per indikator (rata-rata dari semua assessor untuk peserta ini)
        $data['rekap_indikator'] = $this->Mod->GetCustome("
            SELECT i.id_indikator, i.kode_indikator, i.nama_indikator, i.bobot, i.nilai_min, i.nilai_max,
                   k.nama_kriteria, k.kode_kriteria,
                   ROUND(AVG(dp.nilai), 2) as avg_nilai,
                   ROUND(AVG(dp.skor), 2) as avg_skor,
                   MIN(dp.nilai) as min_nilai,
                   MAX(dp.nilai) as max_nilai
            FROM wwc_detail_form_penilaian dff
            JOIN wwc_indikator i ON dff.id_indikator = i.id_indikator
            JOIN wwc_kriteria k ON i.id_kriteria = k.id_kriteria
            LEFT JOIN wwc_detail_penilaian dp ON dp.id_indikator = i.id_indikator
                AND dp.id_penilaian IN (SELECT id_penilaian FROM wwc_penilaian p WHERE p.id_form = " . (int)$id_form . " $where_p)
            WHERE dff.id_form = " . (int)$id_form . " AND dff.status != 8
            GROUP BY i.id_indikator
            ORDER BY k.urutan ASC, dff.urutan ASC
        ")->result_array();

        // Agregat total untuk peserta ini
        $data['summary'] = $this->Mod->GetCustome("
            SELECT ROUND(AVG(total_nilai), 2) as avg_total, ROUND(AVG(persentase), 2) as avg_persentase,
                   MIN(total_nilai) as min_total, MAX(total_nilai) as max_total,
                   COUNT(*) as jumlah_assessor
            FROM wwc_penilaian p
            WHERE p.id_form = " . (int)$id_form . " $where_p
        ")->row_array();

        $this->load->view('template_v2', $data);
    }

    // Export Excel sederhana (via CSV)
    public function Export($id_form = null, $id_peserta = null)
    {
        if (empty($id_form)) { redirect('wwc_laporan'); return; }
        if (empty($id_peserta)) { $id_peserta = $this->input->get('id_peserta'); }

        $form = $this->Mod->GetCustome("
            SELECT fp.*, un.name_unit, r.name_role
            FROM wwc_form_penilaian fp
            LEFT JOIN unit un ON un.id_unit = fp.id_unit
            LEFT JOIN role r ON r.id = fp.id_role
            WHERE fp.id_form = " . (int)$id_form . "
        ")->row_array();

        if (empty($id_peserta)) {
            $first_p = $this->Mod->GetCustome("SELECT id_peserta FROM wwc_penilaian WHERE id_form = " . (int)$id_form . " AND id_peserta IS NOT NULL LIMIT 1")->row_array();
            $id_peserta = $first_p['id_peserta'] ?? null;
        }

        $peserta = null;
        if (!empty($id_peserta)) {
            $peserta = $this->Mod->GetCustome("SELECT id, nik, nama, jabatan FROM user WHERE id = " . (int)$id_peserta)->row_array();
        }

        $where_p = !empty($id_peserta) ? " AND (p.id_peserta = " . (int)$id_peserta . " OR p.id_peserta IS NULL)" : "";

        $rows = $this->Mod->GetCustome("
            SELECT u.nama as nama_assessor, u.nik as nik_assessor,
                   i.kode_indikator, i.nama_indikator, i.bobot,
                   dp.nilai, dp.skor, dp.catatan,
                   p.total_nilai, p.persentase, p.kesimpulan, p.rekomendasi
            FROM wwc_penilaian p
            JOIN wwc_form_assessor fa ON p.id_form_assessor = fa.id_form_assessor
            JOIN user u ON fa.id_user = u.id
            JOIN wwc_detail_penilaian dp ON dp.id_penilaian = p.id_penilaian
            JOIN wwc_indikator i ON dp.id_indikator = i.id_indikator
            WHERE p.id_form = " . (int)$id_form . " $where_p
            ORDER BY fa.urutan ASC, i.id_indikator ASC
        ")->result_array();

        $filename = 'laporan_wwc_' . ($form['kode_form'] ?? 'export') . '_' . date('Ymd') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8

        // Header CSV
        fputcsv($out, ['Laporan Wawancara Kompetensi'], ';');
        fputcsv($out, ['Kode Form', $form['kode_form']], ';');
        fputcsv($out, ['Nama Form', $form['nama_form']], ';');
        fputcsv($out, ['Peserta', ($peserta['nama'] ?? '-') . ' (' . ($peserta['nik'] ?? '-') . ')'], ';');
        fputcsv($out, ['Unit', $form['name_unit']], ';');
        fputcsv($out, ['Jabatan', $peserta['jabatan'] ?? ($form['name_role'] ?? '-')], ';');
        fputcsv($out, ['Tanggal', $form['tanggal_penilaian']], ';');
        fputcsv($out, [''], ';');
        fputcsv($out, ['Nama Assessor', 'NIK', 'Kode Indikator', 'Nama Indikator', 'Bobot', 'Nilai', 'Skor', 'Catatan', 'Total Nilai', 'Persentase (%)', 'Kesimpulan', 'Rekomendasi'], ';');

        foreach ($rows as $row) {
            fputcsv($out, [
                $row['nama_assessor'], $row['nik_assessor'],
                $row['kode_indikator'], $row['nama_indikator'], $row['bobot'],
                $row['nilai'], $row['skor'], $row['catatan'],
                $row['total_nilai'], $row['persentase'], $row['kesimpulan'], $row['rekomendasi']
            ], ';');
        }

        fclose($out);
        exit();
    }

    // Tandai form sebagai Selesai (AJAX)
    public function Complete($id = null)
    {
        if (empty($id)) { echo json_encode(['status' => '400', 'msg' => 'ID tidak valid.']); return; }

        $form = $this->Mod->getWhere('wwc_form_penilaian', array('id_form' => $id))->row_array();
        if (empty($form)) { echo json_encode(['status' => '400', 'msg' => 'Form tidak ditemukan.']); return; }
        if ($form['status'] == 2) { echo json_encode(['status' => '400', 'msg' => 'Form sudah berstatus Selesai.']); return; }
        if ($form['status'] == 0) { echo json_encode(['status' => '400', 'msg' => 'Form masih Draft, publish terlebih dahulu.']); return; }

        // Cek minimal ada 1 penilaian selesai
        $jumlah_penilaian = $this->Mod->GetCustome("SELECT COUNT(*) as total FROM wwc_penilaian WHERE id_form = " . (int)$id)->row_array();
        if ($jumlah_penilaian['total'] < 1) {
            echo json_encode(['status' => '400', 'msg' => 'Belum ada assessor yang menyelesaikan penilaian.']); return;
        }

        $this->Mod->update2('wwc_form_penilaian', array('id_form' => $id), ['status' => 2, 'updated_at' => date('Y-m-d H:i:s')]);
        echo json_encode(['status' => '200', 'msg' => 'Form berhasil ditandai sebagai Selesai.']);
    }

    // Tandai form kembali ke Berjalan (AJAX)
    public function Reopen($id = null)
    {
        if (empty($id)) { echo json_encode(['status' => '400', 'msg' => 'ID tidak valid.']); return; }

        $form = $this->Mod->getWhere('wwc_form_penilaian', array('id_form' => $id))->row_array();
        if (empty($form)) { echo json_encode(['status' => '400', 'msg' => 'Form tidak ditemukan.']); return; }
        if ($form['status'] != 2) { echo json_encode(['status' => '400', 'msg' => 'Form tidak berstatus Selesai.']); return; }

        $this->Mod->update2('wwc_form_penilaian', array('id_form' => $id), ['status' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
        echo json_encode(['status' => '200', 'msg' => 'Form berhasil dibuka kembali (Berjalan).']);
    }

    public function ExportAll()
    {
        $id_unit     = $this->input->get('id_unit');
        $tgl_dari    = $this->input->get('tgl_dari');
        $tgl_sampai  = $this->input->get('tgl_sampai');

        $where_unit    = !empty($id_unit)    ? " AND fp.id_unit = " . (int)$id_unit . "" : "";
        $where_dari    = !empty($tgl_dari)   ? " AND fp.tanggal_penilaian >= '" . $this->db->escape_str($tgl_dari) . "'" : "";
        $where_sampai  = !empty($tgl_sampai) ? " AND fp.tanggal_penilaian <= '" . $this->db->escape_str($tgl_sampai) . "'" : "";

        $data = $this->Mod->GetCustome("
            SELECT fp.id_form, fp.kode_form, fp.nama_form, fp.tanggal_penilaian, fp.status,
                   u.nama as nama_peserta, u.nik,
                   un.name_unit, r.name_role,
                   COUNT(DISTINCT fa.id_form_assessor) as jumlah_assessor,
                   COUNT(DISTINCT p.id_penilaian) as jumlah_penilaian,
                   ROUND(AVG(p.total_nilai), 2) as rata_nilai,
                   ROUND(AVG(p.persentase), 2) as rata_persentase
            FROM wwc_form_penilaian fp
            LEFT JOIN wwc_penilaian p ON p.id_form = fp.id_form
            LEFT JOIN user u ON u.id = COALESCE(p.id_peserta, fp.id_peserta)
            LEFT JOIN unit un ON un.id_unit = COALESCE(NULLIF(fp.id_unit, 0), u.unit_kerja)
            LEFT JOIN role r ON r.id = COALESCE(NULLIF(fp.id_role, 0), u.type_user)
            LEFT JOIN wwc_form_assessor fa ON fa.id_form = fp.id_form AND fa.status != 8
            WHERE fp.status != 8
            $where_unit $where_dari $where_sampai
            GROUP BY fp.id_form, COALESCE(p.id_peserta, fp.id_peserta)
            ORDER BY fp.tanggal_penilaian DESC, fp.id_form DESC
        ")->result_array();

        $filename = 'laporan_wwc_all_' . date('Ymd_His') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8

        fputcsv($out, ['Laporan Wawancara Kompetensi - Rekapitulasi Keseluruhan'], ';');
        fputcsv($out, ['Filter Unit', !empty($id_unit) ? $id_unit : 'Semua Unit'], ';');
        fputcsv($out, ['Filter Periode', (!empty($tgl_dari) ? $tgl_dari : '-') . ' s/d ' . (!empty($tgl_sampai) ? $tgl_sampai : '-')], ';');
        fputcsv($out, [''], ';');

        fputcsv($out, ['No', 'Kode Form', 'Nama Form', 'Nama Peserta', 'NIK', 'Unit', 'Jabatan', 'Tanggal', 'Jml Penilaian', 'Rata Nilai', 'Rata %', 'Predikat'], ';');

        $no = 1;
        foreach ($data as $row) {
            $p = floatval($row['rata_persentase']);
            $pred = 'Perlu Dibina';
            if ($p >= 85) $pred = 'Istimewa';
            elseif ($p >= 70) $pred = 'Kompeten';
            elseif ($p >= 55) $pred = 'Cukup';

            fputcsv($out, [
                $no++,
                $row['kode_form'],
                $row['nama_form'],
                $row['nama_peserta'],
                $row['nik'],
                $row['name_unit'],
                $row['name_role'],
                $row['tanggal_penilaian'],
                $row['jumlah_penilaian'] . '/' . $row['jumlah_assessor'],
                $row['rata_nilai'],
                $p . '%',
                $pred
            ], ';');
        }

        fclose($out);
        exit();
    }

    // =============================================
    // CETAK PDF — Laporan Individu (per peserta)
    // =============================================
    public function CetakIndividu($id_form = null, $id_peserta = null)
    {
        if (empty($id_form)) { redirect('wwc_laporan'); return; }
        if (empty($id_peserta)) { $id_peserta = $this->input->get('id_peserta'); }

        $data['form'] = $this->Mod->GetCustome("
            SELECT fp.*, un.name_unit, r.name_role
            FROM wwc_form_penilaian fp
            LEFT JOIN unit un ON un.id_unit = fp.id_unit
            LEFT JOIN role r ON r.id = fp.id_role
            WHERE fp.id_form = " . (int)$id_form . "
        ")->row_array();

        if (empty($data['form'])) { redirect('wwc_laporan'); return; }

        if (empty($id_peserta)) {
            $first_p = $this->Mod->GetCustome("SELECT id_peserta FROM wwc_penilaian WHERE id_form = " . (int)$id_form . " AND id_peserta IS NOT NULL LIMIT 1")->row_array();
            $id_peserta = $first_p['id_peserta'] ?? null;
        }

        $peserta = null;
        if (!empty($id_peserta)) {
            $peserta = $this->Mod->GetCustome("
                SELECT u.id, u.nik, u.nama, COALESCE(NULLIF(u.jabatan, ''), r.name_role, '-') as jabatan
                FROM user u
                LEFT JOIN role r ON u.type_user = r.id
                WHERE u.id = " . (int)$id_peserta
            )->row_array();
        }
        $data['peserta'] = $peserta;
        $data['form']['nama_peserta'] = !empty($peserta['nama']) ? $peserta['nama'] : '-';
        $data['form']['nik']          = !empty($peserta['nik']) ? $peserta['nik'] : '-';
        $data['form']['jabatan']      = (!empty($peserta['jabatan']) && $peserta['jabatan'] != '-') ? $peserta['jabatan'] : ($data['form']['name_role'] ?? '-');

        $where_p = !empty($id_peserta) ? " AND (p.id_peserta = " . (int)$id_peserta . " OR p.id_peserta IS NULL)" : "";

        $data['penilaian_list'] = $this->Mod->GetCustome("
            SELECT p.id_penilaian, p.id_form_assessor, p.total_nilai, p.persentase,
                   p.kesimpulan, p.rekomendasi, p.tanggal_selesai,
                   u.nama as nama_assessor, u.nik as nik_assessor, u.jabatan as jabatan_assessor, fa.urutan
            FROM wwc_penilaian p
            JOIN wwc_form_assessor fa ON p.id_form_assessor = fa.id_form_assessor
            JOIN user u ON fa.id_user = u.id
            WHERE p.id_form = " . (int)$id_form . " $where_p
            ORDER BY fa.urutan ASC
        ")->result_array();

        $data['rekap_indikator'] = $this->Mod->GetCustome("
            SELECT i.id_indikator, i.kode_indikator, i.nama_indikator, i.bobot, i.nilai_min, i.nilai_max,
                   k.nama_kriteria, k.kode_kriteria,
                   ROUND(AVG(dp.nilai), 2) as avg_nilai,
                   ROUND(AVG(dp.skor), 2) as avg_skor,
                   MIN(dp.nilai) as min_nilai, MAX(dp.nilai) as max_nilai
            FROM wwc_detail_form_penilaian dff
            JOIN wwc_indikator i ON dff.id_indikator = i.id_indikator
            JOIN wwc_kriteria k ON i.id_kriteria = k.id_kriteria
            LEFT JOIN wwc_detail_penilaian dp ON dp.id_indikator = i.id_indikator
                AND dp.id_penilaian IN (SELECT id_penilaian FROM wwc_penilaian p WHERE p.id_form = " . (int)$id_form . " $where_p)
            WHERE dff.id_form = " . (int)$id_form . " AND dff.status != 8
            GROUP BY i.id_indikator
            ORDER BY k.urutan ASC, dff.urutan ASC
        ")->result_array();

        $data['summary'] = $this->Mod->GetCustome("
            SELECT ROUND(AVG(total_nilai), 2) as avg_total, ROUND(AVG(persentase), 2) as avg_persentase,
                   MIN(total_nilai) as min_total, MAX(total_nilai) as max_total,
                   COUNT(*) as jumlah_assessor
            FROM wwc_penilaian p
            WHERE p.id_form = " . (int)$id_form . " $where_p
        ")->row_array();

        $this->load->view('v_cetak_individu', $data);
    }

    // =============================================
    // CETAK PDF — Rekapitulasi Semua Peserta
    // =============================================
    public function CetakRekap()
    {
        $id_unit    = $this->input->get('id_unit');
        $tgl_dari   = $this->input->get('tgl_dari');
        $tgl_sampai = $this->input->get('tgl_sampai');

        $where_unit   = !empty($id_unit)    ? " AND fp.id_unit = " . (int)$id_unit : "";
        $where_dari   = !empty($tgl_dari)   ? " AND fp.tanggal_penilaian >= '" . $this->db->escape_str($tgl_dari) . "'" : "";
        $where_sampai = !empty($tgl_sampai) ? " AND fp.tanggal_penilaian <= '" . $this->db->escape_str($tgl_sampai) . "'" : "";

        $list = $this->Mod->GetCustome("
            SELECT fp.id_form, fp.kode_form, fp.nama_form, fp.tanggal_penilaian, fp.status,
                   fp.lokasi, fp.catatan,
                   u.id as id_peserta,
                   u.nama as nama_peserta, u.nik,
                   COALESCE(NULLIF(u.jabatan, ''), r.name_role, '-') as name_role,
                   un.name_unit,
                   COUNT(DISTINCT fa.id_form_assessor) as jumlah_assessor,
                   COUNT(DISTINCT p.id_penilaian) as jumlah_penilaian,
                   ROUND(AVG(p.total_nilai), 2) as rata_nilai,
                   ROUND(AVG(p.persentase), 2) as rata_persentase
            FROM wwc_form_penilaian fp
            JOIN wwc_penilaian p ON p.id_form = fp.id_form
            JOIN user u ON u.id = COALESCE(p.id_peserta, fp.id_peserta)
            LEFT JOIN unit un ON un.id_unit = COALESCE(NULLIF(fp.id_unit, 0), u.unit_kerja)
            LEFT JOIN role r ON r.id = COALESCE(NULLIF(fp.id_role, 0), u.type_user)
            LEFT JOIN wwc_form_assessor fa ON fa.id_form = fp.id_form AND fa.status != 8
            WHERE fp.status != 8
            $where_unit $where_dari $where_sampai
            GROUP BY fp.id_form, COALESCE(p.id_peserta, fp.id_peserta)
            ORDER BY fp.tanggal_penilaian DESC, fp.id_form DESC, u.nama ASC
        ")->result_array();

        // Ambil detail per peserta & form
        foreach ($list as &$row) {
            $id = (int)$row['id_form'];
            $id_p = (int)($row['id_peserta'] ?? 0);
            $where_p = !empty($id_p) ? " AND (p.id_peserta = $id_p OR p.id_peserta IS NULL)" : "";

            $row['penilaian_list'] = $this->Mod->GetCustome("
                SELECT p.total_nilai, p.persentase, p.kesimpulan, p.rekomendasi,
                       u.nama as nama_assessor, u.nik as nik_assessor, fa.urutan
                FROM wwc_penilaian p
                JOIN wwc_form_assessor fa ON p.id_form_assessor = fa.id_form_assessor
                JOIN user u ON fa.id_user = u.id
                WHERE p.id_form = $id $where_p 
                ORDER BY fa.urutan ASC
            ")->result_array();

            $row['rekap_indikator'] = $this->Mod->GetCustome("
                SELECT i.kode_indikator, i.nama_indikator, i.bobot,
                       k.nama_kriteria,
                       ROUND(AVG(dp.nilai), 2) as avg_nilai,
                       ROUND(AVG(dp.skor), 2) as avg_skor
                FROM wwc_detail_form_penilaian dff
                JOIN wwc_indikator i ON dff.id_indikator = i.id_indikator
                JOIN wwc_kriteria k ON i.id_kriteria = k.id_kriteria
                LEFT JOIN wwc_detail_penilaian dp ON dp.id_indikator = i.id_indikator
                    AND dp.id_penilaian IN (SELECT id_penilaian FROM wwc_penilaian p WHERE p.id_form = $id $where_p)
                WHERE dff.id_form = $id AND dff.status != 8
                GROUP BY i.id_indikator
                ORDER BY k.urutan ASC, dff.urutan ASC
            ")->result_array();
        }
        unset($row);

        $data['list']       = $list;
        $data['filter']     = [
            'id_unit'    => $id_unit,
            'tgl_dari'   => $tgl_dari,
            'tgl_sampai' => $tgl_sampai,
        ];

        $this->load->view('v_cetak_rekap', $data);
    }
}
