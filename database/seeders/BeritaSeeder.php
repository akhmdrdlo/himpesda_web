<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Berita;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        Berita::factory()->count(30)->create();
    }
}