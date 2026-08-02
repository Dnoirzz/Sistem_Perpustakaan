<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Kelola Usulan Buku - SIPUS PSDKU POLNEP</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
    
    <main class="ml-64 p-6 sm:p-10 bg-[#f8faff] min-h-screen">
        @include('petugas.layouts.header', [
            'title' => 'Kelola Usulan Buku',
            'subtitle' => 'Verifikasi usulan pengadaan buku baru dari mahasiswa dan dosen.'
        ])

        <!-- Alert Section -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3 text-emerald-800 text-sm shadow-sm font-semibold">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        <!-- Filter Bar -->
        <section class="mb-8 rounded-3xl border border-outline-variant/10 bg-white p-6 shadow-sm">
            <form action="{{ route('petugas.recommendations.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-wider mb-2">Status Usulan</label>
                    <select name="status" onchange="this.form.submit()" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/45 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant transition-all">
                        <option value="">Semua Status</option>
                        <option value="pending" @selected($selectedStatus === 'pending')>Pending</option>
                        <option value="disetujui" @selected($selectedStatus === 'disetujui')>Disetujui</option>
                        <option value="ditolak" @selected($selectedStatus === 'ditolak')>Ditolak</option>
                    </select>
                </div>
                @if($selectedStatus !== null && $selectedStatus !== '')
                    <div class="pt-6">
                        <a href="{{ route('petugas.recommendations.index') }}" class="rounded-2xl border border-outline-variant/30 px-6 py-3 text-center text-xs font-bold text-outline transition-all hover:bg-slate-50 flex items-center justify-center">
                            Reset Filter
                        </a>
                    </div>
                @endif
            </form>
        </section>

        <!-- Table Card -->
        <x-table :pagination="$recommendations->hasPages() ? $recommendations->links() : null">
            <x-slot name="headers">
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Pengusul</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Judul & Penulis</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Alasan Usulan</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Tanggal Masuk</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Status</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-right text-slate-700 whitespace-nowrap">Aksi</th>
            </x-slot>

            @forelse($recommendations as $rec)
                <tr class="even:bg-slate-50/40 hover:bg-teal-50/40 transition-colors duration-150 group">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex flex-col">
                            <span class="font-bold text-slate-900 text-sm group-hover:text-teal-700 transition-colors">{{ $rec->user?->name }}</span>
                            <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">{{ $rec->user?->role?->role_name }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex flex-col">
                            <span class="font-bold text-slate-900 text-sm">{{ $rec->title }}</span>
                            <span class="text-xs text-slate-500 font-medium">Oleh: {{ $rec->author ?: 'Anonim' }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-5 text-sm text-slate-700 font-medium" title="{{ $rec->reason }}">
                        {{ $rec->reason ?: '-' }}
                    </td>
                    <td class="px-8 py-5 text-sm text-slate-700 font-medium whitespace-nowrap">
                        {{ $rec->created_at->translatedFormat('d-m-Y H:i') }}
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        @if($rec->status === 'pending')
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-amber-100 text-amber-800 border border-amber-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                <span class="w-2 h-2 rounded-full bg-amber-600 mr-2 animate-pulse"></span>
                                Pending
                            </span>
                        @elseif($rec->status === 'disetujui')
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                <span class="w-2 h-2 rounded-full bg-emerald-600 mr-2"></span>
                                Disetujui
                            </span>
                        @else
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-rose-100 text-rose-700 border border-rose-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                <span class="w-2 h-2 rounded-full bg-rose-600 mr-2"></span>
                                Ditolak
                            </span>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-right whitespace-nowrap">
                        @if($rec->status === 'pending')
                            <div class="flex items-center justify-end gap-2" x-data="{ openVerify: false }">
                                <!-- Tombol Tolak -->
                                <form action="{{ route('petugas.recommendations.verify', $rec->rekomendasi_id) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="ditolak">
                                    <button type="submit" class="px-3 py-1.5 rounded-xl border border-rose-200 text-rose-700 bg-rose-50 hover:bg-rose-100 text-xs font-bold transition-all shadow-2xs active:scale-95">
                                        Tolak
                                    </button>
                                </form>

                                <!-- Tombol Setujui dengan Dropdown Sesi Voting (Alpine.js) -->
                                <div class="relative">
                                    <button @click="openVerify = !openVerify" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all flex items-center gap-1 shadow-2xs active:scale-95">
                                        Setujui
                                        <span class="material-symbols-outlined text-[14px]">expand_more</span>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div x-show="openVerify" @click.away="openVerify = false" x-transition class="absolute right-0 mt-2 w-72 bg-white rounded-2xl border border-slate-200 shadow-xl z-50 p-4 text-left">
                                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Tindakan Persetujuan</p>
                                        
                                        <!-- Aksi 1: Setujui langsung tanpa voting -->
                                        <form action="{{ route('petugas.recommendations.verify', $rec->rekomendasi_id) }}" method="POST" class="mb-3">
                                            @csrf
                                            <input type="hidden" name="status" value="disetujui">
                                            <button type="submit" class="w-full text-left px-3 py-2 rounded-xl hover:bg-slate-50 text-xs font-bold text-slate-800 transition-all flex items-center gap-2">
                                                <span class="material-symbols-outlined text-teal-600 text-[18px]">done</span>
                                                Setujui Langsung (Tanpa Voting)
                                            </button>
                                        </form>

                                        <!-- Aksi 2: Setujui dan masukkan ke voting -->
                                        @if($activeVotings->count() > 0)
                                            <div class="border-t border-slate-100 pt-3">
                                                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Setujui & Masukkan ke Sesi Voting:</p>
                                                <div class="space-y-1 max-h-40 overflow-y-auto pr-1">
                                                    @foreach($activeVotings as $voting)
                                                        <form action="{{ route('petugas.recommendations.verify', $rec->rekomendasi_id) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="status" value="disetujui">
                                                            <input type="hidden" name="voting_id" value="{{ $voting->voting_id }}">
                                                            <button type="submit" class="w-full text-left px-3 py-2 rounded-xl hover:bg-teal-50 hover:text-teal-800 text-xs font-semibold text-slate-700 transition-all truncate">
                                                                {{ $voting->title }}
                                                            </button>
                                                        </form>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            <div class="border-t border-slate-100 pt-3">
                                                <p class="text-[10px] text-slate-400 font-semibold">Tidak ada sesi voting aktif saat ini.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Hapus Usulan yang sudah diproses jika perlu -->
                            <form action="{{ route('petugas.recommendations.destroy', $rec->rekomendasi_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus usulan ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 border border-rose-200 hover:bg-rose-600 hover:text-white hover:border-rose-600 flex items-center justify-center transition-all inline-flex active:scale-95">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-8 py-14 text-center text-slate-500 font-medium">Tidak ada usulan buku baru yang cocok dengan kriteria filter.</td>
                </tr>
            @endforelse
        </x-table>
    </main>
</body>
</html>
