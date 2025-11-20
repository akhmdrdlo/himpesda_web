<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    /**
     * Tentukan nama tabel secara eksplisit karena 'pembayaran' adalah singular.
     */
    protected $table = 'pembayaran';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'file_bukti',
        'jumlah',
        'status',
        'catatan_admin',
    ];

    /**
     * Mendapatkan data user pemilik pembayaran ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}