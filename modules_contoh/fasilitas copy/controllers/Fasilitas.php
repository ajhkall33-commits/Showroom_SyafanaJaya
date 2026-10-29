<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Fasilitas extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        //$this->load->library('excel');
        $this->load->model("m_data");
        $this->load->library('Ciqrcode');
        $this->role();
    }

    // private function position() {
    //     $data["position"] = "perangkat";
    //     return $data;
    // }
    private function role()
    {
        $url = urlencode(current_url());
        if (session("username") == "") {
            redirect(base_url('login/auth'));
        }
    }
    public function index()
    {

        //$data = $this->position();
        // $data = access($data,"VIEW");

        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Peralatan";
        $data["title_des"] = "Daftar Peralatan";
        $data["content"] = "v_index";

        $data["data"] = $data;

        $tes = $this->m_data->getWhere('fasilitas', array('status !=' => 8))->result_array();
        $update_lokasi = array();
        foreach ($tes as $key => $value) {
            // $this->m_data->getWhere('fasilitas_detail',array('id_fasilitas' =>$value['id_fasilitas'],'status !=' => 8 ))->result_array();
            if ($value['terminal'] == '3U-INT' || $value['terminal']  == '3U-DOM') {
                $sub = $this->m_data->getWhere('terminal', array('nama_terminal' => $value['zona'], 'status !=' => 8, 'parent_id' => 3))->row_array();
                if (!empty($sub)) {
                    $update_lokasi[] = [
                        'id_lokasi'     => '3',
                        'id_sublokasi'  => $sub['id'],
                        'id_fasilitas'  => $value['id_fasilitas']
                    ];
                }
            } elseif ($value['terminal'] == '2F' || $value['terminal']  == '2E' || $value['terminal']  == '2D') {
                $sub = $this->m_data->getWhere('terminal', array('nama_terminal' => $value['zona'], 'status !=' => 8, 'parent_id' => 2))->row_array();
                if (!empty($sub)) {
                    $update_lokasi[] = [
                        'id_lokasi'     => '2',
                        'id_sublokasi'  => $sub['id'],
                        'id_fasilitas'  => $value['id_fasilitas']
                    ];
                }
            } elseif ($value['terminal'] == '1C' || $value['terminal']  == '1B' || $value['terminal']  == '1A') {
                $sub = $this->m_data->getWhere('terminal', array('nama_terminal' => $value['zona'], 'status !=' => 8, 'parent_id' => 1))->row_array();
                if (!empty($sub)) {
                    $update_lokasi[] = [
                        'id_lokasi'     => '1',
                        'id_sublokasi'  => $sub['id'],
                        'id_fasilitas'  => $value['id_fasilitas']
                    ];
                }
            }
        }
        // foreach ($update_lokasi as $key => $value) {
        //     echo "<pre>",print_r ($value),"</pre>";
        //     $update = $this->Mod->update2('fasilitas',array('id_fasilitas  ' =>$value['id_fasilitas']),$value);
        // }
        // // echo "<pre>",print_r ($tes),"</pre>";

        $this->load->view('template_v2', $data);
        // echo "<pre>",print_r ( $this->session->userdata()),"</pre>";
    }

    function LoadFasilitas()
    {
        $data    =  $this->Mod->GetCustome("SELECT * FROM fasilitas WHERE  id_unit='" . sess()['unit'] . "' AND STATUS ='1' ")->result_array();
        echo json_encode($data);
    }

    function LoadData()
    {
        //$data= $this->position();
        // $acc  = access($data,"VIEW")['access'];

        // Periksa apakah $_POST['limit'] sudah diatur
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
        $from               = $this->uri->segment(3);

        $param = [
            'table'         => 'fasilitas',
            'pk'            => 'id_fasilitas',
            'parameter'     => array('status !=' => 8, 'id_unit' => sess()['unit']),
            'url'           => $this->uri->segment(2),
            'from'          => $from,
            'limit'         => $limit,
            'src'           => $src,
            'filter'        => (!empty($jenis) ? array('id_catagory' => $jenis) : ''),
            'param_src'     => [
                'like' => 'nama_fasilitas',
                'or_like' => 'ip_address'
            ]
        ];
        $totalData          = CountDataPag($param);
        $param['total_data'] = $totalData;
        $param['total_page'] = ceil($totalData / $limit);
        $res                = pagin($param);
        foreach ($res['data'] as $key => $value) {
            $lokasi      = $this->m_data->getWhere('terminal ', array('id' => $value['id_lokasi']))->row_array();
            $sublokasi   = $this->m_data->getWhere('terminal ', array('id' => $value['id_sublokasi']))->row_array();
            $catagory    = $this->m_data->getWhere('fasilitas_catagory ', array('id_catagory' => $value['id_catagory']))->row_array();
            $res['data'][$key]['lokasi']     = (!empty($lokasi['nama_terminal']) ? $lokasi['nama_terminal'] : '');
            $res['data'][$key]['sublokasi']  = (!empty($sublokasi['nama_terminal']) ? $sublokasi['nama_terminal'] : '');
            $res['data'][$key]['catagory']   = (!empty($catagory['nama']) ?  $catagory['nama'] : '');
        }

        $data['fasilitas']  = $res['data'];
        $data['pag']        = $res['pag'];
        echo json_encode($data);
    }

    function summary()
    {
        $data['sum']    = $this->Mod->GetCustome("SELECT a.id,a.nama_terminal, COUNT(b.id_lokasi) as total FROM terminal a left join fasilitas b on b.id_lokasi = a.id where a.parent_id = '-1' and b.id_unit='" . sess()['unit'] . "' group by a.id,a.nama_terminal")->result_array();
        $data['all']    = $this->Mod->GetCustome("SELECT COUNT(*) as total FROM  fasilitas where id_unit='" . sess()['unit'] . "' ")->row_array();
        echo json_encode($data);
    }

    function performa($id = null)
    {
        $data["plugin"][]   = "plugin/datatable";
        $data["plugin"][]   = "plugin/select2";
        $data["title"]      = "Peralatan" . sess()['unit_kode'];
        $data["title_des"]  = " Performa Peralatan" . sess()['unit_name'];
        $data["content"]    = "v_performa";
        $data['id']         = $id;

        $data["data"] = $data;

        $this->load->view('template_v2', $data);
    }


