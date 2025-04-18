@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Kriteria</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kriteria.update', $kriteria->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="kode" class="block text-sm font-semibold text-gray-700">Kode Kriteria</label>
                <input type="text" name="kode" id="kode" value="{{ old('kode', $kriteria->kode) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            <div>
                <label for="nama" class="block text-sm font-semibold text-gray-700">Nama Kriteria</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $kriteria->nama) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-semibold text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="3"
                          class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400">{{ old('deskripsi', $kriteria->deskripsi) }}</textarea>
            </div>

            @if(auth()->user()->role === 'admin')
            <div>
                <label class="block text-sm font-semibold text-gray-700">Bobot (otomatis dari AHP)</label>
                <input type="text" value="{{ $kriteria->bobot ?? '-' }}" 
                       class="w-full border border-gray-200 bg-gray-100 rounded px-3 py-2 mt-1 text-gray-600" 
                       readonly>
            </div>            
            @endif

            <div class="pt-4">
                <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded shadow transition">
                    💾 Update
                </button>
            </div>
        </form>
    </div>
@endsection
