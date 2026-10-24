<!-- Footer -->
<footer class="bg-white border-t border-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4 text-xs sm:text-sm text-slate-500 text-center font-medium">
            <span class="font-semibold text-slate-700">Smile Score &copy; {{ date('Y') }}</span>
            <span class="hidden sm:inline text-slate-300">&bull;</span>
            <span>Media Edukasi Kesehatan Gigi &amp; Mulut</span>
            <span class="hidden sm:inline text-slate-300">&bull;</span>
            <span class="inline-flex items-center gap-1 text-slate-600 font-medium">
                Untuk Siswa SMK
                <svg class="w-3.5 h-3.5 text-rose-500 fill-current inline" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
            </span>
            <span class="hidden sm:inline text-slate-300">&bull;</span>
            <a href="{{ route('admin.dashboard') }}" class="text-[11px] text-slate-400 hover:text-[#168C83] transition-colors">
                Panel Admin
            </a>
        </div>
    </div>
</footer>
