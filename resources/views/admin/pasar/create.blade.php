
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


@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Inisialisasi Peta
        // Set view default ke Kabupaten Indramayu (Koordinat pusat Indramayu)
        var map = L.map('map').setView([-6.3275, 108.3249], 11);

        // Tambahkan Tile Layer (Tampilan Jalan OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = null;

        // 2. Jika ada input old (saat validasi error dan kembali ke form), kembalikan marker ke posisi sebelumnya
        var oldLat = document.getElementById('latitude').value;
        var oldLng = document.getElementById('longitude').value;
        
        if (oldLat && oldLng) {
            marker = L.marker([oldLat, oldLng]).addTo(map);
            map.setView([oldLat, oldLng], 15);
        }

        // 3. Event Listener: Ketika Peta Diklik
        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            // Hapus marker sebelumnya jika ada
            if (marker) {
                map.removeLayer(marker);
            }

            // Tambahkan marker baru di titik yang diklik
            marker = L.marker([lat, lng]).addTo(map);

            // Masukkan nilai Latitude & Longitude ke dalam kolom input hidden
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        });
    });
</script>
@endsection