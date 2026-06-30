<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Rekapitulasi & Laporan - SIPUS PSDKU POLNEP</title>
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
                        "on-tertiary-fixed": "#40000d",
                        "secondary-fixed": "#6ffbbe",
                        "secondary-fixed-dim": "#4edea3",
                        "on-tertiary": "#ffffff",
                        "outline-variant": "#c7c4d8",
                        "surface-container-highest": "#dae2fd",
                        "surface-container-high": "#e2e7ff",
                        "on-error": "#ffffff",
                        "background": "#faf8ff",
                        "on-primary": "#ffffff",
                        "on-secondary": "#ffffff",
                        "on-secondary-fixed": "#002113",
                        "tertiary-fixed-dim": "#ffb2b7",
                        "surface-variant": "#dae2fd",
                        "surface-container": "#eaedff",
                        "secondary-container": "#6cf8bb",
                        "secondary": "#006c49",
                        "tertiary": "#95002b",
                        "tertiary-fixed": "#ffdadb",
                        "primary": "#00a5c0", /* POLNEP Brand Turquoise */
                        "on-primary-container": "#dad7ff",
                        "surface-dim": "#d2d9f4",
                        "tertiary-container": "#bf0f3c",
                        "on-tertiary-fixed-variant": "#92002a",
                        "error-container": "#ffdad6",
                        "inverse-on-surface": "#eef0ff",
                        "on-secondary-fixed-variant": "#005236",
                        "surface-bright": "#faf8ff",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#131b2e",
                        "surface-tint": "#00a5c0",
                        "on-primary-fixed-variant": "#007b91",
                        "inverse-surface": "#283044",
                        "surface-container-low": "#f2f3ff",
                        "error": "#ba1a1a",
                        "on-surface-variant": "#464555",
                        "primary-fixed": "#e2dfff",
                        "on-secondary-container": "#00714d",
                        "primary-container": "#00a5c0",
                        "primary-fixed-dim": "#c3c0ff",
                        "on-primary-fixed": "#0f0069",
                        "on-tertiary-container": "#ffd0d2",
                        "on-error-container": "#93000a",
                        "inverse-primary": "#c3c0ff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "2xl": "1rem",
                        "3xl": "1.5rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "container-max": "1280px",
                        "base": "8px",
                        "margin-mobile": "16px",
                        "gutter": "24px",
                        "margin-desktop": "40px"
                    },
                    "fontFamily": {
                        "headline-md": ["Outfit"],
                        "label-md": ["Inter"],
                        "display-lg": ["Outfit"],
                        "caption": ["Inter"],
                        "headline-lg": ["Outfit"],
                        "headline-lg-mobile": ["Outfit"],
                        "body-lg": ["Inter"],
                        "body-md": ["Inter"]
                    },
                    "fontSize": {
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "600"}],
                        "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "caption": ["12px", {"lineHeight": "16px", "fontWeight": "400"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "fontWeight": "600"}],
                        "headline-lg-mobile": ["28px", {"lineHeight": "36px", "fontWeight": "600"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}]
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
            background-color: #f8faff;
            color: #131b2e;
        }
        .sidebar-active {
            background-color: #00a5c0; /* POLNEP Turquoise */
            color: white;
            box-shadow: 0 4px 12px rgba(0, 165, 192, 0.2);
        }
    </style>
