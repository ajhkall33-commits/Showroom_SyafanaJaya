<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder|CI_DB_mysqli_driver $db
 * @property Mod $Mod
 * @property m_data $m_data
 * @property Excel $Excel
 * @property pdfgenerator $pdfgenerator
 */
class ListWO extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Excel');
        $this->load->model("m_data");
        $this->load->library('pdfgenerator');
        $this->role();
    }

    private function role() {
        $url = urlencode(current_url());
        if (session("username") == "") {
            redirect(base_url('login/auth'));
        }
    }

    public function detail($id) {
        $this->load->model('WorkOrderModel');
        $data['work_order'] = $this->WorkOrderModel->getWorkOrderById($id);
        $data['riwayat_tindakan'] = $this->WorkOrderModel->getRiwayatTindakan($id);
        $this->load->view('work_order', $data);
    }

    public function index() {
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Work Order (Job Report)";
        $data["title_des"] = "Work Order (Job Report)";
        $data["content"] = "v_index";

        $data["data"] = $data;
        $data['pelaksana'] = $this->Mod->getWhere('user ',array('status != ' =>8,'type_user IN (1,102,107)' => null, 'unit_kerja'=> sess()['unit']))->result_array();
        $data['pengawas'] = $this->Mod->getWhere('user ',array('status != ' =>8,'type_user'=>'2' , 'unit_kerja'=> sess()['unit']))->result_array();
        $data['koordinator'] = $this->Mod->getWhere('user ',array('status != ' =>8,'type_user'=>'102' , 'unit_kerja'=> sess()['unit']))->result_array();
        $data['pm_type'] = $this->Mod->getWhere('pm_type ',array('status != ' =>8))->result_array();
        $data['jp'] = $this->Mod->getWhere('fasilitas_catagory ',array('status != ' =>8,'id_unit'=> sess()['unit']))->result_array();
        $data['arahan'] = $this->Mod->getWhere('arahan ',array('status != ' =>8,'id_unit'=> sess()['unit']))->result_array();
        $this->load->view('template_v2', $data);

        // Mendapatkan data unit dan menambahkan flag untuk ATC
    // $data2['unit'] = $this->Mod->getWhere('unit',array('status != ' =>8,'id_unit'=> sess()['unit']))->result_array();
    
    // // Menentukan apakah unit ini termasuk ATC (14,15,16,17,28)
    // $unit_id = sess()['unit'];
    // $atc_units = [14, 15, 16, 17];
    // $data2['is_atc'] = in_array($unit_id, $atc_units);
    
    // // Jika ATC, ambil data ATC
    // if($data2['is_atc']) {
    //     // Sesuaikan query ini dengan struktur database Anda
    //     // Ini contoh, Anda perlu menyesuaikan dengan nama tabel dan field yang sebenarnya
    //     $data2['atc'] = $this->Mod->getWhere('atc', array('status != ' => 8, 'id_unit' => $unit_id))->row_array();
    //     // Atau jika ingin mengambil data spesifik:
    //     // $data2['atc'] = $this->Mod->getWhere('atc', array('id_wo' => $no_wo))->row_array();
    // }
    
    // $this->load->view('v_PM41', $data2);
    }


// Tambahkan function di controller listWO
// function LoadData($id = null) {
//     if (isset($_POST['limit'])) {
//         $limit = $_POST['limit'];
//     } else {
//         $limit = 10;
//     }

//     if (isset($_POST['src'])) {
//         $src = $_POST['src'];
//     } else {
//         $src = '';
//     }
    
//     $tanggal = $this->input->post('tanggal');
//     $filter_fasilitas = $this->input->post('filter_fasilitas');
//     $from = $this->uri->segment(3);
//     $unit_id = sess()['unit'];

//     // Build base query dengan filter unit
//     $this->db->from('wo');
//     $this->db->where('status !=', 8);
//     $this->db->where('id_unit', $unit_id); // Filter berdasarkan unit
//     $this->db->where('YEAR(tanggal)', 2025);
    
//     // Apply date filter if exists
//     if (!empty($tanggal)) {
//         $this->db->where('DATE(tanggal)', $tanggal);
//     }
    
//     // Apply search filter if exists - hanya untuk WO di unit ini
//     if (!empty($src)) {
//         $this->db->group_start();
//         $this->db->like('no_wo', $src);
//         // Tidak perlu or_like karena hanya search no_wo
//         $this->db->group_end();
//     }
    
//     // Get total count
//     $totalData = $this->db->count_all_results('', false);
    
//     // Apply limit and offset
//     $this->db->limit($limit, $from);
//     $this->db->order_by('id_wo', 'DESC');
    
//     $query = $this->db->get();
//     $data = $query->result_array();
    
//     // Process each WO
//     foreach ($data as $key => $value) {
//         $data[$key]['status_label'] = sts('4', $value['status']);
//         $data[$key]['tanggal_label'] = Hari_($value['tanggal']) . ' ' . tgl($value['tanggal'], 'sm');

//         $id_wo = $value['id_wo'];
        
//         // Build detail query dengan filter unit
//         $this->db->select('a.*, d.nama_fasilitas, d.terminal, pmt.name_pm, d.id_unit as fasilitas_unit');
//         $this->db->from('wo_detail a');
//         $this->db->join('pm b', 'b.id_pmheader = a.id_pmheader', 'left');
//         $this->db->join('pm_detail c', 'c.id_pmheader = b.id_pmheader', 'left');
//         $this->db->join('fasilitas d', 'd.id_fasilitas = c.id_fasilitas', 'left');
//         $this->db->join('pm_type pmt', 'pmt.idpm_type = b.idpm_type', 'left');
//         $this->db->where('a.id_wo', $id_wo);
//         $this->db->where('d.id_unit', $unit_id); // Filter fasilitas berdasarkan unit
        
//         // Apply fasilitas filter if exists
//         if(!empty($filter_fasilitas)){
//             $this->db->like('d.nama_fasilitas', $filter_fasilitas);
//         }
        
//         $this->db->group_by('a.id_wodetail');
//         $detail_query = $this->db->get();
//         $detail = $detail_query->result_array();

//         $data[$key]['detail'] = $detail;
//         $data[$key]['jumlah'] = count($detail);

//         $nama_fasilitas_list = array_column($detail, 'nama_fasilitas');
//         $terminal_list = array_column($detail, 'terminal');
//         $data[$key]['nama_fasilitas'] = !empty($nama_fasilitas_list) ? implode(', ', $nama_fasilitas_list) : '-';
//         $data[$key]['terminal'] = !empty($terminal_list) ? implode(', ', $terminal_list) : '-';
        
//         $name_pm_list = array_column($detail, 'name_pm');
//         $data[$key]['name_pm'] = !empty($name_pm_list) ? implode(', ', $name_pm_list) : '';
        
//         // If filter fasilitas is applied and no detail found, remove this WO
//         if(!empty($filter_fasilitas) && empty($detail)){
//             unset($data[$key]);
//         }
//     }
    
//     // Re-index array
//     $data = array_values($data);
    
