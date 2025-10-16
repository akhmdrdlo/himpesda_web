<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;

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
        'published_at'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        // Memastikan semua kolom tanggal diperlakukan sebagai objek Carbon
        'published_at' => 'datetime',
        'created_at' => 'datetime', // <-- Tambahkan ini
        'updated_at' => 'datetime', // <-- Tambahkan ini
    ];

    /**
     * Get the category that owns the news.
     * Mendefinisikan relasi "belongsTo" ke model Category.
     */
    public function category()
    {
        // Relasi ini menghubungkan kolom 'kategori' di tabel 'berita'
        // dengan kolom 'id' di tabel 'categories'.
        return $this->belongsTo(Category::class, 'kategori', 'id');
    }

    // Relasi ke model User (untuk mengetahui penulis)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}