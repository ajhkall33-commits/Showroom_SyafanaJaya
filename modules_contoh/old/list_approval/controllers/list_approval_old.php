<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class List_approval extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->library('excel');
        $this->load->model("m_data");
    }

    public function index()
    {
      
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "List Approval Tiket";
        $data["title_des"] = "";
        $data["content"] = "v_index";

        $data["data"] = $data;

        $this->load->view('template_v2', $data);
        // echo "<pre>",print_r ( $this->session->userdata()),"</pre>";
    }


    public function LoadTiket($input=null){
         ///$data=$this->m_data->Load_Tiket($input)->result_array();
         //$data=$this->m_data->Load_Tiket()->result_array();

         //untuk sementara, karena untuk input data dari awal maret -- strat
         $data = $this->Mod->GetCustome('SELECT a.*, b.nama_fasilitas, c.nama_terminal FROM tiket a LEFT JOIN fasilitas b ON a.id_fasilitas = b.id_fasilitas LEFT JOIN terminal c ON a.id_lokasi = c.id WHERE (a.status != 8 && a.status != 0 && a.status != 9) ORDER BY a.create_date DESC')->result_array();
         //untuk sementara, karena untuk input data dari awal maret -- end
         
         
         //$data = $this->Mod->GetCustome('SELECT a.*, b.nama_fasilitas, c.nama_terminal FROM tiket a LEFT JOIN fasilitas b ON a.id_fasilitas = b.id_fasilitas LEFT JOIN terminal c ON a.id_lokasi = c.id WHERE (a.status != 8 && a.status != 0 && a.status != 9) AND a.create_date >= NOW() - INTERVAL 1 DAY ORDER BY a.create_date DESC')->result_array();
         
         
         foreach ($data as $key => $value) {
            $data[$key ]['label_status']=  st($value['status']);     
         } 
        
         echo json_encode($data);
    }
   

    public function ProsesReject($id=null)
    {
        $data=[
            'status'        => 0,
        ];
        $this->m_data->updateData('tiket',array('id_tiket'=>$id ),$data);
    }
    public function ProsesApprove($id=null)
    {
        $data=[
            'status'        => 3,
        ];
        $this->m_data->updateData('tiket',array('id_tiket '=>$id ),$data);
    }

    public function EditData($id) {
        $data = $this->Mod->GetCustome('SELECT a.*, b.nama_fasilitas, c.kode_unit, d_lokasi.nama_terminal AS nama_lokasi, e_sublokasi.nama_terminal AS nama_sublokasi 
            FROM tiket a
            LEFT JOIN fasilitas b ON a.id_fasilitas = b.id_fasilitas
            LEFT JOIN unit c ON a.id_unit = c.id_unit 
            LEFT JOIN terminal d_lokasi ON a.id_lokasi = d_lokasi.id
            LEFT JOIN terminal e_sublokasi ON a.id_sublokasi = e_sublokasi.id
            WHERE (a.id_tiket = "'.$id.'")')->row_array();
            
        echo json_encode($data);
    }


   
}