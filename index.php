<?php
require_once __DIR__ . '/config/helper.php';

$homePackages = getInternetPackages('home');
$residentialPackages = getInternetPackages('residential');
$services = getActiveServices();

include __DIR__ . '/includes/header.php';
?>

<!-- 1. HERO SECTION (High-Tech Modern Glass & Cyber Glow) -->
<section id="hero" class="relative bg-gradient-hero text-white overflow-hidden py-20 lg:py-28 min-h-[90vh] flex items-center">
    
    <!-- Ambient Cyber Glows -->
    <div class="bg-hero-glow top-0 right-0 opacity-70"></div>
    <div class="bg-hero-glow -bottom-32 -left-32 opacity-50" style="background: radial-gradient(circle, rgba(255, 107, 0, 0.25) 0%, rgba(251, 191, 36, 0.15) 50%, transparent 70%);"></div>

    <!-- Tech Grid Background -->
    <div class="absolute inset-0 bg-grid-pattern-dark pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
            
            <!-- Left Hero Content (7 Cols) -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                
                <!-- Tagline Badge -->
                <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-slate-800/80 border border-sky-500/30 text-sky-300 text-xs sm:text-sm font-semibold backdrop-blur-md shadow-lg shadow-sky-950/50">
                    <span class="w-2.5 h-2.5 rounded-full bg-ringOrange-500 animate-pulse"></span>
                    <span>Ring Network • Connect • Secure • Empower</span>
                    <span class="bg-ringYellow-400 text-slate-950 text-[10px] font-extrabold px-2 py-0.5 rounded-full uppercase tracking-wider">Fiber Optic</span>
                </div>

                <!-- Main Hero Headline -->
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold font-display leading-[1.15] tracking-tight">
                    Solusi Internet <span class="bg-gradient-to-r from-sky-400 via-ringOrange-400 to-ringYellow-400 bg-clip-text text-transparent">Ultra Cepat, Stabil</span> & IT Terpadu
                </h1>

                <!-- Subtitle -->
                <p class="text-base sm:text-lg text-slate-300 max-w-2xl mx-auto lg:mx-0 font-normal leading-relaxed">
                    Ring Network menyediakan layanan <strong class="text-white">Penjualan Internet Fiber 100% Bebas FUP</strong> untuk Home & Residensial, instalasi jaringan profesional, proteksi cerdas <strong class="text-white">CCTV berbasis AI</strong>, hingga <strong class="text-white">setup & virtualisasi server</strong> data center.
                </p>

                <!-- Value Highlights Pills -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-3 pt-1">
                    <span class="inline-flex items-center gap-1.5 text-xs text-slate-200 bg-slate-800/60 border border-slate-700/60 px-3 py-1.5 rounded-xl">
                        <i class="fa-solid fa-gauge-high text-sky-400"></i> Simetris 1:1 Download & Upload
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-xs text-slate-200 bg-slate-800/60 border border-slate-700/60 px-3 py-1.5 rounded-xl">
                        <i class="fa-solid fa-infinity text-ringOrange-400"></i> 100% Tanpa Batasan FUP
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-xs text-slate-200 bg-slate-800/60 border border-slate-700/60 px-3 py-1.5 rounded-xl">
                        <i class="fa-solid fa-shield-halved text-ringYellow-400"></i> SLA 99.9% Uptime
                    </span>
                </div>

                <!-- Hero CTA Buttons -->
                <div class="pt-4 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    <a href="#paket-internet" class="w-full sm:w-auto btn-rn-primary text-base py-3.5 px-8 shadow-xl shadow-orange-600/30">
                        <i class="fa-solid fa-wifi text-sm"></i>
                        <span>Lihat Paket Internet</span>
                    </a>
                    
                    <button onclick="window.openCoverageModal();" class="w-full sm:w-auto btn-rn-outline text-base py-3.5 px-7">
                        <i class="fa-solid fa-map-location-dot"></i>
                        <span>Cek Area Jangkauan</span>
                    </button>

                    <a href="<?= e(getWaLink('Halo Ring Network, saya ingin tanya penawaran dan jadwal survey.')) ?>" target="_blank" class="text-xs font-semibold text-slate-300 hover:text-white flex items-center gap-1.5 transition py-2">
                        <i class="fa-brands fa-whatsapp text-emerald-400 text-base"></i> Hubungi Sales
                    </a>
                </div>

                <!-- Trust Micro-Proof -->
                <div class="pt-6 border-t border-slate-800/80 flex items-center justify-center lg:justify-start gap-8 text-xs text-slate-400">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-400"></i>
                        <span>Gratis Router Wi-Fi 6</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-400"></i>
                        <span>Pemasangan Cepat 1 Hari</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-400"></i>
                        <span>Support NOC 24/7</span>
                    </div>
                </div>

            </div>

            <!-- Right Hero Card / Live Network Simulation (5 Cols) -->
            <div class="lg:col-span-5 relative">
                <div class="relative glass-card-dark rounded-3xl p-6 sm:p-7 border border-sky-500/30 shadow-2xl overflow-hidden animate-float">
                    
                    <!-- Glow Accents Inside Card -->
                    <div class="absolute -top-16 -right-16 w-44 h-44 bg-sky-500/20 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="absolute -bottom-16 -left-16 w-44 h-44 bg-ringOrange-500/20 rounded-full blur-2xl pointer-events-none"></div>

                    <!-- Card Header -->
                    <div class="flex items-center justify-between pb-5 border-b border-slate-700/60 relative z-10">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-sky-500 to-sky-400 flex items-center justify-center text-white shadow-lg shadow-sky-500/30">
                                <i class="fa-solid fa-server text-base"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-white tracking-wide">Ring Core Backbone</h3>
                                <p class="text-[11px] text-sky-300 font-mono flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                                    100% ONLINE • NOC Jakarta
                                </p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-ringYellow-400/20 text-ringYellow-300 border border-ringYellow-400/30">
                            FIBER 10G
                        </span>
                    </div>

                    <!-- Live Metrics Display -->
                    <div class="grid grid-cols-2 gap-3.5 my-5 relative z-10 font-mono">
                        <div class="bg-slate-900/80 p-3.5 rounded-2xl border border-slate-800">
                            <span class="text-[10px] text-slate-400 uppercase tracking-wider block font-sans">Ping Latency</span>
                            <div class="text-xl font-extrabold text-sky-400 flex items-baseline gap-1 mt-0.5">
                                <span>3.2</span> <span class="text-xs text-slate-400 font-sans">ms</span>
                            </div>
                            <span class="text-[10px] text-emerald-400 flex items-center gap-1 mt-1 font-sans">
                                <i class="fa-solid fa-arrow-trend-down"></i> Ultra Rendah
                            </span>
                        </div>

                        <div class="bg-slate-900/80 p-3.5 rounded-2xl border border-slate-800">
                            <span class="text-[10px] text-slate-400 uppercase tracking-wider block font-sans">SLA Uptime</span>
                            <div class="text-xl font-extrabold text-ringYellow-400 flex items-baseline gap-1 mt-0.5">
                                <span>99.98</span> <span class="text-xs text-slate-400 font-sans">%</span>
                            </div>
                            <span class="text-[10px] text-emerald-400 flex items-center gap-1 mt-1 font-sans">
                                <i class="fa-solid fa-shield-check"></i> Redundant Core
                            </span>
                        </div>

                        <div class="bg-slate-900/80 p-3.5 rounded-2xl border border-slate-800">
                            <span class="text-[10px] text-slate-400 uppercase tracking-wider block font-sans">Download Speed</span>
                            <div class="text-xl font-extrabold text-white flex items-baseline gap-1 mt-0.5">
                                <span>300</span> <span class="text-xs text-ringOrange-400 font-sans">Mbps</span>
                            </div>
                            <span class="text-[10px] text-sky-300 font-sans">100% Tanpa FUP</span>
                        </div>

                        <div class="bg-slate-900/80 p-3.5 rounded-2xl border border-slate-800">
                            <span class="text-[10px] text-slate-400 uppercase tracking-wider block font-sans">Upload Speed</span>
                            <div class="text-xl font-extrabold text-white flex items-baseline gap-1 mt-0.5">
                                <span>300</span> <span class="text-xs text-ringOrange-400 font-sans">Mbps</span>
                            </div>
                            <span class="text-[10px] text-sky-300 font-sans">Simetris 1:1</span>
                        </div>
                    </div>

                    <!-- Integrated Services Ticker inside card -->
                    <div class="pt-4 border-t border-slate-700/60 relative z-10 space-y-2">
                        <div class="text-[11px] uppercase tracking-wider text-slate-400 font-bold">Layanan Terpasang:</div>
                        <div class="flex flex-wrap gap-2 text-xs">
                            <span class="px-2.5 py-1 rounded-xl bg-sky-500/20 text-sky-200 border border-sky-500/30">
                                <i class="fa-solid fa-wifi text-sky-400 mr-1"></i> Fiber Internet
                            </span>
                            <span class="px-2.5 py-1 rounded-xl bg-orange-500/20 text-orange-200 border border-orange-500/30">
                                <i class="fa-solid fa-video text-orange-400 mr-1"></i> CCTV 4K AI
                            </span>
                            <span class="px-2.5 py-1 rounded-xl bg-yellow-500/20 text-yellow-200 border border-yellow-500/30">
                                <i class="fa-solid fa-server text-yellow-400 mr-1"></i> Proxmox Server
                            </span>
                            <span class="px-2.5 py-1 rounded-xl bg-emerald-500/20 text-emerald-200 border border-emerald-500/30">
                                <i class="fa-solid fa-network-wired text-emerald-400 mr-1"></i> FO Splicing
                            </span>
                        </div>
                    </div>

                    <!-- Quick Action inside Card -->
                    <div class="mt-5 relative z-10">
                        <button onclick="window.openOrderModal('Pemasangan Cepat Fiber', '100 Mbps', 'Unlimited', '485.000')" class="w-full py-3 rounded-2xl bg-gradient-to-r from-sky-500 via-ringOrange-500 to-ringYellow-400 text-white font-bold text-xs uppercase tracking-wider hover:opacity-95 transition shadow-lg flex items-center justify-center gap-2">
                            <i class="fa-solid fa-bolt"></i> Pasang Jaringan Cepat Sekarang
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- 2. VALUE PROPOSITION BAR (4 Key Pillars) -->
<section class="py-10 bg-white border-b border-sky-100 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="flex items-start gap-4 p-4 rounded-2xl bg-sky-50/50 border border-sky-100/60 hover-card-effect">
                <div class="w-12 h-12 rounded-2xl bg-sky-500 text-white flex items-center justify-center text-xl shrink-0 shadow-md shadow-sky-500/30">
                    <i class="fa-solid fa-infinity"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">100% Bebas FUP</h3>
                    <p class="text-xs text-slate-500 mt-1">Tanpa penurunan kecepatan di tengah bulan. Kuota tanpa batas sepuasnya.</p>
                </div>
            </div>

            <div class="flex items-start gap-4 p-4 rounded-2xl bg-orange-50/50 border border-orange-100/60 hover-card-effect">
                <div class="w-12 h-12 rounded-2xl bg-ringOrange-500 text-white flex items-center justify-center text-xl shrink-0 shadow-md shadow-orange-500/30">
                    <i class="fa-solid fa-arrows-up-down"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Kecepatan Simetris 1:1</h3>
                    <p class="text-xs text-slate-500 mt-1">Kecepatan download dan upload seimbang untuk live streaming, gaming, & CCTV.</p>
                </div>
            </div>

            <div class="flex items-start gap-4 p-4 rounded-2xl bg-amber-50/50 border border-amber-100/60 hover-card-effect">
                <div class="w-12 h-12 rounded-2xl bg-ringYellow-500 text-white flex items-center justify-center text-xl shrink-0 shadow-md shadow-amber-500/30">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">NOC & Support 24 Jam</h3>
                    <p class="text-xs text-slate-500 mt-1">Tim teknisi siaga 24/7 dan monitoring jaringan aktif secara real-time.</p>
                </div>
            </div>

            <div class="flex items-start gap-4 p-4 rounded-2xl bg-emerald-50/50 border border-emerald-100/60 hover-card-effect">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-white flex items-center justify-center text-xl shrink-0 shadow-md shadow-emerald-500/30">
                    <i class="fa-solid fa-certificate"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Teknisi Tersertifikasi</h3>
                    <p class="text-xs text-slate-500 mt-1">Pemasangan rapi standar industri, OTDR splicing akurat & kabel terlindungi.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 3. PAKET LAYANAN UTAMA INTERNET: HOME & RESIDENTIAL -->
