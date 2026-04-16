@extends('layouts.user')

@section('title', 'Berita & Artikel - Pasar Desa Indramayu')

@section('content')
<!-- Hero Header Section -->
<div class="relative bg-blue-deep pt-16 pb-20 border-b-4 border-gold z-10 overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute -top-20 -left-20 w-80 h-80 rounded-full bg-blue-light opacity-20 blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 rounded-full bg-gold opacity-10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-to-t from-blue-900 to-transparent"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
        <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-4">
            Berita & Artikel <span class="text-gold text-transparent bg-clip-text bg-gradient-to-r from-gold to-yellow-200">Seputar Pasar</span>
        </h1>
        <p class="mt-4 max-w-2xl text-xl text-blue-100 mx-auto">
            Ikuti perkembangan terkini, kebijakan baru, dan informasi penting seputar aktivitas perekonomian di pasar desa Indramayu.
        </p>
    </div>
</div>

<!-- Article List Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($artikel->isEmpty())
        <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100">
            <i class="fas fa-newspaper text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-700">Belum Ada Artikel</h3>
            <p class="text-gray-500 mt-2">Nantikan berita dan informasi terbaru dari kami selanjutnya.</p>
        </div>
    @else
        <!-- Featured Article (First article) -->
        @if($artikel->first())
        @php $featured = $artikel->first(); @endphp
        <div class="mb-12 bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 flex flex-col md:flex-row group hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="w-full md:w-1/2 relative overflow-hidden flex-shrink-0 h-72 md:h-80">
                @if($featured->gambar_sampul)
                    <img src="{{ asset('storage/' . $featured->gambar_sampul) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="{{ $featured->judul_artikel }}">
                @else
                    <div class="w-full h-full bg-blue-50 flex items-center justify-center">
                        <i class="fas fa-image text-6xl text-blue-200"></i>
                    </div>
                @endif
                <div class="absolute top-4 left-4 bg-gold text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                    Artikel Utama
                </div>
            </div>
            
            <div class="w-full md:w-1/2 p-8 md:p-10 flex flex-col justify-center">
                <div class="flex items-center space-x-4 mb-4 text-sm">
                    <span class="text-gold font-bold uppercase tracking-wider"><i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($featured->tanggal_rilis)->translatedFormat('d F Y') }}</span>
                    @if($featured->penulis)
                    <span class="text-gray-500"><i class="fas fa-user-edit text-blue-light mr-1"></i> {{ $featured->penulis->nama_lengkap ?? 'Admin' }}</span>
                    @endif
                </div>
                
                <h2 class="text-3xl font-bold text-gray-900 mb-4 line-clamp-3 leading-tight">{{ $featured->judul_artikel }}</h2>
                <p class="text-gray-600 mb-8 line-clamp-3 text-lg leading-relaxed">
                    {{ Str::limit(strip_tags($featured->isi_konten), 200) }}
                </p>
                
                <div>
                    <a href="{{ route('artikel.show', $featured->id) }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-deep hover:bg-blue-dark transition-colors shadow-lg">
                        Baca Selengkapnya
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Rest of Articles -->
        @if($artikel->count() > 1)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($artikel->skip(1) as $art)
            <article class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden card-hover flex flex-col h-full transform transition-all duration-300">
                <div class="relative h-48 overflow-hidden group">
                    @if($art->gambar_sampul)
                        <img src="{{ asset('storage/' . $art->gambar_sampul) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="{{ $art->judul_artikel }}">
                    @else
                        <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-image text-5xl text-gray-300"></i>
                        </div>
                    @endif
                </div>
                
                <div class="p-6 flex-grow flex flex-col">
                    <div class="text-xs text-gold font-bold mb-2 uppercase flex items-center">
                        <i class="far fa-calendar-alt mr-1 text-gray-400"></i> 
                        {{ \Carbon\Carbon::parse($art->tanggal_rilis)->translatedFormat('d F Y') }}
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-blue-deep transition-colors line-clamp-2 card-title">
                        <a href="{{ route('artikel.show', $art->id) }}">{{ $art->judul_artikel }}</a>
                    </h3>
                    
                    <p class="text-sm text-gray-600 line-clamp-3 mb-4 flex-grow">
                        {{ Str::limit(strip_tags($art->isi_konten), 120) }}
                    </p>
                    
                    <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                        @if($art->penulis)
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-user-circle text-blue-light mr-1 text-lg"></i>
                            <span class="truncate max-w-[100px]">{{ $art->penulis->nama_lengkap ?? 'Admin' }}</span>
                        </span>
                        @endif
                        <a href="{{ route('artikel.show', $art->id) }}" class="text-blue-deep font-semibold hover:text-gold transition-colors text-sm flex items-center">
                            Lanjut Baca <i class="fas fa-chevron-right ml-1 text-xs mt-0.5"></i>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        @endif
    @endif
</div>
@endsection
