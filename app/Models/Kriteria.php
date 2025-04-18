<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    // app/Models/Kriteria.php
    protected $fillable = ['kode', 'nama', 'deskripsi']; // tanpa 'bobot'

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }
}

