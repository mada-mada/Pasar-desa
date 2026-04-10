<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisFasilitas;

class JenisFasilitasSeeder extends Seeder
{
    public function run()
    {
        $fasilitas = [
            ['nama_fasilitas' => 'Toilet Umum', 'icon_fasilitas' => 'fa-solid fa-toilet'],
            ['nama_fasilitas' => 'Mushola', 'icon_fasilitas' => 'fa-solid fa-mosque'],
            ['nama_fasilitas' => 'Area Parkir Motor', 'icon_fasilitas' => 'fa-solid fa-motorcycle'],
            ['nama_fasilitas' => 'Area Parkir Mobil', 'icon_fasilitas' => 'fa-solid fa-car'],
            ['nama_fasilitas' => 'Tempat Pembuangan Sampah (TPS)', 'icon_fasilitas' => 'fa-solid fa-trash'],
            ['nama_fasilitas' => 'Pos Keamanan', 'icon_fasilitas' => 'fa-solid fa-handcuffs'],
            ['nama_fasilitas' => 'Akses Kursi Roda', 'icon_fasilitas' => 'fa-solid fa-wheelchair'],
        ];
        foreach ($fasilitas as $item) {
            JenisFasilitas::create($item);
        }
    }
}
