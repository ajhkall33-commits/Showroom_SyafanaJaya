<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class job_pm extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Excel');
        $this->load->model("m_data");
    }

    public function index()
    {
      
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Pekerjaan Perawatan";
        $data["title_des"] = "Daftar Pekerjaan Perawatan";
        $data["content"] = "v_index";
        $data['jenis']= $this->m_data->getWhere('jenis_perangkat',array('id_unit' =>sess()['unit'],'status !='=>8 ))->result_array();
        $data["data"] = $data;

        $this->load->view('template_v2', $data);
        // echo "<pre>",print_r ( $this->session->userdata()),"</pre>";
    }

    
    function LoadData(){
        $unit_sql = get_unit_filter_sql('filter_unit');
        $data= $this->m_data->getWhere('pm_type',array('status' =>1 ))->result_array();
        foreach ($data as $key => $value) {
           $job =  $this->Mod->GetCustome(" SELECT a.id_pmtype,a.id_jenisperangkat,a.id_unit,b.nama as jenis, COUNT(b.id_jenisperangkat) as jumlah FROM job_pm a LEFT JOIN jenis_perangkat b on b.id_jenisperangkat = a.id_jenisperangkat WHERE a.id_pmtype = '".$value['idpm_type']."' AND a.status = 1 AND a.id_unit $unit_sql group by a.id_pmtype,a.id_jenisperangkat,a.id_unit")->result_array();
           
            $data[$key]['detail']       = $job ;
            $data[$key]['row_count']    = count($job);
        }
       
        echo json_encode($data);
    }

    function LoadDataDetail($id=null){
        $unit_sql = get_unit_filter_sql('filter_unit');
        $data= $this->Mod->GetCustome("SELECT * FROM job_pm WHERE id_pmtype = '$id' AND status = 1 AND id_unit $unit_sql")->result_array();
        foreach ($data as $key => $value) {
            $jenis =  $this->Mod->GetCustome("SELECT * FROM jenis_perangkat WHERE id_jenisperangkat = '{$value['id_jenisperangkat']}' AND status = 1 AND id_unit $unit_sql")->row_array();
            $data[$key]['jenis']= isset($jenis['nama']) ? $jenis['nama'] : '';
        }
       
        echo json_encode($data);
    }

    function LoadDataDetailJenis($pmtype,$jenis){
        $unit_sql = get_unit_filter_sql('filter_unit');
        $data= $this->Mod->GetCustome("SELECT * FROM job_pm WHERE id_pmtype = '$pmtype' AND status = 1 AND id_unit $unit_sql AND id_jenisperangkat = '$jenis'")->result_array();
        foreach ($data as $key => $value) {
            $jenis_row =  $this->Mod->GetCustome("SELECT * FROM jenis_perangkat WHERE id_jenisperangkat = '{$value['id_jenisperangkat']}' AND status = 1 AND id_unit $unit_sql")->row_array();
            $data[$key]['jenis']= isset($jenis_row['nama']) ? $jenis_row['nama'] : '';
        }
       
        echo json_encode($data);
    }

    function LoadDataEdit($id=null){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
       
        $data= $this->m_data->getWhere('job_pm',array('id_jobpm' =>$id,'status' => 1,'id_unit' => sess()['unit']))->row_array();
       
       
        echo json_encode($data);
    }

    function EditData($id = null)
    {
        if (!empty($id)) {
            $data = $this->m_data->getWhere('pm_type', array('idpm_type' => $id))->row_array();
            echo json_encode($data);
        } else {
            echo "kosong";
        }
    }

    public function Update($id = null)
    {		
        $data = array_filter($_POST);

        if (!empty($data)) {
            // if (!array_key_exists('parent_id', $data)) {
            //    $data['parent_id'] ='-1';
            // }
            $res_update = $this->Mod->update2('pm_type', array('idpm_type' => $id), $data);
            if ($res_update) {
                $res = [
                    'status' => '200',
                    'msg'       => 'Data Berhasil di Update'
                ];
            } else {
                $res = [
                    'status'    => '400',
                    'msg'       => 'Data Gagal Disimpan, pastikan semua terisi'
                ];
            }
            echo json_encode($res);
        } else {
            $res = [
                'status'    => '400',
                'msg'       => 'Data Gagal Disimpan, pastikan semua terisi'
            ];
            echo json_encode($res);
        }
    }

    public function SaveData()
    {

        $data = array_filter($_POST);
        //$data['parent_id'] = $data['id_jenisperangkat'];
        if (!empty($data)) {
           
            $data['status'] = 1;
            $this->db->insert('pm_type', $data);
            $res = [
                'status' => '200',
                'msg'       => 'Data Berhasil di Update'
            ];

            // echo "<pre>",print_r ( $data),"</pre>";
            echo json_encode($res);
        } else {
            $res = [
                'status'    => '400',
                'msg'       => 'Data Gagal Disimpan, pastikan semua terisi'
            ];
            echo json_encode($res);
        }
    }

    
    public function SaveDetail($id=null)
    {
        $data=[
            'id_pmtype'         => $id,
            'nama'              => $this->input->post('job_name'),
            'id_jenisperangkat' => $this->input->post('id_jenisperangkat'),
            'id_unit'           => sess()['unit'],
            'status'            => 1,
        ];
        $this->m_data->insertData('job_pm',$data);
        
    }
    function UpdateDetail($id=null){
        $data=[
            'nama'              => $this->input->post('job_name'),
            'id_jenisperangkat' => $this->input->post('id_jenisperangkat'),
            'id_unit'           => sess()['unit'],
            'status'            => 1,
        ];
        $this->m_data->updateData('job_pm',array('id_jobpm '=>$id ),$data);
    }

    public function DeleteDetail($id=null)
    {
        $data=[
            'STATUS'                    => 8
        ];
        $this->m_data->updateData('job_pm',array('id_jobpm '=>$id ),$data);
        
    }

  

   
}