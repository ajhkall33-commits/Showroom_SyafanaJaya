<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class DetailPerangkat extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('EXCEL');
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
        $data["title"] = "Menus Sistem";
        $data["title_des"] = " List Menu Sistem";
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
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
       
      
         $data_res['ms']    = $this->Mod->GetCustome('SELECT a.*,b.nama as jenis FROM master_perangkat_detail a left join jenis_perangkat b on b.id_jenisperangkat = a.id_jenisperangkat Where a.status!= 8')->result_array();
         
         
        echo json_encode($data_res);
    }
    function LoadDataByid($id=null){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
       
      
         $data_res['detail']    = $this->m_data->getWhere('master_perangkat_detail',array('id_jenisperangkat' =>$id ))->result_array();
         
         
        echo json_encode($data_res);
    }
   
    
    function EditData($id=null){
        if (!empty($id)) {
            $data = $this->m_data->getWhere('menu',array('idmenu' =>$id ))->row_array();
            echo json_encode($data);
        }else{
            echo "kosong";
        }
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

    public function SaveData()
    {
        $data=array_filter($_POST);

        if (!empty($data)) {
            $data['status'] = 1;
            $this->db->insert('master_perangkat_detail',$data);
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



   
   
}