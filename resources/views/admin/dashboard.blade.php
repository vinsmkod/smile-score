@extends('layouts.admin')

@section('title', request()->routeIs('admin.responden') ? 'Data Responden — Admin Smile Score' : 'Dashboard — Admin Smile Score')
@section('meta_description', 'Dashboard administrasi dan data responden penelitian Smile Score.')
@section('page-title', request()->routeIs('admin.responden') ? 'Data Responden' : 'Dashboard')
@section('breadcrumb', request()->routeIs('admin.responden') ? 'Admin › Data Responden' : 'Admin › Dashboard')

@section('content')

{{-- ═══════════════════════════════════════════════════════════════════
     PAGE HEADER
════════════════════════════════════════════════════════════════════ --}}
<div style="margin-bottom:24px;">
    <h1 style="font-size:22px;font-weight:800;color:#183B38;margin:0 0 4px;">Data Responden Penelitian</h1>
    <p style="font-size:13px;color:#64748b;margin:0;">Ringkasan data responden dan hasil kuesioner Smile Score — SMK Putra Nasional Cibodas</p>
</div>

{{-- ═══════════════════════════════════════════════════════════════════
     STAT CARDS — 4 CARDS
════════════════════════════════════════════════════════════════════ --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:20px;" class="stat-grid">

    {{-- Card 1: Total Responden --}}
    <div class="stat-card">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:14px;">
            <div style="width:38px;height:38px;border-radius:10px;background:#e6f7f5;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="18" height="18" fill="none" stroke="#168C83" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20H7a5 5 0 010-10h.09A5.002 5.002 0 0117 14v6z"/>
                    <circle cx="12" cy="7" r="4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <span style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;">Total</span>
        </div>
        <div style="font-size:30px;font-weight:800;color:#183B38;line-height:1;">{{ $totalRespondents }}</div>
        <div style="font-size:12.5px;font-weight:600;color:#64748b;margin-top:5px;">Total Responden</div>
        <div style="font-size:11.5px;color:#94a3b8;margin-top:2px;">Terdaftar di sistem</div>
    </div>

    {{-- Card 2: Selesai --}}
    <div class="stat-card">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:14px;">
            <div style="width:38px;height:38px;border-radius:10px;background:#dcfce7;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="18" height="18" fill="none" stroke="#15803d" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span style="font-size:11px;font-weight:700;color:#15803d;text-transform:uppercase;letter-spacing:.06em;">Selesai</span>
        </div>
        <div style="font-size:30px;font-weight:800;color:#15803d;line-height:1;">{{ $totalCompleted }}</div>
        <div style="font-size:12.5px;font-weight:600;color:#64748b;margin-top:5px;">Kuesioner Selesai</div>
        <div style="font-size:11.5px;color:#94a3b8;margin-top:2px;">20 soal terjawab penuh</div>
    </div>

    {{-- Card 3: Belum Selesai --}}
    <div class="stat-card">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:14px;">
            <div style="width:38px;height:38px;border-radius:10px;background:#fef9c3;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="18" height="18" fill="none" stroke="#92400e" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9" stroke-width="2"/>
                    <path stroke-linecap="round" stroke-width="2" d="M12 7v5l3 3"/>
                </svg>
            </div>
            <span style="font-size:11px;font-weight:700;color:#92400e;text-transform:uppercase;letter-spacing:.06em;">Draft</span>
        </div>
        <div style="font-size:30px;font-weight:800;color:#b45309;line-height:1;">{{ $totalInProgress }}</div>
        <div style="font-size:12.5px;font-weight:600;color:#64748b;margin-top:5px;">Belum Selesai</div>
        <div style="font-size:11.5px;color:#94a3b8;margin-top:2px;">Hanya isi biodata</div>
    </div>

    {{-- Card 4: Hari Ini --}}
    <div class="stat-card">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:14px;">
            <div style="width:38px;height:38px;border-radius:10px;background:#ede9fe;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2"/>
                    <path stroke-linecap="round" stroke-width="2" d="M16 2v4M8 2v4M3 10h18"/>
                </svg>
            </div>
            <span style="font-size:11px;font-weight:700;color:#7c3aed;text-transform:uppercase;letter-spacing:.06em;">Periode</span>
        </div>
        <div style="font-size:30px;font-weight:800;color:#6d28d9;line-height:1;">{{ $countToday }}</div>
        <div style="font-size:12.5px;font-weight:600;color:#64748b;margin-top:5px;">Hari Ini</div>
        <div style="font-size:11.5px;color:#94a3b8;margin-top:2px;">Minggu ini: <strong style="color:#374151;">{{ $countThisWeek }}</strong> siswa</div>
    </div>

</div>

{{-- ═══════════════════════════════════════════════════════════════════
     ROW: DISTRIBUSI KATEGORI + INFO PENELITIAN
════════════════════════════════════════════════════════════════════ --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;" class="two-col-grid">

    {{-- Distribusi Kategori --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <div style="font-size:14px;font-weight:800;color:#183B38;">Distribusi Kategori Smile Score</div>
                <div style="font-size:12px;color:#64748b;margin-top:2px;">Berdasarkan {{ $totalCompleted }} responden yang selesai</div>
            </div>
        </div>
        <div style="padding:20px;">
            @if ($totalCompleted > 0)
                @php
                    $pctBaik   = $totalCompleted > 0 ? round(($countBaik   / $totalCompleted) * 100) : 0;
                    $pctCukup  = $totalCompleted > 0 ? round(($countCukup  / $totalCompleted) * 100) : 0;
                    $pctKurang = $totalCompleted > 0 ? round(($countKurang / $totalCompleted) * 100) : 0;
                @endphp

                {{-- Baik --}}
                <div style="margin-bottom:16px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:10px;height:10px;border-radius:50%;background:#16a34a;flex-shrink:0;"></div>
                            <span style="font-size:13px;font-weight:600;color:#374151;">Baik <span style="font-size:11px;color:#64748b;">(Skor 16–20)</span></span>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <span style="font-size:13px;font-weight:800;color:#15803d;">{{ $countBaik }}</span>
                            <span style="font-size:12px;color:#94a3b8;min-width:34px;text-align:right;">{{ $pctBaik }}%</span>
                        </div>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width:{{ $pctBaik }}%;background:#16a34a;"></div>
                    </div>
                </div>

                {{-- Cukup --}}
                <div style="margin-bottom:16px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:10px;height:10px;border-radius:50%;background:#f59e0b;flex-shrink:0;"></div>
                            <span style="font-size:13px;font-weight:600;color:#374151;">Cukup <span style="font-size:11px;color:#64748b;">(Skor 12–15)</span></span>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <span style="font-size:13px;font-weight:800;color:#b45309;">{{ $countCukup }}</span>
                            <span style="font-size:12px;color:#94a3b8;min-width:34px;text-align:right;">{{ $pctCukup }}%</span>
                        </div>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width:{{ $pctCukup }}%;background:#f59e0b;"></div>
                    </div>
                </div>

                {{-- Kurang Baik --}}
                <div>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:10px;height:10px;border-radius:50%;background:#e11d48;flex-shrink:0;"></div>
                            <span style="font-size:13px;font-weight:600;color:#374151;">Kurang Baik <span style="font-size:11px;color:#64748b;">(Skor 0–11)</span></span>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <span style="font-size:13px;font-weight:800;color:#be123c;">{{ $countKurang }}</span>
                            <span style="font-size:12px;color:#94a3b8;min-width:34px;text-align:right;">{{ $pctKurang }}%</span>
                        </div>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width:{{ $pctKurang }}%;background:#e11d48;"></div>
                    </div>
                </div>

            @else
                <div style="text-align:center;padding:30px 0;color:#94a3b8;">
                    <svg width="36" height="36" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin:0 auto 10px;display:block;opacity:.5;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <p style="font-size:13px;font-weight:600;">Belum ada data distribusi</p>
                    <p style="font-size:12px;margin-top:3px;">Data akan muncul setelah siswa menyelesaikan kuesioner.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Info Penelitian + Akses Cepat --}}
    <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- Info Penelitian --}}
        <div class="admin-card" style="flex:1;">
            <div class="admin-card-header">
                <div style="font-size:14px;font-weight:800;color:#183B38;">Informasi Penelitian</div>
            </div>
            <div style="padding:16px 20px;display:flex;flex-direction:column;gap:10px;">
                @php
                    $items = [
                        ['label' => 'Judul', 'value' => 'Efektivitas Media Edukasi Berbasis AI dengan Fitur Smile Score'],
                        ['label' => 'Sekolah', 'value' => 'SMK Putra Nasional Cibodas'],
                        ['label' => 'Total Soal', 'value' => '20 Soal Pilihan Ganda'],
                        ['label' => 'Kategori', 'value' => 'Baik (16–20) · Cukup (12–15) · Kurang (0–11)'],
                    ];
                @endphp
                @foreach ($items as $item)
                    <div style="display:flex;gap:10px;padding-bottom:9px;border-bottom:1px solid #f1f5f9;">
                        <div style="font-size:11.5px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.04em;min-width:64px;padding-top:1px;">{{ $item['label'] }}</div>
                        <div style="font-size:12.5px;font-weight:600;color:#374151;flex:1;">{{ $item['value'] }}</div>
                    </div>
                @endforeach
                <div style="display:flex;gap:10px;">
                    <div style="font-size:11.5px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.04em;min-width:64px;padding-top:1px;">Status</div>
                    <div>
                        <span style="background:#dcfce7;color:#15803d;font-size:11.5px;font-weight:700;padding:3px 10px;border-radius:100px;">
                            Pengumpulan Data Aktif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Akses Cepat Ekspor --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <div style="font-size:14px;font-weight:800;color:#183B38;">Ekspor Data Penelitian</div>
            </div>
            <div style="padding:16px 20px;display:flex;flex-direction:column;gap:10px;">
                <a href="{{ route('admin.export', ['format' => 'xlsx', 'scope' => 'completed']) }}" class="btn-excel" style="justify-content:center;">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                    Unduh Excel (.xlsx) — Data Selesai
                </a>
                <a href="{{ route('admin.export', ['format' => 'csv', 'scope' => 'completed']) }}" class="btn-csv" style="justify-content:center;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                    Unduh CSV (.csv) — Untuk SPSS
                </a>
                <a href="{{ route('admin.export', ['format' => 'xlsx', 'scope' => 'all']) }}"
                   class="btn-secondary" style="justify-content:center;font-size:12.5px;">
                    Ekspor Semua Data (tanpa filter)
                </a>
            </div>
        </div>

    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════════
     FILTER TOOLBAR
════════════════════════════════════════════════════════════════════ --}}
<div class="admin-card" style="margin-bottom:20px;">
    <div class="admin-card-header">
        <div style="display:flex;align-items:center;gap:8px;">
            <svg width="15" height="15" fill="none" stroke="#168C83" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            <span style="font-size:14px;font-weight:800;color:#183B38;">Pencarian & Filter</span>
        </div>
        <div style="display:flex;align-items:center;gap:8px;">
            <a href="{{ route('admin.export', array_merge(request()->query(), ['format' => 'xlsx', 'scope' => 'filtered'])) }}" class="btn-excel" style="font-size:12px;padding:7px 14px;">
                <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                Excel
            </a>
            <a href="{{ route('admin.export', array_merge(request()->query(), ['format' => 'csv', 'scope' => 'filtered'])) }}" class="btn-csv" style="font-size:12px;padding:7px 14px;">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                CSV
            </a>
        </div>
    </div>

    <form action="{{ route('admin.dashboard') }}" method="GET" style="padding:16px 20px;">
        <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr 1fr;gap:12px;margin-bottom:12px;" class="filter-grid">

            <div>
                <label style="display:block;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:5px;">Cari Responden</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Nama atau ID responden..."
                       class="admin-input">
            </div>

            <div>
                <label style="display:block;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:5px;">Kelas</label>
                <select name="class_name" class="admin-select">
                    <option value="">Semua Kelas</option>
                    @foreach ($availableClasses as $c)
                        <option value="{{ $c }}" {{ request('class_name') === $c ? 'selected' : '' }}>{{ $c }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="display:block;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:5px;">Jenis Kelamin</label>
                <select name="gender" class="admin-select">
                    <option value="">Semua</option>
                    <option value="Laki-laki" {{ request('gender') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ request('gender') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div>
                <label style="display:block;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:5px;">Kategori Skor</label>
                <select name="category" class="admin-select">
                    <option value="">Semua Kategori</option>
                    <option value="Baik" {{ request('category') === 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Cukup" {{ request('category') === 'Cukup' ? 'selected' : '' }}>Cukup</option>
                    <option value="Kurang baik" {{ request('category') === 'Kurang baik' ? 'selected' : '' }}>Kurang Baik</option>
                </select>
            </div>

            <div>
                <label style="display:block;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:5px;">Status</label>
                <select name="status" class="admin-select">
                    <option value="">Semua Status</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>Belum Selesai</option>
                </select>
            </div>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="font-size:12px;font-weight:600;color:#64748b;">Periode:</span>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="admin-input" style="width:auto;">
                <span style="font-size:12px;color:#94a3b8;">s/d</span>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="admin-input" style="width:auto;">
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
                <button type="submit" class="btn-primary">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35"/></svg>
                    Terapkan Filter
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn-secondary">Reset</a>
            </div>
        </div>
    </form>
</div>

{{-- ═══════════════════════════════════════════════════════════════════
     DATA TABLE
════════════════════════════════════════════════════════════════════ --}}
<div class="admin-card" id="daftar-responden" style="scroll-margin-top: 80px;">
    <div class="admin-card-header">
        <div>
            <div style="font-size:14px;font-weight:800;color:#183B38;">Daftar Responden</div>
            <div style="font-size:12px;color:#64748b;margin-top:2px;">
                Menampilkan {{ $submissions->firstItem() ?? 0 }}–{{ $submissions->lastItem() ?? 0 }} dari {{ $submissions->total() }} data
            </div>
        </div>
        @if ($totalRespondents > 0)
            <div>
                <button type="button"
                        onclick="openDeleteAllModal()"
                        style="display:inline-flex;align-items:center;gap:6px;padding:7px 13px;background:#fff;border:1.5px solid #fecdd3;color:#e11d48;font-size:12px;font-weight:700;border-radius:8px;cursor:pointer;transition:all 0.15s;"
                        onmouseover="this.style.background='#fff1f2';this.style.borderColor='#e11d48'"
                        onmouseout="this.style.background='#fff';this.style.borderColor='#fecdd3'"
                        id="btn-open-delete-all"
                        title="Hapus seluruh data responden untuk memulai penelitian baru">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Bersihkan Seluruh Data
                </button>
            </div>
        @endif
    </div>

    <div style="overflow-x:auto;">
        <table class="admin-table" style="width:100%;border-collapse:collapse;">
            <thead>
                <tr>
                    <th style="width:44px;">#</th>
                    <th>ID</th>
                    <th>Nama Lengkap</th>
                    <th>Usia</th>
                    <th>Kelamin</th>
                    <th>Kelas</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th style="text-align:center;">Benar</th>
                    <th style="text-align:center;">Nilai</th>
                    <th>Kategori</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($submissions as $index => $item)
                    @php $isCompleted = ($item->status === 'completed'); @endphp
                    <tr>
                        <td style="color:#94a3b8;font-weight:700;font-size:12px;">{{ $submissions->firstItem() + $index }}</td>

                        <td>
                            <span style="font-family:monospace;font-size:11.5px;font-weight:700;background:#f1f5f9;color:#475569;padding:2px 7px;border-radius:5px;">
                                {{ $item->formatted_id }}
                            </span>
                        </td>

                        <td style="font-weight:700;color:#1e293b;white-space:nowrap;">{{ $item->name }}</td>

                        <td style="color:#64748b;">{{ $item->age }} th</td>

                        <td style="color:#64748b;white-space:nowrap;">{{ $item->gender }}</td>

                        <td>
                            <span style="background:#f1f5f9;color:#475569;font-size:12px;font-weight:600;padding:3px 9px;border-radius:6px;white-space:nowrap;">
                                {{ $item->class_name }}
                            </span>
                        </td>

                        <td style="color:#64748b;font-size:12px;white-space:nowrap;">
                            <div>{{ $item->created_at ? $item->created_at->format('d M Y') : '—' }}</div>
                            <div style="color:#94a3b8;font-size:11px;">{{ $item->created_at ? $item->created_at->format('H:i') . ' WIB' : '' }}</div>
                        </td>

                        <td>
                            @if ($isCompleted)
                                <span class="badge badge-success">
                                    <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    Selesai
                                </span>
                            @else
                                <span class="badge badge-warning">
                                    <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/><path stroke-linecap="round" stroke-width="2" d="M12 7v5l2 2"/></svg>
                                    Draft
                                </span>
                            @endif
                        </td>

                        <td style="text-align:center;">
                            @if ($isCompleted)
                                <strong style="font-size:14px;font-weight:800;color:#168C83;">{{ $item->correct_count }}</strong>
                                <span style="font-size:11px;color:#94a3b8;">/20</span>
                            @else
                                <span style="color:#cbd5e1;">—</span>
                            @endif
                        </td>

                        <td style="text-align:center;">
                            @if ($isCompleted)
                                <strong style="font-size:14px;font-weight:800;color:#1e293b;">{{ $item->percentage }}%</strong>
                            @else
                                <span style="color:#cbd5e1;">—</span>
                            @endif
                        </td>

                        <td>
                            @if ($isCompleted)
                                @if ($item->category === 'Baik')
                                    <span class="badge badge-baik">Baik</span>
                                @elseif ($item->category === 'Cukup')
                                    <span class="badge badge-cukup">Cukup</span>
                                @else
                                    <span class="badge badge-kurang">Kurang</span>
                                @endif
                            @else
                                <span style="color:#94a3b8;font-size:12px;font-style:italic;">—</span>
                            @endif
                        </td>

                        <td style="text-align:center;">
                            <div style="display:inline-flex;align-items:center;justify-content:center;gap:6px;">
                                <a href="{{ route('admin.detail', $item->id) }}"
                                   style="display:inline-flex;align-items:center;gap:4px;padding:6px 11px;background:#f1f5f9;color:#374151;font-size:12px;font-weight:700;border-radius:7px;text-decoration:none;transition:all 0.15s;"
                                   onmouseover="this.style.background='#168C83';this.style.color='#fff'"
                                   onmouseout="this.style.background='#f1f5f9';this.style.color='#374151'"
                                   title="Lihat rincian jawaban responden">
                                    Detail
                                    <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                </a>
                                <button type="button"
                                        onclick="openDeleteSingleModal('{{ route('admin.responden.destroy', $item->id) }}', '{{ addslashes($item->name) }}', '{{ $item->formatted_id }}', '{{ addslashes($item->class_name) }}')"
                                        style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;background:#fff;border:1px solid #fecdd3;color:#e11d48;border-radius:7px;cursor:pointer;transition:all 0.15s;"
                                        onmouseover="this.style.background='#fff1f2';this.style.borderColor='#e11d48'"
                                        onmouseout="this.style.background='#fff';this.style.borderColor='#fecdd3'"
                                        title="Hapus data responden {{ $item->formatted_id }}"
                                        class="btn-delete-single-trigger">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" style="padding:48px 20px;text-align:center;">
                            <div style="width:48px;height:48px;border-radius:12px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                <svg width="22" height="22" fill="none" stroke="#94a3b8" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35"/></svg>
                            </div>
                            <p style="font-size:14px;font-weight:700;color:#374151;margin:0 0 4px;">Tidak ada data ditemukan</p>
                            <p style="font-size:12.5px;color:#94a3b8;margin:0;">Coba sesuaikan kata kunci atau filter yang digunakan.</p>
                            @if (request()->hasAny(['search','class_name','gender','category','status','date_from','date_to']))
                                <a href="{{ route('admin.dashboard') }}" style="display:inline-block;margin-top:12px;font-size:12.5px;font-weight:700;color:#168C83;text-decoration:none;">
                                    Hapus semua filter
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($submissions->hasPages())
        <div class="pagination-wrapper" style="border-top:1px solid #f1f5f9;">
            {{ $submissions->links() }}
        </div>
    @endif
</div>

{{-- ═══════════════════════════════════════════════════════════════════
     MODAL: HAPUS SATU RESPONDEN
════════════════════════════════════════════════════════════════════ --}}
<div class="custom-modal-overlay" id="modalDeleteSingle" onclick="handleModalBackdropClick(event, 'modalDeleteSingle')">
    <div class="custom-modal-card" role="dialog" aria-modal="true" aria-labelledby="singleModalTitle">
        <div style="padding:22px 24px 18px;display:flex;align-items:flex-start;gap:14px;">
            <div style="width:42px;height:42px;border-radius:10px;background:#fee2e2;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="22" height="22" fill="none" stroke="#dc2626" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <div style="flex:1;">
                <h3 id="singleModalTitle" style="font-size:16px;font-weight:800;color:#183B38;margin:0 0 4px;">Konfirmasi Hapus Responden</h3>
                <p style="font-size:12.5px;color:#64748b;margin:0;line-height:1.5;">Apakah Anda yakin ingin menghapus data responden penelitian berikut?</p>
            </div>
        </div>

        <div style="padding:0 24px 18px;">
            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:12px 16px;margin-bottom:14px;">
                <div style="display:flex;justify-content:space-between;margin-bottom:6px;font-size:12.5px;">
                    <span style="color:#64748b;font-weight:600;">ID Responden:</span>
                    <span style="font-family:monospace;font-weight:700;color:#1e293b;" id="singleModalId">#SS-00000</span>
                </div>
                <div style="display:flex;justify-content:space-between;margin-bottom:6px;font-size:12.5px;">
                    <span style="color:#64748b;font-weight:600;">Nama Lengkap:</span>
                    <strong style="color:#183B38;" id="singleModalName">-</strong>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:12.5px;">
                    <span style="color:#64748b;font-weight:600;">Kelas:</span>
                    <span style="color:#475569;font-weight:600;" id="singleModalClass">-</span>
                </div>
            </div>

            <div style="background:#fff1f2;border:1px solid #fecdd3;border-radius:9px;padding:10px 14px;font-size:12px;color:#9f1239;line-height:1.5;">
                ⚠️ <strong>Perhatian:</strong> Seluruh 20 jawaban kuesioner, hasil penilaian, dan riwayat edukasi AI siswa ini akan <strong>dihapus permanen</strong>. Tindakan ini tidak dapat dibatalkan.
            </div>
        </div>

        <form id="formDeleteSingle" method="POST" style="margin:0;">
            @csrf
            @method('DELETE')
            <div style="padding:14px 24px 18px;background:#f8fafc;border-top:1px solid #f1f5f9;display:flex;justify-content:flex-end;gap:10px;">
                <button type="button"
                        onclick="closeDeleteSingleModal()"
                        style="padding:9px 16px;background:#fff;border:1px solid #dde3eb;color:#475569;font-size:13px;font-weight:700;border-radius:8px;cursor:pointer;">
                    Batal
                </button>
                <button type="submit"
                        id="btnConfirmDeleteSingle"
                        style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#e11d48;border:none;color:#fff;font-size:13px;font-weight:700;border-radius:8px;cursor:pointer;transition:background 0.15s;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Hapus Responden
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════════
     MODAL: BERSIHKAN SELURUH DATA RESPONDEN
════════════════════════════════════════════════════════════════════ --}}
<div class="custom-modal-overlay" id="modalDeleteAll" onclick="handleModalBackdropClick(event, 'modalDeleteAll')">
    <div class="custom-modal-card" style="max-width:520px;" role="dialog" aria-modal="true" aria-labelledby="allModalTitle">
        <div style="padding:22px 24px 18px;display:flex;align-items:flex-start;gap:14px;">
            <div style="width:44px;height:44px;border-radius:10px;background:#fef2f2;border:1px solid #fee2e2;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="24" height="24" fill="none" stroke="#dc2626" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div style="flex:1;">
                <h3 id="allModalTitle" style="font-size:16px;font-weight:800;color:#991b1b;margin:0 0 4px;">Peringatan: Bersihkan Seluruh Data</h3>
                <p style="font-size:12.5px;color:#64748b;margin:0;line-height:1.5;">Tindakan ini untuk mereset seluruh responden guna memulai periode pengujian baru.</p>
            </div>
        </div>

        <form action="{{ route('admin.responden.destroyAll') }}" method="POST" id="formDeleteAll" style="margin:0;">
            @csrf
            @method('DELETE')

            <div style="padding:0 24px 18px;">
                <div style="background:#fff1f2;border:1px solid #fecdd3;border-radius:10px;padding:14px;font-size:12.5px;color:#9f1239;line-height:1.6;margin-bottom:16px;">
                    <div style="font-weight:800;margin-bottom:4px;display:flex;align-items:center;gap:6px;">
                        <span>⚠️ Penghapusan Massal Penelitian</span>
                    </div>
                    Tindakan ini akan <strong>menghapus permanen SELURUH ({{ $totalRespondents }}) data responden</strong> beserta seluruh riwayat pengerjaan, jawaban 20 soal, skor, dan edukasi AI.<br>
                    <span style="display:inline-block;margin-top:6px;color:#881337;font-weight:600;">
                        ✓ Akun admin dan master pertanyaan kuesioner tetap aman dan tidak akan terhapus.
                    </span>
                </div>

                <div style="margin-bottom:8px;">
                    <label for="confirmInputAll" style="display:block;font-size:12.5px;font-weight:700;color:#374151;margin-bottom:6px;">
                        Ketik teks konfirmasi: <code style="background:#f1f5f9;color:#be123c;padding:2px 7px;border-radius:4px;font-size:12px;font-family:monospace;border:1px solid #e2e8f0;">HAPUS DATA RESPONDEN</code>
                    </label>
                    <input type="text"
                           id="confirmInputAll"
                           name="confirmation_text"
                           placeholder="Ketik persis: HAPUS DATA RESPONDEN"
                           required
                           autocomplete="off"
                           class="admin-input"
                           style="border-color:#fecdd3;padding:10px 14px;font-size:13.5px;"
                           oninput="validateDeleteAllConfirmation(this.value)">
                    <p style="font-size:11.5px;color:#94a3b8;margin:5px 0 0;" id="confirmInputHelp">
                        Tombol hapus akan aktif otomatis setelah teks cocok persis (huruf besar).
                    </p>
                </div>
            </div>

            <div style="padding:14px 24px 18px;background:#f8fafc;border-top:1px solid #f1f5f9;display:flex;justify-content:flex-end;gap:10px;">
                <button type="button"
                        onclick="closeDeleteAllModal()"
                        style="padding:9px 16px;background:#fff;border:1px solid #dde3eb;color:#475569;font-size:13px;font-weight:700;border-radius:8px;cursor:pointer;">
                    Batal
                </button>
                <button type="submit"
                        id="btnConfirmDeleteAll"
                        disabled
                        style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#94a3b8;border:none;color:#fff;font-size:13px;font-weight:700;border-radius:8px;cursor:not-allowed;transition:all 0.15s;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Bersihkan Seluruh Responden
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Responsive grid adjustments */
    @media (max-width: 1200px) {
        .stat-grid { grid-template-columns: repeat(2,1fr) !important; }
        .filter-grid { grid-template-columns: 1fr 1fr 1fr !important; }
    }
    @media (max-width: 900px) {
        .two-col-grid { grid-template-columns: 1fr !important; }
        .filter-grid { grid-template-columns: 1fr 1fr !important; }
    }
    @media (max-width: 640px) {
        .stat-grid { grid-template-columns: repeat(2,1fr) !important; }
        .filter-grid { grid-template-columns: 1fr !important; }
    }

    /* Modal styles */
    .custom-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        z-index: 100;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }
    .custom-modal-overlay.active {
        display: flex;
    }
    .custom-modal-card {
        background: #ffffff;
        border-radius: 16px;
        max-width: 480px;
        width: 100%;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        animation: modalFadeIn 0.15s ease-out;
    }
    @keyframes modalFadeIn {
        from { transform: scale(0.96); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.location.pathname.endsWith('/admin/responden') || window.location.hash === '#daftar-responden') {
            const tableEl = document.getElementById('daftar-responden');
            if (tableEl) {
                setTimeout(() => {
                    tableEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 100);
            }
        }
    });

    function openDeleteSingleModal(actionUrl, name, formattedId, className) {
        const form = document.getElementById('formDeleteSingle');
        if (form) form.action = actionUrl;
        document.getElementById('singleModalName').textContent = name || '-';
        document.getElementById('singleModalId').textContent = formattedId || '-';
        document.getElementById('singleModalClass').textContent = className || '-';

        const modal = document.getElementById('modalDeleteSingle');
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeDeleteSingleModal() {
        const modal = document.getElementById('modalDeleteSingle');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    function openDeleteAllModal() {
        const input = document.getElementById('confirmInputAll');
        if (input) input.value = '';
        validateDeleteAllConfirmation('');

        const modal = document.getElementById('modalDeleteAll');
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            setTimeout(() => input?.focus(), 100);
        }
    }

    function closeDeleteAllModal() {
        const modal = document.getElementById('modalDeleteAll');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    function validateDeleteAllConfirmation(value) {
        const btn = document.getElementById('btnConfirmDeleteAll');
        const help = document.getElementById('confirmInputHelp');
        if (!btn) return;

        if (value.trim() === 'HAPUS DATA RESPONDEN') {
            btn.disabled = false;
            btn.style.background = '#dc2626';
            btn.style.cursor = 'pointer';
            if (help) {
                help.textContent = '✓ Teks konfirmasi cocok. Klik tombol untuk menjalankan pembersihan.';
                help.style.color = '#15803d';
            }
        } else {
            btn.disabled = true;
            btn.style.background = '#94a3b8';
            btn.style.cursor = 'not-allowed';
            if (help) {
                help.textContent = 'Ketik "HAPUS DATA RESPONDEN" untuk mengaktifkan tombol.';
                help.style.color = '#94a3b8';
            }
        }
    }

    function handleModalBackdropClick(event, modalId) {
        if (event.target && event.target.id === modalId) {
            if (modalId === 'modalDeleteSingle') closeDeleteSingleModal();
            if (modalId === 'modalDeleteAll') closeDeleteAllModal();
        }
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeDeleteSingleModal();
            closeDeleteAllModal();
        }
    });
</script>
@endpush
