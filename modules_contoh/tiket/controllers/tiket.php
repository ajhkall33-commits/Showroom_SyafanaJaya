<?php
// application/modules/req_open/controllers/Req_open.php
defined('BASEPATH') or exit('No direct script access allowed');

class Tiket extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load library atau helper yang diperlukan
        $this->load->library('pdfgenerator');
        $this->role();
        createFolder();
    }

    private function role()
    {
        $url = urlencode(current_url());

        if (session("username") == "") {
            redirect(base_url('login/auth'));
        }
    }

    public function index()
    {
        // echo "<pre>",print_r ( $this->session->userdata()),"</pre>";
        Permission::grant(uri_string());
        $data["plugin"][]   = "plugin/datatable";
        $data["plugin"][]   = "plugin/select2";
        $data["title"]      = "Perbaikan";
        $data["title_des"]  = "Daftar Perbaikan";
        $data["content"]    = "v_index";
        $data["data"]       = $data;


        $this->load->model('Model');

        $data['lokasi_options']     = $this->Model->get_lokasi_options();
        $data['fasilitas_options']  = $this->Model->get_fasilitas_options();
        $data['pelaksana']               =  $this->Mod->getWhere('user ', array('status != ' => 8, 'type_user' => '1', 'unit_kerja' => sess()['unit']))->result_array();
        $this->load->view('template_v2', $data);
    }

    function LoadData()
    {


        if (isset($_POST['limit'])) {
            $limit = $_POST['limit'];
        } else {
            // Atur nilai default jika $_POST['limit'] tidak diatur
            $limit = 3000;
        }
        if (isset($_POST['src'])) {
            $src = $_POST['src'];
        } else {
            // Atur nilai default jika $_POST['limit'] tidak diatur
            $src = '';
        }

        if (isset($_POST['jenis_perangkat'])) {
            $jenis = $_POST['jenis_perangkat'];
        } else {
            // Atur nilai default jika $_POST['limit'] tidak diatur
            $jenis = '';
        }
        $from               = $this->uri->segment(3);

        $param = [
            'table'         => 'tiket_cm',
            'pk'            => 'id_tiket',
            'parameter'     => array('status !=' => 8, 'id_unit' => sess()['unit']),
            'url'           => $this->uri->segment(2),
            'from'          => $from,
            'limit'         => $limit,
            'src'           => $src,
            'filter'        => (!empty($jenis) ? array('id_jenisperangkat' => $jenis) : ''),
            'param_src'     => [
                'like' => 'no_tiket',
                'or_like' => 'description'
            ]
        ];
        $totalData              = CountDataPag($param);
        $param['total_data']    = $totalData;
        $param['total_page']    = ceil($totalData / $limit);
        $res                    = pagin($param);
        // $res = $this->Mod->getWhere('tiket_cm ',array('status != ' =>8, 'id_unit'=> sess()['unit']))->result_array();
        // $data['data']  = $res['data'];
        // $data['pag']        = $res['pag'];
        foreach ($res['data'] as $key => $value) {
            $res['data'][$key]['status_label'] = stg($value['status']);
            $res['data'][$key]['tanggal_label'] = tgl($value['tanggal'], 's');
            $detail =   $this->Mod->GetCustome("SELECT 
                                    a.*,f.nama_fasilitas,
                                    b.description,
                                    b.foto_before,
                                    b.foto_after,
                                    b.start_time,
                                    b.end_time,
                                    b.report_from ,
                                    d.nama_perangkat,
                                    d.serial_number,
                                    e.nama_masalah 
                                FROM 
                                    tiket_cm_detail a 
                                LEFT JOIN 
                                    tinjut b 
                                ON 
                                    b.id_tinjut = a.id_tinjut
                                LEFT JOIN 
                                    tinjut_detail c 
                                ON 
                                    c.id_tinjut =b.id_tinjut
                                LEFT JOIN 
                                    perangkat d
                                ON 
                                    d.id_perangkat = c.id_perangkat
                                LEFT JOIN 
                                    jenis_masalah e 
                                ON
                                    e.id =c.id_jenismasalah
                                LEFT JOIN 
                                    fasilitas f
                                ON 
                                    f.id_fasilitas = b.id_fasilitas 
                                WHERE  a.id_tiket= '" . $value['id_tiket'] . "'")->result_array();

            $res['data'][$key]['detail'] = $detail;
            $res['data'][$key]['jumlah'] = count($detail);
            //  echo "<pre>",print_r ( $detail),"</pre>";
        }
        echo json_encode($res);
    }

    function SaveData()
    {


        if (isset($_POST['newdata'])) {
            if (isset($_POST['id_user'])) {
                $pelaksana = implode(",", $_POST['id_user']);
            } else {
                $pelaksana = '';
            }

            $head = [
                'tanggal'       => $_POST['tanggal'],
                'team'          => $_POST['team'],
                'shift'         => GetShift()['shift'],
                'pelaksana'     => $pelaksana,
                'id_unit'       => sess()['unit'],
                'create_date'   => date('Y-m-d'),
                'create_by'     => sess()['id']
            ];
            $savedata = $this->db->insert('tiket_cm', $head);
            $id_tiket = $this->db->insert_id();
            foreach ($_POST['newdata'] as $key => $value) {
                //echo "<pre>",print_r ( $value),"</pre>";
                $data = [
                    'id_tiket'  => $id_tiket,
                    'id_tinjut' => $value['id_tinjut'],
                    'status'    =>  0
                ];
                $this->db->insert('tiket_cm_detail', $data);
            }
            if ($savedata) {
                $response = [
                    'code'      => '200',
                    'msg'       =>  'Data Berhasi Disimpan'
                ];
            } else {
                $response = [
                    'code'      => '500',
                    'msg'       =>  'Coba lagi beberapa waktu'
                ];
            }
        } else {
            $response = [
                'code'      => '500',
                'msg'       =>  'Tidak Ada Detail untuk Tiket'
            ];
        }
        echo json_encode($response);
    }




    function ProsesData($id = null)
    {
        if (!empty($id)) {
            $data = [
                'status' => '1'
            ];

            $cek =  $this->Mod->getWhere('tiket_cm_detail', array('id_tiket ' => $id, 'status' => 0))->num_rows();

            if ($cek == 0) {
                $response = [
                    'code'      => '500',
                    'msg'       => 'Gagal Proses Data,Tidak Ada Detail Transaksi/Detail Sudah Digunakan'
                ];
            } else {

                $result     = $this->Mod->update2('tiket_cm', array('id_tiket' => $id), $data);
                $result2    = $this->Mod->update2('tiket_cm_detail', array('id_tiket' => $id, 'status' => 0), $data);
                $cek_detail = $this->Mod->GetCustome("SELECT b.* FROM tiket_cm_detail a left join tinjut b on b.id_tinjut = a.id_tinjut WHERE a.id_tiket= '" . $id . "'")->result_array();
                foreach ($cek_detail as $key => $value) {
                    $data_cancel = ['status' => 8];
                    $result2    = $this->Mod->update2('tiket_cm_detail', array('id_tiket !=' => $id, 'id_tinjut' => $value['id_tinjut'], 'status' => 0), $data_cancel);
                    $data_tinjut = [
                        'status' => '9'
                    ];
                    $this->Mod->update2('tinjut', array('id_tinjut' => $value['id_tinjut']), $data_tinjut);
                }

                // echo "<pre>",print_r ( $cek_detail),"</pre>";
                if ($result) {

                    $cek_user = $this->Mod->getWhere('user', array('id ' => sess()['id']))->row_array();

                    $save_log_ttd = [
                        'id_user'       => sess()['id'],
                        'type_user'     => (!empty($cek_user) ? $cek_user['type_user'] : ''),
                        'rel_id'        =>  $id,
                        'rel_type'      => 'tiket_cm',
                        'create_date'   => date('Y-m-d H:i:s')

                    ];
                    // echo "<pre>",print_r ( $save_log_ttd),"</pre>";
                    $this->db->insert('log_ttd', $save_log_ttd);
                    $response = [
                        'code' => '200',
                        'msg'    =>  'Data Berhasil Di Proses'
                    ];
                } else {
                    $response = [
                        'code'      => '500',
                        'msg'    => 'Gagal Proses Data'
                    ];
                }
            }
        } else {
            $response = [
                'code'      => '500',
                'msg'    =>  'Gagal Proses Data'
            ];
        }

        echo json_encode($response);
    }

    function EditData($id = null)
    {
        $data               = $this->Mod->getWhere('tiket_cm', array('id_tiket ' => $id))->row_array();
        $data['tanggal']    = date("Y-m-d h:m", strtotime($data['tanggal']));
        // $detail             = $this->Mod->GetCustome("SELECT a.*,c.nama_fasilitas FROM tiket_cm_detail a LEFT JOIN tinjut b on b.id_tinjut = a.id_tinjut LEFT JOIN fasilitas c on c.id_fasilitas = b.id_fasilitas WHERE a.id_tiket= '".$data['id_tiket']."'")->result_array();

        // $data['detail'] = $detail ;
        echo json_encode($data);
    }

    function UpdateData($id = null)
    {
        if (isset($_POST['newdata'])) {
            $head = [
                'tanggal'       => $_POST['tanggal'],
                'team'          => $_POST['team'],
                'shift'         => GetShift()['shift'],
                'id_unit'       => sess()['unit'],
                'create_date'   => date('Y-m-d'),
                'create_by'     => sess()['id']
            ];

            $updatedata    = $this->Mod->update2('tiket_cm', array('id_tiket' => $id), $head);

            // $savedata = $this->db->insert('tiket_cm',$head);
            // $id_tiket = $this->db->insert_id();
            foreach ($_POST['newdata'] as $key => $value) {
                //echo "<pre>",print_r ( $value),"</pre>";
                $data = [
                    'id_tiket'  => $id,
                    'id_tinjut' => $value['id_tinjut'],
                    'status'    =>  0
                ];

                $cek =  $this->Mod->getWhere('tiket_cm_detail', array('id_tiket ' => $id, 'id_tinjut' => $value['id_tinjut']))->num_rows();
                if (empty($cek)) {
                    $this->db->insert('tiket_cm_detail', $data);
                }
            }
            if ($updatedata) {
                $response = [
                    'code'      => '200',
                    'msg'       =>  'Data Berhasi Disimpan'
                ];
            } else {
                $response = [
                    'code'      => '500',
                    'msg'       =>  'Coba lagi beberapa waktu'
                ];
            }
        } else {
            $response = [
                'code'      => '500',
                'msg'       =>  'Tidak Ada Detail untuk Tiket'
            ];
        }
        echo json_encode($response);
    }

    function DeleteData($id = null)
    {
        if (!empty($id)) {


            $result = $this->Mod->delete('tiket_cm', array('id_tiket' => $id));
            $this->Mod->delete('tiket_cm_detail', array('id_tiket' => $id));
            if ($result) {
                $response = [
                    'code' => '200',
                    'msg'    =>  'Data Berhasil Di Hapus'
                ];
            } else {
                $response = [
                    'code'      => '500',
                    'msg'    => 'Gagal Proses Data'
                ];
            }
        } else {
            $response = [
                'code'      => '500',
                'msg'    =>  'Gagal Proses Data'
            ];
        }

        echo json_encode($response);
    }

    function ViewData($id = null)
    {
        if (!empty($id)) {
            $header =  $this->Mod->getWhere('tiket_cm', array('id_tiket ' => $id))->row_array();
            $header['pelaksana'] = explode(",", $header['pelaksana']);
            $header['tanggal'] =  tgl($header['tanggal'], 'l');
            $header['shift_l'] = l_sh($header['shift']);
            $header['detail'] = $this->Mod->GetCustome("SELECT 
                a.*,b.nama_fasilitas,c.nama_terminal,f.nama_masalah,e.description as penyelesaian,CONCAT(TIME_FORMAT(a.start_time, '%H:%i'),' - ',TIME_FORMAT(a.end_time, '%H:%i')) as waktu
            FROM 
                tinjut a  
             LEFT JOIN 
                fasilitas b 
            ON 
                b.id_fasilitas = a.id_fasilitas
             LEFT JOIN 
                terminal c 
            ON 
                c.id = b.id_lokasi
            LEFT JOIN 
                tiket_cm_detail d
            ON 
                d.id_tinjut = a.id_tinjut
            LEFT JOIN
                tinjut_detail e
            ON 
                e.id_tinjut = d.id_tinjut
            LEFT JOIN 
                jenis_masalah f
            ON
                f.id = e.id_jenismasalah
            WHERE d.id_tiket = '" . $id . "'")->result_array();
            $data = [
                'code'      => '200',
                'msg'       => 'Load Data Succes',
                'data'      => $header
            ];
        } else {
            $data = [
                'code'      => '404',
                'msg'       =>  'No Data Parameter',
                'data'      => []
            ];
        }
        echo json_encode($data);
    }

    function PrintTiket($id = null)
    {




        $data["data"]           = [];

        $data =  $this->Mod->getWhere('tiket_cm', array('id_tiket ' => $id))->row_array();
        $data['tanggal'] =  tgl($data['tanggal'], 'l');
        $data['shift_l'] = l_sh($data['shift']);

        $data['ttd']['leder'] = $this->Mod->GetCustome("SELECT a.*,b.nama,c.name_role 
                            FROM log_ttd a left join user b 
                            ON b.id = a.id_user
                            LEFT Join role c 
                            ON c.id = a.type_user
                            WHERE 
                                a.type_user='5' 
                            AND
                                a.rel_id ='$id' 
                            and 
                                a.rel_type ='tiket_cm'")->row_array();

        $data['ttd']['organik'] = $this->Mod->GetCustome("SELECT a.*,b.nama,c.name_role 
                                FROM log_ttd a left join user b 
                                ON 
                                    b.id = a.id_user
                                LEFT Join 
                                    role c 
                                ON 
                                    c.id = a.type_user
                                WHERE 
                                    a.type_user='2' 
                                AND 
                                    a.rel_id ='$id' 
                                AND 
                                    a.rel_type ='tiket_cm'")->row_array();
        $data['detail'] = $this->Mod->GetCustome("SELECT 
             a.*,b.nama_fasilitas,c.nama_terminal,f.nama_masalah,e.description as penyelesaian,CONCAT(TIME_FORMAT(a.start_time, '%H:%i'),' - ',TIME_FORMAT(a.end_time, '%H:%i')) as waktu
         FROM 
             tinjut a  
          LEFT JOIN 
             fasilitas b 
         ON 
             b.id_fasilitas = a.id_fasilitas
          LEFT JOIN 
             terminal c 
         ON 
             c.id = b.id_lokasi
         LEFT JOIN 
             tiket_cm_detail d
         ON 
             d.id_tinjut = a.id_tinjut
         LEFT JOIN
             tinjut_detail e
         ON 
             e.id_tinjut = d.id_tinjut
         LEFT JOIN 
             jenis_masalah f
         ON
             f.id = e.id_jenismasalah
         WHERE d.id_tiket = '" . $id . "'")->result_array();
        $data['c_detail'] = count($data['detail']);

        if (sess()['unit'] == 3) {
            $this->CM_CCTV($data);
        } else {
            $this->CM_PSIT($data);
        }
        // $html= $this->load->view('CCTV/cm/CorectivePM2',$data, true);
        // $this->pdfgenerator->generate($html, 'file_pdf','A4','portrait');
    }

    function CM_CCTV($data)
    {
        if (count($data['detail']) > 1) {
            $data['waktu_mulai']    = '';
            $data['waktu_selesai']  = '';
        } else {
            foreach ($data['detail'] as $key => $value) {
                $data['waktu_selesai']  = $value['end_time'];
                $data['waktu_mulai']    = $value['start_time'];
            }
        }
        $data['pelaksana'] = explode(",", $data['pelaksana']);

        $this->load->view('CCTV/cm/index', $data);
        $html = $this->load->view('CCTV/cm/index', $data, true);
        $this->pdfgenerator->generate($html, 'file_pdf', 'A4', 'portrait');
    }


    function CM_PSIT($data)
    {




        $data['pelaksana'] = explode(",", $data['pelaksana']);
        // echo "<pre>",print_r ( $data),"</pre>";
        $this->load->view('FIDS/cm/index', $data);
        $html = $this->load->view('FIDS/cm/index', $data, true);
        $this->pdfgenerator->generate($html, 'file_pdf', 'A4', 'portrait');
    }
}
