<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'level',
        'tipe_anggota',
        'nomor_anggota',
        'nip',
        'jenis_kelamin',
        'tanggal_lahir',
        'provinsi',
        'kabupaten_kota',
        'no_telp',
        'agama',
        'npwp',
        'asal_instansi',
        'unit_kerja',
        'jabatan_fungsional',
        'gol_ruang',
        'pas_foto',
        'status_pengajuan',
        'activated_at',
        'catatan_admin',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Accessor untuk menampilkan Cabang berdasarkan Tipe Anggota.
     * Nama method: get NamaAtribut Attribute -> cabangDisplay
     */
    protected function cabangDisplay(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->tipe_anggota === 'pusat' 
                          ? 'Pusat' 
                          : ($this->provinsi ?? 'Daerah') 
        );
    }
}