@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Data Kriteria</h1>

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('kriteria.create') }}"
               class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 transition">
                + Tambah Kriteria
            </a>
        @endif
    </div>

    @php
        $totalBobot = $kriterias->sum('bobot');
        $isBobotValid = $totalBobot > 0;
        $cr = session('cr') ?? null;
    @endphp

    @if ($isBobotValid)
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            ✅ Bobot kriteria telah dihitung. Total Bobot: <strong>{{ number_format($totalBobot, 4) }}</strong>
            @if ($cr)
                <span class="ml-4">| Consistency Ratio (CR): <strong>{{ $cr }}</strong></span>
            @endif
        </div>
    @else
        <div class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded mb-4">
            ⚠️ Bobot belum dihitung. Silakan lakukan perbandingan berpasangan terlebih dahulu.
            <a href="{{ route('pairwise.index') }}" class="underline text-orange-600 hover:text-orange-800 ml-2">Hitung Bobot Sekarang</a>
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Kode</th>
                    <th class="px-6 py-3">Nama Kriteria</th>
                    <th class="px-6 py-3">Bobot</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kriterias as $kriteria)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-6 py-3">{{ $loop->iteration }}</td>
                        <td class="px-6 py-3">{{ $kriteria->kode }}</td>
                        <td class="px-6 py-3">{{ $kriteria->nama }}</td>
                        <td class="px-6 py-3">
                            @if ($kriteria->bobot !== null)
                                <span class="text-orange-600 font-semibold">
                                    {{ number_format($kriteria->bobot, 4) }}
                                </span>
                            @else
                                <span class="text-gray-400 italic">Belum dihitung</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-center space-x-2">
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('kriteria.edit', $kriteria->id) }}"
                                   class="inline-block px-3 py-1 bg-orange-400 text-white rounded hover:bg-orange-500 text-sm">
                                    Edit
                                </a>
                                <form action="{{ route('kriteria.destroy', $kriteria->id) }}" method="POST" class="inline">
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
                        <td colspan="5" class="text-center text-gray-500 py-6">Belum ada data kriteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($isBobotValid)
        <div class="mt-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Ringkasan Bobot</h2>
            <ul class="text-sm text-gray-700 list-disc ml-6 space-y-1">
                @foreach ($kriterias as $k)
                    <li><strong>{{ $k->nama }}</strong>: {{ number_format($k->bobot, 4) }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
