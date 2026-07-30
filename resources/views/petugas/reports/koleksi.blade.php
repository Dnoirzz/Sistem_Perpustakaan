<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Pratinjau Dokumen Laporan Koleksi - SIPUS PSDKU POLNEP</title>
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
                        "secondary": "#006c49",
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
                    <h1 class="font-headline-md text-slate-800 text-xl font-bold">Laporan Koleksi & Inventaris</h1>
                    <p class="text-xs text-slate-500">Pilih kategori koleksi untuk menampilkan pratinjau lembar cetak dokumen resmi.</p>
                </div>
            </div>
            @if($selectedCollectionType)
                <div class="flex items-center gap-3">
                    <a href="{{ route('petugas.reports.print-koleksi', ['collection_type' => $selectedCollectionType]) }}" target="_blank" class="px-5 py-2.5 rounded-2xl bg-secondary text-white hover:bg-opacity-95 font-bold text-xs transition-all shadow-md shadow-secondary/20 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">print</span>
                        Cetak Dokumen (PDF)
                    </a>
                </div>
            @endif
        </header>

        <!-- Filter Form Header -->
        <section class="no-print bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
            <form action="{{ route('petugas.reports.koleksi') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Pilih Jenis Koleksi Laporan</label>
                    <select name="collection_type" onchange="this.form.submit()" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-secondary focus:ring-2 focus:ring-secondary/20 text-xs font-bold text-slate-800">
                        <option value="">-- Pilih Jenis Koleksi Terlebih Dahulu --</option>
                        @foreach($collectionReportTypes as $typeVal => $typeLabel)
                            <option value="{{ $typeVal }}" {{ $selectedCollectionType === $typeVal ? 'selected' : '' }}>{{ $typeLabel }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Pencarian Kata Kunci</label>
                    <input type="text" name="search" value="{{ $search }}" onchange="this.form.submit()" placeholder="Cari berdasarkan judul / pengarang / mahasiswa..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-secondary focus:ring-2 focus:ring-secondary/20 text-xs font-semibold text-slate-700"/>
                </div>

                <div class="sm:col-span-2 flex justify-end pt-2 border-t border-slate-100">
                    <a href="{{ route('petugas.reports.koleksi') }}" class="text-xs font-bold text-rose-600 hover:text-rose-700 flex items-center gap-1">
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
                <h3 class="text-sm font-bold uppercase tracking-wider text-secondary pt-2">LAPORAN DATA INVENTARIS & KOLEKSI PERPUSTAKAAN</h3>
                <p class="text-xs text-slate-500 font-medium">
                    Kategori: {{ $selectedCollectionType ? ($collectionReportTypes[$selectedCollectionType] ?? '-') : 'Belum Dipilih' }}
                </p>
            </div>

            @if(!$selectedCollectionType)
                <!-- Prompt ketika belum memilih jenis koleksi -->
                <div class="py-16 text-center space-y-3">
                    <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                        <span class="material-symbols-outlined text-[36px]">touch_app</span>
                    </div>
                    <h4 class="font-bold text-slate-800 text-base">Silakan Pilih Jenis Koleksi</h4>
                    <p class="text-xs text-slate-500 max-w-md mx-auto">Silakan tentukan jenis koleksi yang ingin ditampilkan (Buku Umum, Laporan PKL, Proposal TA, atau Laporan TA) pada pilihan filter di atas.</p>
                </div>
            @else
                <!-- Official Document Table based on selectedCollectionType -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs border border-slate-300">
                        <thead>
                            <tr class="bg-slate-100 border-b border-slate-300 text-slate-800 font-bold uppercase">
                                <th class="py-3 px-3 text-center border-r border-slate-300 w-10">No</th>

                                @if($selectedCollectionType === 'book')
                                    <th class="py-3 px-4 border-r border-slate-300">Judul Buku</th>
                                    <th class="py-3 px-4 border-r border-slate-300">Pengarang / Penulis</th>
                                    <th class="py-3 px-3 border-r border-slate-300">Penerbit</th>
                                    <th class="py-3 px-3 border-r border-slate-300 text-center">Tahun</th>
                                    <th class="py-3 px-3 border-r border-slate-300">Kategori</th>
                                    <th class="py-3 px-3 text-center">Stok Fisik</th>
                                @else
                                    <th class="py-3 px-4 border-r border-slate-300">Judul Dokumen / Karya Ilmiah</th>
                                    <th class="py-3 px-4 border-r border-slate-300">Nama Mahasiswa / NIM</th>
                                    <th class="py-3 px-3 border-r border-slate-300">Program Studi</th>
                                    <th class="py-3 px-3 border-r border-slate-300">Tgl Verifikasi</th>
                                    <th class="py-3 px-3 text-center">Status Fisik</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 text-slate-800 font-medium">
                            @forelse($items as $index => $item)
                                <tr class="hover:bg-slate-50">
                                    <td class="py-3 px-3 text-center border-r border-slate-200 font-semibold">
                                        {{ method_exists($items, 'firstItem') ? $items->firstItem() + $index : $index + 1 }}
                                    </td>

                                    @if($selectedCollectionType === 'book')
                                        <td class="py-3 px-4 border-r border-slate-200 font-bold text-slate-900">
                                            {{ $item->judul }}
                                        </td>
                                        <td class="py-3 px-4 border-r border-slate-200">
                                            {{ $item->author ?? '-' }}
                                        </td>
                                        <td class="py-3 px-3 border-r border-slate-200">
                                            {{ $item->publisher ?? '-' }}
                                        </td>
                                        <td class="py-3 px-3 border-r border-slate-200 text-center">
                                            {{ $item->year ?? '-' }}
                                        </td>
                                        <td class="py-3 px-3 border-r border-slate-200">
                                            {{ $item->category?->name ?? '-' }}
                                        </td>
                                        <td class="py-3 px-3 text-center font-bold">
                                            {{ $item->collection?->stock ?? 0 }} item
                                        </td>
                                    @elseif($selectedCollectionType === 'laporan_pkl')
                                        <td class="py-3 px-4 border-r border-slate-200 font-bold text-slate-900">
                                            {{ $item->judul_pkl }}
                                        </td>
                                        <td class="py-3 px-4 border-r border-slate-200">
                                            <div class="font-bold text-slate-900">{{ $item->mahasiswa?->user?->name ?? '-' }}</div>
                                            <div class="text-[10px] text-slate-500 uppercase">NIM: {{ $item->mahasiswa->nim ?? '-' }}</div>
                                        </td>
                                        <td class="py-3 px-3 border-r border-slate-200">
                                            {{ $item->mahasiswa?->prodi?->nama_prodi ?? '-' }}
                                        </td>
                                        <td class="py-3 px-3 border-r border-slate-200">
                                            {{ $item->verified_at ? \Carbon\Carbon::parse($item->verified_at)->translatedFormat('d/m/Y') : '-' }}
                                        </td>
                                        <td class="py-3 px-3 text-center font-bold">
                                            <span class="{{ $item->status === 'aktif' ? 'text-emerald-700' : 'text-amber-700' }} uppercase text-[10px]">
                                                {{ $item->status === 'aktif' ? 'Diserahkan' : 'Belum Diserahkan' }}
                                            </span>
                                        </td>
                                    @elseif($selectedCollectionType === 'proposal_ta')
                                        <td class="py-3 px-4 border-r border-slate-200 font-bold text-slate-900">
                                            {{ $item->judul_proposal }}
                                        </td>
                                        <td class="py-3 px-4 border-r border-slate-200">
                                            <div class="font-bold text-slate-900">{{ $item->mahasiswa?->user?->name ?? '-' }}</div>
                                            <div class="text-[10px] text-slate-500 uppercase">NIM: {{ $item->mahasiswa->nim ?? '-' }}</div>
                                        </td>
                                        <td class="py-3 px-3 border-r border-slate-200">
                                            {{ $item->mahasiswa?->prodi?->nama_prodi ?? '-' }}
                                        </td>
                                        <td class="py-3 px-3 border-r border-slate-200">
                                            {{ $item->verified_at ? \Carbon\Carbon::parse($item->verified_at)->translatedFormat('d/m/Y') : '-' }}
                                        </td>
                                        <td class="py-3 px-3 text-center font-bold">
                                            <span class="{{ $item->status === 'aktif' ? 'text-emerald-700' : 'text-amber-700' }} uppercase text-[10px]">
                                                {{ $item->status === 'aktif' ? 'Diserahkan' : 'Belum Diserahkan' }}
                                            </span>
                                        </td>
                                    @elseif($selectedCollectionType === 'laporan_ta')
                                        <td class="py-3 px-4 border-r border-slate-200 font-bold text-slate-900">
                                            {{ $item->judul_tgs_akhir }}
                                        </td>
                                        <td class="py-3 px-4 border-r border-slate-200">
                                            <div class="font-bold text-slate-900">{{ $item->mahasiswa?->user?->name ?? '-' }}</div>
                                            <div class="text-[10px] text-slate-500 uppercase">NIM: {{ $item->mahasiswa->nim ?? '-' }}</div>
                                        </td>
                                        <td class="py-3 px-3 border-r border-slate-200">
                                            {{ $item->mahasiswa?->prodi?->nama_prodi ?? '-' }}
                                        </td>
                                        <td class="py-3 px-3 border-r border-slate-200">
                                            {{ $item->verified_at ? \Carbon\Carbon::parse($item->verified_at)->translatedFormat('d/m/Y') : '-' }}
                                        </td>
                                        <td class="py-3 px-3 text-center font-bold">
                                            <span class="{{ $item->status === 'aktif' ? 'text-emerald-700' : 'text-amber-700' }} uppercase text-[10px]">
                                                {{ $item->status === 'aktif' ? 'Diserahkan' : 'Belum Diserahkan' }}
                                            </span>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-slate-400 font-medium">Tidak ada data koleksi yang ditemukan pada filter ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Summary & Signature Block -->
                <div class="pt-4 flex justify-between items-end border-t border-slate-200">
                    <div class="text-xs text-slate-500 font-semibold">
                        Total Data Terhitung: {{ method_exists($items, 'total') ? $items->total() : $items->count() }} Record
                    </div>
                    <!-- Signature Block - Only Visible When Printed -->
                    <div class="hidden print-only-signature text-center text-xs space-y-12 pr-6">
                        <p>Sukamara, {{ now()->translatedFormat('d F Y') }}<br>Petugas Perpustakaan,</p>
                        <p class="font-bold underline pt-8 text-slate-900">{{ Auth::user()->name }}</p>
                    </div>
                </div>

                @if(method_exists($items, 'hasPages') && $items->hasPages())
                    <div class="no-print pt-4 border-t border-slate-100">
                        {{ $items->links() }}
                    </div>
                @endif
            @endif
        </div>
    </main>
</body>
</html>
