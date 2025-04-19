<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::all();
        $totalBobot = $kriterias->sum('bobot');
    
        // ambil CR terakhir dari session jika pernah dihitung
        $cr = session('cr'); // atau simpan ke DB kalau perlu
    
        return view('kriteria.index', compact('kriterias', 'totalBobot', 'cr'));
    }
    

    public function create()
    {
        return view('kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:kriterias,kode',
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        Kriteria::create($request->only(['kode', 'nama', 'deskripsi']));

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil ditambahkan!');
    }

    public function edit(Kriteria $kriterium)
    {
        // Ubah nama parameter ke $kriteria agar Blade tetap pakai $kriteria
        return view('kriteria.edit', ['kriteria' => $kriterium]);
    }

    public function update(Request $request, Kriteria $kriterium)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:kriterias,kode,' . $kriterium->id,
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'bobot' => 'nullable|numeric|min:0|max:1',
        ]);
    
        $kriterium->update($request->all());
    
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil diperbarui!');
    }
    
    

    public function destroy(Kriteria $kriterium)
    {
        $kriterium->delete();
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil dihapus!');
    }

    public function show(Kriteria $kriterium)
    {
        return view('kriteria.show', ['kriteria' => $kriterium]);
    }
}
