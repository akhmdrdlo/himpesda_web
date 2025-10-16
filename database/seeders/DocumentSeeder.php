<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama untuk menghindari duplikasi
        Document::query()->delete();

        // Data untuk tiga dokumen wajib
        $documents = [
            [
                'title' => 'Kode Etik dan Kode Perilaku',
                'slug' => 'kode-etik',
                'description' => 'Panduan mengenai standar etika dan perilaku profesional bagi seluruh anggota HIMPESDA.',
                'source_type' => 'upload', // Default ke upload
                'file_path' => null,
                'external_link' => null,
            ],
            [
                'title' => 'Anggaran Dasar (AD)',
                'slug' => 'anggaran-dasar',
                'description' => 'Dokumen fundamental yang mengatur dasar-dasar organisasi HIMPESDA.',
                'source_type' => 'upload',
                'file_path' => null,
                'external_link' => null,
            ],
            [
                'title' => 'Anggaran Rumah Tangga (ART)',
                'slug' => 'anggaran-rumah-tangga',
                'description' => 'Peraturan detail yang menjelaskan operasional dan pelaksanaan dari Anggaran Dasar.',
                'source_type' => 'upload',
                'file_path' => null,
                'external_link' => null,
            ],
        ];

        // Masukkan data ke database
        foreach ($documents as $doc) {
            Document::create($doc);
        }
    }
}

