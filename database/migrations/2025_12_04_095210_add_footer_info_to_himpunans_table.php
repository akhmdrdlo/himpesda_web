<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('himpunans', function (Blueprint $table) {
            $table->text('alamat')->nullable()->after('nominal_iuran');
            $table->string('email_resmi')->nullable()->after('alamat');
            $table->string('nomor_telepon')->nullable()->after('email_resmi');
            $table->text('deskripsi_footer')->nullable()->after('nomor_telepon');
        });
    }

    public function down()
    {
        Schema::table('himpunans', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'email_resmi', 'nomor_telepon', 'deskripsi_footer']);
        });
    }
};
