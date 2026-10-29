<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class perangkat extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('excel');
        $this->load->model("m_data");
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
        $data["title"] = "Perangkat FIDS";
        $data["title_des"] = " List Data Perangkat FIDS";
        $data["content"] = "v_index";
        // $limit = 10;
        // $from = $this->uri->segment(3);
       
        // $data['pagin'] = pagin('perangkat','id_perangkat',array('status !=' => 8),$this->uri->segment(1),$limit,$from);
        $data["data"] = $data;

        $this->load->view('template_v2', $data);
        //  echo "<pre>",print_r ( $data),"</pre>";
    }

    
    function LoadData($from=null){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
        $limit =$_POST['limit'];
        $from = $this->uri->segment(3);
      
        $data['url']= $this->uri->segment(2);
        $totalData= $this->Mod->CountData('perangkat','id_perangkat',array('status !=' => 8))->num_rows();
       
        $res = pagin('perangkat','id_perangkat',array('status !=' => 8),$this->uri->segment(2),$limit,$from,ceil($totalData/$limit));
        $data['perangkat']  = $res['data'];
        $data['pag'] = $res['pag'];

        
        //  $data_res['perangkat'] = $this->Mod->GetCustome('SELECT a.*,b.nama as jenis_perangkat FROM perangkat a left join jenis_perangkat b on b.id_jenisperangkat = a.id_jenisperangkat where a.status != 8')->result_array();
       
        echo json_encode($data);
    }

    function LoadDataDetail($id=null){
        
        $data_res['detail'] = $this->Mod->GetCustome('SELECT a.*,b.nama as property FROM perangkat_detail a left JOIN master_perangkat_detail b on b.idmaster_detail_perangkat = a.idmaster_detail_perangkat Where  a.id_perangkat = \''.$id.'\'')->result_array();
        echo json_encode($data_res);
    }

    function LoadDataByid($id){
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
            p.id_perangkat = $id
    ")->result_array();
        // $data_res['detail'] = $this->m_data->getWhere('perangkat_detail',array('id_perangkat' =>$id ))->result_array();
        echo json_encode($data_res);
    }

    function LoadDataAnl($id=null){


        $fasilitas                           = $this->m_data->getWhere('fasilitas',array('id_fasilitas' => $id))->row_array();
        if (!empty($fasilitas['id_lokasi'])) {
            $lokasi                          =  $this->m_data->getWhere('terminal',array('id' => $fasilitas['id_lokasi']))->row_array();
            $fasilitas['nama_lokasi']        =  (!empty($lokasi['nama_terminal']) ? $lokasi['nama_terminal']: '');
        }else{
            $fasilitas['nama_lokasi']        =  (!empty($lokasi['nama_terminal']) ? $lokasi['nama_terminal']: '');
        }
        if (!empty($fasilitas['id_sublokasi'])) {
            $sub_lokasi                      =  $this->m_data->getWhere('terminal',array('id' => $fasilitas['id_sublokasi']))->row_array();
            $fasilitas['nama_sublokasi']     =  (!empty($sub_lokasi['nama_terminal']) ? $sub_lokasi['nama_terminal']: '');
        }else{
            $fasilitas['nama_sublokasi']     =  (!empty($sub_lokasi['nama_terminal']) ? $sub_lokasi['nama_terminal']: '');
        }

       if (!empty($fasilitas['id_unit'])) {
            $unit                      =  $this->m_data->getWhere('unit',array('id_unit' => $fasilitas['id_unit']))->row_array();
            $fasilitas['nama_unit']     =  (!empty($unit['kode_unit']) ? $unit['kode_unit']: '');
        }else{
            $fasilitas['nama_unit']     =  (!empty($unit['kode_unit']) ? $unit['kode_unit']: '');
        }
       
       $todayDate = date('Y-m-d');
       $logHistory = $this->Mod->GetCustome(" SELECT * FROM logbook WHERE id_fasilitas = '".$id."'
                                       ")->result_array();

                                            // WHERE 
                                            // DATE(tj.date_start) = '$todayDate'
   
       // Menyimpan data log history ke dalam variabel $data
       $result['LogHistory'] = $logHistory;
       // Mengemas semua data ke dalam satu array
      



         // Hitung performa dan tambahkan ke dalam objek $result
         $downtime = $this->Mod->GetCustome("SELECT SUM(TIMESTAMPDIFF(MINUTE, date_start, update_date)) AS total_downTime FROM tinjut WHERE id_fasilitas = '".$id."' AND update_date >= NOW() - INTERVAL 1 MONTH AND date_start >= NOW() - INTERVAL 1 MONTH")->row_array();
         //$uptime = $this->Mod->GetCustome("SELECT (TIMESTAMPDIFF(MINUTE, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH)) * (SELECT COUNT(*) FROM fasilitas)) AS uptime")->row_array();
         $uptime = $this->Mod->GetCustome("SELECT TIMESTAMPDIFF(MINUTE, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH)) AS uptime")->row_array();

         //echo "<pre>",print_r (  $uptime),"</pre>";

        if(empty($downtime['total_downTime'])){
            $downtime['total_downTime'] = 0;
        }

         $totaldowntime = $downtime['total_downTime'];
         $totaluptime = $uptime['uptime'];
         $performa = ($totaluptime - $totaldowntime) / $totaluptime * 100;

         $performa_formatted = number_format(round($performa)); // Format nilai bulat ke 2 angka desimal dan tambahkan '%' di akhir
         $result['perfomChart'] = array('Performa' => round($performa)); // Bulatkan ke 2 angka desimal
         $result['perfomChart'] = array('Performa' => $performa_formatted); // Simpan nilai yang sudah diformat
         
        //  $result['perfomChart'] = array($performa); 
        //  $result['perfomChart'] =array ('Performa' => $performa);

        
        $data['url']= $this->uri->segment(2);
        $totalData= $this->Mod->CountData('perangkat','id_perangkat',array('status !=' => 8))->num_rows();
    //     $tabel = $this->Mod->GetCustome("
    //     SELECT 

    //         p.id_perangkat,
    //         p.status as status_perangkat,
    //         p.nama_perangkat,
    //         u.kode_unit,
    //         f.ip_address,
    //         p.serial_number,
    //         f.status,
    //         l.create_date,
    //         m.nama AS merk_nama
    //     FROM 
    //         perangkat p
    //     LEFT JOIN 
    //         unit u ON p.id_unit = u.id_unit 
    //     LEFT JOIN 
    //         fasilitas f ON f.id_fasilitas = p.nama_perangkat 
    //     LEFT JOIN 
    //         logbook l ON l.id_perangkat = p.id_perangkat
    //     LEFT JOIN
    //         merk m ON m.id = p.merk_id
    //     WHERE
    //         p.id_perangkat = $id
    // ")->result_array();

    $tabel = $this->Mod->GetCustome("
        SELECT 
            p.id_perangkat,
            p.nama_perangkat, 
            p.status as status_perangkat,
            u.kode_unit,
            f.ip_address,
            p.serial_number,
            f.status,
            l.create_date,
            m.nama AS merk_nama,
            jp.nama AS nama_jp
        FROM 
            fasilitas_detail fd
        LEFT JOIN
            perangkat p ON fd.id_perangkat = p.id_perangkat
        LEFT JOIN 
            unit u ON p.id_unit = u.id_unit
        LEFT JOIN
            fasilitas f ON fd.id_fasilitas = f.id_fasilitas
        LEFT JOIN
            (
                SELECT id_perangkat, MAX(create_date) AS max_create_date
                FROM logbook
                GROUP BY id_perangkat
            ) l_max ON l_max.id_perangkat = p.id_perangkat
        LEFT JOIN
            logbook l ON l.id_perangkat = p.id_perangkat AND l.create_date = l_max.max_create_date
        LEFT JOIN
            merk m ON m.id = p.merk_id
        LEFT JOIN
            jenis_perangkat jp ON jp.id_jenisperangkat = p.id_jenisperangkat
        WHERE
            fd.id_fasilitas = $id
        GROUP BY
            fd.id_perangkat
        ORDER BY
            l.create_date DESC
    ")->result_array();


    // Mengemas data ke dalam array result
    $result['tabel-data'] = $tabel;
        
       

      //mengambil detail fasilitas untuk di cari jenis perangkat
      $fp= $this->Mod->GetCustome("SELECT id_fasilitas, id_jenisperangkat, status FROM `fasilitas_detail` WHERE id_fasilitas = '".$id."' group by id_fasilitas, id_jenisperangkat, status;")->result_array();
         $total= $this->m_data->getWhere('logbook',array('id_fasilitas' =>$id ))->num_rows();
         $result['perangkat'][] = $this->Mod->GetCustome("SELECT a.*,b.nama as jenis_perangkat FROM perangkat a left join jenis_perangkat b on b.id_jenisperangkat = a.id_jenisperangkat left join fasilitas_detail c on c.id_jenisperangkat = b.id_jenisperangkat where a.status != 8 and c.id_fasilitas = '".$id."' ")->result_array();
           
        foreach ( $fp  as $key => $value) {
            $jf = $this->m_data->getWhere('jenis_perangkat',array('id_jenisperangkat' => $value['id_jenisperangkat']))->row_array();
            $totalData=$this->Mod->GetCustome("SELECT COUNT(id_jenisperangkat) AS total FROM logbook WHERE id_fasilitas = '".$value['id_fasilitas']."' AND id_jenisperangkat = '".$value['id_jenisperangkat']."' AND create_date >= NOW() - INTERVAL 1 MONTH")->row_array();
            $persen = ($total != 0 ? round(($totalData['total'] / max(1, $total)) * 100) : 0);
            

             $result['ProgressData'][] =[
                'name' =>  $jf['nama'],
                'value' =>   $persen ,
                'class'     => log_status($persen),
                'totaldata' => $total,
                'totaljenis' => $totalData['total']
             ];

        }


        // Mengemas semua data ke dalam satu array
      
        $result['fasilitas']=  $fasilitas;
        echo json_encode($result);
    }


    function Loadmasterdetail($id){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
      
        $data = $this->m_data->getWhere('master_perangkat_detail',array('id_jenisperangkat' =>$id,'status !=' => 8 ))->result_array();
        echo json_encode($data);
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

    function SaveData(){
        $data=array_filter($_POST);
        if (!empty($data)) {
            $data['status'] = 0;
            $data['id_unit'] =sess()['unit'];
            $this->db->insert('perangkat',$data);
        }
    }

    function SaveDataDetail($id=null){
        $data=array_filter($_POST);
        if (!empty($data)) {
            $data['id_perangkat'] = $id;
            $data['status'] = 0;
            $this->db->insert('perangkat_detail',$data);
        }
    }

    function performPerangkat($id=null){
        if (!empty($id)) {
            $data["plugin"][] = "plugin/datatable";
            $data["plugin"][] = "plugin/select2";
            $data["title"] = "Fasilitas";
            $data["title_des"] = " Perangkat Detail Page";
            $data["content"] = "v_performa";
            // $limit = 10;
            // $from = $this->uri->segment(3);
           
            // $data['pagin'] = pagin('perangkat','id_perangkat',array('status !=' => 8),$this->uri->segment(1),$limit,$from);
            $data["data"] = $data;
    
            $this->load->view('template_v2', $data);
        }
    }
}