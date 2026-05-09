<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PasarDesa;
use App\Models\Artikel;
use Illuminate\Support\Str;

class PasarController extends Controller
{
    public function index(Request $request)
    {
        $selectedDay = $this->normalizeDay($request->string('hari')->toString());
        $today = $this->todayName();

        $query = PasarDesa::with(['lokasiGis', 'fasilitas']);

        $this->applyMarketFilters($query, $request, $selectedDay);

        $pasar = $query->get();
        $this->decorateMarkets($pasar, $today);

        $allMarkets = PasarDesa::with('lokasiGis')->get();
        $districts = $allMarkets
            ->map(fn (PasarDesa $market) => $this->extractDistrict($market->alamat_lengkap))
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $quickStats = [
            'total_markets' => $allMarkets->count(),
            'total_districts' => $districts->count(),
            'open_today' => $allMarkets->filter(fn (PasarDesa $market) => $this->isOpenOnDay($market->hari_pasaran, $today))->count(),
        ];

        $artikel = Artikel::with('penulis')
            ->orderByDesc('tanggal_rilis')
            ->take(3)
            ->get();

        $days = $this->availableDays();

        return view('user.pasar.index', [
            'Pasar' => $pasar,
            'artikel' => $artikel,
            'days' => $days,
            'todayName' => $today,
            'selectedDay' => $selectedDay,
            'quickStats' => $quickStats,
        ]);
    }

    public function list(Request $request)
    {
        $selectedDay = $this->normalizeDay($request->string('hari')->toString());
        $selectedDistrict = trim($request->string('kecamatan')->toString());
        $sort = $request->string('sort')->toString() ?: 'nama_asc';
        $view = $request->string('view')->toString() === 'table' ? 'table' : 'grid';
        $today = $this->todayName();

        $query = PasarDesa::with(['lokasiGis', 'fasilitas']);
        $this->applyMarketFilters($query, $request, $selectedDay, $selectedDistrict);

        if ($sort === 'hari') {
            $query->orderByRaw("
                CASE hari_pasaran
                    WHEN 'Senin' THEN 1
                    WHEN 'Selasa' THEN 2
                    WHEN 'Rabu' THEN 3
                    WHEN 'Kamis' THEN 4
                    WHEN 'Jumat' THEN 5
                    WHEN 'Sabtu' THEN 6
                    WHEN 'Minggu' THEN 7
                    ELSE 8
                END
            ");
        } elseif ($sort === 'fasilitas') {
            $query->withCount('fasilitas')->orderByDesc('fasilitas_count')->orderBy('nama_pasar');
        } else {
            $query->orderBy('nama_pasar');
        }

        $pasarPage = $query
            ->paginate(12)
            ->withQueryString()
            ->through(function (PasarDesa $market) use ($today) {
                $market->is_open_today = $this->isOpenOnDay($market->hari_pasaran, $today);
                $market->district_name = $this->extractDistrict($market->alamat_lengkap);
                $market->maps_url = $this->mapsUrl($market);

                return $market;
            });

        $districts = PasarDesa::query()
            ->get(['alamat_lengkap'])
            ->map(fn (PasarDesa $market) => $this->extractDistrict($market->alamat_lengkap))
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return view('user.pasar.list', [
            'pasarPage' => $pasarPage,
            'days' => $this->availableDays(),
            'todayName' => $today,
            'selectedDay' => $selectedDay,
            'districts' => $districts,
            'selectedDistrict' => $selectedDistrict,
            'sort' => $sort,
            'view' => $view,
        ]);
    }

    public function show($id)
    {
        $pasar = PasarDesa::with(['fasilitas.jenisFasilitas', 'lokasiGis'])->findOrFail($id);
        $today = $this->todayName();
        $pasar->is_open_today = $this->isOpenOnDay($pasar->hari_pasaran, $today);
        $pasar->district_name = $this->extractDistrict($pasar->alamat_lengkap);
        $pasar->maps_url = $this->mapsUrl($pasar);

        $ulasans = $pasar->ulasans()->where('is_approved', true)->latest()->paginate(5);

        return view('user.pasar.show', [
            'pasar' => $pasar,
            'todayName' => $today,
            'ulasans' => $ulasans,
        ]);
    }

    private function applyMarketFilters($query, Request $request, ?string $selectedDay = null, ?string $selectedDistrict = null): void
    {
        $search = trim($request->string('search')->toString());

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder->where('nama_pasar', 'like', '%' . $search . '%')
                    ->orWhere('alamat_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        if ($selectedDay) {
            $query->where('hari_pasaran', 'like', '%' . $selectedDay . '%');
        }

        if ($selectedDistrict) {
            $query->where('alamat_lengkap', 'like', '%' . $selectedDistrict . '%');
        }
    }

    private function decorateMarkets($markets, string $today): void
    {
        $markets->transform(function (PasarDesa $market) use ($today) {
            $market->is_open_today = $this->isOpenOnDay($market->hari_pasaran, $today);
            $market->district_name = $this->extractDistrict($market->alamat_lengkap);
            $market->maps_url = $this->mapsUrl($market);

            return $market;
        });
    }

    private function isOpenOnDay(?string $marketDay, string $dayName): bool
    {
        if (! $marketDay) {
            return false;
        }

        return Str::contains(Str::lower($marketDay), Str::lower($dayName));
    }

    private function todayName(): string
    {
        return Carbon::now()->locale('id')->translatedFormat('l');
    }

    private function availableDays(): array
    {
        return ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    }

    private function normalizeDay(string $day): ?string
    {
        $normalized = Str::title(Str::lower(trim($day)));

        return in_array($normalized, $this->availableDays(), true) ? $normalized : null;
    }

    private function extractDistrict(?string $address): ?string
    {
        if (! $address) {
            return null;
        }

        if (preg_match('/kec(?:amatan)?\.?\s*([a-zA-Z\s]+)/iu', $address, $matches)) {
            return trim(Str::title($matches[1]));
        }

        $segments = array_values(array_filter(array_map('trim', explode(',', $address))));

        foreach (array_reverse($segments) as $segment) {
            if (Str::contains(Str::lower($segment), 'indramayu')) {
                continue;
            }

            if (Str::length($segment) <= 40) {
                return Str::title($segment);
            }
        }

        return null;
    }

    private function mapsUrl(PasarDesa $market): ?string
    {
        if (! $market->lokasiGis?->latitude || ! $market->lokasiGis?->longitude) {
            return null;
        }

        return 'https://www.google.com/maps/dir/?api=1&destination=' . $market->lokasiGis->latitude . ',' . $market->lokasiGis->longitude;
    }
}
