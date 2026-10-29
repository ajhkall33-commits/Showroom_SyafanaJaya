<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Komponen extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->library('excel');
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
        $data["title"] = "Komponen";
        $data["title_des"] = "Daftar Komponen";
        $data["content"] = "v_index";

        $data["data"] = $data;

        $this->load->view('template_v2', $data);
        $menu = fetch_menu();
        // foreach ($menu as $key => $value) {
        //     if (count($value['sub']) > 0 ) {
        //        echo "ada turunan";
        //     }else{
        //         echo "tidak";
        //     }

        // }
        // echo "<pre>",print_r ($menu ),"</pre>";
    }

    
    function LoadData(){
        // SK Manager: filter unit dinamis (dropdown atau semua unit yang dikelola)
        $unit_with_global_sql = get_unit_filter_sql('unit', true);
        
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $nama_komponen = $this->input->post('nama_komponen');

        $cond_masuk_awal = "1=0"; // Default: no awal
        $cond_masuk_periode = "1=1"; // Default: all is periode
        $cond_terpakai_awal = "1=0";
        $cond_terpakai_periode = "1=1";

        if (!empty($bulan) && !empty($tahun)) {
            $date_start = "$tahun-$bulan-01";
            $cond_masuk_awal = "tanggal < '$date_start'";
            $cond_masuk_periode = "MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'";
            
            $cond_terpakai_awal = "DATE(t.tanggal_selesai) < '$date_start'";
            $cond_terpakai_periode = "MONTH(t.tanggal_selesai) = '$bulan' AND YEAR(t.tanggal_selesai) = '$tahun'";
        } elseif (!empty($tahun)) {
            $date_start = "$tahun-01-01";
            $cond_masuk_awal = "tanggal < '$date_start'";
            $cond_masuk_periode = "YEAR(tanggal) = '$tahun'";
            
            $cond_terpakai_awal = "DATE(t.tanggal_selesai) < '$date_start'";
            $cond_terpakai_periode = "YEAR(t.tanggal_selesai) = '$tahun'";
        }

        $where_nama = "";
        if (!empty($nama_komponen)) {
            $where_nama = " AND a.nama_komponen LIKE '%" . $this->db->escape_like_str($nama_komponen) . "%' ";
        }

        $sql = "
            SELECT 
                a.*, 
                b.nama,  
                b.id_unit as unit,
                COALESCE(km.stok_awal_masuk, 0) as stok_awal_masuk,
                COALESCE(km.masuk_periode, 0) as masuk_periode,
                COALESCE(kt.stok_awal_terpakai, 0) as stok_awal_terpakai,
                COALESCE(kt.terpakai_periode, 0) as terpakai_periode
            FROM komponen a 
            LEFT JOIN jenis_perangkat b ON a.id_jenisperangkat = b.id_jenisperangkat 
            LEFT JOIN (
                SELECT id_komponen, 
                    SUM(CASE WHEN $cond_masuk_awal THEN satuan_masuk ELSE 0 END) as stok_awal_masuk,
                    SUM(CASE WHEN $cond_masuk_periode THEN satuan_masuk ELSE 0 END) as masuk_periode
                FROM komponen_masuk 
                WHERE status != 8 
                GROUP BY id_komponen
            ) km ON km.id_komponen = a.id_komponen
            LEFT JOIN (
                SELECT kt.id_komponen, 
                    SUM(CASE WHEN $cond_terpakai_awal THEN kt.satuan_terpakai ELSE 0 END) as stok_awal_terpakai,
                    SUM(CASE WHEN $cond_terpakai_periode THEN kt.satuan_terpakai ELSE 0 END) as terpakai_periode
                FROM komponen_terpakai kt
                LEFT JOIN tinjut t ON t.id_tinjut = kt.id_tinjut
                WHERE kt.status != 8 
                GROUP BY kt.id_komponen
            ) kt ON kt.id_komponen = a.id_komponen
            WHERE a.status != 8 and COALESCE(b.id_unit, a.id_unit, 0) $unit_with_global_sql $where_nama 
            ORDER BY b.id_jenisperangkat ASC
        ";

        $data_res = $this->Mod->GetCustome($sql)->result_array();
        
        foreach ($data_res as $key => $value) {
            $update_unit =[
                'id_unit'   => $value['unit']
            ];

            $this->m_data->updateData('komponen',array('id_komponen' =>$value['id_komponen'] ), $update_unit);
            
            $data_res[$key]['label_status'] = master_status($value['status']); 
            
            $stok_awal = $value['stok_awal_masuk'] - $value['stok_awal_terpakai'];
            $stok_akhir = $stok_awal + $value['masuk_periode'] - $value['terpakai_periode'];
            
            $data_res[$key]['stok_awal'] = $stok_awal;
            $data_res[$key]['stok_akhir'] = $stok_akhir;
        } 
        
        $data['data'] = $data_res;
        echo json_encode($data);
    }

    function LoadDataParent(){
        $unit = sess()['unit'];
        // SK Manager: jika role terdaftar di role_sk_manager, tampilkan data dari semua unit yang dikelola
        $unit_with_global_sql = "IN ('0','$unit')";
        if (is_sk_manager()) {
            $sk_units = get_allowed_units();
            if (!empty($sk_units)) {
                $unit_with_global_sql = "IN (0," . implode(',', $sk_units) . ")";
            }
        }
         $data_res['perangkat'] = $this->Mod->GetCustome("SELECT * FROM jenis_perangkat  WHERE status != 8 and id_unit $unit_with_global_sql")->result_array();
         
         //$data_res['masalah']    = $this->Mod->getJoin('jenis_masalah','jenis_perangkat','status')->result_array();
         echo json_encode($data_res);
    }
   
    
    function EditData($id=null){
        if (!empty($id)) {
            $data = $this->m_data->getWhere('komponen',array('id_komponen' =>$id ))->row_array();
            echo json_encode($data);
        }else{
            echo "kosong";
        }
    }

    public function Update($id=null)
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
            
        $data=array_filter($_POST);

        if (!empty($data)) {
            // if (!array_key_exists('id_jenisperangkat', $data)) {
            //    $data['id_jenisperangkat'] ='-1';
            // }
            $res_update = $this->m_data->updateData('komponen',array('id_komponen' =>$id ), $data);
            if ($res_update) {
                $res=[
                    'status' => '200',
                    'msg'       => 'Data Berhasil di Update'
                ];
            }else{
                $res=[
                    'status'    => '400',
                    'msg'       => 'Data Gagal Disimpan, pastikan semua terisi'
                ];
            }
            echo json_encode($res);
        }else{
            $res=[
                'status'    => '400',
                'msg'       => 'Data Gagal Disimpan, pastikan semua terisi'
            ];
            echo json_encode($res);
        }
        
    }

    public function SaveData()
    {

        $data=array_filter($_POST);
        //$data['id_jenisperangkat'] = $data['id_jenisperangkat'];
        if (!empty($data)) {
            if (!array_key_exists('id_jenisperangkat', $data)) {
                $data['id_jenisperangkat'] ='-1';
             }
            $this->db->insert('komponen',$data);
            $res=[
                'status' => '200',
                'msg'       => 'Data Berhasil di Update'
            ];

            // echo "<pre>",print_r ( $data),"</pre>";
            echo json_encode($res);
        }else{
            $res=[
                'status'    => '400',
                'msg'       => 'Data Gagal Disimpan, pastikan semua terisi'
            ];
            echo json_encode($res);
        }
        
       
        
    }

    public function Delete($id=null){
        //$this->m_data->delete('komponen', array('id_komponen' =>$id ));
        $data = [
            'status'        => 8,
        ];
        $res_update = $this->m_data->updateData('komponen',array('id_komponen' =>$id ), $data);
    }

    function LoadDataJM(){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
       
         $data= $this->Mod->getData('komponen')->result_array();
       
        echo json_encode($data);
    }

    function LoadDataByid($id=null){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
       if (!empty($id)) {
            $data = $this->Mod->getWhere('komponen',array('status !=' =>8, 'id_jenisperangkat' => $id))->result_array();
       }else{
        $data=array();
       }
      
        echo json_encode($data);
    }

    public function SaveDataAjax()
    {
        $nama = $this->input->post('nama_komponen');
        $id_jenisperangkat = $this->input->post('id_jenisperangkat');
        
        if (!empty($nama) && !empty($id_jenisperangkat)) {
            // Check if already exists (case insensitive)
            $cek = $this->Mod->GetCustome("SELECT id_komponen FROM komponen WHERE LOWER(nama_komponen) = LOWER('". $this->db->escape_str($nama) ."') AND id_jenisperangkat = '$id_jenisperangkat' AND status != 8")->row_array();
            
            if ($cek) {
                echo json_encode([
                    'status' => '200',
                    'id' => $cek['id_komponen'],
                    'msg' => 'Data sudah ada'
                ]);
            } else {
                $data = [
                    'nama_komponen' => $nama,
                    'id_jenisperangkat' => $id_jenisperangkat,
                    'id_unit' => sess()['unit'],
                    'status' => 1
                ];
                $this->db->insert('komponen', $data);
                $id = $this->db->insert_id();
                
                echo json_encode([
                    'status' => '200',
                    'id' => $id,
                    'msg' => 'Data berhasil ditambahkan'
                ]);
            }
        } else {
            echo json_encode([
                'status' => '400',
                'msg' => 'Data tidak lengkap'
            ]);
        }
    }

   
   
}