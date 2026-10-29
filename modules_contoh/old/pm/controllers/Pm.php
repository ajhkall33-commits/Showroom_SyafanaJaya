<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Pm extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->library('excel');
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
       
			// foreach($object->getWorksheetIterator() as $worksheet){
            //     $highestRow = $worksheet->getHighestRow();
            //     echo $highestColumn = $worksheet->getHighestColumn();
              
            // //   for ($i=0; $i < ; $i++) { 
            // //     # code...
            // //   }
            //     for($row=13 ; $row<=$highestRow; $row++){
            //      echo $pk_id      = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
            //      echo "<br>";
                 
                  
                 
            //     }
            // }
           
			foreach($object->getWorksheetIterator(1) as $worksheet => $value){
			    $highestRow = $value->getHighestRow();
              
                $lastColumn = $value->getHighestDataColumn(); 
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($lastColumn);
            
                $data=array();

               if ($worksheet == 1) {
                $bln_pm= 0;
                    for($col=2 ; $col<=$highestColumnIndex; $col++){
                       
                      for ($row=15; $row <=$highestRow ; $row++) { 
                            $shift      = $value->getCellByColumnAndRow($col, $row)->getValue();
                            $tgl        = $value->getCellByColumnAndRow($col, 12)->getValue();
                         
                           $arr_bln=array();
                           $arr_bln[]=[
                            Fmonth(1),
                            Fmonth(4),
                            Fmonth(7),
                            Fmonth(10),
                        ];
                        $arr_bln[]=[
                            Fmonth(2),
                            Fmonth(5),
                            Fmonth(8),
                            Fmonth(11),
                         
                        ];
                        $arr_bln[]=[
                            Fmonth(3),
                            Fmonth(6),
                            Fmonth(9),
                            Fmonth(12),
                         
                        ];
                           if (!empty($shift) ) {
                             $lokasi    = $value->getCellByColumnAndRow(0, $row)->getValue();
                             $ip        = $value->getCellByColumnAndRow(1, $row)->getValue();
                           
                             $master    =  $this->m_data->getWhere('perangkat',array('ip' => $ip ))->row_array();
                             if (!empty($master)) {
                                $id_perangkat = $master['id'];
                             }else{
                                $id_perangkat = '';
                               
                             }
                          
                            $data=[
                                'id_perangkat'  => $id_perangkat,
                                'lokasi'    => (!empty($lokasi) ? $lokasi:0),
                                'tgl'       => $tgl,
                                'bln'       => $bln_pm++,
                                'shift'     => $shift,
                                'type'      => 2,
                                'status'    => (!empty($id_perangkat) ? 1:0),
                                'col'       => $col,
                                'row'       => $row

                            ];
                             echo "<pre>", print_r($data), "</pre>";
                            
                                // echo "<pre>", print_r($data), "</pre>";
                            // $this->m_data->insertData('jadwal',$data);
                           }else {
                            
                            echo "<pre>", print_r(" ganti tanggal"), "</pre>";
                           
                           }
                          
                      }
                  
                    }
                    // echo "<pre>", print_r($data), "</pre>";
             
               }
          
              
			  }
			 
			  
           
               // $this->db->insert_batch('erp_customer', $data);
           
        }
    }
}