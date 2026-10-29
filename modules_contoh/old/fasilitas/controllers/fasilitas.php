<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Fasilitas extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->library('excel');
        $this->load->model("m_data");
        $this->role();
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
        $data["title"] = "Fasilitas";
        $data["title_des"] = " List Data Fasilitas";
        $data["content"] = "v_index";

        $data["data"] = $data;

        $tes= $this->m_data->getWhere('fasilitas',array('status !=' => 8))->result_array();
        $update_lokasi = array();
        foreach ($tes as $key => $value) {
            // $this->m_data->getWhere('fasilitas_detail',array('id_fasilitas' =>$value['id_fasilitas'],'status !=' => 8 ))->result_array();
            if ($value['terminal'] == '3U-INT' ||$value['terminal']  =='3U-DOM') {
                $sub = $this->m_data->getWhere('terminal',array('nama_terminal' =>$value['zona'],'status !=' => 8 ,'parent_id' =>3 ))->row_array();
                if (!empty($sub)) {
                    $update_lokasi[]=[
                        'id_lokasi'     =>'3',
                        'id_sublokasi'  => $sub['id'],
                        'id_fasilitas'  => $value['id_fasilitas'] 
                    ];
                }
            }elseif ($value['terminal'] == '2F' || $value['terminal']  =='2E' ||$value['terminal']  =='2D') {
                $sub = $this->m_data->getWhere('terminal',array('nama_terminal' =>$value['zona'],'status !=' => 8,'parent_id' =>2 ))->row_array();
                if (!empty($sub)) {
                    $update_lokasi[]=[
                        'id_lokasi'     =>'2',
                        'id_sublokasi'  => $sub['id'],
                        'id_fasilitas'  => $value['id_fasilitas'] 
                    ];
                }
            }elseif ($value['terminal'] == '1C' || $value['terminal']  =='1B' ||$value['terminal']  =='1A') {
                $sub = $this->m_data->getWhere('terminal',array('nama_terminal' =>$value['zona'],'status !=' => 8,'parent_id' =>1 ))->row_array();
                if (!empty($sub)) {
                    $update_lokasi[]=[
                        'id_lokasi'     =>'1',
                        'id_sublokasi'  => $sub['id'],
                        'id_fasilitas'  => $value['id_fasilitas'] 
                    ];
                }
            }
        }
        // foreach ($update_lokasi as $key => $value) {
        //     echo "<pre>",print_r ($value),"</pre>";
        //     $update = $this->Mod->update2('fasilitas',array('id_fasilitas  ' =>$value['id_fasilitas']),$value);
        // }
        // // echo "<pre>",print_r ($tes),"</pre>";
        
        $this->load->view('template_v2', $data);
        // echo "<pre>",print_r ( $this->session->userdata()),"</pre>";
    }

    
    function LoadData(){
        //$data= $this->position();
        // $acc  = access($data,"VIEW")['access'];
      
        // Periksa apakah $_POST['limit'] sudah diatur
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
      
        $param=[
            'table'         => 'fasilitas' ,
            'pk'            => 'id_fasilitas' ,
            'parameter'     => array('status !=' => 8, 'id_unit'=> sess()['unit']) ,
            'url'           => $this->uri->segment(2) ,
            'from'          => $from ,
            'limit'         => $limit ,
            'src'           => $src,
            'param_src'     => [
                                'like' => 'nama_fasilitas',
                                'or_like'=> 'ip_address']
        ];
        $totalData          = CountDataPag($param);
        $param['total_data'] = $totalData;
        $param['total_page'] = ceil($totalData/$limit);
        $res                = pagin($param);
        foreach ($res['data'] as $key => $value) {
           $lokasi      = $this->m_data->getWhere('terminal ',array('id' => $value['id_lokasi']))->row_array();
           $sublokasi   = $this->m_data->getWhere('terminal ',array('id' => $value['id_sublokasi']))->row_array();
           $res['data'][$key]['lokasi']     = (!empty($lokasi['nama_terminal']) ? $lokasi['nama_terminal']: '');
           $res['data'][$key]['sublokasi']  = (!empty($sublokasi['nama_terminal']) ? $sublokasi['nama_terminal']: '');
        }
        $data['fasilitas']  = $res['data'];
        $data['pag']        = $res['pag'];
        echo json_encode($data);
    }
    
    function summary(){
        $data['sum']    = $this->Mod->GetCustome("SELECT a.id,a.nama_terminal, COUNT(b.id_lokasi) as total FROM terminal a left join fasilitas b on b.id_lokasi = a.id where a.parent_id = '-1' and b.id_unit='".sess()['unit']."' group by a.id,a.nama_terminal")->result_array();
        $data['all']    = $this->Mod->GetCustome("SELECT COUNT(*) as total FROM  fasilitas where id_unit='".sess()['unit']."' ")->row_array(); 
        echo json_encode($data);
    }
    function performa($id=null){
        $data["plugin"][]   = "plugin/datatable";
        $data["plugin"][]   = "plugin/select2";
        $data["title"]      = "Fasilitas";
        $data["title_des"]  = " Performa Fasilitas";
        $data["content"]    = "v_performa";
        $data['id']         = $id;
       
        $data["data"] = $data;
       
        $this->load->view('template_v2', $data);
    }


    function LoadDataAnl($id=null){
        $perangkat                              = $this->m_data->getWhere('perangkat',array('id_perangkat' => $id))->row_array();
        if (!empty($perangkat['nama_perangkat'])) {
            $lokasi                             =  $this->m_data->getWhere('terminal',array('id' => $perangkat['id_perangkat']))->row_array();
            $perangkat['nama_perangkat']        =  (!empty($perangkat['nama_perangkat']) ? $perangkat['nama_perangkat']: '');
        }else{
            $perangkat['nama_perangkat']        =  (!empty($lokasi['nama_perangkat']) ? $lokasi['nama_perangkat']: '');
        }
        // $result['data']=  $data;
        $todayDate = date('Y-m-d');
        $logHistory = $this->Mod->GetCustome(" SELECT * FROM logbook WHERE id_fasilitas = '".$id."'
                                        ")->result_array();
 
                                             // WHERE 
                                             // DATE(tj.date_start) = '$todayDate'
    
        // Menyimpan data log history ke dalam variabel $data
        $result['LogHistory'] = $logHistory;
        // Mengemas semua data ke dalam satu array
    
        // $result['data'] = $data;

        $downtime = $this->Mod->GetCustome("SELECT SUM(TIMESTAMPDIFF(MINUTE, date_start, update_date)) AS total_downTime FROM tinjut WHERE update_date >= NOW() - INTERVAL 1 MONTH AND date_start >= NOW() - INTERVAL 1 MONTH")->row_array();
         $uptime = $this->Mod->GetCustome("SELECT (TIMESTAMPDIFF(MINUTE, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH)) * (SELECT COUNT(*) FROM fasilitas)) AS uptime")->row_array();
         
         $totaldowntime = $downtime['total_downTime'];
         $totaluptime = $uptime['uptime'];
         $performa = ($totaluptime - $totaldowntime) / $totaluptime * 100;

         $performa_formatted = number_format(round($performa)); // Format nilai bulat ke 2 angka desimal dan tambahkan '%' di akhir
         $result['perfomChart'] = array('Performa' => round($performa)); // Bulatkan ke 2 angka desimal
         $result['perfomChart'] = array('Performa' => $performa_formatted); // Simpan nilai yang sudah diformat
         
        
        $data['url']            = $this->uri->segment(2);
        $totalData              = $this->Mod->CountData('perangkat','id_perangkat',array('status !=' => 8))->num_rows();
         

        $tabel                  = $this->Mod->GetCustome("
        SELECT 
            p.id_perangkat,
            p.nama_perangkat, 
            p.status as status_perangkat,
            u.kode_unit,
            f.ip_address,
            p.serial_number,
            f.status,
            l.create_date,
            m.nama AS merk_nama,
            jp.nama AS nama_jp
        FROM 
            perangkat p
        LEFT JOIN
            fasilitas_detail fd ON fd.id_perangkat = p.id_perangkat
        LEFT JOIN 
            unit u ON p.id_unit = u.id_unit
        LEFT JOIN
            fasilitas f ON fd.id_fasilitas = f.id_fasilitas
        LEFT JOIN
            (
                SELECT id_perangkat, MAX(create_date) AS max_create_date
                FROM logbook
                GROUP BY id_perangkat
            ) l_max ON l_max.id_perangkat = p.id_perangkat
        LEFT JOIN
            logbook l ON l.id_perangkat = p.id_perangkat AND l.create_date = l_max.max_create_date
        LEFT JOIN
            merk m ON m.id = p.merk_id
        LEFT JOIN
            jenis_perangkat jp ON jp.id_jenisperangkat = p.id_jenisperangkat
        WHERE
            fd.id_fasilitas = $id
        GROUP BY
            fd.id_perangkat
        ORDER BY
            l.create_date DESC
     ")->result_array();

        // Mengemas data ke dalam array result
        $result['tabel-data']   = $tabel;
        

        // $total_log = $this->Mod->GetCustome(" SELECT a.id_jenisperangkat,a.nama,COUNT(b.id_fasilitas) as total FROM jenis_perangkat a left join logbook b on b.id_jenisperangkat = a.id_jenisperangkat  where b.id_fasilitas = ".$id." GROUP by a.id_jenisperangkat,a.nama,b.id_fasilitas")->result_array();
        $total_log =$this->Mod->GetCustome("SELECT b.* FROM fasilitas_detail a left join jenis_perangkat b on b.id_jenisperangkat = a.id_jenisperangkat where a.id_fasilitas ='".$id."'")->result_array();
        $totaldata_log=0;
        foreach ($total_log as $key => $value) {
           
            $perangkat = $this->m_data->getWhere('logbook',array('id_fasilitas'=> $id,'id_jenisperangkat' => $value['id_jenisperangkat']))->num_rows();
            $total_log[$key]['total'] = $perangkat;
            $totaldata_log = $totaldata_log+ $perangkat;
           
        }

        
        // Mengemas semua data ke dalam satu array
        foreach ($total_log as $key => $value) {
            $persen = ($totaldata_log != 0 ? round(($value['total'] / $totaldata_log) * 100) : 0);
            $result['ProgressData'][] =[
                'name'          => $value['nama'],
                'value'         => $persen ,
                'class'         => log_status($persen),
                'totaldata'     => $totaldata_log,
                'totaljenis'    => $value['total'] 
             ];
        }
        $fasilitas = $this->m_data->getWhere('fasilitas',array('id_fasilitas' =>$id ))->row_array();
                
        $result['fasilitas']=  $fasilitas;
        echo json_encode($result);
    }

    
    function Loadmasterdetail($id){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
      
        $data = $this->m_data->getWhere('master_perangkat_detail',array('id_jenisperangkat' =>$id,'status !=' => 8 ))->result_array();
        echo json_encode($data);
    }

     

    function LoadDataJP(){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
       
        //  $data= $this->Mod->getWhere('jenis_perangkat',array('id_unit' => sess()['unit']))->result_array();
         $data=  $this->Mod->GetCustome(" SELECT * FROM jenis_perangkat WHERE id_unit in ('0','".sess()['unit']."')")->result_array(); 
        //  $this->Mod->getData('jenis_perangkat')->result_array();
       
        echo json_encode($data);
    }

    function LoadDataPerangkat($id){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
       
         $data= $this->m_data->getWhere('perangkat',array('status' =>0,'id_unit' => sess()['unit'],'id_jenisperangkat' => $id))->result_array();
       
        echo json_encode($data);
    }
    function LoadDataPerangkatByID($id){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
       
         $data= $this->m_data->getWhere('fasilitas_detail',array('id_fasilitas' =>$id))->result_array();
         foreach ($data as $key => $value) {
            $detail=  $this->m_data->getWhere('perangkat',array('id_perangkat' => $value['id_perangkat']))->row_array();
           
            $data[$key]['detail'] = $detail;
        }
        
        
       
        echo json_encode($data);
    }
    
    function GetLokasi(){
        //$data= $this->Mod->getData('terminal')->result_array();
        $data= $this->Mod->getWhere('terminal',array('parent_id' =>-1))->result_array();
        echo json_encode($data);
    }
    function GetArea($idlokasi){
        $data= $this->Mod->getWhere('terminal',array('parent_id' =>$idlokasi))->result_array();
        echo json_encode($data);
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

    function SaveData(){

        $data=array_filter($_POST);
        unset($data['Newitems']);
        if (!empty($data)) {
            $data['id_unit']    = sess()['unit']; 
            $data['status']     = 0;
            $this->db->insert('fasilitas',$data);
            $id = $this->db->insert_id();
            if (!empty($_POST['Newitems'])) {
				
				foreach ($_POST['Newitems'] as $key => $value) {
					
					$perangkat=[

						'id_fasilitas' 		=>  $id,
						'id_perangkat' 		=>  $value['id_perangkat'],
						'id_jenisperangkat'	=> $value['id_jenisperangkat'], 
						'status' 			=> 1,
					];
                    $this->db->insert('fasilitas_detail',$perangkat);
                    // echo "<pre>",print_r ( $perangkat),"</pre>";
				}	
				
			}
        }
        // echo "<pre>",print_r ( $data),"</pre>";

       
    }

    function EditData($id=null){
        $data           = $this->Mod->GetCustome("SELECT a.*,b.kode_unit as unit,c.nama_terminal as lokasi,d.nama_terminal as sub_lokasi FROM fasilitas a left join unit b on b.id_unit =a.id_unit left join terminal c on c.id=a.id_lokasi left join terminal d on d.id=a.id_sublokasi where a.id_fasilitas = '".$id."'")->row_array();
        $detail         = $this->Mod->GetCustome("SELECT a.*,b.nama_perangkat,b.serial_number,c.nama as jenis_perangkat FROM fasilitas_detail a left join perangkat b on b.id_perangkat = a.id_perangkat left join jenis_perangkat c on c.id_jenisperangkat = a.id_jenisperangkat where a.id_fasilitas = '".$id."'")->result_array();
        $data['detail'] = $detail ;
        echo json_encode($data);
    }

    public function UpdateData($pk=null)
    {
        $data=array_filter($_POST);
        unset($data['Newitems']);
        unset($data['Items']);
        unset($data['removed_items']);
        if (!empty($data)) {
            $update = $this->Mod->update2('fasilitas',array('id_fasilitas  ' =>$pk),$data);
            // $this->db->insert('user',$data);
            if (!empty($_POST['removed_items'])) {
             
				foreach ($_POST['removed_items'] as $key => $value) {
                    $fasilitas_detail = $this->m_data->getWhere('fasilitas_detail',array('idfasilitas_detail' =>$value))->row_array();
                    $status_perangkat =[
                        'status' => 0 
                    ];
                    $this->Mod->update2('perangkat',array('id_perangkat' =>$value['id_perangkat']),$status_perangkat);
                    $result = $this->Mod->delete('fasilitas_detail', array('idfasilitas_detail' => $value));
                    
                    
                    
				}	
			}

            if (!empty($_POST['Items'])) {
				
				foreach ($_POST['Items'] as $key => $value) {
                    $fasilitas_detail = $this->m_data->getWhere('fasilitas_detail',array('idfasilitas_detail' =>$value['idfasilitas_detail']))->row_array();
                    $status_perangkat =[
                        'status' => 0 
                    ];
                    $this->Mod->update2('perangkat',array('id_perangkat' =>$fasilitas_detail['id_perangkat']),$status_perangkat);
                    //mengubah status perangkat sebelumnya diggunakan di fasilitas menjadi tidak digunakan


					$perangkat=[
						'id_fasilitas' 		    => $pk,
						'id_perangkat' 		    => $value['id_perangkat'],
						'id_jenisperangkat'	    => $value['id_jenisperangkat'], 
                        'tanggal_penggunaan'    => $value['tanggal_pemasangan'],
						'status' 			    => 1,
					];
                    $update_detail = $this->Mod->update2('fasilitas_detail',array('idfasilitas_detail' =>$value['idfasilitas_detail']),$perangkat);
                 
                    $status_perangkat =[
                        'status' => 1 
                    ];
                    $this->Mod->update2('perangkat',array('id_perangkat' =>$value['id_perangkat']),$status_perangkat);
				}	
				
			}
            if (!empty($_POST['Newitems'])) {
				
				foreach ($_POST['Newitems'] as $key => $value) {
					
					$perangkat=[
						'id_fasilitas' 		    => $pk,
						'id_perangkat' 		    => $value['id_perangkat'],
						'id_jenisperangkat'	    => $value['id_jenisperangkat'], 
                        'tanggal_penggunaan'    => '',
						'status' 			    => 1,
					];
                    $this->db->insert('fasilitas_detail',$perangkat);

                    $status_perangkat =[
                        'status' => 1 
                    ];
                    $this->Mod->update2('perangkat',array('id_perangkat' =>$value['id_perangkat']),$status_perangkat);
				}	
				
			}
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
        }
             
    }

    function UploadData(){
        $data=array();
        if(isset($_FILES["filelampiran"]["name"])){
			$path = $_FILES["filelampiran"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
       
			
            $data           = array();
            $data_triwulan  = array();
            $data_sms       = array();
            $data_thn       = array();
            $datacctv_bulanan = array();

            $detail_prop= array();
			foreach($object->getWorksheetIterator(1) as $worksheet => $value){
			    $highestRow = $value->getHighestRow();
              
                $lastColumn = $value->getHighestDataColumn(); 
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($lastColumn);
         
                    if ($worksheet == 0) {
                        for($col=3 ; $col<=$highestColumnIndex; $col++){
                            if ($col >= 9 && $col <= 14) {
                                $detail_prop            = $value->getCellByColumnAndRow($col, 3)->getValue();
                                $data['detail_prop_pc'][]= $detail_prop;
                               
                            }
                          
                          
                            
                        }

                          for ($row=4; $row <=$highestRow ; $row++) { 
                            $nama_fasilitas         = $value->getCellByColumnAndRow(1, $row)->getValue();
                            $lokasi                 = $value->getCellByColumnAndRow(2, $row)->getValue();
                            $sublokasi              = $value->getCellByColumnAndRow(3, $row)->getValue();
                            $ipaddress              = $value->getCellByColumnAndRow(4, $row)->getValue();
                            //mini pc
                            $buatan                 = $value->getCellByColumnAndRow(5, $row)->getValue();      
                            $merk                   = $value->getCellByColumnAndRow(6, $row)->getValue();
                            $model                  = $value->getCellByColumnAndRow(7, $row)->getValue();
                            $sn_perangkat           = $value->getCellByColumnAndRow(8, $row)->getValue();
                            $suport_port            = $value->getCellByColumnAndRow(9, $row)->getValue();
                            $disk                   = $value->getCellByColumnAndRow(10, $row)->getValue();
                            $ram                    = $value->getCellByColumnAndRow(11, $row)->getValue();
                            $os                     = $value->getCellByColumnAndRow(12, $row)->getValue();
                            $tahun_perangkat        = $value->getCellByColumnAndRow(13, $row)->getValue();

                            //monitor
                            $buatan2                = $value->getCellByColumnAndRow(15, $row)->getValue();      
                            $merk2                  = $value->getCellByColumnAndRow(16, $row)->getValue();
                            $model2                 = $value->getCellByColumnAndRow(17, $row)->getValue();
                            $sn_perangkat2          = $value->getCellByColumnAndRow(18, $row)->getValue();
                            $suport_port2           = $value->getCellByColumnAndRow(19, $row)->getValue();
                            $ukuran                 = $value->getCellByColumnAndRow(20, $row)->getValue();
                            $tahun_perangkat        = $value->getCellByColumnAndRow(21, $row)->getValue();
                            $kondisi2                = $value->getCellByColumnAndRow(22, $row)->getValue();

                          
                            $getmerek               = $this->Mod->getWhere('merk',array('nama' =>$merk ))->row_array();
                        
                            $miniPC = [
                                'id_jenisperangkat'     => 2,
                                'nama_perangkat'        => 'Mini PC '.$merk.' model '. $model ,
                                'model'                 => $model  ,
                                'merk_id'               => $getmerek['id'] , 
                                'serial_number'         => $sn_perangkat  , 
                                'suport_port'           => $suport_port,
                                'disk_kapasity'         => $disk,
                                'ram'                   => $ram, 
                                'OS'                    => $os,
                                'tahun_pengadaan'       => $tahun_perangkat ,
                            ];

                            $getmerek2               = $this->Mod->getWhere('merk',array('nama' =>$merk2 ))->row_array();
                            $monitor =[
                                'id_jenisperangkat'     => 1,
                               
                                'nama_perangkat'        => 'Monitor '.$merk2.' model '. $model2 ,
                                'buatan'                => $buatan2 ,
                                'merk_id'               => $getmerek2['id'] , 
                                'model'                 => $model2  ,
                                'serial_number'         => $sn_perangkat2  , 
                                'suport_port'           => $suport_port2,
                                'ukuran'                => $ukuran,
                                'tahun_pengadaan'       => $tahun_perangkat ,
                                'kondisi'               => $kondisi2, 
                               
                               
                            ];
                            $sub =  $this->Mod->getWhere('terminal',array('nama_terminal' =>$sublokasi ))->row_array();
                            if (!empty($sub)) {
                                $id_sub = $sub['id'];
                            }else{
                                $id_sub = '';
                            }
                        
                            if ($lokasi = '3U-INT') {
                                $data_lokasi = '3';
                            }
                            $data['data'][] =[
                                'nama_fasilitas'    => $nama_fasilitas, 
                                'id_unit'           => '',
                                'id_lokasi'         => $data_lokasi,
                                'id_sublokasi'      => $id_sub, 
                                'ip_address'        => $ipaddress,
                                'mini_pc'           =>  $miniPC,
                                'monitor'           =>  $monitor
                            ];
                        
                            
                        }
                    }
                   }
             
           
        }

        $perangkat_detail=array();
        foreach ($data as $key => $value) {
           
            if ($key == 'data') {
                $fasilitas =[
                    'nama_fasilitas'        => '' ,
                    'id_unit'               => '' ,
                    'id_lokasi'             =>  '',
                    'id_sublokasi'          => '', 
                    'ip_address'            => ''
                ];
              
                foreach ($value as $key2 => $value2) {
                  
                    if ($key2 =='mini_pc') {
                      
                        $perangkat=[
                            'id_jenisperangkat'     => $value2['mini_pc']['id_jenisperangkat'],
                            'nama_perangkat'        => $value2['mini_pc']['nama_perangkat'],
                            'model'                 => $value2['mini_pc']['model'],
                            'merk_id'               => $value2['mini_pc']['merk_id'],
                            'serial_number'         => $value2['mini_pc']['serial_number'],
                        ];
                        foreach ($value2['mini_pc'] as $key3 => $val3) {
                           
                           
                            if ($key3 == 'suport_port') {
                                $perangkat_detail[]=[
                                    'idmaster_detail_perangkat' => 27,
                                    'nama'                      => $val3
                                ];

                            }

                            if ($key3 == 'disk_kapasity') {
                                $perangkat_detail[]=[
                                    'idmaster_detail_perangkat' => 28,
                                    'nama'                      => $val3
                                ];
                            }

                            if ($key3 == 'disk_kapasity') {
                                $perangkat_detail[]=[
                                    'idmaster_detail_perangkat' => 28,
                                    'nama'                      => $val3
                                ];
                            }

                            if ($key3 == 'ram') {
                                $perangkat_detail[]=[
                                    'idmaster_detail_perangkat' => 29,
                                    'nama'                      => $val3
                                ];
                            }

                            if ($key3 == 'OS') {
                                $perangkat_detail[]=[
                                    'idmaster_detail_perangkat' => 30,
                                    'nama'                      => $val3
                                ];
                            }
                          
                       
                        }

                        
                    }

                    if ($key2 =='monitor') {
                      
                        $perangkat=[
                            'id_jenisperangkat'     => $value2['monitor']['id_jenisperangkat'],
                            'nama_perangkat'        => $value2['monitor']['nama_perangkat'],
                            'model'                 => $value2['monitor']['model'],
                            'merk_id'               => $value2['monitor']['merk_id'],
                            'serial_number'         => $value2['monitor']['serial_number'],
                        ];
                        foreach ($value2['monitor'] as $key3 => $val3) {
                           
                           
                            if ($key3 == 'suport_port') {
                                $perangkat_detail[]=[
                                    'idmaster_detail_perangkat' => 31,
                                    'nama'                      => $val3
                                ];

                            }

                            if ($key3 == 'ukuran') {
                                $perangkat_detail[]=[
                                    'idmaster_detail_perangkat' => 1,
                                    'nama'                      => $val3
                                ];

                            }
                        }
                       
                     
                    }
                    
                }
                
            }
           
         
        }
        echo "<pre>", print_r($perangkat_detail), "</pre>";
    }

//     function   CopyData(){
//         $fasilitas = $this->m_data->getWhere('perangkat_old',array('status !=' =>8))->result_array();
//         foreach ($fasilitas as $key => $value) {
//             $data=[
//                 'nama_fasilitas'    => $value['nama_perangkat'] ,
//                 'ip_address'        => $value['ip'] ,
//                 'keterangan'        => $value['lokasi'] ,
//                 'id_unit'           => sess()['unit'],
//                 'status'            => 0
//             ];
//             $this->db->insert('fasilitas',$data);
//         }
//         echo "<pre>", print_r($fasilitas), "</pre>";
//     }


        function CekIp($id_fasilitas = null){
            if (!empty($id_fasilitas)) {
                $data_res = $this->m_data->getWhere('fasilitas',array('id_fasilitas' =>$id_fasilitas ))->row_array();
                $replay =1; 
                $respon=array();
                if (!empty($data_res['ip_address'])) {
                   $ip=$data_res['ip_address'];
                    exec("ping -n 3  $ip", $output, $status);
                    if ($status == 0) {
                        $respon=[
                            // 'ip'            => $ip,
                            'status'        => 1,
                            'updateDate'    => date("Y-m-d"),
                            'updateTime'    => date("h:i:sa")
                        ];
                        // $this->m_data->updateData('perangkat', array('id' => $data_res['id']), $respon);
                    }else{
        
                        $respon=[
                            // 'ip'            => $ip,
                            'status'        => 0,
                            'updateDate'    => date("Y-m-d"),
                            'updateTime'    => date("h:i:sa")
                        ];
                        // $this->m_data->updateData('perangkat', array('id' => $data_res['id']), $respon);
                        // $responLog=[
                        //     'ip'            => $ip,
                        //     'lokasi'        =>  $data_res['lokasi'],
                        //     'status'        => 'RTO',
                        //     'datecek'       => date("Y-m-d"),
                        //     'updateTime'    => date("h:i:sa")
        
                        // ];
                        //$this->m_data->insertData('perangkat',$data);
                    }
                    echo json_encode($respon);
                }
            }
            
    
           
        }

        function ValidateData(){
            $fasilitas = $this->m_data->getWhere('fasilitas',array('status !=' =>8, 'id_unit'=> sess()['unit']))->result_array();

            foreach ($fasilitas as $key => $value) {
                $detail = $this->m_data->getWhere('fasilitas_detail',array('id_fasilitas' =>$value['id_fasilitas']))->result_array();
                foreach ($detail as $key2 => $val2) {
                    $perangkat = $this->m_data->getWhere('perangkat',array('id_perangkat' =>$val2['id_perangkat']))->row_array();
                    if (!empty($perangkat)) {
                       
                            $perangkat['idfasilitas'] = $value['id_fasilitas'];
                         
                            $fasilitas[$key]['perangkat'][] = [
                                'id_perangkat'          => $perangkat['id_perangkat'],
                                'id_jenisperangkat'     => $perangkat['id_jenisperangkat'],
                                'status'                => $perangkat['status'] 

                            ];
                            
                    }else{
                        $fasilitas[$key]['perangkat'][]='';
                    }
                   
                    
                }
                // $data=[
                //     'nama_fasilitas'    => $value['nama_perangkat'] ,
                //     'ip_address'        => $value['ip'] ,
                //     'keterangan'        => $value['lokasi'] ,
                //     'id_unit'           => sess()['unit'],
                //     'status'            => 0
                //     ];
               
            }
            // echo "<pre>", print_r($fasilitas), "</pre>";

        
        }

        function ViewDetail($id=null){
            if (!empty($id)) {
                $data           = $this->Mod->GetCustome("SELECT a.*,b.kode_unit as unit,c.nama_terminal as lokasi,d.nama_terminal as sub_lokasi FROM fasilitas a left join unit b on b.id_unit =a.id_unit left join terminal c on c.id=a.id_lokasi left join terminal d on d.id=a.id_sublokasi where a.id_fasilitas = '".$id."'")->row_array();
                $detail         = $this->Mod->GetCustome("SELECT a.*,b.nama_perangkat,c.nama as jenis_perangkat FROM fasilitas_detail a left join perangkat b on b.id_perangkat = a.id_perangkat left join jenis_perangkat c on c.id_jenisperangkat = a.id_jenisperangkat where a.id_fasilitas = '".$id."'")->result_array();
           
                $data['detail'] = $detail ;
                echo json_encode($data);
            }
        }
        function SessTerminal(){
            $fasilitas = $this->m_data->getWhere('fasilitas',array('status !=' =>8, 'id_unit'=> sess()['unit'],'id_lokasi ' => 0))->result_array();
            echo "<pre>", print_r($fasilitas), "</pre>";
            foreach ($fasilitas as $key => $value) {
               $terminal =  $this->Mod->GetCustome("SELECT  * FROM terminal WHERE nama_terminal like '%".$value['terminal']."%'")->row_array();
                if (!empty($terminal)) {
                   
                   if ($terminal['parent_id'] == '-1') {
                        $update=['id_lokasi'     => $terminal['id']];
                   }else{
                        $update=[
                            'id_lokasi'         => $terminal['parent_id'],
                            'id_sublokasi'     => $terminal['id'
                            ]];
                   }
                    
                   $this->Mod->update2('fasilitas',array('id_fasilitas  ' =>$value['id_fasilitas']),$update);
                   
                }else{
                    //  echo  $value['nama_fasilitas']."|".$value['terminal']."|Jalan Raya Perkantoran <br>";
                      // echo "<pre>", print_r($value), "</pre>"; 
                    if ($value['terminal'] =='JNP') {
                        $update=['id_lokasi'     => 4];
                    }
                    elseif ($value['terminal'] =='Apron Terminal 2') {
                        $update=['id_lokasi'     => 2];
                    }elseif ($value['terminal'] =='Parkir Terminal 1') {
                        $update=['id_lokasi'     => 1];
                    }elseif ($value['terminal'] =='Parkir Terminal 2') {
                        $update=['id_lokasi'     => 2];
                    }elseif ($value['terminal'] =='Damri Terminal 1') {
                        $update=['id_lokasi'     => 1];
                    }elseif ($value['terminal'] =='Damri Terminal 2') {
                        $update=['id_lokasi'     => 2];
                    }elseif ($value['terminal'] =='Parkir Inap') {
                        $update=['id_lokasi'     => 4];
                    }elseif ($value['terminal'] =='Apron Terminal 1') {
                        $update=['id_lokasi'     => 1];
                    }elseif ($value['terminal'] =='Parkir Terminal 1') {
                        $update=['id_lokasi'     => 1];
                    }elseif ($value['terminal'] =='Apron Terminal 3') {
                        $update=['id_lokasi'     => 3];
                    }elseif ($value['terminal'] =='Cooling T1') {
                        $update=['id_lokasi'     => 1];
                    }elseif ($value['terminal'] =='Cooling T2') {
                        $update=['id_lokasi'     => 2];
                    }elseif ($value['terminal'] =='Masjid Internasional T3') {
                        $update=['id_lokasi'     => 3];
                    }elseif ($value['terminal'] =='AOCC') {
                        $update=['id_lokasi'     => 49];
                    }elseif ($value['terminal'] ==' Terminal 3') {
                        $update=['id_lokasi'     => 3];
                    }elseif ($value['terminal'] ==' Terminal 2') {
                        $update=['id_lokasi'     => 2];
                    }elseif ($value['terminal'] ==' Terminal 1') {
                        $update=['id_lokasi'     => 1];
                    }elseif ($value['terminal'] =='APRON TERMINAL 2') {
                        $update=['id_lokasi'     => 2];
                    }elseif ($value['terminal'] =='APRON TERMINAL 1') {
                        $update=['id_lokasi'     => 2];
                    }elseif ($value['terminal'] =='Parking Inter') {
                        $update=['id_lokasi'     => 3];
                    }elseif ($value['terminal'] =='DKT') {
                        $update=['id_lokasi'     => 4];
                    }elseif ($value['terminal'] =='Cargo') {
                        $update=['id_lokasi'     => 4];
                    }elseif ($value['terminal'] =='Shelter Kalayang') {
                        $update=['id_lokasi'     => 4];
                    }elseif ($value['terminal'] =='MPS') {
                        $update=['id_lokasi'     => 4];
                    }elseif ($value['terminal'] =='Gedung 600') {
                        $update=['id_lokasi'     => 4];
                    }elseif ($value['terminal'] =='TOD') {
                        $update=['id_lokasi'     => 4];
                    }elseif ($value['terminal'] =='MPS 1') {
                        $update=['id_lokasi'     => 4];
                    }
                    else{
                        $update=['id_lokasi'     => 0];
                    }
                    
                   $this->Mod->update2('fasilitas',array('id_fasilitas  ' =>$value['id_fasilitas']),$update);
                    
                  
                }
                
                    
                
            }
            // echo "<pre>", print_r($fasilitas), "</pre>";
        }

        function DellFasilitas(){
            $fasilitas = $this->m_data->getWhere('fasilitas',array( 'id_unit'=>'3'))->result_array();

            foreach ($fasilitas as $key => $value) {
                $this->Mod->delete('fasilitas', array('id_fasilitas' => $value['id_fasilitas']));
                $this->Mod->delete('fasilitas_detail', array('id_fasilitas' => $value['id_fasilitas']));
              
            }
        }

        function AddDetailPerangkat(){
            $fasilitas = $this->Mod->GetCustome(" SELECT * FROM fasilitas WHERE id_unit = '3' ")->result_array(); 
            //  $this->m_data->getWhere('fasilitas',array('id_unit' =>3))->result_array();
            $perangkat = $this->Mod->GetCustome("SELECT * FROM perangkat WHERE id_jenisperangkat IN ('3','4' )")->result_array(); 
            
           
            foreach ($fasilitas as $key => $value) {

                foreach ($perangkat as $key2 => $value2) {
                    $insert =[
                        'id_fasilitas'          => $value['id_fasilitas'],
                        'id_perangkat'          => $value2['id_perangkat'],
                        'id_jenisperangkat'     => $value2['id_jenisperangkat'],
                        'status'                => '1'
                    ];
                   
                   $cek =  $this->m_data->getWhere('fasilitas_detail',array('id_fasilitas' =>$value['id_fasilitas'], 'id_jenisperangkat'=>$value2['id_jenisperangkat'],'id_perangkat' =>$value2['id_perangkat'] ))->row_array();
                   if (!empty($cek)) {
                    echo "DATa sudah ada";
                 
                   }else{
                    echo "<pre>", print_r($cek), "</pre>";
                    $this->db->insert('fasilitas_detail',$insert);
                   }
                    // $this->db->insert('fasilitas_detail',$insert);
                }
                # code...
            }
           
            // echo "<pre>", print_r($perangkat), "</pre>";
        }

        function  AddOderFasilias(){
            $fasilitas = $this->m_data->getWhere('fasilitas',array('status !=' =>8, 'id_unit'=> sess()['unit']))->result_array();

            foreach ($fasilitas as $key => $value) {

                $listrik =[

                ];
                # code...
            }

        }
    }