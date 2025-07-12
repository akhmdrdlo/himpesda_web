<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
    public function model(array $row)
    {
        // FIX: Tambahkan pengecekan apakah data tanggal lahir adalah numerik
        // sebelum mencoba mengonversinya.
        $tanggalLahir = null;
        if (isset($row['tanggal_lahir']) && is_numeric($row['tanggal_lahir'])) {
            $tanggalLahir = Date::excelToDateTimeObject($row['tanggal_lahir'])->format('Y-m-d');
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
        // Fungsi ini akan memetakan setiap baris dari Excel ke kolom di tabel User
        return new User([
            'nama_lengkap'        => $row['nama_lengkap'],
            'email'               => $row['email'],
            'nip'                 => $row['nip'],
            'jenis_kelamin'       => $row['jenis_kelamin'],
            'tanggal_lahir'       => $tanggalLahir,
            'agama'               => $row['agama'],
            'npwp'                => $row['npwp'],
            'asal_instansi'       => $row['asal_instansi'],
            'unit_kerja'          => $row['unit_kerja'],
            'jabatan_fungsional'  => $row['jabatan_fungsional'],
            
            // Kolom dengan nilai default
            'password'            => Hash::make('password'), // Semua user baru diberi password default 'password'
            'level'               => 'anggota',             // Semua user yang diimpor otomatis menjadi 'anggota'
            
            // Kolom pas_foto sengaja tidak diisi melalui import, harus di-upload manual
            'pas_foto'            => null,
        ]);
    }
}