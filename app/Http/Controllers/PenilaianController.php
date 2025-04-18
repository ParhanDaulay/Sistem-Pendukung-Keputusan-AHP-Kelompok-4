<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PenilaianController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::with('penilaian')->get();
        $kriterias = Kriteria::all();
        return view('penilaian.index', compact('karyawans', 'kriterias'));
    }

    public function store(Request $request)
    {
        // Validasi awal
        $request->validate([
            'nilai' => 'required|array',
        ]);

        try {
            foreach ($request->nilai as $karyawan_id => $kriteria_nilai) {
                foreach ($kriteria_nilai as $kriteria_id => $nilai) {
                    Penilaian::updateOrCreate(
                        [
                            'karyawan_id' => $karyawan_id,
                            'kriteria_id' => $kriteria_id
                        ],
                        [
                            'nilai' => $nilai
                        ]
                    );
                }
            }

            return redirect()->back()->with('success', 'Penilaian berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan penilaian: '.$e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan penilaian. Silakan coba lagi.');
        }
    }
}
