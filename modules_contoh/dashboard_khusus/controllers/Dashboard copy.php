<?php
// application/modules/req_open/controllers/Req_open.php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load library atau helper yang diperlukan
        $this->load->library('javascript');
        $this->load->model('Dashboard_m');
    }

    private function role()
    {
        $url = urlencode(current_url());
        if (session("username") == "") {
            redirect(base_url('login/auth'));
        }
    }

    private function position()
    {
        $data["param"] = http_build_query($_GET);
        $data["position"] = "home";
        return $data;
    }

    public function index()
    {
        $this->role();
        $data = $this->position();

        $data["title"]      = "Dashboard";
        $nama_sesi = $this->session->userdata('nama');
        $data["title_des"]  = "Selamat datang di Website Digital Report  " . $nama_sesi . " !";

        $data["data"]       = $data;

        if (sess()['unit'] == 1) {
            $data["content"]    = "Dashboard_cctv";
        } elseif (sess()['unit'] == 2) {
            $data["content"]    = "Dashboard_v";
        } elseif (sess()['unit'] == 3) {
            $data["content"]    = "Dashboard_cctv";
        }
        else {
            $data["content"]    = "Dashboard_mps";
        }
        


        $this->load->view('template_v2', $data);
    }
    function catagory()
    {
        $data = $this->Mod->getWhere('fasilitas_catagory ', array('id_unit' => sess()['unit'], 'status !=' => 8))->result_array();
        echo json_encode($data);
    }

    public function get_data()
    {
        $data = $this->Dashboard_m->get_data();
        echo json_encode($data);
    }

    public function get_monitor_count()
    {

        $this->db->where('id_jenisperangkat', 1); // Filter untuk mendapatkan data monitor (id_jenisperangkat = 1)
        $this->db->where('status', 0);
        $jumlah_monitor = $this->db->count_all_results('perangkat'); // Menghitung jumlah baris yang memenuhi kriteria

        //tambahan untuk count data 
        $count = $this->Mod->GetCustome("SELECT status,COUNT(status) AS total FROM perangkat where id_jenisperangkat = 1 group by status")->result_array();

        $data = array('monitor_count' => $jumlah_monitor, 'data' => $count);
        echo json_encode($data);
    }

    public function get_minipc_count()
    {

        $this->db->where('id_jenisperangkat', 2);
        $this->db->where('status', 0);
        $jumlah_minipc = $this->db->count_all_results('perangkat');

        $count = $this->Mod->GetCustome("SELECT status,COUNT(status) AS total FROM perangkat where id_jenisperangkat = 2 group by status")->result_array();

        $data = array('minipc_count' => $jumlah_minipc, 'data' => $count);
        echo json_encode($data);
    }

    public function get_fasilitas_count()
    {

        $this->db->where('status', 1);
        $this->db->where('id_unit', sess()['unit']);
        $jumlah_fasilitas = $this->db->count_all_results('fasilitas');
        $jum_perangkat = $this->Mod->GetCustome("SELECT COUNT(*)as total FROM perangkat where status != 8 and id_unit ='" . sess()['unit'] . "'")->row_array();
        //   echo "<pre>",print_r ($jum_perangkat),"</pre>";
        $data = array('fasilitas_count' => $jumlah_fasilitas, 'perangkat' => $jum_perangkat['total']);
        echo json_encode($data);
    }

    public function getPersentase_Indikator()
    {

        $data['monitor']    = $this->Mod->GetCustome('SELECT COUNT(id_jenisperangkat) AS jumlahMonitor FROM logbook WHERE id_jenisperangkat = 1 AND create_date >= NOW() - INTERVAL 1 MONTH')->row_array();
        $data['pc']         = $this->Mod->GetCustome('SELECT COUNT(id_jenisperangkat) AS jumlahPC FROM logbook WHERE id_jenisperangkat = 2 AND create_date >= NOW() - INTERVAL 1 MONTH')->row_array();
        $data['jaringan']   = $this->Mod->GetCustome('SELECT COUNT(id_jenisperangkat) AS jumlahJaringan FROM logbook WHERE id_jenisperangkat = 3 AND create_date >= NOW() - INTERVAL 1 MONTH')->row_array();
        $data['listrik']    = $this->Mod->GetCustome('SELECT COUNT(id_jenisperangkat) AS jumlahListrik FROM logbook WHERE id_jenisperangkat = 4 AND create_date >= NOW() - INTERVAL 1 MONTH')->row_array();

        $data['total'] = $this->Mod->GetCustome('SELECT COUNT(*) AS total FROM logbook WHERE create_date >= NOW() - INTERVAL 1 MONTH')->row_array();

        echo json_encode($data);
    }

   function GetPersentase_repair() {
    // Ambil bulan dari request (default bulan ini jika tidak ada)
    $month = $this->input->post('month') ? $this->input->post('month') : date('m');  // Mengambil bulan yang dikirimkan, atau bulan saat ini
    
    // Debugging: cek bulan yang diterima
    log_message('debug', 'Bulan yang diterima: ' . $month);
    $unit = sess()['unit'];  // Ambil unit dari session

    $data['fasilitas'] = $this->Mod->GetCustome("
    SELECT 
    a.id_fasilitas,
    b.nama_fasilitas,
    COUNT(DISTINCT a.id_tinjut) AS jumlah_fasilitas,
    COUNT(DISTINCT td.id_perangkat) AS jumlah_perangkat
    FROM tinjut a 
    LEFT JOIN fasilitas b ON b.id_fasilitas = a.id_fasilitas 
    LEFT JOIN tinjut_detail td ON td.id_tinjut = a.id_tinjut
    WHERE MONTH(a.create_date) = $month
    AND a.id_unit = $unit
    GROUP BY a.id_fasilitas, b.nama_fasilitas
    ORDER BY jumlah_perangkat DESC
    ")->result_array();
    // Debugging: cek apakah data yang diambil ada
    log_message('debug', 'Data fasilitas: ' . print_r($data['fasilitas'], true));

    // Menghitung total jumlah perbaikan
    $total = 0;
     // Menghitung total jumlah perbaikan - PERBAIKAN DI SINI
    $total = 0;
    foreach ($data['fasilitas'] as $key => $value) {
        $total += $value['jumlah_perangkat']; // Gunakan jumlah_perangkat, bukan jumlah
        $data['fasilitas'][$key]['color'] = color($key); // Set color for each bar
    }


    $data['total'] = $total;

    // Mengirimkan data dalam format JSON
    echo json_encode($data);
}



    public function get_top5_data()
    {

        $data   = $this->Mod->GetCustome('SELECT a.*, b.nama_fasilitas, c.kode_unit, d.nama_terminal, COUNT(a.id_fasilitas) AS jumlah
        FROM logbook a 
        LEFT JOIN fasilitas b ON b.id_fasilitas = a.id_fasilitas 
        LEFT JOIN unit c ON c.id_unit = b.id_unit
        LEFT JOIN terminal d ON b.id_lokasi = d.id 
        WHERE a.create_date >= NOW() - INTERVAL 1 MONTH
        GROUP BY a.id_fasilitas ORDER BY jumlah DESC LIMIT 10')->result_array();
        echo json_encode($data);
    }

    public function GetTopTemuan()
    {
        $this->db->select('t.*, f.nama_fasilitas');
        $this->db->from('temuan t');
        $this->db->join('fasilitas f', 'f.id_fasilitas = t.id_fasilitas', 'left');
        $this->db->where('t.id_unit', sess()['unit']);
        $this->db->where('t.status !=', 8);
        $this->db->order_by('t.id_temuan', 'DESC');
        $this->db->limit(10);
        $temuan = $this->db->get()->result_array();

        foreach ($temuan as $key => $value) {
            $temuan[$key]['tanggal_format'] = tgl($value['tanggal'], 'l');
            $temuan[$key]['status_label'] = st($value['status']);

            // Get associated devices
            $detail_temuan = $this->db->get_where('temuan_detail', ['id_temuan' => $value['id_temuan'], 'status !=' => 8])->result_array();
            $perangkat_names = [];
            foreach ($detail_temuan as $detail) {
                $perangkat = $this->db->get_where('perangkat', ['id_perangkat' => $detail['id_perangkat']])->row_array();
                if (!empty($perangkat)) {
                    $perangkat_names[] = $perangkat['nama_perangkat'] ?? 'Perangkat';
                }
            }
            
            if (empty($perangkat_names)) {
                $temuan[$key]['peralatan'] = $value['nama_fasilitas'];
            } else {
                $temuan[$key]['peralatan'] = implode(', ', $perangkat_names);
            }
        }

        echo json_encode($temuan);
    }

   public function get_users()
    {
        $today = date('Y-m-d');
        $current_time = date('H:i:s');
        $shift_PS_start = '08:00:00';
        $shift_PS_end = '20:00:00';
        $shift_M_start = '20:00:00';
        $shift_M_end = '08:00:00';
        $shift_D_start = '07:30:00';
        $shift_D_end = '16:30:00';

        // $users = $this->Mod->GetCustome('
        // SELECT
        //     user.nama, user.nik, user.no_hp, jadwal_kerja.shift, user.jabatan
        // FROM
        //     user
        // JOIN 
        //     jadwal_kerja ON user.id = jadwal_kerja.id_user
        // WHERE 
        //     (
        //         (jadwal_kerja.shift = "PS" AND (jadwal_kerja.tanggal = "'.$today.'" AND TIME("'.$current_time.'") BETWEEN "'.$shift_PS_start.'" AND "'.$shift_PS_end.'")) OR
        //         (jadwal_kerja.shift = "M" AND (
        //             (jadwal_kerja.tanggal = "'.$today.'" AND TIME("'.$current_time.'") >= "'.$shift_M_start.'") OR
        //             (DATE_ADD(jadwal_kerja.tanggal, INTERVAL 1 DAY) = "'.$today.'" AND TIME("'.$current_time.'") <= "'.$shift_M_end.'")
        //         ))
        //     ) AND user.type_user != 2 
        // ORDER BY 
        //     CASE 
        //         WHEN user.jabatan = "SPV" THEN 0
        //         ELSE 1
        //     END
        // ')->result_array();

        if (strtotime(date('H:i')) >= strtotime('08:00') && strtotime(date('H:i')) <= strtotime('19:59')) {
            $shift = 'PS';
            // $dateNow = date("Y-m-d");
            $dateNow = date("Y-m-d");
        }
         elseif (strtotime(date('H:i')) >= strtotime('07:30') && strtotime(date('H:i')) <= strtotime('16:29')) {
            $shift = 'D';
            // $dateNow = date("Y-m-d");
            $dateNow = date("Y-m-d");
        }
        else {
            if (strtotime(date('H:i')) >= strtotime('00:01') && strtotime(date('H:i')) <= strtotime('07:59')) {
                //  echo "tanggal kemarin";
                $dateNow = date("Y-m") . '-' . (date("d") - 1);
                // $dateNow = date("Y-m-d")-1;
            } else {
                $dateNow = date("Y-m-d");
            }

            $shift = 'M';
        }

        // echo "<pre>",print_r (),"</pre>";
        $users = $this->Mod->GetCustome(" SELECT b.nama,b.jabatan,b.nik,b.no_hp,a.* FROM jadwal_kerja a left join user b on b.id = a.id_user where a.tanggal ='" . $dateNow . "' and a.shift= '" . $shift . "' AND b.type_user in ('1','5','101','102','107') AND b.unit_kerja ='" . sess()['unit'] . "' ")->result_array();

        $organik = $this->Mod->GetCustome(" SELECT b.nama,b.jabatan,b.nik,b.no_hp,a.* FROM jadwal_kerja a left join user b on b.id = a.id_user where a.tanggal ='" . $dateNow . "' and a.shift= '" . $shift . "' AND b.type_user= '2' AND b.unit_kerja ='" . sess()['unit'] . "'")->result_array();

        $data = [
            'OM'    => $users,
            'FIDS'  =>  $organik
        ];

        echo json_encode($data);
    }

    public function get_next_shift()
    {
        $today = date('Y-m-d');
        $current_time = date('H:i:s');
        $shift_PS_start = '07:00:00';
        $shift_PS_end = '19:00:00';
        $shift_M_start = '19:00:00';
        $shift_M_end = '07:00:00';



        if (strtotime(date('H:i')) >= strtotime('07:00') && strtotime(date('H:i')) <= strtotime('18:59')) {
            $shift = 'M';
            // $dateNow = date("Y-m-d");
            $dateNow = date("Y-m-d");
        } else {
            if (strtotime(date('H:i')) >= strtotime('00:01') && strtotime(date('H:i')) <= strtotime('06:59')) {
                //  echo "tanggal kemarin";
                $dateNow = date("Y-m") . '-' . (date("d") - 1);
                // $dateNow = date("Y-m-d")-1;
            } else {
                $dateNow = date("Y-m-d");
            }

            $shift = 'PS';
        }

        $organik = $this->Mod->GetCustome(" SELECT b.nama,b.jabatan,b.nik,b.no_hp,a.* FROM jadwal_kerja a left join user b on b.id = a.id_user where a.tanggal ='" . $dateNow . "' and a.shift= '" . $shift . "' AND b.type_user= '2' AND b.unit_kerja ='" . sess()['unit'] . "'")->result_array();
        $om = $this->Mod->GetCustome(" SELECT b.nama,b.jabatan,b.nik,b.no_hp,a.* FROM jadwal_kerja a left join user b on b.id = a.id_user where a.tanggal ='" . $dateNow . "' and a.shift= '" . $shift . "' AND b.type_user in ('1','5')  AND b.unit_kerja ='" . sess()['unit'] . "'")->result_array();
        $data = [
            'OM'    => $om,
            'FIDS'  =>  $organik
        ];

        echo json_encode($data);
    }

    public function get_logbook()
    {

        $todayDate = date('Y-m-d');
        $data['CM']     = $this->Mod->GetCustome("SELECT create_date, COUNT(type_tiket) AS jumlah_CM FROM tiket WHERE type_tiket = 2 AND DATE(create_date) = '$todayDate'")->row_array();
        $data['PM']     = $this->Mod->GetCustome("SELECT create_date, COUNT(type_tiket) AS jumlah_PM FROM tiket WHERE type_tiket != 2 AND DATE(create_date) = '$todayDate'")->row_array();
        $data['data']   = $this->Mod->GetCustome("SELECT * FROM logbook 
                                                    WHERE id_unit='" . sess()['unit'] . "' 
                                                    AND shift='" . GetShift()['shift'] . "'
                                                    AND create_date='" . GetShift()['date'] . "' ")->row_array();

        echo json_encode($data);
    }



    public function GetPersentasePerformance()
    {
        //hitung jumlah fasilitas
        $GetFas = $this->Mod->GetCustome("SELECT id_fasilitas FROM fasilitas")->result_array();
        $jumlah_fas = count($GetFas);

        $test = $this->Mod->GetCustome("SELECT id_fasilitas, SUM(TIMESTAMPDIFF(MINUTE, tanggal_mulai, tanggal_selesai)) AS downTime_fasilitas FROM tinjut GROUP BY id_fasilitas")->result_array();
        $testuptime = $this->Mod->GetCustome("SELECT id_fasilitas, (TIMESTAMPDIFF(MINUTE, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH))) AS uptime_fasilitas FROM tinjut GROUP BY id_fasilitas")->result_array();
        $countTest = count($test);
        $TotalPersentase = 0;
        $total_persentase = 0;

        for ($i = 0; $i < $countTest; $i++) {
            $testingPerform[$i]['persentase'] = (($testuptime[$i]['uptime_fasilitas'] - $test[$i]['downTime_fasilitas']) / $testuptime[$i]['uptime_fasilitas']) * 100;
            $TotalPersentase += $testingPerform[$i]['persentase'];
        }

        for ($i = $countTest; $i < $jumlah_fas; $i++) {
            $TotalPersentase += 100;
        }

        $total_persentase = $TotalPersentase / $jumlah_fas;

        echo json_encode(array('total_persentase' => number_format($total_persentase, 1, '.', '')));
    }

    function GetPersonil()
    {
        if (strtotime(date('H:i')) >= strtotime('07:00') && strtotime(date('H:i')) <= strtotime('18:59')) {
            $shift = 'PS';
            $dateNow = date("d");
        } else {
            if (strtotime(date('H:i')) >= strtotime('00:01') && strtotime(date('H:i')) <= strtotime('06:59')) {
                //  echo "tanggal kemarin";
                $dateNow = date("d") - 1;
            } else {
                $dateNow = date("d");
            }

            $shift = 'M';
        }
        $tgl = date('Y-m-d');
        $personil =  $this->Mod->GetCustome("SELECT * FROM `jadwal_kerja` where tanggal='" . $tgl . "' and shift= '" . $shift . "'")->result_array();
    }

    function get_sum_fasilitas()
    {
        $data = array();
        $data =  $this->Mod->getWhere('jenis_perangkat ', array('id_unit' => sess()['unit'], 'status !=' => 8))->result_array();

        foreach ($data as $key => $value) {
            // $ste= $this->Mod->getWhere('perangkat ',array('id_jenisperangkat' => ,'status !=' => 8 ))->num_rows();

            $data[$key]['rekap'] =  $this->Mod->GetCustome("SELECT STATUS, count(id_jenisperangkat) AS total FROM perangkat WHERE id_jenisperangkat ='" . $value['id_jenisperangkat'] . "'  AND STATUS IN ('1','0') GROUP BY status order by status DESC")->result_array();

            // 
            # code...
            // $data[$key]['icon']  = "fa fa-hdd-o f-40 text-mute";
        }
        echo json_encode($data);
    }

    function GetDiviceProblem()
    {
        $data['perangkat'] = $this->Mod->GetCustome("SELECT 
                                            td.id_perangkat,b.nama_perangkat,b.serial_number, COUNT(td.id_perangkat)as jumlah 
                                        FROM 
                                            tinjut_detail td
                                        LEFT JOIN  
                                            perangkat b 
                                        ON  
                                            b.id_perangkat = td.id_perangkat
                                        LEFT JOIN 
                                            tinjut t
                                        ON  
                                            t.id_tinjut = td.id_tinjut
                                        WHERE   
                                        t.id_unit='" . sess()['unit'] . "' 
                                        AND 
                                            td.id_jenisperangkat  not in ('3','4')
                                        GROUP BY
                                            td.id_perangkat,b.nama_perangkat
                                        ORDER BY `jumlah`,`b`.`nama_perangkat` DESC   limit 10")->result_array();

        $data['fasilitas'] = $this->Mod->GetCustome("SELECT 
                                                        a.id_fasilitas,b.nama_fasilitas, COUNT(a.id_fasilitas)as jumlah 
                                                    FROM 
                                                        tinjut a 
                                                    LEFT JOIN 
                                                        fasilitas b 
                                                    on 
                                                        b.id_fasilitas = a.id_fasilitas
                                                    WHERE a.id_unit='" . sess()['unit'] . "' 
                                                    group by 
                                                        a.id_fasilitas,b.nama_fasilitas 
                                                    ORDER BY `jumlah` 
                                                    DESC limit 10")->result_array();
        echo json_encode($data);
    }

    function ListData($id, $jenis_perangkat)
    {



        if (isset($_POST['limit'])) {
            $limit = $_POST['limit'];
        } else {
            // Atur nilai default jika $_POST['limit'] tidak diatur
            $limit = 10;
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
            'table'         => 'perangkat',
            'pk'            => 'id_perangkat',
            'parameter'     => array('status !=' => 8, 'id_unit' => sess()['unit'], 'id_jenisperangkat' => $jenis_perangkat),
            'url'           => $this->uri->segment(2),
            'filter'        => (!empty($jenis) ? array('id_jenisperangkat' => $jenis) : ''),
            'from'          => $from,
            'limit'         => $limit,
            'src'           => $src,
            'param_src'     => [
                'like' => 'nama_perangkat',
                'or_like' => 'serial_number'
            ]
        ];


        $totalData              = CountDataPag($param);
        $param['total_data']    = $totalData;
        $param['total_page']    = ceil($totalData / $limit);

        // echo "<pre>",print_r ($param),"</pre>";
        $res                    = pagin($param);
        foreach ($res['data'] as $key => $value) {
            $jenis          = $this->Mod->getWhere('jenis_perangkat ', array('id_jenisperangkat' => $value['id_jenisperangkat'], 'status !=' => 8))->row_array();
            $fasilitas      = $this->Mod->getWhere('fasilitas_detail', array('id_jenisperangkat' => $value['id_jenisperangkat'], 'id_perangkat' => $value['id_perangkat']))->row_array();
            $merk           = $this->Mod->getWhere('merk ', array('id' => $value['merk_id']))->row_array();
            $model          = $this->Mod->getWhere('model ', array('id_perangkat' => $value['id_model']))->row_array();
            $res['data'][$key]['model'] = $model['nama_perangkat'];
            $res['data'][$key]['merk'] = $merk['nama'];
            $res['data'][$key]['jenis_perangkat'] = $jenis['nama'];
            $res['data'][$key]['status_label'] = sts('2', $value['status']);
            if (!empty($fasilitas)) {
                $res['data'][$key]['id_fasilitas'] = $fasilitas['id_fasilitas'];
            } else {
                $res['data'][$key]['id_fasilitas'] = '';
            }
        }
        $data['fasilitas']  = $res['data'];
        $data['pag']        = $res['pag'];
        echo json_encode($data);
    }

function GetRekapPerfome()
{
    $data = array();
    $id_unit = sess()['unit'];

    // Variabel penunjang perhitungan waktu
    $total_minutes_in_month = date('t') * 24 * 60;
    $current_year = date('Y');
    $is_leap_year = date('L', strtotime("$current_year-01-01"));
    $total_days_in_year = $is_leap_year ? 366 : 365;
    $total_minutes_in_year = $total_days_in_year * 24 * 60;

    // 1. Ambil semua fasilitas yang ada di unit tertentu
    $fasilitas_list = $this->Mod->GetCustome("
        SELECT id_fasilitas, kode, nama_fasilitas 
        FROM fasilitas 
        WHERE id_unit = '$id_unit' 
        AND status = '1'
    ")->result_array();

    // 2. Ambil semua perangkat di unit tersebut
    $perangkat_list = $this->Mod->GetCustome("
        SELECT p.id_perangkat, p.nama_perangkat, fd.id_fasilitas
        FROM perangkat p
        JOIN fasilitas_detail fd ON p.id_perangkat = fd.id_perangkat
        JOIN fasilitas f ON fd.id_fasilitas = f.id_fasilitas
        WHERE f.id_unit = '$id_unit' AND f.status = '1'
        AND LOWER(p.nama_perangkat) != 'listrik'
        GROUP BY p.id_perangkat, p.nama_perangkat, fd.id_fasilitas
    ")->result_array();

    $fasilitas_devices = [];
    foreach($perangkat_list as $p) {
        $fasilitas_devices[$p['id_fasilitas']][] = $p;
    }

    // 3. Tarik data downtime bulanan untuk semua perangkat di unit
    $downtime_bulan_ini = $this->Mod->GetCustome("
        SELECT td.id_perangkat,
               SUM(TIMESTAMPDIFF(MINUTE, tm.tanggal, t.tanggal_selesai)) AS total_downtime,
               MAX(t.status) AS tinjut_status,
               MAX(td.status) AS tinjut_detail_status
        FROM tinjut t
        LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
        LEFT JOIN temuan tm ON tm.id_temuan = t.id_temuan
        WHERE t.id_unit = '$id_unit'
        AND t.status != '8'
        AND MONTH(t.tanggal_mulai) = MONTH(NOW()) 
        AND YEAR(t.tanggal_mulai) = YEAR(NOW())
        GROUP BY td.id_perangkat
    ")->result_array();

    $dt_bulan_map = [];
    foreach($downtime_bulan_ini as $db) {
        if(!empty($db['id_perangkat'])) {
            $dt_bulan_map[$db['id_perangkat']] = $db;
        }
    }

    // 4. Tarik data downtime tahunan untuk semua perangkat di unit
    $downtime_tahun_ini = $this->Mod->GetCustome("
        SELECT td.id_perangkat,
               SUM(TIMESTAMPDIFF(MINUTE, tm.tanggal, t.tanggal_selesai)) AS total_downtime
        FROM tinjut t
        LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
        LEFT JOIN temuan tm ON tm.id_temuan = t.id_temuan
        WHERE t.id_unit = '$id_unit'
        AND t.status != '8'
        AND YEAR(t.tanggal_mulai) = YEAR(NOW())
        GROUP BY td.id_perangkat
    ")->result_array();

    $dt_tahun_map = [];
    foreach($downtime_tahun_ini as $dt) {
        if(!empty($dt['id_perangkat'])) {
            $dt_tahun_map[$dt['id_perangkat']] = $dt;
        }
    }

    $total_unit_performance = 0;
    $fasilitas_count = 0;
    $performa_details = []; // inisialisasi detail performa per-fasilitas/perangkat

    foreach ($fasilitas_list as $fasilitas) {
        $id_fasilitas = $fasilitas['id_fasilitas'];
        $kode_fasilitas = $fasilitas['kode'];
        $nama_fasilitas = $fasilitas['nama_fasilitas'];
        
        $perangkat_di_fasilitas = isset($fasilitas_devices[$id_fasilitas]) ? $fasilitas_devices[$id_fasilitas] : [];
        
        $total_performance_fasilitas = 0;
        $perangkat_count = 0;
        $detail_perangkat_list = [];
        
        foreach ($perangkat_di_fasilitas as $perangkat) {
            $id_perangkat = $perangkat['id_perangkat'];
            $performaperangkat = 100; // Default
            
            $dt_b = isset($dt_bulan_map[$id_perangkat]) ? $dt_bulan_map[$id_perangkat] : null;
            $dt_t = isset($dt_tahun_map[$id_perangkat]) ? $dt_tahun_map[$id_perangkat] : null;
            
            // ID UNIT KHUSUS BULANAN
            if (in_array($id_unit, [14, 15, 16, 17])) {
                $t_status = $dt_b ? $dt_b['tinjut_status'] : null;
                $td_status = $dt_b ? $dt_b['tinjut_detail_status'] : null;
                if (($t_status == 2 || empty($t_status)) && ($td_status == 2 || empty($td_status))) {
                    $performaperangkat = 100;
                } else {
                    $downtime = $dt_b && !empty($dt_b['total_downtime']) ? $dt_b['total_downtime'] : 0;
                    if ($total_minutes_in_month > 0) {
                        $performaperangkat = (($total_minutes_in_month - $downtime) / $total_minutes_in_month) * 100;
                        $performaperangkat = round($performaperangkat, 2);
                    }
                }
            } 
            // ID UNIT KHUSUS TAHUNAN
            elseif (in_array($id_unit, [18, 17, 19, 20, 21, 22, 23])) {
                $downtime = $dt_t && !empty($dt_t['total_downtime']) ? $dt_t['total_downtime'] : 0;
                if ($total_minutes_in_year > 0) {
                    $downtime_percentage = ($downtime / $total_minutes_in_year) * 100;
                    $performaperangkat = round(100 - $downtime_percentage, 2);
                }
            }
            // UMUM BERDASARKAN KODE FASILITAS
            else {
                if ($kode_fasilitas == 1) {
                    $downtime = $dt_t && !empty($dt_t['total_downtime']) ? $dt_t['total_downtime'] : 0;
                    if ($total_minutes_in_year > 0) {
                        $downtime_percentage = ($downtime / $total_minutes_in_year) * 100;
                        $performaperangkat = round(100 - $downtime_percentage, 2);
                    }
                } elseif ($kode_fasilitas == 2) {
                    $t_status = $dt_b ? $dt_b['tinjut_status'] : null;
                    $td_status = $dt_b ? $dt_b['tinjut_detail_status'] : null;
                    if (($t_status == 2 || empty($t_status)) && ($td_status == 2 || empty($td_status))) {
                        $performaperangkat = 100;
                    } else {
                        $downtime = $dt_b && !empty($dt_b['total_downtime']) ? $dt_b['total_downtime'] : 0;
                        if ($total_minutes_in_month > 0) {
                            $performaperangkat = (($total_minutes_in_month - $downtime) / $total_minutes_in_month) * 100;
                            $performaperangkat = round($performaperangkat, 2);
                        }
                    }
                }
            }

            if ($performaperangkat === null) {
                $performaperangkat = 100;
            }
            
            $detail_perangkat_list[] = [
                'nama_perangkat' => $perangkat['nama_perangkat'],
                'performa' => $performaperangkat
            ];
            
            $total_performance_fasilitas += $performaperangkat;
            $perangkat_count++;
        }
        
        $average_performance_perangkat = ($perangkat_count > 0) ? ($total_performance_fasilitas / $perangkat_count) : 100;
        
        $performa_details[] = [
            'nama_fasilitas' => $nama_fasilitas,
            'rata_rata_performa_fasilitas' => round($average_performance_perangkat, 2),
            'perangkat' => $detail_perangkat_list
        ];
        
        $total_unit_performance += $average_performance_perangkat;
        $fasilitas_count++;
    }

    $final_unit_performance = ($fasilitas_count > 0) ? ($total_unit_performance / $fasilitas_count) : 100;
    $final_unit_performance_formatted = number_format(round($final_unit_performance));

    $data['unit_performance'] = array(
        'average_performance' => $final_unit_performance_formatted,
        'total_facilities' => $fasilitas_count
    );

    $data['performa_details'] = $performa_details; // Inject the details into JSON response

    $data['fasilitas'] = [
        [
            'name' => 'Performance',
            'peralatan' => $fasilitas_count,
            'value' => $final_unit_performance_formatted
        ]
    ];

    $data['perangkat'] = $this->Mod->GetCustome("SELECT 
                                                    c.nama as name, 
                                                    count(a.id_fasilitas) as value 
                                                FROM 
                                                        fasilitas_detail a
                                                LEFT JOIN 
                                                    fasilitas b
                                                ON
                                                    b.id_fasilitas =  a.id_fasilitas
                                                LEFT JOIN 
                                                    jenis_perangkat c
                                                ON 
                                                    c.id_jenisperangkat = a.id_jenisperangkat
                                                WHERE 
                                                    b.status ='1' 
                                                AND 
                                                    a.id_fasilitas is not null 
                                                AND 
                                                    a.id_jenisperangkat is not null 
                                                AND 
                                                    a.id_jenisperangkat not in ('0','3','4')
                                                AND
                                                     b.id_unit = " . sess()['unit'] . "
                                                GROUP BY 
                                                    a.id_jenisperangkat,c.nama")->result_array();


    echo json_encode($data);
}

    function GetUmurPerangkat()
    {
        $data['fasilitas'] = $this->Mod->GetCustome("SELECT count(h.tanggal_penggunaan) as jumlah,
                                        YEAR(h.tanggal_penggunaan) as tahun 
                                    FROM 
                                        fasilitas_detail h
                                    Left Join  
                                        fasilitas d
                                    ON
                                        d.id_fasilitas = h.id_fasilitas
                                    WHERE 
                                        h.tanggal_penggunaan is not null 
                                    AND 
                                        YEAR(h.tanggal_penggunaan) !=0 
                                    AND 
                                        h.status != 8
                                    AND 
                                        d.id_unit = " . sess()['unit'] . "
                                    GROUP BY YEAR(h.tanggal_penggunaan)")->result_array();

        echo json_encode($data);
    }


    function SaveImage()
    {
        $this->load->helper('path');
        $data = array_filter($_POST);
        $content = base64_decode($data['gambar']);

        $upload_path = ".";






        $dataURL = $this->input->post('gambar');
        // $dataURL = $_POST["imageData"]; this should send to the hell cause spend long time
        $dataURL = str_replace('data:image/png;base64,', '', $dataURL);
        $dataURL = str_replace(' ', '+', $dataURL);
        $image = base64_decode($dataURL);
        $filename = date("d-m-Y-h-i-s") . '.' . 'png'; //renama file name based on time
        $path = set_realpath('upload/tes/');



        if (!file_exists($path)) {
            @mkdir($path, 0755, true);
        } else {
            echo $path;
        }



        // file_put_contents( $upload_path, $content);
        echo "<pre>", print_r(file_put_contents($path . $filename, $image)), "</pre>";
    }

    function sum_PM()
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
   
         // âœ… TAMBAHAN: cek filter bulan
            if (isset($_POST['bulan'])) {
                $bulan = $_POST['bulan'];
            } else {
                $bulan = '';
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
            'jenis'         => 'GetSUMPM',
            'param_src'     => [
                'like' => 'nama_fasilitas',
                'or_like' => 'ip_address'
            ]
        ];

        $pm_type = $this->Mod->getWhere('pm_type', array('status !=' => 8))->result_array();
        $totalData          = CountDataPag($param);
        $param['total_data'] = $totalData;
        $param['total_page'] = ceil($totalData / $limit);
        $res                = pagin($param);

        $persentase_per_jenis = [
            '2M' => ['rencana' => 0, 'realisasi' => 0],
            '1B' => ['rencana' => 0, 'realisasi' => 0],
            '3B' => ['rencana' => 0, 'realisasi' => 0],
            '6B' => ['rencana' => 0, 'realisasi' => 0],
            'T'  => ['rencana' => 0, 'realisasi' => 0]
        ];
        

        foreach ($res['data'] as $key => $value) {

            $res['data'][$key]['detail'] = $this->Mod->GetCustome("SELECT a.idpm_type, a.kode,
                (
                    SELECT COUNT(b.idpm_type) 
                    FROM jadwal b where b.tahun = 2026 AND b.idpm_type =a.idpm_type and  b.id_fasilitas= '".$value['id_fasilitas']."'
                    " . (!empty($bulan) ? "AND b.bulan = '".$bulan."'" : "") . "
                    AND b.id_unit ='". sess()['unit']."'

                ) as rencana ,
                (
                    select COUNT(c.idpm_type) 
                    from pm c where YEAR(c.tanggal_pm) = 2026 AND c.idpm_type =a.idpm_type and c.id_fasilitas= '".$value['id_fasilitas']."'
                     " . (!empty($bulan) ? "AND MONTH(c.tanggal_pm) = '".$bulan."'" : "") . "
                    and c.status in ('0','1','9')
                    AND c.id_unit ='". sess()['unit']."'
                ) as realisasi,
                (
                    (
                        select COUNT(b.idpm_type) 
                        from jadwal b where  b.tahun = 2026 AND b.idpm_type =a.idpm_type and  b.id_fasilitas= '".$value['id_fasilitas']."'
                        " . (!empty($bulan) ? "AND b.bulan = '".$bulan."'" : "") . "
                        AND b.id_unit ='". sess()['unit']."'

                    )  -
                    (
                        select COUNT(c.idpm_type) 
                        from pm c where YEAR(c.tanggal_pm) = 2026 AND c.idpm_type =a.idpm_type and c.id_fasilitas= '".$value['id_fasilitas']."'
                        " . (!empty($bulan) ? "AND MONTH(c.tanggal_pm) = '".$bulan."'" : "") . "
                        and c.status in ('0','1','9')
                        AND c.id_unit ='". sess()['unit']."'
                    ) 
                ) as sisa
        
                from pm_type a")->result_array();
         // Reset nilai per fasilitas
    $persen_per_fasilitas = [
        '2M' => 0,
        '1B' => 0,
        '3B' => 0,
        '6B' => 0,
        'T'  => 0
    ];

    // Loop detail per jenis PM
    foreach ($res['data'][$key]['detail'] as $d) {
        $kode_pm = strtoupper(trim($d['kode']));
        if (isset($persen_per_fasilitas[$kode_pm])) {
            $rencana = $d['rencana'];
            $realisasi = $d['realisasi'];
            $persentase = ($rencana > 0) ? ($realisasi / $rencana) * 100 : 0;
            $persen_per_fasilitas[$kode_pm] = round($persentase, 2);
        }
    }

    // Tambahkan ke data fasilitas
    foreach ($persen_per_fasilitas as $kode => $nilai) {
        $res['data'][$key]['persentase_' . $kode] = $nilai;
    }
}

        // ðŸ”½ Taruh di sini!
        $data = array();
        $data['fasilitas']  = $res['data'];
        $data['pag']        = $res['pag'];
        echo json_encode($data);
    }
 public function table_PM_persentase(){
        log_message('error', 'table_PM_persentase terpanggil!');
        $limit = $_POST['limit'] ?? 3000;
        $src = $_POST['src'] ?? '';
        $jenis = $_POST['jenis_perangkat'] ?? '';
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
        'jenis'         => 'GetSUMPeresentase',
        'param_src'     => [
            'like' => 'nama_fasilitas',
            'or_like' => 'ip_address'
        ]
    ];

    $pm_type = $this->Mod->getWhere('pm_type', array('status !=' => 8))->result_array();
    $totalData          = CountDataPag($param);
    $param['total_data'] = $totalData;
    $param['total_page'] = ceil($totalData / $limit);
    $res                = pagin($param);

    $FASILITAS= $this->Mod->getWhere('fasilitas', array('status !=' => 8,'id_unit'=> sess()['unit']))->result_array();
    foreach ($FASILITAS as $key => $value) {
  


        $FASILITAS[$key]['detail'] = $this->Mod->GetCustome("
                SELECT 
                a.idpm_type,
                a.kode,
                COUNT(DISTINCT b.id_jadwal) AS rencana,
                COUNT(DISTINCT c.id_pmheader) AS realisasi,
                (COUNT(DISTINCT b.id_jadwal) - COUNT(DISTINCT c.id_pmheader)) AS sisa
            FROM pm_type a
            LEFT JOIN jadwal b 
                ON b.idpm_type = a.idpm_type
                AND b.tahun = 2026
                AND b.id_fasilitas = '".$value['id_fasilitas']."'
                " . (!empty($bulan) ? "AND b.bulan = '".$bulan."'" : "") . "
                AND b.id_unit = '".sess()['unit']."'
            LEFT JOIN pm c 
                ON c.idpm_type = a.idpm_type
                AND YEAR(c.tanggal_pm) = 2026
                AND c.id_fasilitas = '".$value['id_fasilitas']."'
                " . (!empty($bulan) ? "AND MONTH(c.tanggal_pm) = '".$bulan."'" : "") . "
                AND c.id_unit = '".sess()['unit']."'
                AND c.status IN ('0', '1', '9')
            GROUP BY a.idpm_type, a.kode
        
        ")->result_array();
        
    }
    // 
    // $fasilitas = $this->Mod->getWhere('fasilitas', array('status !=' => 8))->result_array();
    
    
    $totalPersen = 0;
    $duaM =0;
    $satuB =0;
    $tigaB =0;
    $enamB =0;
    $satuT =0;
    $total2m = 0;
    $total1b = 0;
    $total3b = 0;
    $total6b = 0;
    $totalT = 0;
    foreach ($FASILITAS as $key => $value) {
        $persen= 0;
            foreach ($value['detail'] as $key2 => $value2) {
             $persen = ($value2['rencana'] != 0) ? (($value2['realisasi'] / $value2['rencana']) * 100) : 0;

                if($value2['idpm_type'] == '2')
                {
                    $total2m= $total2m+$value2['rencana'];
                    $duaM = $duaM +  ($value2['realisasi']);
                  
                }
                else if($value2['idpm_type'] == '7')
                {
                    $total1b= $total1b+$value2['rencana'];
                    $satuB = $satuB + ($value2['realisasi']);
                    
                }
                else if($value2['idpm_type'] == '8')
                {
                    $total3b= $total3b+$value2['rencana'];
                    $tigaB = $tigaB +  ($value2['realisasi']);
                    
                }
                else if($value2['idpm_type'] == '9')
                {
                    $total6b= $total6b+$value2['rencana'];
                    $enamB = $enamB +  ($value2['realisasi']);
                    
                }
               else if($value2['idpm_type']== '10')
                {
                    $totalT= $totalT+$value2['rencana'];
                    $satuT = $satuT + ($value2['realisasi']);
                }
                $FASILITAS[$key]['detail'][$key2]['persentase']= $persen ;
             
            //$totalPersen = $totalPersen +    $persen ;
            }

      
    }

    $data = array();
    

    $data['fasilitas']  = $res['data'];
    $data['pag']        = $res['pag'];
    $data['total_persen'] = $totalPersen;
    $data['total_row'] = $totalData;
    $data['total_realisasi_2m'] = $duaM;
    $data['total_rencana_2m'] = $total2m;
    $data['total_realisasi_1b'] = $satuB;
    $data['total_rencana_1b'] = $total1b;
    $data['total_realisasi_3b'] = $tigaB;
    $data['total_rencana_3b'] = $total3b;
    $data['total_realisasi_6b'] = $enamB;
    $data['total_rencana_6b'] = $total6b;
    $data['total_realisasi_t'] = $satuT;
    $data['total_rencana_t'] = $totalT;
    $data['total_selisih_2m'] = $total2m - $duaM;
    $data['total_selisih_1b'] = $total1b - $satuB;
    $data['total_selisih_3b'] = $total3b - $tigaB;
    $data['total_selisih_6b'] = $total6b - $enamB;
    $data['total_selisih_t'] = $totalT - $satuT;
    $data['all_persen'] = $totalPersen /$totalData;
    $data['persentase']['2m'] = array(
    'persen' => ($total2m != 0) ? (($duaM / $total2m) * 100) : 0,
    'total' => $total2m
);

$data['persentase']['1b'] = array(
    'persen' => ($total1b != 0) ? (($satuB / $total1b) * 100) : 0,
    'total' => $total1b
);

$data['persentase']['3b'] = array(
    'persen' => ($total3b != 0) ? (($tigaB / $total3b) * 100) : 0,
    'total' => $total3b
);

$data['persentase']['6b'] = array(
    'persen' => ($total6b != 0) ? (($enamB / $total6b) * 100) : 0,
    'total' => $total6b
);

$data['persentase']['t'] = array(
    'persen' => ($totalT != 0) ? (($satuT / $totalT) * 100) : 0,
    'total' => $totalT
);

    $data['fasilitas'] = $FASILITAS;
    echo json_encode($data);

}




public function total_perawatan_perbulan() {
    // Mendapatkan parameter
    $bulan = $this->input->post('bulan') ?? date('m');
    $limit = $_POST['limit'] ?? 3000;
    $src = $_POST['src'] ?? '';
    $jenis = $_POST['jenis_perangkat'] ?? '';
    error_log('ðŸŽ¯ Bulan: ' . $bulan);
    
    // Counter untuk setiap jenis PM
    $persentase_per_jenis = [
        '2M' => ['rencana' => 0, 'realisasi' => 0],
        '1B' => ['rencana' => 0, 'realisasi' => 0],
        '3B' => ['rencana' => 0, 'realisasi' => 0],
        '6B' => ['rencana' => 0, 'realisasi' => 0],
        'T'  => ['rencana' => 0, 'realisasi' => 0]
    ];

    // Mengambil data fasilitas atau data lainnya yang diperlukan untuk pemrosesan
    $res = $this->Mod->getWhere('fasilitas', array('status !=' => 8,'id_unit'=> sess()['unit']))->result_array();


    // Periksa apakah data fasilitas ditemukan
    if(empty($res)) {
        echo json_encode(['status' => 'error', 'message' => 'Data fasilitas tidak ditemukan.']);
        return;
    }

    // Inisialisasi total variabel untuk masing-masing tipe PM
    $totalPersen = 0;
    $duaM = 0;
    $satuB = 0;
    $tigaB = 0;
    $enamB = 0;
    $satuT = 0;
    $total2m = 0;
    $total1b = 0;
    $total3b = 0;
    $total6b = 0;
    $totalT = 0;

    // Mengambil data fasilitas
    foreach ($res as $key => $value) {
        // Query untuk mendapatkan detail per jenis PM
        $res[$key]['detail'] = $this->Mod->GetCustome("
            SELECT 
                a.idpm_type,
                a.kode,
                COUNT(DISTINCT b.id_jadwal) AS rencana,
                COUNT(DISTINCT c.id_pmheader) AS realisasi,
                (COUNT(DISTINCT b.id_jadwal) - COUNT(DISTINCT c.id_pmheader)) AS sisa
            FROM pm_type a
            LEFT JOIN jadwal b 
                ON b.idpm_type = a.idpm_type
                AND b.tahun = 2026
                AND b.id_fasilitas = '".$value['id_fasilitas']."'
                " . (!empty($bulan) ? "AND b.bulan = '".$bulan."'" : "") . "
                AND b.id_unit = '".sess()['unit']."'
            LEFT JOIN pm c 
                ON c.idpm_type = a.idpm_type
                AND YEAR(c.tanggal_pm) = 2026
                AND c.id_fasilitas = '".$value['id_fasilitas']."'
                " . (!empty($bulan) ? "AND MONTH(c.tanggal_pm) = '".$bulan."'" : "") . "
                AND c.id_unit = '".sess()['unit']."'
                AND c.status IN ('0', '1', '9')
            GROUP BY a.idpm_type, a.kode
        ")->result_array();

        // Reset nilai per fasilitas
        $persen_per_fasilitas = [
            '2M' => 0,
            '1B' => 0,
            '3B' => 0,
            '6B' => 0,
            'T'  => 0
        ];

        // Loop detail per jenis PM
        foreach ($res[$key]['detail'] as $d) {
            $kode_pm = strtoupper(trim($d['kode']));
            if (isset($persen_per_fasilitas[$kode_pm])) {
                $rencana = $d['rencana'];
                $realisasi = $d['realisasi'];
                // Menghitung persentase hanya jika rencana lebih dari 0
                $persentase = ($rencana > 0) ? ($realisasi / $rencana) * 100 : 0;
                // Membulatkan hasil persentase
                $persen_per_fasilitas[$kode_pm] = round($persentase, 2);

                // Menambahkan perhitungan ke total berdasarkan jenis PM
                if ($kode_pm == '2M') {
                    $total2m += $rencana;
                    $duaM += $realisasi;
                } else if ($kode_pm == '1B') {
                    $total1b += $rencana;
                    $satuB += $realisasi;
                } else if ($kode_pm == '3B') {
                    $total3b += $rencana;
                    $tigaB += $realisasi;
                } else if ($kode_pm == '6B') {
                    $total6b += $rencana;
                    $enamB += $realisasi;
                } else if ($kode_pm == 'T') {
                    $totalT += $rencana;
                    $satuT += $realisasi;
                }
            }
        }

        // Menambahkan persentase per jenis PM ke dalam data fasilitas
        foreach ($persen_per_fasilitas as $kode => $nilai) {
            $res[$key]['persentase_' . $kode] = $nilai;
        }
    }

    // Membuat array realisasi yang akan dikirimkan ke view
    $realisasi = [
        '2M' => ['rencana' => $total2m, 'realisasi' => $duaM, 'deviasi' => $total2m - $duaM, 'persentase' => ($total2m > 0) ? round(($duaM / $total2m) * 100, 2) : 0],
        '1B' => ['rencana' => $total1b, 'realisasi' => $satuB, 'deviasi' => $total1b - $satuB, 'persentase' => ($total1b > 0) ? round(($satuB / $total1b) * 100, 2) : 0],
        '3B' => ['rencana' => $total3b, 'realisasi' => $tigaB, 'deviasi' => $total3b - $tigaB, 'persentase' => ($total3b > 0) ? round(($tigaB / $total3b) * 100, 2) : 0],
        '6B' => ['rencana' => $total6b, 'realisasi' => $enamB, 'deviasi' => $total6b - $enamB, 'persentase' => ($total6b > 0) ? round(($enamB / $total6b) * 100, 2) : 0],
        'T' => ['rencana' => $totalT, 'realisasi' => $satuT, 'deviasi' => $totalT - $satuT, 'persentase' => ($totalT > 0) ? round(($satuT / $totalT) * 100, 2) : 0],
    ];

    $data = [
        'realisasi' => $realisasi
    ];

    // Mengirimkan data ke dalam format JSON
    echo json_encode($data);
}





}
