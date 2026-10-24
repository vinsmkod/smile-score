@php
    $isHome = request()->routeIs('home');
    $homeUrl = route('home');
@endphp

<!-- Header / Sticky Navbar -->
<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-100 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            
            <!-- Left: Logo & Tagline -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-2xl bg-[#E6F7F5] flex items-center justify-center border border-[#D9EAE4] shadow-sm group-hover:scale-105 transition-transform">
                    <!-- Friendly Tooth SVG Icon -->
                    <svg class="w-7 h-7 text-brand-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 3C4.5 3 3 5 3 7.5C3 11 4.5 14 6 18C7 20.5 8 21.5 9.5 21.5C11 21.5 11.5 19.5 12 17C12.5 19.5 13 21.5 14.5 21.5C16 21.5 17 20.5 18 18C19.5 14 21 11 21 7.5C21 5 19.5 3 17 3C14.5 3 13.5 4.5 12 4.5C10.5 4.5 9.5 3 7 3Z" fill="#2AAB9A" stroke="#168C83" stroke-width="1.5" stroke-linejoin="round"/>
                        <!-- Cute Face details -->
                        <circle cx="9.5" cy="9.5" r="1" fill="#183B38"/>
                        <circle cx="14.5" cy="9.5" r="1" fill="#183B38"/>
                        <path d="M10 13C10.8 14.2 13.2 14.2 14 13" stroke="#183B38" stroke-width="1.5" stroke-linecap="round"/>
                        <!-- Rosy Cheeks -->
                        <circle cx="8" cy="11.5" r="1" fill="#F472B6" opacity="0.6"/>
                        <circle cx="16" cy="11.5" r="1" fill="#F472B6" opacity="0.6"/>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-extrabold tracking-tight text-navy-900 leading-tight">
                        Smile <span class="text-brand-600">Score</span>
                    </span>
                    <span class="text-[11px] font-medium text-slate-500 tracking-wide">
                        Sehat Gigi, Senyum Percaya Diri
                    </span>
                </div>
            </a>

            <!-- Center: Nav Links (Desktop) -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
                <a href="{{ $isHome ? '#beranda' : $homeUrl }}" class="nav-link {{ $isHome ? 'active' : '' }} hover:text-brand-600 transition-colors py-1">Beranda</a>
                <a href="{{ $isHome ? '#tentang' : $homeUrl . '#tentang' }}" class="nav-link hover:text-brand-600 transition-colors py-1">Tentang</a>
                <a href="{{ $isHome ? '#cara-kerja' : $homeUrl . '#cara-kerja' }}" class="nav-link hover:text-brand-600 transition-colors py-1">Cara Kerja</a>
                <a href="#tentang-penelitian" onclick="openResearchModal(); return false;" class="nav-link hover:text-brand-600 transition-colors py-1 cursor-pointer">Tentang Penelitian</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }} text-[#168C83] font-bold hover:text-brand-600 transition-colors py-1">Data Responden</a>
                @endauth
            </nav>

            <!-- Right: CTA Button (Desktop) -->
            <div class="hidden md:flex items-center">
                <a href="{{ route('smile-score.start') }}" class="inline-flex items-center gap-2.5 px-6 py-2.5 rounded-full bg-brand-500 hover:bg-brand-600 text-white font-semibold text-sm shadow-md hover:shadow-lg hover:shadow-[#168C83]/25 active:scale-95 transition-all duration-200">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C9.5 2 7.5 3.5 7.5 5.5c0 .7.2 1.4.6 2C6.8 8.1 6 9.4 6 11c0 2.5 1.5 6 3 9.5 1 2.3 2 2.5 3 2.5s2-.2 3-2.5c1.5-3.5 3-7 3-9.5 0-1.6-.8-2.9-2.1-3.5.4-.6.6-1.3.6-2C16.5 3.5 14.5 2 12 2z"/>
                    </svg>
                    <span>Mulai Smile Score</span>
                </a>
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="flex md:hidden items-center">
                <button type="button" id="mobile-menu-btn" class="p-2 rounded-xl text-slate-600 hover:text-brand-600 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-brand-500" aria-label="Buka Menu" aria-expanded="false">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Drawer Menu -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-slate-100 bg-white/98 px-4 pt-3 pb-6 space-y-3 shadow-xl animate-in slide-in-from-top duration-200">
        <a href="{{ $isHome ? '#beranda' : $homeUrl }}" class="block px-3 py-2.5 rounded-lg text-base font-medium text-slate-700 hover:text-brand-600 hover:bg-[#E6F7F5] transition-colors">Beranda</a>
        <a href="{{ $isHome ? '#tentang' : $homeUrl . '#tentang' }}" class="block px-3 py-2.5 rounded-lg text-base font-medium text-slate-700 hover:text-brand-600 hover:bg-[#E6F7F5] transition-colors">Tentang</a>
        <a href="{{ $isHome ? '#cara-kerja' : $homeUrl . '#cara-kerja' }}" class="block px-3 py-2.5 rounded-lg text-base font-medium text-slate-700 hover:text-brand-600 hover:bg-[#E6F7F5] transition-colors">Cara Kerja</a>
        <a href="{{ $isHome ? '#edukasi' : $homeUrl . '#edukasi' }}" class="block px-3 py-2.5 rounded-lg text-base font-medium text-slate-700 hover:text-brand-600 hover:bg-[#E6F7F5] transition-colors">Edukasi</a>
        <a href="#tentang-penelitian" onclick="openResearchModal(); return false;" class="block px-3 py-2.5 rounded-lg text-base font-medium text-slate-700 hover:text-brand-600 hover:bg-[#E6F7F5] transition-colors">Tentang Penelitian</a>
        @auth
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2.5 rounded-lg text-base font-bold text-[#168C83] bg-[#E6F7F5] transition-colors">Data Responden</a>
        @endauth
        <div class="pt-2">
            <a href="{{ route('smile-score.start') }}" class="w-full flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-brand-500 text-white font-semibold text-sm shadow-md hover:bg-brand-600 transition-colors">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C9.5 2 7.5 3.5 7.5 5.5c0 .7.2 1.4.6 2C6.8 8.1 6 9.4 6 11c0 2.5 1.5 6 3 9.5 1 2.3 2 2.5 3 2.5s2-.2 3-2.5c1.5-3.5 3-7 3-9.5 0-1.6-.8-2.9-2.1-3.5.4-.6.6-1.3.6-2C16.5 3.5 14.5 2 12 2z"/>
                </svg>
                <span>Mulai Smile Score</span>
            </a>
        </div>
    </div>
</header>
