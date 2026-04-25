@extends('layouts.admin')

@section('title', 'Admin - Edit Artikel')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-bold border-l-4 border-gold pl-3 text-blue-deep">Edit Artikel</h2>
        <p class="text-gray-500 mt-1">Perbarui informasi, perbaiki salah ketik, atau ganti sampul artikel.</p>
    </div>
    <a href="{{ route('admin.artikel.index') }}" class="text-gray-600 hover:text-blue-deep font-medium transition-colors">
        <i class="fas fa-arrow-left mr-1"></i> Batal & Kembali
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
        <form action="{{ route('admin.artikel.update', $artikel->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <input type="hidden" name="id_admin" value="{{ auth()->id() }}">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Kolom Utama -->
                <div class="md:col-span-2 space-y-6">
                    <div>
                        <label for="judul_artikel" class="block text-sm font-semibold text-gray-700 mb-1">Judul Artikel <span class="text-red-500">*</span></label>
                        <input type="text" name="judul_artikel" id="judul_artikel" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-light focus:border-transparent transition-shadow" value="{{ old('judul_artikel', $artikel->judul_artikel) }}" required>
                    </div>

                    <div>
                        <label for="isi_konten" class="block text-sm font-semibold text-gray-700 mb-1">Isi Konten <span class="text-red-500">*</span></label>
                        <textarea name="isi_konten" id="isi_konten" rows="12" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-light focus:border-transparent transition-shadow text-gray-800" required>{{ old('isi_konten', $artikel->isi_konten) }}</textarea>
                    </div>
                </div>

                <!-- Bagian Samping -->
                <div class="space-y-6">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Sampul Saat Ini</label>
                        <div class="mb-4 bg-white p-2 border border-gray-200 rounded">
                            @if($artikel->gambar_sampul)
                                <img src="{{ asset('storage/' . $artikel->gambar_sampul) }}" class="w-full h-auto rounded shadow-sm" alt="Sampul Saat Ini">
                            @else
                                <div class="p-6 text-center text-gray-400 bg-gray-100 rounded">
                                    <i class="fas fa-image mb-2 text-2xl block"></i>
                                    <span class="text-xs">Tidak ada sampul</span>
                                </div>
                            @endif
                        </div>

                        <label for="gambar_sampul" class="block text-sm font-semibold text-gray-700 mb-2 border-t pt-3">Ganti Gambar (Opsional)</label>
                        
                        <div class="flex justify-center px-6 pt-4 pb-4 border-2 border-gray-300 border-dashed rounded-lg bg-white relative hover:bg-gray-50 transition-colors">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-file-upload text-3xl text-gray-400 mb-2 block" id="upload-icon"></i>
                                <img id="preview-image" class="mx-auto hidden max-h-32 rounded shadow-sm mb-2">
                                
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="gambar_sampul" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-deep hover:text-blue-light">
                                        <span>Pilih file baru</span>
                                        <input id="gambar_sampul" name="gambar_sampul" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg" onchange="previewFile()">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 py-3 bg-blue-50 text-blue-800 rounded-lg text-sm border border-blue-100">
                        <p><i class="fas fa-calendar-check mr-2"></i> Terbit: {{ $artikel->tanggal_rilis ? \Carbon\Carbon::parse($artikel->tanggal_rilis)->format('d/m/Y') : '-' }}</p>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <button type="submit" class="w-full bg-gold text-blue-deep font-bold py-3 px-4 rounded-xl shadow-lg hover:bg-gold-dark hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-deep transition-all transform hover:-translate-y-1 flex justify-center items-center">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
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
