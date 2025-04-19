<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\HasilRanking;
use App\Models\PerbandinganKriteria;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AHPController extends Controller
{
    // 1. Tampilkan form perbandingan kriteria
    public function index()
    {
        $kriterias = Kriteria::all();
        $nilai = [];

        foreach ($kriterias as $k1) {
            foreach ($kriterias as $k2) {
                if ($k1->id < $k2->id) {
                    $data = PerbandinganKriteria::where('kriteria_1', $k1->id)
                        ->where('kriteria_2', $k2->id)
                        ->first();

                    if ($data) {
                        $nilai[$k1->id][$k2->id] = $data->nilai;
                    }
                }
            }
        }

        return view('pairwise.index', compact('kriterias', 'nilai'));
    }

    public function reset()
    {
        PerbandinganKriteria::truncate();
        return redirect()->route('pairwise.index')->with('success', 'Data berhasil di-reset.');
    }

    // 2. Simpan perbandingan kriteria ke DB
    public function store(Request $request)
    {
        PerbandinganKriteria::truncate();

        foreach ($request->nilai as $id1 => $row) {
            foreach ($row as $id2 => $nilai) {
                if ($id1 != $id2 && $nilai != '') {
                    PerbandinganKriteria::create([
                        'kriteria_1' => $id1,
                        'kriteria_2' => $id2,
                        'nilai' => $nilai,
                    ]);
                }
            }
        }

        // Hitung bobot dan simpan
        $this->hitungBobot();

        return redirect()->route('pairwise.index')->with('success', 'Data berhasil disimpan dan bobot dihitung.');
    }

    // 3. Hitung bobot AHP + validasi CR
    public function hitungBobot()
    {
        $kriterias = Kriteria::all();
        $n = $kriterias->count();
        $matrix = [];

        foreach ($kriterias as $k1) {
            foreach ($kriterias as $k2) {
                if ($k1->id == $k2->id) {
                    $matrix[$k1->id][$k2->id] = 1;
                } else {
                    $data = PerbandinganKriteria::where('kriteria_1', $k1->id)->where('kriteria_2', $k2->id)->first();
                    if ($data) {
                        $matrix[$k1->id][$k2->id] = $data->nilai;
                        $matrix[$k2->id][$k1->id] = 1 / $data->nilai;
                    }
                }
            }
        }

        $totalKolom = [];
        foreach ($kriterias as $k2) {
            $total = 0;
            foreach ($kriterias as $k1) {
                $total += $matrix[$k1->id][$k2->id] ?? 0;
            }
            $totalKolom[$k2->id] = $total ?: 1;
        }

        $bobot = [];
        foreach ($kriterias as $k1) {
            $jumlah = 0;
            foreach ($kriterias as $k2) {
                $normal = ($matrix[$k1->id][$k2->id] ?? 0) / $totalKolom[$k2->id];
                $jumlah += $normal;
            }
            $bobot[$k1->id] = round($jumlah / $n, 4);
            $k1->bobot = $bobot[$k1->id];
            $k1->save();
        }

        $lambdaMax = 0;
        foreach ($kriterias as $k1) {
            $total = 0;
            foreach ($kriterias as $k2) {
                $total += $matrix[$k1->id][$k2->id] * $bobot[$k2->id];
            }
            $lambdaMax += $total / $bobot[$k1->id];
        }
        $lambdaMax /= $n;
        $ci = ($lambdaMax - $n) / ($n - 1);

        $riTable = [1 => 0.00, 2 => 0.00, 3 => 0.58, 4 => 0.90, 5 => 1.12, 6 => 1.24, 7 => 1.32, 8 => 1.41, 9 => 1.45, 10 => 1.49];
        $ri = $riTable[$n] ?? 1.49;
        $cr = ($ri == 0) ? 0 : round($ci / $ri, 4);

        if ($cr > 0.1) {
            return redirect()->back()->with('error', 'Matriks tidak konsisten! (CR = ' . $cr . ', harus ≤ 0.1)');
        }

        return view('pairwise.bobot', compact('kriterias', 'bobot', 'cr'));
    }

    // 4. Hitung ranking akhir berdasarkan nilai & bobot
    public function ranking()
    {
        $kriterias = Kriteria::all();
        $karyawans = Karyawan::with('penilaian')->get();
        $hasil = [];

        foreach ($karyawans as $karyawan) {
            $skorPerKriteria = [];
            $total = 0;

            foreach ($kriterias as $kriteria) {
                $penilaian = $karyawan->penilaian->where('kriteria_id', $kriteria->id)->first();
                $nilai = $penilaian ? $penilaian->nilai : 0;
                $bobot = $kriteria->bobot ?? 0;

                $skor = $nilai * $bobot;
                $skorPerKriteria[$kriteria->kode] = number_format($skor, 4);
                $total += $skor;
            }

            $hasil[] = [
                'nama' => $karyawan->nama,
                'kriteria' => $skorPerKriteria,
                'total_skor' => round($total, 4),
            ];
        }

        $ranking = collect($hasil)->sortByDesc('total_skor')->values();

        HasilRanking::truncate();
        foreach ($ranking as $r) {
            HasilRanking::create([
                'nama_karyawan' => $r['nama'],
                'skor_per_kriteria' => $r['kriteria'],
                'total_skor' => $r['total_skor'],
            ]);
        }

        return view('ahp.ranking', [
            'ranking' => $ranking,
            'kriterias' => $kriterias
        ]);
    }

    // 5. Export ranking ke PDF
    public function exportPDF()
    {
        $kriterias = Kriteria::all();
        $karyawans = Karyawan::with('penilaian')->get();
        $hasil = [];

        foreach ($karyawans as $karyawan) {
            $skorPerKriteria = [];
            $total = 0;

            foreach ($kriterias as $kriteria) {
                $penilaian = $karyawan->penilaian->where('kriteria_id', $kriteria->id)->first();
                $nilai = $penilaian ? $penilaian->nilai : 0;
                $bobot = $kriteria->bobot ?? 0;
                $skor = $nilai * $bobot;

                $skorPerKriteria[$kriteria->kode] = number_format($skor, 4);
                $total += $skor;
            }

            $hasil[] = [
                'nama' => $karyawan->nama,
                'kriteria' => $skorPerKriteria,
                'total_skor' => round($total, 4),
            ];
        }

        $ranking = collect($hasil)->sortByDesc('total_skor')->values();

        $pdf = PDF::loadView('ahp.pdf', compact('ranking', 'kriterias'));
        return $pdf->download('ranking-karyawan.pdf');
    }
}
