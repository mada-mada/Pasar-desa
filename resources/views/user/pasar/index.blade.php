@extends('layouts.user')

@section('title', 'Beranda - Pasar Desa Indramayu')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        /* Leaflet popup custom style */
        .leaflet-popup-content-wrapper {
            border-radius: 1rem;
            padding: 0;
            box-shadow: 0 8px 32px rgba(15, 23, 42, 0.18);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        .leaflet-popup-content { margin: 0; }
        .leaflet-popup-tip { background: white; }

        /* Hero title animation */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up {
            animation: fadeUp 0.7s cubic-bezier(0.4, 0, 0.2, 1) both;
        }
        .animate-fade-up-delay-1 { animation-delay: 0.15s; }
        .animate-fade-up-delay-2 { animation-delay: 0.3s; }

        /* Map section */
        #heroMap {
            z-index: 10;
            border-radius: 1.25rem;
            width: 100%;
            height: 100%;
        }
        .map-container-hidden { display: none; }
        .map-container-visible { display: block; animation: fadeUp 0.4s ease both; }
    </style>
@endsection

@section('content')

{{-- ============================================
     HERO SECTION
     ============================================ --}}
<section class="hero-gradient py-16 md:py-24 relative z-10">
    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

        {{-- Eyebrow --}}
        <div class="animate-fade-up inline-flex items-center justify-center gap-2 mb-5">
            <span class="text-[#eab308] font-bold text-xs uppercase tracking-widest">
                Kabupaten Indramayu
            </span>
            <span class="w-1.5 h-1.5 rounded-full bg-[#eab308] opacity-60"></span>
            <span class="text-white/50 text-xs uppercase tracking-widest">{{ now()->translatedFormat('l, d F Y') }}</span>
        </div>

        {{-- Main Title --}}
        <h1 class="animate-fade-up animate-fade-up-delay-1 font-black text-white leading-[1.1] tracking-tight mb-5"
            style="font-size: clamp(2.5rem, 8vw, 4.5rem);">
            Temukan <span class="text-[#facc15] relative inline-block">
                Pasarmu
                <svg class="absolute -bottom-1 left-0 w-full" viewBox="0 0 200 8" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M2 6 Q50 2 100 6 Q150 10 198 6" stroke="#eab308" stroke-width="2.5" stroke-linecap="round" fill="none" opacity="0.6"/>
                </svg>
            </span><br>
            <span class="text-white/80">di Indramayu</span>
        </h1>

        {{-- Subtitle --}}
        <p class="animate-fade-up animate-fade-up-delay-2 text-white/60 text-base md:text-lg max-w-2xl mx-auto mb-8 leading-relaxed">
            Lokasi, jadwal, dan fasilitas pasar desa — semua di satu tempat.
        </p>

        {{-- Search Bar --}}
        <div class="animate-fade-up animate-fade-up-delay-2 search-bar-wrapper px-4 sm:px-0">
            <form action="{{ route('pasar.index') }}" method="GET" role="search">
                <div style="position:relative; display:flex; align-items:center;">
                    <i class="fas fa-search search-icon" aria-hidden="true"></i>
                    <input
                        type="text"
                        name="search"
                        id="search-input"
                        value="{{ request('search') }}"
                        class="search-bar"
                        placeholder="Cari nama pasar atau kecamatan..."
                        autocomplete="off"
                        aria-label="Cari pasar">
                    <button type="submit" class="search-btn" aria-label="Cari pasar">
                        <span class="hidden sm:inline">Cari Pasar</span>
                        <i class="fas fa-search sm:hidden"></i>
                    </button>
                </div>
            </form>
        </div>

        {{-- Quick Stats --}}
        <div class="animate-fade-up mt-8 flex items-center justify-center gap-6 text-white/50 text-xs">
            <span class="flex items-center gap-1.5">
                <i class="fas fa-store text-[#eab308]"></i>
                <strong class="text-white font-bold text-sm">{{ $Pasar->count() }}</strong> Pasar Aktif
            </span>
            <span class="w-1 h-1 rounded-full bg-white/20"></span>
            <span class="flex items-center gap-1.5">
                <i class="fas fa-map-marker-alt text-[#eab308]"></i>
                Seluruh Kecamatan
            </span>
        </div>
    </div>
</section>

