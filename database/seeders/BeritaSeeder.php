<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Berita; // Sesuaikan dengan path model Berita Anda
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Mengambil semua ID dari Kategori dan User
        // Pastikan seeder untuk Category dan User sudah dijalankan sebelumnya
        $categoryIds = Category::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        if (empty($categoryIds) || empty($userIds)) {
            $this->command->error('Data Kategori atau User tidak ditemukan. Jalankan seeder yang sesuai terlebih dahulu.');
            return;
        }

        // Daftar judul berita yang relevan dengan HIMPESDA
        $titles = [
            'HIMPESDA Gelar Rapat Kerja Nasional (Rakernas) 2025 di Jakarta',
            'Peresmian Bendungan Jatigede: Peran Strategis Ahli Sumber Daya Air',
            'Workshop Pengelolaan Irigasi Modern untuk Ketahanan Pangan Nasional',
            'Wamen PU Kukuhkan Pengurus HIMPESDA Daerah Periode 2025-2028',
            'Kolaborasi Antar Daerah: Kunci Sukses Manajemen Sungai Terpadu',
            'HIMPESDA Dorong Inovasi Teknologi untuk Efisiensi Penggunaan Air',
            'Pengumuman: Program Sertifikasi Profesional Pengelola Sumber Daya Air',
            'Liputan Kegiatan Pelatihan Mitigasi Bencana Banjir dan Kekeringan',
            'Artikel: Tantangan Pengelolaan Air di Era Perubahan Iklim',
            'Youtube Live: Diskusi Panel "Masa Depan Air Indonesia"',
            'Instagram Update: Kunjungan Lapangan ke Proyek Normalisasi Sungai Ciliwung',
            'Pentingnya Kode Etik bagi Profesional Pengelola Sumber Daya Air',
            'Anggaran Dasar HIMPESDA Telah Diperbarui, Simak Poin Pentingnya',
            'Melihat Lebih Dekat Anggaran Rumah Tangga Organisasi HIMPESDA',
            'Pemerintah Siapkan Rp900 Miliar untuk Perbaikan Infrastruktur Air'
        ];

        // Buat 15 berita dengan data yang disesuaikan
        foreach ($titles as $title) {
            Berita::create([
                'judul'      => $title,
                'slug'       => Str::slug($title),
                'kategori'   => $faker->randomElement($categoryIds), // Disesuaikan: menggunakan 'kategori'
                'konten'     => $faker->paragraphs(10, true),        // Disesuaikan: menggunakan 'konten'
                'gambar'     => 'https://placehold.co/800x400/007BFF/FFFFFF?text=HIMPESDA', // Disesuaikan: menggunakan 'gambar'
                'status'     => 'published',                         // Disesuaikan: menggunakan 'status'
                'user_id'    => $faker->randomElement($userIds),      // Disesuaikan: menggunakan 'user_id'
                'published_at' => $faker->dateTimeBetween('-2 years', 'now'), // Tanggal publikasi acak dalam 2 tahun terakhir
            ]);
        }
    }
}

