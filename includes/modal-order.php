<!-- MODAL: ORDER & BOOKING SURVEY PEMASANGAN -->
<div id="orderModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div id="orderModalOverlay" class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm transition-opacity"></div>

    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-sky-100">
            
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-slate-900 via-sky-950 to-slate-900 px-6 py-5 text-white relative">
                <button type="button" id="orderModalClose" class="absolute right-4 top-4 text-slate-400 hover:text-white rounded-full p-1 hover:bg-white/10 transition">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-ringOrange-500 to-ringYellow-400 flex items-center justify-center text-white shadow-lg">
                        <i class="fa-solid fa-bolt text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white" id="modal-title">Formulir Pemasangan Baru</h3>
                        <p class="text-xs text-sky-200">Isi data singkat untuk jadwal survey & aktivasi cepat.</p>
                    </div>
                </div>
            </div>

            <!-- Modal Body Form -->
            <div class="px-6 py-5">
                
                <div id="orderAlert" class="hidden"></div>

                <!-- Selected Package Highlight -->
                <div class="mb-4 p-3 bg-sky-50 border border-sky-100 rounded-2xl flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-sky-600 block">Paket / Layanan Dipilih:</span>
                        <div id="modal_package_name_display" class="font-bold text-slate-800 text-sm">Paket Internet Ring Network</div>
                    </div>
                    <div id="modal_package_details_display" class="flex items-center gap-1">
                        <!-- Speed & FUP Pills injected here via JS -->
                    </div>
                </div>

                <form id="orderForm" class="space-y-3.5">
                    <input type="hidden" name="package_or_service" id="modal_package_input" value="Paket Internet Ring Network">

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap *</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                <i class="fa-regular fa-user text-sm"></i>
                            </span>
                            <input type="text" name="name" required placeholder="Contoh: Budi Santoso" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-100 transition outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nomor WhatsApp Aktif *</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                <i class="fa-brands fa-whatsapp text-sm text-emerald-500"></i>
                            </span>
                            <input type="tel" name="phone" required placeholder="Contoh: 08123456789" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-100 transition outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Alamat Pemasangan / Lokasi *</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                <i class="fa-solid fa-location-dot text-sm text-ringOrange-500"></i>
                            </span>
                            <input type="text" name="address" required placeholder="Nama jalan, perumahan, blok/no rumah, kelurahan" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-100 transition outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Catatan Tambahan (Opsional)</label>
                        <textarea name="message" rows="2" placeholder="Contoh: Butuh penambahan titik CCTV atau router Wi-Fi tambahan di lantai 2" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-100 transition outline-none resize-none"></textarea>
                    </div>

                    <div class="pt-2 flex items-center justify-end gap-2.5">
                        <button type="button" id="orderModalCancel" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold text-xs transition">
                            Batal
                        </button>
                        <button type="submit" id="orderSubmitBtn" class="btn-rn-primary text-xs py-2.5 px-5">
                            <i class="fa-solid fa-paper-plane text-xs"></i>
                            <span>Kirim & Lanjut ke WhatsApp</span>
                        </button>
                    </div>
                </form>

                <p class="text-[11px] text-slate-400 text-center mt-3">
                    <i class="fa-solid fa-shield-halved text-emerald-500"></i> Data Anda aman dan terlindungi bersama Ring Network.
                </p>
            </div>

        </div>
    </div>
</div>

<!-- MODAL: CEK AREA JANGKAUAN -->
<div id="coverageModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="coverage-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm transition-opacity" onclick="document.getElementById('coverageModal').classList.add('hidden');"></div>

    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-sky-100">
            <div class="bg-gradient-to-r from-sky-600 to-sky-700 p-5 text-white flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-satellite-dish text-xl text-ringYellow-300"></i>
                    <h3 class="font-bold text-base">Cek Cakupan Area Fiber Optic</h3>
                </div>
                <button type="button" id="coverageModalClose" class="text-sky-200 hover:text-white">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <div class="p-5 space-y-4">
                <p class="text-xs text-slate-600">
                    Masukkan nama perumahan, cluster, atau nama jalan Anda untuk mengetahui ketersediaan tiang ODP Ring Network.
                </p>
                <div class="relative">
                    <input type="text" id="coverageInput" placeholder="Contoh: Perumahan Grand Harmoni, Blok B" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:border-sky-500 outline-none">
                </div>
                <button type="button" id="coverageCheckBtn" class="w-full btn-rn-secondary text-xs py-2.5">
                    <i class="fa-solid fa-magnifying-glass"></i> Periksa Ketersediaan Jaringan
                </button>
                <div id="coverageResult" class="hidden"></div>
            </div>
        </div>
    </div>
</div>
