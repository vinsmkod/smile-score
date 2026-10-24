@extends('layouts.app')

@section('title', 'Smile Score - Sehat Gigi, Senyum Percaya Diri')
@section('meta_description', 'Kenali kesehatan gigi dan mulutmu dengan Smile Score. Media edukasi digital ramah untuk siswa SMK.')

@section('content')

<!-- HERO SECTION -->
<section id="beranda" class="relative pt-6 pb-16 md:pt-10 md:pb-24 overflow-hidden bg-gradient-to-b from-[#DDF5EC] via-[#E6F7F5] to-[#F1FAF6]">

    <!-- Subtle Organic Curved Blobs in Background -->
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-[#DDF5EC]/60 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/3 -left-20 w-80 h-80 bg-[#E6F7F5]/50 rounded-full blur-2xl pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-8 items-center">

            <!-- Left Column: Headline, Description & CTA Button -->
            <div class="lg:col-span-6 space-y-6 text-center lg:text-left" data-aos="fade-right" data-aos-duration="700">

                <!-- Badge: Media Edukasi Berbasis AI -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#D4F4E7]/80 border border-[#A8E6D7] text-[#11665F] text-xs sm:text-sm font-semibold shadow-sm">
                    <span class="text-amber-400 text-sm">✦</span>
                    <span>Media Edukasi Kesehatan Gigi dan Mulut Berbasis AI</span>
                </div>

                <!-- Main Headline with curved smile accent -->
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-[1.18]">
                    Kenali Kesehatan<br>
                    Gigi dan Mulutmu dengan<br>
                    <span class="text-[#168C83] smile-underline inline-block mt-1">Smile Score</span>
                    <span class="text-amber-400 text-2xl sm:text-3xl inline-block -translate-y-2">✦</span>
                </h1>

                <!-- Description -->
                <p class="text-slate-600 text-sm sm:text-base md:text-[17px] leading-relaxed max-w-xl mx-auto lg:mx-0">
                    Smile Score adalah media edukasi berbasis Artificial Intelligence yang membantu kamu menilai kondisi kesehatan gigi dan mulut melalui jawaban dari 20 pertanyaan, lalu memberikan skor, kategori hasil, edukasi, dan saran yang sesuai dengan kondisi kamu.
                </p>

                <!-- CTA Pill Button & Quick Access Info -->
                <div class="pt-1 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 sm:gap-6">
                    <a href="{{ route('smile-score.start') }}"
                        class="inline-flex items-center gap-3 px-8 py-3.5 rounded-full bg-[#168C83] hover:bg-[#11665F] text-white font-bold text-base shadow-lg shadow-[#168C83]/25 hover:shadow-xl hover:shadow-[#168C83]/35 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                        <!-- White Tooth Icon -->
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C9.5 2 7.5 3.5 7.5 5.5c0 .7.2 1.4.6 2C6.8 8.1 6 9.4 6 11c0 2.5 1.5 6 3 9.5 1 2.3 2 2.5 3 2.5s2-.2 3-2.5c1.5-3.5 3-7 3-9.5 0-1.6-.8-2.9-2.1-3.5.4-.6.6-1.3.6-2C16.5 3.5 14.5 2 12 2z" />
                        </svg>
                        <span>Mulai Smile Score</span>
                        <svg class="w-4 h-4 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>

                    <!-- Time & Accessibility Badge -->
                    <div class="flex items-center gap-2.5 text-slate-500 text-xs sm:text-sm font-medium text-left">
                        <div class="w-8 h-8 rounded-full bg-white/80 border border-[#D9EAE4] flex items-center justify-center text-[#168C83] shadow-sm flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9" stroke-width="2" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7v5l3 2" />
                            </svg>
                        </div>
                        <span class="leading-tight">Mudah, cepat,<br class="hidden sm:inline"> dan bisa diakses kapan saja!</span>
                    </div>
                </div>

            </div>

            <!-- Right Column: Hero Photo with Organic Backdrop & Dental Elements -->
            <div class="lg:col-span-6 flex justify-center lg:justify-end" data-aos="fade-left" data-aos-duration="700">
                <div class="relative w-full max-w-lg">

                    <!-- Organic Mint Backdrop Shape matching reference -->
                    <div class="absolute -top-5 -right-5 w-[104%] h-[104%] bg-[#C4EFE0]/70 rounded-[44px] transform rotate-2 pointer-events-none -z-10"></div>
                    <div class="absolute -bottom-6 -left-6 w-36 h-36 bg-[#DDF5EC]/80 rounded-full blur-2xl pointer-events-none -z-10"></div>

                    <!-- Top-Right Accent Rays radiating outward matching reference -->
                    <div class="absolute -top-5 -right-3 sm:-top-6 sm:-right-4 pointer-events-none select-none text-[#0E6754]">
                        <svg class="w-10 h-10 sm:w-11 sm:h-11" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round">
                            <line x1="16" y1="28" x2="12" y2="12" />
                            <line x1="24" y1="32" x2="33" y2="17" />
                            <line x1="28" y1="38" x2="43" y2="34" />
                        </svg>
                    </div>

                    <!-- Main White Frame Card with Rounded Corners & Soft Shadow -->
                    <div class="relative rounded-[32px] sm:rounded-[36px] bg-white p-2.5 sm:p-3 shadow-xl shadow-[#168C83]/12 border border-slate-100/90">
                        <img src="{{ asset('images/hero-smile.jpg') }}"
                            alt="Pemeriksaan Gigi dan Senyum Sehat Smile Score"
                            loading="eager"
                            decoding="async"
                            class="w-full h-auto aspect-[4/3] object-cover rounded-[24px] sm:rounded-[28px]">
                    </div>

                    <!-- Cute Accent Ticks on bottom-left curve of photo matching reference -->
                    <div class="absolute bottom-5 left-2 sm:bottom-6 sm:left-3 pointer-events-none select-none text-[#0E6754]">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8" viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round">
                            <line x1="10" y1="26" x2="16" y2="14" />
                            <line x1="18" y1="32" x2="24" y2="20" />
                        </svg>
                    </div>

                    <!-- Cute Tooth Illustration Accent with tilt & sparkle star matching client reference -->
                    <div class="absolute -bottom-4 -right-2 sm:-bottom-5 sm:-right-4 pointer-events-none select-none z-10 flex items-start">
                        <div class="relative transform rotate-[8deg] transition-transform duration-300">
                            <!-- Clean Tooth Outline with White Fill -->
                            <svg class="w-14 h-16 sm:w-16 sm:h-18 drop-shadow-md" viewBox="0 0 100 110" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M 50 24 C 43 17, 30 15, 20 22 C 10 30, 8 46, 10 62 C 12 77, 18 92, 25 100 C 29 104, 37 103, 41 96 C 45 88, 48 77, 50 77 C 52 77, 55 88, 59 96 C 63 103, 71 104, 75 100 C 82 92, 88 77, 90 62 C 92 46, 90 30, 80 22 C 70 15, 57 17, 50 24 Z" 
                                      fill="#FFFFFF" 
                                      stroke="#0E6754" 
                                      stroke-width="5" 
                                      stroke-linecap="round" 
                                      stroke-linejoin="round"/>
                            </svg>
                            <!-- Sparkle Star at Top-Right of Tooth -->
                            <div class="absolute -top-1 -right-3 text-[#0E6754]">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2 C12 8 16 12 22 12 C16 12 12 16 12 22 C12 16 8 12 2 12 C8 12 12 8 12 2 Z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Curved Divider at the bottom connecting cleanly to Section 2 -->
    <div class="w-full overflow-hidden leading-none -mb-1 mt-8">
        <svg class="relative block w-full h-8 sm:h-12 text-white" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0 C300,90 900,90 1200,0 L1200,120 L0,120 Z" fill="currentColor"></path>
        </svg>
    </div>
</section>

<!-- ============================================================== -->
<!-- 2. SECTION: APA ITU SMILE SCORE? (3 CARDS)                    -->
<!-- ============================================================== -->
<section id="tentang" class="py-14 md:py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-14" data-aos="fade-up">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-3">
                Apa itu <span class="text-[#168C83]">Smile Score?</span>
                <span class="text-amber-400 text-2xl inline-block">✦</span>
            </h2>
            <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                Smile Score adalah media edukasi berbasis digital yang membantu siswa mengetahui kondisi kesehatan gigi dan mulut melalui penilaian sederhana dan rekomendasi yang mudah dipahami. Didukung oleh teknologi AI, hasil penilaian akan disesuaikan dengan jawaban yang kamu berikan.
            </p>
        </div>

        <!-- 3 Feature Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">

            <!-- Card 1: Menilai -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 card-soft-shadow border border-[#D9EAE4] flex flex-col items-center text-center group" data-aos="fade-up" data-aos-delay="100">
                <div class="w-18 h-18 sm:w-20 sm:h-20 rounded-full bg-[#E6F7F5] text-[#168C83] flex items-center justify-center mb-5 group-hover:scale-105 transition-transform duration-300">
                    <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Menilai</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Menilai kebiasaan dan kondisi gigi dan mulutmu.
                </p>
            </div>

            <!-- Card 2: Skor & Kategori -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 card-soft-shadow border border-slate-100 flex flex-col items-center text-center group" data-aos="fade-up" data-aos-delay="200">
                <div class="w-18 h-18 sm:w-20 sm:h-20 rounded-full bg-[#e6fbf3] text-[#10B981] flex items-center justify-center mb-5 group-hover:scale-105 transition-transform duration-300">
                    <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19h16" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Skor &amp; Kategori</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Mendapatkan hasil Smile Score dan kategori kesehatanmu.
                </p>
            </div>

            <!-- Card 3: Edukasi & Saran (Rich Graduation Cap with Tassel) -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 card-soft-shadow border border-slate-100 flex flex-col items-center text-center group" data-aos="fade-up" data-aos-delay="300">
                <div class="w-18 h-18 sm:w-20 sm:h-20 rounded-full bg-[#f3e8ff] text-[#8B5CF6] flex items-center justify-center mb-5 group-hover:scale-105 transition-transform duration-300">
                    <svg class="w-11 h-11" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="capGrad" x1="12" y1="22" x2="52" y2="34" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#8B5CF6" />
                                <stop offset="0.6" stop-color="#7C3AED" />
                                <stop offset="1" stop-color="#6D28D9" />
                            </linearGradient>
                            <linearGradient id="capBaseGrad" x1="20" y1="28" x2="44" y2="42" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#7C3AED" />
                                <stop offset="1" stop-color="#5B21B6" />
                            </linearGradient>
                        </defs>
                        <ellipse cx="32" cy="50" rx="15" ry="3" fill="#DDD6FE" opacity="0.6" />
                        <path d="M21 28 L21 38 C21 42 43 42 43 38 L43 28 Z" fill="url(#capBaseGrad)" />
                        <path d="M32 16 L52 24 L32 32 L12 24 Z" fill="url(#capGrad)" stroke="#5B21B6" stroke-width="1.5" stroke-linejoin="round" />
                        <path d="M12 24 L32 32 L32 34 L12 26 Z" fill="#4C1D95" />
                        <path d="M52 24 L32 32 L32 34 L52 26 Z" fill="#5B21B6" />
                        <ellipse cx="32" cy="24" rx="2.5" ry="1.5" fill="#DDD6FE" />
                        <path d="M32 24 Q45 26 45 35" stroke="#F59E0B" stroke-width="1.8" fill="none" stroke-linecap="round" />
                        <path d="M43 35 L47 35 L46 43 L44 43 Z" fill="#F59E0B" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Edukasi &amp; Saran</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Memperoleh edukasi dan saran untuk kesehatan gigi yang lebih baik.
                </p>
            </div>

        </div>
    </div>
</section>

<!-- ============================================================== -->
<!-- 3. SECTION: CARA KERJA SMILE SCORE (4 STEPS)                  -->
<!-- ============================================================== -->
<section id="cara-kerja" class="py-14 md:py-20 bg-[#F1FAF6]/50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="text-center max-w-xl mx-auto mb-12 sm:mb-14" data-aos="fade-up">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-3">
                Cara Kerja <span class="text-[#168C83]">Smile Score</span>
                <span class="text-amber-400 text-2xl inline-block">✦</span>
            </h2>
            <p class="text-slate-500 text-sm sm:text-base">
                Langkah mudah untuk mengetahui kondisi kesehatan gigi dan mulutmu.
            </p>
        </div>

        <!-- 4 Steps Flow Container -->
        <div class="rounded-3xl bg-[#E6F7F5] p-6 sm:p-8 lg:p-10 border border-[#D9EAE4]/80 shadow-sm" data-aos="fade-up">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">

                <!-- Step 1: Isi Identitas -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col items-center text-center relative group">
                    <div class="w-7 h-7 rounded-full bg-[#168C83] text-white font-bold text-xs flex items-center justify-center absolute top-4 left-4 shadow-sm">
                        1
                    </div>
                    <div class="w-16 h-16 rounded-full bg-[#E6F7F5] text-[#168C83] flex items-center justify-center mt-3 mb-3 group-hover:scale-105 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">Isi Identitas</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">
                        Masukkan kode responden atau identitas diri kamu.
                    </p>
                    <!-- Connector Arrow -->
                    <div class="hidden lg:flex items-center justify-center absolute -right-3.5 top-1/2 -translate-y-1/2 z-10 text-[#168C83]/60 pointer-events-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>

                <!-- Step 2: Jawab Pertanyaan -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col items-center text-center relative group">
                    <div class="w-7 h-7 rounded-full bg-[#10B981] text-white font-bold text-xs flex items-center justify-center absolute top-4 left-4 shadow-sm">
                        2
                    </div>
                    <div class="w-16 h-16 rounded-full bg-[#e6fbf3] text-[#10B981] flex items-center justify-center mt-3 mb-3 group-hover:scale-105 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">Jawab Pertanyaan</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">
                        Jawab beberapa pertanyaan seputar kesehatan gigi dan mulut.
                    </p>
                    <!-- Connector Arrow -->
                    <div class="hidden lg:flex items-center justify-center absolute -right-3.5 top-1/2 -translate-y-1/2 z-10 text-[#168C83]/60 pointer-events-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>

                <!-- Step 3: Dapatkan Smile Score -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col items-center text-center relative group">
                    <div class="w-7 h-7 rounded-full bg-[#8B5CF6] text-white font-bold text-xs flex items-center justify-center absolute top-4 left-4 shadow-sm">
                        3
                    </div>
                    <div class="w-16 h-16 rounded-full bg-[#f3e8ff] flex items-center justify-center mt-3 mb-3 p-2.5 group-hover:scale-105 transition-transform">
                        <img src="{{ asset('images/tooth-illustration.svg') }}" alt="Ilustrasi Dapatkan Smile Score" class="w-full h-full object-contain">
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">Dapatkan Smile Score</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">
                        Sistem akan menghitung skor dan menentukan kategori kesehatanmu.
                    </p>
                    <!-- Connector Arrow -->
                    <div class="hidden lg:flex items-center justify-center absolute -right-3.5 top-1/2 -translate-y-1/2 z-10 text-[#168C83]/60 pointer-events-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>

                <!-- Step 4: Lihat Edukasi & Saran (Glowing Lightbulb over Open Book) -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col items-center text-center relative group">
                    <div class="w-7 h-7 rounded-full bg-[#F59E0B] text-white font-bold text-xs flex items-center justify-center absolute top-4 left-4 shadow-sm">
                        4
                    </div>
                    <div class="w-16 h-16 rounded-full bg-[#fef3c7] text-[#F59E0B] flex items-center justify-center mt-3 mb-3 group-hover:scale-105 transition-transform">
                        <svg class="w-10 h-10" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="glowBulbGradStep4" x1="24" y1="14" x2="40" y2="34" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FDE047" />
                                    <stop offset="0.6" stop-color="#F59E0B" />
                                    <stop offset="1" stop-color="#D97706" />
                                </linearGradient>
                                <linearGradient id="bookCoverGradStep4" x1="14" y1="36" x2="50" y2="52" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FEF3C7" />
                                    <stop offset="1" stop-color="#FDE68A" />
                                </linearGradient>
                            </defs>
                            <path d="M49 14 Q51 14 51 12 Q51 14 53 14 Q51 14 51 16 Q51 14 49 14 Z" fill="#F59E0B" />
                            <path d="M32 8 L32 11 M22 13 L24 15 M42 13 L40 15 M18 22 L20 22 M46 22 L44 22" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" />
                            <path d="M32 46 C24 43 18 43 14 44 L14 36 C18 35 24 35 32 38 Z" fill="url(#bookCoverGradStep4)" stroke="#D97706" stroke-width="1.5" stroke-linejoin="round" />
                            <path d="M32 46 C40 43 46 43 50 44 L50 36 C46 35 40 35 32 38 Z" fill="url(#bookCoverGradStep4)" stroke="#D97706" stroke-width="1.5" stroke-linejoin="round" />
                            <line x1="32" y1="38" x2="32" y2="47" stroke="#B45309" stroke-width="2" stroke-linecap="round" />
                            <path d="M32 13 C27.5 13 24 16.5 24 21 C24 24 25.8 26.5 27.5 28.5 L27.5 32 L36.5 32 L36.5 28.5 C38.2 26.5 40 24 40 21 C40 16.5 36.5 13 32 13 Z" fill="url(#glowBulbGradStep4)" />
                            <rect x="28.5" y="32" width="7" height="3.5" rx="1" fill="#78350F" />
                            <ellipse cx="29" cy="18" rx="2" ry="3" transform="rotate(-20 29 18)" fill="#FFFFFF" opacity="0.6" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">Lihat Edukasi &amp; Saran</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">
                        Pelajari edukasi dan saran sesuai hasil Smile Score kamu.
                    </p>
                </div>

            </div>
        </div>

    </div>
</section>

<!-- ============================================================== -->
<!-- 4. SECTION: EDUKASI SINGKAT (4 PASTEL HORIZONTAL CARDS)       -->
<!-- ============================================================== -->
<section id="edukasi" class="py-14 md:py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="text-center max-w-xl mx-auto mb-10 sm:mb-12" data-aos="fade-up">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Edukasi Singkat
            </h2>
            <p class="text-slate-500 text-sm mt-2">
                Langkah kecil setiap hari untuk kesehatan gigi yang tahan lama.
            </p>
        </div>

        <!-- 4 Horizontal Pastel Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 items-stretch">

            <!-- Card 1: Sikat Gigi 2x Sehari (Soft Pale Aqua/Teal) -->
            <div class="bg-[#E6F7F5] hover:bg-[#DDF5EC] border border-[#D9EAE4]/90 rounded-2xl p-4 sm:p-5 flex items-center gap-3.5 shadow-sm hover:shadow-md transition-shadow group" data-aos="fade-up" data-aos-delay="50">
                <div class="w-13 h-13 sm:w-14 sm:h-14 flex-shrink-0 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                    <svg class="w-11 h-11 sm:w-12 sm:h-12" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="optTealCupGrad" x1="20" y1="34" x2="44" y2="58" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#5ecdb7" />
                                <stop offset="1" stop-color="#168C83" />
                            </linearGradient>
                            <linearGradient id="optBrushHandleGrad" x1="16" y1="12" x2="25" y2="34" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#a8e6d7" />
                                <stop offset="1" stop-color="#2AAB9A" />
                            </linearGradient>
                            <linearGradient id="optPasteTubeGrad" x1="36" y1="14" x2="42" y2="34" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#DDF5EC" />
                                <stop offset="0.6" stop-color="#a8e6d7" />
                                <stop offset="1" stop-color="#5ecdb7" />
                            </linearGradient>
                        </defs>
                        <ellipse cx="32" cy="59" rx="16" ry="3" fill="#a8e6d7" opacity="0.4" />
                        <path d="M19 12 L17 22 L24 38 L28 36 L22 21 L23 12 Z" fill="url(#optBrushHandleGrad)" />
                        <path d="M15 11 C15 9.5 16 8.5 17.5 8.5 C19 8.5 20 9.5 20 11 L20 17 L15 17 Z" fill="#FFFFFF" />
                        <path d="M15 13 L20 13 M15 15 L20 15" stroke="#a8e6d7" stroke-width="0.8" />
                        <path d="M37 16 L44 19 L40 37 L34 35 Z" fill="url(#optPasteTubeGrad)" />
                        <path d="M38 13 L42 14.5 L41 16.5 L37 15 Z" fill="#11665F" />
                        <rect x="38" y="12" width="4" height="2.5" rx="0.8" transform="rotate(20 38 12)" fill="#0d4f49" />
                        <path d="M36 24 L42 26.5 L41.5 28.5 L35.5 26 Z" fill="#2AAB9A" />
                        <path d="M20 34 L23 54 C23.5 56 25 57 27 57 L37 57 C39 57 40.5 56 41 54 L44 34 Z" fill="url(#optTealCupGrad)" />
                        <ellipse cx="32" cy="34" rx="12" ry="3" fill="#168C83" />
                        <ellipse cx="32" cy="34" rx="10" ry="2" fill="#11665F" />
                        <path d="M23 37 L25 52" stroke="#a8e6d7" stroke-width="1.5" stroke-linecap="round" opacity="0.7" />
                        <circle cx="47" cy="18" r="1.5" fill="#5ecdb7" />
                        <circle cx="13" cy="22" r="1" fill="#a8e6d7" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-[#183B38] text-sm leading-snug mb-1">Sikat Gigi 2x Sehari</h3>
                    <p class="text-slate-600 text-xs leading-relaxed">
                        Sikat gigi pagi setelah sarapan dan malam sebelum tidur.
                    </p>
                </div>
            </div>

            <!-- Card 2: Batasi Makanan Manis (Light Green/Mint) -->
            <div class="bg-[#eaf8f1] hover:bg-[#dcf4e8] border border-emerald-100/90 rounded-2xl p-4 sm:p-5 flex items-center gap-3.5 shadow-sm hover:shadow-md transition-shadow group" data-aos="fade-up" data-aos-delay="100">
                <div class="w-13 h-13 sm:w-14 sm:h-14 flex-shrink-0 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                    <svg class="w-11 h-11 sm:w-12 sm:h-12" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="optPinkCandyGrad" x1="22" y1="22" x2="42" y2="44" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#F472B6" />
                                <stop offset="0.5" stop-color="#EC4899" />
                                <stop offset="1" stop-color="#DB2777" />
                            </linearGradient>
                            <linearGradient id="optCandyTwistGrad" x1="12" y1="38" x2="22" y2="30" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#FB7185" />
                                <stop offset="1" stop-color="#E11D48" />
                            </linearGradient>
                            <linearGradient id="optCandyTwistRight" x1="42" y1="28" x2="52" y2="20" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#FB7185" />
                                <stop offset="1" stop-color="#E11D48" />
                            </linearGradient>
                        </defs>
                        <ellipse cx="32" cy="57" rx="15" ry="3" fill="#A7F3D0" opacity="0.4" />
                        <path d="M23 36 L12 43 C11 44 10 42 11 40 L15 33 L12 28 C11 26 13 25 14 27 L22 32 Z" fill="url(#optCandyTwistGrad)" />
                        <path d="M41 28 L52 21 C53 20 54 22 53 24 L49 31 L52 36 C53 38 51 39 50 37 L42 32 Z" fill="url(#optCandyTwistRight)" />
                        <circle cx="32" cy="32" r="13" fill="url(#optPinkCandyGrad)" />
                        <path d="M25 24 C28 27 36 37 39 40 M23 31 C26 34 33 41 35 43 M29 21 C31 23 39 31 41 33" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round" opacity="0.85" />
                        <ellipse cx="28" cy="26" rx="5" ry="2.2" transform="rotate(-30 28 26)" fill="#FFFFFF" opacity="0.6" />
                        <path d="M16 19 Q18 19 18 17 Q18 19 20 19 Q18 19 18 21 Q18 19 16 19 Z" fill="#FBBF24" />
                        <ellipse cx="18" cy="46" rx="3.5" ry="3" fill="#F97316" />
                        <circle cx="48" cy="18" r="1.5" fill="#F59E0B" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-emerald-950 text-sm leading-snug mb-1">Batasi Makanan Manis</h3>
                    <p class="text-slate-600 text-xs leading-relaxed">
                        Terlalu banyak gula dapat menyebabkan gigi berlubang.
                    </p>
                </div>
            </div>

            <!-- Card 3: Periksa Gigi Rutin (Light Purple) -->
            <div class="bg-[#f5eeff] hover:bg-[#ece0fd] border border-purple-100/90 rounded-2xl p-4 sm:p-5 flex items-center gap-3.5 shadow-sm hover:shadow-md transition-shadow group" data-aos="fade-up" data-aos-delay="150">
                <div class="w-13 h-13 sm:w-14 sm:h-14 flex-shrink-0 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                    <svg class="w-11 h-11 sm:w-12 sm:h-12" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="optShieldGrad" x1="32" y1="10" x2="32" y2="54" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#8B5CF6" />
                                <stop offset="0.7" stop-color="#7C3AED" />
                                <stop offset="1" stop-color="#6D28D9" />
                            </linearGradient>
                            <linearGradient id="optToothGrad" x1="32" y1="20" x2="32" y2="44" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#FFFFFF" />
                                <stop offset="0.7" stop-color="#F8FAFC" />
                                <stop offset="1" stop-color="#E2E8F0" />
                            </linearGradient>
                        </defs>
                        <ellipse cx="32" cy="58" rx="16" ry="3" fill="#DDD6FE" opacity="0.5" />
                        <path d="M32 10 C43 10 50 15 50 24 C50 39 32 52 32 52 C32 52 14 39 14 24 C14 15 21 10 32 10 Z" fill="url(#optShieldGrad)" />
                        <path d="M32 13 C40.5 13 47 17 47 24.5 C47 37 32 48.5 32 48.5 C32 48.5 17 37 17 24.5 C17 17 23.5 13 32 13 Z" stroke="#C4B5FD" stroke-width="1.8" fill="none" opacity="0.7" />
                        <ellipse cx="32" cy="40" rx="8" ry="2" fill="#5B21B6" opacity="0.3" />
                        <path d="M28 22 C25 22 23 23.5 23 26 C23 29 24 33 25.5 37 C26.5 39.5 28 42 29 42 C30 42 30.5 39 32 36 C33.5 39 34 42 35 42 C36 42 37.5 39.5 38.5 37 C40 33 41 29 41 26 C41 23.5 39 22 36 22 C34 22 33 23 32 23 C31 23 30 22 28 22 Z" fill="url(#optToothGrad)" />
                        <circle cx="27" cy="25" r="1.2" fill="#FFFFFF" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-purple-950 text-sm leading-snug mb-1">Periksa Gigi Rutin</h3>
                    <p class="text-slate-600 text-xs leading-relaxed">
                        Periksa gigi setiap 6 bulan sekali ke dokter gigi.
                    </p>
                </div>
            </div>

            <!-- Card 4: Minum Air Putih (Light Cream/Amber) -->
            <div class="bg-[#fef9ee] hover:bg-[#fcf1db] border border-amber-100/90 rounded-2xl p-4 sm:p-5 flex items-center gap-3.5 shadow-sm hover:shadow-md transition-shadow group" data-aos="fade-up" data-aos-delay="200">
                <div class="w-13 h-13 sm:w-14 sm:h-14 flex-shrink-0 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                    <svg class="w-11 h-11 sm:w-12 sm:h-12" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="optWaterGlassGrad" x1="22" y1="28" x2="38" y2="52" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#38BDF8" />
                                <stop offset="1" stop-color="#0284C7" />
                            </linearGradient>
                            <linearGradient id="optDropGrad" x1="44" y1="38" x2="52" y2="54" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#7DD3FC" />
                                <stop offset="1" stop-color="#0284C7" />
                            </linearGradient>
                        </defs>
                        <ellipse cx="30" cy="57" rx="14" ry="2.8" fill="#FDE68A" opacity="0.4" />
                        <path d="M19 16 L23 51 C23.5 53 25 54 27 54 L37 54 C39 54 40.5 53 41 51 L45 16 Z" fill="#E0F2FE" opacity="0.5" stroke="#7DD3FC" stroke-width="1.5" />
                        <path d="M20.5 28 L23 50.5 C23.5 52 24.5 53 26.5 53 L37.5 53 C39.5 53 40.5 52 41 50.5 L43.5 28 Z" fill="url(#optWaterGlassGrad)" />
                        <ellipse cx="32" cy="28" rx="11.5" ry="2.5" fill="#7DD3FC" />
                        <ellipse cx="32" cy="28" rx="9" ry="1.8" fill="#38BDF8" />
                        <ellipse cx="32" cy="16" rx="13" ry="3" stroke="#38BDF8" stroke-width="1.5" fill="none" />
                        <path d="M23 20 L25 48" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" opacity="0.75" />
                        <ellipse cx="48" cy="55" rx="5" ry="1.5" fill="#BAE6FD" opacity="0.5" />
                        <path d="M47 38 C47 38 42 45 42 48.5 C42 51.5 44.2 54 47 54 C49.8 54 52 51.5 52 48.5 C52 45 47 38 47 38 Z" fill="url(#optDropGrad)" />
                        <ellipse cx="45.5" cy="47" rx="1.2" ry="2" fill="#FFFFFF" opacity="0.8" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-amber-950 text-sm leading-snug mb-1">Minum Air Putih</h3>
                    <p class="text-slate-600 text-xs leading-relaxed">
                        Membantu membersihkan sisa makanan dan menjaga kesehatan mulut.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ============================================================== -->
<!-- 5. CALL TO ACTION SECTION (BANNER WITH 3 SMK STUDENTS)        -->
<!-- ============================================================== -->
<section class="py-10 md:py-14">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative rounded-3xl sm:rounded-[36px] bg-[#0E6754] shadow-xl shadow-[#0E6754]/20 overflow-hidden text-white grid grid-cols-1 md:grid-cols-12 items-stretch" data-aos="zoom-in" data-aos-duration="600">

            <!-- Subtle Organic Decorative Ambient Waves (matching reference) -->
            <div class="absolute -top-12 -right-12 w-72 h-72 rounded-full bg-white/[0.04] pointer-events-none"></div>
            <div class="absolute top-0 right-1/3 w-96 h-32 bg-emerald-300/[0.06] rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-10 right-20 w-64 h-48 bg-teal-300/[0.05] rounded-full blur-xl pointer-events-none"></div>

            <!-- Left: Photo of 3 SMK Students seamlessly blending into green background -->
            <div class="md:col-span-5 relative h-56 sm:h-64 md:h-auto min-h-[220px] overflow-hidden">
                <img src="{{ asset('images/students-cta.jpg') }}"
                    alt="Tiga Siswa SMK Tersenyum Percaya Diri"
                    loading="lazy"
                    decoding="async"
                    class="w-full h-full object-cover object-[8%_15%]">

                <!-- Smooth Gradient Transition: Fades seamlessly into #0E6754 green background -->
                <!-- Mobile: fades to bottom, Desktop (md+): fades to right -->
                <div class="absolute inset-0 pointer-events-none bg-gradient-to-b md:bg-gradient-to-r from-transparent via-transparent via-50% md:via-55% to-[#0E6754] z-10"></div>

                <!-- Playful White Doodle Rays above Students (matching reference) -->
                <!-- White rays above Left Student -->
                <div class="absolute top-4 left-8 pointer-events-none select-none text-white drop-shadow z-20">
                    <svg class="w-7 h-7 sm:w-8 sm:h-8" viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="3.2" stroke-linecap="round">
                        <line x1="22" y1="24" x2="10" y2="12" />
                        <line x1="26" y1="28" x2="22" y2="13" />
                    </svg>
                </div>
                <!-- White rays above Right Student -->
                <div class="absolute top-5 right-8 pointer-events-none select-none text-white drop-shadow z-20">
                    <svg class="w-7 h-7 sm:w-8 sm:h-8" viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="3.2" stroke-linecap="round">
                        <line x1="12" y1="28" x2="16" y2="13" />
                        <line x1="16" y1="24" x2="28" y2="14" />
                    </svg>
                </div>
            </div>

            <!-- Right: Invitation Text, Tooth Doodle & Mulai Sekarang Button -->
            <div class="md:col-span-7 p-6 sm:p-8 lg:py-9 lg:px-9 flex flex-col md:flex-row items-center justify-between gap-6 bg-[#0E6754] relative">

                <!-- Text Content -->
                <div class="space-y-2 text-center md:text-left flex-1">
                    <h2 class="text-xl sm:text-2xl lg:text-[25px] font-extrabold text-white tracking-tight leading-snug">
                        Sudah siap mengetahui<br>
                        <span class="inline-flex items-center gap-1.5">
                            Smile Score kamu?
                            <span class="text-amber-300 text-lg sm:text-xl">✦</span>
                        </span>
                    </h2>
                    <p class="text-[#DDF5EC] text-xs sm:text-sm font-medium leading-relaxed max-w-sm">
                        Yuk, mulai pemeriksaan sekarang dan jaga senyummu setiap hari!
                    </p>
                </div>

                <!-- White Outline Tooth tilted -14deg with Sparkles matching client reference -->
                <div class="flex items-center gap-2 sm:gap-2.5 text-white flex-shrink-0 pointer-events-none select-none my-1 md:my-0">
                    <!-- Sparkle on left -->
                    <svg class="w-3.5 h-3.5 text-white/90 fill-current -mb-3" viewBox="0 0 24 24">
                        <path d="M12 2 C12 8 16 12 22 12 C16 12 12 16 12 22 C12 16 8 12 2 12 C8 12 12 8 12 2 Z"/>
                    </svg>

                    <!-- Tilted Tooth outline -->
                    <div class="relative transform -rotate-[14deg] transition-transform duration-300">
                        <svg class="w-11 h-13 sm:w-12 sm:h-14 drop-shadow" viewBox="0 0 100 110" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M 50 24 C 43 17, 30 15, 20 22 C 10 30, 8 46, 10 62 C 12 77, 18 92, 25 100 C 29 104, 37 103, 41 96 C 45 88, 48 77, 50 77 C 52 77, 55 88, 59 96 C 63 103, 71 104, 75 100 C 82 92, 88 77, 90 62 C 92 46, 90 30, 80 22 C 70 15, 57 17, 50 24 Z" 
                                  stroke="#FFFFFF" 
                                  stroke-width="5" 
                                  stroke-linecap="round" 
                                  stroke-linejoin="round"/>
                        </svg>
                        <span class="absolute -top-1 -right-2 text-[11px] text-white/95">✦</span>
                    </div>

                    <!-- Sparkle on right -->
                    <svg class="w-4 h-4 text-white fill-current -mt-3" viewBox="0 0 24 24">
                        <path d="M12 2 C12 8 16 12 22 12 C16 12 12 16 12 22 C12 16 8 12 2 12 C8 12 12 8 12 2 Z"/>
                    </svg>
                </div>

                <!-- Button: Pure White Pill Button with Teal Text -->
                <div class="flex-shrink-0">
                    <a href="{{ route('smile-score.start') }}"
                        class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-full bg-white hover:bg-[#DDF5EC] text-[#0E6754] font-bold text-sm sm:text-base shadow-md hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 whitespace-nowrap">
                        <span>Mulai Sekarang</span>
                        <svg class="w-4 h-4 text-[#0E6754]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

            </div>

        </div>
    </div>
</section>

@endsection