<?php
// application/modules/req_open/controllers/Req_open.php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dash extends MX_Controller {

    public function __construct() {
        parent::__construct();
        // Load library atau helper yang diperlukan
        $this->load->library('javascript');
    }
    
    private function role() {

        $url = urlencode(current_url());

        if (session("username") == "") {
            redirect(base_url('login/auth'));
        }
    }

    private function position() {
        $data["param"] = http_build_query($_GET);
        $data["position"] = "home";

        return $data;
    }


    public function index() {
        $this->role();
        $data = $this->position();
        $data["plugin"][]   = "plugin/datatable";
        $data["plugin"][]   = "plugin/select2";
        $data["title"]      = "Dashboard";
        
        $nama_sesi = $this->session->userdata('nama');
        $data["title_des"]  = "Selamat datang " . $nama_sesi . "!";
    
        $data["content"]    = "v_index";
        $data["data"]       = $data;
        
        $this->load->model('M_dash');
        $this->load->view('template_v2', $data);
    }

    public function get_data()
    {
        $this->load->model('M_dash');
        $data = $this->M_dash->get_data();
        echo json_encode($data);
    }

    public function get_top5_data() {
        // $data   = $this->Mod->GetCustome('SELECT a.*, b.nama_fasilitas, c.kode_unit, d.nama_terminal
        // FROM tiket a 
        // LEFT JOIN fasilitas b ON b.id_fasilitas = a.id_fasilitas 
        // LEFT JOIN unit c ON c.id_unit = a.id_unit
        // LEFT JOIN terminal d ON a.id_lokasi = d.id
        // WHERE a.status NOT IN (8, 0, 2, 5, 9)')->result_array();
        // foreach ($data as $key => $value) {
        //    $data[$key ]['no_tiket']=  TKTNum( $value['id_tiket']);
        //    $data[$key ]['label_status']=  st($value['status']);
           
        // } 
        // echo json_encode($data);

        $data   = $this->Mod->GetCustome('SELECT a.*, b.nama_fasilitas, c.kode_unit, d.nama_terminal, COUNT(a.id_fasilitas) AS jumlah
        FROM logbook a 
        LEFT JOIN fasilitas b ON b.id_fasilitas = a.id_fasilitas 
        LEFT JOIN unit c ON c.id_unit = b.id_unit
        LEFT JOIN terminal d ON b.id_lokasi = d.id 
        WHERE a.create_date >= NOW() - INTERVAL 1 MONTH
        GROUP BY a.id_fasilitas ORDER BY jumlah DESC LIMIT 10')->result_array();

        echo json_encode($data);
    }

    public function get_monitor_count() {
        $this->db->where('id_jenisperangkat', 1); // Filter untuk mendapatkan data monitor (id_jenisperangkat = 1)
        $this->db->where('status', 0);
        $jumlah_monitor = $this->db->count_all_results('perangkat'); // Menghitung jumlah baris yang memenuhi kriteria
        $data = array('monitor_count' => $jumlah_monitor);
        echo json_encode($data);
    }

    public function get_minipc_count() {
        $this->db->where('id_jenisperangkat', 2); 
        $this->db->where('status', 0);
        $jumlah_minipc = $this->db->count_all_results('perangkat'); 
        $data = array('minipc_count' => $jumlah_minipc);
        echo json_encode($data);
    }


    public function getPersentase_Indikator(){
        $data['monitor']  = $this->Mod->GetCustome('SELECT COUNT(id_jenisperangkat) AS jumlahMonitor FROM logbook WHERE id_jenisperangkat = 1 AND create_date >= NOW() - INTERVAL 1 MONTH')->row_array();
        $data['pc']  = $this->Mod->GetCustome('SELECT COUNT(id_jenisperangkat) AS jumlahPC FROM logbook WHERE id_jenisperangkat = 2 AND create_date >= NOW() - INTERVAL 1 MONTH')->row_array();
        $data['jaringan']  = $this->Mod->GetCustome('SELECT COUNT(id_jenisperangkat) AS jumlahJaringan FROM logbook WHERE id_jenisperangkat = 3 AND create_date >= NOW() - INTERVAL 1 MONTH')->row_array();
        $data['listrik']  = $this->Mod->GetCustome('SELECT COUNT(id_jenisperangkat) AS jumlahListrik FROM logbook WHERE id_jenisperangkat = 4 AND create_date >= NOW() - INTERVAL 1 MONTH')->row_array();

        $data['total'] = $this->Mod->GetCustome('SELECT COUNT(*) AS total FROM logbook WHERE create_date >= NOW() - INTERVAL 1 MONTH')->row_array();

        echo json_encode($data);
    }

    public function get_users() {
        $today = date('Y-m-d');
        $current_time = date('H:i:s');
        $shift_PS_start = '07:00:00';
        $shift_PS_end = '19:00:00';
        $shift_M_start = '19:00:00';
        $shift_M_end = '07:00:00';
    
        $users = $this->Mod->GetCustome('
        SELECT
            user.nama, user.nik, user.no_hp, user.foto, jadwal_kerja.shift, user.jabatan
        FROM
            user
        JOIN 
            jadwal_kerja ON user.id = jadwal_kerja.id_user
        WHERE 
            (
                (jadwal_kerja.shift = "PS" AND (jadwal_kerja.tanggal = "'.$today.'" AND TIME("'.$current_time.'") BETWEEN "'.$shift_PS_start.'" AND "'.$shift_PS_end.'")) OR
                (jadwal_kerja.shift = "M" AND (
                    (jadwal_kerja.tanggal = "'.$today.'" AND TIME("'.$current_time.'") >= "'.$shift_M_start.'") OR
                    (DATE_ADD(jadwal_kerja.tanggal, INTERVAL 1 DAY) = "'.$today.'" AND TIME("'.$current_time.'") <= "'.$shift_M_end.'")
                ))
            )
        ORDER BY 
            CASE 
                WHEN user.jabatan = "SPV" THEN 0
                ELSE 1
            END
        ')->result_array();
        echo json_encode($users); 
    }
    
    

    public function get_logbook() {

        $todayDate = date('Y-m-d');

    //     $data = $this->Mod->GetCustome("SELECT 
    //     lb.*,
    //     t.*,
    //     ter.nama_terminal,
    //     fas.nama_fasilitas,
    //     fas.id_unit AS fasilitas_id_unit,
    //     fas.id_lokasi,
    //     fas.id_sublokasi AS fasilitas_id_sublokasi,
    //     tj.update_date,
    //     tj.date_start
    // FROM 
    //     logbook lb
    // JOIN 
    //     tiket t ON lb.id_fasilitas = t.id_fasilitas
    // JOIN 
    //     terminal ter ON t.id_unit = ter.id
    // JOIN 
    //     fasilitas fas ON t.id_fasilitas = fas.id_fasilitas
    // JOIN
    //     tinjut tj ON t.id_tiket = tj.id_tiket
    // WHERE 
    //     DATE(tj.date_start) = '$todayDate'
    // GROUP BY
    //     t.no_tiket;
    // ")->result_array();

    // $res = $this->Mod->GetCustome('SELECT b.*, c.nama_masalah, d.nama AS nama_JP
    //         FROM tinjut a
    //         LEFT JOIN tinjut_detail b ON a.id_tinjut = b.id_tinjut
    //         LEFT JOIN jenis_masalah c ON b.id_jenismasalah = c.id
    //         LEFT JOIN jenis_perangkat d ON d.id_jenisperangkat = b.id_jenisperangkat')->result_array();
        
    //     $count_res = count($res);
    //     $data['tambahan'] = $res;

    //     $data['count'] = $count_res;

        $data['CM'] = $this->Mod->GetCustome("SELECT create_date, COUNT(type_tiket) AS jumlah_CM FROM tiket WHERE type_tiket = 2 AND DATE(create_date) = '$todayDate'")->row_array();
        $data['PM'] = $this->Mod->GetCustome("SELECT create_date, COUNT(type_tiket) AS jumlah_PM FROM tiket WHERE type_tiket != 2 AND DATE(create_date) = '$todayDate'")->row_array();

        echo json_encode($data);
    }



    public function GetPersentasePerformance(){
        // $downtime = $this->Mod->GetCustome("SELECT SUM(TIMESTAMPDIFF(MINUTE, date_start, update_date)) AS total_downTime FROM tinjut WHERE update_date >= NOW() - INTERVAL 1 MONTH AND date_start >= NOW() - INTERVAL 1 MONTH")->row_array();
        // $uptime = $this->Mod->GetCustome("SELECT (TIMESTAMPDIFF(MINUTE, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH))) AS Waktu_UP")->row_array();

        // $GetFas = $this->Mod->GetCustome("SELECT id_fasilitas FROM fasilitas")->result_array();
        // $jumlah_fas = count($GetFas);

        // $totaldowntime = $downtime['total_downTime'];
        //$totaluptime = $uptime['Waktu_UP'] * $jumlah_fas;
        //$performa = ($totaluptime - $totaldowntime) / $totaluptime * 100;

        $GetFas = $this->Mod->GetCustome("SELECT id_fasilitas FROM fasilitas")->result_array();
        $jumlah_fas = count($GetFas);
        $test = $this->Mod->GetCustome("SELECT id_fasilitas, SUM(TIMESTAMPDIFF(MINUTE, date_start, update_date)) AS downTime_fasilitas FROM tinjut GROUP BY id_fasilitas")->result_array();
        $testuptime = $this->Mod->GetCustome("SELECT id_fasilitas, (TIMESTAMPDIFF(MINUTE, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH))) AS uptime_fasilitas FROM tinjut GROUP BY id_fasilitas")->result_array();
        $countTest = count($test);
        $TotalPersentase = 0;
        $total_persentase = 0;

        for ($i=0; $i < $countTest; $i++) { 
            $testingPerform[$i]['persentase'] = (($testuptime[$i]['uptime_fasilitas'] - $test[$i]['downTime_fasilitas']) / $testuptime[$i]['uptime_fasilitas']) * 100;
            $TotalPersentase += $testingPerform[$i]['persentase'];
        }

        for ($i=$countTest; $i < $jumlah_fas; $i++) { 
            $TotalPersentase += 100;
        }

        // $totaluptime = $uptime['Waktu_UP'] * $countTest;
        // $performa = ($totaluptime - $totaldowntime) / $totaluptime * 100;
        
        $total_persentase = $TotalPersentase / $jumlah_fas;
        //$total_persentase = $TotalPersentase / $countTest;
        //$total_persentase = $testingPerform[0]['persentase'];


         //echo json_encode(array('performa' => number_format($performa, 1, '.', '')));
       // echo json_encode($performa);
        // echo json_encode($TotalPersentase);
        // echo json_encode($testingPerform);
        // echo json_encode($total_persentase);
       echo json_encode(array('total_persentase' => number_format($total_persentase, 1, '.', '')));
    }

    public function get_stock() {
        $perangkat_status = $this->Mod->GetCustome("SELECT id_perangkat, id_jenisperangkat, kategori_aset_id, id_unit, nama_perangkat, merk_id, serial_number, status FROM perangkat WHERE status = 3")->result_array();
    
        $count_perangkat = count($perangkat_status);
    
        $count_monitor = $this->Mod->GetCustome("SELECT COUNT(*) FROM perangkat WHERE status = 3 AND id_jenisperangkat = 1")->row_array()['COUNT(*)'];
    
        $count_minipc = $this->Mod->GetCustome("SELECT COUNT(*) FROM perangkat WHERE status = 3 AND id_jenisperangkat = 2")->row_array()['COUNT(*)'];
    
        // Ambil nama perangkat dengan status 3
        $nama_perangkat = '';
        if (!empty($perangkat_status)) {
            $nama_perangkat = $perangkat_status[0]['nama_perangkat']; // Ambil nama perangkat pertama
        }
    
        echo json_encode(array(
            'total_perangkat' => $count_perangkat,
            'detail_monitor_stock' => $count_monitor,
            'detail_mini_pc_stock' => $count_minipc,
            'nama_perangkat' => $nama_perangkat // Sertakan nama perangkat dalam respons JSON
        ));

    }

    public function get_perangkat_stock() {
        $perangkat_status = $this->Mod->GetCustome("SELECT nama_perangkat, serial_number FROM perangkat WHERE status = 3")->result_array();
        
        echo json_encode(array(
            'perangkat' => $perangkat_status
        ));
    }

    public function get_monitor_stock() {
        $perangkat_status = $this->Mod->GetCustome("SELECT nama_perangkat, serial_number FROM perangkat WHERE status = 3 AND id_jenisperangkat = 1")->result_array();
        
        echo json_encode(array(
            'perangkat' => $perangkat_status
        ));
    }
    
    public function get_minipc_stock() {
        $perangkat_status = $this->Mod->GetCustome("SELECT nama_perangkat, serial_number FROM perangkat WHERE status = 3 AND id_jenisperangkat = 2")->result_array();
        
        echo json_encode(array(
            'perangkat' => $perangkat_status
        ));
    }
 

}