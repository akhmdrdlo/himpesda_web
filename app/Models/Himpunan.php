<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Himpunan extends Model
{
    use HasFactory;

    protected $fillable = [
        'profil_singkat',
        'sejarah_singkat',
        'visi',
        'misi',
        'gambar_struktur_organisasi',
        'nama_ketua',
        'foto_ketua',
        'gambar_struktur_organisasi',
        'nama_bank',
        'no_rekening',
        'nama_pemilik_rekening',
        'nominal_iuran',
        'alamat',
        'email_resmi',
        'nomor_telepon',
        'deskripsi_footer',
    ];
}