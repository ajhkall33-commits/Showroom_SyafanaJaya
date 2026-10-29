<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wwc_form_assessor extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $data["plugin"][]  = "plugin/datatable";
        $data["plugin"][]  = "plugin/select2";
        $data["title"]     = "Penugasan Assessor";
        $data["title_des"] = "Kelola penugasan assessor dan pembagian peserta pada form penilaian wawancara";
        $data["content"]   = "v_index";     
        $this->load->view('template_v2', $data);
    }

    // Load daftar form penilaian (AJAX)
    public function LoadData()
    {
        $data = $this->Mod->GetCustome("
            SELECT fp.id_form, fp.kode_form, fp.nama_form, fp.tanggal_penilaian, fp.lokasi, fp.status,
                   fp.id_unit, fp.id_role,
                   un.name_unit, r.name_role,
                   (SELECT COUNT(*) FROM wwc_form_assessor fa WHERE fa.id_form = fp.id_form AND fa.status != 8) as jumlah_assessor,
                   (SELECT COUNT(*) FROM wwc_penilaian p WHERE p.id_form = fp.id_form) as jumlah_selesai,
                   (SELECT COUNT(*) FROM user u WHERE (u.unit_kerja = fp.id_unit OR fp.id_unit IS NULL) AND (u.type_user = fp.id_role OR fp.id_role IS NULL) AND u.type_user IN (1, 101, 102, 107, 109, 110, 111) AND u.status = 1) as total_peserta
            FROM wwc_form_penilaian fp
            LEFT JOIN unit un ON fp.id_unit = un.id_unit
            LEFT JOIN role r ON fp.id_role = r.id
            WHERE fp.status != 8
            ORDER BY fp.tanggal_penilaian DESC, fp.id_form DESC
        ")->result_array();

        echo json_encode($data);
    }

    // Load assessor yang sudah ditugaskan pada suatu form (AJAX)
    public function LoadAssessor($id_form = null)
    {
        if (empty($id_form)) { echo json_encode([]); return; }

        $data = $this->Mod->GetCustome("
            SELECT fa.id_form_assessor, fa.id_form, fa.urutan, fa.catatan, fa.assigned_at, fa.status,
                   u.nama as nama_assessor, u.nik as nik_assessor, u.jabatan,
                   (SELECT COUNT(*) FROM wwc_penilaian p WHERE p.id_form_assessor = fa.id_form_assessor) as sudah_dinilai,
                   (SELECT COUNT(*) FROM wwc_form_assessor_peserta fap WHERE fap.id_form_assessor = fa.id_form_assessor) as total_peserta_khusus,
                   GROUP_CONCAT(DISTINCT up.nama SEPARATOR ', ') as list_nama_peserta
            FROM wwc_form_assessor fa
            JOIN user u ON fa.id_user = u.id
            LEFT JOIN wwc_form_assessor_peserta fap ON fap.id_form_assessor = fa.id_form_assessor
            LEFT JOIN user up ON up.id = fap.id_peserta
            WHERE fa.id_form = " . (int)$id_form . " AND fa.status != 8
            GROUP BY fa.id_form_assessor
            ORDER BY fa.urutan ASC, fa.assigned_at ASC
        ")->result_array();

        echo json_encode($data);
    }

    // Return daftar unit aktif untuk dropdown filter (AJAX)
    public function GetListUnit()
    {
        $data = $this->Mod->GetCustome("
            SELECT id_unit, kode_unit, name_unit
            FROM unit
            WHERE status != 8
            ORDER BY kode_unit ASC, name_unit ASC
        ")->result_array();

        foreach ($data as &$u) {
            $kode = !empty($u['kode_unit']) ? trim($u['kode_unit']) : '-';
            $nama = !empty($u['name_unit']) ? trim($u['name_unit']) : '-';
            $u['label'] = "[ $kode ] $nama";
        }

        echo json_encode($data);
    }

    // Return user yang belum ditugaskan pada form ini (untuk Select2)
    // Format: NIK - Nama - [ kode unit ] - IASS/API (IASS = role 1, 99, 101, 102, 103, 107, 109, 110. Selain itu = API)
    public function GetAvailableUser($id_form = null)
    {
        if (empty($id_form)) { echo json_encode([]); return; }

        $id_unit = $this->input->get('id_unit');
        $where_unit = (!empty($id_unit) && is_numeric($id_unit)) ? " AND u.unit_kerja = " . (int)$id_unit : "";

        $data = $this->Mod->GetCustome("
            SELECT u.id, u.nik, u.nama, u.jabatan, u.type_user, u.unit_kerja, un.kode_unit, un.name_unit,
                   CASE 
                       WHEN u.type_user IN (1, 101, 102, 107, 109, 110, 111) THEN 'IASS'
                       ELSE 'API'
                   END as kategori
            FROM user u
            LEFT JOIN unit un ON u.unit_kerja = un.id_unit
            WHERE u.status = 1
            $where_unit
            AND u.id NOT IN (
                SELECT fa.id_user FROM wwc_form_assessor fa WHERE fa.id_form = " . (int)$id_form . " AND fa.status != 8
            )
            ORDER BY u.nama ASC
        ")->result_array();

        foreach ($data as &$u) {
            $nik       = !empty($u['nik']) ? trim($u['nik']) : '-';
            $nama      = !empty($u['nama']) ? trim($u['nama']) : '-';
            $kode_unit = !empty($u['kode_unit']) ? trim($u['kode_unit']) : (!empty($u['name_unit']) ? trim($u['name_unit']) : '-');
            $kat       = $u['kategori'];
            $u['kode_unit_clean'] = $kode_unit;
            $u['label'] = "$nik - $nama - [ $kode_unit ] - $kat";
        }

        echo json_encode($data);
    }

    // Return daftar peserta (KHUSUS PERSONIL IASS DARI SEMUA UNIT)
    public function GetPesertaForm($id_form = null, $id_form_assessor = null)
    {
        if (empty($id_form)) { echo json_encode([]); return; }

        $id_unit = $this->input->get('id_unit');
        $where_unit = (!empty($id_unit) && is_numeric($id_unit)) ? " AND u.unit_kerja = " . (int)$id_unit : "";

        // Role IASS: 1, 99, 101, 102, 103, 107, 109, 110
        // Role Peserta Asesmen: 1, 101, 102, 107, 109, 110, 111
        $peserta_roles = "1, 101, 102, 107, 109, 110, 111";

        $assigned_ids = [];
        if (!empty($id_form_assessor)) {
            $assigned = $this->Mod->GetCustome("SELECT id_peserta FROM wwc_form_assessor_peserta WHERE id_form_assessor = " . (int)$id_form_assessor)->result_array();
            $assigned_ids = array_column($assigned, 'id_peserta');
        }

        // Open semua personil IASS dari seluruh unit (dengan filter unit opsional)
        $peserta = $this->Mod->GetCustome("
            SELECT u.id, u.nik, u.nama, u.jabatan, u.type_user, u.unit_kerja, un.kode_unit, un.name_unit
            FROM user u
            LEFT JOIN unit un ON u.unit_kerja = un.id_unit
            WHERE u.status = 1
            AND u.type_user IN ($peserta_roles)
            $where_unit
            ORDER BY u.nama ASC
        ")->result_array();

        foreach ($peserta as &$p) {
            $nik       = !empty($p['nik']) ? trim($p['nik']) : '-';
            $nama      = !empty($p['nama']) ? trim($p['nama']) : '-';
            $kode_unit = !empty($p['kode_unit']) ? trim($p['kode_unit']) : (!empty($p['name_unit']) ? trim($p['name_unit']) : '-');
            $p['kode_unit_clean'] = $kode_unit;
            $p['label'] = "$nik - $nama - [ $kode_unit ] - IASS";
            $p['is_assigned'] = in_array($p['id'], $assigned_ids) ? 1 : 0;
        }

        echo json_encode([
            'peserta' => $peserta,
            'selected_ids' => $assigned_ids
        ]);
    }

    // Assign satu atau lebih assessor beserta peserta yang dinilai (AJAX + Transaksi DB)
    public function AssignAssessor()
    {
        $id_form      = $this->input->post('id_form');
        $id_user_arr  = $this->input->post('id_user'); // array
        $id_peserta_arr = $this->input->post('id_peserta'); // array
        $catatan      = $this->input->post('catatan');

        if (empty($id_form) || empty($id_user_arr) || !is_array($id_user_arr)) {
            echo json_encode(['status' => '400', 'msg' => 'Form dan minimal satu assessor harus dipilih.']); return;
        }

        // Cek form aktif
        $form = $this->Mod->getWhere('wwc_form_penilaian', array('id_form' => $id_form))->row_array();
        if (empty($form) || $form['status'] == 8) {
            echo json_encode(['status' => '400', 'msg' => 'Form penilaian tidak ditemukan.']); return;
        }

        $this->db->trans_begin();
        try {
            // Ambil urutan terakhir
            $last = $this->Mod->GetCustome("SELECT MAX(urutan) as max_urutan FROM wwc_form_assessor WHERE id_form = " . (int)$id_form . " AND status != 8")->row_array();
            $urutan = ($last['max_urutan'] ?? 0) + 1;

            $inserted = 0;
            $skipped  = 0;
            foreach ($id_user_arr as $id_user) {
                // Cek duplikat
                $cek = $this->Mod->GetCustome("
                    SELECT id_form_assessor FROM wwc_form_assessor
                    WHERE id_form = " . (int)$id_form . " AND id_user = " . (int)$id_user . " AND status != 8
                ")->row_array();

                if ($cek) { $skipped++; continue; }

                $this->db->insert('wwc_form_assessor', [
                    'id_form'        => (int)$id_form,
                    'id_user'        => (int)$id_user,
                    'urutan'         => $urutan,
                    'status'         => 0,
                    'id_assigned_by' => sess()['id'],
                    'assigned_at'    => date('Y-m-d H:i:s'),
                    'catatan'        => $catatan,
                ]);
                $id_fa = $this->db->insert_id();

                // Simpan daftar peserta yang ditugaskan ke assessor ini
                if (!empty($id_peserta_arr) && is_array($id_peserta_arr)) {
                    foreach ($id_peserta_arr as $id_p) {
                        $this->db->insert('wwc_form_assessor_peserta', [
                            'id_form_assessor' => $id_fa,
                            'id_peserta'       => (int)$id_p,
                        ]);
                    }
                }

                $urutan++;
                $inserted++;
            }

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                echo json_encode(['status' => '400', 'msg' => 'Gagal menyimpan penugasan.']);
            } else {
                $this->db->trans_commit();
                $msg = "$inserted assessor berhasil ditugaskan.";
                if ($skipped > 0) $msg .= " ($skipped assessor sudah pernah ditugaskan, dilewati.)";
                echo json_encode(['status' => '200', 'msg' => $msg]);
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo json_encode(['status' => '400', 'msg' => 'Error: ' . $e->getMessage()]);
        }
    }

    // Update peserta yang dinilai oleh assessor tertentu (AJAX)
    public function UpdatePesertaAssessor()
    {
        $id_form_assessor = $this->input->post('id_form_assessor');
        $id_peserta_arr   = $this->input->post('id_peserta'); // array

        if (empty($id_form_assessor)) {
            echo json_encode(['status' => '400', 'msg' => 'ID penugasan tidak valid.']); return;
        }

        $this->db->trans_begin();
        try {
            // Hapus relasi lama
            $this->db->where('id_form_assessor', (int)$id_form_assessor)->delete('wwc_form_assessor_peserta');

            // Insert relasi baru jika ada yang dipilih
            if (!empty($id_peserta_arr) && is_array($id_peserta_arr)) {
                foreach ($id_peserta_arr as $id_p) {
                    $this->db->insert('wwc_form_assessor_peserta', [
                        'id_form_assessor' => (int)$id_form_assessor,
                        'id_peserta'       => (int)$id_p,
                    ]);
                }
            }

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                echo json_encode(['status' => '400', 'msg' => 'Gagal mengupdate daftar peserta.']);
            } else {
                $this->db->trans_commit();
                $count = !empty($id_peserta_arr) ? count($id_peserta_arr) : 0;
                $info = ($count > 0) ? "$count peserta berhasil ditugaskan." : "Semua peserta di Unit & Role ini dapat dinilai oleh assessor.";
                echo json_encode(['status' => '200', 'msg' => 'Daftar peserta untuk assessor berhasil diperbarui. ' . $info]);
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo json_encode(['status' => '400', 'msg' => 'Error: ' . $e->getMessage()]);
        }
    }

    // Hapus penugasan assessor (AJAX - soft delete)
    public function RemoveAssessor($id = null)
    {
        if (empty($id)) { echo json_encode(['status' => '400', 'msg' => 'ID tidak valid.']); return; }

        // Cek apakah assessor sudah melakukan penilaian
        $cek = $this->Mod->GetCustome("
            SELECT id_penilaian FROM wwc_penilaian WHERE id_form_assessor = " . (int)$id . " LIMIT 1
        ")->num_rows();
        if ($cek > 0) {
            echo json_encode(['status' => '400', 'msg' => 'Assessor yang sudah melakukan penilaian tidak dapat dihapus.']); return;
        }

        $this->db->where('id_form_assessor', (int)$id)->delete('wwc_form_assessor_peserta');
        $this->Mod->update2('wwc_form_assessor', array('id_form_assessor' => $id), ['status' => 8]);
        echo json_encode(['status' => '200', 'msg' => 'Assessor berhasil dihapus dari penugasan.']);
    }
}
