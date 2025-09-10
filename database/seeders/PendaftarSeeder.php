<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Pendaftar;

class PendaftarSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus semua data Pendaftar yang ada
        Pendaftar::truncate();

        // Buat 10 data Pendaftar dummy
        Pendaftar::factory()->count(10)->create();
        

    }
}