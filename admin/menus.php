<?php
$pageTitle = 'Kelola Dropdown Taskbar';
$pageSubtitle = 'Buat dan atur item dropdown menu Layanan pada taskbar / navbar website';
require_once __DIR__ . '/../config/helper.php';

// Handle Add / Edit / Delete Actions
$action = $_POST['action'] ?? $_GET['action'] ?? '';

// DELETE
if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? $_GET['id'] ?? 0);
    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM navbar_menus WHERE id = ?");
        $stmt->execute([$id]);
        setFlash('success', 'Item dropdown menu berhasil dihapus dari taskbar.');
    }
    header('Location: menus.php');
    exit;
}

// TOGGLE STATUS
if ($action === 'toggle_status') {
    $id = (int)($_POST['id'] ?? 0);
    $currentStatus = (int)($_POST['status'] ?? 0);
    $newStatus = $currentStatus === 1 ? 0 : 1;
    $stmt = $pdo->prepare("UPDATE navbar_menus SET is_active = ? WHERE id = ?");
    $stmt->execute([$newStatus, $id]);
    setFlash('success', 'Status menu dropdown berhasil diperbarui.');
    header('Location: menus.php');
    exit;
}

// SAVE (CREATE OR UPDATE)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($action === 'create' || $action === 'update')) {
    $title = trim($_POST['title'] ?? '');
    $url = trim($_POST['url'] ?? '#layanan');
    $icon = trim($_POST['icon'] ?? 'fa-solid fa-link');
    $description = trim($_POST['description'] ?? '');
    $badge = trim($_POST['badge'] ?? '');
    $sortOrder = (int)($_POST['sort_order'] ?? 0);
    $isActive = isset($_POST['is_active']) ? 1 : 0;
    $parentId = 1; // Dropdown "Layanan"

    if (empty($title)) {
        setFlash('danger', 'Nama judul menu wajib diisi.');
    } else {
        if ($action === 'create') {
            $stmt = $pdo->prepare("INSERT INTO navbar_menus (parent_id, title, url, icon, description, badge, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$parentId, $title, $url, $icon, $description, $badge, $sortOrder, $isActive]);
            setFlash('success', "Item dropdown '$title' berhasil ditambahkan ke taskbar!");
        } else {
            $id = (int)$_POST['id'];
            $stmt = $pdo->prepare("UPDATE navbar_menus SET title = ?, url = ?, icon = ?, description = ?, badge = ?, sort_order = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$title, $url, $icon, $description, $badge, $sortOrder, $isActive, $id]);
            setFlash('success', "Item dropdown '$title' berhasil diperbarui.");
        }
        header('Location: menus.php');
        exit;
    }
}

// Fetch edit data if requested
$editItem = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM navbar_menus WHERE id = ?");
    $stmt->execute([$editId]);
    $editItem = $stmt->fetch();
}

// Fetch all menus
$menus = $pdo->query("SELECT * FROM navbar_menus ORDER BY sort_order ASC, id ASC")->fetchAll();

include __DIR__ . '/includes/admin_header.php';
?>

