<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Fill;

class Jadwal_kerja extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('EXCEL');
        $this->load->model("m_data");
    }

    // private function position() {
    //     $data["position"] = "perangkat";
    //     return $data;
    // }

    private function role() {
        $url = urlencode(current_url());
        if (session("username") == "") {
            redirect(base_url('login/auth'));
        }
    }
    public function index()
    {
      
        //$data = $this->position();
        // $data = access($data,"VIEW");
       
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "List Jadwal Kerja ";
        $data["title_des"] = " List Data Jadwal Kerja ";
        $data["content"] = "v_index";

        $data["data"] = $data;

        $this->load->view('template_v2', $data);
        // echo "<pre>",print_r ( $this->session->userdata()),"</pre>";
    }

    
    function LoadData(){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
        if (strtotime(date('H:i')) >= strtotime('07:00') && strtotime(date('H:i')) <= strtotime('18:59')  ) {
            $shift ='PS';
            $dateNow = date("d");
        }else{
                if (strtotime(date('H:i')) >= strtotime('00:01') && strtotime(date('H:i')) <=strtotime('06:59')) {
                
                    $dateNow = date("d")-1;
                }else {
                    $dateNow = date("d");
                }
            
                $shift ='M';
        }

        $data_res['petugas']        = $this->m_data->getWhere('jadwal_kerja',array('tanggal' => date("Y-m-d"),'shift' => $shift,'id_unit' => sess()['unit']))->result_array();
       
        foreach ($data_res['petugas'] as $key => $value) {
            $user = $this->m_data->getWhere('user',array('id' => $value['id_user']))->row_array();
            $data_res['petugas'][$key ]['nama_user']=  $user['nama'];
        }
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
                                $nik        = $value->getCellByColumnAndRow(1, $row)->getValue();
                                $nama       = $value->getCellByColumnAndRow(2, $row)->getValue();
                                $master     =  $this->Mod->getWhere('user',array('nik' =>$nik))->row_array();
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

    function DownloadFormat($bulan=null){
        $personil = $this->m_data->getWhere('user',array('status' =>1,'unit_kerja' =>sess()['unit'] ))->result_array();
        $a_date = date('Y')."-".$bulan."-27";
        $tahun  =     date('Y');
         
        $max_date= date("t", strtotime($a_date));
        // for($x=1;$x<=$max_date;$x++){
        //     echo $x;
        //     //membuat perulangan yang menampilkan angka satu sampai sepuluh sesuai dengan aturan yang sudah di buat pada kondisi di atas.
        // }
        $data['personil']    = $personil;
        $data['date']        = $max_date;
        $data['bulan']       = $bulan;
        $data['tahun']       = $tahun;
        $year =     date('y');
            
         $this->load->view('jadwal_dinas', $data);
        //  echo "<pre>", print_r($data), "</pre>";
    }



}
