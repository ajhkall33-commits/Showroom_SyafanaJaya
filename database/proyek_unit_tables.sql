CREATE TABLE IF NOT EXISTS `proyek` (
  `id_proyek` int(11) NOT NULL AUTO_INCREMENT,
  `nama_proyek` varchar(150) NOT NULL,
  `deskripsi_proyek` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_proyek`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `unit` (
  `id_unit` int(11) NOT NULL AUTO_INCREMENT,
  `id_proyek` int(11) DEFAULT NULL,
  `nama_unit` varchar(150) NOT NULL,
  `deskripsi_unit` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_unit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `proyek` (`nama_proyek`, `deskripsi_proyek`, `created_at`, `updated_at`)
SELECT 'Proyek Penilaian Kinerja 2026', 'Evaluasi performa berkala personil', NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM `proyek` LIMIT 1);

INSERT INTO `unit` (`nama_unit`, `deskripsi_unit`, `created_at`, `updated_at`)
SELECT 'Unit Pelayanan dan Operasional', 'Unit kerja pelayanan personil', NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM `unit` LIMIT 1);
