<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

        // 1. Buat Pengguna Inti (Admin, Operator, Bendahara)
        User::create([
            'nama_lengkap' => 'Admin HIMPESDA',
            'email' => 'admin@himpesda.org',
            'password' => Hash::make('password'),
            'level' => 'admin',
            'tipe_anggota' => 'pusat',
            'provinsi' => 'DKI Jakarta',
            'nomor_anggota' => 'ID-PUSAT-001',
            'nip' => '199001012015031001',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '1990-01-01',
            'asal_instansi' => 'Kementerian PUPR',
        ]);

        User::create([
            'nama_lengkap' => 'Operator Satu',
            'email' => 'operator@himpesda.org',
            'password' => Hash::make('password'),
            'level' => 'operator',
            'tipe_anggota' => 'pusat',
            'provinsi' => 'DKI Jakarta',
            'nomor_anggota' => 'ID-PUSAT-002',
            'nip' => '199102022016041002',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '1991-02-02',
            'asal_instansi' => 'Kementerian PUPR',
        ]);
        
        User::create([
            'nama_lengkap' => 'Bendahara HIMPESDA',
            'email' => 'bendahara@himpesda.org',
            'password' => Hash::make('password'),
            'level' => 'bendahara',
            'tipe_anggota' => 'pusat',
            'provinsi' => 'DKI Jakarta',
            'nomor_anggota' => 'ID-PUSAT-003',
            'nip' => '199203032017052003',
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => '1992-03-03',
            'asal_instansi' => 'Kementerian PUPR',
        ]);

        // 2. Buat 20 Anggota Pusat (Jajaran Direksi statis)
        $anggotaPusat = [
            'Dr. Ir. Budi Santoso, M.Eng.', 'Prof. Dr. Siti Aminah, M.Sc.', 'Ir. H. Joko Prasetyo, IPM.', 'Dr. Rina Wulandari, S.T., M.T.', 'Ahmad Zulkifli, S.T., Ph.D.',
            'Ir. Endang Pujiastuti, M.Si.', 'Dr. Heru Wibowo, M.Eng.', 'Prof. Dr. Ir. Sutrisno, M.Sc.', 'Dewi Lestari, S.T., M.Sc.', 'Ir. Iwan Kurniawan, IPM.',
            'Dr. Taufik Hidayat, M.T.', 'Linda Susanti, S.T., M.Eng.', 'Prof. Dr. Bambang Hartono', 'Ir. Agus Salim, M.Sc.', 'Dr. Fitriani, S.T., Ph.D.',
            'Eko Prasetyo, S.T., M.Eng.', 'Ir. Maya Sari, IPM.', 'Dr. Rizal Abdullah, M.T.', 'Siti Nurhaliza, S.T., M.Sc.', 'Prof. Dr. Ir. Wahyu Hidayat'
        ];

        foreach ($anggotaPusat as $index => $nama) {
            User::factory()->create([
                'nama_lengkap' => $nama,
                'email' => strtolower(str_replace(['. ', ', ', '.'], '', Str::limit($nama, 15))) . '@himpesda.pusat.org',
                'level' => 'anggota',
                'tipe_anggota' => 'pusat',
                'provinsi' => 'DKI Jakarta',
                'nomor_anggota' => 'ID-PUSAT-' . str_pad($index + 4, 3, '0', STR_PAD_LEFT), // Melanjutkan nomor urut
                'asal_instansi' => $asalInstansi[array_rand($asalInstansi)],
                'jabatan_fungsional' => $jabatan[array_rand($jabatan)],
            ]);
        }

        // 3. Buat 100 Anggota Daerah (data acak)
        for ($i = 0; $i < 100; $i++) {
            $provinsi = $provinsiIndonesia[array_rand($provinsiIndonesia)];
            User::factory()->create([
                'level' => 'anggota',
                'tipe_anggota' => 'daerah',
                'provinsi' => $provinsi,
                'nomor_anggota' => 'ID-DAERAH-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'asal_instansi' => $asalInstansi[array_rand($asalInstansi)],
                'jabatan_fungsional' => $jabatan[array_rand($jabatan)],
            ]);
        }
    }
}

