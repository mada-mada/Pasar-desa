@extends('layouts.user')

@section('title', 'Beranda - Pasar Desa Indramayu')
@section('meta_description',
    'Temukan pasar desa di Indramayu berdasarkan hari buka, lokasi, fasilitas, dan rute
    tercepat dari satu portal.')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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

        .hero-noise::after {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0.12;
            pointer-events: none;
            background-image:
                radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.16) 0, transparent 24%),
                radial-gradient(circle at 80% 30%, rgba(250, 204, 21, 0.16) 0, transparent 26%),
                radial-gradient(circle at 50% 80%, rgba(37, 99, 235, 0.2) 0, transparent 25%);
            mix-blend-mode: screen;
        }

        #heroMap {
            width: 100%;
            height: 100%;
            min-height: 420px;
        }

        @media (min-width: 768px) {
            #heroMap {
                min-height: 500px;
            }
        }
    </style>
@endsection

@section('content')
    <section class="hero-gradient hero-noise relative overflow-hidden py-16 md:py-24">
        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-5xl text-center">
                <div
                    class="animate-fade-up inline-flex items-center justify-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.3em] text-white/70">
                    <span class="text-[#facc15]">Portal Pasar Desa</span>
                    <span class="h-1 w-1 rounded-full bg-[#facc15]"></span>
                    <span>{{ now()->locale('id')->translatedFormat('l, d F Y') }}</span>
                </div>

                <h1 class="animate-fade-up animate-fade-up-delay-1 mt-6 font-black leading-[1.02] tracking-tight text-white"
                    style="font-size: clamp(2.6rem, 7vw, 5rem);">
                    Cari pasar yang
                    <span class="text-[#facc15]">buka hari ini</span>,
                    cek fasilitas, lalu berangkat tanpa ragu.
                </h1>

                <p
                    class="animate-fade-up animate-fade-up-delay-2 mx-auto mt-5 max-w-3xl text-base leading-relaxed text-white/65 md:text-lg">
                    Dirancang untuk pencarian cepat di mobile dan pembacaan data yang padat di desktop, lengkap dengan peta
                    interaktif dan rute langsung ke pasar tujuan.
                </p>

                <div class="animate-fade-up animate-fade-up-delay-2 search-bar-wrapper mt-8 px-2 sm:px-0">
                    <form action="{{ route('pasar.index') }}" method="GET" role="search">
                        @if ($selectedDay)
                            <input type="hidden" name="hari" value="{{ $selectedDay }}">
                        @endif
                        <div class="relative flex items-center">
                            <i class="fas fa-search search-icon" aria-hidden="true"></i>
                            <input type="text" name="search" value="{{ request('search') }}" class="search-bar"
                                placeholder="Cari nama pasar, alamat, atau kata kunci desa..." autocomplete="off"
                                aria-label="Cari pasar">
                            <button type="submit" class="search-btn" aria-label="Cari pasar">
                                <span class="hidden sm:inline">Cari Pasar</span>
                                <i class="fas fa-search sm:hidden"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="animate-fade-up mt-6 flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ route('pasar.index', ['hari' => $todayName]) }}"
                        class="inline-flex items-center gap-2 rounded-full border border-[#facc15]/30 bg-[#facc15]/10 px-4 py-2 text-sm font-semibold text-[#fef08a]">
                        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                        {{ $quickStats['open_today'] }} pasar buka {{ strtolower($todayName) }}
                    </a>
                    <span class="text-sm text-white/45">Pilih hari operasional untuk menyaring daftar di bawah.</span>
                </div>

                <div class="mt-7 flex snap-x gap-3 overflow-x-auto pt-3 pb-3 sm:justify-center">
                    <a href="{{ route('pasar.index', array_filter(['search' => request('search')])) }}"
                        class="filter-chip {{ !$selectedDay ? 'filter-chip--active' : '' }}">
                        Semua Hari
                    </a>
                    <a href="{{ route('pasar.index', array_filter(['search' => request('search'), 'hari' => $todayName])) }}"
                        class="filter-chip {{ $selectedDay === $todayName ? 'filter-chip--active' : '' }}">
                        Hari Ini
                    </a>
                    @foreach ($days as $day)
                        <a href="{{ route('pasar.index', array_filter(['search' => request('search'), 'hari' => $day])) }}"
                            class="filter-chip {{ $selectedDay === $day ? 'filter-chip--active' : '' }}">
                            {{ $day }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="mt-10 hidden gap-4 lg:grid lg:grid-cols-3">
                <div class="quick-stat-card">
                    <div class="quick-stat-label">Total Pasar</div>
                    <div class="quick-stat-value" data-counter="{{ $quickStats['total_markets'] }}">0</div>
                    <p class="quick-stat-desc">Lokasi pasar yang sudah terdata di portal.</p>
                </div>
                <div class="quick-stat-card">
                    <div class="quick-stat-label">Jangkauan Kecamatan</div>
                    <div class="quick-stat-value" data-counter="{{ $quickStats['total_districts'] }}">0</div>
                    <p class="quick-stat-desc">Area yang sudah memiliki titik pasar terpetakan.</p>
                </div>
                <div class="quick-stat-card">
                    <div class="quick-stat-label">Buka Hari Ini</div>
                    <div class="quick-stat-value" data-counter="{{ $quickStats['open_today'] }}">0</div>
                    <p class="quick-stat-desc">Pasar yang cocok untuk kebutuhan cepat hari ini.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="peta-pasar" class="section-anchor mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="map-shell">
            <div class="map-shell__header">
                <div>
                    <div class="section-eyebrow mb-2"><span>Peta Interaktif</span></div>
                    <h2 class="section-heading text-2xl md:text-3xl">Pasar <span class="accent">terpetakan</span></h2>
                </div>
                <span class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ $Pasar->count() }}
                    titik</span>
            </div>

            <div class="map-shell__body">
                <aside class="map-sidebar">
                    <p class="map-sidebar__caption">Klik pasar untuk fokus ke marker dan buka rute.</p>
                    <div class="map-sidebar__list">
                        @foreach ($Pasar as $market)
                            <button type="button" class="map-sidebar__item" data-map-target="{{ $market->id }}"
                                @disabled(!$market->lokasiGis)>
                                <span>
                                    <strong>{{ $market->nama_pasar }}</strong>
                                    <small>{{ $market->district_name ?: $market->hari_pasaran }}</small>
                                </span>
                                <i class="fas fa-location-crosshairs" aria-hidden="true"></i>
                            </button>
                        @endforeach
                    </div>
                </aside>
                <div class="map-canvas-wrap">
                    <div id="heroMap"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-anchor mx-auto max-w-7xl px-4 pb-6 pt-2 sm:px-6 lg:px-8 opacity-0 js-scroll-fade-up">
        <div class="list-shell">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <div class="section-eyebrow"><span>Jelajahi</span></div>
                    <h2 class="section-heading">Daftar <span class="accent">Pasar</span> Desa</h2>
                    @if (request('search') || $selectedDay)
                        <p class="mt-2 text-sm text-slate-500">
                            Menampilkan
                            <strong class="text-slate-800">{{ $Pasar->count() }}</strong>
                            hasil
                            @if (request('search'))
                                untuk kata kunci <strong class="text-[#2563eb]">"{{ request('search') }}"</strong>
                            @endif
                            @if ($selectedDay)
                                pada hari <strong class="text-[#eab308]">{{ $selectedDay }}</strong>
                            @endif
                        </p>
                    @endif
                </div>
            </div>

            @if ($Pasar->isEmpty())
                <div class="empty-state mt-6">
                    <div class="empty-state-icon"><i class="fas fa-store-slash"></i></div>
                    <h3 class="empty-state-title">Pasar Tidak Ditemukan</h3>
                    <p class="empty-state-desc">Coba hari lain atau gunakan kata kunci yang lebih umum.</p>
                    <a href="{{ route('pasar.index') }}" class="btn-primary mt-5 inline-flex">
                        <i class="fas fa-rotate-left text-xs"></i>
                        Reset Filter
                    </a>
                </div>
            @else
                <div class="data-dense-grid mt-6">
                    @foreach ($Pasar as $market)
                        @include('user.pasar.partials.card', ['market' => $market])
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    @if ($artikel->isNotEmpty())
        <section class="mt-8 border-t border-slate-200 bg-[#f8fafc] py-14 js-scroll-fade-up">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-8 flex items-end justify-between gap-4">
                    <div>
                        <div class="section-eyebrow"><span>Informasi</span></div>
                        <h2 class="section-heading">Artikel <span class="accent">Terkini</span></h2>
                        <p class="mt-1.5 text-sm text-slate-500">Liputan, panduan, dan sorotan pasar desa Indramayu.</p>
                    </div>
                    <a href="{{ route('artikel.index') }}"
                        class="hidden items-center gap-2 text-sm font-bold text-slate-500 transition-colors hover:text-[#2563eb] md:flex">
                        Semua Artikel
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    @foreach ($artikel as $art)
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
                                <div
                                    class="mb-3 flex items-center gap-3 text-[11px] font-bold uppercase tracking-[0.18em] text-[#eab308]">
                                    <span>{{ $art->tanggal_rilis->translatedFormat('d F Y') }}</span>
                                    <span class="h-1 w-1 rounded-full bg-[#cbd5e1]"></span>
                                    <span>{{ $art->reading_time }} menit baca</span>
                                </div>

                                <a href="{{ route('artikel.show', $art->id) }}" class="mb-2 block">
                                    <h3
                                        class="line-clamp-2 text-lg font-bold leading-snug text-slate-900 transition-colors group-hover:text-[#2563eb]">
                                        {{ $art->judul_artikel }}
                                    </h3>
                                </a>

                                <p class="mb-5 line-clamp-2 flex-1 text-sm leading-relaxed text-slate-600">
                                    {{ $art->excerpt }}
                                </p>

                                <div class="mt-auto border-t border-slate-100 pt-4">
                                    <a href="{{ route('artikel.show', $art->id) }}"
                                        class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-[0.18em] text-[#2563eb] transition-colors hover:text-[#eab308]">
                                        Baca Selengkapnya
                                        <i class="fas fa-chevron-right text-[10px]"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mapEl = document.getElementById('heroMap');
            const counters = document.querySelectorAll('[data-counter]');
            const dataPasar = @json($Pasar->values());

            if (mapEl) {
                const map = L.map(mapEl, {
                    zoomControl: true
                }).setView([-6.3275, 108.3249], 11);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a>',
                    maxZoom: 18
                }).addTo(map);

                const bounds = [];
                const markers = new Map();

                dataPasar.forEach(function(pasar) {
                    if (!pasar.lokasi_gis || !pasar.lokasi_gis.latitude || !pasar.lokasi_gis.longitude) {
                        return;
                    }

                    const lat = Number(pasar.lokasi_gis.latitude);
                    const lng = Number(pasar.lokasi_gis.longitude);
                    bounds.push([lat, lng]);

                    const icon = L.divIcon({
                        className: '',
                        html: `<div style="background:#0f172a;width:40px;height:40px;border-radius:999px;display:flex;align-items:center;justify-content:center;border:2px solid #facc15;box-shadow:0 10px 18px rgba(15,23,42,.24);"><i class='fas fa-store' style='color:#facc15;font-size:14px;'></i></div>`,
                        iconSize: [40, 40],
                        iconAnchor: [20, 20]
                    });

                    const routeButton = pasar.maps_url ?
                        `<a href="${pasar.maps_url}" target="_blank" rel="noopener noreferrer" style="display:inline-flex;align-items:center;gap:8px;background:#eab308;color:#0f172a;padding:8px 12px;border-radius:999px;font-size:12px;font-weight:800;text-decoration:none;">Rute <i class='fas fa-arrow-right'></i></a>` :
                        '';

                    const marker = L.marker([lat, lng], {
                            icon
                        }).addTo(map)
                        .bindPopup(`
                            <div style="width:240px;font-family:'Outfit',sans-serif;">
                                <div style="margin-bottom:6px;font-size:11px;font-weight:800;letter-spacing:.18em;text-transform:uppercase;color:${pasar.is_open_today ? '#16a34a' : '#94a3b8'};">
                                    ${pasar.is_open_today ? 'Buka Hari Ini' : 'Terjadwal Hari Lain'}
                                </div>
                                <h3 style="margin:0 0 8px;font-size:15px;font-weight:800;color:#0f172a;">${pasar.nama_pasar}</h3>
                                <p style="margin:0 0 6px;font-size:12px;color:#475569;">${pasar.hari_pasaran} • ${pasar.jam_operasional ?? 'Jam belum tersedia'}</p>
                                <p style="margin:0 0 12px;font-size:12px;line-height:1.5;color:#64748b;">${pasar.alamat_lengkap}</p>
                                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                    <a href="/pasar/${pasar.id}" style="display:inline-flex;align-items:center;gap:8px;background:#0f172a;color:#fff;padding:8px 12px;border-radius:999px;font-size:12px;font-weight:700;text-decoration:none;">Detail</a>
                                    ${routeButton}
                                </div>
                            </div>
                        `);

                    markers.set(String(pasar.id), marker);
                });

                if (bounds.length) {
                    map.fitBounds(bounds, {
                        padding: [28, 28]
                    });
                }

                document.querySelectorAll('[data-map-target]').forEach(function(button) {
                    button.addEventListener('click', function() {
                        const marker = markers.get(button.getAttribute('data-map-target'));
                        if (!marker) return;
                        map.flyTo(marker.getLatLng(), 15, {
                            duration: 0.8
                        });
                        marker.openPopup();
                    });
                });

                setTimeout(function() {
                    map.invalidateSize();
                }, 200);
            }

            if (counters.length) {
                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (!entry.isIntersecting) return;

                        const target = Number(entry.target.dataset.counter || 0);
                        const duration = 900;
                        const start = performance.now();

                        function tick(now) {
                            const progress = Math.min((now - start) / duration, 1);
                            entry.target.textContent = Math.round(target * progress).toLocaleString(
                                'id-ID');
                            if (progress < 1) {
                                requestAnimationFrame(tick);
                            }
                        }

                        requestAnimationFrame(tick);
                        observer.unobserve(entry.target);
                    });
                }, {
                    threshold: 0.45
                });

                counters.forEach(function(counter) {
                    observer.observe(counter);
                });
            }

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
                    threshold: 0.20
                });

                fadeUpElements.forEach(function(el) {
                    fadeObserver.observe(el);
                });
            }
        });
    </script>
@endsection
