<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $fillable = ['karyawan_id', 'kriteria_id', 'nilai'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}

