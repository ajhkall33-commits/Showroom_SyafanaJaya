<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;




class Jadwal_pm extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("m_data");
        $this->load->model("m_data", "Mod");
    }

    // private function position() {
    //     $data["position"] = "perangkat";
    //     return $data;
    // }

    public function index()
    {

        //$data = $this->position();
        // $data = access($data,"VIEW");

        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Jadwal PM";
        $data["title_des"] = " List Jadwal PM";
        $data["content"] = "v_index";

        $data["data"] = $data;
        $data["lokasi"] = $this->Mod->getWhere('terminal', array('status !=' => 8))->result_array();
        $this->load->view('template_v2', $data);
        // echo "<pre>",print_r ( $this->session->userdata()),"</pre>";
    }




    function LoadData()
    {
        //$data= $this->position();
        // $acc  = access($data,"VIEW")['access'];

        $data_res['perangkat'] = $this->Mod->getWhere('perangkat', array('status !=' => 8))->result_array();
        $data_res['rto'] = $this->Mod->getWhere('perangkat', array('status ' => 0))->num_rows();
        $data_res['replay'] = $this->Mod->getWhere('perangkat', array('status ' => 1))->num_rows();
        echo json_encode($data_res);
    }




    public function Update($pk = null)
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
    // function untuk uploada data dari excel 
    function UploadData()
    {
        // Meningkatkan batas waktu dan memori untuk proses besar
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        if (isset($_FILES["perangkat"]["name"])) {
            $path = $_FILES["perangkat"]["tmp_name"];
            $object = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);

            // 1. Pre-fetch Lookups untuk menghindari query di dalam loop
            // Terminal lookup
            $terminals = $this->Mod->getWhere('terminal', array('status !=' => 8))->result_array();
            $terminal_map = [];
            foreach ($terminals as $t) {
                $terminal_map[trim($t['nama_terminal'])] = $t['id'];
            }

            // Fasilitas lookup
            $fasilitas_list = $this->Mod->getData('fasilitas')->result_array();
            $fasilitas_map = [];
            foreach ($fasilitas_list as $f) {
                $fasilitas_map[trim($f['nama_fasilitas'])] = $f['id_fasilitas'];
            }

            // PM Type lookup
            $pm_types = $this->Mod->getData('pm_type')->result_array();
            $pm_type_map = [];
            foreach ($pm_types as $p) {
                $pm_type_map[trim($p['kode'])] = $p['idpm_type'];
            }

            $data_insert_jadwal = array();
            $unit_id = sess()['unit'];
            $tahun_now = date("Y");

            foreach ($object->getWorksheetIterator() as $worksheet => $value) {
                $highestRow = $value->getHighestRow();
                $lastColumn = "BD";
                $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($lastColumn);

                if ($worksheet == 0) {
                    // PhpSpreadsheet: kolom 1-indexed (A=1, B=2, C=3, D=4, ...)
                    // Fasilitas ada di kolom B (2), Lokasi di kolom C (3), data minggu mulai dari D (4)
                    for ($col = 4; $col <= $highestColumnIndex; $col++) {
                        // Kolom minggu
                        $cell_minggu = $value->getCellByColumnAndRow($col, 2)->getValue();
                        $minggu = !empty($cell_minggu) ? trim($cell_minggu) : '';
                        
                        // Validasi agar hanya memproses jika cell minggu berisi angka
                        if (!is_numeric($minggu)) continue;

                        // Hitung bulan di PHP (lebih cepat daripada query SQL)
                        $bulan_new = '';
                        try {
                            $dd = new DateTime();
                            // Gunakan hari ke-4 (Kamis) sebagai referensi ISO-8601 
                            // agar Minggu 1 selalu jatuh di bulan Januari
                            $dd->setISODate($tahun_now, intval($minggu), 4);
                            $bulan_new = $dd->format('m');
                        } catch (Exception $e) {
                            $bulan_new = '';
                        }

                        for ($row = 3; $row <= $highestRow; $row++) {
                            $cell_lokasi = $value->getCellByColumnAndRow(3, $row)->getValue();
                            $lokasi = !empty($cell_lokasi) ? trim($cell_lokasi) : '';

                            if ($lokasi !== '') {
                                if (!isset($terminal_map[$lokasi])) {
                                    $terminal = ['nama_terminal' => $lokasi, 'parent_id' => '-1', 'status' => 1];
                                    $this->db->insert('terminal', $terminal);
                                    $terminal_map[$lokasi] = $this->db->insert_id();
                                }
                                $id_lokasi = $terminal_map[$lokasi];
                            } else {
                                $id_lokasi = null;
                            }

                            $cell_fasilitas = $value->getCellByColumnAndRow(2, $row)->getValue();
                            $fasilitas_nama = !empty($cell_fasilitas) ? trim($cell_fasilitas) : '';
                            $id_fasilitas = isset($fasilitas_map[$fasilitas_nama]) ? $fasilitas_map[$fasilitas_nama] : null;

                            $jenis = $value->getCellByColumnAndRow($col, $row)->getValue();
                            if (!empty($jenis)) {
                                $pm_type_split = explode("/", $jenis);
                                foreach ($pm_type_split as $val_pm) {
                                    $val_pm_trim = trim($val_pm);
                                    $id_pmtype = isset($pm_type_map[$val_pm_trim]) ? $pm_type_map[$val_pm_trim] : null;

                                    $data_insert_jadwal[] = [
                                        'id_fasilitas' => $id_fasilitas,
                                        'fasilitas' => $fasilitas_nama,
                                        'id_lokasi' => $id_lokasi,
                                        'id_unit' => $unit_id,
                                        'nama_lokasi' => $lokasi,
                                        'minggu' => $minggu,
                                        'bulan' => $bulan_new,
                                        'tahun' => $tahun_now,
                                        'idpm_type' => $id_pmtype,
                                        'pm_type' => $val_pm_trim,
                                        'status' => 1 // Default status
                                    ];
                                }
                            }
                        }
                    }
                }
            }

            if (!empty($data_insert_jadwal)) {
                // Gunakan chunking jika data terlalu besar untuk satu batch insert
                $chunks = array_chunk($data_insert_jadwal, 500);
                foreach ($chunks as $chunk) {
                    $this->db->insert_batch('jadwal', $chunk);
                }
            }
        }
    }
    public function DownloadJadwalPM()
    {
        // --- Query Data Fasilitas, Sesuai CodeIgniter 3 ---
        $this->db->where('id_unit', sess()['unit']);
        $this->db->order_by('id_fasilitas', 'ASC');
        $fasilitas = $this->db->get('fasilitas')->result_array();

        // --- Inisialisasi Spreadsheet ---
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $year = date('Y');

        // --- Style & Header ---
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Nama Alat');
        $sheet->setCellValue('C2', 'Lokasi');

        $col = 4; // Mulai kolom D = 4
        for ($minggu = 1; $minggu <= 53; $minggu++) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
            $sheet->setCellValue($colLetter . '2', $minggu);
            $col++;
        }

        // --- Isi Data Fasilitas ---
        $row = 3;
        foreach ($fasilitas as $no => $f) {
            $sheet->setCellValue('A' . $row, $no + 1);
            $sheet->setCellValue('B' . $row, $f['nama_fasilitas']);
            $sheet->setCellValue('C' . $row, $f['terminal']);
            for ($minggu = 1; $minggu <= 52; $minggu++) {
                $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($minggu + 3);
                $sheet->setCellValue($colLetter . $row, '');
            }
            $row++;
        }

        // --- Style Header & Data ---
        $lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(56); // 53 minggu + 3 = 56
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF009999']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ]
            ]
        ];
        $sheet->getStyle('A2:' . $lastCol . '2')->applyFromArray($headerStyle);
        $sheet->getRowDimension(2)->setRowHeight(25);

        // --- Style data all border & tengah untuk minggu ---
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ]
            ]
        ];
        $sheet->getStyle('A3:' . $lastCol . ($row - 1))->applyFromArray($dataStyle);
        $mingguStyle = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];
        $sheet->getStyle('D3:' . $lastCol . ($row - 1))->applyFromArray($mingguStyle);

        // --- Auto Size Columns ---
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(20);
        for ($i = 4; $i <= 56; $i++) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i);
            $sheet->getColumnDimension($colLetter)->setWidth(12);
        }

        // --- Freeze pane untuk header (sehingga row 2 tetap header) ---
        $sheet->freezePane('A3');

        // --- Judul di atas tabel (row 1 opsional) ---
        $sheet->setCellValue('A1', 'Jadwal PM Tahun ' . $year . ' Unit ' . sess()['unit']);
        $sheet->mergeCells('A1:' . $lastCol . '1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // --- Export ---
        $filename = 'Jadwal_PM_' . $year . '_Unit_' . sess()['unit'] . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

}
