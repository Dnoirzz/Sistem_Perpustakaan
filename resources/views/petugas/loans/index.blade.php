<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Transaksi Peminjaman - SIPUS PSDKU POLNEP</title>
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
    @include('petugas.layouts.sidebar')

    <main class="ml-64 p-margin-desktop bg-[#f8faff] min-h-screen">
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="font-headline-md text-on-surface">Transaksi Peminjaman Buku</h1>
                <p class="text-sm text-outline">Pantau sirkulasi aktif dan buat transaksi peminjaman baru dengan alur petugas yang rapi.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="font-label-md text-on-surface">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-outline font-medium uppercase tracking-wide">{{ Auth::user()->petugas?->jabatan ?? 'Petugas Perpustakaan' }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-primary-container flex items-center justify-center overflow-hidden border-2 border-white shadow-sm">
                    <img alt="User Avatar" class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e2e7ff&color=00a5c0&bold=true"/>
                </div>
            </div>
        </header>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3 text-emerald-800 text-sm shadow-sm">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <div class="font-semibold">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-2xl flex items-center gap-3 text-rose-800 text-sm shadow-sm">
                <span class="material-symbols-outlined text-rose-600">error</span>
                <div class="font-semibold">{{ session('error') }}</div>
            </div>
        @endif

        <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-3xl border border-outline-variant/20 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                        <span class="material-symbols-outlined">swap_horiz</span>
                    </div>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Peminjaman Aktif</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-on-surface">{{ $stats['active_loans'] }}</span>
                    <span class="text-xs text-outline font-semibold">transaksi</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-outline-variant/20 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-rose-400 to-rose-600 flex items-center justify-center text-white shadow-lg shadow-rose-200">
                        <span class="material-symbols-outlined">warning</span>
                    </div>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Pengembalian Terlambat</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold {{ $stats['overdue_loans'] > 0 ? 'text-rose-600' : 'text-on-surface' }}">{{ $stats['overdue_loans'] }}</span>
                    <span class="text-xs text-outline font-semibold">transaksi</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-outline-variant/20 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-sky-400 to-sky-600 flex items-center justify-center text-white shadow-lg shadow-sky-200">
                        <span class="material-symbols-outlined">assignment_turned_in</span>
                    </div>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Buku Dikembalikan Hari Ini</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-on-surface">{{ $stats['returned_today'] }}</span>
                    <span class="text-xs text-outline font-semibold">transaksi</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-outline-variant/20 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white shadow-lg shadow-amber-200">
                        <span class="material-symbols-outlined">menu_book</span>
                    </div>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Stok Tersedia</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-on-surface">{{ $stats['available_books'] }}</span>
                    <span class="text-xs text-outline font-semibold">item</span>
                </div>
            </div>
        </section>

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <section class="bg-white p-6 rounded-3xl border border-outline-variant/10 shadow-sm flex-1">
                <form action="{{ route('petugas.loans.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                        <input type="text" name="search" placeholder="Cari nama, NIM, NIP, atau judul buku" class="w-full pl-12 pr-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold" value="{{ request('search') }}"/>
                    </div>
                    <div>
                        <select name="status" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant">
                            <option value="">Semua Status</option>
                            <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="terlambat" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                            <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 py-3 px-6 rounded-2xl bg-primary text-white font-bold text-xs hover:bg-opacity-95 transition-all">
                            Terapkan Filter
                        </button>
                        @if(request()->filled('search') || request()->filled('status'))
                            <a href="{{ route('petugas.loans.index') }}" class="py-3 px-6 rounded-2xl border border-outline-variant/30 text-on-surface-variant hover:bg-slate-50 font-bold text-xs transition-all text-center">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </section>

            <a href="{{ route('petugas.loans.create') }}" class="flex items-center gap-2 px-6 py-3 rounded-2xl bg-primary text-white font-bold text-sm shadow-lg shadow-primary/20 hover:bg-opacity-95 transition-all whitespace-nowrap">
                <span class="material-symbols-outlined text-[18px]">library_add</span>
                Buat Peminjaman
            </a>
        </div>

        <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/10 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-surface-container-low/50">
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Anggota</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Buku</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Tanggal Pinjam</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Batas Pengembalian</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Pengembalian</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @forelse($loans as $loan)
                            <tr class="hover:bg-surface-container-low/30 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-2xl bg-slate-100 flex items-center justify-center font-bold text-primary text-xs uppercase border border-outline-variant/10 shadow-sm">
                                            {{ substr($loan->user->name, 0, 2) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-bold text-on-surface text-sm">{{ $loan->user->name }}</span>
                                            <span class="text-[10px] text-outline font-bold tracking-wider uppercase">
                                                @if($loan->user->role?->role_name === 'mahasiswa')
                                                    Mahasiswa • NIM {{ $loan->user->mahasiswa->nim ?? '-' }}
                                                @else
                                                    Dosen • NIP {{ $loan->user->dosen->nip ?? '-' }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-on-surface text-sm">{{ $loan->collection?->display_title ?? 'Buku tidak ditemukan' }}</span>
                                        <span class="text-[10px] text-outline font-semibold">
                                            {{ $loan->collection?->book?->author ?? $loan->collection?->display_type_label ?? 'Koleksi' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-sm text-on-surface-variant">
                                    {{ \Carbon\Carbon::parse($loan->tgl_pinjam)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-8 py-5 text-sm {{ $loan->status === 'terlambat' ? 'text-rose-600 font-semibold' : 'text-on-surface-variant' }}">
                                    {{ \Carbon\Carbon::parse($loan->bts_waktu)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-8 py-5 text-sm text-on-surface-variant">
                                    {{ $loan->tgl_kembali ? \Carbon\Carbon::parse($loan->tgl_kembali)->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td class="px-8 py-5">
                                    @if($loan->status === 'terlambat')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold uppercase tracking-wide">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5 animate-pulse"></span>
                                            Terlambat
                                        </span>
                                    @elseif($loan->status === 'dikembalikan')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-wide">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                            Dikembalikan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-sky-50 text-sky-600 text-[10px] font-bold uppercase tracking-wide">
                                            <span class="w-1.5 h-1.5 rounded-full bg-sky-500 mr-1.5"></span>
                                            Dipinjam
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-12 text-center text-outline font-medium">Belum ada transaksi peminjaman yang tercatat.</td>
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
    </main>
</body>
</html>
