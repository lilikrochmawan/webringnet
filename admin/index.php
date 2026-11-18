<?php
$pageTitle = 'Dashboard Overview';
$pageSubtitle = 'Ringkasan operasional dan konten website Ring Network';
include __DIR__ . '/includes/admin_header.php';

// Fetch quick stats
$totalMenus = $pdo->query("SELECT COUNT(*) FROM navbar_menus WHERE is_active = 1")->fetchColumn();
$totalHomePackages = $pdo->query("SELECT COUNT(*) FROM internet_packages WHERE category = 'home' AND is_active = 1")->fetchColumn();
$totalResidentPackages = $pdo->query("SELECT COUNT(*) FROM internet_packages WHERE category = 'residential' AND is_active = 1")->fetchColumn();
$totalServices = $pdo->query("SELECT COUNT(*) FROM services WHERE is_active = 1")->fetchColumn();
$newInquiriesCount = $pdo->query("SELECT COUNT(*) FROM inquiries WHERE status = 'Baru'")->fetchColumn();

// Fetch 5 latest inquiries
$latestInquiries = $pdo->query("SELECT * FROM inquiries ORDER BY id DESC LIMIT 5")->fetchAll();
?>

<!-- Metric Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    
    <!-- Stat 1: Menu Dropdown Taskbar -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Dropdown Taskbar</span>
            <div class="text-3xl font-extrabold text-ringOrange-500 font-display mt-1"><?= $totalMenus ?></div>
            <a href="menus.php" class="text-xs text-sky-600 hover:text-sky-700 font-semibold mt-1 inline-flex items-center gap-1">
                <span>Kelola Menu Taskbar</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-orange-100 text-ringOrange-500 flex items-center justify-center text-xl">
            <i class="fa-solid fa-layer-group"></i>
        </div>
    </div>

    <!-- Stat 2: Paket Internet (Home & Residential) -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Paket Internet</span>
            <div class="text-3xl font-extrabold text-sky-600 font-display mt-1">
                <?= $totalHomePackages + $totalResidentPackages ?>
            </div>
            <span class="text-[11px] text-slate-500 block mt-1">
                <?= $totalHomePackages ?> Home • <?= $totalResidentPackages ?> Resident
            </span>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center text-xl">
            <i class="fa-solid fa-wifi"></i>
        </div>
    </div>

    <!-- Stat 3: Total Layanan Usaha -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Layanan Usaha</span>
            <div class="text-3xl font-extrabold text-amber-500 font-display mt-1"><?= $totalServices ?></div>
            <span class="text-[11px] text-slate-500 block mt-1">Internet, Jaringan, CCTV, Server</span>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-500 flex items-center justify-center text-xl">
            <i class="fa-solid fa-cube"></i>
        </div>
    </div>

    <!-- Stat 4: Permintaan Pasang Baru -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Pesanan Baru</span>
            <div class="text-3xl font-extrabold text-emerald-600 font-display mt-1"><?= $newInquiriesCount ?></div>
            <a href="inquiries.php" class="text-xs text-emerald-600 hover:text-emerald-700 font-semibold mt-1 inline-flex items-center gap-1">
                <span>Lihat Semua Pesanan</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl">
            <i class="fa-solid fa-inbox"></i>
        </div>
    </div>

</div>

<!-- Quick Shortcuts Action Card -->
<div class="bg-gradient-to-r from-slate-900 via-sky-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white relative overflow-hidden shadow-xl">
    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="space-y-2">
            <span class="px-3 py-1 rounded-full bg-ringOrange-500/20 text-ringOrange-400 text-xs font-bold uppercase tracking-wider border border-ringOrange-500/30">
                Fitur Utama Pengelola
            </span>
            <h3 class="text-xl sm:text-2xl font-bold font-display">Ingin Menambah Layanan Baru di Taskbar?</h3>
            <p class="text-xs sm:text-sm text-sky-200 max-w-xl">
                Gunakan modul Dropdown Taskbar untuk membuat item menu layanan baru secara dinamis. Anda juga dapat menentukan spesifikasi kecepatan (Speed) dan kebijakan FUP pada paket internet.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-3 shrink-0">
            <a href="menus.php" class="btn-rn-primary text-xs py-3 px-5 shadow-lg">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>+ Buat Dropdown Taskbar</span>
            </a>
            <a href="packages.php" class="btn-rn-secondary text-xs py-3 px-5 shadow-lg">
                <i class="fa-solid fa-wifi text-xs"></i>
                <span>+ Tambah Paket Internet</span>
            </a>
            <a href="coverage.php" class="px-4 py-3 rounded-full bg-slate-800 hover:bg-slate-700 text-emerald-400 font-bold text-xs flex items-center gap-1.5 border border-emerald-500/30 shadow-lg transition">
                <i class="fa-solid fa-map-location-dot"></i>
                <span>Atur Area Jangkauan</span>
            </a>
        </div>
    </div>
