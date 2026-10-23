@extends('layouts.app')

@section('title', 'Smile Score - Segera Dimulai')
@section('meta_description', 'Halaman persiapan Smile Score untuk siswa SMK.')

@section('content')
<section class="min-h-[75vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg w-full text-center">
        <!-- Mascot Tooth Badge -->
        <div class="relative inline-block mb-6">
            <div class="w-32 h-32 mx-auto rounded-3xl bg-[#E6F7F5] border-2 border-[#D9EAE4] flex items-center justify-center shadow-lg p-2 animate-float">
                <img src="{{ asset('images/cta_tooth_mascot.jpg') }}" alt="Maskot Gigi Ceria" class="w-full h-full object-cover rounded-2xl">
            </div>
            <div class="absolute -top-2 -right-2 bg-amber-400 text-slate-900 text-xs font-extrabold px-2.5 py-1 rounded-full shadow">
                Coming Soon ✨
            </div>
        </div>

        <!-- Heading -->
        <h1 class="text-3xl sm:text-4xl font-extrabold text-navy-900 tracking-tight mb-3">
            Smile Score akan Segera Dimulai!
        </h1>

        <!-- Subtitle -->
        <p class="text-slate-600 text-base leading-relaxed mb-8">
            Modul kuesioner dan penilaian mandiri kesehatan gigi &amp; mulut untuk siswa SMK sedang dipersiapkan. Senyum sehat dan percaya diri segera menantimu!
        </p>

        <!-- Information Card -->
        <div class="bg-white rounded-2xl border border-[#D9EAE4] p-6 shadow-sm mb-8 text-left space-y-3">
            <div class="flex items-start gap-3">
                <div class="w-7 h-7 rounded-full bg-[#DDF5EC] text-brand-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-slate-800">Pertanyaan Mudah &amp; Cepat</h2>
                    <p class="text-xs text-slate-500">Hanya butuh 3-5 menit untuk mengetahui skor kesehatan gigimu.</p>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <div class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-slate-800">Edukasi &amp; Rekomendasi Terarah</h2>
                    <p class="text-xs text-slate-500">Rekomendasi disesuaikan khusus untuk kebiasaan siswa sekolah menengah kejuruan.</p>
                </div>
            </div>
        </div>

        <!-- Back to Home CTA -->
        <div>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-7 py-3 rounded-full bg-brand-500 hover:bg-brand-600 text-white font-semibold text-sm shadow-md hover:shadow-lg transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Kembali ke Beranda</span>
            </a>
        </div>
    </div>
</section>
@endsection
