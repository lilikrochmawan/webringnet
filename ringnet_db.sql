-- ========================================================
-- RING NETWORK - Database Export for MySQL (phpMyAdmin)
-- Generated on 2026-11-18 14:53:05
-- ========================================================

CREATE DATABASE IF NOT EXISTS `ringnet_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ringnet_db`;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `key` varchar(100) NOT NULL,
  `value` text DEFAULT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `navbar_menus`;
CREATE TABLE `navbar_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT 0,
  `title` varchar(150) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon` varchar(100) DEFAULT 'fa-solid fa-link',
  `description` text DEFAULT NULL,
  `badge` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL UNIQUE,
  `category` varchar(50) DEFAULT 'general',
  `icon` varchar(100) DEFAULT 'fa-solid fa-cube',
  `short_desc` text DEFAULT NULL,
  `full_desc` text DEFAULT NULL,
  `features` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `badge` varchar(50) DEFAULT NULL,
  `show_in_navbar` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `internet_packages`;
CREATE TABLE `internet_packages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) NOT NULL,
  `name` varchar(150) NOT NULL,
  `speed` varchar(100) NOT NULL,
  `fup` varchar(150) NOT NULL,
  `price` varchar(50) NOT NULL,
  `billing_cycle` varchar(50) DEFAULT '/bulan',
  `features` text DEFAULT NULL,
  `badge` varchar(50) DEFAULT NULL,
  `is_popular` tinyint(1) DEFAULT 0,
  `whatsapp_text` text DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `coverage_areas`;
CREATE TABLE `coverage_areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area_name` varchar(200) NOT NULL,
  `subdistrict` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT 'Kulon Progo',
  `odp_code` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Tersedia',
  `notes` text DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `inquiries`;
CREATE TABLE `inquiries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `package_or_service` varchar(150) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Baru',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data for table `users`
INSERT INTO `users` (`id`, `username`, `password`, `name`, `email`, `created_at`) VALUES ('1', 'admin', '$2y$10$Vv1kgnnoxW0yT2t6SoYHRuccPNWSSwWQjteWYFylANNlrEgob5dhG', 'Administrator RingNet', 'admin@ringnetwork.co.id', '2026-11-18 06:51:12');

-- Data for table `settings`
INSERT INTO `settings` (`key`, `value`) VALUES ('company_name', 'Ring Network');
INSERT INTO `settings` (`key`, `value`) VALUES ('tagline', 'Connect • Secure • Empower');
INSERT INTO `settings` (`key`, `value`) VALUES ('email', 'sales@ringnetwork.co.id');
INSERT INTO `settings` (`key`, `value`) VALUES ('support_email', 'support@ringnetwork.co.id');
INSERT INTO `settings` (`key`, `value`) VALUES ('operational_hours', 'Senin - Minggu: 24 Jam Non-Stop (NOC & Helpdesk)');
INSERT INTO `settings` (`key`, `value`) VALUES ('hero_title', 'Konektivitas Internet Cepat, Stabil & Solusi IT Terintegrasi');
INSERT INTO `settings` (`key`, `value`) VALUES ('hero_subtitle', 'Ring Network menghadirkan jaringan internet fiber optic berkecepatan tinggi tanpa hambatan, instalasi jaringan profesional, proteksi CCTV modern berbasis AI, hingga setup server handal untuk rumah, residensial, dan bisnis Anda.');
INSERT INTO `settings` (`key`, `value`) VALUES ('speed_guarantee', '99.9% Uptime Guarantee');
INSERT INTO `settings` (`key`, `value`) VALUES ('gmaps_url', 'https://maps.google.com');
INSERT INTO `settings` (`key`, `value`) VALUES ('phone', '+62 812-2934-2503');
INSERT INTO `settings` (`key`, `value`) VALUES ('whatsapp', '6281229342503');
INSERT INTO `settings` (`key`, `value`) VALUES ('address', 'Kantor POP Ring Network: Pedukuhan 7, RT.26/RW.13, Dusun VII, Cerme, Kec. Panjatan, Kabupaten Kulon Progo, Daerah Istimewa Yogyakarta 55655');
INSERT INTO `settings` (`key`, `value`) VALUES ('city', 'Kulon Progo, D.I. Yogyakarta');
INSERT INTO `settings` (`key`, `value`) VALUES ('company_legal', 'Ring Network');

