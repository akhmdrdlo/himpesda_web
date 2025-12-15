<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

require 'vendor/autoload.php';

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Headers sesuai request dan controller import
$headers = [
    'nama_lengkap', 
    'email', 
    'nip', 
    'jenis_kelamin', 
    'tanggal_lahir', 
    'agama', 
    'npwp', 
    'asal_instansi', 
    'unit_kerja', 
    'jabatan_fungsional',
    'no_telp',
    'gol_ruang',
    'provinsi', 
    'kabupaten_kota',
    'tipe_anggota',
    'no_KTA'
];

// Set Headers
$sheet->fromArray($headers, NULL, 'A1');

// Styling Header
$headerStyle = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '4A90E2']
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
    ],
];
$sheet->getStyle('A1:M1')->applyFromArray($headerStyle);

// Auto size columns
foreach (range('A', 'M') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Add Example Data
$exampleData = [
    [
        'Budi Santoso', 
        'budi@example.com', 
        '198001012000121001', 
        'Laki-laki', 
        '1980-01-01', 
        'Islam', 
        '12.345.678.9-000.000', 
        'Dinas PU', 
        'Bidang Tata Ruang', 
        'Ahli Muda',
        '081234567890', 
        'III/a', 
        'JAWA BARAT', 
        'Bandung',
        'daerah',
        ''
    ]
];
$sheet->fromArray($exampleData, NULL, 'A2');

$writer = new Xlsx($spreadsheet);
$path = 'public/assets/templates/template_import_anggota.xlsx';

// Ensure directory exists
if (!file_exists(dirname($path))) {
    mkdir(dirname($path), 0777, true);
}

$writer->save($path);

echo "Template created at $path" . PHP_EOL;
