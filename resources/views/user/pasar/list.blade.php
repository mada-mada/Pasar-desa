@extends('layouts.user')

@section('title', 'Daftar Pasar Desa - Pasar Desa Indramayu')

@section('styles')
    <style>
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fadeUp 0.6s cubic-bezier(0.4,0,0.2,1) both; }
    </style>
@endsection

@section('content')

{{-- Hero --}}
<section class="hero-gradient py-16 md:py-20 relative z-10 overflow-hidden">
    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="animate-fade-up inline-flex items-center justify-center gap-2 mb-4">
            <span class="text-[#eab308] font-bold text-xs uppercase tracking-widest">Pasar Desa</span>
            <span class="w-1 h-1 rounded-full bg-[#eab308] opacity-60"></span>
            <span class="text-white/40 text-xs uppercase tracking-widest">Indramayu</span>
        </div>

        <h1 class="animate-fade-up font-black text-white leading-[1.1] tracking-tight mb-4"
            style="font-size:clamp(2rem,7vw,3.5rem);">
            Semua <span class="text-[#facc15]">Pasar</span><br>
            <span class="text-white/70">dalam Satu Halaman</span>
        </h1>
        <p class="animate-fade-up text-white/50 text-sm md:text-base max-w-xl mx-auto mb-8 leading-relaxed">
            Eksplorasi seluruh pasar desa di Kabupaten Indramayu, temukan lokasi dan fasilitas terbaik untuk kebutuhan Anda.
        </p>

        {{-- Search bar --}}
        <div class="animate-fade-up search-bar-wrapper px-4 sm:px-0">
            <form action="{{ route('pasar.list') }}" method="GET" role="search">
                <div style="position:relative;display:flex;align-items:center;">
                    <i class="fas fa-search search-icon" aria-hidden="true"></i>
                    <input type="text" name="search" id="search-list"
                        value="{{ request('search') }}"
                        class="search-bar"
                        placeholder="Cari pasar atau nama kecamatan..."
                        autocomplete="off"
                        aria-label="Cari pasar">
                    <button type="submit" class="search-btn" aria-label="Mulai Cari">
                        <span class="hidden sm:inline">Cari</span>
                        <i class="fas fa-search sm:hidden"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

{{-- Main List Section --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @if(request('search'))
        <div class="mb-6 flex items-center gap-3">
            <div class="section-eyebrow"><span>Hasil Cari</span></div>
            <h2 class="text-lg font-bold text-[#0f172a]">
                "{{ request('search') }}"
            </h2>
            <span class="text-xs text-slate-400 font-medium bg-slate-100 px-2.5 py-1 rounded-full">
                {{ $pasarPage->total() }} ditemukan
            </span>
            <a href="{{ route('pasar.list') }}"
                class="ml-auto text-xs text-slate-400 hover:text-slate-600 underline font-medium">
                Hapus filter
            </a>
        </div>
    @else
        <div class="mb-6">
            <div class="section-eyebrow"><span>Semua Pasar</span></div>
            <h2 class="section-heading">Daftar <span class="accent">Pasar Desa</span></h2>
        </div>
    @endif

    @if($pasarPage->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-store-slash"></i>
            </div>
            <h3 class="empty-state-title">Pasar Tidak Ditemukan</h3>
            <p class="empty-state-desc">Belum ada data pasar atau coba gunakan kata kunci yang berbeda.</p>
            <a href="{{ route('pasar.list') }}" class="btn-primary mt-5 inline-flex">
                <i class="fas fa-undo text-xs"></i> Tampilkan Semua
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($pasarPage as $p)
                <article class="pasar-card">
                    <div class="card-img-wrapper">
                        @if($p->foto_pasar)
                            <img src="{{ asset('storage/' . $p->foto_pasar) }}" alt="{{ $p->nama_pasar }}" loading="lazy">
                        @else
                            <div class="card-img-placeholder">
                                <i class="fas fa-store text-4xl"></i>
                                <span>Foto Belum Tersedia</span>
                            </div>
                        @endif
                        <div class="card-badge">
                            <i class="far fa-calendar-alt mr-1" aria-hidden="true"></i>
                            {{ $p->hari_pasaran }}
                        </div>
                    </div>

                    <div class="card-body">
                        <h3 class="card-title">
                            <a href="{{ route('pasar.show', $p->id) }}" class="hover:text-[#2563eb] transition-colors">
                                {{ $p->nama_pasar }}
                            </a>
                        </h3>
                        @if($p->deskripsi)
                            <p class="card-desc">{{ $p->deskripsi }}</p>
                        @endif
                        <div class="card-meta">
                            <div class="card-meta-item">
                                <i class="fas fa-map-marker-alt text-[#eab308]" aria-hidden="true"></i>
                                <span class="line-clamp-2">{{ $p->alamat_lengkap }}</span>
                            </div>
                            <div class="card-meta-item">
                                <i class="far fa-clock text-[#2563eb]" aria-hidden="true"></i>
                                <span>{{ $p->jam_operasional }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <span class="text-xs text-slate-400 font-medium">
                            <i class="fas fa-box-open text-[#eab308] mr-1" aria-hidden="true"></i>
                            {{ $p->fasilitas->count() }} fasilitas
                        </span>
                        <a href="{{ route('pasar.show', $p->id) }}" class="btn-primary text-xs px-3 py-1.5">
                            Detail <i class="fas fa-arrow-right text-[10px]" aria-hidden="true"></i>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($pasarPage->hasPages())
            <div class="mt-10 flex justify-center">
                {{ $pasarPage->withQueryString()->links() }}
            </div>
        @endif
    @endif

</section>

@endsection
