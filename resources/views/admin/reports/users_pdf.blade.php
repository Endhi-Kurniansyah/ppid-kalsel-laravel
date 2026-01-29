<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Petugas PPID</title>
    <style>
        @page { margin: 2cm; }
        body { font-family: "Times New Roman", Times, serif; font-size: 11pt; color: #000; line-height: 1.3; }

        /* KOP SURAT */
        .kop-table { width: 100%; border-bottom: 3px double #000; margin-bottom: 2px; }
        .kop-table td { vertical-align: middle; }
        .logo-cell { width: 80px; text-align: center; }
        .logo-img { width: 70px; height: auto; }
        .text-cell { text-align: center; padding-right: 80px; }
        .text-cell h3 { font-size: 14pt; font-weight: bold; margin: 0; text-transform: uppercase; }
        .text-cell h2 { font-size: 16pt; font-weight: bold; margin: 5px 0; text-transform: uppercase; }
        .text-cell p { font-size: 9pt; margin: 0; }
        .garis-tipis { border-top: 1px solid #000; margin-bottom: 25px; }

        /* JUDUL */
        .judul { text-align: center; margin-bottom: 30px; font-weight: bold; text-transform: uppercase; }
        .judul span { text-decoration: underline; display: block; margin-bottom: 5px; font-size: 12pt; }
        .judul p { font-weight: normal; font-size: 11pt; margin-top: 5px; text-transform: none; }

        /* TABEL DATA */
        table.data { width: 100%; border-collapse: collapse; margin-bottom: 20px; table-layout: fixed; }
        table.data th, table.data td { border: 1px solid #000; padding: 8px; font-size: 10pt; vertical-align: middle; word-wrap: break-word; }
        table.data th { background-color: #f2f2f2; text-align: center; text-transform: uppercase; font-weight: bold; }

        /* TANDA TANGAN */
        .ttd-box { float: right; width: 300px; text-align: center; margin-top: 40px; }
        .ttd-box p { margin: 0; line-height: 1.5; }
        .ttd-nama { font-weight: bold; text-decoration: underline; margin-top: 70px; }
    </style>
</head>
<body>

    <table class="kop-table">
        <tr>
            <td class="logo-cell">
                {{-- Pastikan path logo sesuai --}}
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
    <div class="garis-tipis"></div>

    <div class="judul">
        <span>DAFTAR NOMINATIF PETUGAS PENGELOLA SISTEM PPID</span>
        <p>Status Data: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th width="5%">NO.</th>
                <th width="30%">NAMA LENGKAP</th>
                <th width="30%">EMAIL LOGIN</th>
                <th width="20%">HAK AKSES</th>
                <th width="15%">STATUS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $u)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}.</td>
                <td>
                    <strong>{{ $u->name }}</strong>
                </td>
                <td>{{ $u->email }}</td>
                <td style="text-align: center;">
                    @if($u->role == 'super_admin')
                        SUPER ADMIN
                    @else
                        ADMINISTRATOR
                    @endif
                </td>
                <td style="text-align: center;">
                    @if($u->is_active)
                        AKTIF
                    @else
                        NONAKTIF
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px;">
                    <i>Tidak ada data petugas terdaftar.</i>
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
