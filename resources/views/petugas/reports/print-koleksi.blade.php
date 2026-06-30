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
            margin-bottom: 25px;
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
        <h2>KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI</h2>
        <h3>POLITEKNIK NEGERI PONTIANAK</h3>
        <h3>PSDKU KABUPATEN SUKAMARA</h3>
        <p>Jalan Pancasila No. 01, Sukamara, Kalimantan Tengah. Email: psdku@polnep.ac.id</p>
    </div>

    <!-- Judul Laporan -->
    <div class="title-section">
        <h4>Laporan Rekapitulasi Koleksi & Aset Perpustakaan</h4>
        <p>Tanggal Cetak: <b>{{ now()->translatedFormat('d F Y') }}</b></p>
    </div>

    <!-- 1. Buku Teks -->
    <div class="sub-section-title">I. KOLEKSI BUKU TEKS</div>
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
                    <td>{{ $book->penulis ?: '-' }}</td>
                    <td>{{ $book->penerbit ?: '-' }}</td>
                    <td class="text-center">{{ $book->tahun_terbit ?: '-' }}</td>
                    <td class="text-center">{{ $book->stock }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada koleksi buku terdaftar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="page-break"></div>

    <!-- 2. Laporan PKL -->
    <div class="sub-section-title">II. ARSIP DIGITAL - LAPORAN PRAKTIK KERJA LAPANGAN (PKL)</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 40%;">Judul Laporan PKL</th>
                <th style="width: 20%;">Nama Mahasiswa / NIM</th>
                <th style="width: 15%;">Program Studi</th>
                <th style="width: 15%;">Pembimbing</th>
                <th style="width: 5%;">Tahun</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pkls as $index => $pkl)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><b>{{ $pkl->judul_pkl }}</b></td>
                    <td>{{ $pkl->mahasiswa?->user?->name ?: '-' }}<br/><small>NIM. {{ $pkl->mahasiswa?->nim ?: '-' }}</small></td>
                    <td>{{ $pkl->mahasiswa?->prodi?->nama_prodi ?: '-' }}</td>
                    <td>{{ $pkl->pembimbing ?: '-' }}</td>
                    <td class="text-center">{{ $pkl->tahun }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada arsip Laporan PKL.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- 3. Proposal TA -->
    <div class="sub-section-title">III. ARSIP DIGITAL - PROPOSAL TUGAS AKHIR</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 40%;">Judul Proposal Tugas Akhir</th>
                <th style="width: 20%;">Nama Mahasiswa / NIM</th>
                <th style="width: 15%;">Program Studi</th>
                <th style="width: 15%;">Pembimbing</th>
                <th style="width: 5%;">Tahun</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ptas as $index => $pta)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><b>{{ $pta->judul_proposal }}</b></td>
                    <td>{{ $pta->mahasiswa?->user?->name ?: '-' }}<br/><small>NIM. {{ $pta->mahasiswa?->nim ?: '-' }}</small></td>
                    <td>{{ $pta->mahasiswa?->prodi?->nama_prodi ?: '-' }}</td>
                    <td>{{ $pta->pembimbing ?: '-' }}</td>
                    <td class="text-center">{{ $pta->tahun }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada arsip Proposal Tugas Akhir.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- 4. Laporan TA -->
    <div class="sub-section-title">IV. ARSIP DIGITAL - LAPORAN TUGAS AKHIR (TA)</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 40%;">Judul Laporan Tugas Akhir</th>
                <th style="width: 20%;">Nama Mahasiswa / NIM</th>
                <th style="width: 15%;">Program Studi</th>
                <th style="width: 15%;">Pembimbing</th>
                <th style="width: 5%;">Tahun</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tas as $index => $ta)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><b>{{ $ta->judul_tgs_akhir }}</b></td>
                    <td>{{ $ta->mahasiswa?->user?->name ?: '-' }}<br/><small>NIM. {{ $ta->mahasiswa?->nim ?: '-' }}</small></td>
                    <td>{{ $ta->mahasiswa?->prodi?->nama_prodi ?: '-' }}</td>
                    <td>{{ $ta->pembimbing ?: '-' }}</td>
                    <td class="text-center">{{ $ta->tahun }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada arsip Laporan Tugas Akhir.</td>
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
