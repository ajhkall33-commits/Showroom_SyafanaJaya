<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Master_lokasi extends CI_Controller
{

    function __construct()
    {
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
        $data["title"] = "Lokasi";
        $data["title_des"] = " List Lokasi dan Sub Lokasi";
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
        //$data= $this->position();
        // $acc  = access($data,"VIEW")['access'];


        $data_res     = $this->m_data->getWhere('terminal', array('status !=' => 8))->result_array();
        //$data_res['label_status']  =  master_status($value['status']);
        foreach ($data_res as $key => $value) {
            $data_res[$key]['label_status'] =  master_status($value['status']);
        }

        echo json_encode($data_res);
    }

    function LoadDataParent()
    {


        $data_res['m_lokasi'] = $this->m_data->getWhere('terminal', array('parent_id' => '-1', 'status' => '1'))->result_array();
        echo json_encode($data_res);
    }


    function EditData($id = null)
    {
        if (!empty($id)) {
            $data = $this->m_data->getWhere('terminal', array('id' => $id))->row_array();
            echo json_encode($data);
        } else {
            echo "kosong";
        }
    }

    public function Update($id = null)
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

        $data = array_filter($_POST);

        if (!empty($data)) {
            if (!array_key_exists('parent_id', $data)) {
                $data['parent_id'] = '-1';
            }
            $res_update = $this->m_data->updateData('terminal', array('id' => $id), $data);
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

        if (!empty($data)) {
            if (!array_key_exists('parent_id', $data)) {
                $data['parent_id'] = '-1';
            }
            $this->db->insert('terminal', $data);
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
        //$this->m_data->delete('terminal', array('id' =>$id ));
        $data = [
            'status'        => 8,
        ];
        $res_update = $this->m_data->updateData('terminal', array('id' => $id), $data);
    }
}
