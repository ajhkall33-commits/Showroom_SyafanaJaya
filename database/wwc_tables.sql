-- ========================================================
-- WWC (WAWANCARA) DATABASE TABLES FOR SHOWROOM SYAFANA JAYA
-- Compatible with MySQL 5.7+ / MariaDB / phpMyAdmin
-- ========================================================

-- 1. Tabel wwc_kriteria (Master Kriteria Wawancara Kompetensi)
CREATE TABLE IF NOT EXISTS `wwc_kriteria` (
  `id_kriteria` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_kriteria` varchar(50) DEFAULT NULL,
  `nama_kriteria` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=aktif, 0=nonaktif, 8=soft delete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kriteria`),
  KEY `wwc_kriteria_status_idx` (`status`),
  KEY `wwc_kriteria_urutan_idx` (`urutan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Tabel wwc_indikator (Master Indikator Kompetensi per Kriteria)
CREATE TABLE IF NOT EXISTS `wwc_indikator` (
  `id_indikator` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_kriteria` bigint(20) unsigned NOT NULL,
  `kode_indikator` varchar(50) DEFAULT NULL,
  `nama_indikator` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `bobot` int(11) NOT NULL DEFAULT 1,
  `nilai_min` decimal(5,2) NOT NULL DEFAULT 1.00,
  `nilai_max` decimal(5,2) NOT NULL DEFAULT 5.00,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=aktif, 0=nonaktif, 8=soft delete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_indikator`),
  KEY `wwc_indikator_id_kriteria_idx` (`id_kriteria`),
  KEY `wwc_indikator_status_idx` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Tabel wwc_unit_indikator (Mapping Indikator ke Unit Kerja & Jabatan/Role)
CREATE TABLE IF NOT EXISTS `wwc_unit_indikator` (
  `id_unit_indikator` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_indikator` bigint(20) unsigned NOT NULL,
  `id_unit` bigint(20) unsigned DEFAULT NULL,
  `id_role` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_unit_indikator`),
  KEY `wwc_unit_indikator_id_indikator_idx` (`id_indikator`),
  KEY `wwc_unit_indikator_id_unit_idx` (`id_unit`),
  KEY `wwc_unit_indikator_id_role_idx` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Tabel wwc_form_penilaian (Master Form Sesi Wawancara)
CREATE TABLE IF NOT EXISTS `wwc_form_penilaian` (
  `id_form` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_form` varchar(50) DEFAULT NULL,
  `nama_form` varchar(255) NOT NULL,
  `id_peserta` bigint(20) unsigned DEFAULT NULL,
  `id_unit` bigint(20) unsigned DEFAULT NULL,
  `id_role` bigint(20) unsigned DEFAULT NULL,
  `tanggal_penilaian` date DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=draft, 1=in progress/aktif, 2=selesai, 8=soft delete',
  `user_created` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_form`),
  KEY `wwc_form_id_unit_idx` (`id_unit`),
  KEY `wwc_form_id_role_idx` (`id_role`),
  KEY `wwc_form_status_idx` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Tabel wwc_detail_form_penilaian (Indikator terpilih dalam Form)
CREATE TABLE IF NOT EXISTS `wwc_detail_form_penilaian` (
  `id_detail_form` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_form` bigint(20) unsigned NOT NULL,
  `id_indikator` bigint(20) unsigned NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_detail_form`),
  KEY `wwc_detail_form_id_form_idx` (`id_form`),
  KEY `wwc_detail_form_id_indikator_idx` (`id_indikator`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Tabel wwc_form_assessor (Penugasan Penguji/Assessor pada Form)
CREATE TABLE IF NOT EXISTS `wwc_form_assessor` (
  `id_form_assessor` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_form` bigint(20) unsigned NOT NULL,
  `id_user` bigint(20) unsigned NOT NULL COMMENT 'ID User penguji/assessor',
  `urutan` int(11) NOT NULL DEFAULT 1,
  `catatan` text DEFAULT NULL,
  `assigned_at` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=ditugaskan, 1=selesai, 8=soft delete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_form_assessor`),
  KEY `wwc_assessor_id_form_idx` (`id_form`),
  KEY `wwc_assessor_id_user_idx` (`id_user`),
  KEY `wwc_assessor_status_idx` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. Tabel wwc_form_assessor_peserta (Peserta Tertentu yang Ditugaskan ke Assessor Spesifik)
CREATE TABLE IF NOT EXISTS `wwc_form_assessor_peserta` (
  `id_form_assessor_peserta` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_form_assessor` bigint(20) unsigned NOT NULL,
  `id_peserta` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_form_assessor_peserta`),
  KEY `wwc_fap_id_form_assessor_idx` (`id_form_assessor`),
  KEY `wwc_fap_id_peserta_idx` (`id_peserta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 8. Tabel wwc_penilaian (Header Hasil Penilaian oleh Assessor per Peserta)
CREATE TABLE IF NOT EXISTS `wwc_penilaian` (
  `id_penilaian` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_form` bigint(20) unsigned NOT NULL,
  `id_form_assessor` bigint(20) unsigned NOT NULL,
  `id_peserta` bigint(20) unsigned NOT NULL,
  `total_nilai` decimal(8,2) NOT NULL DEFAULT 0.00,
  `persentase` decimal(5,2) NOT NULL DEFAULT 0.00,
  `catatan` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=draft, 1=final/submit',
  `tanggal_mulai` datetime DEFAULT NULL,
  `tanggal_selesai` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_penilaian`),
  KEY `wwc_penilaian_id_form_idx` (`id_form`),
  KEY `wwc_penilaian_id_form_assessor_idx` (`id_form_assessor`),
  KEY `wwc_penilaian_id_peserta_idx` (`id_peserta`),
  KEY `wwc_penilaian_status_idx` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 9. Tabel wwc_detail_penilaian (Skor per Butir Indikator)
CREATE TABLE IF NOT EXISTS `wwc_detail_penilaian` (
  `id_detail_penilaian` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_penilaian` bigint(20) unsigned NOT NULL,
  `id_indikator` bigint(20) unsigned NOT NULL,
  `nilai` decimal(8,2) NOT NULL DEFAULT 0.00,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_detail_penilaian`),
  KEY `wwc_detail_penilaian_id_penilaian_idx` (`id_penilaian`),
  KEY `wwc_detail_penilaian_id_indikator_idx` (`id_indikator`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
