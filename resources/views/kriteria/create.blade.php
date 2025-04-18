@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Kriteria</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kriteria.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="kode" class="block text-sm font-semibold text-gray-700">Kode Kriteria</label>
                <input type="text" name="kode" id="kode" placeholder="Contoh: K1"
                       value="{{ old('kode') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            <div>
                <label for="nama" class="block text-sm font-semibold text-gray-700">Nama Kriteria</label>
                <input type="text" name="nama" id="nama" placeholder="Contoh: Kedisiplinan"
                       value="{{ old('nama') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-semibold text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" placeholder="Deskripsi kriteria..."
                          rows="3"
                          class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400">{{ old('deskripsi') }}</textarea>
            </div>

            <div>
                <label for="bobot" class="block text-sm font-semibold text-gray-700">Bobot</label>
                <input type="number" name="bobot" id="bobot" placeholder="Contoh: 0.5"
                       value="{{ old('bobot') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400"
                       min="0" max="1" step="0.01">
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded shadow transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
