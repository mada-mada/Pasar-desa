@extends('layouts.admin')

@section('title', 'Admin - Tulis Artikel Baru')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-bold border-l-4 border-gold pl-3 text-blue-deep">Tulis Artikel Baru</h2>
        <p class="text-gray-500 mt-1">Buat konten menarik untuk pengunjung portal Pasar Desa.</p>
    </div>
    <a href="{{ route('admin.artikel.index') }}" class="text-gray-600 hover:text-blue-deep font-medium transition-colors">
        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
    </a>
</div>

@if ($errors->any())
<div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fas fa-exclamation-circle text-red-500"></i>
        </div>
        <div class="ml-3">
            <p class="text-sm font-bold">Harap perbaiki kesalahan berikut:</p>
            <ul class="list-disc list-inside text-sm mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 mb-6">
    <div class="p-6">
        <form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Hidden field untuk ID Admin yang sedang login -->
            <input type="hidden" name="id_admin" value="{{ auth()->id() }}">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Kolom Utama -->
                <div class="md:col-span-2 space-y-6">
                    <div>
                        <label for="judul_artikel" class="block text-sm font-semibold text-gray-700 mb-1">Judul Artikel <span class="text-red-500">*</span></label>
                        <input type="text" name="judul_artikel" id="judul_artikel" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-light focus:border-transparent transition-shadow" placeholder="Masukkan judul yang menarik" value="{{ old('judul_artikel') }}" required>
                    </div>

                    <div>
                        <label for="isi_konten" class="block text-sm font-semibold text-gray-700 mb-1">Isi Konten <span class="text-red-500">*</span></label>
                        <textarea name="isi_konten" id="isi_konten" rows="12" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-light focus:border-transparent transition-shadow text-gray-800" placeholder="Tuliskan berita atau informasi Anda di sini..." required>{{ old('isi_konten') }}</textarea>
                        <p class="text-xs text-gray-500 mt-2"><i class="fas fa-info-circle mr-1"></i> Mendukung format paragraf standar. Gunakan Enter ganda untuk paragraf baru.</p>
                    </div>
                </div>

                <!-- Bagian Samping -->
                <div class="space-y-6">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <label for="gambar_sampul" class="block text-sm font-semibold text-gray-700 mb-3">Gambar Sampul</label>
                        
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg bg-white relative hover:bg-gray-50 transition-colors" id="drop-zone">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3 block" id="upload-icon"></i>
                                <img id="preview-image" class="mx-auto hidden max-h-40 rounded shadow-sm mb-3">
                                
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="gambar_sampul" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-deep hover:text-blue-light focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-gold">
                                        <span>Unggah file</span>
                                        <input id="gambar_sampul" name="gambar_sampul" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg" onchange="previewFile()">
                                    </label>
                                    <p class="pl-1">atau seret dan lepas</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG maks 2MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <button type="submit" class="w-full bg-blue-deep text-white font-bold py-3 px-4 rounded-xl shadow-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-gold focus:ring-offset-2 transition-transform transform hover:-translate-y-1 flex justify-center items-center">
                            <i class="fas fa-paper-plane mr-2"></i> Terbitkan Artikel
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function previewFile() {
        const preview = document.getElementById('preview-image');
        const file = document.getElementById('gambar_sampul').files[0];
        const icon = document.getElementById('upload-icon');
        const reader = new FileReader();

        reader.addEventListener("load", function () {
            preview.src = reader.result;
            preview.classList.remove('hidden');
            icon.classList.add('hidden');
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
