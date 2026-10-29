<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');


class Merk extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('merk/m_merk'); 
    }

    public function index() {
        $data["plugin"][]   = "plugin/datatable";
        $data["plugin"][]   = "plugin/select2";
        $data["title"]      = "Merk";
        $data["title_des"]  = "List Merk Perangkat";
        $data["content"]    = "v_index";
        $data["data"]       = $data;

        
        $this->load->model('m_merk');
        $this->load->view('template_v2', $data);
    }

    public function saveData() {
        $data = array(
            'nama' => $this->input->post('nama'),
        );

        $this->m_merk->saveData($data);
        echo json_encode(['status' => 'success']);
    }

    public function LoadData() {
        $data = $this->m_merk->getMerkData();
        echo json_encode($data);
    }

    public function Delete($id = null) {
        if (empty($id) || !is_numeric($id)) {
          
            echo json_encode(array('status' => 'error', 'message' => 'Invalid ID'));
            return;
        }
    
        $result = $this->Mod->delete('merk', array('id' => $id));
    
        if ($result) {
            // Deletion successful
            echo json_encode(array('status' => 'success', 'message' => 'Data deleted successfully'));
        } else {
            // Deletion failed
            echo json_encode(array('status' => 'error', 'message' => 'Failed to delete data'));
        }
    }

    public function EditData($id) {
        $this->load->model('m_merk');

        $data = $this->m_merk->getTiketById($id);
        echo json_encode($data);
    }


    public function UpdateData($id=null)
    {
        $data=array_filter($_POST);
        if (!empty( $data)) {
             $res_update = $this->Mod->update2('merk',array('id'=>$id),$data);  
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
    
    }
