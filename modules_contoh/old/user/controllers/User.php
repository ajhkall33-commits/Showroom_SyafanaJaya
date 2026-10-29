<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class user extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('EXCEL');
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
       
        //$data=$this->Mod->getWhere('user',array('status !=' =>8,'unit_kerja' => sess()['unit']))->result_array();
        
        if(isset($_POST['limit'])) {
            $limit = $_POST['limit'];
        } else {
            // Atur nilai default jika $_POST['limit'] tidak diatur
            $limit = 3000; 
        }
        if(isset($_POST['src'])) {
            $src = $_POST['src'];
        } else {
            // Atur nilai default jika $_POST['limit'] tidak diatur
            $src = ''; 
        }  
        $from               = $this->uri->segment(3);
      
        $param=[
            'table'         => 'user' ,
            'pk'            => 'id' ,
            // 'parameter'     => array('status !=' => 8, 'id_unit'=> sess()['unit']) ,
            'url'           => $this->uri->segment(2) ,
            'from'          => $from ,
            'limit'         => $limit ,
            'src'           => $src,
            'param_src'     => [
                                'like' => 'nik',
                                'or_like'=> 'nama']
        ];
        if(sess()['type_user'] == 'super'){
            $param['parameter'] = array('status !=' => 8);
        }else{
            $param['parameter'] = array('status !=' => 8, 'id_unit'=> sess()['unit']);
        }
      //  echo "<pre>",print_r ( sess()),"</pre>";
        $totalData              = CountDataPag($param);
        $param['total_data']    = $totalData;
        $param['total_page']    = ceil($totalData/$limit);
        $res                    = pagin($param);
        foreach ($res['data'] as $key => $value) {
           $unit                            = $this->Mod->getWhere('unit ',array('id_unit' => $value['unit_kerja']))->row_array();
           $res['data'][$key]['unit']       = (!empty($unit['kode_unit']) ? $unit['kode_unit']: '');
           $role                            = $this->Mod->getWhere('role',array('id' => $value['type_user']))->row_array();
           $res['data'][$key]['name_role']       = (!empty($role['name_role']) ? $role['name_role']: '');
        }
        $data['data']       = $res['data'];
        $data['pag']        = $res['pag'];
      
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
            $error          = array();
            $insert         = array();
            $datainsert     = array();
            $user_type  = $this->Mod->getWhere('role',array('status != ' =>8))->result_array();
			foreach($object->getWorksheetIterator(1) as $worksheet => $value){
			    $highestRow = $value->getHighestRow();
              
                $lastColumn = $value->getHighestDataColumn(); 
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($lastColumn);
          
                    if ($worksheet == 0) {
                        $f_nama = $value->getCellByColumnAndRow(1, 4)->getValue();
                        if ($f_nama !=="NAMA KARYAWAN") {
                            $error []="Kolom NAMA Tidak Sesuai Format";
                        }
                        $f_nik = $value->getCellByColumnAndRow(2, 4)->getValue();
                        if ($f_nik !=="NIK") {
                            $error []="Kolom NIK Tidak Sesuai Format";
                        }
                        $f_hp = $value->getCellByColumnAndRow(3, 4)->getValue();
                        if ($f_hp !=="No Hp") {
                            $error []="Kolom No HpTidak Sesuai Format";
                        }
                        $f_email = $value->getCellByColumnAndRow(4, 4)->getValue();
                        if ($f_email !=="Email") {
                            $error []="Kolom Email Tidak Sesuai Format";
                        }
                        $f_jenis = $value->getCellByColumnAndRow(5, 4)->getValue();
                        if ($f_nama !=="Jenis User") {
                            $error []="Kolom Jenis User Tidak Sesuai Format";
                        }

                        for ($row=5; $row <=$highestRow ; $row++) { 
                           
                            $username       = $value->getCellByColumnAndRow(1, $row)->getValue();
                            $nama           = $value->getCellByColumnAndRow(1, $row)->getValue();
                            $nik            = $value->getCellByColumnAndRow(2, $row)->getValue();
                            $email          = $value->getCellByColumnAndRow(3, $row)->getValue();
                            $hp             = $value->getCellByColumnAndRow(4, $row)->getValue();
                            $jenis          = $value->getCellByColumnAndRow(5, $row)->getValue();
                                    // $password       = $value->getCellByColumnAndRow(1, $row)->getValue();
                                
                                    
                                    
                                    $pas = explode(" ",$nama);
                                
                                    if (count($pas) > 0) {
                                        $pasword =$pas[0];
                                    
                                    }else{
                                        $pasword =  $nama;
                                    }

                                    if (!empty($_POST['id_unit'])) {
                                    $id_unit = $_POST['id_unit'];
                                    }else{
                                        $id_unit ='';
                                    }
                                  
                                    if (in_array($jenis,array_column($user_type, 'name_role'))) {
                                        $tes = array_search($jenis,array_column($user_type, 'name_role'));
                                       
                                        $insert[]=[
                                            'username'          => strtolower($username) ,
                                            'password'          => hassp(strtolower($pasword)) ,
                                           
                                            'nik'               => $nik,
                                            'nama'              => $nama,
                                            'no_hp'             => $hp,
                                            'email'             => $email,
                                            'unit_kerja'        => $id_unit,
                                            'type_user'         => $user_type[$tes]['id'],
                                          
                                            'created'           => '',
                                            'status'            => 1
                                            
                                    
                                        ];
                                        // $this->db->insert('user',$inst);
                                    }else{
                                        $error []="Jenis User Tidak terdaftar";
                                    }
                                    

                                    // $cek= $this->Mod->getWhere('user',array('username ' =>strtolower($username)));
                                    // if ( $cek->num_rows() < 1) {
                                    //     echo "Sudah Ada";
                                    //     echo "<pre>",print_r ($insert),"</pre>";
                                    //     //  $this->db->insert('user',$insert);
                                    // }else{
                                    // $datauser=  $cek->row_array();
                                    //     echo "<pre>",print_r ($datauser),"</pre>";
                                    //     $updateData=[
                                    //         'nik'               => $nik,
                                    //     ];
                                    //     $datauser['id'];
                                    //     // $update = $this->Mod->update2('user',array('id' =>$datauser['id']),$updateData);
                                    
                                    // }
                                    
                                //
                                
                        }
                        
                    }
         
             
            }
            if (count($error) > 1) {
                echo "<pre>",print_r ( $error),"</pre>";
              
            }else{
                foreach ($insert as $key => $value) {
                  
                    $cek        = $this->Mod->getWhere('user',array('status != ' =>8))->result_array();
                 
                    if (array_search($value['username'],array_column($cek, 'username'))) {
                        $tes = array_search($value['username'],array_column($cek, 'username'));
                        // echo "data ada";
                        echo "<pre>",print_r ($cek[$tes]),"</pre>";
                    }else{
                       
                        $this->db->insert('user',$value);
                        // $inst=$value;
                        // echo "<pre>",print_r ($inst),"</pre>";
                    }

                    
                   


                    // 
                }
               
                
            }

            
        }
    }

}

