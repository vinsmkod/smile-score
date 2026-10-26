@extends('layouts.admin')

@section('title', 'Detail ' . $submission->formatted_id . ' — Admin Smile Score')
@section('meta_description', 'Detail biodata, hasil evaluasi, dan rincian jawaban kuesioner responden penelitian Smile Score.')
@section('page-title', 'Detail Responden')
@section('breadcrumb')
Admin › <a href="{{ route('admin.responden') }}" style="color:#168C83;text-decoration:none;font-weight:600;">Data Responden</a> › {{ $submission->formatted_id }}
@endsection

@section('content')

{{-- ─── Back Navigation ─────────────────────────────────────────── --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px;">
    <a href="{{ route('admin.responden') }}"
        style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;background:#fff;border:1px solid #e5e9f0;border-radius:8px;color:#374151;font-size:13px;font-weight:700;text-decoration:none;transition:background 0.15s;"
        onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Daftar Responden
    </a>

    <div style="display:flex;align-items:center;gap:8px;">
        @if ($isCompleted)
        <a href="{{ route('admin.export', ['format' => 'xlsx', 'scope' => 'all']) }}"
            class="btn-excel" style="font-size:12.5px;padding:8px 14px;">
            <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24">
                <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z" />
            </svg>
            Ekspor Data
        </a>
        @endif
        <button type="button"
                onclick="openDetailDeleteModal()"
                style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;background:#fff;border:1.5px solid #fecdd3;color:#e11d48;font-size:12.5px;font-weight:700;border-radius:8px;cursor:pointer;transition:all 0.15s;"
                onmouseover="this.style.background='#fff1f2';this.style.borderColor='#e11d48'"
                onmouseout="this.style.background='#fff';this.style.borderColor='#fecdd3'"
                id="btn-delete-detail">
            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Hapus Responden
        </button>
    </div>
</div>

{{-- ─── Profile Banner ──────────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:20px;">
    <div style="padding:24px;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:20px;">

        {{-- Left: Identity --}}
        <div style="display:flex;align-items:center;gap:16px;">
            <div style="width:60px;height:60px;border-radius:14px;
                {{ $submission->category === 'Baik' ? 'background:#dcfce7;' : ($submission->category === 'Cukup' ? 'background:#fef9c3;' : 'background:#ffe4e6;') }}
                display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:26px;">
                @if ($submission->category === 'Baik') 😍
                @elseif ($submission->category === 'Cukup') 😉
                @elseif ($submission->status === 'completed') 🤨
                @else 👤
                @endif
            </div>
            <div>
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:5px;flex-wrap:wrap;">
                    <span style="font-family:monospace;font-size:12px;font-weight:800;background:#f1f5f9;color:#475569;padding:3px 9px;border-radius:6px;">
                        {{ $submission->formatted_id }}
                    </span>
                    @if ($isCompleted)
                    <span class="badge badge-success">
                        <svg width="9" height="9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                        Kuesioner Selesai
                    </span>
                    @else
                    <span class="badge badge-warning">Belum Selesai (Draft)</span>
                    @endif
                </div>
                <h1 style="font-size:20px;font-weight:800;color:#183B38;margin:0 0 3px;">{{ $submission->name }}</h1>
                <p style="font-size:13px;color:#64748b;margin:0;">
                    Kelas {{ $submission->class_name }} &bull; {{ $submission->age }} Tahun &bull; {{ $submission->gender }}
                </p>
            </div>
        </div>

        {{-- Right: Score Summary --}}
        @if ($isCompleted)
        <div style="background:#f8fffe;border:1px solid #d1fae5;border-radius:12px;padding:16px 24px;text-align:center;min-width:160px;">
            <div style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.07em;margin-bottom:4px;">Skor Akhir</div>
            <div style="font-size:34px;font-weight:800;color:#168C83;line-height:1;">{{ $submission->percentage }}%</div>
            <div style="font-size:12px;color:#64748b;margin-top:2px;">{{ $submission->correct_count }}/20 benar</div>
            <div style="margin-top:8px;">
                @if ($submission->category === 'Baik')
                <span class="badge badge-baik">Baik</span>
                @elseif ($submission->category === 'Cukup')
                <span class="badge badge-cukup">Cukup</span>
                @else
                <span class="badge badge-kurang">Kurang Baik</span>
                @endif
            </div>
        </div>
        @endif

    </div>
</div>

{{-- ─── Two Column Layout ───────────────────────────────────────── --}}
<div style="display:grid;grid-template-columns:300px 1fr;gap:20px;align-items:start;" class="detail-grid">

    {{-- ══ LEFT COLUMN ════════════════════════════════════════════ --}}
    <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- Biodata Card --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <div style="display:flex;align-items:center;gap:8px;">
                    <svg width="15" height="15" fill="none" stroke="#168C83" viewBox="0 0 24 24">
                        <circle cx="12" cy="8" r="4" stroke-width="2" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                    </svg>
                    <span style="font-size:13px;font-weight:800;color:#183B38;">Biodata Siswa</span>
                </div>
            </div>
            <div style="padding:16px 20px;">
                @php
                $biodataItems = [
                ['label' => 'ID Responden', 'value' => $submission->formatted_id, 'mono' => true],
                ['label' => 'Nama Lengkap', 'value' => $submission->name],
                ['label' => 'Usia', 'value' => $submission->age . ' Tahun'],
                ['label' => 'Jenis Kelamin', 'value' => $submission->gender],
                ['label' => 'Kelas', 'value' => $submission->class_name],
                ['label' => 'Mulai', 'value' => $submission->started_at
                ? $submission->started_at->format('d M Y, H:i') . ' WIB'
                : ($submission->created_at ? $submission->created_at->format('d M Y, H:i') . ' WIB' : '—')],
                ['label' => 'Selesai', 'value' => $submission->completed_at
                ? $submission->completed_at->format('d M Y, H:i') . ' WIB'
                : ($isCompleted ? $submission->updated_at->format('d M Y, H:i') . ' WIB' : 'Belum selesai')],
                ];
                @endphp
                @foreach ($biodataItems as $i => $bd)
                <div style="display:flex;flex-direction:column;gap:2px;padding:10px 0;{{ $i < count($biodataItems)-1 ? 'border-bottom:1px solid #f1f5f9;' : '' }}">
                    <span style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;">{{ $bd['label'] }}</span>
                    <span style="{{ isset($bd['mono']) && $bd['mono'] ? 'font-family:monospace;' : '' }}font-size:13.5px;font-weight:700;color:#1e293b;">
                        {{ $bd['value'] }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Hasil Kuesioner Card --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <div style="display:flex;align-items:center;gap:8px;">
                    <svg width="15" height="15" fill="none" stroke="#168C83" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span style="font-size:13px;font-weight:800;color:#183B38;">Hasil Kuesioner</span>
                </div>
            </div>
            <div style="padding:16px 20px;">
                @php
                $hasilItems = [
                ['label' => 'Status', 'value' => $isCompleted ? 'Selesai (20/20)' : 'Belum Selesai (Draft)',
                'color' => $isCompleted ? '#15803d' : '#b45309'],
                ['label' => 'Soal Dijawab', 'value' => $submission->answered_count . ' dari 20 Soal', 'color' => null],
                ['label' => 'Jawaban Benar', 'value' => $isCompleted ? $submission->correct_count : '—', 'color' => '#15803d'],
                ['label' => 'Jawaban Salah', 'value' => $isCompleted ? (20 - $submission->correct_count) : '—', 'color' => '#be123c'],
                ['label' => 'Nilai Persentase','value' => $isCompleted ? $submission->percentage . '%' : '—', 'color' => '#168C83'],
                ['label' => 'Kategori Literasi','value' => $isCompleted ? $submission->category : 'Belum dievaluasi', 'color' => null],
                ];
                @endphp
                @foreach ($hasilItems as $i => $h)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:9px 0;{{ $i < count($hasilItems)-1 ? 'border-bottom:1px solid #f1f5f9;' : '' }}">
                    <span style="font-size:12.5px;color:#64748b;font-weight:500;">{{ $h['label'] }}</span>
                    <span style="font-size:13px;font-weight:800;{{ $h['color'] ? 'color:' . $h['color'] . ';' : 'color:#1e293b;' }}">
                        {{ $h['value'] }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- ══ RIGHT COLUMN: 20 Soal ══════════════════════════════════ --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <div style="font-size:14px;font-weight:800;color:#183B38;">Rincian Jawaban 20 Soal Kuesioner</div>
                <div style="font-size:12px;color:#64748b;margin-top:2px;">Kunci jawaban resmi hanya tersedia di panel admin terproteksi</div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:700;color:#15803d;background:#dcfce7;padding:4px 10px;border-radius:6px;">
                    <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                    Benar
                </span>
                <span style="display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:700;color:#be123c;background:#ffe4e6;padding:4px 10px;border-radius:6px;">
                    <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Salah
                </span>
            </div>
        </div>

        <div style="padding:8px 20px;">
            @foreach ($questionDetails as $item)
            <div style="padding:16px 0;{{ !$loop->last ? 'border-bottom:1px solid #f8fafc;' : '' }}">

                {{-- Question header --}}
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:10px;">
                    <div style="display:flex;align-items:flex-start;gap:10px;flex:1;min-width:0;">
                        <span style="flex-shrink:0;width:24px;height:24px;border-radius:6px;background:#f1f5f9;color:#475569;font-size:11.5px;font-weight:800;display:flex;align-items:center;justify-content:center;margin-top:1px;">
                            {{ $item['number'] }}
                        </span>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:10.5px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;margin-bottom:3px;">
                                {{ $item['topic'] }}
                            </div>
                            <p style="font-size:13.5px;font-weight:600;color:#1e293b;margin:0;line-height:1.5;">
                                {{ $item['question'] }}
                            </p>
                        </div>
                    </div>

                    {{-- Status badge --}}
                    <div style="flex-shrink:0;">
                        @if (!$item['has_answered'])
                        <span class="badge" style="background:#f1f5f9;color:#64748b;">Belum Dijawab</span>
                        @elseif ($item['is_correct'])
                        <span class="badge badge-success">
                            <svg width="9" height="9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                            Benar
                        </span>
                        @else
                        <span class="badge badge-kurang">
                            <svg width="9" height="9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Salah
                        </span>
                        @endif
                    </div>
                </div>

                {{-- Answer comparison --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;padding-left:34px;">
                    {{-- Jawaban Siswa --}}
                    <div style="padding:10px 12px;border-radius:8px;
                            {{ !$item['has_answered'] ? 'background:#f8fafc;border:1px solid #e5e9f0;' : ($item['is_correct'] ? 'background:#f0fdf4;border:1px solid #bbf7d0;' : 'background:#fff1f2;border:1px solid #fecdd3;') }}">
                        <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;
                                {{ $item['is_correct'] ? 'color:#15803d;' : 'color:#94a3b8;' }}">
                            Jawaban Siswa
                        </div>
                        @if ($item['has_answered'])
                        <div style="font-size:13px;font-weight:700;color:#1e293b;">
                            <span style="text-transform:uppercase;">({{ $item['selected_option'] }})</span>
                            {{ $item['selected_text'] }}
                        </div>
                        @else
                        <div style="font-size:12.5px;color:#94a3b8;font-style:italic;">Belum Dijawab</div>
                        @endif
                    </div>

                    {{-- Kunci Jawaban --}}
                    <div style="padding:10px 12px;border-radius:8px;background:#f8fffe;border:1px solid #d1fae5;">
                        <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#64748b;margin-bottom:4px;">
                            Kunci Jawaban Resmi
                        </div>
                        <div style="font-size:13px;font-weight:700;color:#168C83;">
                            <span style="text-transform:uppercase;">({{ $item['correct_option'] }})</span>
                            {{ $item['correct_text'] }}
                        </div>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

    </div>

</div>

{{-- ═══════════════════════════════════════════════════════════════════
     MODAL: HAPUS RESPONDEN INI
════════════════════════════════════════════════════════════════════ --}}
<div class="custom-modal-overlay" id="modalDeleteDetail" onclick="handleDetailBackdropClick(event)">
    <div class="custom-modal-card" role="dialog" aria-modal="true" aria-labelledby="detailModalTitle">
        <div style="padding:22px 24px 18px;display:flex;align-items:flex-start;gap:14px;">
            <div style="width:42px;height:42px;border-radius:10px;background:#fee2e2;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="22" height="22" fill="none" stroke="#dc2626" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <div style="flex:1;">
                <h3 id="detailModalTitle" style="font-size:16px;font-weight:800;color:#183B38;margin:0 0 4px;">Konfirmasi Hapus Responden</h3>
                <p style="font-size:12.5px;color:#64748b;margin:0;line-height:1.5;">Apakah Anda yakin ingin menghapus data responden penelitian ini?</p>
            </div>
        </div>

        <div style="padding:0 24px 18px;">
            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:12px 16px;margin-bottom:14px;">
                <div style="display:flex;justify-content:space-between;margin-bottom:6px;font-size:12.5px;">
                    <span style="color:#64748b;font-weight:600;">ID Responden:</span>
                    <span style="font-family:monospace;font-weight:700;color:#1e293b;">{{ $submission->formatted_id }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;margin-bottom:6px;font-size:12.5px;">
                    <span style="color:#64748b;font-weight:600;">Nama Lengkap:</span>
                    <strong style="color:#183B38;">{{ $submission->name }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:12.5px;">
                    <span style="color:#64748b;font-weight:600;">Kelas:</span>
                    <span style="color:#475569;font-weight:600;">{{ $submission->class_name }}</span>
                </div>
            </div>

            <div style="background:#fff1f2;border:1px solid #fecdd3;border-radius:9px;padding:10px 14px;font-size:12px;color:#9f1239;line-height:1.5;">
                ⚠️ <strong>Perhatian:</strong> Seluruh 20 jawaban kuesioner, hasil penilaian, dan riwayat edukasi AI siswa ini akan <strong>dihapus permanen</strong>. Tindakan ini tidak dapat dibatalkan.
            </div>
        </div>

        <form action="{{ route('admin.responden.destroy', $submission->id) }}" method="POST" style="margin:0;">
            @csrf
            @method('DELETE')
            <div style="padding:14px 24px 18px;background:#f8fafc;border-top:1px solid #f1f5f9;display:flex;justify-content:flex-end;gap:10px;">
                <button type="button"
                        onclick="closeDetailDeleteModal()"
                        style="padding:9px 16px;background:#fff;border:1px solid #dde3eb;color:#475569;font-size:13px;font-weight:700;border-radius:8px;cursor:pointer;">
                    Batal
                </button>
                <button type="submit"
                        id="btnConfirmDeleteDetail"
                        style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#e11d48;border:none;color:#fff;font-size:13px;font-weight:700;border-radius:8px;cursor:pointer;transition:background 0.15s;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Hapus Responden
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
<style>
    @media (max-width: 900px) {
        .detail-grid {
            grid-template-columns: 1fr !important;
        }
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
    function openDetailDeleteModal() {
        const modal = document.getElementById('modalDeleteDetail');
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeDetailDeleteModal() {
        const modal = document.getElementById('modalDeleteDetail');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    function handleDetailBackdropClick(event) {
        if (event.target && event.target.id === 'modalDeleteDetail') {
            closeDetailDeleteModal();
        }
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeDetailDeleteModal();
        }
    });
</script>
@endpush