<?php
$pageTitle = 'Kelola Paket Internet (Home & Residential)';
$pageSubtitle = 'Definisikan kecepatan (Speed), FUP, harga, dan fitur paket internet';
require_once __DIR__ . '/../config/helper.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// DELETE
if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? $_GET['id'] ?? 0);
    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM internet_packages WHERE id = ?");
        $stmt->execute([$id]);
        setFlash('success', 'Paket internet berhasil dihapus.');
    }
    header('Location: packages.php');
    exit;
}

// TOGGLE STATUS
if ($action === 'toggle_status') {
    $id = (int)($_POST['id'] ?? 0);
    $currentStatus = (int)($_POST['status'] ?? 0);
    $newStatus = $currentStatus === 1 ? 0 : 1;
    $stmt = $pdo->prepare("UPDATE internet_packages SET is_active = ? WHERE id = ?");
    $stmt->execute([$newStatus, $id]);
    setFlash('success', 'Status paket berhasil diubah.');
    header('Location: packages.php');
    exit;
}

// SAVE (CREATE OR UPDATE)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($action === 'create' || $action === 'update')) {
    $category = trim($_POST['category'] ?? 'home');
    $name = trim($_POST['name'] ?? '');
    $speed = trim($_POST['speed'] ?? '');
    $fup = trim($_POST['fup'] ?? 'Unlimited (Tanpa FUP)');
    $price = trim($_POST['price'] ?? '0');
    $billingCycle = trim($_POST['billing_cycle'] ?? '/bulan');
    $features = trim($_POST['features'] ?? '');
    $badge = trim($_POST['badge'] ?? '');
    $isPopular = isset($_POST['is_popular']) ? 1 : 0;
    $whatsappText = trim($_POST['whatsapp_text'] ?? '');
    $sortOrder = (int)($_POST['sort_order'] ?? 0);
    $isActive = isset($_POST['is_active']) ? 1 : 0;

    if (empty($name) || empty($speed) || empty($fup)) {
        setFlash('danger', 'Nama paket, Kecepatan (Speed), dan Kebijakan FUP wajib diisi.');
    } else {
        if ($action === 'create') {
            $stmt = $pdo->prepare("INSERT INTO internet_packages (category, name, speed, fup, price, billing_cycle, features, badge, is_popular, whatsapp_text, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$category, $name, $speed, $fup, $price, $billingCycle, $features, $badge, $isPopular, $whatsappText, $sortOrder, $isActive]);
            setFlash('success', "Paket internet '$name' ($speed) berhasil ditambahkan!");
        } else {
            $id = (int)$_POST['id'];
            $stmt = $pdo->prepare("UPDATE internet_packages SET category = ?, name = ?, speed = ?, fup = ?, price = ?, billing_cycle = ?, features = ?, badge = ?, is_popular = ?, whatsapp_text = ?, sort_order = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$category, $name, $speed, $fup, $price, $billingCycle, $features, $badge, $isPopular, $whatsappText, $sortOrder, $isActive, $id]);
            setFlash('success', "Paket internet '$name' berhasil diperbarui.");
        }
        header('Location: packages.php?cat=' . $category);
        exit;
    }
}

// Fetch edit item if requested
$editItem = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM internet_packages WHERE id = ?");
    $stmt->execute([$editId]);
    $editItem = $stmt->fetch();
}

// Active Filter Category
$filterCat = $_GET['cat'] ?? 'all';
if ($filterCat === 'home') {
    $packages = $pdo->query("SELECT * FROM internet_packages WHERE category = 'home' ORDER BY sort_order ASC, id ASC")->fetchAll();
} elseif ($filterCat === 'residential') {
    $packages = $pdo->query("SELECT * FROM internet_packages WHERE category = 'residential' ORDER BY sort_order ASC, id ASC")->fetchAll();
} else {
    $packages = $pdo->query("SELECT * FROM internet_packages ORDER BY category ASC, sort_order ASC, id ASC")->fetchAll();
}

include __DIR__ . '/includes/admin_header.php';
?>

