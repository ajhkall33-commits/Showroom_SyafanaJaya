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
       
       if (strtotime(date('H:i')) >= strtotime('08:00') && strtotime(date('H:i')) <= strtotime('19:59')  ) {
            $shift ='PS';
            $dateNow = date("d");
            
       }else{
            if (strtotime(date('H:i')) >= strtotime('00:01') && strtotime(date('H:i')) <=strtotime('07:59')) {
              //  echo "tanggal kemarin";
                $dateNow = date("d")-1;
            }else {
                $dateNow = date("d");
            }
           
            $shift ='M';
       }
       if (sess()['unit'] == 3) {
        $shift ='ALL';
       }
       //query untuk menapilkan jadwal pada halaman di sort berdasarkan fasilitas, unit, bulan , dan minggu
       $data_res['tanggal']         = $dateNow ;
       $minggu=$this->Mod->GetCustome('SELECT WEEK(now()) as minggu' )->row_array();
      // echo "<pre>", print_r($minggu), "</pre>";
       $w=$minggu['minggu']+1;
       $tahun_sekarang = date("Y");
        // $tahun_sekarang = "2025";
       $pm=$this->Mod->GetCustome("SELECT j.*,p.name_pm, t.nama_terminal FROM jadwal j 
                                    LEFT JOIN pm_type p 
                                    on p.idpm_type = j.idpm_type
                                    LEFT JOIN terminal t
                                    ON t.id = j.id_lokasi 
        where fasilitas is not null and id_unit='".sess()['unit']."'and tahun = '" . $tahun_sekarang . "' and bulan= '".date("m")."' and minggu = '".$w."'" )->result_array();
       
       foreach ($pm as $key => $value) {
        $data_res['pm'][$value['nama_lokasi']][$value['name_pm']][]=$value;
       }
  
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
