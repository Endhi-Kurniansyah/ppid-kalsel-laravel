<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Statistik PPID</title>
    <style>
        @page { margin: 2cm; }
        body { font-family: "Times New Roman", Times, serif; font-size: 11pt; color: #000; line-height: 1.3; }

        .kop-table { width: 100%; border-bottom: 3px double #000; margin-bottom: 2px; }
        .kop-table td { vertical-align: middle; }
        .logo-cell { width: 80px; text-align: center; }
        .logo-img { width: 70px; height: auto; }
        .text-cell { text-align: center; padding-right: 80px; }
        .text-cell h3 { font-size: 14pt; font-weight: bold; margin: 0; text-transform: uppercase; }
        .text-cell h2 { font-size: 16pt; font-weight: bold; margin: 5px 0; text-transform: uppercase; }
        .text-cell p { font-size: 9pt; margin: 0; }
        .garis-tipis { border-top: 1px solid #000; margin-bottom: 25px; }

        .judul { text-align: center; margin-bottom: 30px; font-weight: bold; text-transform: uppercase; }
        .judul span { text-decoration: underline; display: block; margin-bottom: 5px; font-size: 12pt; }
        .judul p { font-weight: normal; font-size: 11pt; }

        /* Style untuk Tabel Statistik */
        .stat-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; margin-top: 20px; }
        .stat-table th, .stat-table td { border: 1px solid #000; padding: 10px; font-size: 11pt; }
        .stat-table th { background-color: #f2f2f2; text-align: left; }
        .stat-table td.angka { text-align: right; font-weight: bold; width: 100px; }

        .section-title { font-weight: bold; margin-top: 20px; margin-bottom: 10px; text-decoration: underline; }

        .ttd-box { float: right; width: 300px; text-align: center; margin-top: 50px; }
        .ttd-box p { margin: 0; line-height: 1.5; }
        .ttd-nama { font-weight: bold; text-decoration: underline; margin-top: 70px; }
    </style>
</head>
<body>

    <table class="kop-table">
        <tr>
            <td class="logo-cell">
                <img src="{{ public_path('assets/static/images/logo/kalsel.png') }}" class="logo-img" alt="Logo">
            </td>
            <td class="text-cell">
                <h3>PEMERINTAH PROVINSI KALIMANTAN SELATAN</h3>
                <h2>DINAS KOMUNIKASI DAN INFORMATIKA</h2>
                <p>Jalan Dharma Praja II Kawasan Perkantoran Pemerintah Provinsi Kalimantan Selatan</p>
                <p>Banjarbaru Kode Pos 70732</p>
                <p>Laman: diskominfomc.kalselprov.go.id | Email: diskominfo@kalselprov.go.id</p>
            </td>
        </tr>
    </table>
    <div class="garis-tipis"></div>

    <div class="judul">
        <span>LAPORAN RINGKASAN STATISTIK PPID</span>
        <p>{{ $periode }}</p>
    </div>

    <div class="section-title">A. PERMOHONAN INFORMASI</div>
    <table class="stat-table">
        <tr>
            <th>Total Permohonan Masuk</th>
            <td class="angka">{{ $stats['requests_total'] }}</td>
        </tr>
        <tr>
            <th>Status Menunggu (Pending)</th>
            <td class="angka">{{ $stats['requests_pending'] }}</td>
        </tr>
        <tr>
            <th>Status Selesai / Ditindaklanjuti</th>
            <td class="angka">{{ $stats['requests_done'] }}</td>
        </tr>
    </table>

    <div class="section-title">B. PUBLIKASI & INFORMASI</div>
    <table class="stat-table">
        <tr>
            <th>Total Berita Diterbitkan</th>
            <td class="angka">{{ $stats['posts_total'] }}</td>
        </tr>
        <tr>
            <th>Total Dokumen Diunggah</th>
            <td class="angka">{{ $stats['docs_total'] }}</td>
        </tr>
    </table>

    <div class="section-title">C. INDEKS KEPUASAN MASYARAKAT (IKM)</div>
    <table class="stat-table">
        <tr>
            <th>Total Responden Survei</th>
            <td class="angka">{{ $stats['surveys_total'] }}</td>
        </tr>
        <tr>
            <th>Rata-Rata Nilai IKM (Skala 5)</th>
            <td class="angka">{{ number_format($stats['surveys_avg'], 2) }}</td>
        </tr>
    </table>

    <div class="ttd-box">
        <p>Banjarbaru, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>Pejabat Pengelola PPID,</p>

        <div class="ttd-nama">Dr. H. MUHAMAD MUSLIM, S.Pd., M.Kes.</div>
        <p>Pembina Utama Muda</p>
        <p>NIP. 19680314 199003 1 010</p>
    </div>

</body>
</html>
