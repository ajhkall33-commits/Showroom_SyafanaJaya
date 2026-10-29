<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Fill;
    use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class Jadwal_kerja extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Excel');
        $this->load->model("m_data");
    }

    // private function position() {
    //     $data["position"] = "perangkat";
    //     return $data;
    // }

    private function role() {
        $url = urlencode(current_url());
        if (session("username") == "") {
            redirect(base_url('login/auth'));
        }
    }

    /**
     * Cek apakah user memiliki hak akses kelola (CRUD) semua unit:
     * 1. User super yang login menggunakan password 'iassomcgk' (atau type_user == 'super' / username == 'iassomcgk')
     * 2. User dengan id_user == 738
     * 3. User dengan role 101 (Senior Koordinator)
     */
    public function canManageAllUnits() {
        $sess = sess();
        $userId = isset($sess['id']) ? (int)$sess['id'] : (isset($sess['id_user']) ? (int)$sess['id_user'] : 0);
        $typeUser = isset($sess['type_user']) ? $sess['type_user'] : '';
        $username = isset($sess['username']) ? $sess['username'] : '';

        // Kondisi 1: User super dengan password / username iassomcgk / type_user super
        $isSuper = ($typeUser === 'super' || $username === 'iassomcgk');

        // Kondisi 2: User dengan id_user 738
        $isUser738 = ($userId === 738);

        // Kondisi 3: User dengan role 101 (Senior Koordinator)
        $isRole101 = ($typeUser == 101 || $typeUser == '101');

        return ($isSuper || $isUser738 || $isRole101);
    }

    public function index()
    {
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Jadwal Dinas ";
        $data["title_des"] = "Daftar Jadwal Dinas ";
        $data["content"] = "v_index";

        $data["can_manage_all_units"] = $this->canManageAllUnits();
        $data["units"] = $this->db->where('status !=', 8)->order_by('id_unit', 'ASC')->get('unit')->result_array();
        $data["current_unit"] = isset(sess()['unit']) ? sess()['unit'] : 28;

        $data["data"] = $data;

        $this->load->view('template_v2', $data);
    }

    
    // public function LoadData(){
    //     // Ambil seluruh data petugas tanpa filter tanggal dan shift
    //     $data_res['petugas'] = $this->m_data->getWhere('jadwal_kerja', array(
    //         'id_unit' => sess()['unit']  // Ambil berdasarkan id_unit saja
    //     ))->result_array();
    
    //     // Loop untuk menambahkan nama_user dan NIK ke dalam data petugas
    //     foreach ($data_res['petugas'] as $key => $value) {
    //         // Ambil data user berdasarkan id_user
    //         $user = $this->m_data->getWhere('user', array('id' => $value['id_user']))->row_array();
            
    //         // Tambahkan nama_user dan NIK
    //         $data_res['petugas'][$key]['nama_user'] = $user['nama']; // Nama user
    //         $data_res['petugas'][$key]['nik'] = $user['nik'];         // NIK user
    //         $data_res['petugas'][$key]['tanggal_format'] = Hari_($value['tanggal']) . ' ' . tgl($value['tanggal'], 'sm');  // Format tanggal
    //     }
    
    //     // Kirim data dalam bentuk JSON
    //     echo json_encode($data_res);
    // }
    public function LoadData(){
        $bulan = $this->input->post('bulan'); // Ambil bulan dari filter
        $tahun = date('Y');
        
        // Jika bulan tidak dipilih, gunakan bulan saat ini
        if(empty($bulan)) {
            $bulan = date('m');
        }
        $bulan = sprintf('%02d', intval($bulan));
        
        // Hitung jumlah hari dalam bulan
        $jumlah_hari = date('t', strtotime($tahun . '-' . $bulan . '-01'));
        
        // Cek hak akses kelola unit
        if ($this->canManageAllUnits()) {
            $post_unit = $this->input->post('id_unit');
            $id_unit = !empty($post_unit) ? $post_unit : (isset(sess()['unit']) ? sess()['unit'] : 28);
        } else {
            $id_unit = isset(sess()['unit']) ? sess()['unit'] : null;
        }

        // Ambil data jadwal kerja berdasarkan bulan
        $data_res['petugas'] = $this->m_data->getWhere('jadwal_kerja', array(
            'id_unit' => $id_unit,
            'MONTH(tanggal)' => $bulan,
            'YEAR(tanggal)' => $tahun
        ))->result_array();
        
        // Ambil personil di unit ini dengan filter role: 1, 101, 102, 103, 107, 109, 110, 111
        // dan urutan baris teratas: 103, 101, 109, 110, 111, 102, 107, 1
        $personil = $this->m_data->getPersonilJadwal($id_unit);
        
        // Format data untuk tampilan horizontal
        $formatted_data = array();
        
        foreach($personil as $key => $person) {
            $formatted_data[$key] = array(
                'nik' => $person['nik'],
                'nama' => $person['nama'],
                'role' => !empty($person['name_role']) ? $person['name_role'] : '-',
                'type_user' => $person['type_user'],
                'user_id' => $person['id'],
                'shifts' => array()
            );
            
            // Inisialisasi array untuk setiap tanggal
            for($i = 1; $i <= $jumlah_hari; $i++) {
                $formatted_data[$key]['shifts'][$i] = '';
            }
            
            // Isi shift yang sudah ada
            foreach($data_res['petugas'] as $jadwal) {
                if($jadwal['id_user'] == $person['id']) {
                    $tgl = intval(date('j', strtotime($jadwal['tanggal'])));
                    $formatted_data[$key]['shifts'][$tgl] = strtoupper(trim($jadwal['shift']));
                }
            }
        }
        
        $data_res['formatted_data'] = $formatted_data;
        $data_res['jumlah_hari'] = $jumlah_hari;
        $data_res['bulan'] = $bulan;
        $data_res['tahun'] = $tahun;
        $data_res['id_unit'] = $id_unit;
        
        // Kirim data dalam bentuk JSON
        echo json_encode($data_res);
    }

    public function UpdateShift() {
        $nik = $this->input->post('nik');
        $tanggal = $this->input->post('tanggal');
        $shift = $this->input->post('shift');
        
        // Tentukan id_unit berdasarkan hak akses
        if ($this->canManageAllUnits()) {
            $post_unit = $this->input->post('id_unit');
            $id_unit = !empty($post_unit) ? $post_unit : (isset(sess()['unit']) ? sess()['unit'] : 28);
        } else {
            $id_unit = isset(sess()['unit']) ? sess()['unit'] : null;
        }

        // Cari user berdasarkan NIK
        $user = $this->m_data->getWhere('user', array('nik' => $nik))->row_array();
        
        if (!$user) {
            echo json_encode(array('status' => 'error', 'message' => 'User tidak ditemukan'));
            return;
        }

        $id_user = $user['id'];

        // Pengguna hanya bisa mengisikan data huruf D, PS, M, C, dan F, selain itu di hapus saja
        $shift = strtoupper(trim((string)$shift));
        $allowed = array('D', 'PS', 'M', 'C', 'F');

        if (!in_array($shift, $allowed)) {
            // Selain itu dihapus
            $shift = '';
        }

        if (empty($shift)) {
            // Hapus data jika dikosongkan atau selain D, PS, M, C, F
            $this->m_data->deleteData('jadwal_kerja', array(
                'id_user' => $id_user,
                'tanggal' => $tanggal,
                'id_unit' => $id_unit
            ));
            echo json_encode(array('status' => 'success', 'message' => 'Shift berhasil dikosongkan/dihapus', 'shift' => ''));
            return;
        } else {
            // Cek apakah data sudah ada
            $existing = $this->m_data->getWhere('jadwal_kerja', array(
                'id_user' => $id_user,
                'tanggal' => $tanggal,
                'id_unit' => $id_unit
            ))->row_array();

            if ($existing) {
                // Update data yang sudah ada
                $this->m_data->updateData('jadwal_kerja', 
                    array('id_jadwal_kerja' => $existing['id_jadwal_kerja']),
                    array('shift' => $shift)
                );
            } else {
                // Insert data baru
                $this->m_data->insertData('jadwal_kerja', array(
                    'id_user' => $id_user,
                    'tanggal' => $tanggal,
                    'shift' => $shift,
                    'id_unit' => $id_unit
                ));
            }
            echo json_encode(array('status' => 'success', 'message' => 'Shift berhasil disimpan', 'shift' => $shift));
            return;
        }
    }

    

   
    
  
    public function Update($pk=null)
    {
        // echo "aa";
        // echo "<pre>", print_r($this->input->post()), "</pre>";
        // $data = $this->position();
        // $data = access($data,"UPDATE");
       
        // if (!empty($this->input->post('target'))) {
        //     foreach ($_POST['target'] as $key => $value) {
        //             $items=[
        //                 // 'PK_ID'                 => $value['PK'],
        //                 'TARGET_SEMESTER1'      => $value['target1'],
        //                 'TARGET_SEMESTER2'      => $value['target2'],
        //             ];  
                    
        //           //  $this->m_indikator->updateData('KM_MAPPING_INDIKATOR',array('PK_ID'=>$value['PK']),$items);    
        //     }	
          
        // }		
      
       
        
    }

    public function UploadData()
    {
        // Return JSON
        header('Content-Type: application/json');

        if (!isset($_FILES["filelampiran"]["name"]) || empty($_FILES["filelampiran"]["tmp_name"])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Silahkan pilih file Excel (.xlsx / .xls) terlebih dahulu.'
            ]);
            return;
        }

        $bulan = $this->input->post('bulan');
        if (empty($bulan)) {
            $bulan = date('m');
        }
        $bulan = sprintf('%02d', intval($bulan));
        $tahun = $this->input->post('tahun') ? intval($this->input->post('tahun')) : intval(date('Y'));

        // Cek hak akses dan target id_unit
        if ($this->canManageAllUnits()) {
            $post_unit = $this->input->post('id_unit');
            $target_unit = !empty($post_unit) ? $post_unit : (isset(sess()['unit']) ? sess()['unit'] : 28);
        } else {
            $target_unit = isset(sess()['unit']) ? sess()['unit'] : null;
        }

        if (empty($target_unit)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Unit tidak valid atau belum dipilih.'
            ]);
            return;
        }

        $path = $_FILES["filelampiran"]["tmp_name"];

        try {
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($path);
            $spreadsheet = $reader->load($path);
            $worksheet = $spreadsheet->getActiveSheet();

            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

            // 1. Identifikasi Kolom secara Cerdas:
            // Cek baris 4 dan baris 5 untuk kolom NIK, Nama, dan nomor Tanggal
            $colNik = null;
            $colNama = null;
            $dateCols = array(); // [colIndex => dayNum (1..31)]

            for ($col = 1; $col <= $highestColumnIndex; $col++) {
                $valRow4 = trim((string)$worksheet->getCellByColumnAndRow($col, 4)->getValue());
                $valRow5 = trim((string)$worksheet->getCellByColumnAndRow($col, 5)->getValue());

                // Deteksi kolom NIK
                if (strcasecmp($valRow4, 'NIK') === 0 || strcasecmp($valRow5, 'NIK') === 0) {
                    $colNik = $col;
                }
                // Deteksi kolom Nama
                if (stripos($valRow4, 'Nama') !== false || stripos($valRow5, 'Nama') !== false) {
                    $colNama = $col;
                }

                // Deteksi kolom Tanggal: jika baris 4 merupakan angka 1 s/d 31
                $rawDate = $worksheet->getCellByColumnAndRow($col, 4)->getValue();
                if (is_numeric($rawDate)) {
                    $d = intval($rawDate);
                    if ($d >= 1 && $d <= 31) {
                        $dateCols[$col] = $d;
                    }
                }
            }

            // Fallback default: Kolom B (2) adalah NIK, Kolom C (3) adalah Nama
            if ($colNik === null) {
                $colNik = 2;
            }
            if ($colNama === null) {
                $colNama = 3;
            }

            // Fallback kolom tanggal jika baris 4 tidak memuat angka
            if (empty($dateCols)) {
                $jumlah_hari = date('t', strtotime($tahun . '-' . $bulan . '-01'));
                for ($d = 1; $d <= $jumlah_hari; $d++) {
                    $col = 4 + $d; // Kolom E (5) ke atas
                    if ($col <= $highestColumnIndex) {
                        $dateCols[$col] = $d;
                    }
                }
            }

            if (empty($dateCols)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Kolom tanggal tidak dapat ditemukan pada file Excel. Pastikan menggunakan format template yang sesuai.'
                ]);
                return;
            }

            // 2. Pre-cache user untuk performa cepat
            $allUsers = $this->db->select('id, nik, nama, unit_kerja')->get_where('user', array('status' => 1))->result_array();
            $userMap = array();
            foreach ($allUsers as $u) {
                $cleanNik = trim((string)$u['nik']);
                if ($cleanNik !== '') {
                    $userMap[$cleanNik] = $u;
                }
            }

            $totalInserted = 0;
            $totalUpdated = 0;
            $totalDeleted = 0;
            $totalSkipped = 0;
            $warnings = array();
            $allowedShifts = array('D', 'PS', 'M', 'C', 'F');

            $this->db->trans_start();

            // 3. Baca data personil mulai dari baris 6
            for ($row = 6; $row <= $highestRow; $row++) {
                $rawNik = $worksheet->getCellByColumnAndRow($colNik, $row)->getValue();
                $nik = trim((string)$rawNik);

                // Stop jika baris merupakan judul legenda keterangan shift
                $valCol1 = trim((string)$worksheet->getCellByColumnAndRow(1, $row)->getValue());
                $valCol2 = trim((string)$worksheet->getCellByColumnAndRow(2, $row)->getValue());
                if (stripos($valCol1, 'Keterangan') !== false || stripos($valCol2, 'Keterangan') !== false) {
                    break;
                }

                // Lewati jika NIK kosong, tanda strip, atau header NIK
                if ($nik === '' || $nik === '-' || strcasecmp($nik, 'NIK') === 0) {
                    continue;
                }

                $rawNama = $worksheet->getCellByColumnAndRow($colNama, $row)->getValue();
                $namaPersonil = trim((string)$rawNama);

                if (!isset($userMap[$nik])) {
                    $warnings[] = "Baris $row: NIK '$nik' ($namaPersonil) tidak terdaftar aktif di database.";
                    continue;
                }

                $id_user = $userMap[$nik]['id'];

                // Loop untuk setiap kolom tanggal
                foreach ($dateCols as $col => $dayNum) {
                    if (!checkdate(intval($bulan), $dayNum, $tahun)) {
                        continue;
                    }

                    $tgl_dinas = sprintf('%04d-%02d-%02d', $tahun, intval($bulan), $dayNum);
                    $cellVal = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                    $shift = strtoupper(trim((string)$cellVal));

                    // Cek jadwal yang sudah ada
                    $existing = $this->db->get_where('jadwal_kerja', array(
                        'id_user' => $id_user,
                        'tanggal' => $tgl_dinas,
                        'id_unit' => $target_unit
                    ))->row_array();

                    if (in_array($shift, $allowedShifts)) {
                        // Nilai shift valid: D, PS, M, C, F
                        if ($existing) {
                            if (strtoupper(trim($existing['shift'])) !== $shift) {
                                $this->db->where('id_jadwal_kerja', $existing['id_jadwal_kerja']);
                                $this->db->update('jadwal_kerja', array('shift' => $shift));
                                $totalUpdated++;
                            } else {
                                $totalSkipped++;
                            }
                        } else {
                            $this->db->insert('jadwal_kerja', array(
                                'id_user' => $id_user,
                                'tanggal' => $tgl_dinas,
                                'shift' => $shift,
                                'id_unit' => $target_unit
                            ));
                            $totalInserted++;
                        }
                    } elseif ($shift === '' || $shift === '-') {
                        // Shift kosong: jika sebelumnya ada data di sistem, hapus agar sinkron dengan template
                        if ($existing) {
                            $this->db->where('id_jadwal_kerja', $existing['id_jadwal_kerja']);
                            $this->db->delete('jadwal_kerja');
                            $totalDeleted++;
                        }
                    } else {
                        // Nilai selain D, PS, M, C, F
                        $warnings[] = "Baris $row ($namaPersonil) Tgl $dayNum: Nilai '$shift' tidak valid (hanya D, PS, M, C, F).";
                    }
                }
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Gagal menyimpan perubahan ke database.'
                ]);
                return;
            }

            $msg = "Import berhasil diproses: <b>$totalInserted</b> disimpan, <b>$totalUpdated</b> diperbarui";
            if ($totalDeleted > 0) {
                $msg .= ", <b>$totalDeleted</b> dikosongkan";
            }
            $msg .= ".";

            echo json_encode([
                'status' => 'success',
                'message' => $msg,
                'details' => [
                    'inserted' => $totalInserted,
                    'updated' => $totalUpdated,
                    'deleted' => $totalDeleted,
                    'skipped' => $totalSkipped,
                    'warnings' => array_slice($warnings, 0, 10)
                ]
            ]);
            return;

        } catch (\Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Terjadi kesalahan membaca file Excel: ' . $e->getMessage()
            ]);
            return;
        }
    }

    public function DownloadFormat($bulan = null)
    {
        if (empty($bulan)) {
            $bulan = $this->input->get('bulan') ? $this->input->get('bulan') : $this->input->post('bulan');
        }
        if (empty($bulan)) {
            $bulan = date('m');
        }
        $bulan = sprintf('%02d', intval($bulan));
        $tahun = $this->input->get('tahun') ? intval($this->input->get('tahun')) : intval(date('Y'));
        $jumlah_hari = date('t', strtotime($tahun . '-' . $bulan . '-01'));

        if ($this->canManageAllUnits()) {
            $get_unit = $this->input->get('id_unit') ? $this->input->get('id_unit') : $this->input->post('id_unit');
            $id_unit = !empty($get_unit) ? $get_unit : (isset(sess()['unit']) ? sess()['unit'] : 28);
        } else {
            $id_unit = isset(sess()['unit']) ? sess()['unit'] : null;
        }

        $unit_nama = '';
        if ($id_unit) {
            $unit_info = $this->m_data->getWhere('unit', array('id_unit' => $id_unit))->row_array();
            if ($unit_info) {
                $unit_nama = !empty($unit_info['name_unit']) ? $unit_info['name_unit'] : (!empty($unit_info['nama_unit']) ? $unit_info['nama_unit'] : $unit_info['kode_unit']);
            }
        }

        $personil = $this->m_data->getPersonilJadwal($id_unit);
        
        $data['personil']    = $personil;
        $data['date']        = $jumlah_hari;
        $data['bulan']       = $bulan;
        $data['tahun']       = $tahun;
        $data['id_unit']     = $id_unit;
        $data['unit_nama']   = $unit_nama;

        // Jika parameter download == 'xls', render via view HTML XLS; default adalah file XLSX modern
        if ($this->input->get('download') == 'xls') {
            $this->load->view('jadwal_dinas', $data);
        } else {
            $this->generateExcelFormatXLSX($data);
        }
    }

    // Function untuk export data jadwal aktual ke Excel (XLSX)
    public function ExportDataExcel($bulan = null)
    {
        if (empty($bulan)) {
            $bulan = $this->input->get('bulan') ? $this->input->get('bulan') : $this->input->post('bulan');
        }
        if (empty($bulan)) {
            $bulan = date('m');
        }
        $bulan = sprintf('%02d', intval($bulan));
        $tahun = date('Y');
        $jumlah_hari = date('t', strtotime($tahun . '-' . $bulan . '-01'));

        if ($this->canManageAllUnits()) {
            $get_unit = $this->input->get('id_unit') ? $this->input->get('id_unit') : $this->input->post('id_unit');
            $id_unit = !empty($get_unit) ? $get_unit : (isset(sess()['unit']) ? sess()['unit'] : 28);
        } else {
            $id_unit = isset(sess()['unit']) ? sess()['unit'] : null;
        }

        $personil = $this->m_data->getPersonilJadwal($id_unit);

        // Ambil nama unit jika ada
        $unit_nama = '';
        if ($id_unit) {
            $unit_info = $this->m_data->getWhere('unit', array('id_unit' => $id_unit))->row_array();
            if ($unit_info) {
                $unit_nama = !empty($unit_info['name_unit']) ? $unit_info['name_unit'] : (!empty($unit_info['nama_unit']) ? $unit_info['nama_unit'] : $unit_info['kode_unit']);
            }
        }

        // Ambil data jadwal kerja bulan ini
        $jadwal_list = $this->m_data->getWhere('jadwal_kerja', array(
            'id_unit' => $id_unit,
            'MONTH(tanggal)' => $bulan,
            'YEAR(tanggal)' => $tahun
        ))->result_array();

        // Mapping jadwal [id_user][hari] => shift
        $shift_map = array();
        foreach ($jadwal_list as $j) {
            $day = intval(date('j', strtotime($j['tanggal'])));
            $shift_map[$j['id_user']][$day] = strtoupper(trim($j['shift']));
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Jadwal Dinas');

        // Title
        $sheet->setCellValue('A1', 'JADWAL DINAS OPERASIONAL - BULAN ' . strtoupper(Fmonth($bulan)) . ' ' . $tahun);
        $sheet->setCellValue('A2', (!empty($unit_nama) ? 'UNIT: ' . strtoupper($unit_nama) . ' | ' : '') . 'BANDARA SOEKARNO-HATTA');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(11);

        // Header Table
        $sheet->setCellValue('A4', 'No');
        $sheet->mergeCells('A4:A5');
        $sheet->setCellValue('B4', 'NIK');
        $sheet->mergeCells('B4:B5');
        $sheet->setCellValue('C4', 'Nama Personil');
        $sheet->mergeCells('C4:C5');
        $sheet->setCellValue('D4', 'Jabatan / Role');
        $sheet->mergeCells('D4:D5');

        $firstDateColIndex = 5; // Kolom E
        $lastColIndex = 4 + $jumlah_hari;
        $firstDateColLetter = $this->numberToLetter($firstDateColIndex);
        $lastColLetter = $this->numberToLetter($lastColIndex);

        $sheet->mergeCells($firstDateColLetter . '3:' . $lastColLetter . '3');
        $sheet->setCellValue($firstDateColLetter . '3', 'TANGGAL');

        for ($d = 1; $d <= $jumlah_hari; $d++) {
            $colLetter = $this->numberToLetter(4 + $d);
            $sheet->setCellValue($colLetter . '4', $d);

            $tgl_str = $tahun . '-' . $bulan . '-' . sprintf('%02d', $d);
            $hari_short = date('D', strtotime($tgl_str));
            $hari_nama = hariIndo($hari_short);
            $sheet->setCellValue($colLetter . '5', $hari_nama);

            // Shading weekend
            if ($hari_short == 'Sun' || $hari_short == 'Sat') {
                $sheet->getStyle($colLetter . '4:' . $colLetter . '5')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFEE2E2');
            }
        }

        // Isi Data Personil dan Jadwal
        $row = 6;
        $no = 1;
        foreach ($personil as $p) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValueExplicit('B' . $row, $p['nik'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('C' . $row, $p['nama']);
            $sheet->setCellValue('D' . $row, !empty($p['name_role']) ? $p['name_role'] : '-');

            for ($d = 1; $d <= $jumlah_hari; $d++) {
                $colLetter = $this->numberToLetter(4 + $d);
                $shift_val = isset($shift_map[$p['id']][$d]) ? $shift_map[$p['id']][$d] : '';
                $sheet->setCellValue($colLetter . $row, $shift_val);

                // Warna Shift:
                // D, PS, M: Putih (#FFFFFF), font hitam
                // C (Cuti): Hijau (#16A34A), font putih bold
                // F (Off/Free): Merah (#DC2626), font putih bold
                if ($shift_val == 'C') {
                    $sheet->getStyle($colLetter . $row)->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('FF16A34A');
                    $sheet->getStyle($colLetter . $row)->getFont()
                        ->getColor()->setARGB('FFFFFFFF');
                    $sheet->getStyle($colLetter . $row)->getFont()->setBold(true);
                } elseif ($shift_val == 'F') {
                    $sheet->getStyle($colLetter . $row)->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('FFDC2626');
                    $sheet->getStyle($colLetter . $row)->getFont()
                        ->getColor()->setARGB('FFFFFFFF');
                    $sheet->getStyle($colLetter . $row)->getFont()->setBold(true);
                } elseif (in_array($shift_val, array('D', 'PS', 'M'))) {
                    $sheet->getStyle($colLetter . $row)->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('FFFFFFFF');
                    $sheet->getStyle($colLetter . $row)->getFont()
                        ->getColor()->setARGB('FF000000');
                    $sheet->getStyle($colLetter . $row)->getFont()->setBold(true);
                }
            }
            $row++;
        }

        $lastDataRow = $row - 1;

        // Styling Header Utama
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF4E79A7']
            ],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]
        ];
        $sheet->getStyle('A4:D5')->applyFromArray($headerStyle);
        $sheet->getStyle($firstDateColLetter . '3:' . $lastColLetter . '3')->applyFromArray($headerStyle);

        // Styling Tanggal Header
        $dateHeaderStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]
        ];
        $sheet->getStyle($firstDateColLetter . '4:' . $lastColLetter . '5')->applyFromArray($dateHeaderStyle);

        // Styling Grid Data
        $dataGridStyle = [
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER]
        ];
        if ($lastDataRow >= 6) {
            $sheet->getStyle('A6:' . $lastColLetter . $lastDataRow)->applyFromArray($dataGridStyle);

            // Center alignment untuk No, NIK, dan semua kolom tanggal
            $sheet->getStyle('A6:A' . $lastDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B6:B' . $lastDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($firstDateColLetter . '6:' . $lastColLetter . $lastDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // Auto width kolom
        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(24);
        for ($d = 1; $d <= $jumlah_hari; $d++) {
            $colLetter = $this->numberToLetter(4 + $d);
            $sheet->getColumnDimension($colLetter)->setWidth(5.5);
        }

        // Legend di bawah tabel
        $legendRow = max($lastDataRow, 6) + 3;
        $sheet->setCellValue('B' . $legendRow, 'Keterangan Shift:');
        $sheet->getStyle('B' . $legendRow)->getFont()->setBold(true);

        $legendItems = [
            ['code' => 'D', 'label' => 'Dinas (Day)', 'bg' => 'FFFFFFFF', 'fg' => 'FF000000'],
            ['code' => 'PS', 'label' => 'Pagi - Siang', 'bg' => 'FFFFFFFF', 'fg' => 'FF000000'],
            ['code' => 'M', 'label' => 'Malam', 'bg' => 'FFFFFFFF', 'fg' => 'FF000000'],
            ['code' => 'C', 'label' => 'Cuti', 'bg' => 'FF16A34A', 'fg' => 'FFFFFFFF'],
            ['code' => 'F', 'label' => 'Off / Free', 'bg' => 'FFDC2626', 'fg' => 'FFFFFFFF'],
        ];

        $lCol = 2; // Mulai kolom B
        foreach ($legendItems as $item) {
            $col1 = $this->numberToLetter($lCol);
            $col2 = $this->numberToLetter($lCol + 1);
            $sheet->setCellValue($col1 . ($legendRow + 1), $item['code']);
            $sheet->setCellValue($col2 . ($legendRow + 1), $item['label']);

            $sheet->getStyle($col1 . ($legendRow + 1))->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB($item['bg']);
            $sheet->getStyle($col1 . ($legendRow + 1))->getFont()
                ->getColor()->setARGB($item['fg']);
            $sheet->getStyle($col1 . ($legendRow + 1))->getFont()->setBold(true);
            $sheet->getStyle($col1 . ($legendRow + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col1 . ($legendRow + 1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $lCol += 3;
        }

        // Output XLSX
        $cleanUnit = !empty($unit_nama) ? preg_replace('/[^A-Za-z0-9_-]/', '_', $unit_nama) . '_' : '';
        $filename = 'Jadwal_Dinas_' . $cleanUnit . Fmonth($bulan) . '_' . $tahun . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }


// Function baru untuk generate XLSX (Format identik dengan ExportDataExcel + Dropdown D, PS, M, C, F)
private function generateExcelFormatXLSX($data)
{
    // Create new Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Template Jadwal Dinas');
    
    $bulan = sprintf('%02d', intval($data['bulan']));
    $tahun = !empty($data['tahun']) ? $data['tahun'] : date('Y');
    $jumlah_hari = !empty($data['date']) ? intval($data['date']) : date('t', strtotime($tahun . '-' . $bulan . '-01'));

    $unit_nama = !empty($data['unit_nama']) ? $data['unit_nama'] : '';
    if (empty($unit_nama) && !empty($data['id_unit'])) {
        $unit_info = $this->m_data->getWhere('unit', array('id_unit' => $data['id_unit']))->row_array();
        if ($unit_info) {
            $unit_nama = !empty($unit_info['name_unit']) ? $unit_info['name_unit'] : (!empty($unit_info['nama_unit']) ? $unit_info['nama_unit'] : $unit_info['kode_unit']);
        }
    }

    // Title
    $sheet->setCellValue('A1', 'JADWAL DINAS OPERASIONAL - BULAN ' . strtoupper(Fmonth($bulan)) . ' ' . $tahun);
    $sheet->setCellValue('A2', (!empty($unit_nama) ? 'UNIT: ' . strtoupper($unit_nama) . ' | ' : '') . 'BANDARA SOEKARNO-HATTA');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(11);

    // Header Table
    $sheet->setCellValue('A4', 'No');
    $sheet->mergeCells('A4:A5');
    $sheet->setCellValue('B4', 'NIK');
    $sheet->mergeCells('B4:B5');
    $sheet->setCellValue('C4', 'Nama Personil');
    $sheet->mergeCells('C4:C5');
    $sheet->setCellValue('D4', 'Jabatan / Role');
    $sheet->mergeCells('D4:D5');

    $firstDateColIndex = 5; // Kolom E
    $lastColIndex = 4 + $jumlah_hari;
    $firstDateColLetter = $this->numberToLetter($firstDateColIndex);
    $lastColLetter = $this->numberToLetter($lastColIndex);

    $sheet->mergeCells($firstDateColLetter . '3:' . $lastColLetter . '3');
    $sheet->setCellValue($firstDateColLetter . '3', 'TANGGAL');

    for ($d = 1; $d <= $jumlah_hari; $d++) {
        $colLetter = $this->numberToLetter(4 + $d);
        $sheet->setCellValue($colLetter . '4', $d);

        $tgl_str = $tahun . '-' . $bulan . '-' . sprintf('%02d', $d);
        $hari_short = date('D', strtotime($tgl_str));
        $hari_nama = hariIndo($hari_short);
        $sheet->setCellValue($colLetter . '5', $hari_nama);

        // Shading weekend
        if ($hari_short == 'Sun' || $hari_short == 'Sat') {
            $sheet->getStyle($colLetter . '4:' . $colLetter . '5')->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFEE2E2');
        }
    }

    // Data validation dropdown list untuk D, PS, M, C, F
    $validation = new DataValidation();
    $validation->setType(DataValidation::TYPE_LIST);
    $validation->setErrorStyle(DataValidation::STYLE_STOP);
    $validation->setAllowBlank(true);
    $validation->setShowInputMessage(true);
    $validation->setShowErrorMessage(true);
    $validation->setShowDropDown(true);
    $validation->setErrorTitle('Shift Tidak Valid');
    $validation->setError('Hanya boleh diisi D, PS, M, C, atau F.');
    $validation->setPromptTitle('Pilih Shift');
    $validation->setPrompt('Pilih atau ketik: D, PS, M, C, F');
    $validation->setFormula1('"D,PS,M,C,F"');

    // Isi Data Personil
    $row = 6;
    $no = 1;
    foreach ($data['personil'] as $p) {
        $sheet->setCellValue('A' . $row, $no++);
        $sheet->setCellValueExplicit('B' . $row, $p['nik'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValue('C' . $row, $p['nama']);
        $sheet->setCellValue('D' . $row, !empty($p['name_role']) ? $p['name_role'] : '-');

        // Isi tanggal kosong + dropdown validation
        for ($d = 1; $d <= $jumlah_hari; $d++) {
            $colLetter = $this->numberToLetter(4 + $d);
            $cellCoord = $colLetter . $row;
            $sheet->setCellValue($cellCoord, '');
            $sheet->getCell($cellCoord)->setDataValidation(clone $validation);
        }
        $row++;
    }

    $lastDataRow = $row - 1;

    // Styling Header Utama
    $headerStyle = [
        'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['argb' => 'FF4E79A7']
        ],
        'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]
    ];
    $sheet->getStyle('A4:D5')->applyFromArray($headerStyle);
    $sheet->getStyle($firstDateColLetter . '3:' . $lastColLetter . '3')->applyFromArray($headerStyle);

    // Styling Tanggal Header
    $dateHeaderStyle = [
        'font' => ['bold' => true],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]
    ];
    $sheet->getStyle($firstDateColLetter . '4:' . $lastColLetter . '5')->applyFromArray($dateHeaderStyle);

    // Styling Grid Data
    $dataGridStyle = [
        'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER]
    ];
    if ($lastDataRow >= 6) {
        $sheet->getStyle('A6:' . $lastColLetter . $lastDataRow)->applyFromArray($dataGridStyle);
        $sheet->getStyle('A6:A' . $lastDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B6:B' . $lastDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($firstDateColLetter . '6:' . $lastColLetter . $lastDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    // Auto width / Fixed width kolom
    $sheet->getColumnDimension('A')->setWidth(6);
    $sheet->getColumnDimension('B')->setWidth(18);
    $sheet->getColumnDimension('C')->setWidth(30);
    $sheet->getColumnDimension('D')->setWidth(24);
    for ($d = 1; $d <= $jumlah_hari; $d++) {
        $colLetter = $this->numberToLetter(4 + $d);
        $sheet->getColumnDimension($colLetter)->setWidth(5.5);
    }

    // Legend di bawah tabel
    $legendRow = max($lastDataRow, 6) + 3;
    $sheet->setCellValue('B' . $legendRow, 'Keterangan Shift (Gunakan kode berikut):');
    $sheet->getStyle('B' . $legendRow)->getFont()->setBold(true);

    $legendItems = [
        ['code' => 'D', 'label' => 'Dinas (Day)', 'bg' => 'FFFFFFFF', 'fg' => 'FF000000'],
        ['code' => 'PS', 'label' => 'Pagi - Siang', 'bg' => 'FFFFFFFF', 'fg' => 'FF000000'],
        ['code' => 'M', 'label' => 'Malam', 'bg' => 'FFFFFFFF', 'fg' => 'FF000000'],
        ['code' => 'C', 'label' => 'Cuti', 'bg' => 'FF16A34A', 'fg' => 'FFFFFFFF'],
        ['code' => 'F', 'label' => 'Off / Free', 'bg' => 'FFDC2626', 'fg' => 'FFFFFFFF'],
    ];

    $lCol = 2; // Mulai kolom B
    foreach ($legendItems as $item) {
        $col1 = $this->numberToLetter($lCol);
        $col2 = $this->numberToLetter($lCol + 1);
        $sheet->setCellValue($col1 . ($legendRow + 1), $item['code']);
        $sheet->setCellValue($col2 . ($legendRow + 1), $item['label']);

        $sheet->getStyle($col1 . ($legendRow + 1))->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB($item['bg']);
        $sheet->getStyle($col1 . ($legendRow + 1))->getFont()
            ->getColor()->setARGB($item['fg']);
        $sheet->getStyle($col1 . ($legendRow + 1))->getFont()->setBold(true);
        $sheet->getStyle($col1 . ($legendRow + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($col1 . ($legendRow + 1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $lCol += 3;
    }

    // Set filename dan download
    $cleanUnit = !empty($unit_nama) ? preg_replace('/[^A-Za-z0-9_-]/', '_', $unit_nama) . '_' : '';
    $filename = 'Template_Jadwal_Dinas_' . $cleanUnit . Fmonth($bulan) . '_' . $tahun . '.xlsx';
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}

// Helper function untuk konversi angka ke huruf kolom Excel
private function numberToLetter($num)
{
    $numeric = ($num - 1) % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval(($num - 1) / 26);
    if ($num2 > 0) {
        return $this->numberToLetter($num2) . $letter;
    } else {
        return $letter;
    }
}


}
