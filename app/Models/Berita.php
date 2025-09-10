<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Berita extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'kategori', 
        'konten', 
        'gambar', 
        'status', 
        'user_id',
    ];

    // Relasi ke model User (untuk mengetahui penulis)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}