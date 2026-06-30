<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Sirkulasi - SIPUS PSDKU POLNEP</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background-color: #fff;
            margin: 30px;
            font-size: 12pt;
            line-height: 1.3;
        }
        .kop-surat {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }
        .kop-surat h2 {
            margin: 0;
            font-size: 14pt;
            font-weight: bold;
        }
        .kop-surat h3 {
            margin: 5px 0 0 0;
            font-size: 13pt;
            font-weight: bold;
        }
        .kop-surat p {
            margin: 5px 0 0 0;
            font-size: 10pt;
            font-style: italic;
        }
        .title-section {
            text-align: center;
            margin-bottom: 20px;
        }
        .title-section h4 {
            margin: 0;
            font-size: 12pt;
            text-decoration: underline;
            text-transform: uppercase;
        }
        .title-section p {
            margin: 5px 0 0 0;
            font-size: 11pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 10pt;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
        .ttd-section {
            margin-top: 50px;
            float: right;
            width: 250px;
            text-align: center;
        }
        .ttd-section p {
            margin: 0;
        }
        .ttd-space {
            height: 75px;
        }
        @media print {
            body {
                margin: 20px;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">
    
    <div class="no-print" style="margin-bottom: 20px; padding: 10px; background: #e0f2f1; border: 1px solid #b2dfdb; border-radius: 5px; font-family: sans-serif; font-size: 10pt;">
        Halaman cetak otomatis terbuka. Klik tombol cetak di browser Anda atau gunakan <b>Ctrl + P</b>. <button onclick="window.close()" style="margin-left: 10px; padding: 5px 10px; cursor: pointer;">Tutup</button>
    </div>

    <!-- Kop Surat Dinas -->
    <div class="kop-surat">
        <h2>KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI</h2>
        <h3>POLITEKNIK NEGERI PONTIANAK</h3>
        <h3>PSDKU KABUPATEN SUKAMARA</h3>
        <p>Jalan Pancasila No. 01, Sukamara, Kalimantan Tengah. Email: psdku@polnep.ac.id</p>
    </div>

    <!-- Judul Laporan -->
    <div class="title-section">
        <h4>Laporan Rekapitulasi Transaksi Sirkulasi</h4>
        <p>Periode: <b>{{ $tglAwal->translatedFormat('d F Y') }}</b> s.d. <b>{{ $tglAkhir->translatedFormat('d F Y') }}</b></p>
    </div>

    <!-- Tabel Data -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 20%;">Nama Anggota</th>
                <th style="width: 35%;">Koleksi Buku / Arsip</th>
                <th style="width: 12%;">Jenis</th>
                <th style="width: 10%;">Tgl Pinjam</th>
                <th style="width: 10%;">Tgl Kembali</th>
                <th style="width: 8%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($loans as $index => $loan)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $loan->user?->name ?: '-' }}</td>
                    <td>{{ $loan->collection?->display_title ?: '-' }}</td>
                    <td class="text-center">{{ $loan->collection?->display_type_label ?: '-' }}</td>
                    <td class="text-center">{{ $loan->tgl_pinjam ? \Carbon\Carbon::parse($loan->tgl_pinjam)->format('d-m-Y') : '-' }}</td>
                    <td class="text-center">{{ $loan->tgl_kembali ? \Carbon\Carbon::parse($loan->tgl_kembali)->format('d-m-Y') : '-' }}</td>
                    <td class="text-center" style="font-weight: bold; text-transform: uppercase;">{{ $loan->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada transaksi sirkulasi pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan -->
    <div class="ttd-section">
        <p>Sukamara, {{ now()->translatedFormat('d F Y') }}</p>
        <p>Mengetahui,</p>
        <p><b>Petugas Perpustakaan</b></p>
        <div class="ttd-space"></div>
        <p><u>{{ Auth::user()->name }}</u></p>
        <p>NIP/NIP. -</p>
    </div>

</body>
</html>
