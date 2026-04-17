@extends('layouts.superadmin')

@section('title', 'Kelola Jenis Fasilitas - SuperAdmin')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold border-l-4 border-gold pl-3 text-gray-800">Master Data Fasilitas</h2>
        <p class="text-gray-500 mt-1 text-sm sm:text-base">Kelola tipe-tipe fasilitas yang dapat dipilih untuk pasar.</p>
    </div>
    <a href="{{ route('superadmin.fasilitas.create') }}" class="btn-blue px-3 py-2 sm:px-4 sm:py-2 rounded-lg text-sm sm:text-base font-medium shadow-lg flex items-center space-x-2 flex-shrink-0">
        <i class="fas fa-plus-circle"></i>
        <span class="hidden sm:inline">Tambah Fasilitas Baru</span>
        <span class="sm:hidden">Tambah</span>
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
    <p>{{ session('success') }}</p>
</div>
@endif

<div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider w-24">Ikon</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Nama Fasilitas / Referensi</th>
                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($fasilitas as $f)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="h-12 w-12 mx-auto bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center">
                            @if($f->icon_fasilitas)
                                <i class="{{ $f->icon_fasilitas }} text-2xl text-blue-deep"></i>
                            @else
                                <i class="fas fa-box text-xl text-gray-400"></i>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-gray-900 border-l-2 border-gold pl-2">{{ $f->nama_fasilitas }}</div>
                        <div class="text-xs text-gray-500 mt-1 font-mono bg-gray-50 p-1 rounded inline-block">{{ $f->icon_fasilitas ?: 'Tanpa Ikon' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('superadmin.fasilitas.edit', $f->id) }}" class="text-gray-700 bg-gold hover:bg-gold-dark rounded px-3 py-1 transition-colors shadow-sm" title="Edit Master Data"><i class="fas fa-edit text-white"></i></a>
                            
                            <form action="{{ route('superadmin.fasilitas.destroy', $f->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus referensi fasilitas ini? Hal ini dapat memengaruhi relasi data fasilitas yang sudah terekam di sistem.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-white bg-red-600 hover:bg-red-700 rounded px-3 py-1 transition-colors shadow-sm" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-10 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-bath text-5xl mb-4 text-gray-300"></i>
                            <p class="text-lg font-medium text-gray-600">Daftar Fasilitas Kosong</p>
                            <p class="text-sm">Belum ada master data jenis fasilitas yang didaftarkan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
