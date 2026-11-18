<?php
$companyName = getSetting('company_name', 'Ring Network');
$companyLegal = getSetting('company_legal', 'Ring Network');
$tagline = getSetting('tagline', 'Connect • Secure • Empower');
$phone = getSetting('phone', '+62 812-2934-2503');
$email = getSetting('email', 'sales@ringnetwork.co.id');
$supportEmail = getSetting('support_email', 'support@ringnetwork.co.id');
$address = getSetting('address', 'Kantor POP Ring Network: Pedukuhan 7, RT.26/RW.13, Dusun VII, Cerme, Kec. Panjatan, Kabupaten Kulon Progo, Daerah Istimewa Yogyakarta 55655');
$operationalHours = getSetting('operational_hours', 'Senin - Minggu: 24 Jam Non-Stop (NOC & Helpdesk)');
?>

    <!-- Floating WhatsApp Action Button -->
    <a href="<?= e(getWaLink('Halo Ring Network, saya butuh informasi/bantuan teknis.')) ?>" target="_blank" class="fixed bottom-6 right-6 z-40 bg-emerald-500 hover:bg-emerald-600 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-xl shadow-emerald-500/30 hover:scale-110 transition-all duration-300 group" title="Chat WhatsApp Customer Care">
        <i class="fa-brands fa-whatsapp text-2xl group-hover:rotate-12 transition-transform"></i>
        <span class="absolute right-16 bg-slate-900 text-white text-xs font-semibold px-3 py-1.5 rounded-xl whitespace-nowrap shadow-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none hidden sm:block">
            Chat Customer Service
        </span>
    </a>

    <!-- Main Footer -->
    <footer class="bg-slate-950 text-slate-300 relative overflow-hidden border-t border-sky-950">
        <!-- Ambient lighting glow -->
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-96 h-96 bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-12 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 lg:gap-8 pb-12 border-b border-slate-800/80">
                
                <!-- Col 1: Brand & Bio (Span 2) -->
                <div class="lg:col-span-2 space-y-5">
                    <a href="index.php" class="inline-block bg-white/90 p-2.5 rounded-2xl">
                        <img src="assets/images/logo.png" alt="Ring Network" class="h-10 w-auto object-contain" onerror="this.onerror=null; this.src='assets/images/logo.jpg';">
                    </a>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed pr-4">
                        <strong class="text-white"><?= e($companyLegal) ?></strong> adalah penyedia solusi telekomunikasi terintegrasi. Menghadirkan konektivitas internet fiber optic super cepat, penataan instalasi jaringan terstruktur, proteksi CCTV modern berbasis AI, dan infrastruktur server enterprise yang tangguh.
                    </p>
                    <div class="flex items-center gap-2 text-xs text-sky-400 font-semibold tracking-wide">
                        <span class="w-2 h-2 rounded-full bg-ringOrange-500"></span>
                        <?= e($tagline) ?>
                    </div>
                    <div class="flex items-center gap-3 pt-2">
                        <a href="#" class="w-9 h-9 rounded-xl bg-slate-900 hover:bg-sky-500 text-slate-400 hover:text-white flex items-center justify-center transition border border-slate-800">
                            <i class="fa-brands fa-facebook-f text-sm"></i>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-xl bg-slate-900 hover:bg-sky-500 text-slate-400 hover:text-white flex items-center justify-center transition border border-slate-800">
                            <i class="fa-brands fa-instagram text-sm"></i>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-xl bg-slate-900 hover:bg-sky-500 text-slate-400 hover:text-white flex items-center justify-center transition border border-slate-800">
                            <i class="fa-brands fa-linkedin-in text-sm"></i>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-xl bg-slate-900 hover:bg-emerald-500 text-slate-400 hover:text-white flex items-center justify-center transition border border-slate-800">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Layanan Utama -->
                <div class="space-y-4">
                    <h4 class="text-white text-sm font-bold uppercase tracking-wider flex items-center gap-2">
                        <span class="w-1.5 h-3.5 bg-ringOrange-500 rounded-sm"></span>
                        Layanan Kami
                    </h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm text-slate-400">
                        <li>
                            <a href="index.php#paket-internet" class="hover:text-sky-400 transition flex items-center gap-2">
                                <i class="fa-solid fa-angle-right text-[10px] text-sky-500"></i> Internet Fiber Home
                            </a>
                        </li>
                        <li>
                            <a href="index.php#paket-internet" class="hover:text-sky-400 transition flex items-center gap-2">
                                <i class="fa-solid fa-angle-right text-[10px] text-sky-500"></i> Internet Residential (1:1)
                            </a>
                        </li>
                        <li>
                            <a href="index.php#layanan" class="hover:text-sky-400 transition flex items-center gap-2">
                                <i class="fa-solid fa-angle-right text-[10px] text-sky-500"></i> Penarikan Kabel FO & LAN
                            </a>
                        </li>
                        <li>
                            <a href="index.php#cctv" class="hover:text-sky-400 transition flex items-center gap-2">
                                <i class="fa-solid fa-angle-right text-[10px] text-sky-500"></i> Pemasangan CCTV AI Smart
                            </a>
                        </li>
                        <li>
                            <a href="index.php#server" class="hover:text-sky-400 transition flex items-center gap-2">
                                <i class="fa-solid fa-angle-right text-[10px] text-sky-500"></i> Setup Rack & Server Proxmox
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Keunggulan & Fitur -->
                <div class="space-y-4">
                    <h4 class="text-white text-sm font-bold uppercase tracking-wider flex items-center gap-2">
                        <span class="w-1.5 h-3.5 bg-ringYellow-400 rounded-sm"></span>
                        Fitur Unggulan
                    </h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm text-slate-400">
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-emerald-400 text-xs"></i> 100% Tanpa FUP (Bebas Kuota)
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-emerald-400 text-xs"></i> Kecepatan Simetris 1:1
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-emerald-400 text-xs"></i> Router Dual-Band Wi-Fi 6
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-emerald-400 text-xs"></i> SLA Uptime 99.9%
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-emerald-400 text-xs"></i> Teknisi Bersertifikat Resmi
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Kontak & NOC -->
                <div class="space-y-4">
                    <h4 class="text-white text-sm font-bold uppercase tracking-wider flex items-center gap-2">
                        <span class="w-1.5 h-3.5 bg-sky-500 rounded-sm"></span>
                        Hubungi Kami
                    </h4>
                    <div class="space-y-3 text-xs sm:text-sm text-slate-400">
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-location-dot text-ringOrange-500 mt-1"></i>
                            <span><?= e($address) ?></span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-phone text-sky-400"></i>
                            <span><?= e($phone) ?></span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-envelope text-ringYellow-400"></i>
                            <span><?= e($email) ?></span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-clock text-emerald-400 mt-1"></i>
                            <span><?= e($operationalHours) ?></span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright & Legal -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <div>
                    &copy; <?= date('Y') ?> <strong class="text-slate-300"><?= e($companyName) ?></strong>. Seluruh hak cipta dilindungi.
                </div>
                <div class="flex items-center gap-5">
                    <a href="#hero" class="hover:text-slate-300 transition">Beranda</a>
                    <a href="#tentang" class="hover:text-slate-300 transition">Tentang Kami</a>
                    <a href="#kontak" class="hover:text-slate-300 transition">Syarat & Ketentuan</a>
                    <a href="admin/login.php" class="text-slate-400 hover:text-amber-400 transition font-medium">
                        <i class="fa-solid fa-lock text-[10px]"></i> Pengelola
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Included Modals -->
    <?php include __DIR__ . '/modal-order.php'; ?>

    <!-- Main JavaScript -->
    <script src="assets/js/main.js"></script>
</body>
</html>
