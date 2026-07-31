<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Koleksi Aset - SIPUS PSDKU POLNEP</title>
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
            margin: 0 auto 25px auto;
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
        .sub-section-title {
            font-size: 11pt;
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 10px;
            text-transform: uppercase;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 9pt;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
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
        .page-break {
            page-break-before: always;
        }
        .ttd-section {
            margin-top: 40px;
            float: right;
            width: 250px;
            text-align: center;
        }
        .ttd-section p {
            margin: 0;
        }
        .ttd-space {
            height: 60px;
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
        <h4>Laporan Rekapitulasi Koleksi &amp; Aset Perpustakaan</h4>
        <p>Jenis Koleksi: <b>{{ $selectedCollectionTypeLabel }}</b></p>
        @if(isset($tahun) && $tahun !== 'all')
            <p>Filter Tahun: <b>{{ $tahun }}</b></p>
        @endif
        <p>Tanggal Cetak: <b>{{ now()->translatedFormat('d F Y') }}</b></p>
    </div>

    @php
        $showBooks = $selectedCollectionType === 'all' || $selectedCollectionType === 'book';
        $showPkls = $selectedCollectionType === 'all' || $selectedCollectionType === 'laporan_pkl';
        $showPtas = $selectedCollectionType === 'all' || $selectedCollectionType === 'proposal_ta';
        $showTas = $selectedCollectionType === 'all' || $selectedCollectionType === 'laporan_ta';
        $printedSections = 0;
    @endphp

    @if($showBooks)
        <div class="sub-section-title">{{ $printedSections === 0 ? 'I' : 'II' }}. KOLEKSI BUKU UMUM</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 35%;">Judul Buku</th>
                    <th style="width: 15%;">Kategori</th>
                    <th style="width: 20%;">Penulis / Pengarang</th>
                    <th style="width: 15%;">Penerbit</th>
                    <th style="width: 5%;">Tahun</th>
                    <th style="width: 5%;">Stok</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $index => $book)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><b>{{ $book->judul }}</b></td>
                        <td>{{ $book->category?->kategori_name ?: '-' }}</td>
                        <td>{{ $book->author ?: '-' }}</td>
                        <td>{{ $book->publisher ?: '-' }}</td>
                        <td class="text-center">{{ $book->release ?: '-' }}</td>
                        <td class="text-center">{{ $book->stock }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada koleksi buku terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @php($printedSections++)
    @endif

    @if($showPkls)
        @if($printedSections > 0)
            <div class="page-break"></div>
        @endif
        <div class="sub-section-title">{{ $printedSections === 0 ? 'I' : ($printedSections === 1 ? 'II' : ($printedSections === 2 ? 'III' : 'IV')) }}. ARSIP DIGITAL - LAPORAN PRAKTIK KERJA LAPANGAN (PKL)</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 4%;">No</th>
                    <th style="width: 13%;">Nomor Surat</th>
                    <th style="width: 30%;">Judul Laporan PKL</th>
                    <th style="width: 18%;">Nama Mahasiswa / NIM</th>
                    <th style="width: 15%;">Program Studi</th>
                    <th style="width: 15%;">Pembimbing</th>
                    <th style="width: 5%;">Tahun</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pkls as $index => $pkl)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center" style="font-family: monospace; font-size: 8pt; font-weight: bold;">{{ $pkl->nomor_surat ?: '-' }}</td>
                        <td><b>{{ $pkl->judul_pkl }}</b></td>
                        <td>{{ $pkl->mahasiswa?->user?->name ?: '-' }}<br/><small>NIM. {{ $pkl->mahasiswa?->nim ?: '-' }}</small></td>
                        <td>{{ $pkl->mahasiswa?->prodi?->nama_prodi ?: '-' }}</td>
                        <td>{{ $pkl->pembimbing ?: '-' }}</td>
                        <td class="text-center">{{ $pkl->tahun }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada arsip Laporan PKL.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @php($printedSections++)
    @endif

    @if($showPtas)
        @if($printedSections > 0)
            <div class="page-break"></div>
        @endif
        <div class="sub-section-title">{{ $printedSections === 0 ? 'I' : ($printedSections === 1 ? 'II' : ($printedSections === 2 ? 'III' : 'IV')) }}. ARSIP DIGITAL - PROPOSAL TUGAS AKHIR</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 4%;">No</th>
                    <th style="width: 13%;">Nomor Surat</th>
                    <th style="width: 30%;">Judul Proposal Tugas Akhir</th>
                    <th style="width: 18%;">Nama Mahasiswa / NIM</th>
                    <th style="width: 15%;">Program Studi</th>
                    <th style="width: 15%;">Pembimbing</th>
                    <th style="width: 5%;">Tahun</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ptas as $index => $pta)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center" style="font-family: monospace; font-size: 8pt; font-weight: bold;">{{ $pta->nomor_surat ?: '-' }}</td>
                        <td><b>{{ $pta->judul_proposal }}</b></td>
                        <td>{{ $pta->mahasiswa?->user?->name ?: '-' }}<br/><small>NIM. {{ $pta->mahasiswa?->nim ?: '-' }}</small></td>
                        <td>{{ $pta->mahasiswa?->prodi?->nama_prodi ?: '-' }}</td>
                        <td>{{ $pta->pembimbing ?: '-' }}</td>
                        <td class="text-center">{{ $pta->tahun }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada arsip Proposal Tugas Akhir.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @php($printedSections++)
    @endif

    @if($showTas)
        @if($printedSections > 0)
            <div class="page-break"></div>
        @endif
        <div class="sub-section-title">{{ $printedSections === 0 ? 'I' : ($printedSections === 1 ? 'II' : ($printedSections === 2 ? 'III' : 'IV')) }}. ARSIP DIGITAL - LAPORAN TUGAS AKHIR (TA)</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 4%;">No</th>
                    <th style="width: 13%;">Nomor Surat</th>
                    <th style="width: 30%;">Judul Laporan Tugas Akhir</th>
                    <th style="width: 18%;">Nama Mahasiswa / NIM</th>
                    <th style="width: 15%;">Program Studi</th>
                    <th style="width: 15%;">Pembimbing</th>
                    <th style="width: 5%;">Tahun</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tas as $index => $ta)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center" style="font-family: monospace; font-size: 8pt; font-weight: bold;">{{ $ta->nomor_surat ?: '-' }}</td>
                        <td><b>{{ $ta->judul_tgs_akhir }}</b></td>
                        <td>{{ $ta->mahasiswa?->user?->name ?: '-' }}<br/><small>NIM. {{ $ta->mahasiswa?->nim ?: '-' }}</small></td>
                        <td>{{ $ta->mahasiswa?->prodi?->nama_prodi ?: '-' }}</td>
                        <td>{{ $ta->pembimbing ?: '-' }}</td>
                        <td class="text-center">{{ $ta->tahun }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada arsip Laporan Tugas Akhir.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @php($printedSections++)
    @endif

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
