@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Hasil Bobot Kriteria</h1>

    <p class="text-sm text-gray-600 mb-4">
        Berikut adalah bobot masing-masing kriteria yang diperoleh dari perhitungan metode AHP. 
        Bobot mencerminkan tingkat kepentingan relatif dari setiap kriteria.
    </p>

    <p class="text-xs text-gray-500 mb-4">
        Dihitung pada: {{ now()->format('d M Y, H:i') }}
    </p>

    @if ($cr <= 0.1)
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            Konsistensi OK ✅ (CR = {{ $cr }})
        </div>
    @else
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            Konsistensi Tidak Valid ❌ (CR = {{ $cr }}) — Silakan revisi perbandingan!
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <p class="text-sm text-gray-700 mb-4">
        Nilai <strong>Consistency Ratio (CR)</strong> harus kurang dari atau sama dengan <strong>0.1</strong> agar hasil dapat dianggap konsisten.
    </p>

    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3">Kode</th>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Bobot</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kriterias as $k)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-6 py-3">{{ $k->kode }}</td>
                        <td class="px-6 py-3">{{ $k->nama }}</td>
                        <td class="px-6 py-3 font-semibold text-orange-600">{{ number_format($k->bobot, 4) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        @if ($cr <= 0.1)
        <a href="{{ route('ranking') }}" class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">
            Lanjut ke Perankingan
        </a>
    @else
        <button disabled class="bg-gray-300 text-gray-600 px-6 py-2 rounded cursor-not-allowed">
            Lanjut ke Perankingan (CR Tidak Valid)
        </button>
    @endif
    
    </div>

    <div class="mt-8">
        <h2 class="text-xl font-bold mb-4">Visualisasi Bobot Kriteria</h2>
        <canvas id="bobotChart" width="400" height="200"></canvas>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('bobotChart').getContext('2d');
        const labels = @json($kriterias->pluck('nama'));
        const dataBobot = @json(array_values($bobot));

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Bobot',
                    data: dataBobot,
                    backgroundColor: '#f97316'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 1,
                        ticks: {
                            stepSize: 0.1
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
