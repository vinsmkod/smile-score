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
                {{-- Jujur: AI gagal, skor tetap aman --}}
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
        @if (in_array($education['source'], ['ai', 'rule_based']))
        <div class="space-y-6">

            {{-- Section 1: Pengantar Personal --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#D9EAE4] shadow-sm" data-aos="fade-up">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-[#E6F7F5] text-[#168C83] flex items-center justify-center text-lg flex-shrink-0">🎯</div>
                    <div>
                        <h2 class="text-lg sm:text-xl font-extrabold text-[#183B38]">
                            {{ $education['source'] === 'ai' ? 'Pesan Personal untuk Kamu' : 'Arti Hasil Kamu' }}
                        </h2>
                        <span class="text-xs text-slate-400">Berdasarkan hasil kuesionermu</span>
                    </div>
                </div>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                    {{ $education['introduction'] }}
                </p>
            </div>

            {{-- Section 2: Interpretasi Skor --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#D9EAE4] shadow-sm" data-aos="fade-up">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg flex-shrink-0">📊</div>
                    <div>
                        <h2 class="text-lg sm:text-xl font-extrabold text-[#183B38]">Apa Artinya Hasil Ini?</h2>
                        <span class="text-xs text-slate-400">Penjelasan konteks skor {{ $result['correct_count'] }}/20</span>
                    </div>
                </div>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                    {{ $education['score_interpretation'] }}
                </p>
            </div>

            {{-- Section 3: Topik Prioritas --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#D9EAE4] shadow-sm" data-aos="fade-up">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg flex-shrink-0">💡</div>
                    <div>
                        <h2 class="text-lg sm:text-xl font-extrabold text-[#183B38]">
                            {{ count($result['incorrect_items']) > 0 ? 'Topik yang Perlu Dipelajari' : 'Penguatan Konsep Penting' }}
                        </h2>
                        <p class="text-xs text-slate-400">
                            {{ count($result['incorrect_items']) > 0
                                ? 'Fokus penguatan pada ' . count($education['priority_topics']) . ' topik dari soal yang kurang tepat'
                                : 'Kamu sudah menjawab semua soal dengan benar!' }}
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach ($education['priority_topics'] as $index => $topic)
                        <div class="bg-[#F1FAF6] rounded-2xl p-5 border border-[#D9EAE4] hover:border-[#168C83] transition-colors">
                            <div class="flex items-start gap-3 mb-2">
                                <span class="w-6 h-6 rounded-full bg-[#168C83] text-white text-xs font-extrabold flex items-center justify-center flex-shrink-0 mt-0.5">
                                    {{ $index + 1 }}
                                </span>
                                <div class="flex-1">
                                    <h3 class="font-bold text-sm sm:text-base text-[#183B38]">
                                        {{ $topic['title'] ?? $topic['topic'] ?? 'Topik ' . ($index + 1) }}
                                    </h3>
                                    @if (!empty($topic['relevance']))
                                        <p class="text-[11px] text-[#168C83] font-semibold mt-0.5">
                                            {{ $topic['relevance'] }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed pl-9">
                                {{ $topic['explanation'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Section 4: Poin-Poin Kunci --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#D9EAE4] shadow-sm" data-aos="fade-up">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg flex-shrink-0">📌</div>
                    <div>
                        <h2 class="text-lg sm:text-xl font-extrabold text-[#183B38]">Poin Penting yang Perlu Diingat</h2>
                        <p class="text-xs text-slate-400">Fakta kunci kesehatan gigi & mulut</p>
                    </div>
                </div>
                <ul class="space-y-2.5">
                    @foreach ($education['key_points'] as $point)
                        <li class="flex items-start gap-2.5 text-sm text-slate-700">
                            <span class="w-5 h-5 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center flex-shrink-0 text-xs font-bold mt-0.5">✓</span>
                            <span class="leading-relaxed">{{ $point }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Section 5: Kebiasaan Sehari-hari --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#D9EAE4] shadow-sm" data-aos="fade-up">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg flex-shrink-0">✨</div>
                    <div>
                        <h2 class="text-lg sm:text-xl font-extrabold text-[#183B38]">Kebiasaan Sehat Sehari-hari</h2>
                        <p class="text-xs text-slate-400">Langkah nyata yang dapat diterapkan mulai hari ini</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-3">
                    @foreach ($education['daily_habits'] as $index => $habit)
                        <div class="flex items-start gap-3 p-4 rounded-2xl bg-white border border-slate-100 hover:bg-[#E6F7F5]/50 transition-colors">
                            <div class="w-6 h-6 rounded-full bg-[#DDF5EC] text-[#168C83] text-xs font-extrabold flex items-center justify-center flex-shrink-0 mt-0.5">
                                {{ $index + 1 }}
                            </div>
                            <p class="text-xs sm:text-sm font-medium text-slate-700 leading-relaxed">{{ $habit }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Section 6: Kapan ke Dokter Gigi + Disclaimer --}}
            <div class="bg-gradient-to-r from-[#11665F] to-[#168C83] text-white rounded-3xl p-6 sm:p-8 shadow-lg" data-aos="fade-up">
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-white/15 p-2 flex items-center justify-center flex-shrink-0 backdrop-blur-sm border border-white/20">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div class="space-y-2 text-center sm:text-left flex-grow">
                        <h3 class="text-base sm:text-lg font-bold text-white">Kapan Harus ke Dokter Gigi?</h3>
                        <p class="text-xs sm:text-sm text-[#DDF5EC] leading-relaxed">
                            {{ $education['when_to_seek_care'] }}
                        </p>
                        <p class="text-[11px] text-white/70 italic pt-1">
                            {{ $education['disclaimer'] }}
                        </p>
                    </div>
                </div>
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
