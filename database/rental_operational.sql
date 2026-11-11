-- Migration untuk fitur Manajemen Sewa Mobil, Invoicing, Perpanjangan, Laporan Harian, Kontrak, Multi-Unit per Penyewa, dan User admin_oprational

CREATE TABLE IF NOT EXISTS `rental_booking` (
  `id_booking` int(11) NOT NULL AUTO_INCREMENT,
  `no_invoice` varchar(40) NOT NULL,
  `nama_user` varchar(150) NOT NULL,
  `no_hp_user` varchar(30) DEFAULT NULL,
  `alamat_user` text DEFAULT NULL,
  `status_pembayaran` enum('Belum Lunas','DP','Lunas') NOT NULL DEFAULT 'Belum Lunas',
  `jumlah_dp` decimal(15,2) NOT NULL DEFAULT 0.00,
  `catatan` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_booking`),
  UNIQUE KEY `uniq_booking_invoice` (`no_invoice`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `rental_transaksi` (
  `id_sewa` int(11) NOT NULL AUTO_INCREMENT,
  `id_booking` int(11) DEFAULT NULL,
  `no_invoice` varchar(40) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `jam_kembali` varchar(10) DEFAULT NULL,
  `hari` int(11) NOT NULL DEFAULT 1,
  `nama_user` varchar(150) NOT NULL,
  `no_hp_user` varchar(30) DEFAULT NULL,
  `alamat_user` text DEFAULT NULL,
  `asal_unit` enum('garasi','luar') NOT NULL DEFAULT 'garasi',
  `id_unit` int(11) DEFAULT NULL,
  `nama_unit_asal` varchar(100) NOT NULL DEFAULT 'Garasi',
  `tipe_unit` varchar(100) NOT NULL,
  `plat_nomor` varchar(30) NOT NULL,
  `warna` varchar(50) DEFAULT NULL,
  `harga_user` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_masuk` decimal(15,2) NOT NULL DEFAULT 0.00,
  `rent_to_rent_harian` decimal(15,2) NOT NULL DEFAULT 0.00,
  `rent_to_rent` decimal(15,2) NOT NULL DEFAULT 0.00,
  `unit_garasi` decimal(15,2) NOT NULL DEFAULT 0.00,
  `unit_luar` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` enum('Open','Selesai') NOT NULL DEFAULT 'Open',
  `status_pembayaran` enum('Belum Lunas','DP','Lunas') NOT NULL DEFAULT 'Belum Lunas',
  `jumlah_dp` decimal(15,2) NOT NULL DEFAULT 0.00,
  `catatan` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_sewa`),
  KEY `idx_no_invoice` (`no_invoice`),
  KEY `idx_booking` (`id_booking`),
  KEY `idx_tanggal_mulai` (`tanggal_mulai`),
  KEY `idx_status` (`status`),
  KEY `idx_asal_unit` (`asal_unit`),
  KEY `idx_id_unit` (`id_unit`),
  CONSTRAINT `fk_transaksi_booking` FOREIGN KEY (`id_booking`) REFERENCES `rental_booking` (`id_booking`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `rental_perpanjangan` (
  `id_perpanjangan` int(11) NOT NULL AUTO_INCREMENT,
  `id_sewa` int(11) NOT NULL,
  `tanggal_selesai_lama` date NOT NULL,
  `tanggal_selesai_baru` date NOT NULL,
  `tambah_hari` int(11) NOT NULL DEFAULT 1,
  `harga_user_harian` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tambahan_tagihan` decimal(15,2) NOT NULL DEFAULT 0.00,
  `rent_to_rent_harian` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tambahan_rent_to_rent` decimal(15,2) NOT NULL DEFAULT 0.00,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_perpanjangan`),
  KEY `idx_perpanjangan_sewa` (`id_sewa`),
  CONSTRAINT `fk_perpanjangan_sewa` FOREIGN KEY (`id_sewa`) REFERENCES `rental_transaksi` (`id_sewa`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `rental_kontrak` (
  `id_kontrak` int(11) NOT NULL AUTO_INCREMENT,
  `no_kontrak` varchar(50) NOT NULL,
  `id_booking` int(11) DEFAULT NULL,
  `id_sewa` int(11) DEFAULT NULL,
  `tanggal_kontrak` date NOT NULL,
  `nama_perusahaan` varchar(150) DEFAULT NULL,
  `penanggung_jawab` varchar(150) DEFAULT NULL,
  `pihak_pertama_nama` varchar(150) NOT NULL DEFAULT 'Anggun Suryo Adi Nugroho',
  `nik_ktp` varchar(30) DEFAULT NULL,
  `no_sim` varchar(30) DEFAULT NULL,
  `no_hp` varchar(30) DEFAULT NULL,
  `alamat_penyewa` text NOT NULL,
  `jaminan` varchar(150) DEFAULT NULL,
  `tujuan_pemakaian` varchar(150) DEFAULT NULL,
  `warna_unit` varchar(150) DEFAULT NULL,
  `jangka_waktu_label` varchar(120) DEFAULT NULL,
  `skema_pembayaran` text DEFAULT NULL,
  `bank_nama` varchar(50) NOT NULL DEFAULT 'BCA',
  `bank_no_rek` varchar(60) NOT NULL DEFAULT '2222 333 033',
  `bank_atas_nama` varchar(100) NOT NULL DEFAULT 'GRAHA TRANSPORT CV',
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `nilai_kontrak` decimal(15,2) NOT NULL DEFAULT 0.00,
  `objek_unit_json` text DEFAULT NULL,
  `km_awal` varchar(30) DEFAULT NULL,
  `bbm_awal` varchar(30) DEFAULT NULL,
  `kelengkapan` text DEFAULT NULL,
  `catatan_kondisi` text DEFAULT NULL,
  `syarat_ketentuan` text DEFAULT NULL,
  `status_kontrak` enum('Aktif','Selesai','Dibatalkan') NOT NULL DEFAULT 'Aktif',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_kontrak`),
  UNIQUE KEY `uniq_no_kontrak` (`no_kontrak`),
  KEY `idx_kontrak_booking` (`id_booking`),
  KEY `idx_kontrak_sewa` (`id_sewa`),
  CONSTRAINT `fk_kontrak_sewa` FOREIGN KEY (`id_sewa`) REFERENCES `rental_transaksi` (`id_sewa`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Notifikasi Realtime & Push Notification HP Android
CREATE TABLE IF NOT EXISTS `rental_push_subscription` (
  `id_sub` int(11) NOT NULL AUTO_INCREMENT,
  `id_agency` int(11) DEFAULT NULL,
  `endpoint` text NOT NULL,
  `endpoint_hash` char(64) NOT NULL,
  `p256dh` varchar(255) NOT NULL,
  `auth` varchar(255) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_sub`),
  UNIQUE KEY `uniq_endpoint_hash` (`endpoint_hash`),
  KEY `idx_sub_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `rental_notifikasi_setting` (
  `id` int(11) NOT NULL,
  `vapid_public_key` varchar(255) DEFAULT NULL,
  `vapid_private_pem` text DEFAULT NULL,
  `vapid_subject` varchar(150) NOT NULL DEFAULT 'mailto:grahatransportungaran@gmail.com',
  `cron_token` varchar(64) NOT NULL,
  `ntfy_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `ntfy_topic` varchar(120) DEFAULT NULL,
  `telegram_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `telegram_bot_token` varchar(150) DEFAULT NULL,
  `telegram_chat_id` varchar(80) DEFAULT NULL,
  `fonnte_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `fonnte_token` varchar(150) DEFAULT NULL,
  `fonnte_target` varchar(50) DEFAULT NULL,
  `reminder_interval_hours` int(11) NOT NULL DEFAULT 12,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `rental_notifikasi_log` (
  `id_notif` int(11) NOT NULL AUTO_INCREMENT,
  `id_sewa` int(11) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `pesan` text NOT NULL,
  `hari_terlambat` int(11) NOT NULL DEFAULT 1,
  `channel` varchar(80) NOT NULL DEFAULT 'in_app',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `sent_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_notif`),
  KEY `idx_notif_sewa_sent` (`id_sewa`, `sent_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `rental_notifikasi_setting` (`id`, `cron_token`, `reminder_interval_hours`)
VALUES (1, SHA2(CONCAT(NOW(), RAND(), 'graha_transport'), 256), 12);

-- Seed default user admin_oprational (password: operational123) jika belum ada
INSERT INTO `agency` (`username`, `password`, `nama_agent`, `position`, `alamat`, `no_tlp`, `email`, `foto_profil`, `created`)
SELECT 'admin_oprational', '$2y$10$wGgzbH3qGJl.GoRqrn1yluZpho83ozbBxq9uUc5kQQixI7Bck.mua', 'Admin Operational', 'admin_oprational', 'Jl. Arjuna III No.17, Mapagan, Kab. Semarang', 6281327160516, 'operational@grahatransport.web.id', 'profile_1726635210.png', NOW()
WHERE NOT EXISTS (
  SELECT 1 FROM `agency` WHERE `username` = 'admin_oprational' OR `position` = 'admin_oprational'
);
