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
        Schema::create('pasar_desa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pasar', 100);
            $table->text('alamat_lengkap');
            $table->text('deskripsi');
            $table->string('hari_pasaran', 50);
            $table->string('jam_operasional', 50);
            $table->string('foto_pasar')->nullable(); // nullable() jika foto tidak wajib diisi saat awal input
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasar_desa');
    }
};
