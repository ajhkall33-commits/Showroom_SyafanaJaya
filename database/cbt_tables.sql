-- ========================================================
-- CBT DATABASE TABLES FOR SHOWROOM SYAFANA JAYA
-- Compatible with MySQL 5.7+ / MariaDB / phpMyAdmin
-- ========================================================

-- 1. Tabel cbt_bank_soal
CREATE TABLE IF NOT EXISTS `cbt_bank_soal` (
  `id_bank_soal_cbt` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pertanyaan` longtext NOT NULL,
  `opsi_a` longtext DEFAULT NULL,
  `opsi_b` longtext DEFAULT NULL,
  `opsi_c` longtext DEFAULT NULL,
  `opsi_d` longtext DEFAULT NULL,
  `jawaban` varchar(10) DEFAULT NULL,
  `bobot` int(11) NOT NULL DEFAULT 1,
  `tanggal` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=aktif, 0=nonaktif, 8=soft delete',
  `user_created` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_bank_soal_cbt`),
  KEY `cbt_bank_soal_status_idx` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Tabel cbt_unit_bank_soal (Mapping Unit & Jabatan)
CREATE TABLE IF NOT EXISTS `cbt_unit_bank_soal` (
  `id_unit_bank_soal` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_bank_soal` bigint(20) unsigned NOT NULL,
  `id_unit` bigint(20) unsigned DEFAULT NULL,
  `id_role` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_unit_bank_soal`),
  KEY `cbt_unit_bank_soal_id_bank_soal_idx` (`id_bank_soal`),
  KEY `cbt_unit_bank_soal_id_unit_idx` (`id_unit`),
  KEY `cbt_unit_bank_soal_id_role_idx` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Tabel cbt_ujian (Master Ujian)
CREATE TABLE IF NOT EXISTS `cbt_ujian` (
  `id_ujian_cbt` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_ujian_cbt` varchar(255) NOT NULL,
  `id_unit` bigint(20) unsigned DEFAULT NULL,
  `id_role` bigint(20) unsigned DEFAULT NULL,
  `tanggal_mulai` datetime DEFAULT NULL,
  `tanggal_selesai` datetime DEFAULT NULL,
  `durasi_menit` int(11) NOT NULL DEFAULT 60,
  `jumlah_soal` int(11) NOT NULL DEFAULT 0,
  `acak_soal` tinyint(4) NOT NULL DEFAULT 0,
  `acak_jawaban` tinyint(4) NOT NULL DEFAULT 0,
  `token` varchar(20) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=draft, 1=aktif, 2=tutup, 8=soft delete',
  `user_created` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_ujian_cbt`),
  KEY `cbt_ujian_id_unit_idx` (`id_unit`),
  KEY `cbt_ujian_id_role_idx` (`id_role`),
  KEY `cbt_ujian_status_idx` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Tabel cbt_detail_ujian (Soal Masuk ke Ujian)
CREATE TABLE IF NOT EXISTS `cbt_detail_ujian` (
  `id_detail_ujian_cbt` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_ujian_cbt` bigint(20) unsigned NOT NULL,
  `id_bank_soal_cbt` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_detail_ujian_cbt`),
  KEY `cbt_detail_ujian_id_ujian_cbt_idx` (`id_ujian_cbt`),
  KEY `cbt_detail_ujian_id_bank_soal_cbt_idx` (`id_bank_soal_cbt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Tabel cbt_hasil_ujian (Rekap Nilai Peserta)
CREATE TABLE IF NOT EXISTS `cbt_hasil_ujian` (
  `id_hasil_ujian_cbt` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_ujian_cbt` bigint(20) unsigned NOT NULL,
  `id_user` bigint(20) unsigned NOT NULL,
  `tanggal_mulai` datetime DEFAULT NULL,
  `tanggal_selesai` datetime DEFAULT NULL,
  `jumlah_benar` int(11) NOT NULL DEFAULT 0,
  `jumlah_salah` int(11) NOT NULL DEFAULT 0,
  `jumlah_selesai` int(11) NOT NULL DEFAULT 0,
  `jumlah_kosong` int(11) NOT NULL DEFAULT 0,
  `nilai` decimal(6,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=mengerjakan, 1=selesai',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_hasil_ujian_cbt`),
  KEY `cbt_hasil_ujian_id_ujian_cbt_idx` (`id_ujian_cbt`),
  KEY `cbt_hasil_ujian_id_user_idx` (`id_user`),
  KEY `cbt_hasil_ujian_status_idx` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Tabel cbt_detail_hasil_ujian (Rincian Jawaban Peserta)
CREATE TABLE IF NOT EXISTS `cbt_detail_hasil_ujian` (
  `id_detail_hasil_ujian_cbt` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_hasil_ujian_cbt` bigint(20) unsigned NOT NULL,
  `id_bank_soal_cbt` bigint(20) unsigned NOT NULL,
  `jawaban_user` varchar(10) DEFAULT NULL,
  `benar_persoal` tinyint(4) NOT NULL DEFAULT 0,
  `nilai_diperoleh_persoal` decimal(6,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_detail_hasil_ujian_cbt`),
  KEY `cbt_detail_hasil_ujian_id_hasil_ujian_cbt_idx` (`id_hasil_ujian_cbt`),
  KEY `cbt_detail_hasil_ujian_id_bank_soal_cbt_idx` (`id_bank_soal_cbt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. Tabel cbt_proses_ujian (Smart Proctoring Session)
CREATE TABLE IF NOT EXISTS `cbt_proses_ujian` (
  `id_proses_ujian_cbt` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_ujian_cbt` bigint(20) unsigned NOT NULL,
  `id_user` bigint(20) unsigned NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Sedang Mengerjakan',
  `waktu_mulai` datetime DEFAULT NULL,
  `waktu_selesai` datetime DEFAULT NULL,
  `warning_count` int(11) NOT NULL DEFAULT 0,
  `foto_awal` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_proses_ujian_cbt`),
  KEY `cbt_proses_ujian_id_ujian_cbt_idx` (`id_ujian_cbt`),
  KEY `cbt_proses_ujian_id_user_idx` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 8. Tabel cbt_log_monitoring (Log & Bukti Pelanggaran)
CREATE TABLE IF NOT EXISTS `cbt_log_monitoring` (
  `id_log_monitoring_cbt` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_proses_ujian_cbt` bigint(20) unsigned NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `nilai` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `foto_bukti` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_log_monitoring_cbt`),
  KEY `cbt_log_monitoring_id_proses_ujian_cbt_idx` (`id_proses_ujian_cbt`),
  KEY `cbt_log_monitoring_jenis_idx` (`jenis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
