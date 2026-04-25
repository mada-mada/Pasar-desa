@extends('layouts.superadmin')

@section('title', 'SuperAdmin - Semua Artikel')

@section('content')
<div class="flex flex-col mb-6">
    <div>
        <h2 class="text-2xl font-bold border-l-4 border-gold pl-3 text-gray-800">Pengawasan Artikel & Berita</h2>
        <p class="text-gray-500 mt-1">Memantau seluruh publikasi yang dibuat oleh semua Admin.</p>
    </div>
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
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Info Artikel</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Kreator</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Tanggal Rilis</th>
                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Aksi Singkat</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($artikel as $a)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-16">
                                @if($a->gambar_sampul)
                                    <img class="h-10 w-16 rounded object-cover border border-gray-200" src="{{ asset('storage/' . $a->gambar_sampul) }}" alt="">
                                @else
                                    <div class="h-10 w-16 rounded bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm border-l-2 border-gold pl-2 font-semibold text-gray-900 w-48 truncate" title="{{ $a->judul_artikel }}">{{ $a->judul_artikel }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                        <i class="fas fa-user-circle text-blue-light mr-1"></i> {{ $a->penulis->nama_lengkap ?? 'Unknown' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($a->tanggal_rilis)->translatedFormat('d F Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('superadmin.artikel.show', $a->id) }}" target="_blank" class="text-white bg-blue-deep hover:bg-blue-dark rounded px-3 py-1 transition-colors" title="Lihat Artikel (Di Tab Baru)"><i class="fas fa-external-link-alt"></i> Lihat</a>
                            
                            <form action="{{ route('superadmin.artikel.destroy', $a->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Peringatan: Selaku SuperAdmin, Anda berwenang menghapus artikel yang melanggar. Anda yakin?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-white bg-red-600 hover:bg-red-700 rounded px-3 py-1 transition-colors" title="Hapus Paksa"><i class="fas fa-trash-alt mr-1"></i> Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                        Belum ada artikel publikasi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
