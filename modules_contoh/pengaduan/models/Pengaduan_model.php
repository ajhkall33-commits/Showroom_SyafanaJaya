<?php

class Pengaduan_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // -----------------------------------------------------------------
    // Ambil semua pengaduan (status != 8) dengan JOIN user/unit/role
    // -----------------------------------------------------------------
    function get_all($where_extra = '')
    {
        $query = "
            SELECT p.*, u.nik, u.nama, u.email, u.no_hp, u.jabatan,
                   un.kode_unit, r.name_role
            FROM pengaduan p
            JOIN user u ON p.user_id = u.id AND u.status != 8
            LEFT JOIN unit un ON u.unit_kerja = un.id_unit AND un.status != 8
            LEFT JOIN role r ON u.type_user = r.id AND r.status != 8
            WHERE p.status != 8
            $where_extra
            ORDER BY p.created_at DESC
        ";
        return $this->db->query($query)->result_array();
    }

    // -----------------------------------------------------------------
    // Ambil satu pengaduan beserta data user/unit/role & daftar gambar
    // -----------------------------------------------------------------
    function get_by_id($id)
    {
        $query = "
            SELECT p.*, u.nik, u.nama, u.email, u.no_hp, u.jabatan,
                   un.kode_unit, r.name_role
            FROM pengaduan p
            JOIN user u ON p.user_id = u.id AND u.status != 8
            LEFT JOIN unit un ON u.unit_kerja = un.id_unit AND un.status != 8
            LEFT JOIN role r ON u.type_user = r.id AND r.status != 8
            WHERE p.id = " . $this->db->escape($id) . "
            AND p.status != 8
            LIMIT 1
        ";
        $data = $this->db->query($query)->row_array();
        if (!empty($data)) {
            $data['gambar'] = $this->get_gambar($id);
        }
        return $data;
    }

    // -----------------------------------------------------------------
    // Ambil gambar dari tabel pengaduan_gambar
    // -----------------------------------------------------------------
    function get_gambar($pengaduan_id)
    {
        return $this->db->where('pengaduan_id', $pengaduan_id)
                        ->order_by('id', 'ASC')
                        ->get('pengaduan_gambar')
                        ->result_array();
    }

    // -----------------------------------------------------------------
    // Insert data ke tabel pengaduan_gambar
    // -----------------------------------------------------------------
    function insert_gambar($data)
    {
        return $this->db->insert('pengaduan_gambar', $data);
    }

    // -----------------------------------------------------------------
    // Get user data (beserta unit & role) berdasarkan ID
    // -----------------------------------------------------------------
    function get_user_by_id($user_id)
    {
        $query = "
            SELECT u.*, un.kode_unit, r.name_role
            FROM user u
            LEFT JOIN unit un ON u.unit_kerja = un.id_unit AND un.status != 8
            LEFT JOIN role r ON u.type_user = r.id AND r.status != 8
            WHERE u.id = " . $this->db->escape($user_id) . "
            AND u.status != 8
            LIMIT 1
        ";
        return $this->db->query($query)->row_array();
    }

    // -----------------------------------------------------------------
    // Generate kode pengaduan unik: PGD-YYYYMMDD-XXXX
    // -----------------------------------------------------------------
    function generate_kode()
    {
        $date = date('Ymd');
        $query = $this->db->query("SELECT COUNT(*) as cnt FROM pengaduan WHERE DATE(created_at) = CURDATE()");
        $row = $query->row();
        $seq = str_pad(($row->cnt ?? 0) + 1, 4, '0', STR_PAD_LEFT);
        return "PGD-{$date}-{$seq}";
    }

    // -----------------------------------------------------------------
    // Insert pengaduan baru
    // -----------------------------------------------------------------
    function insert_pengaduan($data)
    {
        $this->db->insert('pengaduan', $data);
        return $this->db->insert_id();
    }

    // -----------------------------------------------------------------
    // Update status pengaduan
    // -----------------------------------------------------------------
    function update_status($id, $status)
    {
        return $this->db->where('id', $id)
                        ->update('pengaduan', ['status' => $status, 'updated_at' => date('Y-m-d H:i:s')]);
    }

    // -----------------------------------------------------------------
    // Soft delete (status = 8)
    // -----------------------------------------------------------------
    function soft_delete($id)
    {
        return $this->update_status($id, 8);
    }
}

