<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tetap buat user Admin secara manual agar data loginnya pasti
        User::create([
            'nama_lengkap' => 'Admin HIMPESDA',
            'email' => 'admin@himpesda.org',
            'password' => Hash::make('password'),
            'level' => 'admin',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '1990-01-01',
        ]);

        User::create([
            'nama_lengkap' => 'Operator Satu',
            'email' => 'operator@himpesda.org',
            'password' => Hash::make('password'),
            'level' => 'operator',
        ]);
        
        User::create([
            'nama_lengkap' => 'Bendahara HIMPESDA',
            'email' => 'bendahara@himpesda.org',
            'password' => Hash::make('password'),
            'level' => 'bendahara',
        ]);

        // 2. Gunakan Factory untuk membuat 50 data anggota baru secara otomatis
        User::factory()->count(100)->create();
    }
}