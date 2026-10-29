<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Fill;

class Uploader extends CI_Controller {

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
        $data["title"] = "Uploader Data ";
        $data["title_des"] = "Modul untuk upload data";
        $data["content"] = "v_index";

        $data["data"] = $data;

        $this->load->view('template_v2', $data);
        // echo "<pre>",print_r ( $this->session->userdata()),"</pre>";
    }

    
    function LoadData(){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
        // if (strtotime(date('H:i')) >= strtotime('07:00') && strtotime(date('H:i')) <= strtotime('18:59')  ) {
        //     $shift ='PS';
        //     $dateNow = date("d");
        // }else{
        //         if (strtotime(date('H:i')) >= strtotime('00:01') && strtotime(date('H:i')) <=strtotime('06:59')) {
                
        //             $dateNow = date("d")-1;
        //         }else {
        //             $dateNow = date("d");
        //         }
            
        //         $shift ='M';
        // }

        // $data_res['petugas']        = $this->m_data->getWhere('jadwal_kerja',array('tanggal' => date("Y-m-d"),'shift' => $shift,'id_unit' => sess()['unit']))->result_array();
       
        // foreach ($data_res['petugas'] as $key => $value) {
        //     $user = $this->m_data->getWhere('user',array('id' => $value['id_user']))->row_array();
        //     $data_res['petugas'][$key ]['nama_user']=  $user['nama'];
        // }
        // echo json_encode($data_res);
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
        if(isset($_FILES["filelampiran"]["name"])){
			$path = $_FILES["filelampiran"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
       
			
            $data           = array();
            $data_triwulan  = array();
            $data_sms       = array();
            $data_thn       = array();
            $datacctv_bulanan = array();
			foreach($object->getWorksheetIterator(1) as $worksheet => $value){
			    $highestRow = $value->getHighestRow();
              
                $lastColumn = $value->getHighestDataColumn(); 
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($lastColumn);
         
                   if ($worksheet == 0) {
                        for($col=3 ; $col<=$highestColumnIndex; $col++){
                        
                          for ($row=7; $row <=$highestRow ; $row++) { 
                                $shift      = $value->getCellByColumnAndRow($col, $row)->getValue();

                                if (!empty($value->getCellByColumnAndRow($col, 5)->getValue())) {
                                    $tgl        = $value->getCellByColumnAndRow($col, 5)->getValue();
                                
                                    if ( $tgl<10) {
                                        $tgl = "0".$tgl;
                                    }
                                }else{
                                    $tgl='';
                                }
                             
                               if (!empty($shift) ) {
                                $nik    = $value->getCellByColumnAndRow(1, $row)->getValue();
                                $nama    = $value->getCellByColumnAndRow(2, $row)->getValue();
                                $master    =  $this->Mod->getWhere('user',array('nik' =>$nik))->row_array();
                                if (!empty($master)) {
                                    $id_user = $master['id'];
                                 }else{
                                    $id_user = '';
                                
                                 }
                                $insert=[
                                    'tanggal'       => date("Y-").$_POST['bulan'].'-'.$tgl,
                                    'id_user'       => $id_user,
                                    'shift'         => $shift,
                                    // 'nama'          => $master['nama'],
                                    'id_unit'       => $_POST['id_unit'],
                                   
                                ];
                                $this->m_data->insertData('jadwal_kerja',$insert);
                            //    echo "<pre>", print_r( $insert), "</pre>";
                                
                                
                               }
                          }
                        }
                   }
             
           
            }
        }

    
 
    }

    function DownloadFormat(){
        // phpinfo(); 
        // $tableHead = [
        //     'font'=>[
        //         'color'=>[
        //             'rgb'=>'FFFFFF'
        //         ],
        //         'bold'=>true,
        //         'size'=>11
        //     ],
        //     'fill'=>[
        //         'fillType' => Fill::FILL_SOLID,
        //         'startColor' => [
        //             'rgb' => '00BDFF'
        //         ]
        //     ],
        //     'borders' => [
        //         'allBorders' => [
        //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        //             'color' => ['argb' => '000000 '],
        //         ],
        //     ],
        // ];

        // $evenRow = [
           
        //     'borders' => [
        //         'allBorders' => [
        //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        //             'color' => ['argb' => '000000 '],
        //         ],
        //     ],
        // ];

        // $oddRow = [
        //     'borders' => [
        //          'allBorders' => [
        //              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        //              'color' => ['argb' => '000000 '],
        //          ],
        //      ],
        // ];

        
        // $fileName = 'Target Realisasi KPI.xlsx';  
        // $spreadsheet = new Spreadsheet();
        // $sheet = $spreadsheet->getActiveSheet();
        // $spreadsheet->getActiveSheet()->getStyle('A1:H1')->applyFromArray($tableHead);
        // //setting column width
      
        // $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(11);
        // $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(11);
        // $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(11);
        // $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(11);
        // $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(60);
      
        // $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        
        // $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(10);
       
        // $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        
        // $spreadsheet->getActiveSheet()->getStyle('C')
        //             ->getAlignment()->setWrapText(true);

        // $spreadsheet->getActiveSheet()->getStyle('G')
        //             ->getAlignment()->setWrapText(true);  

        // $spreadsheet->getActiveSheet()->getStyle('H')
        //             ->getAlignment()->setWrapText(true);  

        // $spreadsheet->getActiveSheet()->getStyle('A:H')
        //             ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        // $spreadsheet->getActiveSheet()->getStyle('A1:H1')
        //             ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        // $spreadsheet->getActiveSheet()->getStyle('A1:H1')
        //             ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        
        // $spreadsheet->getActiveSheet()->getStyle('B')
        //             ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        // $spreadsheet->getActiveSheet()->getStyle('B')
        //             ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        // $spreadsheet->getActiveSheet()->getStyle('D')
        //             ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        // $spreadsheet->getActiveSheet()->getStyle('D')
        //             ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        // $spreadsheet->getActiveSheet()->getStyle('F')
        //             ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        // $spreadsheet->getActiveSheet()->getStyle('F')
        //             ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        // $spreadsheet->getActiveSheet()->getColumnDimension('A')->setVisible(false);

        // $sheet->setCellValue('A1', 'PK_ID');
        // $sheet->setCellValue('B1', 'Tahun');
		// $sheet->setCellValue('C1', 'Tipe');
        // $sheet->setCellValue('D1', 'No');
        // $sheet->setCellValue('E1', 'Indikator Kinerja');
        // $sheet->setCellValue('F1', 'Jenis');
        // $sheet->setCellValue('G1', 'Semester 1');
		// $sheet->setCellValue('H1', 'Semester 2');     
        // $rows = 2;
        // // foreach ($data_res as $key => $value) {
        // //    foreach ($value['detail'] as $key2 => $val) {
        // //     $sheet->setCellValue('A' . $rows, $val['PK_ID']);
        // //     $sheet->setCellValue('B' . $rows, $value['TAHUN']);
        // //     $sheet->setCellValue('C' . $rows, $val['TIPE']);
        // //     $sheet->setCellValue('D' . $rows, $value['NO']);
        // //     $sheet->setCellValue('E' . $rows, $value['INDIKATOR_KINERJA']);
        // //     $sheet->setCellValue('F' . $rows, $val['JENIS']);
        // //     $spreadsheet->getActiveSheet()->getRowDimension($rows)->setRowHeight(35, 'pt');
        // //     if( $rows % 2 == 0 ){
		// //     //even row
		// //         $spreadsheet->getActiveSheet()->getStyle('A'.$rows.':H'.$rows)->applyFromArray($evenRow);
        // //     }else{
        // //         //odd row
        // //         $spreadsheet->getActiveSheet()->getStyle('A'.$rows.':H'.$rows)->applyFromArray($oddRow);
        // //     }
        // //     $rows++;
        // //    }
        // // }
       
        // $writer = new Xlsx($spreadsheet);
		// $writer->save("upload/jadwal_kerja/".$fileName);
		// header("Content-Type: application/vnd.ms-excel");
        // redirect(base_url()."/upload/".$fileName);   
    }


    function UploadMerk(){
        $id_cctv    =  $this->Mod->getWhere('jenis_perangkat',array('nama' =>'CCTV'))->row_array();
        if(isset($_FILES["filelampiran"]["name"])){
			$path = $_FILES["filelampiran"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
       
			
            $insert           = array();
          
			foreach($object->getWorksheetIterator(1) as $worksheet => $value){
			    $highestRow = $value->getHighestRow();
              
                $lastColumn = $value->getHighestDataColumn(); 
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($lastColumn);
         
                   if ($worksheet == 0) {
                        for ($row=2; $row <=$highestRow ; $row++) { 
                            $merk      = $value->getCellByColumnAndRow(3, $row)->getValue();
                            $model     = $value->getCellByColumnAndRow(4, $row)->getValue();
                            $tahun     = $value->getCellByColumnAndRow(7, $row)->getValue();
                            $power     = $value->getCellByColumnAndRow(14, $row)->getValue();
                            $res1     = $value->getCellByColumnAndRow(15, $row)->getValue();
                            $res2     = $value->getCellByColumnAndRow(16, $row)->getValue();
                            $merk_      =  ucfirst($merk);
                            $master    =  $this->Mod->getWhere('merk',array('nama' =>$merk_))->row_array();
                            if (!empty($master)) {
                               $nama=  $master['id'];
                               $insert_merk=[
                                'nama' =>  $merk_ 
                               ];
                                $this->Mod->update2('merk',array('id' => $master['id']),$insert_merk);
                            }else{
                                $insert_merk=[
                                    'nama' =>  $merk_ 
                                   ];
                                 $this->db->insert('merk',$insert_merk);
                                 $nama= $this->db->insert_id();
                            }
                            echo "<pre>",print_r ($insert_merk),"</pre>";

                            $cek_model    =  $this->Mod->getWhere('model',array('nama_perangkat' =>$model))->row_array();
                           
                            if (empty($cek_model)) {
                                $insert=[
                                    'id_jenisperangkat' => $id_cctv['id_jenisperangkat'],
                                    'merk_id'           => $nama,
                                    'nama_perangkat'    => $model,
                                    'tahun'             => $tahun,
                                    'id_unit'           => sess()['unit'],
                                    'status'            => '0'
                                ];

                                $this->db->insert('model',$insert);
                                 // $update = $this->Mod->update2('merk',array('id' => $master['id']),$insert);
                             }else{
                                $insert=[
                                    'id_jenisperangkat' => $id_cctv['id_jenisperangkat'],
                                    'merk_id'           => $nama,
                                    'nama_perangkat'    => $model,
                                    'tahun'             => $tahun,
                                    'id_unit'           => sess()['unit'],
                                    'status'            => '0'
                                ];
                                $update = $this->Mod->update2('model',array('id_perangkat' => $cek_model['id_perangkat']),$insert);
                                
                                $cek_detail = $this->Mod->getWhere('master_perangkat_detail',array('id_jenisperangkat' =>$id_cctv['id_jenisperangkat']))->result_array();
                              
                                foreach ($cek_detail as $key2 => $value2) {
                                    
                                    $model_spek =[
                                        'id_perangkat'              => $cek_model['id_perangkat'],
                                        'idmaster_detail_perangkat' => $value2['idmaster_detail_perangkat'],
                                        'status'                    => '1',
                                    ];
                                    if ( $value2['nama'] =='POWER CONSUMPTION (WATT)') {
                                      $model_spek['nama'] =$power;
                                    }elseif ( $value2['nama'] =='RESOLUSI IMAGE 1') {
                                        $model_spek['nama'] =$res1;
                                    }elseif ( $value2['nama'] =='RESOLUSI IMAGE 2') {
                                        $model_spek['nama'] =$res2;
                                    }

                                    $cek_detail_spek =$this->Mod->getWhere('model_spec',array('id_perangkat' =>$cek_model['id_perangkat'],'idmaster_detail_perangkat'=>$value2['idmaster_detail_perangkat']))->row_array();
                                   
                                    if (empty($cek_detail_spek)) {
                                        $this->db->insert('model_spec',$model_spek);
                                        echo "Insert";
                                    }else{
                                        echo "<pre>",print_r ($model_spek),"</pre>";
                                    }
                                  

                                    // model_spec
                                }
                              
                             }
 
                            
                        
                              // $this->m_data->insertData('jadwal_kerja',$insert);
                          
                        }
                   }
             
           
            }
          
        }
    
    }

    function UploadPerangkat(){
        $id_cctv    =  $this->Mod->getWhere('jenis_perangkat',array('nama' =>'CCTV'))->row_array();
        if(isset($_FILES["filelampiran"]["name"])){
			$path = $_FILES["filelampiran"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
       
			
            $insert           = array();
          
			foreach($object->getWorksheetIterator(1) as $worksheet => $value){
			    $highestRow = $value->getHighestRow();
              
                $lastColumn = $value->getHighestDataColumn(); 
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($lastColumn);
         
                   if ($worksheet == 0) {
                        for ($row=2; $row <=$highestRow ; $row++) { 
                            // $nama_kamera        = $value->getCellByColumnAndRow(3, $row)->getValue();
                            $merk               = $value->getCellByColumnAndRow(3, $row)->getValue();
                            $sn                 = $value->getCellByColumnAndRow(6, $row)->getValue();
                            $model              = $value->getCellByColumnAndRow(4, $row)->getValue();
                            $nama_kamera = $merk." ".$model ;
                            // $tahun     = $value->getCellByColumnAndRow(7, $row)->getValue();
                            // $power     = $value->getCellByColumnAndRow(14, $row)->getValue();
                            // $res1     = $value->getCellByColumnAndRow(15, $row)->getValue();
                            // $res2     = $value->getCellByColumnAndRow(16, $row)->getValue();
                           
                            $merk_      =  ucfirst($merk);
                            $master    =  $this->Mod->getWhere('merk',array('nama' =>$merk_))->row_array();
                            if (!empty($master)) {
                               $id_merk=  $master['id'];
                                // $update = $this->Mod->update2('merk',array('id' => $master['id']),$insert);
                            }else{
                                $id_merk=  '';
                                // $this->db->insert('merk',$insert);
                            }

                            $m_model    =  $this->Mod->getWhere('model',array('nama_perangkat' =>$model))->row_array();
                            if (!empty($m_model)) {
                                $id_model = $m_model['id_perangkat'];
                            }else{
                                $id_model = '';
                            }
                            $perangkat=[
                                'id_jenisperangkat'     => $id_cctv['id_jenisperangkat'],
                                'id_unit'               => sess()['unit'],
                                'nama_perangkat'        => $nama_kamera,
                                'merk_id'               => $id_merk ,
                                'serial_number'         => $sn ,
                                'id_model'              => $id_model,
                                'type'                  => 1  ,
                                'status'                => 0 ,
                            ];
                            $this->db->insert('perangkat',$perangkat);
                            $insert_id = $this->db->insert_id();
                            // echo "<pre>",print_r ($perangkat),"</pre>";
                            // echo "=================== Perangkat Detail ===============\n";
                            $m_model_detail    =  $this->Mod->getWhere('model_spec',array('id_perangkat' =>$id_model))->result_array();
                            foreach ($m_model_detail as $key3 => $value3) {
                                $perangkat_detail =[
                                    'id_perangkat'                  => $insert_id,
                                    'idmaster_detail_perangkat'     => $value3['idmaster_detail_perangkat'],
                                    'nama'                          => $value3['nama'],
                                    'status'                        => '0',
                                ];    
                                $this->db->insert('perangkat_detail',$perangkat_detail);
                                // echo "<pre>",print_r ($perangkat_detail),"</pre>";
                            }
                           
                            // echo "=================== ===============\n";
                              // $this->m_data->insertData('jadwal_kerja',$insert);
                          
                        }
                   }
             
           
            }
          
        }
    
    }

    function UploadFasilitas(){
        $id_cctv    =  $this->Mod->getWhere('jenis_perangkat',array('nama' =>'CCTV'))->row_array();
        if(isset($_FILES["filelampiran"]["name"])){
			$path = $_FILES["filelampiran"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
       
			
            $insert           = array();
          
			foreach($object->getWorksheetIterator(1) as $worksheet => $value){
			    $highestRow = $value->getHighestRow();
              
                $lastColumn = $value->getHighestDataColumn(); 
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($lastColumn);
         
                   if ($worksheet == 0) {
                        for ($row=2; $row <=$highestRow ; $row++) { 
                            // $nama_kamera        = $value->getCellByColumnAndRow(3, $row)->getValue();
                            $nama_fasilitas     = $value->getCellByColumnAndRow(2, $row)->getValue();
                            $IP                 = $value->getCellByColumnAndRow(5, $row)->getValue();
                            $terminal           = $value->getCellByColumnAndRow(8, $row)->getValue();
                            $sn                 = $value->getCellByColumnAndRow(6, $row)->getValue();
                          
                           
                            // $merk_      =  ucfirst($merk);
                          

                          //  $m_model    =  $this->Mod->getWhere('model',array('nama_perangkat' =>$model))->row_array();
                            if (!empty($m_model)) {
                                $id_model = $m_model['id_perangkat'];
                            }else{
                                $id_model = '';
                            }


                            $fasilitas=[
                                'nama_fasilitas'    => $nama_fasilitas,
                                'terminal'          =>  ucfirst($terminal),
                                // 'zona'              => $IP,
                                'ip_address'        => $IP ,
                                'id_unit'           => sess()['unit'] ,
                                'status'            => '1' ,
                            ];
                            // echo "<pre>",print_r ($fasilitas),"</pre>";
                            $cek_fasilitas   =  $this->Mod->getWhere('fasilitas',array('nama_fasilitas' =>$nama_fasilitas))->row_array();
                            if (!empty($cek_fasilitas)) {
                                echo "Update";
                                $this->Mod->update2('fasilitas',array('id_fasilitas' => $cek_fasilitas['id_fasilitas']),$fasilitas);
                            }else{
                                $this->db->insert('fasilitas',$fasilitas);
                            }
                          
                            $insert_id = $this->db->insert_id();
                            $m_perangkat    =  $this->Mod->getWhere('perangkat',array('serial_number' =>$sn))->row_array();

                            if (!empty( $m_perangkat)) {
                               $id_erangkat =  $m_perangkat['id_perangkat'];
                            }else{
                                $id_erangkat =  '';
                            }
                            $fasilitas_detail =[
                               'id_fasilitas'                  => $insert_id,
                                'id_perangkat'                  => $id_erangkat,
                                'id_jenisperangkat'             => $id_cctv['id_jenisperangkat'],
                                'status'                        => '0',
                            ];  
                             
                            $this->db->insert('fasilitas_detail',$fasilitas_detail);
                            // echo "<pre>",print_r ($perangkat),"</pre>";
                          
                          
                        }
                   }
             
           
            }
          
        }
    
    }

    


}
