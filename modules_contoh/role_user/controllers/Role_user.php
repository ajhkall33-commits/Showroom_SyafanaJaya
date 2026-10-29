<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class role_user extends CI_Controller {

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
        Permission::grant(uri_string());
        //$data = $this->position();
        // $data = access($data,"VIEW");
       
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Role Pengguna";
        $data["title_des"] = " Daftar Hak Akses Pengguna";
        $data["content"] = "v_index";

        $data["data"] = $data;

        $this->load->view('template_v2', $data);
        // echo "<pre>",print_r ( $this->session->userdata()),"</pre>";
    }

    
    function LoadData(){
      
        $data_res['role']    = $this->m_data->getWhere('role',array('status !=' =>8 ))->result_array();
        echo json_encode($data_res);
    }

   
   

   function LoadMenu($id=null){
    if (!empty($id)) {
        $data = $this->Mod->getWhere('menu',array('status !=' =>8 ))->result_array();
        foreach ($data as $key => $value) {
            $akses= $this->Mod->getWhere('role_akses',array('id_menu' =>$value['idmenu'],'id_role' => $id))->row_array();
            if (!empty( $akses)) {
                $data[$key]['controle_create']       = $akses['create'];
                $data[$key]['controle_read']         = $akses['read'];
                $data[$key]['controle_update']       = $akses['update'];
                $data[$key]['controle_delete']       = $akses['delete'];
            }else{
                $data[$key]['controle_create']       = 0;
                $data[$key]['controle_read']         = 0;
                $data[$key]['controle_update']       = 0;
                $data[$key]['controle_delete']       = 0;
            }
        }
    }
    echo json_encode($data);
   }

   function SaveData($id=null){
        if (!empty($id)) {
            
            foreach ($_POST['newdata'] as $key => $value) {
                $akses= $this->Mod->getWhere('role_akses',array('id_menu' =>$value['idmenu'],'id_role' => $id ))->row_array();
                $role=[
                    'id_role'       => $id,
                    'id_menu' 		=> $value['idmenu'],
                    'create' 		=> (!empty($value['create']) ? $value['create']:'0'),
                    'read'	        => (!empty($value['read']) ? $value['read']:'0'),
                    'update'        => (!empty($value['update']) ? $value['update']:'0'),
                    'delete'        => (!empty($value['delete']) ? $value['delete']:'0'),
                ];  
                if (!empty($akses)) {
                    // echo "update";
                    // echo "<pre>",print_r ($role),"</pre>";
                    $this->Mod->update2('role_akses',array('id_role'=> $id,'id_menu' => $value['idmenu']),$role);
                     $msg= 'Data Berhasil Di Ubah';
                }else{
                    // echo "insert";
                    // echo "<pre>",print_r ($role),"</pre>";
                    $this->db->insert('role_akses',$role);
                    $msg= 'Data Berhasil Di Simpan';
                }
                // $this->db->insert('fasilitas_detail',$perangkat);
                $response=[
                    'code' => '200',
                    'msg'    =>  $msg
                ];
            }	
        }else{
            $response = [
                'status' => '400',
                'msg'    => 'Tidak Ada Data yang di Ubah/Tambah'
            ];
           
        }
        echo json_encode($response);
   }

}