@extends('layouts.user')

@section('title', 'Berita & Artikel - Pasar Desa Indramayu')
@section('meta_description',
    'Kumpulan artikel pasar desa Indramayu dengan pencarian cepat, tampilan visual yang
    konsisten, dan ringkasan waktu baca.')

@section('styles')
    <style>
        .article-grid-container {
            display: flex;
            flex-direction: column-reverse; /* News on top for mobile */
            gap: 2.5rem;
        }

        .article-content-area {
            width: 100%;
        }

        .article-sidebar-area {
            width: 100%;
        }

        @media (min-width: 1024px) {
            .article-grid-container {
                flex-direction: row; /* Content left, sidebar right for desktop */
                display: grid;
                grid-template-columns: repeat(12, minmax(0, 1fr));
            }

            .article-content-area {
                grid-column: span 8 / span 8;
            }

            .article-sidebar-area {
                grid-column: span 4 / span 4;
            }
        }
    </style>
@endsection

@section('context_bar')
    <div class="context-bar">
        <div class="context-bar__inner">
            <a href="{{ route('pasar.index') }}">Beranda</a>
            <i class="fas fa-chevron-right"></i>
            <span>Artikel</span>
        </div>
    </div>
@endsection

@section('content')
    <section class="hero-gradient overflow-hidden py-16 md:py-20">
        <div class="relative z-10 mx-auto max-w-5xl px-4 text-center sm:px-6 lg:px-8">
            <div
                class="inline-flex items-center justify-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.3em] text-white/70">
                <span class="text-[#facc15]">Redaksi Pasar Desa</span>
                <span class="h-1 w-1 rounded-full bg-[#facc15]"></span>
                <span>Artikel & Wawasan</span>
            </div>

            <h1 class="mt-6 font-black leading-[1.05] tracking-tight text-white"
                style="font-size: clamp(2.2rem, 6vw, 4rem);">
                Artikel yang lebih <span class="text-[#facc15]">mudah dicari</span> dan nyaman dibaca.
            </h1>

            <p class="mx-auto mt-4 max-w-2xl text-sm leading-relaxed text-white/60 md:text-base">
                Ikuti perkembangan pasar desa, kebijakan baru, dan cerita lapangan dengan pencarian cepat dan kartu artikel
                yang lebih konsisten.
            </p>

            <div class="search-bar-wrapper mt-8 px-2 sm:px-0">
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

    <section class="bg-[#f8f9fa] py-12 md:py-16">
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
                <div class="article-grid-container">
                    {{-- Main Content Side --}}
                    <div class="article-content-area">
                        @if (request('search'))
                            <div class="mb-10 flex items-center justify-between gap-4 border-l-4 border-blue-600 bg-white p-6 rounded-r-xl shadow-sm">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">Hasil Pencarian Untuk</p>
                                    <h2 class="text-2xl font-black text-slate-900">"{{ request('search') }}"</h2>
                                </div>
                                <span class="rounded-full bg-blue-600 px-5 py-2 text-[10px] font-black text-white">
                                    {{ $artikel->total() }} Artikel
                                </span>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2">
                            @foreach ($artikel as $art)
                                <article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white transition-all duration-300 hover:border-blue-400 hover:shadow-2xl hover:shadow-blue-900/5">
                                    {{-- Visual Header: Forced Normalization --}}
                                    <div class="relative w-full overflow-hidden bg-slate-100" style="height: 220px;">
                                        <a href="{{ route('artikel.show', $art->id) }}" class="block h-full w-full">
                                            @if ($art->gambar_sampul_url)
                                                <img src="{{ $art->gambar_sampul_url }}" alt="{{ $art->judul_artikel }}"
                                                    loading="lazy"
                                                    class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
                                            @else
                                                <div class="flex h-full w-full items-center justify-center bg-slate-100">
                                                    <i class="fas fa-image text-4xl text-slate-300"></i>
                                                </div>
                                            @endif
                                            
                                            <div class="absolute left-5 top-5">
                                                <span class="rounded-full bg-blue-600/90 px-4 py-1.5 text-[10px] font-bold uppercase tracking-widest text-white shadow-lg backdrop-blur-sm">
                                                    Warta Desa
                                                </span>
                                            </div>
                                        </a>
                                    </div>

                                    {{-- Content Body --}}
                                    <div class="flex flex-1 flex-col p-8">
                                        <div class="mb-3 flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                                            <i class="far fa-calendar-alt text-blue-500"></i>
                                            {{ $art->tanggal_rilis->translatedFormat('d F Y') }}
                                        </div>

                                        <a href="{{ route('artikel.show', $art->id) }}" class="mb-4 block">
                                            <h2 class="line-clamp-2 text-xl font-extrabold leading-tight text-slate-900 transition-colors group-hover:text-blue-600">
                                                {{ $art->judul_artikel }}
                                            </h2>
                                        </a>

                                        <p class="mb-8 line-clamp-3 text-sm leading-relaxed text-slate-600">
                                            {{ $art->excerpt ?? Str::limit(strip_tags($art->isi_konten), 140) }}
                                        </p>

                                        <div class="mt-auto border-t border-slate-100 pt-6">
                                            <a href="{{ route('artikel.show', $art->id) }}" class="inline-flex items-center gap-3 text-sm font-black text-blue-600 transition-all hover:gap-5 hover:text-blue-700">
                                                Baca Selengkapnya <i class="fas fa-arrow-right text-[10px]"></i>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <div class="mt-16">
                            {{ $artikel->links() }}
                        </div>
                    </div>

                    {{-- Sidebar Side --}}
                    <aside class="article-sidebar-area">
                        @php
                            $beritaTerbaru = \App\Models\Artikel::orderByDesc('tanggal_rilis')->take(5)->get();
                        @endphp

                        <div class="sticky top-24 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl shadow-slate-200/50">
                            {{-- High-Highlight Header --}}
                            <div class="border-b border-slate-100 bg-slate-50/50 p-6">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-black tracking-tight text-slate-900">Berita Terbaru</h3>
                                    <span class="flex items-center gap-2 rounded-full bg-blue-100 px-3 py-1.5 text-[9px] font-black uppercase text-blue-700">
                                        <span class="relative flex h-2 w-2">
                                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-400 opacity-75"></span>
                                            <span class="relative inline-flex h-2 w-2 rounded-full bg-blue-600"></span>
                                        </span>
                                        Live
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col p-3">
                                @foreach ($beritaTerbaru as $index => $terbaru)
                                    <a href="{{ route('artikel.show', $terbaru->id) }}"
                                        class="group flex items-start gap-4 rounded-xl p-4 transition-all duration-300 hover:bg-blue-50/50">
                                        <div class="relative shrink-0">
                                            <div class="overflow-hidden rounded-xl bg-slate-100 shadow-sm"
                                                style="width: 72px; height: 72px;">
                                                @if ($terbaru->gambar_sampul_url)
                                                    <img src="{{ $terbaru->gambar_sampul_url }}"
                                                        alt="{{ $terbaru->judul_artikel }}"
                                                        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                                                @else
                                                    <div class="flex h-full w-full items-center justify-center">
                                                        <i class="fas fa-image text-slate-300 text-xl"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($index === 0)
                                                <div class="absolute -right-2 -top-2 flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-[10px] font-black text-white shadow-xl ring-4 ring-white">
                                                    1
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex flex-col pt-1">
                                            <h4 class="mb-1.5 line-clamp-2 text-sm font-bold leading-snug text-slate-800 transition-colors group-hover:text-blue-600">
                                                {{ $terbaru->judul_artikel }}
                                            </h4>
                                            <div class="flex items-center gap-2 text-[10px] font-bold uppercase text-slate-400">
                                                <i class="far fa-clock text-blue-400"></i>
                                                {{ $terbaru->tanggal_rilis->translatedFormat('d M Y') }}
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>

                            <div class="bg-slate-50/50 p-6">
                                <a href="{{ route('artikel.index') }}"
                                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-slate-900 py-4 text-xs font-black uppercase tracking-widest text-white transition-all hover:bg-blue-600 hover:shadow-xl hover:shadow-blue-200">
                                    Eksplorasi Semua <i class="fas fa-chevron-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </aside>
                </div>
            @endif
        </div>
    </section>
@endsection