<!-- Dengan Kecepatan & FUP yang didefinisikan secara transparan -->
<section id="paket-internet" class="py-20 bg-slate-50 relative bg-grid-pattern">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto space-y-4">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-100 text-sky-700 text-xs font-bold tracking-wide uppercase">
                <i class="fa-solid fa-wifi text-ringOrange-500"></i> Paket Internet Utama
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 font-display">
                Pilih Paket Internet <span class="text-sky-600">Home</span> & <span class="text-ringOrange-500">Residential</span>
            </h2>
            <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                Seluruh paket dilengkapi spesifikasi <strong class="text-slate-900">Kecepatan Nyata</strong> dan kebijakan <strong class="text-slate-900">FUP Transparan</strong>. Tanpa biaya tersembunyi, siap memanjakan aktivitas digital tanpa kompromi.
            </p>

            <!-- Interactive Tab Switcher -->
            <div class="pt-6 flex justify-center">
                <div class="inline-flex p-1.5 rounded-2xl bg-white border border-sky-100 shadow-lg shadow-sky-100/50">
                    <button id="tab-home-btn" class="tab-btn active px-6 py-2.5 rounded-xl font-bold text-xs sm:text-sm text-slate-600 transition flex items-center gap-2">
                        <i class="fa-solid fa-house"></i>
                        <span>Paket Internet HOME</span>
                        <span class="text-[10px] bg-sky-100 text-sky-700 font-extrabold px-1.5 py-0.5 rounded">Rumah</span>
                    </button>
                    <button id="tab-resident-btn" class="tab-btn px-6 py-2.5 rounded-xl font-bold text-xs sm:text-sm text-slate-600 transition flex items-center gap-2">
                        <i class="fa-solid fa-building-user"></i>
                        <span>Paket RESIDENTIAL</span>
                        <span class="text-[10px] bg-ringOrange-100 text-ringOrange-700 font-extrabold px-1.5 py-0.5 rounded">Dedicated 1:1</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- 3A. HOME PACKAGES CONTAINER -->
        <div id="content-packages-home" class="mt-14">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">
                <?php if (!empty($homePackages)): ?>
                    <?php foreach ($homePackages as $pkg): ?>
                        <div class="relative rounded-3xl bg-white p-6 sm:p-7 flex flex-col justify-between transition-all duration-300 hover-card-effect <?= $pkg['is_popular'] ? 'popular-glow ring-2 ring-ringOrange-500' : 'border border-sky-100 shadow-xl shadow-sky-900/5' ?>">
                            
                            <?php if ($pkg['is_popular']): ?>
                                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2">
                                    <span class="popular-badge">
                                        <i class="fa-solid fa-fire mr-1"></i> <?= e($pkg['badge'] ?: 'Paling Populer') ?>
                                    </span>
                                </div>
                            <?php elseif (!empty($pkg['badge'])): ?>
                                <div class="absolute -top-3 left-6">
                                    <span class="text-[10px] font-bold px-3 py-1 rounded-full bg-sky-100 text-sky-800 border border-sky-200">
                                        <?= e($pkg['badge']) ?>
                                    </span>
                                </div>
                            <?php endif; ?>

                            <div>
                                <!-- Package Header -->
                                <div class="pt-2">
                                    <h3 class="text-xl font-extrabold text-slate-900"><?= e($pkg['name']) ?></h3>
                                    <p class="text-xs text-slate-500 mt-1">Kategori: Home Fiber Optic</p>
                                </div>

                                <!-- Speed & FUP Definition Banner -->
                                <div class="my-5 p-4 rounded-2xl bg-gradient-to-r from-sky-50 via-sky-50/50 to-orange-50/40 border border-sky-100">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Kecepatan (Speed):</span>
                                            <div class="text-2xl font-black text-sky-600 font-display flex items-baseline gap-1">
                                                <?= e($pkg['speed']) ?>
                                            </div>
                                        </div>
                                        <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-sky-600">
                                            <i class="fa-solid fa-gauge-high text-lg"></i>
                                        </div>
                                    </div>

                                    <!-- FUP Definition -->
                                    <div class="mt-3 pt-3 border-t border-sky-100/80 flex items-center justify-between text-xs">
                                        <span class="font-medium text-slate-600">Kebijakan FUP:</span>
                                        <span class="font-bold text-emerald-700 bg-emerald-100/80 px-2 py-0.5 rounded-full text-[11px] flex items-center gap-1">
                                            <i class="fa-solid fa-check"></i> <?= e($pkg['fup']) ?>
                                        </span>
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="mb-6">
                                    <span class="text-xs text-slate-400 block font-medium">Biaya Berlangganan:</span>
                                    <div class="flex items-baseline gap-1 text-slate-900">
                                        <span class="text-base font-bold text-ringOrange-500">Rp</span>
                                        <span class="text-3xl sm:text-4xl font-extrabold tracking-tight"><?= e(formatRupiah($pkg['price'])) ?></span>
                                        <span class="text-xs text-slate-500 font-medium"><?= e($pkg['billing_cycle'] ?: '/bulan') ?></span>
                                    </div>
                                </div>

                                <!-- Features list -->
                                <div class="space-y-2.5 mb-8">
                                    <div class="text-xs font-bold text-slate-700 uppercase tracking-wider">Benefit Layanan:</div>
                                    <?php 
                                        $features = explode("\n", $pkg['features'] ?? '');
                                        foreach ($features as $f): 
                                            if (trim($f) === '') continue;
                                    ?>
                                        <div class="flex items-start gap-2.5 text-xs text-slate-600">
                                            <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 shrink-0"></i>
                                            <span><?= e(trim($f)) ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- CTA Buttons -->
                            <div class="space-y-2 pt-2 border-t border-slate-100">
                                <button onclick="window.openOrderModal('<?= e(addslashes($pkg['name'])) ?>', '<?= e(addslashes($pkg['speed'])) ?>', '<?= e(addslashes($pkg['fup'])) ?>', '<?= e(addslashes($pkg['price'])) ?>')" class="w-full <?= $pkg['is_popular'] ? 'btn-rn-primary' : 'btn-rn-secondary' ?> py-3 text-xs uppercase tracking-wider font-bold">
                                    <i class="fa-solid fa-bolt"></i> Pasang Paket Ini
                                </button>
                                <a href="<?= e(getWaLink($pkg['whatsapp_text'] ?: "Halo Ring Network, saya tertarik pasang paket " . $pkg['name'])) ?>" target="_blank" class="w-full text-center py-2 text-xs text-emerald-600 hover:text-emerald-700 font-semibold flex items-center justify-center gap-1.5 transition">
                                    <i class="fa-brands fa-whatsapp text-sm"></i> Tanya via WhatsApp
                                </a>
                            </div>

                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- 3B. RESIDENTIAL PACKAGES CONTAINER (Hidden by default, activated via tab) -->
        <div id="content-packages-resident" class="mt-14 hidden">
            <div class="p-4 mb-8 rounded-2xl bg-gradient-to-r from-orange-50 via-amber-50 to-sky-50 border border-orange-200/80 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-ringOrange-500 text-white flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-city text-base"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-800">Paket Spesial Residential & Komplek Perumahan</h4>
                        <p class="text-xs text-slate-600">Bandwidth Murni Simetris 1:1, Prioritas Latensi Rendah.</p>
                    </div>
                </div>
                <button onclick="window.openOrderModal('Konsultasi Jaringan Residential Cluster', '', 'Dedicated 1:1', '')" class="btn-rn-primary text-xs py-2 px-4 shrink-0 whitespace-nowrap">
                    Konsultasi Area Perumahan
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">
                <?php if (!empty($residentialPackages)): ?>
                    <?php foreach ($residentialPackages as $rpkg): ?>
                        <div class="relative rounded-3xl bg-white p-6 sm:p-7 flex flex-col justify-between transition-all duration-300 hover-card-effect <?= $rpkg['is_popular'] ? 'popular-glow ring-2 ring-ringOrange-500' : 'border border-slate-200 shadow-xl shadow-slate-900/5' ?>">
                            
                            <?php if ($rpkg['is_popular']): ?>
                                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2">
                                    <span class="popular-badge text-[10px]">
                                        <i class="fa-solid fa-star mr-1"></i> <?= e($rpkg['badge'] ?: 'Pilihan Utama') ?>
                                    </span>
                                </div>
                            <?php elseif (!empty($rpkg['badge'])): ?>
                                <div class="absolute -top-3 left-6">
                                    <span class="text-[10px] font-bold px-3 py-1 rounded-full bg-orange-100 text-orange-800 border border-orange-200">
                                        <?= e($rpkg['badge']) ?>
                                    </span>
                                </div>
                            <?php endif; ?>

                            <div>
                                <!-- Header -->
                                <div class="pt-2">
                                    <h3 class="text-lg font-extrabold text-slate-900"><?= e($rpkg['name']) ?></h3>
                                    <p class="text-[11px] text-slate-500 mt-0.5">Dedicated Residential Fiber</p>
                                </div>

                                <!-- Speed & FUP Box -->
                                <div class="my-4 p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Kecepatan Nyata 1:1</span>
                                    <div class="text-xl font-black text-ringOrange-600 font-display">
                                        <?= e($rpkg['speed']) ?>
                                    </div>
                                    <div class="mt-2 pt-2 border-t border-slate-200 flex items-center justify-between text-[11px]">
                                        <span class="text-slate-500">Kebijakan FUP:</span>
                                        <span class="font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                                            <?= e($rpkg['fup']) ?>
                                        </span>
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="mb-5">
                                    <span class="text-[11px] text-slate-400 block font-medium">Biaya Berlangganan:</span>
                                    <div class="flex items-baseline gap-1 text-slate-900">
                                        <span class="text-xs font-bold text-ringOrange-500">Rp</span>
                                        <span class="text-2xl font-extrabold tracking-tight"><?= e(formatRupiah($rpkg['price'])) ?></span>
                                        <span class="text-[10px] text-slate-500"><?= e($rpkg['billing_cycle'] ?: '/bln') ?></span>
                                    </div>
                                </div>

                                <!-- Features list -->
                                <div class="space-y-2 mb-6">
                                    <div class="text-[11px] font-bold text-slate-700 uppercase tracking-wider">Fitur Eksklusif:</div>
                                    <?php 
                                        $rFeatures = explode("\n", $rpkg['features'] ?? '');
                                        foreach ($rFeatures as $rf): 
                                            if (trim($rf) === '') continue;
                                    ?>
                                        <div class="flex items-start gap-2 text-xs text-slate-600">
                                            <i class="fa-solid fa-check text-ringOrange-500 text-[10px] mt-1 shrink-0"></i>
                                            <span><?= e(trim($rf)) ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- CTA Buttons -->
                            <div class="space-y-2 pt-2 border-t border-slate-100">
                                <button onclick="window.openOrderModal('<?= e(addslashes($rpkg['name'])) ?>', '<?= e(addslashes($rpkg['speed'])) ?>', '<?= e(addslashes($rpkg['fup'])) ?>', '<?= e(addslashes($rpkg['price'])) ?>')" class="w-full btn-rn-primary py-2.5 text-xs font-bold uppercase tracking-wider">
                                    Pilih Paket
                                </button>
                                <a href="<?= e(getWaLink($rpkg['whatsapp_text'] ?: "Halo Ring Network, saya tertarik dengan paket " . $rpkg['name'])) ?>" target="_blank" class="w-full text-center py-1.5 text-xs text-slate-500 hover:text-emerald-600 font-semibold flex items-center justify-center gap-1 transition">
                                    <i class="fa-brands fa-whatsapp text-emerald-500"></i> Tanya Paket
                                </a>
                            </div>

                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
