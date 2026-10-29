<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Daily_activity extends CI_Controller
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
        $data["title"] = "Operasional";
        $data["title_des"] = "Daftar Operasional";
        $data["content"] = "v_index";

        $data['lokasi'] = $this->Mod->getWhere('terminal', array('status != ' > 8))->result_array();
        $data["data"] = $data;

        $this->load->view('template_v2', $data);
        $menu = fetch_menu();
    }


    function LoadData()
    {

        $data = $this->Mod->GetCustome("
        SELECT a.*, b.nama_terminal
        FROM daily_activity a
        LEFT JOIN terminal b ON b.id = a.id_lokasi
         WHERE a.status != 8
    ")->result_array();

    foreach ($data as $key => $value) {
        $data[$key]['tanggal_label'] = Hari_($value['tanggal']) . ' ' . tgl($value['tanggal'], 'sm');
    }
    
        echo json_encode($data);
    }

    function LoadDataParent()
    {


        $data_res['perangkat'] = $this->m_data->getWhere('jenis_perangkat', array('status !=' => 8))->result_array();
        //$data_res['masalah']    = $this->Mod->getJoin('jenis_masalah','jenis_perangkat','status')->result_array();
        echo json_encode($data_res);
    }


    function EditData($id = null)
    {
        if (!empty($id)) {
            $data = $this->m_data->getWhere('daily_activity', array('id' => $id))->row_array();
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
            $res_update = $this->Mod->update2('daily_activity', array('id' => $id), $data);
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
            $this->load->library('upload');
            $config['upload_path']   = './upload/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']      = 100000;
    
            $this->upload->initialize($config);
    
            if ($this->upload->do_upload('foto')) {
                $data['foto'] = $this->upload->data('file_name');
            } else {
                $error=[
                     'msg'    => 'Sorry, File uploaded unsuccessfully'
                 ];
            }

            $data['status'] = 1;
            $this->db->insert('daily_activity', $data);
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

            
            $res_update = $this->Mod->update2('daily_activity', array('id' => $id), $data);
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
