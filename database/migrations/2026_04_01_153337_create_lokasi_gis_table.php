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
        Schema::create('lokasi_gis', function (Blueprint $table) {
             $table->id();
            // Mendefinisikan Foreign Key ke tabel pasar_desa
            $table->foreignId('id_pasar')->constrained('pasar_desa')->onDelete('cascade');
            // DECIMAL dengan total 10 digit, 8 digit di belakang koma untuk presisi koordinat peta
            $table->decimal('latitude', 10, 8); 
            $table->decimal('longitude', 11, 8);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasi_gis');
    }
};
