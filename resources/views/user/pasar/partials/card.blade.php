<article class="pasar-card group opacity-0 js-scroll-fade-up">
    <div class="card-img-wrapper">
        @if ($market->foto_pasar_url)
            <img src="{{ $market->foto_pasar_url }}" alt="{{ $market->nama_pasar }}" loading="lazy">
        @else
            <div class="card-img-placeholder">
                <i class="fas fa-store text-4xl"></i>
                <span>Foto Belum Tersedia</span>
            </div>
        @endif

        <div class="card-badge-stack">
            <span class="card-status-badge {{ $market->is_open_today ? 'status-badge-open' : 'status-badge-closed' }}">
                <span class="status-dot" aria-hidden="true"></span>
                {{ $market->is_open_today ? 'Buka Hari Ini' : 'Tutup Hari Ini' }}
            </span>
        </div>
    </div>

    <div class="card-body">
        <div class="mb-3 flex items-start justify-between gap-3">
            <div>
                <h3 class="card-title">
                    <a href="{{ route('pasar.show', $market->id) }}" class="hover:text-[#2563eb] transition-colors">
                        {{ $market->nama_pasar }}
                    </a>
                </h3>
                @if ($market->district_name)
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ $market->district_name }}</p>
                @endif
            </div>

            @if ($market->maps_url)
                <a href="{{ $market->maps_url }}" target="_blank" rel="noopener noreferrer" class="quick-route-btn">
                    <i class="fas fa-route" aria-hidden="true"></i>
                    Rute
                </a>
            @endif
        </div>

        @if ($market->deskripsi)
            <p class="card-desc">{{ $market->deskripsi }}</p>
        @endif

        <div class="card-schedule">
            <div class="card-schedule__label">
                <i class="far fa-calendar-alt" aria-hidden="true"></i>
                <span>Hari Buka</span>
            </div>
            <p class="card-schedule__value" title="{{ $market->hari_pasaran }}">
                {{ $market->hari_pasaran_compact ?? $market->hari_pasaran }}
            </p>
        </div>

        <div class="card-meta">
            <div class="card-meta-item">
                <i class="fas fa-map-marker-alt text-[#eab308]" aria-hidden="true"></i>
                <span class="line-clamp-2">{{ $market->alamat_lengkap }}</span>
            </div>
            <div class="card-meta-item card-meta-item--strong">
                <i class="far fa-clock text-[#2563eb]" aria-hidden="true"></i>
                <span>{{ $market->jam_operasional ?: 'Jam belum tersedia' }}</span>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <a href="{{ route('pasar.show', $market->id) }}#fasilitas" class="facility-link">
            <i class="fas fa-box-open" aria-hidden="true"></i>
            {{ $market->fasilitas->count() }} fasilitas
        </a>
    </div>
</article>
