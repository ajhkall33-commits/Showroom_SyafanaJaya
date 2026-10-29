<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Fasilitas extends CI_Controller {

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
            'parameter'     => array('status !=' => 8) ,
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
        $data = $this->Mod->GetCustome("SELECT a.id,a.nama_terminal, COUNT(b.id_lokasi) as total FROM terminal a left join fasilitas b on b.id_lokasi = a.id where a.parent_id = '-1' group by a.id,a.nama_terminal")->result_array();
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


        $fasilitas                           = $this->m_data->getWhere('fasilitas',array('id_fasilitas' => $id))->row_array();
        if (!empty($fasilitas['id_lokasi'])) {
            $lokasi                          =  $this->m_data->getWhere('terminal',array('id' => $fasilitas['id_lokasi']))->row_array();
            $fasilitas['nama_lokasi']        =  (!empty($lokasi['nama_terminal']) ? $lokasi['nama_terminal']: '');
        }else{
            $fasilitas['nama_lokasi']        =  (!empty($lokasi['nama_terminal']) ? $lokasi['nama_terminal']: '');
        }
        if (!empty($fasilitas['id_sublokasi'])) {
            $sub_lokasi                      =  $this->m_data->getWhere('terminal',array('id' => $fasilitas['id_sublokasi']))->row_array();
            $fasilitas['nama_sublokasi']     =  (!empty($sub_lokasi['nama_terminal']) ? $sub_lokasi['nama_terminal']: '');
        }else{
            $fasilitas['nama_sublokasi']     =  (!empty($sub_lokasi['nama_terminal']) ? $sub_lokasi['nama_terminal']: '');
        }

       if (!empty($fasilitas['id_unit'])) {
            $unit                      =  $this->m_data->getWhere('unit',array('id_unit' => $fasilitas['id_unit']))->row_array();
            $fasilitas['nama_unit']     =  (!empty($unit['kode_unit']) ? $unit['kode_unit']: '');
        }else{
            $fasilitas['nama_unit']     =  (!empty($unit['kode_unit']) ? $unit['kode_unit']: '');
        }
       
       $todayDate = date('Y-m-d');
       $logHistory = $this->Mod->GetCustome("SELECT a.*, b.nama AS nama_JP, c.nama_masalah FROM logbook a LEFT JOIN jenis_perangkat b ON a.id_jenisperangkat = b.id_jenisperangkat
                            LEFT JOIN jenis_masalah c ON a.id_jenismasalah = c.id WHERE id_fasilitas = '".$id."' ORDER BY a.id_logbook DESC")->result_array();

                                            // WHERE 
                                            // DATE(tj.date_start) = '$todayDate'
   
       // Menyimpan data log history ke dalam variabel $data
        $result['LogHistory']   = $logHistory;
       // Mengemas semua data ke dalam satu array
         // Hitung performa dan tambahkan ke dalam objek $result
         $downtime              = $this->Mod->GetCustome("SELECT SUM(TIMESTAMPDIFF(MINUTE, date_start, update_date)) AS total_downTime FROM tinjut WHERE id_fasilitas = '".$id."' AND update_date >= NOW() - INTERVAL 1 MONTH AND date_start >= NOW() - INTERVAL 1 MONTH")->row_array();
         //$uptime              = $this->Mod->GetCustome("SELECT (TIMESTAMPDIFF(MINUTE, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH)) * (SELECT COUNT(*) FROM fasilitas)) AS uptime")->row_array();
         $uptime                = $this->Mod->GetCustome("SELECT TIMESTAMPDIFF(MINUTE, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH)) AS uptime")->row_array();

         //echo "<pre>",print_r (  $uptime),"</pre>";

        if(empty($downtime['total_downTime'])){
            $downtime['total_downTime'] = 0;
        }

         $totaldowntime         = $downtime['total_downTime'];
         $totaluptime           = $uptime['uptime'];
         $performa              = ($totaluptime - $totaldowntime) / $totaluptime * 100;

         $performa_formatted    = number_format(round($performa)); // Format nilai bulat ke 2 angka desimal dan tambahkan '%' di akhir
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

        // $tabel['jaringan']                 = $this->Mod->GetCustome("
        //     SELECT 
        //         jp.nama AS nama_jp,
        //         l.create_date,
        //         p.id_perangkat
        //     FROM 
        //         perangkat p
        //     LEFT JOIN
        //         jenis_perangkat jp ON p.id_jenisperangkat = jp.id_jenisperangkat
        //     LEFT JOIN
        //         (
        //             SELECT id_perangkat, MAX(create_date) AS max_create_date
        //             FROM logbook
        //             GROUP BY id_perangkat
        //         ) l_max ON l_max.id_perangkat = p.id_perangkat
        //     LEFT JOIN
        //         logbook l ON l.id_perangkat = p.id_perangkat AND l.create_date = l_max.max_create_date
        //     WHERE 
        //         p.id_perangkat = -1
        //     ORDER BY
        //         l.create_date DESC")->row_array();

        // $tabel['listrik']                 = $this->Mod->GetCustome("
        //     SELECT 
        //         jp.nama AS nama_jp,
        //         l.create_date,
        //         p.id_perangkat
        //     FROM 
        //         perangkat p
        //     LEFT JOIN
        //         jenis_perangkat jp ON p.id_jenisperangkat = jp.id_jenisperangkat
        //     LEFT JOIN
        //         (
        //             SELECT id_perangkat, MAX(create_date) AS max_create_date
        //             FROM logbook
        //             GROUP BY id_perangkat
        //         ) l_max ON l_max.id_perangkat = p.id_perangkat
        //     LEFT JOIN
        //         logbook l ON l.id_perangkat = p.id_perangkat AND l.create_date = l_max.max_create_date
        //     WHERE 
        //         p.id_perangkat = -2
        //     ORDER BY
        //         l.create_date DESC")->row_array();


        // Mengemas data ke dalam array result
        $result['tabel-data']   = $tabel;
        
       

      //mengambil detail fasilitas untuk di cari jenis perangkat
        // $fp                     = $this->Mod->GetCustome("SELECT id_fasilitas, id_jenisperangkat, status FROM fasilitas_detail WHERE id_fasilitas = '".$id."' group by id_fasilitas, id_jenisperangkat, status;")->result_array();
        // $total                  = $this->m_data->getWhere('logbook',array('id_fasilitas' =>$id ))->num_rows();
        // $result['perangkat'][]  = $this->Mod->GetCustome("SELECT a.*,b.nama as jenis_perangkat FROM perangkat a left join jenis_perangkat b on b.id_jenisperangkat = a.id_jenisperangkat left join fasilitas_detail c on c.id_jenisperangkat = b.id_jenisperangkat where a.status != 8 and c.id_fasilitas = '".$id."' ")->result_array();
        
       
        // foreach ( $fp  as $key => $value) {
        //     $jf = $this->m_data->getWhere('jenis_perangkat',array('id_jenisperangkat' => $value['id_jenisperangkat']))->row_array();
        //     $totalData=$this->Mod->GetCustome("SELECT COUNT(id_jenisperangkat) AS total FROM logbook WHERE id_fasilitas = '".$value['id_fasilitas']."' AND id_jenisperangkat = '".$value['id_jenisperangkat']."' AND create_date >= NOW() - INTERVAL 1 MONTH")->row_array();
        //     $persen = ($total != 0 ? round(($totalData['total'] / max(1, $total)) * 100) : 0);
            

        //      $result['ProgressData'][] =[
        //         'name' =>  $jf['nama'],
        //         'value' =>   $persen ,
        //         'class'     => log_status($persen),
        //         'totaldata' => $total,
        //         'totaljenis' => $totalData['total']
        //      ];

        // }

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
       
         $data= $this->Mod->getData('jenis_perangkat')->result_array();
       
        echo json_encode($data);
    }

    function LoadDataPerangkat($id){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
       
         $data= $this->m_data->getWhere('perangkat',array('status' =>0,'id_unit' => sess()['unit'],'id_jenisperangkat' => $id,'status' => 0))->result_array();
       
        echo json_encode($data);
    }
    function LoadDataPerangkatByID($id){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];

       $data = $this->Mod->GetCustome("SELECT * FROM fasilitas_detail WHERE id_fasilitas = $id")->result_array();
      
         //$data= $this->m_data->getWhere('fasilitas_detail',array('id_fasilitas' =>$id))->result_array();
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $detail=  $this->m_data->getWhere('perangkat',array('id_perangkat' => $value['id_perangkat']))->row_array();
               
                $data[$key]['detail'] = $detail;
            }
        }
        
        // $data['listrik'] = $this->m_data->getWhere('perangkat',array('id_perangkat' =>-2))->row_array();
        // $data['jaringan'] = $this->m_data->getWhere('perangkat',array('id_perangkat' =>-1))->row_array();
        
        // $data['listrik'] = $this->m_data->getWhere('perangkat',array('id_perangkat' =>-2))->row_array();
        // $data['jaringan'] = $this->m_data->getWhere('perangkat',array('id_perangkat' =>-1))->row_array();
       
        echo json_encode($data);
    }
    
    function LoadDataPerangkatJenis($id){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];

       $fasilitas= $this->Mod->GetCustome("SELECT * FROM fasilitas_detail WHERE id_fasilitas = $id")->result_array();
      
         //$data= $this->m_data->getWhere('fasilitas_detail',array('id_fasilitas' =>$id))->result_array();
        
        $data=array();
        if (!empty($fasilitas)) {
            foreach ($fasilitas as $key => $value) {
                $perangkat  =  $this->m_data->getWhere('perangkat',array('id_perangkat' => $value['id_perangkat']))->row_array();
                $jenis      = $this->m_data->getWhere('jenis_perangkat',array('id_jenisperangkat' =>  $perangkat['id_jenisperangkat']))->row_array();
                $data[]=[
                    'id_jenisperangkat'     =>  $jenis['id_jenisperangkat'],
                    'jenis_perangkat'       => $jenis['nama'],
                ];
              
            }
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
    function ViewDetail($id=null){
        if (!empty($id)) {
            $data           = $this->Mod->GetCustome("SELECT a.*,b.kode_unit as unit,c.nama_terminal as lokasi,d.nama_terminal as sub_lokasi FROM fasilitas a left join unit b on b.id_unit =a.id_unit left join terminal c on c.id=a.id_lokasi left join terminal d on d.id=a.id_sublokasi where a.id_fasilitas = '".$id."'")->row_array();
            $detail         = $this->Mod->GetCustome("SELECT a.*,b.nama_perangkat,c.nama as jenis_perangkat FROM fasilitas_detail a left join perangkat b on b.id_perangkat = a.id_perangkat left join jenis_perangkat c on c.id_jenisperangkat = a.id_jenisperangkat where a.id_fasilitas = '".$id."'")->result_array();
            $data['detail'] = $detail ;
            echo json_encode($data);
        }
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
// 
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
            $fasilitas = $this->m_data->getWhere('fasilitas',array('status !=' =>8))->result_array();

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
                    echo "<pre>", print_r($fasilitas), "</pre>";
                    
                }
                // $data=[
                //     'nama_fasilitas'    => $value['nama_perangkat'] ,
                //     'ip_address'        => $value['ip'] ,
                //     'keterangan'        => $value['lokasi'] ,
                //     'id_unit'           => sess()['unit'],
                //     'status'            => 0
                //     ];
               
            }

        
        }
    }