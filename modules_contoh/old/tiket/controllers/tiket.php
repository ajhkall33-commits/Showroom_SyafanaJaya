<?php
// application/modules/req_open/controllers/Req_open.php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tiket extends MX_Controller {

    public function index() {

        Permission::grant(uri_string());
        $data["plugin"][]   = "plugin/datatable";
        $data["plugin"][]   = "plugin/select2";
        $data["title"]      = "Request Tiket";
        $data["title_des"]  = "Lorem ipsum dolor sit amet";
        $data["content"]    = "v_index";
        $data["data"]       = $data;

        
        $this->load->model('Model');

        $data['lokasi_options'] = $this->Model->get_lokasi_options();
        $data['fasilitas_options'] = $this->Model->get_fasilitas_options();
    
        $this->load->view('template_v2', $data);
    }

    function LoadData(){

        //untuk sementara, karena untuk input data dari awal maret -- strat
       
        // $data   = $this->Mod->GetCustome('SELECT a.*,b.nama_fasilitas,c.kode_unit,d.foto_after,e_lokasi.nama_terminal AS nama_lokasi, e_sublokasi.nama_terminal AS nama_sublokasi FROM tiket a 
        // left join fasilitas b on b.id_fasilitas = a.id_fasilitas 
        // left JOIN unit c on c.id_unit = a.id_unit 
        // left JOIN tinjut d on d.id_tiket = a.id_tiket 
        // left JOIN terminal e_lokasi on e_lokasi.id = a.id_lokasi
        // left JOIN terminal e_sublokasi on e_sublokasi.id = a.id_sublokasi
        // WHERE a.status != 8 ORDER BY create_date DESC')->result_array();

        // //untuk sementara, karena untuk input data dari awal maret -- end

        // // $data   = $this->Mod->GetCustome('SELECT a.*,b.nama_fasilitas,c.kode_unit,d.foto_after,e_lokasi.nama_terminal AS nama_lokasi, e_sublokasi.nama_terminal AS nama_sublokasi FROM tiket a 
        // // left join fasilitas b on b.id_fasilitas = a.id_fasilitas 
        // // left JOIN unit c on c.id_unit = a.id_unit 
        // // left JOIN tinjut d on d.id_tiket = a.id_tiket 
        // // left JOIN terminal e_lokasi on e_lokasi.id = a.id_lokasi
        // // left JOIN terminal e_sublokasi on e_sublokasi.id = a.id_sublokasi
        // // WHERE a.status != 8 AND a.create_date >= DATE_SUB(NOW(), INTERVAL 1 DAY) ORDER BY no_tiket DESC')->result_array();

        // foreach ($data as $key => $value) {
        // //    $data[$key ]['no_tiket']=  TKTNum( $value['id_tiket']);
        //    $data[$key ]['label_status']=  st($value['status']);
           
           
        // } 



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
            'table'         => 'tiket' ,
            'pk'            => 'id_tiket' ,
            'parameter'     => array('status !=' => 8, 'id_unit'=> sess()['unit']) ,
            'url'           => $this->uri->segment(2) ,
            'from'          => $from ,
            'limit'         => $limit ,
            'src'           => $src,
            'param_src'     => [
                                'like' => 'no_tiket',
                                'or_like'=> 'description']
        ];
        $totalData              = CountDataPag($param);
        $param['total_data']    = $totalData;
        $param['total_page']    = ceil($totalData/$limit);
        $res                    = pagin($param);
        foreach ($res['data'] as $key => $value) {
            $fasilitas          =  $this->Mod->getWhere('fasilitas ',array('id_fasilitas' => $value['id_fasilitas']))->row_array();
            $tinjut             =  $this->Mod->getWhere('tinjut ',array('id_tiket' => $value['id_tiket']))->row_array();
            $lokasi             = $this->Mod->getWhere('terminal ',array('id' => $value['id_lokasi']))->row_array();
            $sublokasi          = $this->Mod->getWhere('terminal ',array('id' => $value['id_sublokasi']))->row_array();
            
            $res['data'][$key]['nama_lokasi']       = (!empty($lokasi['nama_terminal']) ? $lokasi['nama_terminal']: '');
            $res['data'][$key]['nama_sublokasi']    = (!empty($sublokasi['nama_terminal']) ? $sublokasi['nama_terminal']: '');
            $res['data'][$key]['nama_fasilitas']    = $fasilitas['nama_fasilitas'];

            $res['data'][$key ]['no_tiket']         = TKTNum( $value['id_tiket']);
            $res['data'][$key ]['label_status']     = st($value['status']);
            $res['data'][$key]['foto_after']        = $tinjut['foto_after'];
        }
        $data['data']  = $res['data'];
        $data['pag']        = $res['pag'];
       
        echo json_encode($data);
    }

    function LoadDataAll($status=null){
       if (empty($status)) {
        $status = 1;
       }
        $data   = $this->Mod->getWhere('tiket',array('status' => $status,'id_unit' => sess()['unit']))->result_array();
           
         
        echo json_encode($data);
    }
    
    public function SaveData() {
        $upload_before = '';
    
        if ($_FILES['upload_before']['error'] == 0) {
            $this->load->library('upload');
    
            $config['upload_path']   = './upload/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']      = 100000;
    
            $this->upload->initialize($config);
    
            if ($this->upload->do_upload('upload_before')) {
                $upload_before = $this->upload->data('file_name');
                echo "<script>alert('File uploaded successfully.');";
                echo "window.location.href='" . site_url('req_open/index') . "';</script>";
            } else {
                echo "<script>alert('Sorry, File uploaded unsuccessfully.');";
                echo "window.location.href='" . site_url('req_open/index') . "';</script>";
            }
        } else {
            echo "<script>alert('Sorry, File uploaded unsuccessfully.');</script>";
        }
    
        $pembuat        = $this->session->userdata('nama');
        $unit           = $this->input->post('id_unit');
        $fasilitas      = $this->input->post('id_fasilitas');
        $lokasi         = $this->input->post('id_lokasi');
        $sublokasi      = $this->input->post('id_sublokasi');
        $date_start     = $this->input->post('date_start');
        $keterangan     = $this->input->post('description');
    
        $data = array(
           
            'id_unit'               => $unit,
            'id_fasilitas'          => $fasilitas,
            'id_lokasi'             => $lokasi,
            'id_sublokasi'          => $sublokasi,
            'type_tiket'            => 2,
            'description'           => $keterangan,
            'foto_before'           => $upload_before,
            'type_tiket'            => 2,
            'create_by'             => $pembuat,
            'create_date'           => $date_start,
            'status'                => 0,
        );
        echo TKTNum(1);
        $this->db->insert('tiket',$data);
        $idtiket = $this->db->insert_id();
        $update=[
            'no_tiket'      => TKTNum($idtiket)
        ];
        $this->Mod->update2('tiket',array('id_tiket'=> $idtiket),$update);
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
    }

