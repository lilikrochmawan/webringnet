<?php
$pageTitle = 'Pengaturan Website & Profil';
$pageSubtitle = 'Konfigurasi identitas perusahaan, nomor WhatsApp, email, dan keamanan akun';
require_once __DIR__ . '/../config/helper.php';

// Handle Settings Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // 1. UPDATE COMPANY SETTINGS
    if ($action === 'update_settings') {
        $fields = [
            'company_name', 'company_legal', 'tagline', 'phone', 'whatsapp', 
            'email', 'support_email', 'address', 'operational_hours', 'speed_guarantee'
        ];

        foreach ($fields as $f) {
            $val = trim($_POST[$f] ?? '');
            $stmt = $pdo->prepare("UPDATE settings SET value = ? WHERE key = ?");
            $stmt->execute([$val, $f]);
        }
        setFlash('success', 'Pengaturan website berhasil disimpan.');
        header('Location: settings.php');
        exit;
    }

    // 2. CHANGE PASSWORD
    if ($action === 'change_password') {
        $oldPass = trim($_POST['old_password'] ?? '');
        $newPass = trim($_POST['new_password'] ?? '');
        $confirmPass = trim($_POST['confirm_password'] ?? '');

        if (empty($newPass) || strlen($newPass) < 6) {
            setFlash('danger', 'Kata sandi baru minimal 6 karakter.');
        } elseif ($newPass !== $confirmPass) {
            setFlash('danger', 'Konfirmasi kata sandi baru tidak cocok.');
        } else {
            // Verify current password
            $adminId = $_SESSION['admin_id'] ?? 1;
            $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
            $stmt->execute([$adminId]);
            $currentHash = $stmt->fetchColumn();

            if ($currentHash && password_verify($oldPass, $currentHash)) {
                $newHash = password_hash($newPass, PASSWORD_DEFAULT);
                $upd = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                $upd->execute([$newHash, $adminId]);
                setFlash('success', 'Kata sandi pengelola berhasil diperbarui.');
            } else {
                setFlash('danger', 'Kata sandi lama yang Anda masukkan salah.');
            }
        }
        header('Location: settings.php');
        exit;
    }
}

include __DIR__ . '/includes/admin_header.php';
?>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    
    <!-- Left Column: Company Profile & Contacts (8 Cols) -->
    <div class="lg:col-span-8 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
        <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
            <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-building"></i>
            </div>
            <div>
                <h3 class="font-bold text-slate-900 text-base">Identitas Perusahaan & Kontak</h3>
                <p class="text-xs text-slate-500">Informasi ini otomatis tampil di taskbar header, formulir, dan footer.</p>
            </div>
        </div>

        <form method="POST" action="settings.php" class="space-y-4">
            <input type="hidden" name="action" value="update_settings">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Nama Perusahaan</label>
                    <input type="text" name="company_name" value="<?= e(getSetting('company_name', 'Ring Network')) ?>" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Nama Brand / Usaha</label>
                    <input type="text" name="company_legal" value="<?= e(getSetting('company_legal', 'Ring Network')) ?>" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Tagline Resmi</label>
                <input type="text" name="tagline" value="<?= e(getSetting('tagline', 'Connect • Secure • Empower')) ?>" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Nomor WhatsApp Gateway *</label>
                    <input type="text" name="whatsapp" value="<?= e(getSetting('whatsapp', '6281229342503')) ?>" placeholder="6281229342503" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 outline-none font-mono">
                    <span class="text-[11px] text-slate-400 mt-0.5 block">Format: 628xxxxxxxx (Tanpa spasi / tanda +)</span>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Telepon NOC / Hotline</label>
                    <input type="text" name="phone" value="<?= e(getSetting('phone', '+62 812-2934-2503')) ?>" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Email Sales</label>
                    <input type="email" name="email" value="<?= e(getSetting('email', 'sales@ringnetwork.co.id')) ?>" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Email Support Teknis</label>
                    <input type="email" name="support_email" value="<?= e(getSetting('support_email', 'support@ringnetwork.co.id')) ?>" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Alamat Kantor / NOC</label>
                <textarea name="address" rows="2" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:border-sky-500 outline-none resize-none"><?= e(getSetting('address')) ?></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Jam Operasional</label>
                    <input type="text" name="operational_hours" value="<?= e(getSetting('operational_hours', 'Senin - Minggu: 24 Jam Non-Stop')) ?>" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Jaminan SLA Uptime</label>
                    <input type="text" name="speed_guarantee" value="<?= e(getSetting('speed_guarantee', '99.9% Uptime Guarantee')) ?>" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 outline-none">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="btn-rn-primary text-xs py-3 px-6 uppercase tracking-wider font-bold shadow-md">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Identitas & Kontak</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Right Column: Change Admin Password (4 Cols) -->
    <div class="lg:col-span-4 bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 shadow-sm space-y-6">
        <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
            <div class="w-10 h-10 rounded-xl bg-orange-100 text-ringOrange-500 flex items-center justify-center text-lg">
                <i class="fa-solid fa-lock"></i>
            </div>
            <div>
                <h3 class="font-bold text-slate-900 text-base">Ganti Kata Sandi</h3>
                <p class="text-xs text-slate-500">Amankan akun login pengelola.</p>
            </div>
        </div>

        <form method="POST" action="settings.php" class="space-y-4">
            <input type="hidden" name="action" value="change_password">

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Kata Sandi Saat Ini *</label>
                <input type="password" name="old_password" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Kata Sandi Baru *</label>
                <input type="password" name="new_password" required minlength="6" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 outline-none">
                <span class="text-[11px] text-slate-400">Minimal 6 karakter.</span>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Ulangi Kata Sandi Baru *</label>
                <input type="password" name="confirm_password" required minlength="6" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 outline-none">
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full btn-rn-secondary text-xs py-3 uppercase tracking-wider font-bold shadow-md">
                    <i class="fa-solid fa-key"></i>
                    <span>Perbarui Kata Sandi</span>
                </button>
            </div>
        </form>

        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 text-[11px] text-slate-500 space-y-1">
            <div class="font-bold text-slate-700 flex items-center gap-1">
                <i class="fa-solid fa-shield-halved text-emerald-500"></i> Keamanan Akun:
            </div>
            <p>Gunakan kombinasi huruf, angka, dan simbol untuk keamanan maksimal.</p>
        </div>
    </div>

</div>

<?php include __DIR__ . '/includes/admin_footer.php'; ?>
