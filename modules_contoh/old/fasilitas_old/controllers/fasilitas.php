<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Fasilitas extends CI_Controller {

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
        $data["title"] = "Fasilitas";
        $data["title_des"] = " List Data Fasilitas";
        $data["content"] = "v_index";

        $data["data"] = $data;

        $this->load->view('template_v2', $data);
        // echo "<pre>",print_r ( $this->session->userdata()),"</pre>";
    }

    
    function LoadData(){
        //$data= $this->position();
        // $acc  = access($data,"VIEW")['access'];
      
        // Periksa apakah $_POST['limit'] sudah diatur
        if(isset($_POST['limit'])) {
            $limit = $_POST['limit'];
        } else {
            // Atur nilai default jika $_POST['limit'] tidak diatur
            $limit = 3000; 
        }
      
        $from = $this->uri->segment(3);
      
        $data['url'] = $this->uri->segment(2);
        $totalData = $this->Mod->CountData('fasilitas', 'id_fasilitas', array('status !=' => 8))->num_rows();
        // $data['totalpage'] = ceil($totalData/10);
        // $data['total'] = $totalData;
        $res = pagin('fasilitas', 'id_fasilitas', array('status !=' => 8), $this->uri->segment(2), $limit, $from, ceil($totalData/$limit));
        $data['fasilitas'] = $res['data'];
        $data['pag'] = $res['pag'];
    
        
        //  $data_res['perangkat'] = $this->Mod->GetCustome('SELECT a.*,b.nama as jenis_perangkat FROM perangkat a left join jenis_perangkat b on b.id_jenisperangkat = a.id_jenisperangkat where a.status != 8')->result_array();
       
        echo json_encode($data);
    }
    

    function performa($id=null){
        $data["plugin"][]   = "plugin/datatable";
        $data["plugin"][]   = "plugin/select2";
        $data["title"]      = "Fasilitas";
        $data["title_des"]  = " Performa Fasilitas";
        $data["content"]    = "v_performa";
        $data['id']         = $id;
       
        $data["data"] = $data;
       
        $this->load->view('template_v2', $data);
    }


    function LoadDataAnl($id=null){
        $perangkat                       = $this->m_data->getWhere('perangkat',array('id_perangkat' => $id))->row_array();
        if (!empty($perangkat['nama_perangkat'])) {
            $lokasi                          =  $this->m_data->getWhere('terminal',array('id' => $perangkat['id_perangkat']))->row_array();
            $perangkat['nama_perangkat']        =  (!empty($perangkat['nama_perangkat']) ? $perangkat['nama_perangkat']: '');
        }else{
            $perangkat['nama_perangkat']        =  (!empty($lokasi['nama_perangkat']) ? $lokasi['nama_perangkat']: '');
        }
        // $result['data']=  $data;
        $todayDate = date('Y-m-d');
        $logHistory = $this->Mod->GetCustome(" SELECT * FROM logbook WHERE id_fasilitas = '".$id."'
                                        ")->result_array();
 
                                             // WHERE 
                                             // DATE(tj.date_start) = '$todayDate'
    
        // Menyimpan data log history ke dalam variabel $data
        $result['LogHistory'] = $logHistory;
        // Mengemas semua data ke dalam satu array
    
        // $result['data'] = $data;

        $downtime = $this->Mod->GetCustome("SELECT SUM(TIMESTAMPDIFF(MINUTE, date_start, update_date)) AS total_downTime FROM tinjut WHERE update_date >= NOW() - INTERVAL 1 MONTH AND date_start >= NOW() - INTERVAL 1 MONTH")->row_array();
         $uptime = $this->Mod->GetCustome("SELECT (TIMESTAMPDIFF(MINUTE, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH)) * (SELECT COUNT(*) FROM fasilitas)) AS uptime")->row_array();
         
         $totaldowntime = $downtime['total_downTime'];
         $totaluptime = $uptime['uptime'];
         $performa = ($totaluptime - $totaldowntime) / $totaluptime * 100;

         $performa_formatted = number_format(round($performa)); // Format nilai bulat ke 2 angka desimal dan tambahkan '%' di akhir
         $result['perfomChart'] = array('Performa' => round($performa)); // Bulatkan ke 2 angka desimal
         $result['perfomChart'] = array('Performa' => $performa_formatted); // Simpan nilai yang sudah diformat

         
        $result['perfomPie'] =array('Display OFF' => 30,'HDMI' => 10, 'Kamera Rusak' =>20, 'Listrik OFF' =>20, 'Jaringan Bermasalah' =>20);
      
        $result['perangkat']=  $perangkat;
        echo json_encode($result);
    }

    
    function Loadmasterdetail($id){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
      
        $data = $this->m_data->getWhere('master_perangkat_detail',array('id_jenisperangkat' =>$id,'status !=' => 8 ))->result_array();
        echo json_encode($data);
    }

     

    function LoadDataJP(){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
       
         $data= $this->Mod->getData('jenis_perangkat')->result_array();
       
        echo json_encode($data);
    }

    function LoadDataPerangkat($id){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
       
         $data= $this->m_data->getWhere('perangkat',array('status' =>0,'id_unit' => sess()['unit'],'id_jenisperangkat' => $id))->result_array();
       
        echo json_encode($data);
    }
    function LoadDataPerangkatByID($id){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
       
         $data= $this->m_data->getWhere('fasilitas_detail',array('id_fasilitas' =>$id))->result_array();
         foreach ($data as $key => $value) {
            $detail=  $this->m_data->getWhere('perangkat',array('id_perangkat' => $value['id_perangkat']))->row_array();
           
            $data[$key]['detail'] = $detail;
        }
        
       
        echo json_encode($data);
    }
    
    function GetLokasi(){
        //$data= $this->Mod->getData('terminal')->result_array();
        $data= $this->Mod->getWhere('terminal',array('parent_id' =>-1))->result_array();
        echo json_encode($data);
    }
    function GetArea($idlokasi){
        $data= $this->Mod->getWhere('terminal',array('parent_id' =>$idlokasi))->result_array();
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
        unset($data['Newitems']);
        if (!empty($data)) {
            $data['id_unit']    = sess()['unit']; 
            $data['status']     = 0;
            $this->db->insert('fasilitas',$data);
            $id = $this->db->insert_id();
            if (!empty($_POST['Newitems'])) {
				
				foreach ($_POST['Newitems'] as $key => $value) {
					
					$perangkat=[

						'id_fasilitas' 		=>  $id,
						'id_perangkat' 		=>  $value['id_perangkat'],
						'id_jenisperangkat'	=> $value['id_jenisperangkat'], 
						'status' 			=> 1,
					];
                    $this->db->insert('fasilitas_detail',$perangkat);
                    // echo "<pre>",print_r ( $perangkat),"</pre>";
				}	
				
			}
        }
        // echo "<pre>",print_r ( $data),"</pre>";

       
    }

    function EditData($id=null){
        $data=$this->Mod->GetCustome("SELECT a.*,b.kode_unit as unit FROM fasilitas a left join unit b on b.id_unit =a.id_unit  where a.id_fasilitas = '".$id."'")->row_array();
       
        echo json_encode($data);
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

}