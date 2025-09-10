<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Pendaftar extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_lengkap',
        'email',
        'no_telp',
        'nip',
        'gol_ruang',
        'jenis_kelamin',
        'tanggal_lahir',
        'agama',
        'npwp',
        'asal_instansi',
        'unit_kerja',
        'provinsi_id',
        'jabatan_fungsional',
        'pas_foto',
        'bukti_pembayaran',
        'telepon',
        'alamat',
        'password',
    ];

    /**
     * Secara otomatis mengenkripsi password saat disimpan.
     */
    protected function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}