<!-- Info Box -->
<div class="p-5 rounded-3xl bg-gradient-to-r from-orange-50 via-amber-50 to-sky-50 border border-orange-200/80 flex flex-col md:flex-row items-center justify-between gap-4">
    <div class="flex items-center gap-3">
        <div class="w-12 h-12 rounded-2xl bg-ringOrange-500 text-white flex items-center justify-center text-xl shrink-0 shadow-md shadow-orange-500/30">
            <i class="fa-solid fa-layer-group"></i>
        </div>
        <div>
            <h3 class="font-bold text-slate-800 text-base">Pengatur Dropdown Layanan Pada Taskbar</h3>
            <p class="text-xs text-slate-600 mt-0.5">
                Setiap item yang Anda buat atau ubah di halaman ini akan langsung tampil secara realtime pada dropdown menu <strong>"Layanan"</strong> di taskbar utama website!
            </p>
        </div>
    </div>
    <div class="flex items-center gap-2">
        <a href="../index.php" target="_blank" class="btn-rn-primary text-xs py-2.5 px-4 whitespace-nowrap">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Cek Tampilan Taskbar
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    
    <!-- Left Column: Form Add / Edit Dropdown Item (5 Cols) -->
    <div class="lg:col-span-5 bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 shadow-sm sticky top-24">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
            <div class="flex items-center gap-2">
                <i class="fa-solid <?= $editItem ? 'fa-pen-to-square text-sky-600' : 'fa-circle-plus text-ringOrange-500' ?> text-lg"></i>
                <h3 class="font-bold text-slate-900 text-base">
                    <?= $editItem ? 'Edit Item Dropdown' : 'Tambah Dropdown Layanan' ?>
                </h3>
            </div>
            <?php if ($editItem): ?>
                <a href="menus.php" class="text-xs text-slate-400 hover:text-slate-700">
                    <i class="fa-solid fa-xmark mr-1"></i> Batal Edit
                </a>
            <?php endif; ?>
        </div>

        <form method="POST" action="menus.php" class="space-y-4">
            <input type="hidden" name="action" value="<?= $editItem ? 'update' : 'create' ?>">
            <?php if ($editItem): ?>
                <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <?php endif; ?>

            <!-- Title -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Nama / Judul Layanan *
                </label>
                <input type="text" name="title" required value="<?= e($editItem['title'] ?? '') ?>" placeholder="Contoh: Pemasangan CCTV AI Smart" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-100 outline-none transition">
                <span class="text-[11px] text-slate-400 mt-0.5 block">Teks yang muncul sebagai nama item pada taskbar dropdown.</span>
            </div>

            <!-- Target URL / Link -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Link Tujuan (URL / Anchor) *
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-link text-xs"></i>
                    </span>
                    <input type="text" name="url" required value="<?= e($editItem['url'] ?? '#layanan') ?>" placeholder="Contoh: #cctv atau index.php#paket-internet" class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 outline-none font-mono text-xs">
                </div>
                <div class="flex flex-wrap gap-1.5 mt-1.5 text-[10px]">
                    <span class="text-slate-400">Pilihan cepat:</span>
                    <button type="button" onclick="document.querySelector('[name=url]').value='#paket-internet'" class="px-2 py-0.5 bg-slate-100 hover:bg-slate-200 rounded text-slate-600">#paket-internet</button>
                    <button type="button" onclick="document.querySelector('[name=url]').value='#cctv'" class="px-2 py-0.5 bg-slate-100 hover:bg-slate-200 rounded text-slate-600">#cctv</button>
                    <button type="button" onclick="document.querySelector('[name=url]').value='#server'" class="px-2 py-0.5 bg-slate-100 hover:bg-slate-200 rounded text-slate-600">#server</button>
                    <button type="button" onclick="document.querySelector('[name=url]').value='#layanan'" class="px-2 py-0.5 bg-slate-100 hover:bg-slate-200 rounded text-slate-600">#layanan</button>
                </div>
            </div>

            <!-- Icon Selector -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Ikon FontAwesome
                </label>
                <div class="flex items-center gap-2">
                    <div id="icon-preview-box" class="w-10 h-10 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center shrink-0 text-base">
                        <i id="icon-preview" class="<?= e($editItem['icon'] ?? 'fa-solid fa-wifi') ?>"></i>
                    </div>
                    <input type="text" id="icon-input" name="icon" value="<?= e($editItem['icon'] ?? 'fa-solid fa-wifi') ?>" placeholder="fa-solid fa-wifi" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-mono text-xs focus:border-sky-500 outline-none">
                </div>
                <!-- Popular Icon Presets -->
                <div class="flex flex-wrap items-center gap-1.5 mt-2">
                    <span class="text-[10px] text-slate-400">Pilih cepat:</span>
                    <?php
                        $presetIcons = [
                            'fa-solid fa-wifi' => 'WiFi',
                            'fa-solid fa-video' => 'CCTV',
                            'fa-solid fa-server' => 'Server',
                            'fa-solid fa-network-wired' => 'LAN/FO',
                            'fa-solid fa-shield-halved' => 'Keamanan',
                            'fa-solid fa-house-signal' => 'Smart Home',
                            'fa-solid fa-cloud' => 'Cloud',
                            'fa-solid fa-bolt' => 'Speed'
                        ];
                        foreach ($presetIcons as $ico => $label):
                    ?>
                        <button type="button" onclick="document.getElementById('icon-input').value='<?= $ico ?>'; document.getElementById('icon-preview').className='<?= $ico ?>';" class="px-2 py-1 bg-slate-100 hover:bg-sky-100 rounded text-[11px] text-slate-700 flex items-center gap-1 transition">
                            <i class="<?= $ico ?> text-[10px] text-sky-600"></i> <?= $label ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Deskripsi Singkat (Preview Dropdown)
                </label>
                <textarea name="description" rows="2" placeholder="Contoh: Paket internet ultra cepat untuk Home & Residensial" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:border-sky-500 outline-none resize-none"><?= e($editItem['description'] ?? '') ?></textarea>
                <span class="text-[11px] text-slate-400">Deskripsi singkat ini membuat menu dropdown bernuansa modern mega-menu.</span>
            </div>

            <!-- Badge & Sort Order -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Badge / Label (Opsional)
                    </label>
                    <input type="text" name="badge" value="<?= e($editItem['badge'] ?? '') ?>" placeholder="Misal: Populer, Promo, Baru" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-sky-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Urutan Tampil
                    </label>
                    <input type="number" name="sort_order" value="<?= e($editItem['sort_order'] ?? 1) ?>" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:border-sky-500 outline-none">
                </div>
            </div>

            <!-- Status Active Checkbox -->
            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                    <input type="checkbox" name="is_active" value="1" <?= (!isset($editItem) || $editItem['is_active'] == 1) ? 'checked' : '' ?> class="w-4 h-4 rounded text-sky-600 focus:ring-sky-500 accent-sky-600">
                    <span>Tampilkan Menu ini di Dropdown Taskbar Website</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="pt-3">
                <button type="submit" class="w-full btn-rn-primary py-3 text-xs uppercase tracking-wider font-bold shadow-md">
                    <i class="fa-solid <?= $editItem ? 'fa-floppy-disk' : 'fa-plus' ?>"></i>
                    <span><?= $editItem ? 'Simpan Perubahan Dropdown' : 'Tambahkan ke Taskbar Sekarang' ?></span>
                </button>
            </div>
        </form>
    </div>

    <!-- Right Column: Current Taskbar Dropdown Preview & Table (7 Cols) -->
    <div class="lg:col-span-7 space-y-6">
        
        <!-- Live Visual Preview of the Dropdown Card in Taskbar -->
        <div class="bg-slate-900 rounded-3xl p-6 text-white border border-slate-800 shadow-xl">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800 mb-4">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-sky-400">Live Preview Dropdown Taskbar</h4>
                </div>
                <span class="text-[11px] text-slate-400">Tampilan Pengunjung Website</span>
            </div>

            <div class="bg-white rounded-2xl p-4 text-slate-800 shadow-lg border border-sky-100 max-w-sm mx-auto">
                <div class="px-3 py-1.5 bg-gradient-to-r from-sky-50 to-orange-50 rounded-lg mb-2 flex items-center justify-between text-[11px] font-bold text-slate-700 border border-sky-100">
                    <span class="flex items-center gap-1.5 text-sky-600">
                        <i class="fa-solid fa-layer-group"></i> Solusi & Layanan Kami
                    </span>
                    <span class="text-[9px] bg-sky-500 text-white px-1.5 py-0.5 rounded-full">Ring Net</span>
                </div>
                
                <div class="space-y-1.5 max-h-60 overflow-y-auto">
                    <?php foreach ($menus as $m): ?>
                        <?php if ($m['is_active']): ?>
                            <div class="flex items-start gap-2.5 p-2 rounded-xl bg-slate-50 border border-slate-100">
                                <div class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center shrink-0 text-xs">
                                    <i class="<?= e($m['icon']) ?>"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center justify-between">
                                        <div class="font-bold text-xs text-slate-800 truncate"><?= e($m['title']) ?></div>
                                        <?php if (!empty($m['badge'])): ?>
                                            <span class="text-[9px] font-bold px-1.5 py-0.2 rounded bg-ringOrange-100 text-ringOrange-700">
                                                <?= e($m['badge']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-[10px] text-slate-500 truncate"><?= e($m['description'] ?: 'Layanan Ring Network') ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Table of Dropdown Items -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-900 text-base">Daftar Menu Dropdown Layanan</h3>
                    <p class="text-xs text-slate-500">Total <?= count($menus) ?> item menu terdaftar pada taskbar.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider border-b border-slate-100 font-semibold">
                        <tr>
                            <th class="py-3 px-4">Urutan</th>
                            <th class="py-3 px-4">Menu & Ikon</th>
                            <th class="py-3 px-4">Link Tujuan</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (!empty($menus)): ?>
                            <?php foreach ($menus as $menu): ?>
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-3.5 px-4 font-bold text-slate-400">
                                        #<?= e($menu['sort_order']) ?>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center shrink-0">
                                                <i class="<?= e($menu['icon']) ?>"></i>
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-800 text-sm flex items-center gap-1.5">
                                                    <span><?= e($menu['title']) ?></span>
                                                    <?php if (!empty($menu['badge'])): ?>
                                                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-ringOrange-100 text-ringOrange-700 font-bold">
                                                            <?= e($menu['badge']) ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="text-[11px] text-slate-400 truncate max-w-xs">
                                                    <?= e($menu['description'] ?: '-') ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-[11px] text-sky-600">
                                        <?= e($menu['url']) ?>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <form method="POST" action="menus.php" class="inline">
                                            <input type="hidden" name="action" value="toggle_status">
                                            <input type="hidden" name="id" value="<?= $menu['id'] ?>">
                                            <input type="hidden" name="status" value="<?= $menu['is_active'] ?>">
                                            <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-bold transition <?= $menu['is_active'] ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' ?>" title="Klik untuk mengubah status">
                                                <?= $menu['is_active'] ? '● Aktif' : '○ Nonaktif' ?>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="menus.php?edit=<?= $menu['id'] ?>" class="p-2 rounded-lg bg-sky-50 text-sky-600 hover:bg-sky-100 transition" title="Edit Item">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form method="POST" action="menus.php" onsubmit="return confirmDelete('Hapus menu \'<?= e(addslashes($menu['title'])) ?>\' dari dropdown taskbar?');" class="inline">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?= $menu['id'] ?>">
                                                <button type="submit" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition" title="Hapus Menu">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-400">
                                    Belum ada menu dropdown dibuat.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

<script>
    // Live update icon preview on typing
    const iconInput = document.getElementById('icon-input');
    const iconPreview = document.getElementById('icon-preview');
    if (iconInput && iconPreview) {
        iconInput.addEventListener('input', function() {
            iconPreview.className = this.value || 'fa-solid fa-link';
        });
    }
</script>

<?php include __DIR__ . '/includes/admin_footer.php'; ?>
