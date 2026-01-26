<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Publikasi Berita</title>
    <style>
        /* Pengaturan Kertas A4 Standar Dinas */
        @page {
            margin: 2cm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #000;
        }

        /* KOP SURAT DINAS */
        .kop-table {
            width: 100%;
            border-bottom: 3px double #000;
            margin-bottom: 20px;
        }
        .kop-table td {
            vertical-align: middle;
        }
        .logo-cell {
            width: 80px;
            text-align: center;
        }
        .logo-img {
            width: 70px;
            height: auto;
        }
        .text-cell {
            text-align: center;
            padding-right: 80px; /* Agar teks benar-benar di tengah */
        }
        .text-cell h1 { font-size: 16px; margin: 0; text-transform: uppercase; font-weight: bold; }
        .text-cell h2 { font-size: 14px; margin: 0; text-transform: uppercase; font-weight: bold; }
        .text-cell p { font-size: 11px; margin: 0; }

        /* JUDUL LAPORAN */
        .judul-laporan {
            text-align: center;
            font-weight: bold;
            margin-bottom: 25px;
            font-size: 13px;
            text-transform: uppercase;
        }
        .judul-laporan span {
            text-decoration: underline;
            display: block;
            margin-bottom: 5px;
        }

        /* TABEL DATA */
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: fixed;
        }
        table.data th, table.data td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 11px;
            vertical-align: top;
            word-wrap: break-word;
        }
        table.data th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
        }

        /* TANDA TANGAN PEJABAT */
        .ttd-box {
            float: right;
            width: 300px;
            text-align: center;
            margin-top: 30px;
        }
        .ttd-box p {
            margin: 0;
            line-height: 1.5;
        }
        .ttd-nama {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 70px;
        }
    </style>
</head>
<body>

    <table class="kop-table">
        <tr>
            <td class="logo-cell">
                <img src="{{ public_path('assets/static/images/logo/kalsel.png') }}" class="logo-img" alt="Logo">
            </td>
            <td class="text-cell">
                <h1>PEMERINTAH PROVINSI KALIMANTAN SELATAN</h1>
                <h2>DINAS KOMUNIKASI DAN INFORMATIKA</h2>
                <p>{{ $reportSettings['report_header_address'] ?? 'Jalan Dharma Praja II Kawasan Perkantoran Pemerintah Provinsi Kalimantan Selatan. Banjarbaru Kode Pos 70732' }}</p>
                <p>Laman: dinkominfo.kalselprov.go.id | Email: ppid@kalselprov.go.id</p>
            </td>
        </tr>
    </table>

    <div class="judul-laporan">
        <span>LAPORAN REKAPITULASI PUBLIKASI BERITA DAN PENGUMUMAN</span>
        {{-- Variabel ini dikirim dari Controller (Sudah dinamis) --}}
        {{ $labelPeriode ?? 'PERIODE TAHUN ' . date('Y') }}
    </div>

    <table class="data">
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="15%">TGL TERBIT</th>
                <th width="40%">JUDUL BERITA / ARTIKEL</th>
                <th width="20%">KATEGORI</th>
                <th width="20%">STATUS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $index => $post)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}.</td>
                <td style="text-align: center;">
                    {{ \Carbon\Carbon::parse($post->created_at)->translatedFormat('d/m/Y') }}
                </td>
                <td>
                    <strong>{{ strtoupper($post->title) }}</strong><br>
                    {{-- Menggunakan $post->user->name sesuai relasi standar Laravel --}}
                    <span style="font-style: italic; color: #555;">Penulis: {{ $post->user->name ?? 'Admin' }}</span>
                </td>
                <td style="text-align: center;">
                    {{ strtoupper($post->category->name ?? 'UMUM') }}
                </td>
                <td style="text-align: center;">
                    {{-- Cek jika ada kolom status, jika tidak anggap Published --}}
                    {{ isset($post->status) && $post->status == 'published' ? 'PUBLIK' : 'TAYANG' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px;">
                    <i>Tidak ada data berita pada periode ini.</i>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="ttd-box">
        {{-- Tanggal Otomatis (Format Indonesia) --}}
        <p>Banjarbaru, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>{{ $reportSettings['report_signer_position'] ?? 'Pejabat Pengelola PPID' }},</p>

        <div class="ttd-nama">{{ $reportSettings['report_signer_name'] ?? 'Dr. H. MUHAMAD MUSLIM, S.Pd., M.Kes.' }}</div>
        <p>{{ $reportSettings['report_signer_rank'] ?? 'Pembina Utama Muda' }}</p>
        <p>NIP. {{ $reportSettings['report_signer_nip'] ?? '19680314 199003 1 010' }}</p>
    </div>

</body>
</html>
