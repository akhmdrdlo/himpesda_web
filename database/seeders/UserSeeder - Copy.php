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
        $passwordDefault = Hash::make('password');
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
        
        // Super Admin (000001)
        User::create([
            'nama_lengkap' => 'Super Admin HIMPESDA',
            'email' => 'admin@himpesda.org',
            'password' => $passwordDefault,
            'level' => 'admin',
            'status_pengajuan' => 'active',
            'tipe_anggota' => 'pusat',
            'provinsi' => 'DKI JAKARTA', // Lokasi fisik sekretariat
            'provinsi_id' => '00',
            'nomor_anggota' => '000001', 
            'nip' => 'ADM-001',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '1990-01-01',
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
            'nomor_anggota' => '000002', 
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

        // ==========================================
        // 2. AKUN DAERAH (LOOP DARI KTA HELPER)
        // ==========================================
        
        // Mengambil daftar provinsi langsung dari Helper agar sinkron
        $mapProvinsi = KtaHelper::PROVINCE_CODE_MAP;

        foreach ($mapProvinsi as $namaProvinsi => $kode) {
            
            // Skip jika itu adalah kode PUSAT (00), karena sudah dibuat manual diatas
            if ($namaProvinsi === 'PUSAT') continue;

            // Buat slug untuk email (misal: JAWA BARAT -> jawa-barat)
            $slug = Str::slug($namaProvinsi);
            
            // Format Nama (Title Case)
            $namaDisplay = ucwords(strtolower($namaProvinsi));

            // --- A. OPERATOR DAERAH (Akhiran 0001) ---
            User::create([
                'nama_lengkap'      => 'Operator ' . $namaDisplay,
                'email'             => "operator.{$slug}@himpesda.org",
                'password'          => $passwordDefault,
                'level'             => 'operator_daerah',
                'status_pengajuan'  => 'active',
                'tipe_anggota'      => 'daerah',
                'provinsi'          => $namaProvinsi, // Simpan UPPERCASE sesuai key Helper
                'provinsi_id'       => $kode,
                
                // KTA: [KodeProv][0001] -> Contoh Jabar: 120001
                'nomor_anggota'     => $kode . '0001', 
                
                'nip'               => 'OP-' . $kode . '-001',
                'jenis_kelamin'     => 'Laki-laki',
                'tanggal_lahir'     => '1995-01-01',
                'asal_instansi'     => 'DPD HIMPESDA ' . $namaDisplay,
            ]);

            // --- B. BENDAHARA DAERAH (Akhiran 0002) ---
            User::create([
                'nama_lengkap'      => 'Bendahara ' . $namaDisplay,
                'email'             => "bendahara.{$slug}@himpesda.org",
                'password'          => $passwordDefault,
                'level'             => 'bendahara_daerah',
                'status_pengajuan'  => 'active',
                'tipe_anggota'      => 'daerah',
                'provinsi'          => $namaProvinsi, // Simpan UPPERCASE
                'provinsi_id'       => $kode,
                
                // KTA: [KodeProv][0002] -> Contoh Jabar: 120002
                'nomor_anggota'     => $kode . '0002',
                
                'nip'               => 'BD-' . $kode . '-002',
                'jenis_kelamin'     => 'Perempuan',
                'tanggal_lahir'     => '1996-02-02',
                'asal_instansi'     => 'DPD HIMPESDA ' . $namaDisplay,
            ]);
        }

        // ==========================================
        // 3. GENERATE 20 ANGGOTA PUSAT (DUMMY)
        // ==========================================
        
        for ($i = 1; $i <= 20; $i++) {
            $kode = '00';
            // Generate KTA otomatis (akan mulai dari 000004 karena 1-3 sdh dipakai staff)
            $nomorKTA = KtaHelper::generateNextKta($kode); 

            User::create([
                'nama_lengkap'      => $faker->name,
                'email'             => $faker->unique()->userName . '@example.com', // Email dummy
                'password'          => $passwordDefault,
                'level'             => 'anggota',
                'status_pengajuan'  => 'active', // Langsung aktif
                'tipe_anggota'      => 'pusat',
                'provinsi'          => 'DKI JAKARTA',
                'provinsi_id'       => $kode,
                'nomor_anggota'     => $nomorKTA,
                'nip'               => $faker->numerify('##################'), // 18 digit
                'jenis_kelamin'     => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'tanggal_lahir'     => $faker->date('Y-m-d', '2000-01-01'),
                'asal_instansi'     => 'Kementerian PUPR (Pusat)',
                'jabatan_fungsional'=> 'Teknik Pengairan Ahli Muda',
                'unit_kerja'        => 'Direktorat Jenderal SDA',
            ]);
        }

        // ==========================================
        // 4. GENERATE 30 ANGGOTA DAERAH (ACAK)
        // ==========================================
        
        // Ambil daftar nama provinsi (kecuali PUSAT)
        $provinsiTersedia = array_keys(array_filter($mapProvinsi, fn($k) => $k !== 'PUSAT', ARRAY_FILTER_USE_KEY));

        for ($i = 1; $i <= 30; $i++) {
            // Pilih provinsi acak
            $randomProvinsi = $faker->randomElement($provinsiTersedia);
            $kode = $mapProvinsi[$randomProvinsi];
            $namaDisplay = ucwords(strtolower($randomProvinsi));

            // Generate KTA otomatis untuk wilayah tersebut
            // Ini akan mengecek DB, karena operator sdh dibuat (0001, 0002), 
            // maka anggota ini akan mulai dari 0003, 0004, dst sesuai wilayahnya.
            $nomorKTA = KtaHelper::generateNextKta($kode);

            User::create([
                'nama_lengkap'      => $faker->name,
                'email'             => $faker->unique()->userName . '@example.com',
                'password'          => $passwordDefault,
                'level'             => 'anggota',
                'status_pengajuan'  => 'active',
                'tipe_anggota'      => 'daerah',
                'provinsi'          => $randomProvinsi,
                'provinsi_id'       => $kode,
                'kabupaten_kota'    => $faker->city,
                'nomor_anggota'     => $nomorKTA,
                'nip'               => $faker->numerify('##################'),
                'jenis_kelamin'     => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'tanggal_lahir'     => $faker->date('Y-m-d', '2000-01-01'),
                'asal_instansi'     => 'Dinas SDA Provinsi ' . $namaDisplay,
                'jabatan_fungsional'=> 'Teknik Pengairan Ahli Pertama',
                'unit_kerja'        => 'Bidang Irigasi & Rawa',
                'activated_at'      => now(), // Supaya ada tanggal aktivasi
                'no_telp'           => $faker->phoneNumber,
                'agama'             => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
                'npwp'              => $faker->numerify('##.###.###.#-###.###'),
                'gol_ruang'        => $faker->randomElement(['III/a', 'III/b', 'III/c', 'IV/a', 'IV/b']),
                
            ]);
        }
    }
}