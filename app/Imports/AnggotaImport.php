<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http; // <-- 1. Menggunakan HTTP Client
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class AnggotaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    private $provinsiCache; // Properti untuk menyimpan cache data provinsi
    /**
     * 2. Saat Importer dibuat, ambil data API dan simpan.
     * Ini hanya berjalan SEKALI per file impor.
     */
    public function __construct()
    {
        try {
            $response = Http::get('https://ibnux.github.io/data-indonesia/provinsi.json');
            $this->provinsiCache = $response->successful() ? $response->json() : [];
        } catch (\Exception $e) {
            $this->provinsiCache = [];
        }
    }
    public function model(array $row)
    {
        // FIX: Tambahkan pengecekan apakah data tanggal lahir adalah numerik
        // sebelum mencoba mengonversinya.
        $tanggalLahir = null;
        if (isset($row['tanggal_lahir']) && is_numeric($row['tanggal_lahir'])) {
            try {
                $tanggalLahir = Date::excelToDateTimeObject($row['tanggal_lahir'])->format('Y-m-d');
            } catch (\Exception $e) {
                $tanggalLahir = null; // Biarkan null jika konversi gagal
            }
        } elseif (isset($row['tanggal_lahir'])) {
             try {
                $tanggalLahir = date('Y-m-d', strtotime($row['tanggal_lahir']));
             } catch (\Exception $e) {
                $tanggalLahir = null;
             }
        }

        // FIX: Normalisasi data jenis kelamin
        $jenisKelamin = null;
        if (isset($row['jenis_kelamin'])) {
            // Ubah input menjadi huruf kecil dan hapus spasi berlebih
            $input = trim(strtolower($row['jenis_kelamin']));
            
            if (in_array($input, ['laki-laki', 'laki laki', 'pria', 'l'])) {
                $jenisKelamin = 'Laki-laki';
            } elseif (in_array($input, ['perempuan', 'wanita', 'p'])) {
                $jenisKelamin = 'Perempuan';
            }
        }

        // --- 3. Logika Baru: Cari Provinsi ID dari Cache API ---
        $provinsiNama = $row['provinsi'] ?? null;
        $provinsiId = $this->findProvinsiId($provinsiNama); // Gunakan helper
        
        // Fungsi ini akan memetakan setiap baris dari Excel ke kolom di tabel User
        $user = new User([
            'nama_lengkap'        => $row['nama_lengkap'] ?? null,
            'email'               => $row['email'] ?? null,
            'nip'                 => $row['nip'] ?? null,
            'jenis_kelamin'       => $jenisKelamin, // Gunakan variabel yang sudah dinormalisasi
            'tanggal_lahir'       => $tanggalLahir, // Gunakan variabel yang sudah dinormalisasi
            'agama'               => $row['agama'] ?? null,
            'npwp'                => $row['npwp'] ?? null,
            'asal_instansi'       => $row['asal_instansi'] ?? null,
            'unit_kerja'          => $row['unit_kerja'] ?? null,
            'jabatan_fungsional'  => $row['jabatan_fungsional'] ?? null,
            
            // Kolom dengan nilai default
            'password'            => Hash::make('password'), // Semua user baru diberi password default 'password'
            'level'               => 'anggota',             // Semua user yang diimpor otomatis menjadi 'anggota'
            
            // Kolom pas_foto sengaja tidak diisi melalui import, harus di-upload manual
            'pas_foto'            => null,
            
            // Tambahkan kolom lain yang ada di model Anda tapi tidak ada di file, dengan nilai default
            'no_telp'             => $row['no_telp'] ?? null,
            'gol_ruang'           => $row['gol_ruang'] ?? null,
            'provinsi'            => $provinsiNama, // Tetap simpan nama provinsinya
            'provinsi_id'         => $provinsiId,   // <-- 5. Simpan ID provinsinya
            'kabupaten_kota'      => $row['kabupaten_kota'] ?? null,
            'tipe_anggota'        => $row['tipe_anggota'] ?? 'daerah',
        ]);
        $user->save(); // 6. Simpan user agar mendapatkan ID unik

        // --- 7. LOGIKA PEMBUATAN NOMOR KTA (setelah user->id ada) ---
        // $kodeProvinsi sudah didapat dari $provinsiId
        $nomorUrut = str_pad($user->id, 4, '0', STR_PAD_LEFT); 
        $nomorKTA = $provinsiId . $nomorUrut;

        // 8. Update user dengan nomor KTA yang baru
        $user->nomor_anggota = $nomorKTA;
        $user->save();

        return $user; // Kembalikan user yang sudah lengkap
    }
    
    /**
     * Helper function untuk mencari ID provinsi dari cache
     * @param string|null $namaProvinsi
     * @return string
     */
    private function findProvinsiId($namaProvinsi): string
    {
        if (empty($namaProvinsi) || empty($this->provinsiCache)) {
            return '00'; // Default jika nama provinsi kosong atau API gagal
        }

        foreach ($this->provinsiCache as $provinsi) {
            // Mencocokkan nama dengan case-insensitive
            if (trim(strtolower($provinsi['nama'])) == trim(strtolower($namaProvinsi))) {
                return $provinsi['id'];
            }
        }

        return '00'; // Default jika nama provinsi tidak ditemukan di API
    }
}

