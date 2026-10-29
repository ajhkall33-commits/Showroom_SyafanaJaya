<?php
// application/modules/req_open/controllers/Dashboardmanager.php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboardmanager extends MX_Controller
{
   
    public function __construct()
    {
        parent::__construct();
        $this->load->library('javascript');
        $this->load->model('Dashboard_m');
        $this->load->model('Mod');
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
        $data["param"] = http_build_query($_GET);
        $data["position"] = "home";
        return $data;
    }

    public function index()
    {
        $this->role();
        $data = $this->position();
        
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Dashboard Manager";
        $data["title_des"] = " Semua Unit";
        $data["content"] = "v_deviasi_perawatan";

        $data['units'] = $this->Mod->getWhere('unit', array('status !=' => 8))->result_array();
        $data['categories'] = $this->Mod->getWhere('fasilitas_catagory', array('status !=' => 8))->result_array();

        $data["data"] = $data;

        $this->load->view('template_v2', $data);
    }
    // Start Tabel Deviasi 
    function catagory()
    {
        $data = $this->Mod->getWhere('fasilitas_catagory ', array('status !=' => 8))->result_array();
        echo json_encode($data);
    }
    
    function get_units()
    {
        $data = $this->Mod->getWhere('unit', array('status !=' => 8))->result_array();
        echo json_encode($data);
    }
    
    public function get_deviasi_perawatan()
    {
        @set_time_limit(120);
        @ini_set('memory_limit', '256M');

        try {
            // â”€â”€ Parameter â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
            $limit    = isset($_POST['limit'])    ? (int)$_POST['limit']    : 10;
            $page     = isset($_POST['page'])     ? (int)$_POST['page']     : 1;
            $unit     = $_POST['unit']     ?? '';
            $bulan    = $_POST['bulan']    ?? '';
            $tahun    = $_POST['tahun']    ?? '';
            $search   = $_POST['search']   ?? '';
            $category = $_POST['category'] ?? '';

            if ($limit < 1) $limit = 10;
            if ($page  < 1) $page  = 1;
            $offset = ($page - 1) * $limit;

            // â”€â”€ Query fasilitas (count total) â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
            $this->db->select('f.id_fasilitas, f.nama_fasilitas, f.id_unit, f.id_catagory, u.kode_unit');
            $this->db->from('fasilitas f');
            $this->db->join('unit u', 'f.id_unit = u.id_unit', 'left');
            $this->db->where('f.status !=', 8);
            if (!empty($unit)) {
                if (strpos($unit, ',') !== false) {
                    $this->db->where_in('f.id_unit', explode(',', $unit));
                } else {
                    $this->db->where('f.id_unit', $unit);
                }
            }
            if (!empty($category)) $this->db->where('f.id_catagory', $category);
            if (!empty($search)) {
                $this->db->group_start();
                $this->db->like('f.nama_fasilitas', $search);
                $this->db->or_like('f.ip_address',   $search);
                $this->db->group_end();
            }
            $total_data = $this->db->count_all_results();

            // â”€â”€ Query fasilitas (data dengan limit) â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
            $this->db->select('f.id_fasilitas, f.nama_fasilitas, f.id_unit, f.id_catagory, u.kode_unit');
            $this->db->from('fasilitas f');
            $this->db->join('unit u', 'f.id_unit = u.id_unit', 'left');
            $this->db->where('f.status !=', 8);
            if (!empty($unit)) {
                if (strpos($unit, ',') !== false) {
                    $this->db->where_in('f.id_unit', explode(',', $unit));
                } else {
                    $this->db->where('f.id_unit', $unit);
                }
            }
            if (!empty($category)) $this->db->where('f.id_catagory', $category);
            if (!empty($search)) {
                $this->db->group_start();
                $this->db->like('f.nama_fasilitas', $search);
                $this->db->or_like('f.ip_address',   $search);
                $this->db->group_end();
            }
            $this->db->limit($limit, $offset);
            $fasilitas = $this->db->get()->result_array();

            $pm_types = ['2M', '1B', '3B', '6B', 'T'];

            if (empty($fasilitas)) {
                echo json_encode([
                    'status' => 'success', 'total_data' => $total_data,
                    'total_page' => ceil($total_data / $limit), 'current_page' => $page,
                    'limit' => $limit, 'data' => [], 'pm_types' => $pm_types,
                    'filters' => compact('unit', 'category', 'bulan', 'tahun')
                ]);
                return;
            }

            // â”€â”€ Kumpulkan ID fasilitas â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
            $fasilitas_ids = array_column($fasilitas, 'id_fasilitas');
            $ids_str = implode("','", array_map('intval', $fasilitas_ids));

            // â”€â”€ Filter clauses â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
            $unit_f_jadwal = "";
            if (!empty($unit)) {
                if (strpos($unit, ',') !== false) {
                    $unit_f_jadwal = "AND j.id_unit IN (" . $this->db->escape_str($unit) . ")";
                } else {
                    $unit_f_jadwal = "AND j.id_unit = " . intval($unit);
                }
            }
            $bulan_f_jadwal = !empty($bulan) ? "AND j.bulan = "        . intval($bulan) : "";
            $tahun_f_jadwal = !empty($tahun) ? "AND j.tahun = "        . intval($tahun) : "";

            $unit_f_wo = "";
            if (!empty($unit)) {
                if (strpos($unit, ',') !== false) {
                    $unit_f_wo = "AND w.id_unit IN (" . $this->db->escape_str($unit) . ")";
                } else {
                    $unit_f_wo = "AND w.id_unit = " . intval($unit);
                }
            }
            $bulan_f_wo     = !empty($bulan) ? "AND MONTH(w.tanggal) = " . intval($bulan) : "";
            $tahun_f_wo     = !empty($tahun) ? "AND YEAR(w.tanggal) = "  . intval($tahun) : "";

            // â”€â”€ OPTIMASI Query 1: Rencana semua fasilitas sekaligus â”€â”€â”€â”€â”€â”€â”€
            // Rekomendasi INDEX: ALTER TABLE jadwal ADD INDEX idx_jadwal_pm (id_unit, tahun, bulan, id_fasilitas, idpm_type);
            $rencana_raw = $this->Mod->GetCustome("
                SELECT j.id_fasilitas, j.idpm_type, pt.kode,
                       COUNT(j.idpm_type) AS rencana
                FROM jadwal j
                JOIN pm_type pt ON pt.idpm_type = j.idpm_type
                WHERE j.id_fasilitas IN ('$ids_str')
                  AND pt.status != 8
                  $tahun_f_jadwal
                  $unit_f_jadwal
                  $bulan_f_jadwal
                GROUP BY j.id_fasilitas, j.idpm_type
            ")->result_array();

            // â”€â”€ OPTIMASI Query 2: Realisasi via WO (COUNT DISTINCT wo) â”€â”€â”€
            // Rekomendasi INDEX: ALTER TABLE wo ADD INDEX idx_wo_pm (id_unit, status, idpm_type, tanggal);
            //                    ALTER TABLE pm ADD INDEX idx_pm_header (id_pmheader, id_fasilitas);
            $realisasi_raw = $this->Mod->GetCustome("
                SELECT p.id_fasilitas, w.idpm_type, pt.kode,
                       COUNT(DISTINCT w.id_wo) AS realisasi
                FROM wo w
                JOIN wo_detail wd ON wd.id_wo      = w.id_wo
                JOIN pm p         ON p.id_pmheader = wd.id_pmheader
                JOIN pm_type pt   ON pt.idpm_type  = w.idpm_type
                WHERE w.status  != 8
                  AND p.id_fasilitas IN ('$ids_str')
                  AND pt.status != 8
                  $tahun_f_wo
                  $unit_f_wo
                  $bulan_f_wo
                GROUP BY p.id_fasilitas, w.idpm_type
            ")->result_array();

            // â”€â”€ Build lookup maps di PHP (O(n)) â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
            $rencana_map   = []; // [id_fasilitas][kode] = count
            $realisasi_map = []; // [id_fasilitas][kode] = count

            foreach ($rencana_raw as $r) {
                $kode = strtoupper(trim($r['kode']));
                $rencana_map[$r['id_fasilitas']][$kode] = (int)$r['rencana'];
            }
            foreach ($realisasi_raw as $r) {
                $kode = strtoupper(trim($r['kode']));
                $realisasi_map[$r['id_fasilitas']][$kode] = (int)$r['realisasi'];
            }

            // â”€â”€ Loop fasilitas â€” ZERO query tambahan â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
            foreach ($fasilitas as $key => $fas) {
                $id_fas          = $fas['id_fasilitas'];
                $deviasi_detail  = [];
                $total_rencana   = $total_realisasi = $total_sisa = 0;

                foreach ($pm_types as $kode) {
                    $rencana   = $rencana_map[$id_fas][$kode]   ?? 0;
                    $realisasi = $realisasi_map[$id_fas][$kode] ?? 0;
                    $sisa      = $rencana - $realisasi;
                    $persen    = ($rencana > 0) ? round(($realisasi / $rencana) * 100, 2) : 0;

                    $deviasi_detail[$kode] = [
                        'rencana'    => $rencana,
                        'realisasi'  => $realisasi,
                        'sisa'       => $sisa,
                        'persentase' => $persen
                    ];

                    $total_rencana   += $rencana;
                    $total_realisasi += $realisasi;
                    $total_sisa      += $sisa;
                }

                $fasilitas[$key]['deviasi'] = $deviasi_detail;
                $fasilitas[$key]['total']   = [
                    'rencana'    => $total_rencana,
                    'realisasi'  => $total_realisasi,
                    'sisa'       => $total_sisa,
                    'persentase' => ($total_rencana > 0) ? round(($total_realisasi / $total_rencana) * 100, 2) : 0
                ];
            }

            echo json_encode([
                'status'       => 'success',
                'total_data'   => $total_data,
                'total_page'   => ($limit > 0) ? ceil($total_data / $limit) : 1,
                'current_page' => $page,
                'limit'        => $limit,
                'data'         => $fasilitas,
                'pm_types'     => $pm_types,
                'filters'      => compact('unit', 'category', 'bulan', 'tahun')
            ]);

        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error', 'message' => $e->getMessage(),
                'total_data' => 0, 'total_page' => 0, 'current_page' => 1,
                'limit' => 10, 'data' => []
            ]);
        }
    }
    
    // OPTIMASI: Tambahkan cache untuk data yang sering diakses
    private function getCachedData($key, $callback, $ttl = 300)
    {
        $cache_path = APPPATH . 'cache/';
        if (!is_dir($cache_path)) {
            mkdir($cache_path, 0755, true);
        }
        
        $cache_file = $cache_path . md5($key) . '.cache';
        
        // Cek cache
        if (file_exists($cache_file) && (time() - filemtime($cache_file) < $ttl)) {
            return unserialize(file_get_contents($cache_file));
        }
        
        // Generate data baru
        $data = $callback();
        
        // Simpan ke cache
        file_put_contents($cache_file, serialize($data));
        
        return $data;
    }
    
    // Fungsi lama yang tetap dipertahankan
    public function sum_PM_manager()
    {
        // â”€â”€ Parameter input â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $limit = $_POST['limit']           ?? 3000;
        $src   = $_POST['src']             ?? '';
        $jenis = $_POST['jenis_perangkat'] ?? '';
        
        $unit  = $_POST['unit']  ?? '';
        $bulan = $_POST['bulan'] ?? '';
        $tahun = $_POST['tahun'] ?? '';

        $from  = $this->uri->segment(3);
        $param_where = array('status !=' => 8);
        if (!empty($unit)) {
            $param_where['id_unit'] = $unit;
        }

        $param = [
            'table'     => 'fasilitas',
            'pk'        => 'id_fasilitas',
            'parameter' => $param_where,
            'url'       => $this->uri->segment(2),
            'from'      => $from,
            'limit'     => $limit,
            'src'       => $src,
            'filter'    => (!empty($jenis) ? array('id_catagory' => $jenis) : ''),
            'jenis'     => 'GetSUMPM',
            'param_src' => [
                'like'    => 'nama_fasilitas',
                'or_like' => 'ip_address'
            ]
        ];

        $totalData           = CountDataPag($param);
        $param['total_data'] = $totalData;
        $param['total_page'] = ceil($totalData / $limit);
        $res                 = pagin($param);

        // Filter jadwal dan wo
        $unit_filter_jadwal  = !empty($unit)  ? "AND j.id_unit = '$unit'" : "";
        $tahun_filter_jadwal = !empty($tahun) ? "AND j.tahun = '$tahun'" : "";
        $bulan_filter_jadwal = !empty($bulan) ? "AND j.bulan = " . intval($bulan) : "";

        $unit_filter_wo      = !empty($unit)  ? "AND w.id_unit = '$unit'" : "";
        $tahun_filter_wo     = !empty($tahun) ? "AND YEAR(w.tanggal) = '$tahun'" : "";
        $bulan_filter_wo     = !empty($bulan) ? "AND MONTH(w.tanggal) = " . intval($bulan) : "";

        // â”€â”€ Query 1: Rencana â€” semua fasilitas sekaligus â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $rencana_raw = $this->Mod->GetCustome("
            SELECT j.id_fasilitas, j.idpm_type, pt.kode,
                   COUNT(j.idpm_type) AS rencana
            FROM jadwal j
            JOIN pm_type pt ON pt.idpm_type = j.idpm_type
            WHERE pt.status != 8
              $tahun_filter_jadwal
              $unit_filter_jadwal
              $bulan_filter_jadwal
            GROUP BY j.id_fasilitas, j.idpm_type
        ")->result_array();

        // â”€â”€ Query 2: Realisasi â€” semua fasilitas sekaligus â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $realisasi_raw = $this->Mod->GetCustome("
            SELECT p.id_fasilitas, w.idpm_type,
                   COUNT(DISTINCT w.id_wo) AS realisasi
            FROM wo w
            JOIN wo_detail wd ON wd.id_wo       = w.id_wo
            JOIN pm p         ON p.id_pmheader  = wd.id_pmheader
            WHERE w.status  != 8
              $tahun_filter_wo
              $unit_filter_wo
              $bulan_filter_wo
            GROUP BY p.id_fasilitas, w.idpm_type
        ")->result_array();

        // â”€â”€ Ambil semua pm_type (1 query kecil) â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $pm_types = $this->Mod->getWhere('pm_type', array('status !=' => 8))->result_array();

        // â”€â”€ Build lookup map di PHP (O(n), tanpa query tambahan) â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $rencana_map = [];
        foreach ($rencana_raw as $r) {
            $rencana_map[$r['id_fasilitas']][$r['idpm_type']] = (int)$r['rencana'];
        }

        $realisasi_map = [];
        foreach ($realisasi_raw as $r) {
            $realisasi_map[$r['id_fasilitas']][$r['idpm_type']] = (int)$r['realisasi'];
        }

        $kode_target = ['2M', '1B', '3B', '6B', 'T'];

        // â”€â”€ Loop fasilitas â€” ZERO query tambahan â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        foreach ($res['data'] as $key => $value) {
            $id_fas = $value['id_fasilitas'];

            foreach ($kode_target as $kd) {
                $res['data'][$key]['persentase_' . $kd] = 0;
            }

            $detail = [];
            foreach ($pm_types as $pt) {
                $idpm      = $pt['idpm_type'];
                $kode      = strtoupper(trim($pt['kode']));
                $rencana   = $rencana_map[$id_fas][$idpm]   ?? 0;
                $realisasi = $realisasi_map[$id_fas][$idpm] ?? 0;
                $sisa      = $rencana - $realisasi;

                $detail[] = [
                    'idpm_type' => $idpm,
                    'kode'      => $pt['kode'],
                    'rencana'   => $rencana,
                    'realisasi' => $realisasi,
                    'sisa'      => $sisa
                ];

                if (in_array($kode, $kode_target)) {
                    $persen = ($rencana > 0) ? round(($realisasi / $rencana) * 100, 2) : 0;
                    $res['data'][$key]['persentase_' . $kode] = $persen;
                }
            }
            $res['data'][$key]['detail'] = $detail;
        }

        $data              = [];
        $data['fasilitas'] = $res['data'];
        $data['pag']       = $res['pag'];
        echo json_encode($data);
    }
    
    // End Tabel deviasi

    // Start Grafik 
    public function total_perawatan_perbulan_manager()
{
    // â”€â”€ Guard: cegah timeout & memory limit di server â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    @set_time_limit(120);
    @ini_set('memory_limit', '256M');

    // â”€â”€ Parameter input â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    $unit  = $this->input->post('unit')  ?? '';
    $bulan = $this->input->post('bulan') ?? '';
    $tahun = $this->input->post('tahun') ?? '';

    $unit_filter_jadwal = "";
    if (!empty($unit)) {
        if (strpos($unit, ',') !== false) {
            $unit_filter_jadwal = "AND j.id_unit IN (" . $this->db->escape_str($unit) . ")";
        } else {
            $unit_filter_jadwal = "AND j.id_unit = '" . $this->db->escape_str($unit) . "'";
        }
    }
    $tahun_filter_jadwal = !empty($tahun) ? "AND j.tahun = '$tahun'" : "";
    $bulan_filter_jadwal = !empty($bulan) ? "AND j.bulan = " . intval($bulan) : "";

    $unit_filter_wo = "";
    if (!empty($unit)) {
        if (strpos($unit, ',') !== false) {
            $unit_filter_wo = "AND w.id_unit IN (" . $this->db->escape_str($unit) . ")";
        } else {
            $unit_filter_wo = "AND w.id_unit = '" . $this->db->escape_str($unit) . "'";
        }
    }
    $tahun_filter_wo = !empty($tahun) ? "AND YEAR(w.tanggal) = '$tahun'" : "";
    $bulan_filter_wo = !empty($bulan) ? "AND MONTH(w.tanggal) = " . intval($bulan) : "";

    // â”€â”€ Query 1: Rencana â€” semua fasilitas sekaligus â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    $rencana_raw = $this->Mod->GetCustome("
        SELECT j.id_fasilitas, j.idpm_type, pt.kode,
               COUNT(j.idpm_type) AS rencana
        FROM jadwal j
        JOIN pm_type pt ON pt.idpm_type = j.idpm_type
        JOIN fasilitas f ON f.id_fasilitas = j.id_fasilitas
        WHERE f.status != 8
          AND pt.status != 8
          $tahun_filter_jadwal
          $unit_filter_jadwal
          $bulan_filter_jadwal
        GROUP BY j.id_fasilitas, j.idpm_type
    ")->result_array();

    // â”€â”€ Query 2: Realisasi â€” semua fasilitas sekaligus â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    $realisasi_raw = $this->Mod->GetCustome("
        SELECT p.id_fasilitas, w.idpm_type, pt.kode,
               COUNT(DISTINCT w.id_wo) AS realisasi
        FROM wo w
        JOIN wo_detail wd ON wd.id_wo      = w.id_wo
        JOIN pm p         ON p.id_pmheader = wd.id_pmheader
        JOIN fasilitas f  ON f.id_fasilitas = p.id_fasilitas
        JOIN pm_type pt   ON pt.idpm_type  = w.idpm_type
        WHERE w.status  != 8
          AND f.status  != 8
          AND pt.status != 8
          $tahun_filter_wo
          $unit_filter_wo
          $bulan_filter_wo
        GROUP BY p.id_fasilitas, w.idpm_type
    ")->result_array();

    // Periksa apakah ada data sama sekali
    if (empty($rencana_raw) && empty($realisasi_raw)) {
        echo json_encode([
            'status'  => 'success',
            'data' => [
                '2M' => ['rencana' => 0, 'realisasi' => 0, 'deviasi' => 0, 'persentase' => 0],
                '1B' => ['rencana' => 0, 'realisasi' => 0, 'deviasi' => 0, 'persentase' => 0],
                '3B' => ['rencana' => 0, 'realisasi' => 0, 'deviasi' => 0, 'persentase' => 0],
                '6B' => ['rencana' => 0, 'realisasi' => 0, 'deviasi' => 0, 'persentase' => 0],
                'T'  => ['rencana' => 0, 'realisasi' => 0, 'deviasi' => 0, 'persentase' => 0],
            ]
        ]);
        return;
    }

    // â”€â”€ Build lookup map kode PM â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    $kode_map = [];
    foreach ($rencana_raw  as $r) { $kode_map[$r['idpm_type']] = strtoupper(trim($r['kode'])); }
    foreach ($realisasi_raw as $r) { $kode_map[$r['idpm_type']] = strtoupper(trim($r['kode'])); }

    // â”€â”€ Build pivot map [id_fasilitas][idpm_type] â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    $rencana_map   = [];
    foreach ($rencana_raw as $r) {
        $rencana_map[$r['id_fasilitas']][$r['idpm_type']] = (int)$r['rencana'];
    }

    $realisasi_map = [];
    foreach ($realisasi_raw as $r) {
        $realisasi_map[$r['id_fasilitas']][$r['idpm_type']] = (int)$r['realisasi'];
    }

    // â”€â”€ Hitung totals di PHP â€” ZERO query tambahan â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    $total2m = $total1b = $total3b = $total6b = $totalT = 0;
    $duaM    = $satuB   = $tigaB   = $enamB   = $satuT  = 0;

    $all_fas = array_unique(array_merge(
        array_keys($rencana_map),
        array_keys($realisasi_map)
    ));

    foreach ($all_fas as $id_fas) {
        $all_idpm = array_unique(array_merge(
            array_keys($rencana_map[$id_fas]   ?? []),
            array_keys($realisasi_map[$id_fas] ?? [])
        ));

        foreach ($all_idpm as $idpm) {
            $kode      = $kode_map[$idpm] ?? '';
            $rencana   = $rencana_map[$id_fas][$idpm]   ?? 0;
            $realisasi = $realisasi_map[$id_fas][$idpm] ?? 0;

            switch ($kode) {
                case '2M': $total2m += $rencana; $duaM  += $realisasi; break;
                case '1B': $total1b += $rencana; $satuB += $realisasi; break;
                case '3B': $total3b += $rencana; $tigaB += $realisasi; break;
                case '6B': $total6b += $rencana; $enamB += $realisasi; break;
                case 'T':  $totalT  += $rencana; $satuT += $realisasi; break;
            }
        }
    }

    // â”€â”€ Susun output format â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    $realisasi = [
        '2M' => ['rencana' => $total2m, 'realisasi' => $duaM,  'deviasi' => $total2m - $duaM,  'persentase' => ($total2m > 0) ? round(($duaM  / $total2m) * 100, 2) : 0],
        '1B' => ['rencana' => $total1b, 'realisasi' => $satuB, 'deviasi' => $total1b - $satuB, 'persentase' => ($total1b > 0) ? round(($satuB / $total1b) * 100, 2) : 0],
        '3B' => ['rencana' => $total3b, 'realisasi' => $tigaB, 'deviasi' => $total3b - $tigaB, 'persentase' => ($total3b > 0) ? round(($tigaB / $total3b) * 100, 2) : 0],
        '6B' => ['rencana' => $total6b, 'realisasi' => $enamB, 'deviasi' => $total6b - $enamB, 'persentase' => ($total6b > 0) ? round(($enamB / $total6b) * 100, 2) : 0],
        'T'  => ['rencana' => $totalT,  'realisasi' => $satuT, 'deviasi' => $totalT  - $satuT, 'persentase' => ($totalT  > 0) ? round(($satuT / $totalT)  * 100, 2) : 0],
    ];

    echo json_encode([
        'status' => 'success',
        'data' => $realisasi
    ]);
}



