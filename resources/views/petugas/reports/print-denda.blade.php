<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Denda & Sanksi - SIPUS PSDKU POLNEP</title>
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
        .text-right {
            text-align: right;
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

    <!-- Kop Surat Dinas Resmi -->
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
        <h4>Laporan Rekapitulasi Denda & Sanksi</h4>
        <p>Dicetak Tanggal: <b>{{ now()->translatedFormat('d F Y') }}</b></p>
    </div>

    <!-- Tabel Data -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 22%;">Nama Anggota</th>
                <th style="width: 33%;">Koleksi Buku / Arsip</th>
                <th style="width: 12%;">Jenis Sanksi</th>
                <th style="width: 13%; text-align: right;">Nominal Sanksi</th>
                <th style="width: 15%;">Status Penyelesaian</th>
            </tr>
        </thead>
        <tbody>
            @php $totalAmount = 0; @endphp
            @forelse($penalties as $index => $pen)
                @php $totalAmount += $pen->amount; @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <b>{{ $pen->user?->name ?: '-' }}</b><br>
                        <small style="color: #444;">
                            @if($pen->user?->role?->role_name === 'mahasiswa')
                                NIM: {{ $pen->user->mahasiswa->nim ?? '-' }}
                            @else
                                NIP: {{ $pen->user->dosen->nip ?? '-' }}
                            @endif
                        </small>
                    </td>
                    <td>{{ $pen->loan?->collection?->display_title ?: '-' }}</td>
                    <td class="text-center">{{ ucfirst($pen->type) }}</td>
                    <td class="text-right" style="font-weight: bold;">Rp {{ number_format($pen->amount, 0, ',', '.') }}</td>
                    <td class="text-center" style="font-weight: bold;">
                        @if($pen->status === 'lunas')
                            SELESAI
                        @else
                            <span style="color: red;">BELUM SELESAI</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data denda & sanksi.</td>
                </tr>
            @endforelse
        </tbody>
        @if($penalties->isNotEmpty())
            <tfoot>
                <tr style="background-color: #fafafa;">
                    <td colspan="4" class="text-right" style="font-weight: bold;">TOTAL NOMINAL SANKSI:</td>
                    <td class="text-right" style="font-weight: bold; font-size: 11pt;">Rp {{ number_format($totalAmount, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tfoot>
        @endif
    </table>

    <!-- Tanda Tangan -->
    <div class="ttd-section">
        <p>Sukamara, {{ now()->translatedFormat('d F Y') }}</p>
        <p>Mengetahui,</p>
        <p><b>Petugas Perpustakaan</b></p>
        <div class="ttd-space"></div>
        <p><u>{{ Auth::user()->name }}</u></p>
        <p>NIP. {{ Auth::user()->petugas?->nip ?: (Auth::user()->dosen?->nip ?: '-') }}</p>
    </div>

</body>
</html>
