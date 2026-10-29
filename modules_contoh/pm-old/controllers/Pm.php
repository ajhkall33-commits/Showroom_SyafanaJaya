<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Fill;


class Pm extends CI_Controller {

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
        $data["title"] = "Perangkat FIDS";
        $data["title_des"] = " List Data Perangkat FIDS";
        $data["content"] = "v_index";

        $data["data"] = $data;

        $this->load->view('template_v2', $data);
        // echo "<pre>",print_r ( $this->session->userdata()),"</pre>";
    }

    
    function LoadData(){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
       
         $data_res['perangkat'] = $this->m_data->getMasterPerangkat()->result_array();
         $data_res['rto']   = $this->m_data->getWhere('perangkat',array('status ' =>0 ))->num_rows();
         $data_res['replay'] =$this->m_data->getWhere('perangkat',array('status ' =>1 ))->num_rows();
        echo json_encode($data_res);
    }

   
    
    function CekIp(){
        $data_res = $this->m_data->getWhere('perangkat',array('updateDate =' =>null ))->row_array();
        $replay =1; 
        $respon=array();
		if (!empty($data_res['ip'])) {
           $ip=$data_res['ip'];
			exec("ping -n 3  $ip", $output, $status);
			if ($status == 0) {
				$respon=[
                    // 'ip'            => $ip,
                    'status'        => 1,
                    'updateDate'    => date("Y-m-d"),
                    'updateTime'    => date("h:i:sa")
                ];
                $this->m_data->updateData('perangkat', array('id' => $data_res['id']), $respon);
			}else{

                $respon=[
                    // 'ip'            => $ip,
                    'status'        => 0,
                    'updateDate'    => date("Y-m-d"),
                    'updateTime'    => date("h:i:sa")
                ];
                $this->m_data->updateData('perangkat', array('id' => $data_res['id']), $respon);
                $responLog=[
                    'ip'            => $ip,
                    'lokasi'        =>  $data_res['lokasi'],
                    'status'        => 'RTO',
                    'datecek'       => date("Y-m-d"),
                    'updateTime'    => date("h:i:sa")

                ];
                //$this->m_data->insertData('perangkat',$data);
			}
			
		}

        echo json_encode($respon);
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

    function UploadData(){
        if(isset($_FILES["perangkat"]["name"])){
			$path = $_FILES["perangkat"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
       
			
            $data=array();
			foreach($object->getWorksheetIterator(0) as $worksheet => $value){
			    $highestRow = $value->getHighestRow();
              
                $lastColumn = $value->getHighestDataColumn(); 
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($lastColumn);
            
              

               if ($worksheet == 0) {
                $bln_pm= 0;
                    for($col=2 ; $col<=$highestColumnIndex; $col++){
                       
                      for ($row=3; $row <=$highestRow ; $row++) { 
                           
                        
                            //  $tgl2        = $value->getCellByColumnAndRow($col, 12)->getValue();
                            $nama_fasilitas         =  $value->getCellByColumnAndRow(0, $row)->getValue();
                          
                            if (!empty($value->getCellByColumnAndRow($col, $row)->getValue())) {
                                $tgl            = $value->getCellByColumnAndRow($col, 2)->getValue();
                                $shift          = $value->getCellByColumnAndRow($col,$row)->getValue();
                                $cek_fasilitas   =  $this->Mod->getWhere('fasilitas',array('nama_fasilitas' =>$nama_fasilitas))->row_array();
                                if (!empty($cek_fasilitas)) {
                                    $id_fasilitas   = $cek_fasilitas['id_fasilitas'];
                                    $id_lokasi      =  $cek_fasilitas['id_lokasi'];
                                }else{
                                    $id_fasilitas ='';
                                    $id_lokasi ='';
                                }

                                $data[] =[
                                'id_perangkat'      => $id_fasilitas,
                                'id_lokasi'         => $id_lokasi,
                                'id_unit'           => '3',
                                'fasilitas'         =>  $nama_fasilitas,
                                'tgl'               => $tgl,
                                'bulan'             => '',
                                'tahun'             => '',
                                'shift'             => $shift,
                                'idpm_type'         => 1
                                ];

                             
                                // $tgl            = $value->getCellByColumnAndRow($col, 2)->getValue();
                            }
                            // $data=[
                            //     'shift'     => $shift,
                            //     'tanggal'   => $tgl,
                            //      'tanggal2'   => $tgl2,
                            //     'fasilitas' =>  $fasilitas,
                            //     'col'       => $col,
                            //     'row'       => $row
                            // ];
                            //echo "<pre>", print_r($data), "</pre>";
                           
                      }
                  
                    }
                    // echo "<pre>", print_r($data), "</pre>";
             
               }
          
              
			  }
			 
			  
           
               // $this->db->insert_batch('erp_customer', $data);
               echo "<pre>", print_r(count($data)), "</pre>";
               echo "<pre>", print_r($data), "</pre>";
               $this->db->insert_batch('jadwal', $data);
        }
    }

    function UploadHarian(){
        if(isset($_FILES["filelampiran"]["name"])){
			$path = $_FILES["filelampiran"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
       
			
            $data=array();
			foreach($object->getWorksheetIterator(0) as $worksheet => $value){
			    $highestRow = $value->getHighestRow();
              
                $lastColumn = $value->getHighestDataColumn(); 
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($lastColumn);
            
              

               if ($worksheet == 0) {
                $bln_pm= 0;
                    for($col=2 ; $col<=$highestColumnIndex; $col++){
                       
                      for ($row=4; $row <=$highestRow ; $row++) { 
                           
                        
                            //  $tgl2        = $value->getCellByColumnAndRow($col, 12)->getValue();
                            $nama_fasilitas      =  $value->getCellByColumnAndRow(0, $row)->getValue();
                            if (!empty($value->getCellByColumnAndRow($col, $row)->getValue())) {
                                $tgl            = $value->getCellByColumnAndRow($col, 2)->getValue();
                                $shift          = $value->getCellByColumnAndRow($col,$row)->getValue();
                                $cek_fasilitas   =  $this->Mod->getWhere('fasilitas',array('nama_fasilitas' =>$nama_fasilitas))->row_array();
                                if (!empty($cek_fasilitas)) {
                                    $id_fasilitas   = $cek_fasilitas['id_fasilitas'];
                                    $id_lokasi      =  $cek_fasilitas['id_lokasi'];
                                }else{
                                    $id_fasilitas ='';
                                    $id_lokasi ='';
                                }

                                $data=[
                                'id_perangkat'      => $id_fasilitas,
                                'id_lokasi'         => $id_lokasi,
                                'id_unit'           =>  sess()['unit'],
                                'fasilitas'         =>  $nama_fasilitas,
                                'tgl'               => $tgl,
                                'bulan'             => '',
                                'tahun'             =>  date("Y"),
                                'shift'             => $shift,
                                'idpm_type'         => 1
                                ];

                              
                                $cek_jadwal   =  $this->Mod->getWhere('jadwal',array(
                                        'id_perangkat'  => $id_fasilitas,
                                        'id_unit'       => sess()['unit'],
                                        'tgl'           => $tgl,
                                        'tahun'         => date("Y"),
                                        'idpm_type'         => 1
                                        ))->row_array();
                                if (!empty($cek_jadwal)) {
                                    
                                    echo "Update";
                                    $this->Mod->update2('jadwal',array('id_jadwal' => $cek_jadwal['id_jadwal']),$data);
                                }else{
                                    $this->db->insert('jadwal',$data);
                                }
                             
                                // $tgl            = $value->getCellByColumnAndRow($col, 2)->getValue();
                            }
                            // $data=[
                            //     'shift'     => $shift,
                            //     'tanggal'   => $tgl,
                            //      'tanggal2'   => $tgl2,
                            //     'fasilitas' =>  $fasilitas,
                            //     'col'       => $col,
                            //     'row'       => $row
                            // ];
                            //echo "<pre>", print_r($data), "</pre>";
                           
                      }
                  
                    }
                    // echo "<pre>", print_r($data), "</pre>";
             
               }
          
              
			  }
			 
			  
           
            //    // $this->db->insert_batch('erp_customer', $data);
            //    echo "<pre>", print_r(count($data)), "</pre>";
            //    echo "<pre>", print_r($data), "</pre>";
            //    $this->db->insert_batch('jadwal', $data);
        }
    }

    function UploadMingguanSA(){
        if(isset($_FILES["filelampiran"]["name"])){
			$path = $_FILES["filelampiran"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
       
			
            $data=array();
			foreach($object->getWorksheetIterator(0) as $worksheet => $value){
			    $highestRow = $value->getHighestRow();
              
                $lastColumn = $value->getHighestDataColumn(); 
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($lastColumn);
                $bulan                  =  $value->getCellByColumnAndRow(1, 3)->getValue();

                $bln_con= explode(",",$bulan);
               
              

               if ($worksheet == 0) {
                //
                    for($col=1 ; $col<=$highestColumnIndex; $col++){
                        for ($row=5; $row <=$highestRow ; $row++) { 
                              $nama_fasilitas      =  $value->getCellByColumnAndRow(0, $row)->getValue();
                              // 
                             
                              if (!empty($value->getCellByColumnAndRow($col, $row)->getValue())) {
                                  $tgl            = $value->getCellByColumnAndRow($col, 4)->getValue();
                                  $shift          = $value->getCellByColumnAndRow($col,$row)->getValue();
                                  $cek_fasilitas   =  $this->Mod->getWhere('fasilitas',array('nama_fasilitas' =>$nama_fasilitas))->row_array();
                                  if (!empty($cek_fasilitas)) {
                                      $id_fasilitas   = $cek_fasilitas['id_fasilitas'];
                                      $id_lokasi      =  $cek_fasilitas['id_lokasi'];
                                  }else{
                                      $id_fasilitas ='';
                                      $id_lokasi ='';
                                  }
                                  foreach ($bln_con as $key2 => $value2) {
                                    $data=[
                                    'id_perangkat'      => $id_fasilitas,
                                    'id_lokasi'         => $id_lokasi,
                                    'id_unit'           => sess()['unit'],
                                    'fasilitas'         => $nama_fasilitas,
                                    'tgl'               => $tgl,
                                    'bulan'             => bln_con($value2),
                                    'tahun'             => date("Y"),
                                    'shift'             => $shift,
                                    'idpm_type'         => 2
                                    ];
                                    }
                                    
                                    $cek_jadwal   =  $this->Mod->getWhere('jadwal',array(
                                        'id_perangkat'  => $id_fasilitas,
                                        'id_unit'       => sess()['unit'],
                                        'tgl'           => $tgl,
                                        'bulan'         => bln_con($value2),
                                        'tahun'         => date("Y"),
                                        'idpm_type'         => 2
                                        ))->row_array();

                                    if (!empty($cek_jadwal)) {
                                        echo "Update";
                                        $this->Mod->update2('jadwal',array('id_jadwal' => $cek_jadwal['id_jadwal']),$data);
                                    }else{
                                        $this->db->insert('jadwal',$data);
                                    }
                              }
                        }
                    
                      }
             
               }
          
              
			  }
			 
			  
           
               // $this->db->insert_batch('erp_customer', $data);
            //    echo "<pre>", print_r(count($data)), "</pre>";
            //    echo "<pre>", print_r($data), "</pre>";
            //    $this->db->insert_batch('jadwal', $data);
        }
    }

    function UploadBulananSWITCH(){
        if(isset($_FILES["filelampiran"]["name"])){
			$path = $_FILES["filelampiran"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
       
			
            $data=array();
			foreach($object->getWorksheetIterator(0) as $worksheet => $value){
			    $highestRow = $value->getHighestRow();
              
                $lastColumn = $value->getHighestDataColumn(); 
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($lastColumn);
                $bulan                  =  $value->getCellByColumnAndRow(1, 3)->getValue();

                $bln_con= explode(",",$bulan);
               
              

               if ($worksheet == 0) {
                //
                    for($col=1 ; $col<=$highestColumnIndex; $col++){
                        for ($row=5; $row <=$highestRow ; $row++) { 
                              $nama_fasilitas      =  $value->getCellByColumnAndRow(0, $row)->getValue();
                              // 
                             
                              if (!empty($value->getCellByColumnAndRow($col, $row)->getValue())) {
                                  $tgl            = $value->getCellByColumnAndRow($col, 4)->getValue();
                                  $shift          = $value->getCellByColumnAndRow($col,$row)->getValue();
                                  $cek_fasilitas   =  $this->Mod->getWhere('fasilitas',array('nama_fasilitas' =>$nama_fasilitas))->row_array();
                                  if (!empty($cek_fasilitas)) {
                                      $id_fasilitas   = $cek_fasilitas['id_fasilitas'];
                                      $id_lokasi      =  $cek_fasilitas['id_lokasi'];
                                  }else{
                                      $id_fasilitas ='';
                                      $id_lokasi ='';
                                  }
                                  foreach ($bln_con as $key2 => $value2) {
                                    $data=[
                                    'id_perangkat'      => $id_fasilitas,
                                    'id_lokasi'         => $id_lokasi,
                                    'id_unit'           => '3',
                                    'fasilitas'         =>  $nama_fasilitas,
                                    'tgl'               => $tgl,
                                    'bulan'             => bln_con($value2),
                                    'tahun'             => date("Y"),
                                    'shift'             => $shift,
                                    'idpm_type'         => 3
                                    ];

                                    $cek_jadwal   =  $this->Mod->getWhere('jadwal',array(
                                        'id_perangkat'  => $id_fasilitas,
                                        'id_unit'       => sess()['unit'],
                                        'tgl'           => $tgl,
                                        'bulan'         => bln_con($value2),
                                        'tahun'         => date("Y"),
                                        'idpm_type'     => 3
                                        ))->row_array();
                                        
                                    if (!empty($cek_jadwal)) {
                                        
                                        echo "Update";
                                        $this->Mod->update2('jadwal',array('id_jadwal' => $cek_jadwal['id_jadwal']),$data);
                                    }else{
                                        $this->db->insert('jadwal',$data);
                                    }
                                    }
  
                               
                                  // $tgl            = $value->getCellByColumnAndRow($col, 2)->getValue();
                              }
                              // $data=[
                              //     'shift'     => $shift,
                              //     'tanggal'   => $tgl,
                              //      'tanggal2'   => $tgl2,
                              //     'fasilitas' =>  $fasilitas,
                              //     'col'       => $col,
                              //     'row'       => $row
                              // ];
                              // echo "<pre>", print_r($data), "</pre>";
                             
                        }
                    
                      }
             
                    // echo "<pre>", print_r($data), "</pre>";
             
               }
          
              
			  }
			 
			  
           
               // $this->db->insert_batch('erp_customer', $data);
            //    echo "<pre>", print_r(count($data)), "</pre>";
            //    echo "<pre>", print_r($data), "</pre>";
            //    $this->db->insert_batch('jadwal', $data);
        }
    }

    
}