<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Dokumen PPID</title>
    <style>
        /* SETUP KERTAS A4 & FONT */
        @page { margin: 2cm; }
        body { font-family: "Times New Roman", Times, serif; font-size: 11pt; color: #000; line-height: 1.3; }

        /* KOP SURAT (Layout Tabel agar Logo Kiri & Teks Tengah Rapi) */
        .kop-table { width: 100%; border-bottom: 3px double #000; margin-bottom: 2px; }
        .kop-table td { vertical-align: middle; }
        .logo-cell { width: 80px; text-align: center; }
        .logo-img { width: 70px; height: auto; }
        .text-cell { text-align: center; padding-right: 80px; } /* Padding kanan agar teks benar2 di tengah kertas */
        .text-cell h3 { font-size: 14pt; font-weight: bold; margin: 0; text-transform: uppercase; }
        .text-cell h2 { font-size: 16pt; font-weight: bold; margin: 5px 0; text-transform: uppercase; }
        .text-cell p { font-size: 9pt; margin: 0; }
        .garis-tipis { border-top: 1px solid #000; margin-bottom: 25px; }

        /* JUDUL LAPORAN */
        .judul { text-align: center; margin-bottom: 25px; font-weight: bold; text-transform: uppercase; }
        .judul span { text-decoration: underline; display: block; margin-bottom: 5px; font-size: 12pt; }
        .judul p { font-weight: normal; font-size: 11pt; }

        /* TABEL DATA */
        table.data { width: 100%; border-collapse: collapse; margin-bottom: 20px; table-layout: fixed; }
        table.data th, table.data td { border: 1px solid #000; padding: 6px; font-size: 10pt; vertical-align: top; word-wrap: break-word; }
        table.data th { background-color: #f2f2f2; text-align: center; text-transform: uppercase; font-weight: bold; }

        /* TANDA TANGAN PEJABAT */
        .ttd-box { float: right; width: 300px; text-align: center; margin-top: 30px; }
        .ttd-box p { margin: 0; line-height: 1.5; }
        .ttd-nama { font-weight: bold; text-decoration: underline; margin-top: 70px; }

        /* Utility */
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
    </style>
</head>
<body>

    <table class="kop-table">
        <tr>
            <td class="logo-cell">
                {{-- Gunakan public_path agar gambar muncul di PDF --}}
                <img src="{{ public_path('assets/static/images/logo/kalsel.png') }}" class="logo-img" alt="Logo">
            </td>
            <td class="text-cell">
                <h3>PEMERINTAH PROVINSI KALIMANTAN SELATAN</h3>
                <h2>DINAS KOMUNIKASI DAN INFORMATIKA</h2>
                <p>{{ $reportSettings['report_header_address'] ?? 'Jalan Dharma Praja II Kawasan Perkantoran Pemerintah Provinsi Kalimantan Selatan. Banjarbaru Kode Pos 70732' }}</p>
                <p>Laman: {{ $reportSettings['report_header_website'] ?? 'diskominfomc.kalselprov.go.id' }} | Email: {{ $reportSettings['report_header_email'] ?? 'diskominfo@kalselprov.go.id' }}</p>
            </td>
        </tr>
    </table>

    <div class="judul">
        <span>LAPORAN REKAPITULASI DOKUMEN PUBLIK</span>
        {{-- Variabel $periode dikirim dari ReportController --}}
        <p>{{ $periode ?? 'PERIODE TAHUN ' . date('Y') }}</p>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th width="5%">NO.</th>
                <th width="35%">JUDUL INFORMASI</th>
                <th width="20%">KLASIFIKASI</th>
                <th width="25%">RINGKASAN ISI</th>
                <th width="15%">TANGGAL</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documents as $index => $doc)
            <tr>
                <td class="text-center">{{ $index + 1 }}.</td>
                <td>
                    <span class="fw-bold">{{ $doc->title }}</span>
                </td>
                <td class="text-center">
                    {{ strtoupper(str_replace('-', ' ', $doc->category)) }}
                </td>
                <td>
                    {{ \Illuminate\Support\Str::limit($doc->description, 100) }}
                </td>
                <td class="text-center">
                    {{ \Carbon\Carbon::parse($doc->created_at)->translatedFormat('d F Y') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center" style="padding: 20px;">
                    <i>Tidak ada data dokumen ditemukan pada periode ini.</i>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="ttd-box">
        <p>Banjarbaru, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>{{ $reportSettings['report_signer_position'] ?? 'Pejabat Pengelola PPID' }},</p>

        <div class="ttd-nama">{{ $reportSettings['report_signer_name'] ?? 'Dr. H. MUHAMAD MUSLIM, S.Pd., M.Kes.' }}</div>
        <p>{{ $reportSettings['report_signer_rank'] ?? 'Pembina Utama Muda' }}</p>
        <p>NIP. {{ $reportSettings['report_signer_nip'] ?? '19680314 199003 1 010' }}</p>
    </div>

</body>
</html>
