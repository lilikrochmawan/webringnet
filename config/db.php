<?php
/**
 * Database Connection & Auto-Migration
 * Ring Network Website & Admin Panel
 */

$dbType = 'sqlite'; // 'sqlite' or 'mysql'

// SQLite Database Path
$sqliteFile = __DIR__ . '/../data/ringnet.sqlite';

// MySQL Configuration (if switched to mysql)
$mysqlHost = '127.0.0.1';
$mysqlPort = '3306';
$mysqlDb   = 'ringnet_db';
$mysqlUser = 'root';
$mysqlPass = '';

try {
    if ($dbType === 'sqlite') {
        $dataDir = dirname($sqliteFile);
        if (!is_dir($dataDir)) {
            mkdir($dataDir, 0777, true);
        }
        $isNewDb = !file_exists($sqliteFile);
        $pdo = new PDO("sqlite:" . $sqliteFile);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // Auto initialize tables if newly created or checking schema
        initDatabaseTables($pdo, 'sqlite');
    } else {
        $pdo = new PDO("mysql:host={$mysqlHost};port={$mysqlPort};dbname={$mysqlDb};charset=utf8mb4", $mysqlUser, $mysqlPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        initDatabaseTables($pdo, 'mysql');
    }
} catch (PDOException $e) {
    die("<div style='font-family:sans-serif;padding:20px;background:#fee2e2;color:#b91c1c;border-radius:8px;'>
        <h3>Koneksi Database Gagal</h3>
        <p>" . htmlspecialchars($e->getMessage()) . "</p>
    </div>");
}

/**
 * Creates tables and default seeds if they don't exist
 */
function initDatabaseTables(PDO $pdo, string $driver = 'sqlite') {
    // 1. Users table
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE NOT NULL,
        password TEXT NOT NULL,
        name TEXT NOT NULL,
        email TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // 2. Settings table
    $pdo->exec("CREATE TABLE IF NOT EXISTS settings (
        key TEXT PRIMARY KEY,
        value TEXT
    )");

    // 3. Navbar menus table (For dynamic taskbar & dropdown)
    $pdo->exec("CREATE TABLE IF NOT EXISTS navbar_menus (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        parent_id INTEGER DEFAULT 0,
        title TEXT NOT NULL,
        url TEXT NOT NULL,
        icon TEXT DEFAULT 'fa-solid fa-link',
        description TEXT DEFAULT '',
        badge TEXT DEFAULT '',
        sort_order INTEGER DEFAULT 0,
        is_active INTEGER DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // 4. Services table (Penjualan Internet, Jaringan, CCTV, Server, etc.)
    $pdo->exec("CREATE TABLE IF NOT EXISTS services (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        slug TEXT UNIQUE NOT NULL,
        category TEXT DEFAULT 'general',
        icon TEXT DEFAULT 'fa-solid fa-cube',
        short_desc TEXT,
        full_desc TEXT,
        features TEXT,
        image TEXT,
        badge TEXT,
        show_in_navbar INTEGER DEFAULT 1,
        sort_order INTEGER DEFAULT 0,
        is_active INTEGER DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // 5. Internet Packages table (Home & Residential with speed & FUP definition)
    $pdo->exec("CREATE TABLE IF NOT EXISTS internet_packages (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        category TEXT NOT NULL, -- 'home' or 'residential'
        name TEXT NOT NULL,
        speed TEXT NOT NULL,     -- e.g. '50 Mbps'
        fup TEXT NOT NULL,       -- e.g. 'Unlimited (Tanpa FUP)' or '1000 GB'
        price TEXT NOT NULL,     -- e.g. '325.000'
        billing_cycle TEXT DEFAULT '/bulan',
        features TEXT,          -- JSON or newline separated
        badge TEXT,             -- e.g. 'Paling Populer', 'Best Value'
        is_popular INTEGER DEFAULT 0,
        whatsapp_text TEXT,
        sort_order INTEGER DEFAULT 0,
        is_active INTEGER DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // 6. Inquiries / Order leads
    $pdo->exec("CREATE TABLE IF NOT EXISTS inquiries (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        phone TEXT NOT NULL,
        email TEXT,
        package_or_service TEXT,
        address TEXT,
        message TEXT,
        status TEXT DEFAULT 'Baru', -- 'Baru', 'Dihubungi', 'Survey', 'Selesai'
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // 7. Coverage Areas table (For Cek Ketersediaan Jaringan)
    $pdo->exec("CREATE TABLE IF NOT EXISTS coverage_areas (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        area_name TEXT NOT NULL,
        subdistrict TEXT,
        city TEXT DEFAULT 'Kulon Progo',
        odp_code TEXT,
        status TEXT DEFAULT 'Tersedia', -- 'Tersedia', 'Perluasan', 'Penuh'
        notes TEXT,
        sort_order INTEGER DEFAULT 0,
        is_active INTEGER DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Seed default admin user if not exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = 'admin'");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $defaultPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $insertUser = $pdo->prepare("INSERT INTO users (username, password, name, email) VALUES (?, ?, ?, ?)");
        $insertUser->execute(['admin', $defaultPassword, 'Administrator RingNet', 'admin@ringnetwork.co.id']);
    }

    // Seed default settings
    $defaultSettings = [
        'company_name' => 'Ring Network',
        'company_legal' => 'Ring Network',
        'tagline' => 'Connect • Secure • Empower',
        'phone' => '+62 812-2934-2503',
        'whatsapp' => '6281229342503',
        'email' => 'sales@ringnetwork.co.id',
        'support_email' => 'support@ringnetwork.co.id',
        'address' => 'Kantor POP Ring Network: Pedukuhan 7, RT.26/RW.13, Dusun VII, Cerme, Kec. Panjatan, Kabupaten Kulon Progo, Daerah Istimewa Yogyakarta 55655',
        'city' => 'Kulon Progo, D.I. Yogyakarta',
        'operational_hours' => 'Senin - Minggu: 24 Jam Non-Stop (NOC & Helpdesk)',
        'hero_title' => 'Konektivitas Internet Cepat, Stabil & Solusi IT Terintegrasi',
        'hero_subtitle' => 'Ring Network menghadirkan jaringan internet fiber optic berkecepatan tinggi tanpa hambatan, instalasi jaringan profesional, proteksi CCTV modern berbasis AI, hingga setup server handal untuk rumah, residensial, dan bisnis Anda.',
        'speed_guarantee' => '99.9% Uptime Guarantee',
        'gmaps_url' => 'https://maps.google.com'
    ];

    foreach ($defaultSettings as $k => $v) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM settings WHERE key = ?");
        $stmt->execute([$k]);
        if ($stmt->fetchColumn() == 0) {
            $ins = $pdo->prepare("INSERT INTO settings (key, value) VALUES (?, ?)");
            $ins->execute([$k, $v]);
        }
    }

    // Seed default services
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM services");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $services = [
            [
                'Penjualan Internet Fiber',
                'penjualan-internet',
                'internet',
                'fa-solid fa-wifi',
                'Koneksi internet broadband dan dedicated berkecepatan tinggi dengan latensi ultra rendah untuk rumah, residensial, dan korporasi.',
                'Layanan internet fiber optic Ring Network menawarkan kecepatan simetris unduh dan unggah tanpa lag. Dilengkapi dukungan SLA hingga 99.9% dan proteksi rute ganda untuk menjamin kelancaran aktivitas online, streaming 4K, video conference, dan gaming kompetitif.',
                "Kecepatan Simetris 1:1 Download & Upload\nInfrastruktur 100% Fiber Optic Full Duplex\nTanpa Batasan FUP / FUP Fleksibel Sesuai Kebutuhan\nGratis Sewa Router Dual-Band Wi-Fi 6\nMonitoring NOC 24/7 Realtime",
                'service_internet.jpg',
                'Unggulan',
                1,
                1
            ],
            [
                'Pemasangan Jaringan Internet',
                'pemasangan-jaringan',
                'networking',
                'fa-solid fa-network-wired',
                'Instalasi kabel fiber optic, penarikan kabel LAN UTP/STP, wireless PtP, hingga manajemen router Mikrotik & switch manageable.',
                'Kami melayani jasa penataan dan pemasangan infrastruktur jaringan skala kecil hingga enterprise. Mulai dari penarikan kabel terstruktur (structured cabling), instalasi ODP/closure fiber optic, splicing fusion, konfigurasi hotspot manajemen voucher, hingga instalasi mesh Wi-Fi untuk gedung perkantoran, perumahan, pabrik, dan hotel.',
                "Splicing Fiber Optic & Penarikan Kabel FO/LAN\nSetting Routerboard Mikrotik, Cisco & Fortinet\nInstalasi Access Point Enterprise & UniFi Mesh\nPerapian Rack Server & Dokumentasi Wiring Jaringan\nAudit Sinyal Wi-Fi & Troubleshooting Latensi",
                'service_network.jpg',
                'Profesional',
                1,
                2
            ],
            [
                'Pemasangan CCTV & Smart AI',
                'pemasangan-cctv',
                'security',
                'fa-solid fa-video',
                'Sistem kamera pengawas IP Cam & Analog beresolusi tinggi, fitur ColorVu malam berwarna, dan pantauan real-time via smartphone.',
                'Amankan properti, hunian perumahan, gudang, maupun perkantoran Anda dengan sistem CCTV cerdas dari Ring Network. Didukung fitur AI deteksi wajah, perimeter alert, integrasi NVR dengan kapasitas penyimpanan besar, serta akses live view kapan saja dan di mana saja melalui aplikasi HP.',
                "Kamera Resolusi 4K Ultra HD & ColorVu (Malam Tetap Berwarna)\nDeteksi Gerak Berbasis AI & Notifikasi Instan ke HP\nPemasangan Rapi Menggunakan Pipa Conduit / Tray\nSetup NVR / DVR & Harddisk Khusus Surveillance\nGaransi Resmi Perangkat & Purnajual Terjamin",
                'service_cctv.jpg',
                'Populer',
                1,
                3
            ],
            [
                'Setup & Maintenance Server',
                'setup-server',
                'server',
                'fa-solid fa-server',
                'Instalasi server on-premise, virtualisasi Proxmox/VMware, konfigurasi file sharing, active directory, backup otomatis, dan monitoring server.',
                'Pastikan ekosistem data perusahaan Anda aman dan selalu online. Tim kami berpengalaman dalam merakit rak server, instalasi OS Linux/Windows Server, setting NAS Storage backup otomatis, firewall hardware, sistem disaster recovery, serta penyediaan UPS daya cadangan berstandar data center.',
                "Instalasi Rackmount Server & Cable Management Rapi\nVirtualisasi Virtual Server (Proxmox VE / VMware ESXi)\nFile Server, Active Directory Domain & VPN Antar Cabang\nAutomated Backup System & Disaster Recovery Plan\nMaintenance Rutin & Kontrak Perawatan Berkala",
                'service_server.jpg',
                'Enterprise',
                1,
                4
            ]
        ];

        $insService = $pdo->prepare("INSERT INTO services (title, slug, category, icon, short_desc, full_desc, features, image, badge, show_in_navbar, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($services as $srv) {
            $insService->execute($srv);
        }
    }

    // Seed default navbar menus
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM navbar_menus");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        // Dropdown Items under "Layanan"
        $menus = [
            ['parent_id' => 1, 'title' => 'Penjualan Internet Fiber', 'url' => '#paket-internet', 'icon' => 'fa-solid fa-wifi', 'description' => 'Paket internet ultra cepat untuk Home & Residensial', 'badge' => 'Populer', 'sort_order' => 1],
            ['parent_id' => 1, 'title' => 'Pemasangan Jaringan & FO', 'url' => '#layanan', 'icon' => 'fa-solid fa-network-wired', 'description' => 'Jasa instalasi LAN, Splicing FO & Wi-Fi Mesh', 'badge' => 'Pro', 'sort_order' => 2],
            ['parent_id' => 1, 'title' => 'Pemasangan CCTV Smart AI', 'url' => '#cctv', 'icon' => 'fa-solid fa-video', 'description' => 'Keamanan visual 24/7 jernih dengan kontrol HP', 'badge' => 'Promo', 'sort_order' => 3],
            ['parent_id' => 1, 'title' => 'Setup & Maintenance Server', 'url' => '#server', 'icon' => 'fa-solid fa-server', 'description' => 'Server rack, virtualisasi & backup data center', 'badge' => 'Enterprise', 'sort_order' => 4],
        ];

        $insMenu = $pdo->prepare("INSERT INTO navbar_menus (parent_id, title, url, icon, description, badge, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
        foreach ($menus as $m) {
            $insMenu->execute([$m['parent_id'], $m['title'], $m['url'], $m['icon'], $m['description'], $m['badge'], $m['sort_order']]);
        }
    }

    // Seed default internet packages (Home & Residential)
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM internet_packages");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $packages = [
            // HOME PACKAGES
            [
                'home',
                'Ring Home Starter',
                '50 Mbps',
                'Unlimited (Tanpa Batas FUP)',
                '150.000',
                '/bulan',
                "Kecepatan Up to 50 Mbps Simetris\nUnlimited Kuota (100% Bebas FUP)\nIdeal untuk 3 - 5 Perangkat Sekaligus\nGratis Modem Router Wi-Fi Dual Band\nGratis Biaya Pemasangan Pertama\nSupport NOC & Teknisi 24 Jam",
                'Ekonomis',
                0,
                'Halo Ring Network, saya tertarik untuk berlangganan Paket Ring Home Starter 50 Mbps seharga Rp 150.000/bulan.',
                1
            ],
            [
                'home',
                'Ring Home Family',
                '75 Mbps',
                'Unlimited (Tanpa Batas FUP)',
                '175.000',
                '/bulan',
                "Kecepatan Up to 75 Mbps Simetris\nUnlimited Kuota (100% Bebas FUP)\nIdeal untuk 5 - 8 Perangkat (Streaming 4K Lancar)\nRouter Wi-Fi 5 Gigabit Dual Band\nGratis Biaya Pemasangan & Kabel Dropcore\nPrioritas Penanganan Gangguan Cepat",
                'Terpopuler',
                1,
                'Halo Ring Network, saya tertarik untuk berlangganan Paket Ring Home Family 75 Mbps seharga Rp 175.000/bulan.',
                2
            ],
            [
                'home',
                'Ring Home Ultra',
                '100 Mbps',
                'Unlimited (Tanpa Batas FUP)',
                '200.000',
                '/bulan',
                "Kecepatan Up to 100 Mbps Real-Speed\nUnlimited Kuota (100% Bebas FUP)\nIdeal untuk 8 - 15 Perangkat & Smart Home\nRouter Wi-Fi 6 Next-Gen Super Kencang\nUltra Low Ping untuk Gaming Online Tanpa Lag\nGratis Konsultasi & Pengaturan Jaringan",
                'Super Cepat',
                0,
                'Halo Ring Network, saya tertarik untuk berlangganan Paket Ring Home Ultra 100 Mbps seharga Rp 200.000/bulan.',
                3
            ],
            [
                'home',
                'Ring Home Sultan',
                '200 Mbps',
                'Unlimited (Tanpa Batas FUP)',
                '325.000',
                '/bulan',
                "Kecepatan Up to 200 Mbps Real-Speed Ekstrem\nUnlimited Kuota (100% Bebas FUP)\nIdeal untuk Multi-Perangkat, Kantor Rumahan & Studio\nRouter Wi-Fi 6 High Performance Long Range\nPrioritas Traffic Bandwidth Tertinggi (VIP QoS)\nLayanan Khusus Fast-Response Teknisi Siaga",
                'Sultan Priority',
                0,
                'Halo Ring Network, saya tertarik untuk berlangganan Paket Ring Home Sultan 200 Mbps seharga Rp 325.000/bulan.',
                4
            ],

            // RESIDENTIAL PACKAGES (Untuk Cluster, Villa, Perumahan Elit, Kontrakan/Kost Mewah)
            [
                'residential',
                'Ring Resident Silver',
                '50 Mbps',
                'Tanpa FUP (Dedicated 1:1)',
                '500.000',
                '/bulan',
                "Kecepatan Simetris 50 Mbps Dedicated 1:1\n100% Tanpa FUP & Bandwidth Murni\nIdeal untuk Cluster Hunian & Rumah Bertingkat\nRouter Wi-Fi 6 High Power Long Range\nSLA Uptime 99.5% Dijamin Kontrak\nLayanan Kunjungan Teknisi Prioritas Khusus",
                'Best Choice',
                0,
                'Halo Ring Network, saya ingin menanyakan pemasangan Paket Ring Resident Silver 50 Mbps seharga Rp 500.000/bulan untuk area perumahan saya.',
                1
            ],
            [
                'residential',
                'Ring Resident Gold',
                '100 Mbps',
                'Tanpa FUP (Dedicated 1:1)',
                '1.000.000',
                '/bulan',
                "Kecepatan Simetris 100 Mbps Dedicated 1:1\n100% Tanpa FUP / Uncapped Bandwidth\nTermasuk 1 Unit Router Wi-Fi 6 + 1 Mesh Extender\nGratis 1 Titik Akses Tambahan Lantai 2\nSLA Uptime 99.8% dengan Backup Link Redundan\nDukungan Personal Account Manager & NOC 24 Jam",
                'Paling Laris',
                1,
                'Halo Ring Network, saya ingin memesan Paket Ring Resident Gold 100 Mbps seharga Rp 1.000.000/bulan untuk tempat tinggal saya.',
                2
            ],
            [
                'residential',
                'Ring Resident Platinum',
                '200 Mbps',
                'Tanpa FUP (Dedicated 1:1)',
                '2.000.000',
                '/bulan',
                "Kecepatan Simetris 200 Mbps Dedicated 1:1\n100% Bebas FUP Sepuasnya\nPilihan Gratis IP Publik Statis (/32) untuk Server / CCTV\nPaket Termasuk Router Enterprise & 2 Mesh Wi-Fi 6\nSLA Uptime 99.9% Super Reliable\nPrioritas Penanganan Maksimal 2 Jam On-Site",
                'Ultra Premium',
                0,
                'Halo Ring Network, saya ingin berkonsultasi mengenai Paket Ring Resident Platinum 200 Mbps seharga Rp 2.000.000/bulan.',
                3
            ],
            [
                'residential',
                'Ring Resident Fiber Max',
                '300 Mbps',
                'Tanpa FUP (Dedicated 1:1)',
                '3.000.000',
                '/bulan',
                "Kecepatan Simetris 300 Mbps Dedicated 1:1 Ekstrem\n100% Tanpa Batasan Kuota / FUP Apapun\nFree IP Publik Statis Resmi\nInfrastruktur Fiber Optic Langsung dari Core Distribution\nUltra Low Latency ke Server Internasional & Lokal\nLayanan VIP Dedicated 24/7 Direct Line",
                'Maximum Speed',
                0,
                'Halo Ring Network, saya berminat dengan Paket Ring Resident Fiber Max 300 Mbps seharga Rp 3.000.000/bulan.',
                4
            ]
        ];

        $insPkg = $pdo->prepare("INSERT INTO internet_packages (category, name, speed, fup, price, billing_cycle, features, badge, is_popular, whatsapp_text, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($packages as $p) {
            $insPkg->execute($p);
        }
    }
}