</div>

<!-- Recent Inquiries Section -->
<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h3 class="font-bold text-slate-900 text-base">Permintaan Pasang Baru & Konsultasi Terkini</h3>
            <p class="text-xs text-slate-500">Calon pelanggan yang mengisi formulir pemesanan dari website.</p>
        </div>
        <a href="inquiries.php" class="text-xs font-bold text-sky-600 hover:text-sky-700">
            Lihat Semua &rarr;
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider border-b border-slate-100 font-semibold">
                <tr>
                    <th class="py-3 px-6">Pelanggan</th>
                    <th class="py-3 px-6">Layanan / Paket</th>
                    <th class="py-3 px-6">Lokasi Alamat</th>
                    <th class="py-3 px-6">Status</th>
                    <th class="py-3 px-6">Waktu</th>
                    <th class="py-3 px-6 text-right">Aksi Cepat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (!empty($latestInquiries)): ?>
                    <?php foreach ($latestInquiries as $inq): ?>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-800"><?= e($inq['name']) ?></div>
                                <div class="text-[11px] text-slate-500 flex items-center gap-1 mt-0.5">
                                    <i class="fa-brands fa-whatsapp text-emerald-500"></i>
                                    <span><?= e($inq['phone']) ?></span>
                                </div>
                            </td>
                            <td class="py-4 px-6 font-semibold text-sky-700">
                                <?= e($inq['package_or_service'] ?: 'Konsultasi Umum') ?>
                            </td>
                            <td class="py-4 px-6 text-slate-600 max-w-xs truncate" title="<?= e($inq['address']) ?>">
                                <?= e($inq['address'] ?: '-') ?>
                            </td>
                            <td class="py-4 px-6">
                                <?php
                                    $badgeColor = 'bg-sky-100 text-sky-800';
                                    if ($inq['status'] === 'Baru') $badgeColor = 'bg-emerald-100 text-emerald-800 font-bold';
                                    elseif ($inq['status'] === 'Survey') $badgeColor = 'bg-amber-100 text-amber-800';
                                    elseif ($inq['status'] === 'Selesai') $badgeColor = 'bg-slate-100 text-slate-600';
                                ?>
                                <span class="px-2.5 py-1 rounded-full text-[10px] <?= $badgeColor ?>">
                                    <?= e($inq['status']) ?>
                                </span>
                            </td>
                            <td class="py-4 px-6 text-slate-400">
                                <?= date('d M Y, H:i', strtotime($inq['created_at'])) ?>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <?php 
                                    $waClean = preg_replace('/[^0-9]/', '', $inq['phone']);
                                    if (substr($waClean, 0, 1) === '0') $waClean = '62' . substr($waClean, 1);
                                    $waReply = "Halo Bapak/Ibu " . $inq['name'] . ", kami dari Ring Network menindaklanjuti permintaan pasang paket " . ($inq['package_or_service'] ?: 'internet') . ". Apakah lokasi bapak/ibu di " . $inq['address'] . " siap kami survey?";
                                ?>
                                <a href="https://wa.me/<?= $waClean ?>?text=<?= rawurlencode($waReply) ?>" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-semibold transition text-[11px] shadow-sm">
                                    <i class="fa-brands fa-whatsapp"></i> Chat WA
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-400">
                            <i class="fa-solid fa-inbox text-3xl mb-2 block text-slate-300"></i>
                            Belum ada formulir pesanan masuk.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/includes/admin_footer.php'; ?>
