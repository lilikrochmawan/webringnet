/**
 * RING NETWORK - Main Frontend Interactive Scripts
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileOverlay = document.getElementById('mobile-overlay');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function () {
            mobileMenu.classList.remove('translate-x-full');
            if (mobileOverlay) mobileOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
    }

    function closeMobileMenu() {
        if (mobileMenu) mobileMenu.classList.add('translate-x-full');
        if (mobileOverlay) mobileOverlay.classList.add('hidden');
        document.body.style.overflow = '';
    }

    if (mobileMenuClose) mobileMenuClose.addEventListener('click', closeMobileMenu);
    if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobileMenu);

    // Close mobile menu on link click
    document.querySelectorAll('#mobile-menu a').forEach(link => {
        link.addEventListener('click', closeMobileMenu);
    });

    // 2. Mobile Dropdown Toggle
    const mobileDropdownBtn = document.getElementById('mobile-dropdown-btn');
    const mobileDropdownMenu = document.getElementById('mobile-dropdown-menu');
    const mobileDropdownIcon = document.getElementById('mobile-dropdown-icon');

    if (mobileDropdownBtn && mobileDropdownMenu) {
        mobileDropdownBtn.addEventListener('click', function () {
            mobileDropdownMenu.classList.toggle('hidden');
            if (mobileDropdownIcon) {
                mobileDropdownIcon.classList.toggle('rotate-180');
            }
        });
    }

    // 3. Package Switching Tabs (Home vs Residential)
    const tabHome = document.getElementById('tab-home-btn');
    const tabResident = document.getElementById('tab-resident-btn');
    const contentHome = document.getElementById('content-packages-home');
    const contentResident = document.getElementById('content-packages-resident');

    if (tabHome && tabResident && contentHome && contentResident) {
        tabHome.addEventListener('click', function () {
            tabHome.classList.add('active');
            tabResident.classList.remove('active');
            contentHome.classList.remove('hidden');
            contentResident.classList.add('hidden');
        });

        tabResident.addEventListener('click', function () {
            tabResident.classList.add('active');
            tabHome.classList.remove('active');
            contentResident.classList.remove('hidden');
            contentHome.classList.add('hidden');
        });
    }

    // 4. Modal Order / Pasang Baru
    const orderModal = document.getElementById('orderModal');
    const orderModalOverlay = document.getElementById('orderModalOverlay');
    const orderModalClose = document.getElementById('orderModalClose');
    const orderModalCancel = document.getElementById('orderModalCancel');
    const inputPackage = document.getElementById('modal_package_input');
    const modalPackageNameDisplay = document.getElementById('modal_package_name_display');
    const modalPackageDetailsDisplay = document.getElementById('modal_package_details_display');

    window.openOrderModal = function (packageName, speed, fup, price) {
        if (!orderModal) return;
        if (inputPackage) inputPackage.value = packageName + (speed ? ' (' + speed + ')' : '');
        if (modalPackageNameDisplay) modalPackageNameDisplay.innerText = packageName;
        if (modalPackageDetailsDisplay) {
            let details = '';
            if (speed) details += '<span class="px-2.5 py-1 bg-sky-100 text-sky-800 rounded-full font-semibold text-xs">' + speed + '</span> ';
            if (fup) details += '<span class="px-2.5 py-1 bg-amber-100 text-amber-800 rounded-full font-semibold text-xs">' + fup + '</span> ';
            if (price) details += '<span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-full font-semibold text-xs">Rp ' + price + '</span>';
            modalPackageDetailsDisplay.innerHTML = details;
        }

        orderModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    function closeOrderModal() {
        if (!orderModal) return;
        orderModal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    if (orderModalClose) orderModalClose.addEventListener('click', closeOrderModal);
    if (orderModalCancel) orderModalCancel.addEventListener('click', closeOrderModal);
    if (orderModalOverlay) orderModalOverlay.addEventListener('click', closeOrderModal);

    // 5. Order Form Submission (AJAX + WhatsApp Redirect option)
    const orderForm = document.getElementById('orderForm');
    const orderSubmitBtn = document.getElementById('orderSubmitBtn');
    const orderAlert = document.getElementById('orderAlert');

    if (orderForm) {
        orderForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const submitBtnText = orderSubmitBtn ? orderSubmitBtn.innerHTML : '';
            if (orderSubmitBtn) {
                orderSubmitBtn.disabled = true;
                orderSubmitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Mengirim Permintaan...';
            }

            const formData = new FormData(orderForm);

            fetch('api/submit_inquiry.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    if (orderAlert) {
                        orderAlert.className = 'p-4 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200 mb-4 block';
                        orderAlert.innerHTML = '<div class="flex items-center gap-2 font-semibold"><i class="fa-solid fa-circle-check text-emerald-600"></i> Berhasil!</div><p class="text-sm mt-1">' + data.message + '</p>';
                    }
                    orderForm.reset();

                    // If whatsapp direct URL returned, offer direct redirect or open WhatsApp in new tab
                    if (data.whatsapp_url) {
                        setTimeout(() => {
                            window.open(data.whatsapp_url, '_blank');
                            closeOrderModal();
                        }, 1200);
                    } else {
                        setTimeout(closeOrderModal, 2500);
                    }
                } else {
                    if (orderAlert) {
                        orderAlert.className = 'p-4 rounded-xl bg-red-50 text-red-800 border border-red-200 mb-4 block';
                        orderAlert.innerHTML = '<div class="flex items-center gap-2 font-semibold"><i class="fa-solid fa-triangle-exclamation text-red-600"></i> Gagal</div><p class="text-sm mt-1">' + (data.message || 'Terjadi kesalahan.') + '</p>';
                    }
                }
            })
            .catch(err => {
                if (orderAlert) {
                    orderAlert.className = 'p-4 rounded-xl bg-red-50 text-red-800 border border-red-200 mb-4 block';
                    orderAlert.innerHTML = 'Gagal menghubungi server. Silakan hubungi langsung via WhatsApp.';
                }
            })
            .finally(() => {
                if (orderSubmitBtn) {
                    orderSubmitBtn.disabled = false;
                    orderSubmitBtn.innerHTML = submitBtnText;
                }
            });
        });
    }

    // 6. Interactive Bandwidth & Speed Calculator
    const calcUsers = document.getElementById('calc-users');
    const calcUsersVal = document.getElementById('calc-users-val');
    const calcStreaming = document.getElementById('calc-streaming');
    const calcGaming = document.getElementById('calc-gaming');
    const calcCctv = document.getElementById('calc-cctv');
    const calcResultSpeed = document.getElementById('calc-result-speed');
    const calcRecommendPkg = document.getElementById('calc-recommend-pkg');

    function calculateRecommendedSpeed() {
        if (!calcUsers || !calcResultSpeed) return;
        const users = parseInt(calcUsers.value || 3);
        if (calcUsersVal) calcUsersVal.innerText = users + ' Perangkat';

        let baseSpeed = users * 8; // approx 8 Mbps per concurrent device

        if (calcStreaming && calcStreaming.checked) baseSpeed += 25; // 4K streaming buffer
        if (calcGaming && calcGaming.checked) baseSpeed += 20; // Low latency priority
        if (calcCctv && calcCctv.checked) baseSpeed += 25; // Multiple CCTV upload streams

        let recSpeed = '50 Mbps';
        let recPkg = 'Ring Home Starter (50 Mbps) - Rp 150.000';

        if (baseSpeed > 130) {
            recSpeed = '200 Mbps';
            recPkg = 'Ring Home Sultan (200 Mbps) - Rp 325.000';
        } else if (baseSpeed > 85) {
            recSpeed = '100 Mbps';
            recPkg = 'Ring Home Ultra (100 Mbps) - Rp 200.000';
        } else if (baseSpeed > 45) {
            recSpeed = '75 Mbps';
            recPkg = 'Ring Home Family (75 Mbps) - Rp 175.000';
        }

        calcResultSpeed.innerText = recSpeed;
        if (calcRecommendPkg) calcRecommendPkg.innerText = recPkg;
    }

    if (calcUsers) {
        calcUsers.addEventListener('input', calculateRecommendedSpeed);
    }
    if (calcStreaming) calcStreaming.addEventListener('change', calculateRecommendedSpeed);
    if (calcGaming) calcGaming.addEventListener('change', calculateRecommendedSpeed);
    if (calcCctv) calcCctv.addEventListener('change', calculateRecommendedSpeed);

    // Initial calc trigger
    calculateRecommendedSpeed();

    // 7. Area Coverage Checker Modal (Integrated with Admin Database API)
    const coverageModal = document.getElementById('coverageModal');
    const coverageBtn = document.getElementById('coverageBtn');
    const coverageModalClose = document.getElementById('coverageModalClose');
    const coverageCheckBtn = document.getElementById('coverageCheckBtn');
    const coverageResult = document.getElementById('coverageResult');
    const coverageInput = document.getElementById('coverageInput');

    window.openCoverageModal = function () {
        if (coverageModal) {
            coverageModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            if (coverageInput) {
                setTimeout(() => coverageInput.focus(), 150);
            }
        }
    };

    if (coverageBtn) {
        coverageBtn.addEventListener('click', window.openCoverageModal);
    }

    if (coverageModalClose) {
        coverageModalClose.addEventListener('click', function () {
            coverageModal.classList.add('hidden');
            document.body.style.overflow = '';
        });
    }

    function executeCoverageCheck() {
        if (!coverageInput || !coverageResult) return;
        const loc = coverageInput.value.trim();
        if (!loc) {
            coverageResult.classList.remove('hidden');
            coverageResult.innerHTML = `
                <div class="p-3 bg-red-50 text-red-700 text-xs rounded-xl border border-red-200 flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Silakan masukkan nama dusun, perumahan, kelurahan, atau kecamatan Anda.</span>
                </div>
            `;
            return;
        }

        const originalBtnText = coverageCheckBtn.innerHTML;
        coverageCheckBtn.disabled = true;
        coverageCheckBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1.5"></i> Memeriksa Tiang ODP...';

        fetch('api/check_coverage.php?query=' + encodeURIComponent(loc))
            .then(res => res.json())
            .then(data => {
                coverageResult.classList.remove('hidden');

                if (data.status === 'found' && data.results && data.results.length > 0) {
                    let html = '<div class="space-y-3">';
                    data.results.forEach(item => {
                        if (item.status === 'Tersedia') {
                            html += `
                                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-start gap-3 text-emerald-950">
                                    <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-sm shrink-0 mt-0.5">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </div>
                                    <div class="flex-1 text-left">
                                        <div class="flex items-center justify-between gap-1">
                                            <div class="font-extrabold text-sm text-emerald-900">${item.area_name}</div>
                                            <span class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-emerald-200/70 text-emerald-900">● ODP READY</span>
                                        </div>
                                        <div class="text-[11px] text-emerald-700 mt-0.5">
                                            ${item.subdistrict ? item.subdistrict + ', ' : ''}${item.city || 'Kulon Progo'}
                                            ${item.odp_code ? ' • Kode: <strong class="font-mono">' + item.odp_code + '</strong>' : ''}
                                        </div>
                                        ${item.notes ? '<p class="text-xs text-emerald-800 mt-2 bg-emerald-100/70 p-2 rounded-xl">' + item.notes + '</p>' : ''}
                                        <button onclick="window.openOrderModal('Pasang Baru - ' + '${item.area_name.replace(/'/g, "\\'")}', '', '', ''); document.getElementById('coverageModal').classList.add('hidden');" class="mt-3 w-full sm:w-auto px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition inline-flex items-center justify-center gap-1.5 shadow-sm">
                                            <i class="fa-solid fa-bolt"></i> Booking Jadwal Pasang di Area Ini
                                        </button>
                                    </div>
                                </div>
                            `;
                        } else if (item.status === 'Perluasan') {
                            html += `
                                <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl flex items-start gap-3 text-amber-950">
                                    <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center text-sm shrink-0 mt-0.5">
                                        <i class="fa-solid fa-clock"></i>
                                    </div>
                                    <div class="flex-1 text-left">
                                        <div class="flex items-center justify-between gap-1">
                                            <div class="font-extrabold text-sm text-amber-900">${item.area_name}</div>
                                            <span class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-amber-200 text-amber-900">▲ TAHAP PERLUASAN</span>
                                        </div>
                                        <div class="text-[11px] text-amber-700 mt-0.5">
                                            ${item.subdistrict ? item.subdistrict + ', ' : ''}${item.city || 'Kulon Progo'}
                                        </div>
                                        ${item.notes ? '<p class="text-xs text-amber-800 mt-2 bg-amber-100/70 p-2 rounded-xl">' + item.notes + '</p>' : ''}
                                        <button onclick="window.openOrderModal('Pre-Order Perluasan - ' + '${item.area_name.replace(/'/g, "\\'")}', '', '', ''); document.getElementById('coverageModal').classList.add('hidden');" class="mt-3 w-full sm:w-auto px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl text-xs transition inline-flex items-center justify-center gap-1.5 shadow-sm">
                                            <i class="fa-solid fa-user-plus"></i> Daftar Antrean Pre-Order
                                        </button>
                                    </div>
                                </div>
                            `;
                        } else {
                            html += `
                                <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl flex items-start gap-3 text-slate-800">
                                    <div class="w-8 h-8 rounded-xl bg-slate-500 text-white flex items-center justify-center text-sm shrink-0 mt-0.5">
                                        <i class="fa-solid fa-server"></i>
                                    </div>
                                    <div class="flex-1 text-left">
                                        <div class="font-extrabold text-sm">${item.area_name} (Port ODP Penuh)</div>
                                        <p class="text-xs text-slate-600 mt-1">${item.notes || 'Port ODP sedang penuh. Silakan hubungi kami untuk pembukaan port baru.'}</p>
                                    </div>
                                </div>
                            `;
                        }
                    });
                    html += '</div>';
                    coverageResult.innerHTML = html;
                } else {
                    // Not found in database
                    const waUrl = data.whatsapp_url || ('https://wa.me/6281229342503?text=' + encodeURIComponent('Halo Ring Network, saya ingin menanyakan ketersediaan jaringan internet untuk area: ' + loc));
                    coverageResult.innerHTML = `
                        <div class="p-4 bg-sky-50 border border-sky-200 rounded-2xl text-left text-sky-950 space-y-2">
                            <div class="flex items-center gap-2 font-bold text-sky-900 text-xs sm:text-sm">
                                <i class="fa-solid fa-circle-question text-sky-600 text-base"></i>
                                <span>Area Belum Terdaftar di Peta ODP Digital</span>
                            </div>
                            <p class="text-xs text-sky-800 leading-relaxed">
                                Wilayah <strong>"${loc}"</strong> belum tercatat otomatis di sistem. Namun tiang kami terus bertambah setiap minggu!
                            </p>
                            <p class="text-[11px] text-slate-500">
                                Hubungi teknisi kami via WhatsApp untuk pengecekan jarak tiang terdekat ke rumah Anda secara manual.
                            </p>
                            <div class="pt-1 flex flex-col sm:flex-row gap-2">
                                <a href="${waUrl}" target="_blank" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition inline-flex items-center justify-center gap-1.5 shadow-sm">
                                    <i class="fa-brands fa-whatsapp text-sm"></i> Cek Manual via WhatsApp
                                </a>
                                <button onclick="window.openOrderModal('Permintaan Survey Area Baru - ' + '${loc.replace(/'/g, "\\'")}', '', '', ''); document.getElementById('coverageModal').classList.add('hidden');" class="px-3.5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-xl text-xs transition">
                                    Ajukan Survey Lapangan
                                </button>
                            </div>
                        </div>
                    `;
                }
            })
            .catch(err => {
                coverageResult.classList.remove('hidden');
                coverageResult.innerHTML = `
                    <div class="p-3 bg-red-50 text-red-700 text-xs rounded-xl border border-red-200 text-left">
                        Gagal memeriksa jangkauan. Silakan coba lagi atau hubungi langsung via WhatsApp.
                    </div>
                `;
            })
            .finally(() => {
                coverageCheckBtn.disabled = false;
                coverageCheckBtn.innerHTML = originalBtnText;
            });
    }

    if (coverageCheckBtn) {
        coverageCheckBtn.addEventListener('click', executeCoverageCheck);
    }

    if (coverageInput) {
        coverageInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                executeCoverageCheck();
            }
        });
    }
});