public function LoadDataAnl($id = null)
{
    $perangkat = $this->Mod->getWhere('perangkat', array('id_perangkat' => $id))->row_array();
    $todayDate = date('Y-m-d');
  
    // Mengambil data logbook yang terkait dengan fasilitas
    $logHistory = $this->Mod->GetCustome(" 
     SELECT a.*, b.nama_masalah as nama_masalah_tinjut, c.nama_perangkat, jp.nama as nama_jenis_perangkat, f.nama_fasilitas
        FROM tinjut a 
        LEFT JOIN tinjut_detail td ON td.id_tinjut = a.id_tinjut 
        LEFT JOIN perangkat c ON c.id_perangkat = td.id_perangkat 
        LEFT JOIN jenis_masalah b ON b.id = td.id_jenismasalah
        LEFT JOIN fasilitas f ON f.id_fasilitas = a.id_fasilitas
        LEFT JOIN jenis_perangkat jp ON jp.id_jenisperangkat = td.id_jenisperangkat
       WHERE a.id_fasilitas = '" . $id . "' 
    ")->result_array();

    $result['LogHistory'] = $logHistory;

    // AMBIL ID UNIT DARI SESSION
    $id_unit = !empty(sess()['unit']) ? sess()['unit'] : null;
    
    // AMBIL DATA FASILITAS UNTUK MENDAPATKAN KODE FASILITAS
    $fasilitas_data = $this->Mod->getWhere('fasilitas', array('id_fasilitas' => $id))->row_array();
    $kode_fasilitas = !empty($fasilitas_data['kode']) ? $fasilitas_data['kode'] : null;

    if (in_array($id_unit, [14, 15, 16, 17])) {
          // Mengambil total menit dalam bulan berjalan
    $total_minutes_in_month = date('t') * 24 * 60;
    
    // Mengambil data downtime dan uptime untuk performa
    $downtime = $this->Mod->GetCustome("SELECT SUM(TIMESTAMPDIFF(MINUTE, date_start, update_date)) AS total_downTime 
                                          FROM tinjut 
                                          WHERE update_date >= NOW() - INTERVAL 1 MONTH 
                                          AND date_start >= NOW() - INTERVAL 1 MONTH")->row_array();
    $uptime = $total_minutes_in_month;

    $totaldowntime = $downtime['total_downTime'];
    // Cek apakah $uptime adalah array dan key 'uptime' exists
    $totaluptime = (is_array($uptime) && isset($uptime['uptime'])) ? $uptime['uptime'] : 0;

    $performa = ( $totaluptime  - $totaldowntime) / $total_minutes_in_month * 100;


    }
    elseif (in_array($id_unit, [18, 17, 19, 20, 21, 22, 23]))
    {
        
        // Hitung total menit dalam tahun berjalan dengan DateTime
        $current_year = date('Y');
        $start_of_year = new DateTime("$current_year-01-01");
        $end_of_year = new DateTime("$current_year-12-31");
        $total_days_in_year = $end_of_year->diff($start_of_year)->days + 1;
        $total_minutes_in_year = $total_days_in_year * 24 * 60;

         // Hitung total downtime dalam menit untuk tahun berjalan
        $downtime_query = $this->Mod->GetCustome("
            SELECT SUM(TIMESTAMPDIFF(MINUTE, t.start_time, t.end_time)) AS total_downtime 
            FROM tinjut t
            LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
            WHERE td.id_perangkat = '" . $id . "'
            AND YEAR(t.start_time) = YEAR(NOW())
        ")->row_array();
        
        $downtime = !empty($downtime_query['total_downtime']) ? $downtime_query['total_downtime'] : 0;
        
        // RUMUS PERFORMANCE SCORE YANG ANDA MINTA
        if ($total_minutes_in_year > 0) {
            $downtime_percentage = ($downtime / $total_minutes_in_year) * 100;
            $performa = 100 - $downtime_percentage;
            $performa = round($performa, 2);
        } 
    }
    else
    {
        // LOGIKA BERDASARKAN KODE FASILITAS UNTUK UNIT LAINNYA
        if ($kode_fasilitas == 1) {
            // FASILITAS KODE 1 - RUMUS TAHUNAN
            $current_year = date('Y');
            $start_of_year = new DateTime("$current_year-01-01");
            $end_of_year = new DateTime("$current_year-12-31");
            $total_days_in_year = $end_of_year->diff($start_of_year)->days + 1;
            $total_minutes_in_year = $total_days_in_year * 24 * 60;
            
            // Hitung total downtime dalam menit untuk tahun berjalan
            $downtime_query = $this->Mod->GetCustome("
                SELECT SUM(TIMESTAMPDIFF(MINUTE, t.start_time, t.end_time)) AS total_downtime 
                FROM tinjut t
                LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
                WHERE t.id_fasilitas = '" . $id . "'
                AND YEAR(t.start_time) = YEAR(NOW())
            ")->row_array();
            
            $downtime = !empty($downtime_query['total_downtime']) ? $downtime_query['total_downtime'] : 0;
            
            if ($total_minutes_in_year > 0) {
                $downtime_percentage = ($downtime / $total_minutes_in_year) * 100;
                $performa = 100 - $downtime_percentage;
                $performa = round($performa, 2);
            } else {
                $performa = 100;
            }
            
        } elseif ($kode_fasilitas == 2) {
            // FASILITAS KODE 2 - RUMUS BULANAN
            $total_minutes_in_month = date('t') * 24 * 60;
            
            // Cek status dari tinjut dan tinjut_detail
            $status_query = $this->Mod->GetCustome("
                SELECT t.status AS tinjut_status, td.status AS tinjut_detail_status
                FROM tinjut t
                LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
                WHERE t.id_fasilitas = '" . $id . "'
                AND MONTH(t.start_time) = MONTH(NOW()) 
                AND YEAR(t.start_time) = YEAR(NOW())
            ")->row_array();
            
            $tinjut_status = !empty($status_query['tinjut_status']) ? $status_query['tinjut_status'] : null;
            $tinjut_detail_status = !empty($status_query['tinjut_detail_status']) ? $status_query['tinjut_detail_status'] : null;

            // Jika status di kedua tabel adalah 2, atau kosong, set performa 100%
            if (($tinjut_status == 2 || empty($tinjut_status)) && ($tinjut_detail_status == 2 || empty($tinjut_detail_status))) {
                $performa = 100;
            } else {
                // Hitung downtime bulan berjalan
                $downtime_query = $this->Mod->GetCustome("
                    SELECT SUM(TIMESTAMPDIFF(MINUTE, t.start_time, t.end_time)) AS total_downtime 
                    FROM tinjut t
                    LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
                    WHERE t.id_fasilitas = '" . $id . "'
                    AND MONTH(t.start_time) = MONTH(NOW()) 
                    AND YEAR(t.start_time) = YEAR(NOW())
                ")->row_array();
                
                $downtime = !empty($downtime_query['total_downtime']) ? $downtime_query['total_downtime'] : 0;
                
                if ($total_minutes_in_month > 0) {
                    $performa = (($total_minutes_in_month - $downtime) / $total_minutes_in_month) * 100;
                    $performa = round($performa, 2);
                } else {
                    $performa = 100;
                }
            }
        } else {
            // DEFAULT JIKA TIDAK ADA KODE FASILITAS YANG COCOK
            $performa = 100;
        }
    }

    // Pastikan performa tidak kosong
    if (empty($performa)) {
        $performa = 100;
    }
  
    $performa_formatted = number_format(round($performa));
    $result['perfomChart'] = array('Performa' => round($performa));
    $result['perfomChart'] = array('Performa' => $performa_formatted);

    // Ambil perangkat yang ada dalam fasilitas, kecuali perangkat 'listrik', dan menghitung performa perangkat
    $tabel = $this->Mod->GetCustome("
          SELECT
            p.id_perangkat, 
            p.nama_perangkat, 
            p.status as status_perangkat, 
            u.kode_unit, 
            f.ip_address, 
            p.serial_number, 
            f.status, 
            t.create_date, 
            fd.id_jenisperangkat, 
            m.nama AS merk_nama, 
            jp.nama AS nama_jp,
            t.status as status_tinjut
            FROM perangkat p 
            LEFT JOIN fasilitas_detail fd ON fd.id_perangkat = p.id_perangkat 
            LEFT JOIN unit u ON p.id_unit = u.id_unit 
            LEFT JOIN fasilitas f ON fd.id_fasilitas = f.id_fasilitas 
            LEFT JOIN (

            SELECT td.id_perangkat, MAX(t.create_date) AS max_create_date 
            FROM tinjut_detail td
            LEFT JOIN tinjut t ON t.id_tinjut = td.id_tinjut
            GROUP BY td.id_perangkat

            ) 
            latest_tinjut ON latest_tinjut.id_perangkat = p.id_perangkat 
            LEFT JOIN tinjut_detail td ON td.id_perangkat = p.id_perangkat
            LEFT JOIN tinjut t ON t.id_tinjut = td.id_tinjut AND t.create_date = latest_tinjut.max_create_date
            LEFT JOIN merk m ON m.id = p.merk_id 
            LEFT JOIN jenis_perangkat jp ON jp.id_jenisperangkat = p.id_jenisperangkat 
            WHERE
                fd.id_fasilitas = $id
                AND LOWER(p.nama_perangkat) != 'listrik'  -- Memfilter perangkat yang tidak bernama 'listrik'
            AND p.id_unit = '".sess()['unit']."' 
            GROUP BY
                p.id_perangkat
            ORDER BY
                t.create_date DESC
    ")->result_array();

    // Mengambil performa perangkat berdasarkan rumus yang diberikan
    $totaldata_log = 0;
    $total_perfom = 0;  // Untuk menyimpan jumlah performa perangkat
    $valid_devices = 0; // Untuk menghitung jumlah perangkat yang valid

    // Menyimpan performa perangkat untuk debugging
    $device_performance = []; // Array untuk menyimpan performa setiap perangkat

    foreach ($tabel as $key => $value) {
        // Ambil status dari tinjut dan tinjut_detail untuk perangkat ini
        $status_query = $this->Mod->GetCustome("
            SELECT t.status AS tinjut_status, td.status AS tinjut_detail_status
            FROM tinjut t
            LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
            WHERE td.id_perangkat = '" . $value['id_perangkat'] . "'
            AND MONTH(t.start_time) = MONTH(NOW()) 
            AND YEAR(t.start_time) = YEAR(NOW())
        ")->row_array();

        $tinjut_status = !empty($status_query['tinjut_status']) ? $status_query['tinjut_status'] : null;
        $tinjut_detail_status = !empty($status_query['tinjut_detail_status']) ? $status_query['tinjut_detail_status'] : null;

        // ID UNIT KHUSUS (14, 15, 16, 17) - PERHITUNGAN BULANAN
        if (in_array($id_unit, [14, 15, 16, 17])) {
            // Jika status di kedua tabel adalah 2, atau kosong, set performa 100%
            if (($tinjut_status == 2 || empty($tinjut_status)) && ($tinjut_detail_status == 2 || empty($tinjut_detail_status))) {
                $performaperangkat = 100;
            } else {
                // Hitung downtime bulan berjalan untuk perangkat ini
                $downtime_query = $this->Mod->GetCustome("
                    SELECT SUM(TIMESTAMPDIFF(MINUTE, t.start_time, t.end_time)) AS total_downtime 
                    FROM tinjut t
                    LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
                    WHERE td.id_perangkat = '" . $value['id_perangkat'] . "'
                    AND MONTH(t.start_time) = MONTH(NOW()) 
                    AND YEAR(t.start_time) = YEAR(NOW())
                ")->row_array();
                
                $downtime = !empty($downtime_query['total_downtime']) ? $downtime_query['total_downtime'] : 0;

                // Hitung performa perangkat - RUMUS BULANAN
                if ($total_minutes_in_month > 0) {
                    $performaperangkat = (($total_minutes_in_month - $downtime) / $total_minutes_in_month) * 100;
                    $performaperangkat = round($performaperangkat, 2);
                } else {
                    $performaperangkat = 100; // Fallback jika pembagian nol
                }
            }

        // UNIT LAIN - PERHITUNGAN TAHUNAN (RUMUS YANG ANDA MINTA)
        }
         elseif (in_array($id_unit, [18, 17, 19, 20, 21, 22, 23])) 
        {
            // Hitung total menit dalam tahun berjalan dengan akurat (termasuk kabisat)
            $current_year = date('Y');
            $is_leap_year = date('L', strtotime("$current_year-01-01"));
            $total_days_in_year = $is_leap_year ? 366 : 365;
            $total_minutes_in_year = $total_days_in_year * 24 * 60;
            
            // Hitung total downtime dalam menit untuk tahun berjalan
            $downtime_query = $this->Mod->GetCustome("
                SELECT SUM(TIMESTAMPDIFF(MINUTE, t.start_time, t.end_time)) AS total_downtime 
                FROM tinjut t
                LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
                WHERE td.id_perangkat = '" . $value['id_perangkat'] . "'
                AND YEAR(t.start_time) = YEAR(NOW())
            ")->row_array();
            
            $downtime = !empty($downtime_query['total_downtime']) ? $downtime_query['total_downtime'] : 0;
            
            // RUMUS PERFORMANCE SCORE YANG ANDA MINTA
            // Performance Score = 100 - [(Waktu Rusak (Menit) / Total Waktu (Menit)) × 100]
            if ($total_minutes_in_year > 0) {
                $downtime_percentage = ($downtime / $total_minutes_in_year) * 100;
                $performaperangkat = 100 - $downtime_percentage;
                $performaperangkat = round($performaperangkat, 2);
            } else {
                $performaperangkat = 100; // Fallback jika pembagian nol
            }
        }
        else
        {
            // LOGIKA BERDASARKAN KODE FASILITAS UNTUK PERANGKAT DI UNIT LAINNYA
            if ($kode_fasilitas == 1) {
                // FASILITAS KODE 1 - RUMUS TAHUNAN UNTUK PERANGKAT
                $current_year = date('Y');
                $is_leap_year = date('L', strtotime("$current_year-01-01"));
                $total_days_in_year = $is_leap_year ? 366 : 365;
                $total_minutes_in_year = $total_days_in_year * 24 * 60;
                
                // Hitung total downtime dalam menit untuk tahun berjalan
                $downtime_query = $this->Mod->GetCustome("
                    SELECT SUM(TIMESTAMPDIFF(MINUTE, t.start_time, t.end_time)) AS total_downtime 
                    FROM tinjut t
                    LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
                    WHERE td.id_perangkat = '" . $value['id_perangkat'] . "'
                    AND YEAR(t.start_time) = YEAR(NOW())
                ")->row_array();
                
                $downtime = !empty($downtime_query['total_downtime']) ? $downtime_query['total_downtime'] : 0;
                
                if ($total_minutes_in_year > 0) {
                    $downtime_percentage = ($downtime / $total_minutes_in_year) * 100;
                    $performaperangkat = 100 - $downtime_percentage;
                    $performaperangkat = round($performaperangkat, 2);
                } else {
                    $performaperangkat = 100;
                }
                
            } elseif ($kode_fasilitas == 2) {
                // FASILITAS KODE 2 - RUMUS BULANAN UNTUK PERANGKAT
                $total_minutes_in_month = date('t') * 24 * 60;
                
                // Cek status dari tinjut dan tinjut_detail untuk perangkat ini
                $status_query_perangkat = $this->Mod->GetCustome("
                    SELECT t.status AS tinjut_status, td.status AS tinjut_detail_status
                    FROM tinjut t
                    LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
                    WHERE td.id_perangkat = '" . $value['id_perangkat'] . "'
                    AND MONTH(t.start_time) = MONTH(NOW()) 
                    AND YEAR(t.start_time) = YEAR(NOW())
                ")->row_array();
                
                $tinjut_status_perangkat = !empty($status_query_perangkat['tinjut_status']) ? $status_query_perangkat['tinjut_status'] : null;
                $tinjut_detail_status_perangkat = !empty($status_query_perangkat['tinjut_detail_status']) ? $status_query_perangkat['tinjut_detail_status'] : null;

                // Jika status di kedua tabel adalah 2, atau kosong, set performa 100%
                if (($tinjut_status_perangkat == 2 || empty($tinjut_status_perangkat)) && ($tinjut_detail_status_perangkat == 2 || empty($tinjut_detail_status_perangkat))) {
                    $performaperangkat = 100;
                } else {
                    // Hitung downtime bulan berjalan untuk perangkat ini
                    $downtime_query = $this->Mod->GetCustome("
                        SELECT SUM(TIMESTAMPDIFF(MINUTE, t.start_time, t.end_time)) AS total_downtime 
                        FROM tinjut t
                        LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
                        WHERE td.id_perangkat = '" . $value['id_perangkat'] . "'
                        AND MONTH(t.start_time) = MONTH(NOW()) 
                        AND YEAR(t.start_time) = YEAR(NOW())
                    ")->row_array();
                    
                    $downtime = !empty($downtime_query['total_downtime']) ? $downtime_query['total_downtime'] : 0;
                    
                    if ($total_minutes_in_month > 0) {
                        $performaperangkat = (($total_minutes_in_month - $downtime) / $total_minutes_in_month) * 100;
                        $performaperangkat = round($performaperangkat, 2);
                    } else {
                        $performaperangkat = 100;
                    }
                }
            } else {
                // DEFAULT JIKA TIDAK ADA KODE FASILITAS YANG COCOK
                $performaperangkat = 100;
            }
        }

        // Jika performa perangkat null, set ke 100%
        if ($performaperangkat === null) {
            $performaperangkat = 100;
        }
        
        // Menyimpan nilai performa perangkat untuk debugging
        $device_performance[] = [
            'device_name' => $value['nama_perangkat'], 
            'perform_percentage' => $performaperangkat,
            'id_unit' => $id_unit,
            'kode_fasilitas' => $kode_fasilitas,
            'rumus_digunakan' => in_array($id_unit, [14, 15, 16, 17]) ? 'BULANAN' : 
                                (in_array($id_unit, [18, 17, 19, 20, 21, 22, 23]) ? 'TAHUNAN' : 
                                ($kode_fasilitas == 1 ? 'TAHUNAN (KODE 1)' : 
                                ($kode_fasilitas == 2 ? 'BULANAN (KODE 2)' : 'DEFAULT')))
        ];

        // Menambahkan performa perangkat untuk menghitung rata-rata performa fasilitas
        $total_perfom += $performaperangkat;
        $valid_devices++;
    }

    // Menghitung rata-rata performa fasilitas berdasarkan perangkat yang valid
    if ($valid_devices > 0) {
        $performa_fasilitas = $total_perfom / $valid_devices;  // Rata-rata performa fasilitas
    } else {
        $performa_fasilitas = 0;  // Jika tidak ada perangkat yang valid
    }
   
    // Menambahkan debugging result untuk melihat performa perangkat
    $result['device_performance'] = $device_performance; // Menampilkan performa setiap perangkat
    $result['fasilitas'] = $fasilitas_data; // Menggunakan data fasilitas yang sudah diambil
    $result['fasilitas']['status'] = (lb_st($result['fasilitas']['status']));
    $result['nama_fasilitas'] = $result['fasilitas']['nama_fasilitas'];
    $result['performa_fasilitas'] = $performa_fasilitas;  // Menyimpan rata-rata performa fasilitas
    $result['perfomChart'] = ['Performa' => $performa_fasilitas];
    $result['id_unit_digunakan'] = $id_unit; // Untuk debugging
    $result['kode_fasilitas'] = $kode_fasilitas; // Untuk debugging
     
    echo json_encode($result);
}

public function GetDiviceProblem()
{
    $fasilitas_id = $this->input->post('fasilitas_id');

    // Query perangkat + info fasilitas
    $this->db->select('p.*, fd.id_fasilitas');
    $this->db->from('perangkat p');
    $this->db->join('fasilitas_detail fd', 'fd.id_perangkat = p.id_perangkat', 'left');
    $this->db->where('fd.id_fasilitas', $fasilitas_id);
    $this->db->where('LOWER(p.nama_perangkat) !=', 'listrik');
    $query = $this->db->get();

    // Ambil ID unit dari session
    $id_unit = !empty(sess()['unit']) ? sess()['unit'] : null;

    $device_with_performance = [];

    // Jika ada perangkat
    if ($query->num_rows() > 0) {

        $perangkat_list = $query->result_array();

        // ======================
        // CABANG 1: UNIT 14,15,16,17 (RUMUS BULANAN)
        // ======================
        if (in_array($id_unit, [14, 15, 16, 17])) {

            $total_minutes_in_month = date('t') * 24 * 60;

            foreach ($perangkat_list as $perangkat) {
                $id_perangkat = $perangkat['id_perangkat'];

                // Cek status tinjut
                $status_query = $this->Mod->GetCustome("
                    SELECT t.status AS tinjut_status, td.status AS tinjut_detail_status
                    FROM tinjut t
                    LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
                    WHERE td.id_perangkat = $id_perangkat
                    AND MONTH(t.start_time) = MONTH(NOW())
                    AND YEAR(t.start_time) = YEAR(NOW())
                ")->row_array();

                $tinjut_status = $status_query['tinjut_status'] ?? null;
                $tinjut_detail_status = $status_query['tinjut_detail_status'] ?? null;

                if (($tinjut_status == 2 || empty($tinjut_status)) && ($tinjut_detail_status == 2 || empty($tinjut_detail_status))) {
                    $performaperangkat = 100;
                } else {
                    $downtime_query = $this->Mod->GetCustome("
                        SELECT SUM(TIMESTAMPDIFF(MINUTE, t.start_time, t.end_time)) AS total_downtime 
                        FROM tinjut t
                        LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
                        WHERE td.id_perangkat = $id_perangkat
                        AND MONTH(t.start_time) = MONTH(NOW())
                        AND YEAR(t.start_time) = YEAR(NOW())
                    ")->row_array();

                    $downtime = !empty($downtime_query['total_downtime']) ? $downtime_query['total_downtime'] : 0;
                    $performaperangkat = $total_minutes_in_month > 0 ? round((($total_minutes_in_month - $downtime) / $total_minutes_in_month) * 100, 2): 100;
                }

                // Tambahkan ke array
                $perangkat['perform_percentage'] = $performaperangkat;
                $perangkat['rumus_digunakan'] = 'BULANAN';
                $device_with_performance[] = $perangkat;
            }

        // ======================
        // CABANG 2: UNIT LAIN (18,17,19,20,21,22,23) - RUMUS TAHUNAN
        // ======================
        } elseif (in_array($id_unit, [18, 17, 19, 20, 21, 22, 23])) {

            $current_year = date('Y');
            $is_leap_year = date('L', strtotime("$current_year-01-01"));
            $total_days_in_year = $is_leap_year ? 366 : 365;
            $total_minutes_in_year = $total_days_in_year * 24 * 60;

            foreach ($perangkat_list as $perangkat) {
                $id_perangkat = $perangkat['id_perangkat'];

                $status_query = $this->Mod->GetCustome("
                    SELECT t.status AS tinjut_status, td.status AS tinjut_detail_status
                    FROM tinjut t
                    LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
                    WHERE td.id_perangkat = $id_perangkat
                    AND YEAR(t.start_time) = YEAR(NOW())
                ")->row_array();

                $tinjut_status = $status_query['tinjut_status'] ?? null;
                $tinjut_detail_status = $status_query['tinjut_detail_status'] ?? null;

                $downtime_query = $this->Mod->GetCustome("
                    SELECT SUM(TIMESTAMPDIFF(MINUTE, t.start_time, t.end_time)) AS total_downtime 
                    FROM tinjut t
                    LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
                    WHERE td.id_perangkat = $id_perangkat
                    AND YEAR(t.start_time) = YEAR(NOW())
                ")->row_array();

                $downtime = !empty($downtime_query['total_downtime']) ? $downtime_query['total_downtime'] : 0;
                $performaperangkat = $total_minutes_in_year > 0 ? round(100 - (($downtime / $total_minutes_in_year) * 100), 2): 100;

                $perangkat['perform_percentage'] = $performaperangkat;
                $perangkat['rumus_digunakan'] = 'TAHUNAN';
                $device_with_performance[] = $perangkat;
            }

        // ======================
        // CABANG 3: UNIT LAINNYA - BERDASARKAN KODE FASILITAS
        // ======================
        } else {
             // AMBIL DATA FASILITAS UNTUK MENDAPATKAN KODE FASILITAS
            $fasilitas_data = $this->Mod->getWhere('fasilitas', array('id_fasilitas' => $fasilitas_id))->row_array();
            $kode_fasilitas = !empty($fasilitas_data['kode']) ? $fasilitas_data['kode'] : null;
            foreach ($perangkat_list as $perangkat) {
                $id_perangkat = $perangkat['id_perangkat'];

                // LOGIKA BERDASARKAN KODE FASILITAS
                if ($kode_fasilitas == 1) {
                    // FASILITAS KODE 1 - RUMUS TAHUNAN
                    $current_year = date('Y');
                    $is_leap_year = date('L', strtotime("$current_year-01-01"));
                    $total_days_in_year = $is_leap_year ? 366 : 365;
                    $total_minutes_in_year = $total_days_in_year * 24 * 60;

                    // Hitung total downtime dalam menit untuk tahun berjalan
                    $downtime_query = $this->Mod->GetCustome("
                        SELECT SUM(TIMESTAMPDIFF(MINUTE, t.start_time, t.end_time)) AS total_downtime 
                        FROM tinjut t
                        LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
                        WHERE td.id_perangkat = $id_perangkat
                        AND YEAR(t.start_time) = YEAR(NOW())
                    ")->row_array();
                    
                    $downtime = !empty($downtime_query['total_downtime']) ? $downtime_query['total_downtime'] : 0;
                    
                    if ($total_minutes_in_year > 0) {
                        $downtime_percentage = ($downtime / $total_minutes_in_year) * 100;
                        $performaperangkat = 100 - $downtime_percentage;
                        $performaperangkat = round($performaperangkat, 2);
                    } else {
                        $performaperangkat = 100;
                    }

                    $rumus_digunakan = 'TAHUNAN (KODE 1)';

                } elseif ($kode_fasilitas == 2) {
                    // FASILITAS KODE 2 - RUMUS BULANAN
                    $total_minutes_in_month = date('t') * 24 * 60;
                    
                    // Cek status dari tinjut dan tinjut_detail
                    $status_query = $this->Mod->GetCustome("
                        SELECT t.status AS tinjut_status, td.status AS tinjut_detail_status
                        FROM tinjut t
                        LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
                        WHERE td.id_perangkat = $id_perangkat
                        AND MONTH(t.start_time) = MONTH(NOW()) 
                        AND YEAR(t.start_time) = YEAR(NOW())
                    ")->row_array();
                    
                    $tinjut_status = !empty($status_query['tinjut_status']) ? $status_query['tinjut_status'] : null;
                    $tinjut_detail_status = !empty($status_query['tinjut_detail_status']) ? $status_query['tinjut_detail_status'] : null;

                    // Jika status di kedua tabel adalah 2, atau kosong, set performa 100%
                    if (($tinjut_status == 2 || empty($tinjut_status)) && ($tinjut_detail_status == 2 || empty($tinjut_detail_status))) {
                        $performaperangkat = 100;
                    } else {
                        // Hitung downtime bulan berjalan
                        $downtime_query = $this->Mod->GetCustome("
                            SELECT SUM(TIMESTAMPDIFF(MINUTE, t.start_time, t.end_time)) AS total_downtime 
                            FROM tinjut t
                            LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
                            WHERE td.id_perangkat = $id_perangkat
                            AND MONTH(t.start_time) = MONTH(NOW()) 
                            AND YEAR(t.start_time) = YEAR(NOW())
                        ")->row_array();
                        
                        $downtime = !empty($downtime_query['total_downtime']) ? $downtime_query['total_downtime'] : 0;
                        
                        if ($total_minutes_in_month > 0) {
                            $performaperangkat = (($total_minutes_in_month - $downtime) / $total_minutes_in_month) * 100;
                            $performaperangkat = round($performaperangkat, 2);
                        } else {
                            $performaperangkat = 100;
                        }
                    }

                    $rumus_digunakan = 'BULANAN (KODE 2)';

                } else {
                    // DEFAULT JIKA TIDAK ADA KODE FASILITAS YANG COCOK
                    $performaperangkat = 100;
                    $rumus_digunakan = 'DEFAULT';
                }

                // Tambahkan ke array
                $perangkat['perform_percentage'] = $performaperangkat;
                $perangkat['rumus_digunakan'] = $rumus_digunakan;
                $device_with_performance[] = $perangkat;
            }
        }

        // Response success
        $data = [
            'status' => 'success',
            'jumlah_perangkat' => count($device_with_performance),
            'perangkat' => $device_with_performance,
            'info_fasilitas' => [
                'id_unit' => $id_unit,
              
                'nama_fasilitas' => !empty($fasilitas_data['nama_fasilitas']) ? $fasilitas_data['nama_fasilitas'] : 'Tidak diketahui'
            ]
        ];

    } else {
        // Response jika tidak ada perangkat
        $data = [
            'status' => 'error',
            'message' => 'Tidak ada perangkat terhubung dengan fasilitas ini'
        ];
    }

    echo json_encode($data);
}













    function Loadmasterdetail($id)
    {
        //$data= $this->position();
        // $acc  = access($data,"VIEW")['access'];

        $data = $this->m_data->getWhere('master_perangkat_detail', array('id_jenisperangkat' => $id, 'status !=' => 8))->result_array();
        echo json_encode($data);
    }



    function LoadDataJP()
    {
        
        $data =  $this->Mod->GetCustome(" SELECT a.id_jenisperangkat,a.nama,COUNT(b.id_perangkat) as jumlah FROM jenis_perangkat a left join perangkat b on b.id_jenisperangkat = a.id_jenisperangkat where a.id_unit in ('0','" . sess()['unit'] . "') and b.id_perangkat is not null GROUP BY a.id_jenisperangkat,a.nama  ")->result_array();
        //  $this->Mod->getData('jenis_perangkat')->result_array();

        echo json_encode($data);
    }

    function LoadDataCatagory()
    {
        $data =  $this->Mod->GetCustome(" SELECT * FROM fasilitas_catagory WHERE id_unit ='" . sess()['unit'] . "'")->result_array();
        echo json_encode($data);
    }

    function LoadDataPerangkat($id)
    {
        //$data= $this->position();
        // $acc  = access($data,"VIEW")['access'];
        $jp = $this->Mod->getWhere('jenis_perangkat', array('id_jenisperangkat' => $id))->row_array();

        if ($jp['id_unit']=='0') {
            $data = $this->Mod->getWhere('perangkat', array( 'id_jenisperangkat' => $id))->result_array();
        }else{
            $data = $this->m_data->getWhere('perangkat', array('status' => 0, 'id_unit' => sess()['unit'], 'id_jenisperangkat' => $id))->result_array();

        }
       
        echo json_encode($data);
    }
    function LoadDataPerangkatByID($id)
    {
        //$data= $this->position();
        // $acc  = access($data,"VIEW")['access'];

        $data = $this->m_data->getWhere('fasilitas_detail', array('id_fasilitas' => $id))->result_array();
        foreach ($data as $key => $value) {
            $detail =  $this->m_data->getWhere('perangkat', array('id_perangkat' => $value['id_perangkat']))->row_array();

            $data[$key]['detail'] = $detail;
        }



        echo json_encode($data);
    }

    function GetLokasi()
    {
        //$data= $this->Mod->getData('terminal')->result_array();
        $data = $this->Mod->getWhere('terminal', array('parent_id' => -1))->result_array();
        echo json_encode($data);
    }
    function GetArea($idlokasi)
    {
        $data = $this->Mod->getWhere('terminal', array('parent_id' => $idlokasi))->result_array();
        echo json_encode($data);
    }



    function SaveData()
    {

        $data = array_filter($_POST);
        unset($data['Newitems']);
        if (!empty($data)) {
            $data['id_unit']    = sess()['unit'];
            $data['status']     = 1;
            $this->db->insert('fasilitas', $data);
            $id = $this->db->insert_id();
            if (!empty($_POST['Newitems'])) {

                foreach ($_POST['Newitems'] as $key => $value) {

                    $perangkat = [

                        'id_fasilitas'         =>  $id,
                        'id_perangkat'         =>  $value['id_perangkat'],
                        'id_jenisperangkat'    => $value['id_jenisperangkat'],
                        'status'             => 1,
                    ];
                    $this->db->insert('fasilitas_detail', $perangkat);
                    // echo "<pre>",print_r ( $perangkat),"</pre>";
                }
                $respon = [
                    'code'    => '200',
                    'msg'       => 'Data Berhasil di disimpan'
                ];
            }
        } else {
            $respon = [
                'code'    => '400',
                'msg'       => 'Data Gagal Disimpan, cek data kembali'
            ];
        }
        // echo "<pre>",print_r ( $data),"</pre>";
        echo json_encode($respon);
    }

    function EditData($id = null)
    {
        $data           = $this->Mod->GetCustome("SELECT a.*,b.kode_unit as unit,c.nama_terminal as lokasi,d.nama_terminal as sub_lokasi FROM fasilitas a left join unit b on b.id_unit =a.id_unit left join terminal c on c.id=a.id_lokasi left join terminal d on d.id=a.id_sublokasi where a.id_fasilitas = '" . $id . "'")->row_array();
        $detail         = $this->Mod->GetCustome("SELECT a.*,b.nama_perangkat,b.serial_number,c.nama as jenis_perangkat FROM fasilitas_detail a left join perangkat b on b.id_perangkat = a.id_perangkat left join jenis_perangkat c on c.id_jenisperangkat = a.id_jenisperangkat where a.id_fasilitas = '" . $id . "'")->result_array();
        foreach ($detail as $key => $value) {
            $detail[$key]['tgl'] = date("Y-m-d", strtotime($value['tanggal_penggunaan']));
        }
        $data['detail'] = $detail;
        echo json_encode($data);
    }

    public function UpdateData($pk = null)
    {
        $data = array_filter($_POST);
        unset($data['Newitems']);
        unset($data['Items']);
        unset($data['removed_items']);
        
        if (!empty($data)) {

            if (isset($_POST['kode'])) {
            $data['kode'] = $_POST['kode'];
            }

            $update = $this->Mod->update2('fasilitas', array('id_fasilitas  ' => $pk), $data);
            // $this->db->insert('user',$data);
            if (!empty($_POST['removed_items'])) {

                foreach ($_POST['removed_items'] as $key => $value) {
                    $fasilitas_detail = $this->m_data->getWhere('fasilitas_detail', array('idfasilitas_detail' => $value))->row_array();
                    $status_perangkat = [
                        'status' => 0
                    ];


                    if (!empty($fasilitas_detail['id_perangkat'])) {
                        $this->Mod->update2('perangkat', array('id_perangkat' => $fasilitas_detail['id_perangkat']), $status_perangkat);
                    }

                    $result = $this->Mod->delete('fasilitas_detail', array('idfasilitas_detail' => $value));
                }
            }

            if (!empty($_POST['Items'])) {

                foreach ($_POST['Items'] as $key => $value) {
                    $fasilitas_detail = $this->m_data->getWhere('fasilitas_detail', array('idfasilitas_detail' => $value['idfasilitas_detail']))->row_array();
                    $status_perangkat = [
                        'status' => 0
                    ];
                    $this->Mod->update2('perangkat', array('id_perangkat' => $fasilitas_detail['id_perangkat']), $status_perangkat);
                    //mengubah status perangkat sebelumnya diggunakan di fasilitas menjadi tidak digunakan


                    $perangkat = [
                        'id_fasilitas'             => $pk,
                        'id_perangkat'             => $value['id_perangkat'],
                        'id_jenisperangkat'        => $value['id_jenisperangkat'],
                        'tanggal_penggunaan'    => $value['tanggal_pemasangan'],
                        'status'                 => 1,
                    ];
                    $update_detail = $this->Mod->update2('fasilitas_detail', array('idfasilitas_detail' => $value['idfasilitas_detail']), $perangkat);

                    $status_perangkat = [
                        'status' => 1
                    ];
                    $this->Mod->update2('perangkat', array('id_perangkat' => $value['id_perangkat']), $status_perangkat);
                }
            }
            if (!empty($_POST['Newitems'])) {

                foreach ($_POST['Newitems'] as $key => $value) {

                    $perangkat = [
                        'id_fasilitas'             => $pk,
                        'id_perangkat'             => $value['id_perangkat'],
                        'id_jenisperangkat'        => $value['id_jenisperangkat'],
                        'tanggal_penggunaan'    => '',
                        'status'                 => 1,
                    ];
                    $this->db->insert('fasilitas_detail', $perangkat);

                    $status_perangkat = [
                        'status' => 1
                    ];
                    $this->Mod->update2('perangkat', array('id_perangkat' => $value['id_perangkat']), $status_perangkat);
                }
            }
            if ($update) {
                $respon = [
                    'code'    => '200',
                    'msg'       => 'Data Berhasil di disimpan'
                ];
            } else {
                $respon = [
                    'code'    => '400',
                    'msg'       => 'Data Gagal Disimpan, cek data kembali'
                ];
            }
        } else {
            $respon = [
                'code'    => '400',
                'msg'       => 'Data Gagal Disimpan, Tidak ada perubahan'
            ];
        }
        echo json_encode($respon);
    }

    function UploadData()
    {
        $data = array();
        if (isset($_FILES["filelampiran"]["name"])) {
            $path = $_FILES["filelampiran"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);


            $data           = array();
            $data_triwulan  = array();
            $data_sms       = array();
            $data_thn       = array();
            $datacctv_bulanan = array();

            $detail_prop = array();
            foreach ($object->getWorksheetIterator(1) as $worksheet => $value) {
                $highestRow = $value->getHighestRow();

                $lastColumn = $value->getHighestDataColumn();
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($lastColumn);

                if ($worksheet == 0) {
                    for ($col = 3; $col <= $highestColumnIndex; $col++) {
                        if ($col >= 9 && $col <= 14) {
                            $detail_prop            = $value->getCellByColumnAndRow($col, 3)->getValue();
                            $data['detail_prop_pc'][] = $detail_prop;
                        }
                    }

                    for ($row = 4; $row <= $highestRow; $row++) {
                        $nama_fasilitas         = $value->getCellByColumnAndRow(1, $row)->getValue();
                        $lokasi                 = $value->getCellByColumnAndRow(2, $row)->getValue();
                        $sublokasi              = $value->getCellByColumnAndRow(3, $row)->getValue();
                        $ipaddress              = $value->getCellByColumnAndRow(4, $row)->getValue();
                        //mini pc
                        $buatan                 = $value->getCellByColumnAndRow(5, $row)->getValue();
                        $merk                   = $value->getCellByColumnAndRow(6, $row)->getValue();
                        $model                  = $value->getCellByColumnAndRow(7, $row)->getValue();
                        $sn_perangkat           = $value->getCellByColumnAndRow(8, $row)->getValue();
                        $suport_port            = $value->getCellByColumnAndRow(9, $row)->getValue();
                        $disk                   = $value->getCellByColumnAndRow(10, $row)->getValue();
                        $ram                    = $value->getCellByColumnAndRow(11, $row)->getValue();
                        $os                     = $value->getCellByColumnAndRow(12, $row)->getValue();
                        $tahun_perangkat        = $value->getCellByColumnAndRow(13, $row)->getValue();

                        //monitor
                        $buatan2                = $value->getCellByColumnAndRow(15, $row)->getValue();
                        $merk2                  = $value->getCellByColumnAndRow(16, $row)->getValue();
                        $model2                 = $value->getCellByColumnAndRow(17, $row)->getValue();
                        $sn_perangkat2          = $value->getCellByColumnAndRow(18, $row)->getValue();
                        $suport_port2           = $value->getCellByColumnAndRow(19, $row)->getValue();
                        $ukuran                 = $value->getCellByColumnAndRow(20, $row)->getValue();
                        $tahun_perangkat        = $value->getCellByColumnAndRow(21, $row)->getValue();
                        $kondisi2                = $value->getCellByColumnAndRow(22, $row)->getValue();


                        $getmerek               = $this->Mod->getWhere('merk', array('nama' => $merk))->row_array();

                        $miniPC = [
                            'id_jenisperangkat'     => 2,
                            'nama_perangkat'        => 'Mini PC ' . $merk . ' model ' . $model,
                            'model'                 => $model,
                            'merk_id'               => $getmerek['id'],
                            'serial_number'         => $sn_perangkat,
                            'suport_port'           => $suport_port,
                            'disk_kapasity'         => $disk,
                            'ram'                   => $ram,
                            'OS'                    => $os,
                            'tahun_pengadaan'       => $tahun_perangkat,
                        ];

                        $getmerek2               = $this->Mod->getWhere('merk', array('nama' => $merk2))->row_array();
                        $monitor = [
                            'id_jenisperangkat'     => 1,

                            'nama_perangkat'        => 'Monitor ' . $merk2 . ' model ' . $model2,
                            'buatan'                => $buatan2,
                            'merk_id'               => $getmerek2['id'],
                            'model'                 => $model2,
                            'serial_number'         => $sn_perangkat2,
                            'suport_port'           => $suport_port2,
                            'ukuran'                => $ukuran,
                            'tahun_pengadaan'       => $tahun_perangkat,
                            'kondisi'               => $kondisi2,


                        ];
                        $sub =  $this->Mod->getWhere('terminal', array('nama_terminal' => $sublokasi))->row_array();
                        if (!empty($sub)) {
                            $id_sub = $sub['id'];
                        } else {
                            $id_sub = '';
                        }

                        if ($lokasi = '3U-INT') {
                            $data_lokasi = '3';
                        }
                        $data['data'][] = [
                            'nama_fasilitas'    => $nama_fasilitas,
                            'id_unit'           => '',
                            'id_lokasi'         => $data_lokasi,
                            'id_sublokasi'      => $id_sub,
                            'ip_address'        => $ipaddress,
                            'mini_pc'           =>  $miniPC,
                            'monitor'           =>  $monitor
                        ];
                    }
                }
            }
        }

        $perangkat_detail = array();
        foreach ($data as $key => $value) {

            if ($key == 'data') {
                $fasilitas = [
                    'nama_fasilitas'        => '',
                    'id_unit'               => '',
                    'id_lokasi'             =>  '',
                    'id_sublokasi'          => '',
                    'ip_address'            => ''
                ];

                foreach ($value as $key2 => $value2) {

                    if ($key2 == 'mini_pc') {

                        $perangkat = [
                            'id_jenisperangkat'     => $value2['mini_pc']['id_jenisperangkat'],
                            'nama_perangkat'        => $value2['mini_pc']['nama_perangkat'],
                            'model'                 => $value2['mini_pc']['model'],
                            'merk_id'               => $value2['mini_pc']['merk_id'],
                            'serial_number'         => $value2['mini_pc']['serial_number'],
                        ];
                        foreach ($value2['mini_pc'] as $key3 => $val3) {


                            if ($key3 == 'suport_port') {
                                $perangkat_detail[] = [
                                    'idmaster_detail_perangkat' => 27,
                                    'nama'                      => $val3
                                ];
                            }

                            if ($key3 == 'disk_kapasity') {
                                $perangkat_detail[] = [
                                    'idmaster_detail_perangkat' => 28,
                                    'nama'                      => $val3
                                ];
                            }

                            if ($key3 == 'disk_kapasity') {
                                $perangkat_detail[] = [
                                    'idmaster_detail_perangkat' => 28,
                                    'nama'                      => $val3
                                ];
                            }

                            if ($key3 == 'ram') {
                                $perangkat_detail[] = [
                                    'idmaster_detail_perangkat' => 29,
                                    'nama'                      => $val3
                                ];
                            }

                            if ($key3 == 'OS') {
                                $perangkat_detail[] = [
                                    'idmaster_detail_perangkat' => 30,
                                    'nama'                      => $val3
                                ];
                            }
                        }
                    }

                    if ($key2 == 'monitor') {

                        $perangkat = [
                            'id_jenisperangkat'     => $value2['monitor']['id_jenisperangkat'],
                            'nama_perangkat'        => $value2['monitor']['nama_perangkat'],
                            'model'                 => $value2['monitor']['model'],
                            'merk_id'               => $value2['monitor']['merk_id'],
                            'serial_number'         => $value2['monitor']['serial_number'],
                        ];
                        foreach ($value2['monitor'] as $key3 => $val3) {


                            if ($key3 == 'suport_port') {
                                $perangkat_detail[] = [
                                    'idmaster_detail_perangkat' => 31,
                                    'nama'                      => $val3
                                ];
                            }

                            if ($key3 == 'ukuran') {
                                $perangkat_detail[] = [
                                    'idmaster_detail_perangkat' => 1,
                                    'nama'                      => $val3
                                ];
                            }
                        }
                    }
                }
            }
        }
        echo "<pre>", print_r($perangkat_detail), "</pre>";
    }

    //     function   CopyData(){
    //         $fasilitas = $this->m_data->getWhere('perangkat_old',array('status !=' =>8))->result_array();
    //         foreach ($fasilitas as $key => $value) {
    //             $data=[
    //                 'nama_fasilitas'    => $value['nama_perangkat'] ,
    //                 'ip_address'        => $value['ip'] ,
    //                 'keterangan'        => $value['lokasi'] ,
    //                 'id_unit'           => sess()['unit'],
    //                 'status'            => 0
    //             ];
    //             $this->db->insert('fasilitas',$data);
    //         }
    //         echo "<pre>", print_r($fasilitas), "</pre>";
    //     }


    function CekIp($id_fasilitas = null)
    {
        if (!empty($id_fasilitas)) {
            $data_res = $this->m_data->getWhere('fasilitas', array('id_fasilitas' => $id_fasilitas))->row_array();
            $replay = 1;
            $respon = array();
            if (!empty($data_res['ip_address'])) {
                $ip = $data_res['ip_address'];
                exec("ping -n 3  $ip", $output, $status);
                if ($status == 0) {
                    $respon = [
                        // 'ip'            => $ip,
                        'status'        => 1,
                        'updateDate'    => date("Y-m-d"),
                        'updateTime'    => date("h:i:sa")
                    ];
                    // $this->m_data->updateData('perangkat', array('id' => $data_res['id']), $respon);
                } else {

                    $respon = [
                        // 'ip'            => $ip,
                        'status'        => 0,
                        'updateDate'    => date("Y-m-d"),
                        'updateTime'    => date("h:i:sa")
                    ];
                    // $this->m_data->updateData('perangkat', array('id' => $data_res['id']), $respon);
                    // $responLog=[
                    //     'ip'            => $ip,
                    //     'lokasi'        =>  $data_res['lokasi'],
                    //     'status'        => 'RTO',
                    //     'datecek'       => date("Y-m-d"),
                    //     'updateTime'    => date("h:i:sa")

                    // ];
                    //$this->m_data->insertData('perangkat',$data);
                }
                echo json_encode($respon);
            }
        }
    }

    function ValidateData()
    {
        $fasilitas = $this->m_data->getWhere('fasilitas', array('status !=' => 8, 'id_unit' => sess()['unit']))->result_array();

        foreach ($fasilitas as $key => $value) {
            $detail = $this->m_data->getWhere('fasilitas_detail', array('id_fasilitas' => $value['id_fasilitas']))->result_array();
            foreach ($detail as $key2 => $val2) {
                $perangkat = $this->m_data->getWhere('perangkat', array('id_perangkat' => $val2['id_perangkat']))->row_array();
                if (!empty($perangkat)) {

                    $perangkat['idfasilitas'] = $value['id_fasilitas'];

                    $fasilitas[$key]['perangkat'][] = [
                        'id_perangkat'          => $perangkat['id_perangkat'],
                        'id_jenisperangkat'     => $perangkat['id_jenisperangkat'],
                        'status'                => $perangkat['status']

                    ];
                } else {
                    $fasilitas[$key]['perangkat'][] = '';
                }
            }
            // $data=[
            //     'nama_fasilitas'    => $value['nama_perangkat'] ,
            //     'ip_address'        => $value['ip'] ,
            //     'keterangan'        => $value['lokasi'] ,
            //     'id_unit'           => sess()['unit'],
            //     'status'            => 0
            //     ];

        }
        // echo "<pre>", print_r($fasilitas), "</pre>";


    }

    function ViewDetail($id = null)
    {
        if (!empty($id)) {
            $data           = $this->Mod->GetCustome("SELECT a.*,b.kode_unit as unit,c.nama_terminal as lokasi,d.nama_terminal as sub_lokasi FROM fasilitas a left join unit b on b.id_unit =a.id_unit left join terminal c on c.id=a.id_lokasi left join terminal d on d.id=a.id_sublokasi where a.id_fasilitas = '" . $id . "'")->row_array();
            $detail         = $this->Mod->GetCustome("SELECT a.*,b.nama_perangkat,b.serial_number,c.nama as jenis_perangkat FROM fasilitas_detail a left join perangkat b on b.id_perangkat = a.id_perangkat left join jenis_perangkat c on c.id_jenisperangkat = a.id_jenisperangkat where a.id_fasilitas = '" . $id . "'")->result_array();
            foreach ($detail as $key => $value) {
                $detail[$key]['serial_number'] = (!empty($value['serial_number']) ? $value['serial_number'] : "-");
            }
            $data['detail'] = $detail;
            $lv1            = "doc";
            if (!file_exists($lv1)) {
                mkdir($lv1);
            }
            $lv2 = $lv1 . "/QRCode2";
            if (!file_exists($lv2)) {
                mkdir($lv2);
            }

            if (empty($data['QRCODE'])) {
                $qr  =  $this->QRCodeRender($data['id_fasilitas']);
                $update = ['QRCODE' => $qr];
                $this->Mod->update2('fasilitas', array('id_fasilitas  ' => $id), $update);
                $data['QRCODE'] = $qr;
            } else {
                $filename = 'doc/QRCode/' . $data['QRCODE'];
                if (!file_exists($filename)) {
                    $qr             =  $this->QRCodeRender($data['id_fasilitas']);
                    $update         = ['QRCODE' => $qr];
                    $this->Mod->update2('fasilitas', array('id_fasilitas  ' => $id), $update);
                    $data['QRCODE'] = $qr;
                }
            }

            echo json_encode($data);
        }
    }

    function SessTerminal()
    {
        $fasilitas = $this->m_data->getWhere('fasilitas', array('status !=' => 8, 'id_unit' => sess()['unit'], 'id_lokasi ' => 0))->result_array();

        foreach ($fasilitas as $key => $value) {
            $terminal =  $this->Mod->GetCustome("SELECT  * FROM terminal WHERE nama_terminal like '%" . $value['terminal'] . "%'")->row_array();
            if (!empty($terminal)) {

                if ($terminal['parent_id'] == '-1') {
                    $update = ['id_lokasi'     => $terminal['id']];
                } else {
                    $update = [
                        'id_lokasi'         => $terminal['parent_id'],
                        'id_sublokasi'     => $terminal['id']
                    ];
                }

                $this->Mod->update2('fasilitas', array('id_fasilitas  ' => $value['id_fasilitas']), $update);
            } else {
                //  echo  $value['nama_fasilitas']."|".$value['terminal']."|Jalan Raya Perkantoran <br>";
                // echo "<pre>", print_r($value), "</pre>"; 
                if ($value['terminal'] == 'JNP') {
                    $update = ['id_lokasi'     => 4];
                } elseif ($value['terminal'] == 'Apron Terminal 2') {
                    $update = ['id_lokasi'     => 2];
                } elseif ($value['terminal'] == 'Parkir Terminal 1') {
                    $update = ['id_lokasi'     => 1];
                } elseif ($value['terminal'] == 'Parkir Terminal 2') {
                    $update = ['id_lokasi'     => 2];
                } elseif ($value['terminal'] == 'Damri Terminal 1') {
                    $update = ['id_lokasi'     => 1];
                } elseif ($value['terminal'] == 'Damri Terminal 2') {
                    $update = ['id_lokasi'     => 2];
                } elseif ($value['terminal'] == 'Parkir Inap') {
                    $update = ['id_lokasi'     => 4];
                } elseif ($value['terminal'] == 'Apron Terminal 1') {
                    $update = ['id_lokasi'     => 1];
                } elseif ($value['terminal'] == 'Parkir Terminal 1') {
                    $update = ['id_lokasi'     => 1];
                } elseif ($value['terminal'] == 'Apron Terminal 3') {
                    $update = ['id_lokasi'     => 3];
                } elseif ($value['terminal'] == 'Cooling T1') {
                    $update = ['id_lokasi'     => 1];
                } elseif ($value['terminal'] == 'Cooling T2') {
                    $update = ['id_lokasi'     => 2];
                } elseif ($value['terminal'] == 'Masjid Internasional T3') {
                    $update = ['id_lokasi'     => 3];
                } elseif ($value['terminal'] == 'AOCC') {
                    $update = ['id_lokasi'     => 49];
                } elseif ($value['terminal'] == ' Terminal 3') {
                    $update = ['id_lokasi'     => 3];
                } elseif ($value['terminal'] == ' Terminal 2') {
                    $update = ['id_lokasi'     => 2];
                } elseif ($value['terminal'] == ' Terminal 1') {
                    $update = ['id_lokasi'     => 1];
                } elseif ($value['terminal'] == 'APRON TERMINAL 2') {
                    $update = ['id_lokasi'     => 2];
                } elseif ($value['terminal'] == 'APRON TERMINAL 1') {
                    $update = ['id_lokasi'     => 2];
                } elseif ($value['terminal'] == 'Parking Inter') {
                    $update = ['id_lokasi'     => 3];
                } elseif ($value['terminal'] == 'DKT') {
                    $update = ['id_lokasi'     => 4];
                } elseif ($value['terminal'] == 'Cargo') {
                    $update = ['id_lokasi'     => 4];
                } elseif ($value['terminal'] == 'Shelter Kalayang') {
                    $update = ['id_lokasi'     => 4];
                } elseif ($value['terminal'] == 'MPS') {
                    $update = ['id_lokasi'     => 4];
                } elseif ($value['terminal'] == 'Gedung 600') {
                    $update = ['id_lokasi'     => 4];
                } elseif ($value['terminal'] == 'TOD') {
                    $update = ['id_lokasi'     => 4];
                } elseif ($value['terminal'] == 'MPS 1') {
                    $update = ['id_lokasi'     => 4];
                } else {
                    $update = ['id_lokasi'     => 0];
                }

                $this->Mod->update2('fasilitas', array('id_fasilitas  ' => $value['id_fasilitas']), $update);
            }
        }
        // echo "<pre>", print_r($fasilitas), "</pre>";
    }

    function DellFasilitas()
    {
        $fasilitas = $this->m_data->getWhere('fasilitas', array('id_unit' => '3'))->result_array();

        foreach ($fasilitas as $key => $value) {
            $this->Mod->delete('fasilitas', array('id_fasilitas' => $value['id_fasilitas']));
            $this->Mod->delete('fasilitas_detail', array('id_fasilitas' => $value['id_fasilitas']));
        }
    }

    function AddDetailPerangkat()
    {
        $fasilitas = $this->Mod->GetCustome(" SELECT * FROM fasilitas WHERE id_unit = '3' ")->result_array();
        //  $this->m_data->getWhere('fasilitas',array('id_unit' =>3))->result_array();
        $perangkat = $this->Mod->GetCustome("SELECT * FROM perangkat WHERE id_jenisperangkat IN ('3','4' )")->result_array();


        foreach ($fasilitas as $key => $value) {

            foreach ($perangkat as $key2 => $value2) {
                $insert = [
                    'id_fasilitas'          => $value['id_fasilitas'],
                    'id_perangkat'          => $value2['id_perangkat'],
                    'id_jenisperangkat'     => $value2['id_jenisperangkat'],
                    'status'                => '1'
                ];

                $cek =  $this->m_data->getWhere('fasilitas_detail', array('id_fasilitas' => $value['id_fasilitas'], 'id_jenisperangkat' => $value2['id_jenisperangkat'], 'id_perangkat' => $value2['id_perangkat']))->row_array();
                if (!empty($cek)) {
                    echo "DATa sudah ada";
                } else {
                    echo "<pre>", print_r($cek), "</pre>";
                    $this->db->insert('fasilitas_detail', $insert);
                }
                // $this->db->insert('fasilitas_detail',$insert);
            }
            # code...
        }

        // echo "<pre>", print_r($perangkat), "</pre>";
    }

    function  AddOderFasilias()
    {
        $fasilitas = $this->m_data->getWhere('fasilitas', array('status !=' => 8, 'id_unit' => sess()['unit']))->result_array();

        foreach ($fasilitas as $key => $value) {

            $listrik = [];
            # code...
        }
    }

    function GenQRcode($id = null)
    {
        if (!empty($id)) {
            $fasilitas = $this->m_data->getWhere('fasilitas', array('status !=' => 8, 'id_fasilitas' => $id))->row_array();
            // echo "<pre>", print_r($fasilitas), "</pre>";

            if (empty($fasilitas['QRCODE'])) {
                $qr = $this->QRCodeRender($fasilitas['id_fasilitas']);
                $update = ['QRCODE' => $qr];
                $this->Mod->update2('fasilitas', array('id_fasilitas  ' => $id), $update);
            } else {
                $qr = $fasilitas['QRCODE'];
            }
        } else {
            echo "Semua";
        }
    }


    public function QRCodeRender($id = null)
    {

        $name = rand();
        $tempdir = "doc/QRCode/"; //Nama folder tempat menyimpan file qrcode
        if (!file_exists($tempdir)) //Buat folder bername temp
            mkdir($tempdir);

        //ambil logo
        $logopath = "assets_v2/images/ap2.png";

        //isi qrcode jika di scan
        $codeContents = base_url('informasi/fasilitas/') . $id;


        //simpan file qrcode
        QRcode::png($codeContents, $tempdir . $name . '.png', QR_ECLEVEL_H, 10, 4);


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

        // Scale logo to fit in the QR Code
        $logo_qr_width = $QR_width / 5;
        $scale = $logo_width / $logo_qr_width;
        $logo_qr_height = $logo_height / $scale;

        imagecopyresampled($QR, $logo, $QR_width / 2.5, $QR_height / 2.5, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

        // Simpan kode QR lagi, dengan logo di atasnya
        imagepng($QR, $tempdir . $name . '.png');
        //echo '<img src="'.base_url().$tempdir. $name.'.png" class="img-fluid rounded"/>';
        return $name . '.png';
    }

    public function informasi()
    {
        $data = [];
        $this->load->view('infromasi_fasilitas', $data);
    }

    function GetFasilitas()
    {
        $serc = $this->input->post('q');
        if (!empty($serc)) {
            $query =  $this->Mod->GetCustome("SELECT  *
            FROM fasilitas  where nama_fasilitas like '" . $serc . "' ")->result_array();
        } else {
            $query =  $this->Mod->GetCustome("SELECT  *
            FROM fasilitas  where nama_fasilitas like '" . $serc . "' ")->result_array();
        }

        $data = [];
        foreach ($query as $key => $value) {
            // echo "<pre>",print_r ( $value),"</pre>";
            $data[] = [
                'name'    => $value['nama_fasilitas'],
                'id'    => $value['id_fasilitas']
            ];
        }
        echo json_encode($data);
    }

    function Cekdata()
    {
        $fasilitas =  $this->m_data->getWhere('fasilitas', array('status !=' => 8, 'id_unit' => 1))->result_array();

        $param = 'INT';
        $query =  $this->Mod->GetCustome("SELECT  *
            FROM fasilitas  where terminal like '%" . $param . "%' ")->result_array();

        $lok =  $this->Mod->GetCustome("SELECT  *
            FROM terminal  where nama_terminal  like '%" . $param . "%' ")->row_array();
        foreach ($query as $key => $value) {
            $update_lokasi = [
                'id_area'     => $lok['id']

            ];
            echo "<pre>", print_r($update_lokasi), "</pre>";
            $update = $this->Mod->update2('fasilitas', array('id_fasilitas  ' => $value['id_fasilitas']), $update_lokasi);
        }
    }
       public function performa2() 
        {
            $data['title'] = "Performance Monitoring Alat";
            $data['title_des'] = "Data Performa On/Off Per Bulan";
            
            // Sample data - replace with your actual database query
            $data['performance_data'] = [
                'mei' => [
                    '14' => ['on' => 96, 'off' => 4, 'name' => 'NVA'],
                    '15' => ['on' => 91.71, 'off' => 8.29, 'name' => 'SVA'],
                    '16' => ['on' => 99.29, 'off' => 0.71, 'name' => 'EU'],
                    '17' => ['on' => 93.34, 'off' => 6.66, 'name' => 'UPS&CONV']
                ],
                'juni' => [
                    '14' => ['on' => 97, 'off' => 3, 'name' => 'NVA'],
                    '15' => ['on' => 91.18, 'off' => 8.82, 'name' => 'SVA'],
                    '16' => ['on' => 99.25, 'off' => 0.75, 'name' => 'EU'],
                    '17' => ['on' => 93.34, 'off' => 6.66, 'name' => 'UPS&CONV']
                ],
                'juli' => [
                    '14' => ['on' => 97, 'off' => 3, 'name' => 'NVA'],
                    '15' => ['on' => 85.27, 'off' => 14,73, 'name' => 'SVA'],
                    '16' => ['on' => 99.23, 'off' => 0.77, 'name' => 'EU'],
                    '17' => ['on' => 93.34, 'off' => 6.66, 'name' => 'UPS&CONV']
                ]
            ];
            
            $this->load->view('fasilitas/v_performa2', $data);
        }
}
