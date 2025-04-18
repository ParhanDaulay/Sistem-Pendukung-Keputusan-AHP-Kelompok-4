<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ranking Karyawan - PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        .header { background-color: #eee; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Ranking Karyawan Terbaik (Metode AHP)</h2>

    <table>
        <thead>
            <tr class="header">
                <th>Ranking</th>
                <th>Nama Karyawan</th>
                @foreach ($kriterias as $k)
                    <th>{{ $k->nama }}</th>
                @endforeach
                <th>Skor Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ranking as $index => $r)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $r['nama'] }}</td>
                    @foreach ($kriterias as $k)
                        <td>{{ $r['kriteria'][$k->kode] ?? '-' }}</td>
                    @endforeach
                    <td><strong>{{ $r['total_skor'] }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
