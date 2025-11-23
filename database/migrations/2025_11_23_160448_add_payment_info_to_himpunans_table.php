<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('himpunans', function (Blueprint $table) {
            $table->string('nama_bank')->nullable()->after('foto_ketua');
            $table->string('no_rekening')->nullable()->after('nama_bank');
            $table->string('nama_pemilik_rekening')->nullable()->after('no_rekening');
            $table->decimal('nominal_iuran', 10, 2)->default(100000)->after('nama_pemilik_rekening');
        });
    }

    public function down()
    {
        Schema::table('himpunans', function (Blueprint $table) {
            $table->dropColumn(['nama_bank', 'no_rekening', 'nama_pemilik_rekening', 'nominal_iuran']);
        });
    }
};
