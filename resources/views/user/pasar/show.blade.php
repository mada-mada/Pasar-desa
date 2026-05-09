@extends('layouts.user')

@section('title', $pasar->nama_pasar . ' - Pasar Desa Indramayu')
@section('meta_description', Str::limit(strip_tags($pasar->deskripsi ?: $pasar->alamat_lengkap), 155))

@section('context_bar')
    <div class="context-bar">
        <div class="context-bar__inner">
            <a href="{{ route('pasar.index') }}">Beranda</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('pasar.list') }}">Daftar Pasar</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ $pasar->nama_pasar }}</span>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endsection

@section('content')
    <section class="hero-gradient relative overflow-hidden py-16 md:py-20">
        <div class="absolute inset-0">
            @if ($pasar->foto_pasar_url)
                <img src="{{ $pasar->foto_pasar_url }}" alt="{{ $pasar->nama_pasar }}" class="h-full w-full object-cover opacity-20">
            @endif
            <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(15,23,42,0.55),rgba(15,23,42,0.92))]"></div>
        </div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl">
                <div class="mb-4 flex flex-wrap items-center gap-3">
                    <span class="{{ $pasar->is_open_today ? 'status-badge-open' : 'status-badge-closed' }}">
                        <span class="status-dot"></span>
                        {{ $pasar->is_open_today ? 'Buka Hari Ini' : 'Tidak Buka Hari Ini' }}
                    </span>
                    <span class="rounded-full border border-white/10 bg-white/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.2em] text-white/75" title="{{ $pasar->hari_pasaran }}">
                        {{ $pasar->hari_pasaran_compact ?? $pasar->hari_pasaran }}
                    </span>
                    <span class="rounded-full border border-white/10 bg-white/10 px-4 py-2 text-xs font-semibold text-white/65">
                        {{ $pasar->jam_operasional ?: 'Jam operasional belum tersedia' }}
                    </span>
                </div>

                <h1 class="text-4xl font-black leading-tight tracking-tight text-white md:text-6xl">{{ $pasar->nama_pasar }}</h1>
                <p class="mt-5 max-w-3xl text-base leading-relaxed text-white/70 md:text-lg">
                    {{ $pasar->deskripsi ?: 'Pasar desa ini sudah terdata di portal dengan informasi lokasi, jadwal operasional, dan fasilitas pendukung.' }}
                </p>

                <div class="mt-6 flex flex-wrap gap-3 text-sm text-white/75">
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/8 px-4 py-2">
                        <i class="fas fa-location-dot text-[#facc15]"></i>
                        {{ $pasar->alamat_lengkap }}
                    </span>
                    @if ($pasar->district_name)
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/8 px-4 py-2">
                            <i class="fas fa-map text-[#facc15]"></i>
                            {{ $pasar->district_name }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid gap-8 xl:grid-cols-[1.3fr_0.9fr]">
            <div class="space-y-8">
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm md:p-8">
                    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <div class="section-eyebrow"><span>Ringkasan</span></div>
                            <h2 class="text-2xl font-black text-[#0f172a]">Informasi utama pasar</h2>
                        </div>
                        @if ($pasar->maps_url)
                            <a href="{{ $pasar->maps_url }}" target="_blank" rel="noopener noreferrer" class="btn-primary btn-gold">
                                <i class="fas fa-route"></i>
                                Petunjuk Arah
                            </a>
                        @endif
                    </div>

                    <div class="grid gap-4 md:grid-cols-3">
                        <div class="info-tile">
                            <span class="info-tile__icon"><i class="far fa-calendar-alt"></i></span>
                            <strong>Hari Operasional</strong>
                            <p title="{{ $pasar->hari_pasaran }}">{{ $pasar->hari_pasaran_compact ?? $pasar->hari_pasaran }}</p>
                        </div>
                        <div class="info-tile">
                            <span class="info-tile__icon"><i class="far fa-clock"></i></span>
                            <strong>Jam Operasional</strong>
                            <p>{{ $pasar->jam_operasional ?: 'Belum tersedia' }}</p>
                        </div>
                        <div class="info-tile">
                            <span class="info-tile__icon"><i class="fas fa-box-open"></i></span>
                            <strong>Total Fasilitas</strong>
                            <p>{{ $pasar->fasilitas->count() }} item terdata</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm md:p-8">
                    <div class="section-eyebrow"><span>Galeri</span></div>
                    <h2 class="mb-5 text-2xl font-black text-[#0f172a]">Tampilan pasar</h2>

                    @if ($pasar->foto_pasar_url)
                        <img src="{{ $pasar->foto_pasar_url }}" alt="{{ $pasar->nama_pasar }}" class="h-[320px] w-full rounded-[1.25rem] object-cover shadow-sm md:h-[420px]">
                    @else
                        <div class="flex h-[280px] w-full flex-col items-center justify-center rounded-[1.25rem] border border-dashed border-slate-300 bg-slate-50 text-slate-400">
                            <i class="fas fa-image text-5xl"></i>
                            <p class="mt-4 text-sm font-medium">Foto pasar belum tersedia.</p>
                        </div>
                    @endif
                </div>

                <div id="fasilitas" class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm md:p-8">
                    <div class="section-eyebrow"><span>Fasilitas</span></div>
                    <h2 class="mb-5 text-2xl font-black text-[#0f172a]">Ketersediaan fasilitas pasar</h2>

                    @if ($pasar->fasilitas->isEmpty())
                        <p class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-5 py-8 text-center text-slate-500">
                            Data fasilitas belum tersedia untuk pasar ini.
                        </p>
                    @else
                        <div class="facility-grid">
                            @foreach ($pasar->fasilitas as $facility)
                                @php
                                    $status = $facility->status_ketersediaan;
                                    $statusClass = $status === 'Tersedia'
                                        ? 'facility-status--available'
                                        : ($status === 'Rusak' ? 'facility-status--damaged' : 'facility-status--missing');
                                @endphp
                                <article class="facility-card">
                                    <div class="facility-card__icon">
                                        <i class="{{ optional($facility->jenisFasilitas)->icon_fasilitas ?? 'fas fa-store' }}"></i>
                                    </div>
                                    <div class="space-y-2">
                                        <h3 class="text-lg font-bold text-[#0f172a]">{{ optional($facility->jenisFasilitas)->nama_fasilitas ?? 'Fasilitas' }}</h3>
                                        <span class="facility-status {{ $statusClass }}">{{ $status }}</span>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>

            <aside class="space-y-6">
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="section-eyebrow"><span>Lokasi</span></div>
                    <h2 class="mb-4 text-2xl font-black text-[#0f172a]">Peta & rute</h2>

                    @if ($pasar->lokasiGis)
                        <div id="detailMap" class="h-[340px] overflow-hidden rounded-[1.25rem]"></div>
                        <div class="mt-4 grid gap-3 text-sm text-slate-500">
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <strong class="block text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Status Hari Ini</strong>
                                <p class="mt-2 text-base font-semibold text-slate-700">
                                    {{ $pasar->is_open_today ? 'Buka untuk kunjungan hari ini' : 'Terjadwal pada hari lain' }}
                                </p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <strong class="block text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Koordinat</strong>
                                <p class="mt-2">Lat {{ $pasar->lokasiGis->latitude }}, Lng {{ $pasar->lokasiGis->longitude }}</p>
                            </div>
                        </div>
                        @if ($pasar->maps_url)
                            <a href="{{ $pasar->maps_url }}" target="_blank" rel="noopener noreferrer" class="sticky-route-btn mt-4">
                                <i class="fas fa-route"></i>
                                Buka Petunjuk Arah
                            </a>
                        @endif
                    @else
                        <div class="rounded-[1.25rem] border border-dashed border-slate-300 bg-slate-50 px-5 py-10 text-center text-slate-500">
                            <i class="fas fa-map-location-dot text-4xl text-slate-300"></i>
                            <p class="mt-4">Koordinat pasar belum tersedia.</p>
                        </div>
                    @endif
                </div>

                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="section-eyebrow"><span>Bagikan</span></div>
                    <h2 class="mb-4 text-2xl font-black text-[#0f172a]">Share informasi pasar</h2>
                    <div class="flex flex-wrap gap-3">
                        <a href="https://wa.me/?text={{ urlencode($pasar->nama_pasar . ' - ' . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="btn-secondary">
                            <i class="fab fa-whatsapp"></i>
                            WhatsApp
                        </a>
                        <button type="button" class="btn-secondary" id="copy-market-link" data-url="{{ url()->current() }}">
                            <i class="fas fa-link"></i>
                            Copy Link
                        </button>
                    </div>
                </div>

                <div id="ulasan" class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="mb-5 flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <div class="section-eyebrow"><span>Ulasan</span></div>
                            <h2 class="text-2xl font-black text-[#0f172a]">Apa kata masyarakat</h2>
                        </div>
                        <button id="btn-tulis-ulasan" class="btn-primary" style="display: none;">
                            <i class="fas fa-pencil-alt"></i> Tulis Ulasan
                        </button>
                    </div>

                    <div class="mb-6 flex items-center gap-4">
                        <div class="text-4xl font-black text-[#0f172a]">{{ number_format($pasar->rata_rata_rating, 1) }}</div>
                        <div>
                            <div class="text-lg text-[#facc15]">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= round($pasar->rata_rata_rating) ? 'fas' : 'far' }} fa-star"></i>
                                @endfor
                            </div>
                            <div class="text-sm text-slate-500">Dari {{ $pasar->total_ulasan }} ulasan</div>
                        </div>
                    </div>

                    @if($ulasans->isEmpty())
                        <p class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-5 py-8 text-center text-slate-500">
                            Belum ada ulasan untuk pasar ini. Jadilah yang pertama!
                        </p>
                    @else
                        <div class="space-y-4">
                            @foreach($ulasans as $ulasan)
                                <div class="border-b border-slate-100 pb-4 last:border-0 last:pb-0">
                                    <div class="mb-2 flex items-center justify-between">
                                        <strong class="text-[#0f172a]">{{ $ulasan->nama_pengunjung }}</strong>
                                        <div class="text-sm text-[#facc15]">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="{{ $i <= $ulasan->rating ? 'fas' : 'far' }} fa-star"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-sm text-slate-600">{{ $ulasan->komentar }}</p>
                                    <div class="mt-2 text-xs text-slate-400">{{ $ulasan->created_at->diffForHumans() }}</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6">
                            {{ $ulasans->links('pagination::tailwind') }}
                        </div>
                    @endif
                </div>
            </aside>
        </div>
    </section>

    <!-- Modal Ulasan -->
    <div id="modal-ulasan" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300 px-4">
        <div class="w-full max-w-lg rounded-[1.75rem] bg-white p-6 shadow-xl md:p-8 transform scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto" id="modal-ulasan-content">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-black text-[#0f172a]">Tulis Ulasan Anda</h3>
                <button id="btn-close-modal" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times text-xl"></i></button>
            </div>
            <form id="form-ulasan">
                @csrf
                <input type="hidden" name="ulasanable_id" value="{{ $pasar->id }}">
                <input type="hidden" name="ulasanable_type" value="App\Models\PasarDesa">
                
                <div class="mb-4">
                    <label class="block text-sm font-bold text-[#0f172a] mb-2">Rating</label>
                    <div class="flex gap-2 text-2xl text-slate-300 cursor-pointer" id="star-rating">
                        <i class="fas fa-star" data-rating="1"></i>
                        <i class="fas fa-star" data-rating="2"></i>
                        <i class="fas fa-star" data-rating="3"></i>
                        <i class="fas fa-star" data-rating="4"></i>
                        <i class="fas fa-star" data-rating="5"></i>
                    </div>
                    <input type="hidden" name="rating" id="input-rating" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-[#0f172a] mb-2">Nama Anda</label>
                    <input type="text" name="nama_pengunjung" class="w-full rounded-xl border border-slate-300 p-3 focus:border-[#facc15] focus:outline-none focus:ring-1 focus:ring-[#facc15]" required maxlength="100">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-[#0f172a] mb-2">Kontak (Opsional)</label>
                    <input type="text" name="kontak" class="w-full rounded-xl border border-slate-300 p-3 focus:border-[#facc15] focus:outline-none focus:ring-1 focus:ring-[#facc15]" maxlength="100" placeholder="No HP / Email untuk pelacakan spam">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-[#0f172a] mb-2">Komentar</label>
                    <textarea name="komentar" rows="4" class="w-full rounded-xl border border-slate-300 p-3 focus:border-[#facc15] focus:outline-none focus:ring-1 focus:ring-[#facc15]" required maxlength="500"></textarea>
                </div>

                <button type="submit" class="w-full btn-primary flex justify-center items-center gap-2" id="btn-submit-ulasan">
                    <i class="fas fa-paper-plane"></i> Kirim Ulasan
                </button>
            </form>
        </div>
    </div>

    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "Place",
            "name": @json($pasar->nama_pasar),
            "description": @json($pasar->deskripsi ?: $pasar->alamat_lengkap),
            "address": @json($pasar->alamat_lengkap),
            "openingHours": @json($pasar->jam_operasional),
            "image": @json($pasar->foto_pasar_url)
            @if($pasar->total_ulasan > 0)
            ,"aggregateRating": {
                "@@type": "AggregateRating",
                "ratingValue": "{{ number_format($pasar->rata_rata_rating, 1) }}",
                "reviewCount": "{{ $pasar->total_ulasan }}"
            }
            @endif
        }
    </script>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mapTarget = document.getElementById('detailMap');
            const copyButton = document.getElementById('copy-market-link');

            if (mapTarget) {
                const pasar = @json($pasar);
                const lokasi = pasar.lokasi_gis || pasar.lokasi_gis || pasar.lokasiGis;
                const map = L.map(mapTarget, { zoomControl: true });

                L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                    subdomains: 'abcd',
                    maxZoom: 20
                }).addTo(map);

                if (lokasi && lokasi.latitude && lokasi.longitude) {
                    const lat = Number(lokasi.latitude);
                    const lng = Number(lokasi.longitude);

                    map.setView([lat, lng], 15);

                    const icon = L.divIcon({
                        className: '',
                        html: "<div style='background:#0f172a;width:42px;height:42px;border-radius:999px;display:flex;align-items:center;justify-content:center;border:2px solid #facc15;box-shadow:0 8px 20px rgba(15,23,42,.25);'><i class='fas fa-store' style='color:#facc15;font-size:15px;'></i></div>",
                        iconSize: [42, 42],
                        iconAnchor: [21, 21]
                    });

                    L.marker([lat, lng], { icon }).addTo(map).bindPopup(`
                        <div style="font-family:'Outfit',sans-serif;">
                            <strong style="display:block;margin-bottom:4px;color:#0f172a;">${pasar.nama_pasar}</strong>
                            <span style="font-size:12px;color:#64748b;">${pasar.hari_pasaran_compact ?? pasar.hari_pasaran} • ${pasar.jam_operasional ?? 'Jam belum tersedia'}</span>
                        </div>
                    `).openPopup();
                } else {
                    map.setView([-6.3275, 108.3249], 11);
                }

                setTimeout(function() { map.invalidateSize(); }, 200);
            }

            if (copyButton) {
                copyButton.addEventListener('click', async function() {
                    const url = copyButton.getAttribute('data-url');
                    try {
                        await navigator.clipboard.writeText(url);
                        copyButton.innerHTML = '<i class="fas fa-check"></i> Link Tersalin';
                    } catch (error) {
                        window.prompt('Salin tautan ini:', url);
                    }
                });
            }

            // Ulasan Modal Logic
            const btnTulis = document.getElementById('btn-tulis-ulasan');
            const modal = document.getElementById('modal-ulasan');
            const modalContent = document.getElementById('modal-ulasan-content');
            const btnClose = document.getElementById('btn-close-modal');
            const form = document.getElementById('form-ulasan');
            const starRating = document.getElementById('star-rating');
            const inputRating = document.getElementById('input-rating');
            
            if (starRating) {
                const stars = starRating.querySelectorAll('.fa-star');
                const storageKey = 'has_reviewed_pasar_{{ $pasar->id }}';
                
                if (!localStorage.getItem(storageKey)) {
                    btnTulis.style.display = 'inline-flex';
                }

                function openModal() {
                    modal.classList.remove('hidden');
                    void modal.offsetWidth;
                    modal.classList.remove('opacity-0');
                    modalContent.classList.remove('scale-95');
                }

                function closeModal() {
                    modal.classList.add('opacity-0');
                    modalContent.classList.add('scale-95');
                    setTimeout(() => modal.classList.add('hidden'), 300);
                }

                btnTulis.addEventListener('click', openModal);
                btnClose.addEventListener('click', closeModal);
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) closeModal();
                });

                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        const rating = this.getAttribute('data-rating');
                        inputRating.value = rating;
                        stars.forEach(s => {
                            if (s.getAttribute('data-rating') <= rating) {
                                s.classList.remove('text-slate-300');
                                s.classList.add('text-[#facc15]');
                            } else {
                                s.classList.remove('text-[#facc15]');
                                s.classList.add('text-slate-300');
                            }
                        });
                    });
                });

                form.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    if (!inputRating.value) {
                        alert('Mohon berikan rating (bintang).');
                        return;
                    }

                    const btnSubmit = document.getElementById('btn-submit-ulasan');
                    btnSubmit.disabled = true;
                    btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';

                    try {
                        const formData = new FormData(form);
                        const response = await fetch('{{ route('ulasan.store') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (data.success) {
                            alert(data.message);
                            localStorage.setItem(storageKey, 'true');
                            btnTulis.style.display = 'none';
                            closeModal();
                        } else {
                            if (data.errors) {
                                alert(Object.values(data.errors).flat().join('\n'));
                            } else {
                                alert('Terjadi kesalahan. Silakan coba lagi.');
                            }
                        }
                    } catch (error) {
                        alert('Terjadi kesalahan jaringan.');
                    } finally {
                        btnSubmit.disabled = false;
                        btnSubmit.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim Ulasan';
                    }
                });
            }
        });
    </script>
@endsection