{{-- ============================================
     MAP SECTION (Desktop selalu tampil, Mobile via Toggle FAB)
     ============================================ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 md:-mt-10 relative z-20 mb-10">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
        {{-- Map Header --}}
        <div class="flex items-center justify-between px-5 py-3 border-b border-slate-100">
            <div class="flex items-center gap-2 text-sm font-semibold text-slate-600">
                <i class="fas fa-map text-[#eab308]"></i>
                <span>Peta Pasar Desa</span>
            </div>
            <span class="text-xs text-slate-400 font-medium">{{ $Pasar->count() }} lokasi terpetakan</span>
        </div>
        {{-- Map --}}
        <div id="heroMap" style="height: 380px; border-radius: 0;"></div>
    </div>
</section>

{{-- ============================================
     DAFTAR PASAR SECTION
     ============================================ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-4">

    {{-- Section Header --}}
    <div class="flex justify-between items-end mb-8">
        <div>
            <div class="section-eyebrow">
                <span>Jelajahi</span>
            </div>
            <h2 class="section-heading">
                Daftar <span class="accent">Pasar</span> Desa
            </h2>
            @if(request('search'))
                <p class="text-slate-500 mt-1.5 text-sm">
                    Hasil pencarian untuk:
                    <strong class="text-[#2563eb] font-semibold">"{{ request('search') }}"</strong>
                    <a href="{{ route('pasar.index') }}" class="ml-2 text-xs text-slate-400 hover:text-slate-600 underline">Hapus filter</a>
                </p>
            @endif
        </div>
        <a href="{{ route('pasar.list') }}"
            class="hidden md:flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-[#2563eb] transition-colors">
            Lihat Semua
            <i class="fas fa-arrow-right text-xs"></i>
        </a>
    </div>

    {{-- Grid Pasar --}}
    @if($Pasar->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-store-slash"></i>
            </div>
            <h3 class="empty-state-title">Pasar Tidak Ditemukan</h3>
            <p class="empty-state-desc">Coba gunakan kata kunci pencarian yang lain.</p>
            <a href="{{ route('pasar.index') }}" class="btn-primary mt-5 inline-flex">
                <i class="fas fa-undo text-xs"></i> Lihat Semua Pasar
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($Pasar as $p)
                <article class="pasar-card">
                    {{-- Card Image --}}
                    <div class="card-img-wrapper">
                        @if($p->foto_pasar)
                            <img src="{{ asset('storage/' . $p->foto_pasar) }}" alt="{{ $p->nama_pasar }}" loading="lazy">
                        @else
                            <div class="card-img-placeholder">
                                <i class="fas fa-store text-4xl"></i>
                                <span>Foto Belum Tersedia</span>
                            </div>
                        @endif
                        <div class="card-badge">
                            <i class="far fa-calendar-alt mr-1" aria-hidden="true"></i>
                            {{ $p->hari_pasaran }}
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="card-body">
                        <h3 class="card-title">{{ $p->nama_pasar }}</h3>
                        @if($p->deskripsi)
                            <p class="card-desc">{{ $p->deskripsi }}</p>
                        @endif
                        <div class="card-meta">
                            <div class="card-meta-item">
                                <i class="fas fa-map-marker-alt text-[#eab308]" aria-hidden="true"></i>
                                <span class="line-clamp-2">{{ $p->alamat_lengkap }}</span>
                            </div>
                            <div class="card-meta-item">
                                <i class="far fa-clock text-[#2563eb]" aria-hidden="true"></i>
                                <span>{{ $p->jam_operasional }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Card Footer --}}
                    <div class="card-footer">
                        <span class="text-xs text-slate-400 font-medium">
                            <i class="fas fa-box-open text-[#eab308] mr-1" aria-hidden="true"></i>
                            {{ $p->fasilitas->count() }} fasilitas
                        </span>
                        <a href="{{ route('pasar.show', $p->id) }}" class="btn-primary text-xs px-3 py-1.5">
                            Lihat Detail
                            <i class="fas fa-arrow-right text-[10px]" aria-hidden="true"></i>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</section>

{{-- ============================================
     ARTIKEL TERKINI
     ============================================ --}}
@if(isset($artikel) && $artikel->count() > 0)
<section class="bg-[#f8fafc] border-t border-slate-200 py-14 mt-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-8">
            <div>
                <div class="section-eyebrow"><span>Informasi</span></div>
                <h2 class="section-heading">Artikel <span class="accent">Terkini</span></h2>
                <p class="text-slate-500 mt-1.5 text-sm">Berita dan informasi seputar pasar desa Indramayu.</p>
            </div>
            <a href="{{ route('artikel.index') }}" class="hidden md:flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-[#2563eb] transition-colors">
                Semua Artikel <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($artikel as $art)
                <article class="article-card">
                    <div class="relative h-44 overflow-hidden">
                        @if($art->foto_thumbnail)
                            <img src="{{ asset('storage/' . $art->foto_thumbnail) }}"
                                class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                                alt="{{ $art->judul }}" loading="lazy">
                        @else
                            <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                                <i class="fas fa-image text-4xl text-slate-300"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="text-gold text-xs font-bold uppercase tracking-widest mb-2">
                            {{ \Carbon\Carbon::parse($art->tanggal_rilis)->translatedFormat('d F Y') }}
                        </div>
                        <a href="{{ route('artikel.show', $art->id) }}" class="block mb-2 group">
                            <h3 class="font-bold text-[#0f172a] text-base leading-snug group-hover:text-[#2563eb] transition-colors line-clamp-2">
                                {{ $art->judul }}
                            </h3>
                        </a>
                        <p class="text-slate-500 text-sm line-clamp-3 flex-grow">
                            {{ Str::limit(strip_tags($art->konten), 110) }}
                        </p>
                        <a href="{{ route('artikel.show', $art->id) }}"
                            class="mt-4 text-xs font-bold text-[#2563eb] hover:text-[#eab308] transition-colors flex items-center gap-1 self-start">
                            Baca Selengkapnya <i class="fas fa-chevron-right text-[9px]"></i>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8 text-center md:hidden">
            <a href="{{ route('artikel.index') }}" class="btn-primary inline-flex">
                Lihat Semua Artikel
            </a>
        </div>
    </div>
</section>
@endif

{{-- Mobile bottom spacer (accounted for in layout) --}}

@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var map = L.map('heroMap', { zoomControl: true }).setView([-6.3275, 108.3249], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a>',
        maxZoom: 18
    }).addTo(map);

    var dataPasar = @json($Pasar);
    var bounds = [];

    dataPasar.forEach(function(pasar) {
        if (pasar.lokasi_gis && pasar.lokasi_gis.latitude) {
            var lat = pasar.lokasi_gis.latitude;
            var lng = pasar.lokasi_gis.longitude;
            bounds.push([lat, lng]);

            var customIcon = L.divIcon({
                className: '',
                html: `<div style="
                    background:#0f172a;
                    width:36px; height:36px;
                    border-radius:50%;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    border:2.5px solid #eab308;
                    box-shadow:0 4px 12px rgba(15,23,42,0.4);
                    transition:transform 0.2s ease;
                "><i class='fas fa-store' style='color:#facc15;font-size:14px;'></i></div>`,
                iconSize: [36, 36],
                iconAnchor: [18, 18]
            });

            var marker = L.marker([lat, lng], { icon: customIcon }).addTo(map);

            var fotoHtml = pasar.foto_pasar
                ? `<img src="/storage/${pasar.foto_pasar}" style="width:100%;height:80px;object-fit:cover;border-radius:0.75rem 0.75rem 0 0;" loading="lazy">`
                : `<div style="width:100%;height:60px;background:#f8fafc;border-radius:0.75rem 0.75rem 0 0;display:flex;align-items:center;justify-content:center;"><i class='fas fa-store' style='color:#cbd5e1;font-size:24px;'></i></div>`;

            var popupContent = `
                <div style="font-family:'Outfit',sans-serif;width:220px;border-radius:1rem;overflow:hidden;">
                    ${fotoHtml}
                    <div style="padding:0.75rem;">
                        <div style="font-size:0.7rem;color:#eab308;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;margin-bottom:4px;">
                            ${pasar.hari_pasaran}
                        </div>
                        <h4 style="font-weight:800;font-size:0.9rem;color:#0f172a;margin:0 0 4px;">${pasar.nama_pasar}</h4>
                        <p style="font-size:0.75rem;color:#64748b;margin:0 0 10px;line-height:1.4;">${pasar.alamat_lengkap}</p>
                        <a href="/pasar/${pasar.id}" style="
                            display:inline-block;
                            background:#0f172a;color:#facc15;
                            padding:6px 14px;border-radius:8px;
                            font-size:0.75rem;font-weight:700;
                            text-decoration:none;
                        ">Lihat Detail →</a>
                    </div>
                </div>
            `;
            marker.bindPopup(popupContent, { maxWidth: 240, minWidth: 220 });
        }
    });

    if (bounds.length > 0) {
        map.fitBounds(bounds, { padding: [40, 40] });
    }
});
</script>
@endsection
