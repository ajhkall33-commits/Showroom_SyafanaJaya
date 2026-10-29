<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Fasilitas_catagory extends CI_Controller {

    function __construct() {
        parent::__construct();
       // $this->load->library('excel');
        $this->load->model("m_data");
         $this->role();
  
    }

    // private function position() {
    //     $data["position"] = "perangkat";
    //     return $data;
    // }

    private function role() {
        $url = urlencode(current_url());
        if (session("username") == "") {
            redirect(base_url('login/auth'));
        }
    }
    public function index()
    {
        // echo "<pre>",print_r ( $this->session->userdata()),"</pre>";
        //$data = $this->position();
        // $data = access($data,"VIEW");
       
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Kategori Peralatan";
        $data["title_des"] = "List Kategori Peralatan";
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
        // SK Manager / per-unit filter:
        $unit_filter_sql = get_unit_filter_sql('filter_unit');

        // Ambil data dari fasilitas_catagory dengan filter unit
        $data['ms'] = $this->Mod->GetCustome("SELECT fc.*, u.name_unit FROM fasilitas_catagory fc LEFT JOIN unit u ON u.id_unit = fc.id_unit WHERE fc.status != 8 AND fc.id_unit $unit_filter_sql")->result_array();

        echo json_encode($data);
    }     

    function LoadDataParent(){
      
      
         $data_res['ms'] =$this->m_data->getWhere('fasilitas_catagory',array('parent' =>'-1' ))->result_array();
        echo json_encode($data_res);
    }
   
    
    function EditData($id=null){
        if (!empty($id)) {
            $data = $this->m_data->getWhere('fasilitas_catagory',array('id_catagory' =>$id ))->row_array();
            echo json_encode($data);
        }else{
            echo "kosong";
        }
    }

    public function Update($id=null)
    {
       
        $data=array_filter($_POST);

        if (!empty($data)) {
            // if (!array_key_exists('parent_id', $data)) {
            //    $data['parent_id'] ='-1';
            // }
            $res_update = $this->m_data->updateData('fasilitas_catagory',array('id_catagory' =>$id ), $data);
           
            $res=[
                'code'      => '200',
                'msg'       => 'Data Berhasil di Update'
            ];
            echo json_encode($res);
        }else{
            $res=[
                'code'      => '400',
                'msg'       => 'Data Gagal Disimpan, pastikan semua terisi'
            ];
            echo json_encode($res);
        }
        
    }

    public function SaveData()
    {

        $data=array_filter($_POST);
      
        //$data['parent_id'] = $data['id_jenisperangkat'];
        if (!empty($data)) {
            
            $data['status'] =1;
             
            $this->db->insert('fasilitas_catagory',$data);
            $res=[
                'code' => '200',
                'msg'       => 'Data Berhasil di Update'
            ];

            // echo "<pre>",print_r ( $data),"</pre>";
            echo json_encode($res);
        }else{
            $res=[
                'code'    => '400',
                'msg'       => 'Data Gagal Disimpan, pastikan semua terisi'
            ];
            echo json_encode($res);
        }
        
       
        
    }

    public function Delete($id=null){
        $data=['status'=> 8];
        $res_update = $this->m_data->updateData('fasilitas_catagory',array('id_catagory' =>$id ), $data);
           
        $res=[
            'status' => '200',
            'msg'       => 'Data Berhasil di Hapus'
        ];


        echo json_encode($res);
    }

   
   
}