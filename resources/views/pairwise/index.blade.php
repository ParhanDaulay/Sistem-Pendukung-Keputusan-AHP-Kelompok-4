@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Tabel Perbandingan Berpasangan</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('pairwise.store') }}" method="POST" class="space-y-4">
        @csrf

        <div class="overflow-x-auto bg-white rounded shadow p-4">
            <table class="min-w-full text-sm border" id="pairwise-table">
                <thead class="bg-gray-100 text-center">
                    <tr>
                        <th class="px-4 py-2">Kriteria</th>
                        @foreach ($kriterias as $k)
                            <th class="px-4 py-2">{{ $k->nama }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kriterias as $k1)
                        <tr data-row="{{ $k1->id }}">
                            <th class="px-4 py-2 bg-gray-100 text-left">{{ $k1->nama }}</th>
                            @foreach ($kriterias as $k2)
                                <td class="px-2 py-1 text-center">
                                    @if ($k1->id === $k2->id)
                                        <input type="text" value="1" class="w-full text-center bg-gray-100 border border-gray-300 rounded" disabled>
                                    @elseif ($k1->id < $k2->id)
                                        @if(auth()->user()->role === 'admin')
                                            <input 
                                                type="number" 
                                                name="nilai[{{ $k1->id }}][{{ $k2->id }}]" 
                                                step="0.01" 
                                                min="0.01" 
                                                class="w-full text-center border rounded p-1 pairwise-input" 
                                                data-i="{{ $k1->id }}" 
                                                data-j="{{ $k2->id }}"
                                                value="{{ $nilai[$k1->id][$k2->id] ?? '' }}"
                                            >
                                        @else
                                            <input type="text" value="-" class="w-full text-center bg-gray-50 border border-gray-200 rounded" disabled>
                                        @endif
                                    @else
                                        <input 
                                            type="text" 
                                            class="w-full text-center bg-gray-50 border border-gray-200 rounded inverse-cell" 
                                            data-i="{{ $k1->id }}" 
                                            data-j="{{ $k2->id }}" 
                                            value="{{ isset($nilai[$k2->id][$k1->id]) ? number_format(1 / $nilai[$k2->id][$k1->id], 3) : '-' }}" 
                                            disabled
                                        >
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if(auth()->user()->role === 'admin')
        <div class="mt-4 flex gap-4">
            <button type="submit"
                    class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">
                Simpan
            </button>
            <a href="{{ route('pairwise.index') }}"
               class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                🔁 Reset Form
            </a>
        </div>
        @endif    
    </form>

    <div class="mt-10">
        <h2 class="text-xl font-bold mb-4">Matriks Normalisasi & Bobot</h2>
        <p class="text-sm text-gray-600 mb-2">Langkah normalisasi digunakan untuk menentukan bobot relatif dari tiap kriteria.</p>

        <table class="min-w-full text-sm border bg-white shadow rounded">
            <thead class="bg-gray-100 text-center">
                <tr>
                    <th class="px-4 py-2">Kriteria</th>
                    @foreach ($kriterias as $k)
                        <th class="px-4 py-2">{{ $k->nama }}</th>
                    @endforeach
                    <th class="px-4 py-2">Jumlah Bobot</th>
                </tr>
            </thead>
            <tbody>
                @php $matrix = []; $totalCol = []; $rows = []; $n = count($kriterias); @endphp
                @foreach ($kriterias as $k2)
                    @php $totalCol[$k2->id] = 0; @endphp
                    @foreach ($kriterias as $k1)
                        @php
                            $val = $k1->id === $k2->id ? 1 : (isset($nilai[$k1->id][$k2->id]) ? $nilai[$k1->id][$k2->id] : (isset($nilai[$k2->id][$k1->id]) ? 1 / $nilai[$k2->id][$k1->id] : 1));
                            $matrix[$k1->id][$k2->id] = $val;
                            $totalCol[$k2->id] += $val;
                        @endphp
                    @endforeach
                @endforeach

                @foreach ($kriterias as $k1)
                    <tr>
                        <td class="px-4 py-2 bg-gray-100 font-semibold">{{ $k1->nama }}</td>
                        @php $sum = 0; @endphp
                        @foreach ($kriterias as $k2)
                            @php
                                $val = $matrix[$k1->id][$k2->id];
                                $norm = $val / $totalCol[$k2->id];
                                $sum += $norm;
                            @endphp
                            <td class="px-4 py-2 text-center">{{ number_format($norm, 3) }}</td>
                        @endforeach
                        @php $avg = $sum / $n; @endphp
                        <td class="px-4 py-2 text-center text-orange-600 font-semibold">{{ number_format($avg, 4) }}</td>
                        @php $rows[] = $avg; @endphp
                    </tr>
                @endforeach
                <tr class="bg-gray-100">
                    <td class="px-4 py-2 font-bold text-center">Validasi</td>
                    @foreach ($kriterias as $k)
                        <td class="px-4 py-2 text-center">✔</td>
                    @endforeach
                    <td class="px-4 py-2 text-center">{{ number_format(array_sum($rows), 4) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
