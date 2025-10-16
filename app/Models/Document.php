<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'source_type',
        'file_path',
        'external_link',
    ];

    /**
     * Accessor untuk mendapatkan URL publik dari dokumen,
     * baik itu dari file upload maupun link eksternal.
     */
    public function publicUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->source_type === 'link' && $this->external_link) {
                    return $this->external_link;
                }
                
                // --- PERUBAHAN DI SINI ---
                if ($this->source_type === 'upload' && $this->file_path) {
                    // Mengembalikan link langsung ke file di storage,
                    // sama seperti mengakses gambar.
                    return asset('storage/' . $this->file_path);
                }

                return null;
            }
        );
    }
}

