<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Lokasi extends CI_Controller
{

    function __construct()
    {
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
        $data["title"] = "Lokasi";
        $data["title_des"] = "Daftar Lokasi ";
        $data["content"] = "v_index";

        // $data['lokasi'] = $this->Mod->getWhere('terminal', array('status != ' > 8))->result_array();
        $data["data"] = $data;

        $this->load->view('template_v2', $data);
        $menu = fetch_menu();
    }


    function LoadData()
    {

        //ambil semua data yang ada di tabel daily_activity (maka menggunakan result array)
        $data_res  = $this->m_data->getWhere('lokasi', array('status != ' => 8))->result_array();

        //karena di tabel daily_activity perlu ada mengambil data dari lokasi / berelasi 
        //maka kita perlu megambil 1 baris dari tabel lokasi
        //ketika mengambil data dari tabel lain maka kita menggunakan perinta foreach
        // foreach ($data_res as $key => $value) {
           
        // //ketika mau mengambil 1 baris maka menggunakan (row-array)
        //   $lokasi = $this->Mod->getWhere('terminal', array('status != ' > 8,'id'=> $value['id_lokasi']))->row_array();
        //     $data_res[$key]['lokasi'] = $lokasi['nama_terminal'];
        // }

        echo json_encode($data_res);
    }

    // function LoadDataParent()
    // {


    //     $data_res['perangkat'] = $this->m_data->getWhere('jenis_perangkat', array('status !=' => 8))->result_array();
    //     //$data_res['masalah']    = $this->Mod->getJoin('jenis_masalah','jenis_perangkat','status')->result_array();
    //     echo json_encode($data_res);
    // }


    function EditData($id = null)
    {
        if (!empty($id)) {
            $data = $this->m_data->getWhere('lokasi', array('id' => $id))->row_array();
            echo json_encode($data);
        } else {
            echo "kosong";
        }
    }

    public function Update($id = null)
    {		
        $data = array_filter($_POST);

        if (!empty($data)) {
            // if (!array_key_exists('parent_id', $data)) {
            //    $data['parent_id'] ='-1';
            // }
            $res_update = $this->Mod->update2('lokasi', array('id' => $id), $data);
            if ($res_update) {
                $res = [
                    'status' => '200',
                    'msg'       => 'Data Berhasil di Update'
                ];
            } else {
                $res = [
                    'status'    => '400',
                    'msg'       => 'Data Gagal Disimpan, pastikan semua terisi'
                ];
            }
            echo json_encode($res);
        } else {
            $res = [
                'status'    => '400',
                'msg'       => 'Data Gagal Disimpan, pastikan semua terisi'
            ];
            echo json_encode($res);
        }
    }

    public function SaveData()
    {

        $data = array_filter($_POST);
        //$data['parent_id'] = $data['id_jenisperangkat'];
        if (!empty($data)) {
            // template ci ketika upload
            // $this->load->library('upload');
            // $config['upload_path']   = './upload/';
            // $config['allowed_types'] = 'jpg|png|jpeg';
            // $config['max_size']      = 100000;
    
            // $this->upload->initialize($config);
    
            // if ($this->upload->do_upload('foto')) {
            //     $data['foto'] = $this->upload->data('file_name');
            // } else {
            //     $error=[
            //          'msg'    => 'Sorry, File uploaded unsuccessfully'
            //      ];
            // }

            $data['status'] = 1;
            $this->db->insert('lokasi', $data);
            $res = [
                'status' => '200',
                'msg'       => 'Data Berhasil di Update'
            ];

            // echo "<pre>",print_r ( $data),"</pre>";
            echo json_encode($res);
        } else {
            $res = [
                'status'    => '400',
                'msg'       => 'Data Gagal Disimpan, pastikan semua terisi'
            ];
            echo json_encode($res);
        }
    }

    public function Delete($id = null)
    {
        //$this->m_data->delete('jenis_masalah', array('id' =>$id ));
        $data = [
            'status'        => 8,
        ];
        if (!empty($data)) {

            
            $res_update = $this->Mod->update2('lokasi', array('id' => $id), $data);
            $res = [
                'status' => '200',
                'msg'       => 'Data Berhasil di Hapus'
            ];

            // echo "<pre>",print_r ( $data),"</pre>";
            echo json_encode($res);
        } else {
            $res = [
                'status'    => '400',
                'msg'       => 'Data Gagal Disimpan, pastikan semua terisi'
            ];
            echo json_encode($res);
        }
    }

   

   
}