-- Data for table `navbar_menus`
INSERT INTO `navbar_menus` (`id`, `parent_id`, `title`, `url`, `icon`, `description`, `badge`, `sort_order`, `is_active`, `created_at`) VALUES ('1', '1', 'Penjualan Internet Fiber', '#paket-internet', 'fa-solid fa-wifi', 'Paket internet ultra cepat untuk Home & Residensial', 'Populer', '1', '1', '2026-11-18 06:51:12');
INSERT INTO `navbar_menus` (`id`, `parent_id`, `title`, `url`, `icon`, `description`, `badge`, `sort_order`, `is_active`, `created_at`) VALUES ('2', '1', 'Pemasangan Jaringan & FO', '#layanan', 'fa-solid fa-network-wired', 'Jasa instalasi LAN, Splicing FO & Wi-Fi Mesh', 'Pro', '2', '1', '2026-11-18 06:51:12');
INSERT INTO `navbar_menus` (`id`, `parent_id`, `title`, `url`, `icon`, `description`, `badge`, `sort_order`, `is_active`, `created_at`) VALUES ('3', '1', 'Pemasangan CCTV Smart AI', '#cctv', 'fa-solid fa-video', 'Keamanan visual 24/7 jernih dengan kontrol HP', 'Promo', '3', '1', '2026-11-18 06:51:12');
INSERT INTO `navbar_menus` (`id`, `parent_id`, `title`, `url`, `icon`, `description`, `badge`, `sort_order`, `is_active`, `created_at`) VALUES ('4', '1', 'Setup & Maintenance Server', '#server', 'fa-solid fa-server', 'Server rack, virtualisasi & backup data center', 'Enterprise', '4', '1', '2026-11-18 06:51:12');

