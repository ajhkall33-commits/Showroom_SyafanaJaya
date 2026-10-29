<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wwc_form_penilaian extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $data["plugin"][]  = "plugin/datatable";
        $data["plugin"][]  = "plugin/select2";
        $data["title"]     = "Form Penilaian Wawancara";
        $data["title_des"] = "Kelola form penilaian wawancara kompetensi";
        $data["content"]   = "v_index";

        $data['list_user']  = $this->Mod->GetCustome("SELECT id, nik, nama, jabatan, unit_kerja, type_user FROM user WHERE status = 1 ORDER BY nama ASC")->result_array();
        $data['list_unit']  = $this->Mod->getWhere('unit', array('status !=' => 8))->result_array();
        $data['list_role']  = $this->Mod->GetCustome("SELECT id, name_code, name_role FROM role WHERE status != 8 ORDER BY name_role ASC")->result_array();
        $data['list_kriteria'] = $this->Mod->GetCustome("SELECT id_kriteria, kode_kriteria, nama_kriteria FROM wwc_kriteria WHERE status != 8 ORDER BY urutan ASC")->result_array();

        $this->load->view('template_v2', $data);
    }

    // Halaman detail form penilaian
    public function Detail($id_form = null)
    {
        if (empty($id_form)) { redirect('wwc_form_penilaian'); return; }

        $data["plugin"][]  = "plugin/datatable";
        $data["title"]     = "Detail Form Penilaian";
        $data["title_des"] = "Informasi lengkap form penilaian dan daftar assessor";
        $data["content"]   = "v_detail";

        $data['form'] = $this->Mod->GetCustome("
            SELECT fp.*, u.nama as nama_peserta, u.nik, un.name_unit, r.name_role,
                   (SELECT COUNT(*) FROM wwc_form_assessor fa WHERE fa.id_form = fp.id_form AND fa.status != 8) as jumlah_assessor,
                   (SELECT COUNT(*) FROM wwc_penilaian p WHERE p.id_form = fp.id_form) as jumlah_selesai
            FROM wwc_form_penilaian fp
            LEFT JOIN user u ON fp.id_peserta = u.id
            LEFT JOIN unit un ON fp.id_unit = un.id_unit
            LEFT JOIN role r ON fp.id_role = r.id
            WHERE fp.id_form = " . (int)$id_form . "
        ")->row_array();

        if (empty($data['form'])) { redirect('wwc_form_penilaian'); return; }

        $data['indikator'] = $this->Mod->GetCustome("
            SELECT dff.id_detail_form, i.kode_indikator, i.nama_indikator, i.bobot, i.nilai_min, i.nilai_max,
                   i.deskripsi, k.nama_kriteria, k.kode_kriteria, dff.urutan
            FROM wwc_detail_form_penilaian dff
            JOIN wwc_indikator i ON dff.id_indikator = i.id_indikator
            JOIN wwc_kriteria k ON i.id_kriteria = k.id_kriteria
            WHERE dff.id_form = " . (int)$id_form . " AND dff.status != 8
            ORDER BY k.urutan ASC, dff.urutan ASC
        ")->result_array();

        $data['assessor'] = $this->Mod->GetCustome("
            SELECT fa.id_form_assessor, fa.urutan, fa.catatan, fa.assigned_at, fa.status,
                   u.nama as nama_assessor, u.nik as nik_assessor, u.jabatan,
                   (SELECT COUNT(*) FROM wwc_penilaian p WHERE p.id_form_assessor = fa.id_form_assessor) as sudah_dinilai
            FROM wwc_form_assessor fa
            JOIN user u ON fa.id_user = u.id
            WHERE fa.id_form = " . (int)$id_form . " AND fa.status != 8
            ORDER BY fa.urutan ASC
        ")->result_array();

        $this->load->view('template_v2', $data);
    }

    // Load daftar form (AJAX)
    public function LoadData()
    {
        $id_unit = $this->input->post('id_unit');
        $id_role = $this->input->post('id_role');
        $status  = $this->input->post('status');

        $where = "fp.status != 8";
        if (!empty($id_unit)) $where .= " AND fp.id_unit = " . (int)$id_unit;
        if (!empty($id_role)) $where .= " AND fp.id_role = " . (int)$id_role;
        if ($status !== null && $status !== '') $where .= " AND fp.status = " . (int)$status;

        $data = $this->Mod->GetCustome("
            SELECT fp.id_form, fp.kode_form, fp.nama_form, fp.tanggal_penilaian, fp.lokasi, fp.status,
                   fp.id_unit, fp.id_role,
                   un.name_unit,
                   r.name_role,
                   (SELECT COUNT(*) FROM wwc_detail_form_penilaian d WHERE d.id_form = fp.id_form AND d.status != 8) as jumlah_indikator,
                   (SELECT COUNT(*) FROM wwc_form_assessor fa WHERE fa.id_form = fp.id_form AND fa.status != 8) as jumlah_assessor,
                   (SELECT COUNT(*) FROM wwc_penilaian p WHERE p.id_form = fp.id_form) as jumlah_selesai
            FROM wwc_form_penilaian fp
            LEFT JOIN unit un ON fp.id_unit = un.id_unit
            LEFT JOIN role r ON fp.id_role = r.id
            WHERE $where
            ORDER BY fp.id_form DESC
        ")->result_array();

        echo json_encode($data);
    }

    // Load indikator untuk checklist di modal form berdasarkan Unit & Role
    public function LoadIndikatorByUnitRole()
    {
        $id_unit     = $this->input->post('id_unit');
        $id_role     = $this->input->post('id_role');
        $id_kriteria = $this->input->post('id_kriteria');

        $where = "i.status != 8";
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
            WHERE $where
            ORDER BY k.urutan ASC, i.urutan ASC
        ")->result_array();

        echo json_encode($data);
    }

    // Load Role yang tersedia untuk suatu unit
    public function LoadRole()
    {
        $id_unit = $this->input->post('id_unit');

        if (empty($id_unit)) {
            $data = $this->Mod->GetCustome("SELECT id, name_code, name_role FROM role WHERE status != 8 ORDER BY name_role ASC")->result_array();
        } else {
            $data = $this->Mod->GetCustome("
                SELECT DISTINCT r.id, r.name_code, r.name_role
                FROM role r
                INNER JOIN wwc_unit_indikator ui ON ui.id_role = r.id
                WHERE ui.id_unit = " . (int)$id_unit . "
                AND r.status != 8
                ORDER BY r.name_role ASC
            ")->result_array();

            if (empty($data)) {
                $data = $this->Mod->GetCustome("SELECT id, name_code, name_role FROM role WHERE status != 8 ORDER BY name_role ASC")->result_array();
            }
        }

        echo json_encode($data);
    }

    // Ambil data form untuk edit (AJAX)
    public function EditData($id = null)
    {
        if (empty($id)) { echo json_encode([]); return; }

        $form = $this->Mod->getWhere('wwc_form_penilaian', array('id_form' => $id))->row_array();
        $detail = $this->Mod->GetCustome("
            SELECT id_indikator FROM wwc_detail_form_penilaian WHERE id_form = " . (int)$id . " AND status != 8
        ")->result_array();

        $form['indikator_ids'] = array_column($detail, 'id_indikator');
        echo json_encode($form);
    }

    // Ambil indikator dari suatu form (AJAX - untuk form assessor / penilaian)
    public function GetIndikatorForm($id_form = null)
    {
        if (empty($id_form)) { echo json_encode([]); return; }

        $data = $this->Mod->GetCustome("
            SELECT dff.id_detail_form, i.id_indikator, i.kode_indikator, i.nama_indikator, 
                   i.bobot, i.nilai_min, i.nilai_max, i.deskripsi,
                   k.nama_kriteria, k.kode_kriteria
            FROM wwc_detail_form_penilaian dff
            JOIN wwc_indikator i ON dff.id_indikator = i.id_indikator
            JOIN wwc_kriteria k ON i.id_kriteria = k.id_kriteria
            WHERE dff.id_form = " . (int)$id_form . " AND dff.status != 8
            ORDER BY k.urutan ASC, dff.urutan ASC
        ")->result_array();

        echo json_encode($data);
    }

    // Simpan form penilaian baru (AJAX + Transaksi DB)
    public function SaveData()
    {
        $nama_form        = trim($this->input->post('nama_form'));
        $id_unit          = $this->input->post('id_unit');
        $id_role          = $this->input->post('id_role');
        $tanggal_penilaian = $this->input->post('tanggal_penilaian');
        $lokasi           = $this->input->post('lokasi');
        $catatan          = $this->input->post('catatan');
        $id_indikator_arr = $this->input->post('id_indikator'); // array

        if (empty($nama_form) || empty($id_unit) || empty($id_role) || empty($tanggal_penilaian)) {
            echo json_encode(['status' => '400', 'msg' => 'Nama Form, Unit, Role, dan Tanggal wajib diisi.']); return;
        }
        if (empty($id_indikator_arr) || !is_array($id_indikator_arr)) {
            echo json_encode(['status' => '400', 'msg' => 'Minimal satu indikator harus dipilih.']); return;
        }

        // Generate kode form otomatis
        $count = $this->Mod->GetCustome("SELECT COUNT(*) as total FROM wwc_form_penilaian")->row_array();
        $kode_form = 'WWC-' . date('Ymd') . '-' . str_pad((int)$count['total'] + 1, 4, '0', STR_PAD_LEFT);

        $this->db->trans_begin();
        try {
            // Insert header
            $header = [
                'kode_form'        => $kode_form,
                'nama_form'        => $nama_form,
                'id_peserta'       => null,
                'id_unit'          => (int)$id_unit,
                'id_role'          => (int)$id_role,
                'tanggal_penilaian' => $tanggal_penilaian,
                'lokasi'           => $lokasi,
                'catatan'          => $catatan,
                'status'           => 0,
                'id_created_by'    => sess()['id'],
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('wwc_form_penilaian', $header);
            $id_form = $this->db->insert_id();

            // Insert detail indikator
            $urutan = 1;
            foreach ($id_indikator_arr as $id_ind) {
                $this->db->insert('wwc_detail_form_penilaian', [
                    'id_form'      => $id_form,
                    'id_indikator' => (int)$id_ind,
                    'urutan'       => $urutan,
                    'status'       => 0,
                ]);
                $urutan++;
            }

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                echo json_encode(['status' => '400', 'msg' => 'Gagal menyimpan data. Silakan coba lagi.']);
            } else {
                $this->db->trans_commit();
                echo json_encode(['status' => '200', 'msg' => 'Form Penilaian berhasil disimpan dengan kode ' . $kode_form . '.', 'id_form' => $id_form]);
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo json_encode(['status' => '400', 'msg' => 'Error: ' . $e->getMessage()]);
        }
    }

    // Update form penilaian (AJAX + Transaksi DB)
    public function UpdateData($id = null)
    {
        if (empty($id)) { echo json_encode(['status' => '400', 'msg' => 'ID tidak valid.']); return; }

        // Cek status form - form completed tidak bisa diedit kecuali super admin
        $form = $this->Mod->getWhere('wwc_form_penilaian', array('id_form' => $id))->row_array();
        if ($form['status'] == 2 && sess()['type_user'] != 'super') {
            echo json_encode(['status' => '400', 'msg' => 'Form berstatus Completed tidak dapat diubah.']); return;
        }

        $nama_form        = trim($this->input->post('nama_form'));
        $id_unit          = $this->input->post('id_unit');
        $id_role          = $this->input->post('id_role');
        $tanggal_penilaian = $this->input->post('tanggal_penilaian');
        $lokasi           = $this->input->post('lokasi');
        $catatan          = $this->input->post('catatan');
        $id_indikator_arr = $this->input->post('id_indikator');

        if (empty($nama_form) || empty($id_unit) || empty($id_role) || empty($tanggal_penilaian)) {
            echo json_encode(['status' => '400', 'msg' => 'Nama Form, Unit, Role, dan Tanggal wajib diisi.']); return;
        }
        if (empty($id_indikator_arr) || !is_array($id_indikator_arr)) {
            echo json_encode(['status' => '400', 'msg' => 'Minimal satu indikator harus dipilih.']); return;
        }

        $this->db->trans_begin();
        try {
            // Update header
            $header = [
                'nama_form'        => $nama_form,
                'id_unit'          => (int)$id_unit,
                'id_role'          => (int)$id_role,
                'tanggal_penilaian' => $tanggal_penilaian,
                'lokasi'           => $lokasi,
                'catatan'          => $catatan,
                'updated_at'       => date('Y-m-d H:i:s'),
            ];
            $this->Mod->update2('wwc_form_penilaian', array('id_form' => $id), $header);

            // Hapus detail lama & re-insert
            $this->db->where('id_form', $id)->delete('wwc_detail_form_penilaian');
            $urutan = 1;
            foreach ($id_indikator_arr as $id_ind) {
                $this->db->insert('wwc_detail_form_penilaian', [
                    'id_form'      => (int)$id,
                    'id_indikator' => (int)$id_ind,
                    'urutan'       => $urutan,
                    'status'       => 0,
                ]);
                $urutan++;
            }

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                echo json_encode(['status' => '400', 'msg' => 'Gagal mengupdate data.']);
            } else {
                $this->db->trans_commit();
                echo json_encode(['status' => '200', 'msg' => 'Form Penilaian berhasil diupdate.']);
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo json_encode(['status' => '400', 'msg' => 'Error: ' . $e->getMessage()]);
        }
    }

    // Publish form (AJAX)
    public function Publish($id = null)
    {
        if (empty($id)) { echo json_encode(['status' => '400', 'msg' => 'ID tidak valid.']); return; }
        $this->Mod->update2('wwc_form_penilaian', array('id_form' => $id), ['status' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
        echo json_encode(['status' => '200', 'msg' => 'Form berhasil dipublish.']);
    }

    // Duplicate form (AJAX + Transaksi DB)
    public function Duplicate($id = null)
    {
        if (empty($id)) { echo json_encode(['status' => '400', 'msg' => 'ID tidak valid.']); return; }

        $form = $this->Mod->getWhere('wwc_form_penilaian', array('id_form' => $id))->row_array();
        if (empty($form)) { echo json_encode(['status' => '400', 'msg' => 'Data tidak ditemukan.']); return; }

        $detail = $this->Mod->GetCustome("SELECT id_indikator, urutan FROM wwc_detail_form_penilaian WHERE id_form = " . (int)$id . " AND status != 8")->result_array();

        $count = $this->Mod->GetCustome("SELECT COUNT(*) as total FROM wwc_form_penilaian")->row_array();
        $kode_baru = 'WWC-' . date('Ymd') . '-' . str_pad((int)$count['total'] + 1, 4, '0', STR_PAD_LEFT);

        $this->db->trans_begin();
        try {
            $new_header = [
                'kode_form'        => $kode_baru,
                'nama_form'        => $form['nama_form'] . ' (Copy)',
                'id_peserta'       => $form['id_peserta'],
                'id_unit'          => $form['id_unit'],
                'id_role'          => $form['id_role'],
                'tanggal_penilaian' => $form['tanggal_penilaian'],
                'lokasi'           => $form['lokasi'],
                'catatan'          => $form['catatan'],
                'status'           => 0,
                'id_created_by'    => sess()['id'],
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('wwc_form_penilaian', $new_header);
            $new_id = $this->db->insert_id();

            foreach ($detail as $d) {
                $this->db->insert('wwc_detail_form_penilaian', [
                    'id_form'      => $new_id,
                    'id_indikator' => $d['id_indikator'],
                    'urutan'       => $d['urutan'],
                    'status'       => 0,
                ]);
            }

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                echo json_encode(['status' => '400', 'msg' => 'Gagal menduplikasi form.']);
            } else {
                $this->db->trans_commit();
                echo json_encode(['status' => '200', 'msg' => 'Form berhasil diduplikasi dengan kode ' . $kode_baru . '.']);
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo json_encode(['status' => '400', 'msg' => 'Error: ' . $e->getMessage()]);
        }
    }

    // Soft delete form (AJAX)
    public function Delete($id = null)
    {
        if (empty($id)) { echo json_encode(['status' => '400', 'msg' => 'ID tidak valid.']); return; }

        $form = $this->Mod->getWhere('wwc_form_penilaian', array('id_form' => $id))->row_array();
        if ($form['status'] != 0) {
            echo json_encode(['status' => '400', 'msg' => 'Hanya form berstatus Draft yang dapat dihapus.']); return;
        }

        $this->Mod->update2('wwc_form_penilaian', array('id_form' => $id), ['status' => 8, 'updated_at' => date('Y-m-d H:i:s')]);
        echo json_encode(['status' => '200', 'msg' => 'Form berhasil dihapus.']);
    }
}
