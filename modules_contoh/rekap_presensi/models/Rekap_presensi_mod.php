<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_presensi_mod extends CI_Model {

    protected $table = 'rekap_presensi';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Otomatis inisialisasi tabel rekap_presensi jika belum ada
     */
    public function create_table_if_not_exists() {
        $sql = "CREATE TABLE IF NOT EXISTS `rekap_presensi` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `user_id` int(11) DEFAULT NULL,
          `nik` varchar(50) DEFAULT NULL,
          `date` date DEFAULT NULL,
          `shift` varchar(100) DEFAULT NULL,
          `schedule_in` varchar(20) DEFAULT NULL,
          `schedule_out` varchar(20) DEFAULT NULL,
          `attendance_code` varchar(50) DEFAULT NULL,
          `check_in` varchar(20) DEFAULT NULL,
          `check_out` varchar(20) DEFAULT NULL,
          `keterangan` text DEFAULT NULL,
          `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
          `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`),
          KEY `user_id` (`user_id`),
          KEY `nik` (`nik`),
          KEY `date` (`date`),
          KEY `user_date` (`user_id`,`date`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->db->query($sql);
    }

    /**
     * Helper SQL condition untuk mendeteksi keterlambatan (Toleransi 10 menit)
     * Pagi: > 08:10 (08:11 dst terlambat)
     * Malam: > 20:10 (20:11 dst terlambat)
     */
    private function sql_is_late() {
        return "
            (rp.attendance_code IN ('H', 'T') OR rp.attendance_code = '' OR rp.attendance_code IS NULL)
            AND rp.attendance_code NOT IN ('TAP', 'A', 'UL')
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
     * Mengambil seluruh data presensi dengan join ke user, unit, dan role
     */
    public function get_all($limit = 10, $start = 0, $search = '', $unit_id = null, $start_date = null, $user_id = null, $end_date = null) {
        $this->db->select('rp.*, u.nama as user_nama, u.nama as full_name, u.nik as user_nik, un.kode_unit, un.name_unit, r.name_role as nama_jabatan, r.name_role');
        $this->db->from($this->table . ' rp');
        $this->db->join('user u', 'u.id = rp.user_id', 'left');
        $this->db->join('unit un', 'un.id_unit = u.unit_kerja', 'left');
        $this->db->join('role r', 'r.id = u.type_user', 'left');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('rp.nik', $search);
            $this->db->or_like('u.nama', $search);
            $this->db->or_like('un.kode_unit', $search);
            $this->db->or_like('r.name_role', $search);
            $this->db->or_like('rp.attendance_code', $search);
            $this->db->or_like('rp.shift', $search);
            $this->db->group_end();
        }

        if (!empty($unit_id)) {
            $this->db->where('u.unit_kerja', $unit_id);
        }

        if (!empty($user_id)) {
            $this->db->where('rp.user_id', $user_id);
        }

        if (!empty($start_date)) {
            $this->db->where('rp.date >=', $start_date);
        }

        if (!empty($end_date)) {
            $this->db->where('rp.date <=', $end_date);
        }

        $this->db->order_by('rp.id', 'ASC');

        if ($limit > 0) {
            $this->db->limit($limit, $start);
        }

        return $this->db->get()->result_array();
    }

    /**
     * Menghitung total data presensi untuk pagination (Super Cepat)
     */
    public function count_all($search = '', $unit_id = null, $start_date = null, $user_id = null, $end_date = null) {
        $this->db->from($this->table . ' rp');
        
        $need_join = (!empty($search) || !empty($unit_id));
        if ($need_join) {
            $this->db->join('user u', 'u.id = rp.user_id', 'left');
            $this->db->join('unit un', 'un.id_unit = u.unit_kerja', 'left');
            $this->db->join('role r', 'r.id = u.type_user', 'left');
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('rp.nik', $search);
            $this->db->or_like('u.nama', $search);
            $this->db->or_like('un.kode_unit', $search);
            $this->db->or_like('r.name_role', $search);
            $this->db->or_like('rp.attendance_code', $search);
            $this->db->or_like('rp.shift', $search);
            $this->db->group_end();
        }

        if (!empty($unit_id)) {
            $this->db->where('u.unit_kerja', $unit_id);
        }

        if (!empty($user_id)) {
            $this->db->where('rp.user_id', $user_id);
        }

        if (!empty($start_date)) {
            $this->db->where('rp.date >=', $start_date);
        }

        if (!empty($end_date)) {
            $this->db->where('rp.date <=', $end_date);
        }

        return $this->db->count_all_results();
    }

    /**
     * Mengambil data presensi berdasarkan ID
     */
    public function get_by_id($id) {
        $this->db->select('rp.*, u.nama as user_nama, u.nama as full_name, u.nik as user_nik, un.kode_unit, un.name_unit, r.name_role as nama_jabatan, r.name_role');
        $this->db->from($this->table . ' rp');
        $this->db->join('user u', 'u.id = rp.user_id', 'left');
        $this->db->join('unit un', 'un.id_unit = u.unit_kerja', 'left');
        $this->db->join('role r', 'r.id = u.type_user', 'left');
        $this->db->where('rp.id', $id);
        return $this->db->get()->row_array();
    }

    /**
     * Mengambil data presensi berdasarkan user_id
     */
    public function get_by_user($user_id) {
        return $this->db->get_where($this->table, array('user_id' => $user_id))->result_array();
    }

    /**
     * Mengambil data presensi berdasarkan unit_id (via relasi user.unit_kerja)
     */
    public function get_by_unit($unit_id) {
        $this->db->select('rp.*');
        $this->db->from($this->table . ' rp');
        $this->db->join('user u', 'u.id = rp.user_id', 'left');
        $this->db->where('u.unit_kerja', $unit_id);
        return $this->db->get()->result_array();
    }

    /**
     * Mengambil data presensi berdasarkan tanggal
     */
    public function get_by_date($date) {
        return $this->db->get_where($this->table, array('date' => $date))->result_array();
    }

    /**
     * Mengecek duplikasi presensi berdasarkan user_id dan date
     */
    public function get_by_user_date($user_id, $date) {
        return $this->db->get_where($this->table, array(
            'user_id' => $user_id,
            'date'    => $date
        ))->row();
    }

    /**
     * Mencari user berdasarkan NIK (String) - Hanya user aktif (status != 8)
     */
    public function get_user_by_nik($nik, $full_name = '') {
        $nik = trim((string)$nik);
        $full_name = trim((string)$full_name);

        // 1. Jika ada full_name, coba cari yang cocok NIK + Nama + status != 8
        if (!empty($full_name)) {
            $this->db->from('user');
            $this->db->where('nik', $nik);
            $this->db->where('status !=', 8);
            $this->db->like('nama', $full_name);
            $user_by_name = $this->db->get()->row();
            if ($user_by_name) {
                return $user_by_name;
            }
        }

        // 2. Cari user aktif (status != 8) dengan exclude non-operational role
        $this->db->from('user');
        $this->db->where('nik', $nik);
        $this->db->where('status !=', 8);
        $this->db->where_not_in('type_user', [2, 4, 99, 5, 6, 104, 105, 106, 108]);
        $this->db->order_by('id', 'DESC');
        $user = $this->db->get()->row();

        if ($user) {
            return $user;
        }

        // 3. Fallback: Cari user aktif mana saja dengan NIK tersebut (status != 8)
        return $this->db->where('nik', $nik)
                        ->where('status !=', 8)
                        ->order_by('id', 'DESC')
                        ->get('user')
                        ->row();
    }

    /**
     * Mencari unit berdasarkan kode_unit
     */
    public function get_unit_by_kode($kode_unit) {
        $kode_unit = strtoupper(trim((string)$kode_unit));
        return $this->db->where('kode_unit', $kode_unit)->get('unit')->row();
    }

    /**
     * Insert single data
     */
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    /**
     * Insert batch data
     */
    public function insert_batch($data) {
        return $this->db->insert_batch($this->table, $data);
    }

    /**
     * Update data
     */
    public function update($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    /**
     * Delete data
     */
    public function delete($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }

    /**
     * Rekap statistik kehadiran per karyawan (Hadir, Terlambat, TAP, Izin/Cuti, Sakit, Alpha, Day Off)
     */
    public function get_summary_by_user($unit_id = null, $start_date = null, $end_date = null, $search = '', $user_id = null) {
        $isLateSql = $this->sql_is_late();
        $cutiCodes = "'CTP', 'CL', 'CIU', 'CM', 'IMIK', 'TGS', 'CH', 'CMA', 'CKA', 'CBA', 'CKM', 'CRM', 'CK', 'CIH', 'CKTN', 'CTSPB', 'CTPDP', 'I'";

        $this->db->select("
            rp.user_id,
            rp.nik,
            u.nama as full_name,
            un.kode_unit,
            un.name_unit,
            r.name_role as nama_jabatan,
            r.name_role,
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
            SUM(CASE 
                WHEN ((rp.attendance_code IN ('H', 'T') OR (rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-'))
                     AND (rp.check_out IS NOT NULL AND rp.check_out != '' AND rp.check_out != '-'))
                     AND (rp.attendance_code IS NULL OR rp.attendance_code NOT IN ('TAP', 'A', 'UL', 'S', $cutiCodes))
                THEN 1 ELSE 0 END) as total_hadir_fisik,
            SUM(CASE WHEN $isLateSql THEN 1 ELSE 0 END) as total_terlambat,
            SUM(CASE 
                WHEN rp.attendance_code = 'TAP' 
                     OR (
                         (LOWER(rp.shift) NOT LIKE '%off%' AND LOWER(rp.shift) NOT LIKE '%dayoff%' AND LOWER(rp.shift) NOT LIKE '%libur%')
                         AND (rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-')
                         AND (rp.check_out IS NULL OR rp.check_out = '' OR rp.check_out = '-')
                     )
                THEN 1 ELSE 0 END) as total_tap,
            SUM(CASE 
                WHEN rp.attendance_code = 'A' 
                     OR (
                         (LOWER(rp.shift) NOT LIKE '%off%' AND LOWER(rp.shift) NOT LIKE '%dayoff%' AND LOWER(rp.shift) NOT LIKE '%libur%')
                         AND (rp.check_in IS NULL OR rp.check_in = '' OR rp.check_in = '-')
                         AND (rp.attendance_code IS NULL OR rp.attendance_code = '' OR rp.attendance_code = '0' OR rp.attendance_code = '-')
                     )
                THEN 1 ELSE 0 END) as total_alpha,
            SUM(CASE WHEN rp.attendance_code = 'UL' THEN 1 ELSE 0 END) as total_ul,
            SUM(CASE 
                WHEN rp.attendance_code IN ('A', 'UL') 
                     OR (
                         (LOWER(rp.shift) NOT LIKE '%off%' AND LOWER(rp.shift) NOT LIKE '%dayoff%' AND LOWER(rp.shift) NOT LIKE '%libur%')
                         AND (rp.check_in IS NULL OR rp.check_in = '' OR rp.check_in = '-')
                         AND (rp.attendance_code IS NULL OR rp.attendance_code = '' OR rp.attendance_code = '0' OR rp.attendance_code = '-')
                     )
                THEN 1 ELSE 0 END) as total_tidak_hadir,
            SUM(CASE WHEN rp.attendance_code IN ($cutiCodes, 'S') THEN 1 ELSE 0 END) as total_cuti,
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
        ", FALSE);
        $this->db->from($this->table . ' rp');
        $this->db->join('user u', 'u.id = rp.user_id', 'left');
        $this->db->join('unit un', 'un.id_unit = u.unit_kerja', 'left');
        $this->db->join('role r', 'r.id = u.type_user', 'left');

        if (!empty($unit_id)) {
            $this->db->where('u.unit_kerja', $unit_id);
        }

        if (!empty($user_id)) {
            $this->db->where('rp.user_id', $user_id);
        }

        if (!empty($start_date)) {
            $this->db->where('rp.date >=', $start_date);
        }

        if (!empty($end_date)) {
            $this->db->where('rp.date <=', $end_date);
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('rp.nik', $search);
            $this->db->or_like('u.nama', $search);
            $this->db->or_like('un.kode_unit', $search);
            $this->db->or_like('r.name_role', $search);
            $this->db->group_end();
        }

        $this->db->group_by(array('rp.user_id', 'rp.nik', 'u.nama', 'un.kode_unit', 'un.name_unit', 'r.name_role'));
        $this->db->order_by('total_tidak_hadir', 'DESC');
        $this->db->order_by('total_terlambat', 'DESC');
        $this->db->order_by('u.nama', 'ASC');

        $result = $this->db->get()->result_array();

        // Hitung 3 Persentase untuk Setiap Personil
        foreach ($result as &$row) {
            $total_rec = (int)$row['total_record'];
            $total_off = (int)$row['total_off'];
            $total_hadir = (int)$row['total_hadir'];
            $total_late = (int)$row['total_terlambat'];

            $hari_efektif = max(0, $total_rec - $total_off);
            $row['total_hari_efektif'] = $hari_efektif;

            // 1. % Kehadiran = (Total Masuk / Hari Kerja Efektif) * 100%
            $pct_hadir = ($hari_efektif > 0) ? min(100, max(0, round(($total_hadir / $hari_efektif) * 100, 1))) : 0;
            $row['persen_kehadiran'] = $pct_hadir;

            // 2. % Ketepatan Waktu = ((Total Masuk - Total Terlambat) / Total Masuk) * 100%
            $pct_tepat = ($total_hadir > 0) ? min(100, max(0, round((($total_hadir - $total_late) / $total_hadir) * 100, 1))) : 0;
            $row['persen_tepat_waktu'] = $pct_tepat;

            // 3. % Total Skor = Rata-rata % Kehadiran & % Ketepatan Waktu
            $pct_total = round(($pct_hadir + $pct_tepat) / 2, 1);
            $row['persen_total'] = $pct_total;
        }

        return $result;
    }

    /**
     * Mengambil data agregasi untuk grafik statistik
     */
    public function get_chart_summary($unit_id = null, $start_date = null, $end_date = null, $user_id = null, $include_office = false) {
        $isLateSql = $this->sql_is_late();
        $cutiCodes = "'CTP', 'CL', 'CIU', 'CM', 'IMIK', 'TGS', 'CH', 'CMA', 'CKA', 'CBA', 'CKM', 'CRM', 'CK', 'CIH', 'CKTN', 'CTSPB', 'CTPDP', 'I'";

        // 1. Distribusi Status Kehadiran
        $this->db->select("
            SUM(CASE 
                WHEN (rp.attendance_code IN ('H', 'T') OR (rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-'))
                     AND (rp.check_out IS NOT NULL AND rp.check_out != '' AND rp.check_out != '-')
                     AND (rp.attendance_code IS NULL OR rp.attendance_code NOT IN ('TAP', 'S', 'A', 'UL', $cutiCodes))
                     AND NOT ($isLateSql) 
                THEN 1 ELSE 0 END) as tepat_waktu,
            SUM(CASE WHEN $isLateSql THEN 1 ELSE 0 END) as terlambat,
            SUM(CASE 
                WHEN ((rp.attendance_code IN ('H', 'T') OR (rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-'))
                     AND (rp.check_out IS NOT NULL AND rp.check_out != '' AND rp.check_out != '-'))
                     AND (rp.attendance_code IS NULL OR rp.attendance_code NOT IN ('TAP', 'A', 'UL', 'S', $cutiCodes))
                THEN 1 ELSE 0 END) as hadir_real,
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
                THEN 1 ELSE 0 END) as total_masuk,
            SUM(CASE 
                WHEN rp.attendance_code = 'TAP' 
                     OR (
                         (LOWER(rp.shift) NOT LIKE '%off%' AND LOWER(rp.shift) NOT LIKE '%dayoff%' AND LOWER(rp.shift) NOT LIKE '%libur%')
                         AND (rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-')
                         AND (rp.check_out IS NULL OR rp.check_out = '' OR rp.check_out = '-')
                     )
                THEN 1 ELSE 0 END) as tap,
            SUM(CASE 
                WHEN rp.attendance_code = 'A' 
                     OR (
                         (LOWER(rp.shift) NOT LIKE '%off%' AND LOWER(rp.shift) NOT LIKE '%dayoff%' AND LOWER(rp.shift) NOT LIKE '%libur%')
                         AND (rp.check_in IS NULL OR rp.check_in = '' OR rp.check_in = '-')
                         AND (rp.attendance_code IS NULL OR rp.attendance_code = '' OR rp.attendance_code = '0' OR rp.attendance_code = '-')
                     )
                THEN 1 ELSE 0 END) as alpha,
            SUM(CASE WHEN rp.attendance_code = 'UL' THEN 1 ELSE 0 END) as ul,
            SUM(CASE 
                WHEN rp.attendance_code IN ('A', 'UL') 
                     OR (
                         (LOWER(rp.shift) NOT LIKE '%off%' AND LOWER(rp.shift) NOT LIKE '%dayoff%' AND LOWER(rp.shift) NOT LIKE '%libur%')
                         AND (rp.check_in IS NULL OR rp.check_in = '' OR rp.check_in = '-')
                         AND (rp.attendance_code IS NULL OR rp.attendance_code = '' OR rp.attendance_code = '0' OR rp.attendance_code = '-')
                     )
                THEN 1 ELSE 0 END) as tidak_hadir,
            SUM(CASE WHEN rp.attendance_code IN ($cutiCodes) THEN 1 ELSE 0 END) as izin,
            SUM(CASE WHEN rp.attendance_code = 'S' THEN 1 ELSE 0 END) as sakit,
            SUM(CASE WHEN rp.attendance_code IN ($cutiCodes, 'S') THEN 1 ELSE 0 END) as cuti_izin_sakit,
            SUM(CASE 
                WHEN (LOWER(rp.shift) LIKE '%off%' OR LOWER(rp.shift) LIKE '%dayoff%' OR LOWER(rp.shift) LIKE '%libur%') 
                     OR (
                         (rp.attendance_code = '' OR rp.attendance_code IS NULL) 
                         AND (rp.check_in IS NULL OR rp.check_in = '' OR rp.check_in = '-') 
                         AND (rp.check_out IS NULL OR rp.check_out = '' OR rp.check_out = '-')
                     )
                THEN 1 ELSE 0 END) as day_off,
            COUNT(rp.id) as total_data,
            COUNT(rp.id) as total_hari
        ", FALSE);
        $this->db->from($this->table . ' rp');
        $this->db->join('user u', 'u.id = rp.user_id', 'left');
        if (!empty($unit_id)) $this->db->where('u.unit_kerja', $unit_id);
        if (!empty($user_id)) $this->db->where('rp.user_id', $user_id);
        if (!empty($start_date)) $this->db->where('rp.date >=', $start_date);
        if (!empty($end_date)) $this->db->where('rp.date <=', $end_date);
        $status_summary = $this->db->get()->row_array();

        // 2. Statistik Kategori per Unit Kerja (Top 10)
        $this->db->select("
            COALESCE(un.kode_unit, 'Lainnya') as unit_nama,
            SUM(CASE 
                WHEN ((rp.attendance_code IN ('H', 'T') OR (rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-'))
                     AND (rp.check_out IS NOT NULL AND rp.check_out != '' AND rp.check_out != '-'))
                     AND (rp.attendance_code IS NULL OR rp.attendance_code NOT IN ('TAP', 'A', 'UL', 'S', $cutiCodes))
                THEN 1 ELSE 0 END) as hadir_real,
            SUM(CASE WHEN $isLateSql THEN 1 ELSE 0 END) as terlambat,
            SUM(CASE 
                WHEN rp.attendance_code = 'TAP' 
                     OR (
                         (LOWER(rp.shift) NOT LIKE '%off%' AND LOWER(rp.shift) NOT LIKE '%dayoff%' AND LOWER(rp.shift) NOT LIKE '%libur%')
                         AND (rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-')
                         AND (rp.check_out IS NULL OR rp.check_out = '' OR rp.check_out = '-')
                     )
                THEN 1 ELSE 0 END) as tap,
            SUM(CASE WHEN rp.attendance_code IN ($cutiCodes, 'S') THEN 1 ELSE 0 END) as cuti,
            SUM(CASE 
                WHEN rp.attendance_code = 'A' 
                     OR (
                         (LOWER(rp.shift) NOT LIKE '%off%' AND LOWER(rp.shift) NOT LIKE '%dayoff%' AND LOWER(rp.shift) NOT LIKE '%libur%')
                         AND (rp.check_in IS NULL OR rp.check_in = '' OR rp.check_in = '-')
                         AND (rp.attendance_code IS NULL OR rp.attendance_code = '' OR rp.attendance_code = '0' OR rp.attendance_code = '-')
                     )
                THEN 1 ELSE 0 END) as alpha,
            SUM(CASE WHEN rp.attendance_code = 'UL' THEN 1 ELSE 0 END) as ul
        ", FALSE);
        $this->db->from($this->table . ' rp');
        $this->db->join('user u', 'u.id = rp.user_id', 'left');
        $this->db->join('unit un', 'un.id_unit = u.unit_kerja', 'left');
        if (!empty($unit_id)) $this->db->where('u.unit_kerja', $unit_id);
        if (!empty($user_id)) $this->db->where('rp.user_id', $user_id);
        if (!empty($start_date)) $this->db->where('rp.date >=', $start_date);
        if (!empty($end_date)) $this->db->where('rp.date <=', $end_date);
        $this->db->group_by("COALESCE(un.kode_unit, 'Lainnya')");
        $this->db->order_by("hadir_real", "DESC");
        $this->db->limit(10);
        $unit_summary = $this->db->get()->result_array();

        // 3. Trend Kehadiran Harian
        $this->db->select("
            rp.date,
            SUM(CASE 
                WHEN ((rp.attendance_code IN ('H', 'T') OR (rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-'))
                     AND (rp.check_out IS NOT NULL AND rp.check_out != '' AND rp.check_out != '-'))
                     AND (rp.attendance_code IS NULL OR rp.attendance_code NOT IN ('TAP', 'A', 'UL', 'S', $cutiCodes))
                THEN 1 ELSE 0 END) as hadir_real,
            SUM(CASE WHEN $isLateSql THEN 1 ELSE 0 END) as terlambat,
            SUM(CASE 
                WHEN rp.attendance_code = 'TAP' 
                     OR (
                         (LOWER(rp.shift) NOT LIKE '%off%' AND LOWER(rp.shift) NOT LIKE '%dayoff%' AND LOWER(rp.shift) NOT LIKE '%libur%')
                         AND (rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-')
                         AND (rp.check_out IS NULL OR rp.check_out = '' OR rp.check_out = '-')
                     )
                THEN 1 ELSE 0 END) as tap,
            SUM(CASE WHEN rp.attendance_code IN ($cutiCodes, 'S') THEN 1 ELSE 0 END) as cuti,
            SUM(CASE 
                WHEN rp.attendance_code = 'A' 
                     OR (
                         (LOWER(rp.shift) NOT LIKE '%off%' AND LOWER(rp.shift) NOT LIKE '%dayoff%' AND LOWER(rp.shift) NOT LIKE '%libur%')
                         AND (rp.check_in IS NULL OR rp.check_in = '' OR rp.check_in = '-')
                         AND (rp.attendance_code IS NULL OR rp.attendance_code = '' OR rp.attendance_code = '0' OR rp.attendance_code = '-')
                     )
                THEN 1 ELSE 0 END) as alpha,
            SUM(CASE WHEN rp.attendance_code = 'UL' THEN 1 ELSE 0 END) as ul
        ", FALSE);
        $this->db->from($this->table . ' rp');
        $this->db->join('user u', 'u.id = rp.user_id', 'left');
        if (!empty($unit_id)) $this->db->where('u.unit_kerja', $unit_id);
        if (!empty($user_id)) $this->db->where('rp.user_id', $user_id);
        if (!empty($start_date)) $this->db->where('rp.date >=', $start_date);
        if (!empty($end_date)) $this->db->where('rp.date <=', $end_date);
        $this->db->group_by("rp.date");
        $this->db->order_by("rp.date", "ASC");
        $this->db->limit(31);
        $trend_summary = $this->db->get()->result_array();

        // 4. Analisis Performa Unit Kerja (% Hadir, % Tepat, % Total)
        // Unit teknis: 14 s/d 27 (NVA, SVA, EU, UPS&CONV, PS1, PS2, PS3, HVMV, EN, EP, T1, T2, T3, NTES) + 30 (Cleaning Gardu)
        // Unit 28 (Office) hanya diikutsertakan jika akun super / password khusus valid
        $target_unit_ids = [14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 30];
        if ($include_office) {
            $target_unit_ids[] = 28;
        }
        $targetUnitIdsStr = implode(',', $target_unit_ids);

        $dateCond = "";
        if (!empty($start_date)) {
            $dateCond .= " AND rp.date >= " . $this->db->escape($start_date);
        }
        if (!empty($end_date)) {
            $dateCond .= " AND rp.date <= " . $this->db->escape($end_date);
        }

        $sql_unit_perf = "
            SELECT 
                un.id_unit,
                un.kode_unit,
                un.name_unit,
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
                    THEN 1 ELSE 0 END) as total_masuk,
                SUM(CASE 
                    WHEN ((rp.attendance_code IN ('H', 'T') OR (rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-'))
                         AND (rp.check_out IS NOT NULL AND rp.check_out != '' AND rp.check_out != '-'))
                         AND (rp.attendance_code IS NULL OR rp.attendance_code NOT IN ('TAP', 'A', 'UL', 'S', $cutiCodes))
                    THEN 1 ELSE 0 END) as total_hadir_fisik,
                SUM(CASE WHEN rp.attendance_code IN ($cutiCodes, 'S') THEN 1 ELSE 0 END) as total_cuti,
                SUM(CASE 
                    WHEN rp.attendance_code = 'TAP' 
                         OR (
                             (LOWER(rp.shift) NOT LIKE '%off%' AND LOWER(rp.shift) NOT LIKE '%dayoff%' AND LOWER(rp.shift) NOT LIKE '%libur%')
                             AND (rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-')
                             AND (rp.check_out IS NULL OR rp.check_out = '' OR rp.check_out = '-')
                         )
                    THEN 1 ELSE 0 END) as total_tap,
                SUM(CASE 
                    WHEN (LOWER(rp.shift) LIKE '%off%' OR LOWER(rp.shift) LIKE '%dayoff%' OR LOWER(rp.shift) LIKE '%libur%') 
                         OR (
                             (rp.attendance_code = '' OR rp.attendance_code IS NULL) 
                             AND (rp.check_in IS NULL OR rp.check_in = '' OR rp.check_in = '-') 
                             AND (rp.check_out IS NULL OR rp.check_out = '' OR rp.check_out = '-')
                         )
                    THEN 1 ELSE 0 END) as total_off,
                SUM(CASE WHEN $isLateSql THEN 1 ELSE 0 END) as total_terlambat
            FROM unit un
            LEFT JOIN user u ON u.unit_kerja = un.id_unit AND u.status != 8
            LEFT JOIN {$this->table} rp ON rp.user_id = u.id $dateCond
            WHERE un.id_unit IN ($targetUnitIdsStr)
            GROUP BY un.id_unit, un.kode_unit, un.name_unit
            ORDER BY FIELD(un.id_unit, $targetUnitIdsStr)
        ";

        $unit_perf_raw = $this->db->query($sql_unit_perf)->result_array();
        $unit_performance = [];
        foreach ($unit_perf_raw as $up) {
            $rec = (int)$up['total_record'];
            $off = (int)$up['total_off'];
            $masuk = (int)$up['total_masuk'];
            $late = (int)$up['total_terlambat'];

            $efektif = max(0, $rec - $off);
            $pct_hadir = ($efektif > 0) ? min(100, max(0, round(($masuk / $efektif) * 100, 1))) : 0;
            $pct_tepat = ($masuk > 0) ? min(100, max(0, round((($masuk - $late) / $masuk) * 100, 1))) : 0;
            $pct_total = round(($pct_hadir + $pct_tepat) / 2, 1);

            $up['total_hari_efektif'] = $efektif;
            $up['persen_kehadiran']   = $pct_hadir;
            $up['persen_tepat_waktu'] = $pct_tepat;
            $up['persen_total']       = $pct_total;
            $unit_performance[] = $up;
        }

        return [
            'status_summary'   => $status_summary,
            'unit_summary'     => $unit_summary,
            'trend_summary'    => $trend_summary,
            'unit_performance' => $unit_performance,
            'office_included'  => $include_office
        ];
    }
}
