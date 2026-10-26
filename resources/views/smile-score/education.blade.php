@extends('layouts.app')

@section('title', 'Edukasi Smile Score - Hasil & Tips Kesehatan Gigi Personal')
@section('meta_description', 'Edukasi kesehatan gigi dan mulut yang dipersonalisasi oleh Gemini AI berdasarkan pola jawaban kuesioner Smile Score kamu.')

@section('content')
<section class="py-10 md:py-16 bg-gradient-to-b from-[#E6F7F5] via-[#F1FAF6] to-white min-h-[85vh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 text-sm font-medium">
                <span class="text-xl">✅</span> {{ session('success') }}
            </div>
        @endif
        @if (session('warning'))
            <div class="mb-6 p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-2xl flex items-center gap-3 text-sm font-medium">
                <span class="text-xl">⚠️</span> {{ session('warning') }}
            </div>
        @endif

        {{-- Header Recap Bar --}}
        <div class="bg-white rounded-3xl p-5 sm:p-6 border border-[#D9EAE4] shadow-sm mb-8 flex flex-col sm:flex-row items-center justify-between gap-4" data-aos="fade-down">
            <div class="flex items-center gap-4 text-center sm:text-left">
                <div class="w-16 h-16 rounded-2xl {{ $result['category'] === 'Baik' ? 'bg-emerald-100 text-emerald-800' : ($result['category'] === 'Cukup' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }} flex items-center justify-center text-3xl shadow-sm flex-shrink-0">
                    {{ $result['emoji'] }}
                </div>
                <div>
                    @if(isset($result['student']))
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">
                            Edukasi untuk: <strong class="text-slate-700">{{ $result['student']['name'] }} ({{ $result['student']['class_name'] }})</strong>
                        </span>
                    @else
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Ringkasan Hasilmu</span>
                    @endif
                    <h1 class="text-lg sm:text-xl font-extrabold text-[#183B38]">
                        Kategori {{ $result['category'] }} &bull; {{ $result['correct_count'] }}/20 Benar ({{ $result['percentage'] }}%)
                    </h1>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('smile-score.result') }}" class="px-4 py-2 rounded-full border border-slate-200 text-slate-600 hover:text-[#168C83] hover:border-[#168C83] text-xs font-bold transition-all">
                    Lihat Ringkasan Skor
                </a>
                <a href="{{ route('smile-score.start') }}" class="px-4 py-2 rounded-full bg-[#168C83] hover:bg-[#11665F] text-white text-xs font-bold transition-all shadow-sm">
                    Ulangi Tes
                </a>
            </div>
        </div>

        {{-- AI Source Badge + Honest Status --}}
        <div class="mb-8" data-aos="fade-up">
            @if ($education['source'] === 'ai')
                <div class="bg-gradient-to-r from-teal-50 via-cyan-50 to-blue-50 border border-teal-200 rounded-2xl p-4 flex items-start gap-3 shadow-sm">
                    <span class="text-2xl mt-0.5 flex-shrink-0">✨</span>
                    <div class="flex-1">
                        <strong class="font-extrabold text-[#11665F] text-sm">Dianalisis oleh Gemini AI (Google):</strong>
                        <p class="text-xs text-slate-600 mt-0.5">
                            Materi di bawah disusun secara personal oleh Gemini AI berdasarkan pola jawaban kuesionermu untuk memperkuat pemahaman topik yang perlu ditingkatkan.
                        </p>
                    </div>
                    @isset($education['generated_at'])
                        <span class="text-[10px] text-slate-400 whitespace-nowrap flex-shrink-0 mt-1 hidden sm:block">
                            {{ \Carbon\Carbon::parse($education['generated_at'])->locale('id')->diffForHumans() }}
                        </span>
                    @endisset
                </div>

            @elseif ($education['source'] === 'ai_failed')
                {{-- Status lama ai_failed (tidak lagi diproduksi sistem; hanya ada pada data sebelum pembaruan) --}}
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 shadow-sm" id="ai-failed-banner">
                    <div class="flex items-start gap-3 mb-4">
                        <span class="text-2xl flex-shrink-0">⚠️</span>
                        <div>
                            <strong class="font-extrabold text-amber-800 text-sm block">Edukasi AI Belum Berhasil Dibuat</strong>
                            <p class="text-xs text-amber-700 mt-1 leading-relaxed">
                                Gemini AI dipanggil tetapi tidak berhasil menghasilkan materi edukasi pada saat ini.
                                <strong>Skor dan kategori hasilmu tidak terpengaruh.</strong>
                            </p>
                            @isset($education['error'])
                                <p class="text-[11px] text-amber-600 mt-1 font-mono bg-amber-100 rounded px-2 py-1">
                                    {{ $education['error'] }}
                                </p>
                            @endisset
                        </div>
                    </div>
                    <form method="POST" action="{{ route('smile-score.education.regenerate') }}" class="flex items-center gap-3">
                        @csrf
                        <button type="submit" id="regen-btn"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#168C83] hover:bg-[#11665F] text-white text-xs font-bold transition-all shadow-sm"
                            onclick="this.disabled=true; this.innerHTML='<span>⏳</span> Menghubungi Gemini AI...'">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Coba Buat Edukasi AI Lagi
                        </button>
                        <span class="text-xs text-amber-600">Maks. 3x per sesi</span>
                    </form>
                </div>

            @elseif ($education['source'] === 'rule_based_fallback')
                {{-- Fallback otomatis: AI gagal, edukasi berbasis pedoman ditampilkan sebagai pengganti --}}
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 shadow-sm">
                    <div class="flex items-start gap-3">
                        <span class="text-xl mt-0.5 flex-shrink-0">📚</span>
                        <div class="flex-1">
                            <strong class="font-extrabold text-amber-800 text-sm block">Edukasi Berbasis Pedoman (Mode Cadangan Otomatis):</strong>
                            <p class="text-xs text-amber-700 mt-0.5 leading-relaxed">
                                Gemini AI sedang tidak dapat dihubungi saat ini. Materi edukasi di bawah disusun otomatis berdasarkan pedoman literasi gigi kuesioner penelitian sebagai pengganti sementara.
                                <strong>Skor dan kategori hasilmu tidak terpengaruh.</strong>
                            </p>
                        </div>
                        <form method="POST" action="{{ route('smile-score.education.regenerate') }}" class="flex-shrink-0">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full bg-[#168C83] hover:bg-[#11665F] text-white text-xs font-bold transition-all shadow-sm"
                                onclick="this.disabled=true; this.innerHTML='⏳ Memproses...'">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                Coba AI Lagi
                            </button>
                        </form>
                    </div>
                </div>

            @else
                {{-- Rule-based: jujur bukan Gemini AI --}}
                <div class="bg-[#F1FAF6] border border-[#D9EAE4] rounded-2xl p-4 flex items-center gap-3 text-xs sm:text-sm text-slate-700 shadow-sm">
                    <span class="text-xl">📚</span>
                    <div>
                        <strong class="font-extrabold text-[#168C83]">Edukasi Berbasis Pedoman Medis:</strong>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Disusun berdasarkan pedoman materi kuesioner penelitian literasi gigi SMK Putra Nasional Cibodas. Bukan hasil Gemini AI.
                        </p>
                    </div>
                </div>
            @endif
        </div>

        {{-- ============================================================ --}}
        {{-- KONTEN EDUKASI (AI atau Rule-based) --}}
        {{-- ============================================================ --}}
        {{-- ============================================================ --}}
        {{-- KONTEN EDUKASI (AI atau Rule-based) --}}
        {{-- ============================================================ --}}
        @if (in_array($education['source'], ['ai', 'rule_based', 'rule_based_fallback']))
        <div class="space-y-8">

            {{-- ============================================================ --}}
            {{-- BAGIAN 1: RINGKASAN HASIL & EVALUASI PENGETAHUAN             --}}
            {{-- ============================================================ --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#D9EAE4] shadow-sm relative overflow-hidden" data-aos="fade-up">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-100">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-2xl {{ $result['category'] === 'Baik' ? 'bg-emerald-100 text-emerald-800' : ($result['category'] === 'Cukup' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }} flex items-center justify-center text-2xl flex-shrink-0 shadow-sm">
                            {{ $result['emoji'] }}
                        </div>
                        <div>
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Ringkasan Hasil Evaluasi</span>
                            <h2 class="text-lg sm:text-xl font-extrabold text-[#183B38]">
                                Kategori {{ $result['category'] }} &bull; Skor {{ $result['correct_count'] }}/20 ({{ $result['percentage'] }}%)
                            </h2>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1.5 self-start sm:self-center px-3.5 py-1.5 rounded-full {{ $result['category'] === 'Baik' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($result['category'] === 'Cukup' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-rose-50 text-rose-700 border border-rose-200') }} text-xs font-bold">
                        <span>●</span> {{ $result['category'] === 'Baik' ? 'Tingkat Pengetahuan Tinggi' : ($result['category'] === 'Cukup' ? 'Tingkat Pengetahuan Cukup' : 'Perlu Penguatan Konsep') }}
                    </span>
                </div>

                <!-- Callout Non-Diagnosis -->
                <div class="my-4 p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-start gap-2.5 text-xs text-slate-600 leading-relaxed">
                    <span class="text-base flex-shrink-0">ℹ️</span>
                    <div>
                        <strong class="text-slate-800">Evaluasi Literasi Pengetahuan:</strong>
                        <span> Skor ini mengukur tingkat pemahaman dan wawasan kesehatan gigi dan mulutmu, <em>bukan merupakan diagnosis klinis kondisi fisik gigi atau gusi kamu saat ini</em>.</span>
                    </div>
                </div>

                <!-- Pesan Personal & Interpretasi Hasil -->
                <div class="space-y-3 pt-2 text-sm sm:text-base text-slate-700 leading-relaxed">
                    <p class="font-medium text-[#11665F]">
                        {{ $education['introduction'] }}
                    </p>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed bg-[#F1FAF6] p-4 rounded-2xl border border-[#D9EAE4]">
                        {{ $education['score_interpretation'] }}
                    </p>
                </div>
            </div>

            {{-- ============================================================ --}}
            {{-- BAGIAN 2: MATERI PRIORITAS YANG PERLU DIPAHAMI (MAKS 3-5)    --}}
            {{-- ============================================================ --}}
            <div class="space-y-5" data-aos="fade-up">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#DDF5EC] text-[#168C83] text-xs font-bold uppercase tracking-wider mb-1">
                            <span>💡 Pembelajaran Konsep</span>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-extrabold text-[#183B38]">
                            Materi yang Perlu Dipahami
                        </h2>
                    </div>
                    <span class="text-xs font-bold text-slate-500 bg-white px-3 py-1.5 rounded-full border border-slate-200 self-start sm:self-auto">
                        {{ count($education['priority_topics']) }} Topik Prioritas
                    </span>
                </div>

                <div class="space-y-5">
                    @foreach ($education['priority_topics'] as $index => $topic)
                        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#D9EAE4] shadow-sm hover:border-[#168C83] transition-all duration-200 space-y-4">

                            {{-- Topic Header --}}
                            <div class="flex items-start gap-3.5">
                                <span class="w-8 h-8 rounded-2xl bg-[#168C83] text-white text-xs font-extrabold flex items-center justify-center flex-shrink-0 mt-0.5 shadow-sm">
                                    {{ $index + 1 }}
                                </span>
                                <div class="flex-1">
                                    <h3 class="text-base sm:text-lg font-extrabold text-[#183B38] leading-snug">
                                        {{ $topic['title'] ?? 'Topik ' . ($index + 1) }}
                                    </h3>
                                </div>
                            </div>

                            {{-- 1. Konsep Utama yang Perlu Dipahami --}}
                            <div class="bg-[#E6F7F5] border-l-4 border-[#168C83] rounded-r-2xl p-4">
                                <div class="text-[11px] font-extrabold text-[#11665F] uppercase tracking-wider mb-1 flex items-center gap-1.5">
                                    <span>🎯</span> Konsep yang Perlu Dipahami:
                                </div>
                                <p class="text-xs sm:text-sm font-bold text-[#183B38] leading-relaxed">
                                    {{ $topic['core_concept'] ?? $topic['relevance'] ?? 'Pahami prinsip dasar kesehatan gigi ini.' }}
                                </p>
                            </div>

                            {{-- 2. Penjelasan Sederhana --}}
                            <div class="text-xs sm:text-sm text-slate-600 leading-relaxed pl-1 sm:pl-2">
                                <span class="text-slate-400 font-bold block text-[11px] uppercase tracking-wider mb-1">Penjelasan Singkat:</span>
                                <p class="leading-relaxed">
                                    {{ $topic['explanation'] }}
                                </p>
                            </div>

                            {{-- 3. Situasi Sehari-hari & Hal yang Perlu Diingat (2 Kolom Sub-Card) --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-2">
                                {{-- Contoh Situasi Sehari-hari --}}
                                @if(!empty($topic['daily_context']))
                                    <div class="bg-amber-50/80 rounded-2xl p-4 border border-amber-200/70 space-y-1">
                                        <div class="text-[11px] font-extrabold text-amber-900 uppercase tracking-wider flex items-center gap-1.5">
                                            <span>🎒</span> Situasi Sehari-hari Siswa:
                                        </div>
                                        <p class="text-xs text-amber-950 leading-relaxed font-medium">
                                            {{ $topic['daily_context'] }}
                                        </p>
                                    </div>
                                @endif

                                {{-- Hal yang Perlu Diingat --}}
                                @if(!empty($topic['remember_point']))
                                    <div class="bg-emerald-50/80 rounded-2xl p-4 border border-emerald-200/70 space-y-1 {{ empty($topic['daily_context']) ? 'md:col-span-2' : '' }}">
                                        <div class="text-[11px] font-extrabold text-emerald-900 uppercase tracking-wider flex items-center gap-1.5">
                                            <span>📌</span> Hal yang Perlu Diingat:
                                        </div>
                                        <p class="text-xs text-emerald-950 leading-relaxed font-medium">
                                            {{ $topic['remember_point'] }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ============================================================ --}}
            {{-- BAGIAN 3: KEBIASAAN YANG BISA DITERAPKAN (MAKSIMAL 3)        --}}
            {{-- ============================================================ --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#D9EAE4] shadow-sm space-y-5" data-aos="fade-up">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg flex-shrink-0">
                        ✨
                    </div>
                    <div>
                        <h2 class="text-lg sm:text-xl font-extrabold text-[#183B38]">
                            Kebiasaan Sehat yang Bisa Diterapkan
                        </h2>
                        <p class="text-xs text-slate-400">
                            {{ count($education['daily_habits']) }} tindakan praktis untuk dilakukan dalam kehidupan sehari-hari
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                    @foreach ($education['daily_habits'] as $index => $habit)
                        <div class="flex flex-col justify-between p-4 sm:p-5 rounded-2xl bg-[#F1FAF6] border border-[#D9EAE4] hover:border-[#168C83] transition-colors">
                            <div class="flex items-center justify-between mb-2.5">
                                <span class="w-7 h-7 rounded-xl bg-[#168C83] text-white text-xs font-extrabold flex items-center justify-center shadow-sm">
                                    0{{ $index + 1 }}
                                </span>
                                <span class="text-[10px] font-bold text-[#168C83] uppercase tracking-wider bg-white px-2 py-0.5 rounded-md border border-[#D9EAE4]">
                                    Langkah {{ $index + 1 }}
                                </span>
                            </div>
                            <p class="text-xs sm:text-sm font-medium text-slate-700 leading-relaxed">
                                {{ $habit }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ============================================================ --}}
            {{-- BAGIAN 4: KAPAN PERLU BERKONSULTASI                          --}}
            {{-- ============================================================ --}}
            <div class="bg-gradient-to-r from-[#11665F] via-[#168C83] to-[#1a9b91] text-white rounded-3xl p-6 sm:p-8 shadow-md" data-aos="fade-up">
                <div class="flex flex-col sm:flex-row items-start gap-4 sm:gap-5">
                    <div class="w-12 h-12 rounded-2xl bg-white/15 p-2 flex items-center justify-center flex-shrink-0 backdrop-blur-sm border border-white/20">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div class="space-y-2 flex-grow">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-teal-200 block">Panduan Pemeriksaan Gigi</span>
                        <h3 class="text-base sm:text-lg font-bold text-white leading-snug">
                            Kapan Perlu Berkonsultasi ke Dokter Gigi?
                        </h3>
                        <p class="text-xs sm:text-sm text-[#DDF5EC] leading-relaxed">
                            {{ $education['when_to_seek_care'] }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- ============================================================ --}}
            {{-- BAGIAN 5: PEMBERITAHUAN MEDIS (DISCLAIMER)                   --}}
            {{-- ============================================================ --}}
            <div class="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center text-xs text-slate-500 leading-relaxed space-y-1" data-aos="fade-up">
                <div class="font-bold text-slate-700 flex items-center justify-center gap-1.5 text-xs">
                    <span>🛡️</span> Pemberitahuan Edukasi Literasi
                </div>
                <p class="max-w-2xl mx-auto italic text-[11px] text-slate-500">
                    {{ $education['disclaimer'] }}
                </p>
            </div>

        </div>
        @else
        {{-- AI Failed: show score is safe, no fake content --}}
        <div class="bg-white rounded-3xl p-8 border border-[#D9EAE4] shadow-sm text-center" data-aos="fade-up">
            <div class="text-5xl mb-4">🔄</div>
            <h2 class="text-xl font-extrabold text-[#183B38] mb-2">Materi Edukasi Sedang Disiapkan</h2>
            <p class="text-sm text-slate-500 max-w-md mx-auto mb-6 leading-relaxed">
                Edukasi AI belum berhasil dibuat saat ini. Hasil skor dan kategorimu sudah tersimpan dengan aman.
                Kamu bisa mencoba membuat edukasi AI lagi menggunakan tombol di atas.
            </p>
            <div class="bg-[#F1FAF6] rounded-2xl p-5 border border-[#D9EAE4] text-left max-w-sm mx-auto">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Hasil yang Tersimpan</p>
                <p class="text-2xl font-extrabold text-[#168C83]">{{ $result['correct_count'] }}/20</p>
                <p class="text-sm text-slate-600">Kategori: <strong>{{ $result['category'] }}</strong></p>
                <p class="text-sm text-slate-600">Persentase: <strong>{{ $result['percentage'] }}%</strong></p>
            </div>
        </div>
        @endif

        {{-- Bottom Navigation --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-8" data-aos="fade-up">
            <a href="{{ route('smile-score.start') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full bg-[#168C83] hover:bg-[#11665F] text-white font-bold text-sm shadow-md hover:shadow-lg transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span>Ulangi Tes Smile Score</span>
            </a>
            <a href="{{ route('home') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full bg-white hover:bg-slate-100 text-slate-700 font-bold text-sm border border-slate-200 shadow-sm transition-all">
                <span>Kembali ke Beranda</span>
            </a>
        </div>

    </div>
</section>
@endsection
