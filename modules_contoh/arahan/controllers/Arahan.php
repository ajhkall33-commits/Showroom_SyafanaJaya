<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Arahan extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Excel');
        $this->load->model("m_data");
    }

    public function index()
    {
      
      
       
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "WO Arahan (Kerja)";
        $data["title_des"] = "WO (Arahan Kerja)";
        $data["content"] = "v_index";

        $data["data"] = $data;
              $data['unit'] = $this->Mod->getWhere('unit', array('status !=' => 8))->result_array();
        $this->load->view('template_v2', $data);
        $menu = fetch_menu();
    }



    // Fungsi menampilkan data dari database ke tabel view
    function LoadData()
    {
        // SK Manager: filter unit dinamis berdasarkan pilihan dropdown atau semua unit yang dikelola
        $unit_filter_sql = get_unit_filter_sql('filter_unit');

        $status = $this->input->post('status');
        $tanggal = $this->input->post('tanggal');

        $whereStatus = " AND a.status != 8";
        if ($status !== null && $status !== '') {
            $whereStatus = " AND a.status = " . $this->db->escape($status);
        } else {
            $whereStatus = " AND a.status IN ('0', '1', '2', '9')";
        }

        $whereTanggal = "";
        if (!empty($tanggal)) {
            $whereTanggal = " AND DATE(a.tanggal) = " . $this->db->escape($tanggal);
        }

        $data = $this->Mod->GetCustome("
            SELECT a.*, b.name_unit
            FROM arahan a
            LEFT JOIN unit b ON b.id_unit = a.id_unit
            WHERE 1=1
            $whereStatus
            $whereTanggal
            AND a.id_unit $unit_filter_sql
            ORDER BY a.id_arahan DESC
        ")->result_array();

        foreach ($data as $key => $value) {
            $data[$key]['tanggal_label'] = Hari_($value['tanggal']) . ' ' . tgl($value['tanggal'], 'sm');
        }
        
        echo json_encode($data);
    }



    // function ListData(){
    //     $data = $this->m_data->getWhere('unit',array('status !='=> 8))->result_array(); 

    //     echo json_encode($data);
    // }



//     function LoadDataParent(){   
//         $data_res['ms'] =$this->m_data->getWhere('unit',array('id_unit' =>'-1' ))->result_array();
//        echo json_encode($data_res);
//    }
  
   
   // Fungsi menampilkan data di field saat akan melakukan edit
function EditData($id=null){
    if (!empty($id)) {
        // Ambil data arahan berdasarkan id_arahan
        $data = $this->Mod->getWhere('arahan', array('id_arahan' => $id))->row_array();
        echo json_encode($data);
    } else {
        $res = [
            'code' => '400',
            'msg' => 'ID tidak valid'
        ];
        echo json_encode($res);
    }
}

// Fungsi update data ke database
public function UpdateData($id=null)
{
    $data = array_filter($_POST);
    
    if (!empty($data)) {
        // Siapkan data untuk update sesuai struktur tabel arahan
        $data_to_update = [
            'id_unit'    => sess()['unit'],
            'nomor'      => isset($data['nomor']) ? $data['nomor'] : NULL,
            'deskripsi'  => isset($data['deskripsi']) ? $data['deskripsi'] : NULL,
            'tanggal'    => isset($data['tanggal']) ? $data['tanggal'] : NULL
            // Status tidak diupdate karena sudah ada di SaveData
        ];
        
        // Update data ke database
        $res_update = $this->Mod->update2('arahan', array('id_arahan' => $id), $data_to_update);  
        
        if ($res_update) {
            $res = [
                'status' => '200',  // Konsisten dengan SaveData
                'msg'    => 'Data Berhasil di Update'
            ];
        } else {
            $res = [
                'status' => '400',
                'msg'    => 'Data Gagal Diupdate'
            ];
        }
        echo json_encode($res);
    } else {
        $res = [
            'status' => '400',
            'msg'    => 'Data Gagal Disimpan, pastikan semua terisi'
        ];
        echo json_encode($res);
    }  
}



   // Fungsi sava data ke database
  public function SaveData()
{
    $data = array_filter($_POST);
    
    if (!empty($data)) {
     
        $data_to_insert = [
            'id_unit'    => sess()['unit'],
            'nomor'      => isset($data['nomor']) ? $data['nomor'] : NULL,
            'deskripsi'  => isset($data['deskripsi']) ? $data['deskripsi'] : NULL,
            'tanggal'    => isset($data['tanggal']) ? $data['tanggal'] : NULL,
            'status'     => 0
        ];
        
        // Insert ke database
        $this->db->insert('arahan', $data_to_insert);
        
        $res = [
            'status' => '200',
            'msg'    => 'Data Berhasil disimpan',
            'id'     => $this->db->insert_id()
        ];
        
        echo json_encode($res);
    } else {
        $res = [
            'status' => '400',
            'msg'    => 'Data Gagal Disimpan, pastikan semua terisi'
        ];
        echo json_encode($res);
    }
}



   function Delete($id=null){
    $data = ['status' => 8];
    // Gunakan id_arahan sebagai kondisi WHERE
    $res_update = $this->Mod->update2('arahan', array('id_arahan' => $id), $data);  
   
    $res = [
        'code' => '200',
        'msg' => 'Data Berhasil di Hapus'
    ];
    echo json_encode($res);
}

    function ProsesData($id = null)
    {
        if (!empty($id)) {
            $data = ['status' => 1];
            $res = $this->Mod->update2('arahan', array('id_arahan' => $id), $data);
            if ($res) {
                $res_json = [
                    'code' => '200',
                    'status' => '200',
                    'msg' => 'Data Berhasil di Proses'
                ];
            } else {
                $res_json = [
                    'code' => '400',
                    'status' => '400',
                    'msg' => 'Data Gagal di Proses'
                ];
            }
            echo json_encode($res_json);
        } else {
            echo json_encode(['code' => '400', 'status' => '400', 'msg' => 'ID tidak valid']);
        }
    }
}