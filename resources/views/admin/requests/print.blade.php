<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Permohonan Informasi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        .header p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .badge { font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h2>LAPORAN PERMOHONAN INFORMASI PUBLIK</h2>
        <p>PPID PROVINSI KALIMANTAN SELATAN</p>
        <p><i>Dicetak pada: {{ date('d F Y') }}</i></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">No. Tiket</th>
                <th width="15%">Tgl Masuk</th>
                <th width="20%">Nama Pemohon</th>
                <th width="30%">Rincian Informasi</th>
                <th width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $key => $req)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $req->ticket_number }}</td>
                <td>{{ $req->created_at->format('d/m/Y') }}</td>
                <td>
                    {{ $req->name }}<br>
                    <small>NIK: {{ $req->nik }}</small>
                </td>
                <td>{{ Str::limit($req->details, 100) }}</td>
                <td>
                    @if($req->status == 'pending') MENUNGGU
                    @elseif($req->status == 'processed') DIPROSES
                    @elseif($req->status == 'finished') SELESAI
                    @elseif($req->status == 'rejected') DITOLAK
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data permohonan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
