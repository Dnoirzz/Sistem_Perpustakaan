<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Denda & Sanksi - SIPUS PSDKU POLNEP</title>
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
                        "on-background": "#131b2e", "surface": "#faf8ff", "outline": "#777587",
                        "on-tertiary-fixed": "#40000d", "secondary-fixed": "#6ffbbe", "secondary-fixed-dim": "#4edea3",
                        "on-tertiary": "#ffffff", "outline-variant": "#c7c4d8", "surface-container-highest": "#dae2fd",
                        "surface-container-high": "#e2e7ff", "on-error": "#ffffff", "background": "#faf8ff",
                        "on-primary": "#ffffff", "on-secondary": "#ffffff", "on-secondary-fixed": "#002113",
                        "tertiary-fixed-dim": "#ffb2b7", "surface-variant": "#dae2fd", "surface-container": "#eaedff",
                        "secondary-container": "#6cf8bb", "secondary": "#006c49", "tertiary": "#95002b",
                        "tertiary-fixed": "#ffdadb", "primary": "#00a5c0", "on-primary-container": "#dad7ff",
                        "surface-dim": "#d2d9f4", "tertiary-container": "#bf0f3c", "on-tertiary-fixed-variant": "#92002a",
                        "error-container": "#ffdad6", "inverse-on-surface": "#eef0ff", "on-secondary-fixed-variant": "#005236",
                        "surface-bright": "#faf8ff", "surface-container-lowest": "#ffffff", "on-surface": "#131b2e",
                        "surface-tint": "#00a5c0", "on-primary-fixed-variant": "#007b91", "inverse-surface": "#283044",
                        "surface-container-low": "#f2f3ff", "error": "#ba1a1a", "on-surface-variant": "#464555",
                        "primary-fixed": "#e2dfff", "on-secondary-container": "#00714d", "primary-container": "#00a5c0",
                        "primary-fixed-dim": "#c3c0ff", "on-primary-fixed": "#0f0069", "on-tertiary-container": "#ffd0d2",
                        "on-error-container": "#93000a", "inverse-primary": "#c3c0ff"
                    },
                    "borderRadius": { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "2xl": "1rem", "3xl": "1.5rem", "full": "9999px" },
                    "spacing": { "container-max": "1280px", "base": "8px", "margin-mobile": "16px", "gutter": "24px", "margin-desktop": "40px" },
                    "fontFamily": { "headline-md": ["Outfit"], "label-md": ["Inter"], "display-lg": ["Outfit"], "caption": ["Inter"], "headline-lg": ["Outfit"], "headline-lg-mobile": ["Outfit"], "body-lg": ["Inter"], "body-md": ["Inter"] },
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
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        body { background-color: #f8faff; color: #131b2e; }
        .sidebar-active { background-color: #00a5c0; color: white; box-shadow: 0 4px 12px rgba(0, 165, 192, 0.2); }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #c7c4d8; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #b1afc2; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-body-md text-body-md antialiased min-h-screen">
    @include('petugas.layouts.sidebar')

    <main class="ml-64 p-6 sm:p-10 bg-[#f8faff] min-h-screen">
        @include('petugas.layouts.header', [
            'title' => 'Denda & Sanksi',
            'subtitle' => 'Kelola denda keterlambatan, proses buku hilang, dan kerusakan buku perpustakaan.'
        ])

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

        <section class="mb-8 max-w-sm">
            <div class="bg-white p-6 rounded-3xl border border-outline-variant/100 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-rose-400 to-rose-600 flex items-center justify-center text-white shadow-lg shadow-rose-200">
                        <span class="material-symbols-outlined">gavel</span>
                    </div>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Sanksi Aktif</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold {{ $stats['unpaid_count'] > 0 ? 'text-rose-600' : 'text-on-surface' }}">{{ $stats['unpaid_count'] }}</span>
                    <span class="text-xs text-outline font-semibold">sanksi</span>
                </div>
            </div>
        </section>

        <div class="mb-6 flex justify-end">
            <a href="{{ route('petugas.penalties.create') }}" class="flex items-center gap-2 px-6 py-3.5 rounded-2xl bg-primary text-white font-bold text-sm shadow-lg shadow-primary/20 hover:bg-opacity-95 transition-all whitespace-nowrap">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                Proses Buku Hilang
            </a>
        </div>

        @php
            $searchByOptions = [
                'anggota' => 'Nama Anggota',
                'identitas' => 'NIM / NIP',
                'koleksi' => 'Judul Buku / Arsip',
            ];
            $searchPlaceholders = [
                'all' => 'Masukkan nama, NIM, NIP, atau judul koleksi',
                'anggota' => 'Masukkan nama anggota',
                'identitas' => 'Masukkan NIM atau NIP',
                'koleksi' => 'Masukkan judul buku atau arsip',
            ];
            $selectedSearchBy = request()->filled('search')
                ? (string) request('search_by', 'all')
                : (string) request('search_by', '');
            $statusLabels = [
                'belum_dibayar' => 'Belum Selesai',
                'lunas' => 'Selesai',
            ];
            $hasActiveFilters = request()->filled('search') || request()->filled('status');
        @endphp

        <section class="mb-8 bg-white p-6 rounded-3xl border border-outline-variant/100 shadow-sm">
                <form
                    action="{{ route('petugas.penalties.index') }}"
                    method="GET"
                    x-data="{ searchBy: @js($selectedSearchBy), placeholders: @js($searchPlaceholders) }"
                >
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="penalty_search_by" class="sr-only">Cari berdasarkan</label>
                            <select
                                id="penalty_search_by"
                                name="search_by"
                                x-model="searchBy"
                                @change="searchBy ? $nextTick(() => $refs.searchInput.focus()) : ($refs.searchInput.value = '', $el.form.submit())"
                                class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant transition-all"
                            >
                                <option value="" @selected($selectedSearchBy === '')>Cari berdasarkan</option>
                                @foreach($searchByOptions as $value => $label)
                                    <option value="{{ $value }}" @selected($selectedSearchBy === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="penalty_status" class="sr-only">Status penyelesaian</label>
                            <select id="penalty_status" name="status" onchange="this.form.submit()" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant transition-all">
                            <option value="">Semua Status</option>
                            <option value="belum_dibayar" {{ request('status') === 'belum_dibayar' ? 'selected' : '' }}>Belum Selesai</option>
                            <option value="lunas" {{ request('status') === 'lunas' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                    </div>

                    <div x-cloak x-show="searchBy" x-transition.opacity.duration.200ms class="mt-4 border-t border-outline-variant/60 pt-4">
                        <div class="flex flex-col gap-3 sm:flex-row">
                            <div class="relative flex min-w-0 flex-1 items-center">
                                <span class="material-symbols-outlined absolute left-4 text-outline text-[20px]">search</span>
                                <input
                                    x-ref="searchInput"
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    :placeholder="placeholders[searchBy] || 'Kata kunci pencarian'"
                                    class="w-full pl-12 pr-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold placeholder:truncate transition-all"
                                >
                            </div>
                            <button type="submit" class="flex shrink-0 items-center justify-center gap-1.5 rounded-2xl bg-primary px-7 py-3 text-xs font-bold text-white shadow-lg shadow-primary/20 transition-all hover:-translate-y-0.5 hover:bg-primary/95 active:translate-y-0">
                                <span class="material-symbols-outlined text-[18px]">search</span>
                                Cari
                            </button>
                        </div>
                    </div>

                    @if($hasActiveFilters)
                        <div class="mt-4 flex flex-wrap items-center gap-2 border-t border-outline-variant/60 pt-4">
                            <span class="mr-1 text-[11px] font-bold uppercase tracking-wider text-outline">Filter aktif:</span>

                            @if(request()->filled('search'))
                                <a href="{{ route('petugas.penalties.index', request()->except(['search', 'search_by', 'page'])) }}" class="inline-flex items-center gap-1 rounded-full border border-primary/20 bg-primary/10 px-3 py-1.5 text-[11px] font-bold text-primary transition-colors hover:bg-primary/20" title="Hapus pencarian kata kunci">
                                    {{ $searchByOptions[$selectedSearchBy] ?? 'Pencarian' }}: {{ request('search') }}
                                    <span aria-hidden="true">&times;</span>
                                </a>
                            @endif

                            @if(request()->filled('status'))
                                <a href="{{ route('petugas.penalties.index', request()->except(['status', 'page'])) }}" class="inline-flex items-center gap-1 rounded-full border border-primary/20 bg-primary/10 px-3 py-1.5 text-[11px] font-bold text-primary transition-colors hover:bg-primary/20" title="Hapus filter status">
                                    {{ $statusLabels[request('status')] ?? ucfirst((string) request('status')) }}
                                    <span aria-hidden="true">&times;</span>
                                </a>
                            @endif

                            <a href="{{ route('petugas.penalties.index') }}" class="ml-auto inline-flex items-center gap-1 text-[11px] font-bold text-rose-600 transition-colors hover:text-rose-700 hover:underline">
                                <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                                Reset Semua
                            </a>
                        </div>
                    @endif
                </form>
        </section>

        <x-table :pagination="$penalties->hasPages() ? $penalties->links() : null">
            <x-slot name="headers">
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Anggota</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Buku</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Jenis</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Penyelesaian</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Nominal</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Status</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-center text-slate-700 whitespace-nowrap">Aksi</th>
            </x-slot>

            @forelse($penalties as $penalty)
                @php
                    $needsReplacement = $penalty->type === 'kehilangan'
                        && in_array($penalty->penalti_type, ['ganti_buku', 'kombinasi'], true);
                    $replacementReceived = $penalty->replacement_received_at !== null;
                    $paymentReceived = $penalty->payment_received_at !== null;
                @endphp
                <tr class="even:bg-slate-50/40 hover:bg-teal-50/40 transition-colors duration-150 group">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-slate-100 flex items-center justify-center font-bold text-primary text-xs uppercase border border-outline-variant/100 shadow-sm">
                                {{ substr($penalty->user->name ?? '', 0, 2) }}
                            </div>
                            <div class="flex flex-col">
                                <span class="font-bold text-on-surface text-sm">{{ $penalty->user->name ?? '-' }}</span>
                                <span class="text-[10px] text-outline font-bold tracking-wider uppercase">
                                    @if($penalty->user?->role?->role_name === 'mahasiswa')
                                        NIM {{ $penalty->user->mahasiswa->nim ?? '-' }}
                                    @elseif($penalty->user?->role?->role_name === 'dosen')
                                        NIP {{ $penalty->user->dosen->nip ?? '-' }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex flex-col">
                            <span class="font-bold text-on-surface text-sm">{{ $penalty->loan?->collection?->display_title ?? '-' }}</span>
                            @if($penalty->loan?->collection)
                                <span class="text-[10px] text-outline font-semibold">{{ $penalty->loan->collection->display_type_label }}</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        @php
                            $typeColors = [
                                'keterlambatan' => 'bg-amber-100 text-amber-800 border-amber-300',
                                'kehilangan' => 'bg-rose-100 text-rose-800 border-rose-300',
                                'kerusakan' => 'bg-orange-100 text-orange-800 border-orange-300',
                            ];
                            $color = $typeColors[$penalty->type] ?? 'bg-slate-100 text-slate-800 border-slate-300';
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full {{ $color }} border text-[10px] font-bold uppercase tracking-wider whitespace-nowrap shadow-2xs">
                            {{ ucfirst($penalty->type) }}
                        </span>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        @php
                            $settlementColors = [
                                'uang_tunai' => 'bg-sky-100 text-sky-800 border-sky-300',
                                'denda' => 'bg-sky-100 text-sky-800 border-sky-300',
                                'ganti_buku' => 'bg-violet-100 text-violet-800 border-violet-300',
                                'kombinasi' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                            ];
                            $settlementColor = $settlementColors[$penalty->penalti_type] ?? 'bg-slate-100 text-slate-800 border-slate-300';
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full {{ $settlementColor }} border text-[10px] font-bold uppercase tracking-wider whitespace-nowrap shadow-2xs">
                            {{ $penalty->settlement_method_label }}
                        </span>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <span class="font-extrabold text-slate-900 text-sm">Rp {{ number_format($penalty->amount, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        @if($penalty->status === 'belum_dibayar')
                            @if($needsReplacement && ! $replacementReceived && $paymentReceived)
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-violet-100 text-violet-800 border border-violet-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                    <span class="w-2 h-2 rounded-full bg-violet-600 animate-pulse"></span>
                                    Menunggu Buku Pengganti
                                </span>
                            @elseif($needsReplacement && ! $replacementReceived)
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-amber-100 text-amber-800 border border-amber-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                    <span class="w-2 h-2 rounded-full bg-amber-600 animate-pulse"></span>
                                    Menunggu Penyelesaian
                                </span>
                            @elseif($needsReplacement && $replacementReceived && ! $paymentReceived)
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-sky-100 text-sky-800 border border-sky-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                    <span class="w-2 h-2 rounded-full bg-sky-600 animate-pulse"></span>
                                    Menunggu Pembayaran
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-rose-100 text-rose-700 border border-rose-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                    <span class="w-2 h-2 rounded-full bg-rose-600 animate-pulse"></span>
                                    Belum Selesai
                                </span>
                            @endif
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                                Selesai
                            </span>
                        @endif
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center justify-center gap-2">
                            <button
                                type="button"
                                class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-slate-200 bg-slate-100 text-slate-700 hover:bg-primary hover:text-white hover:border-primary transition-all shadow-xs active:scale-95"
                                title="Lihat keterangan"
                                aria-label="Lihat keterangan denda"
                                data-penalty-info
                                data-member="{{ $penalty->user->name ?? '-' }}"
                                data-book="{{ $penalty->loan?->collection?->display_title ?? '-' }}"
                                data-type="{{ ucfirst($penalty->type) }}"
                                data-settlement="{{ $penalty->settlement_method_label }}"
                                data-amount="Rp {{ number_format($penalty->amount, 0, ',', '.') }}"
                                data-description="{{ $penalty->description ?: 'Tidak ada keterangan tambahan.' }}"
                            >
                                <span class="material-symbols-outlined text-[20px]">info</span>
                            </button>

                            @if(($needsReplacement || in_array($penalty->type, ['kerusakan', 'kehilangan'], true)) && ! $replacementReceived && $penalty->status === 'belum_dibayar')
                                <div class="relative" x-data="{ openOpt: false }">
                                    <button @click="openOpt = !openOpt" type="button" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-violet-600 text-white hover:bg-violet-700 transition-all shadow-xs active:scale-95 shadow-violet-200" title="Konfirmasi Buku Pengganti Diterima">
                                        <span class="material-symbols-outlined text-[20px]">library_add_check</span>
                                    </button>

                                    <div x-show="openOpt" @click.away="openOpt = false" x-transition class="absolute right-0 mt-2 w-64 bg-white rounded-2xl border border-slate-200 shadow-xl z-[90] p-3 text-left space-y-2">
                                        <p class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider mb-1">Pilih Jenis Penggantian:</p>

                                        <button type="button" 
                                                onclick="openSameBookModal('{{ $penalty->penalti_id }}', '{{ e($penalty->loan?->collection?->display_title) }}', '{{ e($penalty->user?->name) }}')"
                                                class="w-full text-left p-2 rounded-xl hover:bg-emerald-50 text-slate-800 transition-all border border-slate-100 hover:border-emerald-200">
                                            <div class="flex items-center gap-2 text-emerald-700 font-bold text-xs">
                                                <span class="material-symbols-outlined text-[16px]">sync</span>
                                                Buku Sama Persis (+1 Stok)
                                            </div>
                                            <p class="text-[10px] text-slate-500 mt-0.5">Stok buku fisik baru bertambah +1.</p>
                                        </button>

                                        <button type="button" 
                                                onclick="openNewCollectionModal('{{ $penalty->penalti_id }}', '{{ e($penalty->loan?->collection?->display_title) }}', '{{ e($penalty->loan?->collection?->book?->category?->kategori_name ?? 'Umum') }}', '{{ $penalty->loan?->collection?->book?->category_id }}', '{{ e($penalty->user?->name) }}')"
                                                class="w-full text-left p-2 rounded-xl hover:bg-sky-50 text-slate-800 transition-all border border-slate-100 hover:border-sky-200">
                                            <div class="flex items-center gap-2 text-sky-700 font-bold text-xs">
                                                <span class="material-symbols-outlined text-[16px]">library_add</span>
                                                Koleksi Baru (1 Kategori)
                                            </div>
                                            <p class="text-[10px] text-slate-500 mt-0.5">Daftarkan koleksi judul baru.</p>
                                        </button>
                                    </div>
                                </div>
                            @endif

                            @if($penalty->status === 'belum_dibayar' && ! ($penalty->type === 'kehilangan' && $penalty->penalti_type === 'ganti_buku' && ! $replacementReceived) && ! $paymentReceived)
                                <form method="POST" action="{{ route('petugas.penalties.mark-paid', $penalty->penalti_id) }}" onsubmit="return confirm('Tandai sanksi ini sebagai selesai?')">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-emerald-500 text-white hover:bg-emerald-600 transition-all shadow-xs active:scale-95 shadow-emerald-200"
                                        title="Tandai selesai"
                                        aria-label="Tandai sanksi sebagai selesai"
                                    >
                                        <span class="material-symbols-outlined text-[20px]">check</span>
                                    </button>
                                </form>
                            @elseif($penalty->status === 'lunas')
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100 text-slate-400 border border-slate-200" title="Sudah selesai">
                                    <span class="material-symbols-outlined text-[20px]">check_circle</span>
                                </span>
                            @elseif($paymentReceived)
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-sky-50 text-sky-600 border border-sky-200" title="Pembayaran sudah dikonfirmasi">
                                    <span class="material-symbols-outlined text-[20px]">payments</span>
                                </span>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-8 py-14 text-center text-slate-500 font-medium">Belum ada data denda atau sanksi.</td>
                </tr>
            @endforelse
        </x-table>
    </main>

    <div id="penalty-info-modal" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-slate-950/45" data-close-penalty-info></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="w-full max-w-xl rounded-3xl bg-white border border-outline-variant/100 shadow-2xl overflow-hidden">
                <div class="flex items-start justify-between gap-4 px-6 py-5 border-b border-outline-variant/100">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary">Informasi Denda</p>
                        <h2 class="mt-1 font-headline-md text-on-surface">Detail Keterangan</h2>
                    </div>
                    <button
                        type="button"
                        class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-slate-100 text-on-surface-variant hover:bg-slate-200 transition-all"
                        aria-label="Tutup detail denda"
                        data-close-penalty-info
                    >
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>

                <div class="px-6 py-5 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div class="rounded-2xl bg-slate-50 px-4 py-3">
                            <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Anggota</p>
                            <p id="penalty-info-member" class="mt-1 font-semibold text-on-surface">-</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 px-4 py-3">
                            <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Buku</p>
                            <p id="penalty-info-book" class="mt-1 font-semibold text-on-surface">-</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 px-4 py-3">
                            <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Jenis</p>
                            <p id="penalty-info-type" class="mt-1 font-semibold text-on-surface">-</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 px-4 py-3">
                            <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Penyelesaian</p>
                            <p id="penalty-info-settlement" class="mt-1 font-semibold text-on-surface">-</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 px-4 py-3 sm:col-span-2">
                            <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Nominal</p>
                            <p id="penalty-info-amount" class="mt-1 font-semibold text-on-surface">-</p>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-outline-variant/100 bg-slate-50 px-5 py-4">
                        <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Keterangan</p>

                        <div class="mt-3 space-y-3">
                            <div id="penalty-info-rule-wrap" class="hidden">
                                <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Aturan</p>
                                <p id="penalty-info-rule" class="mt-1 text-sm leading-6 text-on-surface-variant">-</p>
                            </div>

                            <div id="penalty-info-failed-wrap" class="hidden">
                                <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Checklist Bermasalah</p>
                                <div id="penalty-info-failed-list" class="mt-2 flex flex-wrap gap-2"></div>
                            </div>

                            <div id="penalty-info-inspection-wrap" class="hidden">
                                <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Catatan Inspeksi</p>
                                <p id="penalty-info-inspection" class="mt-1 text-sm leading-6 text-on-surface-variant">-</p>
                            </div>

                            <div id="penalty-info-rule-note-wrap" class="hidden">
                                <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Catatan Sanksi</p>
                                <p id="penalty-info-rule-note" class="mt-1 text-sm leading-6 text-on-surface-variant">-</p>
                            </div>

                            <div id="penalty-info-extra-wrap" class="hidden">
                                <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Informasi Lain</p>
                                <div id="penalty-info-extra-list" class="mt-2 space-y-2"></div>
                            </div>

                            <div id="penalty-info-plain-wrap" class="hidden">
                                <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Keterangan Umum</p>
                                <p id="penalty-info-plain" class="mt-1 text-sm leading-6 text-on-surface-variant whitespace-pre-line">-</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const penaltyInfoModal = document.getElementById('penalty-info-modal');
        const penaltyInfoTriggers = document.querySelectorAll('[data-penalty-info]');
        const penaltyInfoClosers = document.querySelectorAll('[data-close-penalty-info]');

        const penaltyInfoFields = {
            member: document.getElementById('penalty-info-member'),
            book: document.getElementById('penalty-info-book'),
            type: document.getElementById('penalty-info-type'),
            settlement: document.getElementById('penalty-info-settlement'),
            amount: document.getElementById('penalty-info-amount'),
            ruleWrap: document.getElementById('penalty-info-rule-wrap'),
            rule: document.getElementById('penalty-info-rule'),
            failedWrap: document.getElementById('penalty-info-failed-wrap'),
            failedList: document.getElementById('penalty-info-failed-list'),
            ruleNoteWrap: document.getElementById('penalty-info-rule-note-wrap'),
            ruleNote: document.getElementById('penalty-info-rule-note'),
            inspectionWrap: document.getElementById('penalty-info-inspection-wrap'),
            inspection: document.getElementById('penalty-info-inspection'),
            extraWrap: document.getElementById('penalty-info-extra-wrap'),
            extraList: document.getElementById('penalty-info-extra-list'),
            plainWrap: document.getElementById('penalty-info-plain-wrap'),
            plain: document.getElementById('penalty-info-plain'),
        };

        function setSectionVisibility(element, visible) {
            element.classList.toggle('hidden', !visible);
        }

        function normalizeLabel(label) {
            return label.trim().toLowerCase();
        }

        function parsePenaltyDescription(description) {
            const rawText = (description || '').trim();

            if (!rawText) {
                return { plain: 'Tidak ada keterangan tambahan.', extras: [] };
            }

            const structured = {
                rule: '',
                failedChecklist: [],
                ruleNote: '',
                inspectionNote: '',
                followUp: '',
                extras: [],
                plain: '',
            };

            const segments = rawText.split(/\s+\|\s+/).map((segment) => segment.trim()).filter(Boolean);

            if (!segments.some((segment) => segment.includes(':'))) {
                structured.plain = rawText;
                return structured;
            }

            segments.forEach((segment) => {
                const separatorIndex = segment.indexOf(':');

                if (separatorIndex === -1) {
                    structured.extras.push({ label: 'Informasi', value: segment });
                    return;
                }

                const label = normalizeLabel(segment.slice(0, separatorIndex));
                const value = segment.slice(separatorIndex + 1).trim();

                if (!value) {
                    return;
                }

                if (label === 'aturan') {
                    structured.rule = value;
                    return;
                }

                if (label === 'checklist bermasalah') {
                    structured.failedChecklist = value.split(',').map((item) => item.trim()).filter(Boolean);
                    return;
                }

                if (label === 'catatan aturan') {
                    structured.ruleNote = value;
                    return;
                }

                if (label === 'catatan inspeksi') {
                    structured.inspectionNote = value;
                    return;
                }

                if (label === 'tindak lanjut') {
                    structured.followUp = value;
                    return;
                }

                structured.extras.push({
                    label: segment.slice(0, separatorIndex).trim(),
                    value,
                });
            });

            const hasStructuredContent = structured.rule
                || structured.failedChecklist.length
                || structured.ruleNote
                || structured.inspectionNote
                || structured.followUp
                || structured.extras.length;

            if (!hasStructuredContent) {
                structured.plain = rawText;
            }

            return structured;
        }

        function renderPenaltyDescription(description) {
            const parsed = parsePenaltyDescription(description);

            penaltyInfoFields.rule.textContent = parsed.rule || '-';
            setSectionVisibility(penaltyInfoFields.ruleWrap, Boolean(parsed.rule));

            penaltyInfoFields.failedList.innerHTML = '';
            if (parsed.failedChecklist.length) {
                parsed.failedChecklist.forEach((item) => {
                    const chip = document.createElement('span');
                    chip.className = 'inline-flex items-center px-3 py-1 rounded-full bg-rose-100 text-rose-700 text-xs font-semibold';
                    chip.textContent = item;
                    penaltyInfoFields.failedList.appendChild(chip);
                });
            }
            setSectionVisibility(penaltyInfoFields.failedWrap, parsed.failedChecklist.length > 0);

            penaltyInfoFields.ruleNote.textContent = parsed.ruleNote || '-';
            setSectionVisibility(penaltyInfoFields.ruleNoteWrap, Boolean(parsed.ruleNote));

            penaltyInfoFields.inspection.textContent = parsed.inspectionNote || '-';
            setSectionVisibility(penaltyInfoFields.inspectionWrap, Boolean(parsed.inspectionNote));

            penaltyInfoFields.extraList.innerHTML = '';
            if (parsed.extras.length) {
                parsed.extras.forEach((item) => {
                    const row = document.createElement('div');
                    row.className = 'rounded-2xl bg-white/70 px-4 py-3 border border-outline-variant/100';

                    const title = document.createElement('p');
                    title.className = 'text-[11px] font-bold uppercase tracking-widest text-outline';
                    title.textContent = item.label;

                    const content = document.createElement('p');
                    content.className = 'mt-1 text-sm leading-6 text-on-surface-variant';
                    content.textContent = item.value;

                    row.appendChild(title);
                    row.appendChild(content);
                    penaltyInfoFields.extraList.appendChild(row);
                });
            }
            setSectionVisibility(penaltyInfoFields.extraWrap, parsed.extras.length > 0);

            penaltyInfoFields.plain.textContent = parsed.plain || 'Tidak ada keterangan tambahan.';
            setSectionVisibility(
                penaltyInfoFields.plainWrap,
                Boolean(parsed.plain) || (
                    !parsed.rule
                    && !parsed.failedChecklist.length
                    && !parsed.ruleNote
                    && !parsed.inspectionNote
                    && !parsed.followUp
                    && !parsed.extras.length
                )
            );
        }

        function openPenaltyInfo(button) {
            penaltyInfoFields.member.textContent = button.dataset.member || '-';
            penaltyInfoFields.book.textContent = button.dataset.book || '-';
            penaltyInfoFields.type.textContent = button.dataset.type || '-';
            penaltyInfoFields.settlement.textContent = button.dataset.settlement || '-';
            penaltyInfoFields.amount.textContent = button.dataset.amount || '-';
            renderPenaltyDescription(button.dataset.description || '');
            penaltyInfoModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closePenaltyInfo() {
            penaltyInfoModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        penaltyInfoTriggers.forEach((button) => {
            button.addEventListener('click', () => openPenaltyInfo(button));
        });

        penaltyInfoClosers.forEach((button) => {
            button.addEventListener('click', closePenaltyInfo);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !penaltyInfoModal.classList.contains('hidden')) {
                closePenaltyInfo();
            }
        });
    </script>

    <!-- MODAL 1: PENGGANTIAN BUKU SAMA -->
    <div id="modal-same-book" class="fixed inset-0 z-[99999] hidden bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-4 my-auto relative">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2 text-emerald-700">
                    <span class="material-symbols-outlined text-2xl">sync</span>
                    <h3 class="font-bold text-base text-slate-800">Ganti Buku Sama Persis</h3>
                </div>
                <button type="button" onclick="closeSameBookModal()" class="text-slate-400 hover:text-slate-600 rounded-full p-1">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>

            <form id="same-book-form" method="POST" action="" class="space-y-4">
                @csrf
                <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-2xl text-xs text-emerald-900 space-y-1">
                    <p><strong>Peminjam:</strong> <span id="same-user-name"></span></p>
                    <p><strong>Judul Buku:</strong> <span id="same-book-title"></span></p>
                    <p class="text-[11px] text-emerald-700 mt-1 font-medium">💡 Menyetujui penggantian ini akan menambah <strong>+1 Stok Fisik Baru</strong> pada judul buku ini dan menyelesaikan sanksi terkait.</p>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Catatan Penggantian</label>
                    <textarea name="notes" rows="2" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-2xl text-xs resize-none" placeholder="Misal: Diterima 1 eks fisik buku baru berkondisi mulus dari peminjam."></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="closeSameBookModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-md">Proses &amp; Tambah Stok (+1)</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: PENGGANTIAN KOLEKSI BARU (1 KATEGORI) -->
    <div id="modal-new-collection" class="fixed inset-0 z-[99999] hidden bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 shadow-2xl space-y-4 my-auto relative">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2 text-sky-700">
                    <span class="material-symbols-outlined text-2xl">library_add</span>
                    <h3 class="font-bold text-base text-slate-800">Ganti Koleksi Baru (1 Kategori)</h3>
                </div>
                <button type="button" onclick="closeNewCollectionModal()" class="text-slate-400 hover:text-slate-600 rounded-full p-1">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>

            <form id="new-collection-form" method="POST" action="" class="space-y-4">
                @csrf
                <div class="p-3 bg-sky-50 border border-sky-200 rounded-2xl text-xs text-sky-900 space-y-1">
                    <p><strong>Peminjam:</strong> <span id="new-user-name"></span></p>
                    <p><strong>Buku Asli Rusak:</strong> <span id="new-old-title"></span></p>
                    <p><strong>Kategori Terkunci:</strong> <span id="new-category-name" class="font-extrabold text-sky-800"></span></p>
                    <input type="hidden" name="category_id" id="new-category-id" value="">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="space-y-1 md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Judul Buku Baru <span class="text-rose-500">*</span></label>
                        <input type="text" name="judul" required placeholder="Judul buku baru yang diserahkan peminjam" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold focus:border-sky-500">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Pengarang <span class="text-rose-500">*</span></label>
                        <input type="text" name="pengarang" required placeholder="Nama penulis/pengarang" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Penerbit <span class="text-rose-500">*</span></label>
                        <input type="text" name="penerbit" required placeholder="Penerbit" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Tahun Terbit <span class="text-rose-500">*</span></label>
                        <input type="number" name="tahun_terbit" required min="1900" max="{{ date('Y') + 1 }}" value="{{ date('Y') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nomor ISBN</label>
                        <input type="text" name="isbn" placeholder="Opsional (misal: 978-602-...)" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Catatan Penggantian</label>
                    <textarea name="notes" rows="2" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-2xl text-xs resize-none" placeholder="Catatan tambahan petugas..."></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="closeNewCollectionModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs rounded-xl shadow-md">Simpan Koleksi Baru &amp; Selesaikan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openSameBookModal(id, title, user) {
            document.getElementById('same-book-form').action = "{{ url('petugas/penalties') }}/" + id + "/confirm-replacement-same";
            document.getElementById('same-book-title').textContent = title;
            document.getElementById('same-user-name').textContent = user;
            document.getElementById('modal-same-book').classList.remove('hidden');
        }

        function closeSameBookModal() {
            document.getElementById('modal-same-book').classList.add('hidden');
        }

        function openNewCollectionModal(id, oldTitle, categoryName, categoryId, user) {
            document.getElementById('new-collection-form').action = "{{ url('petugas/penalties') }}/" + id + "/confirm-replacement-new";
            document.getElementById('new-old-title').textContent = oldTitle;
            document.getElementById('new-category-name').textContent = categoryName;
            document.getElementById('new-category-id').value = categoryId || '';
            document.getElementById('new-user-name').textContent = user;
            document.getElementById('modal-new-collection').classList.remove('hidden');
        }

        function closeNewCollectionModal() {
            document.getElementById('modal-new-collection').classList.add('hidden');
        }
    </script>
</body>
</html>
