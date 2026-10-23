<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Smile Score - Sehat Gigi, Senyum Percaya Diri')</title>
    <meta name="description" content="@yield('meta_description', 'Smile Score - Media edukasi digital kesehatan gigi dan mulut untuk siswa SMK. Kenali kondisi gigi dan dapatkan rekomendasi senyum sehat!')">
    <meta name="keywords" content="Smile Score, kesehatan gigi, edukasi gigi siswa SMK, gigi sehat, periksa gigi online">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23168C83'><path d='M12 2C9.5 2 7.5 3.5 7.5 5.5c0 .7.2 1.4.6 2C6.8 8.1 6 9.4 6 11c0 2.5 1.5 6 3 9.5 1 2.3 2 2.5 3 2.5s2-.2 3-2.5c1.5-3.5 3-7 3-9.5 0-1.6-.8-2.9-2.1-3.5.4-.6.6-1.3.6-2C16.5 3.5 14.5 2 12 2z'/></svg>">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f1faf6',
                            100: '#ddf5ec',
                            200: '#a8e6d7',
                            300: '#5ecdb7',
                            400: '#2aab9a',
                            500: '#168C83',
                            600: '#11665F',
                            700: '#0d4f49',
                            800: '#0a3b36',
                            900: '#183B38',
                        },
                        navy: {
                            800: '#183B38',
                            900: '#0d2622',
                        },
                        pastel: {
                            blue: '#E6F7F5',
                            teal: '#DDF5EC',
                            purple: '#f3e8ff',
                            amber: '#fef3c7',
                            pink: '#ffe4e6'
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    borderRadius: {
                        '3xl': '1.5rem',
                        '4xl': '2rem',
                    }
                }
            }
        }
    </script>

    <!-- Animate On Scroll (AOS) -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-[#F1FAF6] text-[#183B38] font-sans antialiased selection:bg-[#168C83] selection:text-white flex flex-col min-h-screen">

    <!-- Sticky Navbar -->
    @include('components.navbar')

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.footer')

    <!-- Research Modal (Global on all pages) -->
    @include('components.research-modal')

    <!-- Global Scripts -->
    <script>
        // Mobile menu toggle
        const menuToggleBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (menuToggleBtn && mobileMenu) {
            menuToggleBtn.addEventListener('click', () => {
                const isExpanded = menuToggleBtn.getAttribute('aria-expanded') === 'true';
                menuToggleBtn.setAttribute('aria-expanded', !isExpanded);
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Close mobile menu on link click
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                    if (menuToggleBtn) menuToggleBtn.setAttribute('aria-expanded', 'false');
                }
            });
        });

        // Highlight active nav item on scroll (Throttled with rAF and passive listener for silky 60/120fps)
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-link');
        let scrollTicking = false;

        window.addEventListener('scroll', () => {
            if (!scrollTicking) {
                window.requestAnimationFrame(() => {
                    let current = '';
                    const scrollY = window.scrollY;
                    sections.forEach(section => {
                        const sectionTop = section.offsetTop - 120;
                        const sectionHeight = section.offsetHeight;
                        if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
                            current = section.getAttribute('id');
                        }
                    });

                    navLinks.forEach(link => {
                        link.classList.remove('active');
                        if (link.getAttribute('href') === `#${current}` || (current === '' && link.getAttribute('href') === '#beranda')) {
                            link.classList.add('active');
                        }
                    });
                    scrollTicking = false;
                });
                scrollTicking = true;
            }
        }, { passive: true });

        // Research Modal Toggle
        function openResearchModal() {
            const modal = document.getElementById('researchModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('modal-open');
            }
        }

        function closeResearchModal() {
            const modal = document.getElementById('researchModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.classList.remove('modal-open');
            }
        }

        // Auto open research modal if redirected with #tentang-penelitian hash
        window.addEventListener('DOMContentLoaded', () => {
            if (window.location.hash === '#tentang-penelitian') {
                setTimeout(() => {
                    openResearchModal();
                }, 300);
            }
        });
    </script>

    <!-- Animate On Scroll (AOS) Script -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            AOS.init({
                once: true,
                duration: 500,
                easing: 'ease-out',
                offset: 30,
            });
        });
    </script>
</body>
</html>
