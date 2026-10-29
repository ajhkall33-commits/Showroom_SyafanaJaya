<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Perangkat extends CI_Controller {

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
        // $perangkat  = $this->m_data->getWhere('perangkat ',array('status !=' => 8 ))->result_array();
        
        // foreach ($perangkat as $key => $value) {
        //     $detail = $this->m_data->getWhere('perangkat_detail ',array('id_perangkat' =>$value['id_perangkat'] ))->result_array();
            
        //   if (!empty($detail)) {
        //     foreach ($detail as $key2 => $value2) {
        //         $property = $this->m_data->getWhere('master_perangkat_detail ',array('idmaster_detail_perangkat' =>$value2['idmaster_detail_perangkat'] ))->row_array();
                
        //         $perangkat[$key][$property['nama']] = $value2['nama'];

        //         echo "<pre>",print_r ($perangkat),"</pre>";
        //     }
           
        //   }
            
        // }
        // echo "<pre>",print_r (  $perangkat),"</pre>";
        
        
        // foreach ($perangkat as $key => $value) {
        //     $perangkat = $this->m_data->getWhere('fasilitas_detail ',array('id_perangkat' =>$value['id_perangkat'] ))->result_array();
        //     if (empty($perangkat) && $value['status'] == 1) {
        //         $statusPerangkat = [
        //             'status'        =>'0'
        //         ];
        //         $update = $this->Mod->update2('perangkat',array('id_perangkat  ' =>$value['id_perangkat']),$statusPerangkat);
        //         echo "<pre>",print_r ( $value),"</pre>";
        //     }
        //     // echo "<pre>",print_r ( $perangkat),"</pre>";
        // }

        $this->load->view('template_v2', $data);
        //  echo "<pre>",print_r ( $data),"</pre>";
    }

    
    function LoadData($from=null){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
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
            'table'         => 'perangkat' ,
            'pk'            => 'id_perangkat' ,
            'parameter'     => array('status !=' => 8, 'id_perangkat >=' => 0,'id_unit' => sess()['unit']) ,
            'url'           => $this->uri->segment(2) ,
            'from'          => $from ,
            'limit'         => $limit ,
            
            'src'           => $src,
            'param_src'     => [
                                'like' => 'nama_perangkat',
                                'or_like'=> 'serial_number']
        ];
      
      
        $data['url']        = $this->uri->segment(2);
        $totalData          = CountDataPag($param);
  
        $param['total_data'] = $totalData;
        $param['total_page'] = ceil($totalData/$limit);
        $res                = pagin($param);
        foreach ($res['data'] as $key => $value) {
            $jenis      = $this->m_data->getWhere('jenis_perangkat ',array('id_jenisperangkat' =>$value['id_jenisperangkat'],'status !=' => 8 ))->row_array();
            $fasilitas  = $this->m_data->getWhere('fasilitas_detail',array('id_jenisperangkat' =>$value['id_jenisperangkat'],'id_perangkat' =>$value['id_perangkat']  ))->row_array();
            $merk      = $this->m_data->getWhere('merk ',array('id' =>$value['merk_id'] ))->row_array();
			$model      = $this->m_data->getWhere('model ',array('id_perangkat' =>$value['id_model'] ))->row_array();
            $res['data'][$key]['model'] = $model['nama_perangkat'];
            $res['data'][$key]['merk'] = $merk['nama'];
			$res['data'][$key]['jenis_perangkat'] = $jenis['nama'];
            $res['data'][$key]['stat'] = stat_prangkat($value['status']);
            if (!empty($fasilitas)) {
                $res['data'][$key]['id_fasilitas'] = $fasilitas['id_fasilitas'];
            }else{
                $res['data'][$key]['id_fasilitas'] ='';
            }
            
            
            
        }
        $data['perangkat']  = $res['data'];
        $data['pag']        = $res['pag'];

        
        //  $data_res['perangkat'] = $this->Mod->GetCustome('SELECT a.*,b.nama as jenis_perangkat FROM perangkat a left join jenis_perangkat b on b.id_jenisperangkat = a.id_jenisperangkat where a.status != 8')->result_array();
       
        echo json_encode($data);
    }

    function LoadDataDetail($id=null){
        
        $data_res['detail'] = $this->Mod->GetCustome('SELECT a.*,b.nama as property FROM perangkat_detail a left JOIN master_perangkat_detail b on b.idmaster_detail_perangkat = a.idmaster_detail_perangkat Where  a.id_perangkat = \''.$id.'\'')->result_array();
        echo json_encode($data_res);
    }

    function LoadDataByid($id){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
        $data_res['perangkat'] = $this->Mod->GetCustome("
        SELECT 
            p.id_perangkat,
            p.nama_perangkat,
            u.kode_unit,
            f.ip_address,
            p.serial_number,
            f.status,
            l.create_date,
            m.nama AS merk_nama
        FROM 
            perangkat p
        LEFT JOIN 
            unit u ON p.id_unit = u.id_unit 
        LEFT JOIN 
            fasilitas f ON f.id_fasilitas = p.nama_perangkat 
        LEFT JOIN 
            logbook l ON l.id_perangkat = p.id_perangkat
        LEFT JOIN
            merk m ON m.id = p.merk_id
        WHERE
            p.id_perangkat = $id ")->result_array();
        // $data_res['detail'] = $this->m_data->getWhere('perangkat_detail',array('id_perangkat' =>$id ))->result_array();
        echo json_encode($data_res);
    }

    function ViewDetail($id = null){
        if (!empty($id)) {
         $perangkat  = $this->m_data->getWhere('perangkat ',array('status !=' => 8,'id_perangkat' => $id ))->row_array();
         $merk      = $this->m_data->getWhere('merk ',array('id' =>$perangkat['merk_id'] ))->row_array();
		 $model      = $this->m_data->getWhere('model ',array('id_perangkat' =>$perangkat['id_model'] ))->row_array();
		 
         (!empty($merk) ? $perangkat['model'] = $model['nama_perangkat'] : '');
         (!empty($merk) ? $perangkat['merk'] = $merk['nama'] : '');

            $detail = $this->m_data->getWhere('perangkat_detail ',array('id_perangkat' =>$perangkat['id_perangkat'] ))->result_array();
        
            if (!empty($detail)) {
                    foreach ($detail as $key => $value2) {
                        $property = $this->m_data->getWhere('master_perangkat_detail ',array('idmaster_detail_perangkat' =>$value2['idmaster_detail_perangkat'] ))->row_array();
                        
                        // $detail[$key][$property['nama']] = $value2['nama'];
                        $perangkat['detail'][$key]['property']   = $property['nama'];
                        $perangkat['detail'][$key]['value']      = $value2['nama'];
                       
                    }
                    // $perangkat['detail'] = $detail;
                 
            }else{
                $perangkat['detail']=array();
            }
            // echo "<pre>",print_r ($perangkat),"</pre>";
               
            
        }
        echo json_encode($perangkat);
    }

    function EditData($id = null){
        if (!empty($id)) {
         $perangkat  = $this->m_data->getWhere('perangkat ',array('status !=' => 8,'id_perangkat' => $id ))->row_array();
         $merk      = $this->m_data->getWhere('merk ',array('id' =>$perangkat['merk_id'] ))->row_array();
         (!empty($merk) ? $perangkat['merk'] = $merk['nama'] : '');
            $detail = $this->m_data->getWhere('perangkat_detail ',array('id_perangkat' =>$perangkat['id_perangkat'] ))->result_array();
                
            if (!empty($detail)) {
                    foreach ($detail as $key => $value2) {
                        $property = $this->m_data->getWhere('master_perangkat_detail ',array('idmaster_detail_perangkat' =>$value2['idmaster_detail_perangkat'] ))->row_array();
                        
                        // $detail[$key][$property['nama']] = $value2['nama'];
                        $perangkat['detail'][$key]['id_perangkat_detail'] = $value2['id_perangkat_detail'];
                        $perangkat['detail'][$key]['idmaster_detail_perangkat'] = $value2['idmaster_detail_perangkat'];
                        $perangkat['detail'][$key]['property']   = $property['nama'];
                        $perangkat['detail'][$key]['value']      = $value2['nama'];
                       
                    }
                    // $perangkat['detail'] = $detail;
                 
            }else{
                $perangkat['detail']=array();
            }
            // echo "<pre>",print_r ($perangkat),"</pre>";
               
            
        }
        echo json_encode($perangkat);
    }
   


    function LoadDataAnl($id=null){
        $perangkat                      =  $this->Mod->GetCustome("SELECT a.*,c.nama_fasilitas,d.nama as jenis_perangkat,e.nama as merk from perangkat a LEFT join fasilitas_detail b on b.id_perangkat = a.id_perangkat left join fasilitas c on c.id_fasilitas = b.id_fasilitas LEFT JOIN jenis_perangkat d on d.id_jenisperangkat= a.id_jenisperangkat LEFT JOIN merk e on e.id = a.merk_id where a.id_perangkat = '".$id."'")->row_array();
        $perangkat_detail               = $this->Mod->GetCustome("SELECT a.*,b.nama as property_name FROM perangkat_detail a left join master_perangkat_detail b on b.idmaster_detail_perangkat = a.idmaster_detail_perangkat WHERE id_perangkat ='".$perangkat['id_perangkat']."' ")->result_array();
        $perangkat['detail']            =  $perangkat_detail;
       

        // if (!empty($perangkat['nama_perangkat'])) {
        //     $lokasi                          =  $this->m_data->getWhere('terminal',array('id' => $perangkat['id_perangkat']))->row_array();
        //     $perangkat['nama_perangkat']        =  (!empty($perangkat['nama_perangkat']) ? $perangkat['nama_perangkat']: '');
        // }else{
        //     $perangkat['nama_perangkat']        =  (!empty($lokasi['nama_perangkat']) ? $lokasi['nama_perangkat']: '');
        // }
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

         $downtime = $this->Mod->GetCustome("SELECT SUM(TIMESTAMPDIFF(MINUTE, create_date, end_date)) AS total_downTime FROM logbook WHERE id_perangkat = '".$id."' AND end_date >= NOW() - INTERVAL 1 MONTH AND create_date >= NOW() - INTERVAL 1 MONTH")->row_array();
         $uptime = $this->Mod->GetCustome("SELECT TIMESTAMPDIFF(MINUTE, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH)) AS uptime")->row_array();
         
         if(empty($downtime['total_downTime'])){
            $downtime['total_downTime'] = 0;
        }

         $totaldowntime = $downtime['total_downTime'];
         $totaluptime = $uptime['uptime'];
         $performa = ($totaluptime - $totaldowntime) / $totaluptime * 100;

         $performa_formatted = number_format(round($performa)); // Format nilai bulat ke 2 angka desimal dan tambahkan '%' di akhir
         $result['perfomChart'] = array('Performa' => round($performa)); // Bulatkan ke 2 angka desimal
         $result['perfomChart'] = array('Performa' => $performa_formatted); // Simpan nilai yang sudah diformat

        //  $JP = $perangkat['id_jenisperangkat'];
        //  $list_JM = $this->Mod->GetCustome("SELECT nama_masalah FROM jenis_masalah WHERE parent_id = $JP OR parent_id = '3' OR parent_id = '4'")->result_array();
        //  $get_jumlah = $this->Mod->GetCustome("SELECT COUNT(id_jenismasalah) AS jumlah FROM logbook WHERE id_perangkat = $id GROUP BY id_jenismasalah")->result_array();
         
        $result['perfomPie'] =array('Display OFF' => 30,'HDMI' => 10, 'Kamera Rusak' =>0, 'Listrik OFF' =>20, 'Jaringan Bermasalah' =>20);

        //$result['perfomPie'] =array($list_JM);
      
        $result['perangkat']=  $perangkat;
        echo json_encode($result);
        //echo json_encode($get_jumlah);
    }

    function Loadmasterdetail($id){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
      
        $data = $this->m_data->getWhere('master_perangkat_detail',array('id_jenisperangkat' =>$id,'status !=' => 8 ))->result_array();
        echo json_encode($data);
    }

   
   

    function SaveData(){
        $data=array_filter($_POST);
        if (!empty($data)) {
            unset($data['master']);
            $data['status'] = 0;
            $data['id_unit'] =sess()['unit'];
            $this->db->insert('perangkat',$data);
            $idperangkat = $this->db->insert_id();
            if (!empty($_POST['master'])) {
				
				foreach ($_POST['master'] as $key => $value) {
                 
					$detail=[
						'idmaster_detail_perangkat'     => $value['idmaster_detail_perangkat'],
						'id_perangkat' 		            => $idperangkat,
						'nama'	                        => $value['nilai'], 
						'status' 			            => 1,
					];
                    $this->db->insert('perangkat_detail',$detail);
				}	
				
			}
           
        }
    }

    function UpdateData($id=null){
        $data=array_filter($_POST);
        if (!empty($data)) {
            unset($data['master']);
            unset($data['edit']);
            $data['status'] = 0;
            $data['id_unit'] =sess()['unit'];
            if (!empty($_POST['master'])) {
                $id_delete=array();
				foreach ($_POST['master'] as $key => $value) {
					$detail=[
						'idmaster_detail_perangkat'     => $value['idmaster_detail_perangkat'],
                        'id_perangkat' 		            => $id,
						'nama'	                        => $value['nilai'], 
						'status' 			            => 1,
					];
                    $cek_detail = $this->m_data->getWhere('perangkat_detail',array('idmaster_detail_perangkat' =>$value['idmaster_detail_perangkat'],'id_perangkat' => $id ))->row_array();
                    if (!empty($cek_detail)) {
                        echo "Update  old";
                        $update = $this->Mod->update2('perangkat_detail',array('id_perangkat_detail' => $cek_detail['id_perangkat_detail']),$detail);
                    }else{
                        $id_delete[]=$value['idmaster_detail_perangkat'];
                        // 
                        $this->db->insert('perangkat_detail',$detail);
                        
                    }
                    
				}	
                if (!empty($id_delete)) {
                    
                    $result = $this->Mod->deletein('perangkat_detail', array('id_perangkat' => $id), 'idmaster_detail_perangkat',$id_delete);
                }
               
               
			}
            if (!empty($_POST['edit'])) {
				foreach ($_POST['edit'] as $key => $value) {
                    echo "Update";
					$detail=[
						'idmaster_detail_perangkat'     => $value['idmaster_detail_perangkat'],
						'nama'	                        => $value['nilai'], 
						'status' 			            => 1,
					];
                    $update = $this->Mod->update2('perangkat_detail',array('id_perangkat_detail' =>$value['id_perangkat_detail']),$detail);
				}	
			}

            

           
            $update = $this->Mod->update2('perangkat',array('id_perangkat ' =>$id),$data);
        }
    }

  

    function performPerangkat($id=null){
        if (!empty($id)) {
            $data["plugin"][] = "plugin/datatable";
            $data["plugin"][] = "plugin/select2";
            $data["title"] = "Performansi Perangkat";
            $data["title_des"] = " Spesifikasi & Performansi Perangkat";
            $data["content"] = "v_performa";
            // $limit = 10;
            // $from = $this->uri->segment(3);
           
            // $data['pagin'] = pagin('perangkat','id_perangkat',array('status !=' => 8),$this->uri->segment(1),$limit,$from);
            $data["data"] = $data;
            $data["id"]     = $id;
    
            $this->load->view('template_v2', $data);
        }
    }

    function Validate(){
        $perangkat = $this->m_data->getWhere('perangkat',array('status !=' =>8,'type' =>1  ))->result_array();   
        foreach ($perangkat as $key => $value) {
            $detail = $this->m_data->getWhere('perangkat_detail',array('id_perangkat' =>$value['id_perangkat'] ))->row_array();   
            $detail_perangkat=array();
            if (empty($detail)) {
                $mp= $this->m_data->getWhere('master_perangkat_detail',array('id_jenisperangkat' =>$value['id_jenisperangkat'] ))->result_array();   
                foreach ($mp as $key2 => $val2) {
                    $detail_perangkat[]=[
                        'id_perangkat'                  => $value['id_perangkat'] ,
                        'idmaster_detail_perangkat'     => $val2['idmaster_detail_perangkat'],
                        'status'                        => 0,
                    ];
                }
            }
            if (!empty($detail_perangkat)) {
                $this->db->insert_batch('perangkat_detail', $detail_perangkat);
                echo "<pre>", print_r($value['nama_perangkat']), "</pre>";
                echo "<pre>", print_r($detail_perangkat), "</pre>";
            }else{
                echo "<pre>", print_r($value['nama_perangkat']), "</pre>";
                echo "<pre>", print_r("Detail ADA"), "</pre>";
            }
          
           
        }    
        
    }
}