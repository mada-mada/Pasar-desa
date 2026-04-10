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
        Schema::create('jenis_fasilitas', function (Blueprint $table) {
           $table->id(); 
        // Diberi constraint 'unique()' agar admin tidak bisa membuat 2 nama fasilitas yang persis sama.
            $table->string('nama_fasilitas', 100)->unique(); 

        // Gunanya untuk menyimpan nama class icon FontAwesome/Bootstrap 
        // (contoh: 'fas fa-toilet', 'fas fa-mosque') 
            $table->string('icon_fasilitas', 100)->nullable(); 

             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_fasilitas');
    }
};
