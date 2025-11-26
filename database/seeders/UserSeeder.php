<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\KtaHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker; // Import Faker untuk data palsu yg realistis
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Pakai data orang Indonesia
        // Hapus data user lama untuk memastikan data bersih
        User::query()->delete();

        // Daftar data contoh
        $asalInstansi = ['Kementerian PUPR', 'Balai Wilayah Sungai', 'Dinas SDA Provinsi', 'Konsultan Teknik', 'Akademisi'];
        $jabatan = ['Teknik Pengairan Ahli Muda', 'Teknik Pengairan Ahli Madya', 'Analis SDA', 'Perencana Irigasi'];
        $provinsiIndonesia = [
            'Aceh', 'Sumatera Utara', 'Sumatera Barat', 'Riau', 'Jambi', 'Sumatera Selatan', 'Bengkulu', 'Lampung', 'Kepulauan Bangka Belitung', 'Kepulauan Riau',
            'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'DI Yogyakarta', 'Jawa Timur', 'Banten', 'Bali', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur', 'Kalimantan Barat',
            'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara', 'Sulawesi Utara', 'Sulawesi Tengah', 'Sulawesi Selatan', 'Sulawesi Tenggara', 'Gorontalo', 'Sulawesi Barat',
            'Maluku', 'Maluku Utara', 'Papua Barat', 'Papua'
        ];

        $passwordDefault = Hash::make('password');

        // ==========================================
        // 1. AKUN PUSAT (KODE WILAYAH '00')
        // ==========================================
        
        User::create([
            'nama_lengkap' => 'Super Admin HIMPESDA',
            'email' => 'super.admin@himpesda.org',
            'password' => $passwordDefault,
            'level' => 'admin',
            'status_pengajuan' => 'active',
            'tipe_anggota' => 'pusat',
            'provinsi' => 'DKI JAKARTA', // Lokasi fisik sekretariat
            'provinsi_id' => '00',
            'nip' => 'ADM-001',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '1990-01-01',
            'asal_instansi' => 'DPP HIMPESDA',
        ]);
        
        // Admin Pusat
        User::create([
            'nama_lengkap' => 'Admin Pusat',
            'email' => 'admin@himpesda.org',
            'password' => $passwordDefault,
            'level' => 'admin',
            'status_pengajuan' => 'active',
            'tipe_anggota' => 'pusat',
            'provinsi' => 'DKI JAKARTA',
            'provinsi_id' => '00',
            'nip' => 'ADM-PUSAT',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '1991-01-01',
            'asal_instansi' => 'DPP HIMPESDA',
        ]);

        // Operator Pusat (000002)
        User::create([
            'nama_lengkap' => 'Operator Pusat',
            'email' => 'operator.pusat@himpesda.org',
            'password' => $passwordDefault,
            'level' => 'operator',
            'status_pengajuan' => 'active',
            'tipe_anggota' => 'pusat',
            'provinsi' => 'DKI JAKARTA',
            'provinsi_id' => '00',
            'nip' => 'OP-PUSAT',
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => '1992-02-02',
            'asal_instansi' => 'DPP HIMPESDA',
        ]);

        // Bendahara Pusat (000003)
        User::create([
            'nama_lengkap' => 'Bendahara Pusat',
            'email' => 'bendahara.pusat@himpesda.org',
            'password' => $passwordDefault,
            'level' => 'bendahara',
            'status_pengajuan' => 'active',
            'tipe_anggota' => 'pusat',
            'provinsi' => 'DKI JAKARTA',
            'provinsi_id' => '00',
            'nomor_anggota' => '000003', 
            'nip' => 'BD-PUSAT',
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => '1993-03-03',
            'asal_instansi' => 'DPP HIMPESDA',
        ]);
    }
}