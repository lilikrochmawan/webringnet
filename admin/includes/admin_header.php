<?php
require_once __DIR__ . '/../auth_check.php';
require_once __DIR__ . '/../../config/helper.php';

$currentPage = basename($_SERVER['PHP_SELF']);
$adminName = $_SESSION['admin_name'] ?? 'Administrator';
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Admin Dashboard' ?> | Ring Network</title>
    
    <!-- Favicon Icons (Ring Network Official Emblem) -->
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/apple-touch-icon.png">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ringSky: {
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                        },
                        ringOrange: {
                            500: '#ff6b00',
                            600: '#ea580c',
                        },
                        ringYellow: {
                            400: '#facc15',
                            500: '#f59e0b',
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
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-display { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen flex flex-col md:flex-row antialiased">

    <!-- Sidebar Navigation -->
    <aside class="w-full md:w-64 bg-slate-900 text-slate-300 flex-shrink-0 flex flex-col justify-between border-r border-slate-800">
        <div>
            <!-- Sidebar Header & Logo -->
            <div class="p-5 border-b border-slate-800 flex items-center justify-between">
                <a href="index.php" class="bg-white/95 px-2.5 py-1.5 rounded-xl inline-block shadow">
                    <img src="../assets/images/logo.png" alt="Ring Network" class="h-8 w-auto" onerror="this.onerror=null; this.src='../assets/images/logo.jpg';">
                </a>
                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-sky-500/20 text-sky-400 border border-sky-500/30">
                    Admin
                </span>
            </div>

            <!-- Quick Link to Public Website -->
            <div class="px-4 py-3 bg-slate-950/60 border-b border-slate-800 flex items-center justify-between text-xs">
                <span class="text-slate-400">Live Website:</span>
                <a href="../index.php" target="_blank" class="text-sky-400 hover:text-sky-300 font-semibold flex items-center gap-1 transition">
                    <span>Buka Web</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                </a>
            </div>

            <!-- Menu List -->
            <nav class="p-4 space-y-1 text-sm font-medium">
                <a href="index.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition <?= $currentPage === 'index.php' ? 'bg-sky-600 text-white font-bold shadow-md shadow-sky-600/30' : 'hover:bg-slate-800 text-slate-300' ?>">
                    <i class="fa-solid fa-chart-pie w-5 text-center text-sky-400"></i>
                    <span>Dashboard</span>
                </a>

                <!-- TASKBAR & DROPDOWN BUILDER (HIGHLIGHTED) -->
                <a href="menus.php" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition <?= $currentPage === 'menus.php' ? 'bg-gradient-to-r from-ringOrange-500 to-amber-500 text-white font-bold shadow-md' : 'hover:bg-slate-800 text-slate-300' ?>">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-layer-group w-5 text-center text-ringOrange-400"></i>
                        <span>Dropdown Taskbar</span>
                    </div>
                    <span class="text-[10px] px-1.5 py-0.5 rounded font-bold <?= $currentPage === 'menus.php' ? 'bg-white/20 text-white' : 'bg-orange-500/20 text-orange-400' ?>">
                        Menu
                    </span>
                </a>

                <!-- INTERNET PACKAGES (HOME & RESIDENTIAL) -->
                <a href="packages.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition <?= $currentPage === 'packages.php' ? 'bg-sky-600 text-white font-bold shadow-md shadow-sky-600/30' : 'hover:bg-slate-800 text-slate-300' ?>">
                    <i class="fa-solid fa-wifi w-5 text-center text-ringYellow-400"></i>
                    <span>Paket Internet</span>
                </a>

                <!-- SERVICES (CCTV, SERVER, NETWORKING, ETC.) -->
                <a href="services.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition <?= $currentPage === 'services.php' ? 'bg-sky-600 text-white font-bold shadow-md shadow-sky-600/30' : 'hover:bg-slate-800 text-slate-300' ?>">
                    <i class="fa-solid fa-cube w-5 text-center text-sky-400"></i>
                    <span>Kelola Layanan</span>
                </a>

                <!-- COVERAGE AREAS (CEK JANGKAUAN JARINGAN) -->
                <a href="coverage.php" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition <?= $currentPage === 'coverage.php' ? 'bg-sky-600 text-white font-bold shadow-md shadow-sky-600/30' : 'hover:bg-slate-800 text-slate-300' ?>">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-map-location-dot w-5 text-center text-emerald-400"></i>
                        <span>Cek Jangkauan Area</span>
                    </div>
                    <?php
                        $coveredCount = $pdo->query("SELECT COUNT(*) FROM coverage_areas WHERE is_active = 1")->fetchColumn();
                    ?>
                    <span class="text-[10px] px-1.5 py-0.5 rounded font-bold bg-emerald-500/20 text-emerald-300">
                        <?= $coveredCount ?> Area
                    </span>
                </a>

                <!-- INQUIRIES / LEADS -->
                <a href="inquiries.php" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition <?= $currentPage === 'inquiries.php' ? 'bg-sky-600 text-white font-bold shadow-md shadow-sky-600/30' : 'hover:bg-slate-800 text-slate-300' ?>">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-inbox w-5 text-center text-emerald-400"></i>
                        <span>Pesanan & Survey</span>
                    </div>
                    <?php
                        $unreadCount = $pdo->query("SELECT COUNT(*) FROM inquiries WHERE status = 'Baru'")->fetchColumn();
                        if ($unreadCount > 0):
                    ?>
                        <span class="text-[10px] px-1.5 py-0.5 rounded-full font-bold bg-emerald-500 text-white animate-pulse">
                            <?= $unreadCount ?>
                        </span>
                    <?php endif; ?>
                </a>

                <!-- SETTINGS -->
                <a href="settings.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition <?= $currentPage === 'settings.php' ? 'bg-sky-600 text-white font-bold shadow-md shadow-sky-600/30' : 'hover:bg-slate-800 text-slate-300' ?>">
                    <i class="fa-solid fa-gear w-5 text-center text-slate-400"></i>
                    <span>Pengaturan Web</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Bottom: Admin profile & Logout -->
        <div class="p-4 border-t border-slate-800 bg-slate-950/40">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-sky-500 to-amber-500 flex items-center justify-center text-white text-xs font-bold">
                        <?= strtoupper(substr($adminName, 0, 1)) ?>
                    </div>
                    <div class="overflow-hidden">
                        <span class="block text-xs font-bold text-white truncate"><?= e($adminName) ?></span>
                        <span class="block text-[10px] text-slate-400">Administrator</span>
                    </div>
                </div>
                <a href="logout.php" title="Keluar / Logout" class="p-2 text-slate-400 hover:text-red-400 rounded-lg hover:bg-slate-800 transition">
                    <i class="fa-solid fa-power-off text-sm"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        
        <!-- Top App Bar -->
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between sticky top-0 z-30 shadow-sm">
            <div>
                <h1 class="text-xl font-bold font-display text-slate-900"><?= $pageTitle ?? 'Admin Panel' ?></h1>
                <p class="text-xs text-slate-500"><?= $pageSubtitle ?? 'Kelola konten Ring Network secara realtime' ?></p>
            </div>
            <div class="flex items-center gap-3">
                <a href="../index.php" target="_blank" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition flex items-center gap-1.5">
                    <i class="fa-solid fa-globe text-sky-600"></i>
                    <span>Preview Web</span>
                </a>
                <a href="logout.php" class="px-3.5 py-2 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold transition flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span>Logout</span>
                </a>
            </div>
        </header>

        <!-- Flash Alert Notification -->
        <?php if ($flash): ?>
            <div class="max-w-7xl mx-auto w-full px-6 pt-5">
                <div class="p-4 rounded-2xl flex items-center gap-3 text-sm shadow-sm border <?= $flash['type'] === 'success' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-red-50 text-red-800 border-red-200' ?>">
                    <i class="fa-solid <?= $flash['type'] === 'success' ? 'fa-circle-check text-emerald-600' : 'fa-triangle-exclamation text-red-600' ?> text-lg"></i>
                    <span><?= e($flash['message']) ?></span>
                </div>
            </div>
        <?php endif; ?>

        <!-- Page Dynamic Body Container -->
        <div class="p-6 max-w-7xl w-full mx-auto space-y-6">
