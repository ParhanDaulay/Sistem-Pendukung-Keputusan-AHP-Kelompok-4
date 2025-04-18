@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Hasil Ranking Karyawan Terbaik</h1>
    <p class="text-sm text-gray-600 mb-6">Berikut adalah perhitungan akhir menggunakan metode AHP, berdasarkan bobot kriteria dan penilaian karyawan.</p>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3">Ranking</th>
                    <th class="px-6 py-3">Nama Karyawan</th>
                    @foreach ($kriterias as $k)
                        <th class="px-6 py-3">{{ $k->nama }}</th>
                    @endforeach
                    <th class="px-6 py-3">Jumlah Skor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ranking as $index => $r)
                    <tr class="border-t hover:bg-gray-50 @if ($index === 0) bg-yellow-100 font-semibold @endif">
                        <td class="px-6 py-3 text-orange-600">{{ $index + 1 }}</td>
                        <td class="px-6 py-3">{{ $r['nama'] }}</td>
                        @foreach ($kriterias as $k)
                            <td class="px-6 py-3 text-center">
                                {{ $r['kriteria'][$k->kode] ?? '-' }}
                            </td>
                        @endforeach
                        <td class="px-6 py-3 font-semibold text-gray-800 text-center">
                            {{ number_format($r['total_skor'], 4) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex gap-4">
        <a href="{{ route('ahp.export') }}"
           class="inline-block px-6 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 transition">
            🧾 Download Hasil PDF
        </a>
        <a href="{{ route('pairwise.bobot') }}"
           class="inline-block px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
            ← Kembali ke Bobot
        </a>
    </div>

    <div class="mt-10">
        <h2 class="text-xl font-bold mb-4">Visualisasi Ranking Karyawan</h2>
        <canvas id="rankingChart" height="120"></canvas>
    </div>
@endsection

@section('scripts')
<script>
    const ctxRank = document.getElementById('rankingChart').getContext('2d');
    new Chart(ctxRank, {
        type: 'bar',
        data: {
            labels: {!! json_encode($ranking->pluck('nama')) !!},
            datasets: [{
                label: 'Skor AHP',
                data: {!! json_encode($ranking->pluck('total_skor')) !!},
                backgroundColor: '#f97316',
                hoverBackgroundColor: '#ea580c'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Skor: ' + context.raw;
                        }
                    }
                },
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5,
                    ticks: {
                        stepSize: 0.5
                    },
                    title: {
                        display: true,
                        text: 'Total Skor'
                    }
                }
            }
        }
    });
</script>
@endsection
