<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class ba_type extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('excel');
        $this->load->model("m_data");
    }

    public function index()
    {
      
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "BA";
        $data["title_des"] = " Berita Acara";
        $data["content"] = "v_index";



        $data["isi"] =$this->m_data->getWhere('ba_type',array('status' => 1))->result_array();
       
       
        $data["data"] = $data;
        echo "<pre>",print_r ( $data),"</pre>";
        $this->load->view('template_v2', $data);
       
    }


    function Save(){
        echo "<pre>",print_r (
            


        ),"</pre>";

        $data=[
            'nama_ba' => $this->input->post('job_name'),
            'status'    =>1
        ];

        $this->m_data->insertData('ba_type',$data);

    }
    
  
}