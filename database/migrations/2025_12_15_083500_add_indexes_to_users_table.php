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
        Schema::table('users', function (Blueprint $table) {
            $table->index('level');
            $table->index('provinsi');
            $table->index('unit_kerja');
            $table->index('jabatan_fungsional');
            $table->index('status_pengajuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['level']);
            $table->dropIndex(['provinsi']);
            $table->dropIndex(['unit_kerja']);
            $table->dropIndex(['jabatan_fungsional']);
            $table->dropIndex(['status_pengajuan']);
        });
    }
};
