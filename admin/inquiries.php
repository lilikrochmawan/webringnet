<?php
$pageTitle = 'Pesanan & Permintaan Survey';
$pageSubtitle = 'Kelola calon pelanggan yang mengirimkan formulir pemesanan & survey';
require_once __DIR__ . '/../config/helper.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// DELETE
if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM inquiries WHERE id = ?");
        $stmt->execute([$id]);
        setFlash('success', 'Data permintaan berhasil dihapus.');
    }
    header('Location: inquiries.php');
    exit;
}

// UPDATE STATUS
if ($action === 'update_status') {
    $id = (int)($_POST['id'] ?? 0);
    $status = trim($_POST['status'] ?? 'Baru');
    $stmt = $pdo->prepare("UPDATE inquiries SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
    setFlash('success', 'Status permintaan berhasil diperbarui.');
    header('Location: inquiries.php');
    exit;
}

// Filter Status
$filterStatus = $_GET['status'] ?? 'all';
if ($filterStatus !== 'all') {
    $stmt = $pdo->prepare("SELECT * FROM inquiries WHERE status = ? ORDER BY id DESC");
    $stmt->execute([$filterStatus]);
    $inquiries = $stmt->fetchAll();
} else {
    $inquiries = $pdo->query("SELECT * FROM inquiries ORDER BY id DESC")->fetchAll();
}

include __DIR__ . '/includes/admin_header.php';
?>

<!-- Filter bar -->
<div class="flex flex-wrap items-center justify-between gap-4 bg-white p-3 rounded-2xl border border-slate-200 shadow-sm">
    <div class="flex items-center gap-1.5 text-xs font-bold">
        <a href="inquiries.php?status=all" class="px-3 py-1.5 rounded-xl transition <?= $filterStatus === 'all' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100' ?>">
            Semua (<?= count($pdo->query("SELECT id FROM inquiries")->fetchAll()) ?>)
        </a>
        <a href="inquiries.php?status=Baru" class="px-3 py-1.5 rounded-xl transition <?= $filterStatus === 'Baru' ? 'bg-emerald-600 text-white' : 'text-slate-600 hover:bg-slate-100' ?>">
            Baru (<?= count($pdo->query("SELECT id FROM inquiries WHERE status='Baru'")->fetchAll()) ?>)
        </a>
        <a href="inquiries.php?status=Dihubungi" class="px-3 py-1.5 rounded-xl transition <?= $filterStatus === 'Dihubungi' ? 'bg-sky-600 text-white' : 'text-slate-600 hover:bg-slate-100' ?>">
            Dihubungi
        </a>
        <a href="inquiries.php?status=Survey" class="px-3 py-1.5 rounded-xl transition <?= $filterStatus === 'Survey' ? 'bg-amber-500 text-white' : 'text-slate-600 hover:bg-slate-100' ?>">
            Survey
        </a>
        <a href="inquiries.php?status=Selesai" class="px-3 py-1.5 rounded-xl transition <?= $filterStatus === 'Selesai' ? 'bg-slate-600 text-white' : 'text-slate-600 hover:bg-slate-100' ?>">
            Selesai
        </a>
    </div>
</div>

<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h3 class="font-bold text-slate-900 text-base">Daftar Formulir Masuk</h3>
            <p class="text-xs text-slate-500">Total <?= count($inquiries) ?> pemesanan tercatat.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider border-b border-slate-100 font-semibold">
                <tr>
                    <th class="py-3 px-6">ID & Waktu</th>
                    <th class="py-3 px-6">Nama & Kontak</th>
                    <th class="py-3 px-6">Paket / Layanan</th>
                    <th class="py-3 px-6">Alamat Pasang</th>
                    <th class="py-3 px-6">Status Progres</th>
                    <th class="py-3 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (!empty($inquiries)): ?>
                    <?php foreach ($inquiries as $inq): ?>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-4 px-6 text-slate-400 font-mono">
                                #RN-<?= $inq['id'] ?>
                                <div class="text-[10px] text-slate-400 font-sans mt-0.5">
                                    <?= date('d M Y, H:i', strtotime($inq['created_at'])) ?>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900 text-sm"><?= e($inq['name']) ?></div>
                                <div class="text-[11px] text-emerald-600 flex items-center gap-1 font-semibold mt-0.5">
                                    <i class="fa-brands fa-whatsapp"></i> <?= e($inq['phone']) ?>
                                </div>
                                <?php if (!empty($inq['email'])): ?>
                                    <div class="text-[10px] text-slate-400"><?= e($inq['email']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-bold text-sky-700 bg-sky-50 px-2.5 py-1 rounded-lg border border-sky-100">
                                    <?= e($inq['package_or_service'] ?: 'Konsultasi Umum') ?>
                                </span>
                                <?php if (!empty($inq['message'])): ?>
                                    <p class="text-[11px] text-slate-500 italic mt-1.5 max-w-xs">"<?= e($inq['message']) ?>"</p>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-6 text-slate-700 max-w-xs">
                                <?= e($inq['address'] ?: '-') ?>
                            </td>
                            <td class="py-4 px-6">
                                <form method="POST" action="inquiries.php" class="inline">
                                    <input type="hidden" name="action" value="update_status">
                                    <input type="hidden" name="id" value="<?= $inq['id'] ?>">
                                    <select name="status" onchange="this.form.submit()" class="px-2.5 py-1 rounded-xl text-xs font-semibold border border-slate-200 outline-none cursor-pointer <?= $inq['status'] === 'Baru' ? 'bg-emerald-50 text-emerald-800 border-emerald-300 font-bold' : ($inq['status'] === 'Survey' ? 'bg-amber-50 text-amber-800 border-amber-300' : 'bg-slate-50 text-slate-700') ?>">
                                        <option value="Baru" <?= $inq['status'] === 'Baru' ? 'selected' : '' ?>>Baru</option>
                                        <option value="Dihubungi" <?= $inq['status'] === 'Dihubungi' ? 'selected' : '' ?>>Dihubungi</option>
                                        <option value="Survey" <?= $inq['status'] === 'Survey' ? 'selected' : '' ?>>Survey</option>
                                        <option value="Selesai" <?= $inq['status'] === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                    </select>
                                </form>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <?php 
                                    $waClean = preg_replace('/[^0-9]/', '', $inq['phone']);
                                    if (substr($waClean, 0, 1) === '0') $waClean = '62' . substr($waClean, 1);
                                    $waReply = "Halo Bapak/Ibu " . $inq['name'] . ", kami dari Ring Network menindaklanjuti permintaan pasang paket " . ($inq['package_or_service'] ?: 'internet') . ". Apakah lokasi Anda siap untuk jadwal survey?";
                                ?>
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="https://wa.me/<?= $waClean ?>?text=<?= rawurlencode($waReply) ?>" target="_blank" class="px-3 py-1.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-semibold flex items-center gap-1 shadow-sm transition">
                                        <i class="fa-brands fa-whatsapp"></i> Chat WA
                                    </a>
                                    <form method="POST" action="inquiries.php" onsubmit="return confirmDelete('Hapus data pesanan ini?');" class="inline">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $inq['id'] ?>">
                                        <button type="submit" class="p-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition" title="Hapus">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            <i class="fa-solid fa-inbox text-4xl mb-2 block text-slate-300"></i>
                            Tidak ada data pesanan pada filter ini.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/includes/admin_footer.php'; ?>