</section>

<!-- 4. INTERACTIVE BANDWIDTH & SPEED CALCULATOR -->
<section id="kalkulator" class="py-16 bg-white border-y border-sky-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="rounded-3xl bg-gradient-to-br from-slate-900 via-sky-950 to-slate-900 text-white p-8 sm:p-12 shadow-2xl relative overflow-hidden">
            <!-- Glow background -->
            <div class="absolute top-0 right-0 w-80 h-80 bg-ringOrange-500/15 rounded-full blur-3xl pointer-events-none"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
                
                <!-- Left Controls -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-500/20 text-sky-300 text-xs font-bold">
                        <i class="fa-solid fa-calculator text-ringYellow-400"></i>
                        <span>Smart Speed Estimator</span>
                    </div>

                    <h3 class="text-2xl sm:text-3xl font-extrabold font-display">
                        Bingung Pilih Kecepatan? Hitung Kebutuhan Anda Di Sini
                    </h3>

                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        Sesuaikan jumlah anggota keluarga / perangkat dan aktivitas internet untuk mendapatkan rekomendasi paket kecepatan yang paling pas dan hemat.
                    </p>

                    <!-- Slider: Number of devices -->
                    <div class="space-y-2 pt-2">
                        <div class="flex items-center justify-between text-xs sm:text-sm">
                            <span class="font-bold text-slate-200">Jumlah Perangkat Terhubung:</span>
                            <span id="calc-users-val" class="font-extrabold text-ringYellow-400 bg-slate-800 px-3 py-1 rounded-lg">5 Perangkat</span>
                        </div>
                        <input type="range" id="calc-users" min="1" max="25" value="5" class="w-full h-2.5 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-ringOrange-500">
                        <div class="flex justify-between text-[11px] text-slate-400">
                            <span>1 Device</span>
                            <span>10 Devices</span>
                            <span>25+ Devices</span>
                        </div>
                    </div>

                    <!-- Activity Checkboxes -->
                    <div class="space-y-2.5 pt-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">Aktivitas Utama:</span>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 text-xs">
                            <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-800/80 border border-slate-700 cursor-pointer hover:border-sky-500 transition">
                                <input type="checkbox" id="calc-streaming" checked class="accent-sky-500 rounded">
                                <span>Streaming 4K / Netflix</span>
                            </label>
                            <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-800/80 border border-slate-700 cursor-pointer hover:border-sky-500 transition">
                                <input type="checkbox" id="calc-gaming" checked class="accent-ringOrange-500 rounded">
                                <span>Gaming Online Low Ping</span>
                            </label>
                            <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-800/80 border border-slate-700 cursor-pointer hover:border-sky-500 transition">
                                <input type="checkbox" id="calc-cctv" class="accent-ringYellow-400 rounded">
                                <span>CCTV IP Live Streaming</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Right Recommendation Result Box -->
                <div class="lg:col-span-5 bg-slate-800/90 rounded-2xl p-6 sm:p-7 border border-sky-500/30 text-center space-y-4 shadow-xl">
                    <span class="text-xs uppercase tracking-wider text-slate-400 font-semibold block">Rekomendasi Kecepatan Minimal:</span>
                    
                    <div id="calc-result-speed" class="text-4xl sm:text-5xl font-black text-transparent bg-gradient-to-r from-sky-400 via-ringOrange-400 to-ringYellow-400 bg-clip-text font-display">
                        50 Mbps
                    </div>

                    <div class="p-3 bg-slate-900 rounded-xl border border-slate-700 text-xs">
                        <span class="text-slate-400 block mb-1">Paket yang Disarankan:</span>
                        <strong id="calc-recommend-pkg" class="text-white text-sm font-bold">Ring Home Family (75 Mbps) - Rp 175.000</strong>
                    </div>

                    <p class="text-[11px] text-slate-400">
                        Kecepatan simetris 100% tanpa FUP untuk kenyamanan browsing dan unduh cepat tanpa batasan kuota.
                    </p>

                    <button onclick="window.openOrderModal(document.getElementById('calc-recommend-pkg').innerText, document.getElementById('calc-result-speed').innerText, 'Unlimited (Tanpa FUP)', '')" class="w-full btn-rn-primary text-xs py-3 font-bold uppercase tracking-wider">
                        <i class="fa-solid fa-cart-shopping"></i> Ambil Paket Rekomendasi
                    </button>
                </div>

            </div>

        </div>

    </div>
