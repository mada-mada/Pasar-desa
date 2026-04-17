@extends('layouts.superadmin')

@section('title', 'Tambah Tipe Fasilitas - SuperAdmin')

@section('content')
<div class="mb-4">
    <a href="{{ route('superadmin.fasilitas.index') }}" class="text-gray-600 hover:text-blue-deep font-medium flex items-center transition-colors">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Fasilitas
    </a>
</div>

<div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden max-w-3xl">
    <div class="bg-gray-800 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <h3 class="text-xl font-bold text-white flex items-center">
            <i class="fas fa-plus-circle text-gold mr-3"></i> Form Tambah Jenis Fasilitas
        </h3>
    </div>

    <form action="{{ route('superadmin.fasilitas.store') }}" method="POST" class="p-6 md:p-8">
        @csrf

        <div class="space-y-6">
            <!-- Nama Fasilitas -->
            <div>
                <label for="nama_fasilitas" class="block text-sm font-semibold text-gray-700 mb-2">Nama Jenis Fasilitas <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tag text-gray-400"></i>
                    </div>
                    <input type="text" name="nama_fasilitas" id="nama_fasilitas" class="pl-10 w-full rounded-lg border-gray-300 border px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all @error('nama_fasilitas') border-red-500 @enderror" placeholder="Contoh: Toilet Umum, Tempat Parkir, Mushola" value="{{ old('nama_fasilitas') }}" required>
                </div>
                @error('nama_fasilitas') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Icon Fasilitas -->
            <div>
                <label for="icon_fasilitas" class="block text-sm font-semibold text-gray-700 mb-2">Ikon Indikator (Kode FontAwesome) <span class="text-gray-400 text-xs font-normal">(Opsional)</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-icons text-gray-400"></i>
                    </div>
                    <input type="text" name="icon_fasilitas" id="icon_fasilitas" class="pl-10 w-full rounded-lg border-gray-300 border px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all font-mono @error('icon_fasilitas') border-red-500 @enderror" placeholder="Contoh: fas fa-restroom" value="{{ old('icon_fasilitas') }}">
                </div>
                @error('icon_fasilitas') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                <p class="text-xs text-gray-500 mt-1">Gunakan kode class dari FontAwesome (v6). Contoh: <code class="bg-gray-100 p-1 rounded font-bold">fas fa-parking</code>.</p>
            </div>
        </div>

        <div class="mt-10 pt-4 border-t border-gray-100 flex justify-end">
            <button type="submit" class="bg-blue-deep hover:bg-blue-dark text-white font-bold py-2.5 px-8 rounded-lg shadow-md transition-all flex items-center">
                <i class="fas fa-save mr-2"></i> Simpan Master Fasilitas
            </button>
        </div>
    </form>
</div>
@endsection
