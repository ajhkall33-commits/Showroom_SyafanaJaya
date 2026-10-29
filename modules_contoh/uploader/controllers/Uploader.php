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
        $this->load->model("m_data");
        $this->load->model("m_data", "Mod");
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
			$object = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
       
			
            $data           = array();
            $data_triwulan  = array();
            $data_sms       = array();
            $data_thn       = array();
            $datacctv_bulanan = array();
			foreach($object->getWorksheetIterator() as $worksheet => $value){
			    $highestRow = $value->getHighestRow();
              
                $lastColumn = $value->getHighestDataColumn(); 
                $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($lastColumn);
         
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

    function DownloadFormat($fs =null , $unit){
        $jenis = $this->Mod->getWhere('jenis_perangkat',array('id_unit' => $unit))->result_array();
       
        foreach ($jenis as $key => $value) {
            
            $detail = $this->Mod->getWhere('master_perangkat_detail',array('id_jenisperangkat' =>$value['id_jenisperangkat']))->result_array();
            // echo "<pre>",print_r ($detail),"</pre>";
        }
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
			$object = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
       
			
            $insert           = array();
          
			foreach($object->getWorksheetIterator() as $worksheet => $value){
			    $highestRow = $value->getHighestRow();
              
                $lastColumn = $value->getHighestDataColumn(); 
                $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($lastColumn);
         
                   if ($worksheet == 0) {
                        for ($row=2; $row <=$highestRow ; $row++) { 
                            $merk      = $value->getCellByColumnAndRow(4, $row)->getValue();
                            $model     = $value->getCellByColumnAndRow(5, $row)->getValue();
                            $tahun     = $value->getCellByColumnAndRow(8, $row)->getValue();
                            $power     = $value->getCellByColumnAndRow(15, $row)->getValue();
                            $res1     = $value->getCellByColumnAndRow(16, $row)->getValue();
                            $res2     = $value->getCellByColumnAndRow(17, $row)->getValue();
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

        // $id_unit    =  $this->Mod->getWhere('jenis_perangkat',array('nama' =>$_POST['id_unit']))->row_array();
        if(isset($_FILES["filelampiran"]["name"])){
			$path = $_FILES["filelampiran"]["tmp_name"];
			$object = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
            $insert           = array();
            $insert_detail           = array();
			foreach($object->getWorksheetIterator() as $worksheet => $value){
			    $highestRow = $value->getHighestRow();
              
                $lastColumn = $value->getHighestDataColumn(); 
                $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($lastColumn);
         
                   if ($worksheet == 0) {
                        
                        
                        for ($row=2; $row <=$highestRow ; $row++) { 
                            $nama_perangkat     = $value->getCellByColumnAndRow(4, $row)->getValue();
                            $jenis              = $value->getCellByColumnAndRow(5, $row)->getValue();
                            $merk               = $value->getCellByColumnAndRow(6, $row)->getValue();
                            $model              = $value->getCellByColumnAndRow(7, $row)->getValue();
                            $sn                 = $value->getCellByColumnAndRow(8, $row)->getValue();
                            $tahun              = $value->getCellByColumnAndRow(10, $row)->getValue();
                                
                           
                            $master_jenis_perangkat       =  $this->Mod->getWhere('jenis_perangkat',array('nama' =>$jenis,'id_unit' => $_POST['id_unit'] ))->row_array();
                            
                            if (empty($master_jenis_perangkat )) {
                                $data_jenis=['nama' => $jenis,'id_unit' =>$_POST['id_unit'],'status' => 1];
                                if (!empty($data_jenis['nama'])) {
                                    $this->db->insert('jenis_perangkat',$data_jenis);
                                    $id_jenis = $this->db->insert_id();
                                    echo "Jenis Kosong";
                                    $id_jenis = '';
                                }else{
                                    $id_jenis = '';
                                }
                            }else{
                                $id_jenis =  $master_jenis_perangkat['id_jenisperangkat'];
                            }

                            
                            if (!empty($merk)) {
                                $master_merek       =  $this->Mod->getWhere('merk',array('nama' =>$merk))->row_array();
                                if (empty($master_merek )) {
                                    $data_merk=['nama' => $merk ];
                                    $this->db->insert('merk',$data_merk);
                                    $id_merk = $this->db->insert_id();
                                }else{
                                    $id_merk =  $master_merek['id'];
                                }
                            }else{
                                $id_merk ="";
                            }

                            if (!empty($model)) {
                                $master_model       =  $this->Mod->getWhere('model',array('nama_perangkat' =>$model, 'merk_id'=>  $id_merk))->row_array();
                                if (empty($master_model )) {
                                    $data_model=[
                                        'nama_perangkat'    => $model,
                                        'merk_id'           => $id_merk,
                                        'id_jenisperangkat' => $id_jenis,
                                        'tahun'             => $tahun,
                                        'status'            => 0
                                    ];
                                    $this->db->insert('model',$data_model);
                                    $id_model = $this->db->insert_id();
                                }else{
                                    $id_model =  $master_model['id_perangkat'];
                                }
                            }else{
                                $id_model = '';
                            }
                            
                            $insert=[
                                'nama_perangkat'        => $nama_perangkat,
                                'id_jenisperangkat'     => $id_jenis  ,
                                'merk_id'               => $id_merk,
                                'id_model'              => $id_model,
                                'serial_number'         =>  $sn,
                                'id_unit'               => $_POST['id_unit'],
                                'status'                => 0
                            ];
                            $cek = $this->Mod->getWhere('perangkat',array('nama_perangkat' =>$nama_perangkat,'id_unit' => $_POST['id_unit'],'id_jenisperangkat' => $id_jenis,'status !='=> '8'))->row_array();
                            if (empty( $cek)) {
                                 
                                    $this->db->insert('perangkat',$insert);
                                    $id_perangkat= $this->db->insert_id();

                                    $power          = $value->getCellByColumnAndRow(12, 1)->getValue();
                                    $val_power      = $value->getCellByColumnAndRow(12, $row)->getValue();

                                    $buatan         = $value->getCellByColumnAndRow(9, 1)->getValue();
                                    $val_buatan     = $value->getCellByColumnAndRow(9, $row)->getValue();

                                    $no_serti       = $value->getCellByColumnAndRow(13, 1)->getValue();
                                    $val_no_serti   = $value->getCellByColumnAndRow(13, $row)->getValue();

                                    if ($power =='POWER CONSUMPTION' && $val_power!= ''  ) {
                                        $master_detail_prop      =  $this->Mod->getWhere('master_perangkat_detail',array('nama' =>'POWER CONSUMPTION (WATT)','id_jenisperangkat' => $id_jenis ))->row_array();
                                        $in_power = $master_detail_prop['idmaster_detail_perangkat'];
                                        $insert_detail['idmaster_detail_perangkat']= $in_power;
                                        $insert_detail['nama'] =  $val_no_serti;
                                        $insert_detail['id_perangkat'] =  $id_perangkat;
                                        $insert_detail['status'] =  '1';
                                        $this->db->insert('perangkat_detail',$insert_detail);
                                        // id_perangkat
                                    }

                                    if ($buatan =='BUATAN' && $val_buatan != ''  ) {
                                        $master_detail_prop      =  $this->Mod->getWhere('master_perangkat_detail',array('nama' =>'Buatan','id_jenisperangkat' => $id_jenis ))->row_array();
                                        $in_buat =$master_detail_prop['idmaster_detail_perangkat'];
                                        $insert_detail['idmaster_detail_perangkat']= $in_buat;
                                        $insert_detail['nama'] =  $val_buatan;
                                        $insert_detail['id_perangkat'] =  $id_perangkat;
                                        $insert_detail['status'] =  '1';
                                        
                                        $this->db->insert('perangkat_detail',$insert_detail);
                                    }

                                    if ($no_serti =='SERTIFIKASI' && $val_no_serti != '' ) {
                                        $master_detail_prop      =  $this->Mod->getWhere('master_perangkat_detail',array('nama' =>'No. Sertifikasi','id_jenisperangkat' => $id_jenis ))->row_array();
                                        $in_serti =$master_detail_prop['idmaster_detail_perangkat'];
                                        $insert_detail['idmaster_detail_perangkat']= $in_serti;
                                        $insert_detail['nama'] =  $val_no_serti;
                                        $insert_detail['id_perangkat'] =  $id_perangkat;
                                        $insert_detail['status'] =  '1';
                                        
                                        $this->db->insert('perangkat_detail',$insert_detail);
                                    }
                                
                            }else{
                                echo "Update";
                                $this->Mod->update2('perangkat',array('id_perangkat' => $cek['id_perangkat'] ),$insert);
                                    


                                $power          = $value->getCellByColumnAndRow(12, 1)->getValue();
                                $val_power      = $value->getCellByColumnAndRow(12, $row)->getValue();

                                $buatan         = $value->getCellByColumnAndRow(9, 1)->getValue();
                                $val_buatan     = $value->getCellByColumnAndRow(9, $row)->getValue();

                                $no_serti       = $value->getCellByColumnAndRow(13, 1)->getValue();
                                $val_no_serti   = $value->getCellByColumnAndRow(13, $row)->getValue();
                                if ($power =='POWER CONSUMPTION' && $val_power!= ''  ) {
                                    $master_detail_prop                         =  $this->Mod->getWhere('master_perangkat_detail',array('nama' =>'POWER CONSUMPTION (WATT)','id_jenisperangkat' => $id_jenis ))->row_array();
                                    $in_power                                   = $master_detail_prop['idmaster_detail_perangkat'];
                                    $insert_detail=[
                                        'idmaster_detail_perangkat' => $in_power,
                                        'nama'                      => $val_power,
                                        'id_perangkat'              => $cek['id_perangkat'],
                                    ];

                                    $this->Mod->update2('perangkat_detail',array('idmaster_detail_perangkat' =>$in_power,'id_perangkat' => $cek['id_perangkat'] ),$insert_detail);
                                    
                                }

                                if ($buatan =='BUATAN' && $val_buatan != ''  ) {
                                    $master_detail_prop      =  $this->Mod->getWhere('master_perangkat_detail',array('nama' =>'Buatan','id_jenisperangkat' => $id_jenis ))->row_array();
                                    $in_buat =$master_detail_prop['idmaster_detail_perangkat'];
                                    $insert_detail=[
                                        'idmaster_detail_perangkat' => $in_buat,
                                        'nama'                      => $val_buatan,
                                        'id_perangkat'              => $cek['id_perangkat'],
                                    ];
                                    $this->Mod->update2('perangkat_detail',array('idmaster_detail_perangkat' =>$in_buat,'id_perangkat' => $cek['id_perangkat'] ),$insert_detail);
                                    
                                }

                                if ($no_serti =='SERTIFIKASI' && $val_no_serti != '' ) {
                                    $master_detail_prop      =  $this->Mod->getWhere('master_perangkat_detail',array('nama' =>'No. Sertifikasi','id_jenisperangkat' => $id_jenis ))->row_array();
                                    $in_serti =$master_detail_prop['idmaster_detail_perangkat'];
                                    $insert_detail=[
                                        'idmaster_detail_perangkat' => $in_serti,
                                        'nama'                      => $val_no_serti,
                                        'id_perangkat'              => $cek['id_perangkat'],
                                    ];
                                    $this->Mod->update2('perangkat_detail',array('idmaster_detail_perangkat' =>$in_serti,'id_perangkat' => $cek['id_perangkat'] ),$insert_detail);
                                       
                                }
                                echo "<pre>",print_r ($insert),"</pre>";
                                echo "sudah ada";
                            }   
                          
                        }
                   }
             
           
            }
            
           
        }
       
    }

    function UploadFasilitas(){
        
        if(isset($_FILES["filelampiran"]["name"])){
			$path = $_FILES["filelampiran"]["tmp_name"];
			$object = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
       
			
            $insert           = array();
          
			foreach($object->getWorksheetIterator() as $worksheet => $value){
			    $highestRow = $value->getHighestRow();
              
                $lastColumn = $value->getHighestDataColumn(); 
                $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($lastColumn);
         
                   if ($worksheet == 0) {
                        for ($row=2; $row <=$highestRow ; $row++) { 
                          
                            $lokasi             = $value->getCellByColumnAndRow(1, $row)->getValue();
                            $fasilitas          = $value->getCellByColumnAndRow(2, $row)->getValue();
                            $ip                 = $value->getCellByColumnAndRow(3, $row)->getValue();
                            $nama_perangkat     = $value->getCellByColumnAndRow(4, $row)->getValue();
                            $katagory           = $value->getCellByColumnAndRow(18, $row)->getValue();
                            $kode               = $value->getCellByColumnAndRow(19, $row)->getValue();
                            if ($lokasi != '') {
                                $master_lokasi       =  $this->Mod->getWhere('terminal',array('nama_terminal' =>$lokasi,'status !=' => 8  ))->row_array();
                               if (!empty($master_lokasi)) {
                                    $id_lokasi = $master_lokasi['id'] ;
                               }else{
                                $id_lokasi = '';
                               }
                            }else{
                                $id_lokasi = '';
                            }
                            if ($katagory !='') {
                                $master_catagory =  $this->Mod->getWhere('fasilitas_catagory',array('nama' =>$katagory,'status !=' => 8,'id_unit' => $_POST['id_unit']  ))->row_array();
                                if (empty($master_catagory)) {
                                   $insert_catagory =[
                                    'nama'      => $katagory,
                                    'id_unit'   => $_POST['id_unit'],
                                    'status'    => 1,   
                                   ];
                                   $this->db->insert('fasilitas_catagory',$insert_catagory);
                                   
                                    $id_catagory = $this->db->insert_id();
                                }else{
                                    $id_catagory = $master_catagory['id_catagory'];
                                }
                                
                            }else{
                                $id_catagory = '';
                            }

                            $insert=[
                                'nama_fasilitas'        => $fasilitas,
                                'terminal'              => $lokasi  ,
                                'ip_address'            => $ip,
                                'id_unit'               => $_POST['id_unit'],
                                'id_lokasi'             => $id_lokasi,
                                'status'                => 1,
                                'id_catagory'           => $id_catagory,
                                'kode'                  => $kode 
                            ];
                            $cek_fasilitas  = $this->Mod->getWhere('fasilitas ',array('nama_fasilitas' => $insert['nama_fasilitas'],'id_unit' => $_POST['id_unit']  ))->row_array();
                            if ($nama_perangkat != '') {
                                $master_perangkat       =  $this->Mod->getWhere('perangkat',array('nama_perangkat' =>$nama_perangkat,'status !=' => 8  ))->row_array();
                                if (!empty($master_perangkat)) {
                                        $id_perangkat       = $master_perangkat['id_perangkat'] ;
                                        $id_jenisperangkat  = $master_perangkat['id_jenisperangkat'];
                                }else{
                                    
                                        $id_perangkat = '';
                                        $id_jenisperangkat  ='';
                                     
                                }
                            }else{
                                    $id_perangkat = '';
                                    $id_jenisperangkat  ='';
                            }

                            if (empty($cek_fasilitas )) {
                                $this->db->insert('fasilitas',$insert);
                                $id_fasilitas = $this->db->insert_id();
                               
                            }else{
                              
                                $this->Mod->update2('fasilitas',array('id_fasilitas' =>  $cek_fasilitas['id_fasilitas']),$insert);
                               
                                $id_fasilitas =$cek_fasilitas['id_fasilitas'];
                            }
                            $insert_detail =[
                                'id_fasilitas'          => $cek_fasilitas['id_fasilitas'],
                                'id_perangkat'          => $id_perangkat,
                                'id_jenisperangkat'     => $id_jenisperangkat,
                                'status'                => 0,
                                'mandatory'             => 1,
                            ];
                            // echo "<pre>",print_r ($insert_detail),"</pre>";
                            if ($id_fasilitas != '') {
                                if ($nama_perangkat != '') {
                                    $master_perangkat       =  $this->Mod->getWhere('perangkat',array('nama_perangkat' =>$nama_perangkat,'status !=' => 8  ))->row_array();
                                    if (!empty($master_perangkat)) {
                                            $id_perangkat       = $master_perangkat['id_perangkat'] ;
                                            $id_jenisperangkat  = $master_perangkat['id_jenisperangkat'];
                                    }else{
                                            $id_perangkat = '';
                                            $id_jenisperangkat  ='';
                                    }
                                }else{
                                        $id_perangkat = '';
                                        $id_jenisperangkat  ='';
                                }

                                $insert_detail =[
                                    'id_fasilitas'          => $id_fasilitas,
                                    'id_perangkat'          => $id_perangkat,
                                    'id_jenisperangkat'     => $id_jenisperangkat,
                                    'status'                => 0,
                                    'mandatory'             => 1,
                                ];
                                $cek_detail_fasilitas=$this->Mod->getWhere('fasilitas_detail',array('id_perangkat' =>$id_perangkat,'id_fasilitas'=> $id_fasilitas,'status !=' => 8  ))->row_array();

                                if (empty($cek_detail_fasilitas)) {
                                  //  echo "Insert Detail";
                                    //echo "<pre>",print_r ($insert_detail),"</pre>";
                                    if ($this->db->insert('fasilitas_detail',$insert_detail)) {
                                        $data_update_perangkat =[
                                            'status' => '1'
                                        ];
                                        echo "update status perangkat";
                                        $this->Mod->update2('perangkat',array('id_perangkat' => $id_perangkat ),$data_update_perangkat);
                                        
                                        $master_listrik       =  $this->Mod->getWhere('perangkat',array('id_jenisperangkat' =>'4','status !=' => 8  ))->row_array();
                                        if (empty($master_listrik)) {
                                            $data_listrik = [
                                                'id_jenisperangkat'     => 4,
                                                'nama_perangkat'        => 'Listrik',
                                                'type'                  => '2',
                                                'status'                => '1',
                                                'onetomany'             => '1'
                                            ];
                                            $this->db->insert('perangkat',$data_listrik);
                                            $id_listrik = $this->db->insert_id();
                                        // echo "<pre>",print_r ($data_listrik),"</pre>";
                                        }else{
                                            $id_listrik =$master_listrik['id_perangkat'];
                                        }
                                    
                                        $insert_listrik =[
                                            'id_fasilitas'          => $id_fasilitas,
                                            'id_perangkat'          => $id_listrik,
                                            'id_jenisperangkat'     => $master_listrik['id_jenisperangkat'],
                                            'status'                => 0,
                                            'mandatory'             => 0,
                                        ];
                                        $cek_listrik = $this->Mod->getWhere('fasilitas_detail',array('id_fasilitas' =>$id_fasilitas,'id_perangkat'=> $id_listrik))->row_array();
                                       
                                        if (empty($cek_listrik)) {
                                            echo "<pre>",print_r ("Insert Detail Listrik"),"</pre>";
                                            $this->db->insert('fasilitas_detail',$insert_listrik);
                                        }else{
                                            echo "<pre>",print_r ("Fasilitas Listrik Sudah ada".$cek_listrik),"</pre>";
                                            echo "<pre>",print_r ($cek_listrik),"</pre>";
                                        }
                                       
                                        // 
                                        if ($insert['ip_address']!='') {
                                            $master_jaringan       =  $this->Mod->getWhere('perangkat',array('id_jenisperangkat' =>'3','status !=' => 8  ))->row_array();
                                            if (empty($master_jaringan)) {
                                            $data_jaringan = [
                                                'id_jenisperangkat'     => 3,
                                                'nama_perangkat'        => 'Jaringan',
                                                'type'                  => '2',
                                                'status'                => '1',
                                                'onetomany'             => '1'
                                            ];
                                            $this->db->insert('perangkat',$data_jaringan);
                                            $id_jaringan = $this->db->insert_id();
                                            }else{
                                                $id_jaringan =$master_jaringan['id_perangkat'];
                                            }
        
                                            $insert_jaringan =[
                                                'id_fasilitas'          => $id_fasilitas,
                                                'id_perangkat'          => $id_jaringan,
                                                'id_jenisperangkat'     => $master_jaringan['id_jenisperangkat'],
                                                'status'                => 0,
                                                'mandatory'             => 0,
                                            ];
                                            $cek_jaringan = $this->Mod->getWhere('fasilitas_detail',array('id_fasilitas' =>$id_fasilitas,'id_perangkat'=> $id_jaringan))->row_array();
                                       
                                            if (empty($cek_jaringan)) {
                                                 echo "<pre>",print_r ("Fasilitas Jaringan Sudah ada"),"</pre>";
                                                echo "<pre>",print_r ($insert_jaringan),"</pre>";
                                                $this->db->insert('fasilitas_detail',$insert_jaringan);
                                            }
                                           

                                        }
                                    
                                    

                                    } 
                                }

                               
                            }
                            
                        }
                   }
             
           
            }
          
        }
    
    }

    
    function UploadDistributorSwitch(){
        
        if(isset($_FILES["filelampiran"]["name"])){
			$path = $_FILES["filelampiran"]["tmp_name"];
			$object = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet => $value){
			    $highestRow = $value->getHighestRow();
              
                $lastColumn = $value->getHighestDataColumn(); 
                $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($lastColumn);
         
                   if ($worksheet == 0) {
                        for ($row=3; $row <=$highestRow ; $row++) { 
                          
                            $m_jenis            = $value->getCellByColumnAndRow(3, $row)->getValue();
                            $m_merek            = $value->getCellByColumnAndRow(4, $row)->getValue();
                            $m_model            = $value->getCellByColumnAndRow(6, $row)->getValue();
                            $area               = $value->getCellByColumnAndRow(5, $row)->getValue();
                            $nama_fasilitas     = $value->getCellByColumnAndRow(1, $row)->getValue();
                            $tahun              = $value->getCellByColumnAndRow(7, $row)->getValue();
                            $termimnal          =  $value->getCellByColumnAndRow(2, $row)->getValue();
                            $nama_perangkat     = $m_jenis." ". $m_merek." ".$m_model;


                            $data_terminal = $this->Mod->getWhere('terminal',array('nama_terminal' => $termimnal))->row_array();

                            if (!empty($data_terminal)) {
                               $id_terminal =$data_terminal['id'];
                            }else{
                                $id_terminal ='';
                            }
                           $jenis =  $this->Mod->getWhere('jenis_perangkat',array('nama' =>$m_jenis))->row_array();
                            if (!empty($jenis)) {
                                $data_jenis =['nama'=>$m_jenis,'id_unit' => sess()['unit']];
                                $this->Mod->update2('jenis_perangkat',array('id_jenisperangkat' =>  $jenis['id_jenisperangkat']),$data_jenis);
                              
                                $id_jenis = $jenis['id_jenisperangkat'];   
                            } else{
                                $data_jenis =['nama'=>$m_jenis,'id_unit' => sess()['unit']];
                                $this->db->insert('jenis_perangkat',$data_jenis);
                                $id_jenis = $this->db->insert_id();   
                            }

                           $merek =  $this->Mod->getWhere('merk',array('nama' =>$m_merek))->row_array();
                            if (!empty($merek)) {
                                $id_merek =$merek['id'];
                            } else{
                                $data_merek =['nama'=>$m_merek];
                                $this->db->insert('merk',$data_merek);
                                $id_merek = $this->db->insert_id();   
                           }

                           $model =  $this->Mod->getWhere('model',array('nama_perangkat' =>$m_model))->row_array();
                           if (!empty($model)) {
                                $id_model= $model['id_perangkat'];
                           }else{
                                $data_model =['nama_perangkat'=>$m_model];
                                $this->db->insert('model',$data_model);
                                $id_model = $this->db->insert_id();
                              
                           }  

                            $perangkat=[
                                'id_jenisperangkat'     => $id_jenis,
                                'id_unit'               => sess()['unit'],
                                'nama_perangkat'        => $nama_fasilitas,
                                'merk_id'               => $id_merek ,
                            // 'serial_number'         => $sn ,
                                'id_model'              => $id_model,
                                'type'                  => 1  ,
                                'status'                => 0 ,
                                'tahun_pengadaan'       => $tahun
                            ];
                            $m_perangkat    =  $this->Mod->getWhere('perangkat',array('nama_perangkat' =>$nama_perangkat))->row_array();
                            if (empty($m_perangkat)) {
                                $this->db->insert('perangkat',$perangkat);
                                $id_perangkat = $this->db->insert_id();
                                $m_model_detail    =  $this->Mod->getWhere('model_spec',array('id_perangkat' =>$id_model))->result_array();
                                    foreach ($m_model_detail as $key3 => $value3) {
                                        $perangkat_detail =[
                                            'id_perangkat'                  => $id_perangkat,
                                            'idmaster_detail_perangkat'     => $value3['idmaster_detail_perangkat'],
                                            'nama'                          => $value3['nama'],
                                            'status'                        => '0',
                                        ];    
                                        $this->db->insert('perangkat_detail',$perangkat_detail);
                                    }
                            }else{
                                $this->Mod->update2('perangkat',array('id_perangkat' => $m_perangkat['id_perangkat']),$perangkat);
                                $id_perangkat =$m_perangkat['id_perangkat'];
                            }
                          

                            $fasilitas=[
                                'nama_fasilitas'    => $nama_fasilitas,
                                'id_lokasi'          => $id_terminal,
                                'terminal'          => $area,
                                //'ip_address'        => $IP ,
                                'id_unit'           => sess()['unit'] ,
                                'status'            => '1' ,
                            ];


                           
                            $cek_fasilitas   =  $this->Mod->getWhere('fasilitas',array('nama_fasilitas' =>$nama_fasilitas))->row_array();
                            if (!empty($cek_fasilitas)) {
                              
                                $this->Mod->update2('fasilitas',array('id_fasilitas' => $cek_fasilitas['id_fasilitas']),$fasilitas);
                                $id_fasilitas = $cek_fasilitas['id_fasilitas'];
                            }else{
                                $this->db->insert('fasilitas',$fasilitas);
                                $id_fasilitas = $this->db->insert_id();

                                echo "<pre>",print_r ($fasilitas),"</pre>";
                            }
                           
                          

                            $fasilitas_detail =[
                                'id_fasilitas'                  =>  $id_fasilitas,
                                 'id_perangkat'                  => $id_perangkat,
                                 'id_jenisperangkat'             => $id_jenis,
                                 'status'                        => '0',
                             ];  
                             $cek_fasilitas_detail   =  $this->Mod->getWhere('fasilitas_detail',array('id_fasilitas' =>$id_fasilitas,'id_perangkat'=> $id_perangkat))->row_array();
                            if (empty($cek_fasilitas_detail)) {
                                
                                $this->db->insert('fasilitas_detail',$fasilitas_detail);
                            }
                            
                        }
                   }
             
           
            }
          
            //echo "<pre>",print_r ($m_jenis),"</pre>";
        }
    
    }

    // function UploadFasilitasCek(){
    //     $id_cctv    =  $this->Mod->getWhere('jenis_perangkat',array('nama' =>'CCTV'))->row_array();
    //     if(isset($_FILES["filelampiran"]["name"])){
	// 		$path = $_FILES["filelampiran"]["tmp_name"];
	// 		$object = PHPExcel_IOFactory::load($path);
       
			
	// 		foreach($object->getWorksheetIterator(0) as $worksheet => $value){
	// 		    $highestRow = $value->getHighestRow();
              
    //             $lastColumn = $value->getHighestDataColumn(); 
    //             $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($lastColumn);
         
    //                if ($worksheet == 0) {
    //                     for ($row=2; $row <=$highestRow ; $row++) { 
                         
    //                         $ip                     = $value->getCellByColumnAndRow(5, $row)->getValue();
    //                         $nama_fasilitas         = $value->getCellByColumnAndRow(2, $row)->getValue();
    //                         $tahun                  = $value->getCellByColumnAndRow(7, $row)->getValue();
    //                         $sn                     = $value->getCellByColumnAndRow(6, $row)->getValue();
    //                         $poe                    = $value->getCellByColumnAndRow(10, $row)->getValue();
    //                         $SWITCH                 = $value->getCellByColumnAndRow(11, $row)->getValue();
    //                         $SP                     = $value->getCellByColumnAndRow(12, $row)->getValue();
    //                         $ADAPTOR                = $value->getCellByColumnAndRow(13, $row)->getValue();
    //                         $SFP                    = $value->getCellByColumnAndRow(14, $row)->getValue();
    //                         $MC                     = $value->getCellByColumnAndRow(15, $row)->getValue();
    //                         $MCP                    = $value->getCellByColumnAndRow(16, $row)->getValue();;
    //                         $HP                     = $value->getCellByColumnAndRow(17, $row)->getValue();
    //                         $HUB                    = $value->getCellByColumnAndRow(18, $row)->getValue();

    //                         $tes =[
    //                             'nama_fasilitas'    => $nama_fasilitas,
    //                             'ip_address'        => $ip ,
    //                             'poe'               => $poe
    //                         ];
    //                         if (!empty($poe)) {
    //                             $id_jenis   = $this->Mod->getWhere('jenis_perangkat',array('nama' =>$poe,'id_unit' => sess()['unit']))->row_array();
    //                             // $cek_detail = $this->Mod->getWhere('fasilitas_detail ',array('id_jenisperangkat ' =>$poe,'id_fasilitas' =>'','id_unit' => sess()['unit']))->row_array();
                           
    //                             // $cek =  $this->Mod->GetCustome('SELECT * FROM fasilitas_detail a left join jenis_perangkat b on a.id_jenisperangkat = b.id_jenisperangkat left join perangkat c ON c.id_perangkat = a.id_perangkat Where b.id_unit =3 and ')->result_array();
                                
    //                         }else{
    //                             $id_jenis   ='';
    //                         }
    //                         echo "<pre>",print_r ($tes),"</pre>";
    //                         $fasilitas=[
    //                             'nama_fasilitas'    => $nama_fasilitas,
    //                             // 'id_lokasi'         => $id_terminal,
    //                             // 'terminal'          => $area,
    //                             'ip_address'        => $ip ,
    //                             'id_unit'           => sess()['unit'] ,
    //                             'status'            => '1' ,
    //                            // 'keterangan'        => 'tidak ada'
    //                         ];

    //                         echo "<pre>",print_r ($fasilitas),"</pre>";
                           
    //                         $cek_fasilitas   =  $this->Mod->getWhere('fasilitas',array('nama_fasilitas' =>$nama_fasilitas,'id_unit' => sess()['unit']))->row_array();
                           
    //                         if (!empty($cek_fasilitas)) {
    //                             $this->Mod->update2('fasilitas',array('id_fasilitas' => $cek_fasilitas['id_fasilitas']),$fasilitas);
    //                             echo "<pre>",print_r ("Update"),"</pre>";
    //                             echo "<pre>",print_r ($fasilitas),"</pre>";

    //                             $cek_detail     =  $this->Mod->getWhere('fasilitas_detail',array('id_jenisperangkat' =>$id_jenis))->row_array();
    //                         }else{
    //                             // $this->db->insert('fasilitas',$fasilitas);
    //                             //     $id_fasilitas = $this->db->insert_id();

                                
    //                             $perangkat      =  $this->Mod->getWhere('perangkat',array('serial_number' =>$sn))->row_array();
    //                             $cek_detail     =  $this->Mod->getWhere('fasilitas_detail',array('id_perangkat' =>$perangkat['id_perangkat']))->row_array();
    //                             if (empty($cek_detail)) {
    //                                 $fasilitas_detail =[
    //                                     'id_fasilitas'                  => $id_fasilitas,
    //                                     'id_perangkat'                  => $perangkat['id_perangkat'],
    //                                     'id_jenisperangkat'             => $id_cctv['id_jenisperangkat'],
    //                                     'status'                        => '0',
    //                                 ];         
    //                             }
    //                         }
    //                         // if (!empty($cek_fasilitas)) {
                              
    //                         //     $this->Mod->update2('fasilitas',array('id_fasilitas' => $cek_fasilitas['id_fasilitas']),$fasilitas);
    //                         //     $id_fasilitas = $cek_fasilitas['id_fasilitas'];
    //                         // }else{
    //                         //     $this->db->insert('fasilitas',$fasilitas);
    //                         //     $id_fasilitas = $this->db->insert_id();

    //                         //     echo "<pre>",print_r ($fasilitas),"</pre>";
    //                         // }
                           
                          

    //                         // $fasilitas_detail =[
    //                         //     'id_fasilitas'                  =>  $id_fasilitas,
    //                         //      'id_perangkat'                  => $id_perangkat,
    //                         //      'id_jenisperangkat'             => $id_jenis,
    //                         //      'status'                        => '0',
    //                         //  ];  
    //                         //  $cek_fasilitas_detail   =  $this->Mod->getWhere('fasilitas_detail',array('id_fasilitas' =>$id_fasilitas,'id_perangkat'=> $id_perangkat))->row_array();
    //                         // if (empty($cek_fasilitas_detail)) {
    //                         //     $this->db->insert('fasilitas_detail',$fasilitas_detail);
    //                         // }
                            
    //                     }
    //                }
             
           
    //         }
          
    //         //echo "<pre>",print_r ($m_jenis),"</pre>";
    //     }else{
    //         echo "kosong";
    //     }
    // }


    function UploadPerangkatCek(){
        $id_cctv    =  $this->Mod->getWhere('jenis_perangkat',array('nama' =>'CCTV'))->row_array();
        if(isset($_FILES["filelampiran"]["name"])){
			$path = $_FILES["filelampiran"]["tmp_name"];
			$object = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
       
			
			foreach($object->getWorksheetIterator() as $worksheet => $value){
			    $highestRow = $value->getHighestRow();
              
                $lastColumn = $value->getHighestDataColumn(); 
                $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($lastColumn);
         
                   if ($worksheet == 0) {
                        for ($row=1; $row <=$highestRow ; $row++) { 
                          
                            // $jenisperangkat         = $value->getCellByColumnAndRow(5, $row)->getValue();
                            $model                  = $value->getCellByColumnAndRow(5, $row)->getValue();
                            $merk                   = $value->getCellByColumnAndRow(4, $row)->getValue();
                            
                            $master    =  $this->Mod->getWhere('merk',array('nama' =>$merk))->row_array();
                            if (!empty($master)) {
                               $id_merk=  $master['id'];
                                // $update = $this->Mod->update2('merk',array('id' => $master['id']),$insert);
                            }else{
                                
                                $id_merk=  '';
                                // $this->db->insert('merk',$insert);
                            }


                            $nama_perangkat         = $merk." ".$model ;
                        
                            $sn                     = $value->getCellByColumnAndRow(7, $row)->getValue();
                            $tahun                  = $value->getCellByColumnAndRow(8, $row)->getValue();
                            
                            $m_model                =  $this->Mod->getWhere('model',array('nama_perangkat' =>$model))->row_array();
                            if (!empty($m_model)) {
                                $id_model = $m_model['id_perangkat'];
                            }else{
                                $insert_model=[
                                    'id_jenisperangkat'     => $id_cctv['id_jenisperangkat'],
                                    'merk_id'               => $id_merk,
                                    'nama_perangkat'        => $model ,   
                                    'tahun'                 => $tahun,
                                    'status'                => 0
                                ];
                                $this->db->insert('model',$insert_model);
                                $id_model = $this->db->insert_id();
                                // $id_model = '';
                             
                            }

                            
                            $perangkat=[
                                //'id_jenisperangkat'     => $nama_fasilitas,
                                'id_model'              => $id_model,
                                'nama_perangkat'        => $nama_perangkat,
                                'merk_id'               => $id_merk ,
                                'tahun_pengadaan'       => $tahun,
                                'id_unit'               => sess()['unit'] ,
                                'serial_number'         => $sn,
                                'status'                => '1' ,
                               // 'keterangan'        => 'tidak ada'
                            ];

                            // echo "<pre>",print_r ($perangkat),"</pre>";
                           
                            $cek_perangkat   =  $this->Mod->getWhere('perangkat',array('serial_number' =>$sn,'id_unit' => sess()['unit']))->row_array();
                            if (!empty($cek_perangkat)) {
                                echo "<pre>",print_r ($perangkat),"</pre>";
                                $this->Mod->update2('perangkat',array('id_perangkat' => $cek_perangkat['id_perangkat']),$perangkat);
                            }else{
                                $this->db->insert('perangkat',$perangkat);
                                $id_perangkat = $this->db->insert_id();
                                //echo "<pre>",print_r ($perangkat),"</pre>";
                                $detail_perangkat   =  $this->Mod->getWhere('master_perangkat_detail',array('id_jenisperangkat' =>$id_cctv['id_jenisperangkat']))->result_array();
                               
                                foreach ($detail_perangkat as $key2 => $value2) {
                                    $insert_detail_perangkat =[
                                        'id_perangkat'              => $id_perangkat,
                                        'idmaster_detail_perangkat' => $value2['idmaster_detail_perangkat'],
                                        'nama'                      => '',
                                        'status'                    => '0' ,
                                    ];
                                    echo "DETAIL";
                                    echo "<pre>",print_r ($insert_detail_perangkat),"</pre>";
                                }
                            }
                            
                            // if (!empty($cek_fasilitas)) {
                            //     $this->Mod->update2('fasilitas',array('id_fasilitas' => $cek_fasilitas['id_fasilitas']),$fasilitas);
                            //     //echo "<pre>",print_r ($cek_fasilitas),"</pre>";
                            // }else{
                            //     echo "<pre>",print_r ($cek_perangkat),"</pre>";
                            // }


                            // if (!empty($cek_fasilitas)) {
                              
                            //     $this->Mod->update2('fasilitas',array('id_fasilitas' => $cek_fasilitas['id_fasilitas']),$fasilitas);
                            //     $id_fasilitas = $cek_fasilitas['id_fasilitas'];
                            // }else{
                            //     $this->db->insert('fasilitas',$fasilitas);
                            //     $id_fasilitas = $this->db->insert_id();

                            //     echo "<pre>",print_r ($fasilitas),"</pre>";
                            // }
                           
                          

                            // $fasilitas_detail =[
                            //     'id_fasilitas'                  =>  $id_fasilitas,
                            //      'id_perangkat'                  => $id_perangkat,
                            //      'id_jenisperangkat'             => $id_jenis,
                            //      'status'                        => '0',
                            //  ];  
                            //  $cek_fasilitas_detail   =  $this->Mod->getWhere('fasilitas_detail',array('id_fasilitas' =>$id_fasilitas,'id_perangkat'=> $id_perangkat))->row_array();
                            // if (empty($cek_fasilitas_detail)) {
                            //     $this->db->insert('fasilitas_detail',$fasilitas_detail);
                            // }
                            
                        }
                   }
             
           
            }
          
            //echo "<pre>",print_r ($m_jenis),"</pre>";
        }else{
            echo "kosong";
        }
    }    


    function UploadFasilitasCek(){
        $id_cctv    =  $this->Mod->getWhere('jenis_perangkat',array('nama' =>'CCTV'))->row_array();
        if(isset($_FILES["filelampiran"]["name"])){
			$path = $_FILES["filelampiran"]["tmp_name"];
			$object = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
            $sum_detail = 1;
			
			foreach($object->getWorksheetIterator() as $worksheet => $value){
			    $highestRow = $value->getHighestRow();
              
                $lastColumn = $value->getHighestDataColumn(); 
                $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($lastColumn);
         
                   if ($worksheet == 0) {
                        for ($row=2; $row <=$highestRow ; $row++) { 
                         
                            $ip                     = $value->getCellByColumnAndRow(6, $row)->getValue();
                            $nama_fasilitas         = $value->getCellByColumnAndRow(3, $row)->getValue();
                            $tahun                  = $value->getCellByColumnAndRow(8, $row)->getValue();
                            $sn                     = $value->getCellByColumnAndRow(7, $row)->getValue();
                            $poe                    = $value->getCellByColumnAndRow(11, $row)->getValue();
                            $SWITCH                 = $value->getCellByColumnAndRow(12, $row)->getValue();
                            $SP                     = $value->getCellByColumnAndRow(13, $row)->getValue();
                            $ADAPTOR                = $value->getCellByColumnAndRow(14, $row)->getValue();
                            $SFP                    = $value->getCellByColumnAndRow(15, $row)->getValue();
                            $MC                     = $value->getCellByColumnAndRow(16, $row)->getValue();
                            $MCP                    = $value->getCellByColumnAndRow(17, $row)->getValue();;
                            $HP                     = $value->getCellByColumnAndRow(18, $row)->getValue();
                            $HUB                    = $value->getCellByColumnAndRow(19, $row)->getValue();


                             $fasilitas=[
                                'nama_fasilitas'    => $nama_fasilitas,
                                // 'id_lokasi'         => $id_terminal,
                                // 'terminal'          => $area,
                                'ip_address'        => $ip ,
                                'id_unit'           => sess()['unit'] ,
                                'status'            => '1' ,
                               // 'keterangan'        => 'tidak ada'
                            ];
                            $cek_fasilitas      =  $this->Mod->getWhere('fasilitas',array('nama_fasilitas' =>$nama_fasilitas,'id_unit' => sess()['unit']))->row_array();
                               
                            $cek_cctv =$this->Mod->getWhere('fasilitas_detail',array('id_fasilitas' =>$cek_fasilitas['id_fasilitas'],'id_jenisperangkat' => $id_cctv['id_jenisperangkat']))->row_array();
                           
                            echo "<pre>",print_r ($cek_cctv),"</pre>";
                            if (!empty($cek_cctv)) {
                                $sum_detail++;
                                $update_fasilitas_detail=[
                                    'tanggal_penggunaan' => $tahun.'-01-01'
                                ];
                                $this->Mod->update2('fasilitas_detail',array('idfasilitas_detail' =>  $cek_cctv['idfasilitas_detail']),$update_fasilitas_detail);
                          
                                $update_tahun=['tahun_pengadaan' => $tahun];
                                $this->Mod->update2('perangkat',array('id_perangkat' =>  $cek_cctv['id_perangkat']),$update_tahun);
                            }
                           
                            if (!empty($poe)) {
                                $id_jenis           = $this->Mod->getWhere('jenis_perangkat',array('nama' =>$poe,'id_unit' => sess()['unit']))->row_array();
                                // 
                                if (!empty($id_jenis)) {
                                    # code...
                                }
                                $cek_detail         =  $this->Mod->GetCustome("SELECT * FROM 
                                                                fasilitas_detail a 
                                                                LEFT JOIN fasilitas b 
                                                                on b.id_fasilitas = a.id_fasilitas 
                                                                WHERE b.id_fasilitas ='".$cek_fasilitas['id_fasilitas']."' and
                                                                a.id_jenisperangkat ='". $id_jenis['id_jenisperangkat']."'")->row_array();

                                $nama_perangkat = $poe.' '.$nama_fasilitas;
                                if (empty($cek_detail) ) {
                                    $cek_perangkat_fas = $this->Mod->getWhere('perangkat',array('id_jenisperangkat' =>$id_jenis['id_jenisperangkat'],'id_unit' => sess()['unit'],'nama_perangkat' =>$nama_perangkat ))->row_array();
                                    if (empty($cek_perangkat_fas)) {
                                        $in_perangkat = [
                                            'id_jenisperangkat'     => $id_jenis['id_jenisperangkat'],
                                            'id_unit'               => sess()['unit'],
                                            'nama_perangkat'        => $nama_perangkat,
                                        ];
                                       
                                        if ($this->db->insert('perangkat',$in_perangkat)) {
                                            $id_perangkat_fas = $this->db->insert_id();
                                            $ins_fas_det= [
                                                'id_fasilitas'      => $cek_fasilitas['id_fasilitas'],
                                                'id_perangkat'      => $id_perangkat_fas,
                                                'id_jenisperangkat' => $id_jenis['id_jenisperangkat']
                                            ];
                                            $this->db->insert('fasilitas_detail',$ins_fas_det);
                                            // fasilitas_detail
                                            echo "<pre>",print_r ($ins_fas_det),"</pre>";
                                        }
                                    }
                                
                                }else{
                                    echo "sudah ada";
                                }
                               
                            }

                            if (!empty($SWITCH)) {
                                $id_jenis           = $this->Mod->getWhere('jenis_perangkat',array('nama' =>$SWITCH,'id_unit' => sess()['unit']))->row_array();
                                // $cek_fasilitas      =  $this->Mod->getWhere('fasilitas',array('nama_fasilitas' =>$nama_fasilitas,'id_unit' => sess()['unit']))->row_array();
                                
                                $cek_detail         =  $this->Mod->GetCustome("SELECT * FROM 
                                                                fasilitas_detail a 
                                                                LEFT JOIN fasilitas b 
                                                                on b.id_fasilitas = a.id_fasilitas 
                                                                WHERE b.id_fasilitas ='".$cek_fasilitas['id_fasilitas']."' and
                                                                a.id_jenisperangkat ='". $id_jenis['id_jenisperangkat']."'")->row_array();

                                $nama_perangkat = $SWITCH.' '.$nama_fasilitas;
                                if (empty($cek_detail) ) {
                                    $cek_perangkat_fas = $this->Mod->getWhere('perangkat',array('id_jenisperangkat' =>$id_jenis['id_jenisperangkat'],'id_unit' => sess()['unit'],'nama_perangkat' =>$nama_perangkat ))->row_array();
                                    if (empty($cek_perangkat_fas)) {
                                        $in_perangkat = [
                                            'id_jenisperangkat'     => $id_jenis['id_jenisperangkat'],
                                            'id_unit'               => sess()['unit'],
                                            'nama_perangkat'        => $nama_perangkat,
                                        ];
                                       
                                        if ($this->db->insert('perangkat',$in_perangkat)) {
                                            $id_perangkat_fas = $this->db->insert_id();
                                            $ins_fas_det= [
                                                'id_fasilitas'      => $cek_fasilitas['id_fasilitas'],
                                                'id_perangkat'      => $id_perangkat_fas,
                                                'id_jenisperangkat' => $id_jenis['id_jenisperangkat']
                                            ];
                                            $this->db->insert('fasilitas_detail',$ins_fas_det);
                                            echo "<pre>",print_r ($ins_fas_det),"</pre>";
                                            // fasilitas_detail
                                        }
                                    }
                                
                                }else{
                                    echo "sudah ada";
                                }
                                // echo "<pre>",print_r ($fasilitas),"</pre>";
                            }

                            if (!empty($SP)) {
                                $id_jenis           = $this->Mod->getWhere('jenis_perangkat',array('nama' =>$SP,'id_unit' => sess()['unit']))->row_array();
                                // $cek_fasilitas      =  $this->Mod->getWhere('fasilitas',array('nama_fasilitas' =>$nama_fasilitas,'id_unit' => sess()['unit']))->row_array();
                                
                                $cek_detail         =  $this->Mod->GetCustome("SELECT * FROM 
                                                                fasilitas_detail a 
                                                                LEFT JOIN fasilitas b 
                                                                on b.id_fasilitas = a.id_fasilitas 
                                                                WHERE b.id_fasilitas ='".$cek_fasilitas['id_fasilitas']."' and
                                                                a.id_jenisperangkat ='". $id_jenis['id_jenisperangkat']."'")->row_array();

                                $nama_perangkat = $SP.' '.$nama_fasilitas;
                                if (empty($cek_detail) ) {
                                    $cek_perangkat_fas = $this->Mod->getWhere('perangkat',array('id_jenisperangkat' =>$id_jenis['id_jenisperangkat'],'id_unit' => sess()['unit'],'nama_perangkat' =>$nama_perangkat ))->row_array();
                                    if (empty($cek_perangkat_fas)) {
                                        $in_perangkat = [
                                            'id_jenisperangkat'     => $id_jenis['id_jenisperangkat'],
                                            'id_unit'               => sess()['unit'],
                                            'nama_perangkat'        => $nama_perangkat,
                                        ];
                                       
                                        if ($this->db->insert('perangkat',$in_perangkat)) {
                                            $id_perangkat_fas = $this->db->insert_id();
                                            $ins_fas_det= [
                                                'id_fasilitas'      => $cek_fasilitas['id_fasilitas'],
                                                'id_perangkat'      => $id_perangkat_fas,
                                                'id_jenisperangkat' => $id_jenis['id_jenisperangkat']
                                            ];
                                            $this->db->insert('fasilitas_detail',$ins_fas_det);
                                            echo "<pre>",print_r ($ins_fas_det),"</pre>";
                                            // fasilitas_detail
                                        }
                                    }
                                
                                }else{
                                    echo "sudah ada";
                                }
                                // echo "<pre>",print_r ($fasilitas),"</pre>";
                            }

                            if (!empty($ADAPTOR)) {
                                $id_jenis           = $this->Mod->getWhere('jenis_perangkat',array('nama' =>$ADAPTOR,'id_unit' => sess()['unit']))->row_array();
                                $cek_fasilitas      =  $this->Mod->getWhere('fasilitas',array('nama_fasilitas' =>$nama_fasilitas,'id_unit' => sess()['unit']))->row_array();
                                
                                $cek_detail         =  $this->Mod->GetCustome("SELECT * FROM 
                                                                fasilitas_detail a 
                                                                LEFT JOIN fasilitas b 
                                                                on b.id_fasilitas = a.id_fasilitas 
                                                                WHERE b.id_fasilitas ='".$cek_fasilitas['id_fasilitas']."' and
                                                                a.id_jenisperangkat ='". $id_jenis['id_jenisperangkat']."'")->row_array();

                                $nama_perangkat = $ADAPTOR.' '.$nama_fasilitas;
                                if (empty($cek_detail) ) {
                                    $cek_perangkat_fas = $this->Mod->getWhere('perangkat',array('id_jenisperangkat' =>$id_jenis['id_jenisperangkat'],'id_unit' => sess()['unit'],'nama_perangkat' =>$nama_perangkat ))->row_array();
                                    if (empty($cek_perangkat_fas)) {
                                        $in_perangkat = [
                                            'id_jenisperangkat'     => $id_jenis['id_jenisperangkat'],
                                            'id_unit'               => sess()['unit'],
                                            'nama_perangkat'        => $nama_perangkat,
                                        ];
                                       
                                        if ($this->db->insert('perangkat',$in_perangkat)) {
                                            $id_perangkat_fas = $this->db->insert_id();
                                            $ins_fas_det= [
                                                'id_fasilitas'      => $cek_fasilitas['id_fasilitas'],
                                                'id_perangkat'      => $id_perangkat_fas,
                                                'id_jenisperangkat' => $id_jenis['id_jenisperangkat']
                                            ];
                                            $this->db->insert('fasilitas_detail',$ins_fas_det);
                                            // fasilitas_detail
                                            echo "<pre>",print_r ($ins_fas_det),"</pre>";
                                        }
                                    }
                                
                                }else{
                                    echo "sudah ada";
                                }
                                // echo "<pre>",print_r ($fasilitas),"</pre>";
                            }

                            if (!empty($SFP)) {
                                $id_jenis           = $this->Mod->getWhere('jenis_perangkat',array('nama' =>$SFP,'id_unit' => sess()['unit']))->row_array();
                                // $cek_fasilitas      =  $this->Mod->getWhere('fasilitas',array('nama_fasilitas' =>$nama_fasilitas,'id_unit' => sess()['unit']))->row_array();
                                
                                $cek_detail         =  $this->Mod->GetCustome("SELECT * FROM 
                                                                fasilitas_detail a 
                                                                LEFT JOIN fasilitas b 
                                                                on b.id_fasilitas = a.id_fasilitas 
                                                                WHERE b.id_fasilitas ='".$cek_fasilitas['id_fasilitas']."' and
                                                                a.id_jenisperangkat ='". $id_jenis['id_jenisperangkat']."'")->row_array();

                                $nama_perangkat = $SFP.' '.$nama_fasilitas;
                                if (empty($cek_detail) ) {
                                    $cek_perangkat_fas = $this->Mod->getWhere('perangkat',array('id_jenisperangkat' =>$id_jenis['id_jenisperangkat'],'id_unit' => sess()['unit'],'nama_perangkat' =>$nama_perangkat ))->row_array();
                                    if (empty($cek_perangkat_fas)) {
                                        $in_perangkat = [
                                            'id_jenisperangkat'     => $id_jenis['id_jenisperangkat'],
                                            'id_unit'               => sess()['unit'],
                                            'nama_perangkat'        => $nama_perangkat,
                                        ];
                                       
                                        if ($this->db->insert('perangkat',$in_perangkat)) {
                                            $id_perangkat_fas = $this->db->insert_id();
                                            $ins_fas_det= [
                                                'id_fasilitas'      => $cek_fasilitas['id_fasilitas'],
                                                'id_perangkat'      => $id_perangkat_fas,
                                                'id_jenisperangkat' => $id_jenis['id_jenisperangkat']
                                            ];
                                            $this->db->insert('fasilitas_detail',$ins_fas_det);
                                            // fasilitas_detail
                                            // echo "<pre>",print_r ($ins_fas_det),"</pre>";
                                        }
                                    }
                                
                                }else{
                                    echo "sudah ada";
                                }
                                // echo "<pre>",print_r ($fasilitas),"</pre>";
                            }
                            
                            if (!empty($MC)) {
                                $id_jenis           = $this->Mod->getWhere('jenis_perangkat',array('nama' =>$MC,'id_unit' => sess()['unit']))->row_array();
                                // $cek_fasilitas      =  $this->Mod->getWhere('fasilitas',array('nama_fasilitas' =>$nama_fasilitas,'id_unit' => sess()['unit']))->row_array();
                                
                                $cek_detail         =  $this->Mod->GetCustome("SELECT * FROM 
                                                                fasilitas_detail a 
                                                                LEFT JOIN fasilitas b 
                                                                on b.id_fasilitas = a.id_fasilitas 
                                                                WHERE b.id_fasilitas ='".$cek_fasilitas['id_fasilitas']."' and
                                                                a.id_jenisperangkat ='". $id_jenis['id_jenisperangkat']."'")->row_array();

                                $nama_perangkat = $MC.' '.$nama_fasilitas;
                                if (empty($cek_detail) ) {
                                    $cek_perangkat_fas = $this->Mod->getWhere('perangkat',array('id_jenisperangkat' =>$id_jenis['id_jenisperangkat'],'id_unit' => sess()['unit'],'nama_perangkat' =>$nama_perangkat ))->row_array();
                                    if (empty($cek_perangkat_fas)) {
                                        $in_perangkat = [
                                            'id_jenisperangkat'     => $id_jenis['id_jenisperangkat'],
                                            'id_unit'               => sess()['unit'],
                                            'nama_perangkat'        => $nama_perangkat,
                                        ];
                                       
                                        if ($this->db->insert('perangkat',$in_perangkat)) {
                                            $id_perangkat_fas = $this->db->insert_id();
                                            $ins_fas_det= [
                                                'id_fasilitas'      => $cek_fasilitas['id_fasilitas'],
                                                'id_perangkat'      => $id_perangkat_fas,
                                                'id_jenisperangkat' => $id_jenis['id_jenisperangkat']
                                            ];
                                            $this->db->insert('fasilitas_detail',$ins_fas_det);
                                            // fasilitas_detail
                                            echo "<pre>",print_r ($ins_fas_det),"</pre>";
                                        }
                                    }
                                
                                }else{
                                    echo "sudah ada";
                                }
                                // echo "<pre>",print_r ($fasilitas),"</pre>";
                            }

                            if (!empty($MCP)) {
                                $id_jenis           = $this->Mod->getWhere('jenis_perangkat',array('nama' =>$MCP,'id_unit' => sess()['unit']))->row_array();
                                // $cek_fasilitas      =  $this->Mod->getWhere('fasilitas',array('nama_fasilitas' =>$nama_fasilitas,'id_unit' => sess()['unit']))->row_array();
                                
                                $cek_detail         =  $this->Mod->GetCustome("SELECT * FROM 
                                                                fasilitas_detail a 
                                                                LEFT JOIN fasilitas b 
                                                                on b.id_fasilitas = a.id_fasilitas 
                                                                WHERE b.id_fasilitas ='".$cek_fasilitas['id_fasilitas']."' and
                                                                a.id_jenisperangkat ='". $id_jenis['id_jenisperangkat']."'")->row_array();

                                $nama_perangkat = $MCP.' '.$nama_fasilitas;
                                if (empty($cek_detail) ) {
                                    $cek_perangkat_fas = $this->Mod->getWhere('perangkat',array('id_jenisperangkat' =>$id_jenis['id_jenisperangkat'],'id_unit' => sess()['unit'],'nama_perangkat' =>$nama_perangkat ))->row_array();
                                    if (empty($cek_perangkat_fas)) {
                                        $in_perangkat = [
                                            'id_jenisperangkat'     => $id_jenis['id_jenisperangkat'],
                                            'id_unit'               => sess()['unit'],
                                            'nama_perangkat'        => $nama_perangkat,
                                        ];
                                       
                                        if ($this->db->insert('perangkat',$in_perangkat)) {
                                            $id_perangkat_fas = $this->db->insert_id();
                                            $ins_fas_det= [
                                                'id_fasilitas'      => $cek_fasilitas['id_fasilitas'],
                                                'id_perangkat'      => $id_perangkat_fas,
                                                'id_jenisperangkat' => $id_jenis['id_jenisperangkat']
                                            ];
                                            $this->db->insert('fasilitas_detail',$ins_fas_det);
                                            // fasilitas_detail
                                            echo "<pre>",print_r ($ins_fas_det),"</pre>";
                                        }
                                    }
                                
                                }else{
                                    echo "sudah ada";
                                }
                                // echo "<pre>",print_r ($fasilitas),"</pre>";
                            }

                            if (!empty($HP)) {
                                $id_jenis           = $this->Mod->getWhere('jenis_perangkat',array('nama' =>$HP,'id_unit' => sess()['unit']))->row_array();
                                // $cek_fasilitas      =  $this->Mod->getWhere('fasilitas',array('nama_fasilitas' =>$nama_fasilitas,'id_unit' => sess()['unit']))->row_array();
                                
                                $cek_detail         =  $this->Mod->GetCustome("SELECT * FROM 
                                                                fasilitas_detail a 
                                                                LEFT JOIN fasilitas b 
                                                                on b.id_fasilitas = a.id_fasilitas 
                                                                WHERE b.id_fasilitas ='".$cek_fasilitas['id_fasilitas']."' and
                                                                a.id_jenisperangkat ='". $id_jenis['id_jenisperangkat']."'")->row_array();

                                $nama_perangkat = $HP.' '.$nama_fasilitas;
                                if (empty($cek_detail) ) {
                                    $cek_perangkat_fas = $this->Mod->getWhere('perangkat',array('id_jenisperangkat' =>$id_jenis['id_jenisperangkat'],'id_unit' => sess()['unit'],'nama_perangkat' =>$nama_perangkat ))->row_array();
                                    if (empty($cek_perangkat_fas)) {
                                        $in_perangkat = [
                                            'id_jenisperangkat'     => $id_jenis['id_jenisperangkat'],
                                            'id_unit'               => sess()['unit'],
                                            'nama_perangkat'        => $nama_perangkat,
                                        ];
                                       
                                        if ($this->db->insert('perangkat',$in_perangkat)) {
                                            $id_perangkat_fas = $this->db->insert_id();
                                            $ins_fas_det= [
                                                'id_fasilitas'      => $cek_fasilitas['id_fasilitas'],
                                                'id_perangkat'      => $id_perangkat_fas,
                                                'id_jenisperangkat' => $id_jenis['id_jenisperangkat']
                                            ];
                                            $this->db->insert('fasilitas_detail',$ins_fas_det);
                                            // fasilitas_detail

                                            echo "<pre>",print_r ($ins_fas_det),"</pre>";
                                        }
                                    }
                                
                                }else{
                                    echo "sudah ada";
                                }
                                // echo "<pre>",print_r ($fasilitas),"</pre>";
                            }

                            if (!empty($HUB)) {
                                $id_jenis           = $this->Mod->getWhere('jenis_perangkat',array('nama' =>$HUB,'id_unit' => sess()['unit']))->row_array();
                                // $cek_fasilitas      =  $this->Mod->getWhere('fasilitas',array('nama_fasilitas' =>$nama_fasilitas,'id_unit' => sess()['unit']))->row_array();
                                
                                $cek_detail         =  $this->Mod->GetCustome("SELECT * FROM 
                                                                fasilitas_detail a 
                                                                LEFT JOIN fasilitas b 
                                                                on b.id_fasilitas = a.id_fasilitas 
                                                                WHERE b.id_fasilitas ='".$cek_fasilitas['id_fasilitas']."' and
                                                                a.id_jenisperangkat ='". $id_jenis['id_jenisperangkat']."'")->row_array();

                                $nama_perangkat = $HUB.' '.$nama_fasilitas;
                                if (empty($cek_detail) ) {
                                    $cek_perangkat_fas = $this->Mod->getWhere('perangkat',array('id_jenisperangkat' =>$id_jenis['id_jenisperangkat'],'id_unit' => sess()['unit'],'nama_perangkat' =>$nama_perangkat ))->row_array();
                                    if (empty($cek_perangkat_fas)) {
                                        $in_perangkat = [
                                            'id_jenisperangkat'     => $id_jenis['id_jenisperangkat'],
                                            'id_unit'               => sess()['unit'],
                                            'nama_perangkat'        => $nama_perangkat,
                                        ];
                                       
                                        if ($this->db->insert('perangkat',$in_perangkat)) {
                                            $id_perangkat_fas = $this->db->insert_id();
                                            $ins_fas_det= [
                                                'id_fasilitas'      => $cek_fasilitas['id_fasilitas'],
                                                'id_perangkat'      => $id_perangkat_fas,
                                                'id_jenisperangkat' => $id_jenis['id_jenisperangkat']
                                            ];
                                            $this->db->insert('fasilitas_detail',$ins_fas_det);
                                            // fasilitas_detail
                                        }
                                    }
                                
                                }else{
                                    echo "sudah ada";
                                }
                                // echo "<pre>",print_r ($fasilitas),"</pre>";
                            }

                          
                        }
                   }
             
           
            }
          echo"total detail";
            echo "<pre>",print_r ($cek_cctv),"</pre>";
            //echo "<pre>",print_r ($m_jenis),"</pre>";
        }else{
            echo "kosong";
        }
    }

    function CekPOE(){
        
    }

    function Dev(){

        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Controll Data";
        $data["title_des"] = "Modul Dev Controll Data";
        $data["content"] = "v_dev";

        $data["data"] = $data;

        $this->load->view('template_v2', $data);
    }

    function QueryDev(){
        $query = $_POST['query'];
        $exc = $_POST['queryexc'];

        $data=[];
        if (!empty($exc)) {
            $query2= $this->db->query($exc);
        }

        if ($query) {
            $query= $this->Mod->GetCustome($query);
            $data['listTable']  = $query->list_fields();
            $data['data']       = $query->result_array();
        }
        echo json_encode($data);
       
    }

    function Tescheck(){
        $demo_error = array();
        $data = array();
        $field_table = $this->m_saran_kritik->getData("PRK")->list_fields();

        error_reporting(E_ERROR | E_PARSE);

        if (!isset($_FILES["filelampiran"]["name"])) {
            echo json_encode(["STATUS" => 500, "MSG" => "File tidak ditemukan, harap upload file Excel."]);
            return;
        }
        $file = $_FILES["filelampiran"]["tmp_name"];
        $objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);

        unset($arr_data);
        unset($header);

        $sheet = $objPHPExcel->getSheet(1); //cari sheet
        $highestRow = $sheet->getHighestRow(); //cari baris maksimal
        $highestColumn = 'F';

        $objPHPExcel->setActiveSheetIndex(1);
        $activeSheet = $objPHPExcel->getActiveSheet();
        $cell_collection = $activeSheet->getCoordinates();
        foreach ($cell_collection as $cellCoord) {
            $cellObj   = $activeSheet->getCell($cellCoord);
            $column    = $cellObj->getColumn();
            $row       = $cellObj->getRow();
            $data_value = $cellObj->getValue();
            if ($row == 1) {
                $header[] = $column;
            }

           
        }



        $fieldRow = $sheet->rangeToArray('A2:' . $highestColumn . '2', NULL, TRUE, TRUE);
      
        foreach ($fieldRow[0] as $value) {
          
            if ($value == "" || $value == null) {
                continue;
            }
            $field[] = $value;
        }


        
        for ($row = 3; $row <= $highestRow; $row++) {
          
            $dataRow = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, TRUE); //select 

            if ($dataRow[0][0] == NULL) {
                continue;
            };
            $key = array();
            if (!isset($field)) {
                echo "Error: fields are required.";
                die();
            }

            foreach ($field as $idx => $clm) {

                    $key['header'][$clm] = $dataRow[0][$idx];
               
            }
           
            $data[$row] = $key;
        }
       
     
        foreach ($data as $key => $value) {
         
            $unit = $this->m_saran_kritik->getUnitBy(trim($value['header']['UNIT_NAMA']))->row_array();
            if (!empty($unit)) {
                $data[$key]['header']['UNIT_ID'] = $unit['UNIT_ID'];
            } else {
              
                $demo_error[] = [
                    'sheet' => 1,
                    'row' => $key,
                    'col' => (array_search("UNIT_NAMA", $field) == '' ? $header[array_search("UNIT_NAMA", $field)] : ''),
                    'message' => $value['header']['UNIT_NAMA'] . ' not in data master Unit'
                ];
               
               # echo "<pre>", print_r($demo_error2), "</pre>";
            }
               
            if (empty($value['header']['PRK_NO'])) {
                $demo_error[] = [
                    'sheet' => 1,
                    'row' => $key,
                    'col' => (array_search("PRK_NO", $field) != '' ? $header[array_search("PRK_NO", $field)] : 'kosong'),
                    'message' => 'Data PRK Kosong'
                ];
                //
               
            }else{
                // echo "lewat ".  $value['header']['PRK_NO']."<br>";
                $cek_prk =  $this->m_saran_kritik->getWhere("PRK", array('PRK_NO' => $value['header']['PRK_NO'],'UNIT_NAMA' => $value['header']['UNIT_NAMA']))->row_array();
           
                if (empty( $cek_prk )) {
                    $demo_error[] = [
                        'sheet' => 1,
                        'row' => $key,
                        'col' => (array_search("PRK_NO", $field) != '' ? $header[array_search("PRK_NO", $field)] : 'kosong'),
                        'message' => 'Data PRK dengan nama unit tidak di temukan'
                    ];
                }      

                $cek_log_AI= $this->m_saran_kritik->getWhere("PRK_REVISIAI_LOG", array('PRK_ID' => $cek_prk['PRK_ID'],'STATUS' => '1','JENIS' => 'AI'))->row_array();
                if (empty($cek_log_AI)) {
                    if ($cek_prk['AI_TERBIT'] == $value['header']['NILAI_BARU_AI']) {
                        $demo_error[] = [
                            'sheet' => 1,
                            'row' => $key,
                            'col' => (array_search("PRK_NO", $field) != '' ? $header[array_search("PRK_NO", $field)] : 'kosong'),
                            'message'   => 'Tidak Ada perubahan Data',
                             'type'     => 'error'
                        ];
                    }
                }else{
                    if ($cek_log_AI['NILAI_BARU'] ==$value['header']['NILAI_BARU_AI']) {
                        $demo_error[] = [
                            'sheet' => 1,
                            'row' => $key,
                            'col' => (array_search("PRK_NO", $field) != '' ? $header[array_search("PRK_NO", $field)] : 'kosong'),
                            'message'   => 'Tidak Ada Perubahan Data Dari Terakhir Revisi',
                            'type'      => 'error'
                        ];
                    }
                }
               
               
                if (empty($value['header']['TAHUN']) ) {
                    $demo_error[] = [
                        'sheet'     => 1,
                        'row'       => $key,
                        'col'       => (array_search("TAHUN", $field) != '' ? $header[array_search("TAHUN", $field)] : 'kosong'),
                        'message'   => 'Tahun Anggaran Kosong',
                        'type'      => 'error'
                    ];
                }
                if (empty($value['header']['NILAI_BARU_AI']) ) {
                    $demo_error[] = [
                        'sheet'     => 1,
                        'row'       => $key,
                        'col'       => (array_search("TAHUN", $field) != '' ? $header[array_search("TAHUN", $field)] : 'kosong'),
                        'message'   => 'Data Tidak Lengkap',
                        'type'      => 'error'
                    ];
                }
                
            }
 
        }
     
        $sussces_sum    = 0;
        $failed_sum     = 0;
        $skip_sum       = 0;
        // 
        if ($demo_error) {
            // echo "<pre>", print_r($demo_error), "</pre>";
            foreach ($demo_error as $key_r =>$error) {
                $sheet      = $error["sheet"];
                $column     = $error["col"];
                $row        = $error["row"];
                $message    = $error["message"];
                
                unset($data[$error["row"]]); // menghapus Data error agar tidak tersimpan
              

                if ($error['type']) {
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(55);
                    $objPHPExcel->getActiveSheet()->getStyle("A$row:G$row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                    $objPHPExcel->getActiveSheet()->getStyle("A$row:G$row")->getFill()->getStartColor()->setARGB("e5e5e5");
                    $objPHPExcel->getActiveSheet()->setCellValue("G$row", "$message");
                    $objPHPExcel->getActiveSheet()->getStyle("G$row")->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getTabColor()->setARGB('e5e5e5');
                    $skip_sum++;
                }else{
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(55);
                    $objPHPExcel->getActiveSheet()->getStyle("A$row:G$row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                    $objPHPExcel->getActiveSheet()->getStyle("A$row:G$row")->getFill()->getStartColor()->setARGB("bd544f");
                    $objPHPExcel->getActiveSheet()->setCellValue("G$row", "$message");
                    $objPHPExcel->getActiveSheet()->getStyle("G$row")->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getTabColor()->setARGB('bd544f'); 

                    // $objPHPExcel->getActiveSheet()->getStyle("$column$row")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                    // $objPHPExcel->getActiveSheet()->getStyle("$column$row")->getFill()->getStartColor()->setARGB("ffffcece");
                    // $objPHPExcel->getActiveSheet()->getTabColor()->setARGB('FFFF0000');
                    // $objPHPExcel->getActiveSheet()->getComment("$column$row")->setAuthor('Timur Sahadewa');
                    // $objPHPExcel->getActiveSheet()->getComment("$column$row")->getText()->createTextRun($message);
                    // $objPHPExcel->getActiveSheet()->getComment("$column$row")->getText()->createTextRun("\r\n");
                    // $objPHPExcel->getActiveSheet()->getComment("$column$row")->getText()->createTextRun("\r\n");
                    $failed_sum++;
                }
              
            }
          

            foreach ($data as $key => $val) {
                $insert = $val['header'];

                $old_prk = $this->m_saran_kritik->getWhere("PRK", array('PRK_NO' => $val['header']['PRK_NO']))->row_array();
                $log_status = [
                    'STATUS' => 0,
                ];

                if (!empty($insert['NILAI_BARU_AI'])) {
                    $cek_log= $this->m_saran_kritik->getWhere("PRK_REVISIAI_LOG", array('PRK_ID' => $old_prk['PRK_ID'],'STATUS' => '1','JENIS' => 'AI'))->row_array();
                    if (!empty($cek_log)) {
                       $nilai_awal= $cek_log['NILAI_BARU'];
                    }else{
                        $nilai_awal= $old_prk['AI_TERBIT'];
                    }
                    // echo "<pre>", print_r($log_status), "</pre>";

                    $this->m_saran_kritik->update('PRK_REVISIAI_LOG', array('PRK_ID' => $old_prk['PRK_ID'],'JENIS'=> 'AI'), $log_status);
                    $last_order = $this->m_saran_kritik->maxorder($old_prk['PRK_ID'])->row_array();
                    if (!empty($last_order['LAST_ID'])) {
                        $order = $last_order['LAST_ID'] + 1;
                    } else {
                        $order = 1;
                    }
                    $log_ai=[
                        'PRK_ID'        => $old_prk['PRK_ID'],
                        'NILAI_AWAL'    => $nilai_awal,
                        'NILAI_BARU'    => $insert['NILAI_BARU_AI'],
                        'DESCRIPTION'   => $insert['DESCRIPTION'],
                        'UPDATE_BY'     => $this->session->userdata('nama'),
                        'UPDATE_DATE'   => tgl(date('Y-m-d'), 'sc'),
                        'ORDER_DATA'    => $order,
                        'STATUS'        => '1',
                        'JENIS'         => 'AI',
                    ];

                    $this->m_saran_kritik->Save('PRK_REVISIAI_LOG', $log_ai);
                    $sussces_sum++;
                    // echo "<pre>", print_r($log_ai), "</pre>";
                }

               
                $update_PRK=[
                    "TAHUN_AKTIF"   => $insert['TAHUN_AKTIF']
                ];
                $this->m_saran_kritik->update('PRK', array('PRK_ID' => $old_prk['PRK_ID']), $update_PRK);
                   
            }

            $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
            $namafile = "Error_Loader_Template_PRK_REVISI_AI_AKI" . date("Y-m-d H.i.s") . ".xlsx";
            $path = "./temp/$namafile";

            $upload_id = $this->m_saran_kritik->getNextID('PRK_UPLOAD_SEQ');
            $respon_data = array(
                "STATUS"        => 500,
                "MSG"           => 'Error Data',
                "UPLOAD_ID"     => $upload_id,
                "PATH"          => $path,
                "FILENAME"      => $namafile,
                "TYPE"          => "error_loader_template",
                "DIBUAT_OLEH"   => session("user_id"),
                "total"         => ($sussces_sum+$skip_sum+$failed_sum),
                "succes"        => $sussces_sum,
                "skip"          => $skip_sum,
                "error"         => $failed_sum,
            );
            $this->db->set('WAKTU_DIBUAT', 'CURRENT_TIMESTAMP', FALSE);

            $objWriter->save($path);
            #$objWriter->save('php://output');
            echo json_encode($respon_data);
        } else {
           
            foreach ($data as $key => $val) {
                $insert = $val['header'];

                $old_prk = $this->m_saran_kritik->getWhere("PRK", array('PRK_NO' => $val['header']['PRK_NO']))->row_array();
                $log_status = [
                    'STATUS' => 0,
                ];
                if (!empty($insert['NILAI_BARU_AI'])) {
                    $cek_log= $this->m_saran_kritik->getWhere("PRK_REVISIAI_LOG", array('PRK_ID' => $old_prk['PRK_ID'],'STATUS' => '1','JENIS' => 'AI'))->row_array();
                    if (!empty($cek_log)) {
                       $nilai_awal= $cek_log['NILAI_BARU'];
                    }else{
                        $nilai_awal= $old_prk['AI_TERBIT'];
                    }
                    // echo "<pre>", print_r($log_status), "</pre>";
                    $this->m_saran_kritik->update('PRK_REVISIAI_LOG', array('PRK_ID' => $old_prk['PRK_ID'],'JENIS'=> 'AI'), $log_status);
                    $last_order = $this->m_saran_kritik->maxorder($old_prk['PRK_ID'])->row_array();
                    if (!empty($last_order['LAST_ID'])) {
                        $order = $last_order['LAST_ID'] + 1;
                    } else {
                        $order = 1;
                    }
                    $log_ai=[
                        'PRK_ID'        => $old_prk['PRK_ID'],
                        'NILAI_AWAL'    => $nilai_awal,
                        'NILAI_BARU'    => $insert['NILAI_BARU_AI'],
                        'DESCRIPTION'   => $insert['DESCRIPTION'],
                        'UPDATE_BY'     => $this->session->userdata('nama'),
                        'UPDATE_DATE'   => tgl(date('Y-m-d'), 'sc'),
                        'ORDER_DATA'    => $order,
                        'STATUS'        => '1',
                        'JENIS'         => 'AI',
                    ];

                    $this->m_saran_kritik->Save('PRK_REVISIAI_LOG', $log_ai);
                    $sussces_sum++;
                    // echo "<pre>", print_r($log_ai), "</pre>";
                }

               
                $update_PRK=[
                    "TAHUN"         => $insert['TAHUN'],
                    "TAHUN_AKTIF"   => $insert['TAHUN_AKTIF']
                ];
                $this->m_saran_kritik->update('PRK', array('PRK_ID' => $old_prk['PRK_ID']), $update_PRK);
            }
            $data = array(
                "STATUS"    => 200,
                'MSG'       => 'No Error Data',
                "total"         => ($sussces_sum+$skip_sum+$failed_sum),
                "succes"        => $sussces_sum,
                "skip"          => $skip_sum,
                "error"         => $failed_sum,
                
            );
            echo json_encode($data);
           
        }
    }

    function cleanData(){
       $res =   $this->Mod->GetCustome('Select b.id_fasilitas as fasilitas,a.* from fasilitas_detail a left join fasilitas b on b.id_fasilitas = a.id_fasilitas Where b.id_fasilitas is null')->result_array();
        //    echo "<pre>",print_r ( $res),"</pre>";
       foreach ($res as $key => $value) {
        $this->Mod->delete('fasilitas_detail', array('id_fasilitas' =>$value['id_fasilitas'] ));
        
        $perangkat          =   $this->Mod->GetCustome("Select * from perangkat Where id_perangkat ='".$value['id_perangkat']."' AND id_jenisperangkat   NOT IN ('4','3') ")->row_array();
        $this->m_data->delete('perangkat', array('id_perangkat' =>$value['id_perangkat'] ));
        
        $detail_perangkat   =   $this->Mod->GetCustome("Select * from perangkat_detail Where id_perangkat ='".$perangkat['id_perangkat']."'")->row_array();
        $this->m_data->delete('perangkat_detail', array('id_perangkat' =>$perangkat['id_perangkat'] ));
        
                               
       }
       echo "<pre>",print_r ( $res),"</pre>"; 
       // 
    }

    function cleanDataperangkat(){
        $res =   $this->Mod->GetCustome("Select * from perangkat where id_unit ='".sess()['unit']."' ")->result_array();
        // echo "<pre>",print_r ( $res),"</pre>";
        foreach ($res as $key => $value) {
            $this->m_data->delete('perangkat', array('id_perangkat' =>$value['id_perangkat'] ));
            // $detail =  $this->Mod->getWhere('perangkat_detail',array('id_perangkat' =>$value['id_perangkat'] ))->row_array();
            // echo "<pre>",print_r ( $detail),"</pre>";            
        //  $this->m_data->delete('fasilitas_detail', array('id_fasilitas' =>$value['id_fasilitas'] ));
         
        //  $perangkat          =   $this->Mod->GetCustome("Select * from perangkat Where id_perangkat ='".$value['id_perangkat']."' AND id_jenisperangkat   NOT IN ('4','3') ")->row_array();
        //  $this->m_data->delete('perangkat', array('id_perangkat' =>$value['id_perangkat'] ));
         
        //  $detail_perangkat   =   $this->Mod->GetCustome("Select * from perangkat_detail Where id_perangkat ='".$perangkat['id_perangkat']."'")->row_array();
        //  $this->m_data->delete('perangkat_detail', array('id_perangkat' =>$perangkat['id_perangkat'] ));
         
                                
        }
       
        // 
    }

    function CekStatusPerangkat(){
        $perangkat = $this->Mod->getWhere('perangkat',array('id_unit' => sess()['unit']))->result_array();
        foreach ($perangkat as $key => $value) {
            $detail= $this->Mod->getWhere('fasilitas_detail',array('id_perangkat' =>  $value['id_perangkat']))->row_array();
            if (empty( $detail)) {

                echo "data di bawah belum di gunakan";
                echo "<pre>",print_r ( $value),"</pre>"; 
            }else{
                $update=[
                    'status'    => 1
                ];
                $this->Mod->update2('perangkat',array('id_perangkat' =>  $value['id_perangkat'],'id_unit' => sess()['unit']),$update);
                
            }
             
        }
                           
    }
    function CleanDataDelete(){
        $fasilitas = $this->Mod->getWhere('fasilitas',array('id_unit' => sess()['unit']))->result_array();
        foreach ($fasilitas as $key => $value) {
           
            $fasilitas_d = $this->Mod->getWhere('fasilitas_detail',array('id_fasilitas' => $value['id_fasilitas']))->result_array();
            foreach ($fasilitas_d as $key2 => $value2) {
                $perangkat = $this->Mod->getWhere('perangkat',array('id_perangkat' => $value2['id_perangkat']))->result_array();
                $perangkat_d = $this->Mod->getWhere('perangkat_detail',array('id_perangkat' => $value2['id_perangkat']))->result_array();
               
                //$this->Mod->delete('perangkat_detail', array('id_perangkat' =>$value2['id_fasilitas'] ));
                //$this->Mod->delete('perangkat', array('id_perangkat' =>$value2['id_fasilitas'] ));
                
            }
                $this->Mod->delete('fasilitas_detail', array('id_fasilitas' =>$value['id_fasilitas'] ));
                $this->Mod->delete('fasilitas', array('id_fasilitas' =>$value['id_fasilitas'] ));
       
        }
        $perangkat = $this->Mod->getWhere('perangkat',array('id_unit' => sess()['unit']))->result_array();
        foreach ($perangkat as $key => $value) {
            
            $perangkat_d = $this->Mod->getWhere('perangkat_detail',array('id_perangkat' => $value['id_perangkat']))->result_array();
            $this->Mod->delete('perangkat_detail', array('id_perangkat' =>$value['id_perangkat'] ));
            $this->Mod->delete('perangkat', array('id_perangkat' =>$value['id_perangkat'] ));
                
        }
                
        echo "<pre>",print_r ( $fasilitas),"</pre>"; 

    }
}
