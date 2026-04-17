@extends('layouts.admin')

@section('title', 'Admin - Daftar Artikel')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold border-l-4 border-gold pl-3 text-blue-deep">Manajemen Artikel</h2>
            <p class="text-gray-500 mt-1 text-sm sm:text-base">Kelola berita, pengumuman, dan artikel publikasi pasar desa.</p>
        </div>
        <a href="{{ route('admin.artikel.create') }}"
            class="btn-blue px-3 py-2 sm:px-4 sm:py-2 rounded-lg text-sm sm:text-base font-medium shadow-lg flex items-center space-x-2">
            <i class="fas fa-plus"></i>
            <span class="hidden sm:inline">Tulis Artikel Baru</span>
            <span class="sm:hidden">Tulis Artikel</span>
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Artikel
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Penulis
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal
                            Terbit</th>
                        <th scope="col"
                            class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($artikel as $a)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-16">
                                        @if ($a->gambar_sampul)
                                            <img class="h-12 w-16 rounded object-cover shadow-sm"
                                                src="{{ asset('storage/' . $a->gambar_sampul) }}" alt="">
                                        @else
                                            <div
                                                class="h-12 w-16 rounded bg-gray-200 flex items-center justify-center text-gray-400">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900 truncate max-w-sm"
                                            title="{{ $a->judul_artikel }}">{{ $a->judul_artikel }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-medium">
                                    <i class="fas fa-user-circle text-gold mr-1"></i>
                                    {{ $a->penulis->nama_lengkap ?? 'Unknown' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $a->tanggal_rilis ? \Carbon\Carbon::parse($a->tanggal_rilis)->translatedFormat('d F Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                <div class="flex space-x-2 justify-center">
                                    <a href="{{ url('/artikel/' . $a->id) }}" target="_blank"
                                        class="text-white bg-blue-deep hover:bg-blue-dark rounded px-3 py-1 transition-colors"
                                        title="Lihat Publikasi"><i class="fas fa-external-link-alt"></i></a>
                                    <a href="{{ route('admin.artikel.edit', $a->id) }}"
                                        class="text-gray-700 bg-gold hover:bg-gold-dark rounded px-3 py-1 transition-colors"
                                        title="Edit"><i class="fas fa-edit text-white"></i></a>

                                    <form action="{{ route('admin.artikel.destroy', $a->id) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini? Tindakan ini tidak dapat dibatalkan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-white bg-red-500 hover:bg-red-600 rounded px-3 py-1 transition-colors"
                                            title="Hapus"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                <i class="fas fa-newspaper text-5xl mb-4 text-gray-300 block"></i>
                                <p class="text-lg font-medium">Belum ada artikel diterbitkan.</p>
                                <p class="text-sm mt-1">Mulai tulis pengumuman atau berita tentang pasar desa sekarang.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
