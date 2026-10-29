<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cbt_ujian extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("m_data");
    }

    // =========================================================
    // INDEX
    // =========================================================
    public function index()
    {
        $data["plugin"][]  = "plugin/datatable";
        $data["plugin"][]  = "plugin/select2";
        $data["title"]     = "Master Ujian CBT";
        $data["title_des"] = "Manajemen Ujian Computer-Based Test";   
        $data["content"]   = "v_index";

        $data['unit'] = $this->Mod->getWhere('unit', array('status !=' => 8))->result_array();
        $data['role'] = $this->Mod->getWhere('role', array('status' => 1))->result_array();

        $this->load->view('template_v2', $data);
    }

    // =========================================================
    // LOAD DATA — Daftar ujian sesuai filter status
    // =========================================================
    function LoadData()
    {
        $status = $this->input->post('status');

        $whereStatus = "";
        if ($status !== null && $status !== '') {
            $whereStatus = " AND u.status = " . (int)$status;
        } else {
            $whereStatus = " AND u.status != 8";
        }

        $data = $this->Mod->GetCustome("
            SELECT u.*, un.name_unit, r.name_role,
                   (SELECT COUNT(*) FROM cbt_detail_ujian d WHERE d.id_ujian_cbt = u.id_ujian_cbt) AS jumlah_soal_terpilih
            FROM cbt_ujian u
            LEFT JOIN unit un ON un.id_unit = u.id_unit
            LEFT JOIN role r ON r.id = u.id_role
            WHERE 1=1 $whereStatus
            ORDER BY u.id_ujian_cbt DESC
        ")->result_array();

        echo json_encode($data);
    }

    // =========================================================
    // LOAD BANK SOAL — Soal aktif untuk checklist pemilihan
    // =========================================================
    function LoadBankSoal()
    {
        $id_unit = $this->input->post('id_unit');
        $id_role = $this->input->post('id_role');

        $whereUnit = "";
        if (!empty($id_unit)) {
            $whereUnit = " AND EXISTS (
                SELECT 1 FROM cbt_unit_bank_soal ubs
                WHERE ubs.id_bank_soal = b.id_bank_soal_cbt
                AND ubs.id_unit = " . (int)$id_unit . "
            )";
        }
        if (!empty($id_role)) {
            $whereUnit .= " AND EXISTS (
                SELECT 1 FROM cbt_unit_bank_soal ubs2
                WHERE ubs2.id_bank_soal = b.id_bank_soal_cbt
                AND ubs2.id_role = " . (int)$id_role . "
            )";
        }

        $data = $this->Mod->GetCustome("
            SELECT b.id_bank_soal_cbt, b.pertanyaan, b.jawaban, b.bobot
            FROM cbt_bank_soal b
            WHERE b.status = 1
            $whereUnit
            ORDER BY b.id_bank_soal_cbt ASC
        ")->result_array();

        echo json_encode($data);
    }

    // =========================================================
    // LOAD ROLE — Role yang punya soal di unit tertentu
    // =========================================================
    function LoadRole()
    {
        $id_unit = $this->input->post('id_unit');

        if (empty($id_unit)) {
            $data = $this->Mod->getWhere('role', array('status' => 1))->result_array();
        } else {
            $data = $this->Mod->GetCustome("
                SELECT DISTINCT r.id, r.name_code, r.name_role
                FROM role r
                INNER JOIN cbt_unit_bank_soal ubs ON ubs.id_role = r.id
                WHERE ubs.id_unit = " . (int)$id_unit . "
                AND r.status = 1
                ORDER BY r.name_role ASC
            ")->result_array();
        }

        echo json_encode($data);
    }

    // =========================================================
    // LOAD SOAL TERPILIH — Soal yang sudah dipilih di ujian ini
    // =========================================================
    function LoadSoalTerpilih($id_ujian = null)
    {
        if (empty($id_ujian)) {
            echo json_encode([]);
            return;
        }
        $data = $this->Mod->GetCustome("
            SELECT id_bank_soal_cbt FROM cbt_detail_ujian WHERE id_ujian_cbt = " . (int)$id_ujian
        )->result_array();

        echo json_encode(array_column($data, 'id_bank_soal_cbt'));
    }

    // =========================================================
    // SAVE DATA — Buat ujian baru
    // =========================================================
    public function SaveData()
    {
        $post = $this->input->post(null, true);

        if (empty($post['nama_ujian_cbt'])) {
            echo json_encode(['status' => '400', 'msg' => 'Nama ujian tidak boleh kosong']);
            return;
        }

        $data_insert = [
            'nama_ujian_cbt'  => $post['nama_ujian_cbt'],
            'id_unit'         => (int)$post['id_unit'],
            'id_role'         => !empty($post['id_role']) ? (int)$post['id_role'] : null,
            'tanggal_mulai'   => $post['tanggal_mulai'],
            'tanggal_selesai' => $post['tanggal_selesai'],
            'durasi_menit'    => isset($post['durasi_menit']) ? (int)$post['durasi_menit'] : 60,
            'jumlah_soal'     => isset($post['jumlah_soal']) ? (int)$post['jumlah_soal'] : 0,
            'acak_soal'       => isset($post['acak_soal']) ? 1 : 0,
            'acak_jawaban'    => isset($post['acak_jawaban']) ? 1 : 0,
            'status'          => 0,
            'user_created'    => sess()['id'],
            'token'           => strtoupper(substr(md5(time() . rand()), 0, 6)),
        ];

        $this->db->insert('cbt_ujian', $data_insert);
        $id_ujian = $this->db->insert_id();

        // Insert soal yang dipilih
        if (!empty($post['soal_ids']) && is_array($post['soal_ids'])) {
            foreach ($post['soal_ids'] as $id_soal) {
                $this->db->insert('cbt_detail_ujian', [
                    'id_ujian_cbt'    => $id_ujian,
                    'id_bank_soal_cbt' => (int)$id_soal,
                ]);
            }
        }

        echo json_encode(['status' => '200', 'msg' => 'Ujian berhasil dibuat', 'id' => $id_ujian]);
    }

    // =========================================================
    // EDIT DATA
    // =========================================================
    function EditData($id = null)
    {
        if (empty($id)) {
            echo json_encode(['status' => '400', 'msg' => 'ID tidak valid']);
            return;
        }

        $ujian = $this->Mod->getWhere('cbt_ujian', ['id_ujian_cbt' => $id])->row_array();

        // Soal yang sudah dipilih
        $soal_ids = $this->Mod->GetCustome("
            SELECT id_bank_soal_cbt FROM cbt_detail_ujian WHERE id_ujian_cbt = $id
        ")->result_array();
        $ujian['selected_soal'] = array_column($soal_ids, 'id_bank_soal_cbt');

        echo json_encode($ujian);
    }

    // =========================================================
    // UPDATE DATA
    // =========================================================
    public function UpdateData($id = null)
    {
        if (empty($id)) {
            echo json_encode(['status' => '400', 'msg' => 'ID tidak valid']);
            return;
        }

        $post = $this->input->post(null, true);

        $data_update = [
            'nama_ujian_cbt'  => $post['nama_ujian_cbt'],
            'id_unit'         => (int)$post['id_unit'],
            'id_role'         => !empty($post['id_role']) ? (int)$post['id_role'] : null,
            'tanggal_mulai'   => $post['tanggal_mulai'],
            'tanggal_selesai' => $post['tanggal_selesai'],
            'durasi_menit'    => (int)$post['durasi_menit'],
            'jumlah_soal'     => (int)$post['jumlah_soal'],
            'acak_soal'       => isset($post['acak_soal']) ? 1 : 0,
            'acak_jawaban'    => isset($post['acak_jawaban']) ? 1 : 0,
        ];

        $this->Mod->update2('cbt_ujian', ['id_ujian_cbt' => $id], $data_update);

        // Sync soal
        $this->db->delete('cbt_detail_ujian', ['id_ujian_cbt' => $id]);
        if (!empty($post['soal_ids']) && is_array($post['soal_ids'])) {
            foreach ($post['soal_ids'] as $id_soal) {
                $this->db->insert('cbt_detail_ujian', [
                    'id_ujian_cbt'    => $id,
                    'id_bank_soal_cbt' => (int)$id_soal,
                ]);
            }
        }

        echo json_encode(['status' => '200', 'msg' => 'Ujian berhasil diperbarui']);
    }

    // =========================================================
    // REGENERATE TOKEN
    // =========================================================
    public function RegenerateToken($id = null)
    {
        if (empty($id)) {
            echo json_encode(['status' => '400', 'msg' => 'ID tidak valid']);
            return;
        }
        $new_token = strtoupper(substr(md5(time() . rand()), 0, 6));
        $this->Mod->update2('cbt_ujian', ['id_ujian_cbt' => $id], ['token' => $new_token]);
        echo json_encode(['status' => '200', 'msg' => 'Token berhasil diperbarui', 'token' => $new_token]);
    }

    // =========================================================
    // PUBLISH — status = 1
    // =========================================================
    public function PublishUjian($id = null)
    {
        if (empty($id)) {
            echo json_encode(['status' => '400', 'msg' => 'ID tidak valid']);
            return;
        }
        // Cek minimal ada soal
        $count = $this->db->where('id_ujian_cbt', $id)->count_all_results('cbt_detail_ujian');
        if ($count == 0) {
            echo json_encode(['status' => '400', 'msg' => 'Ujian belum memiliki soal. Tambahkan soal terlebih dahulu.']);
            return;
        }
        $this->Mod->update2('cbt_ujian', ['id_ujian_cbt' => $id], ['status' => 1]);
        echo json_encode(['status' => '200', 'msg' => 'Ujian berhasil dipublikasikan']);
    }

    // =========================================================
    // TUTUP — status = 2
    // =========================================================
    public function TutupUjian($id = null)
    {
        if (empty($id)) {
            echo json_encode(['status' => '400', 'msg' => 'ID tidak valid']);
            return;
        }
        $this->Mod->update2('cbt_ujian', ['id_ujian_cbt' => $id], ['status' => 2]);
        echo json_encode(['status' => '200', 'msg' => 'Ujian berhasil ditutup']);
    }

    // =========================================================
    // DELETE — Soft delete
    // =========================================================
    public function Delete($id = null)
    {
        if (empty($id)) {
            echo json_encode(['status' => '400', 'msg' => 'ID tidak valid']);
            return;
        }
        $this->Mod->update2('cbt_ujian', ['id_ujian_cbt' => $id], ['status' => 8]);
        echo json_encode(['status' => '200', 'msg' => 'Ujian berhasil dihapus']);
    }

    // =========================================================
    // GET DETAIL SOAL UJIAN — Seluruh butir soal dalam ujian
    // =========================================================
    public function GetDetailSoalUjian($id = null)
    {
        if (empty($id)) {
            echo json_encode(['status' => '400', 'msg' => 'ID ujian tidak valid', 'soal' => []]);
            return;
        }

        $ujian = $this->Mod->GetCustome("
            SELECT u.*, un.name_unit, r.name_role
            FROM cbt_ujian u
            LEFT JOIN unit un ON un.id_unit = u.id_unit
            LEFT JOIN role r ON r.id = u.id_role
            WHERE u.id_ujian_cbt = " . (int)$id . "
        ")->row_array();

        if (empty($ujian)) {
            echo json_encode(['status' => '404', 'msg' => 'Data ujian tidak ditemukan', 'soal' => []]);
            return;
        }

        $soal = $this->Mod->GetCustome("
            SELECT b.id_bank_soal_cbt, b.pertanyaan, b.opsi_a, b.opsi_b, b.opsi_c, b.opsi_d, b.jawaban, b.bobot
            FROM cbt_detail_ujian d
            INNER JOIN cbt_bank_soal b ON b.id_bank_soal_cbt = d.id_bank_soal_cbt
            WHERE d.id_ujian_cbt = " . (int)$id . "
            ORDER BY d.id_detail_ujian_cbt ASC
        ")->result_array();

        $total_bobot = 0;
        foreach ($soal as $s) {
            $total_bobot += (int)($s['bobot'] ?? 0);
        }

        echo json_encode([
            'status'      => '200',
            'ujian'       => $ujian,
            'soal'        => $soal,
            'total_soal'  => count($soal),
            'total_bobot' => $total_bobot
        ]);
    }

    // =========================================================
    // PREVIEW SOAL TERPILIH — Preview butir soal yang dicentang di form
    // =========================================================
    public function PreviewSoalTerpilih()
    {
        $soal_ids = $this->input->post('soal_ids');
        if (empty($soal_ids) || !is_array($soal_ids)) {
            echo json_encode(['status' => '400', 'msg' => 'Belum ada soal yang dipilih', 'soal' => []]);
            return;
        }

        $clean_ids = array_map('intval', $soal_ids);
        $ids_str = implode(',', $clean_ids);

        $soal = $this->Mod->GetCustome("
            SELECT b.id_bank_soal_cbt, b.pertanyaan, b.opsi_a, b.opsi_b, b.opsi_c, b.opsi_d, b.jawaban, b.bobot
            FROM cbt_bank_soal b
            WHERE b.id_bank_soal_cbt IN ($ids_str)
            ORDER BY FIELD(b.id_bank_soal_cbt, $ids_str)
        ")->result_array();

        $total_bobot = 0;
        foreach ($soal as $s) {
            $total_bobot += (int)($s['bobot'] ?? 0);
        }

        echo json_encode([
            'status'      => '200',
            'soal'        => $soal,
            'total_soal'  => count($soal),
            'total_bobot' => $total_bobot
        ]);
    }
}

