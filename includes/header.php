<?php
require_once __DIR__ . '/../config/helper.php';
$dropdownItems = getNavbarMenus();
$companyName = getSetting('company_name', 'Ring Network');
$tagline = getSetting('tagline', 'Connect • Secure • Empower');
$whatsapp = getSetting('whatsapp', '6281229342503');
$phone = getSetting('phone', '+62 812-2934-2503');
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($companyName) ?> | Solusi Internet Fiber, Pemasangan Jaringan, CCTV & Setup Server</title>
    <meta name="description" content="<?= e($companyName) ?> - Penyedia Layanan Internet Fiber Optic Home & Residential, Instalasi Jaringan LAN/FO, Pemasangan CCTV AI & Konfigurasi Server Profesional.">
    <meta name="keywords" content="ring network, internet fiber, pasang wifi rumah, internet residential, fup internet, pasang cctv, setup server, jasa instalasi jaringan">
    
    <!-- Favicon Icons (Ring Network Official Emblem) -->
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    
    <!-- Google Fonts: Plus Jakarta Sans & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ringSky: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        ringOrange: {
                            400: '#fb923c',
                            500: '#ff6b00',
                            600: '#ea580c',
                            700: '#c2410c',
                        },
                        ringYellow: {
                            400: '#facc15',
                            500: '#f59e0b',
                            600: '#d97706',
                        },
                        ringDark: {
                            800: '#0f172a',
                            900: '#0a1128',
                            950: '#060a17',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome 6 Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-sky-500 selection:text-white">

    <!-- Top Announcement Bar -->
    <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-sky-950 text-slate-300 text-xs py-2 px-4 border-b border-sky-900/40 hidden md:block">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-6">
                <span class="inline-flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span class="text-sky-300 font-medium">Jaringan Aktif 100% Fiber Optic</span>
                </span>
                <span class="text-slate-400">•</span>
                <span class="flex items-center gap-1.5 hover:text-white transition">
                    <i class="fa-solid fa-headset text-ringOrange-500"></i> NOC & Support 24/7: <?= e($phone) ?>
                </span>
                <span class="text-slate-400">•</span>
                <span class="flex items-center gap-1.5 hover:text-white transition">
                    <i class="fa-solid fa-envelope text-ringYellow-400"></i> <?= e(getSetting('email', 'sales@ringnetwork.co.id')) ?>
                </span>
            </div>
            <div class="flex items-center gap-4">
                <a href="#cakupan" onclick="window.openCoverageModal(); return false;" class="text-sky-300 hover:text-white font-medium flex items-center gap-1">
                    <i class="fa-solid fa-map-location-dot text-ringOrange-500"></i> Cek Area Jangkauan
                </a>
                <span class="text-slate-700">|</span>
                <a href="admin/login.php" class="text-slate-400 hover:text-amber-400 transition flex items-center gap-1">
                    <i class="fa-solid fa-lock text-xs"></i> Portal Admin
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar (Taskbar) -->
    <header class="sticky top-0 z-50 glass-nav transition-all duration-300 shadow-sm" id="main-header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo Brand -->
                <a href="index.php" class="flex items-center gap-3 group">
                    <div class="relative flex items-center bg-white/70 py-1 px-2 rounded-xl">
                        <!-- We use our generated clean logo image -->
                        <img src="assets/images/logo.png" alt="Ring Network Logo" class="h-10 sm:h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105" onerror="this.onerror=null; this.src='assets/images/logo.jpg';">
                    </div>
                </a>

                <!-- Desktop Navigation Menu Links -->
                <nav class="hidden lg:flex items-center gap-1 xl:gap-2">
                    <a href="index.php#hero" class="px-3.5 py-2 text-sm font-semibold text-slate-700 hover:text-sky-600 rounded-lg hover:bg-sky-50 transition">
                        Beranda
                    </a>

                    <!-- DYNAMIC DROPDOWN: LAYANAN (Taskbar Dropdown Builder) -->
                    <div class="relative group">
                        <button type="button" class="px-3.5 py-2 text-sm font-semibold text-slate-700 hover:text-sky-600 rounded-lg hover:bg-sky-50 transition flex items-center gap-1.5 focus:outline-none">
                            <span>Layanan</span>
                            <i class="fa-solid fa-chevron-down text-xs text-slate-400 group-hover:text-sky-600 group-hover:rotate-180 transition-transform duration-200"></i>
                            <span class="w-1.5 h-1.5 rounded-full bg-ringOrange-500"></span>
                        </button>

                        <!-- Dynamic Dropdown Menu Container -->
                        <div class="absolute left-0 top-full pt-2 w-80 xl:w-96 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-2 group-hover:translate-y-0 z-50">
                            <div class="bg-white rounded-2xl shadow-2xl border border-sky-100 p-3 ring-1 ring-black/5 overflow-hidden">
                                <div class="px-3 py-2 bg-gradient-to-r from-sky-50 to-orange-50/50 rounded-xl mb-2 flex items-center justify-between border border-sky-100/60">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-layer-group text-sky-600 text-sm"></i>
                                        <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Solusi & Layanan Kami</span>
                                    </div>
                                    <span class="text-[10px] bg-sky-500 text-white font-bold px-2 py-0.5 rounded-full">Ring Net</span>
                                </div>

                                <div class="space-y-1">
                                    <?php if (!empty($dropdownItems)): ?>
                                        <?php foreach ($dropdownItems as $menu): ?>
                                            <a href="<?= e($menu['url']) ?>" class="group/item flex items-start gap-3.5 p-2.5 rounded-xl hover:bg-gradient-to-r hover:from-sky-50 hover:to-orange-50/30 transition border border-transparent hover:border-sky-100">
                                                <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center shrink-0 group-hover/item:bg-gradient-to-tr group-hover/item:from-sky-500 group-hover/item:to-sky-400 group-hover/item:text-white transition shadow-sm">
                                                    <i class="<?= e($menu['icon'] ?: 'fa-solid fa-check') ?> text-base"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center justify-between gap-1">
                                                        <h4 class="text-sm font-bold text-slate-800 group-hover/item:text-sky-600 transition truncate">
                                                            <?= e($menu['title']) ?>
                                                        </h4>
                                                        <?php if (!empty($menu['badge'])): ?>
                                                            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-ringOrange-500/10 text-ringOrange-600 border border-ringOrange-500/20">
                                                                <?= e($menu['badge']) ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php if (!empty($menu['description'])): ?>
                                                        <p class="text-xs text-slate-500 line-clamp-1 mt-0.5">
                                                            <?= e($menu['description']) ?>
                                                        </p>
                                                    <?php endif; ?>
                                                </div>
                                            </a>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p class="text-xs text-slate-400 p-2">Belum ada menu layanan tambahan.</p>
                                    <?php endif; ?>
                                </div>

                                <!-- Dropdown Footer Notice -->
                                <div class="mt-2 pt-2 border-t border-slate-100 flex items-center justify-between px-2 text-[11px] text-slate-400">
                                    <span class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-shield-halved text-emerald-500"></i> SLA 99.9% Uptime Terjamin
                                    </span>
                                    <span class="text-sky-600 font-semibold flex items-center gap-1">
                                        <i class="fa-solid fa-bolt text-ringOrange-500 text-[10px]"></i> 100% Fiber Optic
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="index.php#paket-internet" class="px-3.5 py-2 text-sm font-semibold text-slate-700 hover:text-sky-600 rounded-lg hover:bg-sky-50 transition flex items-center gap-1.5">
                        <i class="fa-solid fa-bolt text-ringYellow-500 text-xs"></i>
                        <span>Paket Internet</span>
                    </a>

                    <a href="index.php#cctv" class="px-3.5 py-2 text-sm font-semibold text-slate-700 hover:text-sky-600 rounded-lg hover:bg-sky-50 transition">
                        CCTV AI
                    </a>

                    <a href="index.php#server" class="px-3.5 py-2 text-sm font-semibold text-slate-700 hover:text-sky-600 rounded-lg hover:bg-sky-50 transition">
                        Setup Server
                    </a>

                    <a href="index.php#kalkulator" class="px-3.5 py-2 text-sm font-semibold text-slate-700 hover:text-sky-600 rounded-lg hover:bg-sky-50 transition">
                        Kalkulator Speed
                    </a>

                    <a href="index.php#kontak" class="px-3.5 py-2 text-sm font-semibold text-slate-700 hover:text-sky-600 rounded-lg hover:bg-sky-50 transition">
                        Kontak
                    </a>
                </nav>

                <!-- Header Actions (CTA & WhatsApp) -->
                <div class="hidden sm:flex items-center gap-3">
                    <a href="<?= e(getWaLink('Halo Ring Network, saya ingin konsultasi pemasangan baru internet / CCTV.')) ?>" target="_blank" class="p-2.5 rounded-full text-emerald-600 hover:bg-emerald-50 border border-emerald-200 transition" title="Chat WhatsApp Customer Care">
                        <i class="fa-brands fa-whatsapp text-xl"></i>
                    </a>

                    <button onclick="window.openOrderModal('Pemasangan Baru Ring Network', '', '', '')" class="btn-rn-primary text-sm shadow-md">
                        <i class="fa-solid fa-paper-plane text-xs"></i>
                        <span>Pasang Baru</span>
                    </button>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center gap-2 lg:hidden">
                    <button onclick="window.openOrderModal('Pemasangan Cepat', '', '', '')" class="px-3 py-1.5 bg-ringOrange-500 text-white rounded-full text-xs font-bold shadow-sm">
                        Pasang
                    </button>
                    <button id="mobile-menu-btn" type="button" class="p-2 rounded-xl text-slate-700 hover:text-sky-600 hover:bg-sky-50 focus:outline-none" aria-label="Buka Menu">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>

            </div>
        </div>
    </header>

    <!-- Mobile Drawer Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-slate-950/60 z-50 backdrop-blur-sm hidden transition-opacity"></div>

    <!-- Mobile Navigation Drawer -->
    <div id="mobile-menu" class="fixed top-0 right-0 bottom-0 w-80 max-w-[85vw] bg-white z-50 shadow-2xl p-6 flex flex-col justify-between transform translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto">
        <div>
            <!-- Mobile Drawer Header -->
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <img src="assets/images/logo.png" alt="Ring Network" class="h-9 w-auto" onerror="this.onerror=null; this.src='assets/images/logo.jpg';">
                <button id="mobile-menu-close" class="p-2 text-slate-400 hover:text-slate-800 rounded-lg hover:bg-slate-100">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Mobile Nav Items -->
            <div class="mt-6 space-y-1">
                <a href="index.php#hero" class="block px-3 py-2.5 text-base font-semibold text-slate-800 hover:text-sky-600 rounded-xl hover:bg-sky-50">
                    <i class="fa-solid fa-house text-sky-500 w-6"></i> Beranda
                </a>

                <!-- Mobile Dropdown Toggle -->
                <div>
                    <button id="mobile-dropdown-btn" class="w-full flex items-center justify-between px-3 py-2.5 text-base font-semibold text-slate-800 hover:text-sky-600 rounded-xl hover:bg-sky-50">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-layer-group text-ringOrange-500 w-6"></i> Layanan Kami
                        </span>
                        <i id="mobile-dropdown-icon" class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform"></i>
                    </button>
                    <div id="mobile-dropdown-menu" class="hidden pl-8 pr-2 py-2 space-y-2 bg-slate-50 rounded-xl mt-1">
                        <?php foreach ($dropdownItems as $menu): ?>
                            <a href="<?= e($menu['url']) ?>" class="block py-1.5 text-sm font-medium text-slate-600 hover:text-sky-600">
                                <i class="<?= e($menu['icon']) ?> text-xs text-sky-500 mr-1.5"></i> <?= e($menu['title']) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <a href="index.php#paket-internet" class="block px-3 py-2.5 text-base font-semibold text-slate-800 hover:text-sky-600 rounded-xl hover:bg-sky-50">
                    <i class="fa-solid fa-wifi text-sky-500 w-6"></i> Paket Internet (Home & Residential)
                </a>

                <a href="index.php#cctv" class="block px-3 py-2.5 text-base font-semibold text-slate-800 hover:text-sky-600 rounded-xl hover:bg-sky-50">
                    <i class="fa-solid fa-video text-ringOrange-500 w-6"></i> Pemasangan CCTV AI
                </a>

                <a href="index.php#server" class="block px-3 py-2.5 text-base font-semibold text-slate-800 hover:text-sky-600 rounded-xl hover:bg-sky-50">
                    <i class="fa-solid fa-server text-ringYellow-500 w-6"></i> Setup & Maintenance Server
                </a>

                <a href="index.php#kalkulator" class="block px-3 py-2.5 text-base font-semibold text-slate-800 hover:text-sky-600 rounded-xl hover:bg-sky-50">
                    <i class="fa-solid fa-calculator text-emerald-500 w-6"></i> Hitung Kebutuhan Speed
                </a>

                <a href="index.php#kontak" class="block px-3 py-2.5 text-base font-semibold text-slate-800 hover:text-sky-600 rounded-xl hover:bg-sky-50">
                    <i class="fa-solid fa-phone text-sky-600 w-6"></i> Kontak & Bantuan
                </a>
            </div>
        </div>

        <!-- Mobile Drawer Bottom CTA -->
        <div class="pt-6 border-t border-slate-100 space-y-3">
            <button onclick="window.openOrderModal('Pasang Baru Ring Network', '', '', '');" class="w-full btn-rn-primary text-center">
                <i class="fa-solid fa-bolt"></i> Pasang Baru Sekarang
            </button>
            <a href="admin/login.php" class="block text-center py-2 text-xs text-slate-500 hover:text-slate-800">
                <i class="fa-solid fa-lock"></i> Login Panel Pengelola
            </a>
        </div>
    </div>
