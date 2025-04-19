@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-bold mb-4 text-gray-800">Input Penilaian Karyawan</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if($karyawans->isEmpty() || $kriterias->isEmpty())
        <div class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded mb-4">
            ⚠️ Tidak ada data karyawan atau kriteria. Silakan tambahkan terlebih dahulu.
        </div>
    @else
        <form action="{{ route('penilaian.store') }}" method="POST">
            @csrf
            <div class="overflow-x-auto bg-white rounded shadow p-4">
                <table class="min-w-full text-sm text-left border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">Karyawan</th>
                            @foreach($kriterias as $kriteria)
                                <th class="px-4 py-2 border">{{ $kriteria->nama }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($karyawans as $karyawan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border font-semibold text-gray-700">
                                    {{ $karyawan->nama }}
                                </td>
                                @foreach($kriterias as $kriteria)
                                    @php
                                        $existing = $karyawan->penilaian->where('kriteria_id', $kriteria->id)->first();
                                    @endphp
                                    <td class="px-4 py-2 border">
                                        <input type="number"
                                               name="nilai[{{ $karyawan->id }}][{{ $kriteria->id }}]"
                                               value="{{ old("nilai.{$karyawan->id}.{$kriteria->id}", $existing->nilai ?? '') }}"
                                               min="1" max="5"
                                               class="w-full border rounded px-2 py-1 text-center"
                                               @if(auth()->user()->role !== 'admin') disabled @endif>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if(auth()->user()->role === 'admin')
                <div class="mt-4">
                    <button type="submit"
                            class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">
                        💾 Simpan Penilaian
                    </button>
                </div>
            @endif
        </form>
    @endif
@endsection
