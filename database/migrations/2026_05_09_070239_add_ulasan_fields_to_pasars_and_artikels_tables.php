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
        Schema::table('pasar_desa', function (Blueprint $table) {
            $table->decimal('rata_rata_rating', 3, 2)->default(0);
            $table->integer('total_ulasan')->default(0);
        });

        Schema::table('artikel', function (Blueprint $table) {
            $table->decimal('rata_rata_rating', 3, 2)->default(0);
            $table->integer('total_ulasan')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasar_desa', function (Blueprint $table) {
            $table->dropColumn(['rata_rata_rating', 'total_ulasan']);
        });

        Schema::table('artikel', function (Blueprint $table) {
            $table->dropColumn(['rata_rata_rating', 'total_ulasan']);
        });
    }
};
