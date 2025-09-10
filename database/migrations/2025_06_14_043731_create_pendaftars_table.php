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
    Schema::create('pendaftars', function (Blueprint $table) {
        $table->id();
        $table->string('nama_lengkap');
        $table->string('email')->unique();
        $table->string('nip', 20)->unique()->nullable();
        $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
        $table->date('tanggal_lahir')->nullable();
        $table->string('agama', 20)->nullable();
        $table->string('npwp', 25)->nullable();
        $table->string('asal_instansi')->nullable();
        $table->string('unit_kerja')->nullable();
        $table->string('jabatan_fungsional')->nullable();
        $table->string('pas_foto')->nullable(); // Path ke pas foto
        $table->string('bukti_pembayaran')->nullable(); // Path ke bukti pembayaran

        $table->enum('status_pembayaran', ['Belum Lunas', 'Sudah Lunas'])->default('Belum Lunas');
        $table->enum('status_anggota', ['Menunggu Konfirmasi', 'Sedang Diproses', 'Aktif', 'Ditolak'])->default('Menunggu Konfirmasi');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftars');
    }
};
