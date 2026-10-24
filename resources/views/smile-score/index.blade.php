@extends('layouts.app')

@section('title', 'Kuesioner Smile Score - 20 Soal Literasi Kesehatan Gigi')
@section('meta_description', 'Kuesioner 20 soal pengetahuan kesehatan gigi dan mulut untuk siswa SMK.')

@section('content')
<section class="py-10 md:py-14 bg-gradient-to-b from-[#E6F7F5] via-[#F1FAF6] to-white min-h-[85vh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Stage Stepper Indicator -->
        <div class="mb-8" data-aos="fade-down">
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-3 sm:p-4 border border-[#D9EAE4] shadow-sm flex items-center justify-between text-xs font-bold">
                <!-- Step 1: Completed -->
                <a href="{{ route('smile-score.start') }}" class="flex items-center gap-2 text-emerald-600 hover:text-emerald-700 transition-colors">
                    <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[11px] font-extrabold shadow-sm">
                        ✓
                    </span>
                    <span class="hidden sm:inline">Biodata: {{ Str::limit($biodata['name'] ?? 'Siswa', 15) }}</span>
                    <span class="sm:hidden">Biodata</span>
                </a>

                <div class="h-0.5 w-6 sm:w-10 bg-emerald-300"></div>

                <!-- Step 2: Active -->
                <div class="flex items-center gap-2 text-[#168C83]">
                    <span class="w-6 h-6 rounded-full bg-[#168C83] text-white flex items-center justify-center text-[11px] font-extrabold shadow-sm">
                        02
                    </span>
                    <span class="hidden sm:inline">Kuesioner 20 Soal</span>
                    <span class="sm:hidden">Kuesioner</span>
                </div>

                <div class="h-0.5 w-6 sm:w-10 bg-slate-200"></div>

                <!-- Step 3: Result -->
                <div class="flex items-center gap-2 text-slate-400">
                    <span class="w-6 h-6 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center text-[11px] font-extrabold">
                        03
                    </span>
                    <span>Hasil</span>
                </div>
            </div>
        </div>

        <!-- Student Profile Summary Card -->
        @if(isset($biodata))
            <div class="bg-white rounded-2xl p-4 border border-[#D9EAE4] shadow-sm mb-6 flex flex-wrap items-center justify-between gap-3 text-xs sm:text-sm" data-aos="fade-up">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-[#E6F7F5] text-[#168C83] flex items-center justify-center font-bold">
                        👤
                    </div>
                    <div>
                        <span class="text-slate-400 text-[11px] uppercase tracking-wider block font-bold">Siswa Responden:</span>
                        <strong class="text-[#183B38] font-extrabold">{{ $biodata['name'] }}</strong>
                        <span class="text-slate-400">&bull;</span>
                        <span class="text-slate-600 font-medium">Kelas {{ $biodata['class_name'] }}</span>
                        <span class="text-slate-400">&bull;</span>
                        <span class="text-slate-500">{{ $biodata['age'] }} th ({{ $biodata['gender'] }})</span>
                    </div>
                </div>

                <a href="{{ route('smile-score.start') }}" class="text-xs font-semibold text-[#168C83] hover:underline flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    <span>Ubah Biodata</span>
                </a>
            </div>
        @endif

        <!-- Header Card -->
        <div class="text-center max-w-2xl mx-auto mb-8" data-aos="fade-down">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#DDF5EC] text-[#168C83] text-xs font-bold uppercase tracking-wider mb-3">
                <span>📝 Kuesioner Penelitian Literasi Gigi</span>
            </div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-[#183B38] tracking-tight mb-2">
                Ukur <span class="text-[#168C83]">Smile Score</span> Kamu
            </h1>
            <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                Jawablah <strong>20 pertanyaan</strong> pilihan ganda di bawah ini dengan memilih satu jawaban yang paling tepat menurutmu.
            </p>
        </div>

        <!-- Sticky Floating Progress Tracker -->
        <div class="sticky top-20 z-40 bg-white/95 backdrop-blur-md rounded-2xl p-4 mb-8 border border-[#D9EAE4] shadow-md transition-all">
            <div class="flex items-center justify-between text-xs sm:text-sm font-bold text-slate-700 mb-2">
                <span class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#168C83] animate-pulse"></span>
                    <span>Progres Pengisian:</span>
                </span>
                <span id="progress-text" class="text-[#168C83] font-extrabold">0 / 20 Soal Terjawab</span>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden p-0.5">
                <div id="progress-bar" class="bg-gradient-to-r from-[#2AAB9A] to-[#168C83] h-full rounded-full transition-all duration-300 w-0"></div>
            </div>
        </div>

        <!-- Validation Error Alert -->
        @if ($errors->any())
            <div class="bg-rose-50 border-l-4 border-rose-500 rounded-xl p-4 mb-8 shadow-sm animate-shake" role="alert">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-rose-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div>
                        <h2 class="text-sm font-bold text-rose-800">Mohon lengkapi seluruh pertanyaan</h2>
                        <p class="text-xs text-rose-700 mt-1">
                            Seluruh 20 pertanyaan wajib dijawab agar perhitungan Smile Score akurat dan valid untuk penelitian.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Questionnaire Form -->
        <form action="{{ route('smile-score.submit') }}" method="POST" id="questionnaire-form">
            @csrf

            <div class="space-y-6">
                @foreach ($questions as $q)
                    @php
                        $qId = $q['id'];
                        $hasError = $errors->has("answers.{$qId}");
                        $oldVal = old("answers.{$qId}");
                    @endphp

                    <div id="card-question-{{ $qId }}" class="bg-white rounded-3xl p-6 sm:p-7 border {{ $hasError ? 'border-rose-400 ring-2 ring-rose-100' : 'border-[#D9EAE4]' }} shadow-sm hover:shadow-md transition-shadow">
                        <!-- Question Header -->
                        <div class="flex items-start gap-3.5 mb-4">
                            <span class="flex-shrink-0 w-8 h-8 rounded-xl bg-[#E6F7F5] text-[#168C83] font-extrabold text-sm flex items-center justify-center border border-[#D9EAE4]">
                                {{ $qId }}
                            </span>
                            <div class="flex-grow">
                                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">
                                    Topik: {{ $q['topic'] }}
                                </span>
                                <h3 class="text-base sm:text-lg font-bold text-[#183B38] leading-snug">
                                    {{ $q['question'] }}
                                </h3>
                            </div>
                        </div>

                        <!-- Answer Options -->
                        <div class="grid grid-cols-1 gap-2.5 sm:gap-3 pl-0 sm:pl-11">
                            @foreach ($q['options'] as $key => $optionText)
                                @php
                                    $isSelected = ($oldVal === $key);
                                @endphp
                                <label class="option-label group flex items-center gap-3.5 p-3.5 sm:p-4 rounded-2xl border border-slate-200 hover:border-[#168C83] hover:bg-[#F1FAF6] cursor-pointer transition-all duration-150 select-none {{ $isSelected ? 'border-[#168C83] bg-[#E6F7F5] ring-2 ring-[#168C83]/20' : 'bg-white' }}">
                                    <input type="radio"
                                           name="answers[{{ $qId }}]"
                                           value="{{ $key }}"
                                           class="sr-only option-radio"
                                           data-question="{{ $qId }}"
                                           {{ $isSelected ? 'checked' : '' }}
                                           required>
                                    
                                    <!-- Custom Radio Indicator with Letter (a, b, c, d) -->
                                    <span class="radio-badge flex-shrink-0 w-7 h-7 rounded-xl flex items-center justify-center text-xs font-bold uppercase transition-all {{ $isSelected ? 'bg-[#168C83] text-white shadow-sm' : 'bg-slate-100 text-slate-600 group-hover:bg-[#DDF5EC] group-hover:text-[#168C83]' }}">
                                        {{ $key }}
                                    </span>

                                    <!-- Option Text -->
                                    <span class="option-text text-xs sm:text-sm text-slate-700 group-hover:text-slate-900 font-medium leading-relaxed">
                                        {{ $optionText }}
                                    </span>
                                </label>
                            @endforeach
                        </div>

                        @if ($hasError)
                            <p class="text-xs text-rose-600 mt-2 pl-0 sm:pl-11 font-medium flex items-center gap-1">
                                <span>⚠️</span> {{ $errors->first("answers.{$qId}") }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Bottom Action Panel -->
            <div class="mt-10 p-6 sm:p-8 bg-white rounded-3xl border border-[#D9EAE4] shadow-lg text-center" data-aos="fade-up">
                <div class="max-w-md mx-auto space-y-3 mb-6">
                    <h3 class="text-base sm:text-lg font-bold text-[#183B38]">
                        Sudah Menjawab Semua Pertanyaan?
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500">
                        Pastikan seluruh 20 pertanyaan sudah terisi sebelum menekan tombol kirim di bawah. Sistem akan langsung menghitung hasil Smile Score kamu!
                    </p>
                </div>

                <button type="submit" id="submit-btn" class="inline-flex items-center gap-3 px-10 py-4 rounded-full bg-[#168C83] hover:bg-[#11665F] text-white font-bold text-base shadow-lg shadow-[#168C83]/25 hover:shadow-xl hover:shadow-[#168C83]/35 active:scale-95 transition-all duration-200">
                    <!-- Smiling Tooth / Sparkle Icon -->
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C9.5 2 7.5 3.5 7.5 5.5c0 .7.2 1.4.6 2C6.8 8.1 6 9.4 6 11c0 2.5 1.5 6 3 9.5 1 2.3 2 2.5 3 2.5s2-.2 3-2.5c1.5-3.5 3-7 3-9.5 0-1.6-.8-2.9-2.1-3.5.4-.6.6-1.3.6-2C16.5 3.5 14.5 2 12 2z"/>
                    </svg>
                    <span>Selesai &amp; Hitung Smile Score</span>
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>
        </form>

    </div>
</section>

<!-- Interactive Script for Realtime Radio Styling & Progress Tracking -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const radios = document.querySelectorAll('.option-radio');
        const progressBar = document.getElementById('progress-bar');
        const progressText = document.getElementById('progress-text');
        const totalQuestions = 20;

        function updateProgress() {
            const answeredQuestions = new Set();
            radios.forEach(radio => {
                if (radio.checked) {
                    answeredQuestions.add(radio.getAttribute('data-question'));
                }
            });

            const count = answeredQuestions.size;
            const pct = Math.round((count / totalQuestions) * 100);

            if (progressBar) progressBar.style.width = pct + '%';
            if (progressText) {
                progressText.textContent = `${count} / ${totalQuestions} Soal Terjawab (${pct}%)`;
                if (count === totalQuestions) {
                    progressText.classList.remove('text-[#168C83]');
                    progressText.classList.add('text-emerald-600');
                    progressText.innerHTML = `✓ Lengkap! ${count} / ${totalQuestions} Soal Terjawab`;
                }
            }
        }

        function refreshCardVisuals() {
            document.querySelectorAll('.option-label').forEach(label => {
                const radio = label.querySelector('.option-radio');
                const badge = label.querySelector('.radio-badge');
                if (radio && radio.checked) {
                    label.classList.add('border-[#168C83]', 'bg-[#E6F7F5]', 'ring-2', 'ring-[#168C83]/20');
                    label.classList.remove('border-slate-200', 'bg-white');
                    if (badge) {
                        badge.classList.add('bg-[#168C83]', 'text-white', 'shadow-sm');
                        badge.classList.remove('bg-slate-100', 'text-slate-600');
                    }
                } else if (radio) {
                    label.classList.remove('border-[#168C83]', 'bg-[#E6F7F5]', 'ring-2', 'ring-[#168C83]/20');
                    label.classList.add('border-slate-200', 'bg-white');
                    if (badge) {
                        badge.classList.remove('bg-[#168C83]', 'text-white', 'shadow-sm');
                        badge.classList.add('bg-slate-100', 'text-slate-600');
                    }
                }
            });
        }

        radios.forEach(radio => {
            radio.addEventListener('change', () => {
                refreshCardVisuals();
                updateProgress();
            });
        });

        // Initialize state
        refreshCardVisuals();
        updateProgress();
    });
</script>
@endsection
