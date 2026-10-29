<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class user extends CI_Controller {

    function __construct() {
        parent::__construct();
       // $this->load->model("m_user");
        //$this->load->model("m_unit");
    }

    private function role() {
        if (session("role") != "ADMINISTRATOR" && session("role") != "READONLY") {
            redirect("login");
        }
    }


    private function checkData($id = "") {
        if ($id != "") {
            $q = $this->m_user->get(($id));
            if (is_object($q)) {
                redirect("user?token=" . token());
            }
            return $q;
        }
    }

    private function position() {
        $data["position"] = "user";
        return $data;
    }

    public function master() {

        //$this->role();
        $data = $this->position();
        $data["position"] .= "/master";
        // $data = access($data,"VIEW");
        // $data['units'] = $this->m_user->get_unit_options();

        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Users";
        $data["title_des"] = " List Data Users";
        $data["content"] = "v_user_list";
        $data['units']   = $this->Mod->getWhere('unit',array('status !=' =>8 ))->result_array();
        $data["data"] = $data;
        $this->load->view('template_v2', $data);
    }

    public function user_list()
    {
        
       // $data = $this->position();
        // $data["position"] .= "/master";
        // //$data = access($data,"VIEW");
        // $data = $this->m_data->getWhere('user',array('status!=' =>8))->result_array();

        // if($data){
        //     echo json_encode(['status'=>200,"msg"=>"sukses","data"=>$data]);
        // }else{
        //     echo json_encode(['status'=>500,"msg"=>"gagal","data"=>[]]);
        // }
    }

    public function user_log()
    {
        
        $data = $this->position();
        $data["position"] .= "/log";
        $data = access($data,"VIEW");
        $data = $this->m_user->get_user_log();
        if($data){
            echo json_encode(['status'=>200,"msg"=>"sukses","data"=>$data]);
        }else{
            echo json_encode(['status'=>500,"msg"=>"gagal","data"=>[]]);
        }
    }


    public function log()
    {
        $data = $this->position();
        $data["position"] .= "/log";
        $data = access($data,"VIEW");

        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Daftar Pengguna";
        $data["content"] = "v_user_log";

        $data["data"] = $data;
        $this->load->view('template', $data);
    }

    function LoadData(){
       
        $data=$this->Mod->getWhere('user',array('status !=' =>8 ))->result_array();
        echo json_encode($data);
    }

    function EditData($id=null){
       
        $data=$this->Mod->getWhere('user',array('id' =>$id ))->row_array();
        echo json_encode($data);
    }


    public function SaveData()
    {

        $data=array_filter($_POST);

        if (!empty($data)) {
            $cek= $this->Mod->getWhere('user',array('username ' =>$data['username'] ))->num_rows();
                if (!empty($data['password'])) {
                $data['password'] = hassp($data['password']);
               }
            if ( $cek < 1) {
                $this->db->insert('user',$data);
                $res=[
                    'status' => '200',
                    'msg'       => 'Data Berhasil di disimpan'
                ];
    
            }else{
                $res=[
                    'status'    => '400',
                    'msg'       => 'Data Gagal Disimpan, username sudah ada'
                ];
                
            }
           
           
           
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
  

    function UpdateData($id){
        $data=array_filter($_POST);
        if (!empty($data)) {
            
            // $cek= $this->Mod->getWhere('user',array('username ' =>$data['username'] ))->num_rows();
                if (!empty($data['password'])) {
                    $data['password'] = hassp($data['password']);
                }
              
                    $update = $this->Mod->update2('user',array('id ' =>$id),$data);
                    // $this->db->insert('user',$data);
                if ($update) {
                    $res=[
                        'status' => '200',
                        'msg'       => 'Data Berhasil di disimpan'
                    ];
        
                }else{
                    $res=[
                        'status'    => '400',
                        'msg'       => 'Data Gagal Disimpan, username sudah ada'
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
        // echo "<pre>",print_r ( $data),"</pre>";
    }



    function UploadData(){
        if(isset($_FILES["filelampiran"]["name"])){
			$path = $_FILES["filelampiran"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
       
			
            $data           = array();
            $data_triwulan  = array();
            $data_sms       = array();
            $data_thn       = array();
            $datacctv_bulanan = array();
			foreach($object->getWorksheetIterator(1) as $worksheet => $value){
			    $highestRow = $value->getHighestRow();
              
                $lastColumn = $value->getHighestDataColumn(); 
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($lastColumn);
          
                   if ($worksheet == 0) {
                    for ($row=3; $row <=$highestRow ; $row++) { 
                        $nik            = $value->getCellByColumnAndRow(0, $row)->getValue();
                        $username       = $value->getCellByColumnAndRow(1, $row)->getValue();
                        $nama           = $value->getCellByColumnAndRow(1, $row)->getValue();
                                // $password       = $value->getCellByColumnAndRow(1, $row)->getValue();
                             
                                
                                
                                $pas = explode(" ",$nama);
                              
                                if (count($pas) > 0) {
                                    
                                    $pasword =  implode("_",$pas);
                                  
                                }else{
                                    $pasword =  $nama;
                                }

                                if (!empty($_POST['id_unit'])) {
                                  $id_unit = $_POST['id_unit'];
                                }else{
                                    $id_unit ='';
                                }
                                if (!empty($_POST['type_user'])) {
                                    $type_user = $_POST['type_user'];
                                  }else{
                                      $type_user ='';
                                  }
                               
                                $insert=[
                                    'username'          => strtolower($username) ,
                                    'password'          => hassp(strtolower($pasword)) ,
                                    'nik'               => $nik,
                                    'nama'              => $nama,
                                    'no_hp'             => '',
                                    'unit_kerja'        => $id_unit,
                                    'type_user'         => $type_user,
                                    'created'           => '',
                                    'status'            => 1
                                    
                            
                                ];
                             
                                $this->db->insert('user',$insert);
                               
                            //    if (!empty($shift) ) {
                            //      $lokasi    = $value->getCellByColumnAndRow(0, $row)->getValue();
                            //      $ip        = $value->getCellByColumnAndRow(1, $row)->getValue();
                            
                            //      $master    =  $this->Mod->getWhere('fasilitas',array('ip_address' => $ip ))->row_array();
                            //      if (!empty($master)) {
                            //         $id_fasilitas = $master['id_fasilitas'];
                            //      }else{
                            //         $id_fasilitas = '';
                                
                            //      }
                               
                              
                               
                            //    }
                          }
                       
                   }
         
             
            }

        }
    }

}

