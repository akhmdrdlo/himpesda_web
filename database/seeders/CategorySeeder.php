<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama untuk menghindari duplikasi saat seeding ulang
        Category::truncate();

        // Daftar kategori yang relevan sesuai rencana
        $categories = [
            'Berita',
            'Artikel',
            'Kegiatan',
            'Pengumuman',
            'Youtube',
            'Instagram',
            'X.com'
        ];

        foreach ($categories as $categoryName) {
            Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
            ]);
        }
    }
}
