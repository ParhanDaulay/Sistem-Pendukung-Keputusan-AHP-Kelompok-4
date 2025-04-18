@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Admin</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
            <h2 class="text-xl font-semibold text-blue-600">Jumlah Karyawan</h2>
            <p class="text-3xl mt-2 text-blue-800">{{ \App\Models\Karyawan::count() }}</p>
        </div>

        <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
            <h2 class="text-xl font-semibold text-green-600">Jumlah Kriteria</h2>
            <p class="text-3xl mt-2 text-green-800">{{ \App\Models\Kriteria::count() }}</p>
        </div>

        <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
            <h2 class="text-xl font-semibold text-yellow-600">Jumlah Penilaian</h2>
            <p class="text-3xl mt-2 text-yellow-800">{{ \App\Models\Penilaian::count() }}</p>
        </div>
    </div>

    <div class="mt-8">
        <a href="{{ route('pairwise.index') }}"
           class="inline-block px-6 py-3 bg-indigo-600 text-white font-semibold rounded hover:bg-indigo-700">
            Mulai Perbandingan Kriteria
        </a>
    </div>
@endsection
