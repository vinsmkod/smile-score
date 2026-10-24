@extends('layouts.app')

@section('title', 'Hasil Smile Score - Skor Kesehatan Gigi & Mulut Kamu')
@section('meta_description', 'Lihat skor, persentase, dan kategori pengetahuan kesehatan gigi dan mulutmu.')

@section('content')
<section class="py-12 md:py-20 bg-gradient-to-b from-[#E6F7F5] via-[#F1FAF6] to-white min-h-[85vh] flex items-center justify-center">
    <div class="max-w-2xl w-full mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Stage Stepper Indicator -->
        <div class="mb-8" data-aos="fade-down">
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-3 sm:p-4 border border-[#D9EAE4] shadow-sm flex items-center justify-between text-xs font-bold">
                <!-- Step 1: Completed -->
                <div class="flex items-center gap-2 text-emerald-600">
                    <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[11px] font-extrabold shadow-sm">
                        ✓
                    </span>
                    <span class="hidden sm:inline">Biodata</span>
                </div>

                <div class="h-0.5 w-6 sm:w-10 bg-emerald-300"></div>

                <!-- Step 2: Completed -->
                <div class="flex items-center gap-2 text-emerald-600">
                    <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[11px] font-extrabold shadow-sm">
                        ✓
                    </span>
                    <span class="hidden sm:inline">Kuesioner 20 Soal</span>
                    <span class="sm:hidden">Kuesioner</span>
                </div>

                <div class="h-0.5 w-6 sm:w-10 bg-emerald-300"></div>

                <!-- Step 3: Active Result -->
                <div class="flex items-center gap-2 text-[#168C83]">
                    <span class="w-6 h-6 rounded-full bg-[#168C83] text-white flex items-center justify-center text-[11px] font-extrabold shadow-sm">
                        03
                    </span>
                    <span>Hasil</span>
                </div>
            </div>
        </div>

        <!-- Main Result Card -->
        <div class="bg-white rounded-4xl p-6 sm:p-10 border border-[#D9EAE4] shadow-xl text-center relative overflow-hidden" data-aos="zoom-in" data-aos-duration="600">

            <!-- Decorative curved gradient behind badge -->
            <div class="absolute -top-16 -left-16 w-48 h-48 bg-[#DDF5EC]/60 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -right-16 w-48 h-48 bg-amber-100/50 rounded-full blur-2xl pointer-events-none"></div>

            <!-- Page / Section Title -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#DDF5EC] text-[#168C83] text-xs font-bold uppercase tracking-wider mb-4">
                <span>✦ Hasil Penilaian Mandiri ✦</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#183B38] tracking-tight mb-2">
                Hasil Smile Score
            </h1>

            <!-- Student Biodata Identity Card -->
            @if(isset($result['student']))
                <div class="block mb-6">
                    <div class="inline-flex flex-wrap items-center justify-center gap-2 px-4 py-2 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs text-slate-600 font-medium">
                        <span class="text-slate-400 font-bold">Responden:</span>
                        <strong class="text-slate-900 font-extrabold">{{ $result['student']['name'] }}</strong>
                        <span class="text-slate-300">&bull;</span>
                        <span>Kelas {{ $result['student']['class_name'] }}</span>
                        <span class="text-slate-300">&bull;</span>
                        <span>{{ $result['student']['age'] }} th ({{ $result['student']['gender'] }})</span>
                    </div>
                </div>
            @endif

            <!-- Decorative tilted tooth outline in corner matching brand identity -->
            <div class="absolute top-4 right-4 sm:top-6 sm:right-6 pointer-events-none select-none opacity-30 transform rotate-12">
                <svg class="w-10 h-11 text-[#168C83]" viewBox="0 0 100 110" fill="none">
                    <path d="M 50 24 C 43 17, 30 15, 20 22 C 10 30, 8 46, 10 62 C 12 77, 18 92, 25 100 C 29 104, 37 103, 41 96 C 45 88, 48 77, 50 77 C 52 77, 55 88, 59 96 C 63 103, 71 104, 75 100 C 82 92, 88 77, 90 62 C 92 46, 90 30, 80 22 C 70 15, 57 17, 50 24 Z" 
                          stroke="currentColor" 
                          stroke-width="5" 
                          stroke-linecap="round" 
                          stroke-linejoin="round"/>
                </svg>
            </div>

            <!-- Large Prominent Emoji Display with subtle organic tilt -->
            <div class="relative inline-block mb-4">
                <div class="w-32 h-32 sm:w-36 sm:h-36 mx-auto rounded-3xl {{ $result['category'] === 'Baik' ? 'bg-emerald-50 border-emerald-200 ring-4 ring-emerald-100' : ($result['category'] === 'Cukup' ? 'bg-amber-50 border-amber-200 ring-4 ring-amber-100' : 'bg-rose-50 border-rose-200 ring-4 ring-rose-100') }} border-2 flex items-center justify-center shadow-md transform -rotate-2 hover:rotate-0 transition-transform duration-300">
                    <span class="text-6xl sm:text-7xl select-none" role="img" aria-label="Emoji Kategori {{ $result['category'] }}">
                        {{ $result['emoji'] }}
                    </span>
                </div>
            </div>

            <!-- Category Name Badge -->
            <div class="mb-6">
                <span class="inline-block px-5 py-2 rounded-full text-base sm:text-lg font-extrabold shadow-sm {{ $result['category'] === 'Baik' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : ($result['category'] === 'Cukup' ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-rose-100 text-rose-800 border border-rose-200') }}">
                    Kategori: {{ $result['category'] }}
                </span>
            </div>

            <!-- Score & Percentage Display Box with responsive subtle tilt -->
            <div class="grid grid-cols-2 gap-4 max-w-sm mx-auto mb-6">
                <!-- Correct Count Box (subtle -rotate-1 on sm screens, neutral on mobile) -->
                <div class="bg-[#F1FAF6] rounded-2xl p-4 border border-[#D9EAE4] transform sm:-rotate-1 sm:hover:rotate-0 transition-transform duration-200 shadow-sm">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">
                        Jawaban Benar
                    </span>
                    <span class="text-2xl sm:text-3xl font-extrabold text-[#168C83]">
                        {{ $result['correct_count'] }} <span class="text-sm font-bold text-slate-400">/ 20</span>
                    </span>
                </div>

                <!-- Percentage Box (subtle rotate-1 on sm screens, neutral on mobile) -->
                <div class="bg-[#F1FAF6] rounded-2xl p-4 border border-[#D9EAE4] transform sm:rotate-1 sm:hover:rotate-0 transition-transform duration-200 shadow-sm">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">
                        Nilai Persentase
                    </span>
                    <span class="text-2xl sm:text-3xl font-extrabold text-[#183B38]">
                        {{ $result['percentage'] }}%
                    </span>
                </div>
            </div>

            <!-- Brief Meaning / Interpretation -->
            <p class="text-slate-600 text-sm sm:text-base leading-relaxed max-w-lg mx-auto mb-8 font-medium">
                {{ $result['interpretation'] }}
            </p>

            <!-- Call to Action: "Lihat Hasil dan Edukasi" -->
            <div class="space-y-3">
                <a href="{{ route('smile-score.education') }}" id="btn-lihat-edukasi"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 rounded-full bg-[#168C83] hover:bg-[#11665F] text-white font-bold text-base shadow-lg shadow-[#168C83]/25 hover:shadow-xl hover:shadow-[#168C83]/35 active:scale-95 transition-all duration-200">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C9.5 2 7.5 3.5 7.5 5.5c0 .7.2 1.4.6 2C6.8 8.1 6 9.4 6 11c0 2.5 1.5 6 3 9.5 1 2.3 2 2.5 3 2.5s2-.2 3-2.5c1.5-3.5 3-7 3-9.5 0-1.6-.8-2.9-2.1-3.5.4-.6.6-1.3.6-2C16.5 3.5 14.5 2 12 2z"/>
                    </svg>
                    <span>Lihat Hasil dan Edukasi</span>
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>

                <!-- Secondary Link: Ulangi Tes -->
                <div class="pt-2">
                    <a href="{{ route('smile-score.start') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-slate-500 hover:text-[#168C83] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span>Ulangi Pengerjaan Tes</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- Research Reference Note -->
        <div class="mt-6 text-center">
            <p class="text-xs text-slate-400">
                Skor dihitung secara objektif berdasarkan standar kuesioner literasi kesehatan gigi SMK Putra Nasional Cibodas.
            </p>
        </div>

    </div>
</section>
@endsection
