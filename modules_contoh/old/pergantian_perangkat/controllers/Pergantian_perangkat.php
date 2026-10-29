<?php
// application/modules/req_open/controllers/Req_open.php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pergantian_perangkat extends MX_Controller {
    public function __construct() {
        parent::__construct();
        // Load library atau helper yang diperlukan
        $this->load->library('pdfgenerator');
    }
    
    public function index() {

        Permission::grant(uri_string());
        $data["plugin"][]   = "plugin/datatable";
        $data["plugin"][]   = "plugin/select2";
        $data["title"]      = "Pergantian Perangkat";
        $data["title_des"]  = "Lorem ipsum dolor sit amet";
        $data["content"]    = "v_index";
        $data["data"]       = $data;
        $data["fasilitas"]   = $this->Mod->getWhere('fasilitas',array('status ' =>1,'id_unit' => sess()['unit']))->result_array();
        //  echo "<pre>",print_r ($data),"</pre>";
        $this->load->view('template_v2', $data);
    }

    function LoadData(){

        //untuk sementara, karena untuk input data dari awal maret -- strat
       
        $data   = $this->Mod->GetCustome("SELECT a.*,b.nama_fasilitas,c.nama_terminal as lokasi,d.nama_terminal as sub_lokasi FROM change_divice a left join fasilitas b on b.id_fasilitas = a.id_fasilitas LEFT JOIN terminal c ON c.id = b.id_lokasi left JOIN terminal d ON d.id = b.id_sublokasi")->result_array();

       

        foreach ($data as $key => $value) {
        //    $data[$key ]['no_tiket']=  TKTNum( $value['id_tiket']);
           $data[$key ]['label_status']=  st($value['status']);
           $data[$key ]['tanggal_pergantian']=  tgl($value['tanggal_pergantian'], 'l');
           
        } 
        echo json_encode($data);
    }

    function LoadUser(){

        //untuk sementara, karena untuk input data dari awal maret -- strat
       
        $res   = $this->Mod->GetCustome("SELECT a.*,b.name_role,b.name_code FROM user a left join role b on b.id = a.type_user WHERE a.type_user in ('2','4','5','6')")->result_array();

        //untuk sementara, karena untuk input data dari awal maret -- end

      
         $data = array();
        foreach ($res as $key => $value) {
        //    $data[$key ]['no_tiket']=  TKTNum( $value['id_tiket']);
           $data[ $value['name_code']][]=  $value;
          
           
        } 
        echo json_encode($data);
    }

    function LoadDataAll($status=null){
       if (empty($status)) {
        $status = 1;
       }
        $data   = $this->Mod->getWhere('tiket',array('status ' => $status,'id_unit' => sess()['unit']))->result_array();
           
         
        echo json_encode($data);
    }
    
    public function SaveData() {
        $data=array_filter($_POST);
        unset($data['Newitems']);
        if (!empty($data)) {
            $data['id_unit']        = sess()['unit']; 
            $data['status']         = 0;
            $data['create_date']    = 0;
            $data['create_by']      = sess()['nama'];
           
            $this->db->insert('change_divice',$data);
            $id = $this->db->insert_id();

            if (!empty($_POST['Newitems'])) {
				
				foreach ($_POST['Newitems'] as $key => $value) {

                    $_FILES['upload_before']['name']        =  $_FILES['Newitems']['name'][$key]['upload_before'];
                    $_FILES['upload_before']['type']        =  $_FILES['Newitems']['type'][$key]['upload_before'];
                    $_FILES['upload_before']['tmp_name']    =  $_FILES['Newitems']['tmp_name'][$key]['upload_before'];
                    $_FILES['upload_before']['error']       =  $_FILES['Newitems']['error'][$key]['upload_before'];
                    $_FILES['upload_before']['size']        =  $_FILES['Newitems']['size'][$key]['upload_before']; 

                    $_FILES['proses']['name']        =  $_FILES['Newitems']['name'][$key]['proses'];
                    $_FILES['proses']['type']        =  $_FILES['Newitems']['type'][$key]['proses'];
                    $_FILES['proses']['tmp_name']    =  $_FILES['Newitems']['tmp_name'][$key]['proses'];
                    $_FILES['proses']['error']       =  $_FILES['Newitems']['error'][$key]['proses'];
                    $_FILES['proses']['size']        =  $_FILES['Newitems']['size'][$key]['proses']; 

                    $_FILES['SN_new']['name']        =  $_FILES['Newitems']['name'][$key]['SN_new'];
                    $_FILES['SN_new']['type']        =  $_FILES['Newitems']['type'][$key]['SN_new'];
                    $_FILES['SN_new']['tmp_name']    =  $_FILES['Newitems']['tmp_name'][$key]['SN_new'];
                    $_FILES['SN_new']['error']       =  $_FILES['Newitems']['error'][$key]['SN_new'];
                    $_FILES['SN_new']['size']        =  $_FILES['Newitems']['size'][$key]['SN_new']; 


                    $_FILES['upload_after']['name']        =  $_FILES['Newitems']['name'][$key]['upload_after'];
                    $_FILES['upload_after']['type']        =  $_FILES['Newitems']['type'][$key]['upload_after'];
                    $_FILES['upload_after']['tmp_name']    =  $_FILES['Newitems']['tmp_name'][$key]['upload_after'];
                    $_FILES['upload_after']['error']       =  $_FILES['Newitems']['error'][$key]['upload_after'];
                    $_FILES['upload_after']['size']        =  $_FILES['Newitems']['size'][$key]['upload_after']; 

                  
               
                    $data_before    = upload('upload_before', "./upload/temp", "jpg|png|jpeg", 100000, "before_pergantian");
                    $data_proses    = upload('proses', "./upload/temp", "jpg|png|jpeg", 100000, "proses_pergantian");
                    $data_sn        = upload('SN_new', "./upload/temp", "jpg|png|jpeg", 100000, "sn_baru_pergantian");
                    $data_after     = upload('upload_after', "./upload/temp", "jpg|png|jpeg", 100000, "after_pergantian");
                  
					$perangkat=[
                        'id_change'                     => $id,
                        'id_jenisperangkat' 		    => $value['id_jenisbefore'],
						'id_perangkat_before'           => $value['id_perangkatbefore'],
                        'keterangan_before'             => $value['keterangan_before'],
                       
						'id_perangkat_after'	        => $value['id_perangkatafter'],
                        'keterangan_after'              => $value['keterangan_after'], 
                        'documentasi_before'            => $data_before['data_upload']['file_name'],
                        'proses_pergantian'             => $data_proses['data_upload']['file_name'],
                        'sn_baru'                       => $data_sn['data_upload']['file_name'],
                        'documentasi_after'             => $data_after['data_upload']['file_name']
					];
                    $this->db->insert('change_divice_detail',$perangkat);
                    // echo "<pre>",print_r ($perangkat),"</pre>";
				}	
				
			}
           
        }
    }

    public function Delete($id = null) {
        if (empty($id) || !is_numeric($id)) {
            // Handle invalid ID
            echo json_encode(array('status' => 'error', 'message' => 'Invalid ID'));
            return;
        }
        
        // $data= [ 
        //     'status' => '8'
        // ];
        //$result = $this->Mod->update2('tiket', array('id_tiket' => $id),$data);
        $result = $this->Mod->GetCustome('DELETE FROM tiket WHERE id_tiket = "'.$id.'" ');
    
        if ($result) {
            // Deletion successful
            echo json_encode(array('status' => 'success', 'message' => 'Data deleted successfully'));
        } else {
            // Deletion failed
            echo json_encode(array('status' => 'error', 'message' => 'Failed to delete data'));
        }
    }

    public function Waiting($id = null) {
        if (empty($id) || !is_numeric($id)) {
            // Handle invalid ID
            echo json_encode(array('status' => 'error', 'message' => 'Invalid ID'));
            return;
        }
        
        $data= [ 
            'status' => '2'
        ];
        $result = $this->Mod->update2('tiket', array('id_tiket' => $id),$data);
    
        if ($result) {
            // Deletion successful
            echo json_encode(array('status' => 'success', 'message' => 'Data deleted successfully'));
        } else {
            // Deletion failed
            echo json_encode(array('status' => 'error', 'message' => 'Failed to delete data'));
        }
    }

    public function Approve($id = null) {
        if (empty($id) || !is_numeric($id)) {
            // Handle invalid ID
            echo json_encode(array('status' => 'error', 'message' => 'Invalid ID'));
            return;
        }
        
        $data= [ 
            'status' => '3'
        ];
        $result = $this->Mod->update2('tiket', array('id_tiket' => $id),$data);
    
        if ($result) {
            // Deletion successful
            echo json_encode(array('status' => 'success', 'message' => 'Data deleted successfully'));
        } else {
            // Deletion failed
            echo json_encode(array('status' => 'error', 'message' => 'Failed to delete data'));
        }
    }

    public function EditData($id) {
        $this->load->model('Model');

        $data = $this->Model->getTiketById($id);
        $term = $this->Mod->getWhere('terminal',array('id' => $data['id_lokasi']))->row_array();
        $data['nama_terminal'] = $term['nama_terminal'];
        $sublok = $this->Mod->getWhere('terminal',array('id' => $data['id_sublokasi']))->row_array();
        $data['nama_sublokasi'] = $sublok['nama_terminal'];
        $unt = $this->Mod->getWhere('unit',array('id_unit' => $data['id_unit']))->row_array();
        $data['kode_unit'] = $unt['kode_unit'];
        
        echo json_encode($data);
    }


    public function UpdateData($id=null)
    {
        $data=array_filter($_POST);
        if (!empty( $data)) {
             $res_update = $this->Mod->update2('tiket',array('id_tiket'=>$id),$data);  
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


        public function ViewData($id) {

            $data = $this->Mod->GetCustome('SELECT a.*, b.nama_fasilitas, c.kode_unit, d_lokasi.nama_terminal AS nama_lokasi, e_sublokasi.nama_terminal AS nama_sublokasi 
            FROM tiket a
            LEFT JOIN fasilitas b ON a.id_fasilitas = b.id_fasilitas
            LEFT JOIN unit c ON a.id_unit = c.id_unit 
            LEFT JOIN terminal d_lokasi ON a.id_lokasi = d_lokasi.id
            LEFT JOIN terminal e_sublokasi ON a.id_sublokasi = e_sublokasi.id
            WHERE (a.id_tiket = "'.$id.'")')->row_array();
            
            echo json_encode($data);
        }


        function GetData($id=null){
            $data=$this->Mod->GetCustome("SELECT a.*,b.kode_unit as unit, c_lokasi.nama_terminal AS nama_lokasi, d_sublokasi.nama_terminal AS nama_sublokasi
            FROM fasilitas a 
            left join unit b on b.id_unit = a.id_unit
            left join terminal c_lokasi on a.id_lokasi = c_lokasi.id
            left join terminal d_sublokasi on a.id_sublokasi = d_sublokasi.id
            where a.id_fasilitas = '".$id."'")->row_array();
           
            echo json_encode($data);
        }

        function diverse_array($vector) {

            $result = array();
        
            foreach($vector as $key1 => $value1)
                //    echo "<pre>",print_r ($value1),"</pre>";
                foreach($value1 as $key2 => $value2)
                // echo "<pre>",print_r ($value2),"</pre>";
                    $result[$key2][$key1] = $value2;
        
            return $result;
        
        }
        
        function PrintData($id=null){
           
            $data["plugin"][]           = "plugin/datatable";
            $data["plugin"][]           = "plugin/select2";
            $data["title"]              = "Pergantian Perangkat";
            $data["title_des"]          = "Lorem ipsum dolor sit amet";
            $data["content"]            = "NotaDinas";

            $pergantian                 = $this->Mod->getWhere('change_divice',array('id_change' =>$id ))->row_array();
            $pergantian['terbilang']    = tgl_($pergantian['tanggal_pergantian']);
            $pergantian['jenis']        = $this->Mod->GetCustome("SELECT a.id_jenisperangkat,COUNT(a.id_jenisperangkat)as jumlah,b.nama FROM change_divice_detail a left join jenis_perangkat b on b.id_jenisperangkat= a.id_jenisperangkat where a.id_change = '".$id."' group by a.id_jenisperangkat ")->row_array();
            $fasilitas                  = $this->Mod->getWhere('fasilitas',array('id_fasilitas' =>$pergantian['id_fasilitas']))->row_array();
            $ap2                        = $this->Mod->getWhere('user',array('id' =>$pergantian['id_organik']))->row_array();
            $pergantian['nama_fasilitas']          = $fasilitas['nama_fasilitas'];
            $pergantian['ap2']          = $ap2['nama'];
            $leader                     = $this->Mod->getWhere('user',array('id' =>$pergantian['id_leader']))->row_array();
            $pergantian['leader']       = $leader['nama'];

            $planer                     = $this->Mod->getWhere('user',array('id' =>$pergantian['id_planer']))->row_array();
            $pergantian['planer']       = $planer['nama'];

            $pergantian['detail']       = $this->Mod->getWhere('change_divice_detail',array('id_change' =>$id ))->result_array();
           
            
            foreach ($pergantian['detail']  as $key => $value) {
                
                $jenis  = $this->Mod->getWhere('jenis_perangkat',array('id_jenisperangkat' =>$value['id_jenisperangkat'] ))->row_array();
                $perangkat_before  = $this->Mod->GetCustome("SELECT a.*,b.nama as merk FROM perangkat a left join merk b on b.id = a.merk_id WHERE id_perangkat ='".$value['id_perangkat_before']."'")->row_array();
                $pergantian['detail'][$key]['perangkat_before'] = $perangkat_before['nama_perangkat']." ".$perangkat_before['merk']." ".$perangkat_before['serial_number'];
                $pergantian['detail'][$key]['sn_before']        = $perangkat_before['serial_number'];

                
             
                $perangkat_after  = $this->Mod->GetCustome("SELECT a.*,b.nama as merk FROM perangkat a left join merk b on b.id = a.merk_id WHERE id_perangkat ='".$value['id_perangkat_after']."'")->row_array();
                $pergantian['detail'][$key]['perangkat_after']  = $perangkat_after['nama_perangkat']." ".$perangkat_after['merk']." ".$perangkat_after['serial_number'];
                $pergantian['detail'][$key]['sn_after']         = $perangkat_after['serial_number'];
               
               
                $pergantian['detail'][$key]['jenis'] =$jenis['nama'];
                 
            }
            
            
            $data["data"]           = $pergantian;
            // echo "<pre>",print_r ($data),"</pre>";
          
            // $this->load->view('BeritaAcara',$data);
            $html= $this->load->view('BeritaAcara',$data, true);
           
            $this->pdfgenerator->generate($html, 'file_pdf','A4','portrait');
            
        }

        function PrintDataApproval($id=null){
           
            $data["plugin"][]           = "plugin/datatable";
            $data["plugin"][]           = "plugin/select2";
            $data["title"]              = "Pergantian Perangkat";
            $data["title_des"]          = "Lorem ipsum dolor sit amet";
            $data["content"]            = "NotaDinas";

            $pergantian                 = $this->Mod->getWhere('change_divice',array('id_change' =>$id ))->row_array();
            $pergantian['terbilang']    = tgl_($pergantian['tanggal_pergantian']);
            $pergantian['jenis']        = $this->Mod->GetCustome("SELECT a.id_jenisperangkat,COUNT(a.id_jenisperangkat)as jumlah,b.nama FROM change_divice_detail a left join jenis_perangkat b on b.id_jenisperangkat= a.id_jenisperangkat where a.id_change = '".$id."' group by a.id_jenisperangkat ")->row_array();
            $fasilitas                  = $this->Mod->getWhere('fasilitas',array('id_fasilitas' =>$pergantian['id_fasilitas']))->row_array();
            $ap2                        = $this->Mod->getWhere('user',array('id' =>$pergantian['id_organik']))->row_array();
            $pergantian['nama_fasilitas']          = $fasilitas['nama_fasilitas'];
            $pergantian['ap2']          = $ap2['nama'];
            $leader                     = $this->Mod->getWhere('user',array('id' =>$pergantian['id_leader']))->row_array();
            $pergantian['leader']       = $leader['nama'];

            $planer                     = $this->Mod->getWhere('user',array('id' =>$pergantian['id_planer']))->row_array();
            $pergantian['planer']       = $planer['nama'];

            $pergantian['detail']       = $this->Mod->getWhere('change_divice_detail',array('id_change' =>$id ))->result_array();
           
            
            foreach ($pergantian['detail']  as $key => $value) {
                $jenis  = $this->Mod->getWhere('jenis_perangkat',array('id_jenisperangkat' =>$value['id_jenisperangkat'] ))->row_array();
                $perangkat_before  = $this->Mod->GetCustome("SELECT a.*,b.nama as merk FROM perangkat a left join merk b on b.id = a.merk_id WHERE id_perangkat ='".$value['id_perangkat_before']."'")->row_array();
                $pergantian['detail'][$key]['perangkat_before'] = $perangkat_before['nama_perangkat']." ".$perangkat_before['merk']." ".$perangkat_before['serial_number'];
                $pergantian['detail'][$key]['sn_before']        = $perangkat_before['serial_number'];

                
             
                $perangkat_after  = $this->Mod->GetCustome("SELECT a.*,b.nama as merk FROM perangkat a left join merk b on b.id = a.merk_id WHERE id_perangkat ='".$value['id_perangkat_after']."'")->row_array();
                $pergantian['detail'][$key]['perangkat_after']  = $perangkat_after['nama_perangkat']." ".$perangkat_after['merk']." ".$perangkat_after['serial_number'];
                $pergantian['detail'][$key]['sn_after']         = $perangkat_after['serial_number'];
               
               
                $pergantian['detail'][$key]['jenis'] =$jenis['nama'];
                 
            }
            
            
            $data["data"]           = $pergantian;
         
          
            // $this->load->view('BeritaAcara',$data);
            $html= $this->load->view('FormApproval',$data, true);
            $this->pdfgenerator->generate($html, 'file_pdf','A4','landscape');
            
        }

    
    }

