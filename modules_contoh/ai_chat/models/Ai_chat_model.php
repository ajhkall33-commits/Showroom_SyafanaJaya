<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ai_chat_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /* ===================================================
       CONVERSATION & MESSAGE MANAGEMENT
    =================================================== */

    public function get_user_conversations($user_id) {
        return $this->db->select('*')
                        ->from('ai_conversations')
                        ->where('user_id', $user_id)
                        ->where('status !=', 8)
                        ->order_by('updated_at', 'DESC')
                        ->get()
                        ->result_array();
    }

    public function create_conversation($user_id, $title = 'Percakapan Baru') {
        $data = array(
            'user_id'    => $user_id,
            'title'      => mb_strimwidth($title, 0, 50, '...'),
            'status'     => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->insert('ai_conversations', $data);
        return $this->db->insert_id();
    }

    public function update_conversation_title($conversation_id, $title) {
        $this->db->where('id', $conversation_id);
        $this->db->update('ai_conversations', array(
            'title'      => mb_strimwidth($title, 0, 50, '...'),
            'updated_at' => date('Y-m-d H:i:s')
        ));
    }

    public function delete_conversation($conversation_id, $user_id) {
        $this->db->where('id', $conversation_id);
        $this->db->where('user_id', $user_id);
        return $this->db->update('ai_conversations', array('status' => 8));
    }

    public function get_messages($conversation_id, $limit = 20) {
        return $this->db->select('*')
                        ->from('ai_messages')
                        ->where('conversation_id', $conversation_id)
                        ->order_by('id', 'ASC')
                        ->limit($limit)
                        ->get()
                        ->result_array();
    }

    public function save_message($conversation_id, $role, $content) {
        $data = array(
            'conversation_id' => $conversation_id,
            'role'            => $role,
            'content'         => $content,
            'created_at'      => date('Y-m-d H:i:s')
        );
        $this->db->insert('ai_messages', $data);

        $this->db->where('id', $conversation_id);
        $this->db->update('ai_conversations', array('updated_at' => date('Y-m-d H:i:s')));

        return $this->db->insert_id();
    }

    public function log_usage($user_id, $conversation_id, $provider, $model, $input_tokens, $output_tokens, $total_tokens) {
        $data = array(
            'user_id'         => $user_id,
            'conversation_id' => $conversation_id,
            'provider'        => $provider,
            'model'           => $model,
            'input_tokens'    => $input_tokens,
            'output_tokens'   => $output_tokens,
            'total_tokens'    => $total_tokens,
            'created_at'      => date('Y-m-d H:i:s')
        );
        return $this->db->insert('ai_usage', $data);
    }

    /* ===================================================
       STATUS CODE LABEL HELPER
    =================================================== */

    public function format_status($st) {
        if ($st === null || $st === '') return 'N/A';
        switch ((int)$st) {
            case 0: return 'Draft (0)';
            case 1: return 'Proses (1)';
            case 2: return 'Menunggu Approved (2)';
            case 9: return 'Approved (9)';
            case 8: return 'Dihapus/Soft Delete (8)';
            default: return "Status {$st}";
        }
    }

    /* ===================================================
       SMART CONTEXT GENERATOR FROM 23 REQUIRED TABLES
    =================================================== */

    public function build_context($user_question, $user_unit_id = null) {
        $context = array();
                $q = strtolower($user_question);
        
        // Smart Context Filter: Detect unit name in question to drastically reduce tokens
        $filter_pm = ""; $filter_unit = ""; $filter_w = ""; $filter_a = ""; $filter_t = "";
        $filter_tj = ""; $filter_f = ""; $filter_p = ""; $filter_k = ""; $filter_km = ""; $filter_j = "";
        try {
            $units_db = $this->db->get('unit')->result_array();
            // Urutkan dari yang terpanjang ke terpendek untuk mencegah match parsial (misal: "Power Station 1" vs "Power Station")
            usort($units_db, function($a, $b) {
                return strlen($b['name_unit'] ?? '') - strlen($a['name_unit'] ?? '');
            });

            foreach ($units_db as $udb) {
                $match_name = false;
                $match_code = false;
                
                if (!empty($udb['name_unit'])) {
                    $name = preg_quote(strtolower(trim($udb['name_unit'])), '/');
                    if (preg_match("/\b{$name}\b/i", $q)) $match_name = true;
                }
                if (!empty($udb['kode_unit'])) {
                    $code = preg_quote(strtolower(trim($udb['kode_unit'])), '/');
                    if (preg_match("/\b{$code}\b/i", $q)) $match_code = true;
                }

                if ($match_name || $match_code) {
                    $id = $udb['id_unit'];
                    $filter_pm = " AND pm.id_unit = $id ";
                    $filter_unit = " AND id_unit = $id ";
                    $filter_w = " AND w.id_unit = $id ";
                    $filter_a = " AND a.id_unit = $id ";
                    $filter_t = " AND t.id_unit = $id ";
                    $filter_tj = " AND tj.id_unit = $id ";
                    $filter_f = " AND f.id_unit = $id ";
                    $filter_p = " AND p.id_unit = $id ";
                    $filter_k = " AND k.id_unit = $id ";
                    $filter_km = " AND km.id_unit = $id ";
                    $filter_j = " AND j.id_unit = $id ";
                    break;
                }
            }
        } catch (Exception $e) {}

        // Header Catatan Terminologi
        $context[] = "=== ATURAN PENTING TERMINOLOGI SISTEM ===";
        $context[] = "- Peralatan (fasilitas)";
        $context[] = "- Alat (perangkat)";
        $context[] = "- Jenis Alat / Kategori Peralatan (jenis_perangkat / fasilitas_catagory)";
        $context[] = "- Keterangan Kode Status: Status 0 artinya Draft, Status 1 artinya Proses, Status 2 artinya Menunggu Approve, Status 9 artinya Approved, Status 8 artinya Soft Delete (Dihapus)";
        $context[] = "";

        // ---------------------------------------------------
        // KNOWLEDGE BASE: ALUR KERJA SISTEM MPS
        // Smart conditional: show relevant workflow based on user question
        // ---------------------------------------------------
        $is_workflow_question = (strpos($q, 'alur') !== false || strpos($q, 'cara') !== false || strpos($q, 'tambah') !== false || 
            strpos($q, 'buat') !== false || strpos($q, 'menu') !== false || strpos($q, 'langkah') !== false || 
            strpos($q, 'prosedur') !== false || strpos($q, 'bagaimana') !== false || 
            strpos($q, 'input') !== false || strpos($q, 'isi') !== false || strpos($q, 'tutorial') !== false ||
            strpos($q, 'panduan') !== false || strpos($q, 'guide') !== false || strpos($q, 'step') !== false);

        $ask_preventive = (strpos($q, 'preventive') !== false || strpos($q, 'arahan') !== false || 
            strpos($q, 'work order') !== false || strpos($q, 'approval') !== false ||
            strpos($q, 'job report') !== false);
        $ask_corrective = (strpos($q, 'corrective') !== false || strpos($q, 'perbaikan') !== false || 
            strpos($q, 'temuan') !== false || strpos($q, 'tindak lanjut') !== false || strpos($q, 'tinjut') !== false ||
            strpos($q, 'kerusakan') !== false || strpos($q, 'persetujuan perbaikan') !== false);
        $ask_menu_perawatan = (strpos($q, 'menu perawatan') !== false || strpos($q, 'perawatan peralatan') !== false);
        $ask_operasional = (strpos($q, 'operasional') !== false);

        // Jika user hanya tanya "menu perawatan" / "perawatan peralatan" → hanya tampilkan modul PM saja
        if ($is_workflow_question && $ask_menu_perawatan && !$ask_preventive && !$ask_corrective) {
            $context[] = "=== PANDUAN MENU PERAWATAN / PM (Preventive Maintenance) ===";
            $context[] = "";
            $context[] = "## MODUL PM / PERAWATAN (Preventive Maintenance - Execution)";
            $context[] = "Menu: Perawatan > PM / Preventive Maintenance";
            $context[] = "Proses:";
            $context[] = "- Teknisi membuka menu Perawatan dan klik tombol Tambah untuk membuat record PM baru.";
            $context[] = "- Isikan formulir berikut:";
            $context[] = "  1. Peralatan: Pilih peralatan/fasilitas yang akan dirawat dari dropdown.";
            $context[] = "  2. Alat: Pilih alat/perangkat spesifik yang dirawat dari dropdown.";
            $context[] = "  3. Tanggal Perawatan: Pilih tanggal pelaksanaan perawatan (format dd/mm/yyyy).";
            $context[] = "  4. Pelaksana: Nama pelaksana/teknisi yang melakukan perawatan (otomatis terisi dari akun login).";
            $context[] = "  5. Pengawas: Nama pengawas/supervisor yang bertanggung jawab.";
            $context[] = "  6. Jam Mulai: Isi jam mulai pelaksanaan perawatan (format --:--).";
            $context[] = "  7. Sampai: Isi jam selesai pelaksanaan perawatan (format --:--).";
            $context[] = "  8. Jenis Perawatan: Pilih jenis perawatan dari dropdown (2M, 1B, 3B, 6B, T).";
            $context[] = "  9. File Pengukuran: Upload file hasil pengukuran peralatan (jika ada).";
            $context[] = "  10. Catatan Perawatan: Isi catatan/keterangan tambahan terkait perawatan.";
            $context[] = "  11. Dokumentasi Perawatan: Upload foto dokumentasi perawatan umum.";
            $context[] = "- Untuk dokumentasi perawatan berdasarkan Checklist SOP: Tekan tombol berlogo kamera (ikon kamera) di kolom Aksi dengan nama 'Dokumentasi Job' untuk mengisi foto per item checklist SOP.";
            $context[] = "- Status Lifecycle PM: Status 0 artinya Draft (Data sedang diisi teknisi, belum bisa dilaporkan). Status 1 artinya Proses (Teknisi menekan tombol 'Proses', data terkunci dan siap ditarik ke dalam laporan Work Order). Status 2 artinya Menunggu Approve (sudah masuk laporan WO). Status 9 artinya Approved (sudah disetujui/final).";
            $context[] = "- Setiap proses PM mencatat Log TTD (Tanda Tangan) digital teknisi sebagai bukti kehadiran.";
            $context[] = "";
        }

        // Jika user tanya tentang preventive (keseluruhan alur) ATAU pertanyaan umum workflow
        if (($is_workflow_question && $ask_preventive) || 
            ($is_workflow_question && !$ask_corrective && !$ask_menu_perawatan && !$ask_operasional)) {
            $context[] = "=== PANDUAN ALUR KERJA PREVENTIVE MAINTENANCE (PM) & JOB REPORTING ===";
            $context[] = "Alur Lengkap: WO Arahan Kerja → Perawatan (PM) → List WO Job Report → Approval → Dashboard";
            $context[] = "Menu Sidebar: Perawatan";
            $context[] = "";
            $context[] = "### LANGKAH 1: MODUL ARAHAN / WO ARAHAN KERJA (Instruksi/Directive)";
            $context[] = "Menu: Perawatan > Arahan (atau menu Arahan di sidebar)";
            $context[] = "Proses:";
            $context[] = "- Koordinator/admin membuat data Arahan baru sebagai instruksi kerja kepada tim teknisi.";
            $context[] = "- Klik tombol Tambah untuk membuat Arahan baru.";
            $context[] = "- Isikan formulir berikut:";
            $context[] = "  1. NO. WO (Arahan): Masukkan nomor WO Arahan Kerja sebagai referensi utama.";
            $context[] = "  2. Tanggal: Pilih tanggal arahan (format dd/mm/yyyy).";
            $context[] = "  3. Deskripsi Arahan: Masukkan deskripsi arahan/instruksi kerja yang akan dilakukan.";
            $context[] = "- Data tersimpan di tabel 'arahan' dengan status awal AKTIF.";
            $context[] = "- Nomor Arahan ini menjadi 'Header' atau identitas utama saat pembuatan Laporan Preventive Maintenance.";
            $context[] = "- Setelah dieksekusi, dilaporkan menjadi Work Order (WO) dan disetujui, status berubah menjadi Status 9 artinya Approved.";
            $context[] = "";
            $context[] = "### LANGKAH 2: MODUL PM / PERAWATAN (Preventive Maintenance - Execution)";
            $context[] = "Menu: Perawatan > PM / Preventive Maintenance";
            $context[] = "Proses:";
            $context[] = "- Teknisi membuka menu Perawatan dan klik tombol Tambah untuk membuat record PM baru.";
            $context[] = "- Isikan formulir berikut:";
            $context[] = "  1. Peralatan: Pilih peralatan/fasilitas yang akan dirawat dari dropdown.";
            $context[] = "  2. Alat: Pilih alat/perangkat spesifik yang dirawat dari dropdown.";
            $context[] = "  3. Tanggal Perawatan: Pilih tanggal pelaksanaan perawatan (format dd/mm/yyyy).";
            $context[] = "  4. Pelaksana: Nama pelaksana/teknisi yang melakukan perawatan (otomatis terisi dari akun login).";
            $context[] = "  5. Pengawas: Nama pengawas/supervisor yang bertanggung jawab.";
            $context[] = "  6. Jam Mulai: Isi jam mulai pelaksanaan perawatan (format --:--).";
            $context[] = "  7. Sampai: Isi jam selesai pelaksanaan perawatan (format --:--).";
            $context[] = "  8. Jenis Perawatan: Pilih jenis perawatan dari dropdown (2M, 1B, 3B, 6B, T).";
            $context[] = "  9. File Pengukuran: Upload file hasil pengukuran peralatan (jika ada).";
            $context[] = "  10. Catatan Perawatan: Isi catatan/keterangan tambahan terkait perawatan.";
            $context[] = "  11. Dokumentasi Perawatan: Upload foto dokumentasi perawatan umum.";
            $context[] = "- Untuk dokumentasi perawatan berdasarkan Checklist SOP: Tekan tombol berlogo kamera (ikon kamera) di kolom Aksi dengan nama 'Dokumentasi Job' untuk mengisi foto per item checklist SOP.";
            $context[] = "- Status Lifecycle PM: Status 0 artinya Draft (Data sedang diisi teknisi, belum bisa dilaporkan). Status 1 artinya Proses (Teknisi menekan tombol 'Proses', data terkunci dan siap ditarik ke dalam laporan Work Order). Status 2 artinya Menunggu Approve (sudah masuk laporan WO). Status 9 artinya Approved (sudah disetujui/final).";
            $context[] = "- Setiap proses PM mencatat Log TTD (Tanda Tangan) digital teknisi sebagai bukti kehadiran.";
            $context[] = "";
            $context[] = "### LANGKAH 3: MODUL LIST WO / JOB REPORTING (Laporan PM - Compilation & Final Report)";
            $context[] = "Menu: Perawatan > List WO / Work Order";
            $context[] = "Proses:";
            $context[] = "- Klik tombol Tambah untuk membuat laporan WO Job Report baru.";
            $context[] = "- Isikan formulir berikut:";
            $context[] = "  1. No. WO (Arahan): Pilih nomor WO Arahan dari dropdown (arahan yang sudah dibuat di Langkah 1).";
            $context[] = "  2. Tanggal: Pilih tanggal pembuatan laporan WO (format dd/mm/yyyy --:--).";
            $context[] = "  3. Pelaksana: Nama pelaksana/koordinator (otomatis terisi dari akun login).";
            $context[] = "  4. Jenis Perawatan: Pilih jenis perawatan dari dropdown.";
            $context[] = "- Setelah mengisi form di atas, akan muncul tabel berisi daftar record PM yang berstatus Proses (Status 1) dan siap ditarik ke dalam laporan. Tabel menampilkan: Pilih (checkbox), Tanggal Perawatan, Peralatan, dan Lokasi.";
            $context[] = "- Centang/pilih satu atau banyak record PM yang ingin dimasukkan ke dalam laporan WO ini.";
            $context[] = "- Penyimpanan (SaveData): Membuat record baru di tabel 'wo', menghubungkan WO dengan PM/arahan lewat tabel 'wo_detail'. Status record PM dan Arahan berubah menjadi Status 2 artinya Menunggu Approve (Masuk Laporan).";
            $context[] = "- Output (Cetak Report): Menghasilkan Laporan Kerja/Job Report dalam format PDF. Laporan berisi: Detail Arahan, Daftar Personil, Checklist Pekerjaan, Hasil Pengukuran, dan Foto dokumentasi.";
            $context[] = "";
            $context[] = "### LANGKAH 4: MODUL LIST APPROVAL (Verification / Leader Approval)";
            $context[] = "Menu: Perawatan > Daftar Persetujuan / Approval";
            $context[] = "Proses:";
            $context[] = "- Leader/pengawas mengakses List Approval (menampilkan WO dengan Status 2 artinya Menunggu Approve).";
            $context[] = "- Meninjau Checklist, Dokumentasi, dan Personil yang dilaporkan.";
            $context[] = "- Hasil Keputusan: REJECT = Pekerjaan/data tidak lengkap, WO dikembalikan/dicolek. APPROVE = Pekerjaan valid, laporan disetujui.";
            $context[] = "- Jika di-Approve, maka secara otomatis status dari tabel arahan, tabel pm, dan tabel wo akan di-update menjadi Status 9 artinya Approved (Final/Disetujui).";
            $context[] = "";
            $context[] = "### LANGKAH 5: DASHBOARD / TABEL & GRAFIK PM (Monitoring)";
            $context[] = "Menu: Dashboard / Dashboard Manager";
            $context[] = "Proses:";
            $context[] = "- Monitoring realisasi Preventive Maintenance yang sudah disetujui (Status 9 artinya Approved).";
            $context[] = "- Sistem otomatis melakukan counting dari data yang telah berstatus Status 9 artinya Approved dan menampilkannya di Dashboard dalam bentuk Tabel dan Grafik.";
            $context[] = "- Contoh tampilan: Ringkasan Realisasi PM (Total WO, Total PM, Total Arahan yang sudah Approved).";
            $context[] = "";
            $context[] = "### RINGKASAN STATUS DATA PREVENTIVE (Database Flow):";
            $context[] = "ARAHAN (tabel: arahan): AKTIF → TARIK KE LIST WO (Status 2 artinya Menunggu Approve) → APPROVAL → Status 9 artinya Approved (Final)";
            $context[] = "PM (tabel: pm): Status 0 artinya Draft → Status 1 artinya Proses → Status 2 artinya Menunggu Approve (Masuk Laporan WO) → Status 9 artinya Approved (Final)";
            $context[] = "";
        }

        // Jika user tanya tentang corrective (keseluruhan alur) ATAU pertanyaan umum workflow
        if (($is_workflow_question && $ask_corrective) || 
            ($is_workflow_question && !$ask_preventive && !$ask_menu_perawatan && !$ask_operasional)) {
            $context[] = "=== PANDUAN ALUR KERJA CORRECTIVE MAINTENANCE (CM) / PERBAIKAN ===";
            $context[] = "Alur Lengkap: Temuan → Tindak Lanjut → Persetujuan Perbaikan → Dashboard";
            $context[] = "Menu Sidebar: Perbaikan";
            $context[] = "";
            $context[] = "### LANGKAH 1: INPUT TEMUAN KERUSAKAN";
            $context[] = "Menu: Perbaikan > Temuan";
            $context[] = "Proses:";
            $context[] = "- Teknisi/petugas menemukan kerusakan pada peralatan saat inspeksi atau operasional.";
            $context[] = "- Klik tombol Tambah untuk membuat data Temuan baru.";
            $context[] = "- Isikan formulir berikut:";
            $context[] = "  1. Nomor Kerusakan: Masukkan nomor kerusakan sebagai identitas unik temuan.";
            $context[] = "  2. Peralatan: Pilih Fasilitas/Peralatan yang mengalami kerusakan dari dropdown.";
            $context[] = "  3. Uraian Kejadian: Masukkan uraian kejadian kerusakan secara detail.";
            $context[] = "  4. Kategori Kerusakan: Pilih kategori kerusakan dari dropdown.";
            $context[] = "  5. Analisis Risiko: Pilih tingkat analisis risiko dari dropdown.";
            $context[] = "  6. Kondisi Peralatan: Pilih kondisi peralatan saat ini dari dropdown.";
            $context[] = "  7. Tanggal & Waktu: Isi tanggal dan waktu kejadian kerusakan.";
            $context[] = "  8. Dokumentasi Perawatan: Upload gambar/foto dokumentasi kerusakan (format JPG, PNG, GIF, maksimal 5MB).";
            $context[] = "- Data tersimpan di tabel 'temuan' dengan status awal (Open).";
            $context[] = "- Status Open (Status 0 artinya Draft atau Status 1 artinya Proses) = belum ditindaklanjuti. Status Close (Status 9 artinya Approved) = sudah selesai diperbaiki.";
            $context[] = "";
            $context[] = "### LANGKAH 2: TINDAK LANJUT PERBAIKAN";
            $context[] = "Menu: Perbaikan > Tindak Lanjut";
            $context[] = "Proses:";
            $context[] = "- Buat record Tindak Lanjut yang merujuk ke Temuan tertentu.";
            $context[] = "- Isikan formulir berikut:";
            $context[] = "  1. Pilih Temuan: Pilih nomor temuan kerusakan yang akan ditindaklanjuti.";
            $context[] = "  2. Jenis Masalah: Pilih jenis masalah dari dropdown (wajib diisi).";
            $context[] = "  3. Pelaksana: Isi nama pelaksana/teknisi yang melakukan perbaikan (wajib diisi).";
            $context[] = "  4. Tindakan: Deskripsikan tindakan perbaikan yang dilakukan.";
            $context[] = "  5. Komponen / Sparepart: Pilih dan catat komponen/suku cadang yang digunakan untuk perbaikan (wajib diisi jika ada penggantian komponen).";
            $context[] = "  6. Tanggal Mulai & Tanggal Selesai: Isi tanggal mulai dan selesai perbaikan.";
            $context[] = "  7. Foto Before (Sebelum): Upload foto kondisi peralatan sebelum diperbaiki (wajib).";
            $context[] = "  8. Foto Proses: Upload foto proses perbaikan yang sedang berlangsung (wajib).";
            $context[] = "  9. Foto After (Sesudah): Upload foto kondisi peralatan setelah diperbaiki (wajib).";
            $context[] = "- Data tersimpan di tabel 'tinjut'.";
            $context[] = "- Komponen yang digunakan dicatat otomatis di tabel 'komponen_terpakai'.";
            $context[] = "";
            $context[] = "### LANGKAH 3: PERSETUJUAN PERBAIKAN";
            $context[] = "Menu: Perbaikan > Daftar Persetujuan Perbaikan";
            $context[] = "Proses:";
            $context[] = "- Leader/pengawas memverifikasi dan menyetujui laporan perbaikan.";
            $context[] = "- Jika disetujui, status Temuan berubah menjadi Close/Approved (Status 9 artinya Approved).";
            $context[] = "";
            $context[] = "### LANGKAH 4: MONITORING";
            $context[] = "Menu: Dashboard / Dashboard Manager";
            $context[] = "- Rekap Status Kerusakan: Total Kerusakan, Status Open (Belum Selesai), Status Close (Selesai/Approved).";
            $context[] = "";
        }

        // Jika user tanya tentang operasional ATAU pertanyaan umum workflow
        if (($is_workflow_question && $ask_operasional) || 
            ($is_workflow_question && !$ask_preventive && !$ask_corrective && !$ask_menu_perawatan)) {
            $context[] = "=== PANDUAN ALUR OPERASIONAL ===";
            $context[] = "Menu Sidebar: Operasional";
            $context[] = "";
            $context[] = "Proses:";
            $context[] = "- Menu Operasional digunakan untuk mencatat kegiatan operasional harian.";
            $context[] = "- Pencatatan kondisi operasional peralatan secara berkala.";
            $context[] = "- Data operasional digunakan sebagai bahan evaluasi dan monitoring performa peralatan.";
            $context[] = "";
        }

        // Info Master Data, Aset, Komponen → muncul saat pertanyaan umum workflow
        if ($is_workflow_question && !$ask_menu_perawatan) {
            $context[] = "=== MENU PENDUKUNG ===";
            $context[] = "";
            $context[] = "## MENU MASTER DATA (Pengaturan Data Dasar)";
            $context[] = "Menu Sidebar: Master Data";
            $context[] = "- Digunakan untuk mengelola data dasar/referensi yang dibutuhkan modul lain.";
            $context[] = "- Sub-menu: Unit Kerja, Peralatan (Fasilitas), Alat (Perangkat), Jenis Alat, Kategori Peralatan, Komponen/Suku Cadang, Jadwal PM, User/Petugas.";
            $context[] = "- Sebelum menambahkan data PM atau Temuan, pastikan data Master sudah terisi (Unit, Peralatan, Alat).";
            $context[] = "";
            $context[] = "## MENU ASET";
            $context[] = "Menu Sidebar: Aset";
            $context[] = "- Digunakan untuk mengelola data aset peralatan dan perangkat.";
            $context[] = "- Termasuk informasi inventaris, lokasi, dan status aset.";
            $context[] = "";
            $context[] = "## MANAJEMEN KOMPONEN / SUKU CADANG";
            $context[] = "Menu Sidebar: Perbaikan > Komponen, Komponen Masuk, Komponen Terpakai";
            $context[] = "- Komponen: Daftar master komponen/suku cadang per unit.";
            $context[] = "- Komponen Masuk: Pencatatan komponen baru yang masuk ke gudang (stok bertambah).";
            $context[] = "- Komponen Terpakai: Pencatatan komponen yang digunakan untuk perbaikan (stok berkurang). Terhubung dengan Tindak Lanjut.";
            $context[] = "- Stok Saat Ini = Total Komponen Masuk - Total Komponen Terpakai.";
            $context[] = "";
        }
        

        // ---------------------------------------------------
        // 1. MASTER TIPE PM (pm_type) & RINCIAN PM PER TIPE
        // ---------------------------------------------------
        if (strpos($q, '2m') !== false || strpos($q, '1b') !== false || strpos($q, '3b') !== false || 
            strpos($q, '6b') !== false || strpos($q, 't') !== false || strpos($q, 'pm') !== false || 
            strpos($q, 'perawatan') !== false || strpos($q, 'pemeliharaan') !== false || strpos($q, 'tipe') !== false || strpos($q, 'preventive') !== false) {
            
            try {
                $pm_types = $this->db->query("SELECT idpm_type, kode, name_pm FROM pm_type WHERE status != 8")->result_array();
                if (!empty($pm_types)) {
                    $context[] = "=== MASTER TIPE PERAWATAN (pm_type) ===";
                    foreach ($pm_types as $pt) {
                        $context[] = "{$pt['idpm_type']}|{$pt['kode']}|{$pt['name_pm']}";
                    }
                }

                // Rincian Rencana & Realisasi PM per Tipe PM (Dashboard Logic)
                $rencana_raw = $this->db->query("
                    SELECT pt.kode, COUNT(j.idpm_type) AS rencana
                    FROM jadwal j
                    JOIN pm_type pt ON pt.idpm_type = j.idpm_type
                    JOIN fasilitas f ON f.id_fasilitas = j.id_fasilitas
                    WHERE f.status != 8 AND pt.status != 8 AND j.tahun = " . date('Y') . " {$filter_j}
                    GROUP BY pt.kode
                ")->result_array();

                $realisasi_raw = $this->db->query("
                    SELECT pt.kode, COUNT(DISTINCT w.id_wo) AS realisasi
                    FROM wo w
                    JOIN wo_detail wd ON wd.id_wo = w.id_wo
                    JOIN pm p ON p.id_pmheader = wd.id_pmheader
                    JOIN fasilitas f ON f.id_fasilitas = p.id_fasilitas
                    JOIN pm_type pt ON pt.idpm_type = w.idpm_type
                    WHERE w.status = 9 AND p.status = 9 AND f.status != 8 AND pt.status != 8 AND YEAR(w.tanggal) = " . date('Y') . " {$filter_w}
                    GROUP BY pt.kode
                ")->result_array();

                $rencana_map = [];
                foreach ($rencana_raw as $r) { $rencana_map[strtoupper(trim($r['kode']))] = (int)$r['rencana']; }
                
                $realisasi_map = [];
                foreach ($realisasi_raw as $r) { $realisasi_map[strtoupper(trim($r['kode']))] = (int)$r['realisasi']; }

                $pm_codes = ['2M', '1B', '3B', '6B', 'T'];
                $context[] = "=== RINCIAN TARGET & CAPAIAN PERAWATAN PREVENTIVE (PM) KESELURUHAN ===";
                foreach ($pm_codes as $kode) {
                    $rencana = $rencana_map[$kode] ?? 0;
                    $realisasi = $realisasi_map[$kode] ?? 0;
                    $sisa = $rencana - $realisasi;
                    $persen = ($rencana > 0) ? round(($realisasi / $rencana) * 100, 2) : 0;
                    $context[] = "Tipe {$kode} | Target/Rencana: {$rencana} | Capaian/Realisasi: {$realisasi} | Sisa Belum: {$sisa} | Persentase: {$persen}%";
                }

                // Rincian per Peralatan (Jika diminta rangkuman / peralatan / unit tertentu)
                if (strpos($q, 'rangkuman') !== false || strpos($q, 'peralatan') !== false || strpos($q, 'detail') !== false || strpos($q, 'unit') !== false) {
                    $rencana_fas_raw = $this->db->query("
                        SELECT f.nama_fasilitas, u.kode_unit, pt.kode, COUNT(j.idpm_type) AS rencana
                        FROM jadwal j
                        JOIN pm_type pt ON pt.idpm_type = j.idpm_type
                        JOIN fasilitas f ON f.id_fasilitas = j.id_fasilitas
                        LEFT JOIN unit u ON u.id_unit = f.id_unit
                        WHERE f.status != 8 AND pt.status != 8 AND j.tahun = " . date('Y') . " {$filter_j}
                        GROUP BY f.id_fasilitas, pt.kode
                    ")->result_array();

                    $realisasi_fas_raw = $this->db->query("
                        SELECT f.nama_fasilitas, pt.kode, COUNT(DISTINCT w.id_wo) AS realisasi
                        FROM wo w
                        JOIN wo_detail wd ON wd.id_wo = w.id_wo
                        JOIN pm p ON p.id_pmheader = wd.id_pmheader
                        JOIN fasilitas f ON f.id_fasilitas = p.id_fasilitas
                        JOIN pm_type pt ON pt.idpm_type = w.idpm_type
                        WHERE w.status = 9 AND p.status = 9 AND f.status != 8 AND pt.status != 8 AND YEAR(w.tanggal) = " . date('Y') . " {$filter_w}
                        GROUP BY f.id_fasilitas, pt.kode
                    ")->result_array();

                    $fas_map = [];
                    foreach ($rencana_fas_raw as $r) {
                        $fas_map[$r['nama_fasilitas']]['unit'] = $r['kode_unit'] ?? '-';
                        $fas_map[$r['nama_fasilitas']]['data'][strtoupper(trim($r['kode']))]['rencana'] = (int)$r['rencana'];
                    }
                    foreach ($realisasi_fas_raw as $r) {
                        $fas_map[$r['nama_fasilitas']]['data'][strtoupper(trim($r['kode']))]['realisasi'] = (int)$r['realisasi'];
                    }

                    if (!empty($fas_map)) {
                        $context[] = "=== RINCIAN TARGET & CAPAIAN PER PERALATAN (FASILITAS) ===";
                        // Limit to top 500 peralatan to save context size if too many
                        $limit_fas = 0;
                        foreach ($fas_map as $nama_fas => $info) {
                            if ($limit_fas++ >= 500) break;
                            $unit = $info['unit'];
                            $row = "Unit: {$unit} | Peralatan: {$nama_fas} | ";
                            $details = [];
                            foreach ($pm_codes as $kode) {
                                $rencana = $info['data'][$kode]['rencana'] ?? 0;
                                $realisasi = $info['data'][$kode]['realisasi'] ?? 0;
                                $sisa = $rencana - $realisasi;
                                $persen = ($rencana > 0) ? round(($realisasi / $rencana) * 100, 2) : 0;
                                $details[] = "Tipe {$kode} (Rencana:{$rencana}, Realisasi:{$realisasi}, Sisa:{$sisa}, Persentase:{$persen}%)";
                            }
                            $row .= implode(", ", $details);
                            $context[] = $row;
                        }
                    }
                }
            } catch (Exception $e) {}
        }

        // ---------------------------------------------------
        // 2. UNIT KERJA (unit)
        // ---------------------------------------------------
        if (strpos($q, 'unit') !== false || strpos($q, 'lokasi') !== false || strpos($q, 'rincikan') !== false || 
            strpos($q, 'mana') !== false || strpos($q, 'terbanyak') !== false || strpos($q, 'semua') !== false) {
            try {
                $units = $this->db->select('id_unit, kode_unit, name_unit, status')->from('unit')->where('status !=', 8)->where('1=1 ' . $filter_unit)->limit(50)->get()->result_array();
                if (!empty($units)) {
                    $context[] = "=== DAFTAR SELURUH UNIT KERJA (unit) ===";
                    foreach ($units as $u) {
                        $st = $this->format_status($u['status']);
                        $context[] = "{$u['id_unit']}|{$u['kode_unit']}|{$u['name_unit']}|{$st}";
                    }
                }
            } catch (Exception $e) {}
        }

        // ---------------------------------------------------
        // 3. PM, PM DETAIL, PM KHUSUS (pm, pm_detail, pm_khusus)
        // ---------------------------------------------------
        if (strpos($q, 'pm') !== false || strpos($q, 'perawatan') !== false || strpos($q, 'pemeliharaan') !== false || strpos($q, 'khusus') !== false) {
            try {
                $pms = $this->db->query("SELECT pm.id_pmheader, pm.tanggal_pm, pm.pelaksana, pm.catatan_perawatan, pm.status, u.name_unit, f.nama_fasilitas, pt.kode as kode_pm 
                                         FROM pm 
                                         LEFT JOIN unit u ON u.id_unit = pm.id_unit 
                                         LEFT JOIN fasilitas f ON f.id_fasilitas = pm.id_fasilitas 
                                         LEFT JOIN pm_type pt ON pt.idpm_type = pm.idpm_type 
                                         WHERE pm.status != 8 {$filter_pm} 
                                         ORDER BY pm.id_pmheader DESC LIMIT 15")->result_array();
                if (!empty($pms)) {
                    $context[] = "=== DATA DETAIL PERAWATAN / PREVENTIVE MAINTENANCE (pm) (15 Terbaru) ===";
                    foreach ($pms as $p) {
                        $st = $this->format_status($p['status']);
                        $context[] = "PM#{$p['id_pmheader']}|{$p['tanggal_pm']}|{$p['kode_pm']}|{$p['name_unit']}|{$p['nama_fasilitas']}|{$p['pelaksana']}|{$p['catatan_perawatan']}|{$st}";
                    }
                }

                // PM Khusus (pm_khusus)
                $pm_khusus = $this->db->query("SELECT pk.id_pm_khusus, pk.id_pm, pk.status, p.nama_perangkat 
                                               FROM pm_khusus pk 
                                               LEFT JOIN perangkat p ON p.id_perangkat = pk.id_perangkat 
                                               WHERE pk.status != 8 LIMIT 10")->result_array();
                if (!empty($pm_khusus)) {
                    $context[] = "=== DATA PM KHUSUS (pm_khusus) ===";
                    foreach ($pm_khusus as $pk) {
                        $st = $this->format_status($pk['status']);
                        $context[] = "PMK#{$pk['id_pm_khusus']}|PM#{$pk['id_pm']}|{$pk['nama_perangkat']}|{$st}";
                    }
                }
            } catch (Exception $e) {}
        }

        // ---------------------------------------------------
        // 4. WORK ORDER & ARAHAN (wo, wo_detail, arahan)
        // ---------------------------------------------------
        if (strpos($q, 'wo') !== false || strpos($q, 'work order') !== false || strpos($q, 'arahan') !== false) {
            try {
                $wos = $this->db->query("SELECT w.id_wo, w.no_wo, w.tanggal, w.team, w.pelaksana, w.catatan_wo, w.klasifikasi, w.status, u.name_unit 
                                         FROM wo w 
                                         LEFT JOIN unit u ON u.id_unit = w.id_unit 
                                         WHERE w.status != 8 {$filter_w} 
                                         ORDER BY w.id_wo DESC LIMIT 15")->result_array();
                if (!empty($wos)) {
                    $context[] = "=== DATA WORK ORDER (wo) (15 Terbaru) ===";
                    foreach ($wos as $w) {
                        $st = $this->format_status($w['status']);
                        $context[] = "{$w['no_wo']}|{$w['tanggal']}|{$w['name_unit']}|{$w['team']}|{$w['pelaksana']}|{$w['klasifikasi']}|{$st}";
                    }
                }

                $arahans = $this->db->query("SELECT a.id_arahan, a.nomor, a.deskripsi, a.tanggal, a.status, u.name_unit 
                                             FROM arahan a 
                                             LEFT JOIN unit u ON u.id_unit = a.id_unit 
                                             WHERE a.status != 8 {$filter_a} 
                                             ORDER BY a.id_arahan DESC LIMIT 15")->result_array();
                if (!empty($arahans)) {
                    $context[] = "=== DATA ARAHAN KERJA (arahan) ===";
                    foreach ($arahans as $a) {
                        $st = $this->format_status($a['status']);
                        $context[] = "{$a['nomor']}|{$a['tanggal']}|{$a['name_unit']}|{$a['deskripsi']}|{$st}";
                    }
                }
            } catch (Exception $e) {}
        }

        // ---------------------------------------------------
        // 5. TEMUAN & TINDAK LANJUT (temuan, temuan_detail, tinjut, tinjut_detail)
        // ---------------------------------------------------
        if (strpos($q, 'temuan') !== false || strpos($q, 'tinjut') !== false || strpos($q, 'tindak lanjut') !== false || 
            strpos($q, 'kerusakan') !== false || strpos($q, 'perbaikan') !== false) {
            try {
                // Rekap Status Kerusakan (Dashboard Logic)
                $status_kerusakan = $this->db->query("
                    SELECT 
                        COUNT(*) as total_kerusakan,
                        SUM(CASE WHEN status IN (0,1,2) THEN 1 ELSE 0 END) as status_open,
                        SUM(CASE WHEN status = 9 THEN 1 ELSE 0 END) as status_close
                    FROM temuan t
                    WHERE status != 8 {$filter_t}
                ")->row_array();
                
                if (!empty($status_kerusakan)) {
                    $context[] = "=== REKAP STATUS KERUSAKAN / CORRECTIVE (temuan) ===";
                    $context[] = "Total Kerusakan: " . (int)$status_kerusakan['total_kerusakan'];
                    $context[] = "Status Open (Belum Selesai): " . (int)$status_kerusakan['status_open'];
                    $context[] = "Status Close (Selesai/Approved): " . (int)$status_kerusakan['status_close'];
                }

                $temuans = $this->db->query("SELECT t.id_temuan, t.nomor, t.kategori_kerusakan, t.analisis, t.kondisi, t.tanggal, t.uraian_kejadian, t.status, u.name_unit, f.nama_fasilitas 
                                             FROM temuan t 
                                             LEFT JOIN unit u ON u.id_unit = t.id_unit 
                                             LEFT JOIN fasilitas f ON f.id_fasilitas = t.id_fasilitas 
                                             WHERE t.status != 8 {$filter_t} 
                                             ORDER BY t.id_temuan DESC LIMIT 15")->result_array();
                if (!empty($temuans)) {
                    $context[] = "=== DATA TEMUAN KERUSAKAN (temuan) (15 Terbaru) ===";
                    foreach ($temuans as $tm) {
                        $st = $this->format_status($tm['status']);
                        $context[] = "{$tm['nomor']}|{$tm['tanggal']}|{$tm['name_unit']}|{$tm['nama_fasilitas']}|{$tm['kategori_kerusakan']}|{$tm['kondisi']}|{$st}";
                    }
                }

                $tinjuts = $this->db->query("SELECT tj.id_tinjut, tj.nomor, tj.pelaksana, tj.tindakan, tj.tanggal_mulai, tj.tanggal_selesai, tj.status, u.name_unit, f.nama_fasilitas 
                                             FROM tinjut tj 
                                             LEFT JOIN unit u ON u.id_unit = tj.id_unit 
                                             LEFT JOIN fasilitas f ON f.id_fasilitas = tj.id_fasilitas 
                                             WHERE tj.status != 8 {$filter_tj} 
                                             ORDER BY tj.id_tinjut DESC LIMIT 15")->result_array();
                if (!empty($tinjuts)) {
                    $context[] = "=== DATA TINDAK LANJUT PERBAIKAN (tinjut) ===";
                    foreach ($tinjuts as $tj) {
                        $st = $this->format_status($tj['status']);
                        $context[] = "{$tj['nomor']}|{$tj['name_unit']}|{$tj['nama_fasilitas']}|{$tj['pelaksana']}|{$tj['tindakan']}|{$st}";
                    }
                }
            } catch (Exception $e) {}
        }

        // ---------------------------------------------------
        // 6. JENIS MASALAH & JENIS MASALAH TERPAKAI
        // ---------------------------------------------------
        if (strpos($q, 'masalah') !== false || strpos($q, 'jenis masalah') !== false) {
            try {
                $masalahs = $this->db->query("SELECT id, nama_masalah, status FROM jenis_masalah WHERE status != 8 LIMIT 15")->result_array();
                if (!empty($masalahs)) {
                    $context[] = "=== DATA JENIS MASALAH (jenis_masalah) ===";
                    foreach ($masalahs as $jm) {
                        $st = $this->format_status($jm['status']);
                        $context[] = "{$jm['id']}|{$jm['nama_masalah']}|{$st}";
                    }
                }
            } catch (Exception $e) {}
        }

        // ---------------------------------------------------
        // 7. INVENTARIS: FASILITAS, KATAGORI, PERANGKAT, JENIS PERANGKAT
        //    (Peralatan, Kategori Peralatan, Alat, Jenis Alat)
        // ---------------------------------------------------
        if (strpos($q, 'fasilitas') !== false || strpos($q, 'peralatan') !== false || strpos($q, 'perangkat') !== false || 
            strpos($q, 'alat') !== false || strpos($q, 'kategori') !== false || strpos($q, 'jenis') !== false) {
            try {
                // Kategori Peralatan / Jenis Alat (fasilitas_catagory & jenis_perangkat)
                $fcats = $this->db->query("SELECT id_catagory, nama, status FROM fasilitas_catagory WHERE status != 8 LIMIT 20")->result_array();
                if (!empty($fcats)) {
                    $context[] = "=== KATEGORI PERALATAN / JENIS ALAT (fasilitas_catagory) ===";
                    foreach ($fcats as $fc) {
                        $st = $this->format_status($fc['status']);
                        $context[] = "{$fc['id_catagory']}|{$fc['nama']}|{$st}";
                    }
                }

                $jperangkats = $this->db->query("SELECT id_jenisperangkat, nama, status FROM jenis_perangkat WHERE status != 8 LIMIT 20")->result_array();
                if (!empty($jperangkats)) {
                    $context[] = "=== JENIS ALAT / KATEGORI PERALATAN (jenis_perangkat) ===";
                    foreach ($jperangkats as $jp) {
                        $st = $this->format_status($jp['status']);
                        $context[] = "{$jp['id_jenisperangkat']}|{$jp['nama']}|{$st}";
                    }
                }

                // Peralatan (fasilitas)
                $fasilitases = $this->db->query("SELECT f.id_fasilitas, f.nama_fasilitas, f.terminal, f.zona, f.status, u.name_unit, u.kode_unit, fc.nama as kategori 
                                                 FROM fasilitas f 
                                                 LEFT JOIN unit u ON u.id_unit = f.id_unit 
                                                 LEFT JOIN fasilitas_catagory fc ON fc.id_catagory = f.id_catagory 
                                                 WHERE f.status != 8 {$filter_f} 
                                                 ORDER BY u.name_unit ASC LIMIT 500")->result_array();
                if (!empty($fasilitases)) {
                    $context[] = "=== DATA PERALATAN (fasilitas) ===";
                    foreach ($fasilitases as $f) {
                        $st = $this->format_status($f['status']);
                        $kat = $f['kategori'] ? $f['kategori'] : 'Tanpa Kategori';
                        $context[] = "{$f['nama_fasilitas']}|Kategori: {$kat}|{$f['terminal']} {$f['zona']}|Unit: {$f['kode_unit']} - {$f['name_unit']}|{$st}";
                    }
                }

                // Alat (perangkat)
                $perangkats = $this->db->query("SELECT p.id_perangkat, p.nama_perangkat, p.serial_number, p.status, u.name_unit, u.kode_unit, jp.nama as jenis 
                                                FROM perangkat p 
                                                LEFT JOIN unit u ON u.id_unit = p.id_unit 
                                                LEFT JOIN jenis_perangkat jp ON jp.id_jenisperangkat = p.id_jenisperangkat 
                                                WHERE p.status != 8 {$filter_p} 
                                                ORDER BY u.name_unit ASC LIMIT 500")->result_array();
                if (!empty($perangkats)) {
                    $context[] = "=== DATA ALAT (perangkat) ===";
                    foreach ($perangkats as $p) {
                        $st = $this->format_status($p['status']);
                        $jenis = $p['jenis'] ? $p['jenis'] : 'Tanpa Jenis';
                        $context[] = "{$p['nama_perangkat']}|SN: {$p['serial_number']}|Jenis: {$jenis}|Unit: {$p['kode_unit']} - {$p['name_unit']}|{$st}";
                    }
                }
            } catch (Exception $e) {}
        }

        // ---------------------------------------------------
        // 8. KOMPONEN: KOMPONEN, KOMPONEN TERPAKAI, KOMPONEN MASUK
        // ---------------------------------------------------
        if (strpos($q, 'komponen') !== false || strpos($q, 'suku cadang') !== false || strpos($q, 'sparepart') !== false || 
            strpos($q, 'masuk') !== false || strpos($q, 'terpakai') !== false || strpos($q, 'stok') !== false || strpos($q, 'keluar') !== false) {
            try {
                $komponens = $this->db->query("SELECT k.id_komponen, k.nama_komponen, k.status, u.name_unit, u.kode_unit 
                                               FROM komponen k 
                                               LEFT JOIN unit u ON u.id_unit = k.id_unit 
                                               WHERE k.status != 8 {$filter_k} LIMIT 15")->result_array();
                if (!empty($komponens)) {
                    $context[] = "=== DATA KOMPONEN / SUKU CADANG (komponen) ===";
                    foreach ($komponens as $k) {
                        $st = $this->format_status($k['status']);
                        $context[] = "{$k['id_komponen']}|{$k['nama_komponen']}|Unit: {$k['kode_unit']} - {$k['name_unit']}|{$st}";
                    }
                }

                $k_terpakais = $this->db->query("SELECT kt.id_komponen_terpakai, k.nama_komponen, kt.satuan_terpakai, kt.status, tj.nomor as no_tinjut, tj.tanggal_selesai 
                                                 FROM komponen_terpakai kt 
                                                 LEFT JOIN komponen k ON k.id_komponen = kt.id_komponen 
                                                 LEFT JOIN tinjut tj ON tj.id_tinjut = kt.id_tinjut 
                                                 WHERE kt.status != 8 {$filter_tj} LIMIT 50")->result_array();
                if (!empty($k_terpakais)) {
                    $context[] = "=== DATA KOMPONEN TERPAKAI (komponen_terpakai) ===";
                    foreach ($k_terpakais as $kt) {
                        $st = $this->format_status($kt['status']);
                        $tgl = $kt['tanggal_selesai'] ? $kt['tanggal_selesai'] : 'N/A';
                        $context[] = "{$kt['nama_komponen']}|{$kt['satuan_terpakai']}x|TglKeluar:{$tgl}|{$kt['no_tinjut']}|{$st}";
                    }
                }

                $k_masuks = $this->db->query("SELECT km.id_komponen_masuk, k.nama_komponen, km.satuan_masuk, km.tanggal, km.status, u.name_unit, u.kode_unit 
                                              FROM komponen_masuk km 
                                              LEFT JOIN komponen k ON k.id_komponen = km.id_komponen 
                                              LEFT JOIN unit u ON u.id_unit = km.id_unit 
                                              WHERE km.status != 8 {$filter_km} LIMIT 10")->result_array();
                if (!empty($k_masuks)) {
                    $context[] = "=== DATA KOMPONEN MASUK / STOK (komponen_masuk) ===";
                    foreach ($k_masuks as $km) {
                        $st = $this->format_status($km['status']);
                        $context[] = "{$km['nama_komponen']}|{$km['satuan_masuk']}x|{$km['tanggal']}|Unit: {$km['kode_unit']} - {$km['name_unit']}|{$st}";
                    }
                }

                // AI Guide to calculate stock
                if (!empty($k_masuks) || !empty($k_terpakais)) {
                    $context[] = "=== PANDUAN PENTING MENGHITUNG STOK ===";
                    $context[] = "- Stok Saat Ini = Total Satuan Masuk dikurangi Total Satuan Terpakai.";
                    $context[] = "- Selalu hitung dan tampilkan stok saat ini dari selisih tersebut.";
                }

            } catch (Exception $e) {}
        }

        // ---------------------------------------------------
        // 9. JADWAL & USER
        // ---------------------------------------------------
        if (strpos($q, 'jadwal') !== false || strpos($q, 'user') !== false || strpos($q, 'petugas') !== false || strpos($q, 'shift') !== false || strpos($q, 'role') !== false || strpos($q, 'teknisi') !== false || strpos($q, 'admin') !== false || strpos($q, 'siapa') !== false || strpos($q, 'nama') !== false || strpos($q, 'orang') !== false) {
            try {
                $jadwals = $this->db->query("SELECT j.id_jadwal, j.fasilitas, j.tgl, j.shift, j.pm_type, j.status, u.name_unit, u.kode_unit 
                                             FROM jadwal j 
                                             LEFT JOIN unit u ON u.id_unit = j.id_unit 
                                             WHERE j.status != 8 {$filter_j} ORDER BY j.id_jadwal DESC LIMIT 15")->result_array();
                if (!empty($jadwals)) {
                    $context[] = "=== DATA JADWAL PERAWATAN & SHIFT (jadwal) ===";
                    foreach ($jadwals as $j) {
                        $st = $this->format_status($j['status']);
                        $context[] = "{$j['tgl']}|{$j['shift']}|{$j['fasilitas']}|{$j['pm_type']}|Unit: {$j['kode_unit']} - {$j['name_unit']}|{$st}";
                    }
                }

                $users = $this->db->query("SELECT u.id, u.nik, u.nama, u.jabatan, un.name_unit, un.kode_unit, r.name_role, u.status 
                                           FROM user u 
                                           LEFT JOIN role r ON r.id = u.type_user 
                                           LEFT JOIN unit un ON un.id_unit = u.unit_kerja 
                                           WHERE u.status != 8 LIMIT 200")->result_array();
                if (!empty($users)) {
                    $context[] = "=== DATA PETUGAS / USER SYSTEM (user) ===";
                    foreach ($users as $usr) {
                        $st = $this->format_status($usr['status']);
                        $role = $usr['name_role'] ? $usr['name_role'] : 'Tanpa Role';
                        $unit = $usr['name_unit'] ? $usr['kode_unit'] . ' - ' . $usr['name_unit'] : 'Tanpa Unit';
                        $context[] = "{$usr['nik']}|{$usr['nama']}|Role: {$role}|Unit: {$unit}|{$st}";
                    }
                }
            } catch (Exception $e) {}
        }

        // ---------------------------------------------------
        // 10. DEFAULT BACKUP: Tampilkan Ringkasan 23 Tabel Wajib bila Pertanyaan Umum
        // ---------------------------------------------------
        if (count($context) <= 5) {
            try {
                // Selalu sertakan Master Tipe PM dan Rincian PM per Unit & Tipe PM
                $pm_types = $this->db->query("SELECT idpm_type, kode, name_pm FROM pm_type WHERE status != 8")->result_array();
                if (!empty($pm_types)) {
                    $context[] = "=== MASTER TIPE PERAWATAN (pm_type) ===";
                    foreach ($pm_types as $pt) {
                        $context[] = "- Kode: {$pt['kode']} ({$pt['name_pm']})";
                    }
                }

                $pm_type_stat = $this->db->query("SELECT u.name_unit, u.kode_unit, pt.kode as kode_pm, pt.name_pm, COUNT(pm.id_pmheader) as total_pm 
                                                  FROM pm 
                                                  LEFT JOIN unit u ON u.id_unit = pm.id_unit 
                                                  LEFT JOIN pm_type pt ON pt.idpm_type = pm.idpm_type 
                                                  WHERE pm.status != 8 {$filter_pm} 
                                                  GROUP BY pm.id_unit, pm.idpm_type 
                                                  ORDER BY u.name_unit ASC, total_pm DESC LIMIT 50")->result_array();
                if (!empty($pm_type_stat)) {
                    $context[] = "=== RINCIAN JUMLAH PERAWATAN (PM) PER UNIT DENGAN KODE TIPE PM (2M, 1B, 3B, 6B, T) ===";
                    foreach ($pm_type_stat as $pts) {
                        $unit = $pts['name_unit'] ? $pts['kode_unit'] . ' - ' . $pts['name_unit'] : 'Tanpa Unit';
                        $kode = $pts['kode_pm'] ? $pts['kode_pm'] : 'Unspecified';
                        $context[] = "{$unit}|{$kode}|{$pts['total_pm']}x";
                    }
                }

                // Daftar Unit
                $units = $this->db->select('id_unit, kode_unit, name_unit, status')->from('unit')->where('status !=', 8)->where('1=1 ' . $filter_unit)->limit(30)->get()->result_array();
                if (!empty($units)) {
                    $context[] = "=== DAFTAR SELURUH UNIT KERJA (unit) ===";
                    foreach ($units as $u) {
                        $st = $this->format_status($u['status']);
                        $context[] = "{$u['id_unit']}|{$u['kode_unit']}|{$u['name_unit']}|{$st}";
                    }
                }
            } catch (Exception $e) {}
        }

        return implode("\n", $context);
    }
}
