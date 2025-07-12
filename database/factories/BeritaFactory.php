<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Berita>
 */
class BeritaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $judul = $this->faker->sentence(6);
        return [
            'judul' => $judul,
            'slug' => \Illuminate\Support\Str::slug($judul),
            'kategori' => $this->faker->randomElement(['Kegiatan', 'Pengumuman', 'Artikel']),
            'konten' => $this->faker->paragraph(20),
            'status' => 'published',
            'user_id' => \App\Models\User::whereIn('level', ['admin', 'operator'])->inRandomOrder()->first()->id,
        ];
    }
}
