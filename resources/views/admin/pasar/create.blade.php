<x-form-pasar>

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    @endsection
@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Tambah Data Pasar Desa & Lokasi</h4>
        </div>
        <div class="card-body">
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Oops!</strong> Ada masalah dengan inputan Anda.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.pasar.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <h5 class="border-bottom pb-2">Profil Pasar</h5>
                        
                        <div class="form-group mb-3">
                            <label for="nama_pasar">Nama Pasar <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pasar" class="form-control" value="{{ old('nama_pasar') }}" required placeholder="Contoh: Pasar Desa Jatibarang">
                        </div>

                        <div class="form-group mb-3">
                            <label for="hari_pasaran">Hari Pasaran <span class="text-danger">*</span></label>
                            <input type="text" name="hari_pasaran" class="form-control" value="{{ old('hari_pasaran') }}" required placeholder="Contoh: Senin & Kamis">
                        </div>

                        <div class="form-group mb-3">
                            <label for="jam_operasional">Jam Operasional <span class="text-danger">*</span></label>
                            <input type="text" name="jam_operasional" class="form-control" value="{{ old('jam_operasional') }}" required placeholder="Contoh: 05:00 - 12:00 WIB">
                        </div>

                         <div class="form-group mb-3">
                            <label for="nama_fasilitas">Nama Fasilitas</label>
        
                        </div>

                        <div id="fasilitas-container">
                            <div class="row mb-2 fasilitas-row">
                                 <div class="col-md-5 form-group">
                                              <input type="text" name="nama_fasilitas[]" class="form-control" placeholder="Contoh: Toilet Umum" required>
                                </div>
                                     <div class="col-md-5 form-group">
                                              <select name="status_ketersediaan[]" class="form-control" required>
                                                     <option value="">-- Pilih Status --</option>
                                                     <option value="Tersedia">Tersedia</option>
                                                     <option value="Tidak Ada">Tidak Ada</option>
                                                     <option value="Rusak">Rusak</option>
                                             </select>
                                        </div>
                        <div class="col-md-2 form-group">
                               <button type="button" class="btn btn-danger w-100 btn-hapus-fasilitas" style="display: none;">Hapus</button>
                    </div>
                         </div>
                                </div>
                                    <button type="button" id="btn-tambah-fasilitas" class="btn btn-sm btn-outline-success mt-2">
                                              + Tambah Fasilitas Lainnya
                                        </button>

                        <div class="form-group mb-3 mt-4">
                            <label for="alamat_lengkap">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea name="alamat_lengkap" class="form-control" rows="2" required>{{ old('alamat_lengkap') }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="deskripsi">Deskripsi Singkat <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="foto_pasar">Foto Pasar (Opsional)</label>
                            <input type="file" name="foto_pasar" class="form-control" accept="image/*">
                            <small class="text-muted">Maksimal ukuran file: 2MB.</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="border-bottom pb-2">Tentukan Titik Lokasi</h5>
                        <p class="text-muted small mb-2">Geser peta dan klik pada lokasi pasar yang tepat. Koordinat akan terisi otomatis.</p>
                        
                        <div id="map" style="height: 400px; width: 100%; border-radius: 8px; border: 1px solid #ccc; z-index: 1;"></div>

                        <div class="row mt-3">
                            <div class="col-md-6 form-group">
                                <label for="latitude">Latitude <span class="text-danger">*</span></label>
                                <input type="text" name="latitude" id="latitude" class="form-control bg-light" value="{{ old('latitude') }}" readonly required placeholder="Klik pada peta">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="longitude">Longitude <span class="text-danger">*</span></label>
                                <input type="text" name="longitude" id="longitude" class="form-control bg-light" value="{{ old('longitude') }}" readonly required placeholder="Klik pada peta">
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.pasar.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Data Pasar</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
    const container = document.getElementById('fasilitas-container');
    const btnTambah = document.getElementById('btn-tambah-fasilitas');

    // Event untuk menambah baris fasilitas baru
    btnTambah.addEventListener('click', function() {
        // Ambil elemen baris pertama
        const barisPertama = container.querySelector('.fasilitas-row');
        // Kloning (copy) elemen tersebut
        const barisBaru = barisPertama.cloneNode(true);

        // Kosongkan nilai input pada baris kloningan
        barisBaru.querySelector('input').value = '';
        barisBaru.querySelector('select').value = '';
        
        // Tampilkan tombol hapus pada baris kloningan
        barisBaru.querySelector('.btn-hapus-fasilitas').style.display = 'block';

        // Tambahkan baris baru ke dalam container
        container.appendChild(barisBaru);
    });

    // Event delegation untuk tombol hapus (karena tombol di-generate dinamis)
    container.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('btn-hapus-fasilitas')) {
            // Hapus elemen parent (baris) dari tombol yang diklik
            e.target.closest('.fasilitas-row').remove();
        }
    });
});
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Inisialisasi Peta
        var map = L.map('map').setView([-6.3275, 108.3249], 11);

        // 2. Tambahkan Tile Layer (Peta Dasar)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // =========================================================
        // MENAMPILKAN PASAR YANG SUDAH ADA DI DATABASE
        // =========================================================
        
        // Ambil variabel dari Controller (di-parse ke format JSON)
        var pasarLama = @json($pasarExisting);

        // Lakukan perulangan (loop) untuk setiap data pasar
        pasarLama.forEach(function(pasar) {
            var lat = pasar.lokasi_gis.latitude;
            var lng = pasar.lokasi_gis.longitude;

            // Buat penanda (marker) untuk pasar lama
            var existingMarker = L.marker([lat, lng]).addTo(map);

            // Beri tulisan popup agar admin tahu ini pasar apa
            existingMarker.bindPopup(
                "<b>" + pasar.nama_pasar + "</b><br>" +
                "<small class='text-success'>Sudah Terdaftar</small>"
            );
        });
        // =========================================================


        // Variabel untuk menyimpan titik baru yang diklik admin
        var newMarker = null;

        // 3. FITUR PENCARIAN (GEOCODER)
        var geocoder = L.Control.geocoder({
            defaultMarkGeocode: false, 
            placeholder: "Cari desa atau kecamatan..."
        })
        .on('markgeocode', function(e) {
            var lat = e.geocode.center.lat;
            var lng = e.geocode.center.lng;

            map.flyTo([lat, lng], 16);

            if (newMarker) {
                map.removeLayer(newMarker);
            }
            newMarker = L.marker([lat, lng]).addTo(map);
            newMarker.bindPopup("Titik Baru: " + e.geocode.name).openPopup();

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        })
        .addTo(map);

        // 4. Deteksi Klik Manual pada Peta 
        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            if (newMarker) {
                map.removeLayer(newMarker);
            }
            newMarker = L.marker([lat, lng]).addTo(map);
            newMarker.bindPopup("Titik Pasar Baru").openPopup();

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        });

        // 5. Kembalikan marker jika ada error validasi form
        var oldLat = document.getElementById('latitude').value;
        var oldLng = document.getElementById('longitude').value;
        
        if (oldLat && oldLng) {
            newMarker = L.marker([oldLat, oldLng]).addTo(map);
            map.setView([oldLat, oldLng], 15);
        }
        
        // Memperbaiki bug peta abu-abu
        setTimeout(function() {
            map.invalidateSize();
        }, 100);
    });
</script>
@endsection
</x-form-pasar>