<?php
$pageTitle = 'Kelola Bidang Usaha & Layanan';
$pageSubtitle = 'Kelola layanan utama (Internet, Jaringan, CCTV, Server) dan otomatiskan ke dropdown taskbar';
require_once __DIR__ . '/../config/helper.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// DELETE
if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? $_GET['id'] ?? 0);
    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
        $stmt->execute([$id]);
        setFlash('success', 'Layanan berhasil dihapus.');
    }
    header('Location: services.php');
    exit;
}

// TOGGLE STATUS
if ($action === 'toggle_status') {
    $id = (int)($_POST['id'] ?? 0);
    $currentStatus = (int)($_POST['status'] ?? 0);
    $newStatus = $currentStatus === 1 ? 0 : 1;
    $stmt = $pdo->prepare("UPDATE services SET is_active = ? WHERE id = ?");
    $stmt->execute([$newStatus, $id]);
    setFlash('success', 'Status layanan berhasil diubah.');
    header('Location: services.php');
    exit;
}

// SAVE (CREATE OR UPDATE)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($action === 'create' || $action === 'update')) {
    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? 'general');
    $icon = trim($_POST['icon'] ?? 'fa-solid fa-cube');
    $shortDesc = trim($_POST['short_desc'] ?? '');
    $fullDesc = trim($_POST['full_desc'] ?? '');
    $features = trim($_POST['features'] ?? '');
    $badge = trim($_POST['badge'] ?? '');
    $showInNavbar = isset($_POST['show_in_navbar']) ? 1 : 0;
    $sortOrder = (int)($_POST['sort_order'] ?? 0);
    $isActive = isset($_POST['is_active']) ? 1 : 0;

    // Generate slug
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

    if (empty($title)) {
        setFlash('danger', 'Judul layanan wajib diisi.');
    } else {
        if ($action === 'create') {
            $stmt = $pdo->prepare("INSERT INTO services (title, slug, category, icon, short_desc, full_desc, features, badge, show_in_navbar, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $slug, $category, $icon, $shortDesc, $fullDesc, $features, $badge, $showInNavbar, $sortOrder, $isActive]);
            
            // If user checked "Tampilkan otomatis di dropdown Layanan taskbar", also add to navbar_menus!
            if ($showInNavbar) {
                $targetUrl = '#' . $slug;
                $chk = $pdo->prepare("SELECT COUNT(*) FROM navbar_menus WHERE title = ?");
                $chk->execute([$title]);
                if ($chk->fetchColumn() == 0) {
                    $insNav = $pdo->prepare("INSERT INTO navbar_menus (parent_id, title, url, icon, description, badge, sort_order) VALUES (1, ?, ?, ?, ?, ?, ?)");
                    $insNav->execute([$title, $targetUrl, $icon, $shortDesc, $badge, $sortOrder]);
                }
            }

            setFlash('success', "Layanan '$title' berhasil ditambahkan!");
        } else {
            $id = (int)$_POST['id'];
            $stmt = $pdo->prepare("UPDATE services SET title = ?, category = ?, icon = ?, short_desc = ?, full_desc = ?, features = ?, badge = ?, show_in_navbar = ?, sort_order = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$title, $category, $icon, $shortDesc, $fullDesc, $features, $badge, $showInNavbar, $sortOrder, $isActive, $id]);
            setFlash('success', "Layanan '$title' berhasil diperbarui.");
        }
        header('Location: services.php');
        exit;
    }
}

// Fetch edit item
$editItem = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM services WHERE id = ?");
    $stmt->execute([$editId]);
    $editItem = $stmt->fetch();
}

$services = $pdo->query("SELECT * FROM services ORDER BY sort_order ASC, id ASC")->fetchAll();

