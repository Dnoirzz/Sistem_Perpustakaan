<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Pusat Laporan & Rekapitulasi - SIPUS PSDKU POLNEP</title>
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
                        "primary": "#00a5c0",
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
            background-color: #00a5c0;
            color: white;
            box-shadow: 0 4px 12px rgba(0, 165, 192, 0.2);
        }
    </style>
</head>
<body class="font-body-md text-body-md antialiased min-h-screen">
    @include('petugas.layouts.sidebar')
    
    <main class="ml-64 p-margin-desktop bg-[#f8faff] min-h-screen">
        @include('layouts.header', [
            'title' => 'Pusat Laporan Perpustakaan',
            'subtitle' => 'Ringkasan statistik data perpustakaan dan menu laporan terpadu.'
        ])

        <!-- Container Ringkasan Data Perpustakaan (4 Metrics Cards) -->
        <section class="mb-10">
            <h2 class="text-xs font-bold text-outline uppercase tracking-wider mb-4">Ringkasan Total Data Perpustakaan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- 1. Total Anggota -->
                <div class="bg-white p-6 rounded-3xl border border-outline-variant/100 shadow-sm hover:shadow-md transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[24px]">group</span>
                        </div>
                    </div>
                    <h3 class="text-on-surface-variant font-label-md text-xs mb-1">Total Anggota Perpustakaan</h3>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-on-surface">{{ number_format($stats['total_members'], 0, ',', '.') }}</span>
                        <span class="text-xs text-outline font-semibold">orang</span>
                    </div>
                </div>

                <!-- 2. Total Sirkulasi / Peminjaman -->
                <div class="bg-white p-6 rounded-3xl border border-outline-variant/100 shadow-sm hover:shadow-md transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[24px]">swap_horiz</span>
                        </div>
                    </div>
                    <h3 class="text-on-surface-variant font-label-md text-xs mb-1">Total Transaksi Peminjaman</h3>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-on-surface">{{ number_format($stats['total_loans'], 0, ',', '.') }}</span>
                        <span class="text-xs text-outline font-semibold">transaksi</span>
                    </div>
                </div>

                <!-- 3. Total Koleksi Perpustakaan -->
                <div class="bg-white p-6 rounded-3xl border border-outline-variant/100 shadow-sm hover:shadow-md transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[24px]">inventory_2</span>
                        </div>
                    </div>
                    <h3 class="text-on-surface-variant font-label-md text-xs mb-1">Total Stok Koleksi Perpustakaan</h3>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-on-surface">{{ number_format($stats['total_collections'], 0, ',', '.') }}</span>
                        <span class="text-xs text-outline font-semibold">item</span>
                    </div>
                </div>

                <!-- 4. Total Sanksi dan Denda -->
                <div class="bg-white p-6 rounded-3xl border border-outline-variant/100 shadow-sm hover:shadow-md transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[24px]">gavel</span>
                        </div>
                    </div>
                    <h3 class="text-on-surface-variant font-label-md text-xs mb-1">Total Sanksi &amp; Denda</h3>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-rose-600">{{ number_format($stats['total_penalties'], 0, ',', '.') }}</span>
                        <span class="text-xs text-outline font-semibold">kasus</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Navigation Section: Route Buttons ke Halaman Detail Tiap Laporan -->
        <section class="space-y-4">
            <h2 class="text-xs font-bold text-outline uppercase tracking-wider">Pilih Kategori Laporan Detail</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- 1. Laporan Sirkulasi -->
                <div class="bg-white p-6 rounded-3xl border border-outline-variant/100 shadow-sm flex flex-col justify-between hover:border-primary/40 transition-all group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[28px]">sync_alt</span>
                        </div>
                        <h3 class="font-headline-md text-on-surface text-base mb-1">Laporan Sirkulasi Peminjaman</h3>
                        <p class="text-xs text-outline mb-6">Tampilkan tabel detail transaksi peminjaman, batas pengembalian, dan histori peminjaman anggota secara live.</p>
                    </div>
                    <a href="{{ route('petugas.reports.sirkulasi') }}" class="w-full py-3 px-4 rounded-2xl bg-primary text-white text-xs font-bold transition-all shadow-md shadow-primary/20 hover:bg-opacity-95 text-center flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[16px]">visibility</span>
                        Buka Laporan Sirkulasi
                    </a>
                </div>

                <!-- 2. Laporan Koleksi -->
                <div class="bg-white p-6 rounded-3xl border border-outline-variant/100 shadow-sm flex flex-col justify-between hover:border-secondary/40 transition-all group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-secondary/10 text-secondary flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[28px]">menu_book</span>
                        </div>
                        <h3 class="font-headline-md text-on-surface text-base mb-1">Laporan Koleksi & Inventaris</h3>
                        <p class="text-xs text-outline mb-6">Tampilkan tabel detail inventaris katalog buku umum, stok fisik, penerbit, dan kategori buku.</p>
                    </div>
                    <a href="{{ route('petugas.reports.koleksi') }}" class="w-full py-3 px-4 rounded-2xl bg-secondary text-white text-xs font-bold transition-all shadow-md shadow-secondary/20 hover:bg-opacity-95 text-center flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[16px]">visibility</span>
                        Buka Laporan Koleksi
                    </a>
                </div>

                <!-- 3. Laporan Arsip Digital -->
                <div class="bg-white p-6 rounded-3xl border border-outline-variant/100 shadow-sm flex flex-col justify-between hover:border-primary/40 transition-all group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[28px]">folder_shared</span>
                        </div>
                        <h3 class="font-headline-md text-on-surface text-base mb-1">Laporan Pengumpulan Arsip</h3>
                        <p class="text-xs text-outline mb-6">Tampilkan tabel penerimaan dokumen karya ilmiah digital (Laporan PKL, Proposal TA, dan Laporan TA).</p>
                    </div>
                    <a href="{{ route('petugas.reports.arsip') }}" class="w-full py-3 px-4 rounded-2xl bg-primary text-white text-xs font-bold transition-all shadow-md shadow-primary/20 hover:bg-primary/90 text-center flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[16px]">visibility</span>
                        Buka Laporan Arsip
                    </a>
                </div>

                <!-- 4. Laporan Denda & Sanksi -->
                <div class="bg-white p-6 rounded-3xl border border-outline-variant/100 shadow-sm flex flex-col justify-between hover:border-rose-500/40 transition-all group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[28px]">gavel</span>
                        </div>
                        <h3 class="font-headline-md text-on-surface text-base mb-1">Laporan Denda & Sanksi</h3>
                        <p class="text-xs text-outline mb-6">Tampilkan tabel rekapan kasus keterlambatan, kerusakan, kehilangan buku, serta status penyelesaiannya.</p>
                    </div>
                    <a href="{{ route('petugas.reports.denda') }}" class="w-full py-3 px-4 rounded-2xl bg-rose-600 text-white text-xs font-bold transition-all shadow-md shadow-rose-200 hover:bg-rose-700 text-center flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[16px]">visibility</span>
                        Buka Laporan Denda
                    </a>
                </div>

            </div>
        </section>
    </main>
</body>
</html>
