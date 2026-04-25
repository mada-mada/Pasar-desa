@extends('layouts.admin')

@section('title', 'Admin - Tambah Pasar Desa')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
@endsection

@section('content')
<div class="mb-6">
    <div class="flex items-center space-x-2 text-sm text-gray-500 mb-2">
        <a href="{{ route('admin.pasar.index') }}" class="hover:text-gold transition-colors">Daftar Pasar</a>
        <span>/</span>
        <span class="text-gray-800 font-medium">Tambah Data</span>
    </div>
    <h2 class="text-2xl font-bold border-l-4 border-gold pl-3 text-blue-deep">Tambah Data Pasar Desa Baru</h2>
</div>

@if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg shadow-sm">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-500"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Terdapat masalah dengan isian Anda:</h3>
                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

<form action="{{ route('admin.pasar.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Left Column: Form -->
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4 flex items-center">
                <i class="fas fa-info-circle text-gold mr-2"></i> Profil Pasar
            </h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pasar <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_pasar" value="{{ old('nama_pasar') }}" required placeholder="Contoh: Pasar Desa Jatibarang" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold focus:border-gold input-interactive outline-none transition-all">
                </div>

                <div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hari Pasaran <span class="text-red-500">*</span></label>
                        @php
                            $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                            $oldHari = old('hari_pasaran', []);
                            $hariChunks = array_chunk($hariList, 4);

                            if (!is_array($oldHari)) {
                                $oldHari = preg_split('/\s*,\s*/', (string) $oldHari, -1, PREG_SPLIT_NO_EMPTY);
                            }
                        @endphp
                        <div class="rounded-xl border border-gray-200 bg-gray-50/80 p-3 sm:p-4">
                            <div class="space-y-2">
                                @foreach($hariChunks as $chunk)
                                    <div class="grid grid-cols-2 gap-2 lg:grid-cols-4">
                                        @foreach($chunk as $hari)
                                            <label class="group flex min-h-[52px] items-center justify-center gap-3 rounded-xl border border-gray-200 bg-white px-3 py-3 text-sm font-medium text-gray-700 shadow-sm transition-all hover:-translate-y-0.5 hover:border-gold/60 hover:bg-amber-50/60">
                                                <input type="checkbox" name="hari_pasaran[]" value="{{ $hari }}"
                                                       class="h-4 w-4 rounded border-gray-300 text-gold focus:ring-gold"
                                                       {{ in_array($hari, $oldHari) ? 'checked' : '' }}>
                                                <span class="leading-tight">{{ $hari }}</span>
                                            </label>
                                        @endforeach
                                        @if(count($chunk) < 4)
                                            @for($i = count($chunk); $i < 4; $i++)
                                                <div class="hidden lg:block"></div>
                                            @endfor
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Operasional <span class="text-red-500">*</span></label>
                        <input type="text" name="jam_operasional" value="{{ old('jam_operasional') }}" required placeholder="Contoh: 05:00 - 12:00" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold focus:border-gold input-interactive outline-none transition-all">
                    </div>
                </div>

                <!-- Fasilitas section -->
                <div class="mt-8">
                    <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-2 flex items-center">
                        <i class="fas fa-list-check text-gold mr-2"></i> Ketersediaan Fasilitas
                    </h3>
                    <p class="text-xs text-gray-500 mb-4">Tentukan status ketersediaan untuk setiap fasilitas berikut.</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @isset($jenisFasilitas)
                        @foreach($jenisFasilitas as $fasilitas)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100 hover:shadow-sm transition-shadow">
                            <div class="flex items-center">
                                @if($fasilitas->icon_fasilitas)
                                    <i class="{{ $fasilitas->icon_fasilitas }} w-6 text-blue-light"></i>
                                @else
                                    <i class="fas fa-check-circle w-6 text-gray-400"></i>
                                @endif
                                <span class="text-sm font-medium text-gray-700 ml-1">{{ $fasilitas->nama_fasilitas }}</span>
                            </div>
                            
                            <input type="hidden" name="id_jenis_fasilitas[]" value="{{ $fasilitas->id }}">
                            <select name="status_ketersediaan[]" required class="text-sm border-gray-300 rounded-md shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50 py-1 pl-2 pr-8">
                                <option value="Tidak Ada">Tidak Ada</option>
                                <option value="Tersedia">Tersedia</option>
                                <option value="Rusak">Rusak</option>
                            </select>
                        </div>
                        @endforeach
                        @endisset
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1 mt-4">Alamat Lengkap <span class="text-red-500">*</span></label>
                    <textarea name="alamat_lengkap" rows="2" required placeholder="Jalan Raya No..." 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold focus:border-gold input-interactive outline-none transition-all">{{ old('alamat_lengkap') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat <span class="text-red-500">*</span></label>
                    <textarea name="deskripsi" rows="3" required placeholder="Pasar ini merupakan..." 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold focus:border-gold input-interactive outline-none transition-all">{{ old('deskripsi') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Pasar <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="file" name="foto_pasar" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-gray-50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG, Max: 2MB.</p>
                </div>
            </div>
        </div>

        <!-- Right Column: Map -->
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 flex flex-col">
            <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-2 flex items-center">
                <i class="fas fa-map text-gold mr-2"></i> Tentukan Titik Lokasi GIS
            </h3>
            <p class="text-xs text-gray-500 mb-4">Geser peta dan klik pada lokasi pasar yang tepat. Koordinat otomatis tersimpan.</p>
            
            <div id="map" class="w-full h-80 rounded-xl mb-4 relative z-0 border border-gray-200 flex-grow"></div>
            
            <div class="grid grid-cols-1 gap-4 mt-auto sm:grid-cols-2">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase">Latitude</label>
                    <input type="text" name="latitude" id="latitude" value="{{ old('latitude') }}" readonly required
                           class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded mt-1 text-sm text-gray-700 focus:outline-none placeholder-gray-400" placeholder="Klik pada peta">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase">Longitude</label>
                    <input type="text" name="longitude" id="longitude" value="{{ old('longitude') }}" readonly required
                           class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded mt-1 text-sm text-gray-700 focus:outline-none placeholder-gray-400" placeholder="Klik pada peta">
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-8 flex flex-col-reverse gap-3 bg-white p-4 rounded-xl shadow-sm border border-gray-100 sm:flex-row sm:justify-end">
        <a href="{{ route('admin.pasar.index') }}" class="px-6 py-2 text-center rounded-lg text-gray-700 bg-gray-100 hover:bg-gray-200 font-medium transition-colors">Batal</a>
        <button type="submit" class="btn-blue px-6 py-2 rounded-lg font-medium shadow-md flex items-center justify-center">
            <i class="fas fa-save mr-2"></i> Simpan Data Pasar
        </button>
    </div>

