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
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
                    {{-- Main Content: 8 Columns --}}
                    <div class="lg:col-span-8">
                        @if (request('search'))
                            <div
                                class="mb-8 flex items-center justify-between gap-4 border-l-4 border-blue-600 bg-white p-5 rounded-r-xl shadow-sm">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-[0.1em] text-slate-400">Hasil
                                        Pencarian</p>
                                    <h2 class="text-xl font-black text-slate-900">"{{ request('search') }}"</h2>
                                </div>
                                <span class="rounded-full bg-blue-600 px-4 py-1.5 text-[10px] font-black text-white">
                                    {{ $artikel->count() }} Temuan
                                </span>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            @foreach ($artikel as $art)
                                <article
                                    class="group flex h-full flex-col overflow-hidden rounded-xl border border-slate-200 bg-white transition-all duration-300 hover:border-blue-400 hover:shadow-lg">
                                    {{-- Visual Header: Inline style forced height --}}
                                    <div class="relative w-full overflow-hidden bg-slate-100" style="height: 220px;">
                                        <a href="{{ route('artikel.show', $art->id) }}" class="block h-full w-full">
                                            @if ($art->gambar_sampul_url)
                                                <img src="{{ $art->gambar_sampul_url }}" alt="{{ $art->judul_artikel }}"
                                                    loading="lazy"
                                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                            @else
                                                <div class="flex h-full w-full items-center justify-center bg-slate-100">
                                                    <i class="fas fa-image text-3xl text-slate-300"></i>
                                                </div>
                                            @endif

                                            <div class="absolute left-4 top-4">
                                                <span
                                                    class="rounded-lg bg-blue-600 px-3 py-1 text-[9px] font-bold uppercase tracking-wider text-white shadow-sm">
                                                    Warta
                                                </span>
                                            </div>
                                        </a>
                                    </div>

                                    {{-- Content Body --}}
                                    <div class="flex flex-1 flex-col p-6">
                                        <div class="mb-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                                            {{ $art->tanggal_rilis->translatedFormat('d F Y') }}
                                        </div>

                                        <a href="{{ route('artikel.show', $art->id) }}" class="mb-3 block">
                                            <h2
                                                class="line-clamp-2 text-lg font-bold leading-tight text-slate-900 group-hover:text-blue-600">
                                                {{ $art->judul_artikel }}
                                            </h2>
                                        </a>

                                        <p class="mb-6 line-clamp-3 text-sm leading-relaxed text-slate-600">
                                            {{ $art->excerpt ?? Str::limit(strip_tags($art->isi_artikel), 120) }}
                                        </p>

                                        <div class="mt-auto">
                                            <a href="{{ route('artikel.show', $art->id) }}"
                                                class="inline-flex items-center gap-2 text-sm font-bold text-blue-600 transition-colors hover:text-blue-700">
                                                Baca Selengkapnya <i class="fas fa-arrow-right text-[10px]"></i>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>

                    {{-- Sidebar: 4 Columns --}}
                    <aside class="flex flex-col gap-6 lg:col-span-4">
                        @php
                            $beritaTerbaru = \App\Models\Artikel::orderByDesc('tanggal_rilis')->take(5)->get();
                        @endphp

                        <div class="sticky top-24 rounded-xl border border-slate-200 bg-[#f8f9fa] p-6">
                            <h3 class="mb-6 border-b border-slate-200 pb-4 text-lg font-bold text-slate-900">
                                Berita Terbaru
                            </h3>

                            <div class="flex flex-col gap-6">
                                @foreach ($beritaTerbaru as $terbaru)
                                    <a href="{{ route('artikel.show', $terbaru->id) }}"
                                        class="group flex items-start gap-4">
                                        <div class="shrink-0 overflow-hidden rounded-lg bg-white shadow-sm"
                                            style="width: 64px; height: 64px;">
                                            @if ($terbaru->gambar_sampul_url)
                                                <img src="{{ $terbaru->gambar_sampul_url }}"
                                                    alt="{{ $terbaru->judul_artikel }}"
                                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                                            @else
                                                <div class="flex h-full w-full items-center justify-center">
                                                    <i class="fas fa-image text-slate-200 text-lg"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex flex-col pt-0.5">
                                            <h4
                                                class="mb-1 line-clamp-2 text-sm font-bold leading-snug text-slate-900 group-hover:text-blue-600">
                                                {{ $terbaru->judul_artikel }}
                                            </h4>
                                            <span class="text-[10px] font-bold text-slate-400 uppercase">
                                                {{ $terbaru->tanggal_rilis->translatedFormat('d M Y') }}
                                            </span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>

                            <div class="mt-8">
                                <a href="{{ route('artikel.index') }}"
                                    class="flex w-full items-center justify-center gap-2 rounded-lg bg-blue-600 py-3 text-sm font-bold text-white transition-all hover:bg-blue-700 shadow-md shadow-blue-200">
                                    Lihat Semua Artikel <i class="fas fa-chevron-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </aside>
                </div>
            @endif
        </div>
    </section>
@endsection
