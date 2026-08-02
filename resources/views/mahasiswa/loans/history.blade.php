<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Riwayat Peminjaman - SIPUS PSDKU POLNEP</title>
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
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #c7c4d8;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #b1afc2;
        }
    </style>
</head>
<body class="font-body-md text-body-md antialiased min-h-screen">
    @include('mahasiswa.layouts.sidebar')

    <main class="ml-64 p-margin-desktop bg-[#f8faff] min-h-screen">
        @include('layouts.header', [
            'title' => 'Riwayat Aktivitas Perpustakaan',
            'subtitle' => 'Daftar riwayat peminjaman buku fisik dan pembacaan arsip digital secara online.'
        ])

        {{-- Tampilan Desktop Tabel --}}
        <x-table :pagination="$history->hasPages() ? $history->links() : null">
            <x-slot name="headers">
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Buku / Arsip</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Aktivitas</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Tanggal Pinjam</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Tanggal Kembali</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Keterangan</th>
            </x-slot>

            @forelse($history as $item)
                <tr class="even:bg-slate-50/40 hover:bg-teal-50/40 transition-colors duration-150 group">
                    <td class="px-8 py-5">
                        <div class="flex flex-col">
                            <span class="font-bold text-slate-900 text-sm group-hover:text-teal-700 transition-colors">{{ $item['judul'] }}</span>
                            <span class="text-xs font-semibold text-slate-500 mt-0.5">
                                {{ $item['penulis'] }}
                            </span>
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        @if($item['tipe_riwayat'] === 'fisik')
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-sky-100 text-sky-800 border border-sky-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                <span class="w-2 h-2 rounded-full bg-sky-600 mr-2"></span>
                                Buku Fisik
                            </span>
                        @else
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                <span class="w-2 h-2 rounded-full bg-emerald-600 mr-2"></span>
                                Baca Online
                            </span>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-sm text-slate-700 font-medium whitespace-nowrap">
                        @if($item['tipe_riwayat'] === 'fisik')
                            {{ $item['tgl_pinjam'] ? \Carbon\Carbon::parse($item['tgl_pinjam'])->translatedFormat('d M Y') : '-' }}
                        @else
                            {{ $item['tgl_pinjam'] ? \Carbon\Carbon::parse($item['tgl_pinjam'])->translatedFormat('d M Y, H:i') : '-' }} WIB
                        @endif
                    </td>
                    <td class="px-8 py-5 text-sm text-slate-900 font-bold whitespace-nowrap">
                        @if($item['tipe_riwayat'] === 'fisik')
                            {{ $item['tgl_kembali'] ? \Carbon\Carbon::parse($item['tgl_kembali'])->translatedFormat('d M Y') : '-' }}
                        @else
                            @if($item['tgl_kembali'])
                                {{ \Carbon\Carbon::parse($item['tgl_kembali'])->translatedFormat('d M Y, H:i') }} WIB
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold uppercase tracking-wide border border-emerald-200 animate-pulse">
                                    Membaca
                                </span>
                            @endif
                        @endif
                    </td>
                    <td class="px-8 py-5 text-sm text-slate-700 font-semibold whitespace-nowrap">
                        {{ $item['keterangan'] }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-8 py-14 text-center text-slate-500 font-medium">
                        Belum ada riwayat aktivitas peminjaman fisik maupun baca online.
                    </td>
                </tr>
            @endforelse
        </x-table>

        {{-- Tampilan Mobile Card List --}}
        <div class="lg:hidden space-y-4">
            @forelse($history as $item)
                <div class="bg-white p-6 rounded-3xl border border-outline-variant/10 shadow-sm flex flex-col gap-4">
                    <!-- Judul Buku & Penulis -->
                    <div class="flex justify-between items-start gap-3">
                        <div class="flex-1">
                            <h4 class="font-bold text-on-surface text-sm">{{ $item['judul'] }}</h4>
                            <p class="text-xs text-outline mt-0.5">{{ $item['penulis'] }}</p>
                        </div>
                        <div>
                            @if($item['tipe_riwayat'] === 'fisik')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-wide border border-blue-200">
                                    Buku Fisik
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-wide border border-emerald-200">
                                    Baca Online
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Info Tanggal -->
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-outline-variant/10">
                        <div>
                            <span class="text-[10px] text-outline uppercase tracking-wider block mb-1">Tanggal Pinjam</span>
                            <span class="text-xs font-semibold text-on-surface">
                                @if($item['tipe_riwayat'] === 'fisik')
                                    {{ $item['tgl_pinjam'] ? \Carbon\Carbon::parse($item['tgl_pinjam'])->translatedFormat('d M Y') : '-' }}
                                @else
                                    {{ $item['tgl_pinjam'] ? \Carbon\Carbon::parse($item['tgl_pinjam'])->translatedFormat('d M Y, H:i') : '-' }} WIB
                                @endif
                            </span>
                        </div>
                        <div>
                            <span class="text-[10px] text-outline uppercase tracking-wider block mb-1">Tanggal Kembali</span>
                            <span class="text-xs font-bold text-on-surface">
                                @if($item['tipe_riwayat'] === 'fisik')
                                    {{ $item['tgl_kembali'] ? \Carbon\Carbon::parse($item['tgl_kembali'])->translatedFormat('d M Y') : '-' }}
                                @else
                                    @if($item['tgl_kembali'])
                                        {{ \Carbon\Carbon::parse($item['tgl_kembali'])->translatedFormat('d M Y, H:i') }} WIB
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-wide border border-emerald-200 animate-pulse">
                                            Membaca
                                        </span>
                                    @endif
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div class="pt-4 border-t border-outline-variant/10 flex flex-col gap-1">
                        <span class="text-[10px] text-outline uppercase tracking-wider block">Keterangan</span>
                        <span class="text-xs font-medium text-on-surface-variant">
                            {{ $item['keterangan'] }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="bg-white p-8 rounded-3xl border border-outline-variant/10 text-center text-outline text-sm font-medium shadow-sm">
                    Belum ada riwayat aktivitas peminjaman fisik maupun baca online.
                </div>
            @endforelse

            @if($history->hasPages())
                <div class="pt-2">
                    {{ $history->links() }}
                </div>
            @endif
        </div>
    </main>
</body>
</html>
