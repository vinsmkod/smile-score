@extends('layouts.app')

@section('title', 'Biodata Siswa - Smile Score')
@section('meta_description', 'Lengkapi biodata siswa sebelum memulai kuesioner literasi kesehatan gigi dan mulut Smile Score.')

@section('content')
<section class="py-10 md:py-16 bg-gradient-to-b from-[#E6F7F5] via-[#F1FAF6] to-white min-h-[85vh] flex items-center justify-center">
    <div class="max-w-xl w-full mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Stage Stepper Indicator -->
        <div class="mb-8" data-aos="fade-down">
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-3 sm:p-4 border border-[#D9EAE4] shadow-sm flex items-center justify-between text-xs font-bold">
                <!-- Step 1: Active -->
                <div class="flex items-center gap-2 text-[#168C83]">
                    <span class="w-6 h-6 rounded-full bg-[#168C83] text-white flex items-center justify-center text-[11px] font-extrabold shadow-sm">
                        01
                    </span>
                    <span class="hidden sm:inline">Biodata Siswa</span>
                    <span class="sm:hidden">Biodata</span>
                </div>

                <div class="h-0.5 w-6 sm:w-10 bg-slate-200"></div>

                <!-- Step 2: Next -->
                <div class="flex items-center gap-2 text-slate-400">
                    <span class="w-6 h-6 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center text-[11px] font-extrabold">
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

        <!-- Notification Alert if redirected from protected routes -->
        @if (session('warning'))
            <div class="bg-amber-50 border-l-4 border-amber-500 rounded-2xl p-4 mb-6 shadow-sm" role="alert">
                <div class="flex items-center gap-3">
                    <span class="text-amber-600 text-lg">⚠️</span>
                    <p class="text-xs sm:text-sm text-amber-800 font-medium">
                        {{ session('warning') }}
                    </p>
                </div>
            </div>
        @endif

        @if (session('info'))
            <div class="bg-[#E6F7F5] border-l-4 border-[#168C83] rounded-2xl p-4 mb-6 shadow-sm" role="alert">
                <p class="text-xs sm:text-sm text-[#11665F] font-medium">
                    {{ session('info') }}
                </p>
            </div>
        @endif

        <!-- Biodata Form Card -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-[#D9EAE4] shadow-xl relative overflow-hidden" data-aos="zoom-in" data-aos-duration="500">
            
            <!-- Header Section -->
            <div class="text-center mb-8">
                <div class="w-14 h-14 rounded-2xl bg-[#E6F7F5] text-[#168C83] flex items-center justify-center mx-auto mb-3 border border-[#D9EAE4] shadow-sm">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#183B38] tracking-tight mb-2">
                    Biodata Siswa
                </h1>
                <p class="text-slate-500 text-xs sm:text-sm leading-relaxed max-w-sm mx-auto">
                    Lengkapi biodata berikut sebelum memulai kuesioner Smile Score.
                </p>
            </div>

            <form action="{{ route('smile-score.biodata.save') }}" method="POST" class="space-y-5">
                @csrf

                <!-- A. Nama Lengkap -->
                <div>
                    <label for="name" class="block text-xs sm:text-sm font-bold text-[#183B38] mb-1.5">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $savedBiodata['name'] ?? '') }}"
                           placeholder="Masukkan nama lengkap Anda"
                           required
                           class="w-full px-4 py-3 rounded-2xl border {{ $errors->has('name') ? 'border-rose-400 bg-rose-50/40 ring-2 ring-rose-200' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:outline-none focus:border-[#168C83] focus:bg-white focus:ring-2 focus:ring-[#168C83]/20 transition-all duration-150">
                    @error('name')
                        <p class="text-xs text-rose-600 mt-1.5 font-medium flex items-center gap-1">
                            <span>⚠️</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- B. Usia & D. Kelas (Grid on Desktop) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- B. Usia -->
                    <div>
                        <label for="age" class="block text-xs sm:text-sm font-bold text-[#183B38] mb-1.5">
                            Usia <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number"
                                   id="age"
                                   name="age"
                                   min="12"
                                   max="25"
                                   value="{{ old('age', $savedBiodata['age'] ?? '') }}"
                                   placeholder="Masukkan usia Anda"
                                   required
                                   class="w-full px-4 py-3 rounded-2xl border {{ $errors->has('age') ? 'border-rose-400 bg-rose-50/40 ring-2 ring-rose-200' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:outline-none focus:border-[#168C83] focus:bg-white focus:ring-2 focus:ring-[#168C83]/20 transition-all duration-150">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-semibold text-slate-400 pointer-events-none">
                                Tahun
                            </span>
                        </div>
                        @error('age')
                            <p class="text-xs text-rose-600 mt-1.5 font-medium flex items-center gap-1">
                                <span>⚠️</span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- D. Kelas -->
                    <div>
                        <label for="class_name" class="block text-xs sm:text-sm font-bold text-[#183B38] mb-1.5">
                            Kelas <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               id="class_name"
                               name="class_name"
                               value="{{ old('class_name', $savedBiodata['class_name'] ?? '') }}"
                               placeholder="Masukkan kelas Anda"
                               required
                               class="w-full px-4 py-3 rounded-2xl border {{ $errors->has('class_name') ? 'border-rose-400 bg-rose-50/40 ring-2 ring-rose-200' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:outline-none focus:border-[#168C83] focus:bg-white focus:ring-2 focus:ring-[#168C83]/20 transition-all duration-150">
                        @error('class_name')
                            <p class="text-xs text-rose-600 mt-1.5 font-medium flex items-center gap-1">
                                <span>⚠️</span> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- C. Jenis Kelamin -->
                <div>
                    <label class="block text-xs sm:text-sm font-bold text-[#183B38] mb-2">
                        Jenis Kelamin <span class="text-rose-500">*</span>
                    </label>
                    @php
                        $selectedGender = old('gender', $savedBiodata['gender'] ?? '');
                    @endphp
                    <div class="grid grid-cols-2 gap-3">
                        <!-- Option: Laki-laki -->
                        <label class="gender-card group flex items-center justify-center gap-2.5 p-3.5 rounded-2xl border {{ $selectedGender === 'Laki-laki' ? 'border-[#168C83] bg-[#E6F7F5] ring-2 ring-[#168C83]/20 text-[#168C83]' : 'border-slate-200 bg-slate-50/50 text-slate-700' }} hover:border-[#168C83] hover:bg-[#F1FAF6] cursor-pointer transition-all">
                            <input type="radio"
                                   name="gender"
                                   value="Laki-laki"
                                   class="sr-only"
                                   {{ $selectedGender === 'Laki-laki' ? 'checked' : '' }}
                                   required>
                            <span class="w-4 h-4 rounded-full border {{ $selectedGender === 'Laki-laki' ? 'border-[#168C83] bg-[#168C83]' : 'border-slate-300 bg-white' }} flex items-center justify-center">
                                @if($selectedGender === 'Laki-laki')
                                    <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                @endif
                            </span>
                            <span class="text-xs sm:text-sm font-bold">Laki-laki</span>
                        </label>

                        <!-- Option: Perempuan -->
                        <label class="gender-card group flex items-center justify-center gap-2.5 p-3.5 rounded-2xl border {{ $selectedGender === 'Perempuan' ? 'border-[#168C83] bg-[#E6F7F5] ring-2 ring-[#168C83]/20 text-[#168C83]' : 'border-slate-200 bg-slate-50/50 text-slate-700' }} hover:border-[#168C83] hover:bg-[#F1FAF6] cursor-pointer transition-all">
                            <input type="radio"
                                   name="gender"
                                   value="Perempuan"
                                   class="sr-only"
                                   {{ $selectedGender === 'Perempuan' ? 'checked' : '' }}
                                   required>
                            <span class="w-4 h-4 rounded-full border {{ $selectedGender === 'Perempuan' ? 'border-[#168C83] bg-[#168C83]' : 'border-slate-300 bg-white' }} flex items-center justify-center">
                                @if($selectedGender === 'Perempuan')
                                    <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                @endif
                            </span>
                            <span class="text-xs sm:text-sm font-bold">Perempuan</span>
                        </label>
                    </div>
                    @error('gender')
                        <p class="text-xs text-rose-600 mt-1.5 font-medium flex items-center gap-1">
                            <span>⚠️</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Form Action Buttons -->
                <div class="pt-4 space-y-3">
                    <button type="submit"
                            id="btn-submit-biodata"
                            class="w-full flex items-center justify-center gap-3 px-8 py-3.5 rounded-full bg-[#168C83] hover:bg-[#11665F] text-white font-bold text-sm sm:text-base shadow-lg shadow-[#168C83]/25 hover:shadow-xl hover:shadow-[#168C83]/35 active:scale-95 transition-all duration-200">
                        <span>Lanjutkan ke Kuesioner</span>
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>

                    <a href="{{ route('home') }}"
                       class="w-full flex items-center justify-center gap-2 px-6 py-2.5 rounded-full text-slate-500 hover:text-slate-800 text-xs sm:text-sm font-semibold transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>

            </form>

        </div>

        <!-- Privacy Assurance Note -->
        <div class="mt-6 text-center">
            <p class="text-xs text-slate-400">
                🔒 Data diri Anda hanya digunakan untuk kepentingan penelitian literasi kesehatan gigi SMK Putra Nasional Cibodas dan dijamin kerahasiaannya.
            </p>
        </div>

    </div>
