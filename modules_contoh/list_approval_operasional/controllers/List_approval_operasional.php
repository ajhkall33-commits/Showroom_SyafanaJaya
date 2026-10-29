<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class List_approval_operasional extends CI_Controller {

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
        $data["title"]     = "List Approval Operasional";
        $data["title_des"] = "Approval Operasional";
        $data["content"]   = "v_index";
        $data["data"]      = $data;
        $this->load->view('template_v2', $data);
    }

    // =====================================================================
    // LoadData — ambil data operasional status 1 dan 9
    // =====================================================================
    public function LoadData($input = null) {
        $limit = isset($_POST['limit']) ? $_POST['limit'] : 10;
        $src   = isset($_POST['src'])   ? $_POST['src']   : '';
        $from             = $this->uri->segment(3) ? $this->uri->segment(3) : 0;

        $start_date = $this->input->post('tanggal'); // filter dari UI
        $filter_fasilitas = $this->input->post('filter_fasilitas');
        // SK Manager: filter unit dinamis berdasarkan pilihan dropdown atau semua unit yang dikelola
        $unit_filter_sql = get_unit_filter_sql('filter_unit');
        
        $query = "
            SELECT o.*, 
                u.name_unit,
                COUNT(od.id_operasional_detail) as jumlah_detail
            FROM operasional o
            LEFT JOIN unit u ON u.id_unit = o.id_unit
            LEFT JOIN operasional_detail od ON od.id_operasional = o.id_operasional AND od.status != 8
            WHERE o.status IN (1, 9)
            AND o.id_unit $unit_filter_sql
        ";
         
        if (!empty($start_date)) {
            $query .= " AND DATE(o.tanggal) = '" . $this->db->escape_str($start_date) . "'";
        } 
        if (!empty($src)) {
            $query .= " AND (o.nomor LIKE '%" . $this->db->escape_str($src) . "%')";
        }
        
        $query .= " GROUP BY o.id_operasional";
        
        // Count total
        $totalData = $this->db->query($query)->num_rows();

        $query .= " ORDER BY o.id_operasional DESC LIMIT $limit OFFSET $from";
        
        $data = $this->Mod->GetCustome($query)->result_array();

        foreach ($data as $key => $value) {
            if (function_exists('Hari_') && function_exists('tgl')) {
                $data[$key]['tanggal_label'] = Hari_($value['tanggal']) . ' ' . tgl($value['tanggal'], 'sm');
            } else {
                $data[$key]['tanggal_label'] = $value['tanggal'];
            }
            
            if (empty($value['nomor'])) {
                $data[$key]['nomor'] = 'OPR-' . date('Ymd', strtotime($value['tanggal'])) . '-' . str_pad($value['id_operasional'], 4, '0', STR_PAD_LEFT);
            }
            $data[$key]['status_label'] = sts('4', $value['status']);
        }

        $data = array_values($data);

        $response = array(
            'data' => $data,
            'pag'  => array(
                'start' => $from + 1,
                'label' => 'Showing ' . (count($data) > 0 ? $from + 1 : 0) . ' to ' . ($from + count($data)) . ' of ' . $totalData . ' entries'
            ),
            'selected_tanggal'   => $start_date,
            'selected_fasilitas' => $filter_fasilitas,
            'total_data'         => $totalData
        );

        echo json_encode($response);
    }

    // =====================================================================
    // Approve — operasional status = 9, isi pengawas
    // =====================================================================
    public function Approve($id = null) {
        if (empty($id)) {
            echo json_encode(['code' => '500', 'msg' => 'ID tidak valid']);
            return;
        }

        $result = $this->Mod->update2('operasional', array('id_operasional' => $id), array(
            'status'  => 9,
            'pengawas' => sess()['nama']
        ));

        if ($result) {
            $this->Mod->update2('operasional_detail', array('id_operasional' => $id), array('status' => 9));
            $response = ['code' => '200', 'msg' => 'Data berhasil di-approve'];
        } else {
            $response = ['code' => '500', 'msg' => 'Gagal approve data'];
        }

        echo json_encode($response);
    }

    // =====================================================================
    // Reject — operasional status = 0, detail status = 2
    // =====================================================================
    public function Reject($id = null) {
        if (empty($id)) {
            echo json_encode(['code' => '500', 'msg' => 'ID tidak valid']);
            return;
        }

        $result = $this->Mod->update2('operasional', array('id_operasional' => $id), array('status' => 0));

        if ($result) {
            $this->Mod->update2('operasional_detail', array('id_operasional' => $id), array('status' => 2));
            $response = ['code' => '200', 'msg' => 'Data berhasil di-reject'];
        } else {
            $response = ['code' => '500', 'msg' => 'Gagal reject data'];
        }

        echo json_encode($response);
    }

    // =====================================================================
    // DeleteData — operasional status = 8, detail status = 1
    // =====================================================================
    public function DeleteData($id = null) {
        if (empty($id)) {
            echo json_encode(['code' => '500', 'msg' => 'ID tidak valid']);
            return;
        }

        $result = $this->Mod->update2('operasional', array('id_operasional' => $id), array('status' => 8));
        
        if ($result) {
            $this->db->set('status', 1);
            $this->db->set('id_operasional', 'NULL', FALSE);
            $this->db->where('id_operasional', $id);
            $this->db->update('operasional_detail');
            
            $response = ['code' => '200', 'msg' => 'Data berhasil dihapus'];
        } else {
            $response = ['code' => '500', 'msg' => 'Gagal hapus data'];
        }

        echo json_encode($response);
    }

    // =====================================================================
    // SaveTtdApi — simpan PNG ke doc/ttd_operasional/{id_unit}/API/
    // =====================================================================
    public function SaveTtdApi() {
        $id_operasional = $this->input->post('id_operasional');
        $id_unit    = $this->input->post('id_unit');
        $image_data = $this->input->post('image_data');

        if (empty($id_operasional) || empty($id_unit) || empty($image_data)) {
            echo json_encode(['code' => '500', 'msg' => 'Data tidak lengkap']);
            return;
        }

        $folder = './doc/ttd_operasional/' . $id_unit . '/API/';
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $now      = date('Ymd_His');
        $filename = 'API_Pengawas_' . date('Y-m-d') . '_' . date('H-i-s') . '.png';

        $image_clean = str_replace('data:image/png;base64,', '', $image_data);
        $image_clean = str_replace(' ', '+', $image_clean);
        $decoded     = base64_decode($image_clean);

        if ($decoded === false || strlen($decoded) < 100) {
            echo json_encode(['code' => '500', 'msg' => 'Data gambar tidak valid']);
            return;
        }

        file_put_contents($folder . $filename, $decoded);
        $this->Mod->update2('operasional', ['id_operasional' => $id_operasional], ['ttd_api' => $filename]);

        echo json_encode(['code' => '200', 'msg' => 'TTD API berhasil disimpan', 'filename' => $filename]);
    }

    // =====================================================================
    // Print — redirect ke operasional PrintData
    // =====================================================================
    public function PrintData($id = null) {
        redirect(base_url('operasional/PrintData/' . $id));
    }

    public function PrintData2($id = null) {
        redirect(base_url('operasional/PrintData2/' . $id));
    }
     public function PrintData3($id = null) {
        redirect(base_url('operasional/PrintData3/' . $id));
    }

    // =====================================================================
    // ViewData — JSON detail untuk modal
    // =====================================================================
    public function ViewData($id = null) {
        if (!empty($id)) {
            $header = $this->Mod->getWhere('operasional', array('id_operasional' => $id))->row_array();
            if (empty($header)) {
                echo json_encode(['code' => '404', 'msg' => 'Data tidak ditemukan', 'data' => []]);
                return;
            }

            if (empty($header['nomor'])) {
                $header['nomor'] = 'OPR-' . date('Ymd', strtotime($header['tanggal'])) . '-' . str_pad($header['id_operasional'], 4, '0', STR_PAD_LEFT);
            }
            $header['tanggal_f'] = tgl($header['tanggal'], 'l');
            
            $detail = $this->Mod->GetCustome("SELECT * FROM operasional_detail WHERE id_operasional = $id AND status != 8")->result_array();

            $header['detail'] = $detail;
            $header['status_label'] = sts('4', $header['status']);

            echo json_encode(['code' => '200', 'msg' => 'OK', 'data' => $header]);
        } else {
            echo json_encode(['code' => '404', 'msg' => 'ID tidak valid', 'data' => []]);
        }
    }
}