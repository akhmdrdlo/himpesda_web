<?php

namespace App\Helpers;

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
        if (empty($namaProvinsi)) {
            return self::PROVINCE_CODE_MAP['PUSAT'];
        }
        
        // Bersihkan input (Hapus 'PROVINSI', Hapus Spasi, Uppercase)
        // Contoh: "Provinsi Jawa Barat" -> "JAWABARAT" (jika key di atas tanpa spasi)
        // TAPI karena key di atas pakai spasi, kita cukup trim & upper
        $nama = strtoupper(trim(str_replace('PROVINSI', '', $namaProvinsi)));
        
        // Cek array, jika tidak ada kembalikan '00'
        return self::PROVINCE_CODE_MAP[$nama] ?? '00';
    }
}