//     // Prepare response
//     $response = [
//         'data' => $data,
//         'pag' => [
//             'start' => $from + 1,
//             'label' => 'Showing ' . (count($data) > 0 ? $from + 1 : 0) . ' to ' . ($from + count($data)) . ' of ' . $totalData . ' entries'
//         ],
//         'selected_tanggal' => $tanggal,
//         'selected_fasilitas' => $filter_fasilitas,
//         'total_data' => $totalData
//     ];

//     echo json_encode($response);
// }
function LoadData($id = null) {
    if (isset($_POST['limit'])) {
        $limit = $_POST['limit'];
    } else {
        $limit = 10;
    }

    if (isset($_POST['src'])) {
        $src = $_POST['src'];
    } else {
        $src = '';
    }

    $tanggal          = $this->input->post('tanggal');
    $filter_fasilitas = $this->input->post('filter_fasilitas');
    $from             = $this->uri->segment(3);
    $unit_id          = sess()['unit'];

    // Build base query dengan join
    $this->db->select('
        wo.id_wo,
        wo.no_wo,
        wo.klasifikasi,
        wo.tanggal,
        wo.team,
        wo.pelaksana,
        wo.pengawas,
        wo.status,
        pm_type.name_pm,
        fasilitas.nama_fasilitas,
        fasilitas.terminal
    ');
    $this->db->from('wo');
    $this->db->join('wo_detail', 'wo_detail.id_wo = wo.id_wo', 'left');
    $this->db->join('pm', 'pm.id_pmheader = wo_detail.id_pmheader', 'left');
    $this->db->join('fasilitas', 'fasilitas.id_fasilitas = pm.id_fasilitas', 'left');
    $this->db->join('pm_type', 'pm_type.idpm_type = pm.idpm_type', 'left');

    $this->db->where('wo.status !=', 8);
    $this->db->where('wo.id_unit', $unit_id);
    $this->db->where('YEAR(wo.tanggal)', 2026);

    // Apply date filter if exists
    if (!empty($tanggal)) {
        $this->db->where('DATE(wo.tanggal)', $tanggal);
    }

    // Apply search filter if exists
    if (!empty($src)) {
        $this->db->group_start();
        $this->db->like('wo.no_wo', $src);
        $this->db->group_end();
    }

    // Filter nama fasilitas
    if (!empty($filter_fasilitas)) {
        $this->db->like('fasilitas.nama_fasilitas', $filter_fasilitas);
    }

    // Hindari duplikat WO
    $this->db->group_by('wo.id_wo');

    // Get total count
    $totalData = $this->db->count_all_results('', false); 

    // Apply limit and offset
    $this->db->limit($limit, $from);
    $this->db->order_by('wo.id_wo', 'DESC');

    $query = $this->db->get();
    $data  = $query->result_array(); 

    // Process each WO
    foreach ($data as $key => $value) {
        $data[$key]['status_label']  = sts('4', $value['status']);
        $data[$key]['tanggal_label'] = Hari_($value['tanggal']) . ' ' . tgl($value['tanggal'], 'sm');
        // name_pm tidak ada di select, jadi dihapus dari JS atau tambahkan join & select kalau memang perlu
    }

    // Re-index array
    $data = array_values($data);

    // Prepare response
    $response = array(
        'data' => $data,
        'pag'  => array(
            'start' => $from + 1,
            'label' => 'Showing ' . (count($data) > 0 ? $from + 1 : 0) . ' to ' . ($from + count($data)) . ' of ' . $totalData . ' entries'
        ),
        'selected_tanggal'   => $tanggal,
        'selected_fasilitas' => $filter_fasilitas,
        'total_data'         => $totalData
    );

    echo json_encode($response); 
}



function searchFasilitas() {
    if (isset($_POST['keyword'])) {
        $keyword = $_POST['keyword'];
        $unit_id = sess()['unit']; // Ambil unit dari session
        
        // Query hanya dari fasilitas di unit yang login
        $this->db->select('DISTINCT(nama_fasilitas)');
        $this->db->from('fasilitas');
        $this->db->where('status !=', 8);
        $this->db->where('id_unit', $unit_id); // Filter berdasarkan unit yang login
        
        // Jika ada keyword, tambahkan like
        if (!empty($keyword)) {
            $this->db->like('nama_fasilitas', $keyword);
        }
        
        $this->db->order_by('nama_fasilitas', 'ASC');
        $this->db->limit(10);
        
        $result = $this->db->get()->result_array();
        
        echo json_encode($result);
    }
}
    function AddData(){
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Add Work Order";
        $data["title_des"] = "Pembuatan Work Order";
        $data["content"] = "FormData";
        $data["data"] = $data;
        $this->load->view('template_v2', $data);
    }

    function SaveData(){
        if (isset($_POST['id_user'])) {
            $pelaksana = implode(",",$_POST['id_user']);
        }else{
            $pelaksana ='';
        }

        if (isset($_POST['id_pengawas'])) {
            $pengawas = implode(",", $_POST['id_pengawas']);
        } else {
            $pengawas = '';
        }

        if (isset($_POST['newdata'])) {
            $no_wo = $this->input->post('no_wo');
            if (!empty($_POST['id_arahan'])) {
                $arahan = $this->Mod->getWhere('arahan', array('id_arahan' => $_POST['id_arahan']))->row_array();
                if ($arahan) {
                    $no_wo = $arahan['nomor'];
                }
            }
            $head = [
                'no_wo' => $no_wo,
                'id_arahan' => $_POST['id_arahan'],
                'tanggal' => $_POST['tanggal'],
                'atc' => $this->input->post('atc'),
                'avsec_masuk' => $this->input->post('avsec_masuk'),
                'avsec_keluar' => $this->input->post('avsec_keluar'),
                'shift' => GetShift()['shift'],
                'pelaksana' => $pelaksana,
                'pengawas' => $pengawas,


                'idpm_type' => $_POST['idpm_type'],
                'id_unit' => sess()['unit'],
                'create_date' => date('Y-m-d'),
                'create_by' => sess()['nama'],
                'status' => 0
            ];
            $savedata = $this->db->insert('wo',$head);
            $id_wo = $this->db->insert_id();
            foreach ($_POST['newdata'] as $key => $value) {
                $data=[
                    'id_wo' => $id_wo ,
                    'id_pmheader' => $value['id_pmheader'],
                    'status' => 0
                ];
                $this->db->insert('wo_detail',$data);
            }
            if ($savedata) {
                $response=[
                    'code' => '200',
                    'msg' => 'Data Berhasi Disimpan'
                ];
            }else{
                $response=[
                    'code' => '500',
                    'msg' => 'Coba lagi beberapa waktu'
                ];
            }
        }else{
            $response=[
                'code' => '500',
                'msg' => 'Tidak Ada Detail untuk Tiket'
            ];
        }
        echo json_encode($response);
    }

    function ProsesData($id=null){
        if (!empty($id)) {
            $data['status'] = 1;
            $cek = $this->Mod->getWhere('wo_detail',array('id_wo' =>$id,'status' => 0 ))->num_rows();
          
           if ($cek == 0) {
                $res=[
                    'code' => '500',
                    'msg' => 'Gagal Proses Data,Tidak Ada Detail Transaksi/Detail Sudah Digunakan'
                ];
           }else{
                $result = $this->Mod->update2('wo',array('id_wo ' =>$id ),$data);
                $this->Mod->update2('wo_detail',array('id_wo ' =>$id ),$data);
                $res =[
                    'code' => 200,
                    'msg' => 'Data Diproses'
                ];

                if ($result) {
                    $result = $this->Mod->update2('wo', array('id_wo' => $id),$data);
                    $result2 = $this->Mod->update2('wo_detail', array('id_wo' => $id,'status' => 0),$data);
                    $cek_detail = $this->Mod->GetCustome("SELECT b.* FROM wo_detail a left join pm b on b.id_pmheader = a.id_pmheader WHERE a.id_wo= '".$id."'")->result_array();
                    foreach ($cek_detail as $key => $value) {
                        $data_cancel =['status' => 8];
                        $result2 = $this->Mod->update2('wo_detail', array('id_wo !=' => $id, 'id_pmheader' => $value['id_pmheader'],'status' => 0),$data_cancel);
                        $data_pm= [ 
                            'status' => '9'
                        ];
                        $this->Mod->update2('pm', array('id_pmheader' => $value['id_pmheader']),$data_pm);
                    }
                
                    if ($result) {
                        $cek_user = $this->Mod->getWhere('user',array('id ' =>sess()['id'] ))->row_array();
                        $save_log_ttd =[
                            'id_user' => sess()['id'],
                            'type_user' => (!empty($cek_user) ? $cek_user['type_user']: ''),
                            'rel_id' => $id,
                            'rel_type' => 'tiket_cm',
                            'create_date' => date('Y-m-d H:i:s')
                        ];
                        $this->db->insert( 'log_ttd',$save_log_ttd);
                        $response=[
                            'code' => '200',
                            'msg' => 'Data Berhasil Di Proses'
                        ];
                    }else{
                        $response=[
                            'code' => '500',
                            'msg' => 'Gagal Proses Data'
                        ];
                    }
                }else{
                    $response=[
                        'code' => '500',
                        'msg' => 'Gagal Proses Data'
                    ];
                }
           }
        }else{
             $res =[
                'code' => 200,
                'msg' => 'Data Yang Diproses Tidak Valid'
            ];
        }
        echo json_encode($res);
    }

    function DeleteData($id=null){
        if (!empty($id)) {
            // 1. Ambil semua id_pmheader dari wo_detail untuk WO ini
            $details = $this->Mod->getWhere('wo_detail', array('id_wo' => $id))->result_array();
            
            if (!empty($details)) {
                $pm_ids = array_column($details, 'id_pmheader');
                
                // 2. Kembalikan status PM menjadi 1 (Aktif kembali)
                $this->db->where_in('id_pmheader', $pm_ids);
                $this->db->update('pm', array('status' => '1'));
            }

            // 3. Soft Delete WO (status 8)
            $data_delete = ['status' => 8];
            $result = $this->Mod->update2('wo', array('id_wo' => $id), $data_delete);
            
            // 4. Soft Delete WO Detail (status 8)
            $this->Mod->update2('wo_detail', array('id_wo' => $id), $data_delete);

            if ($result) {
                $response=[
                    'code' => '200',
                    'msg' => 'Data Berhasil Di Hapus'
                ];
            }else{
                $response=[
                    'code' => '500',
                    'msg' => 'Gagal Hapus Data'
                ];
            }
        }else{
            $response=[
                'code' => '500',
                'msg' => 'ID Tidak Valid'
            ];
        }
        echo json_encode($response);
    }
     function GetDataPM($id=null){
      
        $data = $this->Mod->GetCustome("SELECT
            a.tanggal_pm, a.id_pmheader,a.status,a.id_jadwalpm,b.id_fasilitas,c.nama_fasilitas as fasilitas,c.terminal as lokasi, d.nama_terminal,e.name_pm 
            FROM 
                pm a 
            LEFT JOIN
                pm_detail b 
            ON 
                b.id_pmheader = a.id_pmheader
            LEFT JOIN 
                fasilitas c 
            ON 
                c.id_fasilitas = b.id_fasilitas
            LEFT JOIN 
                terminal d 
            ON 
                d.id = c.id_lokasi
            LEFT JOIN
                pm_type e
            ON 
                a.idpm_type =e.idpm_type
            WHERE 
              YEAR(a.tanggal_pm) = ".date('Y')."
              and 
                a.status NOT IN ('0','8','9')
            AND 
                a.id_unit = ".sess()['unit']."
            AND 
                b.id_fasilitas is NOT NULL
            GROUP by 
                a.tanggal_pm, a.id_pmheader,a.status,a.id_jadwalpm,c.nama_fasilitas,c.id_fasilitas,d.nama_terminal,e.name_pm")->result_array(); 

        // Early return jika tidak ada data
        if (empty($data)) {
            echo json_encode($data);
            return;
        }

        // Kumpulkan semua id_pmheader dalam satu array (bulk)
        $all_pmheader_ids = array_column($data, 'id_pmheader');
        $ids_str = implode(',', array_map('intval', $all_pmheader_ids));

        if (!empty($id)) {
            // 1 query tunggal: ambil semua id_pmheader yang punya data di pm_detail
            $checked_rows = $this->Mod->GetCustome(
                "SELECT DISTINCT id_pmheader FROM pm_detail WHERE id_pmheader IN ($ids_str)"
            )->result_array();
            $checked_ids = array_column($checked_rows, 'id_pmheader');

            foreach ($data as $key => $value) {
                $data[$key]['tanggal_pm'] = Hari_($value['tanggal_pm']) . ' ' . tgl($value['tanggal_pm'], 'sm');
                if (in_array($value['id_pmheader'], $checked_ids)) {
                    $data[$key]['checked'] = 1;
                }
                // nama fasilitas sudah ada dari query utama, tidak perlu query ulang
                $data[$key]['fasilitas'] = $value['fasilitas'];
            }
        } else {
            // 1 query tunggal: ambil id_pmheader yang punya pm_detail dengan status = 1
            $checked_rows = $this->Mod->GetCustome(
                "SELECT DISTINCT id_pmheader FROM pm_detail WHERE status = 1 AND id_pmheader IN ($ids_str)"
            )->result_array();
            $checked_ids = array_column($checked_rows, 'id_pmheader');

            foreach ($data as $key => $value) {
                $data[$key]['tanggal_pm'] = Hari_($value['tanggal_pm']) . ' ' . tgl($value['tanggal_pm'], 'sm');
                if (in_array($value['id_pmheader'], $checked_ids)) {
                    $data[$key]['checked'] = 0;
                } else {
                    // nama fasilitas sudah ada dari query utama, tidak perlu query ulang
                    $data[$key]['fasilitas'] = $value['fasilitas'];
                }
            }
        }
        echo json_encode($data);
    }
    // function GetDataPM($id=null,$catagory=null){
    //     if (!empty($catagory)) {
    //        $id_catagory = " AND c.id_catagory = '$catagory'";
    //     }else{
    //         $id_catagory = '';
    //     }
    //     $data = $this->Mod->GetCustome("SELECT
    //         a.tanggal_pm, a.id_pmheader,a.status,a.id_jadwalpm,b.id_fasilitas,c.nama_fasilitas as fasilitas,d.nama_terminal,e.name_pm 
    //         FROM 
    //             pm a 
    //         LEFT JOIN
    //             pm_detail b 
    //         ON 
    //             b.id_pmheader = a.id_pmheader
    //         LEFT JOIN 
    //             fasilitas c 
    //         ON 
    //             c.id_fasilitas = b.id_fasilitas
    //         LEFT JOIN 
    //             terminal d 
    //         ON 
    //             d.id = c.id_lokasi
    //         LEFT JOIN
    //             pm_type e
    //         ON 
    //             a.idpm_type =e.idpm_type
    //         WHERE 
    //             a.idpm_type = '$id'
    //         $id_catagory 
    //         AND 
    //             a.status NOT IN ('0','8','9')
    //         AND 
    //             a.id_unit = ".sess()['unit']."
    //         AND 
    //             b.id_fasilitas is NOT NULL
    //         GROUP by 
    //             a.tanggal_pm, a.id_pmheader,a.status,a.id_jadwalpm,c.nama_fasilitas,c.id_fasilitas,d.nama_terminal,e.name_pm")->result_array(); 

    //     if (!empty($id)) {
    //         foreach ($data as $key => $value) {
    //             $data[$key]['tanggal_pm'] = Hari_($value['tanggal_pm']) . ' ' . tgl($value['tanggal_pm'], 'sm');
    //             $cek = $this->Mod->getWhere('pm_detail',array('id_pmheader' => $value['id_pmheader']))->num_rows();
    //             if ($cek != 0) {
    //                 $data[$key]['checked'] = 1;
    //             }
    //             $fasilitas = $this->Mod->getWhere('fasilitas',array('id_fasilitas' =>$value['id_fasilitas'] ))->row_array();
    //             $data[$key]['fasilitas'] = $fasilitas['nama_fasilitas'];
    //         }
    //     }else{
    //         foreach ($data as $key => $value) {
    //             $data[$key]['tanggal_pm'] = Hari_($value['tanggal_pm']) . ' ' . tgl($value['tanggal_pm'], 'sm');
    //             $cek = $this->Mod->getWhere('pm_detail',array('id_pmheader' => $value['id_pmheader'],'status' => 1))->num_rows();
    //             if ($cek != 0) {
    //                 $data[$key]['checked'] = 0;
    //             }else{
    //                 $fasilitas = $this->Mod->getWhere('fasilitas',array('id_fasilitas' =>$value['id_fasilitas'] ))->row_array();
    //                 $data[$key]['fasilitas'] = $fasilitas['nama_fasilitas'];
    //             }
    //         }
    //     }
    //     echo json_encode($data);
    // }

    function ViewData($id=null){
        if (!empty($id)) {
            $header = $this->Mod->getWhere('wo', array('id_wo' => $id))->row_array();
            $header['tanggal'] = tgl($header['tanggal'],'l');
            $header['shift_l'] = l_sh($header['shift']);
            
            $lokasi_data = $this->Mod->GetCustome("SELECT 
                f.terminal,
                f.nama_fasilitas,
                f.id_catagory
            FROM 
                wo w
            LEFT JOIN 
                fasilitas f ON f.id_catagory = w.id_catagory
            WHERE 
                w.id_wo = $id")->result_array();
            
            $header['lokasi'] = $lokasi_data;

            $arahan_data = $this->Mod->GetCustome("SELECT 
                a.nomor as nomor_arahan
            FROM 
                arahan a
            LEFT JOIN 
                wo w ON w.id_arahan = a.id_arahan
            WHERE 
                w.id_wo = $id")->row_array();
            
           $header['arahan'] = $arahan_data ? $arahan_data['nomor_arahan'] : '-';


            $detail = $this->Mod->GetCustome("SELECT 
                a.*, 
                d.nama_fasilitas,
                d.terminal, 
                b.id_pmheader,
                b.pengukuran,
                pmt.name_pm,
                b.catatan_perawatan,
                b.tanggal_pm
            FROM 
                wo_detail a 
            LEFT JOIN 
                pm b ON b.id_pmheader = a.id_pmheader
            LEFT JOIN 
                pm_detail c ON c.id_pmheader = b.id_pmheader
            LEFT JOIN 
                fasilitas d ON d.id_fasilitas = c.id_fasilitas
            LEFT JOIN 
                pm_type pmt ON pmt.idpm_type = b.idpm_type
            WHERE 
                a.id_wo = $id
            GROUP BY 
                a.id_wo, a.id_pmheader, a.status, d.nama_fasilitas, b.pengukuran, pmt.name_pm, b.catatan_perawatan, b.tanggal_pm")->result_array();
            
            $header['name_pm'] = implode(', ', array_column($detail, 'name_pm'));
            
            // AMBIL DATA DOCK (GAMBAR PER JOB) SEPERTI DI PRINTDATA
            $pmheader_ids = array();
            foreach ($detail as $value) {
                if(!empty($value['id_pmheader'])) {
                    $pmheader_ids[] = $value['id_pmheader'];
                }
            }
            
            $header['dock'] = array();
            if (!empty($pmheader_ids)) {
                $ids = implode(",", array_map('intval', $pmheader_ids));
                
                $dock_detail = $this->Mod->GetCustome("SELECT 
                    a.id_job, 
                    a.documentasi, 
                    c.nama,
                    d.nama_fasilitas,
                    a.id_pmheader
                FROM 
                    pm_detail a
                LEFT JOIN 
                    job_pm c ON c.id_jobpm = a.id_job
                LEFT JOIN 
                    pm b ON b.id_pmheader = a.id_pmheader
                LEFT JOIN 
                    fasilitas d ON d.id_fasilitas = b.id_fasilitas
                WHERE 
                    a.id_pmheader IN ($ids)
                GROUP BY 
                    a.id_job, 
                    a.documentasi, 
                    c.nama,
                    d.nama_fasilitas,
                    a.id_pmheader
                ORDER BY
                    a.id_job, d.nama_fasilitas")->result_array();
                    
                $raw_dock = array();
                foreach ($dock_detail as $value) {
                    $job_id = $value['id_job'];
                    
                    if (!isset($raw_dock[$job_id])) {
                        $raw_dock[$job_id] = array(
                            'id_job' => $job_id,
                            'nama' => $value['nama'],
                            'files' => array()
                        );
                    }

                    $isDuplicate = false;
                    foreach ($raw_dock[$job_id]['files'] as $file) {
                        if ($file['documentasi'] === $value['documentasi']) {
                            $isDuplicate = true;
                            break;
                        }
                    }

                    if (!$isDuplicate && !empty($value['documentasi'])) {
                        $raw_dock[$job_id]['files'][] = array(
                            'documentasi' => $value['documentasi'],
                            'nama_fasilitas' => $value['nama_fasilitas'],
                            'id_pmheader' => $value['id_pmheader']
                        );
                    }
                }
                
                // Ubah menjadi index array numerik agar mudah diakses di frontend
                $header['dock'] = array_values($raw_dock);
            }
            
            foreach ($detail as $key => $value) {
                $dock = $this->Mod->GetCustome("SELECT 
                    a.id_job, a.documentasi, b.nama
                FROM 
                    pm_detail a
                LEFT JOIN 
                    job_pm b ON b.id_jobpm = a.id_job
                WHERE 
                    a.id_pmheader = '$value[id_pmheader]'
                GROUP BY 
                    a.id_job, a.documentasi, b.nama")->result_array();
                $detail[$key]['documentasi'] = $dock;
                $detail[$key]['jum'] = count($dock);
                
                // TAMBAHAN UNTUK GAMBAR PENGUKURAN
                $gambar_pengukuran = $this->Mod->getWhere('gambar_pengukuran', array(
                    'id_pm' => $value['id_pmheader'],
                    'status' => 1
                ))->result_array();
                $detail[$key]['gambar_pengukuran'] = $gambar_pengukuran;

                // TAMBAHKAN KODE BARU DI SINI - AMBIL DOKUMENTASI GAMBAR PERAWATAN UNTUK SETIAP PM
                $dokumentasi_gambar_perawatan = $this->Mod->GetCustome("SELECT 
                    dgp.nama_dokumentasi_gambar_perawatan	
                FROM dokumentasi_gambar_perawatan dgp
                WHERE dgp.id_pm = '".$value['id_pmheader']."'")->result_array();
                
                $detail[$key]['dokumentasi_gambar_perawatan'] = $dokumentasi_gambar_perawatan;

                // TAMBAHAN: Fetch Perangkat per item PM
                $perangkat = $this->Mod->GetCustome("SELECT p.nama_perangkat 
                                                    FROM pm_khusus pk 
                                                    JOIN perangkat p ON p.id_perangkat = pk.id_perangkat 
                                                    WHERE pk.id_pm = '".$value['id_pmheader']."'")->result_array();
                $detail[$key]['perangkat'] = implode(', ', array_column($perangkat, 'nama_perangkat'));
            }
            
            $header['detail'] = $detail;
            $header['pengukuran'] = implode(', ', array_column($detail, 'pengukuran'));
            $header['catatan_perawatan'] = implode(', ', array_column($detail, 'catatan_perawatan'));
            $header['tanggal_pm'] = implode(', ', array_column($detail, 'tanggal_pm'));
            $header['kode_pm'] = implode(', ', array_column($detail, 'kode'));
            
            // TAMBAHAN: Ekstrak Peralatan, Perangkat, dan Lokasi string gabungan
            $header['peralatan'] = implode(' | ', array_unique(array_filter(array_column($detail, 'nama_fasilitas'))));
            $header['lokasi'] = implode(' | ', array_unique(array_filter(array_column($detail, 'terminal'))));
            $header['perangkat'] = implode(' | ', array_unique(array_filter(array_column($detail, 'perangkat'))));
            
            $data = [
                'code' => '200',
                'msg' => 'Load Data Success',
                'data' => $header
            ];
        } else {
            $data = [
                'code' => '404',
                'msg' => 'No Data Parameter',
                'data' => []
            ];
        }
        
        echo json_encode($data);
}

    function PrintData($id=null){
        try {
            
            // Cek folder upload
            $upload_path = FCPATH . 'upload/pm/';
            if (!is_dir($upload_path)) {
                if (!mkdir($upload_path, 0755, true)) {
                    throw new Exception('Gagal membuat folder upload');
                }
            }
            
            if (!is_writable($upload_path)) {
                throw new Exception('Folder upload tidak writable');
            }
            
            $data["data"] = [];
            $data = $this->Mod->getWhere('wo',array('id_wo ' =>$id))->row_array();
            
            if (empty($data)) {
                throw new Exception('Data WO tidak ditemukan');
            }
            // TAMBAHKAN KODE INI DI SINI - AMBIL NOMOR ARAHAN
        $arahan_data = $this->Mod->GetCustome("SELECT 
            a.deskripsi 
        FROM 
            arahan a
        LEFT JOIN 
            wo w ON w.id_arahan = a.id_arahan
        WHERE 
            w.id_wo = $id")->row_array();
        
        // Simpan nomor arahan ke dalam array $data
        $data['deskripsi'] = $arahan_data ? $arahan_data['deskripsi'] : '-';
        // AKHIR TAMBAHAN KODE

            if (!empty($data['tanggal'])) {
                $data['waktu_tampil'] = waktu($data['tanggal']);
                
                $dateParts = explode("-", substr($data['tanggal'], 0, 10));
                if (count($dateParts) == 3) {
                    $tahun = $dateParts[0];
                    $bulan = $dateParts[1];
                    $tanggal = $dateParts[2];
                    
                    $timestamp = strtotime($data['tanggal']);
                    $namaHari = date('N', $timestamp);
                    
                    $namaHariIndonesia = array(
                        1 => 'Senin',
                        2 => 'Selasa',
                        3 => 'Rabu',
                        4 => 'Kamis',
                        5 => 'Jumat',
                        6 => 'Sabtu',
                        7 => 'Minggu'
                    );
                    
                    $data['tahunsplit'] = $tahun;
                    $data['bulansplit'] = $bulan;
                    $data['tanggalsplit'] = $tanggal;
                    $data['harisplit'] = $namaHariIndonesia[$namaHari];
                }
            }
            
            $query = $this->Mod->GetCustome("SELECT 
                SUBSTRING_INDEX(pelaksana, ',', 1) AS nama_pelaksana_utama
                FROM wo
                WHERE id_wo = '$id'  
            ");
            
            $result = $query->row_array();
            $data['nama_pelaksana_yang_ttd'] = $result['nama_pelaksana_utama'] ?? '-';
            $data['tanggal'] = tgl($data['tanggal'],'l');
            $data['shift_l'] = l_sh($data['shift']);
            
            $data['job'] = $this->Mod->GetCustome("SELECT 
                c.nama as nama_job, 
                b.documentasi,
                f.nama_fasilitas as peralatan
                FROM 
                wo_detail a 
                LEFT JOIN pm_detail b ON b.id_pmheader = a.id_pmheader 
                LEFT JOIN job_pm c ON c.id_jobpm = b.id_job 
                LEFT JOIN pm d ON d.id_pmheader = b.id_pmheader
                LEFT JOIN fasilitas f ON f.id_fasilitas = d.id_fasilitas
                WHERE a.id_wo = '".$id."'

                /* Hanya unit 14,15,16,17: tampilkan pekerjaan yang ada dokumentasi fotonya saja.
                   Selain unit tersebut: semua ceklist muncul walaupun tidak ada dokumentasi. */
                AND (
                    (d.id_unit IN (14,15,16,17) AND b.documentasi IS NOT NULL AND b.documentasi != '')
                    OR
                    (d.id_unit NOT IN (14,15,16,17))
                )
                
                GROUP BY 
                c.nama, 
                b.documentasi,
                f.nama_fasilitas
                Order By 
                f.nama_fasilitas ASC")->result_array();
            
            $data['c_detail'] = count($data['job']);
            $data['fasilitas'] = $this->Mod->GetCustome("SELECT 
                c.terminal as lokasi,b.id_fasilitas,c.nama_fasilitas,f.nama_perangkat as type,b.catatan_perawatan,b.pengukuran,b.id_pmheader
            FROM 
                wo_detail a 
            LEFT JOIN 
                pm b 
            ON 
                b.id_pmheader = a.id_pmheader 
            LEFT JOIN 
                fasilitas c on c.id_fasilitas = b.id_fasilitas
            LEFT JOIN
                fasilitas_detail d 
            ON  
                d.id_fasilitas = c.id_fasilitas
            LEFT JOIN
                perangkat e
            ON 
                e.id_perangkat = d.id_perangkat
            LEFT JOIN
                model f
            ON 
                f.id_perangkat = e.id_model
            WHERE   
                a.id_wo = '$id' 
            GROUP BY 
                c.terminal,b.id_fasilitas,c.nama_fasilitas,f.nama_perangkat,b.catatan_perawatan,b.pengukuran,b.id_pmheader")->result_array();

            // foreach untuk gambar per listjob dan nama fasilitas 
           // TAMBAHKAN GAMBAR PENGUKURAN UNTUK SETIAP FASILITAS
            foreach ($data['fasilitas'] as $key => $pm) {
                $gambar_pengukuran = $this->Mod->GetCustome("SELECT 
                    gp.nama_gambar_pengukuran,
                    f.nama_fasilitas,
                    gp.id_pm
                FROM gambar_pengukuran gp
                LEFT JOIN pm p ON p.id_pmheader = gp.id_pm
                LEFT JOIN fasilitas f ON f.id_fasilitas = p.id_fasilitas
                WHERE gp.id_pm = '".$pm['id_pmheader']."' 
                AND p.id_fasilitas = '".$pm['id_fasilitas']."'")->result_array();
                
                $data['fasilitas'][$key]['gambar_pengukuran'] = $gambar_pengukuran;
            }

            // TAMBAHKAN KODE BARU DI SINI - AMBIL DOKUMENTASI GAMBAR PERAWATAN UNTUK SETIAP PM
            foreach ($data['fasilitas'] as $key => $pm) {
            $pm['dokumentasi_gambar_perawatan'] = $this->Mod->GetCustome("SELECT 
                dgp.nama_dokumentasi_gambar_perawatan	
            FROM dokumentasi_gambar_perawatan dgp
            WHERE dgp.id_pm = '".$pm['id_pmheader']."'")->result_array();
            
            $data['fasilitas'][$key]['dokumentasi_gambar_perawatan'] = $pm['dokumentasi_gambar_perawatan'];

            // TAMBAHAN: Tarik referensi Alat/Perangkat per PM (dari pm_khusus) untuk PrintData
            $perangkat = $this->Mod->GetCustome("SELECT p.nama_perangkat 
                                                FROM pm_khusus pk 
                                                JOIN perangkat p ON p.id_perangkat = pk.id_perangkat 
                                                WHERE pk.id_pm = '".$pm['id_pmheader']."'")->result_array();
            $data['fasilitas'][$key]['perangkat'] = implode(', ', array_column($perangkat, 'nama_perangkat'));
        }

            /* REVISI: Deduplikasi fasilitas untuk tabel peralatan & Grouping catatan perawatan */
            $unique_fasilitas = [];
            $seen_ids = [];
            $grouped_notes = [];

            foreach ($data['fasilitas'] as $f) {
                $id = $f['id_fasilitas'];
                // Untuk tabel peralatan unik
                if (!in_array($id, $seen_ids)) {
                    $unique_fasilitas[] = $f;
                    $seen_ids[] = $id;
                    $grouped_notes[$id] = [
                        'name' => $f['nama_fasilitas'],
                        'notes' => []
                    ];
                }
                // Tambahkan catatan jika tidak kosong
                if (!empty(trim($f['catatan_perawatan'] ?? ''))) {
                    $grouped_notes[$id]['notes'][] = $f['catatan_perawatan'];
                }
            }
            $data['unique_fasilitas'] = $unique_fasilitas;
            $data['grouped_notes'] = $grouped_notes;
            /* AKHIR REVISI */

            $data['c_fasilitas'] = count($data['fasilitas']);
            $data['lokasi'] = !empty($data['fasilitas'][0]['lokasi']) ? $data['fasilitas'][0]['lokasi'] : '-';
            $data['catatan_perawatan'] = array_column($data['fasilitas'], 'catatan_perawatan');
            $data['pengukuran'] = array_column($data['fasilitas'], 'pengukuran');

            // TAMBAHKAN DATA KOORDINATOR
            $data['koordinator'] = $this->Mod->getWhere('user',array('status != ' =>8,'type_user'=>'102' , 'unit_kerja'=> sess()['unit']))->result_array();
            
            // Ambil nama koordinator pertama jika ada
            if (!empty($data['koordinator'])) {
                $data['nama_koordinator'] = $data['koordinator'][0]['nama'] ?? 'NAMA KOORDINATOR';
            } else {
                $data['nama_koordinator'] = 'NAMA KOORDINATOR';
            }
               
            
            // SINKRONISASI DENGAN ViewData: ambil pmheader_ids dari $data['fasilitas']
            // (sudah JOIN ke tabel pm, nilainya pasti valid — bukan dari wo_detail yang bisa NULL)
            $pmheader_ids = array_values(array_filter(array_unique(array_column($data['fasilitas'], 'id_pmheader'))));

            $data['dock'] = array();
            if (!empty($pmheader_ids)) {
                $ids = implode(",", array_map('intval', $pmheader_ids));
                
                $detail_dock = $this->Mod->GetCustome("SELECT 
                    a.id_job, 
                    a.documentasi, 
                    c.nama,
                    d.nama_fasilitas,
                    a.id_pmheader
                FROM 
                    pm_detail a
                LEFT JOIN 
                    job_pm c ON c.id_jobpm = a.id_job
                LEFT JOIN 
                    pm b ON b.id_pmheader = a.id_pmheader
                LEFT JOIN 
                    fasilitas d ON d.id_fasilitas = b.id_fasilitas
                WHERE 
                    a.id_pmheader IN ($ids)
                GROUP BY 
                    a.id_job, 
                    a.documentasi, 
                    c.nama,
                    d.nama_fasilitas,
                    a.id_pmheader
                ORDER BY
                    a.id_job, d.nama_fasilitas")->result_array();
                    
                $raw_dock = array();
                foreach ($detail_dock as $value) {
                    $job_id = $value['id_job'];
                    
                    if (!isset($raw_dock[$job_id])) {
                        $raw_dock[$job_id] = array(
                            'id_job' => $job_id,
                            'nama' => $value['nama'],
                            'files' => array()
                        );
                    }

                    $isDuplicate = false;
                    foreach ($raw_dock[$job_id]['files'] as $file) {
                        if ($file['documentasi'] === $value['documentasi']) {
                            $isDuplicate = true;
                            break;
                        }
                    }

                    if (!$isDuplicate && !empty($value['documentasi'])) {
                        $raw_dock[$job_id]['files'][] = array(
                            'documentasi'    => $value['documentasi'],
                            'nama_fasilitas' => $value['nama_fasilitas'],
                            'id_pmheader'    => $value['id_pmheader']
                        );
                    }
                }
                
                $data['dock'] = array_values($raw_dock);
            }

            $data['pm_type'] = $this->Mod->getWhere('pm_type',array('idpm_type ' =>$data['idpm_type']))->row_array();
            
            $catagory_check = $this->Mod->getWhere('job_pm_catagory',array('id_unit ' =>$data['id_unit'],'idpm_type'=>$data['idpm_type'] ))->result_array();
            foreach ($catagory_check as $key => $value) {
                $catagory_check[$key]['checklist'] = $this->Mod->getWhere('job_pm_check',array('catagory' =>$value['id_job_catagory'],'id_unit'=>$value['id_unit'] ))->result_array();
            }
            
            $data['check'] = $catagory_check;

             // Panggil fungsi PM sesuai unit
              $this->PM_All($data);
            
        } catch (Exception $e) {
            log_message('error', 'PDF Error: ' . $e->getMessage());
            echo "Error generating PDF: " . $e->getMessage();
        }
      
    }
   
    function PrintData2($id=null){
        try {
            
            // Cek folder upload
            $upload_path = FCPATH . 'upload/pm/';
            if (!is_dir($upload_path)) {
                if (!mkdir($upload_path, 0755, true)) {
                    throw new Exception('Gagal membuat folder upload');
                }
            }
            
            if (!is_writable($upload_path)) {
                throw new Exception('Folder upload tidak writable');
            }
            
            $data["data"] = [];
            $data = $this->Mod->getWhere('wo',array('id_wo ' =>$id))->row_array();
            
            if (empty($data)) {
                throw new Exception('Data WO tidak ditemukan');
            }
            // TAMBAHKAN KODE INI DI SINI - AMBIL NOMOR ARAHAN
        $arahan_data = $this->Mod->GetCustome("SELECT 
            a.deskripsi 
        FROM 
            arahan a
        LEFT JOIN 
            wo w ON w.id_arahan = a.id_arahan
        WHERE 
            w.id_wo = $id")->row_array();
        
        // Simpan nomor arahan ke dalam array $data
        $data['deskripsi'] = $arahan_data ? $arahan_data['deskripsi'] : '-';
        // AKHIR TAMBAHAN KODE

            if (!empty($data['tanggal'])) {
                $data['waktu_tampil'] = waktu($data['tanggal']);
                
                $dateParts = explode("-", substr($data['tanggal'], 0, 10));
                if (count($dateParts) == 3) {
                    $tahun = $dateParts[0];
                    $bulan = $dateParts[1];
                    $tanggal = $dateParts[2];
                    
                    $timestamp = strtotime($data['tanggal']);
                    $namaHari = date('N', $timestamp);
                    
                    $namaHariIndonesia = array(
                        1 => 'Senin',
                        2 => 'Selasa',
                        3 => 'Rabu',
                        4 => 'Kamis',
                        5 => 'Jumat',
                        6 => 'Sabtu',
                        7 => 'Minggu'
                    );
                    
                    $data['tahunsplit'] = $tahun;
                    $data['bulansplit'] = $bulan;
                    $data['tanggalsplit'] = $tanggal;
                    $data['harisplit'] = $namaHariIndonesia[$namaHari];
                }
            }
            
            $query = $this->Mod->GetCustome("SELECT 
                SUBSTRING_INDEX(pelaksana, ',', 1) AS nama_pelaksana_utama
                FROM wo
                WHERE id_wo = '$id'  
            ");
            
            $result = $query->row_array();
            $data['nama_pelaksana_yang_ttd'] = $result['nama_pelaksana_utama'] ?? '-';
            $data['tanggal'] = tgl($data['tanggal'],'l');
            $data['shift_l'] = l_sh($data['shift']);
            
            $data['job'] = $this->Mod->GetCustome("SELECT 
                c.nama as nama_job, 
                b.documentasi,
                f.nama_fasilitas as peralatan
                FROM 
                wo_detail a 
                LEFT JOIN pm_detail b ON b.id_pmheader = a.id_pmheader 
                LEFT JOIN job_pm c ON c.id_jobpm = b.id_job 
                LEFT JOIN pm d ON d.id_pmheader = b.id_pmheader
                LEFT JOIN fasilitas f ON f.id_fasilitas = d.id_fasilitas
                WHERE a.id_wo = '".$id."'

               /* Hanya unit 14,15,16,17: tampilkan pekerjaan yang ada dokumentasi fotonya saja.
                   Selain unit tersebut: semua ceklist muncul walaupun tidak ada dokumentasi. */
                AND (
                    (d.id_unit IN (14,15,16,17) AND b.documentasi IS NOT NULL AND b.documentasi != '')
                    OR
                    (d.id_unit NOT IN (14,15,16,17))
                )

                GROUP BY 
                c.nama, 
                b.documentasi,
                f.nama_fasilitas
                Order By 
                f.nama_fasilitas ASC")->result_array();
            
            $data['c_detail'] = count($data['job']);
            $data['fasilitas'] = $this->Mod->GetCustome("SELECT 
                c.terminal as lokasi,b.id_fasilitas,c.nama_fasilitas,f.nama_perangkat as type,b.catatan_perawatan,b.pengukuran,b.id_pmheader
            FROM 
                wo_detail a 
            LEFT JOIN 
                pm b 
            ON 
                b.id_pmheader = a.id_pmheader 
            LEFT JOIN 
                fasilitas c on c.id_fasilitas = b.id_fasilitas
            LEFT JOIN
                fasilitas_detail d 
            ON  
                d.id_fasilitas = c.id_fasilitas
            LEFT JOIN
                perangkat e
            ON 
                e.id_perangkat = d.id_perangkat
            LEFT JOIN
                model f
            ON 
                f.id_perangkat = e.id_model
            WHERE   
                a.id_wo = '$id' 
            GROUP BY 
                c.terminal,b.id_fasilitas,c.nama_fasilitas,f.nama_perangkat,b.catatan_perawatan,b.pengukuran,b.id_pmheader")->result_array();

          
           // TAMBAHKAN GAMBAR PENGUKURAN UNTUK SETIAP FASILITAS
            foreach ($data['fasilitas'] as $key => $pm) {
                $gambar_pengukuran = $this->Mod->GetCustome("SELECT 
                    gp.nama_gambar_pengukuran,
                    f.nama_fasilitas,
                    gp.id_pm
                FROM gambar_pengukuran gp
                LEFT JOIN pm p ON p.id_pmheader = gp.id_pm
                LEFT JOIN fasilitas f ON f.id_fasilitas = p.id_fasilitas
                WHERE gp.id_pm = '".$pm['id_pmheader']."' 
                AND p.id_fasilitas = '".$pm['id_fasilitas']."'")->result_array();
                
                $data['fasilitas'][$key]['gambar_pengukuran'] = $gambar_pengukuran;
                
            }
              // TAMBAHKAN KODE BARU DI SINI - AMBIL DOKUMENTASI GAMBAR PERAWATAN UNTUK SETIAP PM
            foreach ($data['fasilitas'] as $key => $pm) {
            $pm['dokumentasi_gambar_perawatan'] = $this->Mod->GetCustome("SELECT 
                dgp.nama_dokumentasi_gambar_perawatan	
            FROM dokumentasi_gambar_perawatan dgp
            WHERE dgp.id_pm = '".$pm['id_pmheader']."'")->result_array();
            
            $data['fasilitas'][$key]['dokumentasi_gambar_perawatan'] = $pm['dokumentasi_gambar_perawatan'];

            // TAMBAHAN: Tarik referensi Alat/Perangkat per PM (dari pm_khusus) untuk PrintData2
            $perangkat = $this->Mod->GetCustome("SELECT p.nama_perangkat 
                                                FROM pm_khusus pk 
                                                JOIN perangkat p ON p.id_perangkat = pk.id_perangkat 
                                                WHERE pk.id_pm = '".$pm['id_pmheader']."'")->result_array();
            $data['fasilitas'][$key]['perangkat'] = implode(', ', array_column($perangkat, 'nama_perangkat'));
        }

            /* REVISI: Deduplikasi fasilitas untuk tabel peralatan & Grouping catatan perawatan */
            $unique_fasilitas = [];
            $seen_ids = [];
            $grouped_notes = [];

            foreach ($data['fasilitas'] as $f) {
                $id = $f['id_fasilitas'];
                // Untuk tabel peralatan unik
                if (!in_array($id, $seen_ids)) {
                    $unique_fasilitas[] = $f;
                    $seen_ids[] = $id;
                    $grouped_notes[$id] = [
                        'name' => $f['nama_fasilitas'],
                        'notes' => []
                    ];
                }
                // Tambahkan catatan jika tidak kosong
                if (!empty(trim($f['catatan_perawatan'] ?? ''))) {
                    $grouped_notes[$id]['notes'][] = $f['catatan_perawatan'];
                }
            }
            $data['unique_fasilitas'] = $unique_fasilitas;
            $data['grouped_notes'] = $grouped_notes;
            /* AKHIR REVISI */

            $data['c_fasilitas'] = count($data['fasilitas']);
            $data['lokasi'] = !empty($data['fasilitas'][0]['lokasi']) ? $data['fasilitas'][0]['lokasi'] : '-';
            $data['catatan_perawatan'] = array_column($data['fasilitas'], 'catatan_perawatan');
            $data['pengukuran'] = array_column($data['fasilitas'], 'pengukuran');

            // TAMBAHKAN DATA KOORDINATOR
            $data['koordinator'] = $this->Mod->getWhere('user',array('status != ' =>8,'type_user'=>'102' , 'unit_kerja'=> sess()['unit']))->result_array();
            
            // Ambil nama koordinator pertama jika ada
            if (!empty($data['koordinator'])) {
                $data['nama_koordinator'] = $data['koordinator'][0]['nama'] ?? 'NAMA KOORDINATOR';
            } else {
                $data['nama_koordinator'] = 'NAMA KOORDINATOR';
            }
               
            
            // SINKRONISASI DENGAN ViewData: ambil pmheader_ids dari $data['fasilitas']
            // (sudah JOIN ke tabel pm, nilainya pasti valid — bukan dari wo_detail yang bisa NULL)
            $pmheader_ids = array_values(array_filter(array_unique(array_column($data['fasilitas'], 'id_pmheader'))));

            $data['dock'] = array();
            if (!empty($pmheader_ids)) {
                $ids = implode(",", array_map('intval', $pmheader_ids));
                
                $detail_dock = $this->Mod->GetCustome("SELECT 
                    a.id_job, 
                    a.documentasi, 
                    c.nama,
                    d.nama_fasilitas,
                    a.id_pmheader
                FROM 
                    pm_detail a
                LEFT JOIN 
                    job_pm c ON c.id_jobpm = a.id_job
                LEFT JOIN 
                    pm b ON b.id_pmheader = a.id_pmheader
                LEFT JOIN 
                    fasilitas d ON d.id_fasilitas = b.id_fasilitas
                WHERE 
                    a.id_pmheader IN ($ids)
                GROUP BY 
                    a.id_job, 
                    a.documentasi, 
                    c.nama,
                    d.nama_fasilitas,
                    a.id_pmheader
                ORDER BY
                    a.id_job, d.nama_fasilitas")->result_array();
                    
                $raw_dock = array();
                foreach ($detail_dock as $value) {
                    $job_id = $value['id_job'];
                    
                    if (!isset($raw_dock[$job_id])) {
                        $raw_dock[$job_id] = array(
                            'id_job' => $job_id,
                            'nama' => $value['nama'],
                            'files' => array()
                        );
                    }

                    $isDuplicate = false;
                    foreach ($raw_dock[$job_id]['files'] as $file) {
                        if ($file['documentasi'] === $value['documentasi']) {
                            $isDuplicate = true;
                            break;
                        }
                    }

                    if (!$isDuplicate && !empty($value['documentasi'])) {
                        $raw_dock[$job_id]['files'][] = array(
                            'documentasi'    => $value['documentasi'],
                            'nama_fasilitas' => $value['nama_fasilitas'],
                            'id_pmheader'    => $value['id_pmheader']
                        );
                    }
                }
                
                $data['dock'] = array_values($raw_dock);
            }

            $data['pm_type'] = $this->Mod->getWhere('pm_type',array('idpm_type ' =>$data['idpm_type']))->row_array();
            
            $catagory_check = $this->Mod->getWhere('job_pm_catagory',array('id_unit ' =>$data['id_unit'],'idpm_type'=>$data['idpm_type'] ))->result_array();
            foreach ($catagory_check as $key => $value) {
                $catagory_check[$key]['checklist'] = $this->Mod->getWhere('job_pm_check',array('catagory' =>$value['id_job_catagory'],'id_unit'=>$value['id_unit'] ))->result_array();
            }
            $data['check'] = $catagory_check;

             // Panggil fungsi PM sesuai unit
             $this->PM_API($data);
            
        } catch (Exception $e) {
            log_message('error', 'PDF Error: ' . $e->getMessage());
            echo "Error generating PDF: " . $e->getMessage();
        }
    }


    function PM_API($data){
        $this->load->view('v_PM41', $data);
    }

    function PM_All($data){
        $this->load->view('v_PM4', $data);
    }
}