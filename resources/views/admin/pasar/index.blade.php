@extends('layouts.admin')

@section('title', 'Admin - Daftar Pasar Desa')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold border-l-4 border-gold pl-3 text-blue-deep">Daftar Pasar Desa</h2>
        <p class="text-gray-500 mt-1 text-sm sm:text-base">Kelola data pasar, lokasi GIS, dan fasilitas.</p>
    </div>
    <a href="{{ route('admin.pasar.create') }}" class="btn-blue px-3 py-2 sm:px-4 sm:py-2 rounded-lg text-sm sm:text-base font-medium shadow-lg flex items-center space-x-2">
        <i class="fas fa-plus"></i>
        <span class="hidden sm:inline">Tambah Pasar Baru</span>
        <span class="sm:hidden">Tambah Pasar</span>
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
    <p>{{ session('success') }}</p>
</div>
@endif

<div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pasar</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jadwal</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Fasilitas</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($pasar as $p)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                @if($p->foto_pasar)
                                    <img class="h-10 w-10 rounded-full object-cover border border-gray-200" src="{{ asset('storage/' . $p->foto_pasar) }}" alt="">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-store text-blue-deep"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $p->nama_pasar }}</div>
                                <div class="text-xs text-gray-500 truncate max-w-xs"><i class="fas fa-map-marker-alt text-gold mr-1"></i> {{ $p->alamat_lengkap }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $p->hari_pasaran }}</div>
                        <div class="text-xs text-gray-500"><i class="far fa-clock text-blue-light mr-1"></i> {{ $p->jam_operasional }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                          {{ count($p->fasilitas) }} Tipe
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.pasar.show', $p->id) }}" class="text-white bg-blue-deep hover:bg-blue-dark rounded px-3 py-1 transition-colors"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.pasar.edit', $p->id) }}" class="text-gray-700 bg-gold hover:bg-gold-dark rounded px-3 py-1 transition-colors"><i class="fas fa-edit text-white"></i></a>
                            
                            <form action="{{ route('admin.pasar.destroy', $p->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pasar ini? Tindakan ini akan menghapus data fasilitas dan lokasi secara permanen.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-white bg-red-500 hover:bg-red-600 rounded px-3 py-1 transition-colors" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                        <p>Belum ada data pasar.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
