<!DOCTYPE html>
<html>
<head>
    <title>Laporan Permohonan Informasi</title>
    <style>
        body { font-family: sans-serif; }
        /* Kop Surat */
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid black; padding-bottom: 10px; }
        .header h2, .header h3, .header p { margin: 0; }

        /* Tabel */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 12px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }

        /* Tanda Tangan */
        .footer { margin-top: 50px; text-align: right; }
    </style>
</head>
<body>

    <div class="header">
        <h3>PEMERINTAH PROVINSI KALIMANTAN SELATAN</h3>
        <h2>DINAS KOMUNIKASI DAN INFORMATIKA</h2>
        <p>Jl. Dharma Praja No. 1, Kawasan Perkantoran Pemerintah Provinsi Kalimantan Selatan</p>
        <p>Banjarbaru - Kalimantan Selatan</p>
    </div>

    <center>
        <h4>LAPORAN REKAPITULASI PERMOHONAN INFORMASI PUBLIK</h4>
        <p>Periode: {{ date('Y') }}</p>
    </center>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">No Tiket</th>
                <th width="20%">Nama Pemohon</th>
                <th width="30%">Informasi yang Diminta</th>
                <th width="15%">Tujuan</th>
                <th width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $index => $req)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $req->ticket_number }}</td>
                <td>{{ $req->applicant->name }}</td>
                <td>{{ $req->details }}</td>
                <td>{{ $req->purpose }}</td>
                <td>{{ ucfirst($req->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Banjarbaru, {{ date('d F Y') }}</p>
        <p>Pejabat Pengelola Informasi dan Dokumentasi,</p>
        <br><br><br>
        <p><strong>(Nama Pejabat Disini)</strong></p>
        <p>NIP. 1982xxxx xxxx xxxx</p>
    </div>

</body>
</html>
