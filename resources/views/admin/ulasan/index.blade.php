@extends('layouts.admin')

@section('title', 'Admin - Moderasi Ulasan')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold border-l-4 border-gold pl-3 text-blue-deep">Moderasi Ulasan</h2>
        <p class="text-gray-500 mt-1 text-sm sm:text-base">Kelola ulasan masuk dari pengunjung publik.</p>
    </div>
</div>

@if(session('success'))
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
    <p>{{ session('success') }}</p>
</div>
@endif

<div class="mb-6 flex space-x-2">
    <a href="{{ route('admin.ulasan.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ $status === 'pending' ? 'bg-blue-deep text-white' : 'bg-white text-gray-700 border border-gray-300' }}">Menunggu Persetujuan</a>
    <a href="{{ route('admin.ulasan.index', ['status' => 'approved']) }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ $status === 'approved' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 border border-gray-300' }}">Disetujui</a>
</div>

<div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pengulas</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Target</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Rating & Komentar</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($ulasans as $ulasan)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900">{{ $ulasan->nama_pengulas }}</div>
                        <div class="text-xs text-gray-500">{{ $ulasan->created_at->format('d M Y H:i') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                            {{ class_basename($ulasan->ulasanable_type) }}
                        </span>
                        <div class="text-sm text-gray-900 mt-1">
                            @if($ulasan->ulasanable_type === 'App\Models\PasarDesa')
                                {{ $ulasan->ulasanable->nama_pasar ?? 'Pasar Dihapus' }}
                            @else
                                {{ Str::limit($ulasan->ulasanable->judul_artikel ?? 'Artikel Dihapus', 30) }}
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center mb-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-xs {{ $i <= $ulasan->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                            @endfor
                        </div>
                        <p class="text-sm text-gray-700 whitespace-normal line-clamp-3">{{ $ulasan->komentar }}</p>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex flex-col space-y-2">
                            @if(!$ulasan->is_approved)
                                <form action="{{ route('admin.ulasan.approve', $ulasan->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full text-white bg-green-500 hover:bg-green-600 rounded px-3 py-1.5 transition-colors text-xs text-center"><i class="fas fa-check mr-1"></i> Setujui</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.ulasan.destroy', $ulasan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full text-white bg-red-500 hover:bg-red-600 rounded px-3 py-1.5 transition-colors text-xs text-center"><i class="fas fa-trash mr-1"></i> Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                        <i class="fas fa-comment-slash text-4xl mb-3 text-gray-300"></i>
                        <p>Tidak ada ulasan {{ $status === 'pending' ? 'yang menunggu persetujuan' : 'yang disetujui' }}.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($ulasans->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $ulasans->links() }}
    </div>
    @endif
</div>
@endsection
