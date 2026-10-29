<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class unit extends CI_Controller {

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
        $data["title"] = "Menu Sistem";
        $data["title_des"] = " List Master Data Unit";
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



    // Fungsi menampilkan data dari database ke tabel view
    function LoadData(){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
        //  $data_res['ms']    = $this->Mod->getWhere('unit',array('status !=' =>8 ))->result_array();  
        //  foreach ($data_res as $key => $value) { 
        //  $data_res[$key ]['label_status']=  uh($value['status']); 
        if(!empty($_POST['limit'])) {
            $limit =$_POST['limit'];
        } else {
            $limit =  $this->m_data->getWhere('unit',array('status !='=> 8))->num_rows(); 
        }
        $from = $this->uri->segment(3);
        
        $data['url']= $this->uri->segment(2);
        $totalData= $this->Mod->CountData('unit','id_unit', array('status !=' => 8))->num_rows();
       
        $res = pagin(
                        'unit',
                        'id_unit',
                        array('status !=' => 8),
                        $this->uri->segment(2),
                        $limit,$from,
                        ceil($totalData/$limit)
                    );

                    foreach ($res['data'] as $key => $value) {                      
                        $res['data'][$key]['label_status']=uh($value['status']);
                    }

        $data['unit']  = $res['data'];
        $data['pag'] = $res['pag'];

        echo json_encode($data);
    }

    function ListData(){
        $data = $this->m_data->getWhere('unit',array('status !='=> 8))->result_array(); 

        echo json_encode($data);
    }



    function LoadDataParent(){   
        $data_res['ms'] =$this->m_data->getWhere('unit',array('id_unit' =>'-1' ))->result_array();
       echo json_encode($data_res);
   }
  
   
    // Fungsi menampilkan nama data di field saat akan melakukan edit
   function EditData($id=null){
       if (!empty($id)) {
           $data = $this->m_data->getWhere('unit',array('id_unit' =>$id ))->row_array();
           echo json_encode($data);
       }else{
           echo "kosong";
       }
   }



   // Fungsi update data ke database
   public function UpdateData($id=null)
   {
       $data=array_filter($_POST);
       if (!empty( $data)) {
           if (!array_key_exists('kode_unit', $data)) {
               $data['kode_unit'] ='-1';
            }
           
            $res_update = $this->Mod->update2('unit',array('id_unit'=>$id),$data);  
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



   // Fungsi sava data ke database
   public function SaveData()
   {
       $data=array_filter($_POST);

       if (!empty($data)) {
           $this->db->insert('unit',$data);
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



    function Delete($id=null){
        $this->m_data->delete('unit', array('id_unit' =>$id));  
    }



    
    // function LoadData(){
       
    //     $data_res   = $this->Mod->GetCustome('SELECT a.*,b.kode_unit,c.nama_unit FROM unit')->result_array();
    //     foreach ($data as $key => $value) {
    //     //    $data_res[$key ]['no_tiket']=  TKTNum( $value['id_tiket']);
    //        $data_res[$key ]['label_status']=  st($value['status']);
           
    //     } 
    //     echo json_encode($data);
    // }

    
    



    // function Loadmasterdetail($id){
    //     //$data= $this->position();
    //    // $acc  = access($data,"VIEW")['access'];     
    //     $data = $this->m_data->getWhere('unit',array('id_unit' =>$id,'status !=' => 8 ))->result_array();
    //     echo json_encode($data);
    // }
   


    // function LoadDataByid($id){
    //     //$data= $this->position();
    //    // $acc  = access($data,"VIEW")['access'];
    //     $data_res['negara'] = $this->m_data->getWhere('unit',array('id_unit' =>$id ))->row_array();
    //     // $data_res['detail'] = $this->m_data->getWhere('perangkat_detail',array('id_perangkat' =>$id ))->result_array();
    //     echo json_encode($data_res);
    // }



    // function LoadDataDetail($id=null){
    //     $data_res['detail'] = $this->Mod->GetCustome('SELECT a.*,b.nama as property FROM perangkat_detail a left JOIN master_perangkat_detail b on b.idmaster_detail_perangkat = a.idmaster_detail_perangkat Where  a.id_perangkat = \''.$id.'\'')->result_array();
    //     echo json_encode($data_res);
    // }
   


   

    

}