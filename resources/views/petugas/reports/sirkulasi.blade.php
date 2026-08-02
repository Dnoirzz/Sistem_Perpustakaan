<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Pratinjau Dokumen Laporan Sirkulasi - SIPUS PSDKU POLNEP</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-background": "#131b2e",
                        "surface": "#faf8ff",
                        "outline": "#777587",
                        "outline-variant": "#c7c4d8",
                        "background": "#faf8ff",
                        "primary": "#00a5c0",
                        "primary-container": "#00a5c0",
                        "on-surface": "#131b2e",
                    },
                    "fontFamily": {
                        "headline-md": ["Outfit"],
                        "label-md": ["Inter"],
                        "body-md": ["Inter"]
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            background-color: #f1f5f9;
            color: #131b2e;
        }
        @media print {
            .no-print { display: none !important; }
            body { background-color: #fff !important; }
            .print-paper {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
            }
            .print-only-signature { display: block !important; }
        }
    </style>
</head>
<body class="font-body-md text-body-md antialiased min-h-screen">
    <div class="no-print">
        @include('petugas.layouts.sidebar')
    </div>

    <main class="ml-0 lg:ml-64 p-4 lg:p-8 bg-[#f1f5f9] min-h-screen space-y-6">
        <!-- Top Navigation Header -->
        <header class="no-print flex justify-between items-center bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm">
            <div class="flex items-center gap-4">
                <a href="{{ route('petugas.reports.index') }}" class="w-10 h-10 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center hover:bg-slate-200 transition-all" title="Kembali ke Pusat Laporan">
                    <span class="material-symbols-outlined text-[20px] text-slate-700">arrow_back</span>
                </a>
                <div>
                    <h1 class="font-headline-md text-slate-800 text-xl font-bold">Laporan Transaksi Sirkulasi Peminjaman</h1>
                    <p class="text-xs text-slate-500">Pratinjau lembar cetak dokumen resmi laporan peminjaman perpustakaan.</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('petugas.reports.print-sirkulasi', ['tgl_awal' => $tglAwal ?: '2020-01-01', 'tgl_akhir' => $tglAkhir ?: date('Y-m-d')]) }}" target="_blank" class="px-5 py-2.5 rounded-2xl bg-primary text-white hover:bg-primary/95 font-bold text-xs transition-all shadow-md shadow-primary/20 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">print</span>
                    Cetak Dokumen (PDF)
                </a>
            </div>
        </header>

        <!-- Filter Form Header -->
        <section class="no-print bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
            <form action="{{ route('petugas.reports.sirkulasi') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Pencarian</label>
                    <input type="text" name="search" value="{{ $search }}" onchange="this.form.submit()" placeholder="Nama Anggota, NIM, NIP" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-slate-700"/>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Status Peminjaman</label>
                    <select name="status" onchange="this.form.submit()" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-slate-700">
                        <option value="all" {{ $status === 'all' || !$status ? 'selected' : '' }}>Semua Status</option>
                        <option value="dipinjam" {{ $status === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="terlambat" {{ $status === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                        <option value="dikembalikan" {{ $status === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Mulai Tanggal</label>
                    <input type="date" name="tgl_awal" value="{{ $tglAwal }}" onchange="this.form.submit()" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-slate-700"/>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Sampai Tanggal</label>
                    <input type="date" name="tgl_akhir" value="{{ $tglAkhir }}" onchange="this.form.submit()" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-slate-700"/>
                </div>

                <div class="lg:col-span-4 flex justify-end pt-2 border-t border-slate-100">
                    <a href="{{ route('petugas.reports.sirkulasi') }}" class="text-xs font-bold text-rose-600 hover:text-rose-700 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                        Reset Filter
                    </a>
                </div>
            </form>
        </section>

        <!-- Official Document Paper Container (Lembar Dokumen A4 Preview) -->
        <div class="max-w-5xl mx-auto bg-white p-8 lg:p-12 rounded-2xl shadow-md border border-slate-200 print-paper space-y-6">
            <!-- Kop Surat Resmi -->
            <div class="text-center border-b-2 border-slate-900 pb-4 space-y-1">
                <h2 class="text-base lg:text-lg font-extrabold uppercase tracking-wide text-slate-900">PERPUSTAKAAN PSDKU POLITEKNIK NEGERI PONTIANAK SUKAMARA</h2>
                <h3 class="text-sm font-bold uppercase tracking-wider text-primary pt-2">LAPORAN REKAPITULASI TRANSAKSI SIRKULASI PEMINJAMAN DAN PENGEMBALIAN BUKU</h3>
            </div>

            <!-- Official Document Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs border border-slate-300">
                    <thead>
                        <tr class="bg-slate-100 border-b border-slate-300 text-slate-800 font-bold uppercase">
                            <th class="py-3 px-3 text-center border-r border-slate-300 w-10">No</th>
                            <th class="py-3 px-4 border-r border-slate-300">Nama Anggota</th>
                            <th class="py-3 px-4 border-r border-slate-300">Koleksi Buku / Arsip</th>
                            <th class="py-3 px-3 border-r border-slate-300">Tgl Pinjam</th>
                            <th class="py-3 px-3 border-r border-slate-300">Batas Pengembalian</th>
                            <th class="py-3 px-3 border-r border-slate-300">Tgl Kembali</th>
                            <th class="py-3 px-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-slate-800 font-medium">
                        @forelse($loans as $index => $loan)
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-3 text-center border-r border-slate-200 font-semibold">
                                    {{ $loans->firstItem() + $index }}
                                </td>
                                <td class="py-3 px-4 border-r border-slate-200">
                                    <div class="font-bold text-slate-900">{{ $loan->user?->name ?? '-' }}</div>
                                    <div class="text-[10px] text-slate-500 font-semibold uppercase">
                                        @if($loan->user?->role?->role_name === 'mahasiswa')
                                            NIM: {{ $loan->user->mahasiswa->nim ?? '-' }}
                                        @else
                                            NIP: {{ $loan->user->dosen->nip ?? '-' }}
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-4 border-r border-slate-200">
                                    <div class="font-bold text-slate-900">{{ $loan->collection?->display_title ?? '-' }}</div>
                                    <div class="text-[10px] text-slate-500 uppercase">{{ $loan->collection?->display_type_label ?? 'Koleksi' }}</div>
                                </td>
                                <td class="py-3 px-3 border-r border-slate-200">
                                    {{ $loan->tgl_pinjam ? \Carbon\Carbon::parse($loan->tgl_pinjam)->translatedFormat('d/m/Y') : '-' }}
                                </td>
                                <td class="py-3 px-3 border-r border-slate-200">
                                    {{ $loan->bts_waktu ? \Carbon\Carbon::parse($loan->bts_waktu)->translatedFormat('d/m/Y') : '-' }}
                                </td>
                                <td class="py-3 px-3 border-r border-slate-200">
                                    {{ $loan->tgl_kembali ? \Carbon\Carbon::parse($loan->tgl_kembali)->translatedFormat('d/m/Y') : '-' }}
                                </td>
                                <td class="py-3 px-3 text-center font-bold">
                                    @if($loan->status === 'terlambat')
                                        <span class="text-rose-600 uppercase text-[10px]">Terlambat</span>
                                    @elseif($loan->status === 'dikembalikan')
                                        <span class="text-emerald-600 uppercase text-[10px]">Dikembalikan</span>
                                    @else
                                        <span class="text-blue-600 uppercase text-[10px]">Dipinjam</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400 font-medium">Tidak ada data transaksi peminjaman pada filter ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Summary & Signature Block (Hidden on Web Screen, ONLY visible when printed) -->
            <div class="pt-4 flex justify-between items-end border-t border-slate-200">
                <div class="text-xs text-slate-500 font-semibold">
                    Total Data Terhitung: {{ $loans->total() }} Transaksi
                </div>
                <!-- Signature Block - Only Visible When Printed -->
                <div class="hidden print-only-signature text-center text-xs space-y-12 pr-6">
                    <p>Sukamara, {{ now()->translatedFormat('d F Y') }}<br>Petugas Perpustakaan,</p>
                    <div>
                        <p class="font-bold underline pt-8 text-slate-900">{{ Auth::user()->name }}</p>
                        <p class="text-slate-700">NIP. {{ Auth::user()->petugas?->nip ?: (Auth::user()->dosen?->nip ?: '-') }}</p>
                    </div>
                </div>
            </div>

            @if($loans->hasPages())
                <div class="no-print pt-4 border-t border-slate-100">
                    {{ $loans->links() }}
                </div>
            @endif
        </div>
    </main>
</body>
</html>
