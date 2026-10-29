<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wwc_indikator extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $data["plugin"][]  = "plugin/datatable";
        $data["plugin"][]  = "plugin/select2";
        $data["title"]     = "Master Indikator Kompetensi";
        $data["title_des"] = "Kelola data indikator per kriteria wawancara kompetensi";
        $data["content"]   = "v_index";

        $data['kriteria'] = $this->Mod->GetCustome("
            SELECT id_kriteria, kode_kriteria, nama_kriteria FROM wwc_kriteria WHERE status != 8 ORDER BY urutan ASC
        ")->result_array();
        $data['list_unit'] = $this->Mod->getWhere('unit', array('status !=' => 8))->result_array();
        $data['list_role'] = $this->Mod->GetCustome("SELECT id, name_code, name_role FROM role WHERE status != 8 ORDER BY name_role ASC")->result_array();

        $this->load->view('template_v2', $data);
    }

    // Load semua indikator, support filter by id_kriteria (AJAX)
    public function LoadData()
    {
        $id_kriteria = $this->input->post('id_kriteria');
        $id_unit     = $this->input->post('id_unit');
        $id_role     = $this->input->post('id_role');

        $where_kriteria = !empty($id_kriteria) ? " AND i.id_kriteria = " . (int)$id_kriteria : "";
        $where_unit     = "";
        if (!empty($id_unit)) {
            $where_unit .= " AND EXISTS (
                SELECT 1 FROM wwc_unit_indikator ui
                WHERE ui.id_indikator = i.id_indikator
                AND ui.id_unit = " . (int)$id_unit . "
            )";
        }
        if (!empty($id_role)) {
            $where_unit .= " AND EXISTS (
                SELECT 1 FROM wwc_unit_indikator ui2
                WHERE ui2.id_indikator = i.id_indikator
                AND ui2.id_role = " . (int)$id_role . "
            )";
        }

        $data = $this->Mod->GetCustome("
            SELECT i.id_indikator, i.id_kriteria, i.kode_indikator, i.nama_indikator,
                   i.deskripsi, i.bobot, i.nilai_min, i.nilai_max, i.urutan, i.status,
                   k.nama_kriteria, k.kode_kriteria,
                   GROUP_CONCAT(DISTINCT u.name_unit SEPARATOR ', ') as nama_unit_list,
                   GROUP_CONCAT(DISTINCT r.name_role SEPARATOR ', ') as nama_role_list
            FROM wwc_indikator i
            LEFT JOIN wwc_kriteria k ON i.id_kriteria = k.id_kriteria
            LEFT JOIN wwc_unit_indikator uis ON uis.id_indikator = i.id_indikator
            LEFT JOIN unit u ON u.id_unit = uis.id_unit
            LEFT JOIN role r ON r.id = uis.id_role
            WHERE i.status != 8
            $where_kriteria $where_unit
            GROUP BY i.id_indikator
            ORDER BY k.urutan ASC, i.urutan ASC, i.id_indikator ASC
        ")->result_array();

        echo json_encode($data);
    }

    // Return indikator aktif per kriteria (dipakai oleh form penilaian)
    public function GetByKriteria($id_kriteria = null)
    {
        if (empty($id_kriteria)) { echo json_encode([]); return; }

        $data = $this->Mod->GetCustome("
            SELECT id_indikator, kode_indikator, nama_indikator, bobot, nilai_min, nilai_max, deskripsi
            FROM wwc_indikator
            WHERE id_kriteria = " . (int)$id_kriteria . " AND status != 8
            ORDER BY urutan ASC
        ")->result_array();

        echo json_encode($data);
    }

    // Return semua indikator aktif (untuk form penilaian multi-select)
    public function GetAllAktif()
    {
        $data = $this->Mod->GetCustome("
            SELECT i.id_indikator, i.kode_indikator, i.nama_indikator, i.bobot, i.nilai_min, i.nilai_max,
                   k.nama_kriteria, k.kode_kriteria, k.id_kriteria
            FROM wwc_indikator i
            LEFT JOIN wwc_kriteria k ON i.id_kriteria = k.id_kriteria
            WHERE i.status != 8
            ORDER BY k.urutan ASC, i.urutan ASC
        ")->result_array();

        echo json_encode($data);
    }

    // Ambil 1 data untuk form edit (AJAX)
    public function EditData($id = null)
    {
        if (!empty($id)) {
            $data = $this->Mod->getWhere('wwc_indikator', array('id_indikator' => $id))->row_array();
            
            $units = $this->Mod->GetCustome("SELECT DISTINCT id_unit FROM wwc_unit_indikator WHERE id_indikator = " . (int)$id)->result_array();
            $data['selected_units'] = array_column($units, 'id_unit');

            $roles = $this->Mod->GetCustome("SELECT DISTINCT id_role FROM wwc_unit_indikator WHERE id_indikator = " . (int)$id . " AND id_role IS NOT NULL")->result_array();
            $data['selected_roles'] = array_column($roles, 'id_role');

            echo json_encode($data);
        } else {
            echo json_encode([]);
        }
    }

    // Ambil indikator aktif sesuai filter Unit & Role (dipakai oleh form penilaian)
    public function GetByUnitRole()
    {
        $id_unit = $this->input->post('id_unit');
        $id_role = $this->input->post('id_role');
        $id_kriteria = $this->input->post('id_kriteria');

        $where = "";
        if (!empty($id_unit)) {
            $where .= " AND EXISTS (
                SELECT 1 FROM wwc_unit_indikator ui
                WHERE ui.id_indikator = i.id_indikator
                AND (ui.id_unit = " . (int)$id_unit . " OR ui.id_unit IS NULL)
            )";
        }
        if (!empty($id_role)) {
            $where .= " AND EXISTS (
                SELECT 1 FROM wwc_unit_indikator ui2
                WHERE ui2.id_indikator = i.id_indikator
                AND (ui2.id_role = " . (int)$id_role . " OR ui2.id_role IS NULL)
            )";
        }
        if (!empty($id_kriteria)) {
            $where .= " AND i.id_kriteria = " . (int)$id_kriteria;
        }

        $data = $this->Mod->GetCustome("
            SELECT i.id_indikator, i.kode_indikator, i.nama_indikator, i.bobot, i.nilai_min, i.nilai_max, i.deskripsi,
                   k.nama_kriteria, k.kode_kriteria, k.id_kriteria
            FROM wwc_indikator i
            LEFT JOIN wwc_kriteria k ON i.id_kriteria = k.id_kriteria
            WHERE i.status != 8
            $where
            ORDER BY k.urutan ASC, i.urutan ASC
        ")->result_array();

        echo json_encode($data);
    }

    // Simpan indikator baru (AJAX)
    public function SaveData()
    {
        $id_kriteria   = $this->input->post('id_kriteria');
        $kode_indikator = trim($this->input->post('kode_indikator'));
        $nama_indikator = trim($this->input->post('nama_indikator'));
        $deskripsi     = $this->input->post('deskripsi');
        $bobot         = $this->input->post('bobot');
        $nilai_min     = $this->input->post('nilai_min');
        $nilai_max     = $this->input->post('nilai_max');
        $urutan        = $this->input->post('urutan');

        if (empty($id_kriteria) || empty($nama_indikator)) {
            echo json_encode(['status' => '400', 'msg' => 'Kriteria dan Nama Indikator tidak boleh kosong.']);
            return;
        }
        if (empty($bobot) || (float)$bobot <= 0) {
            $bobot = 1.0;
        }
        if ((int)$nilai_min >= (int)$nilai_max) {
            echo json_encode(['status' => '400', 'msg' => 'Nilai Minimum harus lebih kecil dari Nilai Maksimum.']);
            return;
        }

        // Auto-generate kode indikator jika dikosongkan
        if (empty($kode_indikator)) {
            $count = $this->Mod->GetCustome("SELECT COUNT(*) as total FROM wwc_indikator WHERE id_kriteria = " . (int)$id_kriteria)->row_array();
            $num = (int)$count['total'] + 1;
            $kode_indikator = 'IND-' . str_pad($num, 3, '0', STR_PAD_LEFT);
            while ($this->Mod->GetCustome("SELECT id_indikator FROM wwc_indikator WHERE kode_indikator = '$kode_indikator' AND id_kriteria = " . (int)$id_kriteria . " AND status != 8")->num_rows() > 0) {
                $num++;
                $kode_indikator = 'IND-' . str_pad($num, 3, '0', STR_PAD_LEFT);
            }
        } else {
            // Cek duplikat kode dalam satu kriteria jika diisi manual
            $cek = $this->Mod->GetCustome("
                SELECT id_indikator FROM wwc_indikator
                WHERE kode_indikator = '" . $this->db->escape_str($kode_indikator) . "'
                AND id_kriteria = " . (int)$id_kriteria . " AND status != 8
            ")->row_array();
            if ($cek) {
                echo json_encode(['status' => '400', 'msg' => 'Kode Indikator sudah ada pada kriteria ini.']);
                return;
            }
        }

        $data = [
            'id_kriteria'    => (int)$id_kriteria,
            'kode_indikator' => $kode_indikator,
            'nama_indikator' => $nama_indikator,
            'deskripsi'      => $deskripsi,
            'bobot'          => (float)$bobot,
            'nilai_min'      => (int)$nilai_min,
            'nilai_max'      => (int)$nilai_max,
            'urutan'         => !empty($urutan) ? (int)$urutan : 0,
            'status'         => 0,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ];

        $this->db->insert('wwc_indikator', $data);
        $id_ind = $this->db->insert_id();

        // Assign ke unit & role
        $units = $this->input->post('id_unit');
        $roles = $this->input->post('id_role');
        if (!empty($units) && is_array($units)) {
            foreach ($units as $u_id) {
                if (!empty($roles) && is_array($roles)) {
                    foreach ($roles as $r_id) {
                        $this->db->insert('wwc_unit_indikator', [
                            'id_indikator' => $id_ind,
                            'id_unit'      => (int)$u_id,
                            'id_role'      => (int)$r_id,
                        ]);
                    }
                } else {
                    $this->db->insert('wwc_unit_indikator', [
                        'id_indikator' => $id_ind,
                        'id_unit'      => (int)$u_id,
                        'id_role'      => null,
                    ]);
                }
            }
        }

        echo json_encode(['status' => '200', 'msg' => 'Indikator berhasil disimpan.']);
    }

    // Update indikator (AJAX)
    public function UpdateData($id = null)
    {
        if (empty($id)) { echo json_encode(['status' => '400', 'msg' => 'ID tidak valid.']); return; }

        $id_kriteria    = $this->input->post('id_kriteria');
        $kode_indikator = trim($this->input->post('kode_indikator'));
        $nama_indikator = trim($this->input->post('nama_indikator'));
        $deskripsi      = $this->input->post('deskripsi');
        $bobot          = $this->input->post('bobot');
        $nilai_min      = $this->input->post('nilai_min');
        $nilai_max      = $this->input->post('nilai_max');
        $urutan         = $this->input->post('urutan');

        if (empty($id_kriteria) || empty($nama_indikator)) {
            echo json_encode(['status' => '400', 'msg' => 'Kriteria dan Nama Indikator tidak boleh kosong.']); return;
        }
        if (empty($bobot) || (float)$bobot <= 0) {
            $bobot = 1.0;
        }
        if ((int)$nilai_min >= (int)$nilai_max) {
            echo json_encode(['status' => '400', 'msg' => 'Nilai Minimum harus lebih kecil dari Nilai Maksimum.']); return;
        }

        if (empty($kode_indikator)) {
            $existing = $this->Mod->getWhere('wwc_indikator', array('id_indikator' => $id))->row_array();
            $kode_indikator = !empty($existing['kode_indikator']) ? $existing['kode_indikator'] : 'IND-' . str_pad((int)$id, 3, '0', STR_PAD_LEFT);
        } else {
            // Cek duplikat kode (exclude diri sendiri)
            $cek = $this->Mod->GetCustome("
                SELECT id_indikator FROM wwc_indikator
                WHERE kode_indikator = '" . $this->db->escape_str($kode_indikator) . "'
                AND id_kriteria = " . (int)$id_kriteria . " AND status != 8 AND id_indikator != " . (int)$id . "
            ")->row_array();
            if ($cek) {
                echo json_encode(['status' => '400', 'msg' => 'Kode Indikator sudah digunakan.']); return;
            }
        }

        $data = [
            'id_kriteria'    => (int)$id_kriteria,
            'kode_indikator' => $kode_indikator,
            'nama_indikator' => $nama_indikator,
            'deskripsi'      => $deskripsi,
            'bobot'          => (float)$bobot,
            'nilai_min'      => (int)$nilai_min,
            'nilai_max'      => (int)$nilai_max,
            'urutan'         => !empty($urutan) ? (int)$urutan : 0,
            'updated_at'     => date('Y-m-d H:i:s'),
        ];

        $this->Mod->update2('wwc_indikator', array('id_indikator' => $id), $data);

        // Sync unit & role
        $this->db->where('id_indikator', $id)->delete('wwc_unit_indikator');
        $units = $this->input->post('id_unit');
        $roles = $this->input->post('id_role');
        if (!empty($units) && is_array($units)) {
            foreach ($units as $u_id) {
                if (!empty($roles) && is_array($roles)) {
                    foreach ($roles as $r_id) {
                        $this->db->insert('wwc_unit_indikator', [
                            'id_indikator' => (int)$id,
                            'id_unit'      => (int)$u_id,
                            'id_role'      => (int)$r_id,
                        ]);
                    }
                } else {
                    $this->db->insert('wwc_unit_indikator', [
                        'id_indikator' => (int)$id,
                        'id_unit'      => (int)$u_id,
                        'id_role'      => null,
                    ]);
                }
            }
        }

        echo json_encode(['status' => '200', 'msg' => 'Indikator berhasil diupdate.']);
    }

    // Soft delete (AJAX)
    public function Delete($id = null)
    {
        if (empty($id)) { echo json_encode(['status' => '400', 'msg' => 'ID tidak valid.']); return; }

        // Cek apakah indikator sudah digunakan di form penilaian
        $cek = $this->Mod->GetCustome("
            SELECT id_detail_form FROM wwc_detail_form_penilaian WHERE id_indikator = " . (int)$id . " LIMIT 1
        ")->num_rows();
        if ($cek > 0) {
            echo json_encode(['status' => '400', 'msg' => 'Indikator tidak dapat dihapus karena sudah digunakan pada Form Penilaian.']);
            return;
        }

        $this->Mod->update2('wwc_indikator', array('id_indikator' => $id), ['status' => 8, 'updated_at' => date('Y-m-d H:i:s')]);
        echo json_encode(['status' => '200', 'msg' => 'Indikator berhasil dihapus.']);
    }
}
