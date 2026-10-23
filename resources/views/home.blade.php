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
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-6 items-center">

            <!-- Left Column: Headline, Description & CTA Button -->
            <div class="lg:col-span-6 space-y-6 text-center lg:text-left" data-aos="fade-right" data-aos-duration="700">

                <!-- Main Headline with curved smile accent -->
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-[1.18]">
                    Kenali Kesehatan<br>
                    Gigi dan Mulutmu dengan<br>
                    <span class="text-[#168C83] smile-underline inline-block mt-1">Smile Score</span>
                    <span class="text-amber-400 text-2xl sm:text-3xl inline-block -translate-y-2">✦</span>
                </h1>

                <!-- Description -->
                <p class="text-slate-600 text-sm sm:text-base md:text-[17px] leading-relaxed max-w-xl mx-auto lg:mx-0">
                    Jawab beberapa pertanyaan sederhana tentang kebiasaan dan kondisi gigi serta mulutmu. Dapatkan hasil Smile Score, edukasi, dan saran untuk senyum yang lebih sehat!
                </p>

                <!-- CTA Pill Button -->
                <div class="pt-1 flex items-center justify-center lg:justify-start">
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
                </div>

            </div>

            <!-- Right Column: 3D Artwork of SMK Students & Tooth Mascot -->
            <div class="lg:col-span-6 flex justify-center lg:justify-end" data-aos="fade-left" data-aos-duration="700">
                <div class="relative w-full max-w-lg">
                    <div class="relative rounded-3xl overflow-hidden shadow-lg border border-[#D9EAE4]/80 bg-white/40 p-2">
                        <img src="{{ asset('images/hero_students_tooth.jpg') }}"
                            alt="Siswa SMK dan Maskot Gigi Sehat Smile Score"
                            loading="eager"
                            decoding="async"
                            class="w-full h-auto object-cover rounded-[24px]">
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
                Smile Score adalah media edukasi berbasis digital yang membantu siswa mengetahui kondisi kesehatan gigi dan mulut melalui penilaian sederhana dan rekomendasi yang mudah dipahami.
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
                    <div class="w-16 h-16 rounded-full bg-[#f3e8ff] text-[#8B5CF6] flex items-center justify-center mt-3 mb-3 group-hover:scale-105 transition-transform">
                        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C9.5 2 7.5 3.5 7.5 5.5c0 .7.2 1.4.6 2C6.8 8.1 6 9.4 6 11c0 2.5 1.5 6 3 9.5 1 2.3 2 2.5 3 2.5s2-.2 3-2.5c1.5-3.5 3-7 3-9.5 0-1.6-.8-2.9-2.1-3.5.4-.6.6-1.3.6-2C16.5 3.5 14.5 2 12 2z" />
                        </svg>
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
<!-- 5. CALL TO ACTION SECTION (BLUE BANNER WITH SMILING TOOTH)    -->
<!-- ============================================================== -->
<section class="py-10 md:py-14">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative rounded-3xl sm:rounded-[32px] bg-[#11665F] p-6 sm:p-8 shadow-xl shadow-[#168C83]/15 overflow-hidden text-white flex flex-col lg:flex-row items-center justify-between gap-6" data-aos="zoom-in" data-aos-duration="600">

            <!-- Left Content: Tooth Mascot + Heading + Subtitle -->
            <div class="flex items-center gap-5 sm:gap-6 text-center lg:text-left flex-col sm:flex-row">
                <!-- Waving Smiling Tooth Mascot -->
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-white/15 p-1 backdrop-blur-sm border border-white/25 shadow-inner flex-shrink-0 animate-float">
                    <img src="{{ asset('images/cta_tooth_mascot.jpg') }}"
                        alt="Maskot Gigi Senyum"
                        loading="lazy"
                        decoding="async"
                        class="w-full h-full object-cover rounded-xl">
                </div>

                <div class="space-y-1.5">
                    <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight">
                        Sudah siap mengetahui Smile Score kamu?
                    </h2>
                    <p class="text-[#DDF5EC] text-xs sm:text-sm font-normal">
                        Yuk, mulai pemeriksaan sekarang dan jaga senyummu setiap hari!
                    </p>
                </div>
            </div>

            <!-- Right Button: Pure White Pill Button -->
            <div class="flex-shrink-0">
                <a href="{{ route('smile-score.start') }}" class="inline-flex items-center gap-2 px-7 py-3 rounded-full bg-white hover:bg-[#DDF5EC] text-[#168C83] font-bold text-sm shadow-md hover:shadow-lg transition-all duration-200">
                    <span>Mulai Sekarang</span>
                    <svg class="w-4 h-4 text-[#168C83]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>

        </div>
    </div>
</section>

@endsection