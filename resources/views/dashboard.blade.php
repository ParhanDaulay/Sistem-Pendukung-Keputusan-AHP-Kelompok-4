@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Admin</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
            <h2 class="text-sm font-semibold text-blue-600 uppercase">Jumlah Karyawan</h2>
            <p class="text-4xl mt-2 font-bold text-blue-800">{{ \App\Models\Karyawan::count() }}</p>
        </div>

        <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
            <h2 class="text-sm font-semibold text-green-600 uppercase">Jumlah Kriteria</h2>
            <p class="text-4xl mt-2 font-bold text-green-800">{{ \App\Models\Kriteria::count() }}</p>
        </div>

        <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
            <h2 class="text-sm font-semibold text-yellow-600 uppercase">Jumlah Penilaian</h2>
            <p class="text-4xl mt-2 font-bold text-yellow-800">{{ \App\Models\Penilaian::count() }}</p>
        </div>

        <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
            <h2 class="text-sm font-semibold text-purple-600 uppercase">Hasil Ranking</h2>
            <p class="text-4xl mt-2 font-bold text-purple-800">{{ \App\Models\HasilRanking::count() }}</p>
        </div>
    </div>

    <div class="mt-10 space-y-4">
        <h2 class="text-xl font-semibold text-gray-700 mb-2">Navigasi Cepat</h2>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('karyawan.index') }}"
               class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">👥 Kelola Karyawan</a>

            <a href="{{ route('kriteria.index') }}"
               class="px-6 py-2 bg-green-500 text-white rounded hover:bg-green-600">📋 Kelola Kriteria</a>

            <a href="{{ route('penilaian.index') }}"
               class="px-6 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">📝 Input Penilaian</a>

            <a href="{{ route('pairwise.index') }}"
               class="px-6 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600">⚖️ Perbandingan Kriteria</a>

            <a href="{{ route('ranking') }}"
               class="px-6 py-2 bg-orange-500 text-white rounded hover:bg-orange-600">🏆 Hasil Ranking</a>
        </div>
    </div>
@endsection
