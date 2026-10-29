<?php

defined('BASEPATH')OR exit('No direct script access allowed');



class ganti_perangkat extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('excel');

        $this->load->model("m_data");
        $data['lokasi_options'] = $this->m_data->get_lokasi_options();

        
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
        $data["title"] = "Form Pergantian Perangkat";
        $data["title_des"] = "PT Angkasa Pura";
        $data["content"] = "v_index";

        $data["data"] = $data;
        // 
        $data["id_fasilitas"]= $this->m_data->getidfasilitas();
        // 
        $data["no_tiket"]= $this->m_data->getnotiket();
        // 
        $data["id_lokasi"]= $this->m_data->getidlokasi();

        $this->load->view('template_v2', $data);
        // echo "<pre>",print_r ( $this->session->userdata()),"</pre>";
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
    function loadpbaru(){

        $data=$this->m_data->getWhere(
            'master_lokasi',
        array('status' =>1 )
        )->result_array();

        echo json_encode($data);
    }


    function loadplama(){

        $data=$this->m_data->getWhere(
            'master_lokasi',
        array('status' =>1 )
        )->result_array();

        echo json_encode($data);
    }


    // 
    public function save_data() {
        $foto_sebelum = '';
        $foto_sesudah = '';

        if ($_FILES['foto_sebelum']['error'] == 0)
        if ($_FILES['foto_sesudah']['error'] == 0){
        $this->load->library('upload');

        $config['upload_path']      = './upload/'; // Sesuaikan dengan path direktori penyimpanan gambar
        $config['allowed_types']    = 'gif|jpg|png';
        $config['max_size']         = 3024; // Set maksimum ukuran file dalam kilobyte

        $this->upload->initialize($config);
            // File berhasil diunggah
           if ($this->upload->do_upload('foto_sebelum'))
           if ($this->upload->do_upload('foto_sesudah')){
            $foto_sebelum = $this->upload->data('file_name');
            $foto_sesudah = $this->upload->data('file_name');
            echo "Upload Berhasil";
           }else{
            echo "Upload Gagal: " . $this->upload->display_errors();
           }
        

    //    
    $data = array(
        'fasilitas' => $this->input->post('idfasilitas'),
        'no_tiket' => $this->input->post('id_tiket'),
        'perangkat_awal' => $this->input->post('perangkat_awal'),
        'perangkat_baru' => $this->input->post('pbaru'),
        'lokasi_perangkatlama' => $this->input->post('plama'),
        'jam_mulai' => $this->input->post('tanggal_mulai'),
        'jam_selesai' => $this->input->post('tanggal_selesai'),
        'foto_sebelum' => $foto_sebelum,
        'foto_sesudah' => $foto_sesudah, 
                 
    );


    $result = $this->m_data->save_data($data);

        if ($result) {
            // Jika penyimpanan berhasil, kirim pesan ke JavaScript untuk menampilkan alert
            echo "<script>
                    alert('Data berhasil disimpan!');
                    window.location.href = '".site_url('gperangkat/index')."';
                  </script>";
        } else {
            // Jika terjadi kesalahan, mungkin tampilkan pesan kesalahan
            echo "<script>alert('Gagal menyimpan data.');</script>";
        }
        }
    }
}










   
           
               // $this->db->insert_batch('erp_customer', $data);
            // 	// echo 'Data Imported successfully';
        