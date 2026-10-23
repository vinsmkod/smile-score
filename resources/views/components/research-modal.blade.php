<!-- Modal: Tentang Penelitian -->
<div id="researchModal" onclick="if(event.target === this) closeResearchModal()" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300">
    <div class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl p-6 sm:p-8 overflow-hidden border border-slate-100 max-h-[90vh] flex flex-col animate-in fade-in zoom-in-95 duration-200">
        
        <!-- Header -->
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#E6F7F5] text-[#168C83] flex items-center justify-center font-bold text-lg">
                    🔬
                </div>
                <div>
                    <h3 class="text-lg font-extrabold text-navy-900">Tentang Penelitian Smile Score</h3>
                    <p class="text-xs text-slate-500">Pengembangan Media Edukasi Kesehatan Gigi Remaja</p>
                </div>
            </div>
            <button type="button" onclick="closeResearchModal()" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 flex items-center justify-center transition-colors" aria-label="Tutup Modal">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Body Content -->
        <div class="py-5 overflow-y-auto space-y-4 text-sm text-slate-600 leading-relaxed">
            <p>
                <strong>Smile Score</strong> dikembangkan sebagai bagian dari inisiatif riset dan edukasi kesehatan gigi dan mulut yang dikhususkan bagi siswa <strong>Sekolah Menengah Kejuruan (SMK)</strong>.
            </p>

            <div class="bg-[#E6F7F5]/70 rounded-2xl p-4 border border-[#D9EAE4] space-y-2">
                <h4 class="font-bold text-[#183B38] text-xs uppercase tracking-wider text-[#168C83]">Tujuan Penelitian:</h4>
                <ul class="list-disc list-inside space-y-1 text-xs text-slate-700">
                    <li>Mengidentifikasi tingkat pengetahuan &amp; kebiasaan merawat gigi pada kalangan remaja SMK.</li>
                    <li>Menyediakan sarana skrining mandiri yang ramah dan tidak menghakimi.</li>
                    <li>Meningkatkan kesadaran preventif terhadap karies gigi dan kesehatan gusi sejak dini.</li>
                </ul>
            </div>

            <p class="text-xs text-slate-500">
                Setiap data respon yang diinput dalam program Smile Score dijamin kerahasiaannya dan hanya digunakan semata-mata untuk tujuan pengembangan modul edukasi dan ilmiah.
            </p>
        </div>

        <!-- Modal Footer -->
        <div class="pt-4 border-t border-slate-100 flex justify-end">
            <button type="button" onclick="closeResearchModal()" class="px-6 py-2.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold transition-colors">
                Tutup
            </button>
        </div>

    </div>
</div>
