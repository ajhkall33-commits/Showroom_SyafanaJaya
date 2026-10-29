<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Jadwal_pm extends CI_Controller {

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
        // $data["lokasi"] = $this->m_data->getWhere('terminal',array('parent_id ' =>'-1' ))->result_ARRAY();
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
        $type = $this->input->post('id_lokasi');
        if(isset($_FILES["perangkat"]["name"])){
			$path           = $_FILES["perangkat"]["tmp_name"];
			$object         = PHPExcel_IOFactory::load($path);
       
		
            $data           = array();
          
			foreach($object->getWorksheetIterator(1) as $worksheet => $value){
			    $highestRow = $value->getHighestRow();
              
                $lastColumn = $value->getHighestDataColumn(); 
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($lastColumn);
                //tipe 1 untuk T3
                //tipe 2 untuk non T3
                
               
                if ($type==1) {
                        //   Jadwal Bulanan
                        if ($worksheet == 0) {
                            for($col=2 ; $col<=$highestColumnIndex; $col++){
                                if (!empty($value->getCellByColumnAndRow($col, 10)->getValue())) {
                                    $tgl        = $value->getCellByColumnAndRow($col, 10)->getValue();
                                
                                    if ( $tgl<10) {
                                        $tgl = "0".$tgl;
                                    }
                                }else{
                                    $tgl='';
                                }
                            for ($row=12; $row <=$highestRow ; $row++) { 
                                if (!empty($value->getCellByColumnAndRow(0, $row)->getValue())) {
                                    $IP      = $value->getCellByColumnAndRow(1, $row)->getValue();
                                    $master    =  $this->m_data->getWhere('fasilitas',array('ip_address' => $IP ))->row_array();
                                    // 
                                    if (!empty($master)) {
                                                $id_perangkat = $master['id_fasilitas'];
                                            }else{
                                                $id_perangkat = '';
                                            
                                    }
                                }else{
                                    $id_perangkat = '';
                                }
                                
                                    if (!empty($value->getCellByColumnAndRow($col, $row)->getValue())) {
                                        $shift      = $value->getCellByColumnAndRow($col, $row)->getValue();

                                        $data[]=[
                                            'id_perangkat'  => $id_perangkat,
                                            'fasilitas'     => $value->getCellByColumnAndRow(0, $row)->getValue(),
                                            'tgl'           => $tgl,
                                            'shift'         => $shift,
                                            'type'          => 3,
                                            'bln_excel'     => '' ,
                                            'status'        => (!empty($id_perangkat) ? 1:0),
                                            'col'           => $col,
                                            'row'           => $row,
                                        ];
                                    }else{
                                        $shift      = '';
                                    }
                                
                                    

                            }
                            }  
                    }

                    //Jadwal Triwulan
                    if ($worksheet == 1) {
                        for($col=2 ; $col<=$highestColumnIndex; $col++){
                            if (!empty($value->getCellByColumnAndRow($col, 11)->getValue())) {
                                $tgl        = $value->getCellByColumnAndRow($col, 11)->getValue();
                            
                                if ( $tgl<10) {
                                    $tgl = "0".$tgl;
                                }
                            }else{
                                $tgl='';
                            }

                            
                                    if ($col >= 2 && $col<=12) {
                                        $col_bln= 2;
                                    }elseif ($col >= 13  && $col<=22) {
                                        $col_bln= 13;
                                    }elseif ($col >= 23 && $col<=32) {
                                        $col_bln= 23;
                                    }
                                    $bln_excel          = $value->getCellByColumnAndRow($col_bln, 10)->getValue();
                                    $bln_ary            = explode(",",$bln_excel);
                            for ($row=13; $row <=$highestRow ; $row++) { 
                                if (!empty($value->getCellByColumnAndRow(0, $row)->getValue())) {
                                    $IP      = $value->getCellByColumnAndRow(1, $row)->getValue();
                                    $master    =  $this->m_data->getWhere('fasilitas',array('ip_address' => $IP ))->row_array();
                                    if (!empty($master)) {
                                                $id_perangkat = $master['id_fasilitas'];
                                            }else{
                                                $id_perangkat = '';
                                            
                                    }
                                }else{
                                    $id_perangkat = '';
                                }
                                
                                    if (!empty($value->getCellByColumnAndRow($col, $row)->getValue())) {
                                        $shift              = $value->getCellByColumnAndRow($col, $row)->getValue();
                                    
                                        $data[]=[
                                            'id_perangkat'  => $id_perangkat,
                                            'lokasi'        => (!empty($lokasi) ? $lokasi:0),
                                            'fasilitas'     => $value->getCellByColumnAndRow(0, $row)->getValue(),
                                            'tgl'           => $tgl,
                                            'shift'         => $shift,
                                            'type'          => 4,
                                            'bln_excel'     => $bln_ary ,
                                            'status'        => (!empty($id_perangkat) ? 1:0),
                                            'col'           => $col,
                                            'row'           => $row,
                                        ];
                                    }else{
                                        $shift      = '';
                                    }
                                
                                    

                            }
                        }  
                    }
            
                    //Jadwal Semesteran
                    if ($worksheet == 2) {
                        for($col=2 ; $col<=$highestColumnIndex; $col++){
                            if (!empty($value->getCellByColumnAndRow($col, 11)->getValue())) {
                                $tgl        = $value->getCellByColumnAndRow($col, 11)->getValue();
                            
                                if ( $tgl<10) {
                                    $tgl = "0".$tgl;
                                }
                            }else{
                                $tgl='';
                            }

                            
                            if ($col >= 2 && $col<=6) {
                                $col_bln= 2;
                            }elseif ($col >= 7  && $col<=11) {
                                $col_bln= 7;
                            }elseif ($col >= 12 && $col<=16) {
                                $col_bln= 12;
                            }elseif ($col >= 17 && $col<=21) {
                                $col_bln= 17;
                            }
                            elseif ($col >= 22 && $col<=26) {
                                $col_bln= 22;
                            } elseif ($col >= 27 && $col<=31) {
                                $col_bln= 27;
                            }
                            $bln_excel          = $value->getCellByColumnAndRow($col_bln, 10)->getValue();
                            $bln_ary            = explode(",",$bln_excel);
                            
                            for ($row=13; $row <=$highestRow ; $row++) { 
                                if (!empty($value->getCellByColumnAndRow(0, $row)->getValue())) {
                                    $IP      = $value->getCellByColumnAndRow(1, $row)->getValue();
                                    $master    =  $this->m_data->getWhere('fasilitas',array('ip_address' => $IP ))->row_array();
                                    if (!empty($master)) {
                                                $id_perangkat = $master['id_fasilitas'];
                                            }else{
                                                $id_perangkat = '';
                                            
                                    }
                                }else{
                                    $id_perangkat = '';
                                }
                                
                                    if (!empty($value->getCellByColumnAndRow($col, $row)->getValue())) {
                                        $shift              = $value->getCellByColumnAndRow($col, $row)->getValue();
                                    
                                        $data[]=[
                                            'id_perangkat'  => $id_perangkat,
                                            'fasilitas'     => $value->getCellByColumnAndRow(0, $row)->getValue(),
                                            'tgl'           => $tgl,
                                            'shift'         => $shift,
                                            'type'          => 5,
                                            'bln_excel'     => $bln_ary ,
                                            'status'        => (!empty($id_perangkat) ? 1:0),
                                            'col'           => $col,
                                            'row'           => $row,
                                        ];
                                    }else{
                                        $shift      = '';
                                    }
                                
                                    

                            }
                        }  
                    }

                    //Jadwal Tahunan
                    if ($worksheet == 3) {
                        for($col=2 ; $col<=$highestColumnIndex; $col++){
                            if (!empty($value->getCellByColumnAndRow($col, 11)->getValue())) {
                                $tgl        = $value->getCellByColumnAndRow($col, 11)->getValue();
                            
                                if ( $tgl<10) {
                                    $tgl = "0".$tgl;
                                }
                            }else{
                                $tgl='';
                            }

                            
                            if ($col >= 2 && $col<=6) {
                                $col_bln= 2;
                            }elseif ($col >= 7  && $col<=11) {
                                $col_bln= 7;
                            }elseif ($col >= 12 && $col<=16) {
                                $col_bln= 12;
                            }elseif ($col >= 17 && $col<=21) {
                                $col_bln= 17;
                            }elseif ($col >= 22 && $col<=26) {
                                $col_bln= 22;
                            } elseif ($col >= 27 && $col<=31) {
                                $col_bln= 27;
                            }
                            $bln_excel          = $value->getCellByColumnAndRow($col_bln, 10)->getValue();
                            $bln_ary            = explode(",",$bln_excel);
                            
                            for ($row=13; $row <=$highestRow ; $row++) { 
                                if (!empty($value->getCellByColumnAndRow(0, $row)->getValue())) {
                                    $IP      = $value->getCellByColumnAndRow(1, $row)->getValue();
                                    $master    =  $this->m_data->getWhere('fasilitas',array('ip_address' => $IP ))->row_array();
                                    if (!empty($master)) {
                                                $id_perangkat = $master['id_fasilitas'];
                                            }else{
                                                $id_perangkat = '';
                                            
                                    }
                                }else{
                                    $id_perangkat = '';
                                }
                                
                                    if (!empty($value->getCellByColumnAndRow($col, $row)->getValue())) {
                                        $shift              = $value->getCellByColumnAndRow($col, $row)->getValue();
                                    
                                        $data[]=[
                                            'id_perangkat'  => $id_perangkat,
                                            'fasilitas'     => $value->getCellByColumnAndRow(0, $row)->getValue(),
                                            'tgl'           => $tgl,
                                            'shift'         => $shift,
                                            'type'          => 6,
                                            'bln_excel'     => $bln_ary ,
                                            'status'        => (!empty($id_perangkat) ? 1:0),
                                            'col'           => $col,
                                            'row'           => $row,
                                        ];
                                    }else{
                                        $shift      = '';
                                    }
                                
                                    

                            }
                        }  
                    }
                }else{
                        //   Jadwal Bulanan
                        if ($worksheet == 0) {
                            for($col=2 ; $col<=$highestColumnIndex; $col++){
                                if (!empty($value->getCellByColumnAndRow($col, 10)->getValue())) {
                                    $tgl        = $value->getCellByColumnAndRow($col, 10)->getValue();
                                
                                    if ( $tgl<10) {
                                        $tgl = "0".$tgl;
                                    }
                                }else{
                                    $tgl='';
                                }
                            for ($row=12; $row <=$highestRow ; $row++) { 
                                if (!empty($value->getCellByColumnAndRow(0, $row)->getValue())) {
                                    $IP      = $value->getCellByColumnAndRow(0, $row)->getValue();
                                    $master    =  $this->m_data->getWhere('fasilitas',array('nama_fasilitas' => $IP ))->row_array();
                                    // 
                                    if (!empty($master)) {
                                                $id_perangkat = $master['id_fasilitas'];
                                            }else{
                                                $id_perangkat = '';
                                            
                                    }
                                }else{
                                    $id_perangkat = '';
                                }
                                
                                    if (!empty($value->getCellByColumnAndRow($col, $row)->getValue())) {
                                        $shift      = $value->getCellByColumnAndRow($col, $row)->getValue();

                                        $data[]=[
                                            'id_perangkat'  => $id_perangkat,
                                            'fasilitas'     => $value->getCellByColumnAndRow(0, $row)->getValue(),
                                            'tgl'           => $tgl,
                                            'shift'         => $shift,
                                            'type'          => 3,
                                            'bln_excel'     => '' ,
                                            'status'        => (!empty($id_perangkat) ? 1:0),
                                            'col'           => $col,
                                            'row'           => $row,
                                        ];
                                    }else{
                                        $shift      = '';
                                    }
                                
                                    

                            }
                            }  
                        }

                        //Jadwal Triwulan
                        if ($worksheet == 1) {
                            for($col=2 ; $col<=$highestColumnIndex; $col++){
                                if (!empty($value->getCellByColumnAndRow($col, 11)->getValue())) {
                                    $tgl        = $value->getCellByColumnAndRow($col, 11)->getValue();
                                
                                    if ( $tgl<10) {
                                        $tgl = "0".$tgl;
                                    }
                                }else{
                                    $tgl='';
                                }

                                
                                        if ($col >= 2 && $col<=12) {
                                            $col_bln= 2;
                                        }elseif ($col >= 13  && $col<=22) {
                                            $col_bln= 13;
                                        }elseif ($col >= 23 && $col<=32) {
                                            $col_bln= 23;
                                        }
                                        $bln_excel          = $value->getCellByColumnAndRow($col_bln, 10)->getValue();
                                        $bln_ary            = explode(",",$bln_excel);
                                for ($row=13; $row <=$highestRow ; $row++) { 
                                    if (!empty($value->getCellByColumnAndRow(0, $row)->getValue())) {
                                        $IP      = $value->getCellByColumnAndRow(0, $row)->getValue();
                                        $master    =  $this->m_data->getWhere('fasilitas',array('nama_fasilitas' => $IP ))->row_array();
                                        if (!empty($master)) {
                                                    $id_perangkat = $master['id_fasilitas'];
                                                }else{
                                                    $id_perangkat = '';
                                                
                                        }
                                    }else{
                                        $id_perangkat = '';
                                    }
                                    
                                        if (!empty($value->getCellByColumnAndRow($col, $row)->getValue())) {
                                            $shift              = $value->getCellByColumnAndRow($col, $row)->getValue();
                                        
                                            $data[]=[
                                                'id_perangkat'  => $id_perangkat,
                                                'lokasi'        => (!empty($lokasi) ? $lokasi:0),
                                                'fasilitas'     => $value->getCellByColumnAndRow(0, $row)->getValue(),
                                                'tgl'           => $tgl,
                                                'shift'         => $shift,
                                                'type'          => 4,
                                                'bln_excel'     => $bln_ary ,
                                                'status'        => (!empty($id_perangkat) ? 1:0),
                                                'col'           => $col,
                                                'row'           => $row,
                                            ];
                                        }else{
                                            $shift      = '';
                                        }
                                    
                                        

                                }
                            }  
                        }
            
                        //Jadwal Semesteran
                        if ($worksheet == 2) {
                            for($col=2 ; $col<=$highestColumnIndex; $col++){
                                if (!empty($value->getCellByColumnAndRow($col, 11)->getValue())) {
                                    $tgl        = $value->getCellByColumnAndRow($col, 11)->getValue();
                                
                                    if ( $tgl<10) {
                                        $tgl = "0".$tgl;
                                    }
                                }else{
                                    $tgl='';
                                }

                                
                                if ($col >= 2 && $col<=6) {
                                    $col_bln= 2;
                                }elseif ($col >= 7  && $col<=11) {
                                    $col_bln= 7;
                                }elseif ($col >= 12 && $col<=16) {
                                    $col_bln= 12;
                                }elseif ($col >= 17 && $col<=21) {
                                    $col_bln= 17;
                                }
                                elseif ($col >= 22 && $col<=26) {
                                    $col_bln= 22;
                                } elseif ($col >= 27 && $col<=31) {
                                    $col_bln= 27;
                                }
                                $bln_excel          = $value->getCellByColumnAndRow($col_bln, 10)->getValue();
                                $bln_ary            = explode(",",$bln_excel);
                                
                                for ($row=13; $row <=$highestRow ; $row++) { 
                                    if (!empty($value->getCellByColumnAndRow(0, $row)->getValue())) {
                                        $IP      = $value->getCellByColumnAndRow(0, $row)->getValue();
                                        $master    =  $this->m_data->getWhere('fasilitas',array('nama_fasilitas' => $IP ))->row_array();
                                        if (!empty($master)) {
                                                    $id_perangkat = $master['id_fasilitas'];
                                                }else{
                                                    $id_perangkat = '';
                                                
                                        }
                                    }else{
                                        $id_perangkat = '';
                                    }
                                    
                                        if (!empty($value->getCellByColumnAndRow($col, $row)->getValue())) {
                                            $shift              = $value->getCellByColumnAndRow($col, $row)->getValue();
                                        
                                            $data[]=[
                                            'id_perangkat'  => $id_perangkat,
                                                'fasilitas'     => $value->getCellByColumnAndRow(0, $row)->getValue(),
                                                'tgl'           => $tgl,
                                                'shift'         => $shift,
                                                'type'          => 5,
                                                'bln_excel'     => $bln_ary ,
                                                'status'        => (!empty($id_perangkat) ? 1:0),
                                                'col'           => $col,
                                                'row'           => $row,
                                            ];
                                        }else{
                                            $shift      = '';
                                        }
                                    
                                        

                                }
                            }  
                        }

                        //Jadwal Tahunan
                        if ($worksheet == 3) {
                            for($col=2 ; $col<=$highestColumnIndex; $col++){
                                if (!empty($value->getCellByColumnAndRow($col, 11)->getValue())) {
                                    $tgl        = $value->getCellByColumnAndRow($col, 11)->getValue();
                                
                                    if ( $tgl<10) {
                                        $tgl = "0".$tgl;
                                    }
                                }else{
                                    $tgl='';
                                }

                                
                                if ($col >= 2 && $col<=6) {
                                    $col_bln= 2;
                                }elseif ($col >= 7  && $col<=11) {
                                    $col_bln= 7;
                                }elseif ($col >= 12 && $col<=16) {
                                    $col_bln= 12;
                                }elseif ($col >= 17 && $col<=21) {
                                    $col_bln= 17;
                                }elseif ($col >= 22 && $col<=26) {
                                    $col_bln= 22;
                                } elseif ($col >= 27 && $col<=31) {
                                    $col_bln= 27;
                                }
                                $bln_excel          = $value->getCellByColumnAndRow($col_bln, 10)->getValue();
                                $bln_ary            = explode(",",$bln_excel);
                                
                                for ($row=13; $row <=$highestRow ; $row++) { 
                                    if (!empty($value->getCellByColumnAndRow(0, $row)->getValue())) {
                                        $IP      = $value->getCellByColumnAndRow(0, $row)->getValue();
                                        $master    =  $this->m_data->getWhere('fasilitas',array('nama_fasilitas' => $IP ))->row_array();
                                        if (!empty($master)) {
                                                    $id_perangkat = $master['id_fasilitas'];
                                                }else{
                                                    $id_perangkat = '';
                                                
                                        }
                                    }else{
                                        $id_perangkat = '';
                                    }
                                    
                                        if (!empty($value->getCellByColumnAndRow($col, $row)->getValue())) {
                                            $shift              = $value->getCellByColumnAndRow($col, $row)->getValue();
                                        
                                            $data[]=[
                                            'id_perangkat'  => $id_perangkat,
                                                'fasilitas'     => $value->getCellByColumnAndRow(0, $row)->getValue(),
                                                'tgl'           => $tgl,
                                                'shift'         => $shift,
                                                'type'          => 6,
                                                'bln_excel'     => $bln_ary ,
                                                'status'        => (!empty($id_perangkat) ? 1:0),
                                                'col'           => $col,
                                                'row'           => $row,
                                            ];
                                        }else{
                                            $shift      = '';
                                        }
                                    
                                        

                                }
                            }  
                        }
                }
            }
          
            $insert    = array();
            foreach ($data as $key => $value) {
                if ($type ==1) {
                    $lokasi['id_lokasi']    = '3';
                }else{
                    $lokasi    =  $this->Mod->GetCustome("SELECT b.id_lokasi FROM fasilitas_detail a left join fasilitas b on b.id_fasilitas = a.id_fasilitas where a.id_perangkat = '".$value['id_perangkat']."'")->row_array();
                    echo "<pre>", print_r("SELECT b.id_lokasi FROM fasilitas_detail a left join fasilitas b on b.id_fasilitas = a.id_fasilitas where a.id_perangkat = '".$value['id_perangkat']."'"), "</pre>";
                }
                
                if (!empty($value['bln_excel'])) {
                    foreach ($value['bln_excel'] as $val2) {
                       
                        $insert[]=[
                            'id_perangkat'  => $value['id_perangkat'],
                            'id_lokasi'     => (!empty($lokasi) ?  $lokasi['id_lokasi']: ''),
                          
                            'fasilitas'     => $value['fasilitas'],
                            'tgl'           => $value['tgl'],
                            'bulan'         => bln_con($val2),
                            'tahun'         => date("Y"),
                            'shift'         => $value['shift'],
                            'idpm_type'     => $value['type'],
                            'status'        => 1,
                        ];
                        //$this->m_data->insertData('jadwal',$insert);
                     
                    }
                }else{
                    $insert[]=[
                        'id_perangkat'  => $value['id_perangkat'],
                        'id_lokasi'     => (!empty($lokasi) ?  $lokasi['id_lokasi']: ''),
                      
                        'fasilitas'     => $value['fasilitas'],
                        'tgl'           => $value['tgl'],
                        'bulan'         => '',
                        'tahun'         => date("Y"),
                        'shift'         => $value['shift'],
                        'idpm_type'     => $value['type'],
                        'status'        => 1,
                    ];
                    //$this->m_data->insertData('jadwal',$insert);
                  
                }
                
            }
            //   echo "<pre>", print_r($insert), "</pre>";
            // $this->db->insert_batch('jadwal', $insert);
           
           
        }
    }

   
}