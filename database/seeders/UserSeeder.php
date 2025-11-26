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
     * DATA KETUA UMUM DAERAH (Dari CSV)
     * Key array disesuaikan dengan Nama Provinsi di KtaHelper agar mudah dicocokkan.
     */
    private $dataKetua = [
        'DKI JAKARTA' => ['nama' => 'Rizali, S.T., M.T.', 'gol' => 'IV/a', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BBWS Ciliwung Cisadane'],
        'BANTEN' => ['nama' => 'Mahar Himawan, ST, MSc', 'gol' => 'IV/a', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BBWS Cidanau Ciujung Cidurian'],
        'DAERAH ISTIMEWA YOGYAKARTA' => ['nama' => 'Ir. Sahril, Sp.PSDA.', 'gol' => 'IV/b', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BBWS Serayu Opak'],
        'JAWA TENGAH' => ['nama' => 'Cecep Muhtaj Munajat, S.T., MPSDA', 'gol' => 'IV/a', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BBWS Pemali Juana'],
        'JAWA TIMUR' => ['nama' => 'Dr. Indah Kusuma Hidayati, S.T., M.T.', 'gol' => 'IV/b', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BBWS Brantas'],
        'JAWA BARAT' => ['nama' => 'Dendy Harry Utama, ST., MT.', 'gol' => 'IV/a', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BBWS Citarum'],
        'PAPUA' => ['nama' => 'Romie Rihardson Tongkeles, S.T. M.T.', 'gol' => 'IV/a', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BWS Papua Merauke'],
        'KALIMANTAN UTARA' => ['nama' => 'Bambang Pramujo, S.T. M.T', 'gol' => 'III/d', 'jabatan' => 'Pengelola SDA Ahli Muda', 'unit' => 'BWS Kalimantan V'],
        'KEPULAUAN RIAU' => ['nama' => 'Dadang Ridwan, S.T. MPSDA', 'gol' => 'IV/b', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BWS Sumatera IV'],
        'KALIMANTAN TENGAH' => ['nama' => 'Yakubson, S.T. M.T.', 'gol' => 'III/d', 'jabatan' => 'Pengelola SDA Ahli Muda', 'unit' => 'BWS Kalimantan II'],
        'GORONTALO' => ['nama' => 'Febrian Kusmajaya, S.T. M.T.', 'gol' => 'III/d', 'jabatan' => 'Pengelola SDA Ahli Muda', 'unit' => 'BWS Sulawesi II'],
        'SULAWESI TENGGARA' => ['nama' => 'Arif Sidik, S.T., M.Eng', 'gol' => 'IV/a', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BWS Sulawesi IV'],
        'PAPUA BARAT' => ['nama' => 'Iswandi A. Hasan, S.T.', 'gol' => 'IV/a', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BWS Papua Barat'],
        'MALUKU' => ['nama' => 'Frangky Matayane, S.T.', 'gol' => 'III/d', 'jabatan' => 'Pengelola SDA Ahli Muda', 'unit' => 'BWS Maluku'],
        'NUSA TENGGARA TIMUR' => ['nama' => 'Faris Setiawan, S.T. M.T.', 'gol' => 'III/d', 'jabatan' => 'Pengelola SDA Ahli Muda', 'unit' => 'BBWS Nusa Tenggara II'],
        'SULAWESI UTARA' => ['nama' => 'Marva Ranla Ibnu, ST, MT', 'gol' => 'IV/c', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BWS Sulawesi I'],
        'SULAWESI TENGAH' => ['nama' => 'Muhamad Ismaun, S.T. M.T', 'gol' => 'IV/b', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BWS Sulawesi II'],
        'JAMBI' => ['nama' => 'Oky Subrata, S.T. MPSDA', 'gol' => 'IV/a', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BWS Sumatera VI'],
        'KALIMANTAN SELATAN' => ['nama' => 'Ridwan Fauzi Rakhman, S.T. M.Eng', 'gol' => 'IV/a', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BWS Kalimantan III'],
        'RIAU' => ['nama' => 'Muhammad Efendi Saputra, S.T. M.T', 'gol' => 'IV/a', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BWS Sumatera III'],
        'SULAWESI SELATAN' => ['nama' => 'Ir. Anshar, Sp.1', 'gol' => 'IV/b', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BBWS Pompengan Jeneberang'],
        'ACEH' => ['nama' => 'Variadi, S.T. M.Eng', 'gol' => 'IV/a', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BWS Sumatera I'],
        'BENGKULU' => ['nama' => 'Nurfajri, S.T. Sp.1', 'gol' => 'IV/b', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BBWS Sumatera VII'],
        'BALI' => ['nama' => 'Dwi Aryani Semadhi Kubontubuh, S.T., Sp.', 'gol' => 'IV/b', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BWS Bali Penida'],
        'MALUKU UTARA' => ['nama' => "Muchlis Mas'ud, S.T.", 'gol' => 'III/d', 'jabatan' => 'Pengelola SDA Ahli Muda', 'unit' => 'BWS Maluku Utara'],
        'NUSA TENGGARA BARAT' => ['nama' => 'I Ketut Karihartha, S.T. M.T', 'gol' => 'IV/b', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BBWS Nusa Tenggara I'],
        'SUMATERA UTARA' => ['nama' => 'Dony Hermawan, S.T. MPSDA', 'gol' => 'IV/a', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BBWS Sumatera II'],
        'KEPULAUAN BANGKA BELITUNG' => ['nama' => 'Agus Saputra, S.T., M.T.', 'gol' => 'IV/a', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BWS Bangka Belitung'],
        'LAMPUNG' => ['nama' => 'Bagandi Sutami Ambarita, S.T., M.T', 'gol' => 'IV/b', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BBWS Mesuji Sekampung'],
        'SUMATERA BARAT' => ['nama' => 'Dr. Arlendenovega Satria Negara, S.T., M.Eng', 'gol' => 'IV/b', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BWS Sumatera V'],
        'SUMATERA SELATAN' => ['nama' => 'Devi Popilia, S.T, M.T', 'gol' => 'IV/a', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BBWS Sumatera VIII'],
        'KALIMANTAN BARAT' => ['nama' => 'Ir. Eddy Purnomo, M.T.', 'gol' => 'IV/c', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BWS Kalimantan I Pontianak'],
        'KALIMANTAN TIMUR' => ['nama' => 'Indrasto Dwicahyo, S.T., MPSDA', 'gol' => 'IV/a', 'jabatan' => 'Pengelola SDA Ahli Madya', 'unit' => 'BWS Kalimantan IV Samarinda'],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
$passwordDefault = Hash::make('password');
        $faker = Faker::create('id_ID'); 

        // ==========================================
        // 1. PENGURUS PUSAT
        // ==========================================
        
        User::create([
            'nama_lengkap' => 'Super Admin HIMPESDA',
            'email' => 'superadmin@himpesda.org',
            'password' => $passwordDefault,
            'level' => 'admin',
            'status_pengajuan' => 'active',
            'tipe_anggota' => 'pusat',
            'provinsi' => 'DKI JAKARTA',
            'provinsi_id' => '00',
            'nomor_anggota' => 'SUPER ADMIN HIMPESDA', 
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '1990-01-01',
            'asal_instansi' => 'DPP HIMPESDA',
        ]);

        //admin biasa
        User::create([
            'nama_lengkap' => 'Admin HIMPESDA',
            'email' => 'admin@himpesda.org',
            'password' => $passwordDefault,
            'level' => 'admin',
            'status_pengajuan' => 'active',
            'tipe_anggota' => 'pusat',
            'provinsi' => 'DKI JAKARTA',
            'provinsi_id' => '00',
            'nomor_anggota' => 'ADMIN HIMPESDA', 
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '1990-01-01',
            'asal_instansi' => 'DPP HIMPESDA',
        ]);

        User::create([
            'nama_lengkap' => 'Operator Pusat',
            'email' => 'operator.pusat@himpesda.org',
            'password' => $passwordDefault,
            'level' => 'operator',
            'status_pengajuan' => 'active',
            'tipe_anggota' => 'pusat',
            'provinsi' => 'DKI JAKARTA',
            'provinsi_id' => '00',
            'nomor_anggota' => 'OPERATOR PUSAT', 
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => '1992-02-02',
            'asal_instansi' => 'DPP HIMPESDA',
        ]);

        User::create([
            'nama_lengkap' => 'Bendahara Pusat',
            'email' => 'bendahara.pusat@himpesda.org',
            'password' => $passwordDefault,
            'level' => 'bendahara',
            'status_pengajuan' => 'active',
            'tipe_anggota' => 'pusat',
            'provinsi' => 'DKI JAKARTA',
            'provinsi_id' => '00',
            'nomor_anggota' => 'BENDAHARA PUSAT', 
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => '1993-03-03',
            'asal_instansi' => 'DPP HIMPESDA',
        ]);

        // ==========================================
        // 2. LOOPING DAERAH (KETUA -> OPERATOR -> BENDAHARA)
        // ==========================================
        
        $mapProvinsi = KtaHelper::PROVINCE_CODE_MAP;

        foreach ($mapProvinsi as $namaProvinsi => $kode) {
            
            if ($namaProvinsi === 'PUSAT') continue;

            $slug = Str::slug($namaProvinsi);
            $namaDisplay = ucwords(strtolower($namaProvinsi));

            // -------------------------------------------
            // A. KETUA UMUM DAERAH (Urutan: 0001)
            // -------------------------------------------
            // Cek apakah ada data Ketua untuk provinsi ini di array $dataKetua
            if (isset($this->dataKetua[$namaProvinsi])) {
                $data = $this->dataKetua[$namaProvinsi];
                
                User::create([
                    'nama_lengkap'      => $data['nama'],
                    'email'             => "ketua.{$slug}@himpesda.org", // Email dummy ketua
                    'password'          => $passwordDefault,
                    'level'             => 'operator_daerah', // Ketua levelnya anggota (user), atau bisa dibuat role khusus
                    'status_pengajuan'  => 'active',
                    'tipe_anggota'      => 'daerah',
                    'provinsi'          => $namaProvinsi,
                    'provinsi_id'       => $kode,
                    
                    // KTA KETUA: [KodeProv][0001] (Sesuai Permintaan)
                    'nomor_anggota'     => $kode . '0001',
                    
                    'gol_ruang'         => $data['gol'],
                    'jabatan_fungsional'=> $data['jabatan'],
                    'asal_instansi'     => $data['unit'],
                    'unit_kerja'        => 'Ketua HIMPESDA Provinsi ' . $namaDisplay,
                ]);
            }
        }
    }
}