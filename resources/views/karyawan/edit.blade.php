@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Karyawan</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="nama" class="block text-sm font-semibold text-gray-700">Nama Karyawan</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $karyawan->nama) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            <div>
                <label for="nip" class="block text-sm font-semibold text-gray-700">NPP</label>
                <input type="text" name="nip" id="nip" value="{{ old('nip', $karyawan->nip) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400" readonly>
            </div>

            <div>
                <label for="jabatan" class="block text-sm font-semibold text-gray-700">Divisi</label>
                <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', $karyawan->jabatan) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded shadow transition">
                    Update
                </button>
            </div>
        </form>
    </div>
@endsection
