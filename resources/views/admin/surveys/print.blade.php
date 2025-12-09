<!DOCTYPE html>
<html>
<head>
    <title>Laporan Survei Kepuasan Masyarakat</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; border-bottom: 2px solid black; padding-bottom: 10px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid black; padding: 8px; }
        th { background-color: #f2f2f2; }
        .summary { margin-bottom: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h3>PEMERINTAH PROVINSI KALIMANTAN SELATAN</h3>
        <h2>DINAS KOMUNIKASI DAN INFORMATIKA</h2>
        <p>Laporan Indeks Kepuasan Masyarakat (IKM)</p>
    </div>

    <div class="summary">
        <p>Total Responden: {{ $surveys->count() }} Orang</p>
        <p>Nilai Rata-rata Kepuasan: {{ number_format($average, 2) }} / 5.00</p>
        <p>Kesimpulan:
            @if($average >= 4.5) SANGAT BAIK
            @elseif($average >= 4) BAIK
            @elseif($average >= 3) CUKUP
            @else KURANG
            @endif
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nilai (1-5)</th>
                <th>Saran / Masukan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($surveys as $index => $s)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $s->created_at->format('d-m-Y') }}</td>
                <td>{{ $s->rating }}</td>
                <td>{{ $s->feedback ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="text-align: right; margin-top: 50px;">
        <p>Banjarbaru, {{ date('d F Y') }}</p>
        <p>Pejabat Pengelola,</p>
        <br><br>
        <p>(.........................)</p>
    </div>
</body>
</html>
