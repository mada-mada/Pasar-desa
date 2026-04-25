@extends('layouts.superadmin')

@section('title', 'Kelola Admin - SuperAdmin')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold border-l-4 border-gold pl-3 text-gray-800">Manajemen Akun Admin</h2>
        <p class="text-gray-500 mt-1 text-sm sm:text-base">Kelola informasi, akses login, dan password akun admin pasar desa.</p>
    </div>
    <a href="{{ route('superadmin.admin.create') }}" class="btn-blue px-3 py-2 sm:px-4 sm:py-2 rounded-lg text-sm sm:text-base font-medium shadow-lg flex items-center space-x-2 flex-shrink-0">
        <i class="fas fa-user-plus"></i>
        <span class="hidden sm:inline">Tambah Admin Baru</span>
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
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Info Akun Admin</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Username</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Aktif Sejak</th>
                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($admin as $a)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center border border-blue-200">
                                <i class="fas fa-user-tie text-blue-deep text-lg"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-gray-900">{{ $a->nama_lengkap }}</div>
                                <div class="text-xs text-gray-500">Role: <span class="text-gold font-semibold uppercase">{{ $a->role }}</span></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-800 bg-gray-100 px-3 py-1 rounded inline-block border border-gray-200 font-mono">
                            {{ $a->username }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $a->created_at->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('superadmin.admin.edit', $a->id) }}" class="text-gray-700 bg-gold hover:bg-gold-dark rounded px-3 py-1 transition-colors shadow-sm" title="Edit Data"><i class="fas fa-edit text-white"></i></a>
                            
                            <form action="{{ route('superadmin.admin.destroy', $a->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permanen akun admin ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-white bg-red-600 hover:bg-red-700 rounded px-3 py-1 transition-colors shadow-sm" title="Hapus Akun"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-users-slash text-5xl mb-4 text-gray-300"></i>
                            <p class="text-lg font-medium text-gray-600">Belum Ada Akun Admin Baru</p>
                            <p class="text-sm">Klik "Tambah Admin Baru" untuk menyisipkan data pengguna.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
