<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            HimpunanSeeder::class,
            DocumentSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            BeritaSeeder::class,
            PendaftarSeeder::class, 
        ]);
    }
}