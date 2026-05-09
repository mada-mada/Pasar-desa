@extends('layouts.user')

@section('title', Str::limit($artikel->judul_artikel, 60) . ' - Pasar Desa Indramayu')
@section('meta_description', Str::limit(strip_tags($artikel->isi_konten), 155))

@section('context_bar')
    <div class="context-bar">
        <div class="context-bar__inner">
            <a href="{{ route('pasar.index') }}">Beranda</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('artikel.index') }}">Artikel</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ Str::limit($artikel->judul_artikel, 48) }}</span>
        </div>
    </div>
@endsection

@section('content')
    <section class="hero-gradient relative overflow-hidden pb-16 pt-14">
        <div class="absolute inset-0">
            @if ($artikel->gambar_sampul_url)
                <img src="{{ $artikel->gambar_sampul_url }}" alt="{{ $artikel->judul_artikel }}" class="h-full w-full object-cover opacity-25">
            @endif
            <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(15,23,42,0.52),rgba(15,23,42,0.95))]"></div>
        </div>

        <div class="relative z-10 mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="mb-4 flex flex-wrap items-center gap-3 text-[11px] font-bold uppercase tracking-[0.18em] text-[#facc15]">
                <span>{{ $artikel->tanggal_rilis->translatedFormat('d F Y') }}</span>
                <span class="h-1 w-1 rounded-full bg-white/30"></span>
                <span>{{ $artikel->reading_time }} menit baca</span>
                <span class="h-1 w-1 rounded-full bg-white/30"></span>
                <span>{{ optional($artikel->penulis)->nama_lengkap ?? 'Administrator' }}</span>
            </div>

            <h1 class="max-w-4xl text-4xl font-black leading-tight tracking-tight text-white md:text-6xl">
                {{ $artikel->judul_artikel }}
            </h1>

            <p class="mt-5 max-w-3xl text-base leading-relaxed text-white/70 md:text-lg">
                {{ $artikel->context_excerpt }}
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="article-layout">
            <aside class="article-toc">
                <div class="section-eyebrow"><span>Navigasi</span></div>
                <h2 class="mb-4 text-xl font-black text-[#0f172a]">Ringkasan artikel</h2>

                <div class="space-y-3 rounded-[1.5rem] border border-slate-200 bg-white p-5 shadow-sm">
                    <div>
                        <strong class="block text-xs uppercase tracking-[0.2em] text-slate-400">Waktu baca</strong>
                        <p class="mt-2 text-lg font-bold text-slate-800">{{ $artikel->reading_time }} menit</p>
                    </div>
                    <div>
                        <strong class="block text-xs uppercase tracking-[0.2em] text-slate-400">Ditulis oleh</strong>
                        <p class="mt-2 text-lg font-bold text-slate-800">{{ optional($artikel->penulis)->nama_lengkap ?? 'Administrator' }}</p>
                    </div>
                </div>

                @if ($headings->isNotEmpty())
                    <div class="mt-5 rounded-[1.5rem] border border-slate-200 bg-white p-5 shadow-sm">
                        <strong class="block text-xs uppercase tracking-[0.2em] text-slate-400">Table of Contents</strong>
                        <ol class="mt-4 space-y-3 text-sm leading-relaxed text-slate-600">
                            @foreach ($headings as $heading)
                                <li>{{ $heading }}</li>
                            @endforeach
                        </ol>
                    </div>
                @endif
            </aside>

            <article class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm md:p-10">
                @if ($artikel->gambar_sampul_url)
                    <img src="{{ $artikel->gambar_sampul_url }}" alt="{{ $artikel->judul_artikel }}" class="mb-8 h-[320px] w-full rounded-[1.25rem] object-cover shadow-sm md:h-[420px]">
                @endif

                @if ($artikel->context_points->isNotEmpty())
                    <div class="mb-8 rounded-[1.5rem] border border-slate-200 bg-slate-50 p-5">
                        <strong class="block text-xs uppercase tracking-[0.2em] text-slate-400">Konteks Singkat</strong>
                        <div class="mt-4 space-y-3 text-sm leading-relaxed text-slate-600 md:text-base">
                            @foreach ($artikel->context_points as $point)
                                <p>{{ $point }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="prose article-prose max-w-none">
                    {!! nl2br(e($artikel->isi_konten)) !!}
                </div>

                <div class="mt-10 border-t border-slate-100 pt-6">
                    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                        <strong class="text-lg font-black text-[#0f172a]">Bagikan artikel ini</strong>
                        <div class="flex flex-wrap gap-3">
                            <a href="https://wa.me/?text={{ urlencode($artikel->judul_artikel . ' - ' . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="btn-secondary">
                                <i class="fab fa-whatsapp"></i>
                                WhatsApp
                            </a>
                            <button type="button" class="btn-secondary" id="copy-article-link" data-url="{{ url()->current() }}">
                                <i class="fas fa-link"></i>
                                Copy Link
                            </button>
                        </div>
                    </div>
                    <a href="{{ route('artikel.index') }}" class="btn-primary">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Daftar Artikel
                    </a>
                </div>
            </article>
        </div>
    </section>

    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "Article",
            "headline": @json($artikel->judul_artikel),
            "datePublished": @json($artikel->tanggal_rilis?->toIso8601String()),
            "author": {
                "@@type": "Person",
                "name": @json(optional($artikel->penulis)->nama_lengkap ?? 'Administrator')
            },
            "image": @json($artikel->gambar_sampul_url),
            "description": @json(Str::limit(strip_tags($artikel->isi_konten), 155))
            @if($artikel->total_ulasan > 0)
            ,"aggregateRating": {
                "@@type": "AggregateRating",
                "ratingValue": "{{ number_format($artikel->rata_rata_rating, 1) }}",
                "reviewCount": "{{ $artikel->total_ulasan }}"
            }
            @endif
        }
    </script>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const copyButton = document.getElementById('copy-article-link');

            if (!copyButton) return;

            copyButton.addEventListener('click', async function() {
                const url = copyButton.getAttribute('data-url');

                try {
                    await navigator.clipboard.writeText(url);
                    copyButton.innerHTML = '<i class="fas fa-check"></i> Link Tersalin';
                } catch (error) {
                    window.prompt('Salin tautan ini:', url);
                }
            });
        });
    </script>
@endsection