</section>

<!-- Interactive Radio Selection Styling -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const genderRadios = document.querySelectorAll('input[name="gender"]');
        genderRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                document.querySelectorAll('.gender-card').forEach(card => {
                    const r = card.querySelector('input[type="radio"]');
                    const dotWrapper = card.querySelector('span:first-child');
                    if (r && r.checked) {
                        card.classList.add('border-[#168C83]', 'bg-[#E6F7F5]', 'ring-2', 'ring-[#168C83]/20', 'text-[#168C83]');
                        card.classList.remove('border-slate-200', 'bg-slate-50/50', 'text-slate-700');
                        if (dotWrapper) {
                            dotWrapper.className = 'w-4 h-4 rounded-full border border-[#168C83] bg-[#168C83] flex items-center justify-center';
                            dotWrapper.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-white"></span>';
                        }
                    } else if (r) {
                        card.classList.remove('border-[#168C83]', 'bg-[#E6F7F5]', 'ring-2', 'ring-[#168C83]/20', 'text-[#168C83]');
                        card.classList.add('border-slate-200', 'bg-slate-50/50', 'text-slate-700');
                        if (dotWrapper) {
                            dotWrapper.className = 'w-4 h-4 rounded-full border border-slate-300 bg-white flex items-center justify-center';
                            dotWrapper.innerHTML = '';
                        }
                    }
                });
            });
        });
    });
</script>
@endsection
