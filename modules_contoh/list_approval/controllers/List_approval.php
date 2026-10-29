<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class List_approval extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("m_data");
        $this->role();
    }

    private function role() {
        if (session("username") == "") {
            redirect(base_url('login/auth'));
        }
    }

    public function index() {
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"]     = "List Approval WO";
        $data["title_des"] = "Work Order (Job Report)";
        $data["content"]   = "v_index";
        $data["data"]      = $data;
        $this->load->view('template_v2', $data);
    }

    // =====================================================================
    // LoadData — ambil WO status 1 dan 9
    // =====================================================================
    public function LoadData($input = null) {
        $limit = isset($_POST['limit']) ? $_POST['limit'] : 10;
        $src   = isset($_POST['src'])   ? $_POST['src']   : '';

        $tanggal          = $this->input->post('tanggal');
        $filter_fasilitas = $this->input->post('filter_fasilitas');
        $from             = $this->uri->segment(3);
        $unit_id          = sess()['unit'];

        // SK Manager: jika role terdaftar di role_sk_manager, tampilkan data dari unit yang dipilih/semua unit
        $filter_unit = $this->input->post('filter_unit');
        if (is_sk_manager()) {
            $sk_units = get_allowed_units();
            if (!empty($filter_unit) && in_array((int)$filter_unit, $sk_units)) {
                $this->db->where('wo.id_unit', (int)$filter_unit);
            } else if (!empty($sk_units)) {
                $this->db->where_in('wo.id_unit', $sk_units);
            } else {
                $this->db->where('wo.id_unit', $unit_id);
            }
        } else {
            $this->db->where('wo.id_unit', $unit_id);
        }

        $this->db->select('
            wo.id_wo,
            wo.no_wo,
            wo.klasifikasi,
            wo.tanggal,
            wo.team,
            wo.pelaksana,
            wo.status,
            wo.id_unit,
            wo.ttd_api,
            pm_type.name_pm,
            fasilitas.nama_fasilitas,
            fasilitas.terminal
        ');
        $this->db->from('wo');
        $this->db->join('wo_detail', 'wo_detail.id_wo = wo.id_wo', 'left');
        $this->db->join('pm', 'pm.id_pmheader = wo_detail.id_pmheader', 'left');
        $this->db->join('fasilitas', 'fasilitas.id_fasilitas = pm.id_fasilitas', 'left');
        $this->db->join('pm_type', 'pm_type.idpm_type = pm.idpm_type', 'left');

        $this->db->where_in('wo.status', [1, 9]);
        $this->db->where('YEAR(wo.tanggal)', 2026);

        if (!empty($tanggal)) {
            $this->db->where('DATE(wo.tanggal)', $tanggal);
        }
        if (!empty($src)) {
            $this->db->group_start();
            $this->db->like('wo.no_wo', $src);
            $this->db->group_end();
        }
        if (!empty($filter_fasilitas)) {
            $this->db->like('fasilitas.nama_fasilitas', $filter_fasilitas);
        }

        $this->db->group_by('wo.id_wo');
        $totalData = $this->db->count_all_results('', false);

        $this->db->limit($limit, $from);
        $this->db->order_by('wo.id_wo', 'DESC');

        $query = $this->db->get();
        $data  = $query->result_array();

        foreach ($data as $key => $value) {
            $data[$key]['status_label']  = sts('4', $value['status']);
            $data[$key]['tanggal_label'] = Hari_($value['tanggal']) . ' ' . tgl($value['tanggal'], 'sm');
        }

        $data = array_values($data);

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

    // =====================================================================
    // Approve — wo/pm/arahan status = 9, isi wo.pengawas
    // =====================================================================
    public function Approve($id = null) {
        if (empty($id)) {
            echo json_encode(['code' => '500', 'msg' => 'ID tidak valid']);
            return;
        }

        $wo = $this->Mod->getWhere('wo', array('id_wo' => $id))->row_array();
        if (empty($wo)) {
            echo json_encode(['code' => '500', 'msg' => 'Data WO tidak ditemukan']);
            return;
        }

        $result = $this->Mod->update2('wo', array('id_wo' => $id), array(
            'status'  => 9,
            'pengawas' => sess()['nama']
        ));

        if ($result) {
            // Update wo_detail
            $this->Mod->update2('wo_detail', array('id_wo' => $id), array('status' => 9));

            // Update pm
            $details = $this->Mod->getWhere('wo_detail', array('id_wo' => $id))->result_array();
            if (!empty($details)) {
                $pm_ids = array_column($details, 'id_pmheader');
                $this->db->where_in('id_pmheader', $pm_ids)->update('pm', array('status' => '9'));
            }

            // Update arahan
            if (!empty($wo['id_arahan'])) {
                $this->Mod->update2('arahan', array('id_arahan' => $wo['id_arahan']), array('status' => 9));
            }

            $response = ['code' => '200', 'msg' => 'Data berhasil di-approve'];
        } else {
            $response = ['code' => '500', 'msg' => 'Gagal approve data'];
        }

        echo json_encode($response);
    }

    // =====================================================================
    // Reject — wo status = 0, pm/arahan status = 2
    // =====================================================================
    public function Reject($id = null) {
        if (empty($id)) {
            echo json_encode(['code' => '500', 'msg' => 'ID tidak valid']);
            return;
        }

        $wo = $this->Mod->getWhere('wo', array('id_wo' => $id))->row_array();
        if (empty($wo)) {
            echo json_encode(['code' => '500', 'msg' => 'Data WO tidak ditemukan']);
            return;
        }

        $result = $this->Mod->update2('wo', array('id_wo' => $id), array('status' => 0));

        if ($result) {
            // Update wo_detail status = 0
            $this->Mod->update2('wo_detail', array('id_wo' => $id), array('status' => 0));

            // Update pm status = 2
            $details = $this->Mod->getWhere('wo_detail', array('id_wo' => $id))->result_array();
            if (!empty($details)) {
                $pm_ids = array_column($details, 'id_pmheader');
                $this->db->where_in('id_pmheader', $pm_ids)->update('pm', array('status' => '2'));
            }

            // Update arahan status = 2
            if (!empty($wo['id_arahan'])) {
                $this->Mod->update2('arahan', array('id_arahan' => $wo['id_arahan']), array('status' => 2));
            }

            $response = ['code' => '200', 'msg' => 'Data berhasil di-reject'];
        } else {
            $response = ['code' => '500', 'msg' => 'Gagal reject data'];
        }

        echo json_encode($response);
    }

    // =====================================================================
    // DeleteData — wo/wo_detail status = 8, pm/arahan status = 1
    // =====================================================================
    public function DeleteData($id = null) {
        if (empty($id)) {
            echo json_encode(['code' => '500', 'msg' => 'ID tidak valid']);
            return;
        }

        $wo      = $this->Mod->getWhere('wo', array('id_wo' => $id))->row_array();
        $details = $this->Mod->getWhere('wo_detail', array('id_wo' => $id))->result_array();

        $result = $this->Mod->update2('wo', array('id_wo' => $id), array('status' => 8));
        $this->Mod->update2('wo_detail', array('id_wo' => $id), array('status' => 8));

        if (!empty($details)) {
            $pm_ids = array_column($details, 'id_pmheader');
            $this->db->where_in('id_pmheader', $pm_ids)->update('pm', array('status' => '1'));
        }

        if (!empty($wo['id_arahan'])) {
            $this->Mod->update2('arahan', array('id_arahan' => $wo['id_arahan']), array('status' => 1));
        }

        if ($result) {
            $response = ['code' => '200', 'msg' => 'Data berhasil dihapus'];
        } else {
            $response = ['code' => '500', 'msg' => 'Gagal hapus data'];
        }

        echo json_encode($response);
    }

    // =====================================================================
    // SaveTtdApi — simpan PNG ke doc/ttd_preventive/{id_unit}/API/
    // =====================================================================
    public function SaveTtdApi() {
        $id_wo      = $this->input->post('id_wo');
        $id_unit    = $this->input->post('id_unit');
        $image_data = $this->input->post('image_data');

        if (empty($id_wo) || empty($id_unit) || empty($image_data)) {
            echo json_encode(['code' => '500', 'msg' => 'Data tidak lengkap']);
            return;
        }

        $folder = './doc/ttd_preventive/' . $id_unit . '/API/';
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $now      = date('Ymd_His');
        $filename = 'API_Pengawas_' . $id_wo . '_' . $now . '.png';

        $image_clean = str_replace('data:image/png;base64,', '', $image_data);
        $image_clean = str_replace(' ', '+', $image_clean);
        $decoded     = base64_decode($image_clean);

        if ($decoded === false || strlen($decoded) < 100) {
            echo json_encode(['code' => '500', 'msg' => 'Data gambar tidak valid']);
            return;
        }

        file_put_contents($folder . $filename, $decoded);
        $this->Mod->update2('wo', ['id_wo' => $id_wo], ['ttd_api' => $filename]);

        echo json_encode(['code' => '200', 'msg' => 'TTD API berhasil disimpan', 'filename' => $filename]);
    }

    // =====================================================================
    // Print — redirect ke ListWO PrintData (view yang sama)
    // =====================================================================
    public function PrintData($id = null) {
        redirect(base_url('listWO/PrintData/' . $id));
    }

    public function PrintData2($id = null) {
        redirect(base_url('listWO/PrintData2/' . $id));
    }
    public function PrintData3($id = null) {
        redirect(base_url('listWO/PrintData3/' . $id));
    }

    // =====================================================================
    // ViewData — JSON detail WO untuk modal
    // =====================================================================
    public function ViewData($id = null) {
        if (!empty($id)) {
            $header = $this->Mod->getWhere('wo', array('id_wo' => $id))->row_array();
            if (empty($header)) {
                echo json_encode(['code' => '404', 'msg' => 'Data tidak ditemukan', 'data' => []]);
                return;
            }

            $header['tanggal_f'] = tgl($header['tanggal'], 'l');
            $header['shift_l']   = l_sh($header['shift'] ?? '');

            $detail = $this->Mod->GetCustome("SELECT 
                a.*, 
                d.nama_fasilitas,
                d.terminal, 
                b.id_pmheader,
                pmt.name_pm
            FROM 
                wo_detail a 
            LEFT JOIN pm b ON b.id_pmheader = a.id_pmheader
            LEFT JOIN pm_detail c ON c.id_pmheader = b.id_pmheader
            LEFT JOIN fasilitas d ON d.id_fasilitas = c.id_fasilitas
            LEFT JOIN pm_type pmt ON pmt.idpm_type = b.idpm_type
            WHERE a.id_wo = $id
            GROUP BY a.id_wo, a.id_pmheader, a.status, d.nama_fasilitas, pmt.name_pm")->result_array();

            $header['name_pm']   = implode(', ', array_unique(array_filter(array_column($detail, 'name_pm'))));
            $header['peralatan'] = implode(' | ', array_unique(array_filter(array_column($detail, 'nama_fasilitas'))));
            $header['lokasi']    = implode(' | ', array_unique(array_filter(array_column($detail, 'terminal'))));
            $header['detail']    = $detail;

            echo json_encode(['code' => '200', 'msg' => 'OK', 'data' => $header]);
        } else {
            echo json_encode(['code' => '404', 'msg' => 'ID tidak valid', 'data' => []]);
        }
    }
}