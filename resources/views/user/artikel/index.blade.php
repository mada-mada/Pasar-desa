@extends('layouts.user')

@section('title', 'Berita & Artikel - Pasar Desa Indramayu')
@section('meta_description', 'Kumpulan artikel pasar desa Indramayu dengan pencarian cepat, tampilan visual yang
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

    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        @if ($artikel->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon"><i class="fas fa-newspaper"></i></div>
                <h3 class="empty-state-title">Artikel Tidak Ditemukan</h3>
                <p class="empty-state-desc">Coba kata kunci lain atau kembali ke daftar artikel penuh.</p>
                <a href="{{ route('artikel.index') }}" class="btn-primary mt-5 inline-flex">Lihat Semua Artikel</a>
            </div>
        @else
            @php $featured = $artikel->first(); @endphp

            <div class="mb-6 flex w-full justify-center">
                <div
                    class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.2em] text-blue-600 shadow-sm">
                    <span class="relative flex h-2.5 w-2.5">
                        <span
                            class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                    </span>
                    Sorotan Utama
                </div>
            </div>

            <div class="mb-12 flex justify-center">
                <article
                    class="group flex w-full max-w-5xl flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-shadow hover:shadow-md md:flex-row md:items-center">
                    <div class="h-64 w-full shrink-0 overflow-hidden bg-slate-100 md:h-[22rem] md:w-[50%] lg:w-[55%]">
                        <a href="{{ route('artikel.show', $featured->id) }}" class="block h-full w-full">
                            @if ($featured->gambar_sampul_url)
                                <img src="{{ $featured->gambar_sampul_url }}" alt="{{ $featured->judul_artikel }}"
                                    loading="lazy"
                                    class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="flex h-full w-full items-center justify-center">
                                    <i class="fas fa-image text-6xl text-slate-300"></i>
                                </div>
                            @endif
                        </a>
                    </div>

                    <div class="flex flex-1 flex-col justify-center p-6 md:p-8">
                        <div class="mb-3 flex items-center gap-3">
                            <span
                                class="inline-flex items-center rounded-md bg-blue-100 px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-widest text-blue-700">Rilis
                                Terbaru</span>
                            <span class="text-xs font-medium text-slate-500"><i
                                    class="far fa-clock mr-1"></i>{{ $featured->tanggal_rilis->translatedFormat('d F Y') }}</span>
                        </div>

                        <a href="{{ route('artikel.show', $featured->id) }}">
                            <h2
                                class="mb-3 text-xl font-extrabold leading-tight text-slate-900 transition-colors group-hover:text-blue-600 md:text-2xl lg:text-3xl">
                                {{ $featured->judul_artikel }}
                            </h2>
                        </a>

                        <p class="mb-6 line-clamp-3 text-sm leading-relaxed text-slate-600 md:text-base">
                            {{ $featured->excerpt }}
                        </p>

                        <div class="mt-auto flex items-center justify-between border-t border-slate-100 pt-5">
                            <div class="flex items-center gap-2">
                                <div
                                    class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                    <i class="fas fa-user text-xs"></i>
                                </div>
                                <span class="text-sm font-medium text-slate-600">
                                    {{ optional($featured->penulis)->nama_lengkap ?? 'Administrator' }}
                                </span>
                            </div>
                            <a href="{{ route('artikel.show', $featured->id) }}"
                                class="btn-secondary whitespace-nowrap text-xs md:text-sm">
                                Baca <span class="hidden sm:inline">Selengkapnya</span>
                            </a>
                        </div>
                    </div>
                </article>
            </div>

            @if ($artikel->count() > 1)
                <div class="mb-4 flex items-center justify-between gap-4">
                    <div class="section-eyebrow mb-0"><span>Artikel Lainnya</span></div>
                    @if (request('search'))
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500">
                            {{ $artikel->count() }} hasil untuk "{{ request('search') }}"
                        </span>
                    @endif
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($artikel->skip(1) as $art)
                        <article
                            class="group flex h-full w-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-shadow hover:shadow-md">
                            <div class="h-48 w-full overflow-hidden bg-slate-100 sm:h-52">
                                <a href="{{ route('artikel.show', $art->id) }}" class="block h-full w-full">
                                    @if ($art->gambar_sampul_url)
                                        <img src="{{ $art->gambar_sampul_url }}" alt="{{ $art->judul_artikel }}"
                                            loading="lazy"
                                            class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center">
                                            <i class="fas fa-image text-5xl text-slate-300"></i>
                                        </div>
                                    @endif
                                </a>
                            </div>

                            <div class="flex flex-1 flex-col p-5">
                                <div class="mb-3 flex items-center justify-between">
                                    <span
                                        class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-[10px] font-semibold uppercase tracking-wider text-blue-600">Artikel</span>
                                    <span
                                        class="text-xs font-medium text-slate-500">{{ $art->tanggal_rilis->translatedFormat('d F Y') }}</span>
                                </div>

                                <a href="{{ route('artikel.show', $art->id) }}" class="mb-2 block">
                                    <h3
                                        class="line-clamp-2 text-lg font-bold leading-snug text-slate-900 transition-colors group-hover:text-blue-600">
                                        {{ $art->judul_artikel }}
                                    </h3>
                                </a>

                                <p class="mb-5 line-clamp-2 text-sm leading-relaxed text-slate-600">
                                    {{ $art->excerpt }}
                                </p>

                                <div class="mt-auto flex items-center justify-between border-t border-slate-100 pt-4">
                                    <span class="text-xs font-medium text-slate-500">
                                        {{ optional($art->penulis)->nama_lengkap ?? 'Administrator' }}
                                    </span>
                                    <a href="{{ route('artikel.show', $art->id) }}"
                                        class="text-xs font-semibold text-blue-600 transition-colors hover:text-blue-800 flex items-center gap-1">
                                        Baca <i class="fas fa-arrow-right text-[10px]"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        @endif
    </section>
@endsection
