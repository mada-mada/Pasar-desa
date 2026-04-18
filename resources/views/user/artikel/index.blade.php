@extends('layouts.user')

@section('title', 'Berita & Artikel - Pasar Desa Indramayu')

@section('styles')
    <style>
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-up {
            animation: fadeUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) both;
        }

        .animate-delay-1 {
            animation-delay: 0.12s;
        }
    </style>
@endsection

@section('content')

    {{-- Hero --}}
    <section class="hero-gradient py-14 md:py-20 z-10 overflow-hidden">
        <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-fade-up inline-flex items-center justify-center gap-2 mb-4">
                <span class="text-[#eab308] font-bold text-xs uppercase tracking-widest">Redaksi Pasar Desa</span>
            </div>
            <h1 class="animate-fade-up font-black text-white leading-[1.1] tracking-tight mb-4"
                style="font-size:clamp(2rem,7vw,3.5rem);">
                Berita <span class="text-[#facc15]">&</span> Artikel<br>
                <span class="text-white/60">Seputar Pasar</span>
            </h1>
            <p class="animate-fade-up animate-delay-1 text-white/50 text-sm md:text-base max-w-xl mx-auto leading-relaxed">
                Ikuti perkembangan terkini, kebijakan baru, dan informasi penting seputar aktivitas perekonomian di pasar
                desa Indramayu.
            </p>
        </div>
    </section>

    {{-- Content --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @if ($artikel->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon"><i class="fas fa-newspaper"></i></div>
                <h3 class="empty-state-title">Belum Ada Artikel</h3>
                <p class="empty-state-desc">Nantikan berita dan informasi terbaru dari kami selanjutnya.</p>
            </div>
        @else
            {{-- Featured Article --}}
            @php $featured = $artikel->first(); @endphp
            <div class="mb-10">
                <div class="section-eyebrow mb-3"><span>Artikel Utama</span></div>
                <a href="{{ route('artikel.show', $featured->id) }}" class="group block">
                    <div
                        class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 md:flex">
                        {{-- Featured Image --}}
                        <div class="md:w-1/2 relative flex-shrink-0" style="min-height: 13rem;">
                            <div class="w-full overflow-hidden" style="height: 13rem;">
                                @if ($featured->gambar_sampul)
                                    <img src="{{ asset('storage/' . $featured->gambar_sampul) }}"
                                        class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-105"
                                        alt="{{ $featured->judul }}" loading="lazy">
                                @else
                                    <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                                        <i class="fas fa-image text-6xl text-slate-300"></i>
                                    </div>
                                @endif
                            </div>
                            <span
                                class="absolute top-4 left-4 bg-[#eab308] text-[#0f172a] text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full shadow">
                                Artikel Utama
                            </span>
                        </div>
                        {{-- Featured Body --}}
                        <div class="md:w-1/2 p-7 md:p-10 flex flex-col justify-center">
                            <div class="text-[#eab308] text-xs font-bold uppercase tracking-widest mb-3">
                                <i class="far fa-calendar-alt mr-1"></i>
                                {{ \Carbon\Carbon::parse($featured->tanggal_rilis)->translatedFormat('d F Y') }}
                            </div>
                            <h2 class="font-black text-[#0f172a] leading-tight mb-3 group-hover:text-[#2563eb] transition-colors line-clamp-3"
                                style="font-size:clamp(1.2rem,3vw,1.7rem);">
                                {{ $featured->judul }}
                            </h2>
                            <p class="text-slate-500 text-sm leading-relaxed line-clamp-3 mb-6">
                                {{ Str::limit(strip_tags($featured->konten), 200) }}
                            </p>
                            <span class="btn-primary self-start">
                                Baca Selengkapnya <i class="fas fa-arrow-right text-xs"></i>
                            </span>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Rest of Articles --}}
            @if ($artikel->count() > 1)
                <div class="section-eyebrow mb-4"><span>Artikel Lainnya</span></div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($artikel->skip(1) as $art)
                        <article class="article-card">
                            {{-- Gambar Sampul: ukuran sama dengan card-img-wrapper pasar (13rem) --}}
                            <div class="w-full overflow-hidden" style="height: 13rem;">
                                @if ($featured->gambar_sampul)
                                    <img src="{{ asset('storage/' . $featured->gambar_sampul) }}"
                                        class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-105"
                                        alt="{{ $featured->judul }}" loading="lazy">
                                @else
                                    <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                                        <i class="fas fa-image text-6xl text-slate-300"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-5 flex flex-col flex-grow">
                                <div class="text-gold text-xs font-bold uppercase tracking-widest mb-2">
                                    <i class="far fa-calendar-alt mr-1" aria-hidden="true"></i>
                                    {{ \Carbon\Carbon::parse($art->tanggal_rilis)->translatedFormat('d F Y') }}
                                </div>
                                <a href="{{ route('artikel.show', $art->id) }}" class="block mb-2 group">
                                    <h3
                                        class="font-bold text-[#0f172a] text-base leading-snug group-hover:text-[#2563eb] transition-colors line-clamp-2">
                                        {{ $art->judul }}
                                    </h3>
                                </a>
                                <p class="text-slate-500 text-sm line-clamp-3 flex-grow leading-relaxed">
                                    {{ Str::limit(strip_tags($art->konten), 110) }}
                                </p>
                                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                                    @if (isset($art->penulis) && $art->penulis)
                                        <span class="text-xs text-slate-400 flex items-center gap-1.5">
                                            <i class="fas fa-user-circle text-slate-300"></i>
                                            <span
                                                class="truncate max-w-[100px]">{{ $art->penulis->nama_lengkap ?? 'Admin' }}</span>
                                        </span>
                                    @else
                                        <span></span>
                                    @endif
                                    <a href="{{ route('artikel.show', $art->id) }}"
                                        class="text-xs font-bold text-[#2563eb] hover:text-[#eab308] transition-colors flex items-center gap-1">
                                        Lanjut Baca <i class="fas fa-chevron-right text-[9px]"></i>
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
