@extends('layouts.user')

@section('title', 'Daftar Pasar Desa - Pasar Desa Indramayu')

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
            Pasar <span class="text-gold text-transparent bg-clip-text bg-gradient-to-r from-gold to-yellow-200">Desa</span>
        </h1>
        <p class="mt-4 max-w-2xl text-xl text-blue-100 mx-auto mb-8">
            Eksplorasi seluruh pasar desa di Kabupaten Indramayu, temukan lokasi dan fasilitas terbaik untuk kebutuhan Anda.
        </p>

        <form action="{{ route('pasar.list') }}" method="GET" class="max-w-2xl mx-auto">
            <div class="relative flex items-center shadow-lg rounded-full overflow-hidden border-2 border-transparent focus-within:border-gold transition-colors">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-500 text-lg"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="w-full pl-12 pr-32 py-4 border-0 text-gray-900 focus:ring-0 text-lg outline-none" 
                       placeholder="Cari pasar atau alamat...">
                <button type="submit" class="absolute right-0 top-0 bottom-0 px-8 bg-gold hover:bg-yellow-500 text-blue-deep font-bold transition-colors">
                    Cari
                </button>
            </div>
        </form>
    </div>
</div>

<!-- List Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if(request('search'))
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Hasil Pencarian: <span class="text-blue-deep">"{{ request('search') }}"</span></h2>
            <p class="text-gray-500 mt-1">Ditemukan {{ $pasarPage->total() }} pasar sesuai pencarian Anda.</p>
        </div>
    @endif

    @if($pasarPage->isEmpty())
        <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100">
            <i class="fas fa-store-slash text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-700">Pasar Tidak Ditemukan</h3>
            <p class="text-gray-500 mt-2">Belum ada data pasar atau coba gunakan kata kunci pencarian yang berbeda.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($pasarPage as $p)
                <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover border border-gray-100 flex flex-col h-full transform transition-all duration-300">
                    <div class="relative h-48 overflow-hidden group">
                        @if($p->foto_pasar)
                            <img src="{{ asset('storage/' . $p->foto_pasar) }}" alt="{{ $p->nama_pasar }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        @else
                            <div class="w-full h-full bg-blue-50 flex flex-col items-center justify-center text-blue-300">
                                <i class="fas fa-store text-5xl mb-2"></i>
                                <span>Tidak Ada Foto</span>
                            </div>
                        @endif
                        <div class="absolute top-4 right-4 bg-gold text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                            <i class="far fa-calendar-alt mr-1"></i> {{ $p->hari_pasaran }}
                        </div>
                    </div>
                    
                    <div class="p-6 flex-grow flex flex-col">
                        <h3 class="font-bold text-xl text-gray-900 mb-2 truncate card-title transition-colors">
                            <a href="{{ route('pasar.show', $p->id) }}" class="hover:text-blue-deep">{{ $p->nama_pasar }}</a>
                        </h3>
                        <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $p->deskripsi }}</p>
                        
                        <div class="space-y-2 mt-auto">
                            <div class="flex items-start text-sm text-gray-600">
                                <i class="fas fa-map-marker-alt w-5 text-gold mt-1"></i>
                                <span class="line-clamp-1">{{ $p->alamat_lengkap }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="far fa-clock w-5 text-blue-light"></i>
                                <span>{{ $p->jam_operasional }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 mt-auto flex justify-between items-center">
                        <div class="text-xs text-gray-500">
                            <i class="fas fa-box-open mr-1"></i> <strong>{{ $p->fasilitas->count() }}</strong> Fasilitas Terdata
                        </div>
                        <a href="{{ route('pasar.show', $p->id) }}" class="text-blue-deep font-bold text-sm hover:text-gold transition-colors flex items-center">
                            Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            {{ $pasarPage->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
