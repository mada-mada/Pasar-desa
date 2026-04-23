@extends('layouts.user')

@section('title', 'Daftar Pasar Desa - Pasar Desa Indramayu')
@section('meta_description', 'Jelajahi seluruh pasar desa di Indramayu dengan filter hari buka, kecamatan, mode grid atau tabel, dan pengurutan cepat.')

@section('context_bar')
    <div class="context-bar">
        <div class="context-bar__inner">
            <a href="{{ route('pasar.index') }}">Beranda</a>
            <i class="fas fa-chevron-right"></i>
            <span>Daftar Pasar</span>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-up { animation: fadeUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) both; }
    </style>
@endsection

@section('content')
    <section class="hero-gradient overflow-hidden py-16 md:py-20">
        <div class="relative z-10 mx-auto max-w-5xl px-4 text-center sm:px-6 lg:px-8">
            <div class="animate-fade-up inline-flex items-center justify-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.3em] text-white/70">
                <span class="text-[#facc15]">Explorer</span>
                <span class="h-1 w-1 rounded-full bg-[#facc15]"></span>
                <span>Pasar Desa Indramayu</span>
            </div>

            <h1 class="animate-fade-up mt-6 font-black leading-[1.05] tracking-tight text-white" style="font-size: clamp(2.2rem, 6vw, 4rem);">
                Semua <span class="text-[#facc15]">pasar</span> dalam satu tampilan yang bisa diatur.
            </h1>

            <p class="animate-fade-up mx-auto mt-4 max-w-2xl text-sm leading-relaxed text-white/60 md:text-base">
                Filter hari operasional, sempitkan area, lalu ubah ke mode tabel saat Anda butuh membaca banyak data sekaligus.
            </p>

            <div class="animate-fade-up search-bar-wrapper mt-8 px-2 sm:px-0">
                <form action="{{ route('pasar.list') }}" method="GET" role="search">
                    @foreach (request()->except('search', 'page') as $key => $value)
                        @if (filled($value))
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <div class="relative flex items-center">
                        <i class="fas fa-search search-icon" aria-hidden="true"></i>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="search-bar"
                            placeholder="Cari nama pasar, alamat, atau deskripsi..."
                            autocomplete="off"
                            aria-label="Cari pasar">
                        <button type="submit" class="search-btn">
                            <span class="hidden sm:inline">Cari</span>
                            <i class="fas fa-search sm:hidden"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="market-layout">
            <aside class="filter-panel">
                <div class="filter-panel__section">
                    <div class="section-eyebrow"><span>Filter</span></div>
                    <h2 class="text-xl font-black text-[#0f172a]">Temukan pasar yang tepat</h2>
                </div>

                <form method="GET" action="{{ route('pasar.list') }}" class="space-y-6">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="view" value="{{ $view }}">

                    <div class="filter-panel__section">
                        <label class="filter-label">Hari Operasional</label>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('pasar.list', array_filter(['search' => request('search'), 'sort' => $sort, 'view' => $view, 'kecamatan' => $selectedDistrict])) }}"
                                class="filter-chip {{ !$selectedDay ? 'filter-chip--active' : '' }}">
                                Semua
                            </a>
                            <a href="{{ route('pasar.list', array_filter(['search' => request('search'), 'hari' => $todayName, 'sort' => $sort, 'view' => $view, 'kecamatan' => $selectedDistrict])) }}"
                                class="filter-chip {{ $selectedDay === $todayName ? 'filter-chip--active' : '' }}">
                                Hari Ini
                            </a>
                            @foreach ($days as $day)
                                <a href="{{ route('pasar.list', array_filter(['search' => request('search'), 'hari' => $day, 'sort' => $sort, 'view' => $view, 'kecamatan' => $selectedDistrict])) }}"
                                    class="filter-chip {{ $selectedDay === $day ? 'filter-chip--active' : '' }}">
                                    {{ $day }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    @if ($districts->isNotEmpty())
                        <div class="filter-panel__section">
                            <label for="kecamatan" class="filter-label">Kecamatan</label>
                            <select id="kecamatan" name="kecamatan" class="form-select-modern">
                                <option value="">Semua Kecamatan</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district }}" @selected($selectedDistrict === $district)>{{ $district }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="filter-panel__section">
                        <label for="sort" class="filter-label">Urutkan</label>
                        <select id="sort" name="sort" class="form-select-modern">
                            <option value="nama_asc" @selected($sort === 'nama_asc')>Nama A-Z</option>
                            <option value="hari" @selected($sort === 'hari')>Hari Operasional</option>
                            <option value="fasilitas" @selected($sort === 'fasilitas')>Jumlah Fasilitas</option>
                        </select>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="btn-primary flex-1 justify-center">
                            Terapkan
                        </button>
                        <a href="{{ route('pasar.list') }}" class="btn-secondary flex-1 justify-center">
                            Reset
                        </a>
                    </div>
                </form>
            </aside>

            <div class="space-y-6">
                <div class="flex flex-col gap-4 rounded-[1.5rem] border border-slate-200 bg-white p-5 shadow-sm md:flex-row md:items-center md:justify-between">
                    <div>
                        <div class="section-eyebrow mb-2"><span>Hasil</span></div>
                        <h2 class="text-2xl font-black text-[#0f172a]">
                            {{ $pasarPage->total() }} pasar ditemukan
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">
                            @if (request('search'))
                                Kata kunci <strong class="text-[#2563eb]">"{{ request('search') }}"</strong>
                            @else
                                Semua pasar
                            @endif
                            @if ($selectedDay)
                                • hari <strong class="text-[#eab308]">{{ $selectedDay }}</strong>
                            @endif
                            @if ($selectedDistrict)
                                • kecamatan <strong class="text-slate-700">{{ $selectedDistrict }}</strong>
                            @endif
                        </p>
                    </div>

                    <div class="view-toggle" role="tablist" aria-label="Mode tampilan">
                        <a href="{{ route('pasar.list', array_filter(array_merge(request()->query(), ['view' => 'grid', 'page' => null]))) }}"
                            class="{{ $view === 'grid' ? 'is-active' : '' }}">
                            <i class="fas fa-grip" aria-hidden="true"></i>
                            Grid View
                        </a>
                        <a href="{{ route('pasar.list', array_filter(array_merge(request()->query(), ['view' => 'table', 'page' => null]))) }}"
                            class="{{ $view === 'table' ? 'is-active' : '' }}">
                            <i class="fas fa-table-list" aria-hidden="true"></i>
                            Table View
                        </a>
                    </div>
                </div>

                @if ($pasarPage->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon"><i class="fas fa-store-slash"></i></div>
                        <h3 class="empty-state-title">Pasar Tidak Ditemukan</h3>
                        <p class="empty-state-desc">Coba ubah kombinasi filter atau perluas kata kunci pencarian.</p>
                        <a href="{{ route('pasar.list') }}" class="btn-primary mt-5 inline-flex">
                            Lihat Semua Pasar
                        </a>
                    </div>
                @elseif ($view === 'table')
                    <div class="table-view">
                        <div class="overflow-x-auto">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Nama Pasar</th>
                                        <th>Hari</th>
                                        <th>Jam</th>
                                        <th>Alamat</th>
                                        <th>Fasilitas</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pasarPage as $market)
                                        <tr>
                                            <td>
                                                <div class="font-bold text-[#0f172a]">{{ $market->nama_pasar }}</div>
                                                @if ($market->district_name)
                                                    <div class="text-xs uppercase tracking-[0.2em] text-slate-400">{{ $market->district_name }}</div>
                                                @endif
                                            </td>
                                            <td>{{ $market->hari_pasaran }}</td>
                                            <td>{{ $market->jam_operasional ?: 'Belum ada' }}</td>
                                            <td class="max-w-[280px] text-sm leading-relaxed text-slate-500">{{ $market->alamat_lengkap }}</td>
                                            <td>{{ $market->fasilitas->count() }}</td>
                                            <td>
                                                <span class="{{ $market->is_open_today ? 'status-badge-open' : 'status-badge-closed' }}">
                                                    <span class="status-dot"></span>
                                                    {{ $market->is_open_today ? 'Buka Hari Ini' : 'Hari Lain' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="flex flex-wrap gap-2">
                                                    <a href="{{ route('pasar.show', $market->id) }}" class="btn-primary text-xs px-3 py-2">Detail</a>
    
                                                </div>
                                            </td>
                                        <td>    
                                             <div>
                                                  @if ($market->maps_url)
                                                        <a href="{{ $market->maps_url }}" target="_blank" rel="noopener noreferrer" class="btn-secondary text-xs px-3 py-2">Rute</a>
                                                    @endif
                                             </div>

                                        </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="data-dense-grid">
                        @foreach ($pasarPage as $market)
                            @include('user.pasar.partials.card', ['market' => $market])
                        @endforeach
                    </div>
                @endif

                @if ($pasarPage->hasPages())
                    <div class="flex justify-center pt-4">
                        {{ $pasarPage->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