<!-- Info Header -->
<div class="p-5 rounded-3xl bg-gradient-to-r from-sky-50 via-cyan-50 to-orange-50 border border-sky-200/80 flex flex-col md:flex-row items-center justify-between gap-4">
    <div class="flex items-center gap-3">
        <div class="w-12 h-12 rounded-2xl bg-sky-600 text-white flex items-center justify-center text-xl shrink-0 shadow-md shadow-sky-600/30">
            <i class="fa-solid fa-wifi"></i>
        </div>
        <div>
            <h3 class="font-bold text-slate-800 text-base">Definisi Paket Internet Home & Residential</h3>
            <p class="text-xs text-slate-600 mt-0.5">
                Kelola parameter kecepatan (e.g. 50 Mbps) dan batasan FUP (Fair Usage Policy / Unlimited). Seluruh perubahan langsung tampil di tabel harga website utama.
            </p>
        </div>
    </div>
    <a href="../index.php#paket-internet" target="_blank" class="btn-rn-secondary text-xs py-2.5 px-4 shrink-0 whitespace-nowrap">
        <i class="fa-solid fa-globe"></i> Lihat di Website
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    
    <!-- Left Column: Add / Edit Package Form (5 Cols) -->
    <div class="lg:col-span-5 bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 shadow-sm sticky top-24">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
            <div class="flex items-center gap-2">
                <i class="fa-solid <?= $editItem ? 'fa-pen-to-square text-sky-600' : 'fa-circle-plus text-ringOrange-500' ?> text-lg"></i>
                <h3 class="font-bold text-slate-900 text-base">
                    <?= $editItem ? 'Edit Paket Internet' : 'Tambah Paket Internet Baru' ?>
                </h3>
            </div>
            <?php if ($editItem): ?>
                <a href="packages.php" class="text-xs text-slate-400 hover:text-slate-700">
                    <i class="fa-solid fa-xmark mr-1"></i> Batal Edit
                </a>
            <?php endif; ?>
        </div>

        <form method="POST" action="packages.php" class="space-y-4">
            <input type="hidden" name="action" value="<?= $editItem ? 'update' : 'create' ?>">
            <?php if ($editItem): ?>
                <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <?php endif; ?>

            <!-- Category Switcher: Home vs Residential -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Kategori Layanan *
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="flex items-center justify-center gap-2 p-2.5 rounded-xl border cursor-pointer transition text-xs font-bold <?= (!isset($editItem) || $editItem['category'] === 'home') ? 'bg-sky-50 border-sky-500 text-sky-700' : 'bg-slate-50 border-slate-200 text-slate-600' ?>">
                        <input type="radio" name="category" value="home" <?= (!isset($editItem) || $editItem['category'] === 'home') ? 'checked' : '' ?> class="accent-sky-600">
                        <i class="fa-solid fa-house"></i>
                        <span>Paket HOME</span>
                    </label>
                    <label class="flex items-center justify-center gap-2 p-2.5 rounded-xl border cursor-pointer transition text-xs font-bold <?= (isset($editItem) && $editItem['category'] === 'residential') ? 'bg-orange-50 border-ringOrange-500 text-ringOrange-700' : 'bg-slate-50 border-slate-200 text-slate-600' ?>">
                        <input type="radio" name="category" value="residential" <?= (isset($editItem) && $editItem['category'] === 'residential') ? 'checked' : '' ?> class="accent-ringOrange-500">
                        <i class="fa-solid fa-building-user"></i>
                        <span>RESIDENTIAL</span>
                    </label>
                </div>
            </div>

            <!-- Package Name -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Nama Paket *
                </label>
                <input type="text" name="name" required value="<?= e($editItem['name'] ?? '') ?>" placeholder="Misal: Ring Home Family atau Ring Resident Gold" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 outline-none">
            </div>

            <!-- DEFINABLE SPEED & FUP -->
            <div class="grid grid-cols-2 gap-3 p-3.5 rounded-2xl bg-sky-50/60 border border-sky-100">
                <!-- SPEED -->
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-sky-900 mb-1">
                        Kecepatan (Speed) *
                    </label>
                    <input type="text" name="speed" required value="<?= e($editItem['speed'] ?? '50 Mbps') ?>" placeholder="Misal: 50 Mbps" class="w-full px-3 py-2 rounded-xl border border-sky-200 text-xs font-bold text-sky-700 focus:border-sky-500 outline-none">
                    <span class="text-[10px] text-sky-600 mt-0.5 block">Contoh: 30 Mbps, 100 Mbps</span>
                </div>

                <!-- FUP -->
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-sky-900 mb-1">
                        Kebijakan FUP *
                    </label>
                    <input type="text" name="fup" required value="<?= e($editItem['fup'] ?? 'Unlimited (Tanpa Batas FUP)') ?>" placeholder="Misal: Unlimited atau 1000 GB" class="w-full px-3 py-2 rounded-xl border border-sky-200 text-xs font-bold text-emerald-700 focus:border-sky-500 outline-none">
                    <span class="text-[10px] text-sky-600 mt-0.5 block">Contoh: Unlimited, 1500 GB, 1:1</span>
                </div>
            </div>

            <!-- Price & Billing Cycle -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Harga (Rp) *
                    </label>
                    <input type="text" name="price" required value="<?= e($editItem['price'] ?? '325.000') ?>" placeholder="325.000" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Siklus Tagihan
                    </label>
                    <input type="text" name="billing_cycle" value="<?= e($editItem['billing_cycle'] ?? '/bulan') ?>" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 outline-none">
                </div>
            </div>

            <!-- Features List -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Daftar Benefit / Fitur Paket (1 baris per fitur)
                </label>
                <textarea name="features" rows="4" placeholder="Kecepatan Simetris 1:1&#10;100% Tanpa Batasan FUP&#10;Gratis Router Wi-Fi 6&#10;Support 24 Jam" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-sky-500 outline-none resize-none font-mono"><?= e($editItem['features'] ?? '') ?></textarea>
                <span class="text-[11px] text-slate-400">Tekan Enter untuk membuat baris baru. Setiap baris menjadi tanda centang hijau di kartu.</span>
            </div>

            <!-- Badge & Sort Order -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Badge Label (Opsional)
                    </label>
                    <input type="text" name="badge" value="<?= e($editItem['badge'] ?? '') ?>" placeholder="Terpopuler, Best Choice, Promo" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-sky-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Urutan Tampil
                    </label>
                    <input type="number" name="sort_order" value="<?= e($editItem['sort_order'] ?? 1) ?>" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-sky-500 outline-none">
                </div>
            </div>

            <!-- Checkboxes: Popular & Active -->
            <div class="space-y-2 pt-1">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                    <input type="checkbox" name="is_popular" value="1" <?= (isset($editItem) && $editItem['is_popular'] == 1) ? 'checked' : '' ?> class="w-4 h-4 rounded text-ringOrange-500 accent-ringOrange-500">
                    <span class="text-ringOrange-600 font-bold">Tandai sebagai Paket Paling Populer (Card Glow)</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                    <input type="checkbox" name="is_active" value="1" <?= (!isset($editItem) || $editItem['is_active'] == 1) ? 'checked' : '' ?> class="w-4 h-4 rounded text-sky-600 accent-sky-600">
                    <span>Aktifkan dan Tampilkan Paket Ini di Website</span>
                </label>
            </div>

            <!-- Submit -->
            <div class="pt-3">
                <button type="submit" class="w-full btn-rn-primary py-3 text-xs uppercase tracking-wider font-bold shadow-md">
                    <i class="fa-solid <?= $editItem ? 'fa-floppy-disk' : 'fa-plus' ?>"></i>
                    <span><?= $editItem ? 'Simpan Perubahan Paket' : 'Terbitkan Paket Internet' ?></span>
                </button>
            </div>
        </form>
    </div>

    <!-- Right Column: Package List & Filter (7 Cols) -->
    <div class="lg:col-span-7 space-y-5">
        
        <!-- Filter Tabs -->
        <div class="flex items-center justify-between bg-white p-2.5 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-1.5 text-xs font-bold">
                <a href="packages.php?cat=all" class="px-3 py-1.5 rounded-xl transition <?= $filterCat === 'all' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100' ?>">
                    Semua (<?= count($pdo->query("SELECT * FROM internet_packages")->fetchAll()) ?>)
                </a>
                <a href="packages.php?cat=home" class="px-3 py-1.5 rounded-xl transition <?= $filterCat === 'home' ? 'bg-sky-600 text-white' : 'text-slate-600 hover:bg-slate-100' ?>">
                    <i class="fa-solid fa-house mr-1"></i> Home (<?= count($pdo->query("SELECT * FROM internet_packages WHERE category='home'")->fetchAll()) ?>)
                </a>
                <a href="packages.php?cat=residential" class="px-3 py-1.5 rounded-xl transition <?= $filterCat === 'residential' ? 'bg-ringOrange-500 text-white' : 'text-slate-600 hover:bg-slate-100' ?>">
                    <i class="fa-solid fa-building-user mr-1"></i> Residential (<?= count($pdo->query("SELECT * FROM internet_packages WHERE category='residential'")->fetchAll()) ?>)
                </a>
            </div>
        </div>

        <!-- Package List Table -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider border-b border-slate-100 font-semibold">
                        <tr>
                            <th class="py-3.5 px-4">Paket & Kategori</th>
                            <th class="py-3.5 px-4">Kecepatan</th>
                            <th class="py-3.5 px-4">FUP</th>
                            <th class="py-3.5 px-4">Harga</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (!empty($packages)): ?>
                            <?php foreach ($packages as $pkg): ?>
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-4 px-4">
                                        <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                                            <span><?= e($pkg['name']) ?></span>
                                            <?php if ($pkg['is_popular']): ?>
                                                <span class="text-[9px] px-1.5 py-0.5 rounded bg-ringOrange-100 text-ringOrange-700 font-bold">
                                                    ★ Populer
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mt-0.5">
                                            <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded <?= $pkg['category'] === 'home' ? 'bg-sky-100 text-sky-800' : 'bg-orange-100 text-orange-800' ?>">
                                                <?= e($pkg['category']) ?>
                                            </span>
                                            <?php if (!empty($pkg['badge'])): ?>
                                                <span class="text-[10px] text-slate-400 ml-1">
                                                    (<?= e($pkg['badge']) ?>)
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 font-bold text-sky-700 text-sm">
                                        <?= e($pkg['speed']) ?>
                                    </td>
                                    <td class="py-4 px-4 font-semibold text-emerald-700 text-xs">
                                        <span class="px-2 py-1 bg-emerald-50 rounded-lg border border-emerald-100">
                                            <?= e($pkg['fup']) ?>
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 font-bold text-slate-800">
                                        Rp <?= e(formatRupiah($pkg['price'])) ?>
                                        <span class="text-[10px] text-slate-400 font-normal"><?= e($pkg['billing_cycle'] ?: '/bln') ?></span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <form method="POST" action="packages.php" class="inline">
                                            <input type="hidden" name="action" value="toggle_status">
                                            <input type="hidden" name="id" value="<?= $pkg['id'] ?>">
                                            <input type="hidden" name="status" value="<?= $pkg['is_active'] ?>">
                                            <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-bold transition <?= $pkg['is_active'] ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' ?>" title="Klik toggle status">
                                                <?= $pkg['is_active'] ? '● Aktif' : '○ Nonaktif' ?>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="py-4 px-4 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="packages.php?edit=<?= $pkg['id'] ?>" class="p-2 rounded-lg bg-sky-50 text-sky-600 hover:bg-sky-100 transition" title="Edit Paket">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form method="POST" action="packages.php" onsubmit="return confirmDelete('Hapus paket \'<?= e(addslashes($pkg['name'])) ?>\'?');" class="inline">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?= $pkg['id'] ?>">
                                                <button type="submit" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition" title="Hapus Paket">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400">
                                    Belum ada paket internet di kategori ini.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

<?php include __DIR__ . '/includes/admin_footer.php'; ?>
