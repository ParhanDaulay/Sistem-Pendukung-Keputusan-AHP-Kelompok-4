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
                                            value="{{ session('persisted')[$k1->id][$k2->id] ?? '' }}"
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
                                            value="otomatis" 
                                            disabled
                                        >
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-gray-100 font-semibold text-center">
                        <td class="px-4 py-2 text-left">Jumlah</td>
                        @foreach ($kriterias as $k)
                            <td class="px-4 py-2 total-kolom" id="kolom-{{ $k->id }}">0</td>
                        @endforeach
                    </tr>
                </tfoot>                
            </table>
        </div>

        <div class="mt-4 text-sm text-red-600 hidden" id="warning-box">
            ⚠️ Total nilai pada salah satu baris melebihi batas yang disarankan (misalnya 9).
        </div>

        @if(auth()->user()->role === 'admin')
        <div class="mt-4 flex gap-4">
            @if(session('persisted'))
                <a href="{{ route('pairwise.index') }}"
                   class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    🔁 Reset Form
                </a>
            @else
                <button type="submit"
                        class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">
                    Simpan
                </button>
            @endif
        </div>
        @endif    
    </form>

    <div class="mt-10">
        <h2 class="text-xl font-bold mb-4">Tabel Matriks Normalisasi</h2>
        <p class="text-sm text-gray-600 mb-2">Langkah normalisasi digunakan untuk menentukan bobot relatif dari tiap kriteria.</p>
        <p class="text-sm text-gray-600 mb-4">Normalisasi dilakukan dengan membagi setiap nilai dengan jumlah kolomnya masing-masing.</p>

        <table class="min-w-full text-sm border bg-white shadow rounded">
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
                    <tr>
                        <td class="px-4 py-2 bg-gray-100 font-semibold">{{ $k1->nama }}</td>
                        @foreach ($kriterias as $k2)
                            <td class="px-4 py-2 text-center">-</td> {{-- Nanti diganti saat hasil bobot dihitung --}}
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputs = document.querySelectorAll('.pairwise-input');
        const warningBox = document.getElementById('warning-box');

        function calculateTotals() {
            const kolomTotal = {};
            const normalisasi = {}; // Untuk menyimpan nilai normalisasi
            let warning = false;

            // Reset total kolom
            document.querySelectorAll('.total-kolom').forEach(cell => {
                cell.textContent = '0';
            });

            const allKriteriaIds = [...new Set([...document.querySelectorAll('.pairwise-input')].flatMap(input => [input.dataset.i, input.dataset.j]))];

            allKriteriaIds.forEach(id => {
                kolomTotal[id] = 1; // Diagonal default 1
            });

            inputs.forEach(input => {
                const i = input.dataset.i;
                const j = input.dataset.j;
                const val = parseFloat(input.value);

                if (!isNaN(val)) {
                    // Menambahkan nilai ke kolom total
                    if (!kolomTotal[j]) kolomTotal[j] = 1;
                    kolomTotal[j] += val;

                    // Menangani nilai inverse
                    const inverseCell = document.querySelector(`.inverse-cell[data-i="${j}"][data-j="${i}"]`);
                    if (inverseCell) {
                        const inverseVal = 1 / val;
                        inverseCell.value = inverseVal.toFixed(3);

                        if (!kolomTotal[i]) kolomTotal[i] = 1;
                        kolomTotal[i] += inverseVal;
                    }
                }
            });

            // Update total kolom di tabel
            for (let key in kolomTotal) {
                const kolomCell = document.getElementById('kolom-' + key);
                if (kolomCell) {
                    kolomCell.textContent = kolomTotal[key].toFixed(3);
                }
            }

            // Menghitung normalisasi
            document.querySelectorAll('.pairwise-input').forEach(input => {
                const i = input.dataset.i;
                const j = input.dataset.j;
                const val = parseFloat(input.value);

                if (!isNaN(val)) {
                    const totalKolom = kolomTotal[j];
                    const normalisasiVal = val / totalKolom;

                    // Menyimpan nilai normalisasi
                    normalisasi[i] = normalisasi[i] || {};
                    normalisasi[i][j] = normalisasiVal;

                    // Menampilkan nilai normalisasi di tabel kedua
                    const normalisasiCell = document.querySelector(`td[data-i="${i}"][data-j="${j}"]`);
                    if (normalisasiCell) {
                        normalisasiCell.textContent = normalisasiVal.toFixed(3);
                    }
                }
            });

            if (warning) {
                warningBox.classList.remove('hidden');
            } else {
                warningBox.classList.add('hidden');
            }
        }

        // Menambahkan event listener untuk input
        inputs.forEach(input => {
            input.addEventListener('input', calculateTotals);
        });

        // Menghitung total dan normalisasi pada awalnya
        calculateTotals();
    });
</script>

@endsection
