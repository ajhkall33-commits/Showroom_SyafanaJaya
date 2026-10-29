<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pengaduan extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("Pengaduan_model");
        $this->role();
    }

    private function role()
    {
        if (session("username") == "") {
            redirect(base_url('login/auth'));
        }
    }

    // =========================================================
    // Dashboard – Daftar Pengaduan (status != 8)
    // =========================================================
    public function index()
    {
        Permission::grant(uri_string());
        $data["plugin"][]   = "plugin/datatable";
        $data["plugin"][]   = "plugin/select2";
        $data["title"]      = "Layanan Pengaduan";
        $data["title_des"]  = "Daftar Pengaduan";
        $data["content"]    = "v_index";
        $data["data"]       = $data;

        $this->load->view('template_v2', $data);
    }

    // =========================================================
    // Load data via AJAX untuk tabel index
    // =========================================================
    function LoadData()
    {
        $status = $this->input->post('status');

        $whereStatus = " AND p.status != 8";
        if ($status !== null && $status !== '') {
            $whereStatus = " AND p.status = " . $this->db->escape($status);
        } else {
            $whereStatus = " AND p.status IN ('0', '1', '9')";
        }

        $data = $this->Mod->GetCustome("
            SELECT p.*, u.nik, u.nama, u.email, u.no_hp, u.jabatan,
                   un.kode_unit, r.name_role
            FROM pengaduan p
            JOIN user u ON p.user_id = u.id AND u.status != 8
            LEFT JOIN unit un ON u.unit_kerja = un.id_unit AND un.status != 8
            LEFT JOIN role r ON u.type_user = r.id AND r.status != 8
            WHERE 1=1
            $whereStatus
            ORDER BY p.created_at DESC
        ")->result_array();

        foreach ($data as $key => $value) {
            // Format status label
            $status_map = ['0' => 'Draft', '1' => 'Proses', '9' => 'Selesai'];
            $data[$key]['status_label'] = isset($status_map[$value['status']]) ? $status_map[$value['status']] : '-';
            // Format tanggal
            $data[$key]['tanggal_label'] = date('d-m-Y H:i', strtotime($value['created_at']));
        }

        echo json_encode($data);
    }

    // =========================================================
    // Form buat pengaduan baru
    // =========================================================
    public function create()
    {
        Permission::grant(uri_string());
        $data["plugin"][]   = "plugin/select2";
        $data["title"]      = "Buat Pengaduan";
        $data["title_des"]  = "Form Pengaduan Baru";
        $data["content"]    = "v_create";

        // Ambil data user dari session + join unit & role
        $user_id = sess()['id'];
        $user = $this->Pengaduan_model->get_user_by_id($user_id);
        $data["user"] = $user;

        $this->load->view('template_v2', $data);
    }

    // =========================================================
    // Simpan pengaduan (draft / kirim) – AJAX POST
    // =========================================================
    public function store()
    {
        $post = $this->input->post();
        $action = isset($post['action']) ? $post['action'] : 'draft';
        $user_id = sess()['id'];

        // Validasi required fields
        $required = ['kategori', 'subjek', 'isi_pengaduan'];
        foreach ($required as $field) {
            if (empty($post[$field])) {
                echo json_encode(['status' => '400', 'msg' => "Field $field wajib diisi"]);
                return;
            }
        }

        // Generate kode unik PGD-YYYYMMDD-XXXX
        $kode = $this->Pengaduan_model->generate_kode();

        // Handle multiple lampiran
        $lampiran_json = null;
        if (!empty($_FILES['lampiran']['name'][0])) {
            $upload_path = './uploads/pengaduan/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0755, true);
            }

            $files = $_FILES['lampiran'];
            $file_count = count($files['name']);
            $uploaded_files = [];
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx'];
            $max_size = 5120; // 5MB in KB

            for ($i = 0; $i < $file_count; $i++) {
                if ($files['error'][$i] == 0) {
                    $ext = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));

                    // Validasi ekstensi
                    if (!in_array($ext, $allowed_types)) {
                        echo json_encode(['status' => '400', 'msg' => 'Tipe file ' . $ext . ' tidak diizinkan. Tipe yang diizinkan: jpg, jpeg, png, gif, pdf, doc, docx']);
                        return;
                    }

                    // Validasi ukuran (5MB = 5242880 bytes)
                    if ($files['size'][$i] > 5242880) {
                        echo json_encode(['status' => '400', 'msg' => 'Ukuran file ' . $files['name'][$i] . ' melebihi 5MB']);
                        return;
                    }

                    $new_filename = uniqid('PGD_') . '_' . time() . '.' . $ext;
                    $destination = $upload_path . $new_filename;

                    if (move_uploaded_file($files['tmp_name'][$i], $destination)) {
                        $uploaded_files[] = [
                            'original_name' => $files['name'][$i],
                            'file_name'     => $new_filename,
                            'file_path'     => 'uploads/pengaduan/' . $new_filename,
                            'file_size'     => $files['size'][$i],
                            'file_ext'      => $ext
                        ];
                    }
                }
            }

            if (!empty($uploaded_files)) {
                $lampiran_json = json_encode($uploaded_files);
            }
        }

        $status = ($action === 'submit') ? 1 : 0;

        $insert_data = [
            'kode_pengaduan' => $kode,
            'user_id'        => $user_id,
            'kategori'       => $post['kategori'],
            'subjek'         => $post['subjek'],
            'isi_pengaduan'  => $post['isi_pengaduan'],
            'lampiran'       => $lampiran_json,
            'status'         => $status,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ];

        $this->db->insert('pengaduan', $insert_data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            // Simpan setiap gambar ke tabel pengaduan_gambar
            if (!empty($uploaded_files)) {
                foreach ($uploaded_files as $file_item) {
                    $this->Pengaduan_model->insert_gambar([
                        'pengaduan_id'  => $insert_id,
                        'file_name'     => $file_item['file_name'],
                        'file_path'     => $file_item['file_path'],
                        'original_name' => $file_item['original_name'],
                        'file_size'     => $file_item['file_size'],
                        'file_ext'      => $file_item['file_ext'],
                        'created_at'    => date('Y-m-d H:i:s'),
                    ]);
                }
            }

            // Kirim email jika status = 1 (Kirim Pengaduan)
            if ($status == 1) {
                $user = $this->Pengaduan_model->get_user_by_id($user_id);
                $insert_data['user'] = $user;
                $insert_data['gambar'] = $uploaded_files;
                $this->_send_email_admin($insert_data);
                $this->_send_email_user($insert_data, $user);
            }

            $res = [
                'status' => '200',
                'msg'    => ($status == 1) ? 'Pengaduan berhasil dikirim' : 'Draft berhasil disimpan',
                'id'     => $insert_id
            ];
        } else {
            $res = [
                'status' => '400',
                'msg'    => 'Gagal menyimpan data'
            ];
        }

        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($res);
        exit;
    }

    // =========================================================
    // Detail pengaduan (AJAX / page)
    // =========================================================
    public function detail($id = null)
    {
        if (empty($id)) {
            echo json_encode(['status' => '400', 'msg' => 'ID tidak valid']);
            return;
        }

        // Jika AJAX request, kembalikan JSON
        if ($this->input->is_ajax_request() && !$this->input->get('page')) {
            $pengaduan = $this->Pengaduan_model->get_by_id($id);
            echo json_encode($pengaduan);
            return;
        }

        // Jika page request, load view
        Permission::grant(uri_string());
        $data["plugin"][]   = "plugin/select2";
        $data["title"]      = "Detail Pengaduan";
        $data["title_des"]  = "Info Lengkap Pengaduan";
        $data["content"]    = "v_detail";
        $data["pengaduan"]  = $this->Pengaduan_model->get_by_id($id);

        $this->load->view('template_v2', $data);
    }

    // =========================================================
    // Update status pengaduan (AJAX POST)
    // =========================================================
    public function update_status($id = null)
    {
        $new_status = $this->input->post('status');
        if (empty($id) || $new_status === null) {
            echo json_encode(['status' => '400', 'msg' => 'Parameter kurang']);
            return;
        }

        $data = ['status' => $new_status, 'updated_at' => date('Y-m-d H:i:s')];
        $res = $this->Mod->update2('pengaduan', array('id' => $id), $data);

        if ($res) {
            echo json_encode(['status' => '200', 'msg' => 'Status berhasil diperbarui']);
        } else {
            echo json_encode(['status' => '400', 'msg' => 'Gagal memperbarui status']);
        }
    }

    // =========================================================
    // Soft delete (status = 8) – AJAX POST
    // =========================================================
    public function delete($id = null)
    {
        if (empty($id)) {
            echo json_encode(['status' => '400', 'msg' => 'ID tidak valid']);
            return;
        }

        $data = ['status' => 8, 'updated_at' => date('Y-m-d H:i:s')];
        $res = $this->Mod->update2('pengaduan', array('id' => $id), $data);

        if ($res) {
            echo json_encode(['status' => '200', 'msg' => 'Pengaduan berhasil dihapus']);
        } else {
            echo json_encode(['status' => '400', 'msg' => 'Gagal menghapus']);
        }
    }

    // =========================================================
    // PRIVATE: Kirim email ke Admin
    // =========================================================
    private function _send_email_admin($pengaduan)
    {
        $user = $pengaduan['user'];
        $to = 'iassomelektrikal@gmail.com';
        $subject = 'Pengaduan Baru - ' . $pengaduan['kode_pengaduan'];

        $message = "
        <h2>PENGADUAN BARU</h2>
        <hr>
        <p><strong>Nomor Pengaduan:</strong> {$pengaduan['kode_pengaduan']}</p>

        <h3>DATA PENGADU</h3>
        <table border='0' cellpadding='5'>
            <tr><td><strong>Nama</strong></td><td>: " . htmlspecialchars($user['nama']) . "</td></tr>
            <tr><td><strong>NIK</strong></td><td>: " . htmlspecialchars($user['nik']) . "</td></tr>
            <tr><td><strong>Email</strong></td><td>: " . htmlspecialchars($user['email']) . "</td></tr>
            <tr><td><strong>No HP</strong></td><td>: " . htmlspecialchars($user['no_hp'] ?? '-') . "</td></tr>
            <tr><td><strong>Jabatan</strong></td><td>: " . htmlspecialchars($user['jabatan'] ?? '-') . "</td></tr>
            <tr><td><strong>Unit</strong></td><td>: " . htmlspecialchars($user['kode_unit'] ?? '-') . "</td></tr>
            <tr><td><strong>Role</strong></td><td>: " . htmlspecialchars($user['name_role'] ?? '-') . "</td></tr>
        </table>

        <h3>DATA PENGADUAN</h3>
        <table border='0' cellpadding='5'>
            <tr><td><strong>Kategori</strong></td><td>: " . htmlspecialchars($pengaduan['kategori']) . "</td></tr>
            <tr><td><strong>Subjek</strong></td><td>: " . htmlspecialchars($pengaduan['subjek']) . "</td></tr>
        </table>
        <p><strong>Isi Pengaduan:</strong><br>" . nl2br(htmlspecialchars($pengaduan['isi_pengaduan'])) . "</p>
        <p><strong>Status:</strong> PROSES</p>
        <p><strong>Tanggal:</strong> " . date('d F Y H:i:s', strtotime($pengaduan['created_at'])) . "</p>
        ";

        if (!empty($pengaduan['gambar'])) {
            $message .= "<h3>LAMPIRAN (" . count($pengaduan['gambar']) . " file)</h3><ul>";
            foreach ($pengaduan['gambar'] as $g) {
                $message .= "<li>" . htmlspecialchars($g['original_name']) . "</li>";
            }
            $message .= "</ul>";
        }

        $this->_do_send_email($to, $subject, $message);
    }

    // =========================================================
    // PRIVATE: Kirim email konfirmasi ke User
    // =========================================================
    private function _send_email_user($pengaduan, $user)
    {
        if (empty($user['email'])) return;

        $to = $user['email'];
        $subject = 'Konfirmasi Pengaduan - ' . $pengaduan['kode_pengaduan'];

        $message = "
        <h2>Pengaduan Anda Telah Berhasil Diterima</h2>
        <hr>
        <table border='0' cellpadding='5'>
            <tr><td><strong>Nomor Pengaduan</strong></td><td>: {$pengaduan['kode_pengaduan']}</td></tr>
            <tr><td><strong>Kategori</strong></td><td>: " . htmlspecialchars($pengaduan['kategori']) . "</td></tr>
            <tr><td><strong>Subjek</strong></td><td>: " . htmlspecialchars($pengaduan['subjek']) . "</td></tr>
            <tr><td><strong>Status</strong></td><td>: PROSES</td></tr>
        </table>
        <br>
        <p>Terima kasih telah mengirimkan pengaduan. Tim kami akan segera menindaklanjuti.</p>
        ";

        $this->_do_send_email($to, $subject, $message);
    }

    // =========================================================
    // PRIVATE: Kirim email menggunakan CI_Email / SMTP
    // =========================================================
    private function _do_send_email($to, $subject, $message)
    {
        try {
            $this->load->library('email');

            $config = [
                'protocol'    => 'smtp',
                'smtp_host'   => 'smtp.gmail.com',
                'smtp_port'   => 465,
                'smtp_user'   => 'iassomelektrikal@gmail.com',
                'smtp_pass'   => 'jpemwbshqlswgpoc',
                'smtp_crypto' => 'ssl',
                'mailtype'    => 'html',
                'charset'     => 'utf-8',
                'newline'     => "\r\n",
                'crlf'        => "\r\n",
                'smtp_timeout'=> 10,
                'wordwrap'    => TRUE
            ];

            $this->email->initialize($config);
            $this->email->from('iassomelektrikal@gmail.com', 'Layanan Pengaduan MPS');
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($message);
            @$this->email->send();
        } catch (Exception $e) {
            log_message('error', 'Email gagal dikirim ke ' . $to . ': ' . $e->getMessage());
        }
    }
}
