<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'kode' => 'K1',
                'nama' => 'Kedisiplinan',
                'deskripsi' => 'Menilai kehadiran, kepatuhan, dan ketepatan waktu karyawan.'
            ],
            [
                'kode' => 'K2',
                'nama' => 'Kinerja',
                'deskripsi' => 'Menilai produktivitas, kualitas pekerjaan, dan pencapaian target.'
            ],
            [
                'kode' => 'K3',
                'nama' => 'Loyalitas',
                'deskripsi' => 'Menilai komitmen dan kesetiaan terhadap perusahaan.'
            ],
            [
                'kode' => 'K4',
                'nama' => 'Kerjasama Tim',
                'deskripsi' => 'Menilai kemampuan karyawan dalam bekerja sama dan berinteraksi dengan rekan kerja.'
            ],
            [
                'kode' => 'K5',
                'nama' => 'Kreativitas & Inovasi',
                'deskripsi' => 'Menilai kemampuan karyawan dalam memberikan ide baru dan menyelesaikan masalah.'
            ],
        ];

        foreach ($data as $item) {
            Kriteria::create($item);
        }
    }
}
