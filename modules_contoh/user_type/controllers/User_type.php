<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class User_type extends CI_Controller
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
        $data["title"] = "User_Type";
        $data["title_des"] = "List Jenis-Jenis User";
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


    function LoadData()
    {

        //$data_res['masalah']    = $this->m_data->get_join_WhereCustom('jenis_masalah','jenis_perangkat','parent_id','id_jenisperangkat')->result_array();
        $data_res  = $this->Mod->getWhere('role', array('status != ' > 8))->result_array();
        foreach ($data_res as $key => $value) {
            $data_res[$key]['label_status'] =  master_status($value['status']);
        }

        echo json_encode($data_res);
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
            $data = $this->m_data->getWhere('role', array('id' => $id))->row_array();
            echo json_encode($data);
        } else {
            echo "kosong";
        }
    }

    public function Update($id = null)
    {

        // }		

        $data = array_filter($_POST);

        if (!empty($data)) {
            // if (!array_key_exists('parent_id', $data)) {
            //    $data['parent_id'] ='-1';
            // }
            $res_update = $this->Mod->update2('role', array('id' => $id), $data);
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

            $this->db->insert('role', $data);
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
        $res_update = $this->Mod->update2('role', array('id' => $id), $data);
    }

   

   
}
