<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class home extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->model("aplikasi/m_aplikasi");
        // session_update();
        $this->load->model("pm/m_data");
       
    }

    private function role() {

        $url = urlencode(current_url());

        if (session("username") == "") {
            redirect(base_url('login/auth'));
        }
    }

    private function position() {
        $data["param"] = http_build_query($_GET);
        $data["position"] = "home";

        return $data;
    }

    public function index() {
        $this->role();
        $data = $this->position();
        // $username = session("username");

        $data["title"] = "Home";
        $data["content"] = "v_home";
        $data["plugin"][] = "home_pl";
        $data["plugin"][] = "plugin/select2";
        // $data['setting_approval'] = $this->m_settingapproval->isApprover();
        // echo json_encode($data['setting_approval']); die();

       
    //    echo "<pre>",print_r ( $this->session->userdata()),"</pre>";
        $this->load->view('template_v2', $data);
    }

    function LoadDataPM(){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
       
       if (strtotime(date('H:i')) >= strtotime('07:00') && strtotime(date('H:i')) <= strtotime('18:59')  ) {
            $shift ='PS';
            $dateNow = date("d");
       }else{
            if (strtotime(date('H:i')) >= strtotime('00:01') && strtotime(date('H:i')) <=strtotime('06:59')) {
              //  echo "tanggal kemarin";
                $dateNow = date("d")-1;
            }else {
                $dateNow = date("d");
            }
           
            $shift ='M';
       }
       $data_res['tanggal']         = $dateNow ;
       $pm=  $this->Mod->GetCustome("SELECT a.*,b.name_pm,c.nama_terminal 
       FROM jadwal a left join pm_type b on b.idpm_type = a.idpm_type left join terminal c on c.id= a.id_lokasi 
       WHERE a.tgl = '".$dateNow."' AND a.shift = '".$shift."' AND a.bulan in ('','".date("m")."')" )->result_array();
       $dum =array();
       foreach ($pm as $key => $value) {
       
        $data_res['pm'][$value['nama_terminal']][$value['name_pm']][] =$value;
            // if (date("m") == $value['bulan']) {
            //    $data_res['triwulan'][]=$value;
            // }elseif (empty($value['bulan'])) {
            //     $data_res['bulanan'][]=$value;
            // }
       }

     
     
    //    if (!empty($data_res['harian'])) {
    //     foreach ($data_res['harian'] as $key => $value) {
    //         $perangkat = $this->m_data->getWhere('perangkat',array('id' =>  $value['id_perangkat']))->row_array();
    //         $data_res['harian'][$key]['nama_perangkat']= $perangkat['nama_perangkat'];
    //         $data_res['harian'][$key]['ip']= $perangkat['ip'];
    //      }
    //    }
     
     //  $data_res['minguan']       = $this->m_data->getWhere('jadwal',array('tgl' => $dateNow,'bulan' =>date("m"),'idpm_type' => 2,'shift' => $shift))->result_array();
    //    if (!empty($data_res['minguan'])) {
    //     foreach ($data_res['minguan'] as $key => $value) {

    //         // echo "<pre>",print_r ( $value),"</pre>";
    //         if ($value['id_perangkat'] != 0 ) {
    //             $perangkat = $this->m_data->getWhere('perangkat',array('id' =>  $value['id_perangkat']))->row_array();
    //             $data_res['minguan'][$key]['nama_perangkat']= $perangkat['nama_perangkat'];
    //             $data_res['minguan'][$key]['ip']= $perangkat['ip'];
    //         }
            
    //      }
    //    }

     //   $data_res['triwulan']      = $this->m_data->getWhere('jadwal',array('tgl' => $dateNow,'bulan' =>date("m"),'idpm_type' => 3,'shift' => $shift))->result_array();
       
    //    if (!empty($data_res['triwulan'])) {
    //     foreach ($data_res['triwulan'] as $key => $value) {
    //         if ($value['id_perangkat'] != 0 ) {
    //             $perangkat = $this->m_data->getWhere('perangkat',array('id' =>  $value['id_perangkat']))->row_array();
    //             $data_res['triwulan'][$key]['nama_perangkat']= $perangkat['nama_perangkat'];
    //             $data_res['triwulan'][$key]['ip']= $perangkat['ip'];
    //         }
            
    //      }
    //    }

     //  $data_res['semester']      = $this->m_data->getWhere('jadwal',array('tgl' => $dateNow,'bulan' =>date("m"),'idpm_type' => 4,'shift' => $shift))->result_array();
       
    //    if (!empty($data_res['semester'])) {
    //     foreach ($data_res['semester'] as $key => $value) {
    //         if ($value['id_perangkat'] != 0 ) {
    //             $perangkat = $this->m_data->getWhere('perangkat',array('id' =>  $value['id_perangkat']))->row_array();
    //             $data_res['semester'][$key]['nama_perangkat']= $perangkat['nama_perangkat'];
    //             $data_res['semester'][$key]['ip']= $perangkat['ip'];
    //         }
           
    //      }
    //    }
       
      //  $data_res['tahun']         = $this->m_data->getWhere('jadwal',array('tgl' => $dateNow,'bulan' =>date("m"),'idpm_type' => 5,'shift' => $shift))->result_array();
       
    //    if (!empty($data_res['tahun'])) {
    //     foreach ($data_res['tahun'] as $key => $value) {
    //         if ($value['id_perangkat'] != 0 ) {
    //             $perangkat = $this->m_data->getWhere('perangkat',array('id' =>  $value['id_perangkat']))->row_array();
    //             $data_res['tahun'][$key]['nama_perangkat']= $perangkat['nama_perangkat'];
    //             $data_res['tahun'][$key]['ip']= $perangkat['ip'];
    //         }
            
    //      }
    //    }

       $data_res['jam']           = date('H:i') ;
       $data_res['shift']         = $shift;
        echo json_encode($data_res);
    }

    function ExportExcel($bulan=null, $tahun=null,$unit=null){
        
  
        
        //$tahun= $this->input->post('tahun');
        //  if (!empty( $tahun)) {
        //      $data_res = $this->m_indikator->getWhere('KM_MASTER_INDIKATOR',array('TAHUN'=>$tahun,'STATUS !=' => 8))->result_array();
        //  }else{
        //      $data_res = $this->m_indikator->getWhere('KM_MASTER_INDIKATOR',array('STATUS !=' => 8))->result_array();
        //  }
 
        //  foreach ($data_res as $key => $value) {
        //      # code...
 
 
        //      $unit = $this->m_indikator->getWhere('KM_MAPPING_INDIKATOR',array(  'STATUS ' => 1,'MASTER_ID' => $value['PK_ID']))->result_array();
        //      $data_res[$key]['detail']= $unit;
        //      $data_res[$key]['cout']= count($unit);
        //  }
        //  $data['title'] = 'Korporat';
        //  $data['data'] = $data_res;
        //  // $this->load->view('excel_kpi', $data);
        //  //  echo "<pre>", print_r($data_res), "</pre>";
 
        //  $tableHead = [
        //      'font'=>[
        //          'color'=>[
        //              'rgb'=>'FFFFFF'
        //          ],
        //          'bold'=>true,
        //          'size'=>11
        //      ],
        //      'fill'=>[
        //          'fillType' => Fill::FILL_SOLID,
        //          'startColor' => [
        //              'rgb' => '00BDFF'
        //          ]
        //      ],
        //      'borders' => [
        //          'allBorders' => [
        //              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        //              'color' => ['argb' => '000000 '],
        //          ],
        //      ],
        //  ];
 
 
        //  $evenRow = [
            
        //          'borders' => [
        //              'allBorders' => [
        //                  'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        //                  'color' => ['argb' => '000000 '],
        //              ],
        //          ],
        //  ];
        //  //odd row
        //  $oddRow = [
        //     'borders' => [
        //          'allBorders' => [
        //              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        //              'color' => ['argb' => '000000 '],
        //          ],
        //      ],
        //  ];
 
        //  $fileName = 'Target Realisasi KPI.xlsx';  
        //  $spreadsheet = new Spreadsheet();
        //  $sheet = $spreadsheet->getActiveSheet();
        //  $spreadsheet->getActiveSheet()->getStyle('A1:H1')->applyFromArray($tableHead);
        //  //setting column width
       
        //  $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(11);
        //  $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(11);
        //  $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(11);
        //  $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(11);
        //  $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(60);
       
        //  $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(15);
         
        //  $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        
        //  $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(10);
         
        //  $spreadsheet->getActiveSheet()->getStyle('C')
        //              ->getAlignment()->setWrapText(true);
 
        //  $spreadsheet->getActiveSheet()->getStyle('G')
        //              ->getAlignment()->setWrapText(true);  
 
        //  $spreadsheet->getActiveSheet()->getStyle('H')
        //              ->getAlignment()->setWrapText(true);  
 
        //  $spreadsheet->getActiveSheet()->getStyle('A:H')
        //              ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
 
        //  $spreadsheet->getActiveSheet()->getStyle('A1:H1')
        //              ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        //  $spreadsheet->getActiveSheet()->getStyle('A1:H1')
        //              ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
         
        //  $spreadsheet->getActiveSheet()->getStyle('B')
        //              ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        //  $spreadsheet->getActiveSheet()->getStyle('B')
        //              ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
 
        //  $spreadsheet->getActiveSheet()->getStyle('D')
        //              ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        //  $spreadsheet->getActiveSheet()->getStyle('D')
        //              ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
 
        //  $spreadsheet->getActiveSheet()->getStyle('F')
        //              ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        //  $spreadsheet->getActiveSheet()->getStyle('F')
        //              ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        //  $spreadsheet->getActiveSheet()->getColumnDimension('A')->setVisible(false);
 
        //  $sheet->setCellValue('A1', 'PK_ID');
        //  $sheet->setCellValue('B1', 'Tahun');
        //  $sheet->setCellValue('C1', 'Tipe');
        //  $sheet->setCellValue('D1', 'No');
        //  $sheet->setCellValue('E1', 'Indikator Kinerja');
        //  $sheet->setCellValue('F1', 'Jenis');
        //  $sheet->setCellValue('G1', 'Semester 1');
        //  $sheet->setCellValue('H1', 'Semester 2');     
        //  $rows = 2;
        //  foreach ($data_res as $key => $value) {
        //     foreach ($value['detail'] as $key2 => $val) {
        //      $sheet->setCellValue('A' . $rows, $val['PK_ID']);
        //      $sheet->setCellValue('B' . $rows, $value['TAHUN']);
        //      $sheet->setCellValue('C' . $rows, $val['TIPE']);
        //      $sheet->setCellValue('D' . $rows, $value['NO']);
        //      $sheet->setCellValue('E' . $rows, $value['INDIKATOR_KINERJA']);
        //      $sheet->setCellValue('F' . $rows, $val['JENIS']);
        //      $spreadsheet->getActiveSheet()->getRowDimension($rows)->setRowHeight(35, 'pt');
        //      if( $rows % 2 == 0 ){
        //      //even row
        //          $spreadsheet->getActiveSheet()->getStyle('A'.$rows.':H'.$rows)->applyFromArray($evenRow);
        //      }else{
        //          //odd row
        //          $spreadsheet->getActiveSheet()->getStyle('A'.$rows.':H'.$rows)->applyFromArray($oddRow);
        //      }
        //      $rows++;
        //     }
        //  }
        $objPHPExcel = PHPExcel_IOFactory::load("./forms/english/cash.xlsx");
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A2', "No")
                    ->setCellValue('B2', "Name")
                    ->setCellValue('C2', "Email")
                    ->setCellValue('D2', "Phone")
                    ->setCellValue('E2', "Address");
        //  $writer = new Xlsx($spreadsheet);
        //  $writer->save("upload/".$fileName);
        //  header("Content-Type: application/vnd.ms-excel");
        //  redirect(base_url()."/upload/".$fileName);          
   
    }
 
}
