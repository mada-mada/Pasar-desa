<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PasarDesa extends Model
{
    use HasFactory;

    private const ORDERED_DAYS = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

    protected $table = 'pasar_desa';

    protected $fillable = [
        'id',
        'nama_pasar',
        'alamat_lengkap',
        'deskripsi',
        'hari_pasaran',
        'jam_operasional',
        'foto_pasar',
    ];

    public function getFotoPasarUrlAttribute(): ?string
    {
        return $this->resolvePublicImageUrl($this->foto_pasar);
    }

    public function getHariPasaranCompactAttribute(): ?string
    {
        $days = $this->normalizedMarketDays($this->hari_pasaran);

        if ($days === []) {
            return null;
        }

        if (count($days) === count(self::ORDERED_DAYS)) {
            return 'Senin - Minggu';
        }

        $indexes = array_values(array_map(
            fn (string $day) => array_search($day, self::ORDERED_DAYS, true),
            $days
        ));

        sort($indexes);

        $isSequential = count($indexes) > 2;

        if ($isSequential) {
            for ($i = 1; $i < count($indexes); $i++) {
                if ($indexes[$i] !== $indexes[$i - 1] + 1) {
                    $isSequential = false;
                    break;
                }
            }
        }

        if ($isSequential) {
            return self::ORDERED_DAYS[$indexes[0]] . ' - ' . self::ORDERED_DAYS[$indexes[array_key_last($indexes)]];
        }

        if (count($days) === 2) {
            return implode(' & ', $days);
        }

        return implode(', ', $days);
    }

    // Relasi One-to-Many: 1 Pasar memiliki banyak Fasilitas
    public function fasilitas()
    {
        return $this->hasMany(Fasilitas::class, 'id_pasar', 'id');
    }

    // Relasi One-to-One: 1 Pasar memiliki 1 titik Lokasi GIS
    public function lokasiGis()
    {
        return $this->hasOne(LokasiGis::class, 'id_pasar', 'id');
    }

    private function resolvePublicImageUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '//'])) {
            return $path;
        }

        if (Str::startsWith($path, ['/storage/', 'storage/'])) {
            return asset(ltrim($path, '/'));
        }

        return Storage::disk('public')->url($path);
    }

    private function normalizedMarketDays(?string $marketDays): array
    {
        if (! $marketDays) {
            return [];
        }

        $selectedDays = preg_split('/\s*,\s*/', $marketDays, -1, PREG_SPLIT_NO_EMPTY);

        return array_values(array_filter(
            self::ORDERED_DAYS,
            fn (string $day) => in_array($day, $selectedDays, true)
        ));
    }
}
