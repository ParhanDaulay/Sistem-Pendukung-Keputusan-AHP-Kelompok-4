<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilRanking extends Model
{
    protected $fillable = [
        'nama_karyawan',
        'skor_per_kriteria',
        'total_skor',
    ];

    protected $casts = [
        'skor_per_kriteria' => 'array',
    ];
}
