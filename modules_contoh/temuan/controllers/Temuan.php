<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Temuan extends CI_Controller {

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
        $data["title"] = "Temuan Lapangan";
        $data["title_des"] = "Daftar Temuan";
        $data["content"] = "v_index";
        $data["data"] = $data;
        $this->load->view('template_v2', $data);
    }

    function LoadData() {
        $limit = isset($_POST['limit']) ? $_POST['limit'] : 3000;
        $src = isset($_POST['src']) ? $_POST['src'] : '';
        $tanggal = isset($_POST['tanggal']) ? $_POST['tanggal'] : '';
        $from = $this->uri->segment(3);

        $filter_unit = $this->input->post('filter_unit');
        $parameter = ['id_unit' => sess()['unit']];

        // SK Manager: jika role terdaftar di role_sk_manager, tampilkan data dari unit yang dipilih/semua unit
        if (is_sk_manager()) {
            $sk_units = get_allowed_units();
            if (!empty($filter_unit) && in_array((int)$filter_unit, $sk_units)) {
                $parameter['id_unit'] = (int)$filter_unit;
            } else if (!empty($sk_units)) {
                unset($parameter['id_unit']);
                $parameter['id_unit IN (' . implode(',', $sk_units) . ')'] = null;
            }
        }

        if (!empty($tanggal)) {
            $parameter['DATE(tanggal)'] = $tanggal;
        }

        // [REQ] Filter data berdasarkan tab status aktif (0 = Belum Diproses/Draft, 1 = Sedang Diproses, 2 = Sudah Ditindak Lanjut (status 2 & 9))
        $status_filter = $this->input->post('status_filter');
        if ($status_filter === '1') {
            $parameter['status'] = '1';
        } elseif ($status_filter === '2') {
            $parameter['status !='] = 8;
            $parameter['status != '] = '0';
            $parameter['status !=  '] = '1';
        } else {
            // Default ke status '0' (Belum Diproses / Draft)
            $parameter['status'] = '0';
        }

        $param = [
            'table' => 'temuan',
            'pk' => 'id_temuan',
            'parameter' => $parameter,
            'url' => $this->uri->segment(2),
            'from' => $from,
            'limit' => $limit,
            'src' => $src,
            'filter' => '',
            'param_src' => ['like' => 'uraian_kejadian']
        ];

        $data['url'] = $this->uri->segment(2);
        $totalData = CountDataPag($param);
        $param['total_data'] = $totalData;
        $param['total_page'] = ceil($totalData / $limit);
        $res = pagin($param);

        foreach ($res['data'] as $key => $value) {
            $res['data'][$key]['tanggal'] = tgl($value['tanggal'],'l');
            $res['data'][$key]['status_label'] = $this->custom_status_label($value['status']);

            $fasilitas = $this->m_data->getWhere('fasilitas', ['id_fasilitas' => $value['id_fasilitas']])->row_array();
            $res['data'][$key]['fasilitas'] = !empty($fasilitas) ? $fasilitas['nama_fasilitas'] : '';

            $detail_temuan = $this->m_data->getWhere('temuan_detail', ['id_temuan' => $value['id_temuan'], 'status !=' => 8])->result_array();
            $res['data'][$key]['detail_temuan'] = $detail_temuan;
            $res['data'][$key]['jumlah_perangkat'] = count($detail_temuan);

            $perangkat_names = [];
            foreach ($detail_temuan as $detail) {
                $perangkat = $this->m_data->getWhere('perangkat', ['id_perangkat' => $detail['id_perangkat']])->row_array();
                if (!empty($perangkat)) {
                    $perangkat_names[] = $perangkat['nama_perangkat'] ?? 'Perangkat';
                }
            }
            $res['data'][$key]['perangkat_list'] = implode(', ', $perangkat_names);

            // Ambil semua foto dari dokumentasi_temuan
            $dokumentasi = $this->m_data->getWhere('dokumentasi_temuan', ['id_temuan' => $value['id_temuan'], 'status !=' => 8])->result_array();
            $res['data'][$key]['dokumentasi'] = $dokumentasi;
        }

        $data['data'] = $res['data'];
        $data['pag'] = $res['pag'];

        echo json_encode($data);
    }

    function LoadFasilitasByUnit() {
        $id_unit = sess()['unit'];
        $fasilitas = $this->m_data->getWhere('fasilitas', ['id_unit' => $id_unit, 'status !=' => 8])->result_array();
        echo json_encode($fasilitas);
    }

    function LoadPerangkatByFasilitas($id_fasilitas = null) {
        if (!empty($id_fasilitas)) {
            $this->db->select('perangkat.*');
            $this->db->from('perangkat');
            $this->db->join('fasilitas_detail', 'fasilitas_detail.id_perangkat = perangkat.id_perangkat');
            $this->db->where('fasilitas_detail.id_fasilitas', $id_fasilitas);
            $this->db->where('fasilitas_detail.status !=', 8);
            $this->db->where('perangkat.status !=', 8);
            $this->db->where('perangkat.nama_perangkat IS NOT NULL');
            $this->db->where("TRIM(perangkat.nama_perangkat) !=", "");
            $this->db->where("LOWER(TRIM(perangkat.nama_perangkat)) !=", "listrik");
            $perangkat = $this->db->get()->result_array();
            echo json_encode($perangkat);
        } else {
            echo json_encode([]);
        }
    }

    /**
     * Endpoint AJAX: Mengisi rekomendasi form Temuan dari hasil scan barcode.
     * Dipanggil oleh temuan/views/v_index.php saat halaman dibuka dengan query ?auto_open=1.
     *
     * POST params:
     *   - type : 'fasilitas' | 'perangkat'
     *   - id   : integer (id_fasilitas atau id_perangkat)
     *
     * Response JSON:
     *   - code           : 200 | 404 | 400
     *   - id_fasilitas   : string
     *   - nama_fasilitas : string
     *   - perangkat_list : array [{ id_perangkat, nama_perangkat, serial_number }]
     *                      (sudah di-filter server-side: exclude nama persis 'listrik',
     *                       menggunakan pola WHERE yang sama dengan LoadPerangkatByFasilitas)
     */
    function otomatis_rekomendasi_scan()
    {
        $type = $this->input->post('type');
        $id   = $this->input->post('id');

        if ($type === 'fasilitas') {
            $fasilitas = $this->m_data->getWhere('fasilitas', ['id_fasilitas' => $id, 'status !=' => 8])->row_array();
            if (!$fasilitas) { echo json_encode(['code' => 404]); return; }

            // Single JOIN query — reuse pola WHERE dari LoadPerangkatByFasilitas + tambah serial_number
            $this->db->select('p.id_perangkat, p.nama_perangkat, p.serial_number');
            $this->db->from('perangkat p');
            $this->db->join('fasilitas_detail fd', 'fd.id_perangkat = p.id_perangkat');
            $this->db->where('fd.id_fasilitas', $id);
            $this->db->where('fd.status !=', 8);
            $this->db->where('p.status !=', 8);
            $this->db->where('p.nama_perangkat IS NOT NULL');
            $this->db->where("TRIM(p.nama_perangkat) !=", "");
            $this->db->where("LOWER(TRIM(p.nama_perangkat)) !=", "listrik");
            $perangkat_list = $this->db->get()->result_array();

            echo json_encode([
                'code'           => 200,
                'type'           => 'fasilitas',
                'id_fasilitas'   => $fasilitas['id_fasilitas'],
                'nama_fasilitas' => $fasilitas['nama_fasilitas'],
                'perangkat_list' => $perangkat_list
            ]);

        } elseif ($type === 'perangkat') {
            $perangkat = $this->m_data->getWhere('perangkat', ['id_perangkat' => $id, 'status !=' => 8])->row_array();
            $fas_det   = $this->m_data->getWhere('fasilitas_detail', ['id_perangkat' => $id, 'status !=' => 8])->row_array();

            if (!$perangkat || !$fas_det) { echo json_encode(['code' => 404]); return; }

            $fasilitas      = $this->m_data->getWhere('fasilitas', ['id_fasilitas' => $fas_det['id_fasilitas'], 'status !=' => 8])->row_array();
            $perangkat_list = [];

            // Hanya masukkan ke list jika nama perangkat bukan 'listrik'
            if (strtolower(trim($perangkat['nama_perangkat'])) !== 'listrik') {
                $perangkat_list = [[
                    'id_perangkat'   => $perangkat['id_perangkat'],
                    'nama_perangkat' => $perangkat['nama_perangkat'],
                    'serial_number'  => isset($perangkat['serial_number']) ? $perangkat['serial_number'] : '-'
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


    function EditData($id = null) {
        if (!empty($id)) {
            $temuan = $this->m_data->getWhere('temuan', ['id_temuan' => $id])->row_array();
            $detail_temuan = $this->m_data->getWhere('temuan_detail', ['id_temuan' => $id, 'status !=' => 8])->result_array();
            foreach ($detail_temuan as $key => $detail) {
                $perangkat = $this->m_data->getWhere('perangkat', ['id_perangkat' => $detail['id_perangkat']])->row_array();
                if (!empty($perangkat)) {
                    $detail_temuan[$key]['nama_perangkat'] = $perangkat['nama_perangkat'] ?? 'Perangkat';
                    $detail_temuan[$key]['kode_perangkat'] = $perangkat['kode_perangkat'] ?? '';
                }
            }
            $dokumentasi = $this->m_data->getWhere('dokumentasi_temuan', ['id_temuan' => $id, 'status !=' => 8])->result_array();
            $data = [
                'temuan' => $temuan,
                'detail_temuan' => $detail_temuan,
                'dokumentasi' => $dokumentasi
            ];
            echo json_encode($data);
        } else {
            echo json_encode(['error' => 'ID tidak ditemukan']);
        }
    }

    public function UpdateData($id = null) {
        if (empty($id)) {
            echo json_encode(['code' => '500', 'msg' => 'ID tidak ditemukan']);
            return;
        }
        
        $this->db->trans_start();

        // Ambil status saat ini untuk menjaga konsistensi status setelah edit
        $current_temuan = $this->m_data->getWhere('temuan', ['id_temuan' => $id])->row_array();
        $current_status = !empty($current_temuan) ? $current_temuan['status'] : '0';

        // [REQ] Ketika di-edit data, status disesuaikan dengan status saat ini (jika status = 1 tetap 1, jika status = 0 tetap 0)
        $update_temuan = [
            'nomor' => $this->input->post('nomor'),
            'kategori_kerusakan' => $this->input->post('kategori_kerusakan'),
            'analisis' => $this->input->post('analisis'),
            'kondisi' => $this->input->post('kondisi'),
            'tanggal' => str_replace('T', ' ', $this->input->post('tanggal')),
            'id_fasilitas' => $this->input->post('id_fasilitas'),
            'uraian_kejadian' => $this->input->post('uraian_kejadian'),
            'update_by' => sess()['id'],
            'update_date' => date('Y-m-d'),
            'status' => $current_status
        ];

        $this->db->where('id_temuan', $id);
        $this->db->update('temuan', $update_temuan);

        // Ubah status detail perangkat lama menjadi 8 (deleted)
        $this->db->where('id_temuan', $id);
        $this->db->update('temuan_detail', ['status' => 8]);

        if ($this->input->post('detail_temuan') && is_array($this->input->post('detail_temuan'))) {
            foreach ($this->input->post('detail_temuan') as $detail) {
                if (empty($detail['id_perangkat'])) continue;
                
                $max_id_q = $this->db->select_max('id_temuan_detail')->get('temuan_detail')->row();
                $id_temuan_detail = ($max_id_q && $max_id_q->id_temuan_detail) ? $max_id_q->id_temuan_detail + 1 : 1;

                // Detail perangkat baru disimpan dengan status saat ini
                $detail_data = [
                    'id_temuan_detail' => $id_temuan_detail,
                    'id_temuan' => $id,
                    'id_perangkat' => $detail['id_perangkat'],
                    'status' => $current_status
                ];
                $this->db->insert('temuan_detail', $detail_data);
            }
        }

        // Sinkronisasi status foto dokumentasi yang masih aktif menjadi status saat ini saat data di-edit
        $this->db->where('id_temuan', $id);
        $this->db->where('status !=', 8);
        $this->db->update('dokumentasi_temuan', ['status' => $current_status]);

        // Handle upload multi-foto tambahan jika ada
        if (!empty($_FILES['foto']['name'][0])) {
            $upload_result = $this->upload_multiple_foto($id, $current_status);
            if (is_array($upload_result) && !$upload_result['status']) {
                $this->db->trans_rollback();
                echo json_encode(['code' => '500', 'msg' => $upload_result['error']]);
                return;
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = ['code' => '500', 'msg' => 'Gagal Proses Data'];
        } else {
            $response = ['code' => '200', 'msg' => 'Data Berhasil Di Proses'];
        }
        echo json_encode($response);
    }

    public function SaveData() {
        $this->db->trans_start();

        // [REQ-1] Ketika data ditambahkan di temuan maka status = 0 untuk temuan, temuan_detail, dokumentasi_temuan
        $data_temuan = [
            'nomor' => $this->input->post('nomor'),
            'kategori_kerusakan' => $this->input->post('kategori_kerusakan'),
            'analisis' => $this->input->post('analisis'),
            'kondisi' => $this->input->post('kondisi'),
            'tanggal' => str_replace('T', ' ', $this->input->post('tanggal')),
            'id_fasilitas' => $this->input->post('id_fasilitas'),
            'uraian_kejadian' => $this->input->post('uraian_kejadian'),
            'id_unit' => sess()['unit'],
            'create_by' => sess()['id'],
            'create_date' => date('Y-m-d'),
            'status' => '0'
        ];

        $this->db->insert('temuan', $data_temuan);
        $id_temuan = $this->db->insert_id();

        if ($this->input->post('detail_temuan') && is_array($this->input->post('detail_temuan'))) {
            foreach ($this->input->post('detail_temuan') as $detail) {
                if (empty($detail['id_perangkat'])) continue;

                $max_id_q = $this->db->select_max('id_temuan_detail')->get('temuan_detail')->row();
                $id_temuan_detail = ($max_id_q && $max_id_q->id_temuan_detail) ? $max_id_q->id_temuan_detail + 1 : 1;

                // [REQ-1] Detail perangkat baru disimpan dengan status '0'
                $detail_data = [
                    'id_temuan_detail' => $id_temuan_detail,
                    'id_temuan' => $id_temuan,
                    'id_perangkat' => $detail['id_perangkat'],
                    'status' => '0'
                ];
                $this->db->insert('temuan_detail', $detail_data);
            }
        }

        // Handle upload multi-foto ke folder dokumentasi_temuan
        if (!empty($_FILES['foto']['name'][0])) {
            $upload_result = $this->upload_multiple_foto($id_temuan);
            if (is_array($upload_result) && !$upload_result['status']) {
                $this->db->trans_rollback();
                echo json_encode(['code' => '500', 'msg' => $upload_result['error']]);
                return;
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = ['code' => '500', 'msg' => 'Gagal Simpan Data'];
        } else {
            $response = ['code' => '200', 'msg' => 'Data Berhasil Di Simpan'];
        }
        echo json_encode($response);
    }

    function ProsesData($id = null) {
        if (empty($id)) {
            echo json_encode(['code' => '500', 'msg' => 'Gagal Proses Data']);
            return;
        }

        $this->db->trans_start();

        // [REQ-4] Ketika data diproses maka status = 1 untuk temuan, temuan_detail, dokumentasi_temuan
        $update = [
            'status' => '1',
            'update_by' => sess()['id'],
            'update_date' => date('Y-m-d')
        ];

        $this->db->where('id_temuan', $id);
        $this->db->update('temuan', $update);

        $this->db->where('id_temuan', $id);
        $this->db->update('temuan_detail', ['status' => '1']);

        // [REQ-4] Perbarui status dokumentasi yang masih aktif menjadi '1' saat data diproses
        $this->db->where('id_temuan', $id);
        $this->db->where('status !=', 8);
        $this->db->update('dokumentasi_temuan', ['status' => '1']);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = ['code' => '500', 'msg' => 'Gagal Proses Data'];
        } else {
            $response = ['code' => '200', 'msg' => 'Data Berhasil Di Proses'];
        }

        echo json_encode($response);
    }

    function DeleteData($id = null) {
        if (empty($id)) {
            echo json_encode(['code' => '500', 'msg' => 'Gagal Hapus Data']);
            return;
        }

        $this->db->trans_start();

        // Get all photos first to delete files later
        $fotos = $this->m_data->getWhere('dokumentasi_temuan', ['id_temuan' => $id])->result_array();
        
        // [REQ-3 & REQ-5] Ketika dihapus maka status = 8 untuk temuan, temuan_detail, dokumentasi_temuan
        $update = [
            'status' => '8',
            'update_by' => sess()['id'],
            'update_date' => date('Y-m-d')
        ];

        $this->db->where('id_temuan', $id);
        $this->db->update('temuan', $update);

        $this->db->where('id_temuan', $id);
        $this->db->update('temuan_detail', ['status' => '8']);

        $this->db->where('id_temuan', $id);
        $this->db->update('dokumentasi_temuan', ['status' => '8']);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = ['code' => '500', 'msg' => 'Gagal Hapus Data'];
        } else {
            // Hapus file fisik foto
            foreach ($fotos as $foto) {
                if (!empty($foto['nama_dokumentasi_temuan'])) {
                    $file_path = './upload/dokumentasi_temuan/' . $foto['nama_dokumentasi_temuan'];
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }
            }
            $response = ['code' => '200', 'msg' => 'Data Berhasil Di Hapus'];
        }
        echo json_encode($response);
    }

    function DeleteFoto($id_foto = null) {
        if (!empty($id_foto)) {
            $foto = $this->m_data->getWhere('dokumentasi_temuan', ['id_dokumentasi_temuan' => $id_foto])->row_array();
            if (!empty($foto)) {
                $this->db->where('id_dokumentasi_temuan', $id_foto);
                $this->db->update('dokumentasi_temuan', ['status' => 8]);
                
                $file_path = './upload/dokumentasi_temuan/' . $foto['nama_dokumentasi_temuan'];
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
                echo json_encode(['code' => '200', 'msg' => 'Foto Berhasil Dihapus']);
                return;
            }
        }
        echo json_encode(['code' => '500', 'msg' => 'Gagal Hapus Foto']);
    }

    function GetDetailTemuan($id_temuan = null) {
        if (!empty($id_temuan)) {
            $detail = $this->m_data->getWhere('temuan_detail', ['id_temuan' => $id_temuan, 'status !=' => 8])->result_array();
            foreach ($detail as $key => $d) {
                $perangkat = $this->m_data->getWhere('perangkat', ['id_perangkat' => $d['id_perangkat']])->row_array();
                if (!empty($perangkat)) {
                    $detail[$key]['nama_perangkat'] = $perangkat['nama_perangkat'] ?? 'Perangkat';
                    $detail[$key]['kode_perangkat'] = $perangkat['kode_perangkat'] ?? '';
                }
            }
            echo json_encode($detail);
        } else {
            echo json_encode([]);
        }
    }

    function SelesaiData($id = null) {
        if (empty($id)) {
            echo json_encode(['code' => '500', 'msg' => 'Gagal Update Status']);
            return;
        }

        $this->db->trans_start();

        $update = [
            'status' => '9',
            'update_by' => sess()['id'],
            'update_date' => date('Y-m-d')
        ];

        $this->db->where('id_temuan', $id);
        $this->db->update('temuan', $update);

        $this->db->where('id_temuan', $id);
        $this->db->update('temuan_detail', ['status' => '9']);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = ['code' => '500', 'msg' => 'Gagal Update Status'];
        } else {
            $response = ['code' => '200', 'msg' => 'Status Berhasil Diupdate'];
        }

        echo json_encode($response);
    }

    // Helper function untuk upload multiple foto
    private function upload_multiple_foto($id_temuan, $status = '0') {
        if (!isset($_FILES['foto']['name']) || !is_array($_FILES['foto']['name'])) {
            return true;
        }

        $filesCount = count($_FILES['foto']['name']);
        $uploadPath = './upload/dokumentasi_temuan/';
        
        // Buat direktori jika belum ada
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $config['upload_path'] = $uploadPath;
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 5120; // 5MB
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        $upload_errors = [];
        
        for ($i = 0; $i < $filesCount; $i++) {
            if (empty($_FILES['foto']['name'][$i])) {
                continue;
            }

            $_FILES['file']['name']     = $_FILES['foto']['name'][$i];
            $_FILES['file']['type']     = $_FILES['foto']['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES['foto']['tmp_name'][$i];
            $_FILES['file']['error']    = $_FILES['foto']['error'][$i];
            $_FILES['file']['size']     = $_FILES['foto']['size'][$i];

            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $fileData = $this->upload->data();
                // Simpan foto baru dengan status yang diteruskan (bisa 0, 1, dsb.)
                $doc_data = [
                    'id_temuan' => $id_temuan,
                    'nama_dokumentasi_temuan' => $fileData['file_name'],
                    'tanggal' => date('Y-m-d H:i:s'),
                    'status' => $status
                ];
                $this->db->insert('dokumentasi_temuan', $doc_data);
            } else {
                $upload_errors[] = $_FILES['foto']['name'][$i] . ': ' . $this->upload->display_errors('', '');
            }
        }

        if (!empty($upload_errors)) {
            return [
                'status' => false,
                'error' => implode(', ', $upload_errors)
            ];
        }

        return [
            'status' => true
        ];
    }

    // Helper untuk kustomisasi label status khusus di temuan saja
    private function custom_status_label($status) {
        if ($status == '0') {
            return '<label class="label label-default">data draft</label>';
        } elseif ($status == '1') {
            return '<label class="label label-warning">data temuan di proses</label>';
        } elseif ($status == '2') {
            return '<label class="label label-info">data temuan sudah di tindak lanjut menunggu approved</label>';
        } elseif ($status == '9') {
            return '<label class="label label-success">data temuan sudah di approved</label>';
        } else {
            return '<label class="label label-default">Unknown</label>';
        }
    }

}