<?php
// application/modules/req_open/controllers/Req_open.php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tinjut extends MX_Controller {

    public function index() {
        $data["plugin"][]   = "plugin/datatable";
        $data["plugin"][]   = "plugin/select2";
        $data["title"]      = "TASK";
        $data["title_des"]  = "Lorem ipsum dolor sit amet";
        $data["content"]    = "v_index";
        $data["data"]       = $data;

        
        $this->load->model('M_tinjut');

        $data['lokasi_options'] = $this->M_tinjut->get_lokasi_options();
        $data['fasilitas_options'] = $this->M_tinjut->get_fasilitas_options();
    
        $this->load->view('template_v2', $data);
    }

    function LoadData(){
       
        $data   = $this->Mod->GetCustome("SELECT a.*, b.nama_fasilitas, c.kode_unit, d.nama_terminal
        FROM tiket a 
        LEFT JOIN fasilitas b ON b.id_fasilitas = a.id_fasilitas 
        LEFT JOIN unit c ON c.id_unit = a.id_unit
        LEFT JOIN terminal d ON a.id_lokasi = d.id
        WHERE a.status NOT IN (8, 0, 2, 5, 9) AND a.id_unit='".sess()['unit']."' ORDER BY a.create_date DESC")->result_array();
        foreach ($data as $key => $value) {
           $data[$key ]['no_tiket']=  TKTNum( $value['id_tiket']);
           $data[$key ]['label_status']=  st($value['status']);
           
        } 
        echo json_encode($data);
    }
    

    function GetDataTinjut(){
        $data = $this->Mod->getWhere('tinjut',array('status' => 5, 'id_unit' => sess()['unit']))->result_array();
        foreach ($data as $key => $value) {
            $cek = $this->Mod->getWhere('tiket_cm_detail',array('id_tinjut' => $value['id_tinjut']))->num_rows();
           
            if ($cek != 0) {
                unset($key);
            }
            $fasilitas = $this->Mod->getWhere('fasilitas',array('id_fasilitas' =>$value['id_fasilitas'] ))->row_array();
            $data[$key]['fasilitas'] = $fasilitas['nama_fasilitas'];
            
        }
        // echo "<pre>",print_r ( $data),"</pre>";
        echo json_encode($data);
    }
    public function SaveData() {
        $upload_after = '';
    
        if ($_FILES['upload_after']['error'] == 0) {
            $this->load->library('upload');
    
            $config['upload_path']   = './upload/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']      = 100000;
    
            $this->upload->initialize($config);
    
            if ($this->upload->do_upload('upload_after')) {
                $upload_after = $this->upload->data('file_name');
                echo "<script>alert('File uploaded successfully.');";
                echo "window.location.href='" . site_url('req_open/index') . "';</script>";
            } else {
                echo "<script>alert('Sorry, File uploaded unsuccessfully.');";
                echo "window.location.href='" . site_url('req_open/index') . "';</script>";
            }
        } else {
            echo "<script>alert('Sorry, File uploaded unsuccessfully.');</script>";
        }
    
        $pembuat        = $this->input->post('pembuat');
        $unit           = $this->input->post('id_unit');
        $fasilitas      = $this->input->post('id_fasilitas');
        $lokasi         = $this->input->post('id_lokasi');
        $date_start     = $this->input->post('date_start');
        $keterangan     = $this->input->post('description');
    
        $data = array(
           
            'id_unit'               => $unit,
            'id_fasilitas'          => $fasilitas,
            'id_lokasi'             => $lokasi,
            'type_tiket'            => 2,
            'description'           => $keterangan,
            'foto_after'            => $upload_after,
            'type_tiket'            => 2,
            'create_by'             => '',
            'create_date'           => date('Y-m-d'),
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
        
        $data= [ 
            'status' => '8'
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

    public function Doit($id = null) {
        if (empty($id) || !is_numeric($id)) {
            // Handle invalid ID
            echo json_encode(array('status' => 'error', 'message' => 'Invalid ID'));
            return;
        }
        
        $data= [ 
            'status' => '1'
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
        $this->load->model('M_tinjut');

        $data           = $this->M_tinjut->getTiketById($id);
        $fasilitas      = $this->Mod->getWhere('fasilitas',array('id_fasilitas' => $data['id_fasilitas']))->row_array();
        $unit           = $this->Mod->getWhere('unit',array('id_unit' => $data['id_unit']))->row_array();
        $lokasi         = $this->Mod->getWhere('terminal',array('id' => $data['id_lokasi']))->row_array();
        

        $data['kode_unit']      = (!empty($unit['kode_unit']) ? $unit['kode_unit']:'');;
        $data['nama_fasilitas'] = (!empty($fasilitas['nama_fasilitas']) ? $fasilitas['nama_fasilitas']:'');;
        $data['nama_terminal']  = (!empty($lokasi['nama_terminal']) ? $lokasi['nama_terminal']:'');
        echo json_encode($data);
    }

    public function ViewData($id) {
        $this->load->model('M_tinjut');

        $data = $this->M_tinjut->getTiketById($id);
        echo json_encode($data);
    }

    public function UpdateData($id = null)
    {
        
        $data = array_filter($_POST);
        unset($data['Newitems']);
        $data['id_tiket'] = $id;
        $data['status'] = 6;
        
        $dataTiket = [
            'status'    => '6'
        ];
       $result = $this->Mod->update2('tiket', array('id_tiket' => $id),$dataTiket);
        
        // echo "<pre>",print_r ( $data),"</pre>";
        if (!empty($data)) {

            $data['foto_after'] = '';
    
        if ($_FILES['foto_after']['error'] == 0) {
            $this->load->library('upload');
    
            $config['upload_path']   = './upload/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']      = 100000;
    
            $this->upload->initialize($config);
    
            if ($this->upload->do_upload('foto_after')) {
                $data['foto_after'] = $this->upload->data('file_name');
                echo "<script>alert('File uploaded successfully.');";
                echo "window.location.href='" . site_url('req_open/index') . "';</script>";
            } else {
                echo "<script>alert('Sorry, File uploaded unsuccessfully.');";
                echo "window.location.href='" . site_url('req_open/index') . "';</script>";
            }
        } else {
            echo "<script>alert('Sorry, File uploaded unsuccessfully.');</script>";
        }

        // $data = array(
        //     'foto_after'            => $foto_after,
        // );
        //echo "<pre>",print_r ( $data),"</pre>";

            $this->db->insert('tinjut',$data);
            //$this->db->insert('tinjut',$datafoto);
            $id_tinjut = $this->db->insert_id();
            if (!empty($_POST['Newitems'])) {
			
				foreach ($_POST['Newitems'] as $key => $value) {
					$tinjut=[

					    'id_tinjut'                 => $id_tinjut ,
						'id_jenisperangkat' 		=> $value['id_jenisperangkat'],
						'id_jenismasalah'	        => $value['id_jenismasalah'], 
                        'description'	            => $value['description'], 
                        
						'status' 			=> 1,
					];
                    $this->db->insert('tinjut_detail',$tinjut);
                   
				}	
				
			}
        } else {
            $res = [
                'status' => '400',
                'msg'    => 'Data Gagal Disimpan, pastikan semua terisi'
            ];
            echo json_encode($res);
        }
    }

    
    }