</section>

<!-- 5. CORE COMPANY SERVICES (4 PILLARS) -->
<!-- Internet, Pemasangan Jaringan, CCTV AI, Setup Server -->
<section id="layanan" class="py-20 bg-slate-50 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-ringOrange-100 text-ringOrange-800 text-xs font-bold uppercase tracking-wider">
                <i class="fa-solid fa-cubes text-ringOrange-500"></i> Solusi IT & Telekomunikasi
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 font-display">
                Bidang Usaha & Layanan Ring Network
            </h2>
            <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                Kami tidak hanya menjual bandwidth internet, namun juga menghadirkan ekosistem jaringan terpadu, keamanan CCTV modern, dan manajemen server komprehensif.
            </p>
        </div>

        <!-- 4 Core Service Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Service 1: Penjualan Internet Fiber -->
            <div id="penjualan-internet" class="bg-white rounded-3xl p-8 border border-sky-100 shadow-xl shadow-sky-900/5 hover-card-effect flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-sky-600 to-sky-400 text-white flex items-center justify-center text-2xl shadow-lg shadow-sky-500/30">
                            <i class="fa-solid fa-wifi"></i>
                        </div>
                        <span class="text-xs font-bold px-3 py-1 rounded-full bg-sky-100 text-sky-800">
                            Layanan ISP Resmi
                        </span>
                    </div>

                    <h3 class="text-2xl font-extrabold text-slate-900">Penjualan Internet Fiber Optic</h3>
                    <p class="text-sm text-slate-600 mt-3 leading-relaxed">
                        Penyediaan bandwidth internet broadband maupun dedicated line dengan jaringan 100% serat optik. Cocok untuk kebutuhan residensial, perumahan, instansi sekolah, perkantoran, hingga industri pabrik.
                    </p>

                    <div class="mt-6 space-y-2.5">
                        <div class="flex items-center gap-2.5 text-xs font-semibold text-slate-700">
                            <i class="fa-solid fa-circle-check text-sky-500"></i>
                            <span>Rasio Simetris 1:1 Download & Upload (Ideal untuk Content Creator & Live Streaming)</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-xs font-semibold text-slate-700">
                            <i class="fa-solid fa-circle-check text-sky-500"></i>
                            <span>Bebas FUP Sepuasnya (No Speed Throttling)</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-xs font-semibold text-slate-700">
                            <i class="fa-solid fa-circle-check text-sky-500"></i>
                            <span>Dukungan SLA Hingga 99.9% dengan Dual Backbone Redundancy</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs text-slate-500">Mulai dari <strong class="text-sky-600 text-sm font-bold">Rp 150.000/bln</strong></span>
                    <a href="#paket-internet" class="btn-rn-secondary text-xs py-2.5 px-5">
                        Lihat Semua Paket
                    </a>
                </div>
            </div>

            <!-- Service 2: Pemasangan Jaringan Internet (LAN/FO) -->
            <div id="jaringan" class="bg-white rounded-3xl p-8 border border-sky-100 shadow-xl shadow-sky-900/5 hover-card-effect flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-ringOrange-500 to-amber-500 text-white flex items-center justify-center text-2xl shadow-lg shadow-orange-500/30">
                            <i class="fa-solid fa-network-wired"></i>
                        </div>
                        <span class="text-xs font-bold px-3 py-1 rounded-full bg-orange-100 text-orange-800">
                            Infrastruktur & Splicing
                        </span>
                    </div>

                    <h3 class="text-2xl font-extrabold text-slate-900">Pemasangan Jaringan Internet (LAN & FO)</h3>
                    <p class="text-sm text-slate-600 mt-3 leading-relaxed">
                        Jasa penarikan kabel fiber optik, perapian kabel LAN UTP/STP Cat6/6A, penyambungan splicing core FO dengan alat fusi canggih, setting routerboard Mikrotik/Cisco, dan sistem Wi-Fi Mesh gedung.
                    </p>

                    <div class="mt-6 space-y-2.5">
                        <div class="flex items-center gap-2.5 text-xs font-semibold text-slate-700">
                            <i class="fa-solid fa-circle-check text-ringOrange-500"></i>
                            <span>Splicing Core Fiber Optic & Pengujian OTDR Presisi Redaman Rendah</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-xs font-semibold text-slate-700">
                            <i class="fa-solid fa-circle-check text-ringOrange-500"></i>
                            <span>Instalasi Wireless Point-to-Point (PtP / PtMP) Antar Gedung Jarak Jauh</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-xs font-semibold text-slate-700">
                            <i class="fa-solid fa-circle-check text-ringOrange-500"></i>
                            <span>Setting Mikrotik: Load Balancing, Bandwidth Management & Voucher Hotspot</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs text-slate-500">Gratis Survey & Estimasi RAB</span>
                    <button onclick="window.openOrderModal('Jasa Pemasangan & Perapian Jaringan LAN/FO', '', '', '')" class="btn-rn-primary text-xs py-2.5 px-5">
                        Konsultasi Jaringan
                    </button>
                </div>
            </div>

            <!-- Service 3: Pemasangan CCTV & Smart AI -->
            <div id="cctv" class="bg-white rounded-3xl p-8 border border-sky-100 shadow-xl shadow-sky-900/5 hover-card-effect flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-ringYellow-500 to-amber-600 text-white flex items-center justify-center text-2xl shadow-lg shadow-yellow-500/30">
                            <i class="fa-solid fa-video"></i>
                        </div>
                        <span class="text-xs font-bold px-3 py-1 rounded-full bg-amber-100 text-amber-800">
                            Smart Surveillance
                        </span>
                    </div>

                    <h3 class="text-2xl font-extrabold text-slate-900">Pemasangan CCTV & Smart AI</h3>
                    <p class="text-sm text-slate-600 mt-3 leading-relaxed">
                        Instalasi kamera pengawas IP Camera resolusi ultra 4K, teknologi ColorVu (malam hari tetap terang berwarna), deteksi gerak berbasis kecerdasan buatan (AI Human/Vehicle detection), dan akses live view dari smartphone 24 jam.
                    </p>

                    <div class="mt-6 space-y-2.5">
                        <div class="flex items-center gap-2.5 text-xs font-semibold text-slate-700">
                            <i class="fa-solid fa-circle-check text-ringYellow-500"></i>
                            <span>Kamera 4K Ultra HD & Night Vision ColorVu Jernih Tanpa Noise</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-xs font-semibold text-slate-700">
                            <i class="fa-solid fa-circle-check text-ringYellow-500"></i>
                            <span>Notifikasi Instan ke HP saat Terdeteksi Gerakan / Intrusi Mencurigakan</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-xs font-semibold text-slate-700">
                            <i class="fa-solid fa-circle-check text-ringYellow-500"></i>
                            <span>Pemasangan Rapi dengan Pipa Conduit PVC / Tray Khusus Standar Proteksi</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs text-slate-500">Paket 4, 8, 16 s/d 32 Channel IP Cam</span>
                    <button onclick="window.openOrderModal('Pemasangan CCTV Smart AI', '', '', '')" class="btn-rn-primary text-xs py-2.5 px-5">
                        Pesan Paket CCTV
                    </button>
                </div>
            </div>

            <!-- Service 4: Setup & Maintenance Server -->
            <div id="server" class="bg-white rounded-3xl p-8 border border-sky-100 shadow-xl shadow-sky-900/5 hover-card-effect flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-slate-900 to-sky-900 text-white flex items-center justify-center text-2xl shadow-lg shadow-slate-900/30">
                            <i class="fa-solid fa-server"></i>
                        </div>
                        <span class="text-xs font-bold px-3 py-1 rounded-full bg-slate-100 text-slate-800">
                            Server & Virtualisasi
                        </span>
                    </div>

                    <h3 class="text-2xl font-extrabold text-slate-900">Setup & Maintenance Server</h3>
                    <p class="text-sm text-slate-600 mt-3 leading-relaxed">
                        Layanan instalasi rak server, perakitan hardware, virtualisasi server (Proxmox VE, VMware ESXi), konfigurasi file server/NAS, Active Directory, sistem backup otomatis harian, dan kontrak maintenance berkala.
                    </p>

                    <div class="mt-6 space-y-2.5">
                        <div class="flex items-center gap-2.5 text-xs font-semibold text-slate-700">
                            <i class="fa-solid fa-circle-check text-slate-800"></i>
                            <span>Instalasi Server Rackmount & Tata Kelola Kabel (Cable Management Rapi)</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-xs font-semibold text-slate-700">
                            <i class="fa-solid fa-circle-check text-slate-800"></i>
                            <span>Virtualisasi Proxmox/VMware untuk Efisiensi & Keamanan Resource</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-xs font-semibold text-slate-700">
                            <i class="fa-solid fa-circle-check text-slate-800"></i>
                            <span>Sistem Backup Data Otomatis & Disaster Recovery Redundant</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs text-slate-500">Mendukung Linux & Windows Server</span>
                    <button onclick="window.openOrderModal('Setup & Maintenance Server', '', '', '')" class="btn-rn-secondary text-xs py-2.5 px-5">
                        Konsultasi Server
                    </button>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- 6. ALUR PEMASANGAN (HOW IT WORKS) -->
