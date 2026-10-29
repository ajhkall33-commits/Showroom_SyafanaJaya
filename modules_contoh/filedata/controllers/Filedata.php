<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Filedata extends CI_Controller {

    function __construct() {
        parent::__construct();
       // $this->load->library('excel');
        $this->load->model("m_data");
        $this->role();
    }

    private function role() {
        $url = urlencode(current_url());
       
        if (session("username") == "") {
             redirect(base_url('login/auth'));
        }
    }

    public function index()
    {
        // echo "<pre>",print_r ( $this->session->userdata()),"</pre>";
       
        //  $data = access($data,"VIEW");
       
        $data["plugin"][]       = "plugin/datatable";
        $data["plugin"][]       = "plugin/select2";
        $data["title"]          = "Berangkat Data";
        $data["title_des"]      = " List Berkas & Documentasi";
        $data["content"]        = "v_index";
        $data['jenis_berkas']   = $this->Mod->getWhere('jenis_berkas',array('status !=' => 8 ))->result_array();
         
        $data["data"] = $data;
        // echo "<pre>",print_r ($data),"</pre>";
        $this->load->view('template_v2', $data);
      
    }

    
    function LoadData(){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
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
            'table'         => 'temuan' ,
            'pk'            => 'id_temuan' ,
            'parameter'     => array('status !=' => 8, 'id_unit' => sess()['unit']) ,
            'url'           => $this->uri->segment(2) ,
            'from'          => $from ,
            'limit'         => $limit ,
            'src'           => $src,
            'param_src'     => ['like' => 'keterangan']
        ];
      
      
        $data['url']            = $this->uri->segment(2);
        $totalData              = CountDataPag($param);
  
        $param['total_data']    = $totalData;
        $param['total_page']    = ceil($totalData/$limit);
        $res                    = pagin($param);
        foreach ($res['data'] as $key => $value) {
            $res['data'][$key]['tanggal']       = tgl($value['tanggal'],'s');
            $res['data'][$key]['status_label']  = st($value['status']);
            $fasilitas      = $this->m_data->getWhere('fasilitas',array('id_fasilitas' =>$value['id_fasilitas'] ))->row_array();
         
            if (!empty($fasilitas)) {
                $res['data'][$key]['fasilitas'] = $fasilitas['nama_fasilitas'];
            }else{
                $res['data'][$key]['fasilitas'] ='';
            }
            
            
            
        }
        $data['data']       = $res['data'];
        $data['pag']        = $res['pag'];

        
        //  $data_res['perangkat'] = $this->Mod->GetCustome('SELECT a.*,b.nama as jenis_perangkat FROM perangkat a left join jenis_perangkat b on b.id_jenisperangkat = a.id_jenisperangkat where a.status != 8')->result_array();
       
        echo json_encode($data);
       
    }

    function LoadFile(){
       
        if(!empty($_POST['berkas'])) {
            $jenis = array('status !=' => 8,'id_jenisberkas' =>$_POST['berkas'] );
        } else {
          
            $jenis =  array('status !=' => 8);
        } 
        $data['file']           = $this->Mod->getWhere('filedata', $jenis)->result_array();
        foreach ($data['file']as $key => $value) {

            if ($value['filetype'] != 'png') {
                $data['file'][$key]['icn'] = base_url().'assets_v2/images/'.$value['filetype'].'.png';
            }else{
                $data['file'][$key]['icn'] =  base_url().'doc/file/'.$value['file_name'];
            }
            
        }
        echo json_encode($data);
    }
 
    function UploadData(){
        if ($_FILES['filelampiran']['error'] == 0) {
            $this->load->library('upload');
            $filename= $_POST['file_name'];

            $config['upload_path']   = './doc/file/';
            $config['allowed_types'] = '*';
            $config['max_size']      = 100000;
            $config['file_name'] = $filename;
    
            $this->upload->initialize($config);
            $ext = pathinfo($_FILES['filelampiran']['name'], PATHINFO_EXTENSION);
            if ($this->upload->do_upload('filelampiran')) {
                $data['foto_before'] = $this->upload->data('file_name');

                $insert =[
                    'id_unit'           => sess()['unit'],
                    'id_jenisberkas'    => $_POST['id_jenisberkas'],
                    'file_name'         => $filename.'.'.$ext,
                    'origin_name'       => $_FILES['filelampiran']['name'],
                    'filetype'          => $ext,
                    'is_system'         => 0,
                    'status'            => 1,
                ];
                if($this->db->insert('filedata',$insert)){
                    $response=[
                        'code'      => '200',
                        'msg'       =>  'Data Save'
                    ];
                }else{
                    $response=[
                        'code'      => '500',
                        'msg'       =>  'Coba lagi beberapa waktu'
                    ];
                }
            } else {
                $response=[
                    'code'      => '500',
                    'msg'      => 'Sorry, File uploaded unsuccessfully'
                 ];
            }
        } else {
            $response=[
                'code'      => '500',
                'msg'    => 'Sorry, File Foto Before uploaded unsuccessfully'
            ];
        }
        echo json_encode($response);
    }
}