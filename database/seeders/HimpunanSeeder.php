<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Himpunan;

class HimpunanSeeder extends Seeder
{
    public function run(): void
    {
        Himpunan::create([
            'profil_singkat' => 'HIMPESDA adalah Himpunan profesional yang berfokus pada pengembangan dan pemberdayaan sumber daya manusia di seluruh Indonesia untuk menghadapi tantangan global.',
            'sejarah_singkat' => 'Didirikan pada tahun 2020 oleh para praktisi dan akademisi HR terkemuka.',
            'visi' => 'Menjadi pusat unggulan dalam pengembangan SDM yang berdaya saing, inovatif, dan berintegritas.',
            'misi' => 'Menyelenggarakan pelatihan, sertifikasi, riset, dan advokasi kebijakan di bidang SDM.',
            'gambar_struktur_organisasi' => 'path/to/struktur.jpg',
            'nama_ketua' => 'Dr. Budi Santoso, M.Psi.',
            'foto_ketua' => 'path/to/foto-ketua.jpg',
        ]);
    }
}