<section class="py-16 bg-white border-t border-sky-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-600">Proses Mudah & Transparan</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display mt-1">
                4 Langkah Mudah Pasang Baru di Ring Network
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 relative group hover:bg-sky-50 transition">
                <span class="text-3xl font-black text-sky-200 group-hover:text-sky-500 transition font-display">01</span>
                <h4 class="text-base font-bold text-slate-800 mt-2">Pilih Paket Layanan</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Tentukan pilihan paket Home atau Residential dengan kecepatan dan FUP yang Anda inginkan.</p>
            </div>

            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 relative group hover:bg-orange-50 transition">
                <span class="text-3xl font-black text-orange-200 group-hover:text-ringOrange-500 transition font-display">02</span>
                <h4 class="text-base font-bold text-slate-800 mt-2">Konfirmasi & Survey</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Tim sales kami memvalidasi titik ODP terdekat dan mengonfirmasi jadwal survey lapangan.</p>
            </div>

            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 relative group hover:bg-amber-50 transition">
                <span class="text-3xl font-black text-amber-200 group-hover:text-ringYellow-500 transition font-display">03</span>
                <h4 class="text-base font-bold text-slate-800 mt-2">Instalasi Rapi</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Teknisi berpengalaman menarik kabel fiber/LAN, memasang router Wi-Fi 6 atau perangkat CCTV.</p>
            </div>

            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 relative group hover:bg-emerald-50 transition">
                <span class="text-3xl font-black text-emerald-200 group-hover:text-emerald-500 transition font-display">04</span>
                <h4 class="text-base font-bold text-slate-800 mt-2">Aktivasi & Online</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Speed test langsung di lokasi untuk memastikan kecepatan sesuai spesifikasi tanpa FUP.</p>
            </div>

        </div>

    </div>
