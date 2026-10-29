<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class user extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Excel');
       // $this->load->model("m_user");
        //$this->load->model("m_unit");
    }

    private function role() {
        if (session("role") != "ADMINISTRATOR" && session("role") != "READONLY") {
            redirect("login");
        }
    }


    private function checkData($id = "") {
        if ($id != "") {
            $q = $this->m_user->get(($id));
            if (is_object($q)) {
                redirect("user?token=" . token());
            }
            return $q;
        }
    }

    private function position() {
        $data["position"] = "user";
        return $data;
    }

    public function master() {

        //$this->role();
        $data = $this->position();
        $data["position"] .= "/master";
        // $data = access($data,"VIEW");
        // $data['units'] = $this->m_user->get_unit_options();

        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Pengguna";
        $data["title_des"] = " Daftar Data Pengguna";
        $data["content"] = "v_user_list";
        $this->db->order_by('kode_unit', 'ASC');
        $data['units']   = $this->Mod->getWhere('unit',array('status !=' =>8 ))->result_array();
        $data["data"] = $data;
        $this->load->view('template_v2', $data);
    }

    public function user_list()
    {
        
       // $data = $this->position();
        // $data["position"] .= "/master";
        // //$data = access($data,"VIEW");
        // $data = $this->m_data->getWhere('user',array('status!=' =>8))->result_array();

        // if($data){
        //     echo json_encode(['status'=>200,"msg"=>"sukses","data"=>$data]);
        // }else{
        //     echo json_encode(['status'=>500,"msg"=>"gagal","data"=>[]]);
        // }
    }

    public function user_log()
    {
        
        $data = $this->position();
        $data["position"] .= "/log";
        $data = access($data,"VIEW");
        $data = $this->m_user->get_user_log();
        if($data){
            echo json_encode(['status'=>200,"msg"=>"sukses","data"=>$data]);
        }else{
            echo json_encode(['status'=>500,"msg"=>"gagal","data"=>[]]);
        }
    }


    public function log()
    {
        $data = $this->position();
        $data["position"] .= "/log";
        $data = access($data,"VIEW");

        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Daftar Pengguna";
        $data["content"] = "v_user_log";

        $data["data"] = $data;
        $this->load->view('template', $data);
    }

    function LoadData(){
       
        //$data=$this->Mod->getWhere('user',array('status !=' =>8,'unit_kerja' => sess()['unit']))->result_array();
        
        if(isset($_POST['limit'])) {
            $limit = $_POST['limit'];
        } else {
            // Atur nilai default jika $_POST['limit'] tidak diatur
            $limit = 3000; 
        }
        if(isset($_POST['src'])) {
            $src = $_POST['src'];
        } else {
            // Atur nilai default jika $_POST['limit'] tidak diatur
            $src = ''; 
        }  
        $from               = $this->uri->segment(3);
        
        $kategori           = $this->input->post('kategori_user');
        $filter_unit        = $this->input->post('filter_unit');
        $iass_roles         = [1, 99, 101, 102, 103, 107, 109, 110, 111];
        $api_roles          = [2, 104, 105, 106, 108];

        $sess_user = function_exists('sess') ? sess() : [];
        $is_super = (isset($sess_user['type_user']) && $sess_user['type_user'] === 'super') || 
                    (isset($sess_user['username']) && $sess_user['username'] === 'iassomcgk');
        $user_unit = isset($sess_user['unit']) ? $sess_user['unit'] : null;

        $filter_conditions = [];
        if ($kategori === 'iass') {
            $filter_conditions[] = 'type_user IN (' . implode(',', $iass_roles) . ')';
        } elseif ($kategori === 'api') {
            $filter_conditions[] = 'type_user IN (' . implode(',', $api_roles) . ')';
        }

        // Terapkan filter unit
        if ($is_super) {
            if (!empty($filter_unit) && $filter_unit !== 'all') {
                if ($filter_unit === '0' || $filter_unit === 'none') {
                    $filter_conditions[] = '(unit_kerja = 0 OR unit_kerja IS NULL)';
                } else {
                    $filter_conditions[] = 'unit_kerja = ' . (int)$filter_unit;
                }
            }
        } else {
            if ($user_unit !== null) {
                $filter_conditions[] = 'unit_kerja = ' . (int)$user_unit;
            }
        }

        $filter_clause = !empty($filter_conditions) ? implode(' AND ', $filter_conditions) : '';
      
        $param=[
            'table'         => 'user' ,
            'pk'            => 'id' ,
            'parameter'     => array('status !=' => 8),
            'url'           => $this->uri->segment(2) ,
            'from'          => $from ,
            'limit'         => $limit ,
            'src'           => $src,
            'param_src'     => [
                                'like' => 'nik',
                                'or_like'=> 'nama'],
            'filter'        => $filter_clause ,
        ];

        $totalData              = CountDataPag($param);
        $param['total_data']    = $totalData;
        $param['total_page']    = ceil($totalData/$limit);
        $res                    = pagin($param);

        // Helper untuk menerapkan filter unit pada penghitungan badge total
        $apply_unit_filter = function($db) use ($is_super, $user_unit, $filter_unit) {
            $db->where('status !=', 8);
            if ($is_super) {
                if (!empty($filter_unit) && $filter_unit !== 'all') {
                    if ($filter_unit === '0' || $filter_unit === 'none') {
                        $db->group_start()->where('unit_kerja', 0)->or_where('unit_kerja IS NULL', null, false)->group_end();
                    } else {
                        $db->where('unit_kerja', (int)$filter_unit);
                    }
                }
            } else {
                if ($user_unit !== null) {
                    $db->where('unit_kerja', (int)$user_unit);
                }
            }
        };

        // Hitung total untuk badge tab kategori
        $apply_unit_filter($this->db);
        $count_all = $this->db->count_all_results('user');

        $apply_unit_filter($this->db);
        $this->db->where_in('type_user', $iass_roles);
        $count_iass = $this->db->count_all_results('user');

        $apply_unit_filter($this->db);
        $this->db->where_in('type_user', $api_roles);
        $count_api = $this->db->count_all_results('user');

        foreach ($res['data'] as $key => $value) {
           $unit                            = $this->Mod->getWhere('unit ',array('id_unit' => $value['unit_kerja']))->row_array();
           
           if ($value['unit_kerja'] == 0 || $value['unit_kerja'] == null) {
               $res['data'][$key]['unit'] = '<span class="badge badge-info" style="font-size:11px;">Semua Unit / Manager</span>';
           } else {
               $res['data'][$key]['unit'] = (!empty($unit['kode_unit']) ? $unit['kode_unit'] : '-');
           }
           
           $role                            = $this->Mod->getWhere('role',array('id' => $value['type_user']))->row_array();
           $res['data'][$key]['name_role']       = (!empty($role['name_role']) ? $role['name_role']: '');

           // Klasifikasi kategori user
           $type_user_int = (int)$value['type_user'];
           if (in_array($type_user_int, $iass_roles)) {
               $res['data'][$key]['category'] = 'iass';
           } elseif (in_array($type_user_int, $api_roles)) {
               $res['data'][$key]['category'] = 'api';
           } else {
               $res['data'][$key]['category'] = 'other';
           }
        }
        $data['data']       = $res['data'];
        $data['pag']        = $res['pag'];
        $data['counts']     = [
            'all'  => $count_all,
            'iass' => $count_iass,
            'api'  => $count_api
        ];
      
        echo json_encode($data);
    }

    public function ExportExcel()
    {
        $this->db->select('user.*, role.name_role, unit.kode_unit as unit_nama');
        $this->db->from('user');
        $this->db->join('role', 'user.type_user = role.id', 'left');
        $this->db->join('unit', 'unit.id_unit = user.unit_kerja', 'left');
        $this->db->where('user.status !=', 8);

        // Check if user is super admin or specific hardcoded username 'iassomcgk'
        $sess = sess();
        $is_super = (isset($sess['type_user']) && $sess['type_user'] == 'super') || 
                    (isset($sess['username']) && $sess['username'] == 'iassomcgk');

        if (!$is_super) {
            // Only export for their unit
            if (isset($sess['unit'])) {
                $this->db->where('user.unit_kerja', $sess['unit']);
            }
            // Only export specific user types
            $this->db->where_in('user.type_user', [1, 101, 102, 107]);
        } else {
            $unit_param = $this->input->get('unit');
            if (!empty($unit_param) && $unit_param !== 'all') {
                if ($unit_param === '0') {
                    $this->db->group_start()->where('user.unit_kerja', 0)->or_where('user.unit_kerja IS NULL', null, false)->group_end();
                } else {
                    $this->db->where('user.unit_kerja', (int)$unit_param);
                }
            }
        }

        $this->db->order_by('user.id', 'ASC');
        $res = $this->db->get()->result_array();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'NO');
        $sheet->setCellValue('B1', 'UNIT');
        $sheet->setCellValue('C1', 'USERNAME');
        $sheet->setCellValue('D1', 'NAMA');
        $sheet->setCellValue('E1', 'EMAIL');
        $sheet->setCellValue('F1', 'NIK');
        $sheet->setCellValue('G1', 'ROLE');
        $sheet->setCellValue('H1', 'STATUS');

        $row = 2;
        foreach ($res as $key => $val) {
            $status = ($val['status'] == 1) ? 'ACTIVE' : 'INACTIVE';
            $unit = ($val['unit_kerja'] == 0 || $val['unit_kerja'] == null) ? 'Semua Unit / Manager' : $val['unit_nama'];

            $sheet->setCellValue('A' . $row, $key + 1);
            $sheet->setCellValue('B' . $row, $unit);
            $sheet->setCellValue('C' . $row, $val['username']);
            $sheet->setCellValue('D' . $row, $val['nama']);
            $sheet->setCellValue('E' . $row, $val['email']);
            $sheet->setCellValue('F' . $row, $val['nik']);
            $sheet->setCellValue('G' . $row, $val['name_role']);
            $sheet->setCellValue('H' . $row, $status);
            $row++;
        }

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Export_User_' . date('YmdHis') . '.xlsx';

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    public function ExportExcelPersonil()
    {
        $this->db->select('user.*, role.name_role, unit.kode_unit as unit_nama');
        $this->db->from('user');
        $this->db->join('role', 'user.type_user = role.id', 'left');
        $this->db->join('unit', 'unit.id_unit = user.unit_kerja', 'left');
        $this->db->where('user.status !=', 8);
        $this->db->where('unit.status !=', 8);
        $this->db->where('user.unit_kerja IS NOT NULL');

        // Exclude specific user types for all roles (including super admin)
  
      $this->db->where_not_in('user.type_user', [2, 4, 99, 5, 6, 104, 105, 106, 108]);
        // Check if user is super admin or specific hardcoded username 'iassomcgk'
        $sess = sess();
        $is_super = (isset($sess['type_user']) && $sess['type_user'] == 'super') || 
                    (isset($sess['username']) && $sess['username'] == 'iassomcgk');

        if (!$is_super) {
            // Only export for their unit
            if (isset($sess['unit'])) {
                $this->db->where('user.unit_kerja', $sess['unit']);
            }
        } else {
            $unit_param = $this->input->get('unit');
            if (!empty($unit_param) && $unit_param !== 'all') {
                if ($unit_param === '0') {
                    $this->db->group_start()->where('user.unit_kerja', 0)->or_where('user.unit_kerja IS NULL', null, false)->group_end();
                } else {
                    $this->db->where('user.unit_kerja', (int)$unit_param);
                }
            }
        }

        $this->db->order_by('FIELD(user.unit_kerja, 28, 21, 22, 23, 18, 19, 20, 14, 15, 16, 17, 24, 25, 26, 27, 30) = 0, FIELD(user.unit_kerja, 28, 21, 22, 23, 18, 19, 20, 14, 15, 16, 17, 24, 25, 26, 27, 30)', '', FALSE);
        $this->db->order_by('FIELD(user.type_user, 103, 101, 102, 109, 110, 107, 1) = 0, FIELD(user.type_user, 103, 101, 102, 109, 110, 107, 1)', '', FALSE);
        $res = $this->db->get()->result_array();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'NO');
        $sheet->setCellValue('B1', 'UNIT');
        $sheet->setCellValue('C1', 'USERNAME');
        $sheet->setCellValue('D1', 'NAMA');
        $sheet->setCellValue('E1', 'EMAIL');
        $sheet->setCellValue('F1', 'NIK');
        $sheet->setCellValue('G1', 'ROLE');
        $sheet->setCellValue('H1', 'STATUS');

        $row = 2;
        foreach ($res as $key => $val) {
            $status = ($val['status'] == 1) ? 'ACTIVE' : 'INACTIVE';
            $unit = ($val['unit_kerja'] == 0 || $val['unit_kerja'] == null) ? 'Semua Unit / Manager' : $val['unit_nama'];

            $sheet->setCellValue('A' . $row, $key + 1);
            $sheet->setCellValue('B' . $row, $unit);
            $sheet->setCellValue('C' . $row, $val['username']);
            $sheet->setCellValue('D' . $row, $val['nama']);
            $sheet->setCellValue('E' . $row, $val['email']);
            $sheet->setCellValue('F' . $row, $val['nik']);
            $sheet->setCellValue('G' . $row, $val['name_role']);
            $sheet->setCellValue('H' . $row, $status);
            $row++;
        }

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Export_Personil_' . date('YmdHis') . '.xlsx';

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    public function ExportExcelIASS()
    {
        $this->db->select('user.*, role.name_role, unit.kode_unit as unit_nama');
        $this->db->from('user');
        $this->db->join('role', 'user.type_user = role.id', 'left');
        $this->db->join('unit', 'unit.id_unit = user.unit_kerja', 'left');
        $this->db->where('user.status !=', 8);

        // Only export specific user types for this specific report
        $this->db->where_in('user.type_user', [1, 102, 107]);

        $unit_param = $this->input->get('unit');
        if (!empty($unit_param) && $unit_param !== 'all') {
            if ($unit_param === '0') {
                $this->db->group_start()->where('user.unit_kerja', 0)->or_where('user.unit_kerja IS NULL', null, false)->group_end();
            } else {
                $this->db->where('user.unit_kerja', (int)$unit_param);
            }
        }

        $this->db->order_by('user.id', 'ASC');
        $res = $this->db->get()->result_array();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'NO');
        $sheet->setCellValue('B1', 'UNIT');
        $sheet->setCellValue('C1', 'USERNAME');
        $sheet->setCellValue('D1', 'NAMA');
        $sheet->setCellValue('E1', 'EMAIL');
        $sheet->setCellValue('F1', 'NIK');
        $sheet->setCellValue('G1', 'ROLE');
        $sheet->setCellValue('H1', 'STATUS');

        $row = 2;
        foreach ($res as $key => $val) {
            $status = ($val['status'] == 1) ? 'ACTIVE' : 'INACTIVE';
            $unit = ($val['unit_kerja'] == 0 || $val['unit_kerja'] == null) ? 'Semua Unit / Manager' : $val['unit_nama'];

            $sheet->setCellValue('A' . $row, $key + 1);
            $sheet->setCellValue('B' . $row, $unit);
            $sheet->setCellValue('C' . $row, $val['username']);
            $sheet->setCellValue('D' . $row, $val['nama']);
            $sheet->setCellValue('E' . $row, $val['email']);
            $sheet->setCellValue('F' . $row, $val['nik']);
            $sheet->setCellValue('G' . $row, $val['name_role']);
            $sheet->setCellValue('H' . $row, $status);
            $row++;
        }

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Export_Personil_IASS_' . date('YmdHis') . '.xlsx';

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    function EditData($id=null){
       
        $data=$this->Mod->getWhere('user',array('id' =>$id ))->row_array();
        echo json_encode($data);
    }


    public function SaveData()
    {

        $data=array_filter($_POST);

        if (!empty($data)) {
            $cek= $this->Mod->getWhere('user',array('username ' =>$data['username'] ))->num_rows();
                if (!empty($data['password'])) {
                $data['password'] = hassp($data['password']);
               }
            if ( $cek < 1) {
                $this->db->insert('user',$data);
                $res=[
                    'status' => '200',
                    'msg'       => 'Data Berhasil di disimpan'
                ];
    
            }else{
                $res=[
                    'status'    => '400',
                    'msg'       => 'Data Gagal Disimpan, username sudah ada'
                ];
                
            }
           
           
           
            // echo "<pre>",print_r ( $data),"</pre>";
            echo json_encode($res);
        }else{
            $res=[
                'status'    => '400',
                'msg'       => 'Data Gagal Disimpan, pastikan semua terisi'
            ];
            echo json_encode($res);
        }
        
       
        
    }
  

    function UpdateData($id){
        $data=array_filter($_POST);
        if (!empty($data)) {
            
            // $cek= $this->Mod->getWhere('user',array('username ' =>$data['username'] ))->num_rows();
                if (!empty($data['password'])) {
                    $data['password'] = hassp($data['password']);
                }
              
                    $update = $this->Mod->update2('user',array('id ' =>$id),$data);
                    // $this->db->insert('user',$data);
                if ($update) {
                    $res=[
                        'status' => '200',
                        'msg'       => 'Data Berhasil di disimpan'
                    ];
        
                }else{
                    $res=[
                        'status'    => '400',
                        'msg'       => 'Data Gagal Disimpan, username sudah ada'
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
        // echo "<pre>",print_r ( $data),"</pre>";
    }

    public function DeleteData($id = null)
    {
        //$this->m_data->delete('jenis_masalah', array('id' =>$id ));
        $data = [
            'status'        => 8,
        ];
        if (!empty($data)) {

            
            $res_update = $this->Mod->update2('user', array('id' => $id), $data);
            $res = [
                'status' => '200',
                'msg'       => 'Data Berhasil di Hapus'
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


    function UploadData(){
        if(isset($_FILES["filelampiran"]["name"])){
			$path = $_FILES["filelampiran"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
       
			
            $data           = array(); 
            $error          = array();
            $insert         = array();
            $datainsert     = array();
            $user_type  = $this->Mod->getWhere('role',array('status != ' =>8))->result_array();
            
			foreach($object->getWorksheetIterator(1) as $worksheet => $value){
			    $highestRow = $value->getHighestRow();
              
                $lastColumn = $value->getHighestDataColumn(); 
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($lastColumn);
          
                    if ($worksheet == 0) {
                        $f_nama = $value->getCellByColumnAndRow(1, 4)->getValue();
                        if ($f_nama !=="NAMA KARYAWAN") {
                            $error []="Kolom NAMA Tidak Sesuai Format";
                        }
                        $f_nik = $value->getCellByColumnAndRow(2, 4)->getValue();
                        if ($f_nik !=="NIK") {
                            $error []="Kolom NIK Tidak Sesuai Format";
                        }
                        $f_hp = $value->getCellByColumnAndRow(3, 4)->getValue();
                        if ($f_hp !=="No Hp") {
                            $error []="Kolom No HpTidak Sesuai Format";
                        }
                        $f_email = $value->getCellByColumnAndRow(4, 4)->getValue();
                        if ($f_email !=="Email") {
                            $error []="Kolom Email Tidak Sesuai Format";
                        }
                        $f_jenis = $value->getCellByColumnAndRow(5, 4)->getValue();
                        if ($f_jenis !=="Jenis User") {
                            $error []="Kolom Jenis User Tidak Sesuai Format";
                        }

                        for ($row=5; $row <=$highestRow ; $row++) { 
                           
                            $username       = $value->getCellByColumnAndRow(1, $row)->getValue();
                            $nama_lengkap   = $value->getCellByColumnAndRow(1, $row)->getValue();
                            $nik            = $value->getCellByColumnAndRow(2, $row)->getValue();
                            $email          = $value->getCellByColumnAndRow(3, $row)->getValue();
                            $hp             = $value->getCellByColumnAndRow(4, $row)->getValue();
                            $jenis          = $value->getCellByColumnAndRow(5, $row)->getValue();
                           
                                    // $password       = $value->getCellByColumnAndRow(1, $row)->getValue();
                                
                                    $pas = explode(" ",$nama_lengkap);
                                
                                    if (count($pas) > 0) {
                                        $pasword    = $pas[0];
                                        $nama       = $pas[0];
                                    }else{
                                        $pasword    = $nama_lengkap;
                                        $nama       = $nama_lengkap;
                                    }

                                    if (!empty($_POST['id_unit'])) {
                                        $id_unit = $_POST['id_unit'];
                                    }else{
                                        $id_unit ='';
                                    }
                                    // echo "<pre>",print_r ( in_array($jenis,array_column($user_type, 'name_code'))),"</pre>";
                                    if (in_array($jenis,array_column($user_type, 'name_code'))) {
                                       
                                        $tes = array_search($jenis,array_column($user_type, 'name_role'));
                                       
                                        $insert[]=[
                                            'username'          => strtolower($nama) ,
                                            'password'          => hassp($nik) ,
                                           
                                            'nik'               => $nik,
                                            'nama'              => $nama_lengkap,
                                            'no_hp'             => $hp,
                                            'email'             => $email,
                                            'unit_kerja'        => $id_unit,
                                            'type_user'         => $user_type[$tes]['id'],
                                          
                                            'created'           => '',
                                            'status'            => 1
                                            
                                    
                                        ];
                                        // $this->db->insert('user',$inst);
                                    }else{
                                        $error []=[
                                            'user'  =>$username,
                                            'msg'=>  "Jenis User Tidak terdaftar",

                                        ];
                                       ;
                                    }
                                    

                                    // $cek= $this->Mod->getWhere('user',array('username ' =>strtolower($username)));
                                    // if ( $cek->num_rows() < 1) {
                                    //     echo "Sudah Ada";
                                    //     echo "<pre>",print_r ($insert),"</pre>";
                                    //     //  $this->db->insert('user',$insert);
                                    // }else{
                                    // $datauser=  $cek->row_array();
                                    //     echo "<pre>",print_r ($datauser),"</pre>";
                                    //     $updateData=[
                                    //         'nik'               => $nik,
                                    //     ];
                                    //     $datauser['id'];
                                    //     // $update = $this->Mod->update2('user',array('id' =>$datauser['id']),$updateData);
                                    
                                    // }
                                    
                                //
                                
                        }
                        
                    }
         
             
            }
           
            if (count($error) > 1) {
                // echo "<pre>",print_r ( $error),"</pre>";
              
            }else{
                echo "<pre>",print_r ( $insert),"</pre>";
                // echo "<pre>",print_r ( $insert),"</pre>";
                foreach ($insert as $key => $value) {
                  
                    $cek        = $this->Mod->getWhere('user',array('status != ' =>8))->result_array();
                 
                    if (array_search($value['nik'],array_column($cek, 'nik'))) {
                        $tes = array_search($value['nik'],array_column($cek, 'nik'));
                        // echo "data ada";
                        $this->Mod->update2('user',array('id' =>$cek[$tes]['id']),$value);
                                    
                        // echo "<pre>",print_r ($value),"</pre>";
                        // echo "<pre>",print_r ($cek[$tes]['id']),"</pre>";
                    }else{
                      
                        $this->db->insert('user',$value);
                        // $inst=$value;
                        // echo "<pre>",print_r ($value),"</pre>";
                    }

                    
                   


                    // 
                }
               
                
            }

            
        }
    }

}