// MULAI PENAMBAHAN ENDPOINT BARU
public function get_kategori_kerusakan_manager() {
    $unit = $this->input->get('unit');
    $bulan = $this->input->get('bulan');
    $tahun = $this->input->get('tahun');
    
    $unit_f = "";
    if (!empty($unit)) {
        if (strpos($unit, ',') !== false) {
            $unit_f = "AND id_unit IN (" . $this->db->escape_str($unit) . ")";
        } else {
            $unit_f = "AND id_unit = '" . $this->db->escape_str($unit) . "'";
        }
    }
    $bulan_f = !empty($bulan) ? "AND MONTH(tanggal) = " . intval($bulan) : "";
    $tahun_f = !empty($tahun) ? "AND YEAR(tanggal) = '$tahun'" : "";
    
    $query = $this->db->query("
        SELECT kategori_kerusakan as name, COUNT(*) as value
        FROM temuan
        WHERE status != 8 AND kategori_kerusakan IS NOT NULL AND kategori_kerusakan != ''
        $unit_f $bulan_f $tahun_f
        GROUP BY kategori_kerusakan
    ")->result_array();
    
    $data = [];
    foreach ($query as $row) {
        $name = $row['name'];
        if (strtolower($name) == 'do it now') $name = 'Do It Now';
        elseif (strtolower($name) == 'do it later') $name = 'Do It Later';
        else $name = ucwords($name);
        $data[] = [
            'name' => $name,
            'value' => intval($row['value'])
        ];
    }
    echo json_encode($data);
}

public function get_analisis_manager() {
    $unit = $this->input->get('unit');
    $bulan = $this->input->get('bulan');
    $tahun = $this->input->get('tahun');
    
    $unit_f = "";
    if (!empty($unit)) {
        if (strpos($unit, ',') !== false) {
            $unit_f = "AND id_unit IN (" . $this->db->escape_str($unit) . ")";
        } else {
            $unit_f = "AND id_unit = '" . $this->db->escape_str($unit) . "'";
        }
    }
    $bulan_f = !empty($bulan) ? "AND MONTH(tanggal) = " . intval($bulan) : "";
    $tahun_f = !empty($tahun) ? "AND YEAR(tanggal) = '$tahun'" : "";
    
    $query = $this->db->query("
        SELECT analisis as name, COUNT(*) as value
        FROM temuan
        WHERE status != 8 AND analisis IS NOT NULL AND analisis != ''
        $unit_f $bulan_f $tahun_f
        GROUP BY analisis
    ")->result_array();
    
    $data = [];
    foreach ($query as $row) {
        $data[] = [
            'name' => ucwords($row['name']),
            'value' => intval($row['value'])
        ];
    }
    echo json_encode($data);
}

public function get_jenis_masalah_manager() {
    $unit = $this->input->get('unit');
    $bulan = $this->input->get('bulan');
    $tahun = $this->input->get('tahun');
    
    $unit_f = "";
    if (!empty($unit)) {
        if (strpos($unit, ',') !== false) {
            $unit_f = "AND t.id_unit IN (" . $this->db->escape_str($unit) . ")";
        } else {
            $unit_f = "AND t.id_unit = '" . $this->db->escape_str($unit) . "'";
        }
    }
    $bulan_f = !empty($bulan) ? "AND MONTH(t.create_date) = " . intval($bulan) : "";
    $tahun_f = !empty($tahun) ? "AND YEAR(t.create_date) = '$tahun'" : "";
    
    $query = $this->db->query("
        SELECT jm.nama_masalah as name, COUNT(jmt.id_jenis_masalah_terpakai) as value
        FROM jenis_masalah_terpakai jmt
        JOIN jenis_masalah jm ON jmt.id_jenis_masalah = jm.id
        JOIN tinjut t ON jmt.id_tinjut = t.id_tinjut
        WHERE jmt.status != 8 AND t.status != 8 
        $unit_f $bulan_f $tahun_f
        GROUP BY jmt.id_jenis_masalah, jm.nama_masalah
        ORDER BY value DESC
        LIMIT 10
    ")->result_array();
    
    $data = [];
    foreach ($query as $row) {
        $data[] = [
            'name' => $row['name'],
            'value' => intval($row['value'])
        ];
    }
    echo json_encode($data);
}

public function get_komponen_terpakai_manager() {
    $unit = $this->input->get('unit');
    $bulan = $this->input->get('bulan');
    $tahun = $this->input->get('tahun');
    
    $unit_f = "";
    if (!empty($unit)) {
        if (strpos($unit, ',') !== false) {
            $unit_f = "AND t.id_unit IN (" . $this->db->escape_str($unit) . ")";
        } else {
            $unit_f = "AND t.id_unit = '" . $this->db->escape_str($unit) . "'";
        }
    }
    $bulan_f = !empty($bulan) ? "AND MONTH(t.create_date) = " . intval($bulan) : "";
    $tahun_f = !empty($tahun) ? "AND YEAR(t.create_date) = '$tahun'" : "";
    
    $query = $this->db->query("
        SELECT k.nama_komponen as name, SUM(kt.satuan_terpakai) as value
        FROM komponen_terpakai kt
        JOIN komponen k ON kt.id_komponen = k.id_komponen
        JOIN tinjut t ON kt.id_tinjut = t.id_tinjut
        WHERE kt.status != 8 AND t.status != 8 
        $unit_f $bulan_f $tahun_f
        GROUP BY kt.id_komponen, k.nama_komponen
        ORDER BY value DESC
        LIMIT 10
    ")->result_array();
    
    $data = [];
    foreach ($query as $row) {
        $data[] = [
            'name' => $row['name'],
            'value' => intval($row['value'])
        ];
    }
    echo json_encode($data);
}

public function get_status_kerusakan_manager() {
    $unit = $this->input->get('unit');
    $bulan = $this->input->get('bulan');
    $tahun = $this->input->get('tahun');
    
    $unit_f = "";
    if (!empty($unit)) {
        if (strpos($unit, ',') !== false) {
            $unit_f = "AND id_unit IN (" . $this->db->escape_str($unit) . ")";
        } else {
            $unit_f = "AND id_unit = '" . $this->db->escape_str($unit) . "'";
        }
    }
    $bulan_f = !empty($bulan) ? "AND MONTH(tanggal) = " . intval($bulan) : "";
    $tahun_f = !empty($tahun) ? "AND YEAR(tanggal) = '$tahun'" : "";
    
    $query = $this->db->query("
        SELECT 
            COUNT(*) as total_kerusakan,
            SUM(CASE WHEN status IN (0,1,2) THEN 1 ELSE 0 END) as status_open,
            SUM(CASE WHEN status = 9 THEN 1 ELSE 0 END) as status_close
        FROM temuan
        WHERE status != 8
        $unit_f $bulan_f $tahun_f
    ")->row_array();
    
    echo json_encode([
        'total_kerusakan' => intval($query['total_kerusakan']),
        'status_open' => intval($query['status_open']),
        'status_close' => intval($query['status_close'])
    ]);
}

public function get_daftar_kerusakan_manager() {
    $unit = $this->input->get('unit');
    $bulan = $this->input->get('bulan');
    $tahun = $this->input->get('tahun');
    
    // Menambahkan filter status != 8
    $where = "t.status != 8 AND (tj.status != 8 OR tj.status IS NULL)";
    if (!empty($unit)) {
        if (strpos($unit, ',') !== false) {
            $where .= " AND t.id_unit IN (" . $this->db->escape_str($unit) . ")";
        } else {
            $where .= " AND t.id_unit = '" . $this->db->escape_str($unit) . "'";
        }
    }
    if (!empty($bulan)) $where .= " AND MONTH(t.tanggal) = " . intval($bulan);
    if (!empty($tahun)) $where .= " AND YEAR(t.tanggal) = '$tahun'";
    
    $query = $this->db->query("
        SELECT 
            u.kode_unit,
            t.nomor, t.tanggal, t.kondisi, f.nama_fasilitas, f.terminal, 
            t.uraian_kejadian, t.status, tj.tindakan, tj.pelaksana, 
            tj.tanggal_mulai, tj.tanggal_selesai, tj.id_tinjut,
            (
                SELECT GROUP_CONCAT(DISTINCT p.nama_perangkat SEPARATOR ', ')
                FROM temuan_detail td
                JOIN perangkat p ON td.id_perangkat = p.id_perangkat
                WHERE td.id_temuan = t.id_temuan AND p.status != 8
            ) as nama_perangkat,
            (
                SELECT GROUP_CONCAT(DISTINCT jm.nama_masalah SEPARATOR ', ')
                FROM jenis_masalah_terpakai jmt
                JOIN jenis_masalah jm ON jmt.id_jenis_masalah = jm.id
                WHERE jmt.id_tinjut = tj.id_tinjut
            ) as jenis_masalah,
            (
                SELECT GROUP_CONCAT(DISTINCT CONCAT(k.nama_komponen, ' (', kt.satuan_terpakai, ')') SEPARATOR ', ')
                FROM komponen_terpakai kt
                JOIN komponen k ON kt.id_komponen = k.id_komponen
                WHERE kt.id_tinjut = tj.id_tinjut AND k.status != 8
            ) as komponen_pcs
        FROM temuan t
        LEFT JOIN unit u ON t.id_unit = u.id_unit
        LEFT JOIN fasilitas f ON t.id_fasilitas = f.id_fasilitas
        LEFT JOIN tinjut tj ON t.id_temuan = tj.id_temuan
        WHERE $where
        ORDER BY t.tanggal DESC
    ");
    
    $format_indo = function($datetime) {
        if (empty($datetime) || $datetime == '0000-00-00 00:00:00' || $datetime == '0000-00-00') return '-';
        
        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        $time = strtotime($datetime);
        $b = (int)date('m', $time);
        
        return date('d', $time) . ' ' . $bulan[$b] . ' ' . date('Y H:i:s', $time);
    };

    $data = [];
    foreach ($query->result_array() as $row) {
         $ket_waktu = '-';
         if (!empty($row['tanggal_selesai']) && !empty($row['tanggal']) && $row['tanggal_selesai'] !== '0000-00-00 00:00:00' && $row['tanggal'] !== '0000-00-00 00:00:00') {
             $datetime1 = new DateTime($row['tanggal']);
             $datetime2 = new DateTime($row['tanggal_selesai']);
             $interval = $datetime1->diff($datetime2);
             
             $parts = [];
             if ($interval->d > 0) $parts[] = $interval->d . ' Hari';
             if ($interval->h > 0) $parts[] = $interval->h . ' Jam';
             if ($interval->i > 0) $parts[] = $interval->i . ' Menit';
             
             if (count($parts) > 0) $ket_waktu = implode(', ', $parts);
             else $ket_waktu = 'Kurang dari 1 menit';
         }

         $status_label = '';
         if ($row['status'] == 0) $status_label = '<span class="badge badge-secondary" style="font-size:12px;">(Open) Draft</span>';
         elseif ($row['status'] == 1) $status_label = '<span class="badge badge-warning" style="font-size:12px;">(Open) Proses</span>';
         elseif ($row['status'] == 2) $status_label = '<span class="badge badge-info" style="font-size:12px;">(Open) Menunggu Approve</span>';
         elseif ($row['status'] == 9) $status_label = '<span class="badge badge-success" style="font-size:12px;">(Close) Approved</span>';
         else $status_label = '<span class="badge badge-light">Unknown ('.$row['status'].')</span>';

         $data[] = [
             'kode_unit' => $row['kode_unit'] ?: '-',
             'nomor' => $row['nomor'] ?: '-',
             'tanggal' => $format_indo($row['tanggal']),
             'kondisi' => $row['kondisi'] ?: '-',
             'nama_fasilitas' => $row['nama_fasilitas'] ?: '-',
             'nama_perangkat' => $row['nama_perangkat'] ?: '-',
             'terminal' => $row['terminal'] ?: '-',
             'uraian_kejadian' => $row['uraian_kejadian'] ?: '-',
             'tindakan' => $row['tindakan'] ?: '-',
             'pelaksana' => $row['pelaksana'] ?: '-',
             'jenis_masalah' => $row['jenis_masalah'] ?: '-',
             'komponen_pcs' => $row['komponen_pcs'] ?: '-',
             'tanggal_mulai' => $format_indo($row['tanggal_mulai']),
             'tanggal_selesai' => $format_indo($row['tanggal_selesai']),
             'ket_waktu' => $ket_waktu,
             'status' => $status_label
         ];
    }
    
    echo json_encode([
        'status' => 'success',
        'data' => $data
    ]);
}

public function persentase_alat_peralatan_danJenisAlat_manager()
    {
        $unit = $this->input->get('unit');
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        $kondisi = $this->input->get('kondisi');
        $status_tinjut = $this->input->get('status_tinjut');

        $where = "t.status != '8'";

        if (!empty($unit)) {
            if (strpos($unit, ',') !== false) {
                $where .= " AND t.id_unit IN (" . $this->db->escape_str($unit) . ")";
            } else {
                $where .= " AND t.id_unit = '" . $this->db->escape_str($unit) . "'";
            }
        }
        if (!empty($bulan)) $where .= " AND MONTH(t.tanggal) = " . intval($bulan);
        if (!empty($tahun)) $where .= " AND YEAR(t.tanggal) = '" . $this->db->escape_str($tahun) . "'";
        if (!empty($kondisi)) $where .= " AND t.kondisi = '" . $this->db->escape_str($kondisi) . "'";

        if ($status_tinjut == 'sudah') {
            $where .= " AND tj.status IS NOT NULL AND tj.status != '8'";
        } else if ($status_tinjut == 'belum') {
            $where .= " AND tj.status IS NULL";
        } else {
            $where .= " AND (tj.status != '8' OR tj.status IS NULL)";
        }

        // 1. Peralatan / Fasilitas
        $fasilitas = $this->db->query("
            SELECT f.nama_fasilitas as name, COUNT(DISTINCT t.id_temuan) as value
            FROM temuan t
            JOIN fasilitas f ON t.id_fasilitas = f.id_fasilitas
            LEFT JOIN tinjut tj ON t.id_temuan = tj.id_temuan
            WHERE $where
            GROUP BY t.id_fasilitas, f.nama_fasilitas
            ORDER BY value DESC
        ")->result_array();

        // 2. Alat / Perangkat 
        $perangkat = $this->db->query("
            SELECT 
                p.nama_perangkat as name,
                COUNT(DISTINCT t.id_temuan) as value
            FROM temuan t
            LEFT JOIN tinjut tj ON t.id_temuan = tj.id_temuan
            JOIN temuan_detail td ON td.id_temuan = t.id_temuan
            JOIN perangkat p ON td.id_perangkat = p.id_perangkat
            WHERE $where
              AND p.status != '8'
            GROUP BY p.id_perangkat, p.nama_perangkat
            ORDER BY value DESC
        ")->result_array();

        // 3. Jenis Perangkat
        $jenis_perangkat = $this->db->query("
            SELECT jp.nama as name, COUNT(DISTINCT t.id_temuan) as value
            FROM temuan t
            JOIN fasilitas_detail fd ON t.id_fasilitas = fd.id_fasilitas
            JOIN jenis_perangkat jp ON fd.id_jenisperangkat = jp.id_jenisperangkat
            LEFT JOIN tinjut tj ON t.id_temuan = tj.id_temuan
            WHERE $where
              AND LOWER(jp.nama) != 'listrik'
            GROUP BY jp.id_jenisperangkat, jp.nama
            ORDER BY value DESC
        ")->result_array();

        echo json_encode([
            'fasilitas' => $fasilitas,
            'perangkat' => $perangkat,
            'jenis_perangkat' => $jenis_perangkat
        ]);
    }

// SELESAI PENAMBAHAN ENDPOINT BARU
// End Grafik// End Grafik


// Start persentase perbaikan
// function persentase_perbaikan() {
//     // Ambil parameter filter dari request
//     $month = $this->input->post('month') ? $this->input->post('month') : date('m');
//     $year = $this->input->post('year') ? $this->input->post('year') : date('Y');
//     $unit = $this->input->post('unit');
    
//     // Query untuk mengambil data perbaikan berdasarkan filter
//     $month_val = (int)$month;
//     $year_val  = (int)$year;
    
//     $unit_filter = "";
//     if (!empty($unit)) {
//         $unit_val = (int)$unit;
//         $unit_filter = "AND a.id_unit = $unit_val";
//     }

//     $data['fasilitas'] = $this->Mod->GetCustome("
//     SELECT 
//     a.id_fasilitas,
//     b.nama_fasilitas,
//     COUNT(DISTINCT a.id_tinjut) AS jumlah_fasilitas,
//     COUNT(DISTINCT td.id_perangkat) AS jumlah_perangkat
//     FROM tinjut a 
//     LEFT JOIN fasilitas b ON b.id_fasilitas = a.id_fasilitas 
//     LEFT JOIN tinjut_detail td ON td.id_tinjut = a.id_tinjut
//     WHERE MONTH(a.create_date) = $month_val
//     AND YEAR(a.create_date) = $year_val
//     $unit_filter
//     AND a.status != 8
//     GROUP BY a.id_fasilitas, b.nama_fasilitas
//     ORDER BY jumlah_perangkat DESC
//     ")->result_array();
    
//     // Menghitung total jumlah perbaikan dan menambahkan warna
//     $total = 0;
//     foreach ($data['fasilitas'] as $key => $value) {
//         $total += $value['jumlah_perangkat'];
//         $data['fasilitas'][$key]['color'] = color($key);
//         $data['fasilitas'][$key]['persentase'] = 0;
//     }
    
//     if ($total > 0) {
//         foreach ($data['fasilitas'] as $key => $value) {
//             $data['fasilitas'][$key]['persentase'] = round(($value['jumlah_perangkat'] / $total) * 100, 2);
//         }
//     }

//     $data['tinjut_details'] = $this->Mod->GetCustome("
//     SELECT 
//         a.id_tinjut,
//         tm.id_temuan as ref_temuan,
//         a.id_fasilitas,
//         a.nomor as nomor_wo,
//         tm.tanggal as tanggal_temuan,
//         a.tanggal_mulai as tgl_mulai_f,
//         a.tanggal_selesai as tgl_selesai_f,
//         b.terminal as lokasi,
//         a.description as keterangan,
//         b.nama_fasilitas,
//         p.nama_perangkat as alat,
//         k.nama_komponen as komponen,
//         jm.nama_masalah as jenis_masalah,
//         td.description as tindakan,
//         a.status
//     FROM tinjut_detail td
//     LEFT JOIN tinjut a ON td.id_tinjut = a.id_tinjut
//     LEFT JOIN fasilitas b ON a.id_fasilitas = b.id_fasilitas
//     LEFT JOIN temuan tm ON a.id_temuan = tm.id_temuan
//     LEFT JOIN perangkat p ON td.id_perangkat = p.id_perangkat
//     LEFT JOIN komponen k ON td.id_komponen = k.id_komponen
//     LEFT JOIN jenis_masalah jm ON td.id_jenismasalah = jm.id
//     WHERE MONTH(a.create_date) = $month_val
//     AND YEAR(a.create_date) = $year_val
//     $unit_filter
//     AND a.status != 8
//     ORDER BY a.create_date DESC
//     ")->result_array();
    
//     // Format status menggunakan helper sts
//     foreach ($data['tinjut_details'] as $k => $v) {
//         $data['tinjut_details'][$k]['label_status'] = sts('3', $v['status']);
//     }
    
//     $data['total'] = $total;
//     $data['filters'] = array(
//         'month' => $month,
//         'year' => $year,
//         'unit' => $unit
//     );
    
//     // Mengirimkan data dalam format JSON
//     echo json_encode($data);
// }
// End persentase perbaikan
// public function persentasePeriode() {
//     $data = array();
    
//     // Ambil parameter dari POST
//     $bulan = $this->input->post('bulan');
//     $tahun = $this->input->post('tahun');
//     $id_unit = $this->input->post('unit');

//     // Default bulan & tahun jika tidak ada
//     $bulan = ($bulan && $bulan != 'all') ? (int)$bulan : (int)date('m');
//     $tahun = ($tahun) ? (int)$tahun : (int)date('Y');

//     // ===============================
//     // 1. TOTAL WAKTU
//     // ===============================
//     $total_days_in_month = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
//     $total_minutes_in_month = $total_days_in_month * 24 * 60;

//     $is_leap_year = ($tahun % 4 == 0 && ($tahun % 100 != 0 || $tahun % 400 == 0));
//     $total_days_in_year = $is_leap_year ? 366 : 365;
//     $total_minutes_in_year = $total_days_in_year * 24 * 60;

//     // Batas tanggal bulan
//     $start_date = "$tahun-" . str_pad($bulan, 2, '0', STR_PAD_LEFT) . "-01 00:00:00";
//     $end_date   = date("Y-m-t 23:59:59", strtotime($start_date));

//     // ===============================
//     // 2. DATA FASILITAS
//     // ===============================
//     $unit_filter_fas = "";
//     if (!empty($id_unit)) {
//         $unit_val_fas = (int)$id_unit;
//         $unit_filter_fas = "AND f.id_unit = '$unit_val_fas'";
//     }

//     $fasilitas_list = $this->Mod->GetCustome("
//         SELECT id_fasilitas, kode, nama_fasilitas 
//         FROM fasilitas f
//         WHERE f.status = '1'
//         $unit_filter_fas
//     ")->result_array();

//     $perangkat_list = $this->Mod->GetCustome("
//         SELECT p.id_perangkat, p.nama_perangkat, fd.id_fasilitas
//         FROM perangkat p
//         JOIN fasilitas_detail fd ON p.id_perangkat = fd.id_perangkat
//         JOIN fasilitas f ON fd.id_fasilitas = f.id_fasilitas
//         WHERE f.status = '1'
//         AND LOWER(p.nama_perangkat) != 'listrik'
//         $unit_filter_fas
//         GROUP BY p.id_perangkat, p.nama_perangkat, fd.id_fasilitas
//     ")->result_array();

//     // Mapping perangkat ke fasilitas
//     $fasilitas_devices = [];
//     foreach ($perangkat_list as $p) {
//         $fasilitas_devices[$p['id_fasilitas']][] = $p;
//     }

//     // ===============================
//     // 3. DOWNTIME BULANAN (OVERLAP)
//     // ===============================
//     $downtime_bulan_ini = $this->Mod->GetCustome("
//         SELECT 
//             td.id_perangkat,
//             SUM(
//                 CASE 
//                     WHEN tm.tanggal IS NOT NULL AND t.tanggal_selesai IS NOT NULL THEN
//                         TIMESTAMPDIFF(
//                             MINUTE,
//                             GREATEST(tm.tanggal, '$start_date'),
//                             LEAST(t.tanggal_selesai, '$end_date')
//                         )
//                     ELSE 0
//                 END
//             ) AS total_downtime,
//             MAX(t.status) AS tinjut_status,
//             MAX(td.status) AS tinjut_detail_status
//         FROM tinjut t
//         LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
//         LEFT JOIN temuan tm ON tm.id_temuan = t.id_temuan
//         WHERE t.id_unit = '$id_unit'
//         AND tm.tanggal <= '$end_date'
//         AND t.tanggal_selesai >= '$start_date'
//         GROUP BY td.id_perangkat
//     ")->result_array();

//     $dt_bulan_map = [];
//     foreach ($downtime_bulan_ini as $row) {
//         if (!empty($row['id_perangkat'])) {
//             $dt_bulan_map[$row['id_perangkat']] = $row;
//         }
//     }

//     // ===============================
//     // 4. DOWNTIME TAHUNAN
//     // ===============================
//     $downtime_tahun_ini = $this->Mod->GetCustome("
//         SELECT 
//             td.id_perangkat,
//             SUM(
//                 TIMESTAMPDIFF(MINUTE, tm.tanggal, t.tanggal_selesai)
//             ) AS total_downtime
//         FROM tinjut t
//         LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
//         LEFT JOIN temuan tm ON tm.id_temuan = t.id_temuan
//         WHERE t.id_unit = '$id_unit'
//         AND YEAR(tm.tanggal) = '$tahun'
//         GROUP BY td.id_perangkat
//     ")->result_array();

//     $dt_tahun_map = [];
//     foreach ($downtime_tahun_ini as $row) {
//         if (!empty($row['id_perangkat'])) {
//             $dt_tahun_map[$row['id_perangkat']] = $row;
//         }
//     }

//     // ===============================
//     // 5. PERHITUNGAN PERFORMA
//     // ===============================
//     $total_unit_performance = 0;
//     $fasilitas_count = 0;
//     $performa_details = [];

//     foreach ($fasilitas_list as $fasilitas) {

//         $id_fasilitas = $fasilitas['id_fasilitas'];
//         $kode_fasilitas = $fasilitas['kode'];
//         $nama_fasilitas = $fasilitas['nama_fasilitas'];

//         $perangkat_di_fasilitas = $fasilitas_devices[$id_fasilitas] ?? [];

//         $total_performance_fasilitas = 0;
//         $perangkat_count = 0;
//         $detail_perangkat_list = [];

//         foreach ($perangkat_di_fasilitas as $perangkat) {

//             $id_perangkat = $perangkat['id_perangkat'];
//             $performaperangkat = 100;

//             $dt_b = $dt_bulan_map[$id_perangkat] ?? null;
//             $dt_t = $dt_tahun_map[$id_perangkat] ?? null;

//             // ===============================
//             // LOGIKA BULANAN
//             // ===============================
//             if (in_array($id_unit, [14,15,16,17]) || $kode_fasilitas == 2) {

//                 $t_status  = $dt_b['tinjut_status'] ?? null;
//                 $td_status = $dt_b['tinjut_detail_status'] ?? null;

//                 // if (($t_status == 2 || empty($t_status)) && ($td_status == 2 || empty($td_status))) {
//                 //     $performaperangkat = 100;
//                 // } else {
//                 //     $downtime = $dt_b['total_downtime'] ?? 0;

//                 //     $performaperangkat =
//                 //         (($total_minutes_in_month - $downtime) / $total_minutes_in_month) * 100;
//                 // }
                
                
//                     $downtime = $dt_b['total_downtime'] ?? 0;

//                     $performaperangkat =
//                         (($total_minutes_in_month - $downtime) / $total_minutes_in_month) * 100;
                


//             } 
//             // ===============================
//             // LOGIKA TAHUNAN
//             // ===============================
//             else {

//                 $downtime = $dt_t['total_downtime'] ?? 0;

//                 $downtime_percentage = ($downtime / $total_minutes_in_year) * 100;
//                 $performaperangkat = 100 - $downtime_percentage;
//             }

//             // Sanitasi
//             $performaperangkat = max(0, min(100, $performaperangkat));
//             $performaperangkat = round($performaperangkat, 2);

//             $detail_perangkat_list[] = [
//                 'nama_perangkat' => $perangkat['nama_perangkat'],
//                 'performa' => $performaperangkat
//             ];

//             $total_performance_fasilitas += $performaperangkat;
//             $perangkat_count++;
//         }

//         $average_performance_fasilitas = ($perangkat_count > 0)
//             ? ($total_performance_fasilitas / $perangkat_count)
//             : 100;

//         $performa_details[] = [
//             'id_fasilitas' => $id_fasilitas,
//             'nama_fasilitas' => $nama_fasilitas,
//             'rata_rata_performa_fasilitas' => round($average_performance_fasilitas, 2),
//             'perangkat' => $detail_perangkat_list
//         ];

//         $total_unit_performance += $average_performance_fasilitas;
//         $fasilitas_count++;
//     }

//     // ===============================
//     // 6. OUTPUT
//     // ===============================
//     $final_unit_performance = ($fasilitas_count > 0)
//         ? ($total_unit_performance / $fasilitas_count)
//         : 100;

//     $data['unit_performance'] = [
//         'average_performance' => round($final_unit_performance, 2),
//         'total_facilities' => $fasilitas_count,
//         'periode' => "$bulan-$tahun"
//     ];

//     $data['performa_details'] = $performa_details;

//     echo json_encode($data);
// }


//card kerusakan: 
// 

    /**
     * CARD 4: Penilaian Asesmen â€” Donut chart distribusi orang (semester range)
     * 
     * Logic semester:
     *   - Bulan 01-06  â†’ range Januari s/d Juni
     *   - Bulan 07-12  â†’ range Juli s/d Desember
     *   - Bulan kosong  â†’ range Januari s/d Desember (full year)
     * 
     * Menampilkan berapa orang yang mendapat nilai di range:
     *   - 0-40 (merah), 41-74 (kuning), 75-100 (hijau)
     * Untuk 4 tab: CBT, Wawancara, Rekap Presensi, Hasil Asesmen
     */
    public function get_penilaian_assessmen()
    {
        $unit  = $this->input->post('unit');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');

        if (empty($tahun)) {
            $tahun = date('Y');
        }

        // â”€â”€ Tentukan range bulan berdasarkan semester â”€â”€
        $nama_bulan_map = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April',   5 => 'Mei',      6 => 'Juni',
            7 => 'Juli',    8 => 'Agustus',   9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        if (!empty($bulan)) {
            $bln = (int)$bulan;
            if ($bln >= 1 && $bln <= 6) {
                $month_start = 1;
                $month_end   = 6;
            } else {
                $month_start = 7;
                $month_end   = 12;
            }
        } else {
            $month_start = 1;
            $month_end   = 12;
        }

        $tahun_int = (int)$tahun;
        $date_start = sprintf('%04d-%02d-01', $tahun_int, $month_start);
        $date_end   = date('Y-m-t', strtotime(sprintf('%04d-%02d-01', $tahun_int, $month_end)));

        $range_label = $nama_bulan_map[$month_start] . ' - ' . $nama_bulan_map[$month_end] . ' ' . $tahun;

        // â”€â”€ Helper: SQL condition unit â”€â”€
        $unit_cond_user = "";
        $unit_cond_wfp  = "";
        if (!empty($unit)) {
            if (strpos($unit, ',') !== false) {
                $unit_array = array_map('intval', explode(',', $unit));
                $unit_in = implode(',', $unit_array);
                $unit_cond_user = " AND u.unit_kerja IN ($unit_in)";
                $unit_cond_wfp  = " AND wfp.id_unit IN ($unit_in)";
            } else {
                $uid = (int)$unit;
                $unit_cond_user = " AND u.unit_kerja = $uid";
                $unit_cond_wfp  = " AND wfp.id_unit = $uid";
            }
        }

        // â”€â”€ Helper: SQL keterlambatan (sama dengan Hasil_asesmen_mod) â”€â”€
        $isLateSql = "
            (rp.attendance_code IN ('H', 'T') OR rp.attendance_code = '' OR rp.attendance_code IS NULL)
            AND rp.attendance_code != 'TAP'
            AND rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-'
            AND rp.check_out IS NOT NULL AND rp.check_out != '' AND rp.check_out != '-'
            AND (
                ((LOWER(rp.shift) LIKE '%pagi%' OR rp.schedule_in LIKE '08:%' OR rp.schedule_in = '08:00') AND (rp.check_in > '08:10:59' OR rp.check_in >= '08:11'))
                OR
                ((LOWER(rp.shift) LIKE '%malam%' OR rp.schedule_in LIKE '20:%' OR rp.schedule_in = '20:00') AND (rp.check_in > '20:10:59' OR rp.check_in >= '20:11'))
                OR
                (LOWER(rp.shift) NOT LIKE '%pagi%' AND LOWER(rp.shift) NOT LIKE '%malam%' AND rp.schedule_in NOT LIKE '08:%' AND rp.schedule_in NOT LIKE '20:%' AND rp.schedule_in IS NOT NULL AND rp.schedule_in != '' AND rp.check_in > ADDTIME(rp.schedule_in, '00:10:00'))
            )
        ";

        $cutiCodes = "'CTP', 'CL', 'CIU', 'CM', 'IMIK', 'TGS', 'CH', 'CMA', 'CKA', 'CBA', 'CKM', 'CRM', 'CK', 'CIH', 'CKTN', 'CTSPB', 'CTPDP', 'I'";

        // â”€â”€ 1. Ambil daftar user yang relevan â”€â”€
        $sql_users = "
            SELECT u.id as user_id
            FROM user u
            WHERE u.type_user NOT IN (2, 4, 99, 5, 6, 104, 105, 106, 108)
              AND u.status != 8
              $unit_cond_user
        ";
        $users = $this->db->query($sql_users)->result_array();

        if (empty($users)) {
            echo json_encode([
                'status' => 'success',
                'range_label' => $range_label,
                'cbt'      => ['red' => 0, 'yellow' => 0, 'green' => 0, 'total' => 0],
                'wwc'      => ['red' => 0, 'yellow' => 0, 'green' => 0, 'total' => 0],
                'presensi' => ['red' => 0, 'yellow' => 0, 'green' => 0, 'total' => 0],
                'hasil_asesmen' => ['red' => 0, 'yellow' => 0, 'green' => 0, 'total' => 0]
            ]);
            return;
        }

        $user_ids = array_column($users, 'user_id');
        $user_ids_str = implode(',', $user_ids);

        // â”€â”€ 2. CBT: avg nilai per user dalam range semester â”€â”€
        $sql_cbt = "
            SELECT h.id_user,
                   ROUND(AVG(h.nilai), 2) as avg_nilai
            FROM cbt_hasil_ujian h
            WHERE h.status = 1
              AND h.id_user IN ($user_ids_str)
              AND COALESCE(h.tanggal_selesai, h.tanggal_mulai) >= '$date_start 00:00:00'
              AND COALESCE(h.tanggal_selesai, h.tanggal_mulai) <= '$date_end 23:59:59'
            GROUP BY h.id_user
        ";
        $cbt_rows = $this->db->query($sql_cbt)->result_array();

        $cbt_dist = ['red' => 0, 'yellow' => 0, 'green' => 0, 'total' => count($cbt_rows)];
        $cbt_map = [];
        foreach ($cbt_rows as $c) {
            $val = (float)$c['avg_nilai'];
            $cbt_map[$c['id_user']] = $val;
            if ($val <= 40) $cbt_dist['red']++;
            elseif ($val <= 74) $cbt_dist['yellow']++;
            else $cbt_dist['green']++;
        }

        // â”€â”€ 3. WWC: avg total_nilai per user dalam range semester â”€â”€
        $sql_wwc = "
            SELECT p.id_peserta as user_id,
                   ROUND(AVG(p.total_nilai), 2) as avg_nilai
            FROM wwc_penilaian p
            LEFT JOIN wwc_form_penilaian wfp ON wfp.id_form = p.id_form
            WHERE p.id_peserta IN ($user_ids_str)
              AND wfp.tanggal_penilaian >= '$date_start'
              AND wfp.tanggal_penilaian <= '$date_end'
              $unit_cond_wfp
            GROUP BY p.id_peserta
        ";
        $wwc_rows = $this->db->query($sql_wwc)->result_array();

        $wwc_dist = ['red' => 0, 'yellow' => 0, 'green' => 0, 'total' => count($wwc_rows)];
        $wwc_map = [];
        foreach ($wwc_rows as $w) {
            $val = (float)$w['avg_nilai'];
            $wwc_map[$w['user_id']] = $val;
            if ($val <= 40) $wwc_dist['red']++;
            elseif ($val <= 74) $wwc_dist['yellow']++;
            else $wwc_dist['green']++;
        }

        // â”€â”€ 4. Presensi: skor presensi per user dalam range semester â”€â”€
        $sql_pres = "
            SELECT rp.user_id,
                   COUNT(rp.id) as total_record,
                   SUM(CASE 
                       WHEN (
                           ((rp.attendance_code IN ('H', 'T') OR (rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-'))
                            AND (rp.check_out IS NOT NULL AND rp.check_out != '' AND rp.check_out != '-'))
                           OR rp.attendance_code = 'TAP'
                           OR (
                               (LOWER(rp.shift) NOT LIKE '%off%' AND LOWER(rp.shift) NOT LIKE '%dayoff%' AND LOWER(rp.shift) NOT LIKE '%libur%')
                               AND (rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-')
                               AND (rp.check_out IS NULL OR rp.check_out = '' OR rp.check_out = '-')
                           )
                           OR rp.attendance_code IN ($cutiCodes, 'S')
                       )
                       AND (rp.attendance_code IS NULL OR rp.attendance_code NOT IN ('A', 'UL'))
                       AND NOT (
                           (LOWER(rp.shift) LIKE '%off%' OR LOWER(rp.shift) LIKE '%dayoff%' OR LOWER(rp.shift) LIKE '%libur%')
                           AND (rp.attendance_code = '' OR rp.attendance_code IS NULL)
                           AND (rp.check_in IS NULL OR rp.check_in = '' OR rp.check_in = '-')
                           AND (rp.check_out IS NULL OR rp.check_out = '' OR rp.check_out = '-')
                       )
                       THEN 1 ELSE 0 END) as total_hadir,
                   SUM(CASE WHEN $isLateSql THEN 1 ELSE 0 END) as total_terlambat,
                   SUM(CASE 
                       WHEN (LOWER(rp.shift) LIKE '%off%' OR LOWER(rp.shift) LIKE '%dayoff%' OR LOWER(rp.shift) LIKE '%libur%') 
                            OR (
                                (rp.attendance_code = '' OR rp.attendance_code IS NULL) 
                                AND (rp.check_in IS NULL OR rp.check_in = '' OR rp.check_in = '-') 
                                AND (rp.check_out IS NULL OR rp.check_out = '' OR rp.check_out = '-')
                            )
                       THEN 1 ELSE 0 END) as total_off
            FROM rekap_presensi rp
            WHERE rp.user_id IN ($user_ids_str)
              AND rp.date >= '$date_start' AND rp.date <= '$date_end'
            GROUP BY rp.user_id
        ";
        $pres_rows = $this->db->query($sql_pres)->result_array();

        $pres_dist = ['red' => 0, 'yellow' => 0, 'green' => 0, 'total' => count($pres_rows)];
        $pres_map = [];
        foreach ($pres_rows as $p) {
            $t_rec   = (int)$p['total_record'];
            $t_off   = (int)$p['total_off'];
            $t_hadir = (int)$p['total_hadir'];
            $t_late  = (int)$p['total_terlambat'];

            $hari_efektif = max(0, $t_rec - $t_off);
            $pct_hadir = ($hari_efektif > 0) ? min(100, max(0, round(($t_hadir / $hari_efektif) * 100, 1))) : 0;
            $pct_tepat = ($t_hadir > 0) ? min(100, max(0, round((($t_hadir - $t_late) / $t_hadir) * 100, 1))) : 0;
            $skor = round(($pct_hadir + $pct_tepat) / 2, 1);

            $pres_map[$p['user_id']] = $skor;
            if ($skor <= 40) $pres_dist['red']++;
            elseif ($skor <= 74) $pres_dist['yellow']++;
            else $pres_dist['green']++;
        }

        // â”€â”€ 5. Hasil Asesmen: rata-rata (CBT + WWC + Presensi) / 3 per user â”€â”€
        // Hanya user yang punya minimal 1 data dari CBT/WWC/Presensi
        $all_user_ids_with_data = array_unique(array_merge(
            array_keys($cbt_map),
            array_keys($wwc_map),
            array_keys($pres_map)
        ));

        $hasil_dist = ['red' => 0, 'yellow' => 0, 'green' => 0, 'total' => count($all_user_ids_with_data)];
        foreach ($all_user_ids_with_data as $uid) {
            $val_cbt  = $cbt_map[$uid] ?? 0;
            $val_wwc  = $wwc_map[$uid] ?? 0;
            $val_pres = $pres_map[$uid] ?? 0;
            $total_asesmen = round(($val_cbt + $val_wwc + $val_pres) / 3, 2);

            if ($total_asesmen <= 40) $hasil_dist['red']++;
            elseif ($total_asesmen <= 74) $hasil_dist['yellow']++;
            else $hasil_dist['green']++;
        }

        echo json_encode([
            'status'        => 'success',
            'range_label'   => $range_label,
            'cbt'           => $cbt_dist,
            'wwc'           => $wwc_dist,
            'presensi'      => $pres_dist,
            'hasil_asesmen' => $hasil_dist
        ]);
    }

    /**
     * CARD 5: Peringkat Personil (Top 5 vs Bottom 5)
     * 4 Tab: CBT, Wawancara, Rekap Presensi, Hasil Asesmen
     * Menampilkan 5 orang teratas dan 5 orang terbawah per kategori
     */
    public function get_top_bottom_assessmen()
    {
        $unit  = $this->input->post('unit');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');

        if (empty($tahun)) {
            $tahun = date('Y');
        }

        // ── Tentukan range bulan berdasarkan semester ──
        $nama_bulan_map = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April',   5 => 'Mei',      6 => 'Juni',
            7 => 'Juli',    8 => 'Agustus',   9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        if (!empty($bulan)) {
            $bln = (int)$bulan;
            if ($bln >= 1 && $bln <= 6) {
                $month_start = 1;
                $month_end   = 6;
            } else {
                $month_start = 7;
                $month_end   = 12;
            }
        } else {
            $month_start = 1;
            $month_end   = 12;
        }

        $tahun_int = (int)$tahun;
        $date_start = sprintf('%04d-%02d-01', $tahun_int, $month_start);
        $date_end   = date('Y-m-t', strtotime(sprintf('%04d-%02d-01', $tahun_int, $month_end)));

        $range_label = $nama_bulan_map[$month_start] . ' - ' . $nama_bulan_map[$month_end] . ' ' . $tahun;

        // ── Helper: SQL condition unit ──
        $unit_cond_user = "";
        $unit_cond_wfp  = "";
        if (!empty($unit)) {
            if (strpos($unit, ',') !== false) {
                $unit_array = array_map('intval', explode(',', $unit));
                $unit_in = implode(',', $unit_array);
                $unit_cond_user = " AND u.unit_kerja IN ($unit_in)";
                $unit_cond_wfp  = " AND wfp.id_unit IN ($unit_in)";
            } else {
                $uid = (int)$unit;
                $unit_cond_user = " AND u.unit_kerja = $uid";
                $unit_cond_wfp  = " AND wfp.id_unit = $uid";
            }
        }

        // ── Helper: SQL keterlambatan ──
        $isLateSql = "
            (rp.attendance_code IN ('H', 'T') OR rp.attendance_code = '' OR rp.attendance_code IS NULL)
            AND rp.attendance_code != 'TAP'
            AND rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-'
            AND rp.check_out IS NOT NULL AND rp.check_out != '' AND rp.check_out != '-'
            AND (
                ((LOWER(rp.shift) LIKE '%pagi%' OR rp.schedule_in LIKE '08:%' OR rp.schedule_in = '08:00') AND (rp.check_in > '08:10:59' OR rp.check_in >= '08:11'))
                OR
                ((LOWER(rp.shift) LIKE '%malam%' OR rp.schedule_in LIKE '20:%' OR rp.schedule_in = '20:00') AND (rp.check_in > '20:10:59' OR rp.check_in >= '20:11'))
                OR
                (LOWER(rp.shift) NOT LIKE '%pagi%' AND LOWER(rp.shift) NOT LIKE '%malam%' AND rp.schedule_in NOT LIKE '08:%' AND rp.schedule_in NOT LIKE '20:%' AND rp.schedule_in IS NOT NULL AND rp.schedule_in != '' AND rp.check_in > ADDTIME(rp.schedule_in, '00:10:00'))
            )
        ";

        $cutiCodes = "'CTP', 'CL', 'CIU', 'CM', 'IMIK', 'TGS', 'CH', 'CMA', 'CKA', 'CBA', 'CKM', 'CRM', 'CK', 'CIH', 'CKTN', 'CTSPB', 'CTPDP', 'I'";

        // ── 1. Ambil data personil ──
        $sql_users = "
            SELECT u.id as user_id, u.nik, u.nama,
                   COALESCE(NULLIF(u.jabatan, ''), r.name_role, '-') as nama_jabatan,
                   COALESCE(un.name_unit, '-') as name_unit
            FROM user u
            LEFT JOIN unit un ON un.id_unit = u.unit_kerja
            LEFT JOIN role r ON r.id = u.type_user
            WHERE u.type_user NOT IN (2, 4, 99, 5, 6, 104, 105, 106, 108)
              AND u.status != 8
              $unit_cond_user
        ";
        $users = $this->db->query($sql_users)->result_array();

        if (empty($users)) {
            echo json_encode([
                'status'        => 'success',
                'range_label'   => $range_label,
                'cbt'           => ['top' => [], 'bottom' => []],
                'wwc'           => ['top' => [], 'bottom' => []],
                'presensi'      => ['top' => [], 'bottom' => []],
                'hasil_asesmen' => ['top' => [], 'bottom' => []]
            ]);
            return;
        }

        $user_ids = array_column($users, 'user_id');
        $user_ids_str = implode(',', $user_ids);
        $user_meta = [];
        foreach ($users as $u) {
            $user_meta[$u['user_id']] = [
                'user_id'      => $u['user_id'],
                'nik'          => $u['nik'],
                'nama'         => $u['nama'],
                'nama_jabatan' => $u['nama_jabatan'],
                'name_unit'    => $u['name_unit']
            ];
        }

        // ── 2. CBT ──
        $sql_cbt = "
            SELECT h.id_user,
                   ROUND(AVG(h.nilai), 2) as avg_nilai
            FROM cbt_hasil_ujian h
            WHERE h.status = 1
              AND h.id_user IN ($user_ids_str)
              AND COALESCE(h.tanggal_selesai, h.tanggal_mulai) >= '$date_start 00:00:00'
              AND COALESCE(h.tanggal_selesai, h.tanggal_mulai) <= '$date_end 23:59:59'
            GROUP BY h.id_user
        ";
        $cbt_rows = $this->db->query($sql_cbt)->result_array();
        $cbt_list = [];
        $cbt_map = [];
        foreach ($cbt_rows as $c) {
            $uid = $c['id_user'];
            $val = (float)$c['avg_nilai'];
            $cbt_map[$uid] = $val;
            if (isset($user_meta[$uid])) {
                $cbt_list[] = array_merge($user_meta[$uid], ['nilai' => $val]);
            }
        }

        // ── 3. WWC ──
        $sql_wwc = "
            SELECT p.id_peserta as user_id,
                   ROUND(AVG(p.total_nilai), 2) as avg_nilai
            FROM wwc_penilaian p
            LEFT JOIN wwc_form_penilaian wfp ON wfp.id_form = p.id_form
            WHERE p.id_peserta IN ($user_ids_str)
              AND wfp.tanggal_penilaian >= '$date_start'
              AND wfp.tanggal_penilaian <= '$date_end'
              $unit_cond_wfp
            GROUP BY p.id_peserta
        ";
        $wwc_rows = $this->db->query($sql_wwc)->result_array();
        $wwc_list = [];
        $wwc_map = [];
        foreach ($wwc_rows as $w) {
            $uid = $w['user_id'];
            $val = (float)$w['avg_nilai'];
            $wwc_map[$uid] = $val;
            if (isset($user_meta[$uid])) {
                $wwc_list[] = array_merge($user_meta[$uid], ['nilai' => $val]);
            }
        }

        // ── 4. Presensi ──
        $sql_pres = "
            SELECT rp.user_id,
                   COUNT(rp.id) as total_record,
                   SUM(CASE 
                       WHEN (
                           ((rp.attendance_code IN ('H', 'T') OR (rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-'))
                            AND (rp.check_out IS NOT NULL AND rp.check_out != '' AND rp.check_out != '-'))
                           OR rp.attendance_code = 'TAP'
                           OR (
                               (LOWER(rp.shift) NOT LIKE '%off%' AND LOWER(rp.shift) NOT LIKE '%dayoff%' AND LOWER(rp.shift) NOT LIKE '%libur%')
                               AND (rp.check_in IS NOT NULL AND rp.check_in != '' AND rp.check_in != '-')
                               AND (rp.check_out IS NULL OR rp.check_out = '' OR rp.check_out = '-')
                           )
                           OR rp.attendance_code IN ($cutiCodes, 'S')
                       )
                       AND (rp.attendance_code IS NULL OR rp.attendance_code NOT IN ('A', 'UL'))
                       AND NOT (
                           (LOWER(rp.shift) LIKE '%off%' OR LOWER(rp.shift) LIKE '%dayoff%' OR LOWER(rp.shift) LIKE '%libur%')
                           AND (rp.attendance_code = '' OR rp.attendance_code IS NULL)
                           AND (rp.check_in IS NULL OR rp.check_in = '' OR rp.check_in = '-')
                           AND (rp.check_out IS NULL OR rp.check_out = '' OR rp.check_out = '-')
                       )
                       THEN 1 ELSE 0 END) as total_hadir,
                   SUM(CASE WHEN $isLateSql THEN 1 ELSE 0 END) as total_terlambat,
                   SUM(CASE 
                       WHEN (LOWER(rp.shift) LIKE '%off%' OR LOWER(rp.shift) LIKE '%dayoff%' OR LOWER(rp.shift) LIKE '%libur%') 
                            OR (
                                (rp.attendance_code = '' OR rp.attendance_code IS NULL) 
                                AND (rp.check_in IS NULL OR rp.check_in = '' OR rp.check_in = '-') 
                                AND (rp.check_out IS NULL OR rp.check_out = '' OR rp.check_out = '-')
                            )
                       THEN 1 ELSE 0 END) as total_off
            FROM rekap_presensi rp
            WHERE rp.user_id IN ($user_ids_str)
              AND rp.date >= '$date_start' AND rp.date <= '$date_end'
            GROUP BY rp.user_id
        ";
        $pres_rows = $this->db->query($sql_pres)->result_array();
        $pres_list = [];
        $pres_map = [];
        foreach ($pres_rows as $p) {
            $uid = $p['user_id'];
            $t_rec   = (int)$p['total_record'];
            $t_off   = (int)$p['total_off'];
            $t_hadir = (int)$p['total_hadir'];
            $t_late  = (int)$p['total_terlambat'];

            $hari_efektif = max(0, $t_rec - $t_off);
            $pct_hadir = ($hari_efektif > 0) ? min(100, max(0, round(($t_hadir / $hari_efektif) * 100, 1))) : 0;
            $pct_tepat = ($t_hadir > 0) ? min(100, max(0, round((($t_hadir - $t_late) / $t_hadir) * 100, 1))) : 0;
            $skor = round(($pct_hadir + $pct_tepat) / 2, 1);

            $pres_map[$uid] = $skor;
            if (isset($user_meta[$uid])) {
                $pres_list[] = array_merge($user_meta[$uid], ['nilai' => $skor]);
            }
        }

        // ── 5. Hasil Asesmen ──
        $all_uids = array_unique(array_merge(
            array_keys($cbt_map),
            array_keys($wwc_map),
            array_keys($pres_map)
        ));
        $hasil_list = [];
        foreach ($all_uids as $uid) {
            $val_cbt  = $cbt_map[$uid] ?? 0;
            $val_wwc  = $wwc_map[$uid] ?? 0;
            $val_pres = $pres_map[$uid] ?? 0;
            $total_asesmen = round(($val_cbt + $val_wwc + $val_pres) / 3, 2);
            if (isset($user_meta[$uid])) {
                $hasil_list[] = array_merge($user_meta[$uid], ['nilai' => $total_asesmen]);
            }
        }

        // ── Helper sort Top 5 (Nilai 75-100) and Bottom 5 (Nilai 0-40) ──
        $get_top_bottom = function($list) {
            if (empty($list)) {
                return ['top' => [], 'bottom' => []];
            }

            // Top 5: hanya personil dengan nilai >= 75 (range 75 - 100), sort DESC
            $list_top = array_values(array_filter($list, function($item) {
                return isset($item['nilai']) && (float)$item['nilai'] >= 75;
            }));
            usort($list_top, function($a, $b) {
                if ($b['nilai'] == $a['nilai']) return 0;
                return ($b['nilai'] < $a['nilai']) ? -1 : 1;
            });
            $top = array_slice($list_top, 0, 5);

            // Bottom 5: hanya personil dengan nilai <= 40 (range 0 - 40), sort ASC
            $list_bottom = array_values(array_filter($list, function($item) {
                return isset($item['nilai']) && (float)$item['nilai'] <= 40;
            }));
            usort($list_bottom, function($a, $b) {
                if ($a['nilai'] == $b['nilai']) return 0;
                return ($a['nilai'] < $b['nilai']) ? -1 : 1;
            });
            $bottom = array_slice($list_bottom, 0, 5);

            return ['top' => $top, 'bottom' => $bottom];
        };

        echo json_encode([
            'status'        => 'success',
            'range_label'   => $range_label,
            'cbt'           => $get_top_bottom($cbt_list),
            'wwc'           => $get_top_bottom($wwc_list),
            'presensi'      => $get_top_bottom($pres_list),
            'hasil_asesmen' => $get_top_bottom($hasil_list)
        ]);
    }
}

