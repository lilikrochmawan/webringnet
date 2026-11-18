<?php
require_once __DIR__ . '/../config/helper.php';

$error = '';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = 'Username dan kata sandi wajib diisi.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_name'] = $user['name'];
            $_SESSION['admin_username'] = $user['username'];
            
            header('Location: index.php');
            exit;
        } else {
            $error = 'Username atau kata sandi yang Anda masukkan salah.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengelola | Ring Network</title>
    
    <!-- Favicon Icons (Ring Network Official Emblem) -->
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/apple-touch-icon.png">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-display { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    
    <!-- Background Ambient Glows -->
    <div class="absolute top-10 left-10 w-96 h-96 bg-sky-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-orange-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-md w-full relative z-10">
        
        <!-- Logo Branding -->
        <div class="text-center mb-8">
            <a href="../index.php" class="inline-block bg-white/95 p-3 rounded-2xl shadow-xl shadow-sky-950/80 mb-4 hover:scale-105 transition">
                <img src="../assets/images/logo.png" alt="Ring Network" class="h-10 w-auto" onerror="this.onerror=null; this.src='../assets/images/logo.jpg';">
            </a>
            <h1 class="text-2xl font-bold font-display text-white">Panel Administrasi & Taskbar</h1>
            <p class="text-xs text-sky-300 mt-1">Kelola Layanan, Menu Taskbar, dan Paket Internet</p>
        </div>

        <!-- Login Card -->
        <div class="bg-slate-900/80 backdrop-blur-xl border border-sky-500/30 rounded-3xl p-8 shadow-2xl">
            
            <?php if (!empty($error)): ?>
                <div class="mb-5 p-3.5 rounded-2xl bg-red-500/20 border border-red-500/40 text-red-200 text-xs flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-red-400 text-sm"></i>
                    <span><?= e($error) ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">Username Admin</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-user text-sm"></i>
                        </span>
                        <input type="text" name="username" required value="" class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-950/70 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-none transition" placeholder="Masukkan username admin" autocomplete="username">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </span>
                        <input type="password" name="password" required value="" class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-950/70 border border-slate-700 text-white text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-none transition" placeholder="Masukkan kata sandi" autocomplete="current-password">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-sky-500 via-orange-500 to-amber-500 hover:from-sky-600 hover:to-orange-600 text-white font-bold text-sm shadow-lg shadow-orange-500/30 transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <span>Masuk ke Dashboard</span>
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-800 text-center">
                <a href="../index.php" class="text-xs text-slate-400 hover:text-sky-400 transition flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Website Utama
                </a>
            </div>

        </div>

        <p class="text-[11px] text-slate-500 text-center mt-6">
            &copy; <?= date('Y') ?> Ring Network Security & Telecom Gateway
        </p>

    </div>

</body>
</html>
