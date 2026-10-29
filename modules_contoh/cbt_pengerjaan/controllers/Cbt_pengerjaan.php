<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cbt_pengerjaan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("m_data");
        date_default_timezone_set('Asia/Jakarta');
    }

    // =========================================================
    // INDEX — Daftar ujian aktif sesuai unit peserta
    // =========================================================
    public function index()
    {
        $data["plugin"][]  = "plugin/datatable";
        $data["plugin"][]  = "plugin/sweetalert";
        $data["title"]     = "Pengerjaan Ujian CBT";
        $data["title_des"] = "Daftar Ujian yang Tersedia";
        $data["content"]   = "v_index";

        $id_unit = isset(sess()['unit']) ? (int)sess()['unit'] : 0;
        $id_user = sess()['id'];
        $type_user = sess()['type_user'] ?? '';
        $id_role = (int)$type_user; // type_user menyimpan id role
        $now     = date('Y-m-d H:i:s');

        // Jika admin, abaikan filter unit, waktu, dan status agar bisa test semua
        if ($type_user == 'super') {
            $whereFilter = "";
        } else {
            $whereFilter = "AND u.status = 1 AND u.id_unit = $id_unit AND u.tanggal_mulai <= '$now' AND u.tanggal_selesai >= '$now'
                            AND (u.id_role IS NULL OR u.id_role = $id_role)";
        }

        // Ujian yang sesuai filter
        $data['ujian'] = $this->Mod->GetCustome("
            SELECT u.*,
                h.id_hasil_ujian_cbt,
                h.nilai,
                h.status AS status_pengerjaan,
                r.name_role
            FROM cbt_ujian u
            LEFT JOIN cbt_hasil_ujian h
                ON h.id_ujian_cbt = u.id_ujian_cbt AND h.id_user = $id_user
            LEFT JOIN role r ON r.id = u.id_role
            WHERE 1=1
              $whereFilter
            ORDER BY u.tanggal_mulai ASC
        ")->result_array();

        $this->load->view('template_v2', $data);
    }

    // =========================================================
    // VALIDASI TOKEN
    // =========================================================
    public function ValidasiToken()
    {
        $id_ujian = $this->input->post('id_ujian');
        $token = strtoupper(trim($this->input->post('token')));

        if (empty($id_ujian) || empty($token)) {
            echo json_encode(['status' => '400', 'msg' => 'Data tidak lengkap']);
            return;
        }

        $ujian = $this->Mod->getWhere('cbt_ujian', ['id_ujian_cbt' => $id_ujian])->row_array();
        if (!$ujian) {
            echo json_encode(['status' => '404', 'msg' => 'Ujian tidak ditemukan']);
            return;
        }

        if (strtoupper($ujian['token']) === $token) {
            $this->session->set_userdata('token_ujian_'.$id_ujian, true);
            echo json_encode(['status' => '200', 'msg' => 'Token Valid']);
        } else {
            echo json_encode(['status' => '400', 'msg' => 'Token ujian tidak valid!']);
        }
    }

    // =========================================================
    // MULAI UJIAN — Validasi + buat sesi / lanjutkan sesi
    // =========================================================
    public function MulaiUjian($id_ujian = null)
    {
        if (empty($id_ujian)) {
            show_error('ID Ujian tidak valid');
            return;
        }

        $id_user = sess()['id'];
        $type_user = sess()['type_user'] ?? '';
        $id_unit = isset(sess()['unit']) ? (int)sess()['unit'] : 0;
        $now     = date('Y-m-d H:i:s');

        // Validasi keberadaan ujian
        $ujian = $this->Mod->getWhere('cbt_ujian', ['id_ujian_cbt' => $id_ujian])->row_array();
        if (!$ujian) {
            redirect(base_url('cbt_pengerjaan'));
            return;
        }
        
        // Validasi Unit, Waktu, Status, dan Role (Kecuali admin)
        if ($type_user != 'super') {
            if ($ujian['status'] != 1) {
                redirect(base_url('cbt_pengerjaan'));
                return;
            }
            if ($ujian['id_unit'] != $id_unit) {
                redirect(base_url('cbt_pengerjaan'));
                return;
            }
            if ($now < $ujian['tanggal_mulai'] || $now > $ujian['tanggal_selesai']) {
                redirect(base_url('cbt_pengerjaan'));
                return;
            }
            // Validasi Role: jika ujian punya id_role, harus cocok dengan role user
            if (!empty($ujian['id_role']) && $ujian['id_role'] != $type_user) {
                redirect(base_url('cbt_pengerjaan'));
                return;
            }
        }

        // Cek Token via Session (kecuali kalau sudah punya sesi berjalan, kita izinkan langsung)
        // Kita periksa session ini HANYA jika ujian baru akan dimulai. 
        // Jika statusnya melanjutkan, akan lolos di bawah ini.
        $has_token = $this->session->userdata('token_ujian_'.$id_ujian);

        // Cek apakah sudah ada sesi
        $existing = $this->Mod->getWhere('cbt_hasil_ujian', [
            'id_ujian_cbt' => $id_ujian,
            'id_user'      => $id_user
        ])->row_array();

        if ($existing) {
            // Sudah selesai → redirect ke hasil
            if ($existing['status'] == 1) {
                redirect(base_url('cbt_pengerjaan/HasilUjian/' . $existing['id_hasil_ujian_cbt']));
                return;
            }
            // Lanjutkan
            redirect(base_url('cbt_pengerjaan/KerjakanUjian/' . $existing['id_hasil_ujian_cbt']));
            return;
        }

        // Jika belum ada sesi (ujian baru), wajib punya token dari form
        if (!$has_token) {
            redirect(base_url('cbt_pengerjaan'));
            return;
        }

        // Buat sesi baru
        $this->db->insert('cbt_hasil_ujian', [
            'id_ujian_cbt'  => $id_ujian,
            'id_user'       => $id_user,
            'tanggal_mulai' => $now,
            'status'        => 0,
        ]);
        $id_hasil = $this->db->insert_id();

        // Pastikan jawaban benar-benar fresh (jaga-jaga jika ada data yatim/orphan dari truncate manual)
        $this->db->delete('cbt_detail_hasil_ujian', ['id_hasil_ujian_cbt' => $id_hasil]);

        redirect(base_url('cbt_pengerjaan/KerjakanUjian/' . $id_hasil));
    }

    // =========================================================
    // KERJAKAN UJIAN — Halaman pengerjaan soal
    // =========================================================
    public function KerjakanUjian($id_hasil = null)
    {
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        if (empty($id_hasil)) {
            redirect(base_url('cbt_pengerjaan'));
            return;
        }

        $id_user = sess()['id'];

        $hasil = $this->Mod->getWhere('cbt_hasil_ujian', ['id_hasil_ujian_cbt' => $id_hasil, 'id_user' => $id_user])->row_array();
        if (!$hasil || $hasil['status'] == 1) {
            redirect(base_url('cbt_pengerjaan'));
            return;
        }

        $ujian = $this->Mod->getWhere('cbt_ujian', ['id_ujian_cbt' => $hasil['id_ujian_cbt']])->row_array();

        // --- SMART PROCTORING: Init Proses Ujian ---
        $id_ujian = $ujian['id_ujian_cbt'];
        $proses = $this->Mod->getWhere('cbt_proses_ujian', [
            'id_ujian_cbt' => $id_ujian,
            'id_user'      => $id_user
        ])->row_array();
        
        if (!$proses) {
            $this->db->insert('cbt_proses_ujian', [
                'id_ujian_cbt' => $id_ujian,
                'id_user'      => $id_user,
                'status'       => 'Sedang Mengerjakan',
                'waktu_mulai'  => date('Y-m-d H:i:s'),
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ]);
            $id_proses = $this->db->insert_id();
        } else {
            $id_proses = $proses['id_proses_ujian_cbt'];
        }
        $data['id_proses'] = $id_proses;
        // -------------------------------------------

        // Ambil soal sesuai ujian
        $soal_query = "
            SELECT b.id_bank_soal_cbt, b.pertanyaan, b.opsi_a, b.opsi_b, b.opsi_c, b.opsi_d, b.bobot
            FROM cbt_detail_ujian d
            JOIN cbt_bank_soal b ON b.id_bank_soal_cbt = d.id_bank_soal_cbt
            WHERE d.id_ujian_cbt = " . (int)$ujian['id_ujian_cbt'];

        if ($ujian['acak_soal'] == 1) $soal_query .= " ORDER BY RAND()";

        $soal_list = $this->Mod->GetCustome($soal_query)->result_array();

        // Jika acak jawaban, acak opsi per soal
        if ($ujian['acak_jawaban'] == 1) {
            foreach ($soal_list as &$s) {
                $opsi = ['a' => $s['opsi_a'], 'b' => $s['opsi_b'], 'c' => $s['opsi_c'], 'd' => $s['opsi_d']];
                $keys = array_keys($opsi); shuffle($keys);
                $new_opsi = [];
                foreach ($keys as $k) $new_opsi[$k] = $opsi[$k];
                $s['opsi_a'] = $new_opsi['a'] ?? $s['opsi_a'];
                $s['opsi_b'] = $new_opsi['b'] ?? $s['opsi_b'];
                $s['opsi_c'] = $new_opsi['c'] ?? $s['opsi_c'];
                $s['opsi_d'] = $new_opsi['d'] ?? $s['opsi_d'];
            }
        }

        // Ambil jawaban yang sudah dijawab
        $jawaban_done = $this->Mod->GetCustome("
            SELECT id_bank_soal_cbt, jawaban_user
            FROM cbt_detail_hasil_ujian
            WHERE id_hasil_ujian_cbt = $id_hasil
        ")->result_array();

        $jawaban_map = [];
        foreach ($jawaban_done as $j) {
            $jawaban_map[$j['id_bank_soal_cbt']] = $j['jawaban_user'];
        }

        // Hitung sisa waktu
        $mulai = strtotime($hasil['tanggal_mulai']);
        $durasi_detik = (int)$ujian['durasi_menit'] * 60;
        $sisa_detik = max(0, ($mulai + $durasi_detik) - time());

        $data["plugin"][]    = "plugin/datatable";
        $data["title"]       = "Pengerjaan: " . $ujian['nama_ujian_cbt'];
        $data["title_des"]   = "Kerjakan soal di bawah ini sebelum waktu habis";
        $data["content"]     = "v_pengerjaan";
        $data['ujian']       = $ujian;
        $data['soal_list']   = $soal_list;
        $data['jawaban_map'] = $jawaban_map;
        $data['id_hasil']    = $id_hasil;
        $data['sisa_detik']  = $sisa_detik;

        $this->load->view('template_v2', $data);
    }

    // =========================================================
    // SIMPAN JAWABAN — AJAX, simpan/update per soal
    // =========================================================
    public function SimpanJawaban()
    {
        $id_hasil      = (int)$this->input->post('id_hasil');
        $id_soal       = (int)$this->input->post('id_soal');
        $jawaban_user  = $this->input->post('jawaban', true);

        if (!$id_hasil || !$id_soal) {
            echo json_encode(['status' => '400', 'msg' => 'Data tidak lengkap']);
            return;
        }

        // Cek apakah sudah ada jawaban
        $existing = $this->Mod->getWhere('cbt_detail_hasil_ujian', [
            'id_hasil_ujian_cbt' => $id_hasil,
            'id_bank_soal_cbt'   => $id_soal
        ])->row_array();

        if ($existing) {
            $this->Mod->update2('cbt_detail_hasil_ujian',
                ['id_detail_hasil_ujian_cbt' => $existing['id_detail_hasil_ujian_cbt']],
                ['jawaban_user' => $jawaban_user]
            );
        } else {
            $this->db->insert('cbt_detail_hasil_ujian', [
                'id_hasil_ujian_cbt' => $id_hasil,
                'id_bank_soal_cbt'   => $id_soal,
                'jawaban_user'       => $jawaban_user,
            ]);
        }

        echo json_encode(['status' => '200', 'msg' => 'Jawaban tersimpan']);
    }

    // =========================================================
    // SUBMIT UJIAN — Hitung nilai, simpan hasil
    // =========================================================
    public function SubmitUjian($id_hasil = null)
    {
        if (empty($id_hasil)) {
            echo json_encode(['status' => '400', 'msg' => 'ID tidak valid']);
            return;
        }

        $id_user = sess()['id'];
        $hasil   = $this->Mod->getWhere('cbt_hasil_ujian', ['id_hasil_ujian_cbt' => $id_hasil, 'id_user' => $id_user])->row_array();

        if (!$hasil || $hasil['status'] == 1) {
            echo json_encode(['status' => '400', 'msg' => 'Ujian sudah selesai atau tidak valid']);
            return;
        }

        // Ambil semua soal di ujian ini (dengan kunci jawaban)
        $soal_ujian = $this->Mod->GetCustome("
            SELECT b.id_bank_soal_cbt, b.jawaban AS kunci, b.bobot
            FROM cbt_detail_ujian d
            JOIN cbt_bank_soal b ON b.id_bank_soal_cbt = d.id_bank_soal_cbt
            WHERE d.id_ujian_cbt = " . (int)$hasil['id_ujian_cbt']
        )->result_array();

        $this->db->trans_start();

        // Ambil jawaban peserta
        $jawaban_peserta = $this->Mod->GetCustome("
            SELECT id_bank_soal_cbt, jawaban_user
            FROM cbt_detail_hasil_ujian
            WHERE id_hasil_ujian_cbt = $id_hasil
        ")->result_array();

        $jawaban_map = [];
        foreach ($jawaban_peserta as $j) {
            $jawaban_map[$j['id_bank_soal_cbt']] = $j['jawaban_user'];
        }

        $jumlah_benar  = 0;
        $jumlah_salah  = 0;
        $jumlah_kosong = 0;
        $total_bobot   = 0;
        $bobot_benar   = 0;

        foreach ($soal_ujian as $s) {
            $total_bobot += $s['bobot'];
            $jawaban_user = isset($jawaban_map[$s['id_bank_soal_cbt']]) ? $jawaban_map[$s['id_bank_soal_cbt']] : null;

            if (empty($jawaban_user)) {
                $jumlah_kosong++;
                $benar_persoal = 0;
                $nilai_persoal = 0;
            } elseif (strtolower($jawaban_user) === strtolower($s['kunci'])) {
                $jumlah_benar++;
                $benar_persoal = 1;
                $nilai_persoal = $s['bobot'];
                $bobot_benar  += $s['bobot'];
            } else {
                $jumlah_salah++;
                $benar_persoal = 0;
                $nilai_persoal = 0;
            }

            // Update/insert detail
            $existing = $this->Mod->getWhere('cbt_detail_hasil_ujian', [
                'id_hasil_ujian_cbt' => $id_hasil,
                'id_bank_soal_cbt'   => $s['id_bank_soal_cbt']
            ])->row_array();

            if ($existing) {
                $this->Mod->update2('cbt_detail_hasil_ujian',
                    ['id_detail_hasil_ujian_cbt' => $existing['id_detail_hasil_ujian_cbt']],
                    ['benar_persoal' => $benar_persoal, 'nilai_diperoleh_persoal' => $nilai_persoal]
                );
            } else {
                // Soal yang tidak dijawab — insert dengan kosong
                $this->db->insert('cbt_detail_hasil_ujian', [
                    'id_hasil_ujian_cbt'      => $id_hasil,
                    'id_bank_soal_cbt'        => $s['id_bank_soal_cbt'],
                    'jawaban_user'            => null,
                    'benar_persoal'           => 0,
                    'nilai_diperoleh_persoal' => 0,
                ]);
            }
        }

        // Hitung nilai akhir (skala 100)
        $nilai = ($total_bobot > 0) ? round(($bobot_benar / $total_bobot) * 100, 2) : 0;
        $jumlah_selesai = count($soal_ujian) - $jumlah_kosong;

        // Update hasil ujian
        $this->Mod->update2('cbt_hasil_ujian', ['id_hasil_ujian_cbt' => $id_hasil], [
            'tanggal_selesai' => date('Y-m-d H:i:s'),
            'jumlah_benar'    => $jumlah_benar,
            'jumlah_selesai'  => $jumlah_selesai,
            'jumlah_kosong'   => $jumlah_kosong,
            'nilai'           => $nilai,
            'status'          => 1,
        ]);

        // --- SMART PROCTORING: Update Proses Ujian ---
        $this->Mod->update2('cbt_proses_ujian', [
            'id_ujian_cbt' => $hasil['id_ujian_cbt'],
            'id_user'      => $id_user,
            'status !='    => 'Selesai'
        ], [
            'status'        => 'Selesai',
            'waktu_selesai' => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        ]);
        // ---------------------------------------------

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            echo json_encode(['status' => '500', 'msg' => 'Gagal submit ujian, silakan coba lagi']);
            return;
        }

        echo json_encode([
            'status' => '200',
            'msg'    => 'Ujian berhasil disubmit',
            'redirect' => base_url('cbt_pengerjaan/HasilUjian/' . $id_hasil)
        ]);
    }

    // =========================================================
    // HASIL UJIAN — Tampilkan ringkasan nilai
    // =========================================================
    public function HasilUjian($id_hasil = null)
    {
        if (empty($id_hasil)) {
            redirect(base_url('cbt_pengerjaan'));
            return;
        }

        $id_user = sess()['id'];
        $hasil   = $this->Mod->getWhere('cbt_hasil_ujian', ['id_hasil_ujian_cbt' => $id_hasil, 'id_user' => $id_user])->row_array();

        if (!$hasil) {
            redirect(base_url('cbt_pengerjaan'));
            return;
        }

        $ujian = $this->Mod->getWhere('cbt_ujian', ['id_ujian_cbt' => $hasil['id_ujian_cbt']])->row_array();

        $data["title"]     = "Hasil Ujian: " . $ujian['nama_ujian_cbt'];
        $data["title_des"] = "Ringkasan Nilai Ujian Anda";
        $data["content"]   = "v_hasil";
        $data["plugin"][]  = "plugin/datatable";
        $data['hasil']     = $hasil;
        $data['ujian']     = $ujian;

        $this->load->view('template_v2', $data);
    }

    // =========================================================
    // SMART PROCTORING — API Log Monitoring
    // =========================================================
    public function LogMonitoring()
    {
        $id_proses  = $this->input->post('id_proses');
        $jenis      = $this->input->post('jenis');
        $nilai      = $this->input->post('nilai');
        $keterangan = $this->input->post('keterangan');
        $foto_bukti = $this->input->post('foto_bukti');

        if (empty($id_proses)) {
            echo json_encode(['status' => '400', 'msg' => 'ID Proses tidak valid']);
            return;
        }

        $this->db->insert('cbt_log_monitoring', [
            'id_proses_ujian_cbt' => $id_proses,
            'jenis'               => $jenis,
            'nilai'               => $nilai,
            'keterangan'          => $keterangan,
            'created_at'          => date('Y-m-d H:i:s')
        ]);
        $id_log = $this->db->insert_id();

        $nama_file = null;
        if (!empty($foto_bukti) && preg_match('/^data:image\/(\w+);base64,/', $foto_bukti)) {
            $proses = $this->Mod->GetCustome("
                SELECT p.id_user, u.nama, p.id_ujian_cbt, uj.id_unit 
                FROM cbt_proses_ujian p
                JOIN user u ON u.id = p.id_user
                JOIN cbt_ujian uj ON uj.id_ujian_cbt = p.id_ujian_cbt
                WHERE p.id_proses_ujian_cbt = " . (int)$id_proses
            )->row_array();

            if ($proses) {
                $id_user = $proses['id_user'];
                $nama_clean = preg_replace('/[^A-Za-z0-9\-]/', '_', $proses['nama']);
                $id_unit = $proses['id_unit'] ? $proses['id_unit'] : '0';
                $hari_jam = date('Ymd_His');

                $dir_rel = "{$id_unit}/{$id_user}_{$nama_clean}/";
                $dir_abs = FCPATH . "upload/log_pelanggaran_ujian/" . $dir_rel;
                if (!is_dir($dir_abs)) mkdir($dir_abs, 0777, true);

                $nama_file_only = "proc_log_{$id_log}_{$hari_jam}.jpg";
                $nama_file_db = $dir_rel . $nama_file_only;

                $data = substr($foto_bukti, strpos($foto_bukti, ',') + 1);
                $data = base64_decode($data);
                file_put_contents($dir_abs . $nama_file_only, $data);

                $this->db->where('id_log_monitoring_cbt', $id_log);
                $this->db->update('cbt_log_monitoring', ['foto_bukti' => $nama_file_db]);
            }
        }

        // Jika ini pelanggaran yang krusial, tambahkan warning_count
        if (in_array($jenis, ['MULTIPLE_FACES', 'FACE_NOT_FOUND', 'LOOK_LEFT', 'LOOK_RIGHT', 'TAB_CHANGE', 'FULLSCREEN_EXIT', 'CAMERA_OFF'])) {
            $this->db->set('warning_count', 'warning_count+1', FALSE);
            $this->db->where('id_proses_ujian_cbt', $id_proses);
            $this->db->update('cbt_proses_ujian');
        }

        echo json_encode(['status' => '200', 'msg' => 'Logged']);
    }

    public function SimpanWajahAwal()
    {
        $id_proses = $this->input->post('id_proses');
        $foto_awal = $this->input->post('foto_awal');

        if (empty($id_proses) || empty($foto_awal)) {
            echo json_encode(['status' => '400', 'msg' => 'Data tidak lengkap']);
            return;
        }

        $nama_file_db = null;
        if (preg_match('/^data:image\/(\w+);base64,/', $foto_awal)) {
            $proses = $this->Mod->GetCustome("
                SELECT p.id_user, u.nama, p.id_ujian_cbt, uj.id_unit 
                FROM cbt_proses_ujian p
                JOIN user u ON u.id = p.id_user
                JOIN cbt_ujian uj ON uj.id_ujian_cbt = p.id_ujian_cbt
                WHERE p.id_proses_ujian_cbt = " . (int)$id_proses
            )->row_array();

            if ($proses) {
                $id_user = $proses['id_user'];
                $nama_clean = preg_replace('/[^A-Za-z0-9\-]/', '_', $proses['nama']);
                $id_unit = $proses['id_unit'] ? $proses['id_unit'] : '0';
                $hari_jam = date('Ymd_His');

                $dir_rel = "{$id_unit}/";
                $dir_abs = FCPATH . "upload/foto_awal_ujian/" . $dir_rel;
                if (!is_dir($dir_abs)) mkdir($dir_abs, 0777, true);

                $pattern = $dir_abs . "{$id_user}_{$nama_clean}_*.jpg";
                $files = glob($pattern);
                $ke = $files ? count($files) + 1 : 1;

                $nama_file_only = "{$id_user}_{$nama_clean}_{$hari_jam}_{$ke}.jpg";
                $nama_file_db = $dir_rel . $nama_file_only;

                $data = substr($foto_awal, strpos($foto_awal, ',') + 1);
                $data = base64_decode($data);
                file_put_contents($dir_abs . $nama_file_only, $data);
            }
        }

        $this->Mod->update2('cbt_proses_ujian', ['id_proses_ujian_cbt' => $id_proses], [
            'foto_awal' => $nama_file_db
        ]);

        echo json_encode(['status' => '200', 'msg' => 'Berhasil']);
    }
}

