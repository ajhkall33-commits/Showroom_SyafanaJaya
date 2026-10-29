<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Operasional extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('Excel');
        $this->load->model("m_data");
        $this->load->model("Mod");
        $this->load->library('upload');
        $this->load->helper('file');
        $this->load->library('pdfgenerator');

    }

    public function index()
    {
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/datepicker";

        $data["title"] = "Operasional";
        $data["title_des"] = "Data Operasional";
        $data["content"] = "v_index";

        $data['pelaksana'] = $this->Mod->getWhere('user', array('status !=' => 8, 'type_user IN (1,102,107)' => null, 'unit_kerja' => sess()['unit']))->result_array();
        $data['api'] = $this->Mod->getWhere('user', array('status !=' => 8, 'type_user IN (2,108)' => null, 'unit_kerja' => sess()['unit']))->result_array();
        $data['koordinator'] = $this->Mod->getWhere('user', array('status !=' => 8, 'type_user' => '102', 'unit_kerja' => sess()['unit']))->result_array();
        $data['unit'] = $this->Mod->getWhere('unit', array('status !=' => 8))->result_array();

        $this->load->view('template_v2', $data);
    }

    function LoadData()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        // SK Manager: filter unit dinamis berdasarkan pilihan dropdown atau semua unit yang dikelola
        $unit_filter_sql = get_unit_filter_sql('filter_unit');

        $query = "
            SELECT o.*, 
                u.name_unit,
                COUNT(od.id_operasional_detail) as jumlah_detail
            FROM operasional o
            LEFT JOIN unit u ON u.id_unit = o.id_unit
            LEFT JOIN operasional_detail od ON od.id_operasional = o.id_operasional AND od.status != 8
            WHERE o.status != 8
            AND o.id_unit $unit_filter_sql
            ";



        if (!empty($start_date) && !empty($end_date)) {
            $query .= " AND o.tanggal BETWEEN '" . $this->db->escape_str($start_date) . "' AND '" . $this->db->escape_str($end_date) . "'";
        } elseif (!empty($start_date)) {
            $query .= " AND o.tanggal >= '" . $this->db->escape_str($start_date) . "'";
        } elseif (!empty($end_date)) {
            $query .= " AND o.tanggal <= '" . $this->db->escape_str($end_date) . "'";
        }

        $query .= " GROUP BY o.id_operasional";
        $query .= " ORDER BY o.id_operasional DESC";

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
        }

        echo json_encode($data);
    }


    function GetOperasionalDetail()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        // SK Manager: filter unit dinamis berdasarkan pilihan dropdown atau semua unit yang dikelola
        $unit_filter_sql = get_unit_filter_sql('filter_unit');

        $query = "
            SELECT od.*, 
                u.name_unit
            FROM operasional_detail od
            LEFT JOIN unit u ON u.id_unit = od.id_unit
            WHERE od.status = 1 
            AND od.id_operasional IS NULL
            AND od.id_unit $unit_filter_sql";

        if (!empty($start_date) && !empty($end_date)) {
            $query .= " AND od.tanggal BETWEEN '" . $this->db->escape_str($start_date) . "' AND '" . $this->db->escape_str($end_date) . "'";
        } elseif (!empty($start_date)) {
            $query .= " AND od.tanggal >= '" . $this->db->escape_str($start_date) . "'";
        } elseif (!empty($end_date)) {
            $query .= " AND od.tanggal <= '" . $this->db->escape_str($end_date) . "'";
        }

        $query .= " ORDER BY od.tanggal DESC, od.waktu DESC";

        $data = $this->Mod->GetCustome($query)->result_array();

        foreach ($data as $key => $value) {
            if (function_exists('Hari_') && function_exists('tgl')) {
                $data[$key]['tanggal_label'] = Hari_($value['tanggal']) . ' ' . tgl($value['tanggal'], 'sm');
            } else {
                $data[$key]['tanggal_label'] = $value['tanggal'];
            }
            $data[$key]['waktu_label'] = date('H:i', strtotime($value['waktu']));
        }

        echo json_encode($data);
    }

    function EditData($id = null)
    {

        if (!empty($id)) {
            $query = "
                SELECT o.*, u.name_unit, u.* 
                FROM operasional o 
                LEFT JOIN unit u ON u.id_unit = o.id_unit 
                WHERE o.id_operasional = " . (int) $id . " AND o.status != 8
            ";
            $data = $this->Mod->GetCustome($query)->row_array();

            if (!$data) {
                echo json_encode([
                    'code' => '400',
                    'msg' => 'Data tidak ditemukan'
                ]);
                return;
            }

            $detail_query = "
                SELECT od.*, u.name_unit
                FROM operasional_detail od
                LEFT JOIN unit u ON u.id_unit = od.id_unit 

                WHERE od.id_operasional = " . $this->db->escape_str($id) . "
                AND od.status != 8
                ORDER BY od.tanggal DESC, od.waktu DESC";

            $detail = $this->Mod->GetCustome($detail_query)->result_array();
            $data['operasional_detail'] = $detail;

            $data['dokumentasi_bukti'] = $this->Mod->getWhere(
                'dokumentasi_bukti_operasional',
                array('id_operasional' => $id, 'status !=' => 8)
            )->result_array();

            $data['dokumentasi_pengukuran'] = $this->Mod->getWhere(
                'dokumentasi_pengukuran_operasional',
                array('id_operasional' => $id, 'status !=' => 8)
            )->result_array();

            echo json_encode($data);
        } else {
            $res = [
                'code' => '400',
                'msg' => 'ID tidak valid'
            ];
            echo json_encode($res);
        }
    }

    public function SaveData()
    {
        $this->db->trans_begin();

        try {
            $data = $this->input->post();

            if (!empty($data)) {
                // Handle array untuk pelaksana dan api
                $pelaksana = $this->input->post('pelaksana');
                $api = $this->input->post('api');

                // Convert array to string dengan implode jika berupa array
                $pelaksana_str = is_array($pelaksana) ? implode(', ', $pelaksana) : ($pelaksana ?: '');
                $api_str = is_array($api) ? implode(', ', $api) : ($api ?: '');


                // Generate nomor otomatis
                $nomor = isset($data['nomor']) && !empty($data['nomor']) ? $data['nomor'] :
                    'OPR-' . date('Ymd') . '-' . str_pad($this->Mod->getNextId('operasional'), 4, '0', STR_PAD_LEFT);

                // Insert data operasional
                $head = [
                    'id_unit' => sess()['unit'],
                    'nomor' => $nomor,
                    'tanggal' => $this->input->post('tanggal'),
                    'pelaksana' => $pelaksana_str,
                    'api' => $api_str,
                    'status' => 0
                ];

                $savedata = $this->db->insert('operasional', $head);
                $id_operasional = $this->db->insert_id();

                // Update operasional_detail yang dipilih
                if (isset($data['selected_details']) && !empty($data['selected_details'])) {
                    $selected_details = json_decode($data['selected_details'], true);

                    foreach ($selected_details as $detail_id) {
                        $detail_data = [
                            'id_operasional' => $id_operasional,
                            'status' => 2

                        ];
                        $this->Mod->update2(
                            'operasional_detail',
                            array('id_operasional_detail' => $detail_id),
                            $detail_data
                        );
                    }
                }

                // Handle upload dokumentasi bukti
                if (!empty($_FILES['dokumentasi_bukti']['name'][0])) {
                    $this->UploadDokumentasiBuktiProcess($id_operasional, 'dokumentasi_bukti');
                }

                // Handle upload dokumentasi pengukuran
                if (!empty($_FILES['dokumentasi_pengukuran']['name'][0])) {
                    $this->UploadDokumentasiPengukuranProcess($id_operasional, 'dokumentasi_pengukuran');
                }

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $response = [
                        'code' => '500',
                        'msg' => 'Data Gagal Disimpan'
                    ];
                } else {
                    $this->db->trans_commit();
                    $response = [
                        'code' => '200',
                        'msg' => 'Data Berhasil disimpan',
                        'id' => $id_operasional
                    ];
                }
            } else {
                $response = [
                    'code' => '400',
                    'msg' => 'Data Gagal Disimpan, pastikan semua terisi'
                ];
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'code' => '400',
                'msg' => 'Error: ' . $e->getMessage()
            ];
        }

        echo json_encode($response);
    }

    public function UpdateData($id = null)
    {
        if (empty($id)) {
            echo json_encode([
                'code' => '400',
                'msg' => 'ID tidak valid'
            ]);
            return;
        }

        $this->db->trans_begin();

        try {
            $data = $this->input->post();

            // Validasi field kosong
            if (empty($data['nomor']) || empty($data['tanggal']) || empty($data['pelaksana']) || empty($data['api'])) {
                echo json_encode([
                    'code' => '400',
                    'msg' => 'Data Nomor, Tanggal, Pelaksana, dan API wajib diisi'
                ]);
                return;
            }

            if (!empty($data)) {
                // Handle array untuk pelaksana dan api
                $pelaksana = $this->input->post('pelaksana');
                $api = $this->input->post('api');


                // Convert array to string dengan implode jika berupa array
                $pelaksana_str = is_array($pelaksana) ? implode(', ', $pelaksana) : ($pelaksana ?: '');
                $api_str = is_array($api) ? implode(', ', $api) : ($api ?: '');


                // Update data operasional
                $head = [
                    'id_unit' => sess()['unit'],
                    'nomor' => $this->input->post('nomor'),
                    'tanggal' => $this->input->post('tanggal'),
                    'pelaksana' => $pelaksana_str,
                    'api' => $api_str
                ];

                $savedata = $this->Mod->update2('operasional', array('id_operasional' => $id), $head);

                // Get current status
                $current_op = $this->Mod->getWhere('operasional', array('id_operasional' => $id))->row_array();
                $current_status = $current_op ? $current_op['status'] : 0;
                $detail_status = ($current_status > 0) ? $current_status : 2;

                // Clear existing details first (make them available again)
                $this->db->set('status', 1);
                $this->db->set('id_operasional', 'NULL', FALSE);
                $this->db->where('id_operasional', $id);
                $this->db->update('operasional_detail');

                // Update operasional_detail yang dipilih
                if (isset($data['selected_details']) && !empty($data['selected_details'])) {
                    $selected_details = json_decode($data['selected_details'], true);

                    foreach ($selected_details as $detail_id) {
                        $detail_data = [
                            'id_operasional' => $id,
                            'status' => $detail_status
                        ];
                        $this->Mod->update2(
                            'operasional_detail',
                            array('id_operasional_detail' => $detail_id),
                            $detail_data
                        );
                    }
                }

                // Handle upload dokumentasi bukti baru
                if (!empty($_FILES['dokumentasi_bukti']['name'][0])) {
                    $this->UploadDokumentasiBuktiProcess($id, 'dokumentasi_bukti');
                }

                // Handle upload dokumentasi pengukuran baru
                if (!empty($_FILES['dokumentasi_pengukuran']['name'][0])) {
                    $this->UploadDokumentasiPengukuranProcess($id, 'dokumentasi_pengukuran');
                }

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $response = [
                        'code' => '400',
                        'msg' => 'Data Gagal Diupdate'
                    ];
                } else {
                    $this->db->trans_commit();
                    $response = [
                        'code' => '200',
                        'msg' => 'Data Berhasil di Update'
                    ];
                }
            } else {
                $response = [
                    'code' => '400',
                    'msg' => 'Data Gagal Disimpan, pastikan semua terisi'
                ];
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'code' => '400',
                'msg' => 'Error: ' . $e->getMessage()
            ];
        }

        echo json_encode($response);
    }

    // Upload dokumentasi bukti operasional (gambar) - MULTIPLE FILES
    public function UploadDokumentasiBukti($id_operasional)
    {
        $response = [
            'success' => false,
            'message' => '',
            'files' => []
        ];

        if (!empty($_FILES['file']['name'][0])) {
            $config['upload_path'] = './upload/dokumentasi_bukti_operasional/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 5120; // 5MB
            $config['encrypt_name'] = TRUE;

            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }

            $this->load->library('upload', $config);

            $files = $_FILES;
            $upload_count = count($_FILES['file']['name']);

            for ($i = 0; $i < $upload_count; $i++) {
                $_FILES['userfile']['name'] = $files['file']['name'][$i];
                $_FILES['userfile']['type'] = $files['file']['type'][$i];
                $_FILES['userfile']['tmp_name'] = $files['file']['tmp_name'][$i];
                $_FILES['userfile']['error'] = $files['file']['error'][$i];
                $_FILES['userfile']['size'] = $files['file']['size'][$i];

                $this->upload->initialize($config);

                if ($this->upload->do_upload('userfile')) {
                    $upload_data = $this->upload->data();

                    $data_insert = [
                        'id_operasional' => $id_operasional,
                        'nama_dokumentasi_bukti' => $upload_data['file_name'],
                        'tanggal' => date('Y-m-d H:i:s'),
                        'status' => 1
                    ];

                    $this->db->insert('dokumentasi_bukti_operasional', $data_insert);

                    $response['files'][] = [
                        'file_name' => $upload_data['file_name'],
                        'id' => $this->db->insert_id()
                    ];
                    $response['success'] = true;
                } else {
                    $response['message'] = $this->upload->display_errors();
                }
            }

            if ($response['success']) {
                $response['message'] = count($response['files']) . ' file berhasil diupload';
            }
        } else {
            $response['message'] = 'Tidak ada file yang dipilih';
        }

        echo json_encode($response);
    }

    // Upload dokumentasi pengukuran operasional (gambar, pdf, excel) - MULTIPLE FILES
    public function UploadDokumentasiPengukuran($id_operasional)
    {
        $response = [
            'success' => false,
            'message' => '',
            'files' => []
        ];

        if (!empty($_FILES['file']['name'][0])) {
            $config['upload_path'] = './upload/dokumentasi_pengukuran_operasional/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|xls|xlsx|doc|docx';
            $config['max_size'] = 10240; // 10MB
            $config['encrypt_name'] = TRUE;

            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }

            $this->load->library('upload', $config);

            $files = $_FILES;
            $upload_count = count($_FILES['file']['name']);

            for ($i = 0; $i < $upload_count; $i++) {
                $_FILES['userfile']['name'] = $files['file']['name'][$i];
                $_FILES['userfile']['type'] = $files['file']['type'][$i];
                $_FILES['userfile']['tmp_name'] = $files['file']['tmp_name'][$i];
                $_FILES['userfile']['error'] = $files['file']['error'][$i];
                $_FILES['userfile']['size'] = $files['file']['size'][$i];

                $this->upload->initialize($config);

                if ($this->upload->do_upload('userfile')) {
                    $upload_data = $this->upload->data();

                    $data_insert = [
                        'id_operasional' => $id_operasional,
                        'nama_dokumentasi_pengukuran' => $upload_data['file_name'],
                        'tanggal' => date('Y-m-d H:i:s'),

                        'status' => 1
                    ];

                    $this->db->insert('dokumentasi_pengukuran_operasional', $data_insert);

                    $response['files'][] = [
                        'file_name' => $upload_data['file_name'],
                        'id' => $this->db->insert_id()
                    ];
                    $response['success'] = true;
                } else {
                    $response['message'] = $this->upload->display_errors();
                }
            }

            if ($response['success']) {
                $response['message'] = count($response['files']) . ' file berhasil diupload';
            }
        } else {
            $response['message'] = 'Tidak ada file yang dipilih';
        }

        echo json_encode($response);
    }

    // Fungsi helper untuk upload dokumentasi bukti
    private function UploadDokumentasiBuktiProcess($id_operasional, $field_name)
    {
        if (!empty($_FILES[$field_name]['name'][0])) {
            $config['upload_path'] = './upload/dokumentasi_bukti_operasional/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 5120; // 5MB
            $config['encrypt_name'] = TRUE;

            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }

            $this->load->library('upload', $config);

            $files = $_FILES;
            $upload_count = count($_FILES[$field_name]['name']);

            for ($i = 0; $i < $upload_count; $i++) {
                $_FILES['userfile']['name'] = $files[$field_name]['name'][$i];
                $_FILES['userfile']['type'] = $files[$field_name]['type'][$i];
                $_FILES['userfile']['tmp_name'] = $files[$field_name]['tmp_name'][$i];
                $_FILES['userfile']['error'] = $files[$field_name]['error'][$i];
                $_FILES['userfile']['size'] = $files[$field_name]['size'][$i];

                $this->upload->initialize($config);

                if ($this->upload->do_upload('userfile')) {
                    $upload_data = $this->upload->data();

                    $data_insert = [
                        'id_operasional' => $id_operasional,
                        'nama_dokumentasi_bukti' => $upload_data['file_name'],

                        'tanggal' => date('Y-m-d H:i:s'),

                        'status' => 1
                    ];

                    $this->db->insert('dokumentasi_bukti_operasional', $data_insert);
                }
            }
        }
    }

    // Fungsi helper untuk upload dokumentasi pengukuran
    private function UploadDokumentasiPengukuranProcess($id_operasional, $field_name)
    {
        if (!empty($_FILES[$field_name]['name'][0])) {
            $config['upload_path'] = './upload/dokumentasi_pengukuran_operasional/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|xls|xlsx|doc|docx';
            $config['max_size'] = 10240; // 10MB
            $config['encrypt_name'] = TRUE;

            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }

            $this->load->library('upload', $config);

            $files = $_FILES;
            $upload_count = count($_FILES[$field_name]['name']);

            for ($i = 0; $i < $upload_count; $i++) {
                $_FILES['userfile']['name'] = $files[$field_name]['name'][$i];
                $_FILES['userfile']['type'] = $files[$field_name]['type'][$i];
                $_FILES['userfile']['tmp_name'] = $files[$field_name]['tmp_name'][$i];
                $_FILES['userfile']['error'] = $files[$field_name]['error'][$i];
                $_FILES['userfile']['size'] = $files[$field_name]['size'][$i];

                $this->upload->initialize($config);

                if ($this->upload->do_upload('userfile')) {
                    $upload_data = $this->upload->data();

                    $data_insert = [
                        'id_operasional' => $id_operasional,
                        'nama_dokumentasi_pengukuran' => $upload_data['file_name'],

                        'tanggal' => date('Y-m-d H:i:s'),

                        'status' => 1
                    ];

                    $this->db->insert('dokumentasi_pengukuran_operasional', $data_insert);
                }
            }
        }
    }





    // Hapus dokumentasi bukti
    public function DeleteDokumentasiBukti($id = null)
    {
        if (!empty($id)) {
            $data = $this->Mod->getWhere(
                'dokumentasi_bukti_operasional',
                array('id_dokumentasi_bukti_operasional' => $id)
            )->row_array();

            if ($data) {
                $file_path = './upload/dokumentasi_bukti_operasional/' . $data['nama_dokumentasi_bukti'];
                if (file_exists($file_path)) {
                    unlink($file_path);
                }

                $update_data = [
                    'status' => 8,

                ];

                $this->Mod->update2(
                    'dokumentasi_bukti_operasional',
                    array('id_dokumentasi_bukti_operasional' => $id),
                    $update_data
                );

                $response = [
                    'code' => '200',
                    'msg' => 'Dokumentasi berhasil dihapus'
                ];
            } else {
                $response = [
                    'code' => '400',
                    'msg' => 'Data tidak ditemukan'
                ];
            }
        } else {
            $response = [
                'code' => '400',
                'msg' => 'ID tidak valid'
            ];
        }

        echo json_encode($response);
    }

    // Hapus dokumentasi pengukuran
    public function DeleteDokumentasiPengukuran($id = null)
    {
        if (!empty($id)) {
            $data = $this->Mod->getWhere(
                'dokumentasi_pengukuran_operasional',
                array('id_dokumentasi_pengukuran_operasional' => $id)
            )->row_array();

            if ($data) {
                $file_path = './upload/dokumentasi_pengukuran_operasional/' . $data['nama_dokumentasi_pengukuran'];
                if (file_exists($file_path)) {
                    unlink($file_path);
                }

                $update_data = [
                    'status' => 8,

                ];

                $this->Mod->update2(
                    'dokumentasi_pengukuran_operasional',
                    array('id_dokumentasi_pengukuran_operasional' => $id),
                    $update_data
                );

                $response = [
                    'code' => '200',
                    'msg' => 'Dokumentasi berhasil dihapus'
                ];
            } else {
                $response = [
                    'code' => '400',
                    'msg' => 'Data tidak ditemukan'
                ];
            }
        } else {
            $response = [
                'code' => '400',
                'msg' => 'ID tidak valid'
            ];
        }

        echo json_encode($response);
    }

    // Hapus operasional (soft delete)
    function Delete($id = null)
    {
        if (empty($id)) {
            echo json_encode([
                'code' => '400',
                'msg' => 'ID tidak valid'
            ]);
            return;
        }

        $this->db->trans_begin();

        try {
            // Update status operasional menjadi 8
            $head_update = [
                'status' => 8

            ];
            $this->Mod->update2('operasional', array('id_operasional' => $id), $head_update);

            // Update status detail operasional menjadi 1 (available again)
            $this->db->set('status', 1);
            $this->db->set('id_operasional', 'NULL', FALSE);
            $this->db->where('id_operasional', $id);
            $this->db->update('operasional_detail');

            // Update status dokumentasi
            $doc_update = [
                'status' => 8

            ];
            $this->Mod->update2('dokumentasi_bukti_operasional', array('id_operasional' => $id), $doc_update);
            $this->Mod->update2('dokumentasi_pengukuran_operasional', array('id_operasional' => $id), $doc_update);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $response = [
                    'code' => '400',
                    'msg' => 'Data Gagal di Hapus'
                ];
            } else {
                $this->db->trans_commit();
                $response = [
                    'code' => '200',
                    'msg' => 'Data Berhasil di Hapus'
                ];
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'code' => '400',
                'msg' => 'Error: ' . $e->getMessage()
            ];
        }

        echo json_encode($response);
    }

    // Get detail untuk dropdown (status = 9)
    function GetAvailableDetail()
    {
        $query = "
            SELECT 
                od.*,
                u.name_unit 
            FROM 
                operasional_detail od 
                LEFT JOIN unit u ON u.id_unit = od.id_unit 
            WHERE 
                od.status = 9 
                AND od.id_operasional IS NULL 
            ORDER BY 
                od.tanggal DESC, 
                od.waktu DESC";

        $data = $this->Mod->GetCustome($query)->result_array();  // ✅ result_array()

        echo json_encode($data);  // ✅ Tanpa koma
    }  // ✅ Tanpa koma

    public function ProsesData($id = null)
    {
        if (empty($id)) {
            echo json_encode([
                'code' => '400',
                'msg' => 'ID tidak valid'
            ]);
            return;
        }

        $this->db->trans_begin();

        try {
            $head_update = [
                'status' => 1
            ];
            $this->Mod->update2('operasional', array('id_operasional' => $id), $head_update);
            $this->Mod->update2('operasional_detail', array('id_operasional' => $id), $head_update);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $response = [
                    'code' => '400',
                    'msg' => 'Data Gagal Diproses'
                ];
            } else {
                $this->db->trans_commit();
                $response = [
                    'code' => '200',
                    'msg' => 'Data Berhasil Diproses'
                ];
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'code' => '400',
                'msg' => 'Error: ' . $e->getMessage()
            ];
        }

        echo json_encode($response);
    }

    function DeleteData($id = null)
    {
        $this->db->trans_begin();

        try {
            // Update status operasional menjadi 8
            $head_update = [
                'status' => 8
            ];
            $this->Mod->update2('operasional', array('id_operasional' => $id), $head_update);

            // Update status detail operasional menjadi 1 (available again)
            $this->db->set('status', 1);
            $this->db->set('id_operasional', 'NULL', FALSE);
            $this->db->where('id_operasional', $id);
            $this->db->update('operasional_detail');

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $res = [
                    'code' => '400',
                    'msg' => 'Data Gagal di Hapus'
                ];
            } else {
                $this->db->trans_commit();
                $res = [
                    'code' => '200',
                    'msg' => 'Data Berhasil di Hapus'
                ];
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $res = [
                'code' => '400',
                'msg' => 'Error: ' . $e->getMessage()
            ];
        }

        echo json_encode($res);
    }


    function PrintData($id = null)
    {
        try {
            // Enable error reporting untuk debugging
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

            // Cek folder upload
            $upload_path_bukti = FCPATH . 'upload/dokumentasi_bukti_operasional/';
            $upload_path_pengukuran = FCPATH . 'upload/dokumentasi_pengukuran_operasional/';

            if (!is_dir($upload_path_bukti)) {
                if (!mkdir($upload_path_bukti, 0755, true)) {
                    throw new Exception('Gagal membuat folder dokumentasi bukti operasional');
                }
            }

            if (!is_dir($upload_path_pengukuran)) {
                if (!mkdir($upload_path_pengukuran, 0755, true)) {
                    throw new Exception('Gagal membuat folder dokumentasi pengukuran operasional');
                }
            }

            if (!is_writable($upload_path_bukti)) {
                throw new Exception('Folder dokumentasi bukti operasional tidak writable');
            }

            if (!is_writable($upload_path_pengukuran)) {
                throw new Exception('Folder dokumentasi pengukuran operasional tidak writable');
            }

            $data["data"] = [];
            $data = $this->Mod->getWhere('operasional', array('id_operasional' => $id))->row_array();

            if (empty($data)) {
                throw new Exception('Data Operasional tidak ditemukan');
            }

            // Ambil data unit
            $unit_data = $this->Mod->getWhere('unit', array('id_unit' => $data['id_unit']))->row_array();
            $data['nama_unit'] = $unit_data ? $unit_data['name_unit'] : '-';
            $data['kode_unit'] = $unit_data ? $unit_data['kode_unit'] : '-';

            // Format tanggal
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

            // Ambil data user untuk pelaksana dan pengawas
            // HAPUS loop panjang, GANTI jadi:
            $data['nama_pelaksana_list'] = array_filter(array_map('trim', explode(',', $data['pelaksana'] ?? '')));
            $data['nama_pengawas_list'] = array_filter(array_map('trim', explode(',', $data['pengawas'] ?? '')));
            $data['nama_api_list'] = array_filter(array_map('trim', explode(',', $data['api'] ?? '')));

            // Format tanggal untuk display
            $data['tanggal_formatted'] = tgl($data['tanggal'], 'l');

            // Ambil nama pelaksana utama untuk TTD
            $data['nama_pelaksana_yang_ttd'] = !empty($data['nama_pelaksana_list'][0]) ? $data['nama_pelaksana_list'][0] : '-';
            $data['nama_pengawas_yang_ttd'] = !empty($data['nama_pengawas_list'][0]) ? $data['nama_pengawas_list'][0] : '-';

            // Ambil detail operasional
            $data['operasional_detail'] = $this->Mod->GetCustome("SELECT 
            od.tanggal,
            od.waktu,
            od.deskripsi,
            od.jam_mulai,
            od.jam_selesai,
            u.name_unit as nama_unit,
            od.status
        FROM 
            operasional_detail od
        LEFT JOIN 
            unit u ON u.id_unit = od.id_unit
        WHERE 
            od.id_operasional = '$id'
        ORDER BY 
            od.tanggal, od.waktu")->result_array();

            $data['c_detail'] = count($data['operasional_detail']);

            // Ambil dokumentasi bukti operasional
            $data['dokumentasi_bukti'] = $this->Mod->GetCustome("SELECT *

        FROM 
            dokumentasi_bukti_operasional dbo

        LEFT JOIN 
            operasional o on o.id_operasional = dbo.id_operasional
        WHERE 
            dbo.id_operasional = '$id'
        ORDER BY 
            dbo.tanggal")->result_array();

            $data['c_bukti'] = count($data['dokumentasi_bukti']);




            // TAMBAHKAN DATA KOORDINATOR
            $data['koordinator'] = $this->Mod->getWhere('user', array('status != ' => 8, 'type_user' => '102', 'unit_kerja' => sess()['unit']))->result_array();
            // Ambil nama koordinator pertama jika ada
            if (!empty($data['koordinator'])) {
                $data['nama_koordinator'] = $data['koordinator'][0]['nama'] ?? 'NAMA KOORDINATOR';
            } else {
                $data['nama_koordinator'] = 'NAMA KOORDINATOR';
            }

            // Ambil semua dokumentasi bukti secara random
            $all_bukti = $this->Mod->GetCustome("SELECT * FROM `dokumentasi_bukti_operasional` WHERE id_operasional='$id' AND status=1 ORDER BY RAND()")->result_array();

            $data['dock_bukti'] = array();
            $data['dock_bukti_sisa'] = array();

            $count = 0;
            foreach ($all_bukti as $value) {
                if (!empty($value['nama_dokumentasi_bukti'])) {
                    if ($count < 2) {
                        $data['dock_bukti'][] = array(
                            'nama_dokumentasi' => $value['nama_dokumentasi_bukti'],
                            'tanggal' => $value['tanggal']
                        );
                    } else {
                        $data['dock_bukti_sisa'][] = array(
                            'nama_dokumentasi' => $value['nama_dokumentasi_bukti'],
                            'tanggal' => $value['tanggal']
                        );
                    }
                    $count++;
                }
            }


            // HAPUS query random yang lama, ganti dengan ini:
            $data['dock_pengukuran_operasional'] = $this->Mod->GetCustome("
            SELECT *
            FROM dokumentasi_pengukuran_operasional dpo
            LEFT JOIN operasional o ON o.id_operasional = dpo.id_operasional
            WHERE dpo.id_operasional = '" . $this->db->escape_str($id) . "'
            AND dpo.status != 8
            ORDER BY dpo.tanggal DESC
        ")->result_array();


            // Tentukan tampilan berdasarkan unit
            if ($data['id_unit'] == 3) {
                $this->Operasional_CCTV($data);
            } elseif ($data['id_unit'] == 1) {
                $this->Operasional_PSIT($data);
            } else {
                $this->Operasional_All($data);
            }

        } catch (Exception $e) {
            log_message('error', 'PDF Error: ' . $e->getMessage());
            echo "Error generating PDF: " . $e->getMessage();
        }
    }

    function PrintData2($id = null)
    {
        try {
            // Enable error reporting untuk debugging
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

            // Cek folder upload
            $upload_path_bukti = FCPATH . 'upload/dokumentasi_bukti_operasional/';
            $upload_path_pengukuran = FCPATH . 'upload/dokumentasi_pengukuran_operasional/';

            if (!is_dir($upload_path_bukti)) {
                if (!mkdir($upload_path_bukti, 0755, true)) {
                    throw new Exception('Gagal membuat folder dokumentasi bukti operasional');
                }
            }

            if (!is_dir($upload_path_pengukuran)) {
                if (!mkdir($upload_path_pengukuran, 0755, true)) {
                    throw new Exception('Gagal membuat folder dokumentasi pengukuran operasional');
                }
            }

            if (!is_writable($upload_path_bukti)) {
                throw new Exception('Folder dokumentasi bukti operasional tidak writable');
            }

            if (!is_writable($upload_path_pengukuran)) {
                throw new Exception('Folder dokumentasi pengukuran operasional tidak writable');
            }

            $data["data"] = [];
            $data = $this->Mod->getWhere('operasional', array('id_operasional' => $id))->row_array();

            if (empty($data)) {
                throw new Exception('Data Operasional tidak ditemukan');
            }

            // Ambil data unit
            $unit_data = $this->Mod->getWhere('unit', array('id_unit' => $data['id_unit']))->row_array();
            $data['nama_unit'] = $unit_data ? $unit_data['name_unit'] : '-';
            $data['kode_unit'] = $unit_data ? $unit_data['kode_unit'] : '-';

            // Format tanggal
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

            // Ambil data user untuk pelaksana dan pengawas
            // HAPUS loop panjang, GANTI jadi:
            $data['nama_pelaksana_list'] = array_filter(array_map('trim', explode(',', $data['pelaksana'] ?? '')));
            $data['nama_pengawas_list'] = array_filter(array_map('trim', explode(',', $data['pengawas'] ?? '')));
            $data['nama_api_list'] = array_filter(array_map('trim', explode(',', $data['api'] ?? '')));

            // Format tanggal untuk display
            $data['tanggal_formatted'] = tgl($data['tanggal'], 'l');

            // Ambil nama pelaksana utama untuk TTD
            $data['nama_pelaksana_yang_ttd'] = !empty($data['nama_pelaksana_list'][0]) ? $data['nama_pelaksana_list'][0] : '-';
            $data['nama_pengawas_yang_ttd'] = !empty($data['nama_pengawas_list'][0]) ? $data['nama_pengawas_list'][0] : '-';

            // Ambil detail operasional
            $data['operasional_detail'] = $this->Mod->GetCustome("SELECT 
            od.tanggal,
            od.waktu,
            od.deskripsi,
            od.jam_mulai,
            od.jam_selesai,
            u.name_unit as nama_unit,
            od.status
        FROM 
            operasional_detail od
        LEFT JOIN 
            unit u ON u.id_unit = od.id_unit
        WHERE 
            od.id_operasional = '$id'
        ORDER BY 
            od.tanggal, od.waktu")->result_array();

            $data['c_detail'] = count($data['operasional_detail']);

            // Ambil dokumentasi bukti operasional
            $data['dokumentasi_bukti'] = $this->Mod->GetCustome("SELECT *

        FROM 
            dokumentasi_bukti_operasional dbo

        LEFT JOIN 
            operasional o on o.id_operasional = dbo.id_operasional
        WHERE 
            dbo.id_operasional = '$id'
        ORDER BY 
            dbo.tanggal")->result_array();

            $data['c_bukti'] = count($data['dokumentasi_bukti']);




            // TAMBAHKAN DATA KOORDINATOR
            $data['koordinator'] = $this->Mod->getWhere('user', array('status != ' => 8, 'type_user' => '102', 'unit_kerja' => sess()['unit']))->result_array();
            // Ambil nama koordinator pertama jika ada
            if (!empty($data['koordinator'])) {
                $data['nama_koordinator'] = $data['koordinator'][0]['nama'] ?? 'NAMA KOORDINATOR';
            } else {
                $data['nama_koordinator'] = 'NAMA KOORDINATOR';
            }

            // Ambil semua dokumentasi bukti secara random
            $all_bukti = $this->Mod->GetCustome("SELECT * FROM `dokumentasi_bukti_operasional` WHERE id_operasional='$id' AND status=1 ORDER BY RAND()")->result_array();

            $data['dock_bukti'] = array();
            $data['dock_bukti_sisa'] = array();

            $count = 0;
            foreach ($all_bukti as $value) {
                if (!empty($value['nama_dokumentasi_bukti'])) {
                    if ($count < 2) {
                        $data['dock_bukti'][] = array(
                            'nama_dokumentasi' => $value['nama_dokumentasi_bukti'],
                            'tanggal' => $value['tanggal']
                        );
                    } else {
                        $data['dock_bukti_sisa'][] = array(
                            'nama_dokumentasi' => $value['nama_dokumentasi_bukti'],
                            'tanggal' => $value['tanggal']
                        );
                    }
                    $count++;
                }
            }


            // HAPUS query random yang lama, ganti dengan ini:
            $data['dock_pengukuran_operasional'] = $this->Mod->GetCustome("
            SELECT *
            FROM dokumentasi_pengukuran_operasional dpo
            LEFT JOIN operasional o ON o.id_operasional = dpo.id_operasional
            WHERE dpo.id_operasional = '" . $this->db->escape_str($id) . "'
            AND dpo.status != 8
            ORDER BY dpo.tanggal DESC
        ")->result_array();



            $this->Operasional_API($data);

        } catch (Exception $e) {
            log_message('error', 'PDF Error: ' . $e->getMessage());
            echo "Error generating PDF: " . $e->getMessage();
        }
    }

    function PrintData3($id = null)
    {
        try {
            // Enable error reporting untuk debugging
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

            // Cek folder upload
            $upload_path_bukti = FCPATH . 'upload/dokumentasi_bukti_operasional/';
            $upload_path_pengukuran = FCPATH . 'upload/dokumentasi_pengukuran_operasional/';

            if (!is_dir($upload_path_bukti)) {
                if (!mkdir($upload_path_bukti, 0755, true)) {
                    throw new Exception('Gagal membuat folder dokumentasi bukti operasional');
                }
            }

            if (!is_dir($upload_path_pengukuran)) {
                if (!mkdir($upload_path_pengukuran, 0755, true)) {
                    throw new Exception('Gagal membuat folder dokumentasi pengukuran operasional');
                }
            }

            if (!is_writable($upload_path_bukti)) {
                throw new Exception('Folder dokumentasi bukti operasional tidak writable');
            }

            if (!is_writable($upload_path_pengukuran)) {
                throw new Exception('Folder dokumentasi pengukuran operasional tidak writable');
            }

            $data["data"] = [];
            $data = $this->Mod->getWhere('operasional', array('id_operasional' => $id))->row_array();

            if (empty($data)) {
                throw new Exception('Data Operasional tidak ditemukan');
            }

            // Ambil data unit
            $unit_data = $this->Mod->getWhere('unit', array('id_unit' => $data['id_unit']))->row_array();
            $data['nama_unit'] = $unit_data ? $unit_data['name_unit'] : '-';
            $data['kode_unit'] = $unit_data ? $unit_data['kode_unit'] : '-';

            // Format tanggal
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

            // Ambil data user untuk pelaksana dan pengawas
            // HAPUS loop panjang, GANTI jadi:
            $data['nama_pelaksana_list'] = array_filter(array_map('trim', explode(',', $data['pelaksana'] ?? '')));
            $data['nama_pengawas_list'] = array_filter(array_map('trim', explode(',', $data['pengawas'] ?? '')));
            $data['nama_api_list'] = array_filter(array_map('trim', explode(',', $data['api'] ?? '')));

            // Format tanggal untuk display
            $data['tanggal_formatted'] = tgl($data['tanggal'], 'l');

            // Ambil nama pelaksana utama untuk TTD
            $data['nama_pelaksana_yang_ttd'] = !empty($data['nama_pelaksana_list'][0]) ? $data['nama_pelaksana_list'][0] : '-';
            $data['nama_pengawas_yang_ttd'] = !empty($data['nama_pengawas_list'][0]) ? $data['nama_pengawas_list'][0] : '-';

            // Ambil detail operasional
            $data['operasional_detail'] = $this->Mod->GetCustome("SELECT 
            od.tanggal,
            od.waktu,
            od.deskripsi,
            od.jam_mulai,
            od.jam_selesai,
            u.name_unit as nama_unit,
            od.status
        FROM 
            operasional_detail od
        LEFT JOIN 
            unit u ON u.id_unit = od.id_unit
        WHERE 
            od.id_operasional = '$id'
        ORDER BY 
            od.tanggal, od.waktu")->result_array();

            $data['c_detail'] = count($data['operasional_detail']);

            // Ambil dokumentasi bukti operasional
            $data['dokumentasi_bukti'] = $this->Mod->GetCustome("SELECT *

        FROM 
            dokumentasi_bukti_operasional dbo

        LEFT JOIN 
            operasional o on o.id_operasional = dbo.id_operasional
        WHERE 
            dbo.id_operasional = '$id'
        ORDER BY 
            dbo.tanggal")->result_array();

            $data['c_bukti'] = count($data['dokumentasi_bukti']);




            // TAMBAHKAN DATA KOORDINATOR
            $data['koordinator'] = $this->Mod->getWhere('user', array('status != ' => 8, 'type_user' => '102', 'unit_kerja' => sess()['unit']))->result_array();
            // Ambil nama koordinator pertama jika ada
            if (!empty($data['koordinator'])) {
                $data['nama_koordinator'] = $data['koordinator'][0]['nama'] ?? 'NAMA KOORDINATOR';
            } else {
                $data['nama_koordinator'] = 'NAMA KOORDINATOR';
            }

            // Ambil semua dokumentasi bukti secara random
            $all_bukti = $this->Mod->GetCustome("SELECT * FROM `dokumentasi_bukti_operasional` WHERE id_operasional='$id' AND status=1 ORDER BY RAND()")->result_array();

            $data['dock_bukti'] = array();
            $data['dock_bukti_sisa'] = array();

            $count = 0;
            foreach ($all_bukti as $value) {
                if (!empty($value['nama_dokumentasi_bukti'])) {
                    if ($count < 2) {
                        $data['dock_bukti'][] = array(
                            'nama_dokumentasi' => $value['nama_dokumentasi_bukti'],
                            'tanggal' => $value['tanggal']
                        );
                    } else {
                        $data['dock_bukti_sisa'][] = array(
                            'nama_dokumentasi' => $value['nama_dokumentasi_bukti'],
                            'tanggal' => $value['tanggal']
                        );
                    }
                    $count++;
                }
            }


            // HAPUS query random yang lama, ganti dengan ini:
            $data['dock_pengukuran_operasional'] = $this->Mod->GetCustome("
            SELECT *
            FROM dokumentasi_pengukuran_operasional dpo
            LEFT JOIN operasional o ON o.id_operasional = dpo.id_operasional
            WHERE dpo.id_operasional = '" . $this->db->escape_str($id) . "'
            AND dpo.status != 8
            ORDER BY dpo.tanggal DESC
        ")->result_array();



            $this->Operasional_2logo($data);

        } catch (Exception $e) {
            log_message('error', 'PDF Error: ' . $e->getMessage());
            echo "Error generating PDF: " . $e->getMessage();
        }
    }


    function Operasional_All($data)
    {
        $this->load->view('v_Operasional', $data);
    }

    function Operasional_API($data)
    {
        $this->load->view('v_Operasional1', $data);
    }

    function Operasional_2logo($data)
    {
        $this->load->view('v_Operasional2logo', $data);
    }

    // function ttd 
    public function SaveTtdIass()
    {
        $id_operasional = $this->input->post('id_operasional');
        $image_data = $this->input->post('image');

        if (empty($id_operasional) || empty($image_data)) {
            echo json_encode(['code' => '400', 'msg' => 'Data tidak lengkap']);
            return;
        }

        $this->db->trans_begin();

        try {
            // Ambil data operasional untuk mendapatkan id_unit
            $operasional = $this->Mod->getWhere('operasional', array('id_operasional' => $id_operasional))->row_array();

            if (empty($operasional)) {
                echo json_encode(['code' => '400', 'msg' => 'Data operasional tidak ditemukan']);
                return;
            }

            $id_unit = $operasional['id_unit'];

            // Buat struktur path folder
            $base_dir = './doc/ttd_operasional/';
            $unit_dir = $base_dir . $id_unit . '/';
            $iass_dir = $unit_dir . 'IASS/';
            $pelaksana_dir = $iass_dir . 'Pelaksana/';

            if (!is_dir($base_dir))
                mkdir($base_dir, 0777, true);
            if (!is_dir($unit_dir))
                mkdir($unit_dir, 0777, true);
            if (!is_dir($iass_dir))
                mkdir($iass_dir, 0777, true);
            if (!is_dir($pelaksana_dir))
                mkdir($pelaksana_dir, 0777, true);

            // Bersihkan data base64
            $image_parts = explode(";base64,", $image_data);
            if (count($image_parts) != 2) {
                echo json_encode(['code' => '400', 'msg' => 'Format gambar tidak valid']);
                return;
            }

            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            // Nama file
            $file_name = 'IASS_Pelaksana_' . date('Ymd_His') . '.png';
            $file_path = $pelaksana_dir . $file_name;

            // Simpan gambar ke direktori
            if (!file_put_contents($file_path, $image_base64)) {
                echo json_encode(['code' => '500', 'msg' => 'Gagal menyimpan file gambar']);
                return;
            }

            // Update database field ttd_iass
            $update_data = [
                'ttd_iass' => $file_name
            ];

            $this->Mod->update2('operasional', array('id_operasional' => $id_operasional), $update_data);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo json_encode(['code' => '500', 'msg' => 'Gagal mengupdate database']);
            } else {
                $this->db->trans_commit();
                echo json_encode(['code' => '200', 'msg' => 'Tanda tangan berhasil disimpan']);
            }

        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo json_encode(['code' => '500', 'msg' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function SaveTtdKoordinator()
    {
        $id_operasional = $this->input->post('id_operasional');
        $image_data = $this->input->post('image');

        if (empty($id_operasional) || empty($image_data)) {
            echo json_encode(['code' => '400', 'msg' => 'Data tidak lengkap']);
            return;
        }

        $this->db->trans_begin();

        try {
            // Ambil data operasional untuk mendapatkan id_unit
            $operasional = $this->Mod->getWhere('operasional', array('id_operasional' => $id_operasional))->row_array();

            if (empty($operasional)) {
                echo json_encode(['code' => '400', 'msg' => 'Data operasional tidak ditemukan']);
                return;
            }

            $id_unit = $operasional['id_unit'];

            // Buat struktur path folder
            $base_dir = './doc/ttd_operasional/';
            $unit_dir = $base_dir . $id_unit . '/';
            $iass_dir = $unit_dir . 'IASS/';
            $koordinator_dir = $iass_dir . 'Koordinator/';

            if (!is_dir($base_dir))
                mkdir($base_dir, 0777, true);
            if (!is_dir($unit_dir))
                mkdir($unit_dir, 0777, true);
            if (!is_dir($iass_dir))
                mkdir($iass_dir, 0777, true);
            if (!is_dir($koordinator_dir))
                mkdir($koordinator_dir, 0777, true);

            // Bersihkan data base64
            $image_parts = explode(";base64,", $image_data);
            if (count($image_parts) != 2) {
                echo json_encode(['code' => '400', 'msg' => 'Format gambar tidak valid']);
                return;
            }

            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            // Nama file
            $file_name = 'IASS_Koordinator_' . date('Ymd_His') . '.png';
            $file_path = $koordinator_dir . $file_name;

            // Simpan gambar ke direktori
            if (!file_put_contents($file_path, $image_base64)) {
                echo json_encode(['code' => '500', 'msg' => 'Gagal menyimpan file gambar']);
                return;
            }

            // Update database field ttd_koordinator
            $update_data = [
                'ttd_koordinator' => $file_name
            ];

            $this->Mod->update2('operasional', array('id_operasional' => $id_operasional), $update_data);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo json_encode(['code' => '500', 'msg' => 'Gagal mengupdate database']);
            } else {
                $this->db->trans_commit();
                echo json_encode(['code' => '200', 'msg' => 'Tanda tangan berhasil disimpan']);
            }

        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo json_encode(['code' => '500', 'msg' => 'Error: ' . $e->getMessage()]);
        }
    }
}