</section>

<!-- 7. CONTACT & INQUIRY FORM SECTION -->
<section id="kontak" class="py-20 bg-slate-900 text-white relative overflow-hidden">
    <!-- Ambient glow -->
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-sky-500/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Info -->
            <div class="lg:col-span-5 space-y-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-ringOrange-500/20 text-ringOrange-400 text-xs font-bold">
                    <i class="fa-solid fa-envelope"></i> Hubungi Ring Network
                </div>

                <h2 class="text-3xl sm:text-4xl font-extrabold font-display leading-tight">
                    Siap Menikmati Koneksi Tanpa Batas Bersama Kami?
                </h2>

                <p class="text-sm text-slate-300 leading-relaxed">
                    Konsultasikan kebutuhan internet, CCTV perumahan, maupun infrastruktur server kantor Anda. Tim ahli Ring Network siap membantu memberikan estimasi terbaik dan jadwal pemasangan tercepat.
                </p>

                <div class="space-y-4 pt-2 text-sm text-slate-300">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-800 text-emerald-400 flex items-center justify-center shrink-0">
                            <i class="fa-brands fa-whatsapp text-lg"></i>
                        </div>
                        <div>
                            <span class="text-[11px] text-slate-400 uppercase font-bold block">WhatsApp Sales & Support:</span>
                            <a href="<?= e(getWaLink('Halo Ring Network, saya ingin tanya info pasang baru.')) ?>" target="_blank" class="hover:text-emerald-400 font-semibold transition">
                                <?= e(getSetting('phone', '+62 812-2934-2503')) ?>
                            </a>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-800 text-sky-400 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-envelope text-base"></i>
                        </div>
                        <div>
                            <span class="text-[11px] text-slate-400 uppercase font-bold block">Email Korespondensi:</span>
                            <span class="font-semibold"><?= e(getSetting('email', 'sales@ringnetwork.co.id')) ?></span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-800 text-ringOrange-400 flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fa-solid fa-location-dot text-base"></i>
                        </div>
                        <div>
                            <span class="text-[11px] text-slate-400 uppercase font-bold block">Kantor POP Ring Network:</span>
                            <span class="font-semibold text-xs leading-relaxed"><?= e(getSetting('address', 'Kantor POP Ring Network: Pedukuhan 7, RT.26/RW.13, Dusun VII, Cerme, Kec. Panjatan, Kabupaten Kulon Progo, Daerah Istimewa Yogyakarta 55655')) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Form Card -->
            <div class="lg:col-span-7 bg-white text-slate-800 rounded-3xl p-8 sm:p-10 shadow-2xl border border-sky-100">
                <h3 class="text-xl font-bold text-slate-900 mb-1">Kirim Permintaan Pasang / Konsultasi</h3>
                <p class="text-xs text-slate-500 mb-6">Data Anda akan langsung tercatat di sistem kami dan diteruskan ke WhatsApp.</p>

                <form id="contactForm" onsubmit="event.preventDefault(); window.openOrderModal('Konsultasi Umum', '', '', '');" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap</label>
                            <input type="text" id="contact_name" placeholder="Nama Anda" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nomor WhatsApp</label>
                            <input type="tel" id="contact_phone" placeholder="08xxxxxxxxxx" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Pilihan Layanan</label>
                        <select id="contact_service" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 outline-none">
                            <option value="Paket Internet Home">Paket Internet Home (Fiber Optic)</option>
                            <option value="Paket Internet Residential (1:1)">Paket Internet Residential (Dedicated 1:1)</option>
                            <option value="Pemasangan & Splicing Jaringan FO/LAN">Pemasangan & Splicing Jaringan FO / LAN</option>
                            <option value="Pemasangan CCTV Smart AI">Pemasangan CCTV & Smart AI</option>
                            <option value="Setup & Maintenance Server">Setup & Maintenance Server (Proxmox / Linux)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Alamat / Lokasi Pemasangan</label>
                        <input type="text" id="contact_address" placeholder="Perumahan / Jalan / Kota" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 outline-none">
                    </div>

                    <button type="button" onclick="
                        const name = document.getElementById('contact_name').value;
                        const srv = document.getElementById('contact_service').value;
                        window.openOrderModal(srv, '', '', '');
                    " class="w-full btn-rn-primary py-3.5 text-sm uppercase tracking-wider font-bold">
                        <i class="fa-solid fa-paper-plane mr-1.5"></i> Lanjutkan & Booking Survey
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>

<?php
include __DIR__ . '/includes/footer.php';
?>