</head>
<body class="font-body-md text-body-md antialiased min-h-screen">
    @include('petugas.layouts.sidebar')
    
    <main class="ml-64 p-margin-desktop bg-[#f8faff] min-h-screen">
        <!-- Top Bar / Header Info -->
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="font-headline-md text-on-surface">Rekapitulasi & Laporan</h1>
                <p class="text-sm text-outline">Tarik data rekap transaksi sirkulasi dan status aset inventaris perpustakaan.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="font-label-md text-on-surface">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-outline font-medium uppercase tracking-wide">Petugas Perpustakaan</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-primary-container flex items-center justify-center overflow-hidden border-2 border-white shadow-sm">
                    <img alt="User Avatar" class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e2e7ff&color=00a5c0&bold=true"/>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Sirkulasi Report Card -->
            <div class="bg-white p-8 rounded-3xl border border-outline-variant/10 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center text-primary mb-6">
                        <span class="material-symbols-outlined text-[32px]">sync_alt</span>
                    </div>
                    <h2 class="font-headline-md text-on-surface text-lg mb-2">Laporan Transaksi Sirkulasi</h2>
                    <p class="text-xs text-outline mb-6">Rekapitulasi data transaksi peminjaman, pengembalian, dan keterlambatan buku/arsip dalam rentang waktu tertentu.</p>
                    
                    <form id="form-sirkulasi" class="space-y-4 mb-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-outline uppercase tracking-wider mb-2">Mulai Tanggal</label>
                                <input type="date" id="tgl_awal" name="tgl_awal" value="{{ date('Y-m-01') }}" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-outline uppercase tracking-wider mb-2">Sampai Tanggal</label>
                                <input type="date" id="tgl_akhir" name="tgl_akhir" value="{{ date('Y-m-d') }}" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant transition-all">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="flex gap-3 border-t border-outline-variant/10 pt-6">
                    <button type="button" onclick="actionSirkulasi('print')" class="flex-1 py-3 px-4 rounded-2xl border border-primary/20 text-primary hover:bg-primary/5 text-xs font-bold transition-all text-center flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[16px]">print</span>
                        Cetak Laporan
                    </button>
                    <button type="button" onclick="actionSirkulasi('excel')" class="flex-1 py-3 px-4 rounded-2xl bg-primary hover:bg-primary/90 text-white text-xs font-bold transition-all shadow-md text-center flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[16px]">download</span>
                        Ekspor Excel
                    </button>
                </div>
            </div>

            <!-- Inventory Report Card -->
            <div class="bg-white p-8 rounded-3xl border border-outline-variant/10 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-secondary/10 flex items-center justify-center text-secondary mb-6">
                        <span class="material-symbols-outlined text-[32px]">inventory_2</span>
                    </div>
                    <h2 class="font-headline-md text-on-surface text-lg mb-2">Laporan Koleksi & Aset</h2>
                    <p class="text-xs text-outline mb-6">Rekapitulasi data seluruh inventaris perpustakaan (Buku Teks, Laporan PKL, Proposal Tugas Akhir, dan Laporan Tugas Akhir) secara komprehensif.</p>
                </div>
                <div class="flex gap-3 border-t border-outline-variant/10 pt-6 mt-12">
                    <a href="{{ route('petugas.reports.print-koleksi') }}" target="_blank" class="flex-1 py-3 px-4 rounded-2xl border border-secondary/20 text-secondary hover:bg-secondary/5 text-xs font-bold transition-all text-center flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[16px]">print</span>
                        Cetak Laporan
                    </a>
                    <a href="{{ route('petugas.reports.export-koleksi') }}" class="flex-1 py-3 px-4 rounded-2xl bg-secondary hover:bg-secondary/90 text-white text-xs font-bold transition-all shadow-md text-center flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[16px]">download</span>
                        Ekspor Excel
                    </a>
                </div>
            </div>
        </div>
    </main>

    <script>
        function actionSirkulasi(type) {
            const tglAwal = document.getElementById('tgl_awal').value;
            const tglAkhir = document.getElementById('tgl_akhir').value;

            if(!tglAwal || !tglAkhir) {
                alert('Silakan pilih rentang tanggal laporan terlebih dahulu.');
                return;
            }

            if (type === 'print') {
                const url = `{{ route('petugas.reports.print-sirkulasi') }}?tgl_awal=${tglAwal}&tgl_akhir=${tglAkhir}`;
                window.open(url, '_blank');
            } else if (type === 'excel') {
                window.location.href = `{{ route('petugas.reports.export-sirkulasi') }}?tgl_awal=${tglAwal}&tgl_akhir=${tglAkhir}`;
            }
        }
    </script>
</body>
</html>
