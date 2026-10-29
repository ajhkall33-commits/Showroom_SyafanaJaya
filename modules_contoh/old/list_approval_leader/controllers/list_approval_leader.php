<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class List_approval_leader extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->library('excel');
        $this->load->model("m_data");
    }

    public function index()
    {
      
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Review WO";
        $data["title_des"] = "List WO yang akan direview oleh Shift Leader";
        $data["content"] = "v_index";

        $data["data"] = $data;

        $this->load->view('template_v2', $data);
        // echo "<pre>",print_r ( $this->session->userdata()),"</pre>";
    }


    public function LoadData(){
         ///$data=$this->m_data->Load_Tiket($input)->result_array();
         //$data=$this->m_data->Load_Tiket()->result_array();

         //untuk sementara, karena untuk input data dari awal maret -- strat
         $data = $this->Mod->GetCustome('SELECT a.*, b.nama_fasilitas, c.nama_terminal, d.foto_after 
            FROM tiket a 
            LEFT JOIN fasilitas b ON a.id_fasilitas = b.id_fasilitas 
            LEFT JOIN terminal c ON a.id_lokasi = c.id 
            LEFT JOIN tinjut d ON a.id_tiket = d.id_tiket 
            WHERE (a.status = 6)')->result_array();
         //untuk sementara, karena untuk input data dari awal maret -- end

        //  $data = $this->Mod->GetCustome('SELECT a.*, b.nama_fasilitas, c.nama_terminal, d.foto_after 
        //     FROM tiket a 
        //     LEFT JOIN fasilitas b ON a.id_fasilitas = b.id_fasilitas 
        //     LEFT JOIN terminal c ON a.id_lokasi = c.id 
        //     LEFT JOIN tinjut d ON a.id_tiket = d.id_tiket 
        //     WHERE (a.status = 6) AND a.create_date >= NOW() - INTERVAL 1 DAY')->result_array();

         foreach ($data as $key => $value) {
            $data[$key ]['label_status']=  st($value['status']);     
         } 
        
         echo json_encode($data);
    }
   

    public function ProsesReject($id=null)
    {
        $updateData=[
            'status'        => 1,
        ];
        $data = $this->Mod->GetCustome('SELECT a.id_tinjut, a.id_tiket
            FROM tinjut a
            LEFT JOIN tinjut_detail b ON a.id_tinjut = b.id_tinjut
            WHERE (a.id_tiket = "'.$id.'")')->row_array();
        $res = $data['id_tinjut'];
        //echo "<pre>",print_r ( $data),"</pre>";

        $this->Mod->GetCustome('DELETE FROM tinjut_detail WHERE (id_tinjut = "'.$res.'")');
        $this->Mod->GetCustome('DELETE FROM tinjut WHERE (id_tiket = "'.$id.'")');
        $this->m_data->updateData('tiket',array('id_tiket'=>$id ),$updateData);
    }

    public function ProsesApprove($id=null)
    {
        $data=[
            'status'        => 9,
        ];
        $this->m_data->updateData('tiket',array('id_tiket '=>$id ),$data);
        $tinjut = $this->Mod->getWhere('tinjut', array('id_tiket' =>$id))->row_array();
        if (!empty($tinjut)) {
        $detail = $this->Mod->getWhere('tinjut_detail', array('id_tinjut' =>$tinjut['id_tinjut']))->result_array();

        foreach ($detail as $key => $value) {
            $perangkat = $this->Mod->getWhere('fasilitas_detail', array('id_fasilitas' =>$tinjut['id_fasilitas'],'id_jenisperangkat' => $value['id_jenisperangkat']))->row_array();

            $log = [
                'id_fasilitas'          => $tinjut['id_fasilitas'],
                'create_date'           => $tinjut['date_start'],
                'end_date'              => $tinjut['update_date'],
                'id_jenisperangkat'     => $value['id_jenisperangkat'],
                'id_jenismasalah'       => $value['id_jenismasalah'],
                'note'                  => $value['description'],
                'id_perangkat'          => $perangkat['id_perangkat'],
                'tittle'                 => 'Corrective Maintenance'
            ];
           
        $this->db->insert('logbook',$log);
        //echo "<pre>",print_r ( $log),"</pre>";
        //echo "<pre>",print_r ( $tinjut),"</pre>";
        //echo "<pre>",print_r ( $detail),"</pre>";
            
        }
            
        }

        
    }

    public function EditData($id) {
        
        $res = $this->Mod->GetCustome('SELECT b.*, c.nama_masalah, d.nama AS nama_JP
            FROM tinjut a
            LEFT JOIN tinjut_detail b ON a.id_tinjut = b.id_tinjut
            LEFT JOIN jenis_masalah c ON b.id_jenismasalah = c.id
            LEFT JOIN jenis_perangkat d ON d.id_jenisperangkat = b.id_jenisperangkat
            WHERE (a.id_tiket = "'.$id.'")')->result_array();
        $count_res = count($res);
        //echo "<pre>",print_r ( $res),"</pre>";

        $data = $this->Mod->GetCustome('SELECT a.*, b.nama_fasilitas, c.kode_unit, d.date_start, d.update_date, e.description AS keterangan_akhir, f.nama_masalah, g.nama AS nama_JP, h_lokasi.nama_terminal AS nama_lokasi, i_sublokasi.nama_terminal AS nama_sublokasi 
            FROM tiket a
            LEFT JOIN fasilitas b ON a.id_fasilitas = b.id_fasilitas
            LEFT JOIN unit c ON a.id_unit = c.id_unit 
            LEFT JOIN tinjut d ON a.id_tiket = d.id_tiket
            LEFT JOIN tinjut_detail e ON d.id_tinjut = e.id_tinjut
            LEFT JOIN jenis_masalah f ON e.id_jenismasalah = f.id
            LEFT JOIN jenis_perangkat g ON e.id_jenisperangkat = g.id_jenisperangkat
            LEFT JOIN terminal h_lokasi ON a.id_lokasi = h_lokasi.id
            LEFT JOIN terminal i_sublokasi ON a.id_sublokasi = i_sublokasi.id
            WHERE (a.id_tiket = "'.$id.'")')->row_array();

        $data['count'] = $count_res;

        for ($i=0; $i < $count_res; $i++) { 
            $data[$i]['nama_masalah'] = $res[$i]['nama_masalah'];
            $data[$i]['nama_JP'] = $res[$i]['nama_JP'];
            $data[$i]['ket'] = $res[$i]['description'];
        }
 
        echo json_encode($data);
    }


   
}