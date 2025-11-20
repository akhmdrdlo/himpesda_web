<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @var \Illuminate\Foundation\Auth\Access\AuthorizesRequests
     * Ini adalah "trait" yang memberikan method ->authorize()
     */
    use AuthorizesRequests, ValidatesRequests;

    /**
     * KAMUS KODE PROVINSI MANUAL (Sesuai Gambar/Request Klien)
     * Fungsi ini menerjemahkan NAMA provinsi dari API menjadi KODE INTERNAL.
     */
    public static function getKodeProvinsiCustom($namaProvinsi)
    {
        // Bersihkan nama (Hapus 'PROVINSI', hapus spasi berlebih, jadikan huruf besar)
        $nama = strtoupper(trim(str_replace(['PROVINSI', 'DAERAH ISTIMEWA', 'DKI'], '', $namaProvinsi)));
        $nama = trim($nama); // Trim lagi setelah replace

        // MAPPING MANUAL (Diurutkan berdasarkan ID Custom - Ascending)
        // Data dari: https://ibnux.github.io/data-indonesia/provinsi.json
        $map = [
            'JAKARTA'                   => '01',
            'BANTEN'                    => '02',
            'YOGYAKARTA'                => '03',
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
            'SULAWESI BARAT'            => '32',
            'KALIMANTAN BARAT'          => '33',
            'KALIMANTAN TIMUR'          => '34',
        ];

        // Cari kecocokan parsial (Misal 'DKI JAKARTA' cocok dengan key 'JAKARTA')
        foreach ($map as $key => $code) {
            if (str_contains($nama, $key)) {
                return $code;
            }
        }

        return '00'; // Default jika tidak ditemukan
    }
}