<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends MX_Controller {

    private $iass_roles = [1, 99, 101, 102, 103, 107, 109, 110, 111];
    private $api_roles  = [2, 104, 105, 106, 108];

    public function __construct() {
        parent::__construct();
        if (empty(session("username"))) {
            redirect(base_url('login/auth'));
        }
    }

    public function index() {
        $user_id = session('id');
        $user = $this->db->where('id', $user_id)->get('user')->row_array();

        if (empty($user)) {
            $user = $this->db->where('username', session('username'))->get('user')->row_array();
            $user_id = !empty($user['id']) ? $user['id'] : 0;
        }

        // Tentukan Kategori IASS vs API
        $type_user_int = !empty($user['type_user']) ? (int)$user['type_user'] : 0;
        $kategori = in_array($type_user_int, $this->iass_roles) ? 'iass' : 'api';

        // Ambil Data Unit
        $unit = $this->db->where('id_unit', $user['unit_kerja'])->get('unit')->row_array();
        $user['unit_nama'] = (!empty($unit['kode_unit']) ? $unit['kode_unit'] : 'Semua Unit / Manager');
        $user['unit_desc'] = (!empty($unit['name_unit']) ? $unit['name_unit'] : 'Kantor Pusat / Manager');

        // Ambil Data Role
        $role = $this->db->where('id', $user['type_user'])->get('role')->row_array();
        $user['role_nama'] = (!empty($role['name_role']) ? $role['name_role'] : '-');

        // Data Foto Terkini
        $foto_row = $this->db->where('id_user', $user_id)->get('user_foto_personil')->row_array();

        $data["title"] = "Setting Profil";
        $data["title_des"] = "Pengaturan Foto Profil dan Kata Sandi Akun";
        $data["content"] = "v_profil";
        $data["user"] = $user;
        $data["kategori"] = $kategori;
        $data["foto_row"] = $foto_row;
        $data["foto_url"] = user_photo_url($user_id);
        $data["data"] = $data;

        $this->load->view('template_v2', $data);
    }

    /**
     * AJAX Endpoint: Ganti Foto Profil
     * Direktori: \upload\foto_personil\[kategori]\[id_unit]\
     * Format file: [nik]_[nama].[ext]
     * Database: user_foto_personil
     */
    public function update_foto() {
        header('Content-Type: application/json');

        $user_id = session('id');
        if (empty($user_id)) {
            $user = $this->db->where('username', session('username'))->get('user')->row_array();
            $user_id = !empty($user['id']) ? $user['id'] : 0;
        } else {
            $user = $this->db->where('id', $user_id)->get('user')->row_array();
        }

        if (empty($user)) {
            echo json_encode(['status' => 401, 'msg' => 'Sesi login telah kedaluwarsa. Silakan login kembali.']);
            return;
        }

        if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
            $error_code = isset($_FILES['foto']) ? $_FILES['foto']['error'] : 'NO_FILE';
            $msg = 'File foto tidak valid atau belum dipilih.';
            if ($error_code == UPLOAD_ERR_INI_SIZE || $error_code == UPLOAD_ERR_FORM_SIZE) {
                $msg = 'Ukuran file foto melebihi batas maksimal server (Maksimal 5MB).';
            }
            echo json_encode(['status' => 400, 'msg' => $msg]);
            return;
        }

        $file_tmp  = $_FILES['foto']['tmp_name'];
        $file_name = $_FILES['foto']['name'];
        $file_size = $_FILES['foto']['size'];

        // Validasi Ukuran (Maksimal 5 MB)
        if ($file_size > 5 * 1024 * 1024) {
            echo json_encode(['status' => 400, 'msg' => 'Ukuran file terlalu besar. Maksimal 5 MB.']);
            return;
        }

        // Validasi Ekstensi
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_exts = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($ext, $allowed_exts)) {
            echo json_encode(['status' => 400, 'msg' => 'Format file tidak didukung. Harap gunakan format JPG, JPEG, PNG, atau WEBP.']);
            return;
        }

        // Tentukan Kategori IASS vs API
        $type_user_int = !empty($user['type_user']) ? (int)$user['type_user'] : 0;
        $kategori = in_array($type_user_int, $this->iass_roles) ? 'iass' : 'api';

        // Tentukan ID Unit (0 jika tidak ada)
        $id_unit = (!empty($user['unit_kerja'])) ? (int)$user['unit_kerja'] : 0;

        // Path folder penyimpanan: upload/foto_personil/[kategori]/[id_unit]/
        $relative_folder = "upload/foto_personil/{$kategori}/{$id_unit}/";
        $target_dir = FCPATH . $relative_folder;

        // Buat folder jika belum ada
        if (!is_dir($target_dir)) {
            if (!mkdir($target_dir, 0777, true)) {
                echo json_encode(['status' => 500, 'msg' => 'Gagal membuat direktori penyimpanan di server.']);
                return;
            }
        }

        // Format nama file: [nik]_[nama].[ext]
        $nik_clean = !empty($user['nik']) 
            ? preg_replace('/[^a-zA-Z0-9_-]/', '', trim($user['nik'])) 
            : preg_replace('/[^a-zA-Z0-9_-]/', '', trim($user['username']));
            
        $nama_clean = preg_replace('/[^a-zA-Z0-9_-]/', '_', strtoupper(trim($user['nama'])));
        $nama_clean = trim(preg_replace('/_+/', '_', $nama_clean), '_');

        if (empty($nik_clean)) {
            $nik_clean = 'USER_' . $user_id;
        }
        if (empty($nama_clean)) {
            $nama_clean = 'PERSONIL';
        }

        $new_filename = "{$nik_clean}_{$nama_clean}.{$ext}";
        $target_file = $target_dir . $new_filename;

        // Hapus file lama jika ada record sebelumnya
        $old_row = $this->db->where('id_user', $user_id)->get('user_foto_personil')->row_array();
        if (!empty($old_row) && !empty($old_row['folder_path']) && !empty($old_row['file_foto'])) {
            $old_path = FCPATH . $old_row['folder_path'] . $old_row['file_foto'];
            if (file_exists($old_path) && is_file($old_path)) {
                @unlink($old_path);
            }
        }

        // Pindahkan file yang diunggah
        if (!move_uploaded_file($file_tmp, $target_file)) {
            echo json_encode(['status' => 500, 'msg' => 'Gagal menyimpan file foto ke server.']);
            return;
        }

        // Simpan / Update ke tabel user_foto_personil
        $data_db = [
            'id_user'     => $user_id,
            'nik'         => $user['nik'],
            'nama'        => $user['nama'],
            'kategori'    => $kategori,
            'id_unit'     => $id_unit,
            'file_foto'   => $new_filename,
            'folder_path' => $relative_folder,
            'updated_at'  => date('Y-m-d H:i:s')
        ];

        if (!empty($old_row)) {
            $this->db->where('id_user', $user_id)->update('user_foto_personil', $data_db);
        } else {
            $data_db['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('user_foto_personil', $data_db);
        }

        $new_photo_url = user_photo_url($user_id);

        echo json_encode([
            'status'   => 200,
            'msg'      => 'Foto profil personil berhasil diperbarui!',
            'foto_url' => $new_photo_url,
            'kategori' => strtoupper($kategori),
            'filename' => $new_filename,
            'folder'   => $relative_folder
        ]);
    }

    /**
     * AJAX Endpoint: Ganti Kata Sandi (Password)
     */
    public function update_password() {
        header('Content-Type: application/json');

        $user_id = session('id');
        if (empty($user_id)) {
            $user = $this->db->where('username', session('username'))->get('user')->row_array();
            $user_id = !empty($user['id']) ? $user['id'] : 0;
        } else {
            $user = $this->db->where('id', $user_id)->get('user')->row_array();
        }

        if (empty($user)) {
            echo json_encode(['status' => 401, 'msg' => 'Sesi login telah kedaluwarsa. Silakan login kembali.']);
            return;
        }

        $password_baru = $this->input->post('password_baru');
        $konfirmasi    = $this->input->post('konfirmasi_password');

        if (empty($password_baru) || empty($konfirmasi)) {
            echo json_encode(['status' => 400, 'msg' => 'Kata sandi baru dan konfirmasi kata sandi wajib diisi.']);
            return;
        }

        if (strlen($password_baru) < 6) {
            echo json_encode(['status' => 400, 'msg' => 'Kata sandi baru minimal harus 6 karakter.']);
            return;
        }

        if ($password_baru !== $konfirmasi) {
            echo json_encode(['status' => 400, 'msg' => 'Konfirmasi kata sandi tidak cocok dengan kata sandi baru.']);
            return;
        }

        // Hash password menggunakan fungsi bawaan sistem hassp()
        $hash = hassp($password_baru);

        $update = $this->db->where('id', $user_id)->update('user', ['password' => $hash]);

        if ($update) {
            echo json_encode([
                'status' => 200,
                'msg'    => 'Kata sandi akun Anda berhasil diperbarui!'
            ]);
        } else {
            echo json_encode([
                'status' => 500,
                'msg'    => 'Gagal memperbarui kata sandi di database. Silakan coba lagi.'
            ]);
        }
    }
}
