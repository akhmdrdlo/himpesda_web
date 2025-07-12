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
        Schema::create('himpunans', function (Blueprint $table) {
            $table->id();
            $table->text('profil_singkat');
            $table->text('sejarah_singkat');
            $table->text('visi');
            $table->text('misi');
            $table->string('gambar_struktur_organisasi')->nullable(); // Path ke gambar
            $table->string('nama_ketua');
            $table->string('foto_ketua')->nullable(); // Path ke gambar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('himpunans');
    }
};
