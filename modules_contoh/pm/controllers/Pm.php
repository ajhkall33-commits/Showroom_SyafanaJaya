<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;


class Pm extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('Excel');
        $this->load->model("m_data");
        $this->load->library('pdfgenerator');
    }

    private function role()
    {
        $url = urlencode(current_url());
        if (session("username") == "") {
            redirect(base_url('login/auth'));
        }
    }

    private function position()
    {
        $data["position"] = "home";
        return $data;
    }

    public function index()
    {

        // $data = $this->position();
        // $data = access($data,"VIEW");
        $this->role();
        // $data = $this->position();

        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Perawatan";
        $data["title_des"] = "Daftar Perawatan " . sess()['unit_device'];

        // if (sess()['unit'] == 1) {

        // }
        $data["content"] = "v_index";
        // $data["content"]    = "Dashboard_mps";
        $data['pm_type'] = $this->m_data->getWhere('pm_type', array('status !=' => 8))->result_array();
        $data["data"] = $data;
        $data['pelaksana']           =  $this->Mod->getWhere('user ', array('status != ' => 8, 'type_user IN (1,102,107)' => null, 'unit_kerja' => sess()['unit']))->result_array();
        $data['pengawas']            =  $this->Mod->getWhere('user ', array('status != ' => 8, 'type_user' => '2', 'unit_kerja' => sess()['unit']))->result_array();
        $data['pelaksana1']           =  $this->Mod->getWhere('user ', array('status != ' => 8, 'type_user IN (1,102,107)' => null, 'unit_kerja' => sess()['unit']))->result_array();
        $data['pengawas1']            =  $this->Mod->getWhere('user ', array('status != ' => 8, 'type_user' => '2', 'unit_kerja' => sess()['unit']))->result_array();
        $data['koordinator']         =  $this->Mod->getWhere('user ', array('status != ' => 8, 'type_user' => '102', 'unit_kerja' => sess()['unit']))->result_array();

        $this->load->view('template_v2', $data);
        // echo "<pre>",print_r ( $data),"</pre>";
    }


    function LoadData()
    {

        if (strtotime(date('H:i')) >= strtotime('07:00') && strtotime(date('H:i')) <= strtotime('18:59')) {
            $shift = 'PS';
            $dateNow = date("d");
        } else {
            if (strtotime(date('H:i')) >= strtotime('00:01') && strtotime(date('H:i')) <= strtotime('06:59')) {
                $dateNow = date("d") - 1;
            } else {
                $dateNow = date("d");
            }
            $shift = 'M';
        }

        if (sess()['unit'] == 3) {
            $shift = 'ALL';
        }

        $data_res['tanggal']    = $dateNow;
        $minggu = $this->Mod->GetCustome('SELECT WEEK(now()) as minggu')->row_array();
        $w = $minggu['minggu'] + 1;
        // $pm                     =  $this->Mod->GetCustome(" SELECT 
        //                                                     a.* , IFNULL(NULLIF(c.nama_terminal, ''), a.nama_lokasi) as nama_terminal,b.name_pm,d.id_pmheader, d.status as status_pm, d.id_jadwalpm
        //                                                     FROM 
        //                                                         jadwal a
        //                                                     LEFT JOIN
        //                                                         pm_type b
        //                                                     ON 
        //                                                         b.idpm_type = a.idpm_type
        //                                                     LEFT JOIN 
        //                                                        terminal c 
        //                                                     ON
        //                                                        c.id= a.id_lokasi
        //                                                     LEFT JOIN
        //                                                         pm d
        //                                                     ON 
        //                                                         d.id_jadwalpm = a.id_jadwal
        //                                                     WHERE 
        //                                                         a.fasilitas is not null 
        //                                                     AND
        //                                                         a.id_unit='" . sess()['unit'] . "' 
        //                                                     AND 
        //                                                         a.bulan= '" . date("m") . "' and a.minggu = '" . $w . "'
        //                                                     AND 
        //                                                         (d.status IS NULL OR d.status = 0)")->result_array();

        $tanggal = $this->input->post('tanggal');
        $whereTanggal = "";
        if (!empty($tanggal)) {
            $whereTanggal = " AND DATE(m.tanggal_pm) = '$tanggal'";
        }

        $limit = $this->input->post('limit') ? $this->input->post('limit') : 10;

        // SK Manager: filter unit dinamis berdasarkan pilihan dropdown atau semua unit yang dikelola
        $pm_unit_filter = get_unit_filter_sql('filter_unit');

        $manual_pm = $this->Mod->GetCustome(" SELECT 
                                                m.id_fasilitas, m.idpm_type,
                                                IFNULL(NULLIF(t.nama_terminal, ''), f.terminal) as nama_terminal, pt.name_pm, f.nama_fasilitas as fasilitas,
                                                m.id_pmheader, m.status as status_pm, m.id_jadwalpm,
                                                m.tanggal_pm, m.jam_mulai, m.jam_selesai, m.pelaksana, m.pengawas
                                                FROM pm m
                                                LEFT JOIN fasilitas f ON f.id_fasilitas = m.id_fasilitas
                                                LEFT JOIN terminal t ON t.id = f.id_lokasi
                                                LEFT JOIN pm_type pt ON pt.idpm_type = m.idpm_type
                                                WHERE m.status = 0
                                                AND m.id_unit $pm_unit_filter
                                                $whereTanggal
                                                ORDER BY m.tanggal_pm DESC
                                                LIMIT $limit")->result_array();
        

        // $pm = array_merge($pm, $manual_pm);
        $pm = $manual_pm;

        $dum = array();
        foreach ($pm as $key => $value) {
            $value['tanggal_pm'] = Hari_($value['tanggal_pm']) . ' ' . tgl($value['tanggal_pm'], 'sm');
            $data_res['pm'][] = $value;
        }



        $data_res['jam']        = date('H:i');
        $data_res['shift']      = $shift;
        // 
        echo json_encode($data_res);
    }

    function LoadHistory()
    {
        if (isset($_POST['limit'])) {
            $limit = $_POST['limit'];
        } else {
            $limit = 3000;
        }

        $tanggal = $this->input->post('tanggal');
        $filter_fasilitas = $this->input->post('filter_fasilitas'); // Ambil filter fasilitas
        $filter_perangkat = $this->input->post('filter_perangkat'); // Ambil filter perangkat
        $status = $this->input->post('status');

        $whereTanggal = "";
        if (!empty($tanggal)) {
            $whereTanggal = " AND DATE(a.tanggal_pm) = '$tanggal'";
        }

        $whereFasilitas = "";
        if (!empty($filter_fasilitas)) {
            $whereFasilitas = " AND c.nama_fasilitas LIKE '%$filter_fasilitas%'";
        }

        $wherePerangkat = "";
        if (!empty($filter_perangkat)) {
            $wherePerangkat = " AND p.nama_perangkat LIKE '%$filter_perangkat%'";
        }

        $whereStatus = " AND a.status IN ('1', '9')";
        if ($status !== null && $status !== '') {
            $whereStatus = " AND a.status = " . $this->db->escape($status);
        }

        $from = $this->uri->segment(3);
        $offset = $from ? $from : 0;

        // SK Manager: filter unit dinamis berdasarkan pilihan dropdown atau semua unit yang dikelola
        $pm_unit_filter = get_unit_filter_sql('filter_unit');

        $result = $this->Mod->GetCustome("SELECT 
                                        a.id_pmheader, a.status, a.id_jadwalpm, 
                                        c.nama_fasilitas as fasilitas, 
                                        GROUP_CONCAT(p.nama_perangkat SEPARATOR ', ') as perangkat,
                                        a.tanggal_pm, a.jam_mulai, a.jam_selesai, 
                                        a.pengukuran, a.catatan_perawatan, 
                                        d.nama_terminal, e.name_pm, 
                                        a.pelaksana, a.pengawas, 
                                        c.terminal as lokasi_fasilitas,
                                        a.id_fasilitas, a.idpm_type
                                     FROM 
                                        pm a 
                                     LEFT JOIN 
                                        fasilitas c 
                                     ON 
                                        c.id_fasilitas = a.id_fasilitas
                                     LEFT JOIN
                                        pm_khusus pk
                                     ON
                                        pk.id_pm = a.id_pmheader
                                     LEFT JOIN
                                        perangkat p
                                     ON
                                        p.id_perangkat = pk.id_perangkat
                                     LEFT JOIN 
                                        terminal d 
                                     ON 
                                        d.id = c.id_lokasi
                                     LEFT JOIN
                                        pm_type e
                                     ON 
                                        a.idpm_type = e.idpm_type
                                     WHERE YEAR(a.tanggal_pm) = 2026
                                     $whereStatus
                                     AND a.id_unit $pm_unit_filter
                                     $whereTanggal
                                     $whereFasilitas
                                     $wherePerangkat
                                     GROUP BY 
                                        a.id_pmheader
                                     ORDER BY a.id_pmheader DESC
                                     LIMIT $limit OFFSET $offset");

        // Hitung total data dengan filter yang sama
        $count_query = "SELECT COUNT(DISTINCT a.id_pmheader) as total
                    FROM pm a
                    LEFT JOIN fasilitas c ON c.id_fasilitas = a.id_fasilitas
                    LEFT JOIN pm_khusus pk ON pk.id_pm = a.id_pmheader
                    LEFT JOIN perangkat p ON p.id_perangkat = pk.id_perangkat
                    WHERE YEAR(a.tanggal_pm) = 2026
                    $whereStatus
                    AND a.id_unit $pm_unit_filter
                    $whereTanggal
                    $whereFasilitas
                    $wherePerangkat";

        $count_result = $this->Mod->GetCustome($count_query)->row_array();
        $total_data = $count_result['total'];

        $total_page = ceil($total_data / $limit);

        $data['data'] = $result->result_array();
        foreach ($data['data'] as $key => $value) {
            $data['data'][$key]['tanggal_pm'] = Hari_($value['tanggal_pm']) . ' ' . tgl($value['tanggal_pm'], 'sm');
        }

        $data['pag'] = BTNPag($from, $total_page, $total_data, $limit, 'HistoryPM');

        // Tambahkan filter yang digunakan ke response
        $data['selected_tanggal'] = $tanggal;
        $data['selected_fasilitas'] = $filter_fasilitas;
        $data['selected_perangkat'] = $filter_perangkat;
        $data['selected_status'] = $status;

        echo json_encode($data);
    }
    // Tambahkan function di controller pm
    function searchFasilitas()
    {
        if (isset($_POST['keyword'])) {
            $keyword = $_POST['keyword'];

            // Search fasilitas berdasarkan nama
            $this->db->select('DISTINCT(f.nama_fasilitas)');
            $this->db->from('fasilitas f');
            $this->db->join('pm p', 'p.id_fasilitas = f.id_fasilitas', 'left');
            $this->db->where('f.status !=', 8);

            $filter_unit = $this->input->post('filter_unit');
            if (is_sk_manager()) {
                $allowed = get_allowed_units();
                if (!empty($filter_unit) && in_array((int)$filter_unit, $allowed)) {
                    $this->db->where('f.id_unit', (int)$filter_unit);
                } else if (!empty($allowed)) {
                    $this->db->where_in('f.id_unit', $allowed);
                }
            } else {
                $this->db->where('f.id_unit', sess()['unit']);
            }

            $this->db->where('YEAR(p.tanggal_pm)', 2026);
            $this->db->like('f.nama_fasilitas', $keyword);
            $this->db->group_by('f.nama_fasilitas');
            $this->db->order_by('f.nama_fasilitas', 'ASC');
            $this->db->limit(10);

            $result = $this->db->get()->result_array();

            echo json_encode($result);
        }
    }

    function searchPerangkat()
    {
        if (isset($_POST['keyword'])) {
            $keyword = $_POST['keyword'];

            // Search perangkat berdasarkan nama
            $this->db->select('DISTINCT(p.nama_perangkat)');
            $this->db->from('perangkat p');
            $this->db->join('pm_khusus pk', 'pk.id_perangkat = p.id_perangkat', 'left');
            $this->db->join('pm pm', 'pm.id_pmheader = pk.id_pm', 'left');
            $this->db->where('p.status !=', 8);

            $filter_unit = $this->input->post('filter_unit');
            if (is_sk_manager()) {
                $allowed = get_allowed_units();
                if (!empty($filter_unit) && in_array((int)$filter_unit, $allowed)) {
                    $this->db->where('p.id_unit', (int)$filter_unit);
                } else if (!empty($allowed)) {
                    $this->db->where_in('p.id_unit', $allowed);
                }
            } else {
                $this->db->where('p.id_unit', sess()['unit']);
            }

            $this->db->where('YEAR(pm.tanggal_pm)', 2026);
            $this->db->like('p.nama_perangkat', $keyword);
            $this->db->group_by('p.nama_perangkat');
            $this->db->order_by('p.nama_perangkat', 'ASC');
            $this->db->limit(10);

            $result = $this->db->get()->result_array();

            echo json_encode($result);
        }
    }

    /**
     * [CATATAN] Function ini belum dipakai oleh fitur manapun saat ini.
     * Dibiarkan aktif untuk kebutuhan di masa mendatang. Jangan hapus.
     */
    function getDetailForScan()
    {
        $type = $this->input->post('type');
        $id = $this->input->post('id');

        if ($type === 'fasilitas') {
            $fasilitas = $this->Mod->getWhere('fasilitas', array('id_fasilitas' => $id))->row_array();

            // Get all related perangkat
            $perangkat_list = $this->Mod->GetCustome("
                SELECT p.id_perangkat, p.nama_perangkat 
                FROM fasilitas_detail fd
                JOIN perangkat p ON p.id_perangkat = fd.id_perangkat
                WHERE fd.id_fasilitas = '$id' AND fd.status != 8 AND p.status != 8
            ")->result_array();

            if ($fasilitas) {
                echo json_encode([
                    'code' => 200,
                    'type' => 'fasilitas',
                    'id_fasilitas' => $id,
                    'nama_fasilitas' => $fasilitas['nama_fasilitas'],
                    'perangkat_list' => $perangkat_list
                ]);
            } else {
                echo json_encode(['code' => 404]);
            }
        } else if ($type === 'perangkat') {
            $perangkat = $this->Mod->getWhere('perangkat', array('id_perangkat' => $id))->row_array();
            // Get parent fasilitas
            $fas_det = $this->Mod->getWhere('fasilitas_detail', array('id_perangkat' => $id, 'status !=' => 8))->row_array();

            if ($perangkat && $fas_det) {
                $fasilitas = $this->Mod->getWhere('fasilitas', array('id_fasilitas' => $fas_det['id_fasilitas']))->row_array();
                echo json_encode([
                    'code' => 200,
                    'type' => 'perangkat',
                    'id_fasilitas' => $fasilitas['id_fasilitas'],
                    'nama_fasilitas' => $fasilitas['nama_fasilitas'],
                    'id_perangkat' => $id,
                    'nama_perangkat' => $perangkat['nama_perangkat']
                ]);
            } else {
                echo json_encode(['code' => 404]);
            }
        } else {
            echo json_encode(['code' => 400]);
        }
    }


    /**
     * Endpoint AJAX: Mengisi rekomendasi form PM dari hasil scan barcode.
     * Dipanggil oleh pm/views/v_index.php saat halaman dibuka dengan query ?auto_open=1.
     *
     * POST params:
     *   - type : 'fasilitas' | 'perangkat'
     *   - id   : integer (id_fasilitas atau id_perangkat)
     *
     * Response JSON:
     *   - code           : 200 | 404 | 400
     *   - id_fasilitas   : string
     *   - nama_fasilitas : string
     *   - perangkat_list : array [{ id_perangkat, nama_perangkat }]
     *                      (sudah di-filter server-side: exclude nama persis 'listrik')
     */
    function otomatis_rekomendasi_scan()
    {
        $type = $this->input->post('type');
        $id   = $this->input->post('id');

        if ($type === 'fasilitas') {
            $fasilitas = $this->Mod->getWhere('fasilitas', ['id_fasilitas' => $id])->row_array();
            if (!$fasilitas) { echo json_encode(['code' => 404]); return; }

            // Single JOIN query — semua perangkat sekaligus, exclude 'listrik' di SQL
            $perangkat_list = $this->Mod->GetCustome("
                SELECT p.id_perangkat, p.nama_perangkat
                FROM fasilitas_detail fd
                JOIN perangkat p ON p.id_perangkat = fd.id_perangkat
                WHERE fd.id_fasilitas = '$id'
                  AND fd.status != 8
                  AND p.status != 8
                  AND LOWER(TRIM(p.nama_perangkat)) != 'listrik'
            ")->result_array();

            echo json_encode([
                'code'           => 200,
                'type'           => 'fasilitas',
                'id_fasilitas'   => $fasilitas['id_fasilitas'],
                'nama_fasilitas' => $fasilitas['nama_fasilitas'],
                'perangkat_list' => $perangkat_list
            ]);

        } elseif ($type === 'perangkat') {
            $perangkat = $this->Mod->getWhere('perangkat', ['id_perangkat' => $id])->row_array();
            $fas_det   = $this->Mod->getWhere('fasilitas_detail', ['id_perangkat' => $id, 'status !=' => 8])->row_array();

            if (!$perangkat || !$fas_det) { echo json_encode(['code' => 404]); return; }

            $fasilitas      = $this->Mod->getWhere('fasilitas', ['id_fasilitas' => $fas_det['id_fasilitas']])->row_array();
            $perangkat_list = [];

            // Hanya masukkan ke list jika nama perangkat bukan 'listrik'
            if (strtolower(trim($perangkat['nama_perangkat'])) !== 'listrik') {
                $perangkat_list = [[
                    'id_perangkat'   => $perangkat['id_perangkat'],
                    'nama_perangkat' => $perangkat['nama_perangkat']
                ]];
            }

            echo json_encode([
                'code'           => 200,
                'type'           => 'perangkat',
                'id_fasilitas'   => $fasilitas['id_fasilitas'],
                'nama_fasilitas' => $fasilitas['nama_fasilitas'],
                'perangkat_list' => $perangkat_list
            ]);

        } else {
            echo json_encode(['code' => 400, 'msg' => 'Tipe tidak dikenal']);
        }
    }


    function ListJob($id = null)
    {
        $jadwal     = $this->m_data->getWhere('jadwal', array('id_jadwal' => $id, 'status !=' => 8))->row_array();

        $fasilitas  = $this->m_data->getWhere('jadwal', array('id_fasilitas' => $jadwal['id_fasilitas'], 'status !=' => 8))->row_array();

        $job_pm                 = $this->Mod->GetCustome("SELECT 
                                                            b.id_jobpm,b.id_pmtype,b.id_jenisperangkat,b.nama 
                                                        FROM 
                                                            fasilitas_detail a 
                                                        left join 
                                                            job_pm b 
                                                        ON 
                                                            b.id_jenisperangkat= a.id_jenisperangkat
                                                        WHERE
                                                            a.id_fasilitas ='" . $fasilitas['id_fasilitas'] . "' 
                                                        AND
                                                             a.status !=8 AND b.id_pmtype ='" . $jadwal['idpm_type'] . "' 
                                                        AND 
                                                            b.status != 8 AND b.id_unit =" . sess()['unit'] . "
                                                        GROUP BY
                                                             b.id_jobpm,b.id_pmtype,b.id_jenisperangkat,b.nama")->result_array();

        foreach ($job_pm as $key => $value) {
            $job_pm[$key]['dokumentasi'] =  '';
        }
        $jadwal['list_job']  = $job_pm;
        $response = [
            'code'          => '200',
            'msg'           => 'Load Data Succes',
            'data'          =>  $jadwal
        ];
        echo json_encode($response);
    }

    function ListJobManual($id = null)
    {
        // fasilitas
        $idfasiltas = $_POST['fasilitas'];

        $job_pm                 = $this->Mod->GetCustome("SELECT 
                                                            b.id_jobpm,b.id_pmtype,b.id_jenisperangkat,b.nama 
                                                        FROM 
                                                            fasilitas_detail a 
                                                        left join 
                                                            job_pm b 
                                                        ON 
                                                            b.id_jenisperangkat= a.id_jenisperangkat
                                                        WHERE
                                                            a.id_fasilitas ='" . $idfasiltas . "' 
                                                        AND
                                                             a.status !=8 AND b.id_pmtype ='" . $id . "' 
                                                        AND 
                                                            b.status != 8 AND b.id_unit =" . sess()['unit'] . "
                                                        GROUP BY
                                                             b.id_jobpm,b.id_pmtype,b.id_jenisperangkat,b.nama")->result_array();
        foreach ($job_pm as $key => $value) {
            $job_pm[$key]['dokumentasi'] =  '';
        }
        $jadwal['list_job']  = $job_pm;
        $response = [
            'code'          => '200',
            'msg'           => 'Load Data Succes',
            'data'          =>  $jadwal
        ];
        echo json_encode($response);
    }
    function EditData($id = null)
    {
        $pm         = $this->m_data->getWhere('pm', array('id_pmheader' => $id))->row_array();
        $fasilitas = $this->m_data->getWhere('jadwal', array('id_jadwal' => $pm['id_jadwalpm'], 'status !=' => 8, 'id_unit' => sess()['unit']))->row_array();

        $job_pm = $this->Mod->GetCustome("
            SELECT id_jobpm, id_pmtype, id_jenisperangkat, nama 
            FROM job_pm 
            WHERE id_pmtype = '" . $pm['idpm_type'] . "' 
              AND status != 8 
              AND id_unit = " . sess()['unit'] . " 
              AND id_jenisperangkat IN (
                  SELECT id_jenisperangkat 
                  FROM fasilitas_detail 
                  WHERE id_fasilitas = '" . $pm['id_fasilitas'] . "' AND status != 8
              )
        ")->result_array();

        // Eager-load semua pm_detail sekaligus (eliminasi N+1 query)
        $pm_detail_map = [];
        if (!empty($job_pm)) {
            $job_ids = array_column($job_pm, 'id_jobpm');
            $id_list = implode(',', array_map('intval', $job_ids));
            if (!empty($id_list)) {
                $pm_details_raw = $this->Mod->GetCustome(
                    "SELECT id_pmdetail, id_job, id_jenisperangkat, documentasi
                         FROM pm_detail
                         WHERE id_pmheader = " . (int)$pm['id_pmheader'] . "
                           AND id_job IN (" . $id_list . ")"
                )->result_array();

                // Buat lookup map: key = "id_job_id_jenisperangkat"
                foreach ($pm_details_raw as $detail) {
                    $map_key = $detail['id_job'] . '_' . $detail['id_jenisperangkat'];
                    $pm_detail_map[$map_key] = [
                        'doc' => $detail['documentasi'],
                        'id_pmdetail' => $detail['id_pmdetail']
                    ];
                }
            }
        }

        // Assign dokumentasi dari map (O(1) lookup, tanpa query tambahan)
        foreach ($job_pm as $key => $value) {
            $map_key = $value['id_jobpm'] . '_' . $value['id_jenisperangkat'];
            $job_pm[$key]['dokumentasi'] = isset($pm_detail_map[$map_key]) ? $pm_detail_map[$map_key]['doc'] : '';
            $job_pm[$key]['id_pmdetail'] = isset($pm_detail_map[$map_key]) ? $pm_detail_map[$map_key]['id_pmdetail'] : '';
        }

        $fasilitas['list_job']  = $job_pm;
        $fasilitas['pm']        =  $pm;
        $response = [
            'code'          => '200',
            'msg'           => 'Load Data Succes',
            'data'          =>  $fasilitas
        ];
        echo json_encode($response);
    }

    function EditDataManual($id)
    {
        $pm         = $this->Mod->getWhere('pm', array('id_pmheader' => $id))->row_array();
        if (!$pm) {
            log_message('error', 'Data PM tidak ditemukan untuk ID PM Header: ' . $id);
            $res = ['status' => 500, 'msg' => 'Data tidak ditemukan.'];
            echo json_encode($res);
            return;
        }

        // Ambil fasilitas dan data terkait lainnya
        $fasilitas = $this->m_data->getWhere('jadwal', array('id_jadwal' => $pm['id_jadwalpm'], 'status !=' => 8, 'id_unit' => sess()['unit']))->row_array();
        $fas = $this->m_data->getWhere('fasilitas', array('id_fasilitas' => $pm['id_fasilitas'], 'id_unit' => sess()['unit']))->row_array();

        $pm_khusus = $this->Mod->getWhere('pm_khusus', array('id_pm' => $pm['id_pmheader']))->result_array();
        $id_perangkat_arr = array();
        foreach ($pm_khusus as $pk) {
            $id_perangkat_arr[] = $pk['id_perangkat'];
        }
        $pm['id_perangkat'] = $id_perangkat_arr;

        $pm['fasilitas'] = ['text' => $fas['nama_fasilitas'], 'id' => $fas['id_fasilitas']];
        $job_pm = $this->Mod->GetCustome("
            SELECT id_jobpm, id_pmtype, id_jenisperangkat, nama 
            FROM job_pm 
            WHERE id_pmtype = '" . $pm['idpm_type'] . "' 
              AND status != 8 
              AND id_unit = " . sess()['unit'] . " 
              AND id_jenisperangkat IN (
                  SELECT id_jenisperangkat 
                  FROM fasilitas_detail 
                  WHERE id_fasilitas = '" . $pm['id_fasilitas'] . "' AND status != 8
              )
        ")->result_array();

        // Eager-load semua pm_detail sekaligus (eliminasi N+1 query)
        $pm_detail_map = [];
        if (!empty($job_pm)) {
            $job_ids = array_column($job_pm, 'id_jobpm');
            $id_list = implode(',', array_map('intval', $job_ids));
            $pm_details_raw = $this->Mod->GetCustome(
                "SELECT id_pmdetail, id_job, id_jenisperangkat, documentasi
                     FROM pm_detail
                     WHERE id_pmheader = " . (int)$pm['id_pmheader'] . "
                       AND id_job IN (" . $id_list . ")"
            )->result_array();

            // Buat lookup map: key = "id_job_id_jenisperangkat"
            foreach ($pm_details_raw as $detail) {
                $map_key = $detail['id_job'] . '_' . $detail['id_jenisperangkat'];
                $pm_detail_map[$map_key] = [
                    'doc' => $detail['documentasi'],
                    'id_pmdetail' => $detail['id_pmdetail']
                ];
            }
        }

        // Assign dokumentasi dari map (O(1) lookup, tanpa query tambahan)
        foreach ($job_pm as $key => $value) {
            $map_key = $value['id_jobpm'] . '_' . $value['id_jenisperangkat'];
            $job_pm[$key]['dokumentasi'] = isset($pm_detail_map[$map_key]) ? $pm_detail_map[$map_key]['doc'] : '';
            $job_pm[$key]['id_pmdetail'] = isset($pm_detail_map[$map_key]) ? $pm_detail_map[$map_key]['id_pmdetail'] : '';
        }

        $fasilitas['list_job'] = $job_pm;
        $fasilitas['pm'] = $pm;

        // Fetch Measurement Images
        $fasilitas['gambar_pengukuran'] = $this->Mod->getWhere('gambar_pengukuran', array(
            'id_pm' => $pm['id_pmheader'],
            'status' => 1
        ))->result_array();

        // Fetch Maintenance Images
        $fasilitas['dokumentasi_gambar_perawatan'] = $this->Mod->getWhere('dokumentasi_gambar_perawatan', array(
            'id_pm' => $pm['id_pmheader'],
            'status' => 1
        ))->result_array();

        $response = [
            'code' => '200',
            'msg' => 'Load Data Success',
            'data' => $fasilitas
        ];
        echo json_encode($response);
    }

    function ViewData($id = null)
    {
        if (!empty($id)) {
            // Query header + perangkat sekaligus via GROUP_CONCAT (eliminasi query terpisah)
            $header = $this->Mod->GetCustome("SELECT 
                                        a.*, 
                                        c.nama_fasilitas as fasilitas, 
                                        d.nama_terminal, e.name_pm,
                                        c.terminal as lokasi_fasilitas,
                                        GROUP_CONCAT(DISTINCT p.nama_perangkat SEPARATOR ', ') AS perangkat
                                     FROM 
                                        pm a 
                                     LEFT JOIN 
                                        fasilitas c 
                                     ON 
                                        c.id_fasilitas = a.id_fasilitas
                                     LEFT JOIN 
                                        terminal d 
                                     ON 
                                        d.id = c.id_lokasi
                                     LEFT JOIN
                                        pm_type e
                                     ON 
                                        a.idpm_type = e.idpm_type
                                     LEFT JOIN
                                        pm_khusus pk
                                     ON
                                        pk.id_pm = a.id_pmheader
                                     LEFT JOIN
                                        perangkat p
                                     ON
                                        p.id_perangkat = pk.id_perangkat
                                     WHERE a.id_pmheader = '$id'
                                     GROUP BY a.id_pmheader")->row_array();

            if ($header) {
                $header['tanggal_pm_l'] = Hari_($header['tanggal_pm']) . ' ' . tgl($header['tanggal_pm'], 'l');

                // perangkat sudah diambil via GROUP_CONCAT di query header (tidak perlu query terpisah)

                // Fetch Details (Jobs) — field 'jum' dihitung langsung di SQL, tidak perlu foreach PHP
                $detail = $this->Mod->GetCustome("SELECT 
                                                    a.*,
                                                    b.nama as nama_job,
                                                    IF(a.documentasi IS NOT NULL AND a.documentasi != '', 1, 0) AS jum
                                                FROM 
                                                    pm_detail a
                                                LEFT JOIN 
                                                    job_pm b ON b.id_jobpm = a.id_job
                                                WHERE 
                                                    a.id_pmheader = '$id' AND a.status != 8
                                                GROUP BY 
                                                    a.id_job, a.documentasi, b.nama")->result_array();

                $header['detail'] = $detail;

                // Fetch Measurement Images
                $header['gambar_pengukuran'] = $this->Mod->getWhere('gambar_pengukuran', array(
                    'id_pm' => $id,
                    'status' => 1
                ))->result_array();

                // Fetch Maintenance Images
                $header['dokumentasi_gambar_perawatan'] = $this->Mod->getWhere('dokumentasi_gambar_perawatan', array(
                    'id_pm' => $id,
                    'status' => 1
                ))->result_array();

                $data = [
                    'code' => '200',
                    'msg' => 'Load Data Success',
                    'data' => $header
                ];
            } else {
                $data = [
                    'code' => '404',
                    'msg' => 'Data Not Found',
                    'data' => []
                ];
            }
        } else {
            $data = [
                'code' => '404',
                'msg' => 'No Data Parameter',
                'data' => []
            ];
        }

        echo json_encode($data);
    }


    function wz($id)
    {
        $data = [];
        $data['id'] = $id;
        $this->load->view('v_wizard', $data);
    }

    function UploadData($idfasilitas, $pmtype)
    {

        if (isset($_POST['id_user1'])) {
            $pelaksana1 = implode(",", $_POST['id_user1']);
            // Jika id_user1 ada, maka tampilkan atau simpan datanya
            echo 'Pelaksana: ' . $pelaksana1;  // Debugging untuk mengecek isi 
        } else {
            echo 'Pelaksana tidak ada';  // Jika id_user1 tidak ada
        }

        if (isset($_POST['id_pengawas1'])) {
            $pengawas1 = implode(",", $_POST['id_pengawas1']);
            // Jika id_pengawas1 ada, maka tampilkan atau simpan datanya
            echo 'Pengawas: ' . $pengawas1;  // Debugging untuk mengecek isi
        } else {
            echo 'Pengawas tidak ada';  // Jika id_pengawas1 tidak ada
        }


        $tanggal_sekarang = date('Y-m-d');
        $fasilitas  = $this->Mod->getWhere('fasilitas', array('id_fasilitas' => $idfasilitas, 'status !=' => 8))->row_array();
        $file = array();

        $header = [
            'id_unit'       => sess()['unit'],
            'idpm_type'     => $pmtype,
            'id_jadwalpm'   => $_POST['idjadwal'],
            'id_fasilitas'  => $idfasilitas,
            'tanggal_pm'    => $tanggal_sekarang,
            'pelaksana'     => $pelaksana1,
            'pengawas'      => $pengawas1,
            'jam_mulai'     => $_POST['jam_mulai'],
            'jam_selesai'   => $_POST['jam_selesai'],
            'pengukuran'   => $_POST['pengukuran'],
            'catatan_perawatan'   => $_POST['catatan_perawatan'],
            'status'        => 0,
            'create_date'   => date('Y-m-d'),
            'create_by'     => sess()['nama']
        ];
        $this->db->insert('pm', $header);
        $id_header = $this->db->insert_id();
        //  echo "<pre>",print_r ($header),"</pre>";
        // Proses simpan data detail (documentasi awalnya kosong, diisi di modal 2)
        $job_pm = $this->Mod->GetCustome("
            SELECT id_jobpm, id_pmtype, id_jenisperangkat, nama 
            FROM job_pm 
            WHERE id_pmtype = '" . $pmtype . "' 
              AND status != 8 
              AND id_unit = " . sess()['unit'] . " 
              AND id_jenisperangkat IN (
                  SELECT id_jenisperangkat 
                  FROM fasilitas_detail 
                  WHERE id_fasilitas = '" . $idfasilitas . "' AND status != 8
              )
        ")->result_array();

        foreach ($job_pm as $job) {
            $jobpm = $job['id_jobpm'];
            $fas_detail = $this->Mod->getWhere('fasilitas_detail', array(
                'id_fasilitas' => $idfasilitas,
                'id_jenisperangkat' => $job['id_jenisperangkat']
            ))->result_array();
            
            foreach ($fas_detail as $key2 => $val) {
                $detail = [
                    'id_pmheader'           => $id_header,
                    'id_job'                => $jobpm,
                    'id_jenisperangkat'     => $job['id_jenisperangkat'],
                    'id_perangkat'          => $val['id_perangkat'],
                    'id_fasilitas'          => $idfasilitas,
                    'documentasi'           => '',
                    'status'                => 0,
                    'create_date'           => date('Y-m-d'),
                    'create_by'             => sess()['nama'],
                ];

                $this->db->insert('pm_detail', $detail);
            }
        }
    }


    public function UploadDataManual()
    {
        // Ambil data dari POST
        $idfasilitas    = $_POST['id_fasilitas'];
        $pmtype         = $_POST['idpm_type'];
        $tanggal_pm     = $_POST['tanggal_pm'];
        if (!empty($tanggal_pm)) {
            $tanggal_pm = $tanggal_pm;
        } else {
            $tanggal_pm = date('Y-m-d');
        }
        $id_perangkat    = $this->input->post('id_perangkat'); // Ini sekarang array

        if (isset($_POST['id_user'])) {
            $pelaksana = implode(",", $_POST['id_user']);
        } else {
            $pelaksana = '';
        }

        if (isset($_POST['id_pengawas'])) {
            $pengawas = implode(",", $_POST['id_pengawas']);
        } else {
            $pengawas = '';
        }

        $jam_mulai      = $_POST['jam_mulai'];
        $jam_selesai    = $_POST['jam_selesai'];
        // $pengukuran     = $_POST['pengukuran'];
        $catatan_perawatan = $_POST['catatan_perawatan'];
        $fasilitas      = $this->Mod->getWhere('fasilitas', array('id_fasilitas' => $idfasilitas, 'status !=' => 8))->row_array();
        // $perangkat      = $this->Mod->getWhere('perangkat', array('id_perangkat' => $idperangkat, 'status !=' => 8))->row_array();

        $file = array();
        $header = [
            'id_unit'       => sess()['unit'],
            'idpm_type'     => $pmtype,
            'tanggal_pm'    => $tanggal_pm,
            'pelaksana'     => $pelaksana,
            'pengawas'      => $pengawas,
            'jam_mulai'     => $jam_mulai,
            'jam_selesai'   => $jam_selesai,

            'catatan_perawatan'    => $catatan_perawatan,
            'id_fasilitas'  => $idfasilitas,
            'status'        => 0,
            // 'id_perangkat'  => in_array(sess()['unit'], [18, 19, 20, 21, 22, 23, 28]) ? $idperangkat : null, // Dihapus dari tabel pm
            'create_date'   => date('Y-m-d'),
            'create_by'     => sess()['nama']
        ];

        // Menyimpan data utama
        $this->db->insert('pm', $header);
        $id_header = $this->db->insert_id();


        if (!empty($id_perangkat)) {
            if (!is_array($id_perangkat)) {
                $id_perangkat = array($id_perangkat);
            }
            $batch_khusus = [];
            foreach ($id_perangkat as $idp) {
                if (!empty($idp)) {
                    $batch_khusus[] = [
                        'id_pm' => $id_header,
                        'id_perangkat' => $idp,
                        'status' => 1
                    ];
                }
            }
            if (!empty($batch_khusus)) {
                $this->db->insert_batch('pm_khusus', $batch_khusus);
            }
        }


        // ==============================================
        // PROSES UPLOAD GAMBAR PENGUKURAN
        // ==============================================
        if (isset($_FILES['gambar_pengukuran']) && is_array($_FILES['gambar_pengukuran']['name'])) {
            $upload_path = './upload/gambar_pengukuran/';

            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }

            $file_count = count($_FILES['gambar_pengukuran']['name']);

            // Tambah allowed types: gambar + pdf + doc/docx + xls/xlsx
            $allowed_types = [
                'image/jpeg',
                'image/png',
                'image/gif',
                'image/jpg',
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // docx
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',       // xlsx
            ];

            $max_size = 5 * 1024 * 1024; // 5MB
            $finfo = function_exists('finfo_open') ? finfo_open(FILEINFO_MIME_TYPE) : false;

            $batch_gambar = [];
            for ($i = 0; $i < $file_count; $i++) {

                if (
                    $_FILES['gambar_pengukuran']['error'][$i] === UPLOAD_ERR_OK &&
                    !empty($_FILES['gambar_pengukuran']['name'][$i]) &&
                    $_FILES['gambar_pengukuran']['size'][$i] > 0
                ) {

                    $tmp_name = $_FILES['gambar_pengukuran']['tmp_name'][$i];

                    if ($finfo) {
                        $file_type = finfo_file($finfo, $tmp_name);
                    } else {
                        // fallback ke type dari $_FILES (kurang aman)
                        $file_type = $_FILES['gambar_pengukuran']['type'][$i];
                    }

                    // Validasi tipe file
                    if (!in_array($file_type, $allowed_types)) {
                        continue;
                    }

                    // Validasi ukuran file
                    if ($_FILES['gambar_pengukuran']['size'][$i] > $max_size) {
                        continue;
                    }

                    // Generate nama file unik
                    $file_ext = pathinfo($_FILES['gambar_pengukuran']['name'][$i], PATHINFO_EXTENSION);
                    $new_filename = uniqid() . '_' . time() . '.' . strtolower($file_ext);

                    $destination = $upload_path . $new_filename;

                    if (move_uploaded_file($tmp_name, $destination)) {
                        $batch_gambar[] = [
                            'id_pm' => $id_header,
                            'nama_gambar_pengukuran' => $new_filename,
                            'status' => 1,
                            'tanggal' => date('Y-m-d H:i:s')
                        ];
                    }
                }
            }
            if ($finfo) finfo_close($finfo);
            if (!empty($batch_gambar)) {
                $this->db->insert_batch('gambar_pengukuran', $batch_gambar);
            }
        }

        // ==============================================
        // PROSES UPLOAD GAMBAR PERAWATAN
        // ==============================================
        if (isset($_FILES['dokumentasi_gambar_perawatan']) && is_array($_FILES['dokumentasi_gambar_perawatan']['name'])) {
            $upload_path = './upload/dokumentasi_gambar_perawatan/';

            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }

            $file_count = count($_FILES['dokumentasi_gambar_perawatan']['name']);

            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
            $max_size = 5 * 1024 * 1024;
            $finfo_perawatan = function_exists('finfo_open') ? finfo_open(FILEINFO_MIME_TYPE) : false;
            $batch_perawatan = [];

            for ($i = 0; $i < $file_count; $i++) {
                if (
                    $_FILES['dokumentasi_gambar_perawatan']['error'][$i] === UPLOAD_ERR_OK &&
                    !empty($_FILES['dokumentasi_gambar_perawatan']['name'][$i]) &&
                    $_FILES['dokumentasi_gambar_perawatan']['size'][$i] > 0
                ) {

                    $tmp_name = $_FILES['dokumentasi_gambar_perawatan']['tmp_name'][$i];

                    if ($finfo_perawatan) {
                        $file_type = finfo_file($finfo_perawatan, $tmp_name);
                    } else {
                        $file_type = $_FILES['dokumentasi_gambar_perawatan']['type'][$i];
                    }

                    if (!in_array($file_type, $allowed_types)) continue;
                    if ($_FILES['dokumentasi_gambar_perawatan']['size'][$i] > $max_size) continue;

                    $file_ext = pathinfo($_FILES['dokumentasi_gambar_perawatan']['name'][$i], PATHINFO_EXTENSION);
                    $new_filename = uniqid() . '_' . time() . '.' . strtolower($file_ext);
                    $destination = $upload_path . $new_filename;

                    if (move_uploaded_file($tmp_name, $destination)) {
                        $batch_perawatan[] = [
                            'id_pm' => $id_header,
                            'nama_dokumentasi_gambar_perawatan' => $new_filename,
                            'status' => 1,
                            'tanggal' => date('Y-m-d H:i:s')
                        ];
                    }
                }
            }
            if ($finfo_perawatan) finfo_close($finfo_perawatan);
            if (!empty($batch_perawatan)) {
                $this->db->insert_batch('dokumentasi_gambar_perawatan', $batch_perawatan);
            }
        }


        // Proses simpan data detail
        // Proses simpan data detail (documentasi awalnya kosong, diisi di modal 2)
        $job_pm = $this->Mod->GetCustome("
            SELECT id_jobpm, id_pmtype, id_jenisperangkat, nama 
            FROM job_pm 
            WHERE id_pmtype = '" . $pmtype . "' 
              AND status != 8 
              AND id_unit = " . sess()['unit'] . " 
              AND id_jenisperangkat IN (
                  SELECT id_jenisperangkat 
                  FROM fasilitas_detail 
                  WHERE id_fasilitas = '" . $idfasilitas . "' AND status != 8
              )
        ")->result_array();

        foreach ($job_pm as $job) {
            $jobpm = $job['id_jobpm'];
            $fas_detail = $this->Mod->getWhere('fasilitas_detail', array(
                'id_fasilitas' => $idfasilitas,
                'id_jenisperangkat' => $job['id_jenisperangkat']
            ))->result_array();

            foreach ($fas_detail as $key2 => $val) {
                $detail = [
                    'id_pmheader'           => $id_header,
                    'id_job'                => $jobpm,
                    'id_jenisperangkat'     => $job['id_jenisperangkat'],
                    'id_perangkat'          => $val['id_perangkat'],
                    'id_fasilitas'          => $idfasilitas,
                    'documentasi'           => '',
                    'status'                => 0,
                    'create_date'           => date('Y-m-d'),
                    'create_by'             => sess()['nama'],
                ];

                $this->db->insert('pm_detail', $detail);
            }
        }

        // Menghapus session setelah data berhasil disimpan
        $this->session->unset_userdata('riwayat'); // unset langsung tanpa memanggil method yg echo JSON

        // Kembalikan response sukses
        echo json_encode(['status' => 'success']);
    }

    public function hapusRiwayatSession()
    {
        // Menghapus session yang berhubungan dengan riwayat data
        $this->session->unset_userdata('riwayat'); // Gantilah 'riwayat' dengan nama session yang sesuai

        // Mengembalikan response sukses dalam format JSON
        echo json_encode(['status' => 'session_deleted']);
    }




    function UpdateData($idjadwalpm)
    {
        $pm = $this->Mod->getWhere('pm', array('id_jadwalpm' => $idjadwalpm))->row_array();
        $id_pmheader = $pm['id_pmheader']; // Dapatkan id_pmheader dari hasil query

        if (!$pm) {
            $res = ['status' => 404, 'msg' => 'Data PM tidak ditemukan'];
            echo json_encode($res);
            return;
        }

        // Update data dasar PM
        $new_pelaksana = $this->input->post('id_user1') ? implode(",", $this->input->post('id_user1')) : '';
        $new_pengawas = $this->input->post('id_pengawas1') ? implode(",", $this->input->post('id_pengawas1')) : '';

        $dataPmUpdate = [];
        if ($pm['pelaksana'] != $new_pelaksana) $dataPmUpdate['pelaksana'] = $new_pelaksana;
        if ($pm['pengawas'] != $new_pengawas) $dataPmUpdate['pengawas'] = $new_pengawas;
        if ($pm['jam_mulai'] != $this->input->post('jam_mulai')) $dataPmUpdate['jam_mulai'] = $this->input->post('jam_mulai');
        if ($pm['jam_selesai'] != $this->input->post('jam_selesai')) $dataPmUpdate['jam_selesai'] = $this->input->post('jam_selesai');
        if ($pm['pengukuran'] != $this->input->post('pengukuran')) $dataPmUpdate['pengukuran'] = $this->input->post('pengukuran');
        if ($pm['catatan_perawatan'] != $this->input->post('catatan_perawatan')) $dataPmUpdate['catatan_perawatan'] = $this->input->post('catatan_perawatan');

        if (!empty($dataPmUpdate)) {
            $this->Mod->update2('pm', array('id_pmheader' => $pm['id_pmheader']), $dataPmUpdate);
        }

        // Dihapus karena update via modal 2
        $res = ['status' => 200, 'msg' => 'Data Update'];
        echo json_encode($res);
    }
    function UpdateDataManual($id_pmheader)
    {
        // Ambil data PM berdasarkan id_pmheader
        $pm = $this->Mod->getWhere('pm', array('id_pmheader' => $id_pmheader))->row_array();

        // Cek apakah data ditemukan
        if (!$pm) {
            log_message('error', 'Data PM tidak ditemukan untuk ID PM Header: ' . $id_pmheader);
            $res = ['status' => 500, 'msg' => 'Data tidak ditemukan.'];
            echo json_encode($res);
            return;
        }

        $id_perangkat = $this->input->post('id_perangkat'); // Array

        // Update data dasar PM
        $dataPmUpdate = [
            'idpm_type' => $this->input->post('idpm_type'),
            'tanggal_pm' => $this->input->post('tanggal_pm'),
            'pelaksana' => $this->input->post('id_user') ? implode(",", $this->input->post('id_user')) : '',
            'pengawas' => $this->input->post('id_pengawas') ? implode(",", $this->input->post('id_pengawas')) : '',
            'jam_mulai' => $this->input->post('jam_mulai'),
            'jam_selesai' => $this->input->post('jam_selesai'),
            'pengukuran' => $this->input->post('pengukuran'),
            'catatan_perawatan' => $this->input->post('catatan_perawatan'),
            // 'id_perangkat'  => in_array(sess()['unit'], [18, 19, 20, 21, 22, 23, 28]) ? $this->input->post('id_perangkat') : null, // Dihapus dari pm
        ];

        // Update record di tabel PM
        $this->Mod->update2('pm', array('id_pmheader' => $pm['id_pmheader']), $dataPmUpdate);

        // Update pm_khusus
        $this->db->delete('pm_khusus', array('id_pm' => $id_pmheader));
        if (!empty($id_perangkat)) {
            if (!is_array($id_perangkat)) {
                $id_perangkat = array($id_perangkat);
            }
            $batch_khusus = [];
            foreach ($id_perangkat as $idp) {
                if (!empty($idp)) {
                    $batch_khusus[] = [
                        'id_pm' => $id_pmheader,
                        'id_perangkat' => $idp,
                        'status' => 1
                    ];
                }
            }
            if (!empty($batch_khusus)) {
                $this->db->insert_batch('pm_khusus', $batch_khusus);
            }
        }

        // Dihapus karena update via modal 2

        // === UPLOAD GAMBAR PENGUKURAN ===
        if (isset($_FILES['gambar_pengukuran']) && is_array($_FILES['gambar_pengukuran']['name'])) {
            $upload_path = './upload/gambar_pengukuran/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }

            $allowed_types = [
                'image/jpeg',
                'image/png',
                'image/gif',
                'image/jpg',
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ];
            $max_size = 5 * 1024 * 1024;
            $file_count = count($_FILES['gambar_pengukuran']['name']);
            $batch_gambar = [];

            for ($i = 0; $i < $file_count; $i++) {
                if (
                    $_FILES['gambar_pengukuran']['error'][$i] === UPLOAD_ERR_OK &&
                    !empty($_FILES['gambar_pengukuran']['name'][$i]) &&
                    $_FILES['gambar_pengukuran']['size'][$i] > 0
                ) {
                    $tmp_name = $_FILES['gambar_pengukuran']['tmp_name'][$i];

                    $file_type = $_FILES['gambar_pengukuran']['type'][$i];

                    if (!in_array($file_type, $allowed_types)) continue;
                    if ($_FILES['gambar_pengukuran']['size'][$i] > $max_size) continue;

                    $file_ext = pathinfo($_FILES['gambar_pengukuran']['name'][$i], PATHINFO_EXTENSION);
                    $new_filename = uniqid() . '_' . time() . '_' . $i . '.' . strtolower($file_ext);
                    $destination = $upload_path . $new_filename;

                    if (move_uploaded_file($tmp_name, $destination)) {
                        $batch_gambar[] = [
                            'id_pm'                     => $id_pmheader,
                            'nama_gambar_pengukuran'    => $new_filename,
                            'status'                    => 1,
                            'tanggal'                   => date('Y-m-d H:i:s')
                        ];
                    }
                }
            }
            if (!empty($batch_gambar)) {
                $this->db->insert_batch('gambar_pengukuran', $batch_gambar);
            }
        }

        // === UPLOAD DOKUMENTASI GAMBAR PERAWATAN ===
        if (isset($_FILES['dokumentasi_gambar_perawatan']) && is_array($_FILES['dokumentasi_gambar_perawatan']['name'])) {
            $upload_path = './upload/dokumentasi_gambar_perawatan/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }

            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
            $max_size = 5 * 1024 * 1024;
            $file_count = count($_FILES['dokumentasi_gambar_perawatan']['name']);
            $batch_perawatan = [];

            for ($i = 0; $i < $file_count; $i++) {
                if (
                    $_FILES['dokumentasi_gambar_perawatan']['error'][$i] === UPLOAD_ERR_OK &&
                    !empty($_FILES['dokumentasi_gambar_perawatan']['name'][$i]) &&
                    $_FILES['dokumentasi_gambar_perawatan']['size'][$i] > 0
                ) {
                    $tmp_name = $_FILES['dokumentasi_gambar_perawatan']['tmp_name'][$i];
                    $file_type = $_FILES['dokumentasi_gambar_perawatan']['type'][$i];

                    if (!in_array($file_type, $allowed_types)) continue;
                    if ($_FILES['dokumentasi_gambar_perawatan']['size'][$i] > $max_size) continue;

                    $file_ext = pathinfo($_FILES['dokumentasi_gambar_perawatan']['name'][$i], PATHINFO_EXTENSION);
                    $new_filename = uniqid() . '_' . time() . '_' . $i . '.' . strtolower($file_ext);
                    $destination = $upload_path . $new_filename;

                    if (move_uploaded_file($tmp_name, $destination)) {
                        $batch_perawatan[] = [
                            'id_pm'                                 => $id_pmheader,
                            'nama_dokumentasi_gambar_perawatan'     => $new_filename,
                            'status'                                => 1,
                            'tanggal'                               => date('Y-m-d H:i:s')
                        ];
                    }
                }
            }
            if (!empty($batch_perawatan)) {
                $this->db->insert_batch('dokumentasi_gambar_perawatan', $batch_perawatan);
            }
        }

        // Ambil status terbaru dari record PM setelah update
        $pm_updated = $this->Mod->getWhere('pm', array('id_pmheader' => $id_pmheader))->row_array();
        $pm_status  = isset($pm_updated['status']) ? (int)$pm_updated['status'] : 0;

        $res = ['status' => 200, 'msg' => 'Data Update Berhasil', 'pm_status' => $pm_status];
        echo json_encode($res);
    }

    public function DeleteLampiranDetail($id_pmdetail)
    {
        $this->Mod->update2('pm_detail', ['id_pmdetail' => $id_pmdetail], ['status' => 8]);
        echo json_encode(['status' => 200, 'msg' => 'Berhasil dihapus']);
    }

    function ProsesData($id)
    {
        if (!empty($id)) {
            $data = ['status' => '1'];

            $pm_header = $this->Mod->getWhere('pm', array('id_pmheader' => $id))->row_array();

            // --- Cek dokumentasi yang NULL atau kosong ---
            $this->db->where('id_pmheader', $id);
            $this->db->group_start();
            $this->db->where('documentasi IS NULL', null, false);
            $this->db->or_where('documentasi', '');
            $this->db->group_end();
            $cek = $this->db->count_all_results('pm_detail');

            // Proses data regardless of documentation completeness
            $result  = $this->Mod->update2('pm', array('id_pmheader' => $id), $data);
            $result2 = $this->Mod->update2('pm_detail', array('id_pmheader' => $id, 'status' => 0), $data);

            if ($result) {
                $cek_user = $this->Mod->getWhere('user', array('id' => sess()['id']))->row_array();

                $save_log_ttd = [
                    'id_user'       => sess()['id'],
                    'type_user'     => (!empty($cek_user) ? $cek_user['type_user'] : ''),
                    'rel_id'        => $id,
                    'rel_type'      => 'pm',
                    'create_date'   => date('Y-m-d H:i:s')
                ];
                $this->db->insert('log_ttd', $save_log_ttd);

                $log = [
                    'id_unit'    => $pm_header['id_unit'],
                    'tittle'     => 'PREVENTIVE MAINTENANCE',
                    'note'       => ($cek != 0) ? 'Dokumentasi belum lengkap' : '',
                    'rel_id'     => $pm_header['id_pmheader'],
                    'rel_type'   => 'pm',
                    'start_time' => date('Y-m-d') . ' ' . $pm_header['jam_mulai'],
                    'end_time'   => date('Y-m-d') . ' ' . $pm_header['jam_selesai'],
                    'create_by'  => $pm_header['create_by'],
                    'create_date' => date('Y-m-d'),
                    'shift'      => GetShift()['shift']
                ];
                $this->db->insert('logbook', $log);

                // Response based on documentation completeness
                if ($cek != 0) {
                    $response = [
                        'code' => '200',
                        'msg' => 'Data Berhasil Diproses, namun dokumentasi belum lengkap'
                    ];
                } else {
                    $response = [
                        'code' => '200',
                        'msg'  => 'Data Berhasil Diproses'
                    ];
                }
            } else {
                $response = [
                    'code' => '500',
                    'msg'  => 'Gagal Proses Data'
                ];
            }
        } else {
            $response = [
                'code' => '500',
                'msg'  => 'Gagal Proses Data'
            ];
        }

        echo json_encode($response);
    }


    function PrintData($id = null)
    {

        $data["plugin"][]           = "plugin/datatable";
        $data["plugin"][]           = "plugin/select2";
        $data["title"]              = "PREVENTIVE MAINTENANCE BULANAN";
        $data["title_des"]          = "Lorem ipsum dolor sit amet";
        $data["content"]            = "PM Bulanan";

        $pm  = $this->Mod->GetCustome("SELECT 
            *,CONCAT(TIME_FORMAT(jam_mulai, '%H:%i'),' - ',TIME_FORMAT(jam_selesai, '%H:%i')) as waktu
        FROM pm WHERE id_pmheader = '" . $id . "'")->row_array();

        $pm['pm_type']                  = $this->Mod->getWhere('pm_type', array('idpm_type' => $pm['idpm_type']))->row_array();
        $pm['terbilang']                = tgl_($pm['tanggal_pm']);

        $fasilitas                      = $this->Mod->getWhere('fasilitas', array('id_fasilitas' => $pm['id_fasilitas']))->row_array();
        $pm['fasilitas']                = $fasilitas['nama_fasilitas'];
        $pm['terminal']                = $fasilitas['terminal'];
        $fas                  = $this->Mod->getWhere('terminal', array('id' => $fasilitas['id_lokasi']))->row_array();
        $pm['lokasi'] = $fas['nama_terminal'];
        $cat                  = $this->Mod->getWhere('fasilitas_catagory', array('id_catagory' => $fasilitas['id_catagory']))->row_array();
        $pm['catagory'] = $cat['nama'];

        $pm['job'] = $this->Mod->GetCustome("SELECT 
            pd.documentasi,b.nama as nama_job
            FROM pm ph
            JOIN pm_detail pd ON pd.id_pmheader = ph.id_pmheader
            LEFT JOIN job_pm b ON b.id_jobpm = pd.id_job
        WHERE 
        ph.id_pmheader= '" . $pm['id_pmheader'] . "' GROUP BY pd.id_fasilitas, ph.id_pmheader, b.id_jobpm ORDER BY order_by ASC ")->result_array();

        // Get devices from pm_khusus
        $pm['devices'] = $this->Mod->GetCustome("SELECT 
            p.nama_perangkat
        FROM pm_khusus pk
        JOIN perangkat p ON p.id_perangkat = pk.id_perangkat
        WHERE pk.id_pm = '" . $pm['id_pmheader'] . "'")->result_array();

        // PERBAIKI QUERY INI - SESUAIKAN FIELD NAME
        $pm['gambar_pengukuran'] = $this->Mod->GetCustome("SELECT 
            gp.nama_gambar_pengukuran
        FROM gambar_pengukuran gp
        WHERE gp.id_pm = '" . $pm['id_pmheader'] . "'")->result_array();


        $pm['dokumentasi_gambar_perawatan'] = $this->Mod->GetCustome("SELECT 
            dgp.nama_dokumentasi_gambar_perawatan	
        FROM dokumentasi_gambar_perawatan dgp
        WHERE dgp.id_pm = '" . $pm['id_pmheader'] . "'")->result_array();


        $pm['tanggal'] = Hari_($pm['tanggal_pm']) . ' ' . tgl($pm['tanggal_pm'], 'sm');

        $data = $pm;

        // Debug: lihat struktur data
        echo "<pre>";
        echo "Data yang dikirim ke view:\n";
        print_r($data);
        echo "</pre>";

        $this->PM_ALL($data);
    }


    function PM_ALL($data)
    {
        // $this->load->view('All/pm/v_general',$data);
        $this->load->view('v_PM', $data);
        // $html= $this->load->view('v_PM',$data, true);
        // $this->pdfgenerator->generate($html, 'file_pdf', 'Legal', 'portrait');
    }
    //  function PM_All($data){

    //     //    $this->load->view('All/pm/v_general',$data);
    //     // echo "<pre>",print_r ($data),"</pre>";
    //     // $this->load->view('v_PM4',$data);
    //     $html = $this->load->view('v_PM', $data, true);
    // //  echo "<pre>",print_r ($data),"</pre>";
    //     // Cek jika HTML kosong
    //     if (empty($html)) {
    //         throw new Exception('View menghasilkan HTML kosong');
    //     }

    //     $this->pdfgenerator->generate($html, 'file_pdf', 'Legal', 'portrait');
    // }

    public function DeleteData($id = null)
    {
        //$this->m_data->delete('jenis_masalah', array('id' =>$id ));
        $data = [
            'status'        => 8,
        ];
        if (!empty($data)) {


            $res_update = $this->Mod->update2('pm', array('id_pmheader' => $id), $data);
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

    public function GetDokumentasiJobs($id_pmheader)
    {
        $detail = $this->db->query("
            SELECT 
                pd.id_job,
                pd.id_pmheader,
                jp.nama as nama_job,
                MAX(pd.documentasi) as documentasi,
                COUNT(pd.id_pmdetail) as jumlah_perangkat
            FROM pm_detail pd
            JOIN job_pm jp ON jp.id_jobpm = pd.id_job
            WHERE pd.id_pmheader = '$id_pmheader'
            GROUP BY pd.id_job, jp.nama, pd.id_pmheader
            ORDER BY jp.nama ASC
        ")->result_array();

        echo json_encode(['status' => 'success', 'data' => $detail]);
    }

    public function UploadDokumentasiJobAsync()
    {
        if (!empty($_FILES['file']['name'])) {
            $upload_path = './upload/pm/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }

            $config['upload_path']   = $upload_path;
            $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx';
            $config['max_size']      = 10000;
            $config['file_name']     = 'job_' . time() . '_' . uniqid();

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $uploadData  = $this->upload->data();
                $file_name   = $uploadData['file_name'];
                $id_job      = $this->input->post('id_job');
                $id_pmheader = $this->input->post('id_pmheader');

                if ($id_job && $id_pmheader) {
                    // Update SEMUA baris pm_detail yang id_job & id_pmheader sama
                    $this->db->where('id_pmheader', $id_pmheader)
                             ->where('id_job', $id_job)
                             ->update('pm_detail', ['documentasi' => $file_name]);
                }

                echo json_encode(['status' => 'success', 'file_name' => $file_name]);
            } else {
                echo json_encode(['status' => 'error', 'msg' => $this->upload->display_errors('', '')]);
            }
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Tidak ada file yang dipilih']);
        }
    }

    public function HapusDokumentasiJob()
    {
        $id_job      = $this->input->post('id_job');
        $id_pmheader = $this->input->post('id_pmheader');

        if (!$id_job || !$id_pmheader) {
            echo json_encode(['status' => 'error', 'msg' => 'Parameter tidak lengkap']);
            return;
        }

        $this->db->where('id_pmheader', $id_pmheader)
                 ->where('id_job', $id_job)
                 ->update('pm_detail', ['documentasi' => null]);

        echo json_encode(['status' => 'success']);
    }
}
