<?php
$pageTitle = 'Kelola Jangkauan & Area Coverage';
$pageSubtitle = 'Atur ketersediaan tiang ODP dan wilayah jangkauan fiber optic untuk pengecekan pelanggan';
require_once __DIR__ . '/../config/helper.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// DELETE
if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? $_GET['id'] ?? 0);
    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM coverage_areas WHERE id = ?");
        $stmt->execute([$id]);
        setFlash('success', 'Area jangkauan berhasil dihapus.');
    }
    header('Location: coverage.php');
    exit;
}

// TOGGLE STATUS
if ($action === 'toggle_status') {
    $id = (int)($_POST['id'] ?? 0);
    $currentStatus = (int)($_POST['status'] ?? 0);
    $newStatus = $currentStatus === 1 ? 0 : 1;
    $stmt = $pdo->prepare("UPDATE coverage_areas SET is_active = ? WHERE id = ?");
    $stmt->execute([$newStatus, $id]);
    setFlash('success', 'Status area berhasil diubah.');
    header('Location: coverage.php');
    exit;
}

// SAVE (CREATE OR UPDATE)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($action === 'create' || $action === 'update')) {
    $areaName = trim($_POST['area_name'] ?? '');
    $subdistrict = trim($_POST['subdistrict'] ?? '');
    $city = trim($_POST['city'] ?? 'Kulon Progo');
    $odpCode = trim($_POST['odp_code'] ?? '');
    $status = trim($_POST['status'] ?? 'Tersedia');
    $notes = trim($_POST['notes'] ?? '');
    $sortOrder = (int)($_POST['sort_order'] ?? 0);
    $isActive = isset($_POST['is_active']) ? 1 : 0;

    if (empty($areaName)) {
        setFlash('danger', 'Nama area / perumahan / dusun wajib diisi.');
    } else {
        if ($action === 'create') {
            $stmt = $pdo->prepare("INSERT INTO coverage_areas (area_name, subdistrict, city, odp_code, status, notes, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$areaName, $subdistrict, $city, $odpCode, $status, $notes, $sortOrder, $isActive]);
            setFlash('success', "Area jangkauan '$areaName' berhasil ditambahkan!");
        } else {
            $id = (int)$_POST['id'];
            $stmt = $pdo->prepare("UPDATE coverage_areas SET area_name = ?, subdistrict = ?, city = ?, odp_code = ?, status = ?, notes = ?, sort_order = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$areaName, $subdistrict, $city, $odpCode, $status, $notes, $sortOrder, $isActive, $id]);
            setFlash('success', "Area jangkauan '$areaName' berhasil diperbarui.");
        }
        header('Location: coverage.php');
        exit;
    }
}

// Fetch edit item if requested
$editItem = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM coverage_areas WHERE id = ?");
    $stmt->execute([$editId]);
    $editItem = $stmt->fetch();
}

// Search & Filter
$search = trim($_GET['q'] ?? '');
$filterStatus = $_GET['filter_status'] ?? 'all';

$sql = "SELECT * FROM coverage_areas WHERE 1=1";
$params = [];

if (!empty($search)) {
    $sql .= " AND (area_name LIKE ? OR subdistrict LIKE ? OR odp_code LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if ($filterStatus !== 'all') {
    $sql .= " AND status = ?";
    $params[] = $filterStatus;
}

$sql .= " ORDER BY sort_order ASC, id ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$areas = $stmt->fetchAll();

include __DIR__ . '/includes/admin_header.php';
?>

