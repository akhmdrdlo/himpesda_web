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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('slug')->unique();

            // Kolom untuk menentukan sumber dokumen: 'upload' atau 'link'
            $table->enum('source_type', ['upload', 'link'])->default('upload');
            
            // Kolom untuk menyimpan path file yang diunggah
            $table->string('file_path')->nullable();

            // Kolom untuk menyimpan URL eksternal
            $table->string('external_link')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};