include __DIR__ . '/includes/admin_header.php';
?>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    
    <!-- Left Column: Add / Edit Service (5 Cols) -->
    <div class="lg:col-span-5 bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 shadow-sm sticky top-24">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
            <div class="flex items-center gap-2">
                <i class="fa-solid <?= $editItem ? 'fa-pen-to-square text-sky-600' : 'fa-circle-plus text-ringOrange-500' ?> text-lg"></i>
                <h3 class="font-bold text-slate-900 text-base">
                    <?= $editItem ? 'Edit Layanan' : 'Tambah Layanan Usaha Baru' ?>
                </h3>
            </div>
            <?php if ($editItem): ?>
                <a href="services.php" class="text-xs text-slate-400 hover:text-slate-700">
                    <i class="fa-solid fa-xmark mr-1"></i> Batal Edit
                </a>
            <?php endif; ?>
        </div>

        <form method="POST" action="services.php" class="space-y-4">
            <input type="hidden" name="action" value="<?= $editItem ? 'update' : 'create' ?>">
            <?php if ($editItem): ?>
                <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <?php endif; ?>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Nama Layanan *
                </label>
                <input type="text" name="title" required value="<?= e($editItem['title'] ?? '') ?>" placeholder="Misal: Pemasangan CCTV AI Smart" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Ikon FontAwesome
                </label>
                <input type="text" name="icon" value="<?= e($editItem['icon'] ?? 'fa-solid fa-cube') ?>" placeholder="fa-solid fa-wifi / fa-solid fa-video / fa-solid fa-server" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-mono focus:border-sky-500 outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Ringkasan Singkat
                </label>
                <textarea name="short_desc" rows="2" placeholder="Ringkasan 1-2 kalimat untuk kartu depan" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:border-sky-500 outline-none resize-none"><?= e($editItem['short_desc'] ?? '') ?></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Poin Fitur / Spesifikasi (1 baris per poin)
                </label>
                <textarea name="features" rows="3" placeholder="Poin 1&#10;Poin 2&#10;Poin 3" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:border-sky-500 outline-none resize-none font-mono"><?= e($editItem['features'] ?? '') ?></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Badge (Opsional)
                    </label>
                    <input type="text" name="badge" value="<?= e($editItem['badge'] ?? '') ?>" placeholder="Unggulan, Enterprise" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-sky-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Urutan
                    </label>
                    <input type="number" name="sort_order" value="<?= e($editItem['sort_order'] ?? 1) ?>" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-sky-500 outline-none">
                </div>
            </div>

            <!-- Checkbox: Auto Add to Dropdown Taskbar -->
            <div class="p-3 bg-orange-50 rounded-2xl border border-orange-200 space-y-2">
                <label class="flex items-start gap-2.5 cursor-pointer text-xs font-bold text-slate-800">
                    <input type="checkbox" name="show_in_navbar" value="1" <?= (!isset($editItem) || $editItem['show_in_navbar'] == 1) ? 'checked' : '' ?> class="mt-0.5 accent-ringOrange-500 w-4 h-4">
                    <span>Tampilkan otomatis layanan ini di dropdown Layanan taskbar</span>
                </label>
                <p class="text-[11px] text-slate-500 pl-6.5">
                    Jika dicentang, menu ini otomatis ditambahkan ke dropdown taskbar navigasi website.
                </p>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                    <input type="checkbox" name="is_active" value="1" <?= (!isset($editItem) || $editItem['is_active'] == 1) ? 'checked' : '' ?> class="accent-sky-600 w-4 h-4">
                    <span>Layanan ini aktif dan dapat dipesan</span>
                </label>
            </div>

            <div class="pt-3">
                <button type="submit" class="w-full btn-rn-primary py-3 text-xs uppercase tracking-wider font-bold">
                    <i class="fa-solid <?= $editItem ? 'fa-floppy-disk' : 'fa-plus' ?>"></i>
                    <span><?= $editItem ? 'Simpan Perubahan' : 'Terbitkan Layanan' ?></span>
                </button>
            </div>
        </form>
    </div>

    <!-- Right Column: Services Table (7 Cols) -->
    <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900 text-base">Daftar Bidang Usaha Layanan</h3>
                <p class="text-xs text-slate-500">Total <?= count($services) ?> layanan terdaftar.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider border-b border-slate-100 font-semibold">
                    <tr>
                        <th class="py-3 px-4">Urutan</th>
                        <th class="py-3 px-4">Nama Layanan</th>
                        <th class="py-3 px-4">Taskbar Dropdown</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (!empty($services)): ?>
                        <?php foreach ($services as $srv): ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-4 px-4 font-bold text-slate-400">#<?= e($srv['sort_order']) ?></td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center shrink-0">
                                            <i class="<?= e($srv['icon']) ?>"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800 text-sm"><?= e($srv['title']) ?></div>
                                            <p class="text-[11px] text-slate-500 line-clamp-1 max-w-xs"><?= e($srv['short_desc']) ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <?php if ($srv['show_in_navbar']): ?>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-sky-100 text-sky-800">
                                            <i class="fa-solid fa-check text-xs"></i> Ditampilkan
                                        </span>
                                    <?php else: ?>
                                        <span class="text-slate-400 text-[10px]">Tidak</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-4">
                                    <form method="POST" action="services.php" class="inline">
                                        <input type="hidden" name="action" value="toggle_status">
                                        <input type="hidden" name="id" value="<?= $srv['id'] ?>">
                                        <input type="hidden" name="status" value="<?= $srv['is_active'] ?>">
                                        <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-bold transition <?= $srv['is_active'] ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-500' ?>">
                                            <?= $srv['is_active'] ? '● Aktif' : '○ Nonaktif' ?>
                                        </button>
                                    </form>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="services.php?edit=<?= $srv['id'] ?>" class="p-2 rounded-lg bg-sky-50 text-sky-600 hover:bg-sky-100 transition" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form method="POST" action="services.php" onsubmit="return confirmDelete('Hapus layanan \'<?= e(addslashes($srv['title'])) ?>\'?');" class="inline">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= $srv['id'] ?>">
                                            <button type="submit" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition" title="Hapus">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php include __DIR__ . '/includes/admin_footer.php'; ?>
