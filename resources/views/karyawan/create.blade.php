@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Karyawan</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-4 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('karyawan.store') }}" method="POST" class="bg-white p-6 rounded shadow max-w-xl">
        @csrf

        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-700">Nama</label>
            <input type="text" name="nama" class="w-full border px-4 py-2 rounded" value="{{ old('nama') }}" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-700">NPP</label>
            <input type="text" name="nip" class="w-full border px-4 py-2 rounded" value="{{ old('nip') }}" required>
        </div>

        <div class="mb-6">
            <label class="block mb-1 font-semibold text-gray-700">Divisi</label>
            <input type="text" name="jabatan" class="w-full border px-4 py-2 rounded" value="{{ old('jabatan') }}" required>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('karyawan.index') }}" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-gray-800">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-orange-500 text-white rounded hover:bg-orange-600">
                Simpan
            </button>
        </div>
    </form>
@endsection
