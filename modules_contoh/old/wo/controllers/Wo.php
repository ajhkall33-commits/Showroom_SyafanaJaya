<?php

defined('BASEPATH')OR exit('No direct script access allowed');



class wo extends CI_Controller {

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
        $data["title"] = "Form Work Order AP2";
        $data["title_des"] = "PT Angkasa Pura";
        $data["content"] = "v_index";


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
    function loadlokasi(){

        $data=$this->m_data->getWhere(
            'master_lokasi',
        array('status' =>1 )
        )->result_array();

        echo json_encode($data);
    }


    function loadnamafasilitas(){

        $data=$this->m_data->getWhere(
            'master_lokasi',
        array('status' =>1 )
        )->result_array();

        echo json_encode($data);
    }

    function loadunit(){

        $data=$this->m_data->getWhere(
            'unit',
        array('status' =>1 )
        )->result_array();

        echo json_encode($data);
    }
    
    

    // upload gambar
    public function save_data() {
        $gambar = '';

        if ($_FILES['gambar']['error'] == 0){
        $this->load->library('upload');

        $config['upload_path']      = './upload/'; // Sesuaikan dengan path direktori penyimpanan gambar
        $config['allowed_types']    = 'gif|jpg|png';
        $config['max_size']         = 3024; // Set maksimum ukuran file dalam kilobyte

        $this->upload->initialize($config);
            // File berhasil diunggah
           if ($this->upload->do_upload('gambar')){
            $gambar = $this->upload->data('file_name');
            echo "Upload Berhasil";
           }else{
            echo "Upload Gagal: " . $this->upload->display_errors();
           }
        
           
        // Get data from the form (data yang akan di simpan ke database),(id_pembuat kiri dari nama table, dan id_pembuat kanan dari name view )
        $data = array(
            'id_pembuat' => $this->input->post('id_pembuat'),
            'unit' => $this->input->post('unit'),
            'fasilitas' => $this->input->post('namafasilitas'),
            'lokasi' => $this->input->post('lokasi'),
            'tanggal' => $this->input->post('tanggal'),
            'keterangan' => $this->input->post('keterangan'),
            'gambar' => $gambar,
           
            // Add other fields as needed
            // Jika file berhasil diunggah     
                  
        );

        

        // Save data to the database using the model (untuk menyimpan ke database)
        // $this->m_data->save_data($data); kalau ini ga di comment penyimpanan datanya double
        $result = $this->m_data->save_data($data);

        if ($result) {
            // Jika penyimpanan berhasil, kirim pesan ke JavaScript untuk menampilkan alert
            echo "<script>
                    alert('Data berhasil disimpan!');
                    window.location.href = '".site_url('wo/index')."';
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




// script controller untuk simpan kedatabase




    
        