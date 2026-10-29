<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Menu_aplikasi extends CI_Controller {

    function __construct() {
        parent::__construct();
       // $this->load->library('excel');
        $this->load->model("m_data");
    }

    // private function position() {
    //     $data["position"] = "perangkat";
    //     return $data;
    // }

    public function index()
    {
        // echo "<pre>",print_r ( $this->session->userdata()),"</pre>";
        //$data = $this->position();
        // $data = access($data,"VIEW");
       
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Menus Sistem";
        $data["title_des"] = " Daftar Menu Sistem";
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
       
      
         $data_res['ms']    = $this->m_data->getWhere('menu',array('status !=' =>8 ))->result_array();
         
         
        echo json_encode($data_res);
    }

    function LoadDataParent(){
      
      
         $data_res['ms'] =$this->m_data->getWhere('menu',array('parent' =>'-1' ))->result_array();
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

    public function UpdateData($id=null)
    {
        $data=array_filter($_POST);
        if (!empty( $data)) {
            if (!array_key_exists('parent', $data)) {
                $data['parent'] ='-1';
             }
            
             $res_update = $this->Mod->update2('menu',array('idmenu'=>$id),$data);  
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

        if (!empty($data)) {
            if (!array_key_exists('parent', $data)) {
               $data['parent'] ='-1';
            }
            $this->db->insert('menu',$data);
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
        
        $data = $this->Mod->GetCustome('SELECT * FROM menu')->result_array();
        $countData = count($data);
        for ($i=0; $i < $countData; $i++) { 
            if($data[$i]['parent'] == $id){
                $hapus = 1;
                //echo "<pre>",print_r ( 'tidak akan dihapus'),"</pre>";
                //echo "<pre>",print_r ( $hapus),"</pre>";
                //echo json_encode($data[$i]['parent']);
                break;
            }else {
                $hapus = 2;
                //echo "<pre>",print_r ( $hapus),"</pre>";
                //echo "<pre>",print_r ( $data[$i]['parent']),"</pre>";
                //$res = $this->Mod->GetCustome('DELETE FROM menu WHERE idmenu = "'.$id.'" ');
            };
            
        }
        
        if($hapus == 2){
            echo "<pre>",print_r ( 'akan dihapus'),"</pre>";
            $res = $this->Mod->GetCustome('DELETE FROM menu WHERE idmenu = "'.$id.'" ');
        }

        echo json_encode($hapus);
    }

   
   
}