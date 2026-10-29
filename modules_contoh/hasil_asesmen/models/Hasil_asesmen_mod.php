<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil_asesmen_mod extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Helper SQL condition untuk mendeteksi keterlambatan (Toleransi 10 menit)
     */
    private function sql_is_late() {
        return "
            (rp.attendance_code IN ('H', 'T') OR rp.attendance_code = '' OR rp.attendance_code IS NULL)
            AND rp.attendance_code != 'TAP'
            AND rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-'
            AND rp.check_out IS NOT NULL AND rp.check_out != '' AND rp.check_out != '-'
            AND (
                ((LOWER(rp.shift) LIKE '%pagi%' OR rp.schedule_in LIKE '08:%' OR rp.schedule_in = '08:00') AND (rp.check_in > '08:10:59' OR rp.check_in >= '08:11'))
                OR
                ((LOWER(rp.shift) LIKE '%malam%' OR rp.schedule_in LIKE '20:%' OR rp.schedule_in = '20:00') AND (rp.check_in > '20:10:59' OR rp.check_in >= '20:11'))
                OR
                (LOWER(rp.shift) NOT LIKE '%pagi%' AND LOWER(rp.shift) NOT LIKE '%malam%' AND rp.schedule_in NOT LIKE '08:%' AND rp.schedule_in NOT LIKE '20:%' AND rp.schedule_in IS NOT NULL AND rp.schedule_in != '' AND rp.check_in > ADDTIME(rp.schedule_in, '00:10:00'))
            )
        ";
    }

    /**
     * Mengambil daftar personil beserta ringkasan 3 nilai asesmen
     * (CBT, Wawancara, Presensi)
     */
    public function get_rekap_asesmen($start_date, $end_date, $unit_id = null, $search = '', $user_id = null) {
        $cutiCodes = "'CTP', 'CL', 'CIU', 'CM', 'IMIK', 'TGS', 'CH', 'CMA', 'CKA', 'CBA', 'CKM', 'CRM', 'CK', 'CIH', 'CKTN', 'CTSPB', 'CTPDP', 'I'";
        $isLateSql = $this->sql_is_late();

        // 1. Ambil daftar personil sesuai filter
        $this->db->select("
            u.id as user_id,
            u.nik,
            u.nama as nama_peserta,
            un.id_unit,
            un.kode_unit,
            un.name_unit,
            COALESCE(NULLIF(u.jabatan, ''), r.name_role, '-') as nama_jabatan
        ");
        $this->db->from('user u');
        $this->db->join('unit un', 'un.id_unit = u.unit_kerja', 'left');
        $this->db->join('role r', 'r.id = u.type_user', 'left');
        $this->db->where_not_in('u.type_user', [2, 4, 99, 5, 6, 104, 105, 106, 108]);

        if (!empty($unit_id)) {
            $this->db->where('u.unit_kerja', (int)$unit_id);
        }

        if (!empty($user_id)) {
            $this->db->where('u.id', (int)$user_id);
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('u.nik', $search);
            $this->db->or_like('u.nama', $search);
            $this->db->or_like('un.kode_unit', $search);
            $this->db->or_like('un.name_unit', $search);
            $this->db->or_like('r.name_role', $search);
            $this->db->group_end();
        }

        $this->db->order_by('FIELD(u.unit_kerja, 28, 21, 22, 23, 18, 19, 20, 14, 15, 16, 17, 24, 25, 26, 27, 30) = 0, FIELD(u.unit_kerja, 28, 21, 22, 23, 18, 19, 20, 14, 15, 16, 17, 24, 25, 26, 27, 30)', '', FALSE);
        $this->db->order_by('FIELD(u.type_user, 103, 101, 102, 109, 110, 107, 1) = 0, FIELD(u.type_user, 103, 101, 102, 109, 110, 107, 1)', '', FALSE);
        $this->db->order_by('u.nama', 'ASC');
        $users = $this->db->get()->result_array();

        if (empty($users)) {
            return [];
        }

        $user_ids = array_column($users, 'user_id');

        // 2. Ambil Nilai CBT per user pada periode tanggal
        $where_cbt_date = "";
        if (!empty($start_date)) {
            $where_cbt_date .= " AND COALESCE(h.tanggal_selesai, h.tanggal_mulai) >= '" . $this->db->escape_str($start_date) . " 00:00:00'";
        }
        if (!empty($end_date)) {
            $where_cbt_date .= " AND COALESCE(h.tanggal_selesai, h.tanggal_mulai) <= '" . $this->db->escape_str($end_date) . " 23:59:59'";
        }

        $cbt_map = [];
        $cbt_query = $this->db->query("
            SELECT h.id_user,
                   COUNT(h.id_hasil_ujian_cbt) as total_ujian,
                   ROUND(AVG(h.nilai), 2) as avg_nilai_cbt,
                   MAX(h.nilai) as max_nilai_cbt,
                   GROUP_CONCAT(DISTINCT u.nama_ujian_cbt SEPARATOR ', ') as daftar_ujian
            FROM cbt_hasil_ujian h
            LEFT JOIN cbt_ujian u ON u.id_ujian_cbt = h.id_ujian_cbt
            WHERE h.status = 1 AND h.id_user IN (" . implode(',', $user_ids) . ") $where_cbt_date
            GROUP BY h.id_user
        ")->result_array();

        foreach ($cbt_query as $c) {
            $cbt_map[$c['id_user']] = $c;
        }

        // 3. Ambil Nilai Wawancara (WWC) per user beserta nama-nama Asesor pada periode tanggal
        $where_wwc_date = "";
        if (!empty($start_date)) {
            $where_wwc_date .= " AND (fp.tanggal_penilaian >= '" . $this->db->escape_str($start_date) . "' OR p.tanggal_selesai >= '" . $this->db->escape_str($start_date) . " 00:00:00')";
        }
        if (!empty($end_date)) {
            $where_wwc_date .= " AND (fp.tanggal_penilaian <= '" . $this->db->escape_str($end_date) . "' OR p.tanggal_selesai <= '" . $this->db->escape_str($end_date) . " 23:59:59')";
        }

        $wwc_map = [];
        $wwc_query = $this->db->query("
            SELECT p.id_peserta,
                   COUNT(DISTINCT p.id_penilaian) as total_penilaian,
                   ROUND(AVG(p.total_nilai), 2) as avg_nilai_wwc,
                   ROUND(AVG(p.persentase), 2) as avg_persen_wwc,
                   GROUP_CONCAT(DISTINCT u_assessor.nama SEPARATOR ', ') as nama_assessor
            FROM wwc_penilaian p
            LEFT JOIN wwc_form_penilaian fp ON fp.id_form = p.id_form
            LEFT JOIN wwc_form_assessor fa ON fa.id_form_assessor = p.id_form_assessor
            LEFT JOIN user u_assessor ON u_assessor.id = fa.id_user
            WHERE p.id_peserta IN (" . implode(',', $user_ids) . ") $where_wwc_date
            GROUP BY p.id_peserta
        ")->result_array();

        foreach ($wwc_query as $w) {
            $wwc_map[$w['id_peserta']] = $w;
        }

        // 4. Ambil Rekap Presensi per user pada rentang tanggal
        $presensi_map = [];
        $where_date = "";
        if (!empty($start_date)) {
            $where_date .= " AND rp.date >= '" . $this->db->escape_str($start_date) . "'";
        }
        if (!empty($end_date)) {
            $where_date .= " AND rp.date <= '" . $this->db->escape_str($end_date) . "'";
        }

        $presensi_query = $this->db->query("
            SELECT rp.user_id,
                   COUNT(rp.id) as total_record,
                   SUM(CASE 
                       WHEN (
                           ((rp.attendance_code IN ('H', 'T') OR (rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-'))
                            AND (rp.check_out IS NOT NULL AND rp.check_out != '' AND rp.check_out != '-'))
                           OR rp.attendance_code = 'TAP'
                            OR (
                                (LOWER(rp.shift) NOT LIKE '%off%' AND LOWER(rp.shift) NOT LIKE '%dayoff%' AND LOWER(rp.shift) NOT LIKE '%libur%')
                                AND (rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-')
                                AND (rp.check_out IS NULL OR rp.check_out = '' OR rp.check_out = '-')
                            )
                            OR rp.attendance_code IN ($cutiCodes, 'S')
                       )
                       AND (rp.attendance_code IS NULL OR rp.attendance_code NOT IN ('A', 'UL'))
                       AND NOT (
                           (LOWER(rp.shift) LIKE '%off%' OR LOWER(rp.shift) LIKE '%dayoff%' OR LOWER(rp.shift) LIKE '%libur%')
                           AND (rp.attendance_code = '' OR rp.attendance_code IS NULL)
                           AND (rp.check_in IS NULL OR rp.check_in = '' OR rp.check_in = '-')
                           AND (rp.check_out IS NULL OR rp.check_out = '' OR rp.check_out = '-')
                       )
                       THEN 1 ELSE 0 END) as total_hadir,
                   SUM(CASE WHEN $isLateSql THEN 1 ELSE 0 END) as total_terlambat,
                   SUM(CASE 
                       WHEN rp.attendance_code = 'TAP' 
                            OR (
                                (LOWER(rp.shift) NOT LIKE '%off%' AND LOWER(rp.shift) NOT LIKE '%dayoff%' AND LOWER(rp.shift) NOT LIKE '%libur%')
                                AND (rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-')
                                AND (rp.check_out IS NULL OR rp.check_out = '' OR rp.check_out = '-')
                            )
                       THEN 1 ELSE 0 END) as total_tap,
                   SUM(CASE WHEN rp.attendance_code = 'A' THEN 1 ELSE 0 END) as total_alpha,
                   SUM(CASE WHEN rp.attendance_code = 'UL' THEN 1 ELSE 0 END) as total_ul,
                   SUM(CASE WHEN rp.attendance_code IN ($cutiCodes) THEN 1 ELSE 0 END) as total_izin,
                   SUM(CASE WHEN rp.attendance_code = 'S' THEN 1 ELSE 0 END) as total_sakit,
                   SUM(CASE 
                       WHEN (LOWER(rp.shift) LIKE '%off%' OR LOWER(rp.shift) LIKE '%dayoff%' OR LOWER(rp.shift) LIKE '%libur%') 
                            OR (
                                (rp.attendance_code = '' OR rp.attendance_code IS NULL) 
                                AND (rp.check_in IS NULL OR rp.check_in = '' OR rp.check_in = '-') 
                                AND (rp.check_out IS NULL OR rp.check_out = '' OR rp.check_out = '-')
                            )
                       THEN 1 ELSE 0 END) as total_off
            FROM rekap_presensi rp
            WHERE rp.user_id IN (" . implode(',', $user_ids) . ") $where_date
            GROUP BY rp.user_id
        ")->result_array();

        foreach ($presensi_query as $p) {
            $presensi_map[$p['user_id']] = $p;
        }

        // 5. Gabungkan dan kalkulasikan total nilai asesmen untuk masing-masing personil
        $result = [];
        foreach ($users as $u) {
            $uid = $u['user_id'];

            // CBT
            $cbt_data = $cbt_map[$uid] ?? null;
            $nilai_cbt = !empty($cbt_data) ? (float)$cbt_data['avg_nilai_cbt'] : null;

            // WWC
            $wwc_data = $wwc_map[$uid] ?? null;
            $nilai_wwc = !empty($wwc_data) ? (float)$wwc_data['avg_nilai_wwc'] : null;
            $nama_assessor = !empty($wwc_data['nama_assessor']) ? $wwc_data['nama_assessor'] : '-';

            // Presensi
            $pres_data = $presensi_map[$uid] ?? null;
            $total_rec = !empty($pres_data) ? (int)$pres_data['total_record'] : 0;
            $total_off = !empty($pres_data) ? (int)$pres_data['total_off'] : 0;
            $total_hadir = !empty($pres_data) ? (int)$pres_data['total_hadir'] : 0;
            $total_late = !empty($pres_data) ? (int)$pres_data['total_terlambat'] : 0;

            $hari_efektif = max(0, $total_rec - $total_off);
            $pct_hadir = ($hari_efektif > 0) ? min(100, max(0, round(($total_hadir / $hari_efektif) * 100, 1))) : 0;
            $pct_tepat = ($total_hadir > 0) ? min(100, max(0, round((($total_hadir - $total_late) / $total_hadir) * 100, 1))) : 0;
            $skor_presensi = round(($pct_hadir + $pct_tepat) / 2, 1);

            // Hitung Total Nilai Akhir Asesmen (Rata-rata 3 Parameter)
            $val_cbt_calc = ($nilai_cbt !== null) ? $nilai_cbt : 0;
            $val_wwc_calc = ($nilai_wwc !== null) ? $nilai_wwc : 0;
            $val_pres_calc = $skor_presensi;

            $total_asesmen = round(($val_cbt_calc + $val_wwc_calc + $val_pres_calc) / 3, 2);

            // Predikat
            if ($total_asesmen >= 85) {
                $predikat = 'Istimewa';
                $predikat_badge = 'badge-success';
            } elseif ($total_asesmen >= 70) {
                $predikat = 'Kompeten';
                $predikat_badge = 'badge-primary';
            } elseif ($total_asesmen >= 55) {
                $predikat = 'Cukup';
                $predikat_badge = 'badge-warning text-dark';
            } else {
                $predikat = 'Perlu Pembinaan';
                $predikat_badge = 'badge-danger';
            }

            $result[] = [
                'user_id'         => $uid,
                'nik'             => $u['nik'],
                'nama_peserta'    => $u['nama_peserta'],
                'id_unit'         => $u['id_unit'],
                'kode_unit'       => $u['kode_unit'] ?? '-',
                'name_unit'       => $u['name_unit'] ?? '-',
                'nama_jabatan'    => $u['nama_jabatan'],
                // Nilai Parameter 1 (CBT)
                'nilai_cbt'       => $nilai_cbt,
                'daftar_ujian'    => $cbt_data['daftar_ujian'] ?? '-',
                // Nilai Parameter 2 (WWC)
                'nilai_wwc'       => $nilai_wwc,
                'nama_assessor'   => $nama_assessor,
                // Nilai Parameter 3 (Presensi)
                'total_record'    => $total_rec,
                'total_hadir'     => $total_hadir,
                'total_terlambat' => $total_late,
                'total_tap'       => !empty($pres_data) ? (int)$pres_data['total_tap'] : 0,
                'total_tidak_hadir' => !empty($pres_data) ? ((int)$pres_data['total_alpha'] + (int)$pres_data['total_ul']) : 0,
                'persen_kehadiran'=> $pct_hadir,
                'persen_tepat'    => $pct_tepat,
                'skor_presensi'   => $skor_presensi,
                // Total Asesmen
                'total_asesmen'   => $total_asesmen,
                'predikat'        => $predikat,
                'predikat_badge'  => $predikat_badge
            ];
        }

        return $result;
    }

    /**
     * Mengambil detail komprehensif 1 personil untuk lembar cetak PDF
     */
    public function get_detail_asesmen_personil($user_id, $start_date, $end_date) {
        $cutiCodes = "'CTP', 'CL', 'CIU', 'CM', 'IMIK', 'TGS', 'CH', 'CMA', 'CKA', 'CBA', 'CKM', 'CRM', 'CK', 'CIH', 'CKTN', 'CTSPB', 'CTPDP', 'I'";
        $isLateSql = $this->sql_is_late();

        // 1. Data Diri Personil
        $peserta = $this->db->query("
            SELECT u.id as user_id, u.nik, u.nama as nama_peserta,
                   un.id_unit, un.kode_unit, un.name_unit,
                   COALESCE(NULLIF(u.jabatan, ''), r.name_role, '-') as nama_jabatan
            FROM user u
            LEFT JOIN unit un ON un.id_unit = u.unit_kerja
            LEFT JOIN role r ON r.id = u.type_user
            WHERE u.id = " . (int)$user_id . "
        ")->row_array();

        if (empty($peserta)) {
            return null;
        }

        // 2. Detail Hasil Ujian CBT (Semua ujian yang diikuti peserta pada periode tanggal)
        $where_cbt_date = "";
        if (!empty($start_date)) {
            $where_cbt_date .= " AND COALESCE(h.tanggal_selesai, h.tanggal_mulai) >= '" . $this->db->escape_str($start_date) . " 00:00:00'";
        }
        if (!empty($end_date)) {
            $where_cbt_date .= " AND COALESCE(h.tanggal_selesai, h.tanggal_mulai) <= '" . $this->db->escape_str($end_date) . " 23:59:59'";
        }

        $cbt_list = $this->db->query("
            SELECT h.id_hasil_ujian_cbt, h.id_ujian_cbt, h.nilai,
                   h.jumlah_benar, h.jumlah_selesai, h.jumlah_kosong,
                   h.tanggal_mulai, h.tanggal_selesai,
                   COALESCE(h.tanggal_selesai, h.tanggal_mulai) as tanggal_ujian,
                   u.nama_ujian_cbt, u.durasi_menit, u.jumlah_soal,
                   p.foto_awal
            FROM cbt_hasil_ujian h
            LEFT JOIN cbt_ujian u ON u.id_ujian_cbt = h.id_ujian_cbt
            LEFT JOIN cbt_proses_ujian p ON p.id_ujian_cbt = h.id_ujian_cbt AND p.id_user = h.id_user
            WHERE h.status = 1 AND h.id_user = " . (int)$user_id . " $where_cbt_date
            ORDER BY h.id_hasil_ujian_cbt DESC
        ")->result_array();

        foreach ($cbt_list as &$cbt_item) {
            $cbt_item['detail_jawaban'] = $this->db->query("
                SELECT d.*, b.pertanyaan, b.opsi_a, b.opsi_b, b.opsi_c, b.opsi_d, b.jawaban AS kunci, b.bobot
                FROM cbt_detail_hasil_ujian d
                LEFT JOIN cbt_bank_soal b ON b.id_bank_soal_cbt = d.id_bank_soal_cbt
                WHERE d.id_hasil_ujian_cbt = " . (int)$cbt_item['id_hasil_ujian_cbt'] . "
                ORDER BY d.id_detail_hasil_ujian_cbt ASC
            ")->result_array();
        }
        unset($cbt_item);

        $avg_nilai_cbt = !empty($cbt_list) ? round(array_sum(array_column($cbt_list, 'nilai')) / count($cbt_list), 2) : 0;

        // 3. Detail Hasil Wawancara (WWC) pada periode tanggal
        $where_wwc_date = "";
        if (!empty($start_date)) {
            $where_wwc_date .= " AND (fp.tanggal_penilaian >= '" . $this->db->escape_str($start_date) . "' OR p.tanggal_selesai >= '" . $this->db->escape_str($start_date) . " 00:00:00')";
        }
        if (!empty($end_date)) {
            $where_wwc_date .= " AND (fp.tanggal_penilaian <= '" . $this->db->escape_str($end_date) . "' OR p.tanggal_selesai <= '" . $this->db->escape_str($end_date) . " 23:59:59')";
        }

        $wwc_penilaian = $this->db->query("
            SELECT p.id_penilaian, p.id_form, p.total_nilai, p.persentase, p.kesimpulan, p.rekomendasi, p.tanggal_selesai,
                   fp.kode_form, fp.nama_form, fp.tanggal_penilaian,
                   u_assessor.nama as nama_assessor, u_assessor.nik as nik_assessor,
                   COALESCE(NULLIF(u_assessor.jabatan, ''), r_assessor.name_role, '-') as jabatan_assessor
            FROM wwc_penilaian p
            LEFT JOIN wwc_form_penilaian fp ON fp.id_form = p.id_form
            LEFT JOIN wwc_form_assessor fa ON fa.id_form_assessor = p.id_form_assessor
            LEFT JOIN user u_assessor ON u_assessor.id = fa.id_user
            LEFT JOIN role r_assessor ON r_assessor.id = u_assessor.type_user
            WHERE p.id_peserta = " . (int)$user_id . " $where_wwc_date
            ORDER BY p.id_penilaian ASC
        ")->result_array();

        // Rincian Nilai per Indikator WWC
        $wwc_indikator = $this->db->query("
            SELECT i.id_indikator, i.kode_indikator, i.nama_indikator, i.bobot,
                   k.nama_kriteria, k.kode_kriteria,
                   ROUND(AVG(dp.nilai), 2) as avg_nilai,
                   ROUND(AVG(dp.skor), 2) as avg_skor
            FROM wwc_detail_penilaian dp
            JOIN wwc_penilaian p ON p.id_penilaian = dp.id_penilaian
            JOIN wwc_indikator i ON i.id_indikator = dp.id_indikator
            JOIN wwc_kriteria k ON k.id_kriteria = i.id_kriteria
            LEFT JOIN wwc_form_penilaian fp ON fp.id_form = p.id_form
            LEFT JOIN wwc_form_assessor fa ON fa.id_form_assessor = p.id_form_assessor
            WHERE p.id_peserta = " . (int)$user_id . " $where_wwc_date
            GROUP BY i.id_indikator
            ORDER BY k.urutan ASC, i.id_indikator ASC
        ")->result_array();

        foreach ($wwc_indikator as &$ind_item) {
            $ind_item['assessor_notes'] = $this->db->query("
                SELECT dp.nilai, dp.skor, dp.catatan, u_ass.nama as nama_assessor
                FROM wwc_detail_penilaian dp
                JOIN wwc_penilaian p ON p.id_penilaian = dp.id_penilaian
                LEFT JOIN wwc_form_penilaian fp ON fp.id_form = p.id_form
                LEFT JOIN wwc_form_assessor fa ON fa.id_form_assessor = p.id_form_assessor
                LEFT JOIN user u_ass ON u_ass.id = fa.id_user
                WHERE p.id_peserta = " . (int)$user_id . " AND dp.id_indikator = " . (int)$ind_item['id_indikator'] . " $where_wwc_date
                ORDER BY fa.urutan ASC, dp.id_detail_penilaian ASC
            ")->result_array();
        }
        unset($ind_item);

        $avg_nilai_wwc = !empty($wwc_penilaian) ? round(array_sum(array_column($wwc_penilaian, 'total_nilai')) / count($wwc_penilaian), 2) : 0;
        $daftar_assessor = array_unique(array_filter(array_column($wwc_penilaian, 'nama_assessor')));

        // 4. Detail Rekap Presensi pada Periode
        $where_date = "";
        if (!empty($start_date)) {
            $where_date .= " AND rp.date >= '" . $this->db->escape_str($start_date) . "'";
        }
        if (!empty($end_date)) {
            $where_date .= " AND rp.date <= '" . $this->db->escape_str($end_date) . "'";
        }

        $presensi_summary = $this->db->query("
            SELECT COUNT(rp.id) as total_record,
                   SUM(CASE 
                       WHEN (
                           ((rp.attendance_code IN ('H', 'T') OR (rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-'))
                            AND (rp.check_out IS NOT NULL AND rp.check_out != '' AND rp.check_out != '-'))
                           OR rp.attendance_code = 'TAP'
                            OR (
                                (LOWER(rp.shift) NOT LIKE '%off%' AND LOWER(rp.shift) NOT LIKE '%dayoff%' AND LOWER(rp.shift) NOT LIKE '%libur%')
                                AND (rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-')
                                AND (rp.check_out IS NULL OR rp.check_out = '' OR rp.check_out = '-')
                            )
                            OR rp.attendance_code IN ($cutiCodes, 'S')
                       )
                       AND (rp.attendance_code IS NULL OR rp.attendance_code NOT IN ('A', 'UL'))
                       AND NOT (
                           (LOWER(rp.shift) LIKE '%off%' OR LOWER(rp.shift) LIKE '%dayoff%' OR LOWER(rp.shift) LIKE '%libur%')
                           AND (rp.attendance_code = '' OR rp.attendance_code IS NULL)
                           AND (rp.check_in IS NULL OR rp.check_in = '' OR rp.check_in = '-')
                           AND (rp.check_out IS NULL OR rp.check_out = '' OR rp.check_out = '-')
                       )
                       THEN 1 ELSE 0 END) as total_hadir,
                   SUM(CASE WHEN $isLateSql THEN 1 ELSE 0 END) as total_terlambat,
                   SUM(CASE 
                       WHEN rp.attendance_code = 'TAP' 
                            OR (
                                (LOWER(rp.shift) NOT LIKE '%off%' AND LOWER(rp.shift) NOT LIKE '%dayoff%' AND LOWER(rp.shift) NOT LIKE '%libur%')
                                AND (rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-')
                                AND (rp.check_out IS NULL OR rp.check_out = '' OR rp.check_out = '-')
                            )
                       THEN 1 ELSE 0 END) as total_tap,
                   SUM(CASE WHEN rp.attendance_code = 'A' THEN 1 ELSE 0 END) as total_alpha,
                   SUM(CASE WHEN rp.attendance_code = 'UL' THEN 1 ELSE 0 END) as total_ul,
                   SUM(CASE WHEN rp.attendance_code IN ($cutiCodes) THEN 1 ELSE 0 END) as total_izin,
                   SUM(CASE WHEN rp.attendance_code = 'S' THEN 1 ELSE 0 END) as total_sakit,
                   SUM(CASE 
                       WHEN (LOWER(rp.shift) LIKE '%off%' OR LOWER(rp.shift) LIKE '%dayoff%' OR LOWER(rp.shift) LIKE '%libur%') 
                            OR (
                                (rp.attendance_code = '' OR rp.attendance_code IS NULL) 
                                AND (rp.check_in IS NULL OR rp.check_in = '' OR rp.check_in = '-') 
                                AND (rp.check_out IS NULL OR rp.check_out = '' OR rp.check_out = '-')
                            )
                       THEN 1 ELSE 0 END) as total_off
            FROM rekap_presensi rp
            WHERE rp.user_id = " . (int)$user_id . " $where_date
        ")->row_array();

        $t_rec = (int)($presensi_summary['total_record'] ?? 0);
        $t_off = (int)($presensi_summary['total_off'] ?? 0);
        $t_hadir = (int)($presensi_summary['total_hadir'] ?? 0);
        $t_late = (int)($presensi_summary['total_terlambat'] ?? 0);
        $t_tap = (int)($presensi_summary['total_tap'] ?? 0);
        $t_alpha = (int)($presensi_summary['total_alpha'] ?? 0);
        $t_ul = (int)($presensi_summary['total_ul'] ?? 0);
        $t_tidak_hadir = $t_alpha + $t_ul;
        $t_izin = (int)($presensi_summary['total_izin'] ?? 0);
        $t_sakit = (int)($presensi_summary['total_sakit'] ?? 0);

        $hari_efektif = max(0, $t_rec - $t_off);
        $pct_hadir = ($hari_efektif > 0) ? min(100, max(0, round(($t_hadir / $hari_efektif) * 100, 1))) : 0;
        $pct_tepat = ($t_hadir > 0) ? min(100, max(0, round((($t_hadir - $t_late) / $t_hadir) * 100, 1))) : 0;
        $skor_presensi = round(($pct_hadir + $pct_tepat) / 2, 1);

        // 5. Total Skor Akhir
        $total_asesmen = round(($avg_nilai_cbt + $avg_nilai_wwc + $skor_presensi) / 3, 2);

        if ($total_asesmen >= 85) {
            $predikat = 'Istimewa';
        } elseif ($total_asesmen >= 70) {
            $predikat = 'Kompeten';
        } elseif ($total_asesmen >= 55) {
            $predikat = 'Cukup';
        } else {
            $predikat = 'Perlu Pembinaan';
        }

        return [
            'peserta'          => $peserta,
            'start_date'       => $start_date,
            'end_date'         => $end_date,
            // CBT
            'cbt_list'         => $cbt_list,
            'avg_nilai_cbt'    => $avg_nilai_cbt,
            // WWC
            'wwc_penilaian'    => $wwc_penilaian,
            'wwc_indikator'    => $wwc_indikator,
            'avg_nilai_wwc'    => $avg_nilai_wwc,
            'daftar_assessor'  => implode(', ', $daftar_assessor),
            // Presensi
            'presensi_summary' => [
                'total_record'     => $t_rec,
                'total_hadir'      => $t_hadir,
                'total_terlambat'  => $t_late,
                'total_tidak_hadir'=> $t_tidak_hadir,
                'total_tap'        => $t_tap,
                'total_alpha'      => $t_alpha,
                'total_ul'         => $t_ul,
                'total_izin'       => $t_izin,
                'total_sakit'      => $t_sakit,
                'total_off'        => $t_off,
                'persen_kehadiran' => $pct_hadir,
                'persen_tepat'     => $pct_tepat,
                'skor_presensi'    => $skor_presensi
            ],
            // Overall
            'total_asesmen'    => $total_asesmen,
            'predikat'         => $predikat
        ];
    }
}
