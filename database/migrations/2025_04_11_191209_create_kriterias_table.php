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
        Schema::create('kriterias', function (Blueprint $table) {
            $table->id();
            $table->string('kode');       // Contoh: K1, K2, dst
            $table->string('nama');       // Contoh: Kedisiplinan, Kinerja, dll
            $table->text('deskripsi');    // Penjelasan detail dari proposal
            $table->float('bobot')->nullable();  // Untuk bobot nanti dari AHP
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriterias');
    }
};
