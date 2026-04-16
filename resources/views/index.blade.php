@extends('layouts.user')

@section('title', 'Beranda - Pasar Desa Indramayu')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endsection

@section('content')
    <!-- Hero Section & Search -->
    <div class="relative bg-blue-deep pt-16 pb-24 border-b-4 border-gold z-10">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-blue-light opacity-20 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-to-t from-blue-900 to-transparent"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight mb-4">
                Eksplorasi <span
                    class="text-gold text-transparent bg-clip-text bg-gradient-to-r from-gold to-yellow-200">Pasar
                    Desa</span> Indramayu
            </h1>
            <p class="mt-4 max-w-2xl text-xl text-blue-100 mx-auto mb-10">
                Temukan lokasi, jadwal pasaran, dan fasilitas dari seluruh pasar desa di Kabupaten Indramayu dengan mudah
                dan cepat.
            </p>

            <form action="{{ route('pasar.index') }}" method="GET" class="max-w-3xl mx-auto">
                <div class="relative flex items-center">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="search-input w-full pl-12 pr-32 py-4 rounded-full border-0 text-gray-900 shadow-2xl focus:ring-0 text-lg transition-all"
                        placeholder="Cari nama pasar atau kecamatan...">
                    <button type="submit"
                        class="absolute right-2 px-6 py-2 rounded-full bg-gold hover:bg-yellow-500 text-blue-deep font-bold transition-all shadow-lg transform hover:scale-105">
                        Cari Pasar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Map Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20 mb-16">
        <div class="bg-white rounded-2xl shadow-2xl p-2 md:p-4 border border-x-gray-100">
            <div id="heroMap" class="w-full h-96 md:h-[30rem] rounded-xl object-cover"></div>
        </div>
    </div>

    <!-- List Pasar Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-end mb-8 border-b-2 border-gray-200 pb-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-900"><span class="border-l-4 border-gold pl-3">Daftar</span> Pasar
                    Desa</h2>
                @if (request('search'))
                    <p class="text-gray-500 mt-2">Hasil pencarian untuk: <span
                            class="font-bold text-blue-deep">"{{ request('search') }}"</span></p>
                @endif
            </div>
        </div>

        @if ($Pasar->isEmpty())
            <div class="text-center py-20 bg-white rounded-xl shadow-sm border border-gray-100">
                <i class="fas fa-search-minus text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-600">Pasar Tidak Ditemukan</h3>
                <p class="text-gray-500">Coba gunakan kata kunci pencarian yang lain.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($Pasar as $p)
                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden card-hover border border-gray-100 flex flex-col h-full transform transition-all duration-300">
                        <div class="relative h-48 overflow-hidden group">
                            @if ($p->foto_pasar)
                                <img src="{{ asset('storage/' . $p->foto_pasar) }}" alt="{{ $p->nama_pasar }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div
                                    class="w-full h-full bg-blue-50 flex flex-col items-center justify-center text-blue-300">
                                    <i class="fas fa-store text-5xl mb-2"></i>
                                    <span>Tidak Ada Foto</span>
                                </div>
                            @endif
                            <div
                                class="absolute top-4 right-4 bg-gold text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                <i class="far fa-calendar-alt mr-1"></i> {{ $p->hari_pasaran }}
                            </div>
                        </div>

                        <div class="p-6 flex-grow flex flex-col">
                            <h3 class="font-bold text-xl text-gray-900 mb-2 truncate card-title transition-colors">
                                {{ $p->nama_pasar }}</h3>
                            <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $p->deskripsi }}</p>

                            <div class="space-y-2 mt-auto">
                                <div class="flex items-start text-sm text-gray-600">
                                    <i class="fas fa-map-marker-alt w-5 text-gold mt-1"></i>
                                    <span class="line-clamp-1">{{ $p->alamat_lengkap }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="far fa-clock w-5 text-blue-light"></i>
                                    <span>{{ $p->jam_operasional }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 mt-auto">
                            <a href="{{ route('pasar.show', $p->id) }}"
                                class="block w-full text-center py-2 rounded-lg bg-blue-deep hover:bg-blue-dark text-white font-semibold transition-colors shadow hover:shadow-lg">
                                Lihat Detail <i class="fas fa-arrow-right ml-1 text-sm"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Berita & Artikel Terkini -->
    @if (isset($artikel) && $artikel->count() > 0)
        <div class="bg-gray-100 py-16 border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-end mb-10">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900"><span
                                class="border-l-4 border-gold pl-3">Artikel</span> Terkini</h2>
                        <p class="text-gray-600 mt-2">Informasi dan berita seputar perkembangan perekonomian desa.</p>
                    </div>
                    <a href="{{ route('artikel.index') }}"
                        class="hidden md:flex items-center text-blue-deep font-bold hover:text-gold transition-colors">
                        Lihat Semua Berita <i class="fas fa-long-arrow-alt-right ml-2 text-xl"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach ($artikel as $art)
                        <article
                            class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden transform hover:-translate-y-2 transition-all duration-300">
                            <a href="{{ route('artikel.show', $art->id) }}" class="block">
                                @if ($art->gambar_sampul)
                                    <img src="{{ asset('storage/' . $art->gambar_sampul) }}" class="w-full h-48 object-cover object-center"
                                        alt="{{ $art->judul_artikel }}">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-image text-4xl text-gray-400"></i>
                                    </div>
                                @endif
                                <div class="p-6">
                                    <div class="text-xs text-gold font-bold mb-2 uppercase">
                                        {{ \Carbon\Carbon::parse($art->tanggal_rilis)->translatedFormat('d F Y') }}</div>
                                    <h3 class="text-xl font-bold text-gray-900 hover:text-blue-deep transition-colors line-clamp-2 mt-2">
                                        {{ $art->judul_artikel }}
                                    </h3>
                                    <p class="mt-3 text-base text-gray-500 line-clamp-3">
                                        {{ Str::limit(strip_tags($art->isi_konten), 120) }}
                                    </p>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>

                <div class="mt-8 text-center md:hidden">
                    <a href="{{ route('artikel.index') }}"
                        class="inline-block px-6 py-3 rounded-lg border-2 border-blue-deep text-blue-deep font-bold hover:bg-blue-deep hover:text-white transition-colors">
                        Lihat Semua Berita
                    </a>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var map = L.map('heroMap').setView([-6.3275, 108.3249], 11);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var dataPasar = @json($Pasar);

            if (dataPasar.length > 0) {
                var bounds = [];

                dataPasar.forEach(function(pasar) {
                    if (pasar.lokasi_gis && pasar.lokasi_gis.latitude) {
                        var lat = pasar.lokasi_gis.latitude;
                        var lng = pasar.lokasi_gis.longitude;

                        bounds.push([lat, lng]);

                        // Custom marker icon using HTML
                        var customIcon = L.divIcon({
                            className: 'custom-div-icon',
                            html: "<div style='background-color:#1E3A8A; width:30px; height:30px; border-radius:50%; display:flex; align-items:center; justify-content:center; border:2px solid #D4AF37; box-shadow: 0 4px 6px rgba(0,0,0,0.3);'><i class='fas fa-store' style='color:white; font-size:14px;'></i></div>",
                            iconSize: [30, 30],
                            iconAnchor: [15, 15]
                        });

                        var marker = L.marker([lat, lng], {
                            icon: customIcon
                        }).addTo(map);

                        var popupContent = `
                        <div class="p-1">
                            <h4 class="font-bold text-blue-deep text-lg mb-1">${pasar.nama_pasar}</h4>
                            <p class="text-xs text-gray-600 mb-2 border-b pb-2"><i class="fas fa-map-marker-alt text-gold"></i> ${pasar.alamat_lengkap}</p>
                            <a href="/pasar/${pasar.id}" class="text-xs font-bold text-white bg-gold py-1 px-3 rounded shadow hover:bg-yellow-500 inline-block transition-colors">Lihat Detail</a>
                        </div>
                    `;

                        marker.bindPopup(popupContent, {
                            maxWidth: 250
                        });
                    }
                });

                if (bounds.length > 0) {
                    map.fitBounds(bounds, {
                        padding: [50, 50]
                    });
                }
            }
        });
    </script>
@endsection
