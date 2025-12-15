<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Helpers\KtaHelper;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AnggotaImport implements ToModel, WithHeadingRow
{
    protected $provinsiMap = [];
    protected $latestId;

    public function __construct()
    {

        // Ambil latest ID dari database untuk penomoran KTA
        $lastUser = User::whereNotNull('nomor_anggota')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastUser && preg_match('/(\d+)$/', $lastUser->nomor_anggota, $matches)) {
            $this->latestId = (int)$matches[1];
        } else {
            $this->latestId = 0;
        }
    }

    public function model(array $row)
    {
        $currentUser = Auth::user();
        $rawExcelProvinsi = $row['provinsi'] ?? null;

        // --- 1. VALIDASI WILAYAH OPERATOR ---
        if (in_array($currentUser->level, ['operator_daerah', 'bendahara_daerah'])) {
            if (empty($rawExcelProvinsi)) return null; 

            // Bersihkan string untuk perbandingan
            $excelProvClean = strtoupper(str_replace([' ', 'PROVINSI'], '', $rawExcelProvinsi));
            $userProvClean  = strtoupper(str_replace([' ', 'PROVINSI'], '', $currentUser->provinsi));

            // Jika beda wilayah -> SKIP (Jangan dipaksa masuk)
            if ($excelProvClean !== $userProvClean) {
                return null; 
            }
            $namaProvinsi = $currentUser->provinsi; 
            $tipeAnggota  = 'daerah';
        } else {
            // Admin Pusat
            $namaProvinsi = $rawExcelProvinsi;
            $tipeAnggota  = $namaProvinsi ? 'daerah' : 'pusat';
        }
        
        // 1. Dapat Kode (misal: '12')
        $kodeProvinsi = KtaHelper::getCustomCode($namaProvinsi);
        
        // Ambil Kode Provinsi (Misal: 12) untuk disimpan di kolom provinsi_id
        $kodeProvinsi = KtaHelper::getCustomCode($namaProvinsi);
        
        // Ambil data KTA dari Excel (Cek berbagai kemungkinan nama header)
        // Maatwebsite otomatis mengubah header jadi snake_case (misal: "No KTA" -> "no_kta")
        $manualKTA = $row['no_kta'] ?? $row['nomor_kta'] ?? $row['nomor_anggota'] ?? null;

        if (!empty($manualKTA)) {
            // A. JIKA DI EXCEL ADA ISINYA -> PAKAI ITU
            $nomorKTA = $manualKTA;
        } else {
            // B. JIKA KOSONG (NULL) -> GENERATE OTOMATIS
            $nomorKTA = KtaHelper::generateNextKta($kodeProvinsi);
        }

        // Cek email
        if (User::where('email', $row['email'])->exists()) return null;

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
            
            if (in_array($input, ['laki - laki', 'laki laki', 'pria','Laki - laki','l'])) {
                $jenisKelamin = 'Laki-laki';
            } elseif (in_array($input, ['perempuan', 'wanita', 'p'])) {
                $jenisKelamin = 'Perempuan';
            }
        }

        // ==========================================
        // 3. SIMPAN DATA
        // ==========================================

        return new User([
            'nama_lengkap' => $row['nama_lengkap'],
            'email'        => $row['email'],
            'password'     => Hash::make('password123'),
            
            // Data Pribadi
            'nip'                 => $row['nip'] ?? null,
            'jenis_kelamin'       => $jenisKelamin, // Gunakan variabel yang sudah dinormalisasi
            'tanggal_lahir'       => $tanggalLahir, // Gunakan variabel yang sudah dinormalisasi
            'no_telp'             => $row['no_telp'] ?? null,
            'agama'               => $row['agama'] ?? null,
            'npwp'                => $row['npwp'] ?? null,
            'asal_instansi'       => $row['asal_instansi'] ?? null,
            'unit_kerja'          => $row['unit_kerja'] ?? null,
            'jabatan_fungsional'  => $row['jabatan_fungsional'] ?? null,
            
            // Data Wilayah
            'provinsi'       => $namaProvinsi, // Nama tetap disimpan (untuk API UI)
            'provinsi_id'    => $kodeProvinsi, // ID disesuaikan dengan kode gambar
            'kabupaten_kota' => $row['kabupaten_kota'] ?? null,
            'gol_ruang'      => $row['gol_ruang'] ?? null,
            'nomor_anggota'  => $nomorKTA,     // KTA disesuaikan dengan kode gambar        
            'tipe_anggota'   => $tipeAnggota,
            
            // Status
            // Status - UBAH LOGIKA: Harus verifikasi dulu
            'level'            => 'anggota',
            'status_pengajuan' => 'pending', // Ubah dari 'active' ke 'pending' agar masuk antrian verifikasi
            'activated_at'     => null,      // Belum aktif
        ]);
    }
}