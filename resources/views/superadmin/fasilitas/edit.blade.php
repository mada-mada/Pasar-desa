@extends('layouts.superadmin')

@section('title', 'Ubah Tipe Fasilitas - SuperAdmin')

@section('content')
<div class="mb-4">
    <a href="{{ route('superadmin.fasilitas.index') }}" class="text-gray-600 hover:text-blue-deep font-medium flex items-center transition-colors">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Fasilitas
    </a>
</div>

<div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden max-w-3xl">
    <div class="bg-gray-800 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <h3 class="text-xl font-bold text-white flex items-center">
            <i class="fas fa-edit text-gold mr-3"></i> Form Perbarui Jenis Fasilitas
        </h3>
    </div>

    <form action="{{ route('superadmin.fasilitas.update', $fasilitas->id) }}" method="POST" class="p-6 md:p-8">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Nama Fasilitas -->
            <div>
                <label for="nama_fasilitas" class="block text-sm font-semibold text-gray-700 mb-2">Nama Jenis Fasilitas <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tag text-gray-400"></i>
                    </div>
                    <input type="text" name="nama_fasilitas" id="nama_fasilitas" class="pl-10 w-full rounded-lg border-gray-300 border px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all @error('nama_fasilitas') border-red-500 @enderror" value="{{ old('nama_fasilitas', $fasilitas->nama_fasilitas) }}" required>
                </div>
                @error('nama_fasilitas') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Icon Fasilitas -->
            <div class="flex space-x-4 items-end">
                <div class="flex-grow">
                    <label for="icon_fasilitas" class="block text-sm font-semibold text-gray-700 mb-2">Ikon Indikator <span class="text-gray-400 text-xs font-normal">(Opsional)</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-icons text-gray-400"></i>
                        </div>
                        <input type="text" name="icon_fasilitas" id="icon_fasilitas" class="pl-10 w-full rounded-lg border-gray-300 border px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all font-mono @error('icon_fasilitas') border-red-500 @enderror" value="{{ old('icon_fasilitas', $fasilitas->icon_fasilitas) }}">
                    </div>
                    @error('icon_fasilitas') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="flex-shrink-0 h-[46px] w-[46px] bg-gray-100 border border-gray-300 rounded-lg flex items-center justify-center text-xl text-blue-deep" title="Preview Ikon Saat Ini">
                     @if($fasilitas->icon_fasilitas)
                         <i class="{{ $fasilitas->icon_fasilitas }}"></i>
                     @else
                         <i class="fas fa-question text-gray-300 text-sm"></i>
                     @endif
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-1">Sesuaikan kelas ikon untuk mengganti logo fasilitas yang digunakan (berasal dari library FontAwesome v6).</p>
        </div>

        <div class="mt-10 pt-4 border-t border-gray-100 flex justify-end">
            <button type="submit" class="bg-blue-deep hover:bg-blue-dark text-white font-bold py-2.5 px-8 rounded-lg shadow-md transition-all flex items-center">
                <i class="fas fa-save mr-2"></i> Perbarui Data
            </button>
        </div>
    </form>
</div>
@endsection
