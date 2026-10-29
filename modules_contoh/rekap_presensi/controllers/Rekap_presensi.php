<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class Rekap_presensi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('rekap_presensi/Rekap_presensi_mod', 'Rekap_presensi_MOD');
        $this->Rekap_presensi_mod = $this->Rekap_presensi_MOD;
        $this->load->model('Mod');
    }

    private function role() {
        if (session("username") == "") {
            redirect(base_url('login/auth'));
        }
    }

    /**
     * Halaman Utama Rekap Presensi
     */
    public function index() {
        $this->role();

        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Rekap Presensi";
        $data["title_des"] = "Daftar Rekap Presensi Karyawan";
        $data["content"] = "v_rekap_presensi";
        $data["units"] = $this->Mod->getWhere('unit', array('status !=' => 8))->result_array();
        $data["data"] = $data;

        $this->load->view('template_v2', $data);
    }

    /**
     * Halaman Khusus Import Rekap Presensi
     */
    public function import() {
        $this->role();

        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Import Rekap Presensi";
        $data["title_des"] = "Upload & Import Data Rekap Presensi Excel";
        $data["content"] = "v_import";
        $data["data"] = $data;

        $this->load->view('template_v2', $data);
    }

    /**
     * Load Data AJAX untuk pagination dan filter tabel
     */
    public function LoadData($page = 0) {
        $limit = isset($_POST['limit']) ? intval($_POST['limit']) : 25;
        if ($limit <= 0) $limit = 25;

        $src = isset($_POST['src']) ? trim($_POST['src']) : '';
        $unit_id = isset($_POST['unit_id']) ? $_POST['unit_id'] : '';
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
        $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : (isset($_POST['date']) ? $_POST['date'] : '');
        $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : (isset($_POST['date']) ? $_POST['date'] : '');

        // Role restriction (jika bukan super/iassomcgk, batasi ke unit sendiri)
        $sess = sess();
        $is_super = (isset($sess['type_user']) && $sess['type_user'] == 'super') || 
                    (isset($sess['username']) && $sess['username'] == 'iassomcgk');

        if (!$is_super && isset($sess['unit'])) {
            $unit_id = $sess['unit'];
        }

        $totalData = $this->Rekap_presensi_MOD->count_all($src, $unit_id, $start_date, $user_id, $end_date);
        $offset = intval($page);

        $list = $this->Rekap_presensi_MOD->get_all($limit, $offset, $src, $unit_id, $start_date, $user_id, $end_date);

        $totalPages = ceil($totalData / $limit);

        $response = [
            'status'     => true,
            'data'       => $list,
            'total_data' => $totalData,
            'total_page' => $totalPages,
            'page'       => $offset,
            'limit'      => $limit
        ];

        echo json_encode($response);
    }

    /**
     * AJAX Endpoint: Ambil daftar personil/user berdasarkan unit (filter type_user)
     */
    public function get_users_by_unit() {
        $unit_id = $this->input->post('unit_id');

        $this->db->select('user.id, user.nik, user.nama');
        $this->db->from('user');
        $this->db->where('user.status !=', 8);
        $this->db->where_not_in('user.type_user', [2, 4, 99, 5, 6, 104, 105, 106, 108]);

        if (!empty($unit_id)) {
            $this->db->where('user.unit_kerja', $unit_id);
        }

        $this->db->order_by('user.nama', 'ASC');
        $users = $this->db->get()->result_array();

        echo json_encode([
            'status' => true,
            'data'   => $users
        ]);
    }

    /**
     * AJAX Endpoint: Rekap Kehadiran dan Keterlambatan per Karyawan
     */
    public function get_rekap_karyawan() {
        $unit_id = isset($_POST['unit_id']) ? $_POST['unit_id'] : '';
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
        $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
        $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
        $src = isset($_POST['src']) ? trim($_POST['src']) : '';

        // Role restriction
        $sess = sess();
        $is_super = (isset($sess['type_user']) && $sess['type_user'] == 'super') || 
                    (isset($sess['username']) && $sess['username'] == 'iassomcgk');

        if (!$is_super && isset($sess['unit'])) {
            $unit_id = $sess['unit'];
        }

        $list = $this->Rekap_presensi_MOD->get_summary_by_user($unit_id, $start_date, $end_date, $src, $user_id);

        echo json_encode([
            'status' => true,
            'data'   => $list
        ]);
    }

    /**
     * AJAX Endpoint: Data Grafik Kehadiran & Keterlambatan
     */
    /**
     * AJAX Endpoint: Data Grafik Kehadiran & Keterlambatan
     */
    public function get_chart_data() {
        $unit_id = isset($_POST['unit_id']) ? $_POST['unit_id'] : '';
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
        $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
        $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
        $unlock_key = isset($_POST['unlock_key']) ? trim($_POST['unlock_key']) : '';

        // Role restriction
        $sess = sess();
        $is_super = (isset($sess['type_user']) && $sess['type_user'] == 'super') || 
                    (isset($sess['username']) && $sess['username'] == 'iassomcgk');

        $include_office = ($is_super || $unlock_key === 'iassomcgk');

        if (!$is_super && isset($sess['unit'])) {
            $unit_id = $sess['unit'];
        }

        $chart = $this->Rekap_presensi_MOD->get_chart_summary($unit_id, $start_date, $end_date, $user_id, $include_office);

        echo json_encode([
            'status'          => true,
            'data'            => $chart,
            'is_super'        => $is_super,
            'office_unlocked' => $include_office
        ]);
    }

    /**
     * Cetak PDF Native Rekapitulasi Karyawan
     */
    public function cetak_pdf() {
        $this->role();

        $unit_id    = $this->input->get('unit_id');
        $user_id    = $this->input->get('user_id');
        $start_date = $this->input->get('start_date');
        $end_date   = $this->input->get('end_date');

        // Role restriction
        $sess = sess();
        $is_super = (isset($sess['type_user']) && $sess['type_user'] == 'super') || 
                    (isset($sess['username']) && $sess['username'] == 'iassomcgk');

        if (!$is_super && isset($sess['unit'])) {
            $unit_id = $sess['unit'];
        }

        $list = $this->Rekap_presensi_MOD->get_summary_by_user($unit_id, $start_date, $end_date, '', $user_id);

        $unit_info = null;
        if (!empty($unit_id)) {
            $unit_info = $this->db->get_where('unit', ['id_unit' => $unit_id])->row_array();
        }

        $user_info = null;
        if (!empty($user_id)) {
            $user_info = $this->db->get_where('user', ['id' => $user_id])->row_array();
        }

        $data = [
            'title'      => 'Laporan Rekapitulasi Presensi Karyawan',
            'list'       => $list,
            'unit_info'  => $unit_info,
            'user_info'  => $user_info,
            'start_date' => $start_date,
            'end_date'   => $end_date,
            'unit_id'    => $unit_id,
            'user_id'    => $user_id
        ];

        $this->load->view('v_cetak_pdf', $data);
    }

    /**
     * Cetak Native Web Evaluasi Kinerja & Performa Seluruh Unit Kerja
     */
    public function cetak_kinerja_unit() {
        $this->role();

        $start_date = $this->input->get('start_date');
        $end_date   = $this->input->get('end_date');
        $unlock_key = $this->input->get('unlock_key');
        $view_tab   = $this->input->get('view_tab') ? $this->input->get('view_tab') : 'all';

        $sess = sess();
        $username = isset($sess['username']) ? $sess['username'] : '';
        $session_user_id = isset($sess['id']) ? $sess['id'] : (isset($sess['user_id']) ? $sess['user_id'] : 0);

        $is_super = (isset($sess['type_user']) && $sess['type_user'] == 'super') ||
                    in_array(strtolower($username), ['superadmin', 'admin', 'iassomcgk']) ||
                    (int)$session_user_id === 1;

        $include_office = ($is_super || $unlock_key === 'iassomcgk');

        $chart_data = $this->Rekap_presensi_MOD->get_chart_summary(null, $start_date, $end_date, null, $include_office);

        $data = [
            'title'            => 'Laporan Presentase Presensi Unit Kerja',
            'unit_performance' => $chart_data['unit_performance'] ?? [],
            'status_summary'   => $chart_data['status_summary'] ?? [],
            'trend_summary'    => $chart_data['trend_summary'] ?? [],
            'start_date'       => $start_date,
            'end_date'         => $end_date,
            'office_included'  => $chart_data['office_included'] ?? false,
            'is_super'         => $is_super,
            'view_tab'         => $view_tab
        ];

        $this->load->view('v_cetak_kinerja_unit', $data);
    }

    /**
     * Proses Import Data Excel
     */
    public function process_import() {
        if (!isset($_FILES["file_excel"]["name"]) || empty($_FILES["file_excel"]["name"])) {
            echo json_encode([
                'status'  => false,
                'message' => 'Silakan pilih file Excel terlebih dahulu.'
            ]);
            return;
        }

        $file = $_FILES["file_excel"]["tmp_name"];

        try {
            $reader = IOFactory::createReaderForFile($file);
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray(null, true, true, true);

            if (empty($rows)) {
                echo json_encode([
                    'status'  => false,
                    'message' => 'File Excel kosong atau tidak terbaca.'
                ]);
                return;
            }

            // 1. Cari baris header
            $headerRowIndex = null;
            $headerMap = [];
            $requiredHeaders = [
                'nik'             => 'NIK',
                'full_name'       => 'Full Name',
                'date'            => 'Date*',
                'shift'           => 'Shift',
                'schedule_in'     => 'Schedule In',
                'schedule_out'    => 'Schedule Out',
                'attendance_code' => 'Attendance Code',
                'check_in'        => 'Check In',
                'check_out'       => 'Check Out',
                'keterangan'      => 'Keterangan'
            ];

            foreach ($rows as $rowIndex => $rowCols) {
                $cleanRow = array_map(function($v) {
                    return strtolower(trim((string)$v));
                }, $rowCols);

                // Cek apakah baris ini berisi header NIK dan Full Name atau Date
                if (in_array('nik', $cleanRow) && (in_array('full name', $cleanRow) || in_array('date*', $cleanRow) || in_array('date', $cleanRow))) {
                    $headerRowIndex = $rowIndex;
                    foreach ($rowCols as $colLetter => $colName) {
                        $colNameClean = trim((string)$colName);
                        foreach ($requiredHeaders as $key => $reqHeader) {
                            if (strcasecmp($colNameClean, $reqHeader) === 0 || strcasecmp(str_replace('*', '', $colNameClean), str_replace('*', '', $reqHeader)) === 0) {
                                $headerMap[$key] = $colLetter;
                            }
                        }
                    }
                    break;
                }
            }

            // Validasi kelengkapan header
            if ($headerRowIndex === null || !isset($headerMap['nik']) || !isset($headerMap['date'])) {
                echo json_encode([
                    'status'  => false,
                    'message' => 'Template Excel tidak sesuai. Silakan gunakan Template Rekap Presensi.xlsx dengan header: NIK, Full Name, Date*, Shift, Schedule In, Schedule Out, Attendance Code, Check In, Check Out, Keterangan.'
                ]);
                return;
            }

            // 2. Iterasi membaca data setiap baris
            $total_rows = 0;
            $berhasil = 0;
            $duplicate = 0;
            $user_not_found = 0;
            $gagal = 0;
            $errors = [];

            foreach ($rows as $rowIndex => $rowCols) {
                if ($rowIndex <= $headerRowIndex) {
                    continue; // Skip baris sebelum dan pada header
                }

                // Ambil nilai NIK (harus string)
                $nik = isset($headerMap['nik']) && isset($rowCols[$headerMap['nik']]) ? trim((string)$rowCols[$headerMap['nik']]) : '';
                $full_name = isset($headerMap['full_name']) && isset($rowCols[$headerMap['full_name']]) ? trim((string)$rowCols[$headerMap['full_name']]) : '';
                $raw_date = isset($headerMap['date']) && isset($rowCols[$headerMap['date']]) ? trim((string)$rowCols[$headerMap['date']]) : '';

                // Jika seluruh baris kosong, skip
                if (empty($nik) && empty($raw_date) && empty($full_name)) {
                    continue;
                }

                $total_rows++;

                // A. Validasi NIK
                if (empty($nik)) {
                    $gagal++;
                    $errors[] = [
                        'row'   => $rowIndex,
                        'nik'   => '-',
                        'nama'  => $full_name,
                        'error' => 'NIK kosong pada baris ini'
                    ];
                    continue;
                }

                // Lookup User (Hanya yang status != 8 dan cocok dengan personil aktif)
                $user = $this->Rekap_presensi_MOD->get_user_by_nik($nik, $full_name);
                if (!$user) {
                    $user_not_found++;
                    $gagal++;
                    $errors[] = [
                        'row'   => $rowIndex,
                        'nik'   => $nik,
                        'nama'  => $full_name,
                        'error' => 'User dengan NIK ' . $nik . ' tidak ditemukan di database'
                    ];
                    continue;
                }
                $user_id = $user->id;

                // B. Format Tanggal (Date*)
                $date_formatted = $this->format_date($raw_date);
                if (empty($date_formatted)) {
                    $gagal++;
                    $errors[] = [
                        'row'   => $rowIndex,
                        'nik'   => $nik,
                        'nama'  => !empty($full_name) ? $full_name : $user->nama,
                        'error' => 'Format tanggal (' . $raw_date . ') tidak valid'
                    ];
                    continue;
                }

                // C. Validasi Duplikasi (user_id + date)
                $existing = $this->Rekap_presensi_MOD->get_by_user_date($user_id, $date_formatted);
                if ($existing) {
                    $duplicate++;
                    $errors[] = [
                        'row'   => $rowIndex,
                        'nik'   => $nik,
                        'nama'  => !empty($full_name) ? $full_name : $user->nama,
                        'error' => 'Data presensi tanggal ' . $date_formatted . ' untuk user ini sudah ada (Duplicate)'
                    ];
                    continue;
                }

                // D. Ambil Field Lainnya
                $shift = isset($headerMap['shift']) && isset($rowCols[$headerMap['shift']]) ? trim((string)$rowCols[$headerMap['shift']]) : '';
                $schedule_in = isset($headerMap['schedule_in']) && isset($rowCols[$headerMap['schedule_in']]) ? $this->format_time($rowCols[$headerMap['schedule_in']]) : null;
                $schedule_out = isset($headerMap['schedule_out']) && isset($rowCols[$headerMap['schedule_out']]) ? $this->format_time($rowCols[$headerMap['schedule_out']]) : null;
                $attendance_code = isset($headerMap['attendance_code']) && isset($rowCols[$headerMap['attendance_code']]) ? strtoupper(trim((string)$rowCols[$headerMap['attendance_code']])) : '';
                $check_in = isset($headerMap['check_in']) && isset($rowCols[$headerMap['check_in']]) ? $this->format_time($rowCols[$headerMap['check_in']]) : null;
                $check_out = isset($headerMap['check_out']) && isset($rowCols[$headerMap['check_out']]) ? $this->format_time($rowCols[$headerMap['check_out']]) : null;
                $keterangan = isset($headerMap['keterangan']) && isset($rowCols[$headerMap['keterangan']]) ? trim((string)$rowCols[$headerMap['keterangan']]) : '';

                // Normalisasi attendance code jika bernilai '0', '-', atau 'NULL'
                if (in_array($attendance_code, ['0', '-', 'NULL'])) {
                    $attendance_code = '';
                }

                // Cek kondisi jenis shift (bukan day off / libur)
                $is_off = (stripos($shift, 'off') !== false || stripos($shift, 'libur') !== false);
                $has_checkin = !empty($check_in) && $check_in !== '-';
                $has_checkout = !empty($check_out) && $check_out !== '-';
                $is_ket_empty = (empty($keterangan) || in_array($keterangan, ['-', '0']));

                if (!$is_off) {
                    // Kasus 1: Auto-Alpha (A)
                    // Jika shift kerja aktif, tidak ada check-in, dan tidak ada attendance code resmi/izin (atau memang diisi 'A' / 'ALPHA')
                    if (!$has_checkin && (empty($attendance_code) || in_array($attendance_code, ['A', 'ALPHA']))) {
                        if ($attendance_code === 'A' || $attendance_code === 'ALPHA' || $is_ket_empty) {
                            $attendance_code = 'A';
                            if ($is_ket_empty) {
                                $keterangan = 'Alpha (Tidak Hadir)';
                            }
                        }
                    }
                    // Kasus 2: TAP (Tidak Absen Pulang)
                    // Jika ada check-in, tetapi tidak ada check-out
                    else if ($has_checkin && !$has_checkout) {
                        if (empty($attendance_code) || in_array($attendance_code, ['H', 'TAP'])) {
                            $attendance_code = 'TAP';
                        }
                        if ($is_ket_empty) {
                            $keterangan = 'Tidak Absen Pulang';
                        } else if (stripos($keterangan, 'Tidak Absen Pulang') === false && stripos($keterangan, 'Tidak Check Out') === false) {
                            $keterangan .= ' (Tidak Absen Pulang)';
                        }
                    }
                }

                // E. Insert Data (tanpa unit_id dan full_name)
                $data_insert = [
                    'user_id'         => $user_id,
                    'nik'             => $nik,
                    'date'            => $date_formatted,
                    'shift'           => $shift,
                    'schedule_in'     => $schedule_in,
                    'schedule_out'    => $schedule_out,
                    'attendance_code' => $attendance_code,
                    'check_in'        => $check_in,
                    'check_out'       => $check_out,
                    'keterangan'      => $keterangan
                ];

                $this->Rekap_presensi_MOD->insert($data_insert);
                $berhasil++;
            }

            echo json_encode([
                'status'          => true,
                'message'         => 'Proses import selesai.',
                'total_row'       => $total_rows,
                'berhasil'        => $berhasil,
                'duplicate'       => $duplicate,
                'user_not_found'  => $user_not_found,
                'gagal'           => $gagal,
                'errors'          => $errors
            ]);

        } catch (Exception $e) {
            echo json_encode([
                'status'  => false,
                'message' => 'Terjadi kesalahan saat memproses file Excel: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Download Template Rekap Presensi Excel dari path doc/
     */
    public function download_template() {
        $file_path = FCPATH . 'doc/Template Rekap Presensi.xlsx';

        if (file_exists($file_path)) {
            $this->load->helper('download');
            force_download('Template Rekap Presensi.xlsx', file_get_contents($file_path));
            return;
        }

        // Fallback jika file fisik tidak ada
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'NIK', 'Full Name', 'Date*', 'Shift',
            'Schedule In', 'Schedule Out', 'Attendance Code',
            'Check In', 'Check Out', 'Keterangan'
        ];

        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $col++;
        }

        $sheet->getStyle('A1:J1')->getFont()->setBold(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Template Rekap Presensi.xlsx';

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    /**
     * Delete Presensi Data
     */
    public function delete($id) {
        $id = intval($id);
        $res = $this->Rekap_presensi_MOD->delete($id);
        if ($res) {
            echo json_encode(['status' => true, 'message' => 'Data berhasil dihapus']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal menghapus data']);
        }
    }

    /**
     * Helper Helper format tanggal
     */
    private function format_date($val) {
        if (empty($val)) return null;

        if (is_numeric($val)) {
            try {
                return ExcelDate::excelToDateTimeObject($val)->format('Y-m-d');
            } catch (Exception $e) {
                return null;
            }
        }

        $timestamp = strtotime($val);
        if ($timestamp !== false) {
            return date('Y-m-d', $timestamp);
        }

        return null;
    }

    /**
     * Helper Helper format jam
     */
    private function format_time($val) {
        if (empty($val) || $val == '-') return null;

        $val = trim((string)$val);
        if (is_numeric($val)) {
            try {
                return ExcelDate::excelToDateTimeObject($val)->format('H:i:s');
            } catch (Exception $e) {
                return $val;
            }
        }

        return $val;
    }
}