</form>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
    console.log("Inisialisasi Peta Create Admin...");
    try {
        // Eksekusi langsung tanpa DOMContentLoaded
        var map = L.map('map').setView([-6.3275, 108.3249], 11);

        // Gunakan CartoDB agar tidak diblokir (403 Access Blocked)
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '© OpenStreetMap © CARTO',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        @isset($pasarExisting)
        var pasarLama = @json($pasarExisting);
        pasarLama.forEach(function(pasar) {
            if(pasar.lokasi_gis && (pasar.lokasi_gis.latitude || pasar.lokasi_gis.Latitude)) {
                var lat = parseFloat(pasar.lokasi_gis.latitude || pasar.lokasi_gis.Latitude);
                var lng = parseFloat(pasar.lokasi_gis.longitude || pasar.lokasi_gis.Longitude);
                
                var existingMarker = L.marker([lat, lng]).addTo(map);
                existingMarker.bindPopup(
                    "<b class='text-blue-deep'>" + pasar.nama_pasar + "</b><br>" +
                    "<small class='text-green-600 font-bold'>Sudah Terdaftar</small>"
                );
            }
        });
        @endisset

        var newMarker = null;

        var geocoder = L.Control.geocoder({
            defaultMarkGeocode: false, 
            placeholder: "Cari desa / kecamatan..."
        })
        .on('markgeocode', function(e) {
            var lat = e.geocode.center.lat;
            var lng = e.geocode.center.lng;

            map.flyTo([lat, lng], 16);

            if (newMarker) { map.removeLayer(newMarker); }
            newMarker = L.marker([lat, lng]).addTo(map);
            newMarker.bindPopup("<span class='font-bold text-gold'>Titik Terpilih</span>").openPopup();

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        })
        .addTo(map);

        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            if (newMarker) { map.removeLayer(newMarker); }
            newMarker = L.marker([lat, lng]).addTo(map);
            newMarker.bindPopup("<span class='font-bold text-gold text-sm'>Lokasi Pasar Baru</span>").openPopup();

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        });

        // Ambil nilai lama jika ada validasi error
        var oldLat = document.getElementById('latitude').value;
        var oldLng = document.getElementById('longitude').value;
        
        if (oldLat && oldLng) {
            newMarker = L.marker([oldLat, oldLng]).addTo(map);
            map.setView([oldLat, oldLng], 15);
        }
        
        // Paksa resize
        setTimeout(function() { map.invalidateSize(); }, 500);

    } catch (e) {
        console.error("Gagal load peta admin:", e);
    }
</script>
@endsection
