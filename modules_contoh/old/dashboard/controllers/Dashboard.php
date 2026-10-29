<?php
// application/modules/req_open/controllers/Req_open.php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {

    public function __construct() {
        parent::__construct();
        // Load library atau helper yang diperlukan
        $this->load->library('javascript');
        $this->load->model('Dashboard_m');
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

        $data["title"]      = "Dashboard";
        $nama_sesi = $this->session->userdata('nama');
        $data["title_des"]  = "Selamat datang " . $nama_sesi . "!";
        
        $data["data"]       = $data;

        if (sess()['unit'] == 1) {
            $data["content"]    = "Dashboard_v";
        }elseif (sess()['unit'] == 2) {
            $data["content"]    = "Dashboard_v";
        }elseif (sess()['unit'] == 3) {
            $data["content"]    = "Dashboard_cctv";
        }else{
            $data["content"]    = "";
        }
       
        $this->load->view('template_v2', $data);
    }
    
    public function get_data()
    {
        $data = $this->Dashboard_m->get_data();
        echo json_encode($data);
    }

    public function get_monitor_count() {

        $this->db->where('id_jenisperangkat', 1); // Filter untuk mendapatkan data monitor (id_jenisperangkat = 1)
        $this->db->where('status', 0);
        $jumlah_monitor = $this->db->count_all_results('perangkat'); // Menghitung jumlah baris yang memenuhi kriteria

        //tambahan untuk count data 
        $count = $this->Mod->GetCustome("SELECT status,COUNT(status) AS total FROM perangkat where id_jenisperangkat = 1 group by status")->result_array();

        $data = array('monitor_count' => $jumlah_monitor,'data' => $count);
        echo json_encode($data);
    }

    public function get_minipc_count() {

        $this->db->where('id_jenisperangkat', 2); 
        $this->db->where('status', 0);
        $jumlah_minipc = $this->db->count_all_results('perangkat'); 

        $count = $this->Mod->GetCustome("SELECT status,COUNT(status) AS total FROM perangkat where id_jenisperangkat = 2 group by status")->result_array();

        $data = array('minipc_count' => $jumlah_minipc,'data' => $count);
        echo json_encode($data);
    }

    public function get_fasilitas_count() {

        $this->db->where('status', 1);
        $this->db->where('id_unit', sess()['unit']);
        $jumlah_fasilitas = $this->db->count_all_results('fasilitas'); 
        $data = array('fasilitas_count' => $jumlah_fasilitas);
        echo json_encode($data);
    }

    public function getPersentase_Indikator(){

        $data['monitor']    = $this->Mod->GetCustome('SELECT COUNT(id_jenisperangkat) AS jumlahMonitor FROM logbook WHERE id_jenisperangkat = 1 AND create_date >= NOW() - INTERVAL 1 MONTH')->row_array();
        $data['pc']         = $this->Mod->GetCustome('SELECT COUNT(id_jenisperangkat) AS jumlahPC FROM logbook WHERE id_jenisperangkat = 2 AND create_date >= NOW() - INTERVAL 1 MONTH')->row_array();
        $data['jaringan']   = $this->Mod->GetCustome('SELECT COUNT(id_jenisperangkat) AS jumlahJaringan FROM logbook WHERE id_jenisperangkat = 3 AND create_date >= NOW() - INTERVAL 1 MONTH')->row_array();
        $data['listrik']    = $this->Mod->GetCustome('SELECT COUNT(id_jenisperangkat) AS jumlahListrik FROM logbook WHERE id_jenisperangkat = 4 AND create_date >= NOW() - INTERVAL 1 MONTH')->row_array();

        $data['total'] = $this->Mod->GetCustome('SELECT COUNT(*) AS total FROM logbook WHERE create_date >= NOW() - INTERVAL 1 MONTH')->row_array();

        echo json_encode($data);
    }

    function GetPersentase_repair(){
        $data ['all'] = $this->Mod->GetCustome("SELECT 
        COUNT(a.id_jenisperangkat) as jumlah,b.nama 
        FROM 
            logbook a 
        LEFT JOIN 
            jenis_perangkat b 
        ON 
            b.id_jenisperangkat = a.id_jenisperangkat
        where 
            b.id_unit in ('0','".sess()['unit']."')
        GROUP BY
         a.id_jenisperangkat")->result_array();
        
        echo json_encode($data);
        
    }

    public function get_top5_data() {

        $data   = $this->Mod->GetCustome('SELECT a.*, b.nama_fasilitas, c.kode_unit, d.nama_terminal, COUNT(a.id_fasilitas) AS jumlah
        FROM logbook a 
        LEFT JOIN fasilitas b ON b.id_fasilitas = a.id_fasilitas 
        LEFT JOIN unit c ON c.id_unit = b.id_unit
        LEFT JOIN terminal d ON b.id_lokasi = d.id 
        WHERE a.create_date >= NOW() - INTERVAL 1 MONTH
        GROUP BY a.id_fasilitas ORDER BY jumlah DESC LIMIT 10')->result_array();
        echo json_encode($data);
    }

    public function get_users() {
        $today = date('Y-m-d');
        $current_time = date('H:i:s');
        $shift_PS_start = '07:00:00';
        $shift_PS_end = '19:00:00';
        $shift_M_start = '19:00:00';
        $shift_M_end = '07:00:00';
    
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

        if (strtotime(date('H:i')) >= strtotime('07:00') && strtotime(date('H:i')) <= strtotime('18:59')  ) {
            $shift ='PS';
            // $dateNow = date("Y-m-d");
            $dateNow = date("Y-m-d");
        }else{
            if (strtotime(date('H:i')) >= strtotime('00:01') && strtotime(date('H:i')) <=strtotime('06:59')) {
              //  echo "tanggal kemarin";
                $dateNow = date("Y-m").'-'.(date("d")-1);
                // $dateNow = date("Y-m-d")-1;
            }else {
                $dateNow = date("Y-m-d");
            }
           
            $shift ='M';
        }

        // echo "<pre>",print_r (),"</pre>";
        $users = $this->Mod->GetCustome(" SELECT b.nama,b.jabatan,b.nik,b.no_hp,a.* FROM jadwal_kerja a left join user b on b.id = a.id_user where a.tanggal ='".$dateNow."' and a.shift= '".$shift."' AND b.type_user in ('1','5') AND b.unit_kerja ='".sess()['unit']."' ")->result_array();
        
        $organik = $this->Mod->GetCustome(" SELECT b.nama,b.jabatan,b.nik,b.no_hp,a.* FROM jadwal_kerja a left join user b on b.id = a.id_user where a.tanggal ='".$dateNow."' and a.shift= '".$shift."' AND b.type_user= '2' AND b.unit_kerja ='".sess()['unit']."'")->result_array();
        
        $data =[
            'OM'    => $users,
            'FIDS'  =>  $organik
        ];

        echo json_encode($data); 
    }
    
    public function get_next_shift() {
        $today = date('Y-m-d');
        $current_time = date('H:i:s');
        $shift_PS_start = '07:00:00';
        $shift_PS_end = '19:00:00';
        $shift_M_start = '19:00:00';
        $shift_M_end = '07:00:00';
    
        

        if (strtotime(date('H:i')) >= strtotime('07:00') && strtotime(date('H:i')) <= strtotime('18:59')  ) {
            $shift ='M';
            // $dateNow = date("Y-m-d");
            $dateNow = date("Y-m-d");
        }else{
            if (strtotime(date('H:i')) >= strtotime('00:01') && strtotime(date('H:i')) <=strtotime('06:59')) {
              //  echo "tanggal kemarin";
                $dateNow = date("Y-m").'-'.(date("d")-1);
                // $dateNow = date("Y-m-d")-1;
            }else {
                $dateNow = date("Y-m-d");
            }
           
            $shift ='PS';
        }

        $organik = $this->Mod->GetCustome(" SELECT b.nama,b.jabatan,b.nik,b.no_hp,a.* FROM jadwal_kerja a left join user b on b.id = a.id_user where a.tanggal ='".$dateNow."' and a.shift= '".$shift."' AND b.type_user= '2' AND b.unit_kerja ='".sess()['unit']."'")->result_array();
        $om = $this->Mod->GetCustome(" SELECT b.nama,b.jabatan,b.nik,b.no_hp,a.* FROM jadwal_kerja a left join user b on b.id = a.id_user where a.tanggal ='".$dateNow."' and a.shift= '".$shift."' AND b.type_user in ('1','5')  AND b.unit_kerja ='".sess()['unit']."'")->result_array();
        $data =[
            'OM'    => $om,
            'FIDS'  =>  $organik
        ];

        echo json_encode($data); 
    }

    public function get_logbook() {

        $todayDate = date('Y-m-d');
        $data['CM'] = $this->Mod->GetCustome("SELECT create_date, COUNT(type_tiket) AS jumlah_CM FROM tiket WHERE type_tiket = 2 AND DATE(create_date) = '$todayDate'")->row_array();
        $data['PM'] = $this->Mod->GetCustome("SELECT create_date, COUNT(type_tiket) AS jumlah_PM FROM tiket WHERE type_tiket != 2 AND DATE(create_date) = '$todayDate'")->row_array();

        echo json_encode($data);
    }



    public function GetPersentasePerformance(){

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

        $total_persentase = $TotalPersentase / $jumlah_fas;

       echo json_encode(array('total_persentase' => number_format($total_persentase, 1, '.', '')));
    }

    function GetPersonil(){
        if (strtotime(date('H:i')) >= strtotime('07:00') && strtotime(date('H:i')) <= strtotime('18:59')  ) {
            $shift ='PS';
            $dateNow = date("d");
       }else{
            if (strtotime(date('H:i')) >= strtotime('00:01') && strtotime(date('H:i')) <=strtotime('06:59')) {
              //  echo "tanggal kemarin";
                $dateNow = date("d")-1;
            }else {
                $dateNow = date("d");
            }
           
            $shift ='M';
       }
        $tgl = date('Y-m-d');
        $personil=  $this->Mod->GetCustome("SELECT * FROM `jadwal_kerja` where tanggal='".$tgl."' and shift= '".$shift."'" )->result_array();
    }

    function get_sum_fasilitas(){
        $data =array();
        $data =  $this->Mod->getWhere('jenis_perangkat ',array('id_unit' => sess()['unit'],'status !=' => 8 ))->result_array();
       
        foreach ($data as $key => $value) {
            // $ste= $this->Mod->getWhere('perangkat ',array('id_jenisperangkat' => ,'status !=' => 8 ))->num_rows();
         $data[$key]['rekap'] =  $this->Mod->GetCustome("SELECT STATUS, count(id_jenisperangkat) AS total FROM perangkat WHERE id_jenisperangkat ='".$value['id_jenisperangkat']."' GROUP BY status order by status DESC")->result_array();
            # code...
            // $data[$key]['icon']  = "fa fa-hdd-o f-40 text-mute";
        }
        echo json_encode($data);
    }
}