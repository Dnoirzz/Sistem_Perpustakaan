<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Kelola Sesi Voting Buku - SIPUS PSDKU POLNEP</title>
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
        <!-- Top Bar / Header Info -->
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="font-headline-md text-on-surface">Kelola Sesi Voting Buku</h1>
                <p class="text-sm text-outline">Kelola kegiatan voting pengadaan buku baru untuk perpustakaan.</p>
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

        <!-- Alert Section -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3 text-emerald-800 text-sm shadow-sm font-semibold">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        <section class="mb-6 flex justify-between items-center">
            <h2 class="text-lg font-bold text-on-surface">Daftar Sesi Voting</h2>
            <a href="{{ route('petugas.voting.create') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-primary hover:bg-primary/90 text-white text-xs font-bold transition-all shadow-md">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Buat Sesi Voting Baru
            </a>
        </section>

        <!-- Table Card -->
        <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/10 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-surface-container-low/50">
                            <th class="px-8 py-4 font-label-md text-outline text-xs uppercase tracking-widest">Judul Sesi</th>
                            <th class="px-8 py-4 font-label-md text-outline text-xs uppercase tracking-widest">Tanggal Mulai</th>
                            <th class="px-8 py-4 font-label-md text-outline text-xs uppercase tracking-widest">Tanggal Selesai</th>
                            <th class="px-8 py-4 font-label-md text-outline text-xs uppercase tracking-widest text-center">Kandidat Buku</th>
                            <th class="px-8 py-4 font-label-md text-outline text-xs uppercase tracking-widest text-center">Total Suara</th>
                            <th class="px-8 py-4 font-label-md text-outline text-xs uppercase tracking-widest">Status</th>
                            <th class="px-8 py-4 font-label-md text-outline text-xs uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @forelse($votings as $voting)
                            @php
                                $today = now()->toDateString();
                                $tglMulai = $voting->tgl_mulai->toDateString();
                                $tglSelesai = $voting->tgl_selesai->toDateString();
                                
                                $totalVotes = $voting->votingItems->sum(function($item) {
                                    return $item->votes->count();
                                });
                            @endphp
                            <tr class="hover:bg-surface-container-low/30 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-on-surface text-sm">{{ $voting->title }}</span>
                                        <span class="text-xs text-outline line-clamp-1 max-w-xs">{{ $voting->deskripsi ?: 'Tidak ada deskripsi.' }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-sm text-on-surface-variant">
                                    {{ $voting->tgl_mulai->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-8 py-5 text-sm text-on-surface-variant">
                                    {{ $voting->tgl_selesai->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-8 py-5 text-sm text-on-surface-variant text-center font-semibold">
                                    {{ $voting->votingItems->count() }}
                                </td>
                                <td class="px-8 py-5 text-sm text-primary text-center font-bold">
                                    {{ $totalVotes }}
                                </td>
                                <td class="px-8 py-5">
                                    @if($today < $tglMulai)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-[10px] font-bold uppercase tracking-wider">
                                            Belum Mulai
                                        </span>
                                    @elseif($today <= $tglSelesai)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-wider">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-slate-100 text-outline text-[10px] font-bold uppercase tracking-wider">
                                            Selesai
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('petugas.voting.show', $voting->voting_id) }}" class="p-2 rounded-xl text-primary hover:bg-primary/5 transition-all inline-flex items-center justify-center" title="Lihat Rekap Hasil">
                                            <span class="material-symbols-outlined text-[20px]">analytics</span>
                                        </a>
                                        
                                        <form action="{{ route('petugas.voting.destroy', $voting->voting_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sesi voting ini? Semua kandidat dan hasil vote di dalamnya akan ikut terhapus.')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-xl text-outline hover:text-rose-600 hover:bg-rose-50 transition-all inline-flex items-center justify-center" title="Hapus Sesi">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-8 py-8 text-center text-outline font-medium">Belum ada sesi voting pengadaan buku dibuat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($votings->hasPages())
                <div class="p-6 border-t border-outline-variant/10">
                    {{ $votings->links() }}
                </div>
            @endif
        </section>
    </main>
</body>
</html>
