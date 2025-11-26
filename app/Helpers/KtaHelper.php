<?php

namespace App\Helpers;
use App\Models\User; // <-- Pastikan Import Model User

class KtaHelper
{
    /**
     * Peta Kustom Kode Provinsi (Versi HIMPESDA)
     * Kunci: Nama Provinsi (Uppercase dari API)
     * Nilai: Kode Kustom 2 Digit (Sesuai Gambar Revisi)
     */
    const PROVINCE_CODE_MAP = [
            'DKI JAKARTA'               => '01',
            'BANTEN'                    => '02',
            'DAERAH ISTIMEWA YOGYAKARTA'=> '03',
            'JAWA TENGAH'               => '04',
            'JAWA TIMUR'                => '05',
            'JAWA BARAT'                => '06',
            'PAPUA'                     => '07',
            'KALIMANTAN UTARA'          => '08',
            'KEPULAUAN RIAU'            => '09',
            'KALIMANTAN TENGAH'         => '10',
            'GORONTALO'                 => '11',
            'SULAWESI TENGGARA'         => '12',
            'PAPUA BARAT'               => '13',
            'MALUKU'                    => '14',
            'NUSA TENGGARA TIMUR'       => '15',
            'SULAWESI UTARA'            => '16',
            'SULAWESI TENGAH'           => '17',
            'JAMBI'                     => '18',
            'KALIMANTAN SELATAN'        => '19',
            'RIAU'                      => '20',
            'SUMATERA SELATAN'          => '21',
            'ACEH'                      => '22',
            'BENGKULU'                  => '23',
            'BALI'                      => '24',
            'MALUKU UTARA'              => '25',
            'NUSA TENGGARA BARAT'       => '26',
            'SUMATERA UTARA'            => '27',
            'KEPULAUAN BANGKA BELITUNG' => '28',
            'LAMPUNG'                   => '29',
            'SUMATERA BARAT'            => '30',
            'SULAWESI SELATAN'          => '31',
            'KALIMANTAN BARAT'          => '32',
            'KALIMANTAN TIMUR'          => '33',
            'SULAWESI BARAT'            => '34',
        // Tambahkan default
        'PUSAT' => '00', 
    ];

    /**
     * Fungsi Static untuk mengambil kode
     * Cara Pakai: KtaHelper::getCustomCode('Jawa Barat'); -> Hasil '12'
     */
    public static function getCustomCode($namaProvinsi)
    {
        if (empty($namaProvinsi)) return self::PROVINCE_CODE_MAP['PUSAT'];
        $nama = strtoupper(trim(str_replace('PROVINSI ', '', $namaProvinsi)));
        return self::PROVINCE_CODE_MAP[$nama] ?? self::PROVINCE_CODE_MAP['PUSAT'];
    }

    /**
     * GENERATE NEXT KTA (LOGIKA BARU PER WILAYAH)
     * Mencari nomor terakhir spesifik untuk kode provinsi tersebut.
     */
    public static function generateNextKta($kodeProvinsi)
    {
        // 1. Cari user terakhir yang punya kode provinsi_id SAMA dengan yang diminta
        //    dan nomor_anggotanya tidak kosong.
        $lastUser = User::where('provinsi_id', $kodeProvinsi)
                        ->whereNotNull('nomor_anggota')
                        ->orderBy('nomor_anggota', 'desc') // Urutkan dari yang terbesar (misal 120005)
                        ->first();

        $nextSequence = 1; // Default urutan awal jika belum ada data

        if ($lastUser) {
            // 2. Ambil 4 digit terakhir dari KTA terakhir
            // Misal: KTA "120005" -> diambil "0005"
            // Kita gunakan substr negatif (-4) untuk ambil 4 karakter dari belakang
            $lastSequenceStr = substr($lastUser->nomor_anggota, -4);
            
            // 3. Ubah jadi integer dan tambah 1
            $nextSequence = intval($lastSequenceStr) + 1;
        }

        // 4. Gabungkan Kode Provinsi + Urutan Baru (dipadding nol)
        // Misal: '12' + '0006' = '120006'
        return $kodeProvinsi . str_pad($nextSequence, 4, '0', STR_PAD_LEFT);
    }
}