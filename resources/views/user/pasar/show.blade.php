@extends('layouts.user')

@section('title', $pasar->nama_pasar . ' - Pasar Desa Indramayu')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endsection

@section('content')
<!-- Header Banner -->
<div class="bg-blue-deep relative py-12 md:py-20 border-b-4 border-gold z-10">
    <div class="absolute inset-0 overflow-hidden">
        @if($pasar->foto_pasar)
            <img src="{{ asset('storage/' . $pasar->foto_pasar) }}" class="w-full h-full object-cover opacity-20 filter blur-sm" alt="Background">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-blue-900 to-transparent"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex text-sm text-blue-200 mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('pasar.index') }}" class="hover:text-gold transition-colors">Daftar Pasar</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-xs mx-2"></i>
                        <span class="text-white font-medium">{{ $pasar->nama_pasar }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-2 tracking-tight">{{ $pasar->nama_pasar }}</h1>
        <p class="text-xl text-blue-100 flex items-center mt-2 max-w-2xl"><i class="fas fa-map-marker-alt text-gold mr-2 text-2xl"></i> {{ $pasar->alamat_lengkap }}</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 -mt-10 relative z-20">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Details -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Main Info Card -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 md:p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-4 border-b pb-3"><i class="fas fa-info-circle text-gold mr-2"></i> Tentang Pasar</h3>
                <p class="text-gray-700 leading-relaxed text-lg">{{ $pasar->deskripsi }}</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                    <div class="bg-blue-50 rounded-lg p-5 border border-blue-100 flex items-start">
                        <div class="rounded-full w-12 h-12 bg-white flex items-center justify-center shadow-sm mr-4 flex-shrink-0">
                            <i class="far fa-calendar-alt text-2xl text-blue-deep"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">Hari Pasaran</h4>
                            <p class="text-gray-700">{{ $pasar->hari_pasaran }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-amber-50 rounded-lg p-5 border border-amber-100 flex items-start">
                        <div class="rounded-full w-12 h-12 bg-white flex items-center justify-center shadow-sm mr-4 flex-shrink-0">
                            <i class="far fa-clock text-2xl text-gold"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">Jam Operasional</h4>
                            <p class="text-gray-700">{{ $pasar->jam_operasional }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Photos -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 md:p-8">
                 <h3 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-3"><i class="fas fa-images text-gold mr-2"></i> Galeri</h3>
                 @if($pasar->foto_pasar)
                    <img src="{{ asset('storage/' . $pasar->foto_pasar) }}" class="w-full rounded-lg shadow-md max-h-96 object-cover" alt="Foto {{ $pasar->nama_pasar }}">
                 @else
                    <div class="w-full py-16 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 flex flex-col justify-center items-center">
                        <i class="fas fa-image text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 font-medium">Belum ada foto yang diunggah.</p>
                    </div>
                 @endif
            </div>

            <!-- Facilities -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 md:p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-3"><i class="fas fa-box-open text-gold mr-2"></i> Ketersediaan Fasilitas</h3>
                
                @if($pasar->fasilitas->isEmpty())
                     <p class="text-gray-500 italic">Data fasilitas belum tersedia.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($pasar->fasilitas as $fas)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center mr-3">
                                        @if($fas->jenisFasilitas && $fas->jenisFasilitas->icon_fasilitas)
                                            <i class="{{ $fas->jenisFasilitas->icon_fasilitas }} text-blue-deep"></i>
                                        @else
                                            <i class="fas fa-check text-blue-deep"></i>
                                        @endif
                                    </div>
                                    <span class="font-bold text-gray-800">{{ $fas->jenisFasilitas->nama_fasilitas ?? 'Fasilitas' }}</span>
                                </div>
                                <div>
                                    @if($fas->status_ketersediaan == 'Tersedia')
                                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full shadow-sm"><i class="fas fa-check-circle mr-1"></i> Tersedia</span>
                                    @elseif($fas->status_ketersediaan == 'Rusak')
                                        <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-bold rounded-full shadow-sm"><i class="fas fa-times-circle mr-1"></i> Rusak</span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-200 text-gray-700 text-xs font-bold rounded-full shadow-sm"><i class="fas fa-minus-circle mr-1"></i> Tidak Ada</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            
        </div>
        
        <!-- Right Column: Sidebar Map -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden sticky top-28">
                <div class="bg-blue-deep text-white px-6 py-4 flex items-center">
                    <i class="fas fa-map-marked-alt text-gold text-2xl mr-3"></i>
                    <h3 class="text-xl font-bold">Peta Lokasi</h3>
                </div>
                
                @if($pasar->lokasiGis)
                    <div id="detailMap" class="w-full h-80 z-0"></div>
                    <div class="p-6 bg-gray-50 border-t border-gray-100">
                        <div class="flex justify-between items-center text-xs text-gray-500 mb-4">
                            <span><strong class="text-gray-700">Lat:</strong> {{ $pasar->lokasiGis->latitude }}</span>
                            <span><strong class="text-gray-700">Lng:</strong> {{ $pasar->lokasiGis->longitude }}</span>
                        </div>
                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $pasar->lokasiGis->latitude }},{{ $pasar->lokasiGis->longitude }}" target="_blank" class="w-full flex items-center justify-center bg-gold hover:bg-yellow-500 text-blue-deep font-bold py-3 px-4 rounded-lg shadow transition-all hover:scale-105">
                            <i class="fas fa-directions mr-2 text-xl"></i> Petunjuk Arah
                        </a>
                    </div>
                @else
                    <div class="p-10 text-center bg-gray-50 text-gray-500">
                        <i class="fas fa-map-marker-alt text-4xl mb-3 text-gray-300"></i>
                        <p>Titik koordinat lokasi belum diatur.</p>
                    </div>
                @endif
            </div>
        </div>
        
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if($pasar->lokasiGis)
            var lat = {{ $pasar->lokasiGis->latitude }};
            var lng = {{ $pasar->lokasiGis->longitude }};
            
            var map = L.map('detailMap', {
                zoomControl: false
            }).setView([lat, lng], 15);
            
            L.control.zoom({ position: 'bottomright' }).addTo(map);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            var customIcon = L.divIcon({
                className: 'custom-div-icon',
                html: "<div style='background-color:#D4AF37; width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; border:3px solid #1E3A8A; box-shadow: 0 4px 6px rgba(0,0,0,0.3);'><i class='fas fa-store' style='color:#1E3A8A; font-size:18px;'></i></div>",
                iconSize: [40, 40],
                iconAnchor: [20, 20]
            });

            var marker = L.marker([lat, lng], {icon: customIcon}).addTo(map);
            marker.bindPopup("<div class='font-bold text-center text-blue-deep'>{{ $pasar->nama_pasar }}</div>").openPopup();
            
            setTimeout(function() { map.invalidateSize(); }, 200);
        @endif
    });
</script>
@endsection
