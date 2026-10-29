<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cbt_bank_soal extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("m_data");
    }

    // =========================================================
    // INDEX — Load halaman utama Bank Soal
    // =========================================================
    public function index()
    {
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"]     = "Bank Soal CBT";
        $data["title_des"] = "Manajemen Bank Soal Computer-Based Test";
        $data["content"]   = "v_index";

        $data['unit'] = $this->Mod->getWhere('unit', array('status !=' => 8))->result_array();
        $data['role'] = $this->Mod->getWhere('role', array('status' => 1))->result_array();

        $this->load->view('template_v2', $data);
    }

    // =========================================================
    // LOAD DATA — Ambil semua soal + unit terkait (AJAX)
    // =========================================================
    function LoadData()
    {
        $id_unit_filter = $this->input->post('id_unit');
        $id_role_filter = $this->input->post('id_role');
        $search_soal    = $this->input->post('search_soal');

        $whereUnit = "";
        if (!empty($id_unit_filter)) {
            $whereUnit .= " AND EXISTS (
                SELECT 1 FROM cbt_unit_bank_soal ubs
                WHERE ubs.id_bank_soal = b.id_bank_soal_cbt
                AND ubs.id_unit = " . (int)$id_unit_filter . "
            )";
        }
        if (!empty($id_role_filter)) {
            $whereUnit .= " AND EXISTS (
                SELECT 1 FROM cbt_unit_bank_soal ubs2
                WHERE ubs2.id_bank_soal = b.id_bank_soal_cbt
                AND ubs2.id_role = " . (int)$id_role_filter . "
            )";
        }
        if (!empty($search_soal)) {
            $escaped = $this->db->escape_like_str(trim($search_soal));
            $whereUnit .= " AND (
                b.pertanyaan LIKE '%" . $escaped . "%'
                OR b.opsi_a LIKE '%" . $escaped . "%'
                OR b.opsi_b LIKE '%" . $escaped . "%'
                OR b.opsi_c LIKE '%" . $escaped . "%'
                OR b.opsi_d LIKE '%" . $escaped . "%'
            )";
        }

        $data = $this->Mod->GetCustome("
            SELECT b.*,
                GROUP_CONCAT(DISTINCT u.name_unit SEPARATOR ', ') AS nama_unit_list,
                GROUP_CONCAT(DISTINCT r.name_role SEPARATOR ', ') AS nama_role_list
            FROM cbt_bank_soal b
            LEFT JOIN cbt_unit_bank_soal ubs ON ubs.id_bank_soal = b.id_bank_soal_cbt
            LEFT JOIN unit u ON u.id_unit = ubs.id_unit
            LEFT JOIN role r ON r.id = ubs.id_role
            WHERE b.status != 8
            $whereUnit
            GROUP BY b.id_bank_soal_cbt
            ORDER BY b.id_bank_soal_cbt DESC
        ")->result_array();

        echo json_encode($data);
    }

    // =========================================================
    // LOAD UNIT — Return semua unit aktif untuk dropdown
    // =========================================================
    function LoadUnit()
    {
        $data = $this->Mod->getWhere('unit', array('status !=' => 8))->result_array();
        echo json_encode($data);
    }

    // =========================================================
    // SAVE DATA — Insert soal baru
    // =========================================================
    public function SaveData()
    {
        $post = $this->input->post(null, true);

        if (empty($post['pertanyaan'])) {
            echo json_encode(['status' => '400', 'msg' => 'Pertanyaan tidak boleh kosong']);
            return;
        }

        $data_insert = [
            'pertanyaan'   => $post['pertanyaan'],
            'opsi_a'       => $post['opsi_a'],
            'opsi_b'       => $post['opsi_b'],
            'opsi_c'       => $post['opsi_c'],
            'opsi_d'       => $post['opsi_d'],
            'jawaban'      => $post['jawaban'],
            'bobot'        => isset($post['bobot']) ? (int)$post['bobot'] : 1,
            'tanggal'      => date('Y-m-d H:i:s'),
            'status'       => 1,
            'user_created' => sess()['id'],
        ];

        $this->db->insert('cbt_bank_soal', $data_insert);
        $id_soal = $this->db->insert_id();

        // Assign ke unit+role (multi)
        $units = !empty($post['id_unit']) && is_array($post['id_unit']) ? $post['id_unit'] : [];
        $roles = !empty($post['id_role']) && is_array($post['id_role']) ? $post['id_role'] : [];

        if (!empty($units)) {
            foreach ($units as $id_unit) {
                if (!empty($roles)) {
                    foreach ($roles as $id_role) {
                        $this->db->insert('cbt_unit_bank_soal', [
                            'id_bank_soal' => $id_soal,
                            'id_unit'      => (int)$id_unit,
                            'id_role'      => (int)$id_role,
                        ]);
                    }
                } else {
                    $this->db->insert('cbt_unit_bank_soal', [
                        'id_bank_soal' => $id_soal,
                        'id_unit'      => (int)$id_unit,
                        'id_role'      => null,
                    ]);
                }
            }
        }

        echo json_encode(['status' => '200', 'msg' => 'Soal berhasil disimpan']);
    }

    // =========================================================
    // EDIT DATA — Return data soal + unit yang sudah dipilih
    // =========================================================
    function EditData($id = null)
    {
        if (empty($id)) {
            echo json_encode(['status' => '400', 'msg' => 'ID tidak valid']);
            return;
        }

        $soal = $this->Mod->getWhere('cbt_bank_soal', ['id_bank_soal_cbt' => $id])->row_array();

        // Ambil unit yang sudah di-assign ke soal ini
        $units = $this->Mod->GetCustome("
            SELECT DISTINCT id_unit FROM cbt_unit_bank_soal WHERE id_bank_soal = $id
        ")->result_array();
        $soal['selected_units'] = array_column($units, 'id_unit');

        // Ambil role yang sudah di-assign ke soal ini
        $roles = $this->Mod->GetCustome("
            SELECT DISTINCT id_role FROM cbt_unit_bank_soal WHERE id_bank_soal = $id AND id_role IS NOT NULL
        ")->result_array();
        $soal['selected_roles'] = array_column($roles, 'id_role');

        echo json_encode($soal);
    }

    // =========================================================
    // UPDATE DATA — Update soal + sync unit
    // =========================================================
    public function UpdateData($id = null)
    {
        if (empty($id)) {
            echo json_encode(['status' => '400', 'msg' => 'ID tidak valid']);
            return;
        }

        $post = $this->input->post(null, true);

        $data_update = [
            'pertanyaan' => $post['pertanyaan'],
            'opsi_a'     => $post['opsi_a'],
            'opsi_b'     => $post['opsi_b'],
            'opsi_c'     => $post['opsi_c'],
            'opsi_d'     => $post['opsi_d'],
            'jawaban'    => $post['jawaban'],
            'bobot'      => isset($post['bobot']) ? (int)$post['bobot'] : 1,
        ];

        $this->Mod->update2('cbt_bank_soal', ['id_bank_soal_cbt' => $id], $data_update);

        // Sync unit+role: hapus lama, insert baru
        $this->db->delete('cbt_unit_bank_soal', ['id_bank_soal' => $id]);
        $units = !empty($post['id_unit']) && is_array($post['id_unit']) ? $post['id_unit'] : [];
        $roles = !empty($post['id_role']) && is_array($post['id_role']) ? $post['id_role'] : [];

        if (!empty($units)) {
            foreach ($units as $id_unit) {
                if (!empty($roles)) {
                    foreach ($roles as $id_role) {
                        $this->db->insert('cbt_unit_bank_soal', [
                            'id_bank_soal' => $id,
                            'id_unit'      => (int)$id_unit,
                            'id_role'      => (int)$id_role,
                        ]);
                    }
                } else {
                    $this->db->insert('cbt_unit_bank_soal', [
                        'id_bank_soal' => $id,
                        'id_unit'      => (int)$id_unit,
                        'id_role'      => null,
                    ]);
                }
            }
        }

        echo json_encode(['status' => '200', 'msg' => 'Soal berhasil diperbarui']);
    }

    // =========================================================
    // DELETE — Soft delete soal (status = 8)
    // =========================================================
    public function Delete($id = null)
    {
        if (empty($id)) {
            echo json_encode(['status' => '400', 'msg' => 'ID tidak valid']);
            return;
        }

        $this->Mod->update2('cbt_bank_soal', ['id_bank_soal_cbt' => $id], ['status' => 8]);
        echo json_encode(['status' => '200', 'msg' => 'Soal berhasil dihapus']);
    }

    // =========================================================
    // TOGGLE STATUS — Aktif (1) / Nonaktif (0)
    // =========================================================
    public function ToggleStatus($id = null)
    {
        if (empty($id)) {
            echo json_encode(['status' => '400', 'msg' => 'ID tidak valid']);
            return;
        }

        $soal = $this->Mod->getWhere('cbt_bank_soal', ['id_bank_soal_cbt' => $id])->row_array();
        $new_status = ($soal['status'] == 1) ? 0 : 1;

        $this->Mod->update2('cbt_bank_soal', ['id_bank_soal_cbt' => $id], ['status' => $new_status]);

        $msg = $new_status == 1 ? 'Soal diaktifkan' : 'Soal dinonaktifkan';
        echo json_encode(['status' => '200', 'msg' => $msg, 'new_status' => $new_status]);
    }

    // =========================================================
    // PRINT SOAL — Cetak Laporan Bank Soal CBT (PDF / Print Out)
    // =========================================================
    public function print_soal()
    {
        $id_unit_filter = $this->input->get('id_unit');
        $id_role_filter = $this->input->get('id_role');
        $search_soal    = $this->input->get('search');
        $show_kunci     = $this->input->get('show_kunci') !== null ? (int)$this->input->get('show_kunci') : 1;

        $whereUnit = "";
        if (!empty($id_unit_filter)) {
            $whereUnit .= " AND EXISTS (
                SELECT 1 FROM cbt_unit_bank_soal ubs
                WHERE ubs.id_bank_soal = b.id_bank_soal_cbt
                AND ubs.id_unit = " . (int)$id_unit_filter . "
            )";
        }
        if (!empty($id_role_filter)) {
            $whereUnit .= " AND EXISTS (
                SELECT 1 FROM cbt_unit_bank_soal ubs2
                WHERE ubs2.id_bank_soal = b.id_bank_soal_cbt
                AND ubs2.id_role = " . (int)$id_role_filter . "
            )";
        }
        if (!empty($search_soal)) {
            $escaped = $this->db->escape_like_str(trim($search_soal));
            $whereUnit .= " AND (
                b.pertanyaan LIKE '%" . $escaped . "%'
                OR b.opsi_a LIKE '%" . $escaped . "%'
                OR b.opsi_b LIKE '%" . $escaped . "%'
                OR b.opsi_c LIKE '%" . $escaped . "%'
                OR b.opsi_d LIKE '%" . $escaped . "%'
            )";
        }

        $list = $this->Mod->GetCustome("
            SELECT b.*,
                GROUP_CONCAT(DISTINCT u.name_unit SEPARATOR ', ') AS nama_unit_list,
                GROUP_CONCAT(DISTINCT r.name_role SEPARATOR ', ') AS nama_role_list
            FROM cbt_bank_soal b
            LEFT JOIN cbt_unit_bank_soal ubs ON ubs.id_bank_soal = b.id_bank_soal_cbt
            LEFT JOIN unit u ON u.id_unit = ubs.id_unit
            LEFT JOIN role r ON r.id = ubs.id_role
            WHERE b.status != 8
            $whereUnit
            GROUP BY b.id_bank_soal_cbt
            ORDER BY b.id_bank_soal_cbt DESC
        ")->result_array();

        // Ambil nama unit jika difilter
        $unit_info = null;
        if (!empty($id_unit_filter)) {
            $unit_info = $this->db->get_where('unit', ['id_unit' => (int)$id_unit_filter])->row_array();
        }

        // Ambil nama role jika difilter
        $role_info = null;
        if (!empty($id_role_filter)) {
            $role_info = $this->db->get_where('role', ['id' => (int)$id_role_filter])->row_array();
        }

        // Hitung statistik
        $total_soal     = count($list);
        $total_aktif    = 0;
        $total_nonaktif = 0;
        $total_bobot    = 0;

        foreach ($list as $s) {
            if ($s['status'] == 1) {
                $total_aktif++;
            } else {
                $total_nonaktif++;
            }
            $total_bobot += (int)($s['bobot'] ?? 1);
        }

        $sess = sess();
        $user_nama = $sess['nama'] ?? $sess['username'] ?? 'Administrator';

        $data = [
            'list'           => $list,
            'id_unit_filter' => $id_unit_filter,
            'id_role_filter' => $id_role_filter,
            'search_soal'    => $search_soal,
            'unit_info'      => $unit_info,
            'role_info'      => $role_info,
            'show_kunci'     => $show_kunci,
            'total_soal'     => $total_soal,
            'total_aktif'    => $total_aktif,
            'total_nonaktif' => $total_nonaktif,
            'total_bobot'    => $total_bobot,
            'user_nama'      => $user_nama,
            'tgl_cetak'      => date('d-m-Y H:i')
        ];

        $this->load->view('v_print_soal', $data);
    }
}
