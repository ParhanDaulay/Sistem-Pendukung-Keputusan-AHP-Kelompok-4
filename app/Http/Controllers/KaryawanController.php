<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::all();
        return view('karyawan.index', compact('karyawans'));
    }

    public function create()
    {
        return view('karyawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nip' => 'required|string|max:20|unique:karyawans',
            'jabatan' => 'required|string|max:100',
        ]);
    
        Karyawan::create($request->all());
    
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan!');
    }
    

    public function edit(Karyawan $karyawan)
    {
        return view('karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
        ]);

        $karyawan->update($request->all());
        return redirect()->route('karyawan.index')->with('success', 'Data diperbarui');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return redirect()->route('karyawan.index')->with('success', 'Karyawan dihapus');
    }
}