-- Data for table `services`
INSERT INTO `services` (`id`, `title`, `slug`, `category`, `icon`, `short_desc`, `full_desc`, `features`, `image`, `badge`, `show_in_navbar`, `sort_order`, `is_active`, `created_at`) VALUES ('1', 'Penjualan Internet Fiber', 'penjualan-internet', 'internet', 'fa-solid fa-wifi', 'Koneksi internet broadband dan dedicated berkecepatan tinggi dengan latensi ultra rendah untuk rumah, residensial, dan korporasi.', 'Layanan internet fiber optic Ring Network menawarkan kecepatan simetris unduh dan unggah tanpa lag. Dilengkapi dukungan SLA hingga 99.9% dan proteksi rute ganda untuk menjamin kelancaran aktivitas online, streaming 4K, video conference, dan gaming kompetitif.', 'Kecepatan Simetris 1:1 Download & Upload
Infrastruktur 100% Fiber Optic Full Duplex
Tanpa Batasan FUP / FUP Fleksibel Sesuai Kebutuhan
Gratis Sewa Router Dual-Band Wi-Fi 6
Monitoring NOC 24/7 Realtime', 'service_internet.jpg', 'Unggulan', '1', '1', '1', '2026-11-18 06:51:12');
INSERT INTO `services` (`id`, `title`, `slug`, `category`, `icon`, `short_desc`, `full_desc`, `features`, `image`, `badge`, `show_in_navbar`, `sort_order`, `is_active`, `created_at`) VALUES ('2', 'Pemasangan Jaringan Internet', 'pemasangan-jaringan', 'networking', 'fa-solid fa-network-wired', 'Instalasi kabel fiber optic, penarikan kabel LAN UTP/STP, wireless PtP, hingga manajemen router Mikrotik & switch manageable.', 'Kami melayani jasa penataan dan pemasangan infrastruktur jaringan skala kecil hingga enterprise. Mulai dari penarikan kabel terstruktur (structured cabling), instalasi ODP/closure fiber optic, splicing fusion, konfigurasi hotspot manajemen voucher, hingga instalasi mesh Wi-Fi untuk gedung perkantoran, perumahan, pabrik, dan hotel.', 'Splicing Fiber Optic & Penarikan Kabel FO/LAN
Setting Routerboard Mikrotik, Cisco & Fortinet
Instalasi Access Point Enterprise & UniFi Mesh
Perapian Rack Server & Dokumentasi Wiring Jaringan
Audit Sinyal Wi-Fi & Troubleshooting Latensi', 'service_network.jpg', 'Profesional', '1', '2', '1', '2026-11-18 06:51:12');
INSERT INTO `services` (`id`, `title`, `slug`, `category`, `icon`, `short_desc`, `full_desc`, `features`, `image`, `badge`, `show_in_navbar`, `sort_order`, `is_active`, `created_at`) VALUES ('3', 'Pemasangan CCTV & Smart AI', 'pemasangan-cctv', 'security', 'fa-solid fa-video', 'Sistem kamera pengawas IP Cam & Analog beresolusi tinggi, fitur ColorVu malam berwarna, dan pantauan real-time via smartphone.', 'Amankan properti, hunian perumahan, gudang, maupun perkantoran Anda dengan sistem CCTV cerdas dari Ring Network. Didukung fitur AI deteksi wajah, perimeter alert, integrasi NVR dengan kapasitas penyimpanan besar, serta akses live view kapan saja dan di mana saja melalui aplikasi HP.', 'Kamera Resolusi 4K Ultra HD & ColorVu (Malam Tetap Berwarna)
Deteksi Gerak Berbasis AI & Notifikasi Instan ke HP
Pemasangan Rapi Menggunakan Pipa Conduit / Tray
Setup NVR / DVR & Harddisk Khusus Surveillance
Garansi Resmi Perangkat & Purnajual Terjamin', 'service_cctv.jpg', 'Populer', '1', '3', '1', '2026-11-18 06:51:12');
INSERT INTO `services` (`id`, `title`, `slug`, `category`, `icon`, `short_desc`, `full_desc`, `features`, `image`, `badge`, `show_in_navbar`, `sort_order`, `is_active`, `created_at`) VALUES ('4', 'Setup & Maintenance Server', 'setup-server', 'server', 'fa-solid fa-server', 'Instalasi server on-premise, virtualisasi Proxmox/VMware, konfigurasi file sharing, active directory, backup otomatis, dan monitoring server.', 'Pastikan ekosistem data perusahaan Anda aman dan selalu online. Tim kami berpengalaman dalam merakit rak server, instalasi OS Linux/Windows Server, setting NAS Storage backup otomatis, firewall hardware, sistem disaster recovery, serta penyediaan UPS daya cadangan berstandar data center.', 'Instalasi Rackmount Server & Cable Management Rapi
Virtualisasi Virtual Server (Proxmox VE / VMware ESXi)
File Server, Active Directory Domain & VPN Antar Cabang
Automated Backup System & Disaster Recovery Plan
Maintenance Rutin & Kontrak Perawatan Berkala', 'service_server.jpg', 'Enterprise', '1', '4', '1', '2026-11-18 06:51:12');

-- Data for table `internet_packages`
INSERT INTO `internet_packages` (`id`, `category`, `name`, `speed`, `fup`, `price`, `billing_cycle`, `features`, `badge`, `is_popular`, `whatsapp_text`, `sort_order`, `is_active`, `created_at`) VALUES ('4', 'residential', 'Ring Resident Silver', '50 Mbps', 'Tanpa FUP (Dedicated 1:1)', '500.000', '/bulan', 'Kecepatan Simetris 50 Mbps Dedicated 1:1
100% Tanpa FUP & Bandwidth Murni
Ideal untuk Cluster Hunian & Rumah Bertingkat
Router Wi-Fi 6 High Power Long Range
SLA Uptime 99.5% Dijamin Kontrak
Layanan Kunjungan Teknisi Prioritas Khusus', 'Best Choice', '0', 'Halo Ring Network, saya ingin menanyakan pemasangan Paket Ring Resident Silver 50 Mbps seharga Rp 500.000/bulan untuk area perumahan saya.', '1', '1', '2026-11-18 06:51:12');
INSERT INTO `internet_packages` (`id`, `category`, `name`, `speed`, `fup`, `price`, `billing_cycle`, `features`, `badge`, `is_popular`, `whatsapp_text`, `sort_order`, `is_active`, `created_at`) VALUES ('5', 'residential', 'Ring Resident Gold', '100 Mbps', 'Tanpa FUP (Dedicated 1:1)', '1.000.000', '/bulan', 'Kecepatan Simetris 100 Mbps Dedicated 1:1
100% Tanpa FUP / Uncapped Bandwidth
Termasuk 1 Unit Router Wi-Fi 6 + 1 Mesh Extender
Gratis 1 Titik Akses Tambahan Lantai 2
SLA Uptime 99.8% dengan Backup Link Redundan
Dukungan Personal Account Manager & NOC 24 Jam', 'Paling Laris', '1', 'Halo Ring Network, saya ingin memesan Paket Ring Resident Gold 100 Mbps seharga Rp 1.000.000/bulan untuk tempat tinggal saya.', '2', '1', '2026-11-18 06:51:12');
INSERT INTO `internet_packages` (`id`, `category`, `name`, `speed`, `fup`, `price`, `billing_cycle`, `features`, `badge`, `is_popular`, `whatsapp_text`, `sort_order`, `is_active`, `created_at`) VALUES ('6', 'residential', 'Ring Resident Platinum', '200 Mbps', 'Tanpa FUP (Dedicated 1:1)', '2.000.000', '/bulan', 'Kecepatan Simetris 200 Mbps Dedicated 1:1
100% Bebas FUP Sepuasnya
Pilihan Gratis IP Publik Statis (/32) untuk Server / CCTV
Paket Termasuk Router Enterprise & 2 Mesh Wi-Fi 6
SLA Uptime 99.9% Super Reliable
Prioritas Penanganan Maksimal 2 Jam On-Site', 'Ultra Premium', '0', 'Halo Ring Network, saya ingin berkonsultasi mengenai Paket Ring Resident Platinum 200 Mbps seharga Rp 2.000.000/bulan.', '3', '1', '2026-11-18 06:51:12');
INSERT INTO `internet_packages` (`id`, `category`, `name`, `speed`, `fup`, `price`, `billing_cycle`, `features`, `badge`, `is_popular`, `whatsapp_text`, `sort_order`, `is_active`, `created_at`) VALUES ('7', 'residential', 'Ring Resident Fiber Max', '300 Mbps', 'Tanpa FUP (Dedicated 1:1)', '3.000.000', '/bulan', 'Kecepatan Simetris 300 Mbps Dedicated 1:1 Ekstrem
100% Tanpa Batasan Kuota / FUP Apapun
Free IP Publik Statis Resmi
Infrastruktur Fiber Optic Langsung dari Core Distribution
Ultra Low Latency ke Server Internasional & Lokal
Layanan VIP Dedicated 24/7 Direct Line', 'Maximum Speed', '0', 'Halo Ring Network, saya berminat dengan Paket Ring Resident Fiber Max 300 Mbps seharga Rp 3.000.000/bulan.', '4', '1', '2026-11-18 06:51:12');
INSERT INTO `internet_packages` (`id`, `category`, `name`, `speed`, `fup`, `price`, `billing_cycle`, `features`, `badge`, `is_popular`, `whatsapp_text`, `sort_order`, `is_active`, `created_at`) VALUES ('8', 'home', 'Ring Home Starter', '50 Mbps', 'Unlimited (Tanpa Batas FUP)', '150.000', '/bulan', 'Kecepatan Up to 50 Mbps Simetris
Unlimited Kuota (100% Bebas FUP)
Ideal untuk 3 - 5 Perangkat Sekaligus
Gratis Modem Router Wi-Fi Dual Band
Gratis Biaya Pemasangan Pertama
Support NOC & Teknisi 24 Jam', 'Ekonomis', '1', '', '1', '1', '2026-11-18 07:11:53');
INSERT INTO `internet_packages` (`id`, `category`, `name`, `speed`, `fup`, `price`, `billing_cycle`, `features`, `badge`, `is_popular`, `whatsapp_text`, `sort_order`, `is_active`, `created_at`) VALUES ('9', 'home', 'Ring Home Family', '75 Mbps', 'Unlimited (Tanpa Batas FUP)', '175.000', '/bulan', 'Kecepatan Up to 75 Mbps Simetris
Unlimited Kuota (100% Bebas FUP)
Ideal untuk 5 - 8 Perangkat (Streaming 4K Lancar)
Router Wi-Fi 5 Gigabit Dual Band
Gratis Biaya Pemasangan & Kabel Dropcore
Prioritas Penanganan Gangguan Cepat', 'Terpopuler', '1', 'Halo Ring Network, saya tertarik untuk berlangganan Paket Ring Home Family 75 Mbps seharga Rp 175.000/bulan.', '2', '1', '2026-11-18 07:11:53');
INSERT INTO `internet_packages` (`id`, `category`, `name`, `speed`, `fup`, `price`, `billing_cycle`, `features`, `badge`, `is_popular`, `whatsapp_text`, `sort_order`, `is_active`, `created_at`) VALUES ('10', 'home', 'Ring Home Ultra', '100 Mbps', 'Unlimited (Tanpa Batas FUP)', '200.000', '/bulan', 'Kecepatan Up to 100 Mbps Real-Speed
Unlimited Kuota (100% Bebas FUP)
Ideal untuk 8 - 15 Perangkat & Smart Home
Router Wi-Fi 6 Next-Gen Super Kencang
Ultra Low Ping untuk Gaming Online Tanpa Lag
Gratis Konsultasi & Pengaturan Jaringan', 'Super Cepat', '0', 'Halo Ring Network, saya tertarik untuk berlangganan Paket Ring Home Ultra 100 Mbps seharga Rp 200.000/bulan.', '3', '1', '2026-11-18 07:11:53');
INSERT INTO `internet_packages` (`id`, `category`, `name`, `speed`, `fup`, `price`, `billing_cycle`, `features`, `badge`, `is_popular`, `whatsapp_text`, `sort_order`, `is_active`, `created_at`) VALUES ('11', 'home', 'Ring Home Sultan', '200 Mbps', 'Unlimited (Tanpa Batas FUP)', '325.000', '/bulan', 'Kecepatan Up to 200 Mbps Real-Speed Ekstrem
Unlimited Kuota (100% Bebas FUP)
Ideal untuk Multi-Perangkat, Kantor Rumahan & Studio
Router Wi-Fi 6 High Performance Long Range
Prioritas Traffic Bandwidth Tertinggi (VIP QoS)
Layanan Khusus Fast-Response Teknisi Siaga', 'Sultan Priority', '0', 'Halo Ring Network, saya tertarik untuk berlangganan Paket Ring Home Sultan 200 Mbps seharga Rp 325.000/bulan.', '4', '1', '2026-11-18 07:11:53');

-- Data for table `coverage_areas`
INSERT INTO `coverage_areas` (`id`, `area_name`, `subdistrict`, `city`, `odp_code`, `status`, `notes`, `sort_order`, `is_active`, `created_at`) VALUES ('1', 'Pedukuhan 7, Dusun VII Cerme', 'Kec. Panjatan', 'Kulon Progo', 'ODP-CRM-01', 'Tersedia', 'Area Kantor POP Ring Network. Jaringan Fiber Optic 100% Ready, instalasi same-day.', '1', '1', '2026-11-18 07:28:05');
INSERT INTO `coverage_areas` (`id`, `area_name`, `subdistrict`, `city`, `odp_code`, `status`, `notes`, `sort_order`, `is_active`, `created_at`) VALUES ('2', 'Desa Cerme', 'Kec. Panjatan', 'Kulon Progo', 'ODP-CRM-02', 'Tersedia', 'Tiang ODP aktif terdistribusi di RT 01 - RT 30. Port ODP 16 core siap pakai.', '2', '1', '2026-11-18 07:28:05');
INSERT INTO `coverage_areas` (`id`, `area_name`, `subdistrict`, `city`, `odp_code`, `status`, `notes`, `sort_order`, `is_active`, `created_at`) VALUES ('3', 'Panjatan Kota', 'Kec. Panjatan', 'Kulon Progo', 'ODP-PJT-01', 'Tersedia', 'Cakupan area jalur utama Panjatan dan pemukiman sekitar.', '3', '1', '2026-11-18 07:28:05');
INSERT INTO `coverage_areas` (`id`, `area_name`, `subdistrict`, `city`, `odp_code`, `status`, `notes`, `sort_order`, `is_active`, `created_at`) VALUES ('4', 'Wates Kota & Sekitarnya', 'Kec. Wates', 'Kulon Progo', 'ODP-WTS-01', 'Tersedia', 'Area pusat kota Wates, komplek perumahan & perkantoran.', '4', '1', '2026-11-18 07:28:05');
INSERT INTO `coverage_areas` (`id`, `area_name`, `subdistrict`, `city`, `odp_code`, `status`, `notes`, `sort_order`, `is_active`, `created_at`) VALUES ('5', 'Pengasih', 'Kec. Pengasih', 'Kulon Progo', 'ODP-PGS-01', 'Tersedia', 'Area perumahan & pusat kecamatan Pengasih tercover fiber optic.', '5', '1', '2026-11-18 07:28:06');
INSERT INTO `coverage_areas` (`id`, `area_name`, `subdistrict`, `city`, `odp_code`, `status`, `notes`, `sort_order`, `is_active`, `created_at`) VALUES ('6', 'Sentolo', 'Kec. Sentolo', 'Kulon Progo', 'ODP-SNT-01', 'Perluasan', 'Tahap penarikan kabel feeder FO baru, pre-order dibuka.', '6', '1', '2026-11-18 07:28:06');
INSERT INTO `coverage_areas` (`id`, `area_name`, `subdistrict`, `city`, `odp_code`, `status`, `notes`, `sort_order`, `is_active`, `created_at`) VALUES ('7', 'Lendah', 'Kec. Lendah', 'Kulon Progo', 'ODP-LND-01', 'Perluasan', 'Pemasangan tiang ODP dalam proses perluasan jaringan.', '7', '1', '2026-11-18 07:28:06');
INSERT INTO `coverage_areas` (`id`, `area_name`, `subdistrict`, `city`, `odp_code`, `status`, `notes`, `sort_order`, `is_active`, `created_at`) VALUES ('8', 'Temon (Kawasan YIA)', 'Kec. Temon', 'Kulon Progo', 'ODP-TMN-01', 'Tersedia', 'Mendukung internet residensial dan dedicated korporasi dekat bandara.', '8', '1', '2026-11-18 07:28:06');

