<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Coach_personil
 * 
 * Module Coaching Personil - HMVC
 * Semua business logic utama berada di Controller.
 * Model MOD.php hanya digunakan sebagai helper query database.
 */
class Coach_personil extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    // =========================================================================
    // DATABASE HELPER METHODS (FAIL-SAFE UNTUK WINDOWS & LINUX PRODUCTION)
    // =========================================================================
    private function getRow($sql) {
        return $this->db->query($sql)->row_array();
    }

    private function getResult($sql) {
        return $this->db->query($sql)->result_array();
    }

    private function insert_db($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    private function update_db($table, $where, $data) {
        $this->db->where($where);
        return $this->db->update($table, $data);
    }

    private function delete_db($table, $where) {
        $this->db->where($where);
        return $this->db->delete($table);
    }

    private function countRows($sql) {
        return $this->db->query($sql)->num_rows();
    }

    /**
     * Cek otentikasi login
     */
    private function role() {
        if (session("username") == "") {
            redirect(base_url('login/auth'));
        }
    }

    /**
     * Cek apakah user adalah super admin
     */
    private function isSuperAdmin() {
        $sess = sess();
        return (isset($sess['type_user']) && $sess['type_user'] == 'super') || 
               (isset($sess['username']) && $sess['username'] == 'iassomcgk');
    }

    /**
     * Helper: Ambil daftar ID Unit yang diizinkan untuk user saat ini.
     * - Super Admin (atau username/password iassomcgk): return null (semua unit).
     * - Senior Koordinator (Role 101 atau user di role_sk_manager): return array id_unit binaan.
     * - User biasa / login individu password sendiri: return array [$sess['unit']] (hanya unit sendiri).
     */
    private function getUserAssignedUnitIds() {
        if ($this->isSuperAdmin()) {
            return null;
        }

        $sess = sess();
        $user_id = $sess['id'] ?? 0;
        $id_role = $sess['type_user'] ?? 0;

        // 1. Cek apakah user memiliki mapping unit di role_sk_manager per id_user
        if (!empty($user_id)) {
            $this->db->select('id_unit');
            $this->db->from('role_sk_manager');
            $this->db->where('id_user', (int)$user_id);
            $this->db->where('status !=', 8);
            $sk_units = $this->db->get()->result_array();

            if (!empty($sk_units)) {
                return array_values(array_unique(array_map('intval', array_column($sk_units, 'id_unit'))));
            }
        }

        // 2. Jika tidak ditemukan per id_user, cek per id_role (misal role 101 / Senior Koordinator)
        if (!empty($id_role)) {
            $this->db->select('id_unit');
            $this->db->from('role_sk_manager');
            $this->db->where('id_role', (int)$id_role);
            $this->db->where('status !=', 8);
            $sk_role_units = $this->db->get()->result_array();

            if (!empty($sk_role_units)) {
                return array_values(array_unique(array_map('intval', array_column($sk_role_units, 'id_unit'))));
            }
        }

        // 3. Fallback: unit tunggal dari session user (login individu)
        $user_unit = $sess['unit'] ?? 0;
        return !empty($user_unit) ? [(int)$user_unit] : [];
    }

    /**
     * Helper: Hitung periode berdasarkan semester
     */
    private function getPeriode($tahun, $semester) {
        if ($semester == 'SMT 1') {
            return [
                'start' => $tahun . '-01-01',
                'end'   => $tahun . '-06-30'
            ];
        } else {
            return [
                'start' => $tahun . '-07-01',
                'end'   => $tahun . '-12-31'
            ];
        }
    }

    /**
     * Helper SQL: Deteksi keterlambatan (toleransi 10 menit) - reuse dari existing
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

    // =========================================================================
    // HALAMAN UTAMA
    // =========================================================================

    /**
     * Halaman Utama Coaching Personil
     */
    public function index() {
        $this->role();

        $data["plugin"][]  = "plugin/select2";
        $data["title"]     = "Coaching Personil";
        $data["title_des"] = "Penentuan & Pengelolaan Coaching Personil Berdasarkan Hasil Asesmen";
        $data["content"]   = "v_index";

        $allowed_units = $this->getUserAssignedUnitIds();
        $data['is_super_admin'] = $this->isSuperAdmin();
        $data['allowed_units']  = $allowed_units;

        // Urutan standar: Office (28), unit operasional teknik, dan Cleaning Gardu (30)
        $standard_order = "FIELD(id_unit, 28, 21, 22, 23, 18, 19, 20, 14, 15, 16, 17, 24, 25, 26, 27, 30) = 0, FIELD(id_unit, 28, 21, 22, 23, 18, 19, 20, 14, 15, 16, 17, 24, 25, 26, 27, 30)";

        // Ambil data unit sesuai hak akses
        if ($allowed_units === null) {
            $data['units'] = $this->db->where('status !=', 8)
                                      ->order_by($standard_order, '', FALSE)
                                      ->get('unit')
                                      ->result_array();
        } else if (!empty($allowed_units)) {
            $data['units'] = $this->db->where_in('id_unit', $allowed_units)
                                      ->where('status !=', 8)
                                      ->order_by($standard_order, '', FALSE)
                                      ->get('unit')
                                      ->result_array();
        } else {
            $data['units'] = [];
        }

        $this->load->view('template_v2', $data);
    }

    // =========================================================================
    // AJAX: LOAD DATA PERSONIL
    // =========================================================================

    /**
     * AJAX: Load daftar personil berdasarkan filter
     * Logic utama Perihal Hasil Asesmen vs Lainnya
     */
    public function LoadData() {
        $tahun    = $this->input->post('tahun');
        $semester = $this->input->post('semester');
        $bulan    = $this->input->post('bulan');
        $perihal  = $this->input->post('perihal');
        $unit_id  = $this->input->post('unit_id');
        $user_id  = $this->input->post('user_id');
        $search   = trim($this->input->post('search') ?? '');
        $status_coach_filter = $this->input->post('status_coach') ?? 'all'; // all, belum, sudah

        // Validasi wajib
        if (empty($tahun) || empty($semester) || empty($perihal)) {
            echo json_encode([
                'status'  => false,
                'message' => 'Tahun, Semester, dan Perihal wajib diisi.',
                'data'    => []
            ]);
            return;
        }

        // Role restriction via getUserAssignedUnitIds (mendukung role_sk_manager & single unit)
        $allowed_units = $this->getUserAssignedUnitIds();
        if ($allowed_units !== null) {
            if (!empty($unit_id)) {
                // User memilih unit tertentu di filter: pastikan ada di unit binaannya
                if (!in_array((int)$unit_id, $allowed_units)) {
                    $unit_id = $allowed_units;
                } else {
                    $unit_id = (int)$unit_id;
                }
            } else {
                // User memilih "-- Semua Unit Kerja --": filter mencakup seluruh unit binaannya
                $unit_id = $allowed_units;
            }
        }

        $ada_asesmen      = $this->input->post('ada_asesmen') !== null ? (int)$this->input->post('ada_asesmen') : 1;
        $include_cbt      = $this->input->post('include_cbt') !== null ? (int)$this->input->post('include_cbt') : 1;
        $include_wwc      = $this->input->post('include_wwc') !== null ? (int)$this->input->post('include_wwc') : 1;
        $include_presensi = $this->input->post('include_presensi') !== null ? (int)$this->input->post('include_presensi') : 1;

        if ($perihal == 'Hasil Asesmen' && !$include_cbt && !$include_wwc && !$include_presensi) {
            $include_presensi = 1;
        }

        $res = $this->getFilteredPersonilData($tahun, $semester, $perihal, $ada_asesmen, $unit_id, $user_id, $search, $status_coach_filter, $include_cbt, $include_wwc, $include_presensi);

        echo json_encode(array_merge([
            'status'           => true,
            'perihal'          => $perihal,
            'ada_asesmen'      => $ada_asesmen,
            'include_cbt'      => $include_cbt,
            'include_wwc'      => $include_wwc,
            'include_presensi' => $include_presensi
        ], $res));
    }

    /**
     * Helper: Dapatkan personil beserta status target & coaching terfilter
     */
    private function getFilteredPersonilData($tahun, $semester, $perihal, $ada_asesmen = 1, $unit_id = null, $user_id = null, $search = '', $status_coach_filter = 'all', $include_cbt = 1, $include_wwc = 1, $include_presensi = 1) {
        $periode = $this->getPeriode($tahun, $semester);
        $start_date = $periode['start'];
        $end_date   = $periode['end'];

        $is_automated = ($perihal == 'Hasil Asesmen' && $ada_asesmen == 1) || ($perihal == 'Evaluasi Presensi' && $ada_asesmen == 1);

        if ($perihal == 'Hasil Asesmen' && $ada_asesmen == 1) {
            $data = $this->loadDataHasilAsesmen($start_date, $end_date, $unit_id, $user_id, $search, $include_cbt, $include_wwc, $include_presensi);
        } else if ($perihal == 'Evaluasi Presensi' && $ada_asesmen == 1) {
            $data = $this->loadDataEvaluasiPresensi($start_date, $end_date, $unit_id, $user_id, $search);
        } else {
            $data = $this->loadDataLainnya($unit_id, $user_id, $search);
        }

        // Ambil data target personil yang ditetapkan (untuk mode manual / SMT 1)
        $where_target = "tahun = '" . $this->db->escape_str($tahun) . "' AND semester = '" . $this->db->escape_str($semester) . "' AND perihal = '" . $this->db->escape_str($perihal) . "'";
        $where_coach  = "c.tahun = '" . $this->db->escape_str($tahun) . "' AND c.semester = '" . $this->db->escape_str($semester) . "' AND c.perihal = '" . $this->db->escape_str($perihal) . "' AND c.status != 8";

        if ($unit_id !== null && $unit_id !== '') {
            if (is_array($unit_id)) {
                if (!empty($unit_id)) {
                    $where_target .= " AND id_unit IN (" . implode(',', $unit_id) . ")";
                    $where_coach  .= " AND c.id_unit IN (" . implode(',', $unit_id) . ")";
                } else {
                    $where_target .= " AND id_unit = 0";
                    $where_coach  .= " AND c.id_unit = 0";
                }
            } else {
                $where_target .= " AND id_unit = " . (int)$unit_id;
                $where_coach  .= " AND c.id_unit = " . (int)$unit_id;
            }
        }
        $target_records = $this->getResult("
            SELECT user_id FROM coach_target_personil
            WHERE $where_target
        ");
        $target_map = [];
        foreach ($target_records as $tr) {
            $target_map[$tr['user_id']] = true;
        }
        $coaching_records = $this->getResult("
            SELECT c.id_coaching, c.user_id, c.tanggal_coaching, c.status, c.perihal, c.tahun, c.semester, c.created_at, u_coach.nama as nama_atasan
            FROM coach_coaching c
            LEFT JOIN user u_coach ON u_coach.id = c.created_by
            WHERE $where_coach
            ORDER BY c.id_coaching ASC
        ");

        $coached_map = [];
        foreach ($coaching_records as $cr) {
            $coached_map[$cr['user_id']] = $cr;
            // Yang sudah punya dokumen coaching otomatis diakui sebagai target coaching
            $target_map[$cr['user_id']] = true;
        }

        // Tambahkan informasi status target & coaching ke setiap personil
        $filtered_data = [];
        $total_target = 0;
        $total_sudah = 0;
        $total_belum = 0;
        $total_tidak_target = 0;

        foreach ($data as $p) {
            $uid = $p['user_id'];
            $is_coached = isset($coached_map[$uid]);

            if ($is_automated) {
                // Di mode otomatis (SMT 2 nilai asesmen): seluruh baris yang lolos adalah target
                $is_target = true;
            } else {
                // Di mode manual (SMT 1 / Evaluasi Presensi manual): ditentukan oleh target_map
                $is_target = isset($target_map[$uid]);
            }

            $p['is_target'] = $is_target;
            $p['is_coached'] = $is_coached;
            if ($is_coached) {
                $p['id_coaching']        = $coached_map[$uid]['id_coaching'];
                $p['tanggal_coaching']   = $coached_map[$uid]['tanggal_coaching'];
                $p['status_coaching_db'] = $coached_map[$uid]['status'];
                $p['nama_atasan']        = $coached_map[$uid]['nama_atasan'] ?? '-';
            } else {
                $p['id_coaching']        = null;
                $p['tanggal_coaching']   = null;
                $p['status_coaching_db'] = null;
                $p['nama_atasan']        = '-';
            }

            if ($is_target) {
                $total_target++;
                if ($is_coached) {
                    $total_sudah++;
                } else {
                    $total_belum++;
                }
            } else {
                $total_tidak_target++;
            }

            // Filter status coaching
            if ($status_coach_filter == 'target' && !$is_target) {
                continue;
            }
            if ($status_coach_filter == 'tidak_target' && $is_target) {
                continue;
            }
            if ($status_coach_filter == 'sudah' && !$is_coached) {
                continue;
            }
            if ($status_coach_filter == 'belum') {
                if ($is_automated) {
                    if ($is_coached) continue;
                } else {
                    if (!$is_target || $is_coached) continue;
                }
            }

            $filtered_data[] = $p;
        }

        return [
            'data'               => $filtered_data,
            'total'              => count($filtered_data),
            'total_all'          => count($data),
            'total_target'       => $total_target,
            'total_sudah'        => $total_sudah,
            'total_belum'        => $total_belum,
            'total_tidak_target' => $total_tidak_target,
            'is_automated'       => $is_automated,
            'periode_start'      => $start_date,
            'periode_end'        => $end_date
        ];
    }

    // =========================================================================
    // AJAX: GRAFIK & STATISTIK COACHING
    // =========================================================================

    /**
     * AJAX: Ambil data statistik & komparasi coaching per unit untuk Tab Grafik
     * Mendukung multi-role:
     * - Super Admin / iassomcgk: seluruh 16 unit (14 unit operasional + Office 28 + Cleaning Gardu 30)
     * - Role 101 / Senior Koordinator: unit binaannya dari tabel role_sk_manager
     * - Login individu: hanya unit miliknya sendiri
     */
    public function get_grafik_data() {
        $tahun    = $this->input->post('tahun') ?: date('Y');
        $semester = $this->input->post('semester') ?: 'SMT 1';
        $perihal  = $this->input->post('perihal') ?: 'Hasil Asesmen'; // Hasil Asesmen, Evaluasi Presensi, Semua
        $unit_id  = $this->input->post('unit_id');

        $allowed_units = $this->getUserAssignedUnitIds();

        // Urutan standar: Office (28), HVMV (21), EN (22), EP (23), PS1 (18), PS2 (19), PS3 (20),
        // NVA (14), SVA (15), EU (16), UPS&CONV (17), T1 (24), T2 (25), T3 (26), NTES (27), CG (30)
        $standard_unit_order = [28, 21, 22, 23, 18, 19, 20, 14, 15, 16, 17, 24, 25, 26, 27, 30];

        // Tentukan target unit IDs
        if ($allowed_units === null) {
            // Super Admin / iassomcgk: semua unit terpilih
            if (!empty($unit_id) && $unit_id !== 'all') {
                $target_unit_ids = [(int)$unit_id];
            } else {
                $target_unit_ids = $standard_unit_order;
            }
        } else {
            // Role 101 / SK Manager / Individu
            if (empty($allowed_units)) {
                $target_unit_ids = [];
            } else if (!empty($unit_id) && $unit_id !== 'all' && in_array((int)$unit_id, $allowed_units)) {
                $target_unit_ids = [(int)$unit_id];
            } else {
                // Tampilkan seluruh unit yang diizinkan untuk SK Manager / individu
                $target_unit_ids = array_values(array_intersect($standard_unit_order, $allowed_units));
                if (empty($target_unit_ids)) {
                    $target_unit_ids = $allowed_units;
                }
            }
        }

        if (empty($target_unit_ids)) {
            echo json_encode([
                'status'   => true,
                'tahun'    => $tahun,
                'semester' => $semester,
                'perihal'  => $perihal,
                'data'     => [],
                'summary'  => [
                    'total_unit'     => 0,
                    'total_personil' => 0,
                    'total_target'   => 0,
                    'total_sudah'    => 0,
                    'total_belum'    => 0,
                    'persentase'     => 0
                ]
            ]);
            return;
        }

        // 1. Ambil detail master unit
        $this->db->select('id_unit, kode_unit, name_unit');
        $this->db->from('unit');
        $this->db->where_in('id_unit', $target_unit_ids);
        $this->db->where('status !=', 8);
        $this->db->order_by('FIELD(id_unit, ' . implode(',', $target_unit_ids) . ')', '', FALSE);
        $units_db = $this->db->get()->result_array();

        // 2. Ambil total personil aktif per unit
        $this->db->select('unit_kerja as id_unit, COUNT(id) as total_personil');
        $this->db->from('user');
        $this->db->where_in('unit_kerja', $target_unit_ids);
        $this->db->where('status !=', 8);
        $this->db->where_not_in('type_user', [2, 4, 99, 5, 6, 104, 105, 106, 108]);
        $this->db->group_by('unit_kerja');
        $personil_counts = $this->db->get()->result_array();
        $personil_map = [];
        foreach ($personil_counts as $pc) {
            $personil_map[$pc['id_unit']] = (int)$pc['total_personil'];
        }

        // 3. Ambil data personil yang SUDAH di-coaching pada periode & perihal ini
        $where_coach = "status != 8 AND tahun = '" . $this->db->escape_str($tahun) . "' AND semester = '" . $this->db->escape_str($semester) . "'";
        if (!empty($perihal) && $perihal != 'Semua') {
            $where_coach .= " AND perihal = '" . $this->db->escape_str($perihal) . "'";
        }
        $where_coach .= " AND id_unit IN (" . implode(',', $target_unit_ids) . ")";

        $coached_query = $this->db->query("
            SELECT id_unit, COUNT(DISTINCT user_id) as total_sudah
            FROM coach_coaching
            WHERE $where_coach
            GROUP BY id_unit
        ")->result_array();

        $coached_map = [];
        foreach ($coached_query as $cq) {
            $coached_map[$cq['id_unit']] = (int)$cq['total_sudah'];
        }

        // 4. Hitung target coaching per unit berdasarkan perihal & periode
        $target_map = [];
        $periode = $this->getPeriode($tahun, $semester);
        if ($perihal == 'Hasil Asesmen' && $semester == 'SMT 2') {
            $asesmen_data = $this->loadDataHasilAsesmen($periode['start'], $periode['end'], $target_unit_ids, null, '', 1, 1, 1);
            foreach ($asesmen_data as $ad) {
                $uid = $ad['id_unit'];
                $target_map[$uid] = ($target_map[$uid] ?? 0) + 1;
            }
        } else {
            // SMT 1 atau mode manual (Evaluasi Presensi): ambil dari coach_target_personil UNION coach_coaching
            $where_target = "id_unit IN (" . implode(',', $target_unit_ids) . ") AND tahun = '" . $this->db->escape_str($tahun) . "' AND semester = '" . $this->db->escape_str($semester) . "'";
            if (!empty($perihal) && $perihal != 'Semua') {
                $where_target .= " AND perihal = '" . $this->db->escape_str($perihal) . "'";
            }

            $target_query = $this->db->query("
                SELECT id_unit, COUNT(DISTINCT user_id) as total_target
                FROM (
                    SELECT id_unit, user_id FROM coach_target_personil WHERE $where_target
                    UNION
                    SELECT id_unit, user_id FROM coach_coaching WHERE $where_target AND status != 8
                ) as combined_targets
                GROUP BY id_unit
            ")->result_array();

            foreach ($target_query as $tq) {
                $target_map[$tq['id_unit']] = (int)$tq['total_target'];
            }
        }

        // 5. Susun data rekap per unit
        $list_data = [];
        $sum_personil = 0;
        $sum_target   = 0;
        $sum_sudah    = 0;
        $sum_belum    = 0;

        foreach ($units_db as $u) {
            $id_u   = (int)$u['id_unit'];
            $tot_p  = $personil_map[$id_u] ?? 0;
            $tot_s  = $coached_map[$id_u] ?? 0;
            $tot_t  = $target_map[$id_u] ?? 0;

            $tot_t_display = max($tot_t, $tot_s);
            $tot_b = max(0, $tot_t_display - $tot_s);
            $pct = ($tot_t_display > 0) ? min(100, round(($tot_s / $tot_t_display) * 100, 1)) : ($tot_s > 0 ? 100 : 0);

            $sum_personil += $tot_p;
            $sum_target   += $tot_t_display;
            $sum_sudah    += $tot_s;
            $sum_belum    += $tot_b;

            $list_data[] = [
                'id_unit'        => $id_u,
                'kode_unit'      => $u['kode_unit'],
                'name_unit'      => $u['name_unit'],
                'total_personil' => $tot_p,
                'total_target'   => $tot_t_display,
                'total_sudah'    => $tot_s,
                'total_belum'    => $tot_b,
                'persentase'     => $pct
            ];
        }

        $overall_pct = ($sum_target > 0) ? min(100, round(($sum_sudah / $sum_target) * 100, 1)) : 0;

        echo json_encode([
            'status'   => true,
            'tahun'    => $tahun,
            'semester' => $semester,
            'perihal'  => $perihal,
            'data'     => $list_data,
            'summary'  => [
                'total_unit'     => count($list_data),
                'total_personil' => $sum_personil,
                'total_target'   => $sum_target,
                'total_sudah'    => $sum_sudah,
                'total_belum'    => $sum_belum,
                'persentase'     => $overall_pct
            ]
        ]);
    }

    /**
     * Logic: Perihal = Hasil Asesmen
     * Ambil CBT + WWC + Presensi (Dinamis sesuai opsi aktif) -> Hitung Nilai Akhir -> Filter < 41
     */
    private function loadDataHasilAsesmen($start_date, $end_date, $unit_id = null, $user_id = null, $search = '', $include_cbt = 1, $include_wwc = 1, $include_presensi = 1) {
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
        $this->db->where('u.status !=', 8);
        $this->db->where('u.unit_kerja IS NOT NULL');
        $this->db->where_not_in('u.type_user', [2, 4, 99, 5, 6, 104, 105, 106, 108]);

        if ($unit_id !== null && $unit_id !== '') {
            if (is_array($unit_id)) {
                if (!empty($unit_id)) {
                    $this->db->where_in('u.unit_kerja', $unit_id);
                } else {
                    $this->db->where('u.unit_kerja', 0);
                }
            } else {
                $this->db->where('u.unit_kerja', (int)$unit_id);
            }
        }
        if (!empty($user_id)) {
            $this->db->where('u.id', (int)$user_id);
        }
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('u.nik', $search);
            $this->db->or_like('u.nama', $search);
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

        // 2. Ambil Nilai CBT per user pada periode (hanya jika include_cbt aktif)
        $cbt_map = [];
        if ($include_cbt) {
            $where_cbt_date = "";
            if (!empty($start_date)) {
                $where_cbt_date .= " AND COALESCE(h.tanggal_selesai, h.tanggal_mulai) >= '" . $this->db->escape_str($start_date) . " 00:00:00'";
            }
            if (!empty($end_date)) {
                $where_cbt_date .= " AND COALESCE(h.tanggal_selesai, h.tanggal_mulai) <= '" . $this->db->escape_str($end_date) . " 23:59:59'";
            }

            $cbt_query = $this->db->query("
                SELECT h.id_user,
                       COUNT(h.id_hasil_ujian_cbt) as total_ujian,
                       ROUND(AVG(h.nilai), 2) as avg_nilai_cbt,
                       GROUP_CONCAT(DISTINCT u.nama_ujian_cbt SEPARATOR ', ') as daftar_ujian
                FROM cbt_hasil_ujian h
                LEFT JOIN cbt_ujian u ON u.id_ujian_cbt = h.id_ujian_cbt
                WHERE h.status = 1 AND h.id_user IN (" . implode(',', $user_ids) . ") $where_cbt_date
                GROUP BY h.id_user
            ")->result_array();

            foreach ($cbt_query as $c) {
                $cbt_map[$c['id_user']] = $c;
            }
        }

        // 3. Ambil Nilai Wawancara (WWC) per user pada periode (hanya jika include_wwc aktif)
        $wwc_map = [];
        if ($include_wwc) {
            $where_wwc_date = "";
            if (!empty($start_date)) {
                $where_wwc_date .= " AND (fp.tanggal_penilaian >= '" . $this->db->escape_str($start_date) . "' OR p.tanggal_selesai >= '" . $this->db->escape_str($start_date) . " 00:00:00')";
            }
            if (!empty($end_date)) {
                $where_wwc_date .= " AND (fp.tanggal_penilaian <= '" . $this->db->escape_str($end_date) . "' OR p.tanggal_selesai <= '" . $this->db->escape_str($end_date) . " 23:59:59')";
            }

            $wwc_query = $this->db->query("
                SELECT p.id_peserta,
                       COUNT(DISTINCT p.id_penilaian) as total_penilaian,
                       ROUND(AVG(p.total_nilai), 2) as avg_nilai_wwc,
                       ROUND(AVG(p.persentase), 2) as avg_persen_wwc
                FROM wwc_penilaian p
                LEFT JOIN wwc_form_penilaian fp ON fp.id_form = p.id_form
                WHERE p.id_peserta IN (" . implode(',', $user_ids) . ") $where_wwc_date
                GROUP BY p.id_peserta
            ")->result_array();

            foreach ($wwc_query as $w) {
                $wwc_map[$w['id_peserta']] = $w;
            }
        }

        // 4. Ambil Rekap Presensi per user pada periode (hanya jika include_presensi aktif)
        $presensi_map = [];
        if ($include_presensi) {
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
        }

        // 5. Gabungkan dan kalkulasikan, filter nilai_akhir < 41
        $result = [];
        foreach ($users as $u) {
            $uid = $u['user_id'];

            // CBT
            $cbt_data = $cbt_map[$uid] ?? null;
            $nilai_cbt = !empty($cbt_data) ? (float)$cbt_data['avg_nilai_cbt'] : 0;

            // WWC
            $wwc_data = $wwc_map[$uid] ?? null;
            $nilai_wwc = !empty($wwc_data) ? (float)$wwc_data['avg_nilai_wwc'] : 0;

            // Presensi - formula existing
            $pres_data = $presensi_map[$uid] ?? null;
            $total_rec = !empty($pres_data) ? (int)$pres_data['total_record'] : 0;
            $total_off = !empty($pres_data) ? (int)$pres_data['total_off'] : 0;
            $total_hadir = !empty($pres_data) ? (int)$pres_data['total_hadir'] : 0;
            $total_late = !empty($pres_data) ? (int)$pres_data['total_terlambat'] : 0;

            $hari_efektif = max(0, $total_rec - $total_off);
            $pct_hadir = ($hari_efektif > 0) ? min(100, max(0, round(($total_hadir / $hari_efektif) * 100, 1))) : 0;
            $pct_tepat = ($total_hadir > 0) ? min(100, max(0, round((($total_hadir - $total_late) / $total_hadir) * 100, 1))) : 0;
            $skor_presensi = round(($pct_hadir + $pct_tepat) / 2, 1);

            // Hitung Nilai Akhir secara dinamis berdasarkan komponen yang aktif
            $active_comps = ($include_cbt ? 1 : 0) + ($include_wwc ? 1 : 0) + ($include_presensi ? 1 : 0);
            $divisor = max(1, $active_comps);

            $sum_nilai = 0;
            if ($include_cbt) $sum_nilai += $nilai_cbt;
            if ($include_wwc) $sum_nilai += $nilai_wwc;
            if ($include_presensi) $sum_nilai += $skor_presensi;

            $nilai_akhir = round($sum_nilai / $divisor, 2);

            // FILTER: hanya tampilkan personil dengan nilai_akhir < 41
            if ($nilai_akhir < 41) {
                // Kategori
                if ($nilai_akhir >= 85) {
                    $kategori = 'Istimewa';
                    $badge = 'badge-success';
                } elseif ($nilai_akhir >= 70) {
                    $kategori = 'Kompeten';
                    $badge = 'badge-primary';
                } elseif ($nilai_akhir >= 55) {
                    $kategori = 'Cukup';
                    $badge = 'badge-warning text-dark';
                } else {
                    $kategori = 'Perlu Coaching';
                    $badge = 'badge-danger';
                }

                $result[] = [
                    'user_id'         => $uid,
                    'nik'             => $u['nik'],
                    'nama_peserta'    => $u['nama_peserta'],
                    'id_unit'         => $u['id_unit'],
                    'kode_unit'       => $u['kode_unit'] ?? '-',
                    'name_unit'       => $u['name_unit'] ?? '-',
                    'nama_jabatan'    => $u['nama_jabatan'],
                    'nilai_cbt'       => $include_cbt ? $nilai_cbt : null,
                    'nilai_wwc'       => $include_wwc ? $nilai_wwc : null,
                    'skor_presensi'   => $include_presensi ? $skor_presensi : null,
                    'nilai_akhir'     => $nilai_akhir,
                    'kategori'        => $kategori,
                    'kategori_badge'  => $badge,
                    'daftar_ujian'    => ($include_cbt && !empty($cbt_data['daftar_ujian'])) ? $cbt_data['daftar_ujian'] : '-'
                ];
            }
        }

        return $result;
    }

    /**
     * Logic: Perihal = Evaluasi Presensi (Mode Otomatis Rekap Mesin)
     * Ambil rekap_presensi per user -> Hitung skor presensi / keterlambatan -> Filter yang perlu evaluasi
     */
    private function loadDataEvaluasiPresensi($start_date, $end_date, $unit_id = null, $user_id = null, $search = '') {
        $cutiCodes = "'CTP', 'CL', 'CIU', 'CM', 'IMIK', 'TGS', 'CH', 'CMA', 'CKA', 'CBA', 'CKM', 'CRM', 'CK', 'CIH', 'CKTN', 'CTSPB', 'CTPDP', 'I'";
        $isLateSql = $this->sql_is_late();

        // 1. Ambil daftar personil aktif
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
        $this->db->where('u.status !=', 8);
        $this->db->where('u.unit_kerja IS NOT NULL');
        $this->db->where_not_in('u.type_user', [2, 4, 99, 5, 6, 104, 105, 106, 108]);

        if ($unit_id !== null && $unit_id !== '') {
            if (is_array($unit_id)) {
                if (!empty($unit_id)) {
                    $this->db->where_in('u.unit_kerja', $unit_id);
                } else {
                    $this->db->where('u.unit_kerja', 0);
                }
            } else {
                $this->db->where('u.unit_kerja', (int)$unit_id);
            }
        }
        if (!empty($user_id)) {
            $this->db->where('u.id', (int)$user_id);
        }
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('u.nik', $search);
            $this->db->or_like('u.nama', $search);
            $this->db->group_end();
        }

        $users = $this->db->get()->result_array();
        if (empty($users)) {
            return [];
        }

        $user_ids = array_column($users, 'user_id');

        // 2. Query rekap presensi
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

        $presensi_map = [];
        foreach ($presensi_query as $p) {
            $presensi_map[$p['user_id']] = $p;
        }

        // 3. Filter yang performa presensinya perlu evaluasi
        $result = [];
        foreach ($users as $u) {
            $uid = $u['user_id'];
            if (!isset($presensi_map[$uid])) {
                continue;
            }

            $p = $presensi_map[$uid];
            $t_rec = (int)$p['total_record'];
            $t_off = (int)$p['total_off'];
            $t_hadir = (int)$p['total_hadir'];
            $t_late = (int)$p['total_terlambat'];

            $hari_efektif = max(0, $t_rec - $t_off);
            $pct_hadir = ($hari_efektif > 0) ? min(100, max(0, round(($t_hadir / $hari_efektif) * 100, 1))) : 0;
            $pct_tepat = ($t_hadir > 0) ? min(100, max(0, round((($t_hadir - $t_late) / $t_hadir) * 100, 1))) : 0;
            $skor_presensi = round(($pct_hadir + $pct_tepat) / 2, 1);

            if ($skor_presensi < 85 || $t_late >= 3 || $pct_hadir < 90) {
                $result[] = [
                    'user_id'         => $uid,
                    'nik'             => $u['nik'],
                    'nama_peserta'    => $u['nama_peserta'],
                    'id_unit'         => $u['id_unit'],
                    'kode_unit'       => $u['kode_unit'] ?? '-',
                    'name_unit'       => $u['name_unit'] ?? '-',
                    'nama_jabatan'    => $u['nama_jabatan'],
                    'nilai_cbt'       => null,
                    'nilai_wwc'       => null,
                    'skor_presensi'   => $skor_presensi,
                    'nilai_akhir'     => $skor_presensi,
                    'total_hadir'     => $t_hadir,
                    'total_terlambat' => $t_late,
                    'pct_hadir'       => $pct_hadir,
                    'kategori'        => 'Perlu Evaluasi Presensi',
                    'kategori_badge'  => 'badge-warning text-dark'
                ];
            }
        }

        return $result;
    }

    /**
     * Logic: Perihal = Lainnya / Mode Manual
     * Tidak ambil CBT/WWC/Presensi. Tampilkan semua user.
     */
    private function loadDataLainnya($unit_id = null, $user_id = null, $search = '') {
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
        $this->db->where('u.status !=', 8);
        $this->db->where('u.unit_kerja IS NOT NULL');
        $this->db->where_not_in('u.type_user', [2, 4, 99, 5, 6, 104, 105, 106, 108]);

        if ($unit_id !== null && $unit_id !== '') {
            if (is_array($unit_id)) {
                if (!empty($unit_id)) {
                    $this->db->where_in('u.unit_kerja', $unit_id);
                } else {
                    $this->db->where('u.unit_kerja', 0);
                }
            } else {
                $this->db->where('u.unit_kerja', (int)$unit_id);
            }
        }
        if (!empty($user_id)) {
            $this->db->where('u.id', (int)$user_id);
        }
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('u.nik', $search);
            $this->db->or_like('u.nama', $search);
            $this->db->group_end();
        }

        $this->db->order_by('FIELD(u.unit_kerja, 28, 21, 22, 23, 18, 19, 20, 14, 15, 16, 17, 24, 25, 26, 27, 30) = 0, FIELD(u.unit_kerja, 28, 21, 22, 23, 18, 19, 20, 14, 15, 16, 17, 24, 25, 26, 27, 30)', '', FALSE);
        $this->db->order_by('FIELD(u.type_user, 103, 101, 102, 109, 110, 107, 1) = 0, FIELD(u.type_user, 103, 101, 102, 109, 110, 107, 1)', '', FALSE);
        $this->db->order_by('u.nama', 'ASC');
        $users = $this->db->get()->result_array();

        $result = [];
        foreach ($users as $u) {
            $result[] = [
                'user_id'        => $u['user_id'],
                'nik'            => $u['nik'],
                'nama_peserta'   => $u['nama_peserta'],
                'id_unit'        => $u['id_unit'],
                'kode_unit'      => $u['kode_unit'] ?? '-',
                'name_unit'      => $u['name_unit'] ?? '-',
                'nama_jabatan'   => $u['nama_jabatan'],
                'nilai_cbt'      => null,
                'nilai_wwc'      => null,
                'skor_presensi'  => null,
                'nilai_akhir'    => null,
                'kategori'       => '-',
                'kategori_badge' => 'badge-secondary',
                'daftar_ujian'   => '-'
            ];
        }

        return $result;
    }

    /**
     * AJAX: Load personil berdasarkan unit untuk dropdown
     * Mendukung penyaringan dinamis berdasarkan status coaching (target, belum, sudah, dll)
     */
    public function get_users_by_unit() {
        $unit_id          = $this->input->post('unit_id');
        $status_coach     = $this->input->post('status_coach');
        $tahun            = $this->input->post('tahun');
        $semester         = $this->input->post('semester');
        $perihal          = $this->input->post('perihal');
        $ada_asesmen      = $this->input->post('ada_asesmen') !== null ? (int)$this->input->post('ada_asesmen') : 1;
        $include_cbt      = $this->input->post('include_cbt') !== null ? (int)$this->input->post('include_cbt') : 1;
        $include_wwc      = $this->input->post('include_wwc') !== null ? (int)$this->input->post('include_wwc') : 1;
        $include_presensi = $this->input->post('include_presensi') !== null ? (int)$this->input->post('include_presensi') : 1;

        $allowed_units = $this->getUserAssignedUnitIds();

        // Jika dipanggil dari filter dengan konteks status coaching & periode
        if (!empty($status_coach) && !empty($tahun) && !empty($semester) && !empty($perihal)) {
            $target_unit = (!empty($unit_id) || $unit_id === '0' || $unit_id === 0) ? (int)$unit_id : null;
            if ($allowed_units !== null) {
                if ($target_unit !== null) {
                    if (!in_array($target_unit, $allowed_units)) {
                        $target_unit = !empty($allowed_units) ? $allowed_units : [0];
                    }
                } else {
                    $target_unit = !empty($allowed_units) ? $allowed_units : [0];
                }
            }

            if ($perihal == 'Hasil Asesmen' && !$include_cbt && !$include_wwc && !$include_presensi) {
                $include_presensi = 1;
            }

            $filter_res = $this->getFilteredPersonilData(
                $tahun, $semester, $perihal, $ada_asesmen,
                $target_unit, null, '', $status_coach,
                $include_cbt, $include_wwc, $include_presensi
            );

            $users = [];
            foreach ($filter_res['data'] as $p) {
                $unit_suffix = (!empty($p['kode_unit']) && empty($unit_id)) ? ' (' . $p['kode_unit'] . ')' : '';
                $users[] = [
                    'id'        => $p['user_id'],
                    'nik'       => $p['nik'],
                    'nama'      => $p['nama_peserta'] . $unit_suffix,
                    'kode_unit' => $p['kode_unit'] ?? ''
                ];
            }

            echo json_encode([
                'status'       => true,
                'data'         => $users,
                'status_coach' => $status_coach,
                'total'        => count($users)
            ]);
            return;
        }

        // Fallback / legacy mode (misal saat modal penentuan target dibuka): ambil semua user unit
        $this->db->select('id, nik, nama');
        $this->db->from('user');
        $this->db->where('status !=', 8);
        $this->db->where('unit_kerja IS NOT NULL');
        $this->db->where_not_in('type_user', [2, 4, 99, 5, 6, 104, 105, 106, 108]);

        $target_unit = (!empty($unit_id) || $unit_id === '0' || $unit_id === 0) ? (int)$unit_id : null;
        if ($allowed_units !== null) {
            if ($target_unit !== null) {
                if (!in_array($target_unit, $allowed_units)) {
                    $target_unit = !empty($allowed_units) ? $allowed_units : [0];
                }
            } else {
                $target_unit = !empty($allowed_units) ? $allowed_units : [0];
            }
        }

        if ($target_unit !== null) {
            if (is_array($target_unit)) {
                if (!empty($target_unit)) {
                    $this->db->where_in('unit_kerja', $target_unit);
                } else {
                    $this->db->where('unit_kerja', 0);
                }
            } else {
                $this->db->where('unit_kerja', (int)$target_unit);
            }
        }

        $this->db->order_by('FIELD(unit_kerja, 28, 21, 22, 23, 18, 19, 20, 14, 15, 16, 17, 24, 25, 26, 27, 30) = 0, FIELD(unit_kerja, 28, 21, 22, 23, 18, 19, 20, 14, 15, 16, 17, 24, 25, 26, 27, 30)', '', FALSE);
        $this->db->order_by('FIELD(type_user, 103, 101, 102, 109, 110, 107, 1) = 0, FIELD(type_user, 103, 101, 102, 109, 110, 107, 1)', '', FALSE);
        $this->db->order_by('nama', 'ASC');
        $users = $this->db->get()->result_array();

        echo json_encode([
            'status' => true,
            'data'   => $users,
            'total'  => count($users)
        ]);
    }

    /**
     * AJAX: Ambil daftar user_id yang menjadi target coaching di unit & periode ini
     */
    public function get_target_personil() {
        $unit_id  = $this->input->post('unit_id');
        $tahun    = $this->input->post('tahun');
        $semester = $this->input->post('semester');
        $perihal  = $this->input->post('perihal');

        if (empty($unit_id) || empty($tahun) || empty($semester) || empty($perihal)) {
            echo json_encode(['status' => false, 'message' => 'Parameter tidak lengkap.', 'target_ids' => [], 'coached_ids' => []]);
            return;
        }

        $where_target = "id_unit = " . (int)$unit_id . " AND tahun = '" . $this->db->escape_str($tahun) . "' AND semester = '" . $this->db->escape_str($semester) . "' AND perihal = '" . $this->db->escape_str($perihal) . "'";
        $targets = $this->getResult("SELECT user_id FROM coach_target_personil WHERE $where_target");

        $where_coach = "id_unit = " . (int)$unit_id . " AND tahun = '" . $this->db->escape_str($tahun) . "' AND semester = '" . $this->db->escape_str($semester) . "' AND perihal = '" . $this->db->escape_str($perihal) . "' AND status != 8";
        $coached = $this->getResult("SELECT DISTINCT user_id FROM coach_coaching WHERE $where_coach");

        $target_ids = array_unique(array_merge(
            array_map('intval', array_column($targets, 'user_id')),
            array_map('intval', array_column($coached, 'user_id'))
        ));
        $coached_ids = array_map('intval', array_column($coached, 'user_id'));

        echo json_encode([
            'status'      => true,
            'target_ids'  => array_values($target_ids),
            'coached_ids' => array_values($coached_ids)
        ]);
    }

    /**
     * AJAX: Simpan / update daftar personil yang terkena coaching di suatu unit
     */
    public function save_target_personil() {
        $sess = sess();
        $unit_id  = $this->input->post('unit_id');
        $tahun    = $this->input->post('tahun');
        $semester = $this->input->post('semester');
        $perihal  = $this->input->post('perihal');
        $user_ids = $this->input->post('user_ids');

        if (empty($unit_id) || empty($tahun) || empty($semester) || empty($perihal)) {
            echo json_encode(['status' => false, 'message' => 'Unit, Tahun, Semester, dan Perihal wajib diisi.']);
            return;
        }

        $allowed_units = $this->getUserAssignedUnitIds();
        if ($allowed_units !== null && !in_array((int)$unit_id, $allowed_units)) {
            echo json_encode(['status' => false, 'message' => 'Anda tidak memiliki hak akses untuk unit ini.']);
            return;
        }

        if (!is_array($user_ids)) {
            $user_ids = [];
        }
        $user_ids = array_map('intval', $user_ids);

        // Pertahankan yang sudah punya dokumen coaching
        $coached = $this->getResult("
            SELECT DISTINCT user_id FROM coach_coaching
            WHERE id_unit = " . (int)$unit_id . "
            AND tahun = '" . $this->db->escape_str($tahun) . "'
            AND semester = '" . $this->db->escape_str($semester) . "'
            AND perihal = '" . $this->db->escape_str($perihal) . "'
            AND status != 8
        ");
        $coached_ids = array_map('intval', array_column($coached, 'user_id'));
        $all_targets = array_unique(array_merge($user_ids, $coached_ids));

        if (!empty($coached_ids)) {
            $this->db->where('id_unit', (int)$unit_id);
            $this->db->where('tahun', $tahun);
            $this->db->where('semester', $semester);
            $this->db->where('perihal', $perihal);
            $this->db->where_not_in('user_id', $coached_ids);
            $this->db->delete('coach_target_personil');
        } else {
            $this->db->where('id_unit', (int)$unit_id);
            $this->db->where('tahun', $tahun);
            $this->db->where('semester', $semester);
            $this->db->where('perihal', $perihal);
            $this->db->delete('coach_target_personil');
        }

        $now = date('Y-m-d H:i:s');
        $by = $sess['id'] ?? null;
        foreach ($all_targets as $uid) {
            if ($uid <= 0) continue;
            $this->db->query("
                INSERT IGNORE INTO coach_target_personil (user_id, id_unit, tahun, semester, perihal, keterangan, created_by, created_at)
                VALUES ($uid, " . (int)$unit_id . ", '" . $this->db->escape_str($tahun) . "', '" . $this->db->escape_str($semester) . "', '" . $this->db->escape_str($perihal) . "', 'Ditetapkan oleh atasan/admin', " . (int)$by . ", '$now')
            ");
        }

        echo json_encode([
            'status'       => true,
            'message'      => 'Penetapan personil terkena coaching berhasil disimpan.',
            'total_target' => count($all_targets)
        ]);
    }

    // =========================================================================
    // DETAIL 4 TAB
    // =========================================================================

    /**
     * AJAX: Load detail personil untuk 4 tab
     */
    public function detail() {
        $user_id    = $this->input->post('user_id');
        $start_date = $this->input->post('start_date');
        $end_date   = $this->input->post('end_date');

        if (empty($user_id)) {
            echo json_encode(['status' => false, 'message' => 'User ID wajib.']);
            return;
        }

        $cutiCodes = "'CTP', 'CL', 'CIU', 'CM', 'IMIK', 'TGS', 'CH', 'CMA', 'CKA', 'CBA', 'CKM', 'CRM', 'CK', 'CIH', 'CKTN', 'CTSPB', 'CTPDP', 'I'";
        $isLateSql = $this->sql_is_late();

        // Data Personil
        $peserta = $this->getRow("
            SELECT u.id as user_id, u.nik, u.nama as nama_peserta,
                   un.id_unit, un.kode_unit, un.name_unit,
                   COALESCE(NULLIF(u.jabatan, ''), r.name_role, '-') as nama_jabatan
            FROM user u
            LEFT JOIN unit un ON un.id_unit = u.unit_kerja
            LEFT JOIN role r ON r.id = u.type_user
            WHERE u.id = " . (int)$user_id
        );

        if (empty($peserta)) {
            echo json_encode(['status' => false, 'message' => 'Personil tidak ditemukan.']);
            return;
        }

        // TAB 1: CBT
        $where_cbt = "";
        if (!empty($start_date)) {
            $where_cbt .= " AND COALESCE(h.tanggal_selesai, h.tanggal_mulai) >= '" . $this->db->escape_str($start_date) . " 00:00:00'";
        }
        if (!empty($end_date)) {
            $where_cbt .= " AND COALESCE(h.tanggal_selesai, h.tanggal_mulai) <= '" . $this->db->escape_str($end_date) . " 23:59:59'";
        }

        $cbt_list = $this->getResult("
            SELECT h.id_hasil_ujian_cbt, h.nilai, h.jumlah_benar, h.jumlah_selesai, h.jumlah_kosong,
                   h.tanggal_mulai, h.tanggal_selesai,
                   COALESCE(h.tanggal_selesai, h.tanggal_mulai) as tanggal_ujian,
                   u.nama_ujian_cbt, u.jumlah_soal
            FROM cbt_hasil_ujian h
            LEFT JOIN cbt_ujian u ON u.id_ujian_cbt = h.id_ujian_cbt
            WHERE h.status = 1 AND h.id_user = " . (int)$user_id . " $where_cbt
            ORDER BY h.id_hasil_ujian_cbt DESC
        ");

        $avg_nilai_cbt = !empty($cbt_list) ? round(array_sum(array_column($cbt_list, 'nilai')) / count($cbt_list), 2) : 0;

        // TAB 2: Wawancara (WWC)
        $where_wwc = "";
        if (!empty($start_date)) {
            $where_wwc .= " AND (fp.tanggal_penilaian >= '" . $this->db->escape_str($start_date) . "' OR p.tanggal_selesai >= '" . $this->db->escape_str($start_date) . " 00:00:00')";
        }
        if (!empty($end_date)) {
            $where_wwc .= " AND (fp.tanggal_penilaian <= '" . $this->db->escape_str($end_date) . "' OR p.tanggal_selesai <= '" . $this->db->escape_str($end_date) . " 23:59:59')";
        }

        $wwc_list = $this->getResult("
            SELECT p.id_penilaian, p.total_nilai, p.persentase, p.kesimpulan, p.rekomendasi, p.tanggal_selesai,
                   fp.kode_form, fp.nama_form, fp.tanggal_penilaian,
                   u_assessor.nama as nama_assessor
            FROM wwc_penilaian p
            LEFT JOIN wwc_form_penilaian fp ON fp.id_form = p.id_form
            LEFT JOIN wwc_form_assessor fa ON fa.id_form_assessor = p.id_form_assessor
            LEFT JOIN user u_assessor ON u_assessor.id = fa.id_user
            WHERE p.id_peserta = " . (int)$user_id . " $where_wwc
            ORDER BY p.id_penilaian ASC
        ");

        $avg_nilai_wwc = !empty($wwc_list) ? round(array_sum(array_column($wwc_list, 'total_nilai')) / count($wwc_list), 2) : 0;

        // TAB 3: Rekap Presensi
        $where_date = "";
        if (!empty($start_date)) {
            $where_date .= " AND rp.date >= '" . $this->db->escape_str($start_date) . "'";
        }
        if (!empty($end_date)) {
            $where_date .= " AND rp.date <= '" . $this->db->escape_str($end_date) . "'";
        }

        $presensi_summary = $this->getRow("
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
                   SUM(CASE WHEN rp.attendance_code = 'TAP' OR (
                       (LOWER(rp.shift) NOT LIKE '%off%' AND LOWER(rp.shift) NOT LIKE '%dayoff%' AND LOWER(rp.shift) NOT LIKE '%libur%')
                       AND (rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-')
                       AND (rp.check_out IS NULL OR rp.check_out = '' OR rp.check_out = '-')
                   ) THEN 1 ELSE 0 END) as total_tap,
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
        ");

        $t_rec = (int)($presensi_summary['total_record'] ?? 0);
        $t_off = (int)($presensi_summary['total_off'] ?? 0);
        $t_hadir = (int)($presensi_summary['total_hadir'] ?? 0);
        $t_late = (int)($presensi_summary['total_terlambat'] ?? 0);

        $hari_efektif = max(0, $t_rec - $t_off);
        $pct_hadir = ($hari_efektif > 0) ? min(100, max(0, round(($t_hadir / $hari_efektif) * 100, 1))) : 0;
        $pct_tepat = ($t_hadir > 0) ? min(100, max(0, round((($t_hadir - $t_late) / $t_hadir) * 100, 1))) : 0;
        $skor_presensi = round(($pct_hadir + $pct_tepat) / 2, 1);

        // TAB 4: Hasil Asesmen
        $nilai_akhir = round(($avg_nilai_cbt + $avg_nilai_wwc + $skor_presensi) / 3, 2);

        // Cek status coaching yang sudah ada untuk periode & perihal ini
        $tahun = $this->input->post('tahun');
        $semester = $this->input->post('semester');
        $perihal = $this->input->post('perihal');
        $where_coach = "user_id = " . (int)$user_id . " AND status != 8";
        if (!empty($tahun)) {
            $where_coach .= " AND tahun = '" . $this->db->escape_str($tahun) . "'";
        }
        if (!empty($semester)) {
            $where_coach .= " AND semester = '" . $this->db->escape_str($semester) . "'";
        }
        if (!empty($perihal)) {
            $where_coach .= " AND perihal = '" . $this->db->escape_str($perihal) . "'";
        }
        $existing_coaching = $this->getRow("
            SELECT id_coaching, tanggal_coaching, status, tahun, semester, perihal
            FROM coach_coaching
            WHERE $where_coach
            ORDER BY id_coaching DESC
            LIMIT 1
        ");

        $is_coached = !empty($existing_coaching);
        $id_coaching = $is_coached ? (int)$existing_coaching['id_coaching'] : null;
        $tanggal_coaching = $is_coached ? $existing_coaching['tanggal_coaching'] : null;
        $status_coaching_db = $is_coached ? $existing_coaching['status'] : null;

        echo json_encode([
            'status'             => true,
            'peserta'            => $peserta,
            'is_coached'         => $is_coached,
            'id_coaching'        => $id_coaching,
            'tanggal_coaching'   => $tanggal_coaching,
            'status_coaching_db' => $status_coaching_db,
            'cbt' => [
                'list'     => $cbt_list,
                'avg_nilai'=> $avg_nilai_cbt
            ],
            'wwc' => [
                'list'     => $wwc_list,
                'avg_nilai'=> $avg_nilai_wwc
            ],
            'presensi' => [
                'total_record'    => $t_rec,
                'total_hadir'     => $t_hadir,
                'total_terlambat' => $t_late,
                'total_tap'       => (int)($presensi_summary['total_tap'] ?? 0),
                'total_alpha'     => (int)($presensi_summary['total_alpha'] ?? 0),
                'total_ul'        => (int)($presensi_summary['total_ul'] ?? 0),
                'total_izin'      => (int)($presensi_summary['total_izin'] ?? 0),
                'total_sakit'     => (int)($presensi_summary['total_sakit'] ?? 0),
                'total_off'       => $t_off,
                'persen_kehadiran' => $pct_hadir,
                'persen_tepat'    => $pct_tepat,
                'skor_presensi'   => $skor_presensi
            ],
            'hasil_asesmen' => [
                'nilai_cbt'      => $avg_nilai_cbt,
                'nilai_wwc'      => $avg_nilai_wwc,
                'nilai_presensi' => $skor_presensi,
                'nilai_akhir'    => $nilai_akhir,
                'kategori'       => ($nilai_akhir < 41) ? 'Perlu Coaching' : (($nilai_akhir >= 85) ? 'Istimewa' : (($nilai_akhir >= 70) ? 'Kompeten' : (($nilai_akhir >= 55) ? 'Cukup' : 'Perlu Pembinaan')))
            ]
        ]);
    }

    // =========================================================================
    // COACHING CRUD
    // =========================================================================

    /**
     * Halaman Form Coaching (Create & Edit Mode)
     */
    public function form_coaching($id_coaching = null) {
        $this->role();

        if (empty($id_coaching)) {
            $id_coaching = $this->input->get('id_coaching');
        }

        $data["plugin"][]  = "plugin/select2";
        $data["content"]   = "v_form_coaching";

        $coaching = null;
        if (!empty($id_coaching)) {
            $coaching = $this->getRow("
                SELECT c.*, 
                       u.nik, u.nama as nama_personil,
                       COALESCE(NULLIF(u.jabatan, ''), r.name_role, '-') as nama_jabatan,
                       un.id_unit, un.kode_unit, un.name_unit,
                       ua.nama as nama_atasan
                FROM coach_coaching c
                LEFT JOIN user u ON u.id = c.user_id
                LEFT JOIN role r ON r.id = u.type_user
                LEFT JOIN unit un ON un.id_unit = COALESCE(NULLIF(c.id_unit, 0), u.unit_kerja)
                LEFT JOIN user ua ON ua.id = c.atasan_id
                WHERE c.id_coaching = " . (int)$id_coaching . "
                AND c.status != 8
            ");
        }

        if (!empty($coaching)) {
            // EDIT MODE
            $data['is_edit']     = true;
            $data['id_coaching'] = (int)$id_coaching;
            $data['title']       = "Edit Dokumen Coaching Personil";
            $data['title_des']   = "Perbarui Data & Rencana Aksi Coaching Karyawan";
            $data['coaching']    = $coaching;

            $data['personil'] = [
                'id'           => $coaching['user_id'],
                'nik'          => $coaching['nik'],
                'nama'         => $coaching['nama_personil'],
                'jabatan'      => $coaching['nama_jabatan'],
                'nama_jabatan' => $coaching['nama_jabatan'],
                'id_unit'      => $coaching['id_unit'],
                'kode_unit'    => $coaching['kode_unit'],
                'name_unit'    => $coaching['name_unit']
            ];

            $data['tahun']            = $coaching['tahun'];
            $data['semester']         = $coaching['semester'];
            $data['bulan']            = $coaching['bulan'];
            $data['perihal']          = $coaching['perihal'];
            $data['tanggal_coaching'] = $coaching['tanggal_coaching'];

            $data['periode_start'] = $coaching['periode_start'];
            $data['periode_end']   = $coaching['periode_end'];

            $data['nilai_cbt']      = $coaching['nilai_cbt'];
            $data['nilai_wwc']      = $coaching['nilai_wawancara'];
            $data['nilai_presensi'] = $coaching['nilai_presensi'];
            $data['nilai_akhir']    = $coaching['nilai_akhir'];

            $has_asesmen = ($coaching['perihal'] == 'Hasil Asesmen') && 
                           ($coaching['nilai_akhir'] !== null || $coaching['nilai_cbt'] !== null || $coaching['nilai_wawancara'] !== null);
            $data['has_asesmen'] = $has_asesmen;

            // Performance Gaps
            $saved_gaps = $this->getResult("SELECT * FROM coach_performance_gap WHERE id_coaching = " . (int)$id_coaching);
            $gaps_map = [];
            foreach ($saved_gaps as $sg) {
                $gaps_map[$sg['area_gap']] = $sg;
            }
            $data['saved_gaps'] = $gaps_map;

            // Root Causes
            $saved_rc = $this->getResult("SELECT * FROM coach_root_cause WHERE id_coaching = " . (int)$id_coaching);
            $rc_map = [];
            foreach ($saved_rc as $sr) {
                $rc_map[$sr['root_cause']] = $sr;
            }
            $data['saved_root_causes'] = $rc_map;

            // Action Plans
            $data['saved_action_plans'] = $this->getResult("SELECT * FROM coach_action_plan WHERE id_coaching = " . (int)$id_coaching . " ORDER BY id_action_plan ASC");

            // Commitment
            $data['saved_commitment'] = $this->getRow("SELECT * FROM coach_commitment WHERE id_coaching = " . (int)$id_coaching . " LIMIT 1");

            // Dokumentasi Foto
            $data['saved_dokumentasi'] = $this->getResult("SELECT * FROM coach_dokumentasi WHERE id_coaching = " . (int)$id_coaching . " ORDER BY id_dokumentasi ASC");

            // 7. Monitoring
            $data['saved_monitorings'] = $this->getResult("
                SELECT m.*, u.nama as nama_created_by
                FROM coach_monitoring m
                LEFT JOIN user u ON u.id = m.created_by
                WHERE m.id_coaching = " . (int)$id_coaching . "
                ORDER BY m.tanggal ASC, m.id_monitoring ASC
            ");

            // 8. Evaluasi
            $data['saved_evaluation'] = $this->getRow("SELECT * FROM coach_evaluation WHERE id_coaching = " . (int)$id_coaching . " LIMIT 1");

            // 9. Feedback
            $data['saved_feedback'] = $this->getRow("SELECT * FROM coach_feedback WHERE id_coaching = " . (int)$id_coaching . " LIMIT 1");
        } else {
            // CREATE MODE
            $data['is_edit']     = false;
            $data['id_coaching'] = null;
            $data['title']       = "Form Coaching Personil";
            $data['title_des']   = "Formulir Coaching Karyawan";
            $data['coaching']    = null;

            $user_id  = $this->input->get('user_id');
            $tahun    = $this->input->get('tahun');
            $semester = $this->input->get('semester');
            $bulan    = $this->input->get('bulan');
            $perihal  = $this->input->get('perihal');

            $data['personil'] = $this->getRow("
                SELECT u.id, u.nik, u.nama,
                       COALESCE(NULLIF(u.jabatan, ''), r.name_role, '-') as nama_jabatan,
                       COALESCE(NULLIF(u.jabatan, ''), r.name_role, '-') as jabatan,
                       un.id_unit, un.kode_unit, un.name_unit
                FROM user u
                LEFT JOIN unit un ON un.id_unit = u.unit_kerja
                LEFT JOIN role r ON r.id = u.type_user
                WHERE u.id = " . (int)$user_id
            );

            $data['tahun']            = $tahun;
            $data['semester']         = $semester;
            $data['bulan']            = $bulan;
            $data['perihal']          = $perihal;
            $data['tanggal_coaching'] = date('Y-m-d');

            $periode = $this->getPeriode($tahun, $semester);
            $data['periode_start'] = $periode['start'];
            $data['periode_end']   = $periode['end'];

            $data['nilai_cbt']      = $this->input->get('nilai_cbt');
            $data['nilai_wwc']      = $this->input->get('nilai_wwc');
            $data['nilai_presensi'] = $this->input->get('nilai_presensi');
            $data['nilai_akhir']    = $this->input->get('nilai_akhir');

            $get_has = $this->input->get('has_asesmen');
            $has_asesmen = ($perihal == 'Hasil Asesmen') && 
                           ($get_has === '1' || ($get_has === null && $data['nilai_akhir'] !== null && $data['nilai_akhir'] !== ''));
            $data['has_asesmen'] = $has_asesmen;

            $data['saved_gaps']         = [];
            $data['saved_root_causes']   = [];
            $data['saved_action_plans'] = [];
            $data['saved_commitment']   = null;
            $data['saved_dokumentasi']  = [];
            $data['saved_monitorings']  = [];
            $data['saved_evaluation']   = null;
            $data['saved_feedback']     = null;
        }

        // Performance gap areas
        if ($data['perihal'] == 'Evaluasi Presensi') {
            $data['area_gaps'] = ['Presensi'];
        } else {
            $data['area_gaps'] = [
                'Pengetahuan Dasar', 'Pengetahuan Teknis Peralatan', 'Pengetahuan SOP',
                'Pemahaman Penerapan K3', 'Keterampilan Pengoperasian Peralatan',
                'Keterampilan Penggunaan Alat Kerja', 'Keterampilan Komunikasi',
                'Keterampilan Pemecahan Masalah', 'Keterampilan Analitis',
                'Inisiatif', 'Jujur', 'Tanggung Jawab', 'Disiplin', 'Komitmen',
                'Etika Adab', 'Kepedulian', 'Kerjasama', 'Kepemimpinan',
                'Kerapihan', 'Pelayanan Pelanggan'
            ];
        }

        // Root cause options
        $data['root_causes'] = [
            'Kurang Memahami Pekerjaan', 'Kurang Keterampilan', 'Kurang Disiplin',
            'Kurang Motivasi', 'Beban Kerja Tinggi', 'Masalah Komunikasi',
            'Faktor Pribadi', 'Sarana Kerja Kurang Memadai', 'Lainnya'
        ];

        $this->load->view('template_v2', $data);
    }

    /**
     * AJAX: Cek duplikasi coaching
     */
    public function check_duplicate() {
        $user_id  = $this->input->post('user_id');
        $tahun    = $this->input->post('tahun');
        $semester = $this->input->post('semester');
        $perihal  = $this->input->post('perihal');
        $id_coaching = $this->input->post('id_coaching');

        $where = "user_id = " . (int)$user_id . "
            AND tahun = '" . $this->db->escape_str($tahun) . "'
            AND semester = '" . $this->db->escape_str($semester) . "'
            AND perihal = '" . $this->db->escape_str($perihal) . "'
            AND status != 8";

        if (!empty($id_coaching)) {
            $where .= " AND id_coaching != " . (int)$id_coaching;
        }

        $count = $this->countRows("SELECT id_coaching FROM coach_coaching WHERE $where");

        echo json_encode([
            'status'    => true,
            'duplicate' => ($count > 0),
            'count'     => $count
        ]);
    }

    /**
     * AJAX: Simpan coaching baru / Update coaching (header + performance gap + root cause + action plan + commitment)
     */
    public function save_coaching() {
        $sess = sess();

        $id_coaching = $this->input->post('id_coaching');
        $is_edit = !empty($id_coaching);

        // Validasi wajib
        $user_id  = $this->input->post('user_id');
        $tahun    = $this->input->post('tahun');
        $semester = $this->input->post('semester');
        $perihal  = $this->input->post('perihal');
        $tanggal  = $this->input->post('tanggal_coaching');

        if (empty($user_id) || empty($tahun) || empty($semester) || empty($perihal) || empty($tanggal)) {
            echo json_encode(['status' => false, 'message' => 'Data wajib tidak lengkap.']);
            return;
        }

        $periode = $this->getPeriode($tahun, $semester);

        $id_unit = $this->input->post('id_unit');
        if (empty($id_unit)) {
            $user_unit = $this->getRow("SELECT unit_kerja FROM user WHERE id = " . (int)$user_id);
            $id_unit = $user_unit['unit_kerja'] ?? null;
        }

        // Siapkan data header coaching
        $coaching_data = [
            'user_id'          => (int)$user_id,
            'id_unit'          => $id_unit ? (int)$id_unit : null,
            'tahun'            => $tahun,
            'semester'         => $semester,
            'bulan'            => $this->input->post('bulan'),
            'perihal'          => $perihal,
            'periode_start'    => $periode['start'],
            'periode_end'      => $periode['end'],
            'tanggal_coaching' => $tanggal,
            'atasan_id'        => $sess['id'] ?? null
        ];

        // Snapshot nilai hanya untuk Perihal = Hasil Asesmen
        if ($perihal == 'Hasil Asesmen') {
            $cbt_val   = $this->input->post('nilai_cbt');
            $wwc_val   = $this->input->post('nilai_wawancara');
            $pres_val  = $this->input->post('nilai_presensi');
            $akhir_val = $this->input->post('nilai_akhir');

            $coaching_data['nilai_cbt']       = ($cbt_val !== '' && $cbt_val !== null) ? $cbt_val : null;
            $coaching_data['nilai_wawancara']  = ($wwc_val !== '' && $wwc_val !== null) ? $wwc_val : null;
            $coaching_data['nilai_presensi']   = ($pres_val !== '' && $pres_val !== null) ? $pres_val : null;
            $coaching_data['nilai_akhir']      = ($akhir_val !== '' && $akhir_val !== null) ? $akhir_val : null;
            $coaching_data['kategori_nilai']   = $coaching_data['nilai_akhir'] !== null ? 'Perlu Coaching' : null;
        } else {
            // Perihal lainnya: nilai NULL
            $coaching_data['nilai_cbt']       = null;
            $coaching_data['nilai_wawancara']  = null;
            $coaching_data['nilai_presensi']   = null;
            $coaching_data['nilai_akhir']      = null;
            $coaching_data['kategori_nilai']   = null;
        }

        // Handle Foto Bukti Coaching (Upload File / Webcam Base64)
        $foto_path = null;
        $path_info = $this->get_upload_path($tahun, $semester, $perihal, $coaching_data['id_unit']);

        // A. Cek jika ada base64 dari kamera webcam
        $foto_base64 = $this->input->post('foto_bukti_base64');
        if (!empty($foto_base64) && strpos($foto_base64, 'data:image') === 0) {
            $foto_parts = explode(',', $foto_base64);
            $foto_decoded = base64_decode($foto_parts[1] ?? '');
            if ($foto_decoded) {
                $filename = 'bukti_coaching_' . $user_id . '_' . $tahun . '_' . time() . '.jpg';
                file_put_contents($path_info['absolute'] . $filename, $foto_decoded);
                $foto_path = $path_info['relative'] . $filename;
            }
        } 
        // B. Cek jika ada upload file dari input file / kamera HP
        else if (isset($_FILES['foto_bukti']) && !empty($_FILES['foto_bukti']['name']) && $_FILES['foto_bukti']['error'] == 0) {
            $ext = strtolower(pathinfo($_FILES['foto_bukti']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                $filename = 'bukti_coaching_' . $user_id . '_' . $tahun . '_' . time() . '.' . $ext;
                if (move_uploaded_file($_FILES['foto_bukti']['tmp_name'], $path_info['absolute'] . $filename)) {
                    $foto_path = $path_info['relative'] . $filename;
                }
            }
        }

        if (!empty($foto_path)) {
            $coaching_data['foto_dokumentasi'] = $foto_path;
        }

        // Handle Tanda Tangan Digital (TTD Peserta & TTD Coach)
        // 1. TTD Peserta
        $ttd_peserta_base64 = $this->input->post('ttd_peserta_base64');
        if (!empty($ttd_peserta_base64) && strpos($ttd_peserta_base64, 'data:image') === 0) {
            $ttd_path_p = $this->get_ttd_path($perihal, $coaching_data['id_unit'], 'peserta');
            $ttd_clean = str_replace('data:image/png;base64,', '', $ttd_peserta_base64);
            $ttd_clean = str_replace(' ', '+', $ttd_clean);
            $decoded_ttd = base64_decode($ttd_clean);
            if ($decoded_ttd !== false && strlen($decoded_ttd) > 50) {
                $filename_ttd_p = 'ttd_peserta_' . $user_id . '_' . date('Ymd_His') . '.png';
                file_put_contents($ttd_path_p['absolute'] . $filename_ttd_p, $decoded_ttd);
                $coaching_data['ttd_peserta'] = $ttd_path_p['relative'] . $filename_ttd_p;
            }
        }

        // 2. TTD Coach
        $ttd_coach_base64 = $this->input->post('ttd_coach_base64');
        if (!empty($ttd_coach_base64) && strpos($ttd_coach_base64, 'data:image') === 0) {
            $ttd_path_c = $this->get_ttd_path($perihal, $coaching_data['id_unit'], 'coach');
            $ttd_clean = str_replace('data:image/png;base64,', '', $ttd_coach_base64);
            $ttd_clean = str_replace(' ', '+', $ttd_clean);
            $decoded_ttd = base64_decode($ttd_clean);
            if ($decoded_ttd !== false && strlen($decoded_ttd) > 50) {
                $filename_ttd_c = 'ttd_coach_' . ($sess['id'] ?? $user_id) . '_' . date('Ymd_His') . '.png';
                file_put_contents($ttd_path_c['absolute'] . $filename_ttd_c, $decoded_ttd);
                $coaching_data['ttd_coach'] = $ttd_path_c['relative'] . $filename_ttd_c;
            }
        }

        if ($is_edit) {
            $coaching_data['updated_at'] = date('Y-m-d H:i:s');
            $this->update_db('coach_coaching', ['id_coaching' => (int)$id_coaching], $coaching_data);
            $target_id_coaching = (int)$id_coaching;
        } else {
            $coaching_data['status']     = 1;
            $coaching_data['created_by'] = $sess['id'] ?? null;
            $coaching_data['created_at'] = date('Y-m-d H:i:s');
            $target_id_coaching = $this->insert_db('coach_coaching', $coaching_data);

            // Sinkronkan ke coach_target_personil agar personil ini tercatat sebagai target
            if ($target_id_coaching) {
                $this->db->query("
                    INSERT IGNORE INTO coach_target_personil (user_id, id_unit, tahun, semester, perihal, keterangan, created_by, created_at)
                    VALUES (" . (int)$user_id . ", " . (int)$coaching_data['id_unit'] . ", '" . $this->db->escape_str($tahun) . "', '" . $this->db->escape_str($semester) . "', '" . $this->db->escape_str($perihal) . "', 'Otomatis sinkron saat coaching dibuat', " . (int)($sess['id'] ?? 0) . ", '" . date('Y-m-d H:i:s') . "')
                ");
            }
        }

        if (!$target_id_coaching) {
            echo json_encode(['status' => false, 'message' => 'Gagal menyimpan data coaching.']);
            return;
        }

        // Insert ke tabel coach_dokumentasi jika ada foto baru
        if (!empty($foto_path)) {
            $this->insert_db('coach_dokumentasi', [
                'id_coaching' => $target_id_coaching,
                'file_path'   => $foto_path,
                'file_name'   => basename($foto_path),
                'created_at'  => date('Y-m-d H:i:s')
            ]);
        }

        // Simpan / Sinkronisasi Performance Gap
        if ($is_edit) {
            $this->delete_db('coach_performance_gap', ['id_coaching' => $target_id_coaching]);
        }
        $gaps = $this->input->post('gaps');
        if (!empty($gaps) && is_array($gaps)) {
            foreach ($gaps as $gap) {
                if (!empty($gap['area_gap'])) {
                    $this->insert_db('coach_performance_gap', [
                        'id_coaching' => $target_id_coaching,
                        'area_gap'    => $gap['area_gap'],
                        'status_gap'  => $gap['status_gap'] ?? null,
                        'catatan'     => $gap['catatan'] ?? null,
                        'created_at'  => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }

        // Simpan / Sinkronisasi Root Cause
        if ($is_edit) {
            $this->delete_db('coach_root_cause', ['id_coaching' => $target_id_coaching]);
        }
        $root_causes = $this->input->post('root_causes');
        if (!empty($root_causes) && is_array($root_causes)) {
            foreach ($root_causes as $rc) {
                if (!empty($rc['root_cause'])) {
                    $this->insert_db('coach_root_cause', [
                        'id_coaching' => $target_id_coaching,
                        'root_cause'  => $rc['root_cause'],
                        'catatan'     => $rc['catatan'] ?? null,
                        'created_at'  => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }

        // Simpan / Sinkronisasi Action Plans
        if ($is_edit) {
            $this->delete_db('coach_action_plan', ['id_coaching' => $target_id_coaching]);
        }
        $action_plans = $this->input->post('action_plans');
        if (!empty($action_plans) && is_array($action_plans)) {
            foreach ($action_plans as $ap) {
                if (!empty($ap['sasaran_perbaikan'])) {
                    $this->insert_db('coach_action_plan', [
                        'id_coaching'           => $target_id_coaching,
                        'sasaran_perbaikan'     => $ap['sasaran_perbaikan'],
                        'target'                => $ap['target'] ?? null,
                        'indikator_keberhasilan'=> $ap['indikator_keberhasilan'] ?? null,
                        'deadline'              => !empty($ap['deadline']) ? $ap['deadline'] : null,
                        'dukungan_atasan'       => $ap['dukungan_atasan'] ?? null,
                        'status'                => $ap['status'] ?? 'Belum Mulai',
                        'created_at'            => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }

        // Simpan / Sinkronisasi Commitment
        if ($is_edit) {
            $this->delete_db('coach_commitment', ['id_coaching' => $target_id_coaching]);
        }
        $commitment = $this->input->post('commitment');
        if (!empty($commitment)) {
            $this->insert_db('coach_commitment', [
                'id_coaching'         => $target_id_coaching,
                'komitmen_karyawan'   => $commitment['komitmen_karyawan'] ?? null,
                'nama_karyawan'       => $commitment['nama_karyawan'] ?? null,
                'tanggal_karyawan'    => !empty($commitment['tanggal_karyawan']) ? $commitment['tanggal_karyawan'] : null,
                'arahan'              => $commitment['arahan'] ?? null,
                'pendampingan'        => $commitment['pendampingan'] ?? null,
                'pelatihan'           => $commitment['pelatihan'] ?? null,
                'monitoring_mingguan' => $commitment['monitoring_mingguan'] ?? null,
                'monitoring_bulanan'  => $commitment['monitoring_bulanan'] ?? null,
                'catatan_atasan'      => $commitment['catatan_atasan'] ?? null,
                'created_at'          => date('Y-m-d H:i:s')
            ]);
        }

        // 7. Simpan / Sinkronisasi Monitoring Progres
        if ($is_edit) {
            $this->delete_db('coach_monitoring', ['id_coaching' => $target_id_coaching]);
        }
        $monitorings = $this->input->post('monitorings');
        if (!empty($monitorings) && is_array($monitorings)) {
            foreach ($monitorings as $m) {
                if (!empty($m['progres']) || !empty($m['tindak_lanjut']) || !empty($m['kendala'])) {
                    $this->insert_db('coach_monitoring', [
                        'id_coaching'   => $target_id_coaching,
                        'tanggal'       => !empty($m['tanggal']) ? $m['tanggal'] : date('Y-m-d'),
                        'progres'       => $m['progres'] ?? null,
                        'kendala'       => $m['kendala'] ?? null,
                        'tindak_lanjut' => $m['tindak_lanjut'] ?? null,
                        'paraf_atasan'  => $m['paraf_atasan'] ?? null,
                        'created_by'    => $sess['id'] ?? null,
                        'created_at'    => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }

        // 8. Simpan / Sinkronisasi Evaluasi Akhir Coaching
        $evaluation = $this->input->post('evaluation');
        if (!empty($evaluation)) {
            $existing_eval = $this->countRows("SELECT id_evaluation FROM coach_evaluation WHERE id_coaching = " . (int)$target_id_coaching);
            $eval_data = [
                'id_coaching'       => (int)$target_id_coaching,
                'target_tercapai'   => $evaluation['target_tercapai'] ?? null,
                'ada_peningkatan'   => $evaluation['ada_peningkatan'] ?? null,
                'coaching_lanjutan'  => $evaluation['coaching_lanjutan'] ?? null,
                'perlu_pelatihan'   => $evaluation['perlu_pelatihan'] ?? null,
                'perlu_tindakan'    => $evaluation['perlu_tindakan'] ?? null,
                'tanggal_evaluasi'  => !empty($evaluation['tanggal_evaluasi']) ? $evaluation['tanggal_evaluasi'] : date('Y-m-d'),
                'catatan_evaluasi'  => $evaluation['catatan_evaluasi'] ?? null,
                'created_by'        => $sess['id'] ?? null
            ];
            if ($existing_eval > 0) {
                $eval_data['updated_at'] = date('Y-m-d H:i:s');
                $this->update_db('coach_evaluation', ['id_coaching' => (int)$target_id_coaching], $eval_data);
            } else {
                $eval_data['created_at'] = date('Y-m-d H:i:s');
                $this->insert_db('coach_evaluation', $eval_data);
            }
        }

        // 9. Simpan / Sinkronisasi Feedback & Masukan
        $feedback = $this->input->post('feedback');
        if (!empty($feedback)) {
            $existing_fb = $this->countRows("SELECT id_feedback FROM coach_feedback WHERE id_coaching = " . (int)$target_id_coaching);
            $fb_data = [
                'id_coaching'        => (int)$target_id_coaching,
                'feedback_perusahaan'=> $feedback['feedback_perusahaan'] ?? null,
                'feedback_tim'       => $feedback['feedback_tim'] ?? null
            ];
            if ($existing_fb > 0) {
                $fb_data['updated_at'] = date('Y-m-d H:i:s');
                $this->update_db('coach_feedback', ['id_coaching' => (int)$target_id_coaching], $fb_data);
            } else {
                $fb_data['created_at'] = date('Y-m-d H:i:s');
                $this->insert_db('coach_feedback', $fb_data);
            }
        }

        echo json_encode([
            'status'      => true,
            'message'     => $is_edit ? 'Dokumen coaching berhasil diperbarui.' : 'Coaching berhasil disimpan.',
            'id_coaching' => $target_id_coaching
        ]);
    }

    /**
     * Helper: Menghasilkan struktur direktori upload sesuai aturan:
     * upload/dokumentasi_coaching/[smt1 2026]/[berdasarkan_filter_perihal]/[id_unit]/
     * Secara otomatis membuat folder jika belum ada.
     */
    private function get_upload_path($tahun, $semester, $perihal, $id_unit = 0) {
        $thn = !empty($tahun) ? $tahun : date('Y');
        
        $smt_clean = (stripos($semester, '1') !== false) ? 'smt1' : 'smt2';
        $periode_folder = $smt_clean . ' ' . $thn;
        
        $perihal_clean = !empty($perihal) ? $perihal : 'hasil_asesmen';
        $perihal_slug  = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $perihal_clean)));
        
        $unit_folder = !empty($id_unit) ? (int)$id_unit : '0';
        $relative_path = 'upload/dokumentasi_coaching/' . $periode_folder . '/' . $perihal_slug . '/' . $unit_folder . '/';
        $absolute_path = FCPATH . $relative_path;
        
        if (!is_dir($absolute_path)) {
            mkdir($absolute_path, 0777, true);
        }
        
        return [
            'relative' => $relative_path,
            'absolute' => $absolute_path
        ];
    }

    /**
     * Helper: Menghasilkan struktur direktori upload TTD:
     * doc/ttd_coaching/[filter_perihal]/[id_unit]/[ttd_peserta|ttd_coach]/
     */
    private function get_ttd_path($perihal, $id_unit = 0, $type = '') {
        $perihal_clean = !empty($perihal) ? $perihal : 'hasil_asesmen';
        $perihal_slug  = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $perihal_clean)));
        $unit_folder   = !empty($id_unit) ? (int)$id_unit : '0';
        
        $subfolder = '';
        if ($type == 'peserta' || $type == 'ttd_peserta') {
            $subfolder = 'ttd_peserta/';
        } elseif ($type == 'coach' || $type == 'ttd_coach') {
            $subfolder = 'ttd_coach/';
        }

        $base_relative = 'doc/ttd_coaching/' . $perihal_slug . '/' . $unit_folder . '/';
        $base_absolute = FCPATH . $base_relative;

        // Pastikan folder root unit dan 2 subfolder ttd_peserta dan ttd_coach selalu dibuat otomatis
        if (!is_dir($base_absolute)) {
            mkdir($base_absolute, 0777, true);
        }
        if (!is_dir($base_absolute . 'ttd_peserta/')) {
            mkdir($base_absolute . 'ttd_peserta/', 0777, true);
        }
        if (!is_dir($base_absolute . 'ttd_coach/')) {
            mkdir($base_absolute . 'ttd_coach/', 0777, true);
        }

        $relative_path = $base_relative . $subfolder;
        $absolute_path = FCPATH . $relative_path;

        return [
            'relative' => $relative_path,
            'absolute' => $absolute_path
        ];
    }

    /**
     * AJAX: Simpan TTD satuan dari modal signature pad
     */
    public function save_ttd_single() {
        $id_coaching = $this->input->post('id_coaching');
        $type        = $this->input->post('type'); // 'peserta' atau 'coach'
        $image_data  = $this->input->post('image_data'); // base64 PNG

        if (empty($id_coaching) || empty($type) || empty($image_data)) {
            echo json_encode(['status' => false, 'message' => 'Data TTD tidak lengkap.']);
            return;
        }

        $coaching = $this->getRow("SELECT * FROM coach_coaching WHERE id_coaching = " . (int)$id_coaching);
        if (empty($coaching)) {
            echo json_encode(['status' => false, 'message' => 'Data coaching tidak ditemukan.']);
            return;
        }

        if (empty($coaching['id_unit'])) {
            $user_unit = $this->getRow("SELECT unit_kerja FROM user WHERE id = " . (int)$coaching['user_id']);
            $coaching['id_unit'] = $user_unit['unit_kerja'] ?? 0;
        }

        $ttd_path_info = $this->get_ttd_path($coaching['perihal'], $coaching['id_unit'], $type);
        $image_clean   = str_replace('data:image/png;base64,', '', $image_data);
        $image_clean   = str_replace(' ', '+', $image_clean);
        $decoded       = base64_decode($image_clean);

        if ($decoded === false || strlen($decoded) < 50) {
            echo json_encode(['status' => false, 'message' => 'Format gambar TTD tidak valid.']);
            return;
        }

        $prefix   = ($type == 'coach') ? 'ttd_coach_' : 'ttd_peserta_';
        $user_ref = ($type == 'coach') ? ($coaching['atasan_id'] ?? $coaching['user_id']) : $coaching['user_id'];
        $filename = $prefix . $user_ref . '_' . date('Ymd_His') . '.png';

        file_put_contents($ttd_path_info['absolute'] . $filename, $decoded);
        $relative_file = $ttd_path_info['relative'] . $filename;

        $col = ($type == 'coach') ? 'ttd_coach' : 'ttd_peserta';
        $this->update_db('coach_coaching', ['id_coaching' => (int)$id_coaching], [
            $col => $relative_file,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        echo json_encode([
            'status'    => true,
            'message'   => 'Tanda tangan ' . ($type == 'coach' ? 'Coach' : 'Peserta') . ' berhasil disimpan.',
            'type'      => $type,
            'file_path' => $relative_file,
            'full_url'  => base_url($relative_file)
        ]);
    }

    // =========================================================================
    // VIEW COACHING
    // =========================================================================

    /**
     * Halaman View Coaching Detail
     */
    public function view_coaching($id_coaching = null) {
        $this->role();

        if (empty($id_coaching)) {
            redirect('coach_personil');
            return;
        }

        $data["plugin"][]  = "plugin/select2";
        $data["title"]     = "Detail Coaching Personil";
        $data["title_des"] = "Detail & Monitoring Coaching Karyawan";
        $data["content"]   = "v_view_coaching";

        // Data coaching header
        $data['coaching'] = $this->getRow("
            SELECT c.*, 
                   u.nik, u.nama as nama_personil,
                   COALESCE(NULLIF(u.jabatan, ''), r.name_role, '-') as jabatan,
                   COALESCE(NULLIF(u.jabatan, ''), r.name_role, '-') as nama_jabatan,
                   un.id_unit, un.kode_unit, un.name_unit,
                   ua.nama as nama_atasan
            FROM coach_coaching c
            LEFT JOIN user u ON u.id = c.user_id
            LEFT JOIN role r ON r.id = u.type_user
            LEFT JOIN unit un ON un.id_unit = COALESCE(NULLIF(c.id_unit, 0), u.unit_kerja)
            LEFT JOIN user ua ON ua.id = c.atasan_id
            WHERE c.id_coaching = " . (int)$id_coaching . "
            AND c.status != 8
        ");

        if (empty($data['coaching'])) {
            redirect('coach_personil');
            return;
        }

        // Performance Gaps
        $data['gaps'] = $this->getResult("
            SELECT * FROM coach_performance_gap WHERE id_coaching = " . (int)$id_coaching . " ORDER BY id_gap ASC
        ");

        // Root Causes
        $data['root_causes'] = $this->getResult("
            SELECT * FROM coach_root_cause WHERE id_coaching = " . (int)$id_coaching . " ORDER BY id_root_cause ASC
        ");

        // Action Plans
        $data['action_plans'] = $this->getResult("
            SELECT * FROM coach_action_plan WHERE id_coaching = " . (int)$id_coaching . " ORDER BY id_action_plan ASC
        ");

        // Commitment
        $data['commitment'] = $this->getRow("
            SELECT * FROM coach_commitment WHERE id_coaching = " . (int)$id_coaching . " LIMIT 1
        ");

        // Monitoring
        $data['monitorings'] = $this->getResult("
            SELECT m.*, u.nama as nama_created_by
            FROM coach_monitoring m
            LEFT JOIN user u ON u.id = m.created_by
            WHERE m.id_coaching = " . (int)$id_coaching . " ORDER BY m.tanggal ASC, m.id_monitoring ASC
        ");

        // Evaluation
        $data['evaluation'] = $this->getRow("
            SELECT e.*, u.nama as nama_created_by
            FROM coach_evaluation e
            LEFT JOIN user u ON u.id = e.created_by
            WHERE e.id_coaching = " . (int)$id_coaching . " LIMIT 1
        ");

        // Feedback
        $data['feedback'] = $this->getRow("
            SELECT * FROM coach_feedback WHERE id_coaching = " . (int)$id_coaching . " LIMIT 1
        ");

        // Dokumentasi / Foto Bukti Coaching
        $data['dokumentasi'] = $this->getResult("
            SELECT * FROM coach_dokumentasi WHERE id_coaching = " . (int)$id_coaching . " ORDER BY id_dokumentasi DESC
        ");

        // Area gaps (full list)
        $data['area_gaps'] = [
            'Pengetahuan Dasar', 'Pengetahuan Teknis Peralatan', 'Pengetahuan SOP',
            'Pemahaman Penerapan K3', 'Keterampilan Pengoperasian Peralatan',
            'Keterampilan Penggunaan Alat Kerja', 'Keterampilan Komunikasi',
            'Keterampilan Pemecahan Masalah', 'Keterampilan Analitis',
            'Inisiatif', 'Jujur', 'Tanggung Jawab', 'Disiplin', 'Komitmen',
            'Etika Adab', 'Kepedulian', 'Kerjasama', 'Kepemimpinan',
            'Kerapihan', 'Pelayanan Pelanggan'
        ];

        $data['root_cause_options'] = [
            'Kurang Memahami Pekerjaan', 'Kurang Keterampilan', 'Kurang Disiplin',
            'Kurang Motivasi', 'Beban Kerja Tinggi', 'Masalah Komunikasi',
            'Faktor Pribadi', 'Sarana Kerja Kurang Memadai', 'Lainnya'
        ];

        $this->load->view('template_v2', $data);
    }

    /**
     * AJAX: Daftar coaching yang sudah dibuat
     */
    public function list_coaching() {
        $tahun    = $this->input->post('tahun');
        $semester = $this->input->post('semester');
        $unit_id  = $this->input->post('unit_id');

        $allowed_units = $this->getUserAssignedUnitIds();

        $where = "c.status != 8";
        if (!empty($tahun)) {
            $where .= " AND c.tahun = '" . $this->db->escape_str($tahun) . "'";
        }
        if (!empty($semester)) {
            $where .= " AND c.semester = '" . $this->db->escape_str($semester) . "'";
        }

        if ($allowed_units !== null) {
            if (!empty($unit_id) && in_array((int)$unit_id, $allowed_units)) {
                $where .= " AND c.id_unit = " . (int)$unit_id;
            } else if (!empty($allowed_units)) {
                $where .= " AND c.id_unit IN (" . implode(',', $allowed_units) . ")";
            }
        } else if (!empty($unit_id)) {
            $where .= " AND c.id_unit = " . (int)$unit_id;
        }

        $data = $this->getResult("
            SELECT c.id_coaching, c.user_id, c.tahun, c.semester, c.bulan, c.perihal,
                   c.tanggal_coaching, c.nilai_akhir, c.kategori_nilai, c.status,
                   u.nik, u.nama as nama_personil,
                   un.kode_unit, un.name_unit,
                   ua.nama as nama_atasan
            FROM coach_coaching c
            LEFT JOIN user u ON u.id = c.user_id
            LEFT JOIN unit un ON un.id_unit = c.id_unit
            LEFT JOIN user ua ON ua.id = c.atasan_id
            WHERE $where
            ORDER BY c.created_at DESC
        ");

        echo json_encode(['status' => true, 'data' => $data]);
    }

    // =========================================================================
    // MONITORING CRUD
    // =========================================================================

    /**
     * AJAX: Simpan monitoring baru
     */
    public function save_monitoring() {
        $sess = sess();
        $id_coaching = $this->input->post('id_coaching');

        if (empty($id_coaching)) {
            echo json_encode(['status' => false, 'message' => 'ID Coaching wajib.']);
            return;
        }

        $id = $this->insert_db('coach_monitoring', [
            'id_coaching'   => (int)$id_coaching,
            'tanggal'       => $this->input->post('tanggal') ?: date('Y-m-d'),
            'progres'       => $this->input->post('progres'),
            'kendala'       => $this->input->post('kendala'),
            'tindak_lanjut' => $this->input->post('tindak_lanjut'),
            'paraf_atasan'  => $this->input->post('paraf_atasan'),
            'created_by'    => $sess['id'] ?? null,
            'created_at'    => date('Y-m-d H:i:s')
        ]);

        echo json_encode(['status' => true, 'message' => 'Monitoring berhasil disimpan.', 'id' => $id]);
    }

    /**
     * AJAX: Delete monitoring
     */
    public function delete_monitoring() {
        $id = $this->input->post('id_monitoring');
        $this->delete_db('coach_monitoring', ['id_monitoring' => (int)$id]);
        echo json_encode(['status' => true, 'message' => 'Monitoring berhasil dihapus.']);
    }

    // =========================================================================
    // EVALUATION CRUD
    // =========================================================================

    /**
     * AJAX: Simpan/Update evaluation
     */
    public function save_evaluation() {
        $sess = sess();
        $id_coaching = $this->input->post('id_coaching');

        if (empty($id_coaching)) {
            echo json_encode(['status' => false, 'message' => 'ID Coaching wajib.']);
            return;
        }

        $eval_data = [
            'id_coaching'       => (int)$id_coaching,
            'target_tercapai'   => $this->input->post('target_tercapai'),
            'ada_peningkatan'   => $this->input->post('ada_peningkatan'),
            'coaching_lanjutan'  => $this->input->post('coaching_lanjutan'),
            'perlu_pelatihan'   => $this->input->post('perlu_pelatihan'),
            'perlu_tindakan'    => $this->input->post('perlu_tindakan'),
            'catatan_evaluasi'  => $this->input->post('catatan_evaluasi'),
            'tanggal_evaluasi'  => $this->input->post('tanggal_evaluasi') ?: date('Y-m-d'),
            'created_by'        => $sess['id'] ?? null
        ];

        // Cek apakah sudah ada evaluation
        $existing = $this->countRows("SELECT id_evaluation FROM coach_evaluation WHERE id_coaching = " . (int)$id_coaching);

        if ($existing > 0) {
            $eval_data['updated_at'] = date('Y-m-d H:i:s');
            $this->update_db('coach_evaluation', ['id_coaching' => (int)$id_coaching], $eval_data);
            echo json_encode(['status' => true, 'message' => 'Evaluasi berhasil diperbarui.']);
        } else {
            $eval_data['created_at'] = date('Y-m-d H:i:s');
            $id = $this->insert_db('coach_evaluation', $eval_data);
            echo json_encode(['status' => true, 'message' => 'Evaluasi berhasil disimpan.', 'id' => $id]);
        }
    }

    // =========================================================================
    // FEEDBACK CRUD
    // =========================================================================

    /**
     * AJAX: Simpan/Update feedback
     */
    public function save_feedback() {
        $id_coaching = $this->input->post('id_coaching');

        if (empty($id_coaching)) {
            echo json_encode(['status' => false, 'message' => 'ID Coaching wajib.']);
            return;
        }

        $fb_data = [
            'id_coaching'        => (int)$id_coaching,
            'feedback_perusahaan'=> $this->input->post('feedback_perusahaan'),
            'feedback_tim'       => $this->input->post('feedback_tim')
        ];

        $existing = $this->countRows("SELECT id_feedback FROM coach_feedback WHERE id_coaching = " . (int)$id_coaching);

        if ($existing > 0) {
            $fb_data['updated_at'] = date('Y-m-d H:i:s');
            $this->update_db('coach_feedback', ['id_coaching' => (int)$id_coaching], $fb_data);
            echo json_encode(['status' => true, 'message' => 'Feedback berhasil diperbarui.']);
        } else {
            $fb_data['created_at'] = date('Y-m-d H:i:s');
            $id = $this->insert_db('coach_feedback', $fb_data);
            echo json_encode(['status' => true, 'message' => 'Feedback berhasil disimpan.', 'id' => $id]);
        }
    }

    // =========================================================================
    // ACTION PLAN UPDATE
    // =========================================================================

    /**
     * AJAX: Update status action plan
     */
    public function update_action_plan() {
        $id = $this->input->post('id_action_plan');
        $status = $this->input->post('status');

        if (empty($id)) {
            echo json_encode(['status' => false, 'message' => 'ID Action Plan wajib.']);
            return;
        }

        $this->update_db('coach_action_plan', ['id_action_plan' => (int)$id], [
            'status'     => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        echo json_encode(['status' => true, 'message' => 'Status action plan berhasil diperbarui.']);
    }

    /**
     * AJAX: Update status coaching
     */
    public function update_status() {
        $id = $this->input->post('id_coaching');
        $status = $this->input->post('status');

        if (empty($id)) {
            echo json_encode(['status' => false, 'message' => 'ID Coaching wajib.']);
            return;
        }

        $this->update_db('coach_coaching', ['id_coaching' => (int)$id], [
            'status'     => (int)$status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        echo json_encode(['status' => true, 'message' => 'Status coaching berhasil diperbarui.']);
    }

    // =========================================================================
    // FOTO DOKUMENTASI CRUD (UPLOAD & DELETE DARI VIEW COACHING)
    // =========================================================================

    /**
     * AJAX: Upload / Ambil Foto Dokumentasi Baru dari Halaman Detail Coaching
     */
    public function upload_foto_dokumentasi() {
        $id_coaching = $this->input->post('id_coaching');
        if (empty($id_coaching)) {
            echo json_encode(['status' => false, 'message' => 'ID Coaching wajib.']);
            return;
        }

        $coaching = $this->getRow("SELECT * FROM coach_coaching WHERE id_coaching = " . (int)$id_coaching);
        if (empty($coaching)) {
            echo json_encode(['status' => false, 'message' => 'Data coaching tidak ditemukan.']);
            return;
        }

        if (empty($coaching['id_unit'])) {
            $user_unit = $this->getRow("SELECT unit_kerja FROM user WHERE id = " . (int)$coaching['user_id']);
            $coaching['id_unit'] = $user_unit['unit_kerja'] ?? 0;
        }

        $path_info = $this->get_upload_path($coaching['tahun'], $coaching['semester'], $coaching['perihal'], $coaching['id_unit']);
        $foto_path = null;

        // A. Cek jika ada base64 dari kamera webcam
        $foto_base64 = $this->input->post('foto_bukti_base64');
        if (!empty($foto_base64) && strpos($foto_base64, 'data:image') === 0) {
            $foto_parts = explode(',', $foto_base64);
            $foto_decoded = base64_decode($foto_parts[1] ?? '');
            if ($foto_decoded) {
                $filename = 'bukti_coaching_' . $coaching['user_id'] . '_' . $coaching['tahun'] . '_' . time() . '.jpg';
                file_put_contents($path_info['absolute'] . $filename, $foto_decoded);
                $foto_path = $path_info['relative'] . $filename;
            }
        } 
        // B. Cek jika ada upload file dari input file / kamera HP
        else if (isset($_FILES['foto_bukti']) && !empty($_FILES['foto_bukti']['name']) && $_FILES['foto_bukti']['error'] == 0) {
            $ext = strtolower(pathinfo($_FILES['foto_bukti']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                $filename = 'bukti_coaching_' . $coaching['user_id'] . '_' . $coaching['tahun'] . '_' . time() . '.' . $ext;
                if (move_uploaded_file($_FILES['foto_bukti']['tmp_name'], $path_info['absolute'] . $filename)) {
                    $foto_path = $path_info['relative'] . $filename;
                }
            }
        }

        if (empty($foto_path)) {
            echo json_encode(['status' => false, 'message' => 'Tidak ada file foto yang diunggah / dipotret.']);
            return;
        }

        // Simpan ke tabel coach_dokumentasi
        $id_dok = $this->insert_db('coach_dokumentasi', [
            'id_coaching' => (int)$id_coaching,
            'file_path'   => $foto_path,
            'file_name'   => basename($foto_path),
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        // Update juga foto utama jika masih kosong
        if (empty($coaching['foto_dokumentasi'])) {
            $this->update_db('coach_coaching', ['id_coaching' => (int)$id_coaching], [
                'foto_dokumentasi' => $foto_path
            ]);
        }

        echo json_encode([
            'status'         => true,
            'message'        => 'Foto bukti dokumentasi coaching berhasil disimpan.',
            'id_dokumentasi' => $id_dok,
            'file_path'      => $foto_path,
            'full_url'       => base_url($foto_path)
        ]);
    }

    /**
     * AJAX: Hapus Foto Dokumentasi
     */
    public function delete_foto_dokumentasi() {
        $id_dok = $this->input->post('id_dokumentasi');
        if (empty($id_dok)) {
            echo json_encode(['status' => false, 'message' => 'ID Dokumentasi wajib.']);
            return;
        }

        $dok = $this->getRow("SELECT * FROM coach_dokumentasi WHERE id_dokumentasi = " . (int)$id_dok);
        if (!empty($dok)) {
            $file_full_path = FCPATH . $dok['file_path'];
            if (file_exists($file_full_path)) {
                @unlink($file_full_path);
            }
            $this->delete_db('coach_dokumentasi', ['id_dokumentasi' => (int)$id_dok]);
        }

        echo json_encode(['status' => true, 'message' => 'Foto bukti berhasil dihapus.']);
    }

    // =========================================================================
    // NATIVE WEB PDF / PRINT HANDLERS
    // =========================================================================

    /**
     * Cetak Dokumen Coaching Individu (Native Web PDF)
     */
    public function print_coaching($id_coaching = null) {
        $this->role();

        if (empty($id_coaching)) {
            show_404();
            return;
        }

        // Data coaching header
        $data['coaching'] = $this->getRow("
            SELECT c.*, 
                   u.nik, u.nama as nama_personil,
                   COALESCE(NULLIF(u.jabatan, ''), r.name_role, '-') as jabatan,
                   COALESCE(NULLIF(u.jabatan, ''), r.name_role, '-') as nama_jabatan,
                   un.id_unit, un.kode_unit, un.name_unit,
                   u_coach.nama as nama_atasan
            FROM coach_coaching c
            LEFT JOIN user u ON u.id = c.user_id
            LEFT JOIN role r ON r.id = u.type_user
            LEFT JOIN unit un ON un.id_unit = COALESCE(NULLIF(c.id_unit, 0), u.unit_kerja)
            LEFT JOIN user u_coach ON u_coach.id = c.created_by
            WHERE c.id_coaching = " . (int)$id_coaching . "
        ");

        if (empty($data['coaching'])) {
            show_404();
            return;
        }

        // Performance Gaps
        $data['gaps'] = $this->getResult("
            SELECT * FROM coach_performance_gap WHERE id_coaching = " . (int)$id_coaching . " ORDER BY id_gap ASC
        ");

        // Root Causes
        $data['root_causes'] = $this->getResult("
            SELECT * FROM coach_root_cause WHERE id_coaching = " . (int)$id_coaching . " ORDER BY id_root_cause ASC
        ");

        // Action Plans
        $data['action_plans'] = $this->getResult("
            SELECT * FROM coach_action_plan WHERE id_coaching = " . (int)$id_coaching . " ORDER BY id_action_plan ASC
        ");

        // Commitment
        $data['commitment'] = $this->getRow("
            SELECT * FROM coach_commitment WHERE id_coaching = " . (int)$id_coaching . " LIMIT 1
        ");

        // Monitorings
        $data['monitorings'] = $this->getResult("
            SELECT m.*, u.nama as nama_created_by
            FROM coach_monitoring m
            LEFT JOIN user u ON u.id = m.created_by
            WHERE m.id_coaching = " . (int)$id_coaching . "
            ORDER BY m.tanggal ASC
        ");

        // Evaluation
        $data['evaluation'] = $this->getRow("
            SELECT e.*, u.nama as nama_created_by
            FROM coach_evaluation e
            LEFT JOIN user u ON u.id = e.created_by
            WHERE e.id_coaching = " . (int)$id_coaching . "
            LIMIT 1
        ");

        // Feedback
        $data['feedback'] = $this->getRow("
            SELECT * FROM coach_feedback WHERE id_coaching = " . (int)$id_coaching . " LIMIT 1
        ");

        // Dokumentasi Foto
        $data['dokumentasi'] = $this->getResult("
            SELECT * FROM coach_dokumentasi WHERE id_coaching = " . (int)$id_coaching . " ORDER BY id_dokumentasi ASC
        ");

        $type = $this->input->get('type');
        if ($type === 'lengkap') {
            $this->load->view('v_print_coaching_lengkap', $data);
        } else {
            $this->load->view('v_print_coaching', $data);
        }
    }

    /**
     * Cetak Laporan Rekapitulasi Keseluruhan Hasil Coaching (Laporan Baru - Native Web PDF)
     */
    public function print_rekap() {
        $this->role();

        $tahun    = $this->input->get('tahun') ?: date('Y');
        $semester = $this->input->get('semester') ?: 'SMT 1';
        $bulan    = $this->input->get('bulan') ?: '';
        $perihal  = $this->input->get('perihal') ?: 'Hasil Asesmen';
        $unit_id  = $this->input->get('unit_id') ?: null;
        $status_coach_filter = $this->input->get('status_coach') ?: 'all';

        // Role restriction via getUserAssignedUnitIds
        $allowed_units = $this->getUserAssignedUnitIds();
        if ($allowed_units !== null) {
            if (!empty($unit_id)) {
                if (!in_array((int)$unit_id, $allowed_units)) {
                    $unit_id = $allowed_units;
                } else {
                    $unit_id = (int)$unit_id;
                }
            } else {
                $unit_id = $allowed_units;
            }
        }

        // Unit info
        $data['unit_info'] = null;
        if (!empty($unit_id) && !is_array($unit_id)) {
            $data['unit_info'] = $this->getRow("SELECT * FROM unit WHERE id_unit = " . (int)$unit_id);
        }

        // Hitung periode
        $periode = $this->getPeriode($tahun, $semester);
        $start_date = $periode['start'];
        $end_date   = $periode['end'];

        $ada_asesmen      = $this->input->get('ada_asesmen') !== null ? (int)$this->input->get('ada_asesmen') : 1;
        $include_cbt      = $this->input->get('include_cbt') !== null ? (int)$this->input->get('include_cbt') : 1;
        $include_wwc      = $this->input->get('include_wwc') !== null ? (int)$this->input->get('include_wwc') : 1;
        $include_presensi = $this->input->get('include_presensi') !== null ? (int)$this->input->get('include_presensi') : 1;

        if ($perihal == 'Hasil Asesmen' && !$include_cbt && !$include_wwc && !$include_presensi) {
            $include_presensi = 1;
        }

        if ($perihal == 'Hasil Asesmen' && $ada_asesmen == 1) {
            $raw_data = $this->loadDataHasilAsesmen($start_date, $end_date, $unit_id, null, '', $include_cbt, $include_wwc, $include_presensi);
        } else if ($perihal == 'Evaluasi Presensi' && $ada_asesmen == 1) {
            $raw_data = $this->loadDataEvaluasiPresensi($start_date, $end_date, $unit_id, null, '');
        } else {
            $raw_data = $this->loadDataLainnya($unit_id, null, '');
        }

        // Ambil data target personil yang ditetapkan (untuk mode manual / SMT 1)
        $where_target = "tahun = '" . $this->db->escape_str($tahun) . "' AND semester = '" . $this->db->escape_str($semester) . "' AND perihal = '" . $this->db->escape_str($perihal) . "'";
        if (!empty($unit_id)) {
            if (is_array($unit_id)) {
                $where_target .= " AND id_unit IN (" . implode(',', $unit_id) . ")";
            } else {
                $where_target .= " AND id_unit = " . (int)$unit_id;
            }
        }
        $target_records = $this->getResult("SELECT user_id FROM coach_target_personil WHERE $where_target");
        $target_map = [];
        foreach ($target_records as $tr) {
            $target_map[$tr['user_id']] = true;
        }

        // Ambil data riwayat coaching untuk periode & tahun ini
        $coaching_records = $this->getResult("
            SELECT c.*, u_coach.nama as nama_atasan
            FROM coach_coaching c
            LEFT JOIN user u_coach ON u_coach.id = c.created_by
            WHERE c.tahun = '" . $this->db->escape_str($tahun) . "'
            AND c.semester = '" . $this->db->escape_str($semester) . "'
            AND c.perihal = '" . $this->db->escape_str($perihal) . "'
            AND c.status != 8
        ");

        $coached_map = [];
        foreach ($coaching_records as $cr) {
            $coached_map[$cr['user_id']] = $cr;
            $target_map[$cr['user_id']] = true;
        }

        $is_automated = ($perihal == 'Hasil Asesmen' && $ada_asesmen == 1) || ($perihal == 'Evaluasi Presensi' && $ada_asesmen == 1);

        $list = [];
        $total_target = 0;
        $total_sudah  = 0;
        $total_belum  = 0;
        $total_tidak_target = 0;

        foreach ($raw_data as $p) {
            $uid = $p['user_id'];
            $is_target = $is_automated ? true : isset($target_map[$uid]);
            $p['is_target'] = $is_target;

            if (isset($coached_map[$uid])) {
                $p['is_coached']         = true;
                $p['id_coaching']        = $coached_map[$uid]['id_coaching'];
                $p['tanggal_coaching']   = $coached_map[$uid]['tanggal_coaching'];
                $p['status_coaching_db'] = $coached_map[$uid]['status'];
                $p['nama_atasan']        = $coached_map[$uid]['nama_atasan'];
            } else {
                $p['is_coached']         = false;
                $p['id_coaching']        = null;
                $p['tanggal_coaching']   = null;
                $p['status_coaching_db'] = null;
                $p['nama_atasan']        = '-';
            }

            if ($is_target) {
                $total_target++;
                if ($p['is_coached']) {
                    $total_sudah++;
                } else {
                    $total_belum++;
                }
            } else {
                $total_tidak_target++;
            }

            if ($status_coach_filter == 'target' && !$is_target) continue;
            if ($status_coach_filter == 'tidak_target' && $is_target) continue;
            if ($status_coach_filter == 'sudah' && !$p['is_coached']) continue;
            if ($status_coach_filter == 'belum') {
                if ($is_automated) {
                    if ($p['is_coached']) continue;
                } else {
                    if (!$is_target || $p['is_coached']) continue;
                }
            }

            $list[] = $p;
        }

        $data['tahun']               = $tahun;
        $data['semester']            = $semester;
        $data['bulan']               = $bulan;
        $data['perihal']             = $perihal;
        $data['ada_asesmen']         = $ada_asesmen;
        $data['include_cbt']         = $include_cbt;
        $data['include_wwc']         = $include_wwc;
        $data['include_presensi']    = $include_presensi;
        $data['periode_start']       = $start_date;
        $data['periode_end']         = $end_date;
        $data['list']                = $list;
        $data['total_all']           = count($raw_data);
        $data['total_target']        = $total_target;
        $data['total_sudah']         = $total_sudah;
        $data['total_belum']         = $total_belum;
        $data['total_tidak_target']  = $total_tidak_target;
        $data['is_automated']        = $is_automated;
        $data['status_coach_filter'] = $status_coach_filter;

        $this->load->view('v_print_rekap', $data);
    }
}