<!-- Info Header -->
<div class="p-5 rounded-3xl bg-gradient-to-r from-sky-50 via-cyan-50 to-emerald-50 border border-sky-200/80 flex flex-col md:flex-row items-center justify-between gap-4">
    <div class="flex items-center gap-3">
        <div class="w-12 h-12 rounded-2xl bg-sky-600 text-white flex items-center justify-center text-xl shrink-0 shadow-md shadow-sky-600/30">
            <i class="fa-solid fa-map-location-dot"></i>
        </div>
        <div>
            <h3 class="font-bold text-slate-800 text-base">Pengaturan Cek Ketersediaan Jaringan (ODP Fiber)</h3>
            <p class="text-xs text-slate-600 mt-0.5">
                Area yang didaftarkan di sini akan otomatis merespons saat calon pelanggan memeriksa wilayahnya melalui tombol <strong>"Cek Area Jangkauan"</strong> di website.
            </p>
        </div>
    </div>
    <button onclick="window.open('../index.php#cakupan', '_blank');" class="btn-rn-primary text-xs py-2.5 px-4 shrink-0 whitespace-nowrap">
        <i class="fa-solid fa-magnifying-glass"></i> Cek Tampilan di Web
    </button>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    
    <!-- Left Column: Form Add / Edit Area (5 Cols) -->
    <div class="lg:col-span-5 bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 shadow-sm sticky top-24">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
            <div class="flex items-center gap-2">
                <i class="fa-solid <?= $editItem ? 'fa-pen-to-square text-sky-600' : 'fa-circle-plus text-ringOrange-500' ?> text-lg"></i>
                <h3 class="font-bold text-slate-900 text-base">
                    <?= $editItem ? 'Edit Wilayah Jangkauan' : 'Tambah Area Jangkauan Baru' ?>
                </h3>
            </div>
            <?php if ($editItem): ?>
                <a href="coverage.php" class="text-xs text-slate-400 hover:text-slate-700">
                    <i class="fa-solid fa-xmark mr-1"></i> Batal Edit
                </a>
            <?php endif; ?>
        </div>

        <form method="POST" action="coverage.php" class="space-y-4">
            <input type="hidden" name="action" value="<?= $editItem ? 'update' : 'create' ?>">
            <?php if ($editItem): ?>
                <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <?php endif; ?>

            <!-- Area Name -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Nama Area / Perumahan / Dusun *
                </label>
                <input type="text" name="area_name" required value="<?= e($editItem['area_name'] ?? '') ?>" placeholder="Misal: Pedukuhan 7 Cerme atau Perumahan Griya Asri" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 outline-none">
                <span class="text-[11px] text-slate-400 mt-0.5 block">Kata kunci yang akan dicari pelanggan saat melakukan cek area.</span>
            </div>

            <!-- Subdistrict & City -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Kecamatan / Kelurahan
                    </label>
                    <input type="text" name="subdistrict" value="<?= e($editItem['subdistrict'] ?? 'Kec. Panjatan') ?>" placeholder="Kec. Panjatan" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-sky-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Kabupaten / Kota
                    </label>
                    <input type="text" name="city" value="<?= e($editItem['city'] ?? 'Kulon Progo') ?>" placeholder="Kulon Progo" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-sky-500 outline-none">
                </div>
            </div>

            <!-- ODP Code & Status -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Kode Tiang ODP
                    </label>
                    <input type="text" name="odp_code" value="<?= e($editItem['odp_code'] ?? '') ?>" placeholder="Misal: ODP-CRM-01" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-sky-500 outline-none font-mono">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Status Jaringan *
                    </label>
                    <select name="status" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-sky-500 outline-none cursor-pointer font-bold">
                        <option value="Tersedia" <?= (!isset($editItem) || $editItem['status'] === 'Tersedia') ? 'selected' : '' ?> class="text-emerald-700">● Tersedia (Ready ODP)</option>
                        <option value="Perluasan" <?= (isset($editItem) && $editItem['status'] === 'Perluasan') ? 'selected' : '' ?> class="text-amber-700">▲ Perluasan (On Progress)</option>
                        <option value="Penuh" <?= (isset($editItem) && $editItem['status'] === 'Penuh') ? 'selected' : '' ?> class="text-red-700">■ Port Penuh (Antrean Splitter)</option>
                    </select>
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Keterangan & Estimasi Waktu Pemasangan
                </label>
                <textarea name="notes" rows="3" placeholder="Contoh: Tiang ODP 16 Port aktif. Instalasi same-day / 1 hari kerja siap." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-sky-500 outline-none resize-none"><?= e($editItem['notes'] ?? '') ?></textarea>
                <span class="text-[11px] text-slate-400">Pesan ini muncul di kotak hasil pencarian calon pelanggan.</span>
            </div>

            <!-- Sort Order -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Urutan Tampil
                </label>
                <input type="number" name="sort_order" value="<?= e($editItem['sort_order'] ?? 1) ?>" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-sky-500 outline-none">
            </div>

            <!-- Is Active -->
            <div class="pt-1">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                    <input type="checkbox" name="is_active" value="1" <?= (!isset($editItem) || $editItem['is_active'] == 1) ? 'checked' : '' ?> class="accent-sky-600 w-4 h-4">
                    <span>Aktifkan area ini untuk pencarian live</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="pt-3">
                <button type="submit" class="w-full btn-rn-primary py-3 text-xs uppercase tracking-wider font-bold shadow-md">
                    <i class="fa-solid <?= $editItem ? 'fa-floppy-disk' : 'fa-plus' ?>"></i>
                    <span><?= $editItem ? 'Simpan Perubahan Area' : 'Terbitkan Area Jangkauan' ?></span>
                </button>
            </div>
        </form>
    </div>

    <!-- Right Column: Coverage Area Table & Filter (7 Cols) -->
    <div class="lg:col-span-7 space-y-5">
        
        <!-- Filter & Search Bar -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 bg-white p-3 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-1.5 text-xs font-bold w-full sm:w-auto overflow-x-auto">
                <a href="coverage.php?filter_status=all" class="px-3 py-1.5 rounded-xl transition <?= $filterStatus === 'all' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100' ?>">
                    Semua
                </a>
                <a href="coverage.php?filter_status=Tersedia" class="px-3 py-1.5 rounded-xl transition <?= $filterStatus === 'Tersedia' ? 'bg-emerald-600 text-white' : 'text-slate-600 hover:bg-slate-100' ?>">
                    ● Tersedia
                </a>
                <a href="coverage.php?filter_status=Perluasan" class="px-3 py-1.5 rounded-xl transition <?= $filterStatus === 'Perluasan' ? 'bg-amber-500 text-white' : 'text-slate-600 hover:bg-slate-100' ?>">
                    ▲ Perluasan
                </a>
                <a href="coverage.php?filter_status=Penuh" class="px-3 py-1.5 rounded-xl transition <?= $filterStatus === 'Penuh' ? 'bg-red-500 text-white' : 'text-slate-600 hover:bg-slate-100' ?>">
                    ■ Penuh
                </a>
            </div>

            <!-- Search input -->
            <form method="GET" action="coverage.php" class="relative w-full sm:w-60">
                <input type="text" name="q" value="<?= e($search) ?>" placeholder="Cari nama area / ODP..." class="w-full pl-8 pr-3 py-1.5 rounded-xl border border-slate-200 text-xs focus:border-sky-500 outline-none">
                <i class="fa-solid fa-magnifying-glass absolute left-2.5 top-2.5 text-slate-400 text-xs pointer-events-none"></i>
            </form>
        </div>

        <!-- Areas Table -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-900 text-base">Daftar Wilayah Jangkauan Fiber</h3>
                    <p class="text-xs text-slate-500">Total <?= count($areas) ?> area terdaftar pada sistem ODP digital.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider border-b border-slate-100 font-semibold">
                        <tr>
                            <th class="py-3 px-4">Area / Wilayah</th>
                            <th class="py-3 px-4">Kode ODP</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Keterangan</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (!empty($areas)): ?>
                            <?php foreach ($areas as $a): ?>
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-3.5 px-4">
                                        <div class="font-bold text-slate-900 text-sm"><?= e($a['area_name']) ?></div>
                                        <div class="text-[11px] text-slate-500 mt-0.5">
                                            <?= e($a['subdistrict'] ?: '-') ?>, <?= e($a['city'] ?: 'Kulon Progo') ?>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-[11px] font-bold text-sky-700">
                                        <?= e($a['odp_code'] ?: '-') ?>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <?php if ($a['status'] === 'Tersedia'): ?>
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                ● Ready ODP
                                            </span>
                                        <?php elseif ($a['status'] === 'Perluasan'): ?>
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                                ▲ Perluasan
                                            </span>
                                        <?php else: ?>
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-800 border border-red-200">
                                                ■ Port Penuh
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600 max-w-xs truncate" title="<?= e($a['notes']) ?>">
                                        <?= e($a['notes'] ?: '-') ?>
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="coverage.php?edit=<?= $a['id'] ?>" class="p-2 rounded-lg bg-sky-50 text-sky-600 hover:bg-sky-100 transition" title="Edit Area">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form method="POST" action="coverage.php" onsubmit="return confirmDelete('Hapus area \'<?= e(addslashes($a['area_name'])) ?>\'?');" class="inline">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?= $a['id'] ?>">
                                                <button type="submit" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition" title="Hapus Area">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">
                                    <i class="fa-solid fa-map-location-dot text-3xl mb-2 block text-slate-300"></i>
                                    Tidak ada area yang cocok dengan pencarian.
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
