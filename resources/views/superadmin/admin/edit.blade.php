@extends('layouts.superadmin')

@section('title', 'Edit Admin - SuperAdmin')

@section('content')
<div class="mb-4">
    <a href="{{ route('superadmin.admin.index') }}" class="text-gray-600 hover:text-blue-deep font-medium flex items-center transition-colors">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Admin
    </a>
</div>

<div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden max-w-3xl">
    <div class="bg-gray-800 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <h3 class="text-xl font-bold text-white flex items-center">
            <i class="fas fa-user-edit text-gold mr-3"></i> Form Ubah Akun Admin
        </h3>
    </div>

    <form action="{{ route('superadmin.admin.update', $admin->id) }}" method="POST" class="p-6 md:p-8">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Nama Lengkap -->
            <div>
                <label for="nama_lengkap" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap Admin <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-id-card text-gray-400"></i>
                    </div>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="pl-10 w-full rounded-lg border-gray-300 border px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all @error('nama_lengkap') border-red-500 @enderror" value="{{ old('nama_lengkap', $admin->nama_lengkap) }}" required>
                </div>
                @error('nama_lengkap') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">Username Login <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" name="username" id="username" class="pl-10 w-full rounded-lg border-gray-300 border px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all @error('username') border-red-500 @enderror" value="{{ old('username', $admin->username) }}" required>
                    </div>
                    @error('username') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi Baru</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" name="password" id="password" class="pl-10 w-full rounded-lg border-gray-300 border px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all @error('password') border-red-500 @enderror" placeholder="Biarkan kosong jika tidak diubah">
                    </div>
                    @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    <p class="text-xs text-gray-500 mt-1">Isi hanya jika Anda ingin mengubah sandi (Min: 6 Karakter).</p>
                </div>
            </div>
        </div>

        <div class="mt-10 pt-4 border-t border-gray-100 flex justify-end">
            <button type="submit" class="bg-blue-deep hover:bg-blue-dark text-white font-bold py-2.5 px-8 rounded-lg shadow-md transition-all flex items-center">
                <i class="fas fa-save mr-2"></i> Perbarui Profil Admin
            </button>
        </div>
    </form>
</div>
@endsection
