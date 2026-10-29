<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_role_sk_manager extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Ambil data pemetaan yang digroup per User & Role
     * Mendukung pencarian keyword dan filter role
     */
    public function get_grouped_mappings($search = null, $role_id = null) {
        $this->db->select("
            rsk.id_role,
            IFNULL(r.name_code, '-') as role_code,
            IFNULL(r.name_role, 'Role Khusus') as name_role,
            rsk.id_user,
            IFNULL(u.nik, '-') as nik,
            IFNULL(u.nama, 'User Tidak Ditemukan') as user_nama,
            IFNULL(u.jabatan, '-') as jabatan,
            IFNULL(u.unit_kerja, '-') as unit_kerja,
            COUNT(DISTINCT rsk.id_unit) as total_units,
            GROUP_CONCAT(DISTINCT un.id_unit ORDER BY un.name_unit ASC SEPARATOR ',') as unit_ids,
            GROUP_CONCAT(DISTINCT un.name_unit ORDER BY un.name_unit ASC SEPARATOR '||') as unit_names,
            GROUP_CONCAT(DISTINCT IFNULL(un.kode_unit, '') ORDER BY un.name_unit ASC SEPARATOR '||') as unit_codes,
            GROUP_CONCAT(DISTINCT rsk.id_role_sk_manager SEPARATOR ',') as mapping_ids
        ", FALSE);

        $this->db->from('role_sk_manager rsk');
        $this->db->join('role r', 'rsk.id_role = r.id', 'left');
        $this->db->join('user u', 'rsk.id_user = u.id', 'left');
        $this->db->join('unit un', 'rsk.id_unit = un.id_unit', 'left');
        $this->db->where('rsk.status !=', 8);

        if (!empty($role_id)) {
            $this->db->where('rsk.id_role', (int)$role_id);
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('u.nama', $search);
            $this->db->or_like('u.nik', $search);
            $this->db->or_like('u.jabatan', $search);
            $this->db->or_like('r.name_role', $search);
            $this->db->or_like('un.name_unit', $search);
            $this->db->group_end();
        }

        $this->db->group_by(['rsk.id_user', 'rsk.id_role']);
        $this->db->order_by('u.nama', 'ASC');

        return $this->db->get()->result_array();
    }

    /**
     * Ambil data per-baris mapping (Detail view)
     */
    public function get_raw_mappings($id_user = null, $id_role = null) {
        $this->db->select("
            rsk.id_role_sk_manager,
            rsk.id_role,
            rsk.id_user,
            rsk.id_unit,
            rsk.status,
            r.name_code as role_code,
            r.name_role,
            u.nik,
            u.nama as user_nama,
            u.jabatan,
            un.kode_unit,
            un.name_unit
        ");
        $this->db->from('role_sk_manager rsk');
        $this->db->join('role r', 'rsk.id_role = r.id', 'left');
        $this->db->join('user u', 'rsk.id_user = u.id', 'left');
        $this->db->join('unit un', 'rsk.id_unit = un.id_unit', 'left');
        $this->db->where('rsk.status !=', 8);

        if (!empty($id_user)) {
            $this->db->where('rsk.id_user', (int)$id_user);
        }
        if (!empty($id_role)) {
            $this->db->where('rsk.id_role', (int)$id_role);
        }

        $this->db->order_by('un.name_unit', 'ASC');
        return $this->db->get()->result_array();
    }

    /**
     * Ambil array ID Unit yang aktif ditugaskan ke user + role tertentu
     */
    public function get_assigned_unit_ids($id_user, $id_role) {
        $this->db->select('id_unit');
        $this->db->from('role_sk_manager');
        $this->db->where('id_user', (int)$id_user);
        $this->db->where('id_role', (int)$id_role);
        $this->db->where('status !=', 8);
        $res = $this->db->get()->result_array();

        if (empty($res)) {
            return [];
        }

        return array_map('intval', array_column($res, 'id_unit'));
    }

    /**
     * Sinkronisasi Multi-Unit Assignment untuk User & Role
     * - Unit yang dipilih: jika sudah ada -> pastikan status = 1; jika belum ada -> INSERT
     * - Unit yang tidak ada di daftar pilihan: diubah status = 8 (soft delete)
     */
    public function sync_user_units($id_role, $id_user, array $selected_unit_ids) {
        $this->db->trans_start();

        // 1. Ambil semua data pemetaan yang pernah ada (termasuk status 8) untuk pasangan ini
        $this->db->select('id_role_sk_manager, id_unit, status');
        $this->db->from('role_sk_manager');
        $this->db->where('id_user', (int)$id_user);
        $this->db->where('id_role', (int)$id_role);
        $existing = $this->db->get()->result_array();

        $existing_map = [];
        foreach ($existing as $row) {
            $existing_map[(int)$row['id_unit']] = [
                'id_role_sk_manager' => (int)$row['id_role_sk_manager'],
                'status'             => (int)$row['status']
            ];
        }

        // Sanitasi input unit_ids
        $target_unit_ids = array_values(array_unique(array_filter(array_map('intval', $selected_unit_ids))));

        // 2. Nonaktifkan (status = 8) unit yang TIDAK ADA di $target_unit_ids
        foreach ($existing_map as $unit_id => $data) {
            if (!in_array($unit_id, $target_unit_ids)) {
                if ($data['status'] != 8) {
                    $this->db->where('id_role_sk_manager', $data['id_role_sk_manager']);
                    $this->db->update('role_sk_manager', ['status' => 8]);
                }
            }
        }

        // 3. Tambahkan atau aktifkan kembali unit yang ADA di $target_unit_ids
        foreach ($target_unit_ids as $unit_id) {
            if (isset($existing_map[$unit_id])) {
                // Sudah ada, pastikan status = 1
                if ($existing_map[$unit_id]['status'] != 1) {
                    $this->db->where('id_role_sk_manager', $existing_map[$unit_id]['id_role_sk_manager']);
                    $this->db->update('role_sk_manager', ['status' => 1]);
                }
            } else {
                // Baru sama sekali, insert
                $this->db->insert('role_sk_manager', [
                    'id_role' => (int)$id_role,
                    'id_user' => (int)$id_user,
                    'id_unit' => (int)$unit_id,
                    'status'  => 1
                ]);
            }
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * Soft delete semua unit binaan untuk User & Role terkait
     */
    public function delete_user_mappings($id_user, $id_role) {
        $this->db->where('id_user', (int)$id_user);
        $this->db->where('id_role', (int)$id_role);
        return $this->db->update('role_sk_manager', ['status' => 8]);
    }

    /**
     * Ambil dropdown Roles aktif
     */
    public function get_active_roles() {
        $this->db->select('id, name_code, name_role');
        $this->db->from('role');
        $this->db->where('status !=', 8);
        $this->db->order_by('name_role', 'ASC');
        return $this->db->get()->result_array();
    }

    /**
     * Ambil dropdown Users aktif
     */
    public function get_active_users() {
        $this->db->select('id, nik, nama, jabatan, unit_kerja, type_user');
        $this->db->from('user');
        $this->db->where('status !=', 8);
        $this->db->order_by('nama', 'ASC');
        return $this->db->get()->result_array();
    }

    /**
     * Ambil dropdown Units aktif
     */
    public function get_active_units() {
        $this->db->select('id_unit, kode_unit, name_unit');
        $this->db->from('unit');
        $this->db->where('status !=', 8);
        $this->db->order_by('name_unit', 'ASC');
        return $this->db->get()->result_array();
    }

    /**
     * Ringkasan statistik
     */
    public function get_stats() {
        $sql = "
            SELECT 
                COUNT(DISTINCT rsk.id_user) as total_sk_users,
                COUNT(DISTINCT rsk.id_unit) as total_units_managed,
                COUNT(rsk.id_role_sk_manager) as total_assignments
            FROM role_sk_manager rsk
            WHERE rsk.status != 8
        ";
        return $this->db->query($sql)->row_array();
    }
}
