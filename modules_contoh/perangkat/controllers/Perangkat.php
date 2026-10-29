<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Perangkat extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('Excel');
        $this->load->library('Ciqrcode');
        $this->load->library('pdfgenerator');
        $this->role();
    }
    private function role()
    {
        $url = urlencode(current_url());
        if (session("username") == "") {
            redirect(base_url('login/auth'));
        }
    }

    // private function position() {
    //     $data["position"] = "perangkat";
    //     return $data;
    // }

    public function QRCodeRender($perangkat = null)
    {
        $id = $perangkat['id_perangkat'];
        $id_unit = sess()['unit'];

        // Clean name for filename
        $safe_nama = preg_replace('/[^a-zA-Z0-9]/', '_', $perangkat['nama_perangkat']);
        $name = $id . '_' . $safe_nama;

        $tempdir = "doc/QRCode/" . $id_unit . "/"; // Group by unit folder
        if (!file_exists($tempdir)) // Create directory if it doesn't exist
            mkdir($tempdir, 0777, true);

        //ambil logo
        $logopath = FCPATH . "assets_v2/images/Injourney_alat.png";

        //isi qrcode jika di scan
        $codeContents = base_url('perangkat/performPerangkat/') . $id;


        //simpan file qrcode
        QRcode::png($codeContents, $tempdir . $name . '.png', QR_ECLEVEL_H, 20, 4);


        // ambil file qrcode
        $QR = imagecreatefrompng($tempdir . $name . '.png');

        // memulai menggambar logo dalam file qrcode
        $logo = imagecreatefromstring(file_get_contents($logopath));

        imagecolortransparent($logo, imagecolorallocatealpha($logo, 0, 0, 0, 127));
        imagealphablending($logo, false);
        imagesavealpha($logo, true);

        $QR_width = imagesx($QR);
        $QR_height = imagesy($QR);

        $logo_width = imagesx($logo);
        $logo_height = imagesy($logo);

        // Scale logo to fit in the QR Code (Diperbesar hingga 50% agar sangat jelas)
        $logo_qr_width = $QR_width / 2.5; // Diatur ke 40% untuk keseimbangan antara visibilitas dan scannability
        $scale = $logo_width / $logo_qr_width;
        $logo_qr_height = $logo_height / $scale;

        // Kalkulasi posisi X dan Y agar logo tepat berada di tengah QR Code
        $logo_qr_x = ($QR_width - $logo_qr_width) / 2;
        $logo_qr_y = ($QR_height - $logo_qr_height) / 2;

        // Draw background putih agar tulisan logo tidak bertumpuk dengan kotak-kotak QR code (Bring to Front)
        $white = imagecolorallocate($QR, 255, 255, 255);
        // Padding putih tambahan (opsional) agar tidak terlalu mepet kotak QR
        $padding = 2; // Minimal padding untuk melindungi scannability
        imagefilledrectangle($QR, $logo_qr_x - $padding, $logo_qr_y - $padding, $logo_qr_x + $logo_qr_width + $padding, $logo_qr_y + $logo_qr_height + $padding, $white);

        imagecopyresampled($QR, $logo, $logo_qr_x, $logo_qr_y, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

        // Simpan kode QR lagi, dengan logo di atasnya
        imagepng($QR, $tempdir . $name . '.png');
        //echo '<img src="'.base_url().$tempdir. $name.'.png" class="img-fluid rounded"/>';
        return $id_unit . '/' . $name . '.png';
    }
    public function index()
    {

        //$data = $this->position();
        // $data = access($data,"VIEW");

        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Alat" . sess()['unit_kode'];
        $data["title_des"] = " List Data Alat " . sess()['unit_name'];
        $data["content"] = "v_index";

        $data["data"] = $data;
        $this->load->view('template_v2', $data);

        // echo "<pre>",print_r (sess()),"</pre>";
        //  echo "<pre>",print_r ( $data),"</pre>";
    }


    function LoadData($from = null)
    {
        if (isset($_POST['limit'])) {
            $limit = $_POST['limit'];
        } else {
            // Atur nilai default jika $_POST['limit'] tidak diatur
            $limit = 3000;
        }

        if (isset($_POST['src'])) {
            $src = $_POST['src'];
        } else {
            // Atur nilai default jika $_POST['limit'] tidak diatur
            $src = '';
        }

        if (isset($_POST['jenis_perangkat'])) {
            $jenis = $_POST['jenis_perangkat'];
        } else {
            // Atur nilai default jika $_POST['limit'] tidak diatur
            $jenis = '';
        }
        $from = $this->uri->segment(3);

        $unit_val = $this->input->post('filter_unit');
        if (empty($unit_val)) {
            $unit_val = $this->input->post('unit');
        }

        if (is_sk_manager()) {
            $allowed = get_allowed_units();
            if (!empty($unit_val) && in_array((int)$unit_val, $allowed)) {
                $where_unit = array('id_unit' => (int)$unit_val);
            } else {
                $where_unit = array('id_unit IN (' . implode(',', $allowed) . ')' => null);
            }
        } else {
            $where_unit = array('id_unit' => sess()['unit']);
        }

        $param = [
            'table' => 'perangkat',
            'pk' => 'id_perangkat',
            'parameter' => array_merge(array('status !=' => 8, 'id_perangkat >=' => 0), $where_unit),
            'url' => $this->uri->segment(2),
            'from' => $from,
            'limit' => $limit,
            'filter' => (!empty($jenis) ? array('id_jenisperangkat' => $jenis) : ''),

            'src' => $src,
            'param_src' => [
                'like' => 'nama_perangkat',
                'or_like' => 'serial_number'
            ]
        ];


        $data['url'] = $this->uri->segment(2);
        $totalData = CountDataPag($param);

        $param['total_data'] = $totalData;
        $param['total_page'] = ceil($totalData / $limit);
        $res = pagin($param);
        foreach ($res['data'] as $key => $value) {
            $jenis = $this->Mod->getWhere('jenis_perangkat ', array('id_jenisperangkat' => $value['id_jenisperangkat'], 'status !=' => 8))->row_array();
            $fasilitas = $this->Mod->getWhere('fasilitas_detail', array('id_jenisperangkat' => $value['id_jenisperangkat'], 'id_perangkat' => $value['id_perangkat']))->row_array();
            $merk = $this->Mod->getWhere('merk', array('id' => $value['merk_id']))->row_array();
            $model = $this->Mod->getWhere('model', array('id_perangkat' => $value['id_model']))->row_array();
            // Validasi sebelum mengakses array
            $res['data'][$key]['model'] = $this->safeArrayValue($model, 'nama_perangkat');
            $res['data'][$key]['merk'] = $this->safeArrayValue($merk, 'nama');
            $res['data'][$key]['jenis_perangkat'] = $this->safeArrayValue($jenis, 'nama');
            $res['data'][$key]['stat'] = sts('2', $value['status']);
            if (!empty($fasilitas)) {
                $res['data'][$key]['id_fasilitas'] = $fasilitas['id_fasilitas'];
                $nf = $this->Mod->getWhere('fasilitas', array('id_fasilitas' => $fasilitas['id_fasilitas']))->row_array();
                $res['data'][$key]['nama_fasilitas'] = !empty($nf['nama_fasilitas']) ? $nf['nama_fasilitas'] : '-';
                $res['data'][$key]['lokasi'] = !empty($nf['terminal']) ? $nf['terminal'] : '-';
            } else {
                $res['data'][$key]['id_fasilitas'] = '';
                $res['data'][$key]['nama_fasilitas'] = '-';
                $res['data'][$key]['lokasi'] = '-';
            }
        }
        $data['perangkat'] = $res['data'];
        $data['pag'] = $res['pag'];


        echo json_encode($data);
    }
    private function safeArrayValue($array, $key, $default = '-')
    {
        return (is_array($array) && isset($array[$key]) && !empty($array[$key])) ? $array[$key] : $default;
    }

    public function ExportExcel()
    {
        $src = isset($_GET['src']) ? $_GET['src'] : '';
        $jenis = isset($_GET['jenis_perangkat']) ? $_GET['jenis_perangkat'] : '';
        $from = 0;

        $id_unit = sess()['unit'];

        $this->db->select('p.nama_perangkat, p.serial_number, p.status, jp.nama as jenis_alat, f.nama_fasilitas as nama_peralatan, f.terminal as lokasi');
        $this->db->from('perangkat p');
        $this->db->join('jenis_perangkat jp', 'jp.id_jenisperangkat = p.id_jenisperangkat', 'left');
        $this->db->join('fasilitas_detail fd', 'fd.id_perangkat = p.id_perangkat', 'left');
        $this->db->join('fasilitas f', 'f.id_fasilitas = fd.id_fasilitas', 'left');
        $this->db->where('p.status !=', 8);
        $this->db->where('p.id_unit', $id_unit);

        if (!empty($jenis)) {
            $this->db->where('p.id_jenisperangkat', $jenis);
        }

        if (!empty($src)) {
            $this->db->group_start();
            $this->db->like('p.nama_perangkat', $src);
            $this->db->or_like('p.serial_number', $src);
            $this->db->group_end();
        }

        $this->db->order_by('p.id_perangkat', 'ASC');
        $res = $this->db->get()->result_array();

        $perangkatData = [];
        if (!empty($res)) {
            foreach ($res as $key => $value) {
                $status_text = '';
                if ($value['status'] == 1) {
                    $status_text = 'Used';
                } elseif ($value['status'] == 0) {
                    $status_text = 'Stock';
                }

                $perangkatData[] = [
                    'no' => $key + 1,
                    'nama_alat' => $value['nama_perangkat'],
                    'nama_peralatan' => !empty($value['nama_peralatan']) ? $value['nama_peralatan'] : '-',
                    'lokasi' => !empty($value['lokasi']) ? $value['lokasi'] : '-',
                    'sn' => $value['serial_number'],
                    'jenis_alat' => !empty($value['jenis_alat']) ? $value['jenis_alat'] : '-',
                    'status' => $status_text
                ];
            }
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Alat');
        $sheet->setCellValue('C1', 'Nama Peralatan');
        $sheet->setCellValue('D1', 'Lokasi');
        $sheet->setCellValue('E1', 'SN');
        $sheet->setCellValue('F1', 'Jenis Alat');
        $sheet->setCellValue('G1', 'Status');

        $row = 2;
        foreach ($perangkatData as $data) {
            $sheet->setCellValue('A' . $row, $data['no']);
            $sheet->setCellValue('B' . $row, $data['nama_alat']);
            $sheet->setCellValue('C' . $row, $data['nama_peralatan']);
            $sheet->setCellValue('D' . $row, $data['lokasi']);
            $sheet->setCellValue('E' . $row, $data['sn']);
            $sheet->setCellValue('F' . $row, $data['jenis_alat']);
            $sheet->setCellValue('G' . $row, $data['status']);
            $row++;
        }

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Export_Alat_' . date('YmdHis') . '.xlsx';

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    function LoadDataDetail($id = null)
    {

        $data_res['detail'] = $this->Mod->GetCustome('SELECT a.*,b.nama as property FROM perangkat_detail a left JOIN master_perangkat_detail b on b.idmaster_detail_perangkat = a.idmaster_detail_perangkat Where  a.id_perangkat = \'' . $id . '\'')->result_array();
        echo json_encode($data_res);
    }

    function LoadDataByid($id)
    {
        //$data= $this->position();
        // $acc  = access($data,"VIEW")['access'];
        $data_res['perangkat'] = $this->Mod->GetCustome("
        SELECT 
            p.id_perangkat,
            p.nama_perangkat,
            u.kode_unit,
            f.ip_address,
            p.serial_number,
            f.status,
            l.create_date,
            m.nama AS merk_nama
        FROM 
            perangkat p
        LEFT JOIN 
            unit u ON p.id_unit = u.id_unit 
        LEFT JOIN 
            fasilitas f ON f.id_fasilitas = p.nama_perangkat 
        LEFT JOIN 
            logbook l ON l.id_perangkat = p.id_perangkat
        LEFT JOIN
            merk m ON m.id = p.merk_id
        WHERE
            p.id_perangkat = $id ")->result_array();
        // $data_res['detail'] = $this->Mod->getWhere('perangkat_detail',array('id_perangkat' =>$id ))->result_array();
        echo json_encode($data_res);
    }

    function ViewDetail($id = null)
    {
        if (!empty($id)) {
            $perangkat = $this->Mod->getWhere('perangkat ', array('status !=' => 8, 'id_perangkat' => $id))->row_array();
            $merk = $this->Mod->getWhere('merk ', array('id' => $perangkat['merk_id']))->row_array();
            $model = $this->Mod->getWhere('model ', array('id_perangkat' => $perangkat['id_model']))->row_array();
            $jenis = $this->Mod->getWhere('jenis_perangkat ', array('id_jenisperangkat' => $perangkat['id_jenisperangkat']))->row_array();
            $perangkat['jenis'] = $this->safeArrayValue($jenis, 'nama');
            (!empty($model) ? $perangkat['model'] = $model['nama_perangkat'] : '');
            (!empty($merk) ? $perangkat['merk'] = $merk['nama'] : '');

            // Get linked facility info
            $fasilitas_detail = $this->Mod->getWhere('fasilitas_detail', array('id_perangkat' => $id))->row_array();
            if (!empty($fasilitas_detail)) {
                $fasilitas = $this->Mod->getWhere('fasilitas', array('id_fasilitas' => $fasilitas_detail['id_fasilitas']))->row_array();
                $perangkat['nama_fasilitas'] = !empty($fasilitas['nama_fasilitas']) ? $fasilitas['nama_fasilitas'] : '-';
                $perangkat['terminal'] = !empty($fasilitas['terminal']) ? $fasilitas['terminal'] : '-';
            } else {
                $perangkat['nama_fasilitas'] = '-';
                $perangkat['terminal'] = '-';
            }

            $detail = $this->Mod->getWhere('perangkat_detail ', array('id_perangkat' => $perangkat['id_perangkat']))->result_array();

            if (!empty($detail)) {
                foreach ($detail as $key => $value2) {
                    $property = $this->Mod->getWhere('master_perangkat_detail ', array('idmaster_detail_perangkat' => $value2['idmaster_detail_perangkat']))->row_array();

                    // $detail[$key][$property['nama']] = $value2['nama'];
                    $perangkat['detail'][$key]['property'] = $property['nama'];
                    $perangkat['detail'][$key]['value'] = $value2['nama'];
                }
                // $perangkat['detail'] = $detail;

            } else {
                $perangkat['detail'] = array();
            }

            $lv1 = "doc";
            if (!file_exists($lv1)) {
                mkdir($lv1);
            }
            $lv2 = $lv1 . "/QRCode2";
            if (!file_exists($lv2)) {
                mkdir($lv2);
            }


            if (empty($perangkat['QRCODE'])) {
                //echo "<pre>",print_r ($perangkat),"</pre>";
                $qr = $this->QRCodeRender($perangkat);
                $update = ['QRCODE' => $qr];
                $this->Mod->update2('perangkat', array('id_perangkat' => $id), $update);
                $perangkat['QRCODE'] = $qr;
            } else {
                $filename = 'doc/QRCode/' . $perangkat['QRCODE'];
                // Regenerate if file missing OR if it's the old format (no slash in path)
                if (!file_exists($filename) || strpos($perangkat['QRCODE'], '/') === false) {
                    $qr = $this->QRCodeRender($perangkat);
                    $update = ['QRCODE' => $qr];
                    $this->Mod->update2('perangkat', array('id_perangkat' => $id), $update);
                    $perangkat['QRCODE'] = $qr;
                }
            }
        }
        echo json_encode($perangkat);
    }

    function EditData($id = null)
    {
        if (!empty($id)) {
            $perangkat = $this->Mod->getWhere('perangkat ', array('status !=' => 8, 'id_perangkat' => $id))->row_array();
            $merk = $this->Mod->getWhere('merk ', array('id' => $perangkat['merk_id']))->row_array();
            (!empty($merk) ? $perangkat['merk'] = $merk['nama'] : '');
            $detail = $this->Mod->getWhere('perangkat_detail ', array('id_perangkat' => $perangkat['id_perangkat']))->result_array();

            if (!empty($detail)) {
                foreach ($detail as $key => $value2) {
                    $property = $this->Mod->getWhere('master_perangkat_detail ', array('idmaster_detail_perangkat' => $value2['idmaster_detail_perangkat']))->row_array();

                    // $detail[$key][$property['nama']] = $value2['nama'];
                    $perangkat['detail'][$key]['id_perangkat_detail'] = $value2['id_perangkat_detail'];
                    $perangkat['detail'][$key]['idmaster_detail_perangkat'] = $value2['idmaster_detail_perangkat'];
                    $perangkat['detail'][$key]['property'] = $property['nama'];
                    $perangkat['detail'][$key]['value'] = $value2['nama'];
                }
                // $perangkat['detail'] = $detail;

            } else {
                $perangkat['detail'] = array();
            }
            // echo "<pre>",print_r ($perangkat),"</pre>";


        }
        echo json_encode($perangkat);
    }



    // function LoadDataAnl($id = null)
    // {
    //     $perangkat = $this->Mod->GetCustome("SELECT a.*,c.nama_fasilitas,d.nama as jenis_perangkat,e.nama as merk from perangkat a LEFT join fasilitas_detail b on b.id_perangkat = a.id_perangkat left join fasilitas c on c.id_fasilitas = b.id_fasilitas LEFT JOIN jenis_perangkat d on d.id_jenisperangkat= a.id_jenisperangkat LEFT JOIN merk e on e.id = a.merk_id where a.id_perangkat = '" . $id . "'")->row_array();
    //     $perangkat_detail = $this->Mod->GetCustome("SELECT a.*,b.nama as property_name FROM perangkat_detail a left join master_perangkat_detail b on b.idmaster_detail_perangkat = a.idmaster_detail_perangkat WHERE id_perangkat ='" . $perangkat['id_perangkat'] . "' ")->result_array();
    //     $perangkat['detail'] = $perangkat_detail;
    //     $todayDate = date('Y-m-d');
    //     // Mengambil data history tinjut yang terkait dengan perangkat ini
    //     $logHistory = $this->Mod->GetCustome("   SELECT 
    //         t.nomor,
    //         t.description,
    //         t.tanggal_mulai,
    //         t.tanggal_selesai,
    //         tm.id_temuan,
    //         tm.tanggal as tanggal_temuan,
    //         c.nama_perangkat, 
    //         jm.nama_masalah as nama_masalah_tinjut,
    //         k.nama_komponen,
    //         td.description as tindakan,
    //         f.nama_fasilitas,
    //         TIMESTAMPDIFF(MINUTE, tm.tanggal, t.tanggal_selesai) as downtime_menit
    //     FROM tinjut t
    //     LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut 
    //     LEFT JOIN perangkat c ON c.id_perangkat = td.id_perangkat 
    //     LEFT JOIN jenis_masalah jm ON jm.id = td.id_jenismasalah 
    //     LEFT JOIN temuan tm ON tm.id_temuan = t.id_temuan
    //     LEFT JOIN komponen k ON k.id_komponen = td.id_komponen
    //     LEFT JOIN fasilitas f ON f.id_fasilitas = t.id_fasilitas
    //     WHERE td.id_perangkat = '" . $id . "'
    //     ORDER BY t.tanggal_mulai DESC ")->result_array();

    //     $result['LogHistory'] = $logHistory;

    //     // AMBIL ID UNIT DARI SESSION - CARA YANG LEBIH FLEKSIBEL
    //     $id_unit = !empty(sess()['unit']) ? sess()['unit'] : null;

    //     // ID UNIT KHUSUS (14, 15, 16, 17) - PERHITUNGAN BULANAN
    //     if (in_array($id_unit, [14, 15, 16, 17])) {
    //         $total_minutes_in_month = date('t') * 24 * 60;

    //         // Cek status dari tinjut dan tinjut_detail
    //         $status_query = $this->Mod->GetCustome("
    //         SELECT t.status AS tinjut_status, td.status AS tinjut_detail_status
    //         FROM tinjut t
    //         LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
    //         WHERE td.id_perangkat = '" . $id . "'
    //         AND MONTH(t.tanggal_mulai) = MONTH(NOW()) 
    //         AND YEAR(t.tanggal_mulai) = YEAR(NOW())
    //     ")->row_array();

    //         $tinjut_status = !empty($status_query['tinjut_status']) ? $status_query['tinjut_status'] : null;
    //         $tinjut_detail_status = !empty($status_query['tinjut_detail_status']) ? $status_query['tinjut_detail_status'] : null;

    //         // Jika status di kedua tabel adalah 2, atau kosong, set performa 100%
    //         if (($tinjut_status == 2 || empty($tinjut_status)) && ($tinjut_detail_status == 2 || empty($tinjut_detail_status))) {
    //             $performa = 100;
    //         } else {
    //             // Hitung downtime bulan berjalan
    //             $downtime_query = $this->Mod->GetCustome("
    //             SELECT SUM(TIMESTAMPDIFF(MINUTE, tm.tanggal, t.tanggal_selesai)) AS total_downtime 
    //             FROM tinjut t
    //             LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
    //             LEFT JOIN temuan tm ON tm.id_temuan = t.id_temuan
    //             WHERE td.id_perangkat = '" . $id . "'
    //             AND MONTH(t.tanggal_mulai) = MONTH(NOW()) 
    //             AND YEAR(t.tanggal_mulai) = YEAR(NOW())
    //         ")->row_array();

    //             $downtime = !empty($downtime_query['total_downtime']) ? $downtime_query['total_downtime'] : 0;

    //             if ($total_minutes_in_month > 0) {
    //                 $performa = (($total_minutes_in_month - $downtime) / $total_minutes_in_month) * 100;
    //                 $performa = round($performa, 2);
    //             } else {
    //                 $performa = 100;
    //             }
    //         }

    //         // UNIT LAIN - PERHITUNGAN TAHUNAN (RUMUS YANG ANDA MINTA)
    //     } elseif (in_array($id_unit, [18, 17, 19, 20, 21, 22, 23])) {
    //         // Hitung total menit dalam tahun berjalan dengan DateTime
    //         $current_year = date('Y');
    //         $start_of_year = new DateTime("$current_year-01-01");
    //         $end_of_year = new DateTime("$current_year-12-31");
    //         $total_days_in_year = $end_of_year->diff($start_of_year)->days + 1;
    //         $total_minutes_in_year = $total_days_in_year * 24 * 60;

    //         // Hitung total downtime dalam menit untuk tahun berjalan
    //         $downtime_query = $this->Mod->GetCustome("
    //         SELECT SUM(TIMESTAMPDIFF(MINUTE, tm.tanggal, t.tanggal_selesai)) AS total_downtime 
    //         FROM tinjut t
    //         LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
    //         LEFT JOIN temuan tm ON tm.id_temuan = t.id_temuan
    //         WHERE td.id_perangkat = '" . $id . "'
    //         AND YEAR(t.tanggal_mulai) = YEAR(NOW())
    //     ")->row_array();

    //         $downtime = !empty($downtime_query['total_downtime']) ? $downtime_query['total_downtime'] : 0;

    //         if ($total_minutes_in_year > 0) {
    //             $downtime_percentage = ($downtime / $total_minutes_in_year) * 100;
    //             $performa = 100 - $downtime_percentage;
    //             $performa = round($performa, 2);
    //         } else {
    //             $performa = 100;
    //         }

    //     } else {
    //         // AMBIL DATA FASILITAS BERDASARKAN PERANGKAT
    //         $fasilitas_query = $this->Mod->GetCustome("
    //         SELECT c.kode 
    //         FROM perangkat a 
    //         LEFT JOIN fasilitas_detail b ON b.id_perangkat = a.id_perangkat 
    //         LEFT JOIN fasilitas c ON c.id_fasilitas = b.id_fasilitas 
    //         WHERE a.id_perangkat = '" . $id . "'
    //     ")->row_array();

    //         $kode_fasilitas = !empty($fasilitas_query['kode']) ? $fasilitas_query['kode'] : null;

    //         // LOGIKA BERDASARKAN KODE FASILITAS
    //         if ($kode_fasilitas == 1) {
    //             // FASILITAS KODE 1 - RUMUS TAHUNAN
    //             $current_year = date('Y');
    //             $start_of_year = new DateTime("$current_year-01-01");
    //             $end_of_year = new DateTime("$current_year-12-31");
    //             $total_days_in_year = $end_of_year->diff($start_of_year)->days + 1;
    //             $total_minutes_in_year = $total_days_in_year * 24 * 60;

    //             // Hitung total downtime dalam menit untuk tahun berjalan
    //             $downtime_query = $this->Mod->GetCustome("
    //             SELECT SUM(TIMESTAMPDIFF(MINUTE, tm.tanggal, t.tanggal_selesai)) AS total_downtime 
    //             FROM tinjut t
    //             LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
    //             LEFT JOIN temuan tm ON tm.id_temuan = t.id_temuan
    //             WHERE td.id_perangkat = '" . $id . "'
    //               AND YEAR(t.tanggal_mulai) = YEAR(NOW())
    //         ")->row_array();

    //             $downtime = !empty($downtime_query['total_downtime']) ? $downtime_query['total_downtime'] : 0;

    //             if ($total_minutes_in_year > 0) {
    //                 $downtime_percentage = ($downtime / $total_minutes_in_year) * 100;
    //                 $performa = 100 - $downtime_percentage;
    //                 $performa = round($performa, 2);
    //             } else {
    //                 $performa = 100;
    //             }

    //         } elseif ($kode_fasilitas == 2) {
    //             // FASILITAS KODE 2 - RUMUS BULANAN
    //             $total_minutes_in_month = date('t') * 24 * 60;

    //             // Cek status dari tinjut dan tinjut_detail
    //             $status_query = $this->Mod->GetCustome("
    //             SELECT t.status AS tinjut_status, td.status AS tinjut_detail_status
    //             FROM tinjut t
    //             LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
    //             WHERE td.id_perangkat = '" . $id . "'
    //             AND MONTH(t.tanggal_mulai) = MONTH(NOW()) 
    //             AND YEAR(t.tanggal_mulai) = YEAR(NOW())
    //         ")->row_array();

    //             $tinjut_status = !empty($status_query['tinjut_status']) ? $status_query['tinjut_status'] : null;
    //             $tinjut_detail_status = !empty($status_query['tinjut_detail_status']) ? $status_query['tinjut_detail_status'] : null;

    //             // Jika status di kedua tabel adalah 2, atau kosong, set performa 100%
    //             if (($tinjut_status == 2 || empty($tinjut_status)) && ($tinjut_detail_status == 2 || empty($tinjut_detail_status))) {
    //                 $performa = 100;
    //             } else {
    //                 // Hitung downtime bulan berjalan
    //                 $downtime_query = $this->Mod->GetCustome("
    //                 SELECT SUM(TIMESTAMPDIFF(MINUTE, tm.tanggal, t.tanggal_selesai)) AS total_downtime 
    //                 FROM tinjut t
    //                 LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
    //                 LEFT JOIN temuan tm ON tm.id_temuan = t.id_temuan
    //                 WHERE td.id_perangkat = '" . $id . "'
    //                 AND MONTH(t.tanggal_mulai) = MONTH(NOW()) 
    //                 AND YEAR(t.tanggal_mulai) = YEAR(NOW())
    //             ")->row_array();

    //                 $downtime = !empty($downtime_query['total_downtime']) ? $downtime_query['total_downtime'] : 0;

    //                 if ($total_minutes_in_month > 0) {
    //                     $performa = (($total_minutes_in_month - $downtime) / $total_minutes_in_month) * 100;
    //                     $performa = round($performa, 2);
    //                 } else {
    //                     $performa = 100;
    //                 }
    //             }
    //         } else {
    //             // DEFAULT JIKA TIDAK ADA KODE FASILITAS YANG COCOK
    //             $performa = 100;
    //         }
    //     }

    //     // Pastikan performa tidak kosong
    //     if (empty($performa)) {
    //         $performa = 100;
    //     }

    //     // Formatting dan warna
    //     $performa_formatted = number_format($performa, 1);

    //     if ($performa_formatted <= 35) {
    //         $warna = '#f20505';
    //     } elseif ($performa_formatted <= 75) {
    //         $warna = '#f27b05';
    //     } else {
    //         $warna = '#3380ff';
    //     }

    //     $result['perfomChart'] = array(
    //         'Performa' => $performa,
    //         'color' => $warna
    //     );

    //     $result['nilai_Asli'] = $performa_formatted;

    //     // Data untuk Chart Masalah Kerusakan (berdasarkan kategori masalah)
    //     $problem_data = $this->Mod->GetCustome("
    //     SELECT jm.nama_masalah, COUNT(*) as total 
    //     FROM tinjut_detail td
    //     JOIN jenis_masalah jm ON jm.id = td.id_jenismasalah
    //     WHERE td.id_perangkat = '" . $id . "'
    //     GROUP BY td.id_jenismasalah
    // ")->result_array();

    //     foreach ($problem_data as $val) {
    //         $result['ProblemChart']['lebel'][] = $val['nama_masalah'];
    //         $result['ProblemChart']['value'][] = $val['total'];
    //         $result['ProblemChart']['color'][] = colrand();
    //     }

    //     // Data untuk Chart Kerusakan Komponen (berdasarkan komponen yang diganti/diperbaiki)
    //     $component_data = $this->Mod->GetCustome("
    //     SELECT k.nama_komponen, COUNT(*) as total 
    //     FROM tinjut_detail td
    //     JOIN komponen k ON k.id_komponen = td.id_komponen
    //     WHERE td.id_perangkat = '" . $id . "'
    //     GROUP BY td.id_komponen
    // ")->result_array();

    //     foreach ($component_data as $val) {
    //         $result['ComponentChart']['lebel'][] = $val['nama_komponen'];
    //         $result['ComponentChart']['value'][] = $val['total'];
    //         $result['ComponentChart']['color'][] = colrand();
    //     }

    //     $result['perangkat'] = $perangkat;
    //     echo json_encode($result);
    // }


    public function GetInfoPerangkat($id) {
        $query = $this->db->query("
            SELECT a.nama_perangkat, a.serial_number, c.nama_fasilitas, c.terminal as lokasi, d.nama as jenis_perangkat, a.status 
            FROM perangkat a 
            LEFT JOIN fasilitas_detail b on b.id_perangkat = a.id_perangkat 
            LEFT JOIN fasilitas c on c.id_fasilitas = b.id_fasilitas 
            LEFT JOIN jenis_perangkat d on d.id_jenisperangkat = a.id_jenisperangkat 
            WHERE a.id_perangkat = '$id'
        ");
        $data = $query->row_array();
        
        echo json_encode([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function LoadHistoryKerusakan()
    {
        $id_perangkat = $this->input->post('id_perangkat');
        $bulan = $this->input->post('bulan');
        
        $whereBulan = "";
        if (!empty($bulan)) {
            $whereBulan = " AND MONTH(t.tanggal) = '$bulan' ";
        }

        // Tinjut detail is the link between perangkat and tinjut
        $query = $this->db->query("
            SELECT 
                t.nomor, 
                t.tanggal, 
                t.kondisi, 
                f.nama_fasilitas, 
                f.terminal, 
                t.uraian_kejadian, 
                t.status,
                tj.tindakan, 
                tj.pelaksana, 
                tj.tanggal_mulai, 
                tj.tanggal_selesai,
                tj.id_tinjut,
                (
                    SELECT GROUP_CONCAT(CONCAT('<a href=\"".base_url()."perangkat/performPerangkat/', p.id_perangkat, '\" target=\"_blank\" class=\"text-primary font-weight-bold\">', p.nama_perangkat, '</a>') SEPARATOR ', ')
                    FROM temuan_detail td_in
                    JOIN perangkat p ON td_in.id_perangkat = p.id_perangkat
                    WHERE td_in.id_temuan = t.id_temuan
                ) as nama_perangkat,
                (
                    SELECT GROUP_CONCAT(jm.nama_masalah SEPARATOR ', ')
                    FROM jenis_masalah_terpakai jmt
                    JOIN jenis_masalah jm ON jmt.id_jenis_masalah = jm.id
                    WHERE jmt.id_tinjut = tj.id_tinjut
                ) as jenis_masalah,
                (
                    SELECT GROUP_CONCAT(CONCAT(k.nama_komponen, ' (', kt.satuan_terpakai, ')') SEPARATOR ', ')
                    FROM komponen_terpakai kt
                    JOIN komponen k ON kt.id_komponen = k.id_komponen
                    WHERE kt.id_tinjut = tj.id_tinjut
                ) as komponen_pcs
            FROM temuan t
            JOIN temuan_detail td ON td.id_temuan = t.id_temuan
            LEFT JOIN fasilitas f ON t.id_fasilitas = f.id_fasilitas
            LEFT JOIN tinjut tj ON t.id_temuan = tj.id_temuan
            WHERE td.id_perangkat = '$id_perangkat'
              $whereBulan
              AND t.status != 8
              AND (tj.status != 8 OR tj.status IS NULL)
            GROUP BY t.id_temuan
            ORDER BY t.tanggal DESC
        ");

        $formatIndo = function($datetime) {
            if (empty($datetime) || $datetime === '0000-00-00 00:00:00') return null;
            $hari = array ( 1 =>    'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu' );
            $bulan = array (1 =>   'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember' );
            
            $time = strtotime($datetime);
            $hari_ini = $hari[date('N', $time)];
            $tgl = date('d', $time);
            $bln = $bulan[(int)date('m', $time)];
            $thn = date('Y', $time);
            $jam = date('H:i', $time); 
            
            return $hari_ini . ', ' . $tgl . ' ' . $bln . ' ' . $thn . ' ' . $jam;
        };

        $data = [];
        foreach ($query->result_array() as $row) {
            $ket_waktu = '-';
            if (!empty($row['tanggal_selesai']) && !empty($row['tanggal']) && $row['tanggal_selesai'] !== '0000-00-00 00:00:00' && $row['tanggal'] !== '0000-00-00 00:00:00') {
                $datetime1 = new DateTime($row['tanggal']);
                $datetime2 = new DateTime($row['tanggal_selesai']);
                $interval = $datetime1->diff($datetime2);
                
                $parts = [];
                if ($interval->d > 0) $parts[] = $interval->d . ' Hari';
                if ($interval->h > 0) $parts[] = $interval->h . ' Jam';
                if ($interval->i > 0) $parts[] = $interval->i . ' Menit';
                
                if (count($parts) > 0) {
                    $ket_waktu = implode(', ', $parts);
                } else {
                    $ket_waktu = 'Kurang dari 1 menit';
                }
            }

            $status_label = '';
            if ($row['status'] == 0) $status_label = '<span class="badge badge-secondary" style="font-size:12px;">(Open) Draft</span>';
            elseif ($row['status'] == 1) $status_label = '<span class="badge badge-warning" style="font-size:12px;">(Open) Proses</span>';
            elseif ($row['status'] == 2) $status_label = '<span class="badge badge-info" style="font-size:12px;">(Open) Menunggu Approve</span>';
            elseif ($row['status'] == 9) $status_label = '<span class="badge badge-success" style="font-size:12px;">(Close) Approved</span>';
            else $status_label = '<span class="badge badge-light">Unknown ('.$row['status'].')</span>';

            $data[] = [
                'nomor' => $row['nomor'] ?: '-',
                'tanggal' => $formatIndo($row['tanggal']) ?: '-',
                'kondisi' => $row['kondisi'] ?: '-',
                'nama_fasilitas' => $row['nama_fasilitas'] ?: '-',
                'nama_perangkat' => $row['nama_perangkat'] ?: '-',
                'terminal' => $row['terminal'] ?: '-',
                'uraian_kejadian' => $row['uraian_kejadian'] ?: '-',
                'tindakan' => $row['tindakan'] ?: '-',
                'pelaksana' => $row['pelaksana'] ?: '-',
                'jenis_masalah' => $row['jenis_masalah'] ?: '-',
                'komponen_pcs' => $row['komponen_pcs'] ?: '-',
                'tanggal_mulai' => $formatIndo($row['tanggal_mulai']) ?: '-',
                'tanggal_selesai' => $formatIndo($row['tanggal_selesai']) ?: '-',
                'ket_waktu' => $ket_waktu,
                'status_label' => $status_label
            ];
        }

        echo json_encode([
            'status' => 'success',
            'data' => $data
        ]);
    }
    
    function Loadmasterdetail($id)
    {
        //$data= $this->position();
        // $acc  = access($data,"VIEW")['access'];

        $data = $this->Mod->getWhere('master_perangkat_detail', array('id_jenisperangkat' => $id, 'status !=' => 8))->result_array();
        echo json_encode($data);
    }


    function SaveData()
    {
        $data = array_filter($_POST);
        if (!empty($data)) {
            unset($data['master']);
            $data['status'] = (int) $_POST['status']; // Langsung konversi ke int
            $data['id_unit'] = sess()['unit'];
            $this->db->insert('perangkat', $data);
            $idperangkat = $this->db->insert_id();
            if (!empty($_POST['master'])) {

                foreach ($_POST['master'] as $key => $value) {

                    $detail = [
                        'idmaster_detail_perangkat' => $value['idmaster_detail_perangkat'],
                        'id_perangkat' => $idperangkat,
                        'nama' => $value['nilai'],
                        'status' => 1,
                    ];
                    $this->db->insert('perangkat_detail', $detail);
                }
            }
        }
    }

    function UpdateData($id = null)
    {
        $data = array_filter($_POST);
        if (!empty($data)) {
            unset($data['master']);
            unset($data['edit']);
            $data['status'] = (int) $_POST['status']; // Langsung konversi ke int
            $data['id_unit'] = sess()['unit'];
            if (!empty($_POST['master'])) {
                $id_delete = array();
                foreach ($_POST['master'] as $key => $value) {
                    $detail = [
                        'idmaster_detail_perangkat' => $value['idmaster_detail_perangkat'],
                        'id_perangkat' => $id,
                        'nama' => $value['nilai'],
                        'status' => 1,
                    ];
                    $cek_detail = $this->Mod->getWhere('perangkat_detail', array('idmaster_detail_perangkat' => $value['idmaster_detail_perangkat'], 'id_perangkat' => $id))->row_array();
                    if (!empty($cek_detail)) {
                        echo "Update  old";
                        $update = $this->Mod->update2('perangkat_detail', array('id_perangkat_detail' => $cek_detail['id_perangkat_detail']), $detail);
                    } else {
                        $id_delete[] = $value['idmaster_detail_perangkat'];
                        // 
                        $this->db->insert('perangkat_detail', $detail);
                    }
                }
                if (!empty($id_delete)) {

                    $result = $this->Mod->deletein('perangkat_detail', array('id_perangkat' => $id), 'idmaster_detail_perangkat', $id_delete);
                }
            }
            if (!empty($_POST['edit'])) {
                foreach ($_POST['edit'] as $key => $value) {
                    echo "Update";
                    $detail = [
                        'idmaster_detail_perangkat' => $value['idmaster_detail_perangkat'],
                        'nama' => $value['nilai'],
                        'status' => 1,
                    ];
                    $update = $this->Mod->update2('perangkat_detail', array('id_perangkat_detail' => $value['id_perangkat_detail']), $detail);
                }
            }




            $update = $this->Mod->update2('perangkat', array('id_perangkat' => $id), $data);
            $response = [
                'code' => '200',
                'msg' => 'Update Data Succes'
            ];
        } else {
            $response = [
                'code' => '400',
                'msg' => 'Failed Update Data'
            ];
        }
        echo json_encode($response);
    }



    function performPerangkat($id = null)
    {
        if (!empty($id)) {
            $data["plugin"][] = "plugin/datatable";
            $data["plugin"][] = "plugin/select2";
            $data["title"] = "History Card Alat " . sess()['unit_kode'];
            $data["title_des"] = " History Card & Spesifikasi Alat " . sess()['unit_name'];
            $data["content"] = "v_performa";
            // $limit = 10;
            // $from = $this->uri->segment(3);

            // $data['pagin'] = pagin('perangkat','id_perangkat',array('status !=' => 8),$this->uri->segment(1),$limit,$from);
            $data["data"] = $data;
            $data["id"] = $id;

            $this->load->view('template_v2', $data);
        }
    }

    function Validate()
    {
        $perangkat = $this->Mod->getWhere('perangkat', array('status !=' => 8, 'type' => 1))->result_array();
        foreach ($perangkat as $key => $value) {
            $detail = $this->Mod->getWhere('perangkat_detail', array('id_perangkat' => $value['id_perangkat']))->row_array();
            $detail_perangkat = array();
            if (empty($detail)) {
                $mp = $this->Mod->getWhere('master_perangkat_detail', array('id_jenisperangkat' => $value['id_jenisperangkat']))->result_array();
                foreach ($mp as $key2 => $val2) {
                    $detail_perangkat[] = [
                        'id_perangkat' => $value['id_perangkat'],
                        'idmaster_detail_perangkat' => $val2['idmaster_detail_perangkat'],
                        'status' => 0,
                    ];
                }
            }
            if (!empty($detail_perangkat)) {
                // $this->db->insert_batch('perangkat_detail', $detail_perangkat);
                echo "<pre>", print_r($value['nama_perangkat']), "</pre>";
                echo "<pre>", print_r($detail_perangkat), "</pre>";
            }
        }
    }


    function LoadDataPerangkatByID($id = null)
    {
        $data = array();
        if (!empty($id)) {
            $fd = $this->Mod->getWhere('fasilitas_detail', array('status !=' => 8, 'id_fasilitas' => $id))->result_array();
            // echo "<pre>", print_r($fd), "</pre>";
            foreach ($fd as $key => $value) {
                $data['perangkat'][] = $this->Mod->getWhere('perangkat', array('status !=' => 8, 'id_perangkat' => $value['id_perangkat']))->row_array();
            }
            foreach ($data['perangkat'] as $key => $value) {
                if (in_array(sess()['unit'], [18, 19, 20, 21, 22, 23, 28])) {
                    $data['perangkat'][$key]['nama_perangkat'] = $value['nama_perangkat'];
                } else {
                    $data['perangkat'][$key]['nama_perangkat'] = $value['nama_perangkat'] . (!empty($value['serial_number']) ? "-" . $value['serial_number'] : '');
                }
            }
        }
        echo json_encode($data);
    }

    function Sysdata()
    {


        $perangkat = $this->Mod->getWhere('perangkat', array('status !=' => 8, 'id_unit' => sess()['unit']))->result_array();
        foreach ($perangkat as $key => $value) {
            if (!empty($value['id_model'])) {
                $model = $this->Mod->getWhere('model', array('status !=' => 8, 'id_perangkat' => $value['id_model']))->row_array();
                $detail_model = $this->Mod->getWhere('master_perangkat_detail', array('id_jenisperangkat' => $value['id_jenisperangkat']))->result_array();
                foreach ($detail_model as $key_m => $value_m) {
                    $spek = [
                        'id_perangkat' => $value['id_perangkat'],
                        'idmaster_detail_perangkat' => $value2['idmaster_detail_perangkat'],
                        'status' => '1',
                    ];
                    $cek_m = $this->Mod->getWhere('perangkat_detail', array('id_perangkat' => $value['id_perangkat'], 'idmaster_detail_perangkat' => $value_m['idmaster_detail_perangkat']))->num_rows();
                    if ($cek_m == 0) {
                        $this->db->insert('model_spec', $spek);
                        // echo "<pre>",print_r ($spek),"</pre>";
                    }
                }
            } else {
                $detail = $this->Mod->getWhere('perangkat_detail', array('id_perangkat' => $value['id_perangkat']))->num_rows();
                if ($detail == 0) {

                    $property = $this->Mod->getWhere('master_perangkat_detail', array('id_jenisperangkat' => $value['id_jenisperangkat']))->result_array();
                    foreach ($property as $key2 => $value2) {
                        $insert_detail = [
                            'id_perangkat' => $value['id_perangkat'],
                            'idmaster_detail_perangkat' => $value2['idmaster_detail_perangkat'],
                            'nama' => '',
                            'status' => '0',
                        ];
                        $this->db->insert('perangkat_detail', $insert_detail);
                        // echo "<pre>", print_r($insert_detail), "</pre>";
                    }
                } else {
                    echo "da" . $value['id_perangkat'];
                }
            }
            // echo "<pre>", print_r($detail), "</pre>";
        }
    }
    function LoadPerangkat($from = null)
    {

        if (isset($_POST['limit'])) {
            $limit = $_POST['limit'];
        } else {
            // Atur nilai default jika $_POST['limit'] tidak diatur
            $limit = 3000;
        }

        if (isset($_POST['src'])) {
            $src = $_POST['src'];
        } else {
            // Atur nilai default jika $_POST['limit'] tidak diatur
            $src = '';
        }

        if (isset($_POST['jenis_perangkat'])) {
            $jenis = $_POST['jenis_perangkat'];
        } else {
            // Atur nilai default jika $_POST['limit'] tidak diatur
            $jenis = '';
        }
        $from = $this->uri->segment(3);

        $param = [
            'table' => 'perangkat',
            'pk' => 'id_perangkat',
            'parameter' => array('status !=' => 8, 'id_perangkat >=' => 0, 'id_unit' => sess()['unit']),
            'url' => $this->uri->segment(2),
            'from' => $from,
            'limit' => $limit,
            'filter' => (!empty($jenis) ? array('id_jenisperangkat' => $jenis) : ''),

            'src' => $src,
            'param_src' => [
                'like' => 'nama_perangkat',
                'or_like' => 'serial_number'
            ]
        ];


        $data['url'] = $this->uri->segment(2);
        $totalData = CountDataPag($param);

        $param['total_data'] = $totalData;
        $param['total_page'] = ceil($totalData / $limit);
        $param['jenis'] = 'PrintQrCode';
        $res = pagin($param);
        foreach ($res['data'] as $key => $value) {
            $jenis = $this->Mod->getWhere('jenis_perangkat ', array('id_jenisperangkat' => $value['id_jenisperangkat'], 'status !=' => 8))->row_array();
            $fasilitas = $this->Mod->getWhere('fasilitas_detail', array('id_jenisperangkat' => $value['id_jenisperangkat'], 'id_perangkat' => $value['id_perangkat']))->row_array();
            $merk = $this->Mod->getWhere('merk ', array('id' => $value['merk_id']))->row_array();
            $model = $this->Mod->getWhere('model ', array('id_perangkat' => $value['id_model']))->row_array();

            $res['data'][$key]['model'] = $this->safeArrayValue($model, 'nama_perangkat');
            $res['data'][$key]['merk'] = $this->safeArrayValue($merk, 'nama');
            $res['data'][$key]['jenis_perangkat'] = $this->safeArrayValue($jenis, 'nama');
            $res['data'][$key]['stat'] = sts('2', $value['status']);
            if (!empty($fasilitas)) {
                $res['data'][$key]['id_fasilitas'] = $fasilitas['id_fasilitas'];
            } else {
                $res['data'][$key]['id_fasilitas'] = '';
            }
        }
        $data['perangkat'] = $res['data'];
        $data['pag'] = $res['pag'];


        echo json_encode($data);
        // $data =$this->Mod->getWhere('perangkat',array('status !=' =>8,'id_unit' =>sess()['unit'] ))->result_array();  
        // echo json_encode($data);
    }
    function PrintListQr()
    {
        $data = array();
        if (!empty($_POST)) {
            foreach ($_POST['newdata'] as $key => $value) {

                $perangkat = $this->Mod->getWhere('perangkat', array('id_perangkat' => $value['id_perangkat']))->row_array();
                if (!empty($perangkat['QRCODE']) && strpos($perangkat['QRCODE'], '/') !== false && file_exists('doc/QRCode/' . $perangkat['QRCODE'])) {
                    $data['data'][] = [
                        'id_perangkat' => $value['id_perangkat'],
                        'Qrcode' => base_url('doc/QRCode/') . $perangkat['QRCODE'],
                        'sn' => $perangkat['serial_number']
                    ];
                } else {

                    $qr = $this->QRCodeRender($perangkat);
                    $update = ['QRCODE' => $qr];
                    $this->Mod->update2('perangkat', array('id_perangkat' => $value['id_perangkat']), $update);

                    $data['data'][] = [
                        'id_perangkat' => $value['id_perangkat'],
                        'Qrcode' => base_url('doc/QRCode/') . $qr,
                        'sn' => $perangkat['serial_number']
                    ];
                }

                // echo "<pre>",print_r ($perangkat),"</pre>";

            }
            // 
        }
        if (!empty($data)) {
            $data['totaldata'] = count($data['data']);

            // echo "<pre>",print_r ($data),"</pre>";

            // $this->load->view('v_QR',$data);
            $html = $this->load->view('v_QR', $data, true);
            $result = $this->pdfgenerator->generate($html, 'PrintQRCode', 'A4', 'portrait', FALSE);

            $response = [
                'code' => '200',
                'msg' => 'Print File Succes',
                'file' => $result
            ];
        } else {
            $response = [
                'code' => '400',
                'msg' => 'No Data Selected',
                'file' => ''
            ];
        }
        echo json_encode($response);
        // echo "<pre>",print_r ($data),"</pre>";
    }


    function UploadData()
    {
        if (isset($_FILES["filelampiran"]["name"])) {
            $this->load->library('EXCEL');
            $data = array();
            $error_msg = array();
            // $path = $_FILES["filelampiran"]["tmp_name"];
            // $objPHPExcel = PHPExcel_IOFactory::load($path);
            // foreach($objPHPExcel->getWorksheetIterator(1) as $worksheet => $value){
            //     $highestRow = $value->getHighestRow();

            //     $lastColumn = $value->getHighestDataColumn(); 
            //     $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($lastColumn);

            //        if ($worksheet == 0) {
            //         for($col=1 ; $col<=$highestColumnIndex; $col++){
            //               for ($row=2; $row <=$highestRow ; $row++) { 
            //                     $nama       = $value->getCellByColumnAndRow(0, $row)->getValue();
            //                     $merek      = $value->getCellByColumnAndRow(1, $row)->getValue();
            //                     $model      = $value->getCellByColumnAndRow(2, $row)->getValue();
            //                     $sn         = $value->getCellByColumnAndRow(3, $row)->getValue();

            //                     $data[]=[
            //                         'nama_perangkat'    => $nama ,
            //                         'merek'             => $merek  ,
            //                         'model'             => $model,
            //                         'sn'                => $sn
            //                     ];

            //                     if (empty($nama)) {
            //                         $error_msg[]=[
            //                           'sheet' => 0,
            //                             'row' => $row,
            //                             'col' => $col,   
            //                             'message' => 'data null'       
            //                         ];
            //                     }elseif (empty($merek)) {
            //                         $error_msg[]=[
            //                             'sheet' => 0,
            //                             'row' => $row,
            //                             'col' => $col,      
            //                             'message' => 'data null'       
            //                           ];
            //                     }elseif (empty($model)) {
            //                         $error_msg[]=[
            //                             'sheet' => 0,
            //                             'row' => $row,
            //                             'col' => $col,   
            //                             'message' => 'data null'        
            //                           ];
            //                     }elseif (empty($sn)) {
            //                         $error_msg[]=[
            //                             'sheet' => 0,
            //                             'row' => $row,
            //                             'col' =>$col,    
            //                               'message' => 'data null'    
            //                           ];
            //                     }else{
            //                         $cek_merek =$this->Mod->getLike('merk',array('nama' =>$merek));  
            //                         if ($cek_merek->num_rows() == 0 ) {
            //                         //   echo "Kosong merek";
            //                         }else{
            //                            $res_merk=  $cek_merek->row_array();

            //                             $cek_model =$this->Mod->getLike('model',array('nama_perangkat' =>$model,'merk_id'  =>  $res_merk['id']));  

            //                             if ($cek_model->num_rows() == 0 ) {
            //                                 // echo "Kosong model";
            //                             }else{
            //                             //   echo "<pre>", print_r( $data), "</pre>";
            //                             }
            //                         }
            //                     }



            //                 //    echo "<pre>", print_r( $insert), "</pre>";

            //                 // echo "<pre>", print_r( $data), "</pre>";

            //               }
            //             }

            //        }


            // }

            // if ($error_msg) {
            //     foreach ($error_msg as $error) {
            //         $sheet = $error["sheet"];
            //         $column = $error["col"];
            //         $row = $error["row"];
            //         $message = $error["message"];
            //         echo "<pre>", print_r( $sheet), "</pre>";
            //         echo "<pre>", print_r( $column), "</pre>";
            //         echo "<pre>", print_r( $row), "</pre>";
            //         echo "<pre>", print_r( $message), "</pre>";
            //         // unset($data[$error["row"]]);

            //         // $objPHPExcel->setActiveSheetIndex($sheet);
            //         // $objPHPExcel->getActiveSheet()->getStyle("$column$row")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            //         // $objPHPExcel->getActiveSheet()->getStyle("$column$row")->getFill()->getStartColor()->setARGB("ffffcece");
            //         // $objPHPExcel->getActiveSheet()->getTabColor()->setARGB('FFFF0000');
            //         // $objPHPExcel->getActiveSheet()->getComment("$column$row")->setAuthor('Timur Sahadewa');
            //         // $objPHPExcel->getActiveSheet()->getComment("$column$row")->getText()->createTextRun($message);
            //         // $objPHPExcel->getActiveSheet()->getComment("$column$row")->getText()->createTextRun("\r\n");
            //         // $objPHPExcel->getActiveSheet()->getComment("$column$row")->getText()->createTextRun("\r\n");

            //        echo "add comment di ".$column.$row; // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            //         // $namafile = "Error Loader Template " . date("Y-m-d H.i.s") . ".xlsx";
            //         // $path = "./temp/$namafile";
            //         // $objWriter->save($path);
            //     }
            // }else{
            //     echo "ok";
            // }

            // echo "<pre>", print_r( $data), "</pre>";
            // echo "<pre>", print_r( $error_msg), "</pre>";


            $demo_error = array();
            $data = array();
            $file = $_FILES["filelampiran"]["tmp_name"];
            $objPHPExcel = PHPExcel_IOFactory::load($file);
            $sheet = $objPHPExcel->getSheet(1);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = 'D';
            $objPHPExcel->setActiveSheetIndex(1);
            $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
            foreach ($cell_collection as $cell) {
                $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                if ($row == 1) {
                    $header[] = $column;
                }
            }

            $fieldRow = $sheet->rangeToArray('A1:' . $highestColumn . '2', NULL, TRUE, TRUE);
            foreach ($fieldRow[0] as $value) {
                if ($value == "" || $value == null) {
                    continue;
                }

                $field[] = $value;
            }


            for ($row = 2; $row <= $highestRow; $row++) {
                $dataRow = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, TRUE); //select 
                if ($dataRow[0][0] == NULL) {
                    continue;
                }
                ;
                $key = array();
                if (!isset($field)) {
                    echo "Error: fields are required.";
                    die();
                }
                foreach ($field as $idx => $clm) {
                    $key['header'][$clm] = $dataRow[0][$idx];
                }
                $data[$row] = $key;
            }
            // echo "<pre>", print_r( $data), "</pre>";
            foreach ($data as $key_data => $val_data) {
                // echo "<pre>", print_r( $val_data['header']), "</pre>";

                foreach ($val_data['header'] as $key2 => $val) {

                    if (empty($val)) {
                        $demo_error[] = [
                            'sheet' => 1,
                            'row' => $key_data,

                            'col' => (array_search($key2, $field) != '' ? $header[array_search($key2, $field)] : ''),
                            'message' => $key2 . ' kosong',
                        ];
                    }
                }

                $cek_merek = $this->Mod->getLike('merk', array('nama' => $val_data['header']['Merk']));
                if ($cek_merek->num_rows() == 0) {
                    $demo_error[] = [
                        'sheet' => 1,
                        'row' => $key_data,

                        'col' => (array_search('Merk', $field) != '' ? $header[array_search('Merk', $field)] : ''),
                        'message' => 'Merk Tidak Terdaftar',
                    ];
                    // echo "<pre>", print_r($val_data['header']), "</pre>";
                } else {
                    $res_merk = $cek_merek->row_array();
                    $cek_model = $this->Mod->getLike('model', array('nama_perangkat' => $val_data['header']['Model'], 'merk_id' => $res_merk['id']));
                    if ($cek_model->num_rows() == 0) {
                        $demo_error[] = [
                            'sheet' => 1,
                            'row' => $key_data,

                            'col' => (array_search('Model', $field) != '' ? $header[array_search('Model', $field)] : ''),
                            'message' => 'Model Tidak Terdaftar',
                        ];
                    } else {
                        //   echo "<pre>", print_r( $data), "</pre>";
                    }
                }
                // $data[]=[
                //         'nama_perangkat'    => $nama ,
                //         'merek'             => $merek  ,
                //         'model'             => $model,
                //         'sn'                => $sn
                // ];
            }


            // echo "<pre>", print_r($demo_error), "</pre>";
            if ($demo_error) {
                foreach ($demo_error as $error) {
                    $sheet = $error["sheet"];
                    $column = $error["col"];
                    $row = $error["row"];
                    $message = $error["message"];
                    unset($data[$error["row"]]);

                    $objPHPExcel->setActiveSheetIndex($sheet);
                    $objPHPExcel->getActiveSheet()->getStyle("$column$row")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                    $objPHPExcel->getActiveSheet()->getStyle("$column$row")->getFill()->getStartColor()->setARGB("ffffcece");
                    $objPHPExcel->getActiveSheet()->getTabColor()->setARGB('FFFF0000');
                    $objPHPExcel->getActiveSheet()->getComment("$column$row")->setAuthor('Timur Sahadewa');
                    $objPHPExcel->getActiveSheet()->getComment("$column$row")->getText()->createTextRun($message);
                    $objPHPExcel->getActiveSheet()->getComment("$column$row")->getText()->createTextRun("\r\n");
                    $objPHPExcel->getActiveSheet()->getComment("$column$row")->getText()->createTextRun("\r\n");
                }
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                $namafile = "Error Loader Perangkat " . date("Y-m-d H.i.s") . ".xlsx";
                $path = "./temp/$namafile";

                $respon_data = array(
                    "STATUS" => 500,
                    "PATH" => $path,
                    "FILENAME" => $namafile,
                    "TYPE" => "error_loader_template",
                );
                $objWriter->save($path);

                echo json_encode($respon_data);
            }
            // echo "<pre>", print_r( $header), "</pre>";

            // echo "<pre>", print_r($data), "</pre>";

        }
    }


    function summary()
    {
        $filter = '';
        if (!empty($jenis)) {
            $filter .= " AND a.id_jenisperangkat = '$jenis'";
        } else {
            $filter .= "";
        }

        if (!empty($lokasi)) {
            $filter .= " AND a.id_lokasi = '$lokasi'";
        } else {
            $filter .= "";
        }
        if (!empty($sub_lokasi)) {
            $filter .= " AND a.id_sublokasi = '$sub_lokasi'";
        } else {
            $filter .= "";
        }

        $data['sum'] = $this->Mod->GetCustome("SELECT COUNT(c.idfasilitas_detail) as total,a.id_lokasi,
    e.nama_terminal 
from 
	fasilitas_detail c 
left join 
	fasilitas a 
on 
	a.id_fasilitas = c.id_fasilitas
left join 
	perangkat b 
on 
	b.id_perangkat = c.id_perangkat
left join 
terminal e
on e.id = a.id_lokasi
where a.id_unit =  " . sess()['unit'] . "
$filter
GROUP by a.id_lokasi,e.nama_terminal
")->result_array();

        // $data['sum']    = $this->Mod->GetCustome("SELECT a.id,a.nama_terminal, COUNT(b.id_lokasi) as total FROM terminal a left join fasilitas b on b.id_lokasi = a.id where a.parent_id = '-1' and b.id_unit='".sess()['unit']."' group by a.id,a.nama_terminal")->result_array();
        $data['all'] = $this->Mod->GetCustome("SELECT COUNT(c.idfasilitas_detail) as total,a.id_lokasi,
    e.nama_terminal 
from 
	fasilitas_detail c 
left join 
	fasilitas a 
on 
	a.id_fasilitas = c.id_fasilitas
left join 
	perangkat b 
on 
	b.id_perangkat = c.id_perangkat
left join 
terminal e
on e.id = a.id_lokasi
where a.id_unit =  " . sess()['unit'] . "
")->row_array();
        echo json_encode($data);
    }


    function DetailSummary($id_lokasi)
    {
        $filter = "";
        if (!empty($lokasi)) {
            $filter .= " AND a.id_lokasi = '$id_lokasi'";
        } else {
            $filter .= "";
        }
        $data['sum'] = $this->Mod->GetCustome("SELECT COUNT(c.idfasilitas_detail) as total,a.id_lokasi,
    e.nama_terminal 
from 
	fasilitas_detail c 
left join 
	fasilitas a 
on 
	a.id_fasilitas = c.id_fasilitas
left join 
	perangkat b 
on 
	b.id_perangkat = c.id_perangkat
left join 
terminal e
on e.id = a.id_lokasi
where a.id_unit =  3
and c.id_jenisperangkat = 19
$filter
GROUP by a.id_lokasi,e.nama_terminal
    ")->result_array();
        echo json_encode($data);
    }

    function Delete($id = null)
    {
        $data = ['status' => 8];
        $res_update = $this->Mod->update2('perangkat', array('id_perangkat' => $id), $data);

        $res = [
            'code' => '200',
            'msg' => 'Data Berhasil di Hapus'
        ];
        echo json_encode($res);
    }

    // function rekap_perangkat
    // function rekap_perangkat($id = null)
    // {
    //     if (empty($id)) {
    //         echo json_encode(['code' => '400', 'msg' => 'ID Perangkat tidak ditemukan']);
    //         return;
    //     }

    //     // Filter bulan (opsional)
    //     $bulan = isset($_POST['bulan']) ? $_POST['bulan'] : '';

    //     $unit = sess()['unit'];

    //     // 1. Cari fasilitas yang mengandung perangkat ini
    //     $fasilitas_list = $this->Mod->GetCustome("
    //         SELECT f.id_fasilitas, f.nama_fasilitas
    //         FROM fasilitas_detail fd
    //         JOIN fasilitas f ON f.id_fasilitas = fd.id_fasilitas
    //         WHERE fd.id_perangkat = '$id'
    //           AND fd.status != 8
    //           AND f.status != 8
    //           AND f.id_unit = '$unit'
    //         GROUP BY f.id_fasilitas, f.nama_fasilitas
    //     ")->result_array();

    //     // 2. Ambil semua jenis PM
    //     $pm_types = $this->Mod->getWhere('pm_type', array('status !=' => 8))->result_array();

    //     $hasil = [];

    //     foreach ($fasilitas_list as $fasilitas) {
    //         $id_fasilitas = $fasilitas['id_fasilitas'];

    //         // Query detail per jenis PM (rencana dari jadwal, realisasi dari wo->pm_khusus)
    //         $detail = $this->Mod->GetCustome("SELECT a.idpm_type, a.kode,
    //             (
    //                 SELECT COUNT(b.idpm_type)
    //                 FROM jadwal b
    //                 WHERE b.tahun = 2026
    //                   AND b.idpm_type = a.idpm_type
    //                   AND b.id_fasilitas = '$id_fasilitas'
    //                   " . (!empty($bulan) ? "AND b.bulan = '$bulan'" : "") . "
    //                   AND b.id_unit = '$unit'
    //             ) AS rencana,
    //             (
    //                 SELECT COUNT(DISTINCT w.id_wo)
    //                 FROM wo w
    //                 JOIN wo_detail wd ON wd.id_wo = w.id_wo
    //                 JOIN pm p ON p.id_pmheader = wd.id_pmheader
    //                 JOIN pm_khusus pk ON pk.id_pm = p.id_pmheader
    //                 WHERE YEAR(w.tanggal) = 2026
    //                   AND w.idpm_type = a.idpm_type
    //                   AND p.id_fasilitas = '$id_fasilitas'
    //                   AND pk.id_perangkat = '$id'
    //                   " . (!empty($bulan) ? "AND MONTH(w.tanggal) = '$bulan'" : "") . "
    //                   AND w.status != 8
    //                   AND w.id_unit = '$unit'
    //             ) AS realisasi
    //             FROM pm_type a
    //             WHERE a.status != 8
    //         ")->result_array();

    //         // Hitung sisa & persentase
    //         $persentase = [
    //             '2M' => 0, '1B' => 0, '3B' => 0, '6B' => 0, 'T' => 0
    //         ];

    //         foreach ($detail as $dk => $d) {
    //             $sisa = $d['rencana'] - $d['realisasi'];
    //             $detail[$dk]['sisa'] = $sisa;
    //             $pct = ($d['rencana'] > 0) ? round(($d['realisasi'] / $d['rencana']) * 100, 2) : 0;
    //             $detail[$dk]['persentase'] = $pct;

    //             $kode = strtoupper(trim($d['kode']));
    //             if (isset($persentase[$kode])) {
    //                 $persentase[$kode] = $pct;
    //             }
    //         }

    //         $row = [
    //             'id_fasilitas'   => $id_fasilitas,
    //             'nama_fasilitas' => $fasilitas['nama_fasilitas'],
    //             'detail'         => $detail,
    //         ];
    //         foreach ($persentase as $k => $v) {
    //             $row['persentase_' . $k] = $v;
    //         }

    //         $hasil[] = $row;
    //     }

    //     echo json_encode([
    //         'code'   => '200',
    //         'data'   => $hasil,
    //         'bulan'  => $bulan,
    //     ]);
    // }

    function history_pm_perangkat($id = null)
    {
        if (empty($id)) {
            echo json_encode(['code' => '400', 'msg' => 'ID Perangkat tidak ditemukan']);
            return;
        }

        $bulan = isset($_POST['bulan']) ? $_POST['bulan'] : '';
        $unit  = sess()['unit'];

        $filter_bulan = '';
        if (!empty($bulan)) {
            $filter_bulan = "AND MONTH(p.tanggal_pm) = '" . $bulan . "'";
        }

        $data = $this->Mod->GetCustome("
            SELECT
                p.id_pmheader,
                p.tanggal_pm,
                p.jam_mulai,
                p.jam_selesai,
                p.pelaksana,
                p.catatan_perawatan,
                pt.kode        AS kode_pm,
                pt.name_pm     AS nama_pm_type,
                f.nama_fasilitas,
                w.no_wo        AS nomor_wo
            FROM pm_khusus pk
            JOIN pm p         ON p.id_pmheader = pk.id_pm
            JOIN pm_type pt   ON pt.idpm_type   = p.idpm_type
            JOIN fasilitas f  ON f.id_fasilitas  = p.id_fasilitas
            LEFT JOIN wo_detail wd ON wd.id_pmheader = p.id_pmheader
            LEFT JOIN wo w         ON w.id_wo = wd.id_wo AND w.status != 8
            WHERE pk.id_perangkat  = '$id'
              AND p.id_unit        = '$unit'
              AND YEAR(p.tanggal_pm) = 2026
              $filter_bulan
            GROUP BY p.id_pmheader
            ORDER BY p.tanggal_pm DESC
        ")->result_array();

        // Format tanggal ke Indonesia
        foreach ($data as $k => $v) {
            $data[$k]['tanggal_pm_fmt'] = tgl($v['tanggal_pm'], 'l');
        }

        echo json_encode([
            'code'  => '200',
            'data'  => $data,
            'total' => count($data),
            'bulan' => $bulan,
        ]);
    }

}
