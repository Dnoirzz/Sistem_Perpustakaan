<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Penerimaan Arsip - SIPUS PSDKU POLNEP</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background-color: #fff;
            margin: 30px;
            font-size: 11pt;
            line-height: 1.3;
        }
        .kop-surat {
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            border: none !important;
            margin-bottom: 0;
        }
        .kop-table tr, .kop-table td {
            border: none !important;
            padding: 0 !important;
        }
        .kop-surat h2 {
            margin: 0;
            font-size: 16pt;
            font-weight: normal;
        }
        .kop-surat h3.line-2 {
            margin: 5px 0 0 0;
            font-size: 14pt;
            font-weight: bold;
        }
        .kop-surat h3.line-3 {
            margin: 5px 0 0 0;
            font-size: 12pt;
            font-weight: bold;
        }
        .kop-surat p {
            margin: 5px 0 0 0;
            font-size: 11pt;
            font-style: normal;
            line-height: 1.2;
        }
        .title-section {
            text-align: center;
            margin: 0 auto 20px auto;
            width: 100%;
            clear: both;
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
            font-size: 9.5pt;
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
        <table class="kop-table">
            <tr>
                <td style="width: 15%; text-align: center; vertical-align: middle;">
                    <img src="{{ route('receipt.logo') }}" style="height: 140px; width: auto;" alt="Logo Instansi">
                </td>
                <td style="width: 75%; text-align: center; vertical-align: middle; padding-left: 25px;">
                    <h2>{!! nl2br(e(\App\Models\AppSetting::get('receipt_kop_line_1', 'KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI'))) !!}</h2>
                    <h3 class="line-2">{{ \App\Models\AppSetting::get('receipt_kop_line_2', 'POLITEKNIK NEGERI PONTIANAK') }}</h3>
                    <h3 class="line-3">{{ \App\Models\AppSetting::get('receipt_kop_line_3', 'PERPUSTAKAAN PSDKU POLNEP DI KABUPATEN SUKAMARA') }}</h3>
                    <p style="margin-top: 5px;">{!! nl2br(e(\App\Models\AppSetting::get('receipt_kop_alamat', "Jalan Jenderal Ahmad Yani - Pontianak 78124, Kalimantan Barat\nTelepon: (0561)736180, Faksimile: (0561)740143, Kotak Pos: 1286"))) !!}</p>
                </td>
                <td style="width: 10%;"></td>
            </tr>
        </table>
    </div>

    <!-- Judul Laporan -->
    <div class="title-section">
        <h4>Laporan Rekapitulasi Penerimaan & Penyerahan Arsip</h4>
        <p>Periode: <b>{{ $tglAwal->translatedFormat('d F Y') }}</b> s.d. <b>{{ $tglAkhir->translatedFormat('d F Y') }}</b></p>
        @if($jenisArsip !== 'all')
            <p>Kategori: <b>{{ $jenisArsip === 'laporan_pkl' ? 'Laporan PKL' : ($jenisArsip === 'proposal_ta' ? 'Proposal TA' : 'Laporan TA') }}</b></p>
        @endif
        @if(isset($tahun) && $tahun !== 'all')
            <p>Tahun Karya: <b>{{ $tahun }}</b></p>
        @endif
    </div>

    <!-- Tabel Data -->
    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 13%;">Nomor Surat</th>
                <th style="width: 14%;">Nama Mahasiswa</th>
                <th style="width: 8%;">NIM</th>
                <th style="width: 11%;">Program Studi</th>
                <th style="width: 22%;">Judul Arsip</th>
                @if($jenisArsip === 'laporan_pkl')
                    <th style="width: 12%;">Tempat PKL</th>
                @else
                    <th style="width: 8%;">Kategori</th>
                @endif
                <th style="width: 5%;">Tahun</th>
                <th style="width: 11%;">Status Buku</th>
            </tr>
        </thead>
        <tbody>
            @forelse($archives as $index => $archive)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center" style="font-family: monospace; font-size: 8.5pt; font-weight: bold;">{{ $archive->nomor_surat ?: '-' }}</td>
                    <td>{{ $archive->mahasiswa?->user?->name ?: '-' }}</td>
                    <td class="text-center">{{ $archive->mahasiswa?->nim ?: '-' }}</td>
                    <td>{{ $archive->mahasiswa?->prodi?->nama_prodi ?: '-' }}</td>
                    <td>
                        {{ $archive->judul_display ?: '-' }}
                        @if($jenisArsip === 'all' && $archive->jenis_label === 'Laporan PKL' && $archive->nama_tempat_pkl)
                            <br><small style="color: #555;">Tempat PKL: <b>{{ $archive->nama_tempat_pkl }}</b></small>
                        @endif
                    </td>
                    @if($jenisArsip === 'laporan_pkl')
                        <td>{{ $archive->nama_tempat_pkl ?: '-' }}</td>
                    @else
                        <td class="text-center">{{ $archive->jenis_label ?: '-' }}</td>
                    @endif
                    <td class="text-center">{{ $archive->tahun ?: '-' }}</td>
                    <td class="text-center" style="font-weight: bold; font-size: 8.5pt;">
                        @if($archive->status === 'aktif')
                            <span style="color: #006c49;">Diserahkan</span>
                        @else
                            <span style="color: #95002b;">Belum penyerahan</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data penyerahan arsip pada periode ini.</td>
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
