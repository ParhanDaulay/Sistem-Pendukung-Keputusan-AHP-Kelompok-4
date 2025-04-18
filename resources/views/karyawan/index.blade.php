@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Karyawan</h1>

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('karyawan.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
                + Tambah Karyawan
            </a>
        @endif
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">NIP</th>
                    <th class="px-6 py-3">Jabatan</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($karyawans as $karyawan)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-6 py-3">{{ $loop->iteration }}</td>
                        <td class="px-6 py-3">{{ $karyawan->nama }}</td>
                        <td class="px-6 py-3">{{ $karyawan->nip }}</td>
                        <td class="px-6 py-3">{{ $karyawan->jabatan }}</td>
                        <td class="px-6 py-3 text-center space-x-2">
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('karyawan.edit', $karyawan->id) }}"
                                   class="inline-block px-3 py-1 bg-orange-400 text-white rounded hover:bg-orange-500 text-sm">
                                    Edit
                                </a>

                                <form action="{{ route('karyawan.destroy', $karyawan->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Yakin ingin menghapus?')"
                                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                        Hapus
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-sm italic">Tidak tersedia</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-6">Belum ada data karyawan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
