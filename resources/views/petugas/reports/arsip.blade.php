<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Pratinjau Dokumen Laporan Pengumpulan Arsip - SIPUS PSDKU POLNEP</title>
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
                        "teal-brand": "#0d9488",
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
                    <h1 class="font-headline-md text-slate-800 text-xl font-bold">Laporan Pengumpulan Arsip Digital</h1>
                    <p class="text-xs text-slate-500">Pratinjau lembar cetak dokumen resmi penerimaan karya ilmiah mahasiswa.</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('petugas.reports.print-arsip', ['tgl_awal' => $tglAwal, 'tgl_akhir' => $tglAkhir, 'jenis_arsip' => $jenisArsip, 'tahun' => $tahun]) }}" target="_blank" class="px-5 py-2.5 rounded-2xl bg-teal-600 text-white hover:bg-teal-700 font-bold text-xs transition-all shadow-md shadow-teal-200 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">print</span>
                    Cetak Dokumen (PDF)
                </a>
            </div>
        </header>

        <!-- Filter Form Header -->
        <section class="no-print bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
            <form action="{{ route('petugas.reports.arsip') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Jenis Arsip</label>
                    <select name="jenis_arsip" onchange="this.form.submit()" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 text-xs font-semibold text-slate-700">
                        <option value="all" {{ $jenisArsip === 'all' ? 'selected' : '' }}>Semua Jenis Arsip</option>
                        <option value="laporan_pkl" {{ $jenisArsip === 'laporan_pkl' ? 'selected' : '' }}>Laporan PKL</option>
                        <option value="proposal_ta" {{ $jenisArsip === 'proposal_ta' ? 'selected' : '' }}>Proposal Tugas Akhir</option>
                        <option value="laporan_ta" {{ $jenisArsip === 'laporan_ta' ? 'selected' : '' }}>Laporan Tugas Akhir</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Filter Tahun</label>
                    <input
                        type="number"
                        name="tahun"
                        value="{{ ($tahun ?? 'all') !== 'all' ? $tahun : '' }}"
                        min="2000"
                        max="{{ date('Y') + 2 }}"
                        placeholder="Contoh: {{ date('Y') }}"
                        onchange="this.form.submit()"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 text-xs font-semibold text-slate-700"
                    />
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Mulai Tanggal Verifikasi</label>
                    <input type="date" name="tgl_awal" value="{{ $tglAwal }}" onchange="this.form.submit()" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 text-xs font-semibold text-slate-700"/>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Sampai Tanggal Verifikasi</label>
                    <input type="date" name="tgl_akhir" value="{{ $tglAkhir }}" onchange="this.form.submit()" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 text-xs font-semibold text-slate-700"/>
                </div>

                <div class="sm:col-span-4 flex justify-end pt-2 border-t border-slate-100">
                    <a href="{{ route('petugas.reports.arsip') }}" class="text-xs font-bold text-rose-600 hover:text-rose-700 flex items-center gap-1">
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
                <h3 class="text-sm font-bold uppercase tracking-wider text-teal-700 pt-2">LAPORAN REKAPITULASI PENGUMPULAN ARSIP DIGITAL</h3>
                <p class="text-xs text-slate-500 font-medium">
                    Periode Verifikasi: {{ $tglAwal ? \Carbon\Carbon::parse($tglAwal)->translatedFormat('d M Y') : 'Awal' }} s/d {{ $tglAkhir ? \Carbon\Carbon::parse($tglAkhir)->translatedFormat('d M Y') : 'Sekarang' }}
                    @if(isset($tahun) && $tahun !== 'all')
                        • Tahun Karya: <b>{{ $tahun }}</b>
                    @endif
                </p>
            </div>

            <!-- Official Document Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs border border-slate-300">
                    <thead>
                        <tr class="bg-slate-100 border-b border-slate-300 text-slate-800 font-bold uppercase">
                            <th class="py-3 px-3 text-center border-r border-slate-300 w-10">No</th>
                            <th class="py-3 px-3 border-r border-slate-300">Nomor Surat</th>
                            <th class="py-3 px-4 border-r border-slate-300">Nama Mahasiswa / NIM</th>
                            <th class="py-3 px-3 border-r border-slate-300">Prodi</th>
                            <th class="py-3 px-4 border-r border-slate-300">Judul Karya Ilmiah</th>
                            <th class="py-3 px-3 border-r border-slate-300 whitespace-nowrap">Jenis Dokumen</th>
                            <th class="py-3 px-2 border-r border-slate-300 text-center whitespace-nowrap">Tahun</th>
                            <th class="py-3 px-3 border-r border-slate-300 whitespace-nowrap">Tgl Verifikasi</th>
                            <th class="py-3 px-3 text-center whitespace-nowrap">Status Fisik</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-slate-800 font-medium">
                        @forelse($archives as $index => $item)
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-3 text-center border-r border-slate-200 font-semibold whitespace-nowrap">{{ $index + 1 }}</td>
                                <td class="py-3 px-3 border-r border-slate-200 font-mono text-[11px] text-teal-800 font-bold whitespace-nowrap">
                                    {{ $item->nomor_surat ?? '-' }}
                                </td>
                                <td class="py-3 px-4 border-r border-slate-200">
                                    <div class="font-bold text-slate-900">{{ $item->mahasiswa?->user?->name ?? '-' }}</div>
                                    <div class="text-[10px] text-slate-500 uppercase">NIM: {{ $item->mahasiswa->nim ?? '-' }}</div>
                                </td>
                                <td class="py-3 px-3 border-r border-slate-200 whitespace-nowrap">
                                    {{ $item->mahasiswa?->prodi?->nama_prodi ?? '-' }}
                                </td>
                                <td class="py-3 px-4 border-r border-slate-200 font-bold text-slate-900">
                                    {{ $item->judul_display }}
                                </td>
                                <td class="py-3 px-3 border-r border-slate-200 whitespace-nowrap">
                                    {{ $item->jenis_label }}
                                </td>
                                <td class="py-3 px-2 border-r border-slate-200 text-center">
                                    {{ $item->tahun ?? '-' }}
                                </td>
                                <td class="py-3 px-3 border-r border-slate-200">
                                    {{ $item->verified_at ? \Carbon\Carbon::parse($item->verified_at)->translatedFormat('d/m/Y') : '-' }}
                                </td>
                                <td class="py-3 px-3 text-center font-bold">
                                    @if($item->status === 'aktif')
                                        <span class="text-emerald-700 uppercase text-[10px]">Diserahkan</span>
                                    @else
                                        <span class="text-amber-700 uppercase text-[10px]">Belum Diserahkan</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-8 text-center text-slate-400 font-medium">Tidak ada data penyerahan arsip pada filter ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Summary & Signature Block -->
            <div class="pt-4 flex justify-between items-end border-t border-slate-200">
                <div class="text-xs text-slate-500 font-semibold">
                    Total Dokumen Terhitung: {{ $archives->count() }} Dokumen
                </div>
                <!-- Signature Block - Only Visible When Printed -->
                <div class="hidden print-only-signature text-center text-xs space-y-12 pr-6">
                    <p>Sukamara, {{ now()->translatedFormat('d F Y') }}<br>Petugas Perpustakaan,</p>
                    <p class="font-bold underline pt-8 text-slate-900">{{ Auth::user()->name }}</p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
