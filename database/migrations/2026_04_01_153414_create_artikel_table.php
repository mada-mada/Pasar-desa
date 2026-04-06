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
        Schema::create('artikel', function (Blueprint $table) {
            $table->id();
            // Mendefinisikan Foreign Key ke tabel users untuk mengaitkan artikel dengan admin yang membuatnya
            $table->foreignId('id_admin')->constrained('users')->onDelete('cascade');
            $table->string('judul_artikel');
            $table->longText('isi_konten');
            $table->timestamp('tanggal_rilis')->useCurrent(); // Otomatis mengisi waktu saat dibuat
            $table->string('gambar_sampul')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikel');
    }
};
