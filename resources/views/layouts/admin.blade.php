<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Admin Panel — Smile Score')</title>
    <meta name="description" content="@yield('meta_description', 'Dashboard administrasi penelitian Smile Score.')">

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
                            50:  '#f1faf6',
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

    <style>
        /* ─── Admin Layout Foundation ─────────────────────────────── */
        html, body { height: 100%; }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
            background: #f4f6f9;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* ─── Sidebar ─────────────────────────────────────────────── */
        .admin-sidebar {
            width: 256px;
            min-width: 256px;
            background: #ffffff;
            border-right: 1px solid #e5e9f0;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 50;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .admin-sidebar::-webkit-scrollbar { width: 4px; }
        .admin-sidebar::-webkit-scrollbar-track { background: transparent; }
        .admin-sidebar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 4px; }

        /* ─── Main Content Area ───────────────────────────────────── */
        .admin-main {
            flex: 1;
            margin-left: 256px;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 100vh;
        }

        /* ─── Topbar ──────────────────────────────────────────────── */
        .admin-topbar {
            height: 64px;
            background: #ffffff;
            border-bottom: 1px solid #e5e9f0;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 40;
            flex-shrink: 0;
        }

        /* ─── Content body ────────────────────────────────────────── */
        .admin-content {
            flex: 1;
            padding: 1.75rem 1.75rem;
            overflow-x: hidden;
        }

        /* ─── Sidebar Nav Item ────────────────────────────────────── */
        .sidebar-nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 600;
            color: #64748b;
            text-decoration: none;
            transition: all 0.15s ease;
            margin: 1px 0;
            position: relative;
        }

        .sidebar-nav-item:hover {
            background: #f1faf6;
            color: #168C83;
        }

        .sidebar-nav-item.active {
            background: #e6f7f5;
            color: #168C83;
            font-weight: 700;
        }

        .sidebar-nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 6px;
            bottom: 6px;
            width: 3px;
            background: #168C83;
            border-radius: 0 4px 4px 0;
        }

        .sidebar-nav-item svg {
            flex-shrink: 0;
            opacity: 0.7;
        }

        .sidebar-nav-item.active svg,
        .sidebar-nav-item:hover svg {
            opacity: 1;
        }

        .sidebar-nav-item.danger {
            color: #64748b;
        }
        .sidebar-nav-item.danger:hover {
            background: #fff1f2;
            color: #e11d48;
        }
        .sidebar-nav-item.danger:hover svg {
            opacity: 1;
        }

        .sidebar-section-label {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #94a3b8;
            padding: 14px 16px 6px;
        }

        /* ─── Stat Cards ──────────────────────────────────────────── */
        .stat-card {
            background: #fff;
            border: 1px solid #e5e9f0;
            border-radius: 12px;
            padding: 20px 20px 16px;
            transition: box-shadow 0.15s;
        }
        .stat-card:hover { box-shadow: 0 4px 16px rgba(22,140,131,0.07); }

        /* ─── Table ───────────────────────────────────────────────── */
        .admin-table th {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            padding: 11px 14px;
            background: #f8fafc;
            border-bottom: 1px solid #e5e9f0;
            white-space: nowrap;
        }

        .admin-table td {
            font-size: 13px;
            padding: 12px 14px;
            border-bottom: 1px solid #f1f5f9;
            color: #374151;
            vertical-align: middle;
        }

        .admin-table tbody tr:hover { background: #f8fffe; }
        .admin-table tbody tr:last-child td { border-bottom: none; }

        /* ─── Badges ──────────────────────────────────────────────── */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 100px;
            font-size: 11.5px;
            font-weight: 700;
            white-space: nowrap;
        }
        .badge-success { background: #dcfce7; color: #15803d; }
        .badge-warning { background: #fef9c3; color: #92400e; }
        .badge-baik    { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .badge-cukup   { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .badge-kurang  { background: #ffe4e6; color: #9f1239; border: 1px solid #fecdd3; }

        /* ─── Form Controls ───────────────────────────────────────── */
        .admin-input, .admin-select {
            width: 100%;
            padding: 8px 12px;
            font-size: 13px;
            border: 1px solid #dde3eb;
            border-radius: 8px;
            background: #fff;
            color: #374151;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
            font-family: inherit;
        }
        .admin-input:focus, .admin-select:focus {
            border-color: #168C83;
            box-shadow: 0 0 0 3px rgba(22,140,131,0.12);
        }
        .admin-input::placeholder { color: #9ca3af; }

        /* ─── Buttons ─────────────────────────────────────────────── */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            background: #168C83;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.15s;
            font-family: inherit;
        }
        .btn-primary:hover { background: #11665F; }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            background: #fff;
            color: #374151;
            font-size: 13px;
            font-weight: 600;
            border-radius: 8px;
            border: 1px solid #dde3eb;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.15s, border-color 0.15s;
            font-family: inherit;
        }
        .btn-secondary:hover { background: #f8fafc; border-color: #c7d0dd; }

        .btn-excel {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            background: #16a34a;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.15s;
        }
        .btn-excel:hover { background: #15803d; }

        .btn-csv {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            background: #168C83;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.15s;
        }
        .btn-csv:hover { background: #11665F; }

        /* ─── Progress Bar ─────────────────────────────────────────── */
        .progress-track {
            height: 6px;
            background: #e5e9f0;
            border-radius: 99px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            border-radius: 99px;
            transition: width 0.6s ease;
        }

        /* ─── Responsive Mobile Overlay ───────────────────────────── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 45;
        }

        /* ─── Section Card ────────────────────────────────────────── */
        .admin-card {
            background: #fff;
            border: 1px solid #e5e9f0;
            border-radius: 12px;
            overflow: hidden;
        }
        .admin-card-header {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        /* ─── Pagination override ─────────────────────────────────── */
        .pagination-wrapper nav {
            padding: 14px 20px;
        }
        .pagination-wrapper span[aria-current="page"] span,
        .pagination-wrapper a {
            border-radius: 6px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
        }

        /* ─── Mobile Responsive ───────────────────────────────────── */
        @media (max-width: 1023px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.sidebar-open {
                transform: translateX(0);
            }
            .admin-main {
                margin-left: 0;
            }
            .sidebar-overlay.overlay-active {
                display: block;
            }
            .admin-content {
                padding: 1.25rem 1rem;
            }
        }

        @media (max-width: 640px) {
            .admin-content { padding: 1rem 0.75rem; }
            .admin-topbar { padding: 0 1rem; }
        }
    </style>

    @stack('styles')
</head>
<body class="h-full" style="font-family:'Plus Jakarta Sans',sans-serif; background:#f4f6f9;">

<div class="admin-wrapper">

    <!-- ═══ SIDEBAR ═══════════════════════════════════════════════════ -->
    <aside class="admin-sidebar" id="adminSidebar">

        <!-- Brand Identity -->
        <div style="padding: 20px 20px 0; flex-shrink:0;">
            <div style="display:flex; align-items:center; gap:10px; padding-bottom:18px; border-bottom:1px solid #f0f4f8;">
                <div style="width:38px;height:38px;border-radius:10px;background:#e6f7f5;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="#168C83">
                        <path d="M12 2C9.5 2 7.5 3.5 7.5 5.5c0 .7.2 1.4.6 2C6.8 8.1 6 9.4 6 11c0 2.5 1.5 6 3 9.5 1 2.3 2 2.5 3 2.5s2-.2 3-2.5c1.5-3.5 3-7 3-9.5 0-1.6-.8-2.9-2.1-3.5.4-.6.6-1.3.6-2C16.5 3.5 14.5 2 12 2z"/>
                    </svg>
                </div>
                <div>
                    <div style="font-size:15px;font-weight:800;color:#183B38;line-height:1.2;">Smile Score</div>
                    <div style="font-size:9.5px;font-weight:700;letter-spacing:0.1em;color:#94a3b8;text-transform:uppercase;">Admin Panel</div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav style="flex:1; padding: 10px 12px; overflow-y:auto;">

            <div class="sidebar-section-label">Main Menu</div>

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-nav-item {{ (request()->routeIs('admin.dashboard') && !request()->routeIs('admin.responden')) ? 'active' : '' }}"
               id="nav-dashboard">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7" rx="1.5" stroke-width="2"/>
                    <rect x="14" y="3" width="7" height="7" rx="1.5" stroke-width="2"/>
                    <rect x="3" y="14" width="7" height="7" rx="1.5" stroke-width="2"/>
                    <rect x="14" y="14" width="7" height="7" rx="1.5" stroke-width="2"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('admin.responden') }}"
               class="sidebar-nav-item {{ (request()->routeIs('admin.responden') || request()->routeIs('admin.detail')) ? 'active' : '' }}"
               id="nav-responden">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20H7a5 5 0 010-10h.09A5.002 5.002 0 0117 14v6z"/>
                    <circle cx="12" cy="7" r="4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Data Responden
            </a>

            <div class="sidebar-section-label" style="margin-top:6px;">Data & Export</div>

            <a href="{{ route('admin.export', ['format' => 'xlsx', 'scope' => 'all']) }}"
               class="sidebar-nav-item"
               id="nav-export-xlsx">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Ekspor Excel
            </a>

            <a href="{{ route('admin.export', ['format' => 'csv', 'scope' => 'all']) }}"
               class="sidebar-nav-item"
               id="nav-export-csv">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                </svg>
                Ekspor CSV
            </a>

            <div class="sidebar-section-label" style="margin-top:6px;">System</div>

            <a href="{{ route('home') }}" class="sidebar-nav-item" id="nav-website">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Kembali ke Website
            </a>

            <form action="{{ route('admin.logout') }}" method="POST" id="sidebar-logout-form">
                @csrf
                <button type="submit" class="sidebar-nav-item danger" style="width:100%;background:none;border:none;cursor:pointer;text-align:left;" id="nav-logout">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>

        </nav>

        <!-- Admin Info (bottom) -->
        <div style="padding: 14px 16px; border-top: 1px solid #f0f4f8; flex-shrink:0; display:flex; align-items:center; gap:10px;">
            <div style="width:32px;height:32px;border-radius:8px;background:#e6f7f5;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="16" height="16" fill="none" stroke="#168C83" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4" stroke-width="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
            </div>
            <div style="min-width:0;">
                <div style="font-size:12.5px;font-weight:700;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ Auth::user()->name ?? 'Admin' }}
                </div>
                <div style="font-size:10.5px;color:#94a3b8;font-weight:500;">Administrator</div>
            </div>
        </div>

    </aside>

    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ═══ MAIN AREA ══════════════════════════════════════════════════ -->
    <div class="admin-main">

        <!-- ─── TOPBAR ─────────────────────────────────────────── -->
        <header class="admin-topbar">
            <!-- Mobile menu toggle -->
            <button id="sidebarToggle"
                    style="display:none; width:36px;height:36px;align-items:center;justify-content:center;border-radius:8px;border:1px solid #e5e9f0;background:#fff;cursor:pointer;margin-right:12px; flex-shrink:0;"
                    aria-label="Buka sidebar">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <!-- Page Title & Breadcrumb -->
            <div style="flex:1;min-width:0;">
                <div style="font-size:15px;font-weight:800;color:#183B38;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    @yield('page-title', 'Dashboard')
                </div>
                <div style="font-size:11.5px;color:#94a3b8;font-weight:500;margin-top:1px;">
                    {!! $__env->yieldContent('breadcrumb', 'Admin › Dashboard') !!}
                </div>
            </div>

            <!-- Right: user info & actions -->
            <div style="display:flex;align-items:center;gap:10px;flex-shrink:0;margin-left:16px;">
                <div style="display:flex;align-items:center;gap:8px;padding:6px 12px;background:#f8fafc;border-radius:8px;border:1px solid #e5e9f0;">
                    <div style="width:26px;height:26px;border-radius:6px;background:#e6f7f5;display:flex;align-items:center;justify-content:center;">
                        <svg width="13" height="13" fill="none" stroke="#168C83" viewBox="0 0 24 24">
                            <circle cx="12" cy="8" r="4" stroke-width="2.2"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                        </svg>
                    </div>
                    <span style="font-size:13px;font-weight:700;color:#374151;white-space:nowrap;max-width:140px;overflow:hidden;text-overflow:ellipsis;">
                        {{ Auth::user()->name ?? 'Admin' }}
                    </span>
                </div>

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            title="Keluar"
                            style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;border-radius:8px;border:1px solid #fecdd3;background:#fff;color:#e11d48;cursor:pointer;transition:background 0.15s;"
                            onmouseover="this.style.background='#fff1f2'" onmouseout="this.style.background='#fff'">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </header>

        <!-- ─── PAGE CONTENT ───────────────────────────────────── -->
        <main class="admin-content">

            @if (session('success'))
                <div style="background:#dcfce7;border-left:4px solid #16a34a;border-radius:8px;padding:12px 16px;font-size:13px;color:#15803d;font-weight:600;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('info'))
                <div style="background:#dbeafe;border-left:4px solid #3b82f6;border-radius:8px;padding:12px 16px;font-size:13px;color:#1d4ed8;font-weight:600;margin-bottom:20px;">
                    {{ session('info') }}
                </div>
            @endif

            @if (session('error'))
                <div style="background:#fee2e2;border-left:4px solid #ef4444;border-radius:8px;padding:12px 16px;font-size:13px;color:#b91c1c;font-weight:600;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="background:#fff1f2;border-left:4px solid #e11d48;border-radius:8px;padding:12px 16px;font-size:13px;color:#9f1239;font-weight:600;margin-bottom:20px;">
                    <ul style="margin:0;padding-left:18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')

        </main>

    </div><!-- /admin-main -->
</div><!-- /admin-wrapper -->

<script>
    // Mobile sidebar toggle
    const sidebarToggle   = document.getElementById('sidebarToggle');
    const adminSidebar    = document.getElementById('adminSidebar');
    const sidebarOverlay  = document.getElementById('sidebarOverlay');

    function openSidebar() {
        adminSidebar.classList.add('sidebar-open');
        sidebarOverlay.classList.add('overlay-active');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        adminSidebar.classList.remove('sidebar-open');
        sidebarOverlay.classList.remove('overlay-active');
        document.body.style.overflow = '';
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            adminSidebar.classList.contains('sidebar-open') ? closeSidebar() : openSidebar();
        });
    }
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeSidebar);
    }

    // Show toggle button on mobile
    function checkBreakpoint() {
        if (window.innerWidth < 1024) {
            sidebarToggle.style.display = 'flex';
        } else {
            sidebarToggle.style.display = 'none';
            closeSidebar();
        }
    }
    checkBreakpoint();
    window.addEventListener('resize', checkBreakpoint);

    // Sidebar navigation click handling & mobile auto-close
    document.querySelectorAll('.admin-sidebar a').forEach(item => {
        item.addEventListener('click', (e) => {
            if (window.innerWidth < 1024) {
                closeSidebar();
            }

            if (item.id === 'nav-responden') {
                const target = document.getElementById('daftar-responden');
                const isDashboard = window.location.pathname.endsWith('/admin') || window.location.pathname.endsWith('/admin/responden');
                if (target && isDashboard) {
                    e.preventDefault();
                    history.pushState(null, '', '{{ route("admin.responden") }}');
                    document.getElementById('nav-dashboard')?.classList.remove('active');
                    document.getElementById('nav-responden')?.classList.add('active');
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    });
</script>

@stack('scripts')

</body>
</html>
