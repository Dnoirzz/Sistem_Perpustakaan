<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Sistem Antrian Buku - SIPUS PSDKU POLNEP</title>
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

    <main class="ml-64 p-6 sm:p-10 bg-[#f8faff] min-h-screen">
        @include('petugas.layouts.header', [
            'title' => 'Sistem Antrian Buku',
            'subtitle' => 'Kelola daftar tunggu buku yang sedang kosong stoknya.'
        ])

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3 text-emerald-800 text-sm shadow-sm animate-fade-in">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <div class="font-semibold">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-2xl flex items-center gap-3 text-rose-800 text-sm shadow-sm animate-fade-in">
                <span class="material-symbols-outlined text-rose-600">error</span>
                <div class="font-semibold">{{ session('error') }}</div>
            </div>
        @endif

        {{-- Statistik --}}
        <section class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-3xl border border-outline-variant/100 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white shadow-lg shadow-amber-200">
                        <span class="material-symbols-outlined">hourglass_empty</span>
                    </div>
                    <span class="text-[10px] font-bold text-outline uppercase tracking-wider">Menunggu</span>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Anggota Menunggu</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-on-surface">{{ $stats['waiting'] }}</span>
                    <span class="text-xs text-outline font-semibold">orang</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-outline-variant/100 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                        <span class="material-symbols-outlined">check_circle</span>
                    </div>
                    <span class="text-[10px] font-bold text-outline uppercase tracking-wider">Tersedia</span>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Buku Tersedia</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-on-surface">{{ $stats['available'] }}</span>
                    <span class="text-xs text-outline font-semibold">transaksi</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-outline-variant/100 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-sky-400 to-sky-600 flex items-center justify-center text-white shadow-lg shadow-sky-200">
                        <span class="material-symbols-outlined">done_all</span>
                    </div>
                    <span class="text-[10px] font-bold text-outline uppercase tracking-wider">Selesai</span>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Antrian Selesai</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-on-surface">{{ $stats['done'] }}</span>
                    <span class="text-xs text-outline font-semibold">transaksi</span>
                </div>
            </div>
        </section>

        {{-- Filter & Search --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <section class="bg-white p-6 rounded-3xl border border-outline-variant/100 shadow-sm flex-1">
                <form action="{{ route('petugas.antrian.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                        <input type="text" name="search" placeholder="Cari nama, NIM, NIP, atau judul buku" class="w-full pl-12 pr-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold" value="{{ request('search') }}"/>
                    </div>
                    <div>
                        <select name="status" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant">
                            <option value="">Semua Status</option>
                            <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="tersedia" {{ request('status') === 'tersedia' ? 'selected' : '' }}>Buku Tersedia</option>
                            <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai / Diambil</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 py-3 px-6 rounded-2xl bg-primary text-white font-bold text-xs hover:bg-opacity-95 transition-all shadow-sm">
                            Terapkan Filter
                        </button>
                        @if(request()->filled('search') || request()->filled('status'))
                            <a href="{{ route('petugas.antrian.index') }}" class="py-3 px-6 rounded-2xl border border-outline-variant/100 text-on-surface-variant hover:bg-slate-50 font-bold text-xs transition-all text-center">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </section>
        </div>

        {{-- Tabel --}}
        <x-table :pagination="$antrianList->hasPages() ? $antrianList->links() : null">
            <x-slot name="headers">
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">No. Antrian</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Anggota</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Buku</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Status</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-center text-slate-700 whitespace-nowrap">Aksi</th>
            </x-slot>

            @forelse($antrianList as $antrian)
                <tr class="even:bg-slate-50/40 hover:bg-teal-50/40 transition-colors duration-150 group">
                    <td class="px-8 py-5 text-sm font-extrabold text-teal-700 whitespace-nowrap">
                        #{{ $antrian->no_antrian }}
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-slate-100 flex items-center justify-center font-bold text-teal-700 text-xs uppercase border border-outline-variant/100 shadow-xs">
                                {{ substr($antrian->user->name, 0, 2) }}
                            </div>
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-900 text-sm group-hover:text-teal-700 transition-colors">{{ $antrian->user->name }}</span>
                                <span class="text-[10px] text-slate-500 font-bold tracking-wider uppercase">
                                    @if($antrian->user->role?->role_name === 'mahasiswa')
                                        Mahasiswa • NIM {{ $antrian->user->mahasiswa->nim ?? '-' }}
                                    @else
                                        Dosen • NIP {{ $antrian->user->dosen->nip ?? '-' }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex flex-col">
                            <span class="font-bold text-slate-900 text-sm">{{ $antrian->collection?->display_title ?? 'Buku tidak ditemukan' }}</span>
                            <span class="text-[10px] text-slate-500 font-semibold">
                                Stok Koleksi: {{ $antrian->collection?->stock ?? 0 }} eks
                            </span>
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        @if($antrian->status === 'menunggu')
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-amber-100 text-amber-800 border border-amber-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                <span class="w-2 h-2 rounded-full bg-amber-600 mr-2 animate-pulse"></span>
                                Menunggu Stok
                            </span>
                        @elseif($antrian->status === 'tersedia')
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                <span class="w-2 h-2 rounded-full bg-emerald-600 mr-2 animate-pulse"></span>
                                Buku Tersedia
                            </span>
                        @elseif($antrian->status === 'selesai')
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-slate-100 text-slate-700 border border-slate-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                <span class="w-2 h-2 rounded-full bg-slate-500 mr-2"></span>
                                Selesai
                            </span>
                        @else
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-slate-100 text-slate-800 border border-slate-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                {{ $antrian->status }}
                            </span>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-center whitespace-nowrap">
                        @if($antrian->status === 'menunggu')
                            <button type="button" disabled title="Stok fisik belum tersedia" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 text-slate-400 font-bold text-xs cursor-not-allowed border border-slate-200/80 shadow-none">
                                <span class="material-symbols-outlined text-[16px]">book</span>
                                Proses Peminjaman
                            </button>
                        @elseif($antrian->status === 'tersedia')
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('petugas.loans.create', ['user_id' => $antrian->user_id, 'koleksi_id' => $antrian->koleksi_id]) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-700 transition-all shadow-xs active:scale-95 shadow-emerald-200">
                                    <span class="material-symbols-outlined text-[16px]">book</span>
                                    Proses Peminjaman
                                </a>
                                <form action="{{ route('petugas.antrian.mark-done', $antrian->antrian_id) }}" method="POST">
                                    @csrf
                                    <button type="submit" title="Tandai Selesai" class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition-all border border-slate-200">
                                        <span class="material-symbols-outlined text-[18px]">done</span>
                                    </button>
                                </form>
                            </div>
                        @else
                            <span class="text-xs text-slate-400 font-medium">Selesai diproses</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-8 py-14 text-center text-slate-500 font-medium">
                        Tidak ada data antrian buku.
                    </td>
                </tr>
            @endforelse
        </x-table>
    </main>
</body>
</html>
