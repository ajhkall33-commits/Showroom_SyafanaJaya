<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_sk_manager extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_role_sk_manager');
        $this->load->model('Mod');
        
        // Cek login
        if (empty($this->session->userdata('username')) && empty(sess()['username'])) {
            // Jika request via AJAX, kirim JSON 401
            if ($this->input->is_ajax_request()) {
                echo json_encode(['status' => 401, 'message' => 'Sesi berakhir, silakan login kembali.']);
                exit;
            }
            redirect(base_url('login/auth'));
        }
    }

    /**
     * Halaman Utama
     */
    public function index() {
        if (class_exists('Permission')) {
            Permission::grant('role_sk_manager');
        }

        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Role SK & Multi-Unit Manager";
        $data["title_des"] = "Kelola Hak Akses Multi-Unit Binaan untuk SK, Koor-K3, Koordinator & Role Lain";
        $data["content"] = "v_index";

        // Pre-load data dropdown & stats untuk render awal yang cepat
        $data["roles"] = $this->m_role_sk_manager->get_active_roles();
        $data["units"] = $this->m_role_sk_manager->get_active_units();
        $data["users"] = $this->m_role_sk_manager->get_active_users();
        $data["stats"] = $this->m_role_sk_manager->get_stats();

        $data["data"] = $data;
        $this->load->view('template_v2', $data);
    }

    /**
     * AJAX Endpoint: Ambil daftar data pemetaan yang digroup per user & role
     */
    public function LoadData() {
        $search = $this->input->post('search', TRUE) ?? $this->input->get('search', TRUE);
        $role_id = $this->input->post('role_id', TRUE) ?? $this->input->get('role_id', TRUE);

        $mappings = $this->m_role_sk_manager->get_grouped_mappings($search, $role_id);
        $stats = $this->m_role_sk_manager->get_stats();

        // Format data untuk memudahkan rendering di frontend (baik Desktop maupun Mobile)
        $formatted = [];
        foreach ($mappings as $row) {
            $unit_ids = !empty($row['unit_ids']) ? explode(',', $row['unit_ids']) : [];
            $unit_names = !empty($row['unit_names']) ? explode('||', $row['unit_names']) : [];
            $unit_codes = !empty($row['unit_codes']) ? explode('||', $row['unit_codes']) : [];

            $units_list = [];
            for ($i = 0; $i < count($unit_names); $i++) {
                $units_list[] = [
                    'id'   => $unit_ids[$i] ?? 0,
                    'name' => $unit_names[$i] ?? '',
                    'code' => $unit_codes[$i] ?? ''
                ];
            }

            $formatted[] = [
                'id_user'     => (int)$row['id_user'],
                'user_nama'   => $row['user_nama'],
                'nik'         => $row['nik'],
                'jabatan'     => $row['jabatan'],
                'unit_kerja'  => $row['unit_kerja'],
                'id_role'     => (int)$row['id_role'],
                'name_role'   => $row['name_role'],
                'role_code'   => $row['role_code'],
                'total_units' => (int)$row['total_units'],
                'units'       => $units_list,
                'unit_ids'    => $unit_ids
            ];
        }

        $response = [
            'status' => 200,
            'data'   => $formatted,
            'stats'  => $stats,
            'total'  => count($formatted)
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    /**
     * AJAX Endpoint: Ambil opsi dropdown (Role, User, Unit)
     */
    public function GetDropdownOptions() {
        $roles = $this->m_role_sk_manager->get_active_roles();
        $users = $this->m_role_sk_manager->get_active_users();
        $units = $this->m_role_sk_manager->get_active_units();

        $response = [
            'status' => 200,
            'roles'  => $roles,
            'users'  => $users,
            'units'  => $units
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    /**
     * AJAX Endpoint: Ambil detail mapping untuk modal edit
     */
    public function GetDetail() {
        $id_user = (int)($this->input->post('id_user') ?? $this->input->get('id_user'));
        $id_role = (int)($this->input->post('id_role') ?? $this->input->get('id_role'));

        if (empty($id_user) || empty($id_role)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 400, 'message' => 'Parameter tidak valid']));
            return;
        }

        $assigned_units = $this->m_role_sk_manager->get_assigned_unit_ids($id_user, $id_role);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'   => 200,
                'id_user'  => $id_user,
                'id_role'  => $id_role,
                'unit_ids' => $assigned_units
            ]));
    }

    /**
     * AJAX Endpoint: Simpan / Sinkronisasi Mapping Unit
     */
    public function SaveData() {
        $id_role = (int)$this->input->post('id_role');
        $id_user = (int)$this->input->post('id_user');
        $unit_ids = $this->input->post('unit_ids');

        if (empty($id_role)) {
            echo json_encode(['status' => 400, 'message' => 'Silakan pilih Role terlebih dahulu.']);
            return;
        }

        if (empty($id_user)) {
            echo json_encode(['status' => 400, 'message' => 'Silakan pilih Personil/User terlebih dahulu.']);
            return;
        }

        if (empty($unit_ids) || !is_array($unit_ids)) {
            echo json_encode(['status' => 400, 'message' => 'Pilih minimal satu Unit binaan yang dikelola.']);
            return;
        }

        $success = $this->m_role_sk_manager->sync_user_units($id_role, $id_user, $unit_ids);

        if ($success) {
            $res = [
                'status'  => 200,
                'message' => 'Pemetaan hak akses unit binaan berhasil disimpan.'
            ];
        } else {
            $res = [
                'status'  => 500,
                'message' => 'Terjadi kesalahan sistem saat menyimpan ke database.'
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($res));
    }

    /**
     * AJAX Endpoint: Hapus / Nonaktifkan mapping untuk user terkait
     */
    public function DeleteData() {
        $id_user = (int)$this->input->post('id_user');
        $id_role = (int)$this->input->post('id_role');

        if (empty($id_user) || empty($id_role)) {
            echo json_encode(['status' => 400, 'message' => 'Parameter tidak lengkap.']);
            return;
        }

        $success = $this->m_role_sk_manager->delete_user_mappings($id_user, $id_role);

        if ($success) {
            $res = [
                'status'  => 200,
                'message' => 'Pemetaan unit untuk personil ini berhasil dinonaktifkan.'
            ];
        } else {
            $res = [
                'status'  => 500,
                'message' => 'Gagal menonaktifkan data.'
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($res));
    }
}
