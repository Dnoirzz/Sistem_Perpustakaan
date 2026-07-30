<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Pinjaman Saya - SIPUS PSDKU POLNEP</title>
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
<body class="font-body-md text-body-md antialiased min-h-screen flex">
    @include('mahasiswa.layouts.sidebar')

    <main class="ml-64 flex-1 p-margin-desktop bg-[#f8faff] min-h-screen">
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="font-headline-md text-on-surface">Buku Sedang Dipinjam</h1>
                <p class="text-sm text-outline">Daftar koleksi buku fisik perpustakaan yang sedang Anda pinjam saat ini.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="font-label-md text-on-surface">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-outline font-medium uppercase tracking-wide">NIM: {{ Auth::user()->mahasiswa->nim ?? '-' }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-primary-container flex items-center justify-center overflow-hidden border-2 border-white shadow-sm">
                    <img alt="User Avatar" class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e2e7ff&color=00a5c0&bold=true"/>
                </div>
            </div>
        </header>

        {{-- Tampilan Desktop Tabel --}}
        <section class="hidden lg:block bg-white rounded-3xl shadow-sm border border-outline-variant/10 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-surface-container-low/50">
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Buku</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Tanggal Pinjam</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Batas Pengembalian</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Status</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Denda Aktif</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @forelse($loans as $loan)
                            @php
                                $unpaidFines = $loan->penalties->where('status', 'belum_dibayar')->sum('amount');
                            @endphp
                            <tr class="hover:bg-surface-container-low/30 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-on-surface text-sm">{{ $loan->collection?->display_title ?? 'Koleksi tidak ditemukan' }}</span>
                                        <span class="text-xs text-outline">
                                            {{ $loan->collection?->book?->author ?? 'Penulis' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-sm text-on-surface-variant">
                                    {{ $loan->tgl_pinjam ? \Carbon\Carbon::parse($loan->tgl_pinjam)->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td class="px-8 py-5 text-sm text-on-surface-variant font-semibold">
                                    {{ $loan->bts_waktu ? \Carbon\Carbon::parse($loan->bts_waktu)->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td class="px-8 py-5">
                                    @if($loan->status === 'terlambat' || $loan->isOverdue())
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold uppercase tracking-wide">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5 animate-pulse"></span>
                                            Terlambat
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-wide">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5"></span>
                                            Dipinjam
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-sm font-bold text-on-surface">
                                    @if($unpaidFines > 0)
                                        <span class="text-rose-600">Rp {{ number_format($unpaidFines, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-outline font-medium">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-12 text-center text-outline font-medium">
                                    Anda tidak sedang meminjam buku fisik saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($loans->hasPages())
                <div class="p-6 border-t border-outline-variant/10 bg-slate-50/50">
                    {{ $loans->links() }}
                </div>
            @endif
        </section>

        {{-- Tampilan Mobile Card List --}}
        <div class="lg:hidden space-y-4">
            @forelse($loans as $loan)
                @php
                    $unpaidFines = $loan->penalties->where('status', 'belum_dibayar')->sum('amount');
                @endphp
                <div class="bg-white p-6 rounded-3xl border border-outline-variant/10 shadow-sm flex flex-col gap-4">
                    <!-- Judul Buku & Penulis -->
                    <div>
                        <h4 class="font-bold text-on-surface text-sm">{{ $loan->collection?->display_title ?? 'Koleksi tidak ditemukan' }}</h4>
                        <p class="text-xs text-outline mt-0.5">{{ $loan->collection?->book?->author ?? 'Penulis' }}</p>
                    </div>

                    <!-- Info Tanggal -->
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-outline-variant/10">
                        <div>
                            <span class="text-[10px] text-outline uppercase tracking-wider block mb-1">Tanggal Pinjam</span>
                            <span class="text-xs font-semibold text-on-surface">
                                {{ $loan->tgl_pinjam ? \Carbon\Carbon::parse($loan->tgl_pinjam)->translatedFormat('d M Y') : '-' }}
                            </span>
                        </div>
                        <div>
                            <span class="text-[10px] text-outline uppercase tracking-wider block mb-1">Batas Pengembalian</span>
                            <span class="text-xs font-bold text-on-surface">
                                {{ $loan->bts_waktu ? \Carbon\Carbon::parse($loan->bts_waktu)->translatedFormat('d M Y') : '-' }}
                            </span>
                        </div>
                    </div>

                    <!-- Status & Denda -->
                    <div class="flex justify-between items-center pt-4 border-t border-outline-variant/10">
                        <div>
                            @if($loan->status === 'terlambat' || $loan->isOverdue())
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold uppercase tracking-wide">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5 animate-pulse"></span>
                                    Terlambat
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-wide">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5"></span>
                                    Dipinjam
                                </span>
                            @endif
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] text-outline uppercase tracking-wider block mb-0.5">Denda</span>
                            @if($unpaidFines > 0)
                                <span class="text-xs font-bold text-rose-600">Rp {{ number_format($unpaidFines, 0, ',', '.') }}</span>
                            @else
                                <span class="text-xs font-semibold text-outline">-</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white p-8 rounded-3xl border border-outline-variant/10 text-center text-outline text-sm font-medium shadow-sm">
                    Anda tidak sedang meminjam buku fisik saat ini.
                </div>
            @endforelse

            @if($loans->hasPages())
                <div class="pt-2">
                    {{ $loans->links() }}
                </div>
            @endif
        </div>
    </main>
</body>
</html>
