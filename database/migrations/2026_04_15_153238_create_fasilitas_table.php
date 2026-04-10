<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
    Schema::create('fasilitas', function (Blueprint $table) {
        $table->id();
        
        $table->foreignId('id_pasar')
              ->constrained('pasar_desa')
              ->onDelete('cascade');
              
        $table->foreignId('id_jenis_fasilitas')
              ->constrained('jenis_fasilitas')
              ->onDelete('cascade');
              
        
        // Tipe: ENUM
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
