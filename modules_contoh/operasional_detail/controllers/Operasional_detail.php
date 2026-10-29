<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Operasional_detail extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Excel');
        $this->load->model("m_data");
     
    }

    public function index()
    {
        $data["plugin"][] = "plugin/datatable";
      
        $data["plugin"][] = "plugin/datepicker";
        $data["title"] = "Operasional Detail";
        $data["title_des"] = "Detail Operasional";
        $data["content"] = "v_index";

        $data['unit'] = $this->Mod->getWhere('unit', array('status !=' => 8))->result_array();
        // $data['operasional'] = $this->Mod->getWhere('operasional', array('status !=' => 8))->result_array();
        
        $this->load->view('template_v2', $data);
    }

    function LoadData()
    {
        // SK Manager: filter unit dinamis berdasarkan pilihan dropdown atau semua unit yang dikelola
        $unit_filter_sql = get_unit_filter_sql('filter_unit');
        
        // Ambil parameter filter dari POST/GET
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $status = $this->input->post('status');
        
        // Query dasar
        $query = "
            SELECT od.*, 
                u.name_unit
            FROM operasional_detail od
            LEFT JOIN unit u ON u.id_unit = od.id_unit
            WHERE od.id_unit $unit_filter_sql";
        
        if ($status !== null && $status !== '') {
            $query .= " AND od.status = " . $this->db->escape_str($status);
        } else {
            $query .= " AND od.status != 8";
        }
        
        // Tambahkan filter tanggal jika ada
        if (!empty($start_date) && !empty($end_date)) {
            $query .= " AND od.tanggal BETWEEN '" . $this->db->escape_str($start_date) . "' AND '" . $this->db->escape_str($end_date) . "'";
        } elseif (!empty($start_date)) {
            $query .= " AND od.tanggal >= '" . $this->db->escape_str($start_date) . "'";
        } elseif (!empty($end_date)) {
            $query .= " AND od.tanggal <= '" . $this->db->escape_str($end_date) . "'";
        }
        
        $query .= " ORDER BY od.id_operasional_detail DESC";
        
        
        
        $data = $this->Mod->GetCustome($query)->result_array();

        foreach ($data as $key => $value) {
            $data[$key]['tanggal_label'] = Hari_($value['tanggal']) . ' ' . tgl($value['tanggal'], 'sm');
            $data[$key]['jam_mulai_label'] = !empty($value['jam_mulai']) ? date('H:i', strtotime($value['jam_mulai'])) : '';
            $data[$key]['jam_selesai_label'] = !empty($value['jam_selesai']) ? date('H:i', strtotime($value['jam_selesai'])) : '';
        }
        
        echo json_encode($data);
    }

    function EditData($id=null){
        if (!empty($id)) {
            $data = $this->Mod->getWhere('operasional_detail', array('id_operasional_detail' => $id))->row_array();
            echo json_encode($data);
        } else {
            $res = [
                'code' => '400',
                'msg' => 'ID tidak valid'
            ];
            echo json_encode($res);
        }
    }

    public function UpdateData($id=null)
    {
        $data = array_filter($_POST);
        
        // Validasi required fields TAMBahan
        if (empty($_POST['tanggal']) || empty($_POST['deskripsi'])) {
            $res = [
                'status' => '400',
                'msg'    => 'Tanggal dan Deskripsi wajib diisi'
            ];
            echo json_encode($res);
            return;
        }

        if (!empty($data)) {
            $data_to_update = [
                'id_unit'        => sess()['unit'],
                'tanggal'        => isset($data['tanggal']) ? $data['tanggal'] : NULL,
                'jam_mulai'      => isset($data['jam_mulai']) ? $data['jam_mulai'] : NULL,
                'jam_selesai'    => isset($data['jam_selesai']) ? $data['jam_selesai'] : NULL,
                'deskripsi'      => isset($data['deskripsi']) ? $data['deskripsi'] : NULL
            ];
            
            $res_update = $this->Mod->update2('operasional_detail', array('id_operasional_detail' => $id), $data_to_update);  
            
            if ($res_update) {
                $res = [
                    'status' => '200',
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

   public function SaveData()
{
    $data = array_filter($_POST);
    
    // Validasi required fields TAMBahan
    if (empty($_POST['tanggal']) || empty($_POST['deskripsi'])) {
        $res = [
            'status' => '400',
            'msg'    => 'Tanggal dan Deskripsi wajib diisi'
        ];
        echo json_encode($res);
        return;
    }
    
    if (!empty($data)) {
        $data_to_insert = [
            'id_operasional' => isset($data['id_operasional']) ? $data['id_operasional'] : NULL,
            'id_unit'        => sess()['unit'],
            'tanggal'        => $_POST['tanggal'],  // Langsung pakai $_POST karena sudah divalidasi
            'jam_mulai'      => isset($data['jam_mulai']) ? $data['jam_mulai'] : NULL,
            'jam_selesai'    => isset($data['jam_selesai']) ? $data['jam_selesai'] : NULL,
            'deskripsi'      => $_POST['deskripsi'], // Langsung pakai $_POST karena sudah divalidasi
            'status'         => 0
        ];
        
        $this->db->insert('operasional_detail', $data_to_insert);
        
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


    // Fungsi untuk mengubah status menjadi 1 (Proses)
    public function Proses($id=null)
    {
        if (!empty($id)) {
            // Cek dulu apakah data dengan id tersebut ada dan statusnya 0
            $cek_data = $this->Mod->getWhere('operasional_detail', 
                array('id_operasional_detail' => $id, 'status' => 0)
            )->row_array();
            
            if ($cek_data) {
                // Update status dari 0 menjadi 1
                $data_update = ['status' => 1];
                $res_update = $this->Mod->update2('operasional_detail', 
                    array('id_operasional_detail' => $id), 
                    $data_update
                );  
                
                if ($res_update) {
                    $res = [
                        'code' => '200',
                        'msg' => 'Status berhasil diubah menjadi Proses'
                    ];
                } else {
                    $res = [
                        'code' => '400',
                        'msg' => 'Gagal mengubah status'
                    ];
                }
            } else {
                $res = [
                    'code' => '400',
                    'msg' => 'Data tidak ditemukan atau sudah diproses'
                ];
            }
            
            echo json_encode($res);
        } else {
            $res = [
                'code' => '400',
                'msg' => 'ID tidak valid'
            ];
            echo json_encode($res);
        }
    }

    // Fungsi untuk mengubah status menjadi 0 (Draft)
    public function Draft($id=null)
    {
        if (!empty($id)) {
            // Cek dulu apakah data dengan id tersebut ada dan statusnya 1
            $cek_data = $this->Mod->getWhere('operasional_detail', 
                array('id_operasional_detail' => $id, 'status' => 1)
            )->row_array();
            
            if ($cek_data) {
                // Update status dari 1 menjadi 0
                $data_update = ['status' => 0];
                $res_update = $this->Mod->update2('operasional_detail', 
                    array('id_operasional_detail' => $id), 
                    $data_update
                );  
                
                if ($res_update) {
                    $res = [
                        'code' => '200',
                        'msg' => 'Status berhasil dikembalikan menjadi Draft'
                    ];
                } else {
                    $res = [
                        'code' => '400',
                        'msg' => 'Gagal mengubah status'
                    ];
                }
            } else {
                $res = [
                    'code' => '400',
                    'msg' => 'Data tidak ditemukan atau bukan berstatus Proses'
                ];
            }
            
            echo json_encode($res);
        } else {
            $res = [
                'code' => '400',
                'msg' => 'ID tidak valid'
            ];
            echo json_encode($res);
        }
    }

    function Delete($id=null){
        $data = ['status' => 8];
        $res_update = $this->Mod->update2('operasional_detail', array('id_operasional_detail' => $id), $data);  
       
        $res = [
            'code' => '200',
            'msg' => 'Data Berhasil di Hapus'
        ];
        echo json_encode($res);
    }
}