<article
    class="group flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white transition-all duration-300 hover:border-blue-400 hover:shadow-xl hover:-translate-y-1">
    {{-- Visual Header --}}
    <div class="relative w-full overflow-hidden bg-slate-100" style="height: 220px;">
        <a href="{{ route('artikel.show', $art->id) }}" class="block h-full w-full">
            @if ($art->gambar_sampul_url)
                <img src="{{ $art->gambar_sampul_url }}" alt="{{ $art->judul_artikel }}"
                    loading="lazy"
                    class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
            @else
                <div class="flex h-full w-full items-center justify-center bg-slate-100">
                    <i class="fas fa-image text-4xl text-slate-300"></i>
                </div>
            @endif

            <div class="absolute left-5 top-5">
                <span
                    class="rounded-full bg-blue-600/90 px-4 py-1.5 text-[10px] font-bold uppercase tracking-widest text-white shadow-lg backdrop-blur-sm">
                    Warta Desa
                </span>
            </div>
        </a>
    </div>

    {{-- Content Body --}}
    <div class="flex flex-1 flex-col p-8">
        <div class="mb-3 flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">
            <i class="far fa-calendar-alt text-blue-500"></i>
            {{ $art->tanggal_rilis->translatedFormat('d F Y') }}
        </div>

        <a href="{{ route('artikel.show', $art->id) }}" class="mb-4 block">
            <h2 class="line-clamp-2 text-xl font-extrabold leading-tight text-slate-900 transition-colors group-hover:text-blue-600">
                {{ $art->judul_artikel }}
            </h2>
        </a>

        <p class="mb-8 line-clamp-3 text-sm leading-relaxed text-slate-600">
            {{ $art->excerpt ?? Str::limit(strip_tags($art->isi_konten), 140) }}
        </p>

        <div class="mt-auto border-t border-slate-100 pt-6">
            <a href="{{ route('artikel.show', $art->id) }}"
                class="inline-flex items-center gap-3 text-sm font-black text-blue-600 transition-colors hover:text-blue-700">
                Baca Selengkapnya
                <i class="fas fa-arrow-right text-[10px] transition-transform duration-300 group-hover:translate-x-1.5"></i>
            </a>
        </div>
    </div>
</article>
