<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id();
            // Mendefinisikan Foreign Key ke tabel pasar_desa
            $table->foreignId('id_pasar')->constrained('pasar_desa')->onDelete('cascade');
            $table->string('nama_fasilitas', 100);
            $table->enum('status_ketersediaan', ['Tersedia', 'Tidak Ada', 'Rusak']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fasilitas');
    }
};
