<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Approvalpergantian extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->library('excel');
        $this->load->model("m_data");
    }

    public function index()
    {
      
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Persetujuan Pergantian Alat";
        $data["title_des"] = "Daftar Persetujuan Pergantian Alat";
        $data["content"] = "v_index";

        $data["data"] = $data;

        $this->load->view('template_v2', $data);
        // echo "<pre>",print_r ( $this->session->userdata()),"</pre>";
    }


    function LoadData(){

        //untuk sementara, karena untuk input data dari awal maret -- strat
       
        $data   = $this->Mod->GetCustome("SELECT a.*,b.nama_fasilitas,c.nama_terminal as lokasi,d.nama_terminal as sub_lokasi FROM change_divice a left join fasilitas b on b.id_fasilitas = a.id_fasilitas LEFT JOIN terminal c ON c.id = b.id_lokasi left JOIN terminal d ON d.id = b.id_sublokasi where a.status not in ('0','8')")->result_array();

       

        foreach ($data as $key => $value) {
        //    $data[$key ]['no_tiket']=  TKTNum( $value['id_tiket']);
           $data[$key ]['label_status']=  st($value['status']);
           $data[$key ]['tanggal_pergantian']=  tgl($value['tanggal_pergantian'], 'l');
           
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
    function SaveTTD($id=null){
        $imagedata = base64_decode($_POST['img_data']);
        $filename = md5(date("dmYhisA"));
        //Location to where you want to created sign image
        $file_name = 'doc/Sig/'.$filename.'.jpg';
        file_put_contents($file_name,$imagedata);
        $result['status'] = 1;
        $result['file_name'] = $file_name;

        $cek_user = $this->Mod->getWhere('user',array('id ' =>sess()['id'] ))->row_array();
        $data=[
            'rel_type'      => 'pergantian_perangkat',
            'rel_id'        => $_POST['id'],
            'create_date'   => date('Y-m-d H:i:s'),
            'create_by'     => sess()['id'],
            'file_name'     =>  $file_name,
            'type_user'     =>  (!empty($cek_user) ? $cek_user['type_user']: ''),
        ];
        if (!empty($cek_user)) {
            $cek = $this->Mod->getWhere('sig_log',array('rel_id' =>$_POST['id'],'rel_type'=>'pergantian_perangkat','type_user' =>$cek_user['type_user']  ))->row_array();
        }else{
            $cek = $this->Mod->getWhere('sig_log',array('rel_id' =>$_POST['id'],'rel_type'=>'pergantian_perangkat'))->row_array();
         
        }
        if (empty($cek)) {
            $this->db->insert('sig_log',$data);
            $res=['status' => 200,'msg'=>'Data Save'];
        }else{
            $this->Mod->update2('sig_log', array('id_sig' => $cek['id_sig']),$data);
            $res=['status' => 200,'msg'=>'Data Update'];
        }
       $updatests=[
        'status'=> 9
       ];
        $this->Mod->update2('change_divice', array('id_change' => $_POST['id']),$updatests);

        $pergantian         = $this->Mod->getWhere('change_divice',array('id_change' =>$_POST['id'] ))->row_array();
        $pergantian_detail  = $this->Mod->getWhere('change_divice_detail',array('id_change' =>$_POST['id'] ))->result_array();
        $fasilitas          = $this->Mod->getWhere('fasilitas',array('id_fasilitas' =>$pergantian['id_fasilitas']))->row_array();
        foreach ($pergantian_detail as $key => $value) {
           
            $perangkat_before   = $this->Mod->getWhere('perangkat',array('id_perangkat' =>$value['id_perangkat_before'] ))->row_array();
            $perangkat_after    = $this->Mod->getWhere('perangkat',array('id_perangkat' =>$value['id_perangkat_after'] ))->row_array();
          
            $logperangkat_awal=[
                'id_perangkat'      => $value['id_perangkat_before'],
                'id_jenisperangkat' => $value['id_jenisperangkat'],
                'id_fasilitas'      => $pergantian['id_fasilitas'],
                'keterangan'        => $perangkat_before['nama_perangkat'].' doganti karena '.$pergantian['description'],
                'create_date'       => date('Y-m-d'),
                'create_by'         => $pergantian['create_by'],

            ];
            echo "<pre>",print_r ( $logperangkat_awal),"</pre>";
            $this->db->insert('logperangkat',$logperangkat_awal);
            $logperangkat_baru=[
                'id_perangkat'      => $value['id_perangkat_after'],
                'id_jenisperangkat' => $value['id_jenisperangkat'],
                'id_fasilitas'      => $pergantian['id_fasilitas'],
                'keterangan'        => $perangkat_after['nama_perangkat'].'Digunakan pada Fasilitas '.$fasilitas ['nama_fasilitas'],
                'create_date'       => date('Y-m-d'),
                'create_by'         => $pergantian['create_by'],

            ];
            $this->db->insert('logperangkat',$logperangkat_baru);
            echo "<pre>",print_r ( $logperangkat_baru),"</pre>";


            $prkt_lama=['status'    => 5];
            $this->Mod->update2('perangkat', array('id_perangkat' =>$value['id_perangkat_before']),$prkt_lama);
           
            $prkt_baru=['status'    => 1];
            $this->Mod->update2('perangkat', array('id_perangkat' =>$value['id_perangkat_after']),$prkt_baru);
           
            $update_fasilitas=[
                'id_perangkat'          => $value['id_perangkat_after'],
                'tanggal_penggunaan'    => date('Y-m-d H:i:s')
            ];
            $this->Mod->update2('fasilitas_detail', array('id_fasilitas' =>$pergantian['id_fasilitas'],'id_jenisperangkat'=> $value['id_jenisperangkat']),$update_fasilitas);
           
        }
        // $before = $this->Mod->getWhere('fasilitas_detail',array('id_change' =>$_POST['id'] ))->row_array();
    //    echo "<pre>",print_r ( $pergantian),"</pre>";
    //    echo "<pre>",print_r ( $pergantian_detail),"</pre>";
        echo json_encode($res);
    }
   
}