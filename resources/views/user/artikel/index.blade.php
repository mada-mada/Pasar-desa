@extends('layouts.user')

@section('title', 'Berita & Artikel - Pasar Desa Indramayu')
@section('meta_description',
    'Kumpulan artikel pasar desa Indramayu dengan pencarian cepat, tampilan visual yang
    konsisten, dan ringkasan waktu baca.')



@section('context_bar')
    <div class="context-bar">
        <div class="context-bar__inner">
            <a href="{{ route('pasar.index') }}">Beranda</a>
            <i class="fas fa-chevron-right"></i>
            <span>Artikel</span>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-up {
            animation: fadeUp 0.7s cubic-bezier(0.4, 0, 0.2, 1) both;
        }

        .animate-fade-up-delay-1 {
            animation-delay: 0.12s;
        }

        .animate-fade-up-delay-2 {
            animation-delay: 0.24s;
        }
    </style>
@endsection

@section('content')
    <section class="hero-gradient overflow-hidden py-16 md:py-20">
        <div class="relative z-10 mx-auto max-w-5xl px-4 text-center sm:px-6 lg:px-8">
            <div
                class="animate-fade-up inline-flex items-center justify-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.3em] text-white/70">
                <span class="text-[#facc15]">Redaksi Pasar Desa</span>
                <span class="h-1 w-1 rounded-full bg-[#facc15]"></span>
                <span>Artikel & Wawasan</span>
            </div>

            <h1 class="animate-fade-up animate-fade-up-delay-1 mt-6 font-black leading-[1.05] tracking-tight text-white"
                style="font-size: clamp(2.2rem, 6vw, 4rem);">
                Artikel yang lebih <span class="text-[#facc15]">mudah dicari</span> dan nyaman dibaca.
            </h1>

            <p class="animate-fade-up animate-fade-up-delay-2 mx-auto mt-4 max-w-2xl text-sm leading-relaxed text-white/60 md:text-base">
                Ikuti perkembangan pasar desa, kebijakan baru, dan cerita lapangan dengan pencarian cepat dan kartu artikel
                yang lebih konsisten.
            </p>

            <div class="animate-fade-up animate-fade-up-delay-2 search-bar-wrapper mt-8 px-2 sm:px-0">
                <form action="{{ route('artikel.index') }}" method="GET" role="search">
                    <div class="relative flex items-center">
                        <i class="fas fa-search search-icon" aria-hidden="true"></i>
                        <input type="text" name="search" value="{{ request('search') }}" class="search-bar"
                            placeholder="Cari judul atau isi artikel..." autocomplete="off" aria-label="Cari artikel">
                        <button type="submit" class="search-btn">
                            <span class="hidden sm:inline">Cari Artikel</span>
                            <i class="fas fa-search sm:hidden"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="bg-[#f8f9fa] py-12 md:py-16 opacity-0 js-scroll-fade-up">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if ($artikel->isEmpty())
                <div class="empty-state rounded-2xl border border-slate-200 bg-white p-12 text-center shadow-sm">
                    <div
                        class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-blue-50 text-blue-600">
                        <i class="fas fa-newspaper text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900">Artikel Tidak Ditemukan</h3>
                    <p class="mt-2 text-slate-500">Coba kata kunci lain atau kembali ke daftar artikel penuh.</p>
                    <a href="{{ route('artikel.index') }}" class="btn-primary mt-8 inline-flex px-8 py-3">Lihat Semua
                        Artikel</a>
                </div>
            @else
                <div class="grid grid-cols-1 items-start gap-8 md:grid-cols-3 lg:grid-cols-12">
                    {{-- Main Content Side --}}
                    <div class="md:col-span-2 lg:col-span-8">
                        @if (request('search'))
                            <div
                                class="mb-10 flex items-center justify-between gap-4 border-l-4 border-blue-600 bg-white p-6 rounded-r-xl shadow-sm">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">Hasil
                                        Pencarian Untuk</p>
                                    <h2 class="text-2xl font-black text-slate-900">"{{ request('search') }}"</h2>
                                </div>
                                <span class="rounded-full bg-blue-600 px-5 py-2 text-[10px] font-black text-white">
                                    {{ $artikel->total() }} Artikel
                                </span>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 mt-6 mb-6">
                            @foreach ($artikel as $art)
                                @include('user.artikel.partials.card')
                            @endforeach
                        </div>

                        <div class="mt-16">
                            {{ $artikel->links() }}
                        </div>
                    </div>

                    {{-- Sidebar Side --}}
                    <aside class="md:col-span-1 lg:col-span-4 mt-6">
                        @php
                            $beritaTerbaru = \App\Models\Artikel::orderByDesc('tanggal_rilis')->take(5)->get();
                        @endphp

                        <div class="md:sticky md:top-28 rounded-xl border border-slate-200 bg-white shadow-sm mb-8 md:mb-0">
                            {{-- Header --}}
                            <div class="border-b border-slate-100 px-6 py-5 mt-2 mb-3">
                                <h3 class="text-[17px] font-bold text-slate-800">Berita Terbaru</h3>
                            </div>

                            {{-- Vertical List --}}
                            <div class="flex flex-col gap-3 p-4">
                                @foreach ($beritaTerbaru as $index => $terbaru)
                                    <a href="{{ route('artikel.show', $terbaru->id) }}"
                                        class="group flex items-start gap-4 rounded-xl border border-transparent p-3 transition-all hover:border-slate-100 hover:bg-slate-50 hover:shadow-sm">
                                        {{-- Thumbnail --}}
                                        <div class="shrink-0 pt-0.5">
                                            <div
                                                class="overflow-hidden rounded bg-slate-100 w-16 h-12 shadow-sm border border-slate-100/50">
                                                @if ($terbaru->gambar_sampul_url)
                                                    <img src="{{ $terbaru->gambar_sampul_url }}"
                                                        alt="{{ $terbaru->judul_artikel }}"
                                                        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                                @else
                                                    <div class="flex h-full w-full items-center justify-center">
                                                        <i class="fas fa-image text-slate-300 text-xs"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Text --}}
                                        <div class="flex-1 min-w-0">
                                            <h4
                                                class="line-clamp-2 text-[13px] font-medium leading-snug text-slate-800 transition-colors group-hover:text-blue-600">
                                                {{ $terbaru->judul_artikel }}
                                            </h4>
                                            <div class="mt-1 flex items-center gap-1 text-[11px] text-slate-500">
                                                <i class="far fa-clock"></i>
                                                {{ $terbaru->tanggal_rilis->translatedFormat('d F Y') }}
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </aside>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Scroll Animation Observer for elements that should fade up
            const fadeUpElements = document.querySelectorAll('.js-scroll-fade-up');
            if (fadeUpElements.length) {
                const fadeObserver = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.remove('opacity-0'); 
                            entry.target.classList.add('animate-fade-up');
                            fadeObserver.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.15 
                });

                fadeUpElements.forEach(function(el) {
                    fadeObserver.observe(el);
                });
            }
        });
    </script>
@